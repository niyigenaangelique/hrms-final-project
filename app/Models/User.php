<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\ApprovalStatus;
use App\Enum\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * Class User
 *
 * @property string $id
 * @property string $code
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string $username
 * @property string|null $email
 * @property string $phone_number
 * @property string $password
 * @property Carbon|null $phone_verified_at
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $password_changed_at
 * @property UserRole $role
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $created_by
 * @property string $updated_by
 * @property string $locked_by
 * @property ApprovalStatus $approval_status
 *
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Note[] $notes
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $locker
 *
 * @method static updateOrCreate(array $attributes, array $values)
 * @method static create(array $attributes)
 * @method static where(string $column, $value)
 * @method static latest(string $column = 'created_at')
 * @method static find($id)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasUuids, Notifiable, SoftDeletes;
    protected $fillable = [
        'code',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'password',
        'phone_verified_at',
        'email_verified_at',
        'password_changed_at',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
            'password_changed_at' => 'datetime',
            'role' => UserRole::class,
        ];
    }


    /**
     * Get the user's full name, with middle name if available.
     *
     * Usage:
     * <pre>
     * $user = User::factory()->create();
     * $user->full_name; // "John Doe" or "John M Doe"
     * </pre>
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Get the employee associated with the user.
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Notes associated with this record as a notable entity.
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }


    /**
     * Scope a query to only include users with a given code.
     *
     * @return Builder
     *
     * Example: User::code('USER-001')->first()
     *
     **/
    public function scopeCode($query, string $code): Builder
    {
        return $query->where('code', $code);
    }

    /**
     * Comments associated with this record as a commentable entity.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function projects():BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_users')
            ->using(ProjectUser::class)
            ->withPivot(['id', 'code', 'approval_status', 'is_locked', 'locked_by', 'created_by', 'updated_by'])
            ->withTimestamps();
    }

}
