<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\LazyCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ProjectUser;
use App\Jobs\FlexibleImportJob;
use Exception;

class FlexibleImporterHelper
{
    /**
     * Dispatch an import job to process data asynchronously.
     *
     * @param string $filePath Path to the uploaded file
     * @param string $target Table name or Eloquent model class
     * @param array $rules Validation rules for each column
     * @param int $chunkSize Number of rows to process per chunk
     * @param array $fixedValues Fixed values to merge into each row (e.g., ['project_id' => 1])
     * @param array $fieldMap Mapping of file headers to DB columns (e.g., ['User ID' => 'user_id'])
     * @param mixed $userId User ID for event broadcasting
     * @return void
     */
    public static function dispatchImport(string $filePath, string $target, array $rules = [], int $chunkSize = 100, array $fixedValues = [], array $fieldMap = [], mixed $userId): void
    {
        FlexibleImportJob::dispatch($filePath, $target, $rules, $chunkSize, $fixedValues, $fieldMap, $userId)
            ->onQueue('imports');
    }

    /**
     * Import data from an Excel/CSV file into a database table or model.
     *
     * @param string $filePath Path to the uploaded file
     * @param string $target Table name or Eloquent model class
     * @param array $rules Validation rules for each column
     * @param int $chunkSize Number of rows to process per chunk
     * @param array $fixedValues Fixed values to merge into each row
     * @param array $fieldMap Mapping of file headers to DB columns
     * @return array Import results including inserted count and file paths
     * @throws Exception If file reading fails or target is invalid
     */
    public static function import(string $filePath, string $target, array $rules = [], int $chunkSize = 100, array $fixedValues = [], array $fieldMap = []): array
    {

        try {
            // Validate fixed values against relevant rules
            $fixedRules = Arr::only($rules, array_keys($fixedValues));
            $fixedValidator = Validator::make($fixedValues, $fixedRules);
            if ($fixedValidator->fails()) {
                Log::error('Fixed values validation failed: ' . implode(', ', $fixedValidator->errors()->all()));
                throw new Exception('Fixed values validation failed: ' . implode(', ', $fixedValidator->errors()->all()));
            }

            $collection = self::loadExcelFile($filePath, $fieldMap);

            if ($collection->isEmpty()) {
                Log::error('File is empty.');
                return self::formatResult(0, null, null, 'File is empty.', $fixedValues);
            }

            $headers = array_keys($collection->first()->toArray());
            $rules = empty($rules) ? self::generateDefaultRules($headers) : array_merge($rules, $fixedRules);

            $results = self::processRows($collection, $target, $rules, $chunkSize, $fixedValues);

            // Clean up the uploaded file
            $relativePath = str_replace(storage_path('app/public/'), '', $filePath);
            Storage::disk('public')->delete($relativePath);

            Log::info('FlexibleImporterHelper import completed',
                [
                    'target' => $target,
                    'file_path' => $filePath,
                    'fixed_values' => $fixedValues,
                    'field_map' => $fieldMap,
                ]
            );

            return self::generateExportFiles(
                $results['validRows'],
                $results['invalidRows'],
                $results['inserted'],
                $fixedValues
            );
        } catch (Exception $e) {
            // Clean up on failure
            $relativePath = str_replace(storage_path('app/public/'), '', $filePath);
            Storage::disk('public')->delete($relativePath);

            Log::error('FlexibleImporterHelper import failed', [
                'exception' => $e->getMessage(),
                'target' => $target,
                'file_path' => $filePath,
                'fixed_values' => $fixedValues,
                'field_map' => $fieldMap,
            ]);

            return self::formatResult(0, null, null, 'Import failed: ' . $e->getMessage(), $fixedValues);
        }
    }

    /**
     * Load Excel/CSV file into a collection, applying field mapping.
     *
     * @param string $filePath
     * @param array $fieldMap
     * @return Collection
     * @throws Exception If file cannot be read
     */
    protected static function loadExcelFile(
        string $filePath,
        array $fieldMap = []): Collection
    {
        $collection = Excel::toCollection(new class implements ToCollection, WithHeadingRow {
            public function collection(Collection $rows)
            {
                return $rows;
            }
        }, $filePath)->first() ?? collect();

        if (!empty($fieldMap)) {
            $collection = $collection->map(function ($row) use ($fieldMap) {
                $mappedRow = [];
                foreach ($row->toArray() as $header => $value) {
//##################################################################################################
                    $headerNormalized = strtolower(trim($header));
                    $match = collect($fieldMap)->first(
                        fn($dbCol, $fileCol) => strtolower(trim($fileCol)) === $headerNormalized,
                        $default = null
                    );
//   ################################################################################################
//                    $dbColumn = $fieldMap[$header] ?? $header;
                    $dbColumn = $match ?? $header;
                    $mappedRow[$dbColumn] = $value;

                }
                return $mappedRow;
            });
        }



        return $collection;
    }

    /**
     * Generate default validation rules for headers.
     *
     * @param array $headers
     * @return array
     */
    protected static function generateDefaultRules(array $headers): array
    {
        return array_fill_keys($headers, 'nullable|string|max:255');
    }

