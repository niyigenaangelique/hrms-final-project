<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\RolePermission;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

#[Title('TalentFlow Pro | Admin Dashboard')]
class AdminDashboard extends Component
{
    use WithPagination;

    public $users;
    public $search = '';
    public $roleFilter = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $selectedUser;

    // User form fields
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $role;
    public $password;
    public $password_confirmation;

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
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $query = User::with(['employee', 'role'])
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

        $this->users = $query->paginate(10);
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadUsers();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
        $this->loadUsers();
    }

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
        ]);

        // Create corresponding employee record if not Employee role
        if ($this->role !== 'Employee') {
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
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => Auth::id(),
            ]);
        }

        $this->resetForm();
        $this->showCreateModal = false;
        $this->loadUsers();

        session()->flash('success', "User {$user->full_name} created successfully with credentials: Email: {$user->email}, Password: {$this->password}");
    }

    public function editUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->first_name = $this->selectedUser->first_name;
        $this->last_name = $this->selectedUser->last_name;
        $this->email = $this->selectedUser->email;
        $this->phone_number = $this->selectedUser->phone_number;
        $this->role = $this->selectedUser->role;
        $this->showEditModal = true;
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

        $this->selectedUser->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
        ]);

        // Update corresponding employee record if exists
        if ($this->selectedUser->employee) {
            $this->selectedUser->employee->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'updated_by' => Auth::id(),
            ]);
        }

        $this->resetForm();
        $this->showEditModal = false;
        $this->loadUsers();

        session()->flash('success', "User {$this->selectedUser->full_name} updated successfully");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent deletion of admin account
        if ($user->email === 'angelbrenna20@gmail.com') {
            session()->flash('error', 'Cannot delete the main admin account');
            return;
        }

        $userName = $user->full_name;
        $user->delete();
        $this->loadUsers();

        session()->flash('success', "User {$userName} deleted successfully");
    }

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
        $this->selectedUser = null;
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

    public function render()
    {
        return view('livewire.admin.admin-dashboard')
            ->layout('components.layouts.app');
    }
}
