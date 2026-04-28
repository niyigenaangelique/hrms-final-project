<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

#[Title('TalentFlow Pro | Admin — User Management')]
class UserManager extends Component
{
    use WithPagination;

    // ── List filters ────────────────────────────────────────
    public string $search     = '';
    public string $filterRole = '';
    public string $filterType = 'all'; // Default to show everyone as requested
    public int    $perPage    = 15;

    // ── Modal flags ─────────────────────────────────────────
    public bool    $showModal       = false;
    public bool    $showView        = false;
    public bool    $showDelete      = false;
    public bool    $showCredentials = false;
    public ?string $editingId       = null;
    public ?string $deletingId      = null;
    public ?User   $viewRecord      = null;
    public ?User   $credRecord      = null;
    public ?string $targetEmployeeId = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code         = '';
    public string $firstName    = '';
    public string $middleName   = '';
    public string $lastName     = '';
    public string $username     = '';
    public string $email        = '';
    public string $phoneNumber  = '';
    public string $password     = '';
    public string $role         = 'employee';
    public string $plainPassword = '';

    // ── Constants ────────────────────────────────────────────
    // ── Roles are now centralized in User model ─────────────────

    // ── Validation ───────────────────────────────────────────
    protected function rules(): array
    {
        $rules = [
            'code'        => ['required', 'string', 'max:50', Rule::unique('users', 'code')->ignore($this->editingId)],
            'firstName'   => ['required', 'string', 'max:255'],
            'middleName'  => ['nullable', 'string', 'max:255'],
            'lastName'    => ['required', 'string', 'max:255'],
            'username'    => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->editingId)],
            'email'       => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->editingId)],
            'phoneNumber' => ['nullable', 'string', 'max:255'],
            'role'        => ['required', Rule::in(array_keys(User::ROLES))],
        ];

        if (!$this->editingId) {
            $rules['password'] = ['required', 'string', 'min:6'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:6'];
        }

        return $rules;
    }

    // ── Lifecycle ────────────────────────────────────────────
    public function mount(): void 
    {
        $this->filterType = request()->get('filterType', 'all');
        if (!in_array($this->filterType, ['users', 'employees', 'all'])) {
            $this->filterType = 'all';
        }
    }

    public function updatedSearch(): void     { $this->resetPage(); }
    public function updatedFilterRole(): void { $this->resetPage(); }
    public function updatedFilterType(): void { $this->resetPage(); }
    
    public function resetToEmployees(): void
    {
        $this->filterType = 'all';
        $this->resetPage();
    }

    private function generateCode(): string
    {
        $last = User::orderBy('created_at', 'desc')->first();
        $n    = $last ? ((int) preg_replace('/\D/', '', $last->code ?? '0')) + 1 : 1;
        return 'USR-' . str_pad($n, 5, '0', STR_PAD_LEFT);
    }

    public function updatedFirstName(): void  { $this->suggestUsername(); }
    public function updatedLastName(): void   { $this->suggestUsername(); }

    private function suggestUsername(): void
    {
        if (!$this->editingId && $this->firstName && $this->lastName) {
            $base = strtolower($this->firstName . '.' . $this->lastName);
            $this->username = preg_replace('/[^a-z0-9.]/', '', $base);
        }
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->code = $this->generateCode();
        $this->showModal = true;
    }

    public function openCreateCredentials(string $employeeId): void
    {
        $this->resetForm();
        $employee = Employee::findOrFail($employeeId);
        $this->firstName = $employee->first_name;
        $this->lastName = $employee->last_name;
        $this->email = $employee->email;
        $this->phoneNumber = $employee->phone_number;
        $this->role        = 'employee';
        $this->targetEmployeeId = $employeeId;
        $this->code        = $this->generateCode();
        $this->showModal   = true;
    }

    public function openEdit(string $id): void
    {
        $u = User::findOrFail($id);
        $this->editingId   = $id;
        $this->code        = $u->code        ?? '';
        $this->firstName   = $u->first_name  ?? '';
        $this->middleName  = $u->middle_name ?? '';
        $this->lastName    = $u->last_name   ?? '';
        $this->username    = $u->username    ?? '';
        $this->email       = $u->email       ?? '';
        $this->phoneNumber = $u->phone_number ?? '';
        $this->role        = $u->role        ?? 'employee';
        $this->password    = '';
        $this->showModal   = true;
    }

    public function openView(string $id): void
    {
        $this->viewRecord = User::findOrFail($id);
        $this->showView   = true;
    }

    public function closeView(): void { $this->showView = false; $this->viewRecord = null; }
    public function closeModal(): void { $this->showModal = false; $this->resetForm(); }

    public function viewCredentials(string $id): void
    {
        $this->credRecord = User::findOrFail($id);
        $this->showCredentials = true;
    }

    public function closeCredentials(): void { $this->showCredentials = false; $this->credRecord = null; $this->plainPassword = ''; }

    public function confirmDelete(string $id): void { $this->deletingId = $id; $this->showDelete = true; }
    public function cancelDelete(): void { $this->deletingId = null; $this->showDelete = false; }

    public function deleteRecord(): void
    {
        if (!$this->deletingId) { $this->cancelDelete(); return; }
        try {
            User::findOrFail($this->deletingId)->delete();
            $this->cancelDelete();
            session()->flash('success', 'User account deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    public function toggleStatus(string $id): void
    {
        try {
            $user = User::findOrFail($id);
            $user->is_active = !$user->is_active;
            $user->save();
            
            $status = $user->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "User account {$status} successfully.");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to change status: ' . $e->getMessage());
        }
    }

    public function assignRole(string $id, string $newRole): void
    {
        try {
            if (!array_key_exists($newRole, User::ROLES)) {
                throw new \Exception('Invalid role selected.');
            }
            
            $user = User::findOrFail($id);
            $user->role = $newRole;
            $user->save();
            
            session()->flash('success', "Role for {$user->name} updated to " . User::ROLES[$newRole]);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    public function resetPassword(string $id): void
    {
        try {
            $newPw = Str::random(10);
            User::findOrFail($id)->update(['password' => Hash::make($newPw)]);
            $this->plainPassword   = $newPw;
            $this->credRecord      = User::findOrFail($id);
            $this->showCredentials = true;
            session()->flash('success', 'Password reset successful.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function save(): void
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            session()->flash('error', $errors[array_key_first($errors)][0] ?? 'Validation failed.');
            return;
        }

        DB::beginTransaction();
        try {
            $data = [
                'code'         => strtoupper(trim($this->code)),
                'first_name'   => trim($this->firstName),
                'middle_name'  => trim($this->middleName) ?: null,
                'last_name'    => trim($this->lastName),
                'username'     => trim($this->username),
                'email'        => strtolower(trim($this->email)),
                'phone_number' => trim($this->phoneNumber) ?: null,
                'role'         => $this->role,
            ];

            if ($this->password !== '') {
                $data['password'] = Hash::make($this->password);
            }

            if ($this->editingId) {
                User::findOrFail($this->editingId)->update($data);
                $msg = 'User account updated successfully.';
            } else {
                $existingUser = User::where('email', $this->email)->first();
                if ($existingUser) {
                    $employee = Employee::where('email', $this->email)->first();
                    if ($employee && !$employee->user_id) {
                        $employee->update(['user_id' => $existingUser->id]);
                        $msg = 'Existing account linked to employee successfully.';
                    } else {
                        throw new \Exception('A user with this email already exists.');
                    }
                } else {
                    $user = User::create($data);
                    
                    // Case 1: Manual linkage via targetEmployeeId (Recommended)
                    if ($this->targetEmployeeId) {
                        $employee = Employee::find($this->targetEmployeeId);
                        if ($employee) {
                            $employee->update(['user_id' => $user->id]);
                            // Update the reverse link if column exists
                            $user->update(['employee_id' => $employee->id]);
                            $msg = 'Credentials created and linked to ' . $employee->full_name . '.';
                        } else {
                            $msg = 'User created but target employee not found.';
                        }
                    }
                    // Case 2: Fallback to email matching
                    else {
                        $employee = Employee::where('email', $this->email)->first();
                        if ($employee && !$employee->user_id) {
                            $employee->update(['user_id' => $user->id]);
                            $user->update(['employee_id' => $employee->id]);
                            $msg = 'Credentials created and linked to ' . $employee->full_name . '.';
                        } else {
                            $msg = 'System user account created successfully.';
                        }
                    }
                }
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    private function resetForm(): void
    {
        $this->editingId = $this->code = $this->firstName = $this->middleName = $this->lastName = '';
        $this->username = $this->email = $this->phoneNumber = $this->password = '';
        $this->role = 'employee';
        $this->targetEmployeeId = null;
        $this->resetValidation();
    }

    public function render()
    {
        if ($this->filterType === 'employees') {
            $records = Employee::whereNull('user_id')
                ->when($this->search, fn($q) => $q->where(fn($q2) => 
                    $q2->where('first_name','like',"%{$this->search}%")->orWhere('last_name','like',"%{$this->search}%")
                ))
                ->orderBy('first_name')->paginate($this->perPage);
        } elseif ($this->filterType === 'users') {
            $records = User::whereDoesntHave('employee')
                ->when($this->search, fn($q) => $q->where('first_name', 'like', "%{$this->search}%"))
                ->orderBy('first_name')->paginate($this->perPage);
        } else {
            $records = Employee::with('user')
                ->when($this->search, fn($q) => $q->where(fn($q2) => 
                    $q2->where('first_name','like',"%{$this->search}%")->orWhere('last_name','like',"%{$this->search}%")
                ))
                ->orderBy('first_name')->paginate($this->perPage);
        }

        return view('livewire.admin.user-management', [
            'records'     => $records,
            'totalCount'  => Employee::count() + User::whereDoesntHave('employee')->count(),
            'adminCount'  => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'hrCount'     => User::where('role', 'hr_manager')->count(),
            'empCount'    => Employee::count(),
            'roles'       => User::ROLES,
        ])->layout('components.layouts.admin');
    }
}