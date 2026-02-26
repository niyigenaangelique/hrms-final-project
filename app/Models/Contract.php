<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Enum\ContractStatus;
use App\Enum\EmployeeCategory;
use App\Enum\RemunerationType;
use App\Helpers\FormattedCodeHelper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 * Class Contract
 *
 * @property string $id
 * @property string $code
 * @property string $project_id
 * @property string $employee_id
 * @property string $position_id
 * @property string $remuneration
 * @property RemunerationType $remuneration_type
 * @property EmployeeCategory $employee_category
 * @property string $daily_working_hours
 * @property string $start_date
 * @property string $end_date
 * @property ContractStatus $status
 *
 * @property bool $is_locked
 * @property string $created_by
 * @property string $updated_by
 * @property string $locked_by
 * @property string $deleted_by
 * @property ApprovalStatus $approval_status
 *
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Note[] $notes
 *
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $locker
 * @property-read User|null $deleter
 *
 * @method static updateOrCreate(array $attributes, array $values)
 * @method static create(array $attributes)
 * @method static update(array $attributes)
 * @method static where(string $column, $value)
 * @method static latest(string $column = 'created_at')
 * @method static find($id)
 *
 */

class Contract extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'project_id',
        'employee_id',
        'position_id',
        'remuneration',
        'remuneration_type',
        'employee_category',
        'daily_working_hours',
        'start_date',
        'end_date',
        'status',
        'approval_status',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'remuneration' => 'decimal:2',
            'daily_working_hours' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_locked' => 'boolean',
            'remuneration_type' => RemunerationType::class,
            'employee_category' => EmployeeCategory::class,
            'status' => ContractStatus::class,
            'approval_status' => ApprovalStatus::class,
        ];
    }

    protected $hidden = [

    ];


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Contract $contract) {
            if (is_null($contract->code)) {
                $contract->code = FormattedCodeHelper::getNextFormattedCode(Contract::class, 'SGA', 5);
            }
            // Set project_id to null since projects table doesn't exist
            $contract->project_id = null;
        });
    }
    // public function project(): BelongsTo
    // {
    //     // Return null relationship since Project model doesn't exist yet
    //     return $this->belongsTo(Project::class);
    // }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }


    /**
     * Notes associated with this record as a notable entity.
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Comments associated with this record as a commentable entity.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Relationships
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
