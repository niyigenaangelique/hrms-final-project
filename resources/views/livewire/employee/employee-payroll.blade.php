<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Payroll</h1>
        <p class="text-gray-600 mt-2">View your salary information, deductions, and payslips</p>
    </div>

    <!-- Employee Information Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Personal Details</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Name:</span>
                            <span class="text-sm font-medium">{{ $employee->full_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Employee ID:</span>
                            <span class="text-sm font-medium">{{ $employee->code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Email:</span>
                            <span class="text-sm font-medium">{{ $employee->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Phone:</span>
                            <span class="text-sm font-medium">{{ $employee->phone_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Hire Date:</span>
                            <span class="text-sm font-medium">{{ $employee->join_date?->format('M d, Y') ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Identification</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">National ID:</span>
                            <span class="text-sm font-medium">{{ $employee->national_id ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">RSS Number:</span>
                            <span class="text-sm font-medium">{{ $employee->rss_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Passport:</span>
                            <span class="text-sm font-medium">{{ $employee->passport_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Nationality:</span>
                            <span class="text-sm font-medium">{{ $employee->nationality ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Position</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Department:</span>
                            <span class="text-sm font-medium">{{ $employee->department?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Position:</span>
                            <span class="text-sm font-medium">{{ $employee->position?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="text-sm font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Month Payroll Summary -->
    @if($currentPayrollEntry)
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Current Month Payroll - {{ $currentPayrollEntry->payrollMonth->name ?? 'Current Period' }}</h2>
                    <div class="text-right">
                        <span class="text-sm text-gray-500">Net Pay</span>
                        <p class="text-2xl font-bold text-green-600">${{ formatCurrency($netPay) }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-900">Daily Rate</p>
                                <p class="text-lg font-semibold text-blue-600">${{ formatCurrency($currentPayrollEntry->daily_rate) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-900">Work Days Pay</p>
                                <p class="text-lg font-semibold text-green-600">${{ formatCurrency($currentPayrollEntry->work_days_pay) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-purple-900">Overtime</p>
                                <p class="text-lg font-semibold text-purple-600">${{ formatCurrency($currentPayrollEntry->overtime_total_amount) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-orange-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-orange-900">Total Deductions</p>
                                <p class="text-lg font-semibold text-orange-600">${{ formatCurrency($totalDeductions) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Breakdown -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Earnings Breakdown -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Earnings Breakdown</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Work Days ({{ $currentPayrollEntry->work_days }} days)</span>
                                <span class="text-sm font-medium">${{ formatCurrency($currentPayrollEntry->work_days_pay) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Overtime ({{ $currentPayrollEntry->overtime_hours_worked }} hrs @ ${{ formatCurrency($currentPayrollEntry->overtime_hour_rate) }}/hr)</span>
                                <span class="text-sm font-medium">${{ formatCurrency($currentPayrollEntry->overtime_total_amount) }}</span>
                            </div>
                            @if($totalBenefits > 0)
                                <div class="flex justify-between text-green-600">
                                    <span class="text-sm">Total Benefits</span>
                                    <span class="text-sm font-medium">+${{ formatCurrency($totalBenefits) }}</span>
                                </div>
                            @endif
                            <div class="border-t pt-2">
                                <div class="flex justify-between font-semibold">
                                    <span class="text-sm">Gross Pay</span>
                                    <span class="text-sm">${{ formatCurrency($currentPayrollEntry->work_days_pay + $currentPayrollEntry->overtime_total_amount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions Breakdown -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Deductions Breakdown</h3>
                        @if($currentPayrollEntry->deductionEntries->count() > 0)
                            <div class="space-y-2">
                                @foreach($currentPayrollEntry->deductionEntries as $deduction)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">{{ $deduction->deduction->name }}</span>
                                        <span class="text-sm font-medium">${{ formatCurrency($deduction->amount) }}</span>
                                    </div>
                                @endforeach
                                <div class="border-t pt-2">
                                    <div class="flex justify-between font-semibold">
                                        <span class="text-sm">Total Deductions</span>
                                        <span class="text-sm">${{ formatCurrency($totalDeductions) }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No deductions for this period</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payroll data for current period</h3>
                    <p class="mt-1 text-sm text-gray-500">Payroll information will be available once processed.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Work Hours and Leave Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Attendances -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Attendance (Last 30 Days)</h3>
                @if($recentAttendances->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Clock In</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Clock Out</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hours</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentAttendances as $attendance)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $attendance->date->format('M d') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $attendance->check_in ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $attendance->check_out ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm">
                                            @if($attendance->check_in && $attendance->check_out)
                                                {{ Carbon::parse($attendance->check_in)->diffInHours(Carbon::parse($attendance->check_out)) }}h
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No attendance records found</p>
                @endif
            </div>
        </div>

        <!-- Leave Balances -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Balances</h3>
                @if($leaveBalances->count() > 0)
                    <div class="space-y-3">
                        @foreach($leaveBalances as $balance)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($balance->leave_type) }}</p>
                                    <p class="text-xs text-gray-500">{{ $balance->year }} Year</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-900">{{ $balance->remaining_days }} days</p>
                                    <p class="text-xs text-gray-500">of {{ $balance->total_days }} total</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No leave balance information available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Payroll History -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Payroll History</h3>
            @if($payrollEntries->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Work Days Pay</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Overtime</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deductions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Pay</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payrollEntries as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $entry->payrollMonth->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">${{ formatCurrency($entry->work_days_pay) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">${{ formatCurrency($entry->overtime_total_amount) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">${{ formatCurrency($entry->deductionEntries->sum('amount')) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">${{ formatCurrency($entry->total_amount - $entry->deductionEntries->sum('amount')) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($entry->status->value === 'processed') bg-green-100 text-green-800
                                            @elseif($entry->status->value === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($entry->status->value) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($entry->payslipEntry)
                                            <button class="text-blue-600 hover:text-blue-900 font-medium">View Payslip</button>
                                        @else
                                            <span class="text-gray-400">Not Available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payroll history</h3>
                    <p class="mt-1 text-sm text-gray-500">Your payroll information will appear here once processed.</p>
                </div>
            @endif
        </div>
    </div>
</div>
