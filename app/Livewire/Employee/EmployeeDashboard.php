<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Contract;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | Employee Dashboard')]
class EmployeeDashboard extends Component
{
    public $employee;
    public $leaveRequests;
    public $contracts;
    public $attendances;
    public $upcomingHolidays;
    public $recentActivities;

    // Chart data
    public $leaveChartData = [];
    public $attendanceChartData = [];
    public $performanceChartData = [];

    public function mount()
    {
        $this->loadEmployeeData();
    }

    public function loadEmployeeData()
    {
        $user = Auth::user();
        
        // Get the employee record for the current user
        $this->employee = Employee::where('user_id', $user->id)->first();
        
        if (!$this->employee) {
            // Create a sample employee for the logged-in user with a unique code
            $maxEmployee = Employee::where('code', 'like', 'EMP-%')->orderByRaw('CAST(SUBSTRING(code, 5) AS UNSIGNED) DESC')->first();
            $nextNumber = $maxEmployee ? (int)substr($maxEmployee->code, 4) + 1 : 1;
            
            $this->employee = Employee::create([
                'code' => 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT),
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'user_id' => $user->id,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ]);
        }

        // Load related data
        $this->leaveRequests = LeaveRequest::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $this->contracts = Contract::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $this->attendances = Attendance::where('employee_id', $this->employee->id)
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        // Prepare chart data
        $this->prepareChartData();

        // Sample upcoming holidays
        $this->upcomingHolidays = [
            ['name' => 'New Year', 'date' => '2024-01-01'],
            ['name' => 'Independence Day', 'date' => '2024-07-04'],
            ['name' => 'Labor Day', 'date' => '2024-09-02'],
        ];

        // Sample recent activities
        $this->recentActivities = [
            ['type' => 'login', 'description' => 'Logged in to system', 'time' => '2 hours ago'],
            ['type' => 'leave', 'description' => 'Leave request submitted', 'time' => '1 day ago'],
            ['type' => 'profile', 'description' => 'Profile updated', 'time' => '3 days ago'],
        ];
    }

    public function prepareChartData()
    {
        // Leave Chart Data
        $leaveStats = [
            'approved' => $this->leaveRequests->where('status', 'approved')->count(),
            'pending' => $this->leaveRequests->where('status', 'pending')->count(),
            'rejected' => $this->leaveRequests->where('status', 'rejected')->count(),
        ];
        
        $this->leaveChartData = [
            'labels' => ['Approved', 'Pending', 'Rejected'],
            'data' => [$leaveStats['approved'], $leaveStats['pending'], $leaveStats['rejected']],
        ];

        // Attendance Chart Data (last 7 days)
        $attendanceStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $present = $this->attendances->where('date', $date)->where('status', 'present')->count();
            $attendanceStats[] = $present > 0 ? 1 : 0;
        }
        
        $this->attendanceChartData = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'data' => $attendanceStats,
        ];

        // Performance Chart Data (sample data)
        $this->performanceChartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [85, 88, 92, 87, 90, 93],
        ];
    }

    public function render()
    {
        return view('livewire.employee.employee-dashboard')
            ->layout('components.layouts.employee');
    }
}
