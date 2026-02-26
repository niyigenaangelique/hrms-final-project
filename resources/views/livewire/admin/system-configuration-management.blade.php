<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">System Configuration</h1>
        <p class="text-gray-600 mt-2">Configure system-wide settings and preferences</p>
    </div>

    <!-- Configuration Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form wire:submit="saveConfiguration" class="space-y-6">
            <!-- General Settings -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">General Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Application Name</label>
                        <input type="text" wire:model="app_name" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('app_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Default Language</label>
                        <select wire:model="default_language" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="en">English</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Timezone</label>
                        <select wire:model="timezone" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">Eastern Time</option>
                            <option value="America/Chicago">Central Time</option>
                            <option value="America/Denver">Mountain Time</option>
                            <option value="America/Los_Angeles">Pacific Time</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date Format</label>
                        <select wire:model="date_format" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Y-m-d">YYYY-MM-DD</option>
                            <option value="m/d/Y">MM/DD/YYYY</option>
                            <option value="d/m/Y">DD/MM/YYYY</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Email Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mail Driver</label>
                        <select wire:model="mail_driver" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="smtp">SMTP</option>
                            <option value="mail">Mail</option>
                            <option value="sendmail">Sendmail</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mail Host</label>
                        <input type="text" wire:model="mail_host" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mail Port</label>
                        <input type="number" wire:model="mail_port" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mail Username</label>
                        <input type="text" wire:model="mail_username" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mail Password</label>
                        <input type="password" wire:model="mail_password" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mail Encryption</label>
                        <select wire:model="mail_encryption" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">None</option>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- File Upload Settings -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">File Upload Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max File Size (MB)</label>
                        <input type="number" wire:model="max_file_size" min="1" max="100"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Allowed File Types</label>
                        <input type="text" wire:model="allowed_file_types" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="jpg,png,pdf,doc">
                    </div>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Maintenance Mode</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="maintenance_mode" 
                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <label class="ml-2 block text-sm text-gray-900">Enable Maintenance Mode</label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Maintenance Message</label>
                        <textarea wire:model="maintenance_message" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">Laravel Version:</span> {{ $systemInfo['laravel_version'] ?? 'Unknown' }}
                        </div>
                        <div>
                            <span class="font-medium">PHP Version:</span> {{ $systemInfo['php_version'] ?? 'Unknown' }}
                        </div>
                        <div>
                            <span class="font-medium">Database:</span> {{ $systemInfo['database'] ?? 'Unknown' }}
                        </div>
                        <div>
                            <span class="font-medium">Server:</span> {{ $systemInfo['server'] ?? 'Unknown' }}
                        </div>
                        <div>
                            <span class="font-medium">Environment:</span> {{ config('app.env') }}
                        </div>
                        <div>
                            <span class="font-medium">Debug Mode:</span> {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6">
                <div class="space-x-3">
                    <button type="button" wire:click="clearCache" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Clear Cache
                    </button>
                    <button type="button" wire:click="backupSystem" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Backup System
                    </button>
                </div>
                <div class="space-x-3">
                    <button type="button" wire:click="resetToDefaults" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Reset to Defaults
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Save Configuration
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
</div>
