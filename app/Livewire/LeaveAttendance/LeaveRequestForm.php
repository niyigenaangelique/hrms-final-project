<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Holiday;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title('ZIBITECH | C-HRMS | Leave Request')]
class LeaveRequestForm extends Component
{
    use WithFileUploads;

    public $leaveTypes;
    public $selectedLeaveType;
    public $start_date;
    public $end_date;
    public $reason;
    public $attachment;
    public $total_days;
    public $leaveBalance;
    public $holidays;
    public $conflictingRequests;

    protected $rules = [
        'selectedLeaveType' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10|max:500',
        'attachment' => 'nullable|file|max:5120', // 5MB max
    ];

    public function mount()
    {
        $this->loadLeaveTypes();
        $this->holidays = Holiday::whereYear('date', now()->year)
            ->orWhere('is_recurring', true)
            ->get();
    }

    public function loadLeaveTypes()
    {
        $this->leaveTypes = LeaveType::where('is_active', true)->get();
    }

    public function updatedSelectedLeaveType()
    {
        if ($this->selectedLeaveType && auth()->user()->employee) {
            $this->leaveBalance = LeaveBalance::where('employee_id', auth()->user()->employee->id)
                ->where('leave_type_id', $this->selectedLeaveType)
                ->where('year', now()->year)
                ->first();
        }
    }

    public function updatedStartDate()
    {
        $this->calculateDays();
        $this->checkConflicts();
    }

    public function updatedEndDate()
    {
        $this->calculateDays();
        $this->checkConflicts();
    }

    private function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);
            
            $days = 0;
            $current = $start->copy();
            
            while ($current <= $end) {
                // Skip weekends
                if ($current->dayOfWeek != 0 && $current->dayOfWeek != 6) {
                    // Skip holidays
                    if (!$this->isHoliday($current)) {
                        $days++;
                    }
                }
                $current->addDay();
            }
            
            $this->total_days = $days;
        }
    }

    private function isHoliday($date)
    {
        return $this->holidays->contains(function ($holiday) use ($date) {
            if ($holiday->is_recurring) {
                return $holiday->date->month == $date->month && $holiday->date->day == $date->day;
            }
            return $holiday->date->format('Y-m-d') == $date->format('Y-m-d');
        });
    }

    private function checkConflicts()
    {
        if ($this->start_date && $this->end_date && auth()->user()->employee) {
            $this->conflictingRequests = LeaveRequest::where('employee_id', auth()->user()->employee->id)
                ->where('status', '!=', 'rejected')
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) {
                    $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                          ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                          ->orWhere(function ($q) {
                              $q->where('start_date', '<=', $this->start_date)
                                ->where('end_date', '>=', $this->end_date);
                          });
                })
                ->get();
        } else {
            $this->conflictingRequests = collect();
        }
    }

    public function submit()
    {
        $this->validate();

        // Check if employee has sufficient leave balance
        if ($this->leaveBalance && $this->leaveBalance->balance_days < $this->total_days) {
            $this->addError('total_days', 'Insufficient leave balance. You have ' . $this->leaveBalance->balance_days . ' days available.');
            return;
        }

        // Check for conflicts
        if ($this->conflictingRequests && $this->conflictingRequests->isNotEmpty()) {
            $this->addError('conflict', 'You have conflicting leave requests for the selected period.');
            return;
        }

        $leaveRequest = LeaveRequest::create([
            'code' => 'LR-' . uniqid(),
            'employee_id' => auth()->user()->employee->id,
            'leave_type_id' => $this->selectedLeaveType,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'reason' => $this->reason,
            'status' => \App\Enum\LeaveStatus::PENDING,
            'approval_status' => \App\Enum\ApprovalStatus::Pending,
            'created_by' => auth()->id(),
        ]);

        // Handle attachment
        if ($this->attachment) {
            $path = $this->attachment->store('leave-attachments', 'public');
            $leaveRequest->update(['attachment_path' => $path]);
        }

        $this->dispatch('showNotification', 'Leave request submitted successfully', 'success');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->selectedLeaveType = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->reason = null;
        $this->attachment = null;
        $this->total_days = null;
        $this->leaveBalance = null;
        $this->conflictingRequests = collect();
    }

    public function render()
    {
        return view('livewire.leave-attendance.leave-request-form');
    }
}
