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
        'payroll'   => ['payroll.view'=>'View Payroll','payroll.create'=>'Create Payroll','payroll.edit'=>'Edit Payroll','payroll.delete'=>'Delete Payroll','payroll.approve'=>'Approve Payroll'],
        'employees' => ['employees.view'=>'View Employees','employees.create'=>'Create Employees','employees.edit'=>'Edit Employees','employees.delete'=>'Delete Employees'],
        'reports'   => ['reports.view'=>'View Reports','reports.export'=>'Export Reports'],
        'admin'     => ['admin.users'=>'Manage Users','admin.roles'=>'Manage Roles','admin.settings'=>'System Settings','admin.audit'=>'View Audit Log'],
    ];
 
    const DEFAULT_PERMISSIONS = [
        'admin'      => ['payroll.view'=>true,'payroll.create'=>true,'payroll.edit'=>true,'payroll.delete'=>true,'payroll.approve'=>true,'employees.view'=>true,'employees.create'=>true,'employees.edit'=>true,'employees.delete'=>true,'reports.view'=>true,'reports.export'=>true,'admin.users'=>true,'admin.roles'=>true,'admin.settings'=>true,'admin.audit'=>true],
        'hr_manager' => ['payroll.view'=>true,'payroll.create'=>true,'payroll.edit'=>true,'payroll.delete'=>false,'payroll.approve'=>true,'employees.view'=>true,'employees.create'=>true,'employees.edit'=>true,'employees.delete'=>false,'reports.view'=>true,'reports.export'=>true,'admin.users'=>false,'admin.roles'=>false,'admin.settings'=>false,'admin.audit'=>false],
        'employee'   => ['payroll.view'=>true,'payroll.create'=>false,'payroll.edit'=>false,'payroll.delete'=>false,'payroll.approve'=>false,'employees.view'=>false,'employees.create'=>false,'employees.edit'=>false,'employees.delete'=>false,'reports.view'=>false,'reports.export'=>false,'admin.users'=>false,'admin.roles'=>false,'admin.settings'=>false,'admin.audit'=>false],
    ];
 
    const ROLES = ['admin'=>'Admin','hr_manager'=>'HR Manager','employee'=>'Employee'];
 
    public function mount(): void
    {
        $this->permissions = self::DEFAULT_PERMISSIONS;
        try {
            $rows = DB::table('role_permissions')->get();
            foreach ($rows as $row) {
                $this->permissions[$row->role][$row->permission] = (bool) $row->allowed;
            }
        } catch (\Exception) {}
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
        DB::beginTransaction();
        try {
            foreach ($this->permissions as $role => $perms) {
                foreach ($perms as $permKey => $allowed) {
                    DB::table('role_permissions')->upsert(
                        ['role'=>$role,'permission'=>$permKey,'allowed'=>(bool)$allowed,'updated_at'=>now(),'created_at'=>now()],
                        ['role','permission'], ['allowed','updated_at']
                    );
                }
            }
            DB::commit();
            session()->flash('success', 'Permissions saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to save permissions: '.$e->getMessage());
        }
    }
 
    public function render()
    {
        return view('livewire.admin.permission-management', [
            'allPermissions' => self::ALL_PERMISSIONS,
            'roles'          => self::ROLES,
        ])->layout('components.layouts.admin');
    }
}
 