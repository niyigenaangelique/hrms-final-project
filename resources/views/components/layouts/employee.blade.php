<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentFlow Pro - Employee Dashboard' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite('resources/css/app.css')
    @endif
    @fluxAppearance
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ══════════════════════════════════════════════════════
           TalentFlow Pro — Floating Pill Sidebar
           Glassmorphism white pill, purple accent, icon-only default.
           Expands on hover to show labels. Pin button locks it open.
        ══════════════════════════════════════════════════════ */

        :root {
            --tf-bg:              #EDEAF8;
            --tf-purple:          #5B4FDB;
            --tf-purple-lt:       rgba(91,79,219,0.09);
            --tf-purple-pill:     rgba(91,79,219,0.12);
            --tf-icon:            #9FA3BB;
            --tf-sidebar-bg:      rgba(255,255,255,0.75);
            --tf-sidebar-border:  rgba(255,255,255,0.95);
            --tf-shadow:          0 8px 40px rgba(91,79,219,0.13), 0 2px 10px rgba(0,0,0,0.05);
            --sb-collapsed:       64px;
            --sb-expanded:        220px;
            --sb-left:            14px;
            --sb-transition:      0.3s cubic-bezier(0.4,0,0.2,1);
        }

        html.tf-dark {
            --tf-bg:              #100F1C;
            --tf-purple:          #7B6FEF;
            --tf-purple-lt:       rgba(123,111,239,0.11);
            --tf-purple-pill:     rgba(123,111,239,0.18);
            --tf-icon:            #525570;
            --tf-sidebar-bg:      rgba(22,20,38,0.82);
            --tf-sidebar-border:  rgba(255,255,255,0.06);
            --tf-shadow:          0 8px 40px rgba(0,0,0,0.45);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--tf-bg) !important;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.25s;
            margin: 0;
        }

        /* Hide Flux's own sidebar */
        [data-flux-sidebar],
        [data-flux-sidebar] > div:first-child { display: none !important; }

        /* ── Layout shell ─────────────────────────────────── */
        .tf-layout { display: flex; min-height: 100vh; }

        /* ── Floating pill sidebar ────────────────────────── */
        .tf-sidebar {
            position: fixed;
            top: 50%;
            left: var(--sb-left);
            transform: translateY(-50%);
            max-height: calc(100vh - 36px);
            width: var(--sb-collapsed);
            background: var(--tf-sidebar-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1.5px solid var(--tf-sidebar-border);
            border-radius: 22px;
            box-shadow: var(--tf-shadow);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            z-index: 50;
            transition: width var(--sb-transition);
        }

        .tf-sidebar:hover,
        .tf-sidebar.tf-pinned {
            width: var(--sb-expanded);
            align-items: flex-start;
        }

        /* ── Logo ─────────────────────────────────────────── */
        .tf-logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 0 14px;
            width: 100%;
            justify-content: center;
            flex-shrink: 0;
        }

        .tf-sidebar:hover .tf-logo-wrap,
        .tf-sidebar.tf-pinned .tf-logo-wrap {
            padding: 18px 14px 14px;
            justify-content: flex-start;
        }

        .tf-logo-mark {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #5B4FDB 0%, #8B5CF6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(91,79,219,0.32);
        }

        .tf-logo-mark svg {
            width: 17px; height: 17px;
            stroke: #fff; fill: none; stroke-width: 2.3;
        }

        .tf-logo-name {
            font-family: 'Sora', sans-serif;
            font-size: 13.5px;
            font-weight: 800;
            color: var(--tf-purple);
            letter-spacing: -0.3px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.15s 0.06s;
        }

        .tf-sidebar:hover .tf-logo-name,
        .tf-sidebar.tf-pinned .tf-logo-name { opacity: 1; }

        /* Divider */
        .tf-divider {
            width: 40px;
            height: 1px;
            background: rgba(91,79,219,0.10);
            flex-shrink: 0;
            margin-bottom: 6px;
            transition: width var(--sb-transition);
        }

        .tf-sidebar:hover .tf-divider,
        .tf-sidebar.tf-pinned .tf-divider { width: calc(100% - 24px); margin: 0 12px 6px; }

        /* ── Nav ──────────────────────────────────────────── */
        .tf-nav {
            flex: 1;
            width: 100%;
            padding: 4px 8px;
            display: flex;
            flex-direction: column;
            gap: 1px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .tf-nav::-webkit-scrollbar { width: 0; }

        .tf-nav-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 13px;
            text-decoration: none;
            color: var(--tf-icon);
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
            overflow: hidden;
            flex-shrink: 0;
        }

        .tf-nav-item:hover { background: var(--tf-purple-lt); color: var(--tf-purple); }
        .tf-nav-item.active { background: var(--tf-purple-pill); color: var(--tf-purple); }

        .tf-nav-item svg {
            width: 19px; height: 19px;
            stroke: currentColor; fill: none; stroke-width: 1.7;
            flex-shrink: 0; min-width: 19px;
        }

        .tf-nav-label {
            font-size: 13px; font-weight: 600;
            opacity: 0; transition: opacity 0.15s 0.05s;
        }

        .tf-sidebar:hover .tf-nav-label,
        .tf-sidebar.tf-pinned .tf-nav-label { opacity: 1; }

        /* Tooltip — only shows when collapsed (not hovered/pinned) */
        .tf-tooltip {
            position: absolute;
            left: calc(var(--sb-collapsed) - var(--sb-left) + 20px);
            top: 50%; transform: translateY(-50%);
            background: #2d2770; color: #fff;
            font-size: 11.5px; font-weight: 600;
            padding: 5px 10px; border-radius: 8px;
            white-space: nowrap; pointer-events: none;
            opacity: 0; transition: opacity 0.1s; z-index: 200;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .tf-tooltip::before {
            content: ''; position: absolute;
            left: -5px; top: 50%; transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #2d2770; border-left: none;
        }
        .tf-sidebar:not(:hover):not(.tf-pinned) .tf-nav-item:hover .tf-tooltip { opacity: 1; }

        /* ── Footer ───────────────────────────────────────── */
        .tf-sidebar-foot {
            width: 100%; padding: 6px 8px 14px;
            display: flex; flex-direction: column; gap: 1px; flex-shrink: 0;
        }

        .tf-foot-divider {
            width: 40px; height: 1px;
            background: rgba(91,79,219,0.10);
            margin: 0 auto 4px;
            transition: width var(--sb-transition);
        }
        .tf-sidebar:hover .tf-foot-divider,
        .tf-sidebar.tf-pinned .tf-foot-divider { width: calc(100% - 24px); margin: 0 12px 4px; }

        .tf-foot-item {
            position: relative;
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 13px;
            text-decoration: none; color: var(--tf-icon);
            transition: background 0.15s, color 0.15s;
            white-space: nowrap; overflow: hidden;
            cursor: pointer; background: none; border: none;
            width: 100%;
        }
        .tf-foot-item:hover { background: var(--tf-purple-lt); color: var(--tf-purple); }

        .tf-foot-item svg {
            width: 19px; height: 19px;
            stroke: currentColor; fill: none; stroke-width: 1.7;
            flex-shrink: 0; min-width: 19px;
        }

        .tf-foot-label {
            font-size: 13px; font-weight: 600;
            opacity: 0; transition: opacity 0.15s 0.05s;
        }
        .tf-sidebar:hover .tf-foot-label,
        .tf-sidebar.tf-pinned .tf-foot-label { opacity: 1; }

        .tf-foot-tooltip {
            position: absolute;
            left: calc(var(--sb-collapsed) - var(--sb-left) + 20px);
            top: 50%; transform: translateY(-50%);
            background: #2d2770; color: #fff;
            font-size: 11.5px; font-weight: 600;
            padding: 5px 10px; border-radius: 8px;
            white-space: nowrap; pointer-events: none;
            opacity: 0; transition: opacity 0.1s; z-index: 200;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .tf-foot-tooltip::before {
            content: ''; position: absolute;
            left: -5px; top: 50%; transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #2d2770; border-left: none;
        }
        .tf-sidebar:not(:hover):not(.tf-pinned) .tf-foot-item:hover .tf-foot-tooltip { opacity: 1; }

        /* ── Light/Dark pill ──────────────────────────────── */
        .tf-mode-wrap {
            display: flex; justify-content: center;
            padding: 6px 4px 0; width: 100%;
        }

        .tf-mode-pill {
            display: flex;
            background: var(--tf-purple-lt);
            border-radius: 100px; padding: 3px; gap: 2px;
            width: 46px;
            transition: width var(--sb-transition);
            overflow: hidden;
        }

        .tf-sidebar:hover .tf-mode-pill,
        .tf-sidebar.tf-pinned .tf-mode-pill { width: calc(100% - 8px); }

        .tf-mode-btn {
            flex: 1; display: flex; align-items: center; justify-content: center;
            gap: 5px; padding: 5px 6px; border-radius: 100px;
            font-size: 11px; font-weight: 600;
            color: var(--tf-icon); cursor: pointer;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }
        .tf-mode-btn svg {
            width: 12px; height: 12px;
            stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0;
        }
        .tf-mode-btn.active { background: #fff; color: var(--tf-purple); box-shadow: 0 1px 4px rgba(91,79,219,0.15); }
        html.tf-dark .tf-mode-btn.active { background: rgba(255,255,255,0.10); }

        .tf-mode-text { opacity: 0; transition: opacity 0.15s 0.05s; }
        .tf-sidebar:hover .tf-mode-text,
        .tf-sidebar.tf-pinned .tf-mode-text { opacity: 1; }

        /* ── Main wrapper ─────────────────────────────────── */
        .tf-main-wrapper {
            margin-left: calc(var(--sb-collapsed) + var(--sb-left) + 14px);
            flex: 1; min-width: 0;
            transition: margin-left var(--sb-transition);
        }
        .tf-main-wrapper.tf-pinned {
            margin-left: calc(var(--sb-expanded) + var(--sb-left) + 14px);
        }

        [data-flux-main] { background: transparent !important; }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(91,79,219,0.15); border-radius: 4px; }
    </style>
</head>

<body class="min-h-screen">

<div class="tf-layout">

    {{-- ══ FLOATING PILL SIDEBAR ══ --}}
    <div class="tf-sidebar" id="tfSidebar">

        {{-- Logo --}}
        <div class="tf-logo-wrap">
            <div class="tf-logo-mark">
                <svg viewBox="0 0 24 24">
                    <polyline points="4 17 12 5 20 17" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="7" y1="13" x2="17" y2="13" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="tf-logo-name">TalentFlow</span>
        </div>

        <div class="tf-divider"></div>

        <nav class="tf-nav">

            <a href="{{ route('employee.dashboard') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                <span class="tf-nav-label">Dashboard</span>
                <span class="tf-tooltip">Dashboard</span>
            </a>

            <a href="{{ route('employee.profile') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.profile') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.87 3.13-7 7-7s7 3.13 7 7" stroke-linecap="round"/></svg>
                <span class="tf-nav-label">My Profile</span>
                <span class="tf-tooltip">My Profile</span>
            </a>

            <a href="{{ route('employee.contracts') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.contracts') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke-linecap="round" stroke-linejoin="round"/><polyline points="14 2 14 8 20 8" stroke-linecap="round"/><line x1="16" y1="13" x2="8" y2="13" stroke-linecap="round"/><line x1="16" y1="17" x2="8" y2="17" stroke-linecap="round"/></svg>
                <span class="tf-nav-label">My Contracts</span>
                <span class="tf-tooltip">My Contracts</span>
            </a>

            <a href="{{ route('employee.performance') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.performance') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10" stroke-linecap="round"/><line x1="12" y1="20" x2="12" y2="4" stroke-linecap="round"/><line x1="6" y1="20" x2="6" y2="14" stroke-linecap="round"/></svg>
                <span class="tf-nav-label">Performance</span>
                <span class="tf-tooltip">Performance</span>
            </a>

            <a href="{{ route('employee.leave.request') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.leave.request') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke-linecap="round" stroke-linejoin="round"/><polyline points="14 2 14 8 20 8" stroke-linecap="round"/><line x1="12" y1="18" x2="12" y2="12" stroke-linecap="round"/><line x1="9" y1="15" x2="15" y2="15" stroke-linecap="round"/></svg>
                <span class="tf-nav-label">Manage Leave</span>
                <span class="tf-tooltip">Manage Leave</span>
            </a>

            <a href="{{ route('employee.calendar') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.calendar') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round"/><line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round"/><line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round"/></svg>
                <span class="tf-nav-label">My Calendar</span>
                <span class="tf-tooltip">My Calendar</span>
            </a>

            <a href="{{ route('employee.attendance') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.attendance') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="tf-nav-label">Attendance</span>
                <span class="tf-tooltip">Attendance</span>
            </a>

            <a href="{{ route('employee.communication') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.communication') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="tf-nav-label">Messages</span>
                <span class="tf-tooltip">Messages</span>
            </a>

            <a href="{{ route('employee.payroll') }}" wire:navigate
               class="tf-nav-item {{ request()->routeIs('employee.payroll') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="2" y1="10" x2="22" y2="10" stroke-linecap="round"/></svg>
                <span class="tf-nav-label">Payroll</span>
                <span class="tf-tooltip">Payroll</span>
            </a>

        </nav>

        <div class="tf-sidebar-foot">

            <div class="tf-foot-divider"></div>

            {{-- Pin sidebar --}}
            <div class="tf-foot-item" id="tfPinBtn">
                <svg viewBox="0 0 24 24"><line x1="12" y1="17" x2="12" y2="22" stroke-linecap="round"/><path d="M5 17h14v-1.76a2 2 0 00-1.11-1.79l-1.78-.9A2 2 0 0115 10.76V6h1a2 2 0 000-4H8a2 2 0 000 4h1v4.76a2 2 0 01-1.11 1.79l-1.78.9A2 2 0 005 15.24V17z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="tf-foot-label" id="tfPinLabel">Pin Sidebar</span>
                <span class="tf-foot-tooltip">Pin Sidebar</span>
            </div>

            {{-- Logout --}}
            <a href="{{ route('logout') }}" wire:navigate class="tf-foot-item">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke-linecap="round" stroke-linejoin="round"/><polyline points="16 17 21 12 16 7" stroke-linecap="round" stroke-linejoin="round"/><line x1="21" y1="12" x2="9" y2="12" stroke-linecap="round"/></svg>
                <span class="tf-foot-label">Logout</span>
                <span class="tf-foot-tooltip">Logout</span>
            </a>

            {{-- Light / Dark --}}
            <div class="tf-mode-wrap">
                <div class="tf-mode-pill">
                    <div class="tf-mode-btn active" id="lightBtn">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke-linecap="round"/></svg>
                        <span class="tf-mode-text">Light</span>
                    </div>
                    <div class="tf-mode-btn" id="darkBtn">
                        <svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="tf-mode-text">Dark</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ══ MAIN CONTENT ══ --}}
    <div class="tf-main-wrapper" id="tfMainWrapper">
        <flux:sidebar sticky stashable></flux:sidebar>
        <flux:main class="!p-0 overflow-scroll">
            {{ $slot }}
        </flux:main>
    </div>

</div>

@livewireScripts

@persist('toast')
<flux:toast />
@endpersist

<script>
(function () {
    var DARK_KEY = 'tf-dark';
    var PIN_KEY  = 'tf-pinned';

    var sidebar     = document.getElementById('tfSidebar');
    var mainWrapper = document.getElementById('tfMainWrapper');
    var pinBtn      = document.getElementById('tfPinBtn');
    var pinLabel    = document.getElementById('tfPinLabel');
    var lightBtn    = document.getElementById('lightBtn');
    var darkBtn     = document.getElementById('darkBtn');

    /* ── Dark mode ── */
    function applyDark(on) {
        document.documentElement.classList.toggle('tf-dark', on);
        document.documentElement.classList.toggle('dark', on);
        lightBtn.classList.toggle('active', !on);
        darkBtn.classList.toggle('active', on);
        try { localStorage.setItem(DARK_KEY, on ? 'true' : 'false'); } catch(e) {}
    }
    var isDark = false;
    try { isDark = localStorage.getItem(DARK_KEY) === 'true'; } catch(e) {}
    applyDark(isDark);

    lightBtn.addEventListener('click', function() { applyDark(false); });
    darkBtn.addEventListener('click',  function() { applyDark(true);  });

    /* ── Pin ── */
    var isPinned = false;
    function applyPin(on) {
        isPinned = on;
        sidebar.classList.toggle('tf-pinned', on);
        mainWrapper.classList.toggle('tf-pinned', on);
        if (pinLabel) pinLabel.textContent = on ? 'Unpin Sidebar' : 'Pin Sidebar';
        try { localStorage.setItem(PIN_KEY, on ? 'true' : 'false'); } catch(e) {}
    }
    try { isPinned = localStorage.getItem(PIN_KEY) === 'true'; } catch(e) {}
    applyPin(isPinned);

    if (pinBtn) {
        pinBtn.addEventListener('click', function() { applyPin(!isPinned); });
    }

    /* ── Active nav on Livewire navigate ── */
    function highlightActive() {
        var path = window.location.pathname;
        document.querySelectorAll('.tf-nav-item').forEach(function(a) {
            a.classList.toggle('active', a.getAttribute('href') === path);
        });
    }
    document.addEventListener('livewire:navigated', function() {
        var dark = false;
        try { dark = localStorage.getItem(DARK_KEY) === 'true'; } catch(e) {}
        applyDark(dark);
        highlightActive();
    });
    highlightActive();
})();
</script>

</body>
</html>