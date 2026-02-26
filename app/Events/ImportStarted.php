<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $target;
    public $filePath;
    public $fixedValues;
    public $userId;

    public function __construct(string $target, string $filePath, array $fixedValues, int $userId)
    {
        $this->target = $target;
        $this->filePath = $filePath;
        $this->fixedValues = $fixedValues;
        $this->userId = $userId;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('job-results.' . $this->userId);
    }
}
