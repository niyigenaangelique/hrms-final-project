<?php

namespace App\Livewire\Employee;

use App\Models\Contract;
use App\Models\Employee;
use App\Services\ContractPdfService;
use Illuminate\Support\Facades\Auth;
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
        $this->employee = Employee::where('user_id', $user->id)->first();
        
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

    public function downloadContract($contractId)
    {
        try {
            $contract = Contract::where('employee_id', $this->employee->id)
                ->find($contractId);
            
            if (!$contract) {
                session()->flash('error', 'Contract not found.');
                return;
            }

            $pdfService = new ContractPdfService();
            return $pdfService->downloadContract($contract);
            
        } catch (\Exception $e) {
            \Log::error('Contract download failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to download contract. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-contracts')
            ->layout('components.layouts.employee');
    }
}
