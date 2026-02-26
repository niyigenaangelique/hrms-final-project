<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentFlow Pro - Employee Dashboard' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    
    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite('resources/css/app.css')
    @endif
    @fluxAppearance
    @livewireStyles
    
    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 scrollbar-custom">
<flux:sidebar sticky stashable 
              class="bg-zinc-200 scrollbar-custom dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <img src="{{ asset('images/logo_4_1.png') }}" class="w-auto max-lg:!hidden hidden dark:flex" alt="">
    <flux:separator/>
    @auth
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('employee.dashboard') }}" wire:navigate>Dashboard</flux:navlist.item>
            
            <flux:navlist.group expandable heading="Personal" class="hidden lg:grid">
                <flux:navlist.item icon="user" href="{{ route('employee.profile') }}" wire:navigate>My Profile</flux:navlist.item>
                <flux:navlist.item icon="document-text" href="{{ route('employee.contracts') }}" wire:navigate>My Contracts</flux:navlist.item>
                <flux:navlist.item icon="presentation-chart-line" href="{{ route('employee.performance') }}" wire:navigate>Performance</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group expandable heading="Work Management" class="hidden lg:grid">
                <flux:navlist.item icon="document-plus" href="{{ route('employee.leave.request') }}" wire:navigate>Request Leave</flux:navlist.item>
                <flux:navlist.item icon="check-circle" href="{{ route('employee.leave-status') }}" wire:navigate>Leave Status</flux:navlist.item>
                <flux:navlist.item icon="calendar" href="{{ route('employee.calendar') }}" wire:navigate>My Calendar</flux:navlist.item>
                <flux:navlist.item icon="clock" href="{{ route('employee.attendance') }}" wire:navigate>Attendance</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group expandable heading="Communication" class="hidden lg:grid">
                <flux:navlist.item icon="chat-bubble-left-right" href="{{ route('employee.communication') }}" wire:navigate>Messages</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group expandable heading="Financial" class="hidden lg:grid">
                <flux:navlist.item icon="banknotes" href="{{ route('employee.payroll') }}" wire:navigate>Payroll</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.item icon="arrow-right" href="{{ route('logout') }}" wire:navigate>Logout</flux:navlist.item>
        </flux:navlist>
    @endauth
</flux:sidebar>

<!-- Main Content -->
<flux:main class="!p-0 overflow-scroll scrollbar-custom">
    {{ $slot }}
</flux:main>

@livewireScripts
@persist('toast')
<flux:toast/>
@endpersist
</body>
</html>
