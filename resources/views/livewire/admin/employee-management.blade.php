<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Employee Management</h1>
        <p class="text-gray-600 mt-2">Manage employee records and information</p>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" id="search" wire:model.live.debounce.250ms" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Search employees...">
            </div>
            <div>
                <label for="departmentFilter" class="block text-sm font-medium text-gray-700">Department</label>
                <select id="departmentFilter" wire:model.live.debounce.250ms" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Departments</option>
                    @foreach($employees->pluck('department')->unique() as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-1 flex items-end">
                <button wire:click="openCreateEmployeeModal" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-black bg-white hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v6m0 0v6m0 0h6m-6 0h6m-6 0v6m-6 0h6m-6 0v6m-6 0v6m-6 0v6m-6 0v6" />
                    </svg>
                    Add Employee
                </button>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Employee Records</h3>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hire Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('images/user.svg') }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $employee->employee_code ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $employee->department ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $employee->position ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $employee->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $employee->basic_salary ? number_format($employee->basic_salary, 2) . ' ' . ($employee->salary_currency ?? 'RWF') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openEditEmployeeModal({{ $employee->id }})" class="text-black hover:text-blue-600 mr-3">Edit</button>
                                <button wire:click="openDeleteEmployeeModal({{ $employee->id }})" class="text-black hover:text-blue-600">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No employees found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($employees->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:items-center sm:justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
                </div>
                {{ $employees->links() }}
            </div>
        @endif
    </div>

    <!-- Create Employee Modal -->
    @if($showCreateEmployeeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Create New Employee</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                        <input type="text" id="first_name" wire:model="first_name" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter first name">
                                        @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                        <input type="text" id="last_name" wire:model="last_name" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter last name">
                                        @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" id="email" wire:model="email" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter email address">
                                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="tel" id="phone_number" wire:model="phone_number" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter phone number">
                                        @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                        <input type="text" id="department" wire:model="department" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter department">
                                        @error('department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                                        <input type="text" id="position" wire:model="position" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter position">
                                        @error('position') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="employee_code" class="block text-sm font-medium text-gray-700">Employee Code</label>
                                        <input type="text" id="employee_code" wire:model="employee_code" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter employee code">
                                        @error('employee_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                                        <input type="date" id="hire_date" wire:model="hire_date" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('hire_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="basic_salary" class="block text-sm font-medium text-gray-700">Basic Salary (RWF)</label>
                                        <input type="number" id="basic_salary" wire:model="basic_salary" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter basic salary" step="0.01">
                                        @error('basic_salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="salary_currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                        <select id="salary_currency" wire:model="salary_currency" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="RWF">RWF - Rwandan Franc</option>
                                            <option value="USD">USD - US Dollar</option>
                                            <option value="EUR">EUR - Euro</option>
                                        </select>
                                        @error('salary_currency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                        <select id="payment_method" wire:model="payment_method" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="bank">Bank Transfer</option>
                                            <option value="cash">Cash</option>
                                            <option value="mobile_money">Mobile Money</option>
                                        </select>
                                        @error('payment_method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:target="payment_method">
                                        @if($payment_method === 'bank')
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                                    <select id="bank_name" wire:model="bank_name" 
                                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option value="">Select Bank</option>
                                                        @foreach($banks as $bank)
                                                            <option value="{{ $bank->name }}">{{ $bank->name }} ({{ $bank->code }})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                                                    <input type="text" id="bank_account_number" wire:model="bank_account_number" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                           placeholder="Enter account number">
                                                    @error('bank_account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label for="bank_branch" class="block text-sm font-medium text-gray-700">Bank Branch</label>
                                                    <input type="text" id="bank_branch" wire:model="bank_branch" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                           placeholder="Enter bank branch">
                                                    @error('bank_branch') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        @elseif($payment_method === 'mobile_money')
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="mobile_money_provider" class="block text-sm font-medium text-gray-700">Mobile Money Provider</label>
                                                    <select id="mobile_money_provider" wire:model="mobile_money_provider" 
                                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option value="">Select Provider</option>
                                                        <option value="mtn">MTN Mobile Money</option>
                                                        <option value="airtel">Airtel Money</option>
                                                        <option value="tigocash">Tigo Cash</option>
                                                    </select>
                                                    @error('mobile_money_provider') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label for="mobile_money_number" class="block text-sm font-medium text-gray-700">Mobile Money Number</label>
                                                    <input type="tel" id="mobile_money_number" wire:model="mobile_money_number" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                           placeholder="Enter mobile money number">
                                                    @error('mobile_money_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label for="salary_effective_date" class="block text-sm font-medium text-gray-700">Salary Effective Date</label>
                                        <input type="date" id="salary_effective_date" wire:model="salary_effective_date" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('salary_effective_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="rssb_rate" class="block text-sm font-medium text-gray-700">RSSB Rate (%)</label>
                                            <input type="number" id="rssb_rate" wire:model="rssb_rate" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   placeholder="3.00" step="0.01" min="0" max="100">
                                            @error('rssb_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="pension_rate" class="block text-sm font-medium text-gray-700">Pension Rate (%)</label>
                                            <input type="number" id="pension_rate" wire:model="pension_rate" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   placeholder="5.00" step="0.01" min="0" max="100">
                                            @error('pension_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_taxable" wire:model="is_taxable" 
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_taxable" class="ml-2 block text-sm text-gray-900">
                                            Subject to PAYE Tax
                                        </label>
                                        @error('is_taxable') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="user_id" class="block text-sm font-medium text-gray-700">Associated User</label>
                                        <select id="user_id" wire:model="user_id" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="createEmployee" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Create Employee
                        </button>
                        <button type="button" wire:click="closeCreateEmployeeModal" 
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Employee Modal -->
    @if($showEditEmployeeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Employee</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="edit_first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                        <input type="text" id="edit_first_name" wire:model="first_name" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter first name">
                                        @error('edit_first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                        <input type="text" id="edit_last_name" wire:model="last_name" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter last name">
                                        @error('edit_last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" id="edit_email" wire:model="email" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter email address">
                                        @error('edit_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="tel" id="edit_phone_number" wire:model="phone_number" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter phone number">
                                        @error('edit_phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_department" class="block text-sm font-medium text-gray-700">Department</label>
                                        <input type="text" id="edit_department" wire:model="department" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter department">
                                        @error('edit_department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_position" class="block text-sm font-medium text-gray-700">Position</label>
                                        <input type="text" id="edit_position" wire:model="position" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter position">
                                        @error('edit_position') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_employee_code" class="block text-sm font-medium text-gray-700">Employee Code</label>
                                        <input type="text" id="edit_employee_code" wire:model="employee_code" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter employee code">
                                        @error('edit_employee_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                                        <input type="date" id="edit_hire_date" wire:model="hire_date" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('edit_hire_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_basic_salary" class="block text-sm font-medium text-gray-700">Basic Salary (RWF)</label>
                                        <input type="number" id="edit_basic_salary" wire:model="basic_salary" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               placeholder="Enter basic salary" step="0.01">
                                        @error('basic_salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_salary_currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                        <select id="edit_salary_currency" wire:model="salary_currency" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="RWF">RWF - Rwandan Franc</option>
                                            <option value="USD">USD - US Dollar</option>
                                            <option value="EUR">EUR - Euro</option>
                                        </select>
                                        @error('salary_currency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                        <select id="edit_payment_method" wire:model="payment_method" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="bank">Bank Transfer</option>
                                            <option value="cash">Cash</option>
                                            <option value="mobile_money">Mobile Money</option>
                                        </select>
                                        @error('payment_method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:target="payment_method">
                                        @if($payment_method === 'bank')
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="edit_bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                                    <select id="edit_bank_name" wire:model="bank_name" 
                                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option value="">Select Bank</option>
                                                        @foreach($banks as $bank)
                                                            <option value="{{ $bank->name }}">{{ $bank->name }} ({{ $bank->code }})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label for="edit_bank_account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                                                    <input type="text" id="edit_bank_account_number" wire:model="bank_account_number" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                           placeholder="Enter account number">
                                                    @error('bank_account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label for="edit_bank_branch" class="block text-sm font-medium text-gray-700">Bank Branch</label>
                                                    <input type="text" id="edit_bank_branch" wire:model="bank_branch" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                           placeholder="Enter bank branch">
                                                    @error('bank_branch') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        @elseif($payment_method === 'mobile_money')
                                            <div class="space-y-3">
                                                <div>
                                                    <label for="edit_mobile_money_provider" class="block text-sm font-medium text-gray-700">Mobile Money Provider</label>
                                                    <select id="edit_mobile_money_provider" wire:model="mobile_money_provider" 
                                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option value="">Select Provider</option>
                                                        <option value="mtn">MTN Mobile Money</option>
                                                        <option value="airtel">Airtel Money</option>
                                                        <option value="tigocash">Tigo Cash</option>
                                                    </select>
                                                    @error('mobile_money_provider') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label for="edit_mobile_money_number" class="block text-sm font-medium text-gray-700">Mobile Money Number</label>
                                                    <input type="tel" id="edit_mobile_money_number" wire:model="mobile_money_number" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                           placeholder="Enter mobile money number">
                                                    @error('mobile_money_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label for="edit_salary_effective_date" class="block text-sm font-medium text-gray-700">Salary Effective Date</label>
                                        <input type="date" id="edit_salary_effective_date" wire:model="salary_effective_date" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('salary_effective_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="edit_rssb_rate" class="block text-sm font-medium text-gray-700">RSSB Rate (%)</label>
                                            <input type="number" id="edit_rssb_rate" wire:model="rssb_rate" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   placeholder="3.00" step="0.01" min="0" max="100">
                                            @error('rssb_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="edit_pension_rate" class="block text-sm font-medium text-gray-700">Pension Rate (%)</label>
                                            <input type="number" id="edit_pension_rate" wire:model="pension_rate" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   placeholder="5.00" step="0.01" min="0" max="100">
                                            @error('pension_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="edit_is_taxable" wire:model="is_taxable" 
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="edit_is_taxable" class="ml-2 block text-sm text-gray-900">
                                            Subject to PAYE Tax
                                        </label>
                                        @error('is_taxable') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="edit_user_id" class="block text-sm font-medium text-gray-700">Associated User</label>
                                        <select id="edit_user_id" wire:model="user_id" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('edit_user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="updateEmployee" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update Employee
                        </button>
                        <button type="button" wire:click="closeEditEmployeeModal" 
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Employee Modal -->
    @if($showDeleteEmployeeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="mt-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Employee</h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Are you sure you want to delete this employee? This action cannot be undone.
                                    </p>
                                </div>
                                <div class="mt-4 text-center">
                                    <button type="button" wire:click="deleteEmployee" 
                                            class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                                        Yes, Delete Employee
                                    </button>
                                    <button type="button" wire:click="closeDeleteEmployeeModal" 
                                            class="mt-3 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
