<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class UserManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    // User Form
    public $showEditUserModal = false;
    public $showDeleteUserModal = false;
    public $showCreateFromEmployeeModal = false;
    public $selectedUserId;
    public $selectedUser;

    // Form Fields
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $username;
    public $role;
    public $password;
    public $password_confirmation;
    public $force_password_change = false;

    // Employee Selection
    public $selectedEmployeeId;
    public $selectedEmployee;
    public $employeesWithoutUsers;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone_number' => 'required|string|max:20',
        'role' => 'required|in:SuperAdmin,HRManager,OperationsManager,Employee',
        'password' => 'required|string|min:8|confirmed',
    ];

    protected $messages = [
        'password.confirmed' => 'The password confirmation does not match.',
        'email.unique' => 'This email address is already registered.',
    ];

    public function mount()
    {
        // Initialize with empty values
    }

    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => $this->loadUsers(),
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
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        return $query->paginate(10);
    }

    public function openEditUserModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedUser = User::findOrFail($userId);
        $this->fill([
            'first_name' => $this->selectedUser->first_name,
            'last_name' => $this->selectedUser->last_name,
            'email' => $this->selectedUser->email,
            'phone_number' => $this->selectedUser->phone_number,
            'username' => $this->selectedUser->username,
            'role' => $this->selectedUser->role,
        ]);
        $this->showEditUserModal = true;
    }

    public function closeEditUserModal()
    {
        $this->showEditUserModal = false;
        $this->resetUserForm();
    }

    public function openDeleteUserModal($id)
    {
        $this->selectedUserId = $id;
        $this->selectedUser = User::findOrFail($id);
        $this->showDeleteUserModal = true;
    }

    public function closeDeleteUserModal()
    {
        $this->showDeleteUserModal = false;
        $this->selectedUserId = null;
        $this->selectedUser = null;
    }

    public function openCreateFromEmployeeModal()
    {
        $this->loadEmployeesWithoutUsers();
        $this->resetEmployeeForm();
        $this->showCreateFromEmployeeModal = true;
    }

    public function closeCreateFromEmployeeModal()
    {
        $this->showCreateFromEmployeeModal = false;
        $this->resetEmployeeForm();
    }

    public function loadEmployeesWithoutUsers()
    {
        $this->employeesWithoutUsers = \App\Models\Employee::whereDoesntHave('user')
            ->select('id', 'first_name', 'last_name', 'email', 'phone_number', 'department', 'position')
            ->orderBy('first_name')
            ->get();
    }

    public function updatedSelectedEmployeeId($employeeId)
    {
        if ($employeeId) {
            $this->selectedEmployee = \App\Models\Employee::find($employeeId);
            if ($this->selectedEmployee) {
                $this->first_name = $this->selectedEmployee->first_name;
                $this->last_name = $this->selectedEmployee->last_name;
                $this->email = $this->selectedEmployee->email;
                $this->phone_number = $this->selectedEmployee->phone_number;
                $this->role = 'Employee'; // Default role for employee-created users
            }
        } else {
            $this->resetEmployeeForm();
        }
    }

    public function createUserFromEmployee()
    {
        $this->validate([
            'selectedEmployeeId' => 'required|exists:employees,id',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:SuperAdmin,HRManager,Manager,Employee',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'code' => 'USR-' . str_pad(User::count() + 1, 5, '0', STR_PAD_LEFT),
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'password_changed_at' => now(),
            ]);

            // Link employee to user if needed
            if ($this->selectedEmployee) {
                // You might want to add a user_id field to employees table
                // For now, we'll just log the activity
            }

            session()->flash('success', "User account created successfully for {$user->first_name} {$user->last_name}!");
            $this->closeCreateFromEmployeeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function resetEmployeeForm()
    {
        $this->selectedEmployeeId = null;
        $this->selectedEmployee = null;
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->role = 'Employee';
        $this->password = '';
        $this->password_confirmation = '';
        $this->force_password_change = false;
    }

    public function resetUserForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->username = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->force_password_change = false;
        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->showCreateUserModal = false;
        $this->showEditUserModal = false;
        $this->showDeleteUserModal = false;
    }

    public function quickCreateUser($employeeId)
    {
        try {
            $employee = \App\Models\Employee::findOrFail($employeeId);
            
            // Debug: Show employee details
            session()->flash('info', 'Employee: ' . $employee->first_name . ' ' . $employee->last_name . ' | Email: ' . $employee->email);
            
            // Check if user already exists
            $existingUser = User::where('email', $employee->email)->first();
            if ($existingUser) {
                session()->flash('error', 'User account already exists for this employee! Email: ' . $employee->email . ' | User ID: ' . $existingUser->id . ' | Username: ' . $existingUser->username);
                return;
            }
            
            session()->flash('info', 'No existing user found for email: ' . $employee->email . ' - Proceeding with account creation...');
            
            // Generate unique code and username
            $code = 'USR-' . str_pad(User::count() + 1, 5, '0', STR_PAD_LEFT);
            $username = strtolower($employee->first_name) . '.' . strtolower($employee->last_name);
            
            // Ensure username is unique
            $originalUsername = $username;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }
            
            // Generate default password
            $defaultPassword = 'password123';
            
            $user = User::create([
                'code' => $code,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'username' => $username,
                'email' => $employee->email,
                'phone_number' => $employee->phone_number,
                'password' => Hash::make($defaultPassword),
                'role' => 'Employee',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'password_changed_at' => now(),
            ]);
            
            // Link employee to user
            $employee->update(['user_id' => $user->id]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'user_created_quick',
                'description' => "Quick created user account for {$employee->first_name} {$employee->last_name} ({$user->code})",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            session()->flash('success', "✅ User account created successfully! 
                Code: {$user->code}, 
                Username: {$user->username}, 
                Password: {$defaultPassword}
                (Employee should change password on first login)");
            
        } catch (\Exception $e) {
            session()->flash('error', '❌ Failed to create user account: ' . $e->getMessage());
        }
    }

    public function updateUser()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->selectedUserId)],
            'phone_number' => 'required|string|max:20',
            'role' => 'required|in:SuperAdmin,HRManager,OperationsManager,Employee',
        ]);

        $user = User::findOrFail($this->selectedUserId);
        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'username' => $this->username,
            'role' => $this->role,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_updated',
            'description' => "Updated user: {$user->first_name} {$user->last_name} ({$user->code})",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->closeEditUserModal();
        session()->flash('success', "User updated successfully!");
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->selectedUserId);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_deleted',
            'description' => "Deleted user: {$user->first_name} {$user->last_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $user->delete();

        $this->closeDeleteUserModal();
        session()->flash('success', 'User deleted successfully!');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }
}
