<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">HR Payroll Dashboard</h1>
                <p class="text-gray-600 mt-2">Process employee payroll and manage payments</p>
            </div>
            <div class="flex space-x-4">
                <button wire:click="openProcessModal" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-users-cog mr-2"></i>Process Payroll
                </button>
                <button wire:click="openBulkProcessModal" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    <i class="fas fa-users mr-2"></i>Bulk Process All
                </button>
                <button wire:click="generatePayslips" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                    <i class="fas fa-file-invoice mr-2"></i>Generate Payslips
                </button>
                <select wire:model.live="selectedMonth" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}">{{ Carbon\Carbon::createFromDate(null, $month, 1)->format('F') }}</option>
                    @endfor
                </select>
                <select wire:model.live="selectedYear" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($year = now()->year - 2; $year <= now()->year + 1; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Payroll</dt>
                        <dd class="text-lg font-semibold text-gray-900">${{ number_format($totalPayrollAmount, 2) }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Employees</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $totalEmployees }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Payments</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $pendingPayments }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Completed Payments</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $completedPayments }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Overview and Comparison -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Current Month Payroll -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                {{ Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1)->format('F Y') }} Payroll
            </h2>
            <div class="text-3xl font-bold text-blue-600">
                ${{ number_format($monthlyComparison['current'], 2) }}
            </div>
            <div class="mt-2 flex items-center">
                @if($monthlyComparison['change'] > 0)
                    <i class="fas fa-arrow-up text-green-500 mr-2"></i>
                    <span class="text-green-600 text-sm">+{{ number_format($monthlyComparison['change'], 1) }}% from previous month</span>
                @elseif($monthlyComparison['change'] < 0)
                    <i class="fas fa-arrow-down text-red-500 mr-2"></i>
                    <span class="text-red-600 text-sm">{{ number_format($monthlyComparison['change'], 1) }}% from previous month</span>
                @else
                    <i class="fas fa-minus text-gray-500 mr-2"></i>
                    <span class="text-gray-600 text-sm">No change from previous month</span>
                @endif
            </div>
        </div>

        <!-- Department Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Department Overview</h2>
            <div class="space-y-4">
                @if($departmentStats)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $departmentStats->department }}</span>
                        <span class="font-semibold text-gray-900">{{ $departmentStats->employee_count }} employees</span>
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Avg. Salary</span>
                    <span class="font-semibold text-gray-900">
                        ${{ number_format($totalEmployees > 0 ? $totalPayrollAmount / $totalEmployees : 0, 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Payroll Entries</span>
                    <span class="font-semibold text-gray-900">{{ $totalPayrollEntries }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Payrolls -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Upcoming Payroll Periods</h2>
        </div>
        <div class="p-6">
            @if($upcomingPayrolls->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingPayrolls as $payroll)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-900">{{ $payroll->name }}</div>
                                <div class="text-sm text-gray-600">
                                    {{ Carbon\Carbon::parse($payroll->start_date)->format('M d') }} - 
                                    {{ Carbon\Carbon::parse($payroll->end_date)->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">{{ $payroll->payrollEntries->count() }} employees</div>
                                <div class="font-semibold text-gray-900">
                                    ${{ number_format($payroll->payrollEntries->sum('total_amount'), 2) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-calendar-times text-4xl mb-3"></i>
                    <p>No upcoming payroll periods</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Payments</h2>
        </div>
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentPayments as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $payment->employee->first_name }} {{ $payment->employee->last_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($payment->amount_paid, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ ucfirst($payment->payment_method ?? 'bank') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($payment->status->value === 'completed') bg-green-100 text-green-800
                                    @elseif($payment->status->value === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($payment->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payroll Trends Chart -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Payroll Trends (Last 6 Months)</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($payrollTrends as $trend)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-900">
                                {{ Carbon\Carbon::createFromDate($trend->year, $trend->month, 1)->format('F Y') }}
                            </span>
                            <span class="text-xs text-gray-500">({{ $trend->count }} entries)</span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-semibold text-gray-900">
                                ${{ number_format($trend->total, 2) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Process Payroll Modal -->
    @if($showProcessModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Process Employee Payroll</h3>
                    <button wire:click="$showProcessModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- Select Payroll Month -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Payroll Month</label>
                        <select wire:model.live="processingMonth.id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500">
                            <option value="">Select a payroll month</option>
                            @foreach($upcomingPayrolls as $payroll)
                                <option value="{{ $payroll->id }}">{{ $payroll->name }} ({{ Carbon\Carbon::parse($payroll->start_date)->format('M Y') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Employees -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Employees</label>
                        <div class="border border-gray-300 rounded-md p-4 max-h-40 overflow-y-auto">
                            @foreach(App\Models\Employee::where('approval_status', 'approved')->get() as $employee)
                                <div class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                    <input type="checkbox" wire:model="processingEmployees.{{ $employee->id }}" 
                                           class="mr-3 h-4 w-4 text-blue-600 rounded focus:ring-blue-500">
                                    <label class="sr-only">{{ $employee->first_name }} {{ $employee->last_name }}</label>
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</span>
                                        <span class="text-sm text-gray-500">{{ $employee->code }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Processing Status -->
                    @if($processingStatus === 'processing')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-blue-700">Processing payroll...</span>
                                <span class="text-sm text-blue-600">{{ $processedCount }} / {{ $totalCount }}</span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $processingProgress }}%"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button wire:click="$showProcessModal = false" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button wire:click="processPayroll" 
                                :disabled="$processingStatus === 'processing'"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-cog mr-2"></i>
                            {{ $processingStatus === 'processing' ? 'Processing...' : 'Process Payroll' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bulk Process Modal -->
    @if($showBulkProcessModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Bulk Process All Employees</h3>
                    <button wire:click="$showBulkProcessModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- Payroll Month Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Payroll Month</label>
                        <select wire:model.live="processingMonth.id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500">
                            <option value="">Select a payroll month</option>
                            @foreach($upcomingPayrolls as $payroll)
                                <option value="{{ $payroll->id }}">{{ $payroll->name }} ({{ Carbon\Carbon::parse($payroll->start_date)->format('M Y') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Processing Status -->
                    @if($processingStatus === 'processing')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-blue-700">Processing all employees...</span>
                                <span class="text-sm text-blue-600">{{ $processedCount }} / {{ $totalCount }}</span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $processingProgress }}%"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button wire:click="$showBulkProcessModal = false" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button wire:click="bulkProcessAllEmployees" 
                                :disabled="$processingStatus === 'processing'"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-users mr-2"></i>
                            {{ $processingStatus === 'processing' ? 'Processing...' : 'Bulk Process All' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
