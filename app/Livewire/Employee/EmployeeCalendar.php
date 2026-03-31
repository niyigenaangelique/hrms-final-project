<?php

namespace App\Livewire\Employee;

use App\Models\LeaveRequest;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | My Calendar')]
class EmployeeCalendar extends Component
{
    public $employee;
    public $currentMonth;
    public $currentYear;
    public $calendarDays   = [];
    public $miniCalendarDays = [];
    public $leaveRequests  = [];
    public $holidays       = [];
    public $attendanceRecords = [];
    public $upcomingLeave  = [];
    public $tasks;
    public $showScheduleModal = false;
    public $showTaskModal     = false;
    public $selectedDate      = null;
    public $scheduleTitle       = '';
    public $scheduleDescription = '';
    public $scheduleStartTime   = '';
    public $scheduleEndTime     = '';
    public $workSchedules = [];

    // Task properties
    public $taskTitle       = '';
    public $taskDescription = '';
    public $taskHour        = null;
    public $taskDay         = null;
    public $editingTaskId   = null;

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('user_id', $user->id)->first();

        if (!$this->employee) {
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);

            $this->employee = Employee::create([
                'code'            => $newCode,
                'first_name'      => $user->first_name,
                'last_name'       => $user->last_name,
                'email'           => $user->email,
                'phone_number'    => $user->phone_number,
                'user_id'         => $user->id,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ]);
        }

        $this->currentMonth = now()->startOfMonth();
        $this->currentYear  = now()->year;
        $this->tasks        = collect([]);

        $this->loadCalendarData();
        $this->loadTasks();
    }

    public function loadCalendarData()
    {
        try {
            $monthStart = Carbon::create($this->currentYear, $this->currentMonth->month, 1)->startOfMonth();
            $monthEnd   = $monthStart->copy()->endOfMonth();

            // ── FIX 1: proper employee-scoped leave query ──────────────────
            // Both clauses must stay scoped to this employee_id
            $this->leaveRequests = LeaveRequest::where('employee_id', $this->employee->id)
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    // Leave overlaps the current calendar month
                    $q->where('start_date', '<=', $monthEnd)
                      ->where('end_date',   '>=', $monthStart);
                })
                ->get();

            // ── FIX 2: load holidays for the full calendar month window ────
            // Calendar grid can show days from prev/next month, so expand range slightly
            $calStart = $monthStart->copy()->startOfWeek();
            $calEnd   = $monthEnd->copy()->endOfWeek();

            $this->holidays = Holiday::whereBetween('date', [
                $calStart->format('Y-m-d'),
                $calEnd->format('Y-m-d'),
            ])->orderBy('date')->get();

            // ── Attendance for current month ───────────────────────────────
            $this->attendanceRecords = Attendance::where('employee_id', $this->employee->id)
                ->whereYear('date',  $this->currentYear)
                ->whereMonth('date', $this->currentMonth->month)
                ->get();

            // ── Work schedules (session-based) ─────────────────────────────
            $this->workSchedules = $this->getWorkSchedules();

            // ── Upcoming / recent leave sidebar list ───────────────────────
            // FIX: employee_id scoped, broader window so leave actually appears
            $this->upcomingLeave = LeaveRequest::where('employee_id', $this->employee->id)
                ->where(function ($q) {
                    $q->where('start_date', '>=', now()->subDays(30))
                      ->where('start_date', '<=', now()->addDays(60));
                })
                ->orderBy('start_date', 'asc')
                ->get();

            $this->generateCalendarDays();
            $this->generateMiniCalendarDays();

        } catch (\Exception $e) {
            \Log::error('Calendar loading error: ' . $e->getMessage() . ' ' . $e->getTraceAsString());
            $this->leaveRequests    = collect([]);
            $this->holidays         = collect([]);
            $this->attendanceRecords = collect([]);
            $this->workSchedules    = collect([]);
            $this->upcomingLeave    = collect([]);
            $this->generateCalendarDays();
            $this->generateMiniCalendarDays();
        }
    }

    public function generateCalendarDays()
    {
        $this->calendarDays = [];

        $firstDay  = Carbon::create($this->currentYear, $this->currentMonth->month, 1);
        $lastDay   = $firstDay->copy()->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek();
        $endDate   = $lastDay->copy()->endOfWeek();
        $current   = $startDate->copy();

        while ($current <= $endDate) {
            $dayInfo = [
                'date'           => $current->day,
                'dateObj'        => $current->copy(),
                'fullDate'       => $current->format('Y-m-d'),
                'isCurrentMonth' => $current->month === $this->currentMonth->month,
                'isToday'        => $current->isToday(),
                'isWeekend'      => $current->isWeekend(),
                'leaveRequests'  => [],
                'holidays'       => [],
                'attendance'     => null,
                'hasWorkSchedule'=> false,
                'workSchedules'  => [],
            ];

            // ── FIX 3: compare dates correctly (Carbon → string) ──────────
            foreach ($this->leaveRequests as $leave) {
                $start = $leave->start_date instanceof Carbon
                    ? $leave->start_date
                    : Carbon::parse($leave->start_date);
                $end = $leave->end_date instanceof Carbon
                    ? $leave->end_date
                    : Carbon::parse($leave->end_date);

                if ($current->between($start, $end)) {
                    $dayInfo['leaveRequests'][] = $leave;
                }
            }

            // ── FIX 4: normalise holiday date for comparison ───────────────
            foreach ($this->holidays as $holiday) {
                $hDate = $holiday->date instanceof Carbon
                    ? $holiday->date->format('Y-m-d')
                    : Carbon::parse($holiday->date)->format('Y-m-d');

                if ($current->format('Y-m-d') === $hDate) {
                    $dayInfo['holidays'][] = $holiday;
                }
            }

            // Attendance
            $att = $this->attendanceRecords->first(
                fn ($a) => Carbon::parse($a->date)->format('Y-m-d') === $current->format('Y-m-d')
            );
            if ($att) {
                $dayInfo['attendance']     = $att;
                $dayInfo['hasWorkSchedule'] = true;
            } elseif (!$current->isWeekend() && empty($dayInfo['leaveRequests']) && empty($dayInfo['holidays'])) {
                $dayInfo['hasWorkSchedule'] = true;
            }

            foreach ($this->workSchedules as $schedule) {
                if ($schedule['date'] === $current->format('Y-m-d')) {
                    $dayInfo['workSchedules'][] = $schedule;
                    $dayInfo['hasWorkSchedule'] = true;
                }
            }

            $this->calendarDays[] = $dayInfo;
            $current->addDay();
        }
    }

    public function generateMiniCalendarDays()
    {
        $this->miniCalendarDays = [];

        $firstDay  = Carbon::create($this->currentYear, $this->currentMonth->month, 1);
        $lastDay   = $firstDay->copy()->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek();
        $endDate   = $lastDay->copy()->endOfWeek();
        $current   = $startDate->copy();

        while ($current <= $endDate) {
            $isCurrentMonth = $current->month === $this->currentMonth->month;

            $this->miniCalendarDays[] = [
                'date'           => $current->copy(),
                'isCurrentMonth' => $isCurrentMonth,
                'isToday'        => $current->isToday(),
                'isWeekend'      => $current->isWeekend(),
                'hasEvents'      => $isCurrentMonth && $this->hasEventsForDay($current),
            ];

            $current->addDay();
        }
    }

    private function hasEventsForDay(Carbon $date): bool
    {
        $dateStr = $date->format('Y-m-d');

        $hasLeave = $this->leaveRequests->contains(function ($leave) use ($date) {
            $s = $leave->start_date instanceof Carbon ? $leave->start_date : Carbon::parse($leave->start_date);
            $e = $leave->end_date   instanceof Carbon ? $leave->end_date   : Carbon::parse($leave->end_date);
            return $date->between($s, $e);
        });

        $hasHoliday = $this->holidays->contains(function ($h) use ($dateStr) {
            $hd = $h->date instanceof Carbon ? $h->date->format('Y-m-d') : Carbon::parse($h->date)->format('Y-m-d');
            return $hd === $dateStr;
        });

        $hasAttendance = $this->attendanceRecords->contains(
            fn ($a) => Carbon::parse($a->date)->format('Y-m-d') === $dateStr
        );

        return $hasLeave || $hasHoliday || $hasAttendance;
    }

    // ── Navigation ─────────────────────────────────────────────────────────
    public function previousMonth()
    {
        $this->currentMonth->subMonth();
        $this->currentYear = $this->currentMonth->year;
        $this->loadCalendarData();
    }

    public function nextMonth()
    {
        $this->currentMonth->addMonth();
        $this->currentYear = $this->currentMonth->year;
        $this->loadCalendarData();
    }

    // ── Tasks ──────────────────────────────────────────────────────────────
    public function loadTasks()
    {
        $this->tasks = collect([
            (object)['id' => 1, 'title' => 'Team standup',   'hour' => 9,  'day' => 1, 'description' => 'Daily sync with the team'],
            (object)['id' => 2, 'title' => 'Project review', 'hour' => 14, 'day' => 2, 'description' => 'Q2 progress review'],
            (object)['id' => 3, 'title' => 'Client call',    'hour' => 11, 'day' => 3, 'description' => ''],
        ]);
    }

    public function addTask($hour, $day)
    {
        $this->taskHour        = $hour;
        $this->taskDay         = $day;
        $this->taskTitle       = '';
        $this->taskDescription = '';
        $this->editingTaskId   = null;
        $this->showTaskModal   = true;
    }

    public function editTask($taskId)
    {
        $task = $this->tasks->firstWhere('id', $taskId);
        if ($task) {
            $this->editingTaskId   = $taskId;
            $this->taskTitle       = $task->title;
            $this->taskHour        = $task->hour;
            $this->taskDay         = $task->day;
            $this->taskDescription = $task->description ?? '';
            $this->showTaskModal   = true;
        }
    }

    public function saveTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskHour'  => 'required|integer|min:8|max:18',
            'taskDay'   => 'required|integer|min:1|max:5',
        ]);

        if ($this->editingTaskId) {
            $task = $this->tasks->firstWhere('id', $this->editingTaskId);
            if ($task) {
                $task->title       = $this->taskTitle;
                $task->description = $this->taskDescription;
                $task->hour        = (int) $this->taskHour;
                $task->day         = (int) $this->taskDay;
            }
        } else {
            $this->tasks->push((object)[
                'id'          => ($this->tasks->max('id') ?? 0) + 1,
                'title'       => $this->taskTitle,
                'description' => $this->taskDescription,
                'hour'        => (int) $this->taskHour,
                'day'         => (int) $this->taskDay,
            ]);
        }

        $this->closeTaskModal();
        session()->flash('success', 'Task saved successfully!');
    }

    public function deleteTask($taskId)
    {
        $this->tasks = $this->tasks->reject(fn ($t) => $t->id == $taskId);
    }

    public function openTaskModal()
    {
        $this->reset(['taskTitle', 'taskDescription', 'taskHour', 'taskDay', 'editingTaskId']);
        $this->showTaskModal = true;
    }

    public function closeTaskModal()
    {
        $this->showTaskModal = false;
        $this->reset(['taskTitle', 'taskDescription', 'taskHour', 'taskDay', 'editingTaskId']);
    }

    // ── Schedule modal ─────────────────────────────────────────────────────
    public function openScheduleModal($day)
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth->month, $day);
        $this->selectedDate       = $date->format('Y-m-d');
        $this->scheduleTitle      = '';
        $this->scheduleDescription= '';
        $this->scheduleStartTime  = '09:00';
        $this->scheduleEndTime    = '17:00';
        $this->showScheduleModal  = true;
    }

    public function closeScheduleModal()
    {
        $this->showScheduleModal = false;
        $this->selectedDate      = null;
        $this->reset(['scheduleTitle', 'scheduleDescription', 'scheduleStartTime', 'scheduleEndTime']);
    }

    public function saveWorkSchedule()
    {
        $this->validate([
            'scheduleTitle'     => 'required|string|max:255',
            'scheduleDescription'=> 'nullable|string|max:1000',
            'scheduleStartTime' => 'required',
            'scheduleEndTime'   => 'required|after:scheduleStartTime',
        ]);

        $schedule = [
            'id'          => uniqid(),
            'employee_id' => $this->employee->id,
            'date'        => $this->selectedDate,
            'title'       => $this->scheduleTitle,
            'description' => $this->scheduleDescription,
            'start_time'  => $this->scheduleStartTime,
            'end_time'    => $this->scheduleEndTime,
            'created_at'  => now(),
        ];

        session()->put("work_schedule_{$schedule['id']}", $schedule);
        $this->closeScheduleModal();
        session()->flash('success', 'Work schedule added successfully!');
        $this->loadCalendarData();
    }

    public function getWorkSchedules()
    {
        $schedules = [];
        foreach (session()->all() as $key => $value) {
            if (str_starts_with($key, 'work_schedule_') && is_array($value)) {
                $d = Carbon::parse($value['date']);
                if ($d->month == $this->currentMonth->month && $d->year == $this->currentYear) {
                    $schedules[] = $value;
                }
            }
        }
        return collect($schedules);
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function render()
    {
        return view('livewire.employee.employee-calendar', [
            'workSchedules' => $this->getWorkSchedules(),
        ])->layout('components.layouts.employee');
    }
}