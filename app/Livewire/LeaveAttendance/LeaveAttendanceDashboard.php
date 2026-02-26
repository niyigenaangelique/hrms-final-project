<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('ZIBITECH | C-HRMS | Leave & Attendance Dashboard')]
class LeaveAttendanceDashboard extends Component
{
    public $totalEmployees;
    public $presentToday;
    public $absentToday;
    public $onLeaveToday;
    public $pendingLeaveRequests;
    public $approvedLeaveRequests;
    public $thisMonthAttendance;
    public $upcomingHolidays;
    public $recentAttendance;
    public $recentLeaveRequests;
    public $attendanceTrends;
    public $leaveBalanceSummary;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $today = now()->toDateString();
        
        $this->totalEmployees = Employee::where('is_active', true)->count();
        $this->presentToday = Attendance::where('date', $today)->where('status', 'Approved')->count();
        $this->absentToday = $this->totalEmployees - $this->presentToday - $this->onLeaveToday;
        
        // Count employees on leave today
        $this->onLeaveToday = LeaveRequest::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', 'approved')
            ->count();
        
        $this->pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        $this->approvedLeaveRequests = LeaveRequest::where('status', 'approved')->count();
        
        // This month attendance rate
        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();
        $workingDays = $this->getWorkingDays($thisMonthStart, $thisMonthEnd);
        $totalAttendances = Attendance::whereBetween('date', [$thisMonthStart, $thisMonthEnd])
            ->where('status', 'Approved')
            ->count();
        $expectedAttendances = $this->totalEmployees * $workingDays;
        $this->thisMonthAttendance = $expectedAttendances > 0 ? round(($totalAttendances / $expectedAttendances) * 100, 1) : 0;
        
        // Upcoming holidays (next 30 days)
        $this->upcomingHolidays = Holiday::whereBetween('date', [now(), now()->addDays(30)])
            ->orderBy('date')
            ->take(5)
            ->get();
        
        // Recent attendance
        $this->recentAttendance = Attendance::with('employee')
            ->latest('date')
            ->take(10)
            ->get();
        
        // Recent leave requests
        $this->recentLeaveRequests = LeaveRequest::with(['employee', 'leaveType'])
            ->latest()
            ->take(10)
            ->get();
        
        $this->attendanceTrends = $this->getAttendanceTrends();
        $this->leaveBalanceSummary = $this->getLeaveBalanceSummary();
    }

    private function getWorkingDays($startDate, $endDate)
    {
        $days = 0;
        $current = $startDate->copy();
        
        while ($current <= $endDate) {
            if ($current->dayOfWeek != 0 && $current->dayOfWeek != 6) { // Not Sunday or Saturday
                $days++;
            }
            $current->addDay();
        }
        
        return $days;
    }

    private function getAttendanceTrends()
    {
        return Attendance::selectRaw('DATE(date) as date, COUNT(*) as total_attendances')
            ->where('date', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date')
            ->get();
    }

    private function getLeaveBalanceSummary()
    {
        return LeaveBalance::with(['leaveType'])
            ->where('employee_id', auth()->user()->employee->id ?? null)
            ->where('year', now()->year)
            ->get();
    }

    public function render()
    {
        return view('livewire.leave-attendance.leave-attendance-dashboard');
    }
}
