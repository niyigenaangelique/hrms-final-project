<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | Admin - Access Control Management')]

class AccessControlManagement extends Component
{
    public function render(): object
    {
        $stats = [
            'total_roles' => count(\App\Models\User::ROLES),
            'total_permissions' => \DB::table('role_permissions')->count(),
            'active_users' => \App\Models\User::where('is_active', true)->count(),
        ];

        $roleCounts = [
            'super_admin' => \App\Models\User::where('role', \App\Models\User::ROLE_SUPER_ADMIN)->count(),
            'admin'       => \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN)->count(),
            'hr_manager'  => \App\Models\User::where('role', \App\Models\User::ROLE_HR_MANAGER)->count(),
            'employee'    => \App\Models\User::where('role', \App\Models\User::ROLE_EMPLOYEE)->count(),
        ];

        return view('livewire.admin.access-control-management', [
            'stats' => $stats,
            'roleCounts' => $roleCounts,
        ])->layout('components.layouts.admin');
    }
}
