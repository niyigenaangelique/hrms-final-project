<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Tom Select CSS -->
    {{--    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">--}}


</head>
<body class="min-h-screen bg-white dark:bg-zinc-800  scrollbar-custom">
<flux:sidebar sticky stashable
              class="bg-zinc-200   scrollbar-custom dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden " icon="x-mark"/>

    <img src="{{ asset('images/logo_3_1.png') }}" class="w-auto max-lg:hidden dark:hidden" alt="">
    <img src="{{ asset('images/logo_4_1.png') }}" class="w-auto max-lg:!hidden hidden dark:flex" alt="">
    <flux:separator/>
    @auth
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('home') }}" wire:navigate>Home</flux:navlist.item>
            <flux:navlist.item icon="inbox" badge="0" href="#">Inbox</flux:navlist.item>

            @if(auth()->user()->role === 'SuperAdmin')
                <flux:navlist.group expandable heading="Administration" class="hidden lg:grid">
                    <flux:navlist.item icon="shield-check" href="{{ route('admin.enhanced-dashboard') }}" wire:navigate>Admin Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="users" href="{{ route('admin.users') }}" wire:navigate>User Management</flux:navlist.item>
                    <flux:navlist.item icon="user-tie" href="{{ route('admin.employees') }}" wire:navigate>Employee Management</flux:navlist.item>
                    <flux:navlist.item icon="key" href="{{ route('admin.permissions') }}" wire:navigate>Permissions</flux:navlist.item>
                    <flux:navlist.item icon="clipboard-list" href="{{ route('admin.activity-logs') }}" wire:navigate>Activity Logs</flux:navlist.item>
                    <flux:navlist.item icon="cog" href="{{ route('admin.system-configuration') }}" wire:navigate>System Configuration</flux:navlist.item>
                    <flux:navlist.item icon="database" href="{{ route('admin.database-management') }}" wire:navigate>Database Management</flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" href="{{ route('admin.system-analytics') }}" wire:navigate>System Analytics</flux:navlist.item>
                </flux:navlist.group>
            @endif

            @canany(['systemAdministrationView', 'companyAdministrationView'], Auth::user())
                <flux:navlist.group expandable heading="Administration" class="hidden lg:grid">
                    @can('systemAdministrationView', Auth::user())
                        <flux:navlist.item icon="shield-check" href="{{ route('admin.enhanced-dashboard') }}" wire:navigate>Admin Dashboard</flux:navlist.item>
                        <flux:navlist.item icon="user-group" href="{{  route('users')}}"  wire:navigate>Users</flux:navlist.item>
                    @endcanany
                    <flux:navlist.item icon="hashtag" href="{{ route('positions') }}" wire:navigate>Positions/Designation</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group expandable heading="Common data" class="hidden lg:grid" :expanded="false">
                    <flux:navlist.item icon="adjustments-horizontal" href="{{ route('banks') }}">Banks</flux:navlist.item>
                </flux:navlist.group>

            @endcanany
            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Personnel administration" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="users" href="{{ route('employees') }}" wire:navigate>Employees</flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" href="{{ route('contracts') }}" wire:navigate>Employment Contracts</flux:navlist.item>
                </flux:navlist.group>
            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Leave & Attendance" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="calendar-days" href="{{ route('leave-attendance.dashboard') }}" wire:navigate>Leave Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="document-plus" href="{{ route('leave-attendance.requests') }}" wire:navigate>Leave Request</flux:navlist.item>
                    <flux:navlist.item icon="check-circle" href="{{ route('leave-attendance.hr-leave-management') }}" wire:navigate>Manage Leave</flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-left-right" href="{{ route('leave-attendance.hr-communication') }}" wire:navigate>Messages</flux:navlist.item>
                    <flux:navlist.item icon="calendar" href="{{ route('leave-attendance.hr-calendar') }}" wire:navigate>Calendar</flux:navlist.item>
                </flux:navlist.group>
            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Payroll" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="calculator" href="{{ route('payroll.dashboard') }}" wire:navigate>Payroll Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="banknotes" href="{{ route('payroll.entries') }}" wire:navigate>Payroll Entries</flux:navlist.item>
                    <flux:navlist.item icon="calendar" href="{{ route('payroll.months') }}" wire:navigate>Payroll Months</flux:navlist.item>
                    <flux:navlist.item icon="document-text" href="{{ route('payroll.payslip-generator') }}" wire:navigate>Payslip Generator</flux:navlist.item>
                    <flux:navlist.item icon="calculator" href="{{ route('payroll.tax-calculator') }}" wire:navigate>Tax Calculator</flux:navlist.item>
                </flux:navlist.group>
            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Performance" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="chart-bar" href="{{ route('performance.dashboard') }}" wire:navigate>Performance Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="star" href="{{ route('performance.kpi-management') }}" wire:navigate>KPI Management</flux:navlist.item>
                </flux:navlist.group>
            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Analytics" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="chart-bar" href="{{ route('analytics.dashboard') }}" wire:navigate>Analytics Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="document-text" href="{{ route('analytics.report-builder') }}" wire:navigate>Report Builder</flux:navlist.item>
                </flux:navlist.group>
            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="System" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="bell" href="{{ route('notifications.center') }}" wire:navigate>Notifications</flux:navlist.item>
                    <flux:navlist.item icon="shield-check" href="{{ route('access-control.dashboard') }}" wire:navigate>Access Control</flux:navlist.item>
                    <flux:navlist.item icon="arrow-down-tray" href="{{ route('imports') }}">Imports/Exports</flux:navlist.item>
                </flux:navlist.group>
            @endcan

        </flux:navlist>

        <flux:spacer/>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog" href="#">Settings</flux:navlist.item>
            <flux:navlist.item icon="question-mark-circle" href="#">Help</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="{{ asset('images/user.svg') }}"
                          name="{{Auth::user()->first_name ?? ''}} {{Auth::user()->last_name ?? ''}}"/>

            <flux:menu>
                <flux:menu.item
                    icon="arrow-right"
                    href="{{ route('logout') }}"
                >Logout
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @endauth
</flux:sidebar>


<flux:main class="!p-0 overflow-scroll  scrollbar-custom">
    {{ $slot }}
    @yield('commands')
</flux:main>
<flux:modal name="loadingPage" :dismissible="false" class=" !bg-zinc-600 !bg-opacity-50 !rounded-lg"  >
    <div class="flex justify-center items-center h-full p-1 ">
        <i class="fas fa-spinner fa-spin text-4xl text-green-600" style="display: inline-block;"></i>
    </div>
</flux:modal>
@fluxScripts
@livewireScripts
@persist('toast')
<flux:toast/>
@endpersist
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>



<!-- Tom Select JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js" defer></script>--}}
</body>
</html>
