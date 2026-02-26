<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\PayrollMonth;
use App\Models\PayrollEntry;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | HR Calendar')]
class HrUnifiedCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;
    public $teamLeaveRequests;
    public $personalLeaveRequests;
    public $holidays;
    public $payrollMonths;
    public $payrollEntries;
    public $hrEmployee;
    public $filterEmployee = null;
    public $filterStatus = 'all';
    public $activeView = 'team'; // 'team', 'personal', or 'payroll'

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadHrEmployee();
        $this->loadData();
    }

    public function loadHrEmployee()
    {
        $user = Auth::user();
        $this->hrEmployee = Employee::where('email', $user->email)->first();
    }

    public function loadData()
    {
        $this->loadTeamLeaveRequests();
        $this->loadPersonalLeaveRequests();
        $this->loadHolidays();
        $this->loadPayrollData();
    }

    public function loadTeamLeaveRequests()
    {
        $query = LeaveRequest::with(['employee', 'leaveType'])
            ->where(function($query) {
                $query->whereMonth('start_date', $this->currentMonth)
                      ->whereYear('start_date', $this->currentYear)
                      ->orWhere(function($query) {
                          $query->whereMonth('end_date', $this->currentMonth)
                                ->whereYear('end_date', $this->currentYear);
                      });
            });

        if ($this->filterEmployee) {
            $query->where('employee_id', $this->filterEmployee);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $this->teamLeaveRequests = $query->orderBy('start_date')->get();
    }

    public function loadPersonalLeaveRequests()
    {
        if (!$this->hrEmployee) {
            $this->personalLeaveRequests = collect();
            return;
        }

        $this->personalLeaveRequests = LeaveRequest::with(['leaveType'])
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

    public function loadPayrollData()
    {
        // Get payroll months that overlap with current month
        $this->payrollMonths = PayrollMonth::where(function($query) {
                $query->whereMonth('start_date', '<=', $this->currentMonth)
                      ->whereYear('start_date', '<=', $this->currentYear)
                      ->whereMonth('end_date', '>=', $this->currentMonth)
                      ->whereYear('end_date', '>=', $this->currentYear);
            })
            ->get();

        // Get payroll entries for the current month (using payroll month dates)
        $this->payrollEntries = PayrollEntry::with(['employee'])
            ->whereHas('payrollMonth', function($query) {
                $query->whereMonth('start_date', '<=', $this->currentMonth)
                      ->whereYear('start_date', '<=', $this->currentYear)
                      ->whereMonth('end_date', '>=', $this->currentMonth)
                      ->whereYear('end_date', '>=', $this->currentYear);
            })
            ->orderBy('created_at')
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
        $this->loadData();
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
        $this->loadData();
    }

    public function updatedFilterEmployee()
    {
        $this->loadTeamLeaveRequests();
    }

    public function updatedFilterStatus()
    {
        $this->loadTeamLeaveRequests();
    }

    public function switchView($view)
    {
        $this->activeView = $view;
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

    public function getTeamLeaveRequestsForDate($date)
    {
        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $date);
        
        return $this->teamLeaveRequests->filter(function($leaveRequest) use ($carbonDate) {
            $start = Carbon::parse($leaveRequest->start_date);
            $end = Carbon::parse($leaveRequest->end_date);
            return $carbonDate->between($start, $end);
        });
    }

    public function getPersonalLeaveRequestsForDate($date)
    {
        if (!$this->hrEmployee) {
            return collect();
        }

        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $date);
        
        return $this->personalLeaveRequests->filter(function($leaveRequest) use ($carbonDate) {
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

    public function getPayrollEventsForDate($date)
    {
        $carbonDate = Carbon::create($this->currentYear, $this->currentMonth, $date);
        $events = collect();

        // Check for payroll months
        foreach ($this->payrollMonths as $payrollMonth) {
            $monthStart = Carbon::parse($payrollMonth->start_date);
            $monthEnd = Carbon::parse($payrollMonth->end_date);
            
            if ($carbonDate->isSameDay($monthStart)) {
                $events->push([
                    'type' => 'period_start',
                    'title' => 'Pay Period Start',
                    'description' => $payrollMonth->name,
                    'data' => $payrollMonth
                ]);
            }
            
            if ($carbonDate->isSameDay($monthEnd)) {
                $events->push([
                    'type' => 'period_end',
                    'title' => 'Pay Period End',
                    'description' => $payrollMonth->name,
                    'data' => $payrollMonth
                ]);
            }
            
            // Use the end date as payday (or you could add a specific payday field)
            if ($carbonDate->isSameDay($monthEnd)) {
                $events->push([
                    'type' => 'payday',
                    'title' => 'Payday!',
                    'description' => $payrollMonth->name . ' Payroll',
                    'data' => $payrollMonth
                ]);
            }
        }

        // Check for individual payroll entries (use created_at as date)
        $entriesForDate = $this->payrollEntries->filter(function($entry) use ($carbonDate) {
            return $carbonDate->isSameDay(Carbon::parse($entry->created_at));
        });

        foreach ($entriesForDate as $entry) {
            $events->push([
                'type' => 'payment',
                'title' => 'Payment Processed',
                'description' => $entry->employee->first_name . ' ' . $entry->employee->last_name,
                'data' => $entry
            ]);
        }

        return $events;
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
        return view('livewire.leave-attendance.hr-unified-calendar')
            ->layout('components.layouts.app');
    }
}
