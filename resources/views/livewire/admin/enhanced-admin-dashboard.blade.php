<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">System overview and quick actions</p>
    </div>

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="admin-dashboard-card stats-card-gradient-1">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 stat-icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-white opacity-90 truncate">Total Employees</dt>
                            <dd class="text-lg font-medium text-white">{{ $stats['total_employees'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-dashboard-card stats-card-gradient-2">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 stat-icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-white opacity-90 truncate">Monthly Payroll</dt>
                            <dd class="text-lg font-medium text-white">${{ number_format($stats['monthly_payroll'] ?? 0, 0) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-dashboard-card stats-card-gradient-3">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 stat-icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-white opacity-90 truncate">Pending Leaves</dt>
                            <dd class="text-lg font-medium text-white">{{ $stats['pending_leaves'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-dashboard-card stats-card-gradient-4">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 stat-icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-white opacity-90 truncate">Avg Performance</dt>
                            <dd class="text-lg font-medium text-white">{{ $stats['avg_performance'] ?? 0 }}%</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Department Distribution -->
        <div class="admin-dashboard-card p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Department Distribution</h3>
            <div class="chart-placeholder h-64 flex items-center justify-center rounded">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Department chart will be displayed here</p>
                </div>
            </div>
        </div>

        <!-- Weekly Attendance -->
        <div class="admin-dashboard-card p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Weekly Attendance</h3>
            <div class="chart-placeholder h-64 flex items-center justify-center rounded">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Weekly attendance chart will be displayed here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Type Chart -->
    <div class="admin-dashboard-card p-6 mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Type Distribution</h3>
        <div class="chart-placeholder h-64 flex items-center justify-center rounded">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">Employee type chart will be displayed here</p>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Recent Activities and Upcoming Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Activities -->
        <div class="admin-dashboard-card p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h3>
            <div class="space-y-4">
                @forelse($activityLogs->take(5) as $activity)
                    <div class="activity-item">
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">{{ $activity->description ?? 'System activity' }}</p>
                            <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent activities</p>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="admin-dashboard-card p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Tasks</h3>
            <div class="space-y-4">
                <div class="activity-item">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Process monthly payroll</p>
                        <p class="text-xs text-gray-500">Due in 3 days</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Review pending leave requests</p>
                        <p class="text-xs text-gray-500">{{ $stats['pending_leaves'] }} requests pending</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Complete performance reviews</p>
                        <p class="text-xs text-gray-500">12 reviews remaining</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-dashboard-card p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button wire:click="openCreateEmployeeModal" class="quick-action-card">
                <div class="icon-wrapper">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <span class="text-sm font-medium">Add Employee</span>
            </button>
            <button wire:click="processPayroll" class="quick-action-card">
                <div class="icon-wrapper">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <span class="text-sm font-medium">Process Payroll</span>
            </button>
            <button wire:click="reviewLeaves" class="quick-action-card">
                <div class="icon-wrapper">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-sm font-medium">Review Leaves</span>
            </button>
            <button wire:click="performanceReview" class="quick-action-card">
                <div class="icon-wrapper">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="text-sm font-medium">Performance Review</span>
            </button>
        </div>
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