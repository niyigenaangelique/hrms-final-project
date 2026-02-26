<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\FlexibleImporterHelper;
use App\Events\ImportStarted;
use App\Events\ImportCompleted;
use Illuminate\Support\Facades\Log;

class FlexibleImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected string $target;
    protected array $rules;
    protected int $chunkSize;
    protected array $fixedValues;
    protected array $fieldMap;
    protected mixed $userId;

    public function __construct(string $filePath, string $target, array $rules, int $chunkSize, array $fixedValues, array $fieldMap, mixed $userId)
    {
        $this->filePath = $filePath;
        $this->target = $target;
        $this->rules = $rules;
        $this->chunkSize = $chunkSize;
        $this->fixedValues = $fixedValues;
        $this->fieldMap = $fieldMap;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        try {
            event(new ImportStarted($this->target, $this->filePath, $this->fixedValues, $this->userId));

            $results = FlexibleImporterHelper::import(
                $this->filePath,
                $this->target,
                $this->rules,
                $this->chunkSize,
                $this->fixedValues,
                $this->fieldMap
            );

            event(new ImportCompleted($this->userId, [
                'job_id' => $this->getJobId(),
                'target' => $this->target,
                'inserted' => $results['inserted'],
                'valid_file' => $results['valid_file'],
                'error_file' => $results['error_file'],
                'message' => $results['message'],
                'fixed_values' => $results['fixed_values'],
            ]));
        } catch (\Exception $e) {
            Log::error('FlexibleImportJob failed', [
                'exception' => $e->getMessage(),
                'target' => $this->target,
                'file_path' => $this->filePath,
                'fixed_values' => $this->fixedValues,
                'user_id' => $this->userId,
            ]);

            event(new ImportCompleted($this->userId, [
                'job_id' => $this->getJobId(),
                'target' => $this->target,
                'inserted' => 0,
                'valid_file' => null,
                'error_file' => null,
                'message' => 'Import failed: ' . $e->getMessage(),
                'fixed_values' => $this->fixedValues,
            ]));
        }
    }

    public function getJobId(): ?string
    {
        return $this->job?->getJobId();
    }
}
