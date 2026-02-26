<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\SecuritySetting;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AccessControlService
{
    public function login($credentials)
    {
        $settings = SecuritySetting::getLoginSettings();
        
        // Check for rate limiting
        $this->checkRateLimit($credentials['email'], $settings['max_login_attempts']);
        
        // Attempt authentication
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Your account has been deactivated. Please contact administrator.',
                ]);
            }
            
            // Log successful login
            ActivityLog::logLogin($user->id, 'User logged in successfully');
            
            // Clear rate limiting
            RateLimiter::clear($this->getThrottleKey($credentials['email']));
            
            return $user;
        }
        
        // Log failed login
        $this->handleFailedLogin($credentials['email'], $settings);
        
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }
    
    private function checkRateLimit($email, $maxAttempts)
    {
        if (RateLimiter::tooManyAttempts($this->getThrottleKey($email), $maxAttempts)) {
            $seconds = RateLimiter::availableIn($this->getThrottleKey($email));
            
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
            ]);
        }
    }
    
    private function handleFailedLogin($email, $settings)
    {
        $user = User::where('email', $email)->first();
        
        if ($user) {
            ActivityLog::logFailedLogin($user->id, 'Failed login attempt');
        } else {
            ActivityLog::logFailedLogin(null, "Failed login attempt for email: {$email}");
        }
        
        RateLimiter::hit($this->getThrottleKey($email));
        
        // Check if we should send an alert
        $attempts = RateLimiter::attempts($this->getThrottleKey($email));
        if ($attempts >= $settings['failed_login_threshold'] && $settings['enable_failed_login_alerts']) {
            $this->sendFailedLoginAlert($email, $attempts);
        }
    }
    
    private function getThrottleKey($email)
    {
        return 'login|' . strtolower($email);
    }
    
    private function sendFailedLoginAlert($email, $attempts)
    {
        // Send alert to administrators about suspicious activity
        // This would integrate with the notification system
        ActivityLog::logActivity(
            null,
            'security_alert',
            'security',
            "Multiple failed login attempts detected for email: {$email} ({$attempts} attempts)"
        );
    }
    
    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            ActivityLog::logLogout($user->id, 'User logged out');
            Auth::logout();
        }
    }
    
    public function checkPermission($user, $permission)
    {
        if (!$user) {
            return false;
        }
        
        // Super Admin has all permissions
        if ($user->user_role === 'SuperAdmin') {
            return true;
        }
        
        // Check user's role permissions
        $role = Role::where('user_role', $user->user_role)
            ->with('permissions.permission')
            ->first();
        
        if (!$role) {
            return false;
        }
        
        return $role->hasPermission($permission);
    }
    
    public function getUserPermissions($user)
    {
        if (!$user) {
            return [];
        }
        
        // Super Admin has all permissions
        if ($user->user_role === 'SuperAdmin') {
            return Permission::where('is_active', true)->pluck('name')->toArray();
        }
        
        $role = Role::where('user_role', $user->user_role)
            ->with('permissions.permission')
            ->first();
        
        if (!$role) {
            return [];
        }
        
        return $role->getPermissions()->pluck('name')->toArray();
    }
    
    public function createRole($data)
    {
        $role = Role::create([
            'code' => 'ROLE-' . uniqid(),
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'user_role' => $data['user_role'],
            'is_active' => true,
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);
        
        ActivityLog::logCreate(auth()->id(), 'role_management', "Created role: {$role->name}", $data);
        
        return $role;
    }
    
    public function updateRole($role, $data)
    {
        $oldValues = $role->toArray();
        
        $role->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? $role->description,
            'user_role' => $data['user_role'],
            'updated_by' => auth()->id(),
        ]);
        
        $newValues = $role->toArray();
        
        ActivityLog::logUpdate(auth()->id(), 'role_management', "Updated role: {$role->name}", $oldValues, $newValues);
        
        return $role;
    }
    
    public function deleteRole($role)
    {
        $data = $role->toArray();
        $roleName = $role->name;
        
        $role->delete();
        
        ActivityLog::logDelete(auth()->id(), 'role_management', "Deleted role: {$roleName}", $data);
    }
    
    public function assignPermissionToRole($role, $permissionId)
    {
        $rolePermission = $role->assignPermission($permissionId);
        
        ActivityLog::logCreate(auth()->id(), 'role_management', "Assigned permission to role: {$role->name}", [
            'role' => $role->name,
            'permission_id' => $permissionId,
        ]);
        
        return $rolePermission;
    }
    
    public function revokePermissionFromRole($role, $permissionId)
    {
        $role->revokePermission($permissionId);
        
        ActivityLog::logDelete(auth()->id(), 'role_management', "Revoked permission from role: {$role->name}", [
            'role' => $role->name,
            'permission_id' => $permissionId,
        ]);
    }
    
    public function createUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        
        $user = User::create(array_merge($data, [
            'created_by' => auth()->id(),
        ]));
        
        ActivityLog::logCreate(auth()->id(), 'user_management', "Created user: {$user->name}", [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->user_role,
        ]);
        
        return $user;
    }
    
    public function updateUser($user, $data)
    {
        $oldValues = $user->toArray();
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update(array_merge($data, [
            'updated_by' => auth()->id(),
        ]));
        
        $newValues = $user->toArray();
        
        ActivityLog::logUpdate(auth()->id(), 'user_management', "Updated user: {$user->name}", $oldValues, $newValues);
        
        return $user;
    }
    
    public function deleteUser($user)
    {
        $data = $user->toArray();
        $userName = $user->name;
        
        $user->delete();
        
        ActivityLog::logDelete(auth()->id(), 'user_management', "Deleted user: {$userName}", $data);
    }
    
    public function deactivateUser($user)
    {
        $oldValues = $user->toArray();
        
        $user->update([
            'is_active' => false,
            'updated_by' => auth()->id(),
        ]);
        
        $newValues = $user->toArray();
        
        ActivityLog::logUpdate(auth()->id(), 'user_management', "Deactivated user: {$user->name}", $oldValues, $newValues);
        
        return $user;
    }
    
    public function activateUser($user)
    {
        $oldValues = $user->toArray();
        
        $user->update([
            'is_active' => true,
            'updated_by' => auth()->id(),
        ]);
        
        $newValues = $user->toArray();
        
        ActivityLog::logUpdate(auth()->id(), 'user_management', "Activated user: {$user->name}", $oldValues, $newValues);
        
        return $user;
    }
    
    public function resetPassword($user, $newPassword)
    {
        $oldValues = $user->toArray();
        
        $user->update([
            'password' => Hash::make($newPassword),
            'updated_by' => auth()->id(),
        ]);
        
        $newValues = $user->toArray();
        
        ActivityLog::logUpdate(auth()->id(), 'user_management', "Reset password for user: {$user->name}", $oldValues, $newValues);
        
        return $user;
    }
    
    public function getSecuritySettings()
    {
        return SecuritySetting::getSecuritySettings();
    }
    
    public function updateSecuritySetting($key, $value, $description = null)
    {
        $oldValue = SecuritySetting::getValue($key);
        
        SecuritySetting::setValue($key, $value, $description);
        
        ActivityLog::logUpdate(auth()->id(), 'security_settings', "Updated security setting: {$key}", [
            'key' => $key,
            'old_value' => $oldValue,
        ], [
            'key' => $key,
            'new_value' => $value,
        ]);
    }
    
    public function validatePassword($password)
    {
        $settings = SecuritySetting::getLoginSettings();
        
        if (strlen($password) < $settings['password_min_length']) {
            return false;
        }
        
        if ($settings['password_require_uppercase'] && !preg_match('/[A-Z]/', $password)) {
            return false;
        }
        
        if ($settings['password_require_lowercase'] && !preg_match('/[a-z]/', $password)) {
            return false;
        }
        
        if ($settings['password_require_numbers'] && !preg_match('/[0-9]/', $password)) {
            return false;
        }
        
        if ($settings['password_require_symbols'] && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return false;
        }
        
        return true;
    }
    
    public function getSessionTimeout()
    {
        return SecuritySetting::getInteger('session_timeout', 120); // minutes
    }
    
    public function checkSessionTimeout()
    {
        $timeout = $this->getSessionTimeout();
        $lastActivity = session('last_activity');
        
        if ($lastActivity && (time() - $lastActivity) > ($timeout * 60)) {
            $this->logout();
            return true;
        }
        
        session(['last_activity' => time()]);
        return false;
    }
    
    public function logActivity($action, $module, $description, $oldValues = [], $newValues = [])
    {
        ActivityLog::logActivity(auth()->id(), $action, $module, $description, $oldValues, $newValues);
    }
    
    public function getActivityLogs($filters = [])
    {
        $query = ActivityLog::with('user');
        
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        
        if (isset($filters['action'])) {
            $query->where('action', $filters['action']);
        }
        
        if (isset($filters['module'])) {
            $query->where('module', $filters['module']);
        }
        
        if (isset($filters['start_date'])) {
            $query->where('created_at', '>=', $filters['start_date']);
        }
        
        if (isset($filters['end_date'])) {
            $query->where('created_at', '<=', $filters['end_date']);
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function getSecurityStats($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? now()->subDays(30);
        $endDate = $endDate ?? now();
        
        return [
            'total_logins' => ActivityLog::where('action', 'login')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'failed_logins' => ActivityLog::where('action', 'failed_login')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
        ];
    }
}
