<?php

namespace App\Livewire\Employee;

use App\Models\LeaveType;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('TalentFlow Pro | Leave Types')]
class EmployeeLeaveTypes extends Component
{
    public $leaveTypes;

    public function mount()
    {
        $this->loadLeaveTypes();
    }

    public function loadLeaveTypes()
    {
        $this->leaveTypes = LeaveType::where('is_active', true)->get();
    }

    public function render()
    {
        return view('livewire.employee.employee-leave-types')
            ->layout('components.layouts.employee');
    }
}
