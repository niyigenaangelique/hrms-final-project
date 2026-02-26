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
 * Class ActivityLog
 *
 * @property string $id
 * @property string $code
 * @property string $user_id
 * @property string $action
 * @property string $module
 * @property string $description
 * @property string $ip_address
 * @property string $user_agent
 * @property array $old_values
 * @property array $new_values
 * @property string $status
 * @property Carbon $created_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @property ApprovalStatus $approval_status
 *
 * @property Carbon|null $deleted_at
 * @property Carbon $updated_at
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $deleter
 * @property-read User $user
 */

class ActivityLog extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
        'status',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public static function logActivity($userId, $action, $module, $description, $oldValues = [], $newValues = [])
    {
        return self::create([
            'code' => 'ACT-' . uniqid(),
            'user_id' => $userId,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'status' => 'completed',
            'approval_status' => ApprovalStatus::Initiated,
            'created_by' => $userId,
        ]);
    }

    public static function logLogin($userId, $description = null)
    {
        return self::logActivity(
            $userId,
            'login',
            'authentication',
            $description ?? 'User logged in',
            [],
            []
        );
    }

    public static function logLogout($userId, $description = null)
    {
        return self::logActivity(
            $userId,
            'logout',
            'authentication',
            $description ?? 'User logged out',
            [],
            []
        );
    }

    public static function logCreate($userId, $module, $description, $newValues = [])
    {
        return self::logActivity(
            $userId,
            'create',
            $module,
            $description,
            [],
            $newValues
        );
    }

    public static function logUpdate($userId, $module, $description, $oldValues = [], $newValues = [])
    {
        return self::logActivity(
            $userId,
            'update',
            $module,
            $description,
            $oldValues,
            $newValues
        );
    }

    public static function logDelete($userId, $module, $description, $oldValues = [])
    {
        return self::logActivity(
            $userId,
            'delete',
            $module,
            $description,
            $oldValues,
            []
        );
    }

    public static function logFailedLogin($userId, $description = null)
    {
        return self::create([
            'code' => 'ACT-' . uniqid(),
            'user_id' => $userId,
            'action' => 'failed_login',
            'module' => 'authentication',
            'description' => $description ?? 'Failed login attempt',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_values' => [],
            'new_values' => [],
            'status' => 'failed',
            'approval_status' => ApprovalStatus::Initiated,
            'created_by' => $userId,
        ]);
    }

    public function getActionColor()
    {
        return match($this->action) {
            'login', 'create' => 'green',
            'logout', 'update' => 'blue',
            'delete' => 'red',
            'failed_login' => 'red',
            default => 'gray',
        };
    }

    public function getActionIcon()
    {
        return match($this->action) {
            'login' => 'sign-in',
            'logout' => 'sign-out',
            'create' => 'plus-circle',
            'update' => 'edit',
            'delete' => 'trash',
            'failed_login' => 'x-circle',
            default => 'info-circle',
        };
    }
}
