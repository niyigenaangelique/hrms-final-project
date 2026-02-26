<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\FlexibleImporterHelper;
use App\Events\ImportCompleted;
use App\Models\JobResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected string $target;
    protected array $rules;
    protected int $chunkSize;
    protected mixed $userId;
    protected array $fixedValues;

    /**
     * Create a new job instance.
     *
     * @param string $filePath Path to the uploaded file
     * @param string $target Table name or Eloquent model class
     * @param array $rules Validation rules for each column
     * @param int $chunkSize Number of rows to process per chunk
     * @param mixed|null $userId User ID for the job
     * @param array $fixedValues Fixed values to merge into each row (e.g., ['project_id' => 1])
     */
    public function __construct(string $filePath, string $target, array $rules = [], int $chunkSize = 100, mixed $userId = null, array $fixedValues = [])
    {
        $this->filePath = $filePath;
        $this->target = $target;
        $this->rules = $rules;
        $this->chunkSize = $chunkSize;
        $this->userId = $userId ?? Auth::id();
        $this->fixedValues = $fixedValues;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobResult = JobResult::create([
            'job_id' => $this->job->getJobId(),
            'job_type' => 'import',
            'message' => 'Import job queued.',
            'status' => 'queued',
            'user_id' => $this->userId,
            'fixed_values' => $this->fixedValues, // Store fixed values
        ]);

        try {
            $result = FlexibleImporterHelper::import(
                $this->filePath,
                $this->target,
                $this->rules,
                $this->chunkSize,
                $this->fixedValues
            );

            $jobResult->update([
                'file_path' => $result['valid_file'] ?? $result['error_file'],
                'message' => $result['message'] . ($result['inserted'] ? " Inserted {$result['inserted']} rows." : '') . (!empty($this->fixedValues) ? " Fixed values: " . json_encode($this->fixedValues) : ''),
                'status' => 'completed',
                'fixed_values' => $this->fixedValues, // Update fixed values
            ]);

            event(new ImportCompleted($jobResult));
            Log::info('Import job completed', [
                'file' => $this->filePath,
                'target' => $this->target,
                'inserted' => $result['inserted'],
                'fixed_values' => $this->fixedValues,
            ]);
        } catch (\Exception $e) {
            $jobResult->update([
                'file_path' => $result['error_file'] ?? null,
                'message' => 'Import failed: ' . $e->getMessage(),
                'status' => 'failed',
                'fixed_values' => $this->fixedValues, // Store fixed values on failure
            ]);

            event(new ImportCompleted($jobResult));
            Log::error('Import job failed', [
                'file' => $this->filePath,
                'target' => $this->target,
                'error' => $e->getMessage(),
                'fixed_values' => $this->fixedValues,
            ]);

            $this->fail($e);
        }
    }

    public function getTheJobId(): ?string
    {
        return $this->job?->getJobId();
    }
}
