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
 * Class KPITarget
 *
 * @property string $id
 * @property string $code
 * @property string $kpi_id
 * @property string $employee_id
 * @property string $period_type
 * @property string $period_start
 * @property string $period_end
 * @property string $target_value
 * @property string $actual_value
 * @property string $achievement_percentage
 * @property string $score
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
 * @property-read KPI $kpi
 * @property-read Employee $employee
 */

class KPITarget extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'kpi_id',
        'employee_id',
        'period_type',
        'period_start',
        'period_end',
        'target_value',
        'actual_value',
        'achievement_percentage',
        'score',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'target_value' => 'decimal:2',
            'actual_value' => 'decimal:2',
            'achievement_percentage' => 'decimal:2',
            'score' => 'decimal:2',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function kpi(): BelongsTo
    {
        return $this->belongsTo(KPI::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
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

    public function calculateAchievement(): void
    {
        if ($this->target_value > 0) {
            $this->achievement_percentage = ($this->actual_value / $this->target_value) * 100;
            $this->score = ($this->achievement_percentage / 100) * $this->kpi->weight_percentage;
        } else {
            $this->achievement_percentage = 0;
            $this->score = 0;
        }
        $this->save();
    }
}
