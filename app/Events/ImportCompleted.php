<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\JobResult;

class ImportCompleted
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public JobResult $jobResult;

    /**
     * Create a new event instance.
     *
     * @param JobResult $jobResult
     */
    public function __construct(JobResult $jobResult)
    {
        $this->jobResult = $jobResult;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel("job-results.{$this->jobResult->user_id}");
    }

    /**
     * Get the event name for broadcasting.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'ImportCompleted';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'jobResult' => [
                'id' => $this->jobResult->id,
                'job_id' => $this->jobResult->job_id,
                'job_type' => $this->jobResult->job_type,
                'message' => $this->jobResult->message,
                'status' => $this->jobResult->status,
                'file_path' => $this->jobResult->file_path,
                'user_id' => $this->jobResult->user_id,
                'fixed_values' => $this->jobResult->fixed_values, // Include fixed values
            ],
        ];
    }
}
