<?php

namespace App\Livewire\Admin;
 
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
 
#[Title('TalentFlow Pro | Permissions Matrix')]
class PermissionManagement extends Component
{
    public array $permissions = [];
 
    const ALL_PERMISSIONS = [
        'payroll'     => [
            'payroll.view' => 'View Payroll',
            'payroll.create' => 'Create Entry',
            'payroll.edit' => 'Edit Entry',
            'payroll.delete' => 'Delete Entry',
            'payroll.approve' => 'Approve Payroll',
            'payroll.payslips' => 'Generate Payslips'
        ],
        'employees'   => [
            'employees.view' => 'View Employees',
            'employees.create' => 'Create Employee',
            'employees.edit' => 'Edit Employee',
            'employees.delete' => 'Delete Employee',
            'employees.contracts' => 'Manage Contracts'
        ],
        'attendance'  => [
            'attendance.view' => 'View Attendance',
            'attendance.edit' => 'Edit Clock-ins',
            'attendance.reports' => 'Attendance Reports',
            'attendance.devices' => 'Manage Devices'
        ],
        'leaves'      => [
            'leaves.view' => 'View Leave Requests',
            'leaves.approve' => 'Approve/Reject Leaves',
            'leaves.settings' => 'Manage Leave Types',
            'leaves.calendar' => 'View Leave Calendar'
        ],
        'performance' => [
            'performance.view' => 'View KPIs',
            'performance.edit' => 'Manage Targets',
            'performance.review' => 'Conduct Reviews'
        ],
        'finance'     => [
            'banks.manage' => 'Manage Banks',
            'currency.edit' => 'Currency Settings',
            'tax.config' => 'Tax Brackets'
        ],
        'system'      => [
            'admin.users' => 'User Management',
            'admin.settings' => 'System Settings',
            'admin.audit' => 'Audit Logs',
            'admin.oversight' => 'Data Oversight'
        ],
    ];
 
    // DEFAULT_PERMISSIONS now acts as a template. Admin always has true for everything.
    const DEFAULT_PERMISSIONS = [
        'admin'      => ['payroll.view'=>true,'payroll.create'=>true,'payroll.edit'=>true,'payroll.delete'=>true,'payroll.approve'=>true,'employees.view'=>true,'employees.create'=>true,'employees.edit'=>true,'employees.delete'=>true,'reports.view'=>true,'reports.export'=>true,'admin.users'=>true,'admin.roles'=>true,'admin.settings'=>true,'admin.audit'=>true],
        'super_admin'=> ['payroll.view'=>true,'payroll.create'=>true,'payroll.edit'=>true,'payroll.delete'=>true,'payroll.approve'=>true,'employees.view'=>true,'employees.create'=>true,'employees.edit'=>true,'employees.delete'=>true,'reports.view'=>true,'reports.export'=>true,'admin.users'=>true,'admin.roles'=>true,'admin.settings'=>true,'admin.audit'=>true],
    ];
 
    // ROLES are now centralized in User model
 
    public function mount(): void
    {
        $targetRoles = ['admin', 'hr_manager', 'employee'];

        // Initialize permissions for selected roles
        foreach ($targetRoles as $role) {
            $this->permissions[$role] = self::DEFAULT_PERMISSIONS[$role] ?? [];
            // Fill missing permissions with false as default
            foreach (self::ALL_PERMISSIONS as $group => $perms) {
                foreach ($perms as $key => $label) {
                    if (!isset($this->permissions[$role][$key])) {
                        $this->permissions[$role][$key] = false;
                    }
                }
            }
        }

        try {
            $rows = DB::table('role_permissions')->get();
            foreach ($rows as $row) {
                if (isset($this->permissions[$row->role])) {
                    $this->permissions[$row->role][$row->permission] = (bool) $row->allowed;
                }
            }
        } catch (\Exception $e) {}
    }
 
    public function togglePermission(string $role, string $perm): void
    {
        $this->permissions[$role][$perm] = !($this->permissions[$role][$perm] ?? false);
    }
 
    public function resetPermissions(string $role): void
    {
        $this->permissions[$role] = self::DEFAULT_PERMISSIONS[$role] ?? [];
        session()->flash('success', ucwords(str_replace('_',' ',$role)) . ' permissions reset to defaults.');
    }
 
    public function savePermissions(): void
    {
        try {
            foreach ($this->permissions as $role => $perms) {
                foreach ($perms as $permKey => $allowed) {
                    DB::table('role_permissions')->updateOrInsert(
                        ['role' => $role, 'permission' => $permKey],
                        ['allowed' => (bool)$allowed, 'updated_at' => now()]
                    );
                }
            }
            session()->flash('success', 'Permissions saved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save permissions: '.$e->getMessage());
        }
    }
 
    public function render()
    {
        return view('livewire.admin.permission-management', [
            'allPermissions' => self::ALL_PERMISSIONS,
            'roles'          => \App\Models\User::ROLES,
        ])->layout('components.layouts.admin');
    }
}
 