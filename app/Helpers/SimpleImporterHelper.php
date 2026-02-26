<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class SimpleImporterHelper
{
    /**
     * Import and validate rows into valid/invalid arrays.
     *
     * @param string $filePath
     * @param array $rules
     * @param array $fieldMap
     * @param array $fixedValues
     * @return array
     * @throws Exception
     */
    public static function importToArray(
        string $filePath,
        array $rules = [],
        array $fieldMap = [],
        array $fixedValues = []): array
    {

        // Validate file path
        if (!self::isValidFilePath($filePath)) {
            Log::warning("Invalid file path attempted: {$filePath}");
            throw new Exception("Invalid file path. File must be located in the storage/app directory.");
        }

        try {
            $collection = self::loadExcelFile($filePath, $fieldMap);
        } catch (FileNotFoundException $e) {
            Log::error("File not found: {$filePath}", ['exception' => $e->getMessage()]);
            throw new Exception("The specified file does not exist: {$filePath}");
        } catch (Exception $e) {
            Log::error("Failed to load file: {$filePath}", ['exception' => $e->getMessage()]);
            throw new Exception("Error loading file: {$e->getMessage()}");
        }

        $valid = [];
        $invalid = [];

        // Ensure rules are not empty and include necessary constraints
        if (empty($rules)) {
            Log::warning("No validation rules provided for file import: {$filePath}");
        }

        foreach ($collection as $row) {
            $rowData = array_merge($row->toArray(), $fixedValues);

            $validator = Validator::make($rowData, $rules);

            if ($validator->fails()) {
                $rowData['errors'] = implode('; ', $validator->errors()->all());
                $invalid[] = $rowData;
            } else {
                $valid[] = Arr::only($rowData, array_keys($rules));
            }
        }

        return [
            'valid' => $valid,
            'invalid' => $invalid,
        ];
    }

    /**
     * Import to database directly (only valid rows).
     *
     * @param string $filePath
     * @param string $target Table name or Eloquent Model::class
     * @param array $rules
     * @param array $fieldMap
     * @param array $fixedValues
     * @return array
     * @throws Exception
     */
    public static function importToDatabase(string $filePath, string $target, array $rules = [], array $fieldMap = [], array $fixedValues = []): array
    {
        // Validate file path
        if (!self::isValidFilePath($filePath)) {
            Log::warning("Invalid file path attempted: {$filePath}");
            throw new Exception("Invalid file path. File must be located in the storage/app directory.");
        }

        try {
            $result = self::importToArray($filePath, $rules, $fieldMap, $fixedValues);
        } catch (Exception $e) {
            throw new Exception("Failed to process file: {$e->getMessage()}");
        }

        $inserted = 0;

        if (!empty($result['valid'])) {
            try {
                DB::beginTransaction();
                $inserted = self::insertRows($result['valid'], $target);
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                Log::error("Database insertion failed for target: {$target}", ['exception' => $e->getMessage()]);
                throw new Exception("Database insertion failed: {$e->getMessage()}");
            } catch (Exception $e) {
                DB::rollBack();
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
     * Load and map Excel/CSV file into a collection.
     *
     * @param string $filePath
     * @param array $fieldMap
     * @return Collection
     * @throws Exception
     */
    protected static function loadExcelFile(string $filePath, array $fieldMap = []): Collection
    {
        try {
            $collection = Excel::toCollection(new class implements ToCollection, WithHeadingRow {
                public function collection(Collection $rows)
                {
                    return $rows;
                }
            }, $filePath)->first() ?? collect();
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
     * Insert valid rows into the database.
     *
     * @param array $rows
     * @param string $target
     * @return int
     * @throws Exception
     */
    protected static function insertRows(array $rows, string $target): int
    {
        if (class_exists($target) && is_subclass_of($target, Model::class)) {
            foreach ($rows as $row) {
                try {
                    $target::create($row);
                } catch (QueryException $e) {
                    Log::error("Failed to insert row into model {$target}", ['row' => $row, 'exception' => $e->getMessage()]);
                    throw new Exception("Failed to insert row into model: {$e->getMessage()}");
                }
            }
            return count($rows);
        }

        $rows = array_map(fn($r) => array_merge($r, [
            'created_at' => now(),
            'updated_at' => now(),
        ]), $rows);

        try {
            DB::table($target)->insert($rows);
        } catch (QueryException $e) {
            Log::error("Failed to insert rows into table {$target}", ['exception' => $e->getMessage()]);
            throw new Exception("Failed to insert rows into table: {$e->getMessage()}");
        }

        return count($rows);
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
}
