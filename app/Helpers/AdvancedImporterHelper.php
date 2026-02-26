<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Excel as ExcelFiles;
use Maatwebsite\Excel\Exceptions\NoFilePathGivenException;
use Maatwebsite\Excel\Facades\Excel;

class AdvancedImporterHelper
{
    private const FORMAT_XLSX = 'Xlsx';
    private const FORMAT_CSV = 'Csv';
    /**
     * Import to database directly (only valid rows) with relationship lookup support.
     *
     * @param string $filePath
     * @param string $target
     * @param array $rules
     * @param array $fieldMap
     * @param array $fixedValues
     * @param array $lookupFields
     * @param array $customMessages
     * @param int $chunkSize
     * @param bool $useBatchInsert
     * @param string|null $sheetName
     * @param string|null $format
     * @param string $disk
     * @param bool $dryRun
     * @param callable|null $postProcessor
     * @param callable|null $progressCallback
     * @return array
     * @throws Exception
     */
    public static function importToDatabase(
        string    $filePath,
        string    $target,
        array     $rules = [],
        array     $fieldMap = [],
        array     $fixedValues = [],
        array     $lookupFields = [],
        array     $customMessages = [],
        int       $chunkSize = 1000,
        bool      $useBatchInsert = true,
        ?string   $sheetName = null,
        ?string   $format = null,
        string    $disk = 'local',
        bool      $dryRun = false,
        ?callable $postProcessor = null,
        ?callable $progressCallback = null
    ): array
    {
        if (!self::isValidFilePath($filePath)) {
            Log::warning("Invalid file path attempted: {$filePath}");
            throw new Exception("Invalid file path. File must be located in the storage/app directory. attempted path: {$filePath}");
        }

        // Check if file exists on the specified disk
        if ($filePath) {
            Log::warning("File does not exist on disk: {$filePath}", ['disk' => $disk]);
            throw new Exception("File does not exist on disk {$disk}: {$filePath}");
        }

        // Validate relationship rules
        self::validateRelationshipRules($rules, $lookupFields);

        try {
            $result = self::importToArray(
                $filePath,
                $rules,
                $fieldMap,
                $fixedValues,
                $lookupFields,
                $customMessages,
                $chunkSize,
                $sheetName,
                $progressCallback
            );
        } catch (Exception $e) {
            throw new Exception("Failed to process file: {$e->getMessage()}");
        }

        // Apply post-processing to valid rows
        if ($postProcessor) {
            $result['valid'] = array_map($postProcessor, $result['valid']);
        }

        $inserted = 0;

        if (!empty($result['valid'])) {
            try {
                if (!$dryRun) {
                    DB::beginTransaction();
                    $inserted = self::insertRows($result['valid'], $target, $chunkSize, $useBatchInsert);
                    DB::commit();
                } else {
                    $inserted = count($result['valid']);
                    Log::info("Dry run: {$inserted} rows would be inserted into {$target}");
                }
            } catch (QueryException $e) {
                if (!$dryRun) {
                    DB::rollBack();
                }
                Log::error("Database insertion failed for target: {$target}", ['exception' => $e->getMessage()]);
                throw new Exception("Database insertion failed: {$e->getMessage()}");
            } catch (Exception $e) {
                if (!$dryRun) {
                    DB::rollBack();
                }
                Log::error("Unexpected error during database insertion for target: {$target}", ['exception' => $e->getMessage()]);
                throw new Exception("Unexpected error during insertion: {$e->getMessage()}");
            }
        }




        return [
            'inserted' => $inserted,
            'valid_count' => count($result['valid']),
            'invalid_count' => count($result['invalid']),
            'invalid_rows' => $result['invalid'],
        ];
    }

    /**
     * Validate that the file path is within the storage/app directory.
     *
     * @param string $filePath
     * @return bool
     */
    protected static function isValidFilePath(string $filePath): bool
    {
        $storagePath = storage_path('app');
        $realPath = realpath($filePath);
        return $realPath !== false && str_starts_with($realPath, realpath($storagePath));
    }

