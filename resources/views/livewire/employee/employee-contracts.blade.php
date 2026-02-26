<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Contracts</h1>
                <p class="text-gray-600 mt-2">View and manage your employment contracts</p>
            </div>
        </div>
    </div>

    <!-- Contracts List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($contracts && $contracts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contract Code
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Current Salary
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Duration
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($contracts as $contract)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $contract->code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contract->position->name ?? 'Not specified' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($employee && $employee->basic_salary)
                                            <span class="text-green-600 font-semibold">
                                                {{ number_format($employee->basic_salary, 2) }} {{ $employee->salary_currency ?? 'RWF' }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">Not set</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contract->start_date->format('M d, Y') }} - 
                                        {{ $contract->end_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($contract->status->value === 'active') bg-green-100 text-green-800
                                            @elseif($contract->status->value === 'expired') bg-red-100 text-red-800
                                            @elseif($contract->status->value === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($contract->status->value === 'terminated') bg-gray-100 text-gray-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ ucfirst($contract->status->value) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button type="button" wire:click="viewContract('{{ $contract->id }}')" class="text-blue-600 hover:text-blue-900 mr-3">
                                            View
                                        </button>
                                        <button type="button" wire:click="downloadContract('{{ $contract->id }}')" class="text-green-600 hover:text-green-900">
                                            Download
                                        </button>
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
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No contracts found</h3>
                    <p class="mt-1 text-sm text-gray-500">You don't have any contracts assigned yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Contract Details Modal -->
    @if($selectedContract)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Contract Details</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contract Information -->
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900">Contract Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Contract Code</label>
                                    <p class="text-gray-900">{{ $selectedContract->code }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Position</label>
                                    <p class="text-gray-900">{{ $selectedContract->position->name ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Project</label>
                                    <p class="text-gray-900">Not assigned</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Employee Category</label>
                                    <p class="text-gray-900">{{ ucfirst($selectedContract->employee_category->value ?? 'Not specified') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Details -->
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900">Employment Details</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Start Date</label>
                                    <p class="text-gray-900">{{ $selectedContract->start_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">End Date</label>
                                    <p class="text-gray-900">{{ $selectedContract->end_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Daily Working Hours</label>
                                    <p class="text-gray-900">{{ $selectedContract->daily_working_hours }} hours</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($selectedContract->status->value === 'active') bg-green-100 text-green-800
                                        @elseif($selectedContract->status->value === 'expired') bg-red-100 text-red-800
                                        @elseif($selectedContract->status->value === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($selectedContract->status->value === 'terminated') bg-gray-100 text-gray-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst($selectedContract->status->value) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Compensation -->
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900">Compensation</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Contract Remuneration</label>
                                    <p class="text-gray-900">{{ number_format($selectedContract->remuneration, 2) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Remuneration Type</label>
                                    <p class="text-gray-900">{{ ucfirst($selectedContract->remuneration_type->value ?? 'Not specified') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Current Salary Details -->
                        @if($employee && ($employee->basic_salary || $employee->daily_rate || $employee->hourly_rate))
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900">Current Salary Details</h4>
                                <div class="space-y-3">
                                    @if($employee->basic_salary)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Basic Salary</label>
                                            <p class="text-gray-900 font-semibold">{{ number_format($employee->basic_salary, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->daily_rate)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Daily Rate</label>
                                            <p class="text-gray-900">{{ number_format($employee->daily_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->hourly_rate)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Hourly Rate</label>
                                            <p class="text-gray-900">{{ number_format($employee->hourly_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->salary_effective_date)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Salary Effective Date</label>
                                            <p class="text-gray-900">{{ $employee->salary_effective_date->format('M d, Y') }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->is_taxable !== null)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Tax Status</label>
                                            <p class="text-gray-900">
                                                @if($employee->is_taxable)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Taxable
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Non-Taxable
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Payment Information -->
                        @if($employee && $employee->payment_method)
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900">Payment Information</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Payment Method</label>
                                        <p class="text-gray-900">{{ ucfirst($employee->payment_method) }}</p>
                                    </div>
                                    
                                    @if($employee->payment_method === 'bank' && $employee->bank_name)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Bank Name</label>
                                            <p class="text-gray-900">{{ $employee->bank_name }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->payment_method === 'bank' && $employee->bank_account_number)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Account Number</label>
                                            <p class="text-gray-900">{{ $employee->bank_account_number }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->payment_method === 'bank' && $employee->bank_branch)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Bank Branch</label>
                                            <p class="text-gray-900">{{ $employee->bank_branch }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->payment_method === 'mobile_money' && $employee->mobile_money_provider)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Mobile Money Provider</label>
                                            <p class="text-gray-900">{{ $employee->mobile_money_provider }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->payment_method === 'mobile_money' && $employee->mobile_money_number)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Mobile Money Number</label>
                                            <p class="text-gray-900">{{ $employee->mobile_money_number }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- RSSB Information -->
                        @if($employee && ($employee->rssb_rate || $employee->pension_rate))
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900">RSSB Information</h4>
                                <div class="space-y-3">
                                    @if($employee->rssb_rate)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">RSSB Rate</label>
                                            <p class="text-gray-900">{{ number_format($employee->rssb_rate, 2) }}%</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->pension_rate)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Pension Rate</label>
                                            <p class="text-gray-900">{{ number_format($employee->pension_rate, 2) }}%</p>
                                        </div>
                                    @endif
                                    
                                    @if($employee->rss_number)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">RSSB Number</label>
                                            <p class="text-gray-900">{{ $employee->rss_number }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Approval Status -->
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900">Approval Status</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Contract Status</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($selectedContract->approval_status->value === 'approved') bg-green-100 text-green-800
                                        @elseif($selectedContract->approval_status->value === 'rejected') bg-red-100 text-red-800
                                        @elseif($selectedContract->approval_status->value === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($selectedContract->approval_status->value) }}
                                    </span>
                                </div>
                                @if($selectedContract->approved_at)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Approved Date</label>
                                        <p class="text-gray-900">{{ $selectedContract->approved_at->format('M d, Y H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-end space-x-3">
                            <button wire:click="downloadContract('{{ $selectedContract->id }}')" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Contract
                            </button>
                            <button wire:click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
