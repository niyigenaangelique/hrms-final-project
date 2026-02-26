<?php

namespace App\Livewire\Employee;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Enum\LeaveStatus;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | Request Leave')]
class EmployeeLeaveRequest extends Component
{
    public $leaveTypes;
    public $employee;
    public $leave_type_id;
    public $start_date;
    public $end_date;
    public $reason;
    public $attachments = [];

    protected $rules = [
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:500',
    ];

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

        $this->leaveTypes = LeaveType::where('is_active', true)->get();
    }

    public function submit()
    {
        $this->validate();

        try {
            // Calculate total days
            $startDate = \Carbon\Carbon::parse($this->start_date);
            $endDate = \Carbon\Carbon::parse($this->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1;

            // Generate leave request code
            $code = 'LR-' . str_pad(LeaveRequest::count() + 1, 4, '0', STR_PAD_LEFT);

            LeaveRequest::create([
                'code' => $code,
                'employee_id' => $this->employee->id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $totalDays,
                'reason' => $this->reason,
                'status' => LeaveStatus::PENDING,
                'approval_status' => \App\Enum\ApprovalStatus::Pending,
                'created_by' => Auth::id(),
            ]);

            $this->reset(['leave_type_id', 'start_date', 'end_date', 'reason', 'attachments']);
            
            session()->flash('success', 'Leave request submitted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Leave request submission failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to submit leave request. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-leave-request')
            ->layout('components.layouts.employee');
    }
}
