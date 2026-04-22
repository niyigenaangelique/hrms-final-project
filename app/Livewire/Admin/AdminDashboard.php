<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Admin Console')]
class AdminDashboard extends Component
{
    use WithPagination;

    // ── Active tab ───────────────────────────────────────────
    public string $activeTab = 'users';

    // ══ USER MANAGEMENT ══════════════════════════════════════
    public string $search      = '';
    public string $filterRole  = '';
    public int    $perPage     = 10;

    public bool    $showModal       = false;
    public bool    $showView        = false;
    public bool    $showDelete      = false;
    public bool    $showCredentials = false;
    public ?string $editingId       = null;
    public ?string $deletingId      = null;
    public ?User   $viewRecord      = null;
    public ?User   $credRecord      = null;
    public string  $plainPassword   = '';

    // User form fields
    public string $code        = '';
    public string $firstName   = '';
    public string $middleName  = '';
    public string $lastName    = '';
    public string $username    = '';
    public string $email       = '';
    public string $phoneNumber = '';
    public string $password    = '';
    public string $role        = 'employee';

    // ══ PERMISSIONS MATRIX ═══════════════════════════════════
    // permissions[role][permission] = bool
    public array $permissions = [];

    const ALL_PERMISSIONS = [
        'payroll' => [
            'payroll.view'    => 'View Payroll',
            'payroll.create'  => 'Create Payroll',
            'payroll.edit'    => 'Edit Payroll',
            'payroll.delete'  => 'Delete Payroll',
            'payroll.approve' => 'Approve Payroll',
        ],
        'employees' => [
            'employees.view'   => 'View Employees',
            'employees.create' => 'Create Employees',
            'employees.edit'   => 'Edit Employees',
            'employees.delete' => 'Delete Employees',
        ],
        'reports' => [
            'reports.view'   => 'View Reports',
            'reports.export' => 'Export Reports',
        ],
        'admin' => [
            'admin.users'       => 'Manage Users',
            'admin.roles'       => 'Manage Roles',
            'admin.settings'    => 'System Settings',
            'admin.audit'       => 'View Audit Log',
        ],
    ];

    const DEFAULT_PERMISSIONS = [
        'admin' => [
            'payroll.view'=>true,'payroll.create'=>true,'payroll.edit'=>true,'payroll.delete'=>true,'payroll.approve'=>true,
            'employees.view'=>true,'employees.create'=>true,'employees.edit'=>true,'employees.delete'=>true,
            'reports.view'=>true,'reports.export'=>true,
            'admin.users'=>true,'admin.roles'=>true,'admin.settings'=>true,'admin.audit'=>true,
        ],
        'hr_manager' => [
            'payroll.view'=>true,'payroll.create'=>true,'payroll.edit'=>true,'payroll.delete'=>false,'payroll.approve'=>true,
            'employees.view'=>true,'employees.create'=>true,'employees.edit'=>true,'employees.delete'=>false,
            'reports.view'=>true,'reports.export'=>true,
            'admin.users'=>false,'admin.roles'=>false,'admin.settings'=>false,'admin.audit'=>false,
        ],
        'employee' => [
            'payroll.view'=>true,'payroll.create'=>false,'payroll.edit'=>false,'payroll.delete'=>false,'payroll.approve'=>false,
            'employees.view'=>false,'employees.create'=>false,'employees.edit'=>false,'employees.delete'=>false,
            'reports.view'=>false,'reports.export'=>false,
            'admin.users'=>false,'admin.roles'=>false,'admin.settings'=>false,'admin.audit'=>false,
        ],
    ];

    // ══ SECURITY SETTINGS ════════════════════════════════════
    public bool   $twoFactorEnabled      = false;
    public bool   $sessionTimeoutEnabled = true;
    public int    $sessionTimeoutMinutes = 60;
    public bool   $passwordExpiry        = false;
    public int    $passwordExpiryDays    = 90;
    public bool   $loginAuditEnabled     = true;
    public int    $maxLoginAttempts      = 5;
    public bool   $ipWhitelistEnabled    = false;
    public string $ipWhitelist           = '';

