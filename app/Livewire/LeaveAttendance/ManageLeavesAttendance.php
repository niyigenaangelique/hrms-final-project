<?php

namespace App\Livewire\LeaveAttendance;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | ManageLeavesAttendances')]

class ManageLeavesAttendance extends Component
{
    #[On('manage_leaves_attendanceNotification')]
    public function handleNotification(): void
    {

    }
    public function render()
    {
        return view('livewire.leave-attendance.manage-leaves-attendance')->layout('components.layouts.app');
    }
}
