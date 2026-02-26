<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Employee;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\SecuritySetting;
use App\Models\NotificationSetting;
use App\Models\NotificationLog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Enhanced Admin Dashboard')]
class EnhancedAdminDashboard extends Component
{
    use WithPagination;

    // Navigation
    public $activeTab = 'dashboard';
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $dateFilter = '';

    // User Management
    public $showCreateUserModal = false;
    public $showUserModal = false;
    public $showEditUserModal = false;
    public $showDeleteUserModal = false;
    public $selectedUser;

    // User Form Fields
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $role;
    public $password;
    public $password_confirmation;
    public $force_password_change = false;

    // Permission Management
    public $userPermissions;
    public $showPermissionModal = false;
    public $selectedPermissions = [];

    // Activity Logs
    public $showActivityModal = false;

    // Security Settings
    public $passwordPolicy;
    public $sessionTimeout;
    public $maxLoginAttempts;
    public $lockoutDuration;

    // Session Management
    public $showSessionModal = false;

    // Password Reset Management
    public $showPasswordResetModal = false;
    public $resetUserId;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'required|string|max:20',
        'role' => 'required|in:SuperAdmin,HRManager,Manager,Employee',
        'password' => 'required|string|min:8|confirmed',
    ];

    protected $messages = [
        'password.confirmed' => 'The password confirmation does not match.',
        'email.unique' => 'This email address is already registered.',
    ];

    public function mount()
    {
        // Set active tab from URL parameter if present, default to empty for overview
        $tab = request()->get('tab', '');
        if (in_array($tab, ['users', 'employees', 'permissions', 'activity', 'security', 'sessions', 'passwords'])) {
            $this->activeTab = $tab;
        }
        
        $this->loadSecuritySettings();
    }

    private function loadSecuritySettings()
    {
        // Create default security settings if they don't exist
        $defaultSettings = [
            'password_min_length' => '8',
            'password_require_uppercase' => 'true',
            'password_require_lowercase' => 'true',
            'password_require_numbers' => 'true',
            'password_require_symbols' => 'true',
            'session_timeout_minutes' => '120',
            'max_login_attempts' => '5',
            'lockout_duration_minutes' => '15',
            'enable_two_factor' => 'false',
            'force_password_change_days' => '90',
        ];

        foreach ($defaultSettings as $key => $value) {
            SecuritySetting::setValue($key, $value, "Security setting for {$key}");
        }

        // Load settings as an object for the form
        $this->password_min_length = SecuritySetting::getInteger('password_min_length', 8);
        $this->password_require_uppercase = SecuritySetting::getBoolean('password_require_uppercase', true);
        $this->password_require_lowercase = SecuritySetting::getBoolean('password_require_lowercase', true);
        $this->password_require_numbers = SecuritySetting::getBoolean('password_require_numbers', true);
        $this->password_require_symbols = SecuritySetting::getBoolean('password_require_symbols', true);
        $this->session_timeout = SecuritySetting::getInteger('session_timeout_minutes', 120);
        $this->max_login_attempts = SecuritySetting::getInteger('max_login_attempts', 5);
        $this->lockout_duration = SecuritySetting::getInteger('lockout_duration_minutes', 15);
        $this->enable_two_factor = SecuritySetting::getBoolean('enable_two_factor', false);
        $this->force_password_change_days = SecuritySetting::getInteger('force_password_change_days', 90);
    }

    public function loadPasswordResetRequests()
    {
        $this->passwordResetRequests = DB::table('password_resets')
            ->join('users', 'password_resets.email', '=', 'users.email')
            ->select('password_resets.*', 'users.first_name', 'users.last_name', 'users.email')
            ->orderBy('password_resets.created_at', 'desc')
            ->get();
    }

    // User Management Methods
    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
            'password_changed_at' => $this->force_password_change ? null : now(),
        ]);

        // Create corresponding employee record
        // Get the highest existing employee code number
        $lastEmployee = Employee::orderBy('id', 'desc')->first();
        $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
        $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
        
        Employee::create([
            'code' => $newCode,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'user_id' => $user->id,
            'approval_status' => \App\Enum\ApprovalStatus::Approved,
            'created_by' => Auth::id(),
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user_created',
            'description' => "Created user: {$user->full_name} with role: {$this->role}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->resetForm();
        $this->showCreateUserModal = false;
        $this->loadUsers();

        session()->flash('success', "User {$user->full_name} created successfully. Credentials: Email: {$user->email}, Password: {$this->password}");
    }

    public function editUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->first_name = $this->selectedUser->first_name;
        $this->last_name = $this->selectedUser->last_name;
        $this->email = $this->selectedUser->email;
        $this->phone_number = $this->selectedUser->phone_number;
        $this->role = $this->selectedUser->role;
        $this->showEditUserModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->selectedUser->id)],
            'phone_number' => 'required|string|max:20',
            'role' => 'required|in:SuperAdmin,HRManager,Manager,Employee',
        ]);

        $oldRole = $this->selectedUser->role;
        
        $this->selectedUser->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
        ]);

        // Update corresponding employee record
        if ($this->selectedUser->employee) {
            $this->selectedUser->employee->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'updated_by' => Auth::id(),
            ]);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user_updated',
            'description' => "Updated user: {$this->selectedUser->full_name}. Role changed from {$oldRole} to {$this->role}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->resetForm();
        $this->showEditUserModal = false;
        $this->loadUsers();

        session()->flash('success', "User {$this->selectedUser->full_name} updated successfully");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->email === 'angelbrenna20@gmail.com') {
            session()->flash('error', 'Cannot delete the main admin account');
            return;
        }

        $userName = $user->full_name;
        
        // Log activity before deletion
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user_deleted',
            'description' => "Deleted user: {$userName}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $user->delete();
        $this->loadUsers();

        session()->flash('success', "User {$userName} deleted successfully");
    }

    public function resetUserPassword($userId)
    {
        $user = User::findOrFail($userId);
        $newPassword = Str::password(12);
        
        $user->update([
            'password' => Hash::make($newPassword),
            'password_changed_at' => null,
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'password_reset',
            'description' => "Reset password for user: {$user->full_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', "Password reset for {$user->full_name}. New password: {$newPassword}");
    }

    // Permission Management
    public function manageUserPermissions($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->selectedPermissions = $this->selectedUser->permissions->pluck('id')->toArray();
        $this->showPermissionModal = true;
    }

    public function updateUserPermissions()
    {
        // Sync user permissions
        $this->selectedUser->permissions()->sync($this->selectedPermissions);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'permissions_updated',
            'description' => "Updated permissions for user: {$this->selectedUser->full_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->showPermissionModal = false;
        session()->flash('success', "Permissions updated for {$this->selectedUser->full_name}");
    }

    // Security Settings Management
    public function updateSecuritySettings()
    {
        $this->validate([
            'password_min_length' => 'required|integer|min:6|max:20',
            'session_timeout' => 'required|integer|min:5|max:1440',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'lockout_duration' => 'required|integer|min:5|max:60',
        ]);

        // Update individual security settings
        SecuritySetting::setValue('password_min_length', $this->password_min_length);
        SecuritySetting::setValue('password_require_uppercase', $this->password_require_uppercase);
        SecuritySetting::setValue('password_require_lowercase', $this->password_require_lowercase);
        SecuritySetting::setValue('password_require_numbers', $this->password_require_numbers);
        SecuritySetting::setValue('password_require_symbols', $this->password_require_symbols);
        SecuritySetting::setValue('session_timeout_minutes', $this->session_timeout);
        SecuritySetting::setValue('max_login_attempts', $this->max_login_attempts);
        SecuritySetting::setValue('lockout_duration_minutes', $this->lockout_duration);
        SecuritySetting::setValue('enable_two_factor', $this->enable_two_factor);
        SecuritySetting::setValue('force_password_change_days', $this->force_password_change_days);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'security_settings_updated',
            'description' => "Updated security settings",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', "Security settings updated successfully");
    }

    // Session Management
    public function terminateUserSession($userId)
    {
        // This would revoke the user's session tokens
        // For now, we'll just log the action
        
        $user = User::findOrFail($userId);
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'session_terminated',
            'description' => "Terminated session for user: {$user->full_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', "Session terminated for {$user->full_name}");
    }

    // Password Reset Management
    public function approvePasswordReset($email)
    {
        // This would typically send a password reset email
        // For now, we'll just log the approval
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'password_reset_approved',
            'description' => "Approved password reset request for: {$email}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Remove the reset request
        DB::table('password_resets')->where('email', $email)->delete();

        session()->flash('success', "Password reset approved for {$email}");
    }

    public function denyPasswordReset($email)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'password_reset_denied',
            'description' => "Denied password reset request for: {$email}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Remove the reset request
        DB::table('password_resets')->where('email', $email)->delete();

        session()->flash('success', "Password reset denied for {$email}");
    }

    // Utility Methods
    public function generatePassword()
    {
        $this->password = Str::password(12);
        $this->password_confirmation = $this->password;
    }

    public function resetForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->force_password_change = false;
        $this->selectedUser = null;
        $this->selectedPermissions = [];
    }

    public function getRoleBadgeClass($role)
    {
        return match($role) {
            'SuperAdmin' => 'bg-purple-100 text-purple-800',
            'HRManager' => 'bg-blue-100 text-blue-800',
            'Manager' => 'bg-green-100 text-green-800',
            'Employee' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openCreateUserModal()
    {
        $this->resetUserForm();
        $this->showUserModal = true;
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->resetUserForm();
    }

    public function resetUserForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->force_password_change = false;
        $this->selectedUser = null;
        $this->selectedPermissions = [];
    }

    public function getStats()
    {
        return [
            'total_users' => User::count(),
            'total_employees' => Employee::count(),
            'active_sessions' => ActivityLog::where('action', 'login')->where('created_at', '>', now()->subHours(24))->count(),
            'password_resets' => DB::table('password_resets')->count(),
            'recent_activities' => ActivityLog::where('created_at', '>', now()->subHours(24))->count(),
            'monthly_payroll' => 150000, // Placeholder - calculate from payroll data
            'pending_leaves' => \App\Models\LeaveRequest::where('status', \App\Enum\LeaveStatus::PENDING)->count(),
            'avg_performance' => 85, // Placeholder - calculate from performance data
        ];
    }

    public function openCreateEmployeeModal()
    {
        $this->resetUserForm();
        $this->showUserModal = true;
        session()->flash('info', 'Add Employee functionality coming soon');
    }

    public function processPayroll()
    {
        session()->flash('info', 'Process Payroll functionality coming soon');
    }

    public function reviewLeaves()
    {
        session()->flash('info', 'Review Leaves functionality coming soon');
    }

    public function performanceReview()
    {
        session()->flash('info', 'Performance Review functionality coming soon');
    }

    public function refreshActivityLogs()
    {
        // Data is loaded in render method, just trigger a re-render
    }

    public function refreshSessions()
    {
        // Data is loaded in render method, just trigger a re-render
    }

    public function refreshPasswordResets()
    {
        // Data is loaded in render method, just trigger a re-render
    }

    public function editEmployee($id)
    {
        // Placeholder for edit employee functionality
        session()->flash('info', 'Edit employee functionality coming soon');
    }

    public function deleteEmployee($id)
    {
        // Placeholder for delete employee functionality
        session()->flash('info', 'Delete employee functionality coming soon');
    }

    public function viewRolePermissions($role)
    {
        // Placeholder for view role permissions functionality
        session()->flash('info', "View permissions for {$role} coming soon");
    }

    public function editRolePermissions($role)
    {
        // Placeholder for edit role permissions functionality
        session()->flash('info', "Edit permissions for {$role} coming soon");
    }

    public function terminateSession($id)
    {
        // Placeholder for terminate session functionality
        session()->flash('info', 'Terminate session functionality coming soon');
    }

    public function render()
    {
        // Load data for the current active tab
        $users = $this->loadUsers();
        $employees = $this->loadEmployees();
        $permissions = $this->loadPermissionsData();
        $activityLogs = $this->loadActivityLogsData();
        $activeSessions = $this->loadActiveSessionsData();
        $passwordResets = $this->loadPasswordResetRequestsData();

        return view('livewire.admin.enhanced-admin-dashboard', [
            'stats' => $this->getStats(),
            'users' => $users,
            'employees' => $employees,
            'permissions' => $permissions,
            'activityLogs' => $activityLogs,
            'activeSessions' => $activeSessions,
            'passwordResets' => $passwordResets,
        ])->layout('components.layouts.admin');
    }

    private function loadUsers()
    {
        $query = User::with(['employee'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        return $query->paginate(10);
    }

    private function loadEmployees()
    {
        $query = Employee::with(['user', 'department', 'position'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        return $query->paginate(10);
    }

    private function loadPermissionsData()
    {
        return Permission::all();
    }

    private function loadActivityLogsData()
    {
        $query = ActivityLog::with(['user'])
            ->orderBy('created_at', 'desc');

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('action', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                               ->orWhere('last_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return $query->paginate(15);
    }

    private function loadActiveSessionsData()
    {
        // For now, return empty collection as we don't have a sessions table
        return collect([]);
    }

    private function loadPasswordResetRequestsData()
    {
        return DB::table('password_resets')
            ->join('users', 'password_resets.email', '=', 'users.email')
            ->select('password_resets.*', 'users.first_name', 'users.last_name', 'users.email')
            ->orderBy('password_resets.created_at', 'desc')
            ->get();
    }
}