    // ══ PASSWORD RESET ════════════════════════════════════════
    public string  $resetSearch     = '';
    public ?string $resetUserId     = null;
    public string  $newPassword     = '';
    public string  $resetGenerated  = '';
    public bool    $showResetModal  = false;
    public ?User   $resetUser       = null;

    // ══ ACTIVITY / AUDIT ══════════════════════════════════════
    public string $auditSearch     = '';
    public string $auditFilterType = '';
    public string $auditDateFrom   = '';
    public string $auditDateTo     = '';

    // ══ SESSION MANAGEMENT ════════════════════════════════════
    // (session data is read from DB/cache — simulated here)

    // ── Constants ────────────────────────────────────────────
    const ROLES = [
        'admin'      => 'Admin',
        'hr_manager' => 'HR Manager',
        'employee'   => 'Employee',
    ];

    const TABS = [
        'users'       => ['label' => 'User Accounts',      'icon' => 'users'],
        'roles'       => ['label' => 'Role Management',    'icon' => 'shield'],
        'permissions' => ['label' => 'Permissions Matrix', 'icon' => 'key'],
        'activity'    => ['label' => 'Activity Log',       'icon' => 'activity'],
        'audit'       => ['label' => 'Audit Trail',        'icon' => 'eye'],
        'sessions'    => ['label' => 'Session Management', 'icon' => 'monitor'],
        'password'    => ['label' => 'Password Reset',     'icon' => 'lock'],
        'security'    => ['label' => 'Security Settings',  'icon' => 'settings'],
    ];

    // ── ADD to mount() — loads saved settings from DB on boot ──────────────
 
    private function loadSecuritySettings(): void
    {
        try {
            $rows = DB::table('security_settings')->pluck('value', 'key');
            if ($rows->isEmpty()) return;
 
            $this->twoFactorEnabled      = (bool) ($rows['two_factor_enabled']      ?? false);
            $this->sessionTimeoutEnabled = (bool) ($rows['session_timeout_enabled'] ?? true);
            $this->sessionTimeoutMinutes = (int)  ($rows['session_timeout_minutes'] ?? 60);
            $this->passwordExpiry        = (bool) ($rows['password_expiry_enabled'] ?? false);
            $this->passwordExpiryDays    = (int)  ($rows['password_expiry_days']    ?? 90);
            $this->loginAuditEnabled     = (bool) ($rows['login_audit_enabled']     ?? true);
            $this->maxLoginAttempts      = (int)  ($rows['max_login_attempts']      ?? 5);
            $this->ipWhitelistEnabled    = (bool) ($rows['ip_whitelist_enabled']    ?? false);
            $this->ipWhitelist           = (string)($rows['ip_whitelist']           ?? '');
        } catch (\Exception) {
            // Table may not exist yet — silently ignore
        }
    }
 
    private function loadSavedPermissions(): void
    {
        try {
            $rows = DB::table('role_permissions')->get();
            if ($rows->isEmpty()) return;
 
            foreach ($rows as $row) {
                $this->permissions[$row->role][$row->permission] = (bool) $row->allowed;
            }
        } catch (\Exception) {
            // Table may not exist yet — silently ignore
        }
    }

    // ── Lifecycle ────────────────────────────────────────────
    public function mount(): void
    {
        $this->permissions   = self::DEFAULT_PERMISSIONS;
        $this->auditDateFrom = now()->subDays(30)->format('Y-m-d');
        $this->auditDateTo   = now()->format('Y-m-d');
 
        // Override defaults with whatever is saved in DB
        $this->loadSecuritySettings();
        $this->loadSavedPermissions();
    }

    public function setTab(string $tab): void
    {
        if (array_key_exists($tab, self::TABS)) {
            $this->activeTab = $tab;
            $this->resetPage();
        }
    }