    /**
     * Validate that relationship fields have appropriate rules (e.g., exists).
     *
     * @param array $rules
     * @param array $lookupFields
     * @throws Exception
     */
    protected static function validateRelationshipRules(array $rules, array $lookupFields): void
    {
        foreach ($lookupFields as $field => $config) {
            $table = $config['table'] ?? null;
            $model = $config['model'] ?? null;
            $targetColumn = $config['target_column'] ?? 'id';

            if (!$table && !$model) {
                throw new Exception("Invalid lookup configuration for field: {$field}. Must specify either 'table' or 'model'.");
            }

            $tableName = $table ?: (new $model)->getTable();

            if (!isset($rules[$field])) {
                Log::warning("No validation rule provided for relationship field: {$field}");
                throw new Exception("Validation rule missing for relationship field: {$field}");
            }

            $ruleString = is_array($rules[$field]) ? implode('|', $rules[$field]) : $rules[$field];
            if (!Str::contains($ruleString, "exists:{$tableName},{$targetColumn}")) {
                Log::warning("Missing 'exists' rule for relationship field: {$field} on {$tableName}.{$targetColumn}");
                throw new Exception("Rule for {$field} must include 'exists:{$tableName},{$targetColumn}'");
            }
        }
    }

    /**
     * Import and validate rows into valid/invalid arrays with relationship lookup support.
     *
     * @param string $filePath
     * @param array $rules
     * @param array $fieldMap
     * @param array $fixedValues
     * @param array $lookupFields
     * @param array $customMessages
     * @param int $chunkSize
     * @param string|null $sheetName
     * @param string|null $format
     * @param string $disk
     * @param callable|null $progressCallback
     * @return array
     * @throws Exception
     */
    public static function importToArray(
        string    $filePath,
        array     $rules = [],
        array     $fieldMap = [],
        array     $fixedValues = [],
        array     $lookupFields = [],
        array     $customMessages = [],
        int       $chunkSize = 1000,
        ?string   $sheetName = null,
        ?callable $progressCallback = null
    ): array
    {
        if (!self::isValidFilePath($filePath)) {
            Log::warning("Invalid file path attempted: {$filePath}");
            throw new Exception("Invalid file path. File must be located in the storage/app directory. attempted path: {$filePath}");
        }

        try {
            $collection = self::loadExcelFile($filePath, $fieldMap, $chunkSize, $sheetName);
        } catch (FileNotFoundException $e) {
            Log::error("File not found: {$filePath}", ['exception' => $e->getMessage()]);
            throw new Exception("The specified file does not exist: {$filePath}");
        } catch (Exception $e) {
            Log::error("Failed to load file: {$filePath}", ['exception' => $e->getMessage()]);
            throw new Exception("Error loading file: {$e->getMessage()}");
        }

        $valid = [];
        $invalid = [];

        // Warn if no validation rules are provided
        if (empty($rules)) {
            Log::warning("No validation rules provided for file import: {$filePath}");
        }

        // Build lookup cache for relationship fields
        $lookupCache = self::buildLookupCache($lookupFields);

        foreach ($collection as $index => $row) {
            $rowData = $row->toArray();

            // Evaluate fixed values (handle callables with row data)
            $evaluatedFixedValues = [];
            foreach ($fixedValues as $key => $value) {
                if (is_callable($value)) {
                    try {
                        $evaluatedFixedValues[$key] = call_user_func($value, $rowData);
                    } catch (Exception $e) {
                        Log::error("Failed to evaluate fixed value for {$key}: {$e->getMessage()}", [
                            'row' => $rowData,
                            'stack' => $e->getTraceAsString(),
                        ]);
                        $rowData['errors'] = ($rowData['errors'] ?? '') . "Invalid fixed value for {$key}: {$e->getMessage()}; ";
                        $invalid[] = $rowData;
                        continue 2; // Skip to next row
                    }
                } else {
                    $evaluatedFixedValues[$key] = $value;
                }
            }

            $rowData = array_merge($rowData, $evaluatedFixedValues);

            // Apply relationship lookups (e.g., employee_code to employee_id)
            foreach ($lookupFields as $field => $config) {
                $sourceField = $config['source_field'] ?? $field;
                if (isset($rowData[$sourceField])) {
                    $lookupValue = $lookupCache[$field][$rowData[$sourceField]] ?? null;
                    if ($lookupValue === null) {
                        $source = $config['table'] ?? $config['model'] ?? 'unknown';
                        $rowData['errors'] = ($rowData['errors'] ?? '') . "Invalid {$sourceField}: {$rowData[$sourceField]} not found in {$source}; ";
                        $invalid[] = $rowData;
                        continue 2; // Skip to next row
                    }
                    $rowData[$field] = $lookupValue;
                    unset($rowData[$sourceField]);
                }
            }

            // Validate with row data available for closure-based rules
            $validator = Validator::make($rowData, $rules, $customMessages, $rowData);

            if ($validator->fails()) {
                $rowData['errors'] = $validator->errors()->toArray();
                Log::debug("Validation failed for row", ['row' => $rowData, 'errors' => $rowData['errors']]);
                $invalid[] = $rowData;
            } else {
                $valid[] = Arr::only($rowData, array_keys($rules));

            }

            // Report progress
            if ($progressCallback) {
                call_user_func($progressCallback, $index + 1, $collection->count());
            }
        }

        return [
            'valid' => $valid,
            'invalid' => $invalid,
            'valid_count' => count($valid),
            'invalid_count' => count($invalid),
        ];
    }

