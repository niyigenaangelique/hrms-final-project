<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">System Analytics</h1>
        <p class="text-gray-600 mt-2">View system performance and usage analytics</p>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" wire:model.live.debounce.250ms="startDate" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" wire:model.live.debounce.250ms="endDate" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex items-end">
                <button wire:click="applyDateFilter" 
                        class="px-4 py-2 bg-white text-black rounded hover:bg-blue-50 hover:border-blue-300 border border-transparent">
                    Apply Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Total Users</div>
                <div class="text-2xl font-bold text-gray-900">{{ $analytics['total_users'] ?? 0 }}</div>
                <div class="text-sm text-green-600">+{{ $analytics['user_growth'] ?? 0 }}% this month</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Total Employees</div>
                <div class="text-2xl font-bold text-gray-900">{{ $analytics['total_employees'] ?? 0 }}</div>
                <div class="text-sm text-green-600">+{{ $analytics['employee_growth'] ?? 0 }}% this month</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Active Sessions</div>
                <div class="text-2xl font-bold text-gray-900">{{ $analytics['active_sessions'] ?? 0 }}</div>
                <div class="text-sm text-blue-600">Currently online</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">System Load</div>
                <div class="text-2xl font-bold text-gray-900">{{ $analytics['system_load'] ?? 0 }}%</div>
                <div class="text-sm text-yellow-600">Average load</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- User Registration Chart -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">User Registration Trend</h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
                <div class="text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-2">User registration chart would be displayed here</p>
                    <p class="text-sm">Last 30 days: {{ $analytics['new_users_30_days'] ?? 0 }} new users</p>
                </div>
            </div>
        </div>

        <!-- Attendance Analytics -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Attendance Analytics</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Present Today</span>
                    <span class="text-sm font-medium text-green-600">{{ $analytics['attendance_present'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Absent Today</span>
                    <span class="text-sm font-medium text-red-600">{{ $analytics['attendance_absent'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">On Leave</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $analytics['attendance_leave'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Attendance Rate</span>
                    <span class="text-sm font-medium text-blue-600">{{ $analytics['attendance_rate'] ?? 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Distribution -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Department Distribution</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
                <div class="text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <p class="mt-2">Department distribution chart would be displayed here</p>
                </div>
            </div>
            <div class="space-y-2">
                @forelse($analytics['department_stats'] ?? [] as $department)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                        <span class="text-sm text-gray-700">{{ $department['name'] }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $department['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $department['count'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-sm text-gray-500 py-4">No department data available</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Leave Analytics -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Analytics</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $analytics['pending_leaves'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Pending Leaves</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $analytics['approved_leaves'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Approved Leaves</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $analytics['rejected_leaves'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Rejected Leaves</div>
            </div>
        </div>
    </div>

    <!-- System Performance -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">System Performance</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <div class="text-sm text-gray-600">CPU Usage</div>
                <div class="text-lg font-medium text-gray-900">{{ $analytics['cpu_usage'] ?? 0 }}%</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $analytics['cpu_usage'] ?? 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="text-sm text-gray-600">Memory Usage</div>
                <div class="text-lg font-medium text-gray-900">{{ $analytics['memory_usage'] ?? 0 }}%</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $analytics['memory_usage'] ?? 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="text-sm text-gray-600">Disk Usage</div>
                <div class="text-lg font-medium text-gray-900">{{ $analytics['disk_usage'] ?? 0 }}%</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                    <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $analytics['disk_usage'] ?? 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="text-sm text-gray-600">Response Time</div>
                <div class="text-lg font-medium text-gray-900">{{ $analytics['response_time'] ?? 0 }}ms</div>
                <div class="text-sm text-green-600">Good</div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent System Activities</h3>
        <div class="space-y-3">
            @forelse($analytics['recent_activities'] ?? [] as $activity)
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full"></div>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm text-gray-900">{{ $activity['description'] }}</div>
                        <div class="text-xs text-gray-500">{{ $activity['time'] }} by {{ $activity['user'] }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-gray-500 py-4">No recent activities</div>
            @endforelse
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex space-x-3">
        <button wire:click="exportAnalytics" 
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Export Report
        </button>
        <button wire:click="refreshAnalytics" 
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Refresh Data
        </button>
        <button wire:click="scheduleReport" 
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Schedule Report
        </button>
    </div>

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