    // ══ USER MANAGEMENT ══════════════════════════════════════

    protected function userRules(): array
    {
        $rules = [
            'code'        => ['required','string','max:50', Rule::unique('users','code')->ignore($this->editingId)],
            'firstName'   => ['required','string','max:255'],
            'middleName'  => ['nullable','string','max:255'],
            'lastName'    => ['required','string','max:255'],
            'username'    => ['required','string','max:255', Rule::unique('users','username')->ignore($this->editingId)],
            'email'       => ['required','email','max:255', Rule::unique('users','email')->ignore($this->editingId)],
            'phoneNumber' => ['nullable','string','max:255'],
            'role'        => ['required', Rule::in(array_keys(self::ROLES))],
        ];
        $rules['password'] = $this->editingId
            ? ['nullable','string','min:6']
            : ['required','string','min:6'];
        return $rules;
    }

    public function updatedSearch(): void     { $this->resetPage(); }
    public function updatedFilterRole(): void { $this->resetPage(); }
    public function updatedFirstName(): void  { $this->suggestUsername(); }
    public function updatedLastName(): void   { $this->suggestUsername(); }

    private function suggestUsername(): void
    {
        if (!$this->editingId && $this->firstName && $this->lastName) {
            $base = strtolower($this->firstName . '.' . $this->lastName);
            $this->username = preg_replace('/[^a-z0-9.]/', '', $base);
        }
    }

    private function generateCode(): string
    {
        $last = User::orderBy('created_at','desc')->first();
        $n = $last ? ((int)preg_replace('/\D/','', $last->code ?? '0')) + 1 : 1;
        return 'USR-' . str_pad($n, 5, '0', STR_PAD_LEFT);
    }

    public function openCreate(): void
    {
        $this->resetUserForm();
        $this->code      = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $u = User::findOrFail($id);
        $this->editingId   = $id;
        $this->code        = $u->code         ?? '';
        $this->firstName   = $u->first_name   ?? '';
        $this->middleName  = $u->middle_name  ?? '';
        $this->lastName    = $u->last_name    ?? '';
        $this->username    = $u->username     ?? '';
        $this->email       = $u->email        ?? '';
        $this->phoneNumber = $u->phone_number ?? '';
        $this->role        = $u->role         ?? 'employee';
        $this->password    = '';
        $this->showModal   = true;
    }

    public function openView(string $id): void
    {
        $this->viewRecord = User::findOrFail($id);
        $this->showView   = true;
    }

    public function closeView(): void       { $this->showView = false; $this->viewRecord = null; }
    public function closeModal(): void      { $this->showModal = false; $this->resetUserForm(); }

    public function openEditFromView(string $id): void
    {
        $this->closeView();
        $this->openEdit($id);
    }

    public function confirmDelete(string $id): void { $this->deletingId = $id; $this->showDelete = true; }
    public function cancelDelete(): void            { $this->deletingId = null; $this->showDelete = false; }

