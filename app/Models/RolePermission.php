<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class RolePermission extends Model
{
    protected $table    = 'role_permissions';
    protected $fillable = ['role', 'permission', 'allowed'];
    protected $casts    = ['allowed' => 'boolean'];
 
    /**
     * Check whether a given role has a permission.
     * Call: RolePermission::allows('hr_manager', 'payroll.approve')
     */
    public static function allows(string $role, string $permission): bool
    {
        if ($role === 'admin') return true; // admin always passes
 
        return static::where('role', $role)
            ->where('permission', $permission)
            ->where('allowed', true)
            ->exists();
    }
 
    /**
     * Get all permissions for a role as a flat key=>bool array.
     */
    public static function forRole(string $role): array
    {
        return static::where('role', $role)
            ->pluck('allowed', 'permission')
            ->map(fn($v) => (bool) $v)
            ->toArray();
    }
}
 
 