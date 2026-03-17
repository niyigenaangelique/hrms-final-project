<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentFlow Pro - HR Dashboard' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet"/>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite('resources/css/app.css')
    @endif
    @fluxAppearance
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ════════════════════════════════════════════════════
           iOS 26 DEEP OCEAN SIDEBAR — HR Edition
        ════════════════════════════════════════════════════ */

        body {
            background:
                radial-gradient(ellipse 80% 60% at 10% 10%,  rgba(186,230,253,0.55) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 5%,   rgba(216,180,254,0.45) 0%, transparent 55%),
                radial-gradient(ellipse 70% 60% at 50% 100%, rgba(167,243,208,0.40) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 80% 60%,  rgba(253,230,138,0.30) 0%, transparent 50%),
                linear-gradient(160deg, #e0f2fe 0%, #f0fdf4 40%, #fdf4ff 80%, #fff7ed 100%) !important;
            min-height: 100vh;
        }

        /* ── Wider sidebar via Flux's CSS var ────────────── */
        :root {
            --flux-sidebar-width: 280px !important;
        }

        .hr-sidebar-glass {
            width: 280px !important;
            min-width: 280px !important;
            height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            background: linear-gradient(
                175deg,
                rgba(7, 28, 48, 0.97) 0%,
                rgba(5, 38, 56, 0.97) 40%,
                rgba(4, 30, 45, 0.98) 100%
            ) !important;
            backdrop-filter: blur(32px) saturate(1.6) !important;
            -webkit-backdrop-filter: blur(32px) saturate(1.6) !important;
            border-right: 1px solid rgba(32,178,170,0.18) !important;
            box-shadow: 4px 0 40px rgba(0,0,0,0.35), inset -1px 0 0 rgba(32,178,170,0.08) !important;
            position: relative !important;
        }

        .hr-sidebar-glass .gs-nav-scroll {
            flex: 1 1 0%;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 8px;
        }

        .hr-sidebar-glass .gs-nav-scroll::-webkit-scrollbar { width: 3px; }
        .hr-sidebar-glass .gs-nav-scroll::-webkit-scrollbar-track { background: transparent; }
        .hr-sidebar-glass .gs-nav-scroll::-webkit-scrollbar-thumb { background: rgba(20,184,166,0.22); border-radius: 4px; }
        .hr-sidebar-glass .gs-nav-scroll::-webkit-scrollbar-thumb:hover { background: rgba(20,184,166,0.4); }

        .hr-sidebar-glass .gs-sidebar-footer {
            flex-shrink: 0;
            border-top: 1px solid rgba(32,178,170,0.12);
            padding: 10px 0 6px;
        }

        .hr-sidebar-glass::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(32,210,200,0.5), transparent);
            z-index: 10;
            pointer-events: none;
        }

        .gs-glow-1 {
            position: absolute;
            top: -80px; left: -50px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(20,184,166,0.16) 0%, transparent 65%);
            pointer-events: none; z-index: 0;
        }

        .gs-glow-2 {
            position: absolute;
            bottom: 20px; right: -70px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,0.12) 0%, transparent 65%);
            pointer-events: none; z-index: 0;
        }

        .gs-glow-3 {
            position: absolute;
            top: 45%; left: 50%;
            transform: translate(-50%, -50%);
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.06) 0%, transparent 70%);
            pointer-events: none; z-index: 0;
        }

        .hr-sidebar-glass > *:not(.gs-glow-1):not(.gs-glow-2):not(.gs-glow-3) {
            position: relative;
            z-index: 1;
        }

        /* ── Logo ────────────────────────────────────────── */
        .gs-logo {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(32,178,170,0.14);
            flex-shrink: 0;
        }

        .gs-logo-mark {
            width: 42px; height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(13,148,136,0.5), inset 0 1px 0 rgba(255,255,255,0.25);
        }

        .gs-logo-mark svg {
            width: 20px; height: 20px;
            stroke: #fff; fill: none; stroke-width: 2;
        }

        .gs-logo-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 16px; font-weight: 600;
            color: #ffffff;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .gs-logo-sub {
            font-family: 'DM Sans', sans-serif;
            font-size: 10px; font-weight: 500;
            color: rgba(94,234,212,0.55);
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* ── Nav links ───────────────────────────────────── */
        .hr-sidebar-glass a[href] {
            color: rgba(255, 255, 255, 0.72) !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 14px !important;
            border-radius: 11px !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            transition: background 0.15s, color 0.15s, transform 0.12s !important;
        }

        .hr-sidebar-glass a[href]:hover {
            background: rgba(20,184,166,0.13) !important;
            color: #ffffff !important;
            transform: translateX(2px);
            box-shadow: inset 0 0 0 1px rgba(20,184,166,0.18) !important;
        }

        /* ── Active page ─────────────────────────────────── */
        .hr-sidebar-glass a[aria-current="page"],
        .hr-sidebar-glass a[aria-current="true"],
        .hr-sidebar-glass a.active,
        .hr-sidebar-glass [class*="navlist-item"][aria-current="page"],
        .hr-sidebar-glass [class*="navlist-item"].active,
        .hr-sidebar-glass li > a[aria-current="page"],
        .hr-sidebar-glass [data-active="true"],
        .hr-sidebar-glass [data-flux-navlist-item][aria-current="page"] {
            background: rgba(13,148,136,0.28) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: inset 0 0 0 1px rgba(20,184,166,0.32), 0 2px 14px rgba(13,148,136,0.22) !important;
            border-radius: 11px !important;
        }

        .hr-sidebar-glass a[aria-current="page"] *,
        .hr-sidebar-glass a[aria-current="true"] *,
        .hr-sidebar-glass a.active *,
        .hr-sidebar-glass [data-flux-navlist-item][aria-current="page"] * {
            color: #ffffff !important;
            background: transparent !important;
        }

        .hr-sidebar-glass a[aria-current="page"] svg,
        .hr-sidebar-glass a[aria-current="true"] svg,
        .hr-sidebar-glass a.active svg,
        .hr-sidebar-glass [data-flux-navlist-item][aria-current="page"] svg {
            stroke: #2dd4bf !important;
            opacity: 1 !important;
        }

        .hr-sidebar-glass [class*="bg-white"],
        .hr-sidebar-glass [class*="bg-gray"],
        .hr-sidebar-glass [class*="bg-zinc"],
        .hr-sidebar-glass [class*="bg-slate"] {
            background: transparent !important;
        }

        .hr-sidebar-glass a[href] svg,
        .hr-sidebar-glass a[href] [data-flux-icon] {
            opacity: 0.5;
            transition: opacity 0.15s;
        }

        .hr-sidebar-glass a[href]:hover svg,
        .hr-sidebar-glass a[href]:hover [data-flux-icon] {
            opacity: 1 !important;
        }

        /* ── Group headings ──────────────────────────────── */
        .hr-sidebar-glass [data-flux-navlist-group] > button,
        .hr-sidebar-glass li > button {
            color: rgba(255, 255, 255, 0.38) !important;
            font-size: 10.5px !important;
            letter-spacing: 0.12em !important;
            text-transform: uppercase !important;
            font-weight: 600 !important;
            font-family: 'DM Sans', sans-serif !important;
        }

        .hr-sidebar-glass [data-flux-navlist-group] > button:hover {
            color: rgba(255,255,255,0.65) !important;
        }

        .hr-sidebar-glass [data-flux-navlist-group] > button svg {
            color: rgba(255,255,255,0.3) !important;
            opacity: 1 !important;
        }

        /* ── Separator ───────────────────────────────────── */
        .hr-sidebar-glass hr,
        .hr-sidebar-glass [data-flux-separator] {
            border-color: rgba(32,178,170,0.12) !important;
        }

        /* ── Badges ──────────────────────────────────────── */
        .hr-sidebar-glass [data-flux-badge],
        .hr-sidebar-glass [class*="badge"] {
            background: rgba(239,68,68,0.75) !important;
            color: #fff !important;
        }

        /* ── Profile button ──────────────────────────────── */
        .hr-sidebar-glass [data-flux-profile],
        .hr-sidebar-glass button[class*="profile"] {
            background: rgba(13,148,136,0.14) !important;
            border: 1px solid rgba(32,178,170,0.2) !important;
            border-radius: 13px !important;
        }

        .hr-sidebar-glass [data-flux-profile]:hover {
            background: rgba(13,148,136,0.22) !important;
        }

        .hr-sidebar-glass [data-flux-profile] span,
        .hr-sidebar-glass [data-flux-profile] p,
        .hr-sidebar-glass [data-flux-profile] * {
            color: #ffffff !important;
        }

        /* ── Dropdown menu ───────────────────────────────── */
        [data-flux-menu],
        [data-flux-dropdown] [role="menu"] {
            background: rgba(5, 32, 46, 0.97) !important;
            backdrop-filter: blur(24px) !important;
            -webkit-backdrop-filter: blur(24px) !important;
            border: 1px solid rgba(32,178,170,0.2) !important;
            border-radius: 14px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.45) !important;
        }

        [data-flux-menu] a,
        [data-flux-menu] button {
            color: rgba(255,255,255,0.8) !important;
            border-radius: 8px !important;
        }

        [data-flux-menu] a:hover,
        [data-flux-menu] button:hover {
            background: rgba(20,184,166,0.14) !important;
            color: #fff !important;
        }

        /* ── Toggle / close button ───────────────────────── */
        .hr-sidebar-glass button {
            color: rgba(255,255,255,0.45) !important;
        }

        /* ── Scrollbar (global) ──────────────────────────── */
        .hr-sidebar-glass ::-webkit-scrollbar { width: 3px; }
        .hr-sidebar-glass ::-webkit-scrollbar-track { background: transparent; }
        .hr-sidebar-glass ::-webkit-scrollbar-thumb { background: rgba(20,184,166,0.22); border-radius: 4px; }
        .hr-sidebar-glass ::-webkit-scrollbar-thumb:hover { background: rgba(20,184,166,0.4); }

        /* ════════════════════════════════════════════════════
           FIX: Flux sidebar stash overlay blocks all clicks
           The overlay sits fixed inset-0 z-10 with
           pointer-events:auto even when visually hidden.
        ════════════════════════════════════════════════════ */

        /* Target the Flux stash overlay directly by its exact classes */
        .fixed.inset-0.hidden,
        [class~="hidden"][class~="fixed"][class~="inset-0"] {
            pointer-events: none !important;
        }

        /* Also target via Alpine — when x-show hides it, ensure no blocking */
        [x-show][style*="display: none"] {
            pointer-events: none !important;
        }

        /* flux:main must NOT create a stacking context that traps z-index.
           overflow-scroll creates a stacking context — use overflow:auto
           and isolate:auto to prevent z-index trapping inside it. */
        [data-flux-main] {
            isolation: auto !important;
            overflow: auto !important;
            /* Do not use overflow:scroll — it creates a stacking context */
        }

        /* Raise HR page roots above the overlay (z-10) */
        .hlm-root, .hc-root, .hpc-root, .huc-root,
        .lad-root, .hlr-root, .hcom-root {
            position: relative;
            z-index: 15;
        }

        /* Glass cards above overlay */
        .g-card {
            position: relative;
            z-index: 15;
        }

        /* Modals above everything */
        .hlm-modal-bg {
            z-index: 60 !important;
        }

        /* Alpine x-cloak */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen scrollbar-custom">

<flux:sidebar sticky stashable class="hr-sidebar-glass scrollbar-custom">

    <div class="gs-glow-1" aria-hidden="true"></div>
    <div class="gs-glow-2" aria-hidden="true"></div>
    <div class="gs-glow-3" aria-hidden="true"></div>

    <div class="gs-logo">
        <div class="gs-logo-mark">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
        </div>
        <div>
            <div class="gs-logo-name">TalentFlow</div>
            <div class="gs-logo-sub">Pro</div>
        </div>
    </div>

    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>
    <flux:separator/>

    <div class="gs-nav-scroll">
        @auth
            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" href="{{ route('home') }}" wire:navigate>HR Dashboard</flux:navlist.item>

                <flux:navlist.group expandable heading="Employee Management">
                    <flux:navlist.item icon="users" href="{{ route('employees') }}" wire:navigate>Employees</flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" href="{{ route('contracts') }}" wire:navigate>Employment Contracts</flux:navlist.item>
                    <flux:navlist.item icon="hashtag" href="{{ route('positions') }}" wire:navigate>Positions/Designations</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group expandable heading="Leave & Attendance">
                    <flux:navlist.item icon="calendar-days" href="{{ route('leave-attendance.dashboard') }}" wire:navigate>Leave Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="document-plus" href="{{ route('leave-attendance.requests') }}" wire:navigate>Leave Requests</flux:navlist.item>
                    <flux:navlist.item icon="check-circle" href="{{ route('leave-attendance.hr-leave-management') }}" wire:navigate>Manage Leave</flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-left-right" href="{{ route('leave-attendance.hr-communication') }}" wire:navigate>HR Communications</flux:navlist.item>
                    <flux:navlist.item icon="calendar" href="{{ route('leave-attendance.hr-calendar') }}" wire:navigate>HR Calendar</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group expandable heading="Payroll Management">
                    <flux:navlist.item icon="calculator" href="{{ route('payroll.dashboard') }}" wire:navigate>Payroll Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="banknotes" href="{{ route('payroll.entries') }}" wire:navigate>Payroll Entries</flux:navlist.item>
                    <flux:navlist.item icon="calendar" href="{{ route('payroll.months') }}" wire:navigate>Payroll Months</flux:navlist.item>
                    <flux:navlist.item icon="document-text" href="{{ route('payroll.payslip-generator') }}" wire:navigate>Payslip Generator</flux:navlist.item>
                    <flux:navlist.item icon="calculator" href="{{ route('payroll.tax-calculator') }}" wire:navigate>Tax Calculator</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group expandable heading="Performance & Analytics">
                    <flux:navlist.item icon="chart-bar" href="{{ route('performance.dashboard') }}" wire:navigate>Performance Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="star" href="{{ route('performance.kpi-management') }}" wire:navigate>KPI Management</flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" href="{{ route('analytics.dashboard') }}" wire:navigate>Analytics Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="document-text" href="{{ route('analytics.report-builder') }}" wire:navigate>Report Builder</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group expandable heading="System & Settings">
                    <flux:navlist.item icon="bell" href="{{ route('notifications.center') }}" wire:navigate>Notifications</flux:navlist.item>
                    <flux:navlist.item icon="shield-check" href="{{ route('access-control.dashboard') }}" wire:navigate>Access Control</flux:navlist.item>
                    <flux:navlist.item icon="arrow-down-tray" href="{{ route('imports') }}" wire:navigate>Imports/Exports</flux:navlist.item>
                    <flux:navlist.item icon="adjustments-horizontal" href="{{ route('banks') }}" wire:navigate>Banks</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
        @endauth
    </div>

    <div class="gs-sidebar-footer">
        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog" href="#">Settings</flux:navlist.item>
            <flux:navlist.item icon="question-mark-circle" href="#">Help</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="{{ asset('images/user.svg') }}"
                          name="{{Auth::user()->first_name ?? ''}} {{Auth::user()->last_name ?? ''}}"/>
            <flux:menu>
                <flux:menu.item icon="arrow-right" href="{{ route('logout') }}">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>

</flux:sidebar>

{{-- FIX: removed overflow-scroll which creates a stacking context trapping z-index --}}
<flux:main class="!p-0">
    {{ $slot }}
    @yield('commands')
</flux:main>

@livewireScripts
@persist('toast')
<flux:toast/>
@endpersist

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.hr-sidebar-glass')
        || document.querySelector('[data-flux-sidebar]');

    if (sidebar) {
        sidebar.style.setProperty('width', '280px', 'important');
        sidebar.style.setProperty('min-width', '280px', 'important');
        sidebar.style.setProperty('background', 'linear-gradient(175deg, rgba(7,28,48,0.97) 0%, rgba(5,38,56,0.97) 40%, rgba(4,30,45,0.98) 100%)', 'important');
        sidebar.style.setProperty('backdrop-filter', 'blur(32px) saturate(1.6)', 'important');
        sidebar.style.setProperty('-webkit-backdrop-filter', 'blur(32px) saturate(1.6)', 'important');
        sidebar.style.setProperty('border-right', '1px solid rgba(32,178,170,0.18)', 'important');
        sidebar.style.setProperty('box-shadow', '4px 0 40px rgba(0,0,0,0.35)', 'important');
    }

    /* FIX: disable pointer events on the Flux stash overlay when hidden */
    function fixOverlay() {
        document.querySelectorAll('.fixed.inset-0').forEach(el => {
            if (el.classList.contains('hidden') ||
                el.style.display === 'none' ||
                getComputedStyle(el).display === 'none') {
                el.style.setProperty('pointer-events', 'none', 'important');
            }
        });
    }
    fixOverlay();

    /* Re-run after every Livewire navigation so the overlay stays disabled */
    document.addEventListener('livewire:navigated', fixOverlay);
    document.addEventListener('livewire:navigate', fixOverlay);

    /* Watch for the overlay being re-added or toggled */
    new MutationObserver(fixOverlay).observe(document.body, {
        subtree: true, attributes: true, childList: true,
        attributeFilter: ['class', 'style', 'data-show-stashed-sidebar']
    });

    function fixActiveNavItems() {
        const sidebarEl = document.querySelector('.hr-sidebar-glass');
        if (!sidebarEl) return;
        const activeEls = sidebarEl.querySelectorAll('[aria-current="page"],[aria-current="true"],[data-active="true"]');
        activeEls.forEach(el => {
            el.style.setProperty('background', 'rgba(13,148,136,0.28)', 'important');
            el.style.setProperty('color', '#ffffff', 'important');
            el.style.setProperty('border-radius', '11px', 'important');
            el.style.setProperty('box-shadow', 'inset 0 0 0 1px rgba(20,184,166,0.32)', 'important');
            el.style.setProperty('font-weight', '600', 'important');
            el.querySelectorAll('*').forEach(child => {
                child.style.setProperty('color', '#ffffff', 'important');
                if (['svg','path','circle','rect','line'].includes(child.tagName)) {
                    child.style.setProperty('stroke', '#2dd4bf', 'important');
                }
                const bg = window.getComputedStyle(child).backgroundColor;
                if (bg && bg !== 'rgba(0, 0, 0, 0)' && bg !== 'transparent' && !bg.includes('13, 148')) {
                    child.style.setProperty('background-color', 'transparent', 'important');
                    child.style.setProperty('background', 'transparent', 'important');
                }
            });
        });
    }

    fixActiveNavItems();
    document.addEventListener('livewire:navigated', fixActiveNavItems);
    document.addEventListener('livewire:navigate', fixActiveNavItems);

    const sidebarEl = document.querySelector('.hr-sidebar-glass');
    if (sidebarEl) {
        new MutationObserver(fixActiveNavItems).observe(sidebarEl, {
            subtree: true, attributes: true,
            attributeFilter: ['aria-current', 'class', 'data-active']
        });
    }
});
</script>

</body>
</html>