    public function deleteRecord(): void
    {
        if (!$this->deletingId) { $this->cancelDelete(); return; }
        try {
            User::findOrFail($this->deletingId)->delete();
            $this->cancelDelete();
            session()->flash('success', 'User account deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    public function viewCredentials(string $id): void
    {
        $this->credRecord      = User::findOrFail($id);
        $this->plainPassword   = '';
        $this->showCredentials = true;
    }

    public function closeCredentials(): void { $this->showCredentials = false; $this->credRecord = null; $this->plainPassword = ''; }

    public function assignRole(string $id, string $role): void
    {
        if (!array_key_exists($role, self::ROLES)) return;
        try {
            User::findOrFail($id)->update(['role' => $role]);
            session()->flash('success', 'Role updated to ' . self::ROLES[$role] . '.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function saveUser(): void
    {
        try {
            $this->validate($this->userRules());
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
                $msg = 'Account updated successfully.';
            } else {
                User::create($data);
                $msg = 'Account created successfully.';
            }
            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Save failed: ' . $e->getMessage());
        }
    }

    private function resetUserForm(): void
    {
        $this->editingId = null;
        $this->code = $this->firstName = $this->middleName = $this->lastName = '';
        $this->username = $this->email = $this->phoneNumber = $this->password = '';
        $this->role = 'employee';
        $this->resetValidation();
    }

    // ══ PERMISSIONS ══════════════════════════════════════════

    public function togglePermission(string $role, string $perm): void
    {
        $this->permissions[$role][$perm] = !($this->permissions[$role][$perm] ?? false);
    }

    public function savePermissions(): void
    {
        DB::beginTransaction();
        try {
            foreach ($this->permissions as $role => $perms) {
                foreach ($perms as $permKey => $allowed) {
                    DB::table('role_permissions')->upsert(
                        [
                            'role'       => $role,
                            'permission' => $permKey,
                            'allowed'    => (bool) $allowed,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ],
                        ['role', 'permission'],      // unique keys
                        ['allowed', 'updated_at']    // columns to update
                    );
                }
            }
            DB::commit();
 
            // Audit log
            \App\Services\AuditLogger::log(
                'update',
                'Permissions matrix updated by admin.',
                null,
                ['roles_updated' => array_keys($this->permissions)]
            );
 
            session()->flash('success', 'Permissions saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to save permissions: ' . $e->getMessage());
        }
    }

    // ══ SECURITY SETTINGS ════════════════════════════════════

    public function saveSecuritySettings(): void
    {
        DB::beginTransaction();
        try {
            $settings = [
                'two_factor_enabled'     => $this->twoFactorEnabled      ? '1' : '0',
                'session_timeout_enabled'=> $this->sessionTimeoutEnabled  ? '1' : '0',
                'session_timeout_minutes'=> (string) $this->sessionTimeoutMinutes,
                'password_expiry_enabled'=> $this->passwordExpiry         ? '1' : '0',
                'password_expiry_days'   => (string) $this->passwordExpiryDays,
                'login_audit_enabled'    => $this->loginAuditEnabled      ? '1' : '0',
                'max_login_attempts'     => (string) $this->maxLoginAttempts,
                'ip_whitelist_enabled'   => $this->ipWhitelistEnabled     ? '1' : '0',
                'ip_whitelist'           => $this->ipWhitelist,
            ];
 
            foreach ($settings as $key => $value) {
                DB::table('security_settings')->upsert(
                    ['key' => $key, 'value' => $value, 'updated_at' => now(), 'created_at' => now()],
                    ['key'],
                    ['value', 'updated_at']
                );
            }
 
            DB::commit();
 
            \App\Services\AuditLogger::log(
                'update',
                'Security settings updated by admin.',
                null,
                $settings
            );
 
            session()->flash('success', 'Security settings saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to save settings: ' . $e->getMessage());
        }
    }

    // ══ PASSWORD RESET ════════════════════════════════════════

    public function updatedResetSearch(): void { $this->resetPage(); }

    public function openResetModal(string $id): void
    {
        $this->resetUser      = User::findOrFail($id);
        $this->resetUserId    = $id;
        $this->newPassword    = '';
        $this->resetGenerated = '';
        $this->showResetModal = true;
    }

    public function closeResetModal(): void
    {
        $this->showResetModal = false;
        $this->resetUser = null;
        $this->newPassword = $this->resetGenerated = '';
    }

    public function generatePassword(): void
    {
        $this->resetGenerated = Str::random(12);
        $this->newPassword    = $this->resetGenerated;
    }

    public function doResetPassword(): void
    {
        if (!$this->resetUserId || !$this->newPassword) {
            session()->flash('error', 'Please enter or generate a password.');
            return;
        }
        if (strlen($this->newPassword) < 6) {
            session()->flash('error', 'Password must be at least 6 characters.');
            return;
        }
        try {
            User::findOrFail($this->resetUserId)->update(['password' => Hash::make($this->newPassword)]);
            $this->resetGenerated = $this->newPassword;
            session()->flash('success', 'Password reset successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ══ SESSION MANAGEMENT ════════════════════════════════════

    public function terminateSession(string $sessionId): void
    {
        try {
            DB::table('sessions')->where('id', $sessionId)->delete();
            session()->flash('success', 'Session terminated.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function terminateAllSessions(): void
    {
        try {
            // Keep current session alive
            DB::table('sessions')
                ->where('id', '!=', session()->getId())
                ->delete();
            session()->flash('success', 'All other sessions terminated.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ── Render ──────────────────────────────────────────────
    public function render()
    {
        // Users list
        $users = User::query()
            ->when($this->search, fn($q) => $q->where(function($q2) {
                $q2->where('first_name','like',"%{$this->search}%")
                   ->orWhere('last_name','like',"%{$this->search}%")
                   ->orWhere('email','like',"%{$this->search}%")
                   ->orWhere('username','like',"%{$this->search}%")
                   ->orWhere('code','like',"%{$this->search}%");
            }))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->orderBy('created_at','desc')
            ->paginate($this->perPage, ['*'], 'usersPage');

        $totalUsers = User::count();
        $adminCount = User::where('role','admin')->count();
        $hrCount    = User::where('role','hr_manager')->count();
        $empCount   = User::where('role','employee')->count();

        // Activity log — from DB audit_logs table if exists, else simulate
        $activityLogs = collect();
        try {
            $activityLogs = DB::table('audit_logs')
                ->when($this->auditSearch, fn($q) => $q->where('description','like',"%{$this->auditSearch}%"))
                ->when($this->auditFilterType, fn($q) => $q->where('event', $this->auditFilterType))
                ->when($this->auditDateFrom, fn($q) => $q->whereDate('created_at','>=',$this->auditDateFrom))
                ->when($this->auditDateTo,   fn($q) => $q->whereDate('created_at','<=',$this->auditDateTo))
                ->orderBy('created_at','desc')
                ->paginate(15, ['*'], 'auditPage');
        } catch (\Exception) {
            $activityLogs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
        }

        // Sessions
        $sessions = collect();
        try {
            $sessions = DB::table('sessions')
                ->orderBy('last_activity','desc')
                ->limit(50)
                ->get()
                ->map(function($s) {
                    $s->last_activity_human = Carbon::createFromTimestamp($s->last_activity)->diffForHumans();
                    $s->is_current = $s->id === session()->getId();
                    return $s;
                });
        } catch (\Exception) {}

        // Password reset user list
        $resetUsers = User::query()
            ->when($this->resetSearch, fn($q) => $q->where(function($q2) {
                $q2->where('first_name','like',"%{$this->resetSearch}%")
                   ->orWhere('last_name','like',"%{$this->resetSearch}%")
                   ->orWhere('email','like',"%{$this->resetSearch}%");
            }))
            ->orderBy('first_name')
            ->paginate(10, ['*'], 'resetPage');

        return view('livewire.admin.admin-dashboard', [
            'users'          => $users,
            'totalUsers'     => $totalUsers,
            'adminCount'     => $adminCount,
            'hrCount'        => $hrCount,
            'empCount'       => $empCount,
            'roles'          => self::ROLES,
            'tabs'           => self::TABS,
            'allPermissions' => self::ALL_PERMISSIONS,
            'activityLogs'   => $activityLogs,
            'sessions'       => $sessions,
            'resetUsers'     => $resetUsers,
            'showModal'      => $this->showModal,
            'showView'       => $this->showView,
            'showDelete'     => $this->showDelete,
            'showCredentials'=> $this->showCredentials,
            'showResetModal' => $this->showResetModal,
        ])->layout('components.layouts.admin');
    }
}