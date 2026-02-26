<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\JobResult;

class ExportCompleted
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public JobResult $jobResult;

    public function __construct(JobResult $jobResult)
    {
        $this->jobResult = $jobResult;
    }

    public function broadcastOn()
    {
        return new Channel("job-results.{$this->jobResult->user_id}");
    }

    public function broadcastAs()
    {
        return 'ExportCompleted';
    }
}
