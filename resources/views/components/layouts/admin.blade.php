<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite('resources/css/app.css')
    @endif
    @fluxAppearance
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900">
<div class="flex h-screen">
    <!-- Admin Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        <div class="p-4">
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                    <p class="text-sm text-gray-500">Administrator</p>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <!-- Dashboard Section -->
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dashboard</div>
                <a href="{{ route('admin.enhanced-dashboard') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Overview</span>
                </a>
                
                <!-- User Management Section -->
                <div class="px-4 py-2 mt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">User Management</div>
                <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-users w-5"></i>
                    <span>Users Management</span>
                </a>
                <a href="{{ route('admin.employees') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-user-tie w-5"></i>
                    <span>Employees</span>
                </a>
                <a href="{{ route('admin.permissions') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-user-shield w-5"></i>
                    <span>Permissions</span>
                </a>
                
                <!-- System Management Section -->
                <div class="px-4 py-2 mt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">System Management</div>
                <a href="{{ route('admin.activity-logs') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-history w-5"></i>
                    <span>Activity Logs</span>
                </a>
                <a href="{{ route('admin.security-settings') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-lock w-5"></i>
                    <span>Security Settings</span>
                </a>
                <a href="{{ route('admin.active-sessions') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-desktop w-5"></i>
                    <span>Active Sessions</span>
                </a>
                <a href="{{ route('admin.password-resets') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-key w-5"></i>
                    <span>Password Resets</span>
                </a>
                
                <!-- System Tools Section -->
                <div class="px-4 py-2 mt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">System Tools</div>
                <a href="{{ route('admin.system-configuration') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-cog w-5"></i>
                    <span>System Configuration</span>
                </a>
                <a href="{{ route('admin.database-management') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-database w-5"></i>
                    <span>Database Management</span>
                </a>
                <a href="{{ route('admin.system-analytics') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>System Analytics</span>
                </a>
                
                <!-- User Section -->
                <div class="px-4 py-2 mt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</div>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-user-cog w-5"></i>
                    <span>Profile Settings</span>
                </a>
                <a href="{{ route('logout') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Page Content -->
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>

@livewireScripts
@fluxScripts
</body>
</html>
