<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
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
 * Class Goal
 *
 * @property string $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property string $employee_id
 * @property string $manager_id
 * @property string $category
 * @property string $priority
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $status
 * @property string $progress_percentage
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
 * @property-read Employee $employee
 * @property-read Employee $manager
 * @property-read Collection|GoalUpdate[] $updates
 */

class Goal extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'employee_id',
        'manager_id',
        'category',
        'priority',
        'start_date',
        'end_date',
        'status',
        'progress_percentage',
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
            'progress_percentage' => 'decimal:2',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(GoalUpdate::class);
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

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function updateProgress($percentage): void
    {
        $this->progress_percentage = min(100, max(0, $percentage));
        $this->save();
    }

    public function markCompleted(): void
    {
        $this->status = 'completed';
        $this->progress_percentage = 100;
        $this->save();
    }
}
