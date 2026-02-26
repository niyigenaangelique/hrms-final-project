<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Enum\AttendanceMethod;
use App\Enum\AttendanceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * Class Attendance
 *
 * @property string $id
 * @property string $code
 * @property string $employee_id
 * @property Carbon $date
 * @property Carbon $check_in
 * @property Carbon $check_out
 * @property string $device_id
 * @property AttendanceMethod $check_in_method
 * @property AttendanceMethod $check_out_method
 * @property AttendanceStatus $status
 * @property string $is_locked
 *
 *
 * * @property string $created_by
 * * @property string $updated_by
 * * @property string $locked_by
 * * @property string $deleted_by
 * * @property ApprovalStatus $approval_status
 * *
 * * @property-read Collection|Comment[] $comments
 * * @property-read Collection|Note[] $notes
 * *
 * * @property Carbon|null $deleted_at
 * * @property Carbon $created_at
 * * @property Carbon $updated_at
 *
 * * @property-read User|null $creator
 * * @property-read User|null $updater
 * * @property-read User|null $locker
 * * @property-read User|null $deleter
 *
 * @method static updateOrCreate(array $attributes, array $values)
 * @method static create(array $attributes)
 * @method static update(array $attributes)
 * @method static where(string $column, $value)
 * @method static latest(string $column = 'created_at')
 * @method static find($id)
 *
 */

class Attendance extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'device_id',
        'check_in_method',
        'check_out_method',
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
            'date' => 'date',
            'check_in' => 'datetime:H:i:s',
            'check_out' => 'datetime:H:i:s',
            'check_in_method' => AttendanceMethod::class,
            'check_out_method' => AttendanceMethod::class,
            'status' => AttendanceStatus::class,
            'approval_status' => ApprovalStatus::class,
            'is_locked' => 'boolean',
            ];
    }

    protected $hidden = [

    ];


    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
    public function project():HasManyThrough
    {
        return $this->hasManyThrough(Project::class, Device::class);
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
