<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
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
 * Class JobResult
 *
 * @property string $id
 * @property string $job_id
 * @property string $job_type
 * @property string $file_path
 * @property string $message
 * @property array $fixed_values
 * @property string $status
 *
 * @property string $user_id
 *
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static updateOrCreate(array $attributes, array $values)
 * @method static create(array $attributes)
 * @method static update(array $attributes)
 * @method static where(string $column, $value)
 * @method static latest(string $column = 'created_at')
 * @method static find($id)
 *
 */

class JobResult extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'job_id',
        'job_type',
        'message',
        'fixed_values',
        'status',
        'file_path',
        'user_id',
    ];


    protected function casts(): array
    {
        return [
            'fixed_values' => 'array', // Cast JSON to array
        ];
    }

    protected $hidden = [

    ];



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
        return $this->belongsTo(User::class, 'user_id');
    }

}
