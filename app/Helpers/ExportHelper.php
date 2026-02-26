<?php
namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Log;

class ExportHelper
{
    protected array $allowedFields = [];
    protected bool $convertToSnakeCase = false;
    protected bool $trimHeaders = false;
    protected array $exampleData = [];
    protected int $chunkSize = 1000; // Default chunk size
    protected string $outputFormat = 'xlsx'; // Default output format

    /**
     * Set allowed fields for export.
     *
     * @param array $allowedFields
     * @return $this
     */
    public function setAllowedFields(array $allowedFields): self
    {
        $this->validateAllowedFields($allowedFields);
        $this->allowedFields = $allowedFields;
        return $this;
    }

    /**
     * Set whether to convert headers to snake_case.
     *
     * @param bool $convertToSnakeCase
     * @return $this
     */
    public function setConvertToSnakeCase(bool $convertToSnakeCase): self
    {
        $this->convertToSnakeCase = $convertToSnakeCase;
        return $this;
    }

    /**
     * Set whether to trim headers.
     *
     * @param bool $trimHeaders
     * @return $this
     */
    public function setTrimHeaders(bool $trimHeaders): self
    {
        $this->trimHeaders = $trimHeaders;
        return $this;
    }

    /**
     * Set example data for the export template.
     *
     * @param array $exampleData
     * @return $this
     */
    public function setExampleData(array $exampleData): self
    {
        $this->validateExampleData($exampleData);
        $this->exampleData = $exampleData;
        return $this;
    }

    /**
     * Set the chunk size for database exports.
     *
     * @param int $chunkSize
     * @return $this
     */
    public function setChunkSize(int $chunkSize): self
    {
        if ($chunkSize <= 0) {
            Log::error('Chunk size must be greater than zero.');
            throw new InvalidArgumentException('Chunk size must be greater than zero.');
        }
        $this->chunkSize = $chunkSize;
        return $this;
    }

    /**
     * Set the output format (e.g., xlsx, csv).
     *
     * @param string $outputFormat
     * @return $this
     */
    public function setOutputFormat(string $outputFormat): self
    {
        $supportedFormats = ['xlsx', 'csv'];
        if (!in_array($outputFormat, $supportedFormats)) {
            Log::error("Unsupported output format: $outputFormat. Supported formats are: " . implode(', ', $supportedFormats));
            throw new InvalidArgumentException("Unsupported output format: $outputFormat. Supported formats are: " . implode(', ', $supportedFormats));
        }
        $this->outputFormat = $outputFormat;
        return $this;
    }

