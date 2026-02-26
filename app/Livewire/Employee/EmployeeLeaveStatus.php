<?php

namespace App\Livewire\Employee;

use App\Models\LeaveRequest;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | Leave Status')]
class EmployeeLeaveStatus extends Component
{
    public $employee;
    public $leaveRequests;
    public $selectedRequest = null;

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('user_id', $user->id)->first();
        
        if (!$this->employee) {
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

        $this->loadLeaveRequests();
    }

    public function loadLeaveRequests()
    {
        $this->leaveRequests = LeaveRequest::with('leaveType')
            ->where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function viewRequest($requestId)
    {
        $this->selectedRequest = LeaveRequest::with('leaveType')
            ->where('employee_id', $this->employee->id)
            ->findOrFail($requestId);
    }

    public function closeModal()
    {
        $this->selectedRequest = null;
    }

    public function render()
    {
        return view('livewire.employee.employee-leave-status')
            ->layout('components.layouts.employee');
    }
}
