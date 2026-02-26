<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\Holiday;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | My Calendar')]
class HrPersonalCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;
    public $leaveRequests;
    public $holidays;
    public $hrEmployee;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadHrEmployee();
        $this->loadLeaveRequests();
        $this->loadHolidays();
    }

    public function loadHrEmployee()
    {
        $user = Auth::user();
        $this->hrEmployee = Employee::where('email', $user->email)->first();
    }

    public function loadLeaveRequests()
    {
        if (!$this->hrEmployee) {
            $this->leaveRequests = collect();
            return;
        }

        $this->leaveRequests = LeaveRequest::with(['leaveType'])
            ->where('employee_id', $this->hrEmployee->id)
            ->where(function($query) {
                $query->whereMonth('start_date', $this->currentMonth)
                      ->whereYear('start_date', $this->currentYear)
                      ->orWhere(function($query) {
                          $query->whereMonth('end_date', $this->currentMonth)
                                ->whereYear('end_date', $this->currentYear);
                      });
            })
            ->orderBy('start_date')
            ->get();
    }

    public function loadHolidays()
    {
        $this->holidays = Holiday::whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->orderBy('date')
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
        $this->loadHolidays();
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
        $this->loadHolidays();
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
        if (!$this->hrEmployee) {
            return collect();
        }

        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $date);
        
        return $this->leaveRequests->filter(function($leaveRequest) use ($carbonDate) {
            $start = Carbon::parse($leaveRequest->start_date);
            $end = Carbon::parse($leaveRequest->end_date);
            return $carbonDate->between($start, $end);
        });
    }

    public function getHolidaysForDate($date)
    {
        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $date);
        
        return $this->holidays->filter(function($holiday) use ($carbonDate) {
            $holidayDate = Carbon::parse($holiday->date);
            return $carbonDate->isSameDay($holidayDate);
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
        return view('livewire.leave-attendance.hr-personal-calendar')
            ->layout('components.layouts.app');
    }
}