    /**
     * Export a template file with headers and example data.
     *
     * @param string|null $filePath
     * @param string|null $filename
     * @return array ['success' => bool, 'message' => string]
     */
    public function exportTemplate(?string $filePath = null, ?string $filename = null): array
    {
        try {
            if (empty($this->allowedFields)) {
                Log::error('Allowed fields must be defined to generate a template.');
                return [
                    'success' => false,
                    'message' => 'Allowed fields must be defined to generate a template.',
                ];
            }

            // Create a new spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Write the header row
            $headers = $this->convertHeadersForExport();
            $sheet->fromArray([$headers], null, 'A1');

            // Add example data rows if provided
            if (!empty($this->exampleData)) {
                $this->validateExampleData($this->exampleData);
                foreach ($this->exampleData as $rowIndex => $row) {
                    $formattedRow = $this->formatRow($row);
                    $sheet->fromArray([$formattedRow], null, 'A' . ($rowIndex + 2));
                }
            }

            // Save or stream the file
            if ($filePath) {
                $writer = $this->getWriter($spreadsheet);
                $writer->save($filePath);
                Log::info('Template file has been generated successfully.');
                return [
                    'success' => true,
                    'message' => "Template file has been generated successfully.",
                ];
            } else {
                return $this->streamFile($spreadsheet, $filename ?? 'template.' . $this->outputFormat);
            }
        } catch (\Exception $e) {
            Log::error('Template export failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error exporting template: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Export data directly from the database.
     *
     * @param Builder $query
     * @param string|null $filePath
     * @param string|null $filename
     * @return array ['success' => bool, 'message' => string]
     */
    public function exportFromDatabase(Builder $query, ?string $filePath = null, ?string $filename = null): array
    {
        try {
            if (empty($this->allowedFields)) {
                Log::error('Allowed fields must be defined to generate the export.');
                return [
                    'success' => false,
                    'message' => 'Allowed fields must be defined to generate the export.',
                ];
            }

            // Create a new spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Write the header row
            $headers = $this->convertHeadersForExport();
            $sheet->fromArray([$headers], null, 'A1');

            // Fetch data from the database in chunks
            $query->chunk($this->chunkSize, function ($results) use ($sheet) {
                foreach ($results as $rowIndex => $row) {
                    $formattedRow = $this->formatRow($row);
                    $sheet->fromArray([$formattedRow], null, 'A' . ($rowIndex + 2));
                }
            });

            // Save or stream the file
            if ($filePath) {
                $writer = $this->getWriter($spreadsheet);
                $writer->save($filePath);
                Log::info('Data has been exported successfully.');
                return [
                    'success' => true,
                    'message' => "Data has been exported successfully.",
                ];
            } else {
                return $this->streamFile($spreadsheet, $filename ?? 'database_export.' . $this->outputFormat);
            }
        } catch (\Exception $e) {
            Log::error('Database export failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error exporting data: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Convert headers for export based on configuration.
     *
     * @return array
     */
    protected function convertHeadersForExport(): array
    {
        $headers = $this->allowedFields;
        if ($this->convertToSnakeCase) {
            $headers = array_map(function ($header) {
                return str_replace(' ', '_', strtolower($header));
            }, $headers);
        }
        if ($this->trimHeaders) {
            $headers = array_map('trim', $headers);
        }
        return $headers;
    }

    /**
     * Format a single row for export.
     *
     * @param mixed $row
     * @return array
     */
    protected function formatRow($row): array
    {
        $formattedRow = [];
        foreach ($this->allowedFields as $field) {
            $formattedRow[] = data_get($row, $field, '');
        }
        return $formattedRow;
    }

    /**
     * Validate allowed fields.
     *
     * @param array $allowedFields
     * @throws InvalidArgumentException
     */
    protected function validateAllowedFields(array $allowedFields): void
    {
        if (empty($allowedFields)) {
            Log::error('Allowed fields cannot be empty.');
            throw new InvalidArgumentException('Allowed fields cannot be empty.');
        }
    }

    /**
     * Validate example data.
     *
     * @param array $exampleData
     * @throws InvalidArgumentException
     */
    protected function validateExampleData(array $exampleData): void
    {
        if (!empty($exampleData)) {
            foreach ($exampleData as $row) {
                if (!is_array($row)) {
                    Log::error('Each row in example data must be an array.');
                    throw new InvalidArgumentException('Each row in example data must be an array.');
                }
            }
        }
    }

    /**
     * Get the appropriate writer based on output format.
     *
     * @param Spreadsheet $spreadsheet
     * @return IWriter
     */
    public function getWriter(Spreadsheet $spreadsheet): IWriter|Csv|Xlsx
    {
        return $this->outputFormat === 'csv' ? new Csv($spreadsheet) : new Xlsx($spreadsheet);
    }

    /**
     * Stream the file to the browser.
     *
     * @param Spreadsheet $spreadsheet
     * @param string $filename
     * @return array ['success' => bool, 'message' => string]
     */
    protected function streamFile(Spreadsheet $spreadsheet, string $filename): array
    {
        $writer = $this->getWriter($spreadsheet);

        header('Content-Type: application/' . ($this->outputFormat === 'csv' ? 'csv' : 'vnd.malformations-office document.spreadsheet.sheet'));
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        Log::info('File streamed successfully.');
        return [
            'success' => true,
            'message' => "File streamed successfully.",
        ];
    }
}
