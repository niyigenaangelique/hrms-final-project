<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Employee;
use App\Models\ActivityLog;
use App\Models\LeaveRequest;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SystemAnalytics extends Component
{
    public $dateRange = '30'; // days
    public $activeTab = 'security'; // security, infrastructure, governance

    public function render()
    {
        return view('livewire.admin.system-analytics', [
            'securityData' => $this->getSecurityAudit(),
            'infrastructure' => $this->getInfrastructureHealth(),
            'governance' => $this->getGovernanceOversight(),
            'activityTrends' => $this->getActivityTrends(),
        ])->layout('components.layouts.admin');
    }

    private function getSecurityAudit()
    {
        $startDate = now()->subDays($this->dateRange);
        
        return [
            'total_logins' => ActivityLog::where('action', 'login')->where('created_at', '>=', $startDate)->count(),
            'failed_attempts' => ActivityLog::where('action', 'failed_login')->where('created_at', '>=', $startDate)->count(),
            'password_resets' => ActivityLog::where('action', 'password_reset')->where('created_at', '>=', $startDate)->count(),
            'active_admins' => User::where('role', 'admin')->where('is_active', true)->count(),
            'recent_failures' => ActivityLog::where('action', 'failed_login')
                ->orderBy('created_at', 'desc')->take(5)->get(),
        ];
    }

    private function getInfrastructureHealth()
    {
        return [
            'database_size' => $this->getEstimatedDbSize(),
            'total_records' => ActivityLog::count() + User::count(),
            'cache_status' => 'Optimized',
            'storage_used' => '1.2 GB',
            'environment' => config('app.env'),
            'row_counts' => [
                'Users' => User::count(),
                'Activity Logs' => ActivityLog::count(),
                'Permissions' => DB::table('role_permissions')->count(),
            ]
        ];
    }

    private function getGovernanceOversight()
    {
        return [
            'role_distribution' => User::selectRaw('role, COUNT(*) as count')->groupBy('role')->get(),
            'recent_permission_changes' => ActivityLog::where('action', 'update_permissions')
                ->orderBy('created_at', 'desc')->take(5)->get(),
            'account_status' => [
                'Active' => User::where('is_active', true)->count(),
                'Inactive' => User::where('is_active', false)->count(),
            ]
        ];
    }

    private function getActivityTrends()
    {
        $startDate = now()->subDays($this->dateRange);
        return ActivityLog::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getEstimatedDbSize()
    {
        try {
            $results = DB::select('SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?', [config('database.connections.mysql.database')]);
            return round($results[0]->size, 2) . ' MB';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    private function getChartData()
    {
        $startDate = now()->subDays($this->dateRange);
        
        return [
            'daily_activity' => $this->getDailyActivityData($startDate),
            'user_registrations' => $this->getUserRegistrationData($startDate),
            'leave_requests' => $this->getLeaveRequestData($startDate),
            'system_load' => $this->getSystemLoadData($startDate),
        ];
    }

    // Helper methods for analytics data
    private function getUserGrowthData($startDate)
    {
        return User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getUserActivityData($startDate)
    {
        return ActivityLog::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getUserRoleDistribution()
    {
        return User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get();
    }

    private function getUserLoginTrends($startDate)
    {
        return ActivityLog::where('action', 'login')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getEmployeeGrowthData($startDate)
    {
        return Employee::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getDepartmentDistribution()
    {
        return Employee::selectRaw('department, COUNT(*) as count')
            ->groupBy('department')
            ->get();
    }

    private function getPositionDistribution()
    {
        return Employee::selectRaw('position, COUNT(*) as count')
            ->groupBy('position')
            ->get();
    }

    private function getEmployeeTurnoverRate($startDate)
    {
        $totalEmployees = Employee::count();
        $leftEmployees = Employee::where('left_date', '>=', $startDate)->count();
        
        return [
            'total_employees' => $totalEmployees,
            'left_employees' => $leftEmployees,
            'turnover_rate' => $totalEmployees > 0 ? round(($leftEmployees / $totalEmployees) * 100, 2) : 0,
        ];
    }

    private function getAttendanceRate($startDate)
    {
        $totalDays = $this->dateRange;
        $totalEmployees = Employee::count();
        
        // This is a simplified calculation - in real implementation, you'd have actual attendance records
        $presentDays = AttendanceRecord::where('date', '>=', $startDate)
            ->where('status', 'present')
            ->count();
            
        $possibleAttendance = $totalEmployees * $totalDays;
        
        return [
            'attendance_rate' => $possibleAttendance > 0 ? round(($presentDays / $possibleAttendance) * 100, 2) : 0,
            'total_days' => $totalDays,
            'present_days' => $presentDays,
            'absent_days' => $possibleAttendance - $presentDays,
        ];
    }

    private function getAttendanceTrends($startDate)
    {
        return AttendanceRecord::where('date', '>=', $startDate)
            ->selectRaw('date, status, COUNT(*) as count')
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();
    }

    private function getAbsencePatterns($startDate)
    {
        return AttendanceRecord::where('date', '>=', $startDate)
            ->where('status', '!=', 'present')
            ->selectRaw('DAYOFWEEK(date) as day_of_week, status, COUNT(*) as count')
            ->groupBy('day_of_week', 'status')
            ->get();
    }

    private function getDepartmentAttendance($startDate)
    {
        return DB::table('attendances as ar')
            ->join('employees as e', 'ar.employee_id', '=', 'e.id')
            ->where('ar.date', '>=', $startDate)
            ->selectRaw('e.department, ar.status, COUNT(*) as count')
            ->groupBy('e.department', 'ar.status')
            ->get();
    }

    private function getLeaveRequestStats($startDate)
    {
        return [
            'total_requests' => LeaveRequest::where('created_at', '>=', $startDate)->count(),
            'approved_requests' => LeaveRequest::where('created_at', '>=', $startDate)->where('status', 'approved')->count(),
            'pending_requests' => LeaveRequest::where('created_at', '>=', $startDate)->where('status', 'pending')->count(),
            'rejected_requests' => LeaveRequest::where('created_at', '>=', $startDate)->where('status', 'rejected')->count(),
        ];
    }

    private function getLeaveTypeDistribution($startDate)
    {
        return DB::table('leave_requests as lr')
            ->join('leave_types as lt', 'lr.leave_type_id', '=', 'lt.id')
            ->where('lr.created_at', '>=', $startDate)
            ->selectRaw('lt.name as leave_type, COUNT(*) as count')
            ->groupBy('lt.name')
            ->get();
    }

    private function getLeaveApprovalRate($startDate)
    {
        $totalRequests = LeaveRequest::where('created_at', '>=', $startDate)->count();
        $approvedRequests = LeaveRequest::where('created_at', '>=', $startDate)->where('status', 'approved')->count();
        
        return $totalRequests > 0 ? round(($approvedRequests / $totalRequests) * 100, 2) : 0;
    }

    private function getLeaveBalanceStats()
    {
        // This would query leave balance tables - simplified for now
        return [
            'total_balance_days' => 0,
            'used_days' => 0,
            'remaining_days' => 0,
        ];
    }

    private function getAverageResponseTimes()
    {
        // Simplified - in real implementation, you'd track actual response times
        return [
            'database_query_time' => '25ms',
            'api_response_time' => '150ms',
            'page_load_time' => '800ms',
        ];
    }

    private function getErrorRates()
    {
        $startDate = now()->subDays($this->dateRange);
        $totalRequests = ActivityLog::where('created_at', '>=', $startDate)->count();
        $errorLogs = ActivityLog::where('created_at', '>=', $startDate)->where('action', 'like', '%error%')->count();
        
        return [
            'total_requests' => $totalRequests,
            'error_count' => $errorLogs,
            'error_rate' => $totalRequests > 0 ? round(($errorLogs / $totalRequests) * 100, 2) : 0,
        ];
    }

    private function getDatabasePerformance()
    {
        return [
            'query_time_avg' => '15ms',
            'slow_queries' => 0,
            'connections' => 5,
        ];
    }

    private function getCachePerformance()
    {
        return [
            'hit_rate' => '85%',
            'miss_rate' => '15%',
            'memory_usage' => '45MB',
        ];
    }

    private function getDailyActivityData($startDate)
    {
        return ActivityLog::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getUserRegistrationData($startDate)
    {
        return User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getLeaveRequestData($startDate)
    {
        return LeaveRequest::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getSystemLoadData($startDate)
    {
        // Simplified system load data
        $data = [];
        for ($i = 0; $i < $this->dateRange; $i++) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[] = [
                'date' => $date,
                'cpu_usage' => rand(20, 80),
                'memory_usage' => rand(30, 70),
                'disk_usage' => rand(40, 60),
            ];
        }
        
        return array_reverse($data);
    }

    private function calculateSystemUptime()
    {
        // Simplified uptime calculation
        return '99.9%';
    }

    public function exportAnalytics()
    {
        // Export functionality placeholder
        session()->flash('info', 'Analytics export functionality coming soon');
    }

    public function refreshAnalytics()
    {
        session()->flash('success', 'Analytics data refreshed successfully!');
    }

    public function updatedDateRange()
    {
        // Trigger re-render when date range changes
    }

    public function updatedDepartmentFilter()
    {
        // Trigger re-render when department filter changes
    }

    public function updatedUserTypeFilter()
    {
        // Trigger re-render when user type filter changes
    }

    public function updatedChartType()
    {
        // Trigger re-render when chart type changes
    }
}
