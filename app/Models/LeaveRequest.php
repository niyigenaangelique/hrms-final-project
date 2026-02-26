<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Enum\LeaveStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class LeaveRequest
 *
 * @property string $id
 * @property string $code
 * @property string $employee_id
 * @property string $leave_type_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $total_days
 * @property string $reason
 * @property string $attachment_path
 * @property Carbon $approved_at
 * @property string $approved_by
 * @property string $rejection_reason
 * @property LeaveStatus $status
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @property ApprovalStatus $approval_status
 *
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $deleter
 * @property-read User|null $approver
 * @property-read Employee $employee
 * @property-read LeaveType $leaveType
 * @property-read Collection|LeaveComment[] $comments
 */

class LeaveRequest extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'attachment_path',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'status',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_days' => 'integer',
            'approved_at' => 'datetime',
            'status' => LeaveStatus::class,
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LeaveComment::class);
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function morphComments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approve(User $approver): void
    {
        $this->update([
            'status' => LeaveStatus::Approved,
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'approval_status' => ApprovalStatus::Approved,
        ]);
    }

    public function reject(string $reason, User $approver): void
    {
        $this->update([
            'status' => LeaveStatus::Rejected,
            'approved_by' => $approver->id,
            'rejection_reason' => $reason,
            'approval_status' => ApprovalStatus::Rejected,
        ]);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => LeaveStatus::Cancelled,
            'approval_status' => ApprovalStatus::Cancelled,
        ]);
    }
}
