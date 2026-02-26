<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Exception;

class FlexibleExporterHelper
{
    /**
     * Export data from a query to Excel or CSV.
     *
     * @param EloquentBuilder|QueryBuilder $query The query to fetch data
     * @param string $fileName Base name for the output file (without extension)
     * @param string $format Output format ('csv' or 'xlsx')
     * @param array $columns Columns to export (maps database fields to export headers)
     * @param int $chunkSize Number of rows to process per chunk
     * @return array Export result including file path and message
     * @throws Exception If export fails
     */
    public static function export($query, string $fileName, string $format = 'csv', array $columns = [], int $chunkSize = 1000): array
    {
        try {
            // Validate format
            if (!in_array($format, ['csv', 'xlsx'])) {
                throw new Exception('Invalid format. Use "csv" or "xlsx".');
            }

            // Generate unique file name
            $fileName = sprintf('%s_%s.%s', $fileName, Str::uuid(), $format);
            $filePath = storage_path("app/public/{$fileName}");

            // Build collection from query
            $collection = self::buildCollection($query, $columns, $chunkSize);

            if ($collection->isEmpty()) {
                return self::formatResult(null, 'No data to export.');
            }

            // Export to file
            self::exportToFile($collection, $filePath, $format, $columns);

            return self::formatResult(asset("storage/{$fileName}"), 'Export completed.');
        } catch (Exception $e) {
            return self::formatResult(null, 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Build a collection from the query with optional column mapping.
     *
     * @param EloquentBuilder|QueryBuilder $query
     * @param array $columns
     * @param int $chunkSize
     * @return Collection
     */
    protected static function buildCollection($query, array $columns, int $chunkSize): Collection
    {
        $collection = collect();

        // Handle Eloquent or Query Builder
        $callback = fn($rows) => $collection->push(...self::mapColumns($rows, $columns));

        if ($query instanceof EloquentBuilder) {
            $query->chunk($chunkSize, $callback);
        } else {
            $query->chunk($chunkSize, $callback);
        }

        return $collection;
    }

    /**
     * Map database rows to export columns.
     *
     * @param iterable $rows
     * @param array $columns
     * @return array
     */
    protected static function mapColumns(iterable $rows, array $columns): array
    {
        $mapped = [];

        foreach ($rows as $row) {
            $rowArray = is_array($row) ? $row : $row->toArray();

            // If no columns specified, use all columns
            if (empty($columns)) {
                $mapped[] = $rowArray;
                continue;
            }

            // Map database fields to export headers
            $mappedRow = [];
            foreach ($columns as $dbField => $exportHeader) {
                $mappedRow[is_numeric($dbField) ? $exportHeader : $exportHeader] = $rowArray[$dbField] ?? null;
            }
            $mapped[] = $mappedRow;
        }

        return $mapped;
    }

    /**
     * Export collection to Excel or CSV file.
     *
     * @param Collection $collection
     * @param string $filePath
     * @param string $format
     * @param array $columns
     */
    protected static function exportToFile(Collection $collection, string $filePath, string $format, array $columns): void
    {
        Excel::store(new class($collection, $columns) implements FromCollection, WithHeadings {
            protected $collection;
            protected $columns;

            public function __construct(Collection $collection, array $columns)
            {
                $this->collection = $collection;
                $this->columns = $columns;
            }

            public function collection()
            {
                return $this->collection;
            }

            public function headings(): array
            {
                if (empty($this->columns)) {
                    return array_keys($this->collection->first() ?? []);
                }

                return array_values($this->columns);
            }
        }, $filePath, 'public', $format === 'xlsx' ? \Maatwebsite\Excel\Excel::XLSX : \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Format the result array.
     *
     * @param string|null $filePath
     * @param string $message
     * @return array
     */
    protected static function formatResult(?string $filePath, string $message): array
    {
        return [
            'file_path' => $filePath,
            'message' => $message,
        ];
    }
}
