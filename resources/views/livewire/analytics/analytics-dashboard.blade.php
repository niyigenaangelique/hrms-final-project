<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">HR Analytics Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Comprehensive HR metrics and insights</p>
            </div>
            <div class="flex space-x-3">
                <select
                    wire:model.live="selectedPeriod"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="quarter">This Quarter</option>
                    <option value="year">This Year</option>
                </select>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Export Report
                </button>
            </div>
        </div>
    </div>

    <!-- Period Display -->
    <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="text-blue-800 dark:text-blue-200">
                <span class="font-semibold">Period:</span>
                <span class="ml-2">{{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</span>
            </div>
            <div class="text-blue-800 dark:text-blue-200">
                <span class="font-semibold">Selected:</span>
                <span class="ml-2 capitalize">{{ $selectedPeriod }}</span>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 003-3H5a3 3 0 00-3 3v2m0 0V5a2 2 0 012 2h6l2 2h2a2 2 0 012-2v-2a2 2 0 00-2-2H9a2 2 0 00-2-2V5a2 2 0 00-2-2H5a2 2 0 00-2-2v-2z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Employees</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $metrics['total_employees'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-9-3h9m-9-3v3m0 0v3m0 0h-9m-9 6h9m-9-6h9m-9-6v9m9 6v9m9-6v-9m-9-9h9m-9 9h-9"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">New Hires</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $metrics['new_hires'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Contracts</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $metrics['active_contracts'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Avg Tenure</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($metrics['avg_tenure'], 1) }} years</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Turnover Rate Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Turnover Rate Analysis</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Turnover Rate</span>
                    <span class="text-2xl font-bold {{ $turnoverRate['rate'] > 10 ? 'text-red-600' : 'text-green-600' }} dark:text-white">
                        {{ $turnoverRate['rate'] }}%
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Separated:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $turnoverRate['total_separated'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Total Employees:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $turnoverRate['total_employees'] }}</span>
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <div class="mb-2">Turnover Rate by Period:</div>
                        <div class="space-y-1">
                            <div class="flex justify-between">
                                <span>{{ $turnoverRate['period'] }}:</span>
                                <span class="font-medium">{{ $turnoverRate['rate'] }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diversity Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Diversity Statistics</h3>
            <div class="space-y-4">
                <!-- Gender Distribution -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gender Distribution</h4>
                    <div class="space-y-2">
                        @foreach($diversityStats['gender_distribution'] as $gender => $count)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($gender) }}</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($count / $diversityStats['gender_distribution']->sum()) * 100 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Age Groups -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Age Groups</h4>
                    <div class="space-y-2">
                        @foreach($diversityStats['age_groups'] as $ageGroup => $count)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $ageGroup }}</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($count / $diversityStats['age_groups']->sum()) * 100 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skill Gap Analysis -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Skill Gap Analysis</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Overall Gap Score -->
            <div class="text-center">
                <div class="text-4xl font-bold {{ $skillGapAnalysis['overall_gap_score'] > 20 ? 'text-red-600' : 'text-yellow-600' }} dark:text-white">
                    {{ $skillGapAnalysis['overall_gap_score'] }}%
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Overall Skill Gap</div>
            </div>

            <!-- Critical Gaps -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Critical Gaps</h4>
                <div class="space-y-2">
                    @if(!empty($skillGapAnalysis['critical_gaps']))
                        @foreach($skillGapAnalysis['critical_gaps'] as $gap)
                            <div class="flex items-center justify-between bg-red-50 dark:bg-red-900 rounded p-2">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $gap['skill'] }}</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ $gap['category'] }}</div>
                                </div>
                                <span class="text-sm font-semibold text-red-600 dark:text-red-400">{{ $gap['gap_percentage'] }}%</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No critical gaps identified</p>
                    @endif
                </div>
            </div>

            <!-- Training Recommendations -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Training Recommendations</h4>
                <div class="space-y-2">
                    @foreach($skillGapAnalysis['training_recommendations'] as $training)
                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $training['title'] }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ $training['target'] }} • {{ $training['duration'] }}</div>
                            <span class="inline-block px-2 py-1 text-xs rounded 
                                @if($training['priority'] === 'high') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                @elseif($training['priority'] === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @endif">
                                {{ $training['priority'] }} priority
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Performance & Attendance Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Performance Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance Statistics</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Average Score</span>
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        {{ number_format($performanceStats['average_score'], 1) }}/5.0
                    </span>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Performance Distribution</h4>
                    <div class="space-y-2">
                        @foreach($performanceStats['performance_distribution'] as $rating => $count)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ $rating }}</span>
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($count / array_sum($performanceStats['performance_distribution'])) * 100 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Top Performers</h4>
                    <div class="space-y-1">
                        @foreach(array_slice($performanceStats['top_performers'], 0, 3) as $performer)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-900 dark:text-white">{{ $performer['name'] }}</span>
                                <span class="font-medium text-green-600 dark:text-green-400">{{ number_format($performer['score'], 1) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Attendance Statistics</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Attendance Rate</span>
                    <span class="text-2xl font-bold {{ $attendanceStats['attendance_rate'] > 90 ? 'text-green-600' : ($attendanceStats['attendance_rate'] > 75 ? 'text-yellow-600' : 'text-red-600') }} dark:text-white">
                        {{ $attendanceStats['attendance_rate'] }}%
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Absenteeism Rate</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $attendanceStats['absenteeism_rate'] }}%</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Late Arrivals</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $attendanceStats['late_arrivals'] }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Early Departures</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $attendanceStats['early_departures'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Present Today</span>
                        <span class="font-medium text-green-600 dark:text-green-400">
                            {{ Employee::where('is_active', true)->count() - $attendanceStats['late_arrivals'] - $attendanceStats['early_departures'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Statistics -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    {{ $leaveStats['total_leave_requests'] }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Requests</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                    {{ $leaveStats['approved_leaves'] }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Approved</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                    {{ $leaveStats['pending_leaves'] }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Pending</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                    {{ number_format($leaveStats['average_leave_days'], 1) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Avg Days</div>
            </div>
        </div>
    </div>
</div>
