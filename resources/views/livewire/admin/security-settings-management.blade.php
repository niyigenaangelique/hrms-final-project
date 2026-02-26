<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Security Settings</h1>
        <p class="text-gray-600 mt-2">Configure system security policies and settings</p>
    </div>

    <!-- Security Settings Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form wire:submit="saveSecuritySettings" class="space-y-6">
            <!-- Password Policies -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Password Policies</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password_min_length" class="block text-sm font-medium text-gray-700">Minimum Password Length</label>
                        <input type="number" id="password_min_length" wire:model="password_min_length" min="6" max="20"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('password_min_length') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="session_timeout_minutes" class="block text-sm font-medium text-gray-700">Session Timeout (minutes)</label>
                        <input type="number" id="session_timeout_minutes" wire:model="session_timeout_minutes" min="5" max="480"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('session_timeout_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="max_login_attempts" class="block text-sm font-medium text-gray-700">Max Login Attempts</label>
                        <input type="number" id="max_login_attempts" wire:model="max_login_attempts" min="3" max="10"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('max_login_attempts') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="lockout_duration_minutes" class="block text-sm font-medium text-gray-700">Lockout Duration (minutes)</label>
                        <input type="number" id="lockout_duration_minutes" wire:model="lockout_duration_minutes" min="5" max="1440"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('lockout_duration_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="force_password_change_days" class="block text-sm font-medium text-gray-700">Force Password Change (days)</label>
                        <input type="number" id="force_password_change_days" wire:model="force_password_change_days" min="0" max="365"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('force_password_change_days') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" id="password_require_uppercase" wire:model="password_require_uppercase" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="password_require_uppercase" class="ml-2 block text-sm text-gray-900">Require Uppercase Letters</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="password_require_lowercase" wire:model="password_require_lowercase" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="password_require_lowercase" class="ml-2 block text-sm text-gray-900">Require Lowercase Letters</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="password_require_numbers" wire:model="password_require_numbers" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="password_require_numbers" class="ml-2 block text-sm text-gray-900">Require Numbers</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="password_require_symbols" wire:model="password_require_symbols" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="password_require_symbols" class="ml-2 block text-sm text-gray-900">Require Symbols</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="enable_two_factor" wire:model="enable_two_factor" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="enable_two_factor" class="ml-2 block text-sm text-gray-900">Enable Two-Factor Authentication</label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6">
                <div class="space-x-3">
                    <button type="button" wire:click="resetToDefaults" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset to Defaults
                    </button>
                    <button type="button" wire:click="testPasswordPolicy" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Test Policy
                    </button>
                    <button type="button" wire:click="generateSecurityReport" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2m-3-4h1m-1-4h1m-6-4h.01M9 16h.01" />
                        </svg>
                        Generate Report
                    </button>
                </div>
                <div class="space-x-3">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
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

    <!-- Info Message -->
    @if(session()->has('info'))
        <div class="fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded z-50">
            {{ session('info') }}
        </div>
    @endif
</div>
