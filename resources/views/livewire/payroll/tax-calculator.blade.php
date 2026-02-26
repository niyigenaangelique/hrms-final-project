<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tax Calculator</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Calculate employee taxes and net salary</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input Section -->
        <div class="space-y-6">
            <!-- Gross Salary Input -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Salary Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="grossSalary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Gross Salary
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input
                                type="number"
                                id="grossSalary"
                                wire:model.live="grossSalary"
                                class="block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                            />
                        </div>
                        @error('grossSalary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tax Rates -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tax Rates (%)</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="payeRate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            PAYE Rate
                        </label>
                        <input
                            type="number"
                            id="payeRate"
                            wire:model.live="payeRate"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            step="0.1"
                            min="0"
                            max="100"
                        />
                    </div>

                    <div>
                        <label for="pensionRate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pension Rate
                        </label>
                        <input
                            type="number"
                            id="pensionRate"
                            wire:model.live="pensionRate"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            step="0.1"
                            min="0"
                            max="100"
                        />
                    </div>

                    <div>
                        <label for="maternityRate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Maternity Rate
                        </label>
                        <input
                            type="number"
                            id="maternityRate"
                            wire:model.live="maternityRate"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            step="0.1"
                            min="0"
                            max="100"
                        />
                    </div>

                    <div>
                        <label for="cbhiRate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            CBHI Rate
                        </label>
                        <input
                            type="number"
                            id="cbhiRate"
                            wire:model.live="cbhiRate"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            step="0.1"
                            min="0"
                            max="100"
                        />
                    </div>
                </div>
            </div>

            <!-- Custom Deductions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Custom Deductions</h2>
                    <button
                        type="button"
                        wire:click="addCustomDeduction"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Add Deduction
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($customDeductions as $index => $deduction)
                        <div class="flex space-x-2">
                            <input
                                type="text"
                                wire:model.live="customDeductions.{{ $index }}.name"
                                class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Deduction name"
                            />
                            <input
                                type="number"
                                wire:model.live="customDeductions.{{ $index }}.amount"
                                class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Amount"
                                step="0.01"
                                min="0"
                            />
                            <button
                                type="button"
                                wire:click="removeCustomDeduction('{{ $index }}')"
                                class="px-2 py-1 text-red-600 hover:text-red-800"
                            >
                                Remove
                            </button>
                        </div>
                    @endforeach
                    @if(empty($customDeductions))
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No custom deductions added</p>
                    @endif
                </div>
            </div>

            <!-- Custom Benefits -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Custom Benefits</h2>
                    <button
                        type="button"
                        wire:click="addCustomBenefit"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Add Benefit
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($customBenefits as $index => $benefit)
                        <div class="flex space-x-2">
                            <input
                                type="text"
                                wire:model.live="customBenefits.{{ $index }}.name"
                                class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Benefit name"
                            />
                            <input
                                type="number"
                                wire:model.live="customBenefits.{{ $index }}.amount"
                                class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Amount"
                                step="0.01"
                                min="0"
                            />
                            <button
                                type="button"
                                wire:click="removeCustomBenefit('{{ $index }}')"
                                class="px-2 py-1 text-red-600 hover:text-red-800"
                            >
                                Remove
                            </button>
                        </div>
                    @endforeach
                    @if(empty($customBenefits))
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No custom benefits added</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="space-y-6">
            <!-- Tax Breakdown -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tax Breakdown</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Gross Salary</span>
                        <span class="font-medium text-gray-900 dark:text-white">${{ number_format($grossSalary, 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Pension Deduction</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-${{ number_format($pensionAmount, 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Custom Deductions</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-${{ number_format(collect($customDeductions)->sum('amount'), 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Taxable Income</span>
                        <span class="font-medium text-gray-900 dark:text-white">${{ number_format($taxableIncome, 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">PAYE Tax</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-${{ number_format($payeAmount, 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Maternity Contribution</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-${{ number_format($maternityAmount, 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">CBHI Contribution</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-${{ number_format($cbhiAmount, 2) }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Custom Benefits</span>
                        <span class="font-medium text-green-600 dark:text-green-400">+${{ number_format(collect($customBenefits)->sum('amount'), 2) }}</span>
                    </div>

                    <div class="flex justify-between py-3 bg-gray-50 dark:bg-gray-700 rounded-md px-3">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Net Salary</span>
                        <span class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($netSalary, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Summary</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $grossSalary > 0 ? number_format(($totalDeductions / $grossSalary) * 100, 1) : '0.0' }}%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Deduction Rate</div>
                    </div>

                    <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $grossSalary > 0 ? number_format(($netSalary / $grossSalary) * 100, 1) : '0.0' }}%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Take Home Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
