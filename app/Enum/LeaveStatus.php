<?php

namespace App\Enum;

enum LeaveStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
            self::COMPLETED => 'Completed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'yellow',
            self::APPROVED => 'green',
            self::REJECTED => 'red',
            self::CANCELLED => 'gray',
            self::COMPLETED => 'blue',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'clock',
            self::APPROVED => 'check-circle',
            self::REJECTED => 'x-circle',
            self::CANCELLED => 'ban',
            self::COMPLETED => 'check',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::PENDING => 'Leave request is waiting for approval',
            self::APPROVED => 'Leave request has been approved',
            self::REJECTED => 'Leave request has been rejected',
            self::CANCELLED => 'Leave request has been cancelled',
            self::COMPLETED => 'Leave period has been completed',
        };
    }
}