    /**
     * Process rows in chunks, validate, and insert into the database.
     *
     * @param Collection $collection
     * @param string $target
     * @param array $rules
     * @param int $chunkSize
     * @param array $fixedValues
     * @return array
     */
    protected static function processRows(Collection $collection, string $target, array $rules, int $chunkSize, array $fixedValues): array
    {
        $validRows = [];
        $invalidRows = [];
        $inserted = 0;

        LazyCollection::make($collection)->chunk($chunkSize)->each(function ($chunk) use (&$validRows, &$invalidRows, $target, $rules, &$inserted, $fixedValues) {
            $chunkValid = [];

            foreach ($chunk as $row) {
                $rowArray = $row->toArray();
                // Merge fixed values into the row
                $rowArray = array_merge($rowArray, $fixedValues);


                // Check for duplicate pivot records dynamically
                if (property_exists($target, 'uniqueKeys')) {
                    $uniqueKeys = $target::$uniqueKeys;

                    // Make sure all required keys exist in the row
                    if (collect($uniqueKeys)->every(fn($key) => isset($rowArray[$key]))) {
                        $query = $target::query();
                        foreach ($uniqueKeys as $key) {
                            $query->where($key, $rowArray[$key]);
                        }

                        if ($query->exists()) {
                            $invalidRows[] = array_merge($rowArray, [
                                'errors' => self::sanitizeErrorMessage('Duplicate ' . implode(' and ', $uniqueKeys) . ' combination')
                            ]);
                            continue;
                        }
                    }
                }


                $validator = Validator::make($rowArray, $rules);

                if ($validator->fails()) {
                    $invalidRows[] = array_merge($rowArray, ['errors' => self::sanitizeErrorMessage(implode('; ', $validator->errors()->all()))]);
                } else {
                    // Only include fields defined in rules for insertion
                    $validRow = Arr::only($rowArray, array_keys($rules));
                    $chunkValid[] = $validRow;
                    $validRows[] = $rowArray; // Retain fixed values for output file
                }
            }
            if (!empty($chunkValid)) {
                $inserted += self::insertRows($chunkValid, $target);
            }
        });

        return [
            'validRows' => $validRows,
            'invalidRows' => $invalidRows,
            'inserted' => $inserted,
        ];
    }

    /**
     * Insert valid rows into the database.
     *
     * @param array $rows
     * @param string $target
     * @return int Number of inserted rows
     */
    protected static function insertRows(array $rows, string $target): int
    {
        try {
            if (class_exists($target) && is_subclass_of($target, Model::class)) {
                $inserted = 0;
                foreach ($rows as $row) {
                    $target::create($row);
                    $inserted++;
                }
                return $inserted;
            }

            $rows = array_map(fn($row) => array_merge($row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]), $rows);

            DB::table($target)->insert($rows);
            return count($rows);
        } catch (Exception $e) {
            Log::error('FlexibleImporterHelper insertRows failed', [
                'exception' => $e->getMessage(),
                'target' => $target,
                'rows_count' => count($rows),
            ]);
            throw new Exception('Database insertion failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate export files for valid and invalid rows.
     *
     * @param array $validRows
     * @param array $invalidRows
     * @param int $inserted
     * @param array $fixedValues
     * @return array
     */
    protected static function generateExportFiles(array $validRows, array $invalidRows, int $inserted, array $fixedValues): array
    {
        $validFile = null;
        $invalidFile = null;

        // Include fixed values in headers for output files
        $extraHeaders = array_keys($fixedValues);

        if (!empty($validRows)) {
            $validFile = 'import_valid_' . Str::uuid() . '.csv';
            $headers = array_keys($validRows[0]);
            $headers = array_diff($headers, ['errors']); // Exclude 'errors' from valid rows
            $headers = array_merge($headers, array_diff($extraHeaders, $headers));
            self::saveCsv(storage_path("app/public/{$validFile}"), $validRows, $headers);
            $validFile = Storage::url($validFile);
        }

        if (!empty($invalidRows)) {
            $invalidFile = 'import_errors_' . Str::uuid() . '.csv';
            $headers = array_keys($invalidRows[0]);
            $headers = array_merge($headers, array_diff($extraHeaders, array_diff($headers, ['errors'])));
            self::saveCsv(storage_path("app/public/{$invalidFile}"), $invalidRows, $headers);
            $invalidFile = Storage::url($invalidFile);
        }

        return self::formatResult(
            $inserted,
            $validFile,
            $invalidFile,
            empty($invalidRows) ? "Import completed successfully. Inserted $inserted rows." : "Import completed with errors. Inserted $inserted rows.",
            $fixedValues
        );
    }

    /**
     * Format the result array.
     *
     * @param int $inserted
     * @param string|null $validFile
     * @param string|null $errorFile
     * @param string $message
     * @param array $fixedValues
     * @return array
     */
    protected static function formatResult(int $inserted, ?string $validFile, ?string $errorFile, string $message, array $fixedValues): array
    {
        return [
            'inserted' => $inserted,
            'valid_file' => $validFile,
            'error_file' => $errorFile,
            'message' => $message,
            'fixed_values' => $fixedValues,
        ];
    }

    /**
     * Sanitize error messages to prevent CSV delimiter issues.
     *
     * @param string $message
     * @return string
     */
    protected static function sanitizeErrorMessage(string $message): string
    {
        // Replace commas and semicolons with underscores
        return str_replace([',', ';'], '_', $message);
    }

    /**
     * Save rows to a CSV file, ensuring proper escaping.
     *
     * @param string $path
     * @param array $rows
     * @param array $headers
     * @throws Exception If file cannot be written
     */
    protected static function saveCsv(string $path, array $rows, array $headers): void
    {
        $handle = @fopen($path, 'w');
        if ($handle === false) {
            throw new Exception('Failed to open file for writing: ' . $path);
        }

        try {
            // Write headers
            fputcsv($handle, $headers, ',', '"');

            // Write rows with proper escaping
            foreach ($rows as $row) {
                $rowData = [];
                foreach ($headers as $header) {
                    $value = $row[$header] ?? '';
                    $rowData[] = $header === 'errors' ? self::sanitizeErrorMessage((string)$value) : (string)$value;
                }
                fputcsv($handle, $rowData, ',', '"');
            }
        } finally {
            fclose($handle);
        }
    }
}
