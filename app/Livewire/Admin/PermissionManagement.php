<?php

namespace App\Livewire\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public $search = '';
    public $roleFilter = '';
    public $permissionFilter = '';

    // Permission Form
    public $showCreatePermissionModal = false;
    public $showEditPermissionModal = false;
    public $showDeletePermissionModal = false;
    public $selectedPermissionId;
    public $selectedPermission;

    // Form Fields
    public $name;
    public $description;
    public $guard_name;
    public $selectedRoles = [];
    
    // Employee Role Assignment
    public $showEmployeeRoleModal = false;
    public $employees;
    public $selectedEmployeeId;
    public $selectedEmployee;
    public $selectedEmployeeRoles = [];
    public $employeeRoles = ['SuperAdmin', 'HRManager', 'OperationsManager', 'Employee'];
    public $forcePasswordChange = false;

    public function testClick()
    {
        session()->flash('test_message', 'Permission Management Livewire test successful! Method called at: ' . now()->format('H:i:s'));
    }

    public function testModalClick()
    {
        session()->flash('test_message', 'Modal button test successful! Selected Employee: ' . ($this->selectedEmployee ? $this->selectedEmployee->first_name : 'None') . ' | Selected Role: ' . json_encode($this->selectedEmployeeRoles));
    }

    public function testAssignRoleClick()
    {
        session()->flash('test_message', 'Test Assign Role button clicked! Employee ID: ' . $this->selectedEmployeeId . ' | Selected Roles: ' . json_encode($this->selectedEmployeeRoles) . ' | Time: ' . now()->format('H:i:s'));
    }

    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name',
        'description' => 'nullable|string',
        'guard_name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadEmployees();
        // Initialize with empty values
    }

    public function render()
    {
        $permissions = $this->loadPermissions();
        $roles = Role::all();
        $employees = \App\Models\Employee::all()->sortBy('first_name');

        return view('livewire.admin.permission-management', [
            'permissions' => $permissions,
            'roles' => $roles,
            'employees' => $employees,
        ])->layout('components.layouts.admin');
    }

    private function loadPermissions()
    {
        $query = Permission::query()->orderBy('name');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->permissionFilter) {
            $query->where('name', 'like', '%' . $this->permissionFilter . '%');
        }

        return $query->paginate(15);
    }

    public function openCreatePermissionModal()
    {
        $this->resetPermissionForm();
        $this->showCreatePermissionModal = true;
    }

    public function closeCreatePermissionModal()
    {
        $this->showCreatePermissionModal = false;
        $this->resetPermissionForm();
    }

    public function openEditPermissionModal($id)
    {
        $this->selectedPermission = Permission::findOrFail($id);
        $this->selectedPermissionId = $id;
        
        $this->name = $this->selectedPermission->name;
        $this->description = $this->selectedPermission->description;
        $this->guard_name = $this->selectedPermission->guard_name;
        
        // Load existing role permissions
        $this->selectedRoles = $this->selectedPermission->roles()->pluck('id')->toArray();
        
        $this->showEditPermissionModal = true;
    }

    public function closeEditPermissionModal()
    {
        $this->showEditPermissionModal = false;
        $this->resetPermissionForm();
    }

    public function openDeletePermissionModal($id)
    {
        $this->selectedPermissionId = $id;
        $this->selectedPermission = Permission::findOrFail($id);
        $this->showDeletePermissionModal = true;
    }

    public function closeDeletePermissionModal()
    {
        $this->showDeletePermissionModal = false;
        $this->selectedPermissionId = null;
        $this->selectedPermission = null;
    }

    public function resetPermissionForm()
    {
        $this->name = '';
        $this->description = '';
        $this->guard_name = 'web';
        $this->selectedRoles = [];
        $this->selectedPermissionId = null;
        $this->selectedPermission = null;
        $this->showCreatePermissionModal = false;
        $this->showEditPermissionModal = false;
        $this->showDeletePermissionModal = false;
    }

    public function createPermission()
    {
        $this->validate();

        $permission = Permission::create([
            'name' => $this->name,
            'description' => $this->description,
            'guard_name' => $this->guard_name,
            'created_by' => auth()->id(),
        ]);

        // Assign to selected roles
        if (!empty($this->selectedRoles)) {
            $permission->roles()->sync($this->selectedRoles);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'permission_created',
            'description' => "Created permission: {$permission->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->closeCreatePermissionModal();
        session()->flash('success', 'Permission created successfully!');
    }

    public function updatePermission()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions,name,'.$this->selectedPermissionId,
            'description' => 'nullable|string',
            'guard_name' => 'required|string|max:255',
        ]);

        $this->selectedPermission->update([
            'name' => $this->name,
            'description' => $this->description,
            'guard_name' => $this->guard_name,
            'updated_by' => auth()->id(),
        ]);

        // Update role assignments
        $this->selectedPermission->roles()->sync($this->selectedRoles);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'permission_updated',
            'description' => "Updated permission: {$this->selectedPermission->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->closeEditPermissionModal();
        session()->flash('success', 'Permission updated successfully!');
    }

    public function deletePermission()
    {
        $permission = Permission::findOrFail($this->selectedPermissionId);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'permission_deleted',
            'description' => "Deleted permission: {$permission->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $permission->delete();

        $this->closeDeletePermissionModal();
        session()->flash('success', 'Permission deleted successfully!');
    }

    // Employee Role Assignment Methods
    public function openEmployeeRoleModal()
    {
        $this->loadEmployees();
        $this->resetEmployeeRoleForm();
        $this->showEmployeeRoleModal = true;
    }

    public function openEditEmployeeRoleModal($employeeId)
    {
        $this->loadEmployees();
        $this->selectedEmployeeId = $employeeId;
        $this->selectedEmployee = \App\Models\Employee::with('user')->find($employeeId);
        
        if ($this->selectedEmployee && $this->selectedEmployee->user) {
            // Get current user role
            if ($this->selectedEmployee->user->role) {
                $this->selectedEmployeeRoles = [$this->selectedEmployee->user->role];
            }
        }
        
        $this->showEmployeeRoleModal = true;
    }

    public function closeEmployeeRoleModal()
    {
        $this->showEmployeeRoleModal = false;
        $this->resetEmployeeRoleForm();
    }

    public function loadEmployees()
    {
        $this->employees = \App\Models\Employee::all()->sortBy('first_name');
    }

    public function updatedSelectedEmployeeId($employeeId)
    {
        if ($employeeId) {
            $this->selectedEmployee = \App\Models\Employee::with('user')->find($employeeId);
            if ($this->selectedEmployee && $this->selectedEmployee->user) {
                $this->selectedEmployeeId = $employeeId;
                // Get current user roles
                $currentRoles = [];
                if ($this->selectedEmployee->user->role) {
                    $currentRoles[] = $this->selectedEmployee->user->role;
                }
                $this->selectedEmployeeRoles = $currentRoles;
            }
        } else {
            $this->resetEmployeeRoleForm();
        }
    }

    public function assignEmployeeRole()
    {
        try {
            // Simple validation
            if (!$this->selectedEmployeeId) {
                session()->flash('error', 'Please select an employee');
                return;
            }

            if (empty($this->selectedEmployeeRoles)) {
                session()->flash('error', 'Please select a role');
                return;
            }

            $selectedRole = $this->selectedEmployeeRoles[0];
            
            session()->flash('info', 'Processing: Employee ID: ' . $this->selectedEmployeeId . ' | Role: ' . $selectedRole);

            $employee = \App\Models\Employee::findOrFail($this->selectedEmployeeId);
            $user = $employee->user;
            
            if (!$user) {
                // Create user account
                $user = User::create([
                    'code' => 'USR-' . str_pad(User::count() + 1, 5, '0', STR_PAD_LEFT),
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'username' => strtolower($employee->first_name) . '.' . strtolower($employee->last_name),
                    'email' => $employee->email,
                    'phone_number' => $employee->phone_number,
                    'password' => Hash::make('password123'),
                    'role' => $selectedRole,
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                    'password_changed_at' => now(),
                ]);
                
                $employee->update(['user_id' => $user->id]);
                session()->flash('success', 'User account created and role assigned successfully!');
            } else {
                // Update existing user role
                $user->update(['role' => $selectedRole]);
                session()->flash('success', 'Role updated successfully!');
            }

            $this->closeEmployeeRoleModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    public function resetEmployeeRoleForm()
    {
        $this->selectedEmployeeId = null;
        $this->selectedEmployee = null;
        $this->selectedEmployeeRoles = [];
        $this->forcePasswordChange = false;
    }
}