    /**
     * Load and map Excel/CSV file into a collection with chunking.
     *
     * @param string $filePath
     * @param array $fieldMap
     * @param int $chunkSize
     * @param string|null $sheetName
     * @return Collection
     * @throws Exception
     */
    protected static function loadExcelFile(
        string  $filePath,
        array   $fieldMap = [],
        int     $chunkSize = 1000,
        ?string $sheetName = null,
    ): Collection
    {
        // Validating input parameters
        if (empty($filePath)) {
            throw new NoFilePathGivenException('File path cannot be empty');
        }

        if ($chunkSize <= 0) {
            throw new InvalidArgumentException('Chunk size must be positive');
        }

        try {
            $importer = new class($chunkSize) implements ToCollection, WithHeadingRow, WithChunkReading {
                protected int $chunkSize;

                public function __construct(int $chunkSize)
                {
                    $this->chunkSize = $chunkSize;
                }

                public function collection(Collection $rows): Collection
                {
                    return $rows;
                }

                public function chunkSize(): int
                {
                    return $this->chunkSize;
                }
            };
            $sheets = Excel::toCollection($importer, $filePath);
            $collection = $sheetName ? $sheets->firstWhere('title', $sheetName) : $sheets->first();
            $collection = $collection ?? collect();
        } catch (FileNotFoundException $e) {
            throw new FileNotFoundException("File not found: {$filePath}");
        } catch (Exception $e) {
            throw new Exception("Error reading file: {$e->getMessage()}");
        }

        if (!empty($fieldMap)) {
            $collection = $collection->map(function ($row) use ($fieldMap) {
                $mapped = [];
                foreach ($row->toArray() as $header => $value) {
                    $match = collect($fieldMap)->first(
                        fn($dbCol, $fileCol) => strtolower(trim($fileCol)) === strtolower(trim($header)),
                        $default = null
                    );
                    $dbCol = $match ?? $header;
                    $mapped[$dbCol] = $value;
                }
                return collect($mapped);
            });
        }

        return $collection;
    }

