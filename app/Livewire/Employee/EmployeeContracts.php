<?php

namespace App\Livewire\Employee;

use App\Models\Contract;
use App\Models\Employee;
use App\Services\ContractPdfService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | My Contracts')]
class EmployeeContracts extends Component
{
    public $contracts;
    public $employee;
    public $selectedContract = null;

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('user_id', $user->id)
            ->with(['positionAssignment', 'departmentAssignment'])
            ->first();
        
        if ($this->employee) {
            $this->loadContracts();
        }
    }

    public function loadContracts()
    {
        $this->contracts = Contract::where('employee_id', $this->employee->id)
            ->with(['position'])
            ->orderBy('start_date', 'desc')
            ->get();
    }

    public function viewContract($contractId)
    {
        $this->selectedContract = Contract::with(['position'])
            ->find($contractId);
    }

    public function closeModal()
    {
        $this->selectedContract = null;
    }

    public function openPdfModal($contractId)
    {
        $this->selectedContract = Contract::with(['position'])
            ->find($contractId);
    }

    public function render()
    {
        return view('livewire.employee.employee-contracts')
            ->layout('components.layouts.employee');
    }
}
