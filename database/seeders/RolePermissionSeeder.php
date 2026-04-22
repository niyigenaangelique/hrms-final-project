<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    const DEFAULT_PERMISSIONS = [
        'admin' => [
            'payroll.view'     => true,
            'payroll.create'   => true,
            'payroll.edit'     => true,
            'payroll.delete'   => true,
            'payroll.approve'  => true,
            'employees.view'   => true,
            'employees.create' => true,
            'employees.edit'   => true,
            'employees.delete' => true,
            'reports.view'     => true,
            'reports.export'   => true,
            'admin.users'      => true,
            'admin.roles'      => true,
            'admin.settings'   => true,
            'admin.audit'      => true,
        ],
        'hr_manager' => [
            'payroll.view'     => true,
            'payroll.create'   => true,
            'payroll.edit'     => true,
            'payroll.delete'   => false,
            'payroll.approve'  => true,
            'employees.view'   => true,
            'employees.create' => true,
            'employees.edit'   => true,
            'employees.delete' => false,
            'reports.view'     => true,
            'reports.export'   => true,
            'admin.users'      => false,
            'admin.roles'      => false,
            'admin.settings'   => false,
            'admin.audit'      => false,
        ],
        'employee' => [
            'payroll.view'     => true,
            'payroll.create'   => false,
            'payroll.edit'     => false,
            'payroll.delete'   => false,
            'payroll.approve'  => false,
            'employees.view'   => false,
            'employees.create' => false,
            'employees.edit'   => false,
            'employees.delete' => false,
            'reports.view'     => false,
            'reports.export'   => false,
            'admin.users'      => false,
            'admin.roles'      => false,
            'admin.settings'   => false,
            'admin.audit'      => false,
        ],
    ];

    public function run(): void
    {
        $rows = [];
        $now  = now();

        foreach (self::DEFAULT_PERMISSIONS as $role => $perms) {
            foreach ($perms as $permission => $allowed) {
                $rows[] = [
                    'role'       => $role,
                    'permission' => $permission,
                    'allowed'    => $allowed,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // upsert so re-running is safe
        DB::table('role_permissions')->upsert(
            $rows,
            ['role', 'permission'],
            ['allowed', 'updated_at']
        );

        $this->command->info('✓ Role permissions seeded (' . count($rows) . ' rows).');
    }
}
