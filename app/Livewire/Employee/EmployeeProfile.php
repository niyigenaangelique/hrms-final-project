<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Contract;
use App\Models\Document;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | My Profile')]
class EmployeeProfile extends Component
{
    public $employee;
    public $activeTab = 'overview';
    public $contracts;
    public $documents;
    public $emergencyContacts;

    public function mount($employeeId = null)
    {
        if ($employeeId) {
            // Admin viewing employee profile
            $this->employee = Employee::with([
                'contracts',
                'documents',
                'position',
                'department'
            ])->findOrFail($employeeId);
        } else {
            // Employee viewing their own profile
            $user = Auth::user();
            $this->employee = Employee::where('user_id', $user->id)->first();
            
            if (!$this->employee) {
                // Create employee if not exists
                // Get the highest existing employee code number
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            $this->employee = Employee::create([
                'code' => $newCode,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'user_id' => $user->id,
                    'approval_status' => \App\Enum\ApprovalStatus::Approved,
                ]);
            }
        }
        
        $this->loadRelatedData();
    }

    public function loadRelatedData()
    {
        $this->contracts = $this->employee->contracts()->latest()->get();
        $this->documents = $this->employee->documents()->latest()->get();
        $this->emergencyContacts = $this->employee->emergencyContacts()->get();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getEmploymentHistory()
    {
        return $this->employee->contracts()
            ->with('position')
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($contract) {
                return [
                    'title' => $contract->position->name ?? 'Position',
                    'company' => 'ZIBITECH',
                    'period' => $contract->start_date->format('M Y') . ' - ' . 
                              ($contract->end_date ? $contract->end_date->format('M Y') : 'Present'),
                    'type' => $contract->contract_type ?? 'Full-time',
                    'description' => $contract->job_description ?? 'Employee role and responsibilities'
                ];
            });
    }

    public function render()
    {
        return view('livewire.employee.employee-profile')
            ->layout('components.layouts.employee');
    }
}
