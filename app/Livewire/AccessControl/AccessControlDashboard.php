<?php

namespace App\Livewire\AccessControl;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\SecuritySetting;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('ZIBITECH | C-HRMS | Access Control & Logs')]
class AccessControlDashboard extends Component
{
    use WithPagination;

    public $activeTab = 'dashboard';
    public $searchTerm = '';
    public $filterModule = 'all';
    public $filterAction = 'all';
    public $filterDateRange = '7days';
    public $startDate;
    public $endDate;
    public $selectedUser;
    public $showUserManagement = false;
    public $showRoleManagement = false;
    public $showPermissionMatrix = false;
    public $showSecuritySettings = false;

    // User Management Properties
    public $userName;
    public $userEmail;
    public $userRole;
    public $userPassword;
    public $userIsActive = true;

    // Role Management Properties
    public $roleName;
    public $roleDescription;
    public $roleUserRole;
    public $selectedRole;
    public $rolePermissions = [];

    protected $rules = [
        'userName' => 'required|string|max:255',
        'userEmail' => 'required|email|max:255|unique:users,email',
        'userRole' => 'required|string|max:100',
        'userPassword' => 'required|string|min:8',
        'roleName' => 'required|string|max:255',
        'roleDescription' => 'nullable|string|max:1000',
        'roleUserRole' => 'required|string|max:100',
    ];

    public function mount()
    {
        $this->setDateRange();
    }

    public function setDateRange()
    {
        switch ($this->filterDateRange) {
            case 'today':
                $this->startDate = now()->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            case '7days':
                $this->startDate = now()->subDays(7)->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            case '30days':
                $this->startDate = now()->subDays(30)->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            case '90days':
                $this->startDate = now()->subDays(90)->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            default:
                $this->startDate = now()->subDays(7)->startOfDay();
                $this->endDate = now()->endOfDay();
        }
    }

    public function updatedFilterDateRange()
    {
        $this->setDateRange();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getActivityLogs()
    {
        $query = ActivityLog::with('user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc');

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('action', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('module', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->searchTerm . '%')
                               ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }

        if ($this->filterModule !== 'all') {
            $query->where('module', $this->filterModule);
        }

        if ($this->filterAction !== 'all') {
            $query->where('action', $this->filterAction);
        }

        return $query->paginate(50);
    }

    public function getSecurityStats()
    {
        $totalUsers = User::count();
        $activeUsers = User::whereNull('deleted_at')->count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $failedLogins = ActivityLog::where('action', 'failed_login')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
        $successfulLogins = ActivityLog::where('action', 'login')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'total_roles' => $totalRoles,
            'total_permissions' => $totalPermissions,
            'failed_logins' => $failedLogins,
            'successful_logins' => $successfulLogins,
            'login_success_rate' => ($failedLogins + $successfulLogins) > 0 
                ? round(($successfulLogins / ($failedLogins + $successfulLogins)) * 100, 2) 
                : 0,
        ];
    }

    public function getRecentActivities()
    {
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    public function getTopModules()
    {
        return ActivityLog::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('module, COUNT(*) as count')
            ->groupBy('module')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();
    }

    public function getTopActions()
    {
        return ActivityLog::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();
    }

    public function getRoles()
    {
        return Role::withCount('users')
            ->where('is_active', true)
            ->get();
    }

    public function getPermissions()
    {
        return Permission::where('is_active', true)
            ->orderBy('module')
            ->orderBy('resource')
            ->get();
    }

    public function getUsers()
    {
        return User::with('role')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function getSecuritySettings()
    {
        return SecuritySetting::where('is_active', true)
            ->orderBy('key')
            ->get();
    }

    // User Management Methods
    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->userName,
            'email' => $this->userEmail,
            'password' => bcrypt($this->userPassword),
            'user_role' => $this->userRole,
            'is_active' => $this->userIsActive,
            'created_by' => auth()->id(),
        ]);

        ActivityLog::logCreate(auth()->id(), 'user_management', "Created user: {$user->name}", [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->user_role,
        ]);

