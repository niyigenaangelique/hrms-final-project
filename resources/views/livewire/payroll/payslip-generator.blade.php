<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payslip Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Generate and manage employee payslips</p>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="selectedPayrollMonth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Payroll Month
                </label>
                <select
                    id="selectedPayrollMonth"
                    wire:model.live="selectedPayrollMonth"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    <option value="">All Months</option>
                    @foreach(\App\Models\PayrollMonth::orderBy('start_date', 'desc')->get() as $month)
                        <option value="{{ $month->id }}">{{ $month->name }} ({{ $month->start_date->format('M Y') }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="selectedEmployee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Employee
                </label>
                <select
                    id="selectedEmployee"
                    wire:model.live="selectedEmployee"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 flex space-x-3">
            <button
                wire:click="bulkGeneratePayslips"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Generate All Payslips
            </button>
        </div>
    </div>

    <!-- Payroll Entries Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Payroll Entries</h2>
        </div>
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payroll Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gross Pay</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Net Pay</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payslip Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($payrollEntries as $entry)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $entry->employee->first_name }} {{ $entry->employee->last_name }}
                                <div class="text-gray-500 dark:text-gray-400">{{ $entry->employee->employee_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $entry->payrollMonth->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                ${{ number_format($entry->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($entry->payslipEntry)
                                    ${{ number_format($entry->payslipEntry->net_pay, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($entry->payslipEntry)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        Generated
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        Not Generated
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @if(!$entry->payslipEntry)
                                    <button
                                        wire:click="generatePayslip('{{ $entry->id }}')"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                    >
                                        Generate
                                    </button>
                                @else
                                    <button
                                        wire:click="previewPayslip('{{ $entry->id }}')"
                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                    >
                                        Preview
                                    </button>
                                    <button
                                        wire:click="downloadPayslip('{{ $entry->id }}')"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                    >
                                        Download
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payslip Preview Modal -->
    @if($payslipData)
        <div x-data="{ show: false }" x-show="show" x-init="$watch('show', (value) => { if (value) $dispatch('showPayslipPreview') })" style="display: none;">
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payslip Preview</h3>
                                    
                                    <!-- Payslip Content -->
                                    <div class="border border-gray-200 rounded-lg p-6">
                                        <!-- Header -->
                                        <div class="text-center mb-6">
                                            <h1 class="text-2xl font-bold">ZIBITECH</h1>
                                            <p class="text-gray-600">Payslip for {{ $payslipData->payrollMonth->name }}</p>
                                        </div>

                                        <!-- Employee Info -->
                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div>
                                                <h4 class="font-semibold">Employee Details</h4>
                                                <p>{{ $payslipData->employee->first_name }} {{ $payslipData->employee->last_name }}</p>
                                                <p>Employee No: {{ $payslipData->employee->employee_number }}</p>
                                                <p>Department: {{ $payslipData->employee->department->name ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold">Pay Period</h4>
                                                <p>{{ $payslipData->payrollMonth->start_date->format('M d, Y') }} - {{ $payslipData->payrollMonth->end_date->format('M d, Y') }}</p>
                                                <p>Pay Date: {{ now()->format('M d, Y') }}</p>
                                            </div>
                                        </div>

                                        <!-- Earnings -->
                                        <div class="mb-6">
                                            <h4 class="font-semibold mb-2">Earnings</h4>
                                            <table class="w-full text-sm">
                                                <tr>
                                                    <td>Basic Salary</td>
                                                    <td class="text-right">${{ number_format($payslipData->work_days_pay, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Overtime</td>
                                                    <td class="text-right">${{ number_format($payslipData->overtime_total_amount, 2) }}</td>
                                                </tr>
                                                <tr class="font-semibold border-t">
                                                    <td>Gross Pay</td>
                                                    <td class="text-right">${{ number_format($payslipData->total_amount, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Deductions -->
                                        <div class="mb-6">
                                            <h4 class="font-semibold mb-2">Deductions</h4>
                                            <table class="w-full text-sm">
                                                <tr>
                                                    <td>PAYE Tax</td>
                                                    <td class="text-right">${{ number_format($payslipData->payslipEntry->paye, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pension</td>
                                                    <td class="text-right">${{ number_format($payslipData->payslipEntry->pension, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Maternity</td>
                                                    <td class="text-right">${{ number_format($payslipData->payslipEntry->maternity, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>CBHI</td>
                                                    <td class="text-right">${{ number_format($payslipData->payslipEntry->cbhi, 2) }}</td>
                                                </tr>
                                                <tr class="font-semibold border-t">
                                                    <td>Total Deductions</td>
                                                    <td class="text-right">${{ number_format($payslipData->payslipEntry->paye + $payslipData->payslipEntry->pension + $payslipData->payslipEntry->maternity + $payslipData->payslipEntry->cbhi, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Net Pay -->
                                        <div class="border-t-2 border-gray-800 pt-4">
                                            <div class="flex justify-between text-lg font-bold">
                                                <span>Net Pay</span>
                                                <span>${{ number_format($payslipData->payslipEntry->net_pay, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="button"
                                wire:click="downloadPayslip('{{ $payslipData->id }}')"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Download PDF
                            </button>
                            <button
                                type="button"
                                onclick="window.dispatchEvent(new CustomEvent('closePayslipPreview'))"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.addEventListener('showPayslipPreview', () => {
                document.querySelector('[x-data="{ show: false }"]').setAttribute('x-show', 'true');
            });
            window.addEventListener('closePayslipPreview', () => {
                document.querySelector('[x-data="{ show: false }"]').setAttribute('x-show', 'false');
            });
        </script>
    @endif
</div>
