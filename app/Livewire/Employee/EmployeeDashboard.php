<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Contract;
use App\Models\Attendance;
use App\Models\Message;
use App\Models\Holiday;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Employee Dashboard')]
class EmployeeDashboard extends Component
{
    public $employee;
    public $leaveRequests;
    public $contracts;
    public $attendances;
    public $upcomingHolidays;
    public $recentActivities;
    public $notifications;
    
    // New data for enhanced dashboard
    public $dailyTasks;
    public $recentMessages;
    public $calendarDays;
    public $announcements;
    public $upcomingEvents;
    public $quickStats;

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
        
        // Get the employee record for current user
        $this->employee = Employee::where('user_id', $user->id)->first();
        
        if (!$this->employee) {
            // Create a sample employee for logged-in user with a unique code
            $nextNumber = 1;
            
            // Find the next available employee code
            do {
                $newCode = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $exists = Employee::where('code', $newCode)->exists();
                $nextNumber++;
            } while ($exists);
            
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

        // Load existing data
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

        // Load new dashboard features
        $this->loadDailyTasks();
        $this->loadRecentMessages();
        $this->loadCalendarData();
        $this->loadAnnouncements();
        $this->loadUpcomingEvents();
        $this->loadQuickStats();

        // Load notifications (using a collection for now)
        $this->notifications = collect([
            ['title' => 'Contract Renewal', 'message' => 'Your contract is expiring soon', 'read' => false],
            ['title' => 'Leave Approved', 'message' => 'Your leave request has been approved', 'read' => false],
            ['title' => 'New Policy', 'message' => 'Company policy updated', 'read' => true],
        ]);

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

    public function loadDailyTasks()
    {
        // Load today's tasks for the employee
        $today = Carbon::today();
        
        // Since we don't have a Task model, create sample data
        $this->dailyTasks = collect([
            [
                'id' => 1,
                'title' => 'Complete project proposal',
                'description' => 'Finish the Q4 project proposal document',
                'priority' => 'high',
                'due_time' => '14:00',
                'completed' => false,
                'category' => 'work'
            ],
            [
                'id' => 2,
                'title' => 'Team meeting',
                'description' => 'Weekly sync with development team',
                'priority' => 'medium',
                'due_time' => '16:00',
                'completed' => false,
                'category' => 'meeting'
            ],
            [
                'id' => 3,
                'title' => 'Review code changes',
                'description' => 'Review pull requests from team members',
                'priority' => 'medium',
                'due_time' => '17:30',
                'completed' => true,
                'category' => 'development'
            ],
        ]);
    }

    public function loadRecentMessages()
    {
        // Load real messages for the employee
        $this->recentMessages = Message::where('receiver_id', Auth::id())
            ->with(['sender'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($message) {
                $senderName = $message->sender ? 
                    ($message->sender->first_name . ' ' . $message->sender->last_name) : 
                    'Unknown Sender';
                
                $senderInitials = $message->sender ? 
                    (substr($message->sender->first_name, 0, 1) . substr($message->sender->last_name, 0, 1)) : 
                    'UN';
                
                return [
                    'id' => $message->id,
                    'sender' => $senderName,
                    'subject' => $message->subject,
                    'message' => $message->message,
                    'time' => $message->created_at->diffForHumans(),
                    'read' => $message->is_read,
                    'avatar' => strtoupper($senderInitials),
                    'created_at' => $message->created_at
                ];
            });
    }

    public function loadCalendarData()
    {
        // Generate calendar days for current month
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        
        $this->calendarDays = [];
        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = Carbon::create($year, $month, 1)->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek(Carbon::MONDAY);
        $endDate = $lastDay->copy()->endOfWeek(Carbon::SUNDAY);
        
        // Load holidays for this month
        $holidays = Holiday::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orWhere('is_recurring', true)
            ->get();
        
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $isCurrentMonth = $current->month === $month;
            $isToday = $current->isToday();
            
            // Check if this date has holidays
            $hasEvents = $holidays->contains('date', $current->format('Y-m-d'));
            
            $this->calendarDays[] = [
                'date' => $current->day,
                'is_current_month' => $isCurrentMonth,
                'is_today' => $isToday,
                'has_events' => $hasEvents,
                'full_date' => $current->format('Y-m-d')
            ];
            
            $current->addDay();
        }
    }

    public function loadAnnouncements()
    {
        // Use ActivityLog as announcements for system activities
        $this->announcements = ActivityLog::where('module', 'system')
            ->orWhere('module', 'announcement')
            ->orWhere('action', 'create')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($activity) {
                $priority = 'medium';
                if ($activity->action === 'delete' || $activity->action === 'failed_login') {
                    $priority = 'high';
                } elseif ($activity->action === 'login' || $activity->action === 'update') {
                    $priority = 'low';
                }
                
                return [
                    'id' => $activity->id,
                    'title' => ucwords(str_replace('_', ' ', $activity->action)) . ' - ' . ucfirst($activity->module),
                    'content' => $activity->description,
                    'priority' => $priority,
                    'posted_at' => $activity->created_at->diffForHumans(),
                    'author' => 'System',
                    'created_at' => $activity->created_at
                ];
            });
        
        // If no system activities, create some default announcements
        if ($this->announcements->isEmpty()) {
            $this->announcements = collect([
                [
                    'id' => 1,
                    'title' => 'Welcome to TalentFlow Pro',
                    'content' => 'Your employee dashboard is now ready. Explore all the features available.',
                    'priority' => 'medium',
                    'posted_at' => 'Just now',
                    'author' => 'System'
                ]
            ]);
        }
    }

