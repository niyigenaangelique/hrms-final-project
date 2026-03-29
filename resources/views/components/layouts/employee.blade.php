<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentFlow Pro - Employee Dashboard' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet"/>

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
           TalentFlow Pro — Design System
           Sidebar: white bg, filled active pill, search, dark mode
        ══════════════════════════════════════════════════════ */

        /* ── Tokens (light) ───────────────────────────────── */
        :root {
            --tf-blue:      #3B6FE8;
            --tf-blue-lt:   rgba(59,111,232,0.10);
            --tf-ink:       #1A1D2E;
            --tf-ink2:      #3A3D52;
            --tf-ink3:      #8A8FA8;
            --tf-bg:        #EEF2F7;
            --tf-white:     #FFFFFF;
            --tf-border:    rgba(26,29,46,0.09);
            --tf-search-bg: #F4F6FB;
        }

        /* ── Tokens (dark) ────────────────────────────────── */
        html.tf-dark {
            --tf-blue:      #5B8FF9;
            --tf-blue-lt:   rgba(91,143,249,0.12);
            --tf-ink:       #E8EAF0;
            --tf-ink2:      #B0B5C8;
            --tf-ink3:      #5C6070;
            --tf-bg:        #0F1117;
            --tf-white:     #181C27;
            --tf-border:    rgba(255,255,255,0.07);
            --tf-search-bg: rgba(255,255,255,0.05);
        }

        /* ── Global ───────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--tf-bg) !important;
            min-height: 100vh;
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background 0.25s;
        }

        /* ── Flux sidebar wrapper — force white bg ────────── */
        [data-flux-sidebar],
        [data-flux-sidebar] > div:first-child {
            background: var(--tf-white) !important;
            border-right: 1px solid var(--tf-border) !important;
            box-shadow: 2px 0 20px rgba(26,29,46,0.06) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            width: 268px !important;
            min-width: 268px !important;
            transition: background 0.25s, border-color 0.25s !important;
        }

        /* ── Main area ────────────────────────────────────── */
        [data-flux-main] {
            background: var(--tf-bg) !important;
            transition: background 0.25s !important;
        }

        /* ══ NAV ITEMS — base reset ════════════════════════════ */
        [data-flux-sidebar] a[href],
        [data-flux-sidebar] [data-flux-navlist-item] {
            display: flex !important;
            align-items: center !important;
            gap: 11px !important;
            padding: 9px 12px !important;
            border-radius: 10px !important;
            text-decoration: none !important;
            color: var(--tf-ink3) !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            font-family: 'DM Sans', sans-serif !important;
            transition: background 0.15s, color 0.15s !important;
            background: transparent !important;
            backdrop-filter: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        [data-flux-sidebar] a[href]:hover,
        [data-flux-sidebar] [data-flux-navlist-item]:hover {
            background: var(--tf-blue-lt) !important;
            color: var(--tf-blue) !important;
        }

        [data-flux-sidebar] a[href] svg,
        [data-flux-sidebar] [data-flux-navlist-item] svg {
            width: 18px !important;
            height: 18px !important;
            stroke: currentColor !important;
            fill: none !important;
            stroke-width: 1.75 !important;
            flex-shrink: 0 !important;
            opacity: 0.75 !important;
            transition: opacity 0.15s !important;
        }

        [data-flux-sidebar] a[href]:hover svg { opacity: 1 !important; }

        /* ══ ACTIVE — solid filled blue pill ══════════════════ */
        [data-flux-sidebar] a[aria-current="page"],
        [data-flux-sidebar] a[aria-current="true"],
        [data-flux-sidebar] [data-flux-navlist-item][aria-current="page"],
        [data-flux-sidebar] [data-active="true"] {
            background: var(--tf-blue) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(59,111,232,0.28) !important;
        }

        [data-flux-sidebar] a[aria-current="page"] svg,
        [data-flux-sidebar] a[aria-current="true"] svg,
        [data-flux-sidebar] [data-flux-navlist-item][aria-current="page"] svg {
            stroke: #ffffff !important;
            opacity: 1 !important;
            color: #ffffff !important;
        }

        [data-flux-sidebar] a[aria-current="page"] *,
        [data-flux-sidebar] a[aria-current="true"] *,
        [data-flux-sidebar] [data-flux-navlist-item][aria-current="page"] * {
            color: #ffffff !important;
            background: transparent !important;
        }

        /* ── Group heading buttons ────────────────────────── */
        [data-flux-sidebar] button,
        [data-flux-sidebar] [data-flux-navlist-group] > button {
            color: var(--tf-ink3) !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            letter-spacing: 0.09em !important;
            text-transform: uppercase !important;
            font-family: 'DM Sans', sans-serif !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* ── Separator ────────────────────────────────────── */
        [data-flux-sidebar] hr { border-color: var(--tf-border) !important; }

        /* ── Badges ───────────────────────────────────────── */
        [data-flux-sidebar] [data-flux-badge] {
            background: rgba(240,68,56,0.12) !important;
            color: #D92D20 !important; font-weight: 700 !important;
            border-radius: 100px !important; font-size: 10px !important;
        }
        [data-flux-sidebar] a[aria-current="page"] [data-flux-badge] {
            background: rgba(255,255,255,0.25) !important;
            color: #fff !important;
        }

        /* Kill Tailwind bg classes inside sidebar */
        [data-flux-sidebar] [class*="bg-white"],
        [data-flux-sidebar] [class*="bg-gray"],
        [data-flux-sidebar] [class*="bg-zinc"],
        [data-flux-sidebar] [class*="bg-slate"] {
            background: transparent !important;
        }

        /* Scrollbar */
        [data-flux-sidebar] ::-webkit-scrollbar { width: 3px; }
        [data-flux-sidebar] ::-webkit-scrollbar-thumb { background: var(--tf-border); border-radius: 4px; }

        /* ══ CUSTOM SIDEBAR COMPONENTS ════════════════════════ */

        .tf-logo {
            display: flex; align-items: center; gap: 12px;
            padding: 22px 20px 20px;
            border-bottom: 1px solid var(--tf-border);
            flex-shrink: 0;
        }
        .tf-logo-mark {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #3B6FE8 0%, #6B4FDB 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(59,111,232,0.35);
        }
        .tf-logo-mark svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; }
        .tf-logo-name {
            font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 800;
            color: var(--tf-ink); letter-spacing: -0.3px; line-height: 1.2;
        }
        .tf-logo-sub {
            font-size: 10px; font-weight: 700; color: var(--tf-blue);
            letter-spacing: 0.10em; text-transform: uppercase; margin-top: 1px;
        }

        /* Search */
        .tf-search-wrap { padding: 14px 12px 8px; }
        .tf-search-box {
            display: flex; align-items: center; gap: 9px;
            background: var(--tf-search-bg);
            border: 1px solid var(--tf-border);
            border-radius: 10px; padding: 9px 13px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .tf-search-box:focus-within {
            border-color: rgba(59,111,232,0.45);
            box-shadow: 0 0 0 3px rgba(59,111,232,0.09);
        }
        .tf-search-box svg { width: 14px; height: 14px; stroke: var(--tf-ink3); fill: none; flex-shrink: 0; }
        .tf-search-box input {
            border: none; background: transparent; outline: none; width: 100%;
            font-size: 13px; font-weight: 500; color: var(--tf-ink);
            font-family: 'DM Sans', sans-serif;
        }
        .tf-search-box input::placeholder { color: var(--tf-ink3); }

        /* Bottom section */
        .tf-sidebar-bottom {
            border-top: 1px solid var(--tf-border);
            padding: 10px 12px 14px;
        }

        /* User card */
        .tf-user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; background: var(--tf-search-bg);
            border: 1px solid var(--tf-border); border-radius: 12px;
            margin-bottom: 6px; cursor: pointer; transition: background 0.15s;
        }
        .tf-user-card:hover { background: var(--tf-blue-lt); }
        .tf-user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #3B6FE8, #6B4FDB);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .tf-user-info { flex: 1; min-width: 0; }
        .tf-user-name { font-size: 13px; font-weight: 700; color: var(--tf-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tf-user-role { font-size: 11px; font-weight: 500; color: var(--tf-ink3); }
        .tf-chevron { width: 14px; height: 14px; stroke: var(--tf-ink3); fill: none; flex-shrink: 0; }

        /* Logout link */
        .tf-logout {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 12px; border-radius: 10px; text-decoration: none;
            color: var(--tf-ink3); font-size: 13.5px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }
        .tf-logout:hover { background: var(--tf-blue-lt); color: var(--tf-blue); }
        .tf-logout svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.75; flex-shrink: 0; }

        /* Dark mode row */
        .tf-darkmode-row {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 12px; border-radius: 10px; cursor: pointer;
            transition: background 0.15s;
        }
        .tf-darkmode-row:hover { background: var(--tf-blue-lt); }
        #darkModeIcon { width: 18px; height: 18px; stroke: var(--tf-ink3); fill: none; stroke-width: 1.75; flex-shrink: 0; }
        .tf-darkmode-label { font-size: 13.5px; font-weight: 600; color: var(--tf-ink3); flex: 1; }

        /* Toggle switch */
        .tf-toggle { position: relative; display: inline-block; width: 38px; height: 22px; flex-shrink: 0; }
        .tf-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
        .tf-toggle-slider {
            position: absolute; inset: 0; background: #DDE1EC;
            border-radius: 100px; cursor: pointer; transition: background 0.2s;
        }
        .tf-toggle-slider::before {
            content: ''; position: absolute;
            width: 16px; height: 16px; left: 3px; top: 3px;
            background: #fff; border-radius: 50%;
            transition: transform 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.18);
        }
        .tf-toggle input:checked + .tf-toggle-slider { background: var(--tf-blue); }
        .tf-toggle input:checked + .tf-toggle-slider::before { transform: translateX(16px); }

        /* Global scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--tf-border); border-radius: 4px; }
    </style>
</head>

<body class="min-h-screen">

<flux:sidebar sticky stashable>

    {{-- Logo --}}
    <div class="tf-logo">
        <div class="tf-logo-mark">
            <svg viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div>
            <div class="tf-logo-name">TalentFlow</div>
            <div class="tf-logo-sub">Pro</div>
        </div>
    </div>

    {{-- Search --}}
    <div class="tf-search-wrap">
        <div class="tf-search-box">
            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Search...">
        </div>
    </div>

    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    @auth
        <flux:navlist variant="outline">

            <flux:navlist.item icon="home" href="{{ route('employee.dashboard') }}" wire:navigate>
                Dashboard
            </flux:navlist.item>

            <flux:navlist.group expandable heading="Personal" class="hidden lg:grid">
                <flux:navlist.item icon="user" href="{{ route('employee.profile') }}" wire:navigate>
                    My Profile
                </flux:navlist.item>
                <flux:navlist.item icon="document-text" href="{{ route('employee.contracts') }}" wire:navigate>
                    My Contracts
                </flux:navlist.item>
                <flux:navlist.item icon="presentation-chart-line" href="{{ route('employee.performance') }}" wire:navigate>
                    Performance
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group expandable heading="Work Management" class="hidden lg:grid">
                <flux:navlist.item icon="document-plus" href="{{ route('employee.leave.request') }}" wire:navigate>
                    Request Leave
                </flux:navlist.item>
                <flux:navlist.item icon="check-circle" href="{{ route('employee.leave-status') }}" wire:navigate>
                    Leave Status
                </flux:navlist.item>
                <flux:navlist.item icon="calendar" href="{{ route('employee.calendar') }}" wire:navigate>
                    My Calendar
                </flux:navlist.item>
                <flux:navlist.item icon="clock" href="{{ route('employee.attendance') }}" wire:navigate>
                    Attendance
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group expandable heading="Communication" class="hidden lg:grid">
                <flux:navlist.item icon="chat-bubble-left-right" href="{{ route('employee.communication') }}" wire:navigate>
                    Messages
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group expandable heading="Financial" class="hidden lg:grid">
                <flux:navlist.item icon="banknotes" href="{{ route('employee.payroll') }}" wire:navigate>
                    Payroll
                </flux:navlist.item>
            </flux:navlist.group>

        </flux:navlist>
    @endauth

    <flux:spacer/>

    {{-- Bottom: user + logout + dark mode --}}
    <div class="tf-sidebar-bottom">

        @auth
        <div class="tf-user-card">
            <div class="tf-user-avatar">
                {{ strtoupper(substr(Auth::user()->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? '', 0, 1)) }}
            </div>
            <div class="tf-user-info">
                <div class="tf-user-name">{{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}</div>
                <div class="tf-user-role">{{ ucfirst(Auth::user()->role->value ?? 'Employee') }}</div>
            </div>
            <svg class="tf-chevron" viewBox="0 0 24 24" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </div>
        @endauth

        <a href="{{ route('logout') }}" class="tf-logout" wire:navigate>
            <svg viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
        </a>

        <div class="tf-darkmode-row" id="darkModeRow">
            <svg id="darkModeIcon" viewBox="0 0 24 24">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
            </svg>
            <span class="tf-darkmode-label" id="darkModeLabel">Dark Mode</span>
            <label class="tf-toggle" onclick="event.stopPropagation()">
                <input type="checkbox" id="darkModeToggle">
                <span class="tf-toggle-slider"></span>
            </label>
        </div>

    </div>

</flux:sidebar>

<flux:main class="!p-0 overflow-scroll">
    {{ $slot }}
</flux:main>

@livewireScripts

@persist('toast')
<flux:toast/>
@endpersist

<script>
(function () {
    var DARK_KEY  = 'tf-dark';
    var SUN_PATH  = 'M12 17a5 5 0 100-10 5 5 0 000 10zm0-15v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42';
    var MOON_PATH = 'M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z';

    /* ── Apply / remove dark mode ── */
    function applyDark(on) {
        var html = document.documentElement;
        if (on) {
            html.classList.add('tf-dark');
            /* Flux uses 'dark' class for its own dark mode */
            html.classList.add('dark');
        } else {
            html.classList.remove('tf-dark', 'dark');
        }

        var toggle = document.getElementById('darkModeToggle');
        var label  = document.getElementById('darkModeLabel');
        var icon   = document.getElementById('darkModeIcon');

        if (toggle) toggle.checked = on;
        if (label)  label.textContent = on ? 'Light Mode' : 'Dark Mode';
        if (icon) {
            var path = icon.querySelector('path');
            if (path) path.setAttribute('d', on ? SUN_PATH : MOON_PATH);
        }

        try { localStorage.setItem(DARK_KEY, on ? 'true' : 'false'); } catch(e){}
    }

    /* Apply saved preference before first paint */
    var isDark = false;
    try { isDark = localStorage.getItem(DARK_KEY) === 'true'; } catch(e){}
    applyDark(isDark);

    /* ── Enforce active nav item styling after Flux renders ── */
    function enforceActiveNav() {
        var sidebar = document.querySelector('[data-flux-sidebar]');
        if (!sidebar) return;

        var activeEls = sidebar.querySelectorAll(
            '[aria-current="page"],[aria-current="true"],[data-active="true"]'
        );

        activeEls.forEach(function(el) {
            el.style.setProperty('background',   'var(--tf-blue)',                'important');
            el.style.setProperty('color',        '#ffffff',                       'important');
            el.style.setProperty('font-weight',  '700',                           'important');
            el.style.setProperty('box-shadow',   '0 4px 14px rgba(59,111,232,0.28)', 'important');
            el.style.setProperty('border-radius','10px',                          'important');

            el.querySelectorAll('svg, path, circle, rect, line, polyline').forEach(function(s) {
                s.style.setProperty('stroke',  '#ffffff', 'important');
                s.style.setProperty('opacity', '1',       'important');
                s.style.setProperty('color',   '#ffffff', 'important');
            });
            el.querySelectorAll('span, p, div').forEach(function(t) {
                t.style.setProperty('color', '#ffffff', 'important');
            });
        });
    }

    /* ── Wire up controls after DOM is ready ── */
    function init() {
        /* Dark mode toggle */
        var toggle = document.getElementById('darkModeToggle');
        if (toggle) {
            toggle.checked = isDark;
            toggle.addEventListener('change', function() { applyDark(this.checked); });
        }

        /* Clicking the whole row also toggles */
        var row = document.getElementById('darkModeRow');
        if (row) {
            row.addEventListener('click', function(e) {
                if (e.target.closest('label') || e.target.tagName === 'INPUT') return;
                var t = document.getElementById('darkModeToggle');
                if (t) { t.checked = !t.checked; applyDark(t.checked); }
            });
        }

        enforceActiveNav();

        /* Watch for Flux updating aria-current / class */
        var sb = document.querySelector('[data-flux-sidebar]');
        if (sb && window.MutationObserver) {
            new MutationObserver(enforceActiveNav).observe(sb, {
                subtree: true, attributes: true,
                attributeFilter: ['aria-current', 'class', 'data-active']
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    /* Re-apply after Livewire SPA navigation */
    document.addEventListener('livewire:navigated', function() {
        var dark = false;
        try { dark = localStorage.getItem(DARK_KEY) === 'true'; } catch(e){}
        applyDark(dark);
        init();
    });

})();
</script>

</body>
</html>
