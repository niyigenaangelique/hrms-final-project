<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Leave Request</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Submit a new leave request</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Leave Request Form -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form wire:submit="submit">
                    <div class="space-y-6">
                        <!-- Leave Type Selection -->
                        <div>
                            <label for="selectedLeaveType" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Leave Type
                            </label>
                            <select
                                id="selectedLeaveType"
                                wire:model.live="selectedLeaveType"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required
                            >
                                <option value="">Select a leave type</option>
                                @foreach($leaveTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->default_days }} days)</option>
                                @endforeach
                            </select>
                            @error('selectedLeaveType')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Start Date
                                </label>
                                <input
                                    type="date"
                                    id="start_date"
                                    wire:model.live="start_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    End Date
                                </label>
                                <input
                                    type="date"
                                    id="end_date"
                                    wire:model.live="end_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Total Days Display -->
                        @if($total_days)
                            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md p-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-blue-800 dark:text-blue-200">
                                        Total leave days: <strong>{{ $total_days }}</strong> (excluding weekends and holidays)
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Reason -->
                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Reason for Leave
                            </label>
                            <textarea
                                id="reason"
                                wire:model="reason"
                                rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Please provide a detailed reason for your leave request..."
                                required
                            ></textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attachment -->
                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Attachment (Optional)
                            </label>
                            <input
                                type="file"
                                id="attachment"
                                wire:model="attachment"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            />
                            @error('attachment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max 5MB)
                            </p>
                        </div>

                        <!-- Conflict Warning -->
                        @if($conflictingRequests && $conflictingRequests->isNotEmpty())
                            <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-md p-4">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-yellow-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Conflicting Leave Requests</h3>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                            You have existing leave requests that overlap with the selected period:
                                        </p>
                                        <ul class="mt-2 text-sm text-yellow-700 dark:text-yellow-300 list-disc list-inside">
                                            @foreach($conflictingRequests as $conflict)
                                                <li>{{ $conflict->leaveType->name }} from {{ $conflict->start_date->format('M d, Y') }} to {{ $conflict->end_date->format('M d, Y') }} ({{ $conflict->total_days }} days)</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @error('conflict')
                            <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-md p-4">
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            </div>
                        @enderror

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                            >
                                <span wire:loading wire:target="submit" class="mr-2">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                Submit Leave Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Leave Balance -->
            @if($leaveBalance)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave Balance</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total Days:</span>
                            <span class="font-medium">{{ $leaveBalance->total_days + $leaveBalance->carried_forward_days }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Used Days:</span>
                            <span class="font-medium">{{ $leaveBalance->used_days }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Available Days:</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">{{ $leaveBalance->balance_days }}</span>
                        </div>
                        @if($total_days)
                            <div class="border-t pt-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">After Request:</span>
                                    <span class="font-bold {{ $leaveBalance->balance_days >= $total_days ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $leaveBalance->balance_days - $total_days }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Upcoming Holidays -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Upcoming Holidays</h3>
                <div class="space-y-2">
                    @foreach($holidays->take(5) as $holiday)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $holiday->name }}</div>
                                <div class="text-gray-500 dark:text-gray-400">{{ $holiday->date->format('M d, Y') }}</div>
                            </div>
                            <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Leave Policy -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave Policy</h3>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <p>• Weekends are excluded from leave calculations</p>
                    <p>• Public holidays are automatically excluded</p>
                    <p>• Leave requests require manager approval</p>
                    <p>• Attach supporting documents when required</p>
                    <p>• Submit requests at least 3 days in advance</p>
                </div>
            </div>
        </div>
    </div>
</div>