    public function loadUpcomingEvents()
    {
        // Load upcoming holidays as events
        $this->upcomingEvents = Holiday::where('date', '>=', Carbon::today())
            ->orderBy('date', 'asc')
            ->take(5)
            ->get()
            ->map(function ($holiday) {
                $eventType = 'holiday';
                $location = 'Company-wide';
                
                // Determine event type based on holiday name
                if (stripos($holiday->name, 'meeting') !== false || stripos($holiday->name, 'review') !== false) {
                    $eventType = 'meeting';
                    $location = 'Office';
                } elseif (stripos($holiday->name, 'training') !== false || stripos($holiday->name, 'workshop') !== false) {
                    $eventType = 'training';
                    $location = 'Training Room';
                } elseif (stripos($holiday->name, 'event') !== false || stripos($holiday->name, 'celebration') !== false) {
                    $eventType = 'event';
                    $location = 'Company Premises';
                }
                
                return [
                    'id' => $holiday->id,
                    'title' => $holiday->name,
                    'date' => $holiday->date->format('Y-m-d'),
                    'time' => 'All Day',
                    'type' => $eventType,
                    'location' => $location,
                    'description' => $holiday->description
                ];
            });
        
        // If no upcoming holidays, add some default events
        if ($this->upcomingEvents->isEmpty()) {
            $this->upcomingEvents = collect([
                [
                    'id' => 1,
                    'title' => 'Team Meeting',
                    'date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                    'time' => '10:00',
                    'type' => 'meeting',
                    'location' => 'Conference Room'
                ],
                [
                    'id' => 2,
                    'title' => 'Performance Review',
                    'date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                    'time' => '14:00',
                    'type' => 'meeting',
                    'location' => 'Office'
                ]
            ]);
        }
    }

    public function loadQuickStats()
    {
        // Calculate quick statistics
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        
        // Get real attendance data for this month - count records with check-in times
        $monthStart = Carbon::create($thisYear, $thisMonth, 1);
        $presentDays = Attendance::where('employee_id', $this->employee->id)
            ->where('date', '>=', $monthStart->format('Y-m-d'))
            ->whereNotNull('check_in')
            ->count();
            
        $pendingLeaves = $this->leaveRequests->where('status', 'pending')->count();
        
        // Count both approved and active contracts
        $activeContracts = $this->contracts->filter(function($contract) {
            return in_array($contract->status->value, ['approved', 'active']);
        })->count();
        
        $unreadMessages = $this->recentMessages->where('read', false)->count();
        
        $this->quickStats = [
            'present_days' => $presentDays,
            'pending_leaves' => $pendingLeaves,
            'active_contracts' => $activeContracts,
            'unread_messages' => $unreadMessages,
            'tasks_completed' => $this->dailyTasks->where('completed', true)->count(),
            'total_tasks' => $this->dailyTasks->count()
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
