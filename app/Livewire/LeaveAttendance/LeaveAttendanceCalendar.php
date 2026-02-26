<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Title('ZIBITECH | C-HRMS | Leave & Attendance Calendar')]
class LeaveAttendanceCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $viewMode = 'month'; // month, week, day
    public $selectedEmployee;
    public $showTeamView = false;
    public $calendarData;
    public $employees;
    public $events;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->employees = Employee::where('is_active', true)->get();
        $this->loadCalendarData();
    }

    public function loadCalendarData()
    {
        $this->events = collect();
        
        // Load attendance records
        $attendanceQuery = Attendance::whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->with('employee');

        if ($this->selectedEmployee) {
            $attendanceQuery->where('employee_id', $this->selectedEmployee);
        }

        $attendances = $attendanceQuery->get();

        foreach ($attendances as $attendance) {
            $this->events->push([
                'type' => 'attendance',
                'date' => $attendance->date,
                'title' => 'Attendance',
                'employee' => $attendance->employee->first_name . ' ' . $attendance->employee->last_name,
                'status' => $attendance->status->value,
                'check_in' => $attendance->check_in?->format('H:i'),
                'check_out' => $attendance->check_out?->format('H:i'),
                'color' => $attendance->status->value === 'Approved' ? 'green' : 'yellow'
            ]);
        }

        // Load leave requests
        $leaveQuery = LeaveRequest::whereMonth('start_date', '<=', $this->currentMonth)
            ->whereMonth('end_date', '>=', $this->currentMonth)
            ->whereYear('start_date', '<=', $this->currentYear)
            ->whereYear('end_date', '>=', $this->currentYear)
            ->with(['employee', 'leaveType']);

        if ($this->selectedEmployee) {
            $leaveQuery->where('employee_id', $this->selectedEmployee);
        }

        $leaveRequests = $leaveQuery->get();

        foreach ($leaveRequests as $leave) {
            $start = Carbon::parse($leave->start_date);
            $end = Carbon::parse($leave->end_date);
            
            while ($start <= $end) {
                if ($start->month == $this->currentMonth && $start->year == $this->currentYear) {
                    $this->events->push([
                        'type' => 'leave',
                        'date' => $start->toDateString(),
                        'title' => $leave->leaveType->name,
                        'employee' => $leave->employee->first_name . ' ' . $leave->employee->last_name,
                        'status' => $leave->status->value,
                        'total_days' => $leave->total_days,
                        'color' => $leave->status->value === 'approved' ? 'blue' : 'orange'
                    ]);
                }
                $start->addDay();
            }
        }

        // Load holidays
        $holidays = Holiday::whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->orWhere('is_recurring', true)
            ->get();

        foreach ($holidays as $holiday) {
            if ($holiday->date->month == $this->currentMonth && $holiday->date->year == $this->currentYear) {
                $this->events->push([
                    'type' => 'holiday',
                    'date' => $holiday->date->toDateString(),
                    'title' => $holiday->name,
                    'description' => $holiday->description,
                    'color' => 'red'
                ]);
            }
        }

        $this->calendarData = $this->generateCalendarData();
    }

    private function generateCalendarData()
    {
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $lastDay = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();
        $daysInMonth = $lastDay->day;
        $startingDayOfWeek = $firstDay->dayOfWeek;

        $calendar = [];
        $currentWeek = [];

        // Add empty cells for days before month starts
        for ($i = 0; $i < $startingDayOfWeek; $i++) {
            $currentWeek[] = null;
        }

        // Add days of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $dayEvents = $this->events->filter(fn($event) => $event['date'] === $date->toDateString());
            
            $currentWeek[] = [
                'day' => $day,
                'date' => $date,
                'events' => $dayEvents,
                'isToday' => $date->isToday(),
                'isWeekend' => $date->isWeekend()
            ];

            // If it's the end of the week, add to calendar and start new week
            if (($startingDayOfWeek + $day - 1) % 7 === 6 || $day === $daysInMonth) {
                // Fill remaining days of the week
                while (count($currentWeek) < 7) {
                    $currentWeek[] = null;
                }
                $calendar[] = $currentWeek;
                $currentWeek = [];
            }
        }

        return $calendar;
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

    public function goToToday()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadCalendarData();
    }

    public function updatedSelectedEmployee()
    {
        $this->loadCalendarData();
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'month' ? 'week' : 'month';
    }

    public function toggleTeamView()
    {
        $this->showTeamView = !$this->showTeamView;
        $this->loadCalendarData();
    }

    public function render()
    {
        return view('livewire.leave-attendance.leave-attendance-calendar');
    }
}
