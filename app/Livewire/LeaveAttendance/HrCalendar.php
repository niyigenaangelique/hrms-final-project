<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | HR Calendar')]
class HrCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;
    public $leaveRequests;
    public $employees;
    public $filterEmployee = null;
    public $filterStatus = 'all';

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadLeaveRequests();
        $this->loadEmployees();
    }

    public function loadLeaveRequests()
    {
        $query = LeaveRequest::with(['employee', 'leaveType'])
            ->whereMonth('start_date', $this->currentMonth)
            ->whereYear('start_date', $this->currentYear)
            ->orWhere(function($query) {
                $query->whereMonth('end_date', $this->currentMonth)
                      ->whereYear('end_date', $this->currentYear);
            });

        if ($this->filterEmployee) {
            $query->where('employee_id', $this->filterEmployee);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $this->leaveRequests = $query->orderBy('start_date')->get();
    }

    public function loadEmployees()
    {
        $this->employees = Employee::where('approval_status', 'Approved')
            ->orderBy('first_name')
            ->get();
    }

    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
        $this->loadLeaveRequests();
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
        $this->loadLeaveRequests();
    }

    public function updatedFilterEmployee()
    {
        $this->loadLeaveRequests();
    }

    public function updatedFilterStatus()
    {
        $this->loadLeaveRequests();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function getDaysInMonth()
    {
        return Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;
    }

    public function getFirstDayOfMonth()
    {
        return Carbon::create($this->currentYear, $this->currentMonth)->firstOfMonth()->dayOfWeek;
    }

    public function getMonthName()
    {
        return Carbon::create($this->currentYear, $this->currentMonth)->format('F');
    }

    public function getLeaveRequestsForDate($date)
    {
        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $date);
        
        return $this->leaveRequests->filter(function($leaveRequest) use ($carbonDate) {
            $start = Carbon::parse($leaveRequest->start_date);
            $end = Carbon::parse($leaveRequest->end_date);
            return $carbonDate->between($start, $end);
        });
    }

    public function isWeekend($day)
    {
        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $day);
        return $carbonDate->isWeekend();
    }

    public function isToday($day)
    {
        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $day);
        return $carbonDate->isToday();
    }

    public function render()
    {
        return view('livewire.leave-attendance.hr-calendar')
            ->layout('components.layouts.app');
    }
}