    /**
     * Build a cache for lookup fields to map source values to target values for relationships.
     *
     * @param array $lookupFields
     * @return array
     * @throws Exception
     */
    private static function buildLookupCache(array $lookupFields): array
    {
        $cache = [];

        foreach ($lookupFields as $field => $config) {
            $table = $config['table'] ?? null;
            $model = $config['model'] ?? null;
            $sourceColumn = $config['source_column'] ?? $field;
            $targetColumn = $config['target_column'] ?? 'id';

            // Validate lookup configuration
            if (($table && $model) || (!$table && !$model)) {
                Log::error("Invalid lookup configuration for field: {$field}. Must specify either 'table' or 'model', but not both.", ['config' => $config]);
                throw new Exception("Invalid lookup configuration for field: {$field}. Must specify either 'table' or 'model', but not both.");
            }

            if ($model && (!class_exists($model) || !is_subclass_of($model, Model::class))) {
                Log::error("Invalid model class for field: {$field}", ['model' => $model]);
                throw new Exception("Invalid model class for field: {$field}. Must be a valid Eloquent model.");
            }

            try {
                $query = $model ? $model::query()->select($sourceColumn, $targetColumn) : DB::table($table)->select($sourceColumn, $targetColumn);
                $cache[$field] = [];
                $query->chunk(1000, function ($rows) use (&$cache, $field, $sourceColumn, $targetColumn) {
                    foreach ($rows as $row) {
                        $cache[$field][$row->$sourceColumn] = $row->$targetColumn;
                    }
                });
                $source = $model ?? $table;
                Log::info("Lookup cache built for {$field} from {$source}");
            } catch (QueryException $e) {
                $source = $model ?? $table;
                Log::error("Failed to build lookup cache for {$field} from {$source}", [
                    'exception' => $e->getMessage(),
                    'source_column' => $sourceColumn,
                    'target_column' => $targetColumn,
                ]);
                throw new Exception("Failed to build lookup cache for {$field}: {$e->getMessage()}");
            }
        }

        return $cache;
    }

    /**
     * Insert valid rows into the database with batch or single-row support for Eloquent.
     *
     * @param array $rows
     * @param string $target
     * @param int $chunkSize
     * @param bool $useBatchInsert
     * @param bool $addTimestamps
     * @return int
     * @throws Exception
     */
    protected static function insertRows(
        array  $rows,
        string $target,
        int    $chunkSize = 1000,
        bool   $useBatchInsert = true,
        bool   $addTimestamps = true
    ): int
    {
        $inserted = 0;

        if (class_exists($target) && is_subclass_of($target, Model::class)) {
            if ($useBatchInsert) {
                // Batch insert for Eloquent models
                collect($rows)->chunk($chunkSize)->each(function ($chunk) use ($target, &$inserted) {
                    try {
                        $target::insert($chunk->toArray());
                        $inserted += $chunk->count();
                    } catch (QueryException $e) {
                        Log::error("Failed to batch insert rows into model {$target}", [
                            'chunk' => $chunk->toArray(),
                            'exception' => $e->getMessage(),
                        ]);
                        throw new Exception("Failed to batch insert rows into model: {$e->getMessage()}");
                    }
                });
            } else {
                // Single-row insert for Eloquent models (to trigger events)
                foreach ($rows as $row) {
                    try {
                        $target::create($row);
                        $inserted++;
                    } catch (QueryException $e) {
                        Log::error("Failed to insert row into model {$target}", [
                            'row' => $row,
                            'exception' => $e->getMessage(),
                        ]);
                        throw new Exception("Failed to insert row into model: {$e->getMessage()}");
                    }
                }
            }
        } else {
            // Add timestamps for raw table inserts if enabled
            if ($addTimestamps) {
                $rows = array_map(fn($r) => array_merge($r, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]), $rows);
            }

            // Batch insert for raw tables
            collect($rows)->chunk($chunkSize)->each(function ($chunk) use ($target, &$inserted) {
                try {
                    DB::table($target)->insert($chunk->toArray());
                    $inserted += $chunk->count();
                } catch (QueryException $e) {
                    Log::error("Failed to batch insert rows into table {$target}", [
                        'chunk' => $chunk->toArray(),
                        'exception' => $e->getMessage(),
                    ]);
                    throw new Exception("Failed to batch insert rows into table: {$e->getMessage()}");
                }
            });
        }

        return $inserted;
    }
}
