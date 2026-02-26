<?php

namespace App\Livewire\Attendance;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Attendances')]

class AttendancePage extends Component
{
    #[On('attendanceNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.attendance.attendance-page');
    }
}
