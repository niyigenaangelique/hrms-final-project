<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @stack('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentFlow Pro - Admin Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
           TalentFlow Pro — Admin Layout (Floating Pill Sidebar)
           Matches employee.blade.php design — blue accent
        ══════════════════════════════════════════════════════ */
        :root {
            --tf-bg: #EEF2FA;
            --tf-blue: #3B6FE8;
            --tf-blue-lt: rgba(59, 111, 232, 0.09);
            --tf-blue-pill: rgba(59, 111, 232, 0.13);
            --tf-icon: #9FA3BB;
            --tf-sidebar-bg: rgba(255, 255, 255, 0.80);
            --tf-sidebar-border: rgba(255, 255, 255, 0.95);
            --tf-shadow: 0 8px 40px rgba(59, 111, 232, 0.13), 0 2px 10px rgba(0, 0, 0, 0.05);
            --sb-collapsed: 64px;
            --sb-expanded: 230px;
            --sb-left: 14px;
            --sb-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html.tf-dark {
            --tf-bg: #0E1220;
            --tf-blue: #5B8FF9;
            --tf-blue-lt: rgba(91, 143, 249, 0.11);
            --tf-blue-pill: rgba(91, 143, 249, 0.18);
            --tf-icon: #525570;
            --tf-sidebar-bg: rgba(18, 22, 42, 0.88);
            --tf-sidebar-border: rgba(255, 255, 255, 0.06);
            --tf-shadow: 0 8px 40px rgba(0, 0, 0, 0.50);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            background: var(--tf-bg) !important;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.25s;
            margin: 0;
        }

        /* Hide Flux's own sidebar — we render our own */
        [data-flux-sidebar],
        [data-flux-sidebar]>div:first-child {
            display: none !important;
        }

        .tf-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── Floating Sidebar ── */
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

        /* ── Logo ── */
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
            background: linear-gradient(135deg, #3B6FE8 0%, #6B4FDB 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(59, 111, 232, 0.35);
        }

        .tf-logo-mark svg {
            width: 17px;
            height: 17px;
            stroke: #fff;
            fill: none;
            stroke-width: 2.3;
        }

        .tf-logo-name {
            font-family: 'Sora', sans-serif;
            font-size: 13.5px;
            font-weight: 800;
            color: var(--tf-blue);
            letter-spacing: -0.3px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.15s 0.06s;
        }

        .tf-sidebar:hover .tf-logo-name,
        .tf-sidebar.tf-pinned .tf-logo-name {
            opacity: 1;
        }

        .tf-divider {
            width: 40px;
            height: 1px;
            background: rgba(59, 111, 232, 0.10);
            flex-shrink: 0;
            margin-bottom: 6px;
            transition: width var(--sb-transition);
        }

        .tf-sidebar:hover .tf-divider,
        .tf-sidebar.tf-pinned .tf-divider {
            width: calc(100% - 24px);
            margin: 0 12px 6px;
        }

        /* ── Nav ── */
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

        .tf-nav::-webkit-scrollbar {
            width: 0;
        }

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

        .tf-nav-item:hover {
            background: var(--tf-blue-lt);
            color: var(--tf-blue);
        }

        .tf-nav-item.active {
            background: var(--tf-blue-pill);
            color: var(--tf-blue);
        }

        .tf-nav-item svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.7;
            flex-shrink: 0;
            min-width: 19px;
        }

        .tf-nav-label {
            font-size: 13px;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.15s 0.05s;
        }

        .tf-sidebar:hover .tf-nav-label,
        .tf-sidebar.tf-pinned .tf-nav-label {
            opacity: 1;
        }

        .tf-nav-section {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.10em;
            text-transform: uppercase;
            color: var(--tf-blue);
            padding: 10px 12px 2px;
            opacity: 0;
            transition: opacity 0.15s 0.05s;
            white-space: nowrap;
        }

        .tf-sidebar:hover .tf-nav-section,
        .tf-sidebar.tf-pinned .tf-nav-section {
            opacity: 0.7;
        }

        /* Tooltip — shows only when collapsed */
        .tf-tooltip {
            position: absolute;
            left: calc(var(--sb-collapsed) - var(--sb-left) + 20px);
            top: 50%;
            transform: translateY(-50%);
            background: #1A3FA8;
            color: #fff;
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 8px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.1s;
            z-index: 200;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .tf-tooltip::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1A3FA8;
            border-left: none;
        }

        .tf-sidebar:not(:hover):not(.tf-pinned) .tf-nav-item:hover .tf-tooltip {
            opacity: 1;
        }

        /* ── Footer ── */
        .tf-sidebar-foot {
            width: 100%;
            padding: 6px 8px 14px;
            display: flex;
            flex-direction: column;
            gap: 1px;
            flex-shrink: 0;
        }

        .tf-foot-divider {
            width: 40px;
            height: 1px;
            background: rgba(59, 111, 232, 0.10);
            margin: 0 auto 4px;
            transition: width var(--sb-transition);
        }

        .tf-sidebar:hover .tf-foot-divider,
        .tf-sidebar.tf-pinned .tf-foot-divider {
            width: calc(100% - 24px);
            margin: 0 12px 4px;
        }

        .tf-foot-item {
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
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        .tf-foot-item:hover {
            background: var(--tf-blue-lt);
            color: var(--tf-blue);
        }

        .tf-foot-item svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.7;
            flex-shrink: 0;
            min-width: 19px;
        }

        .tf-foot-label {
            font-size: 13px;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.15s 0.05s;
        }

        .tf-sidebar:hover .tf-foot-label,
        .tf-sidebar.tf-pinned .tf-foot-label {
            opacity: 1;
        }

        .tf-foot-tooltip {
            position: absolute;
            left: calc(var(--sb-collapsed) - var(--sb-left) + 20px);
            top: 50%;
            transform: translateY(-50%);
            background: #1A3FA8;
            color: #fff;
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 8px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.1s;
            z-index: 200;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .tf-foot-tooltip::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1A3FA8;
            border-left: none;
        }

        .tf-sidebar:not(:hover):not(.tf-pinned) .tf-foot-item:hover .tf-foot-tooltip {
            opacity: 1;
        }

        /* ── Mode Pill ── */
        .tf-mode-wrap {
            display: flex;
            justify-content: center;
            padding: 6px 4px 0;
            width: 100%;
        }

        .tf-mode-pill {
            display: flex;
            background: var(--tf-blue-lt);
            border-radius: 100px;
            padding: 3px;
            gap: 2px;
            width: 46px;
            transition: width var(--sb-transition);
            overflow: hidden;
        }

        .tf-sidebar:hover .tf-mode-pill,
        .tf-sidebar.tf-pinned .tf-mode-pill {
            width: calc(100% - 8px);
        }

        .tf-mode-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 5px 6px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            color: var(--tf-icon);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }

        .tf-mode-btn svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .tf-mode-btn.active {
            background: #fff;
            color: var(--tf-blue);
            box-shadow: 0 1px 4px rgba(59, 111, 232, 0.15);
        }

        html.tf-dark .tf-mode-btn.active {
            background: rgba(255, 255, 255, 0.10);
        }

        .tf-mode-text {
            opacity: 0;
            transition: opacity 0.15s 0.05s;
        }

        .tf-sidebar:hover .tf-mode-text,
        .tf-sidebar.tf-pinned .tf-mode-text {
            opacity: 1;
        }

        /* ── z-index fixes (modals above overlay) ── */
        .hlm-root,
        .hc-root,
        .hpc-root,
        .huc-root,
        .lad-root,
        .hlr-root,
        .hcom-root,
        .la-shell,
        .um-root {
            position: relative;
            z-index: 15;
        }

        .g-card {
            position: relative;
            z-index: 15;
        }

        .hlm-modal-bg,
        .um-modal-bg {
            z-index: 60 !important;
        }

        [x-cloak] {
            display: none !important;
        }

        /* ── Main ── */
        .tf-main-wrapper {
            margin-left: calc(var(--sb-collapsed) + var(--sb-left) + 14px);
            flex: 1;
            min-width: 0;
            transition: margin-left var(--sb-transition);
        }

        .tf-main-wrapper.tf-pinned {
            margin-left: calc(var(--sb-expanded) + var(--sb-left) + 14px);
        }

        [data-flux-main] {
            background: transparent !important;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(59, 111, 232, 0.15);
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen">
    <div class="tf-layout">

        {{-- ══ FLOATING PILL SIDEBAR ══ --}}
        <div class="tf-sidebar" id="tfSidebar">

            {{-- Logo --}}
            <div class="tf-logo-wrap">
                <div class="tf-logo-mark">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <span class="tf-logo-name">TalentFlow · Admin</span>
            </div>

            <div class="tf-divider"></div>

            <nav class="tf-nav">
                @auth

                <a href="{{ route('admin.dashboard') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    <span class="tf-nav-label">Dashboard</span>
                    <span class="tf-tooltip">Dashboard</span>
                </a>

                <div class="tf-nav-section">System Access</div>

                <a href="{{ route('admin.users') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/></svg>
                    <span class="tf-nav-label">User Accounts</span>
                    <span class="tf-tooltip">User Accounts</span>
                </a>

                <a href="{{ route('admin.access-control') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.access-control') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span class="tf-nav-label">Role Management</span>
                    <span class="tf-tooltip">Role Management</span>
                </a>

                <a href="{{ route('admin.permissions') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.permissions') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                    <span class="tf-nav-label">Permissions Matrix</span>
                    <span class="tf-tooltip">Permissions Matrix</span>
                </a>

                <div class="tf-nav-section">Security</div>

                <a href="{{ route('admin.active-sessions') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.active-sessions') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    <span class="tf-nav-label">Session Management</span>
                    <span class="tf-tooltip">Session Management</span>
                </a>

                <a href="{{ route('admin.password-reset') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.password-reset') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span class="tf-nav-label">Password Reset</span>
                    <span class="tf-tooltip">Password Reset</span>
                </a>

                <a href="{{ route('admin.security-settings') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.security-settings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="8 12 11 15 16 9"/></svg>
                    <span class="tf-nav-label">Security Settings</span>
                    <span class="tf-tooltip">Security Settings</span>
                </a>
                
                <div class="tf-nav-section">System Logs</div>

                <a href="{{ route('admin.activity-logs') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('admin.activity-logs') && !request()->query('type') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span class="tf-nav-label">Activity Log</span>
                    <span class="tf-tooltip">Activity Log</span>
                </a>

                <a href="{{ route('admin.activity-logs', ['type' => 'audit']) }}" wire:navigate
                   class="tf-nav-item {{ request()->query('type') === 'audit' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <span class="tf-nav-label">Audit Trail</span>
                    <span class="tf-tooltip">Audit Trail</span>
                </a>

                <div class="tf-nav-section">Navigation</div>

                <a href="{{ route('home') }}" wire:navigate
                   class="tf-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    <span class="tf-nav-label">Back to App</span>
                    <span class="tf-tooltip">Back to App</span>
                </a>

                @endauth
            </nav>

            <div class="tf-sidebar-foot">
                <div class="tf-foot-divider"></div>

                {{-- Pin sidebar --}}
                <div class="tf-foot-item" id="tfPinBtn">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="17" x2="12" y2="22" />
                        <path
                            d="M5 17h14v-1.76a2 2 0 00-1.11-1.79l-1.78-.9A2 2 0 0115 10.76V6h1a2 2 0 000-4H8a2 2 0 000 4h1v4.76a2 2 0 01-1.11 1.79l-1.78.9A2 2 0 005 15.24V17z" />
                    </svg>
                    <span class="tf-foot-label" id="tfPinLabel">Pin Sidebar</span>
                    <span class="tf-foot-tooltip">Pin Sidebar</span>
                </div>

                {{-- Logout --}}
                <a href="{{ route('logout') }}" wire:navigate class="tf-foot-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span class="tf-foot-label">Logout</span>
                    <span class="tf-foot-tooltip">Logout</span>
                </a>

                {{-- Light / Dark mode --}}
                <div class="tf-mode-wrap">
                    <div class="tf-mode-pill">
                        <div class="tf-mode-btn active" id="lightBtn">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="4" />
                                <path
                                    d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                            </svg>
                            <span class="tf-mode-text">Light</span>
                        </div>
                        <div class="tf-mode-btn" id="darkBtn">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                            </svg>
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
                @yield('commands')
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
            var PIN_KEY = 'tf-admin-pinned';

            var sidebar = document.getElementById('tfSidebar');
            var mainWrapper = document.getElementById('tfMainWrapper');
            var pinBtn = document.getElementById('tfPinBtn');
            var pinLabel = document.getElementById('tfPinLabel');
            var lightBtn = document.getElementById('lightBtn');
            var darkBtn = document.getElementById('darkBtn');

            /* ── Dark mode ── */
            function applyDark(on) {
                document.documentElement.classList.toggle('tf-dark', on);
                document.documentElement.classList.toggle('dark', on);
                if (lightBtn) lightBtn.classList.toggle('active', !on);
                if (darkBtn) darkBtn.classList.toggle('active', on);
                try { localStorage.setItem(DARK_KEY, on ? 'true' : 'false'); } catch (e) { }
            }
            var isDark = false;
            try { isDark = localStorage.getItem(DARK_KEY) === 'true'; } catch (e) { }
            applyDark(isDark);
            if (lightBtn) lightBtn.addEventListener('click', function () { applyDark(false); });
            if (darkBtn) darkBtn.addEventListener('click', function () { applyDark(true); });

            /* ── Pin ── */
            var isPinned = false;
            function applyPin(on) {
                isPinned = on;
                if (sidebar) sidebar.classList.toggle('tf-pinned', on);
                if (mainWrapper) mainWrapper.classList.toggle('tf-pinned', on);
                if (pinLabel) pinLabel.textContent = on ? 'Unpin Sidebar' : 'Pin Sidebar';
                try { localStorage.setItem(PIN_KEY, on ? 'true' : 'false'); } catch (e) { }
            }
            try { isPinned = localStorage.getItem(PIN_KEY) === 'true'; } catch (e) { }
            applyPin(isPinned);
            if (pinBtn) pinBtn.addEventListener('click', function () { applyPin(!isPinned); });

            /* ── Active nav highlight ── */
            function highlightActive() {
                var path = window.location.pathname;
                document.querySelectorAll('.tf-nav-item').forEach(function (a) {
                    a.classList.toggle('active', a.getAttribute('href') === path);
                });
            }
            document.addEventListener('livewire:navigated', function () {
                var dark = false;
                try { dark = localStorage.getItem(DARK_KEY) === 'true'; } catch (e) { }
                applyDark(dark);
                highlightActive();
            });
            highlightActive();
        })();
    </script>

    @stack('scripts')
</body>

</html>