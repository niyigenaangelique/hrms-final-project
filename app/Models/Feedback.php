<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Feedback
 *
 * @property string $id
 * @property string $code
 * @property string $performance_review_id
 * @property string $giver_id
 * @property string $receiver_id
 * @property string $feedback_type
 * @property string $relationship
 * @property string $rating
 * @property string $strengths
 * @property string $areas_for_improvement
 * @property string $comments
 * @property string $status
 * @property Carbon $feedback_date
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
 * @property-read PerformanceReview $performanceReview
 * @property-read Employee $giver
 * @property-read Employee $receiver
 */

class Feedback extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'performance_review_id',
        'giver_id',
        'receiver_id',
        'feedback_type',
        'relationship',
        'rating',
        'strengths',
        'areas_for_improvement',
        'comments',
        'status',
        'feedback_date',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'feedback_date' => 'datetime',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function performanceReview(): BelongsTo
    {
        return $this->belongsTo(PerformanceReview::class);
    }

    public function giver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'giver_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'receiver_id');
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
}
