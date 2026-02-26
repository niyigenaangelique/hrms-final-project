<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Enum\ProjectStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
 * Class Project
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property ProjectStatus $status
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $manager_id
 * @property bool $is_locked
 *
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

class Project extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
        'approval_status',
        'start_date',
        'end_date',
        'address',
        'city',
        'state',
        'country',
        'manager_id',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_locked' => 'boolean',
            'status' => ProjectStatus::class,
            'approval_status' => ApprovalStatus::class,
        ];
    }

    protected $hidden = [

    ];


    /**
     * Scope a query to only include projects with a given code.
     *
     * Usage:
     * <pre>
     * Project::code('PROJ-001')->first();
     * </pre>
     */
    public function scopeCode($query, string $code): Builder
    {
        return $query->where('code', $code);
    }
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }


    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_users')
            ->using(ProjectUser::class)
            ->withPivot(['id', 'code', 'approval_status', 'is_locked', 'locked_by', 'created_by', 'updated_by'])
            ->withTimestamps();
    }
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

   public function employees() :HasManyThrough
   {
       return $this->hasManyThrough(Employee::class, Contract::class);
   }
    public function positions() :HasManyThrough
    {
        return $this->hasManyThrough(Position::class, Contract::class);
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