        $this->dispatch('showNotification', 'User created successfully', 'success');
        $this->resetUserForm();
        $this->showUserManagement = false;
    }

    public function editUser($userId)
    {
        $this->selectedUser = User::find($userId);
        if ($this->selectedUser) {
            $this->userName = $this->selectedUser->name;
            $this->userEmail = $this->selectedUser->email;
            $this->userRole = $this->selectedUser->user_role;
            $this->userIsActive = $this->selectedUser->is_active;
            $this->showUserManagement = true;
        }
    }

    public function updateUser()
    {
        $this->validate([
            'userName' => 'required|string|max:255',
            'userEmail' => 'required|email|max:255|unique:users,email,' . $this->selectedUser->id,
            'userRole' => 'required|string|max:100',
        ]);

        if ($this->selectedUser) {
            $oldValues = [
                'name' => $this->selectedUser->name,
                'email' => $this->selectedUser->email,
                'role' => $this->selectedUser->user_role,
                'is_active' => $this->selectedUser->is_active,
            ];

            $this->selectedUser->update([
                'name' => $this->userName,
                'email' => $this->userEmail,
                'user_role' => $this->userRole,
                'is_active' => $this->userIsActive,
                'updated_by' => auth()->id(),
            ]);

            $newValues = [
                'name' => $this->selectedUser->name,
                'email' => $this->selectedUser->email,
                'role' => $this->selectedUser->user_role,
                'is_active' => $this->selectedUser->is_active,
            ];

            ActivityLog::logUpdate(auth()->id(), 'user_management', "Updated user: {$this->selectedUser->name}", $oldValues, $newValues);

            $this->dispatch('showNotification', 'User updated successfully', 'success');
            $this->resetUserForm();
            $this->showUserManagement = false;
        }
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            ActivityLog::logDelete(auth()->id(), 'user_management', "Deleted user: {$user->name}", [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->user_role,
            ]);

            $user->delete();
            $this->dispatch('showNotification', 'User deleted successfully', 'success');
        }
    }

    // Role Management Methods
    public function createRole()
    {
        $this->validate();

        $role = Role::create([
            'code' => 'ROLE-' . uniqid(),
            'name' => $this->roleName,
            'description' => $this->roleDescription,
            'user_role' => $this->roleUserRole,
            'is_active' => true,
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);

        ActivityLog::logCreate(auth()->id(), 'role_management', "Created role: {$role->name}", [
            'name' => $role->name,
            'description' => $role->description,
            'user_role' => $role->user_role,
        ]);

        $this->dispatch('showNotification', 'Role created successfully', 'success');
        $this->resetRoleForm();
        $this->showRoleManagement = false;
    }

    public function editRole($roleId)
    {
        $this->selectedRole = Role::find($roleId);
        if ($this->selectedRole) {
            $this->roleName = $this->selectedRole->name;
            $this->roleDescription = $this->selectedRole->description;
            $this->roleUserRole = $this->selectedRole->user_role;
            $this->rolePermissions = $this->selectedRole->permissions->pluck('permission_id')->toArray();
            $this->showRoleManagement = true;
        }
    }

    public function updateRole()
    {
        $this->validate([
            'roleName' => 'required|string|max:255',
            'roleUserRole' => 'required|string|max:100',
        ]);

        if ($this->selectedRole) {
            $oldValues = [
                'name' => $this->selectedRole->name,
                'description' => $this->selectedRole->description,
                'user_role' => $this->selectedRole->user_role,
            ];

            $this->selectedRole->update([
                'name' => $this->roleName,
                'description' => $this->roleDescription,
                'user_role' => $this->roleUserRole,
                'updated_by' => auth()->id(),
            ]);

            $newValues = [
                'name' => $this->selectedRole->name,
                'description' => $this->selectedRole->description,
                'user_role' => $this->selectedRole->user_role,
            ];

            ActivityLog::logUpdate(auth()->id(), 'role_management', "Updated role: {$this->selectedRole->name}", $oldValues, $newValues);

            $this->dispatch('showNotification', 'Role updated successfully', 'success');
            $this->resetRoleForm();
            $this->showRoleManagement = false;
        }
    }

    public function deleteRole($roleId)
    {
        $role = Role::find($roleId);
        if ($role) {
            ActivityLog::logDelete(auth()->id(), 'role_management', "Deleted role: {$role->name}", [
                'name' => $role->name,
                'description' => $role->description,
                'user_role' => $role->user_role,
            ]);

            $role->delete();
            $this->dispatch('showNotification', 'Role deleted successfully', 'success');
        }
    }

    private function resetUserForm()
    {
        $this->userName = '';
        $this->userEmail = '';
        $this->userRole = '';
        $this->userPassword = '';
        $this->userIsActive = true;
        $this->selectedUser = null;
    }

    private function resetRoleForm()
    {
        $this->roleName = '';
        $this->roleDescription = '';
        $this->roleUserRole = '';
        $this->rolePermissions = [];
        $this->selectedRole = null;
    }

    public function render()
    {
        return view('livewire.access-control.access-control-dashboard', [
            'activityLogs' => $this->getActivityLogs(),
            'securityStats' => $this->getSecurityStats(),
            'recentActivities' => $this->getRecentActivities(),
            'topModules' => $this->getTopModules(),
            'topActions' => $this->getTopActions(),
            'roles' => $this->getRoles(),
            'permissions' => $this->getPermissions(),
            'users' => $this->getUsers(),
            'securitySettings' => $this->getSecuritySettings(),
        ]);
    }
}
