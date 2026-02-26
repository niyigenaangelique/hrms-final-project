<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelHelper
{
    protected array $allowedFields = [];
    protected array $validationRules = [];
    protected string $errorLogFile = 'LogFile.xlsx';
    protected bool $hasHeaders = true;
    protected bool $trimHeaders = false;
    protected bool $convertToSnakeCase = false;
    protected int $headerOnRow = 0;
    protected bool $preserveEmptyRows = false;
    protected bool $preserveDateTimeFormatting = false;
    protected array $defaultValues = [];
    protected array $exampleData = [];
    protected int $batchSize = 100;
    protected int $chunkSize = 1000; // Default chunk size
    protected string $outputFormat = 'xlsx'; // Default output format

    public function setAllowedFields(array $allowedFields): self
    {
        $this->validateAllowedFields($allowedFields);
        $this->allowedFields = $allowedFields;
        return $this;
    }

    public function setValidationRules(array $validationRules): self
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    public function setErrorLogFile(string $errorLogFile): self
    {
        $this->errorLogFile = $errorLogFile;
        return $this;
    }

    public function setHasHeaders(bool $hasHeaders): self
    {
        $this->hasHeaders = $hasHeaders;
        return $this;
    }

    public function setTrimHeaders(bool $trimHeaders): self
    {
        $this->trimHeaders = $trimHeaders;
        return $this;
    }

    public function setConvertToSnakeCase(bool $convertToSnakeCase): self
    {
        $this->convertToSnakeCase = $convertToSnakeCase;
        return $this;
    }

    public function setHeaderOnRow(int $headerOnRow): self
    {
        $this->headerOnRow = $headerOnRow;
        return $this;
    }

    public function setPreserveEmptyRows(bool $preserveEmptyRows): self
    {
        $this->preserveEmptyRows = $preserveEmptyRows;
        return $this;
    }

    public function setPreserveDateTimeFormatting(bool $preserveDateTimeFormatting): self
    {
        $this->preserveDateTimeFormatting = $preserveDateTimeFormatting;
        return $this;
    }

    public function setDefaultValues(array $defaultValues): self
    {
        $this->defaultValues = $defaultValues;
        return $this;
    }

    public function setExampleData(array $exampleData): self
    {
        $this->validateExampleData($exampleData);
        $this->exampleData = $exampleData;
        return $this;
    }

    public function setBatchSize(int $batchSize): self
    {
        $this->batchSize = $batchSize;
        return $this;
    }

    public function setChunkSize(int $chunkSize): self
    {
        if ($chunkSize <= 0) {
            Log::error('Chunk size must be greater than zero.');
            throw new InvalidArgumentException('Chunk size must be greater than zero.');
        }
        $this->chunkSize = $chunkSize;
        return $this;
    }

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



    public function __construct(array $allowedFields = [], array $validationRules = [])
    {
        $this->allowedFields = $allowedFields;
        $this->validationRules = $validationRules;
    }

    public function exportSheet():Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Write the header row
        $headers = $this->convertHeadersForExport();
        $sheet->fromArray([$headers], null, 'A1');


        return $spreadsheet;
    }

    public function exportTemplate( ?string $filename = null): array
    {
        try {

            // Create a new spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Write the header row
            $headers = $this->convertHeadersForExport();
            $sheet->fromArray([$headers], null, 'A1');
            $sheet->fromArray($this->exampleData, null, 'A2'); // Add example data rows if provided (this)

            $writer = $this->getWriter($spreadsheet);
            $writer->setPreCalculateFormulas(false);

            $savePath= storage_path('app/public/templates/');
            if (!file_exists($savePath)) {
                mkdir($savePath, 0777, true);
            }
            $writer->save($savePath . $filename . '.' . $this->outputFormat);
            Log::info('Template created successfully.');

            $this->streamFile($spreadsheet, $filename);

            return [
                'success' => true,
                'filePath' => $savePath . $filename . '.' . $this->outputFormat,
                'message' => "Template created successfully.",
            ];





        }catch (Exception $e) {
            // Log the error and return a failure response
            Log::error('Error creating export: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error creating export: ' . $e->getMessage(),
            ];
        }
    }

    protected function validateAllowedFields(array $allowedFields): void
    {
        if (empty($allowedFields)) {
            Log::error('Allowed fields cannot be empty.');
            throw new InvalidArgumentException('Allowed fields cannot be empty.');
        }
    }
    protected function streamFile(Spreadsheet $spreadsheet, string $filename): array
    {
        $writer = $this->getWriter($spreadsheet);

        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer = IOFactory::createWriter($spreadsheet, $this->outputFormat);
        $writer->save('php://output');
        Log::info('File streamed successfully.');
        return [
            'success' => true,
            'message' => "File streamed successfully.",
        ];
    }
    public function getWriter(Spreadsheet $spreadsheet): IWriter|Csv|Xlsx
    {
        return $this->outputFormat === 'csv' ? new Csv($spreadsheet) : new Xlsx($spreadsheet);
    }
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
    protected function formatRow($row): array
    {
        $formattedRow = [];
        foreach ($this->allowedFields as $field) {
            $formattedRow[] = data_get($row, $field, '');
        }
        return $formattedRow;
    }

}
