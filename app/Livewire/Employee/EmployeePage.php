<?php

namespace App\Livewire\Employee;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Employees')]

class EmployeePage extends Component
{
    #[On('employeeNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.employee.employee-page', [
            'banks' => \App\Models\Bank::orderBy('name')->get(),
        ]);
    }
}
