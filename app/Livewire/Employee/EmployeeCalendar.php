<?php

namespace App\Livewire\Employee;

use App\Models\LeaveRequest;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Attendance;
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
    public $attendanceRecords = [];
    public $showScheduleModal = false;
    public $selectedDate = null;
    public $scheduleTitle = '';
    public $scheduleDescription = '';
    public $scheduleStartTime = '';
    public $scheduleEndTime = '';
    public $workSchedules = [];

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

            // Load attendance records for current month
            $this->attendanceRecords = Attendance::where('employee_id', $this->employee->id)
                ->whereYear('date', $this->currentYear)
                ->whereMonth('date', $this->currentMonth)
                ->get();

            // Load work schedules for current month
            $this->workSchedules = $this->getWorkSchedules();

            $this->generateCalendarDays();
        } catch (\Exception $e) {
            \Log::error('Calendar loading error: ' . $e->getMessage());
            // Set empty arrays to prevent errors
            $this->leaveRequests = collect([]);
            $this->holidays = collect([]);
            $this->attendanceRecords = collect([]);
            $this->workSchedules = collect([]);
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
                'attendance' => null,
                'hasWorkSchedule' => false,
                'workSchedules' => [],
            ];

            // Check for leave requests on this day
            foreach ($this->leaveRequests as $leave) {
                if ($currentDate->between($leave->start_date, $leave->end_date)) {
                    $dayInfo['leaveRequests'][] = $leave;
                }
            }

            // Check for holidays on this day
            foreach ($this->holidays as $holiday) {
                if ($currentDate->format('Y-m-d') === $holiday->date->format('Y-m-d')) {
                    $dayInfo['holidays'][] = $holiday;
                }
            }

            // Check for attendance
            $attendance = $this->attendanceRecords->firstWhere('date', $currentDate->format('Y-m-d'));
            if ($attendance) {
                $dayInfo['attendance'] = $attendance;
                $dayInfo['hasWorkSchedule'] = true;
            } else {
                // Check if it's a workday (weekday without leave/holiday)
                if (!$currentDate->isWeekend() && empty($dayInfo['leaveRequests']) && empty($dayInfo['holidays'])) {
                    $dayInfo['hasWorkSchedule'] = true; // Expected workday
                }
            }

            // Check for custom work schedules
            foreach ($this->workSchedules as $schedule) {
                if ($schedule['date'] === $currentDate->format('Y-m-d')) {
                    $dayInfo['workSchedules'][] = $schedule;
                    $dayInfo['hasWorkSchedule'] = true;
                }
            }

            $this->calendarDays[] = $dayInfo;
            $currentDate->addDay();
        }
    }

    public function openScheduleModal($day)
    {
        $date = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, $day);
        $this->selectedDate = $date->format('Y-m-d');
        $this->scheduleTitle = '';
        $this->scheduleDescription = '';
        $this->scheduleStartTime = '09:00';
        $this->scheduleEndTime = '17:00';
        $this->showScheduleModal = true;
    }

    public function closeScheduleModal()
    {
        $this->showScheduleModal = false;
        $this->selectedDate = null;
        $this->reset(['scheduleTitle', 'scheduleDescription', 'scheduleStartTime', 'scheduleEndTime']);
    }

    public function saveWorkSchedule()
    {
        $this->validate([
            'scheduleTitle' => 'required|string|max:255',
            'scheduleDescription' => 'nullable|string|max:1000',
            'scheduleStartTime' => 'required',
            'scheduleEndTime' => 'required|after:scheduleStartTime',
        ]);

        // For now, we'll just store this in session as a simple example
        // In a real implementation, you'd have a WorkSchedule model
        $schedule = [
            'id' => uniqid(),
            'employee_id' => $this->employee->id,
            'date' => $this->selectedDate,
            'title' => $this->scheduleTitle,
            'description' => $this->scheduleDescription,
            'start_time' => $this->scheduleStartTime,
            'end_time' => $this->scheduleEndTime,
            'created_at' => now(),
        ];

        // Store in session (temporary solution)
        session()->put("work_schedule_{$schedule['id']}", $schedule);

        $this->closeScheduleModal();
        session()->flash('message', 'Work schedule added successfully!');
        $this->loadCalendarData();
    }

    public function getWorkSchedules()
    {
        $schedules = [];
        // Get schedules from session (temporary)
        foreach (session()->all() as $key => $value) {
            if (str_starts_with($key, 'work_schedule_') && is_array($value)) {
                $scheduleDate = \Carbon\Carbon::parse($value['date']);
                if ($scheduleDate->month == $this->currentMonth && $scheduleDate->year == $this->currentYear) {
                    $schedules[] = $value;
                }
            }
        }
        return collect($schedules);
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
        $workSchedules = $this->getWorkSchedules();
        
        return view('livewire.employee.employee-calendar', [
            'workSchedules' => $workSchedules
        ])->layout('components.layouts.employee');
    }
}
