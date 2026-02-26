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
 * class Role
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $user_role
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
 * @property-read Collection|RolePermission[] $permissions
 * @property-read Collection|User[] $users
 */

class Role extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'user_role',
        'is_active',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role', 'user_role');
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

    public function hasPermission($permission)
    {
        return $this->permissions()
            ->whereHas('permission', function ($query) use ($permission) {
                $query->where('resource', $permission['resource'])
                      ->where('action', $permission['action']);
            })
            ->where('is_active', true)
            ->exists();
    }

    public function getPermissions()
    {
        return $this->permissions()
            ->with('permission')
            ->where('is_active', true)
            ->get()
            ->map(function ($rolePermission) {
                return $rolePermission->permission;
            });
    }

    public function assignPermission($permissionId)
    {
        return RolePermission::firstOrCreate([
            'role_id' => $this->id,
            'permission_id' => $permissionId,
            'is_active' => true,
            'approval_status' => ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);
    }

    public function revokePermission($permissionId)
    {
        return RolePermission::where('role_id', $this->id)
            ->where('permission_id', $permissionId)
            ->delete();
    }

    public function syncPermissions($permissionIds)
    {
        $currentPermissionIds = $this->permissions()->pluck('permission_id')->toArray();
        
        // Remove permissions that are not in the new list
        $toRemove = array_diff($currentPermissionIds, $permissionIds);
        foreach ($toRemove as $permissionId) {
            $this->revokePermission($permissionId);
        }
        
        // Add new permissions
        foreach ($permissionIds as $permissionId) {
            if (!in_array($permissionId, $currentPermissionIds)) {
                $this->assignPermission($permissionId);
            }
        }
    }
}
