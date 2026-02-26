<?php

namespace App\Livewire\Employee;

use App\Models\LeaveRequest;
use App\Models\Holiday;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | My Calendar')]
class EmployeeCalendar extends Component
{
    public $employee;
    public $currentMonth;
    public $currentYear;
    public $calendarDays = [];
    public $leaveRequests = [];
    public $holidays = [];

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

        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadCalendarData();
    }

    public function loadCalendarData()
    {
        try {
            // Load employee's leave requests
            $this->leaveRequests = LeaveRequest::where('employee_id', $this->employee->id)
                ->where(function($query) {
                    $query->whereYear('start_date', $this->currentYear)
                          ->whereMonth('start_date', $this->currentMonth);
                })->orWhere(function($query) {
                    $query->where('employee_id', $this->employee->id)
                          ->whereYear('end_date', $this->currentYear)
                          ->whereMonth('end_date', $this->currentMonth);
                })->get();

            // Load holidays for current month
            $this->holidays = Holiday::whereYear('date', $this->currentYear)
                ->whereMonth('date', $this->currentMonth)
                ->get();

            $this->generateCalendarDays();
        } catch (\Exception $e) {
            \Log::error('Calendar loading error: ' . $e->getMessage());
            // Set empty arrays to prevent errors
            $this->leaveRequests = collect([]);
            $this->holidays = collect([]);
            $this->generateCalendarDays();
        }
    }

    public function generateCalendarDays()
    {
        $this->calendarDays = [];
        
        $firstDay = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek();
        $endDate = $lastDay->copy()->endOfWeek();

        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dayInfo = [
                'date' => $currentDate->day,
                'dateObj' => $currentDate->copy(),
                'isCurrentMonth' => $currentDate->month === $this->currentMonth,
                'isToday' => $currentDate->isToday(),
                'isWeekend' => $currentDate->isWeekend(),
                'leaveRequests' => [],
                'holidays' => [],
            ];

            // Check for leave requests on this day
            foreach ($this->leaveRequests as $leaveRequest) {
                if ($currentDate->between($leaveRequest->start_date, $leaveRequest->end_date)) {
                    $dayInfo['leaveRequests'][] = $leaveRequest;
                }
            }

            // Check for holidays on this day
            foreach ($this->holidays as $holiday) {
                if ($currentDate->isSameDay($holiday->date)) {
                    $dayInfo['holidays'][] = $holiday;
                }
            }

            $this->calendarDays[] = $dayInfo;
            $currentDate->addDay();
        }
    }

    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
        $this->loadCalendarData();
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        }
        $this->loadCalendarData();
    }

    public function render()
    {
        return view('livewire.employee.employee-calendar')
            ->layout('components.layouts.employee');
    }
}
