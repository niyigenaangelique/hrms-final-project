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
 * Class PerformanceReview
 *
 * @property string $id
 * @property string $code
 * @property string $employee_id
 * @property string $reviewer_id
 * @property string $review_period_start
 * @property string $review_period_end
 * @property string $type
 * @property string $overall_rating
 * @property string $overall_score
 * @property string $strengths
 * @property string $areas_for_improvement
 * @property string $development_plan
 * @property string $employee_comments
 * @property string $manager_comments
 * @property string $status
 * @property Carbon $review_date
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
 * @property-read Employee $reviewer
 * @property-read Collection|PerformanceReviewItem[] $items
 * @property-read Collection|Feedback[] $feedback
 */

class PerformanceReview extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'employee_id',
        'reviewer_id',
        'review_period_start',
        'review_period_end',
        'type',
        'overall_rating',
        'overall_score',
        'strengths',
        'areas_for_improvement',
        'development_plan',
        'employee_comments',
        'manager_comments',
        'status',
        'review_date',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'review_period_start' => 'date',
            'review_period_end' => 'date',
            'overall_score' => 'decimal:2',
            'review_date' => 'datetime',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'reviewer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PerformanceReviewItem::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
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

    public function calculateOverallScore(): void
    {
        $totalScore = $this->items->sum('score');
        $totalWeight = $this->items->sum('weight');
        
        if ($totalWeight > 0) {
            $this->overall_score = $totalScore / $totalWeight;
        } else {
            $this->overall_score = 0;
        }
        
        $this->save();
    }
}
