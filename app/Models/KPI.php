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
 * Class KPI
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $category
 * @property string $measurement_unit
 * @property string $target_type
 * @property string $target_value
 * @property string $weight_percentage
 * @property bool $is_active
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
 * @property-read Collection|KPITarget[] $targets
 */

class KPI extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $table = 'kpis';

    protected $fillable = [
        'code',
        'name',
        'description',
        'category',
        'measurement_unit',
        'target_type',
        'target_value',
        'weight_percentage',
        'is_active',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'target_value' => 'decimal:2',
            'weight_percentage' => 'decimal:2',
            'is_active' => 'boolean',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function targets(): HasMany
    {
        return $this->hasMany(KPITarget::class);
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
