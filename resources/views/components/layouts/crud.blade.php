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

            @canany(['systemAdministrationView', 'companyAdministrationView'], Auth::user())
                <flux:navlist.group expandable heading="Administration" class="hidden lg:grid">
                    @can('systemAdministrationView', Auth::user())
                        {{--                        <flux:navlist.item icon="user-group" href="{{  route('users')}}"  wire:navigate>Users</flux:navlist.item>--}}
                        <flux:navlist.item icon="user-group" href="{{  route('users')}}"  wire:navigate>Users</flux:navlist.item>
                    @endcanany
                    <flux:navlist.item icon="viewfinder-circle" href="{{ route('projects') }}" wire:navigate>Projects</flux:navlist.item>
                    <flux:navlist.item icon="building-office" href="{{ route('departments') }}" wire:navigate>Departments</flux:navlist.item>
                    <flux:navlist.item icon="hashtag" href="{{ route('positions') }}" wire:navigate>Positions/Designation</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group expandable heading="Common data" class="hidden lg:grid" :expanded="false">
                    @can('systemAdministrationView', Auth::user())
                        <flux:navlist.item icon="banknotes" href="#">Currencies</flux:navlist.item>
                    @endcanany
                    <flux:navlist.item icon="adjustments-horizontal" href="#" wire:navigate>Employee Benefits</flux:navlist.item>
                    <flux:navlist.item icon="adjustments-horizontal" href="#" wire:navigate>Banks</flux:navlist.item>
                    <flux:navlist.item icon="adjustments-horizontal" href="#" wire:navigate>Relationships</flux:navlist.item>
                </flux:navlist.group>

            @endcanany
            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Personnel administration" class="hidden lg:grid"
                                    :expanded="false">
                    {{--                    <flux:navlist.item icon="users" href="#" wire:navigate>Payroll profiles</flux:navlist.item>--}}
                    <flux:navlist.item icon="users" href="#" wire:navigate>Employees</flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" href="#" wire:navigate>Employment Contracts</flux:navlist.item>

                </flux:navlist.group>
            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Time management" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="calendar-date-range" href="#">Public holidays</flux:navlist.item>
                    <flux:navlist.item icon="calendar-days" href="#">Events definition</flux:navlist.item>
                    <flux:navlist.item icon="pencil" href="#">Attendance entry</flux:navlist.item>
                    <flux:navlist.item icon="rectangle-stack" href="#">Attendance records</flux:navlist.item>
                    <flux:navlist.item icon="printer" href="#">Printing attendance</flux:navlist.item>

                </flux:navlist.group>

            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Payroll" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="calendar-date-range" href="#">Pay period</flux:navlist.item>
                    <flux:navlist.item icon="command-line" href="#">Automatic generation</flux:navlist.item>
                    <flux:navlist.item icon="rectangle-stack" href="#">Employee payslips</flux:navlist.item>
                    <flux:navlist.item icon="calculator" href="#">Payroll Calculation</flux:navlist.item>
                    <flux:navlist.item icon="printer" href="#">Printing payslips</flux:navlist.item>

                </flux:navlist.group>

            @endcan

            @can('hrManagerView', Auth::user())
                <flux:navlist.group expandable heading="Usage" class="hidden lg:grid"
                                    :expanded="false">
                    <flux:navlist.item icon="calendar-date-range" href="#">Imports</flux:navlist.item>
                    <flux:navlist.item icon="calendar-days" href="#">Exports</flux:navlist.item>
                    <flux:navlist.item icon="pencil" href="#">Templates</flux:navlist.item>
                    <flux:navlist.item icon="rectangle-stack" href="#">Devices Integration</flux:navlist.item>
                    <flux:navlist.item icon="printer" href="#">Usage reports</flux:navlist.item>

                </flux:navlist.group>

            @endcan

        </flux:navlist>

        <flux:spacer/>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
            <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="{{ asset('images/user.svg') }}"
                          name="{{Auth::user()->first_name ?? ''}} {{Auth::user()->last_name ?? ''}}"/>

            <flux:menu>
                <flux:menu.item
                    icon="arrow-right-start-on-rectangle"
                    href="{{ route('logout') }}"
                >Logout
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @endauth
</flux:sidebar>


<flux:main class="!p-0 overflow-scroll  scrollbar-custom">
    <div class=" h-screen w-full flex !items-start">
        <div class="flex flex-wrap flex-1 max-h-screen">
            {{ $slot }}
        </div>
        @yield('commands')
    </div>
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
</body>
</html>
