<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\FlexibleExporterHelper;
use App\Events\ExportCompleted;
use App\Models\JobResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ExportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected EloquentBuilder|QueryBuilder $query;
    protected string $fileName;
    protected string $format;
    protected array $columns;
    protected int $chunkSize;
    protected mixed $userId;

    public function __construct(EloquentBuilder|QueryBuilder $query, string $fileName, string $format = 'csv', array $columns = [], int $chunkSize = 1000, $userId = null)
    {
        $this->query = $query;
        $this->fileName = $fileName;
        $this->format = $format;
        $this->columns = $columns;
        $this->chunkSize = $chunkSize;
        $this->userId = $userId ?? Auth::id();
    }

    public function handle(): void
    {
        $jobResult = JobResult::create([
            'job_id' => $this->job->getJobId(),
            'job_type' => 'export',
            'message' => 'Export job queued.',
            'status' => 'queued',
            'user_id' => $this->userId,
        ]);

        try {
            $result = FlexibleExporterHelper::export(
                $this->query,
                $this->fileName,
                $this->format,
                $this->columns,
                $this->chunkSize
            );

            $jobResult->update([
                'file_path' => $result['file_path'],
                'message' => $result['message'],
                'status' => 'completed',
            ]);

            event(new ExportCompleted($jobResult));
            Log::info('Export job completed', $result);
        } catch (\Exception $e) {
            $jobResult->update([
                'message' => 'Export failed: ' . $e->getMessage(),
                'status' => 'failed',
            ]);

            event(new ExportCompleted($jobResult));
            Log::error('Export job failed', [
                'fileName' => $this->fileName,
                'error' => $e->getMessage(),
            ]);

            $this->fail($e);
        }
    }
    public function getTheJobId(): ?string
    {
        return $this->job?->getJobId();
    }
}

