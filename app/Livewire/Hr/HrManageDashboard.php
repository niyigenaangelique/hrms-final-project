<?php

namespace App\Livewire\HR;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('TalentFlow Pro | HR Management')]
class HrManageDashboard extends Component
{
    public $activeSection = 'overview';

    public function mount()
    {
        $this->activeSection = 'overview';
    }

    #[\Livewire\Attributes\Computed]
    public function stats()
    {
        return [
            'active_employees' => \App\Models\Employee::where('is_active', true)->count() ?? 0,
            'active_contracts' => \App\Models\Contract::where('status', 'active')->count() ?? 0,
            'pending_leaves' => \App\Models\LeaveRequest::where('status', 'pending')->count() ?? 0,
            'expiring_contracts' => \App\Models\Contract::where('end_date', '<=', now()->addDays(30))->count() ?? 0,
            'department_distribution' => \App\Models\Department::withCount('employees')->get()->map(function($dept) {
                return ['name' => $dept->name, 'count' => $dept->employees_count];
            })->toArray()
        ];
    }

    #[\Livewire\Attributes\Computed]
    public function recentEmployees()
    {
        return \App\Models\Employee::with('department')->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.hr.manage')->layout('components.layouts.app');
    }
}
