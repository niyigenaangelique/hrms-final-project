<div x-data class="ios-root">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

        /* ── iOS 26 Liquid Glass Variables ───────────────────── */
        .ios-root {
            --glass-bg:        rgba(255, 255, 255, 0.45);
            --glass-bg-strong: rgba(255, 255, 255, 0.65);
            --glass-border:    rgba(255, 255, 255, 0.65);
            --glass-shadow:    0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
            --blur:            blur(24px) saturate(1.8);
            --blur-nav:        blur(32px) saturate(2);
            --radius-card:     20px;
            --radius-pill:     100px;
            --text-primary:    rgba(15, 15, 25, 0.96);
            --text-secondary:  rgba(15, 15, 25, 0.72);
            --text-tertiary:   rgba(15, 15, 25, 0.50);
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            position: relative;
            min-height: 100vh;
        }

        /* ── Background mesh (inside root) ───────────────────── */
        .ios-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 80% 60% at 10% 10%,  rgba(186,230,253,0.55) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 5%,   rgba(216,180,254,0.45) 0%, transparent 55%),
                radial-gradient(ellipse 70% 60% at 50% 100%, rgba(167,243,208,0.40) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 80% 60%,  rgba(253,230,138,0.30) 0%, transparent 50%),
                linear-gradient(160deg, #e0f2fe 0%, #f0fdf4 40%, #fdf4ff 80%, #fff7ed 100%);
        }

        /* ── Layout ───────────────────────────────────────────── */
        .ios-main {
            position: relative;
            z-index: 1;
            padding: 36px 40px 130px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 100%;
            margin: 0 auto;
        }

        /* ── Glass card base ──────────────────────────────────── */
        .g-card {
            background: var(--glass-bg);
            backdrop-filter: var(--blur);
            -webkit-backdrop-filter: var(--blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-card);
            box-shadow: var(--glass-shadow);
            padding: 26px;
            transition: box-shadow 0.2s ease;
        }

        /* ── Top bar ──────────────────────────────────────────── */
        .ios-topbar { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 4px; }
        .ios-greeting { font-size: 38px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px; margin: 0; }
        .ios-date { font-size: 15px; font-weight: 500; color: var(--text-secondary); margin: 4px 0 0; }
        .ios-code-badge {
            background: var(--glass-bg-strong);
            backdrop-filter: var(--blur);
            -webkit-backdrop-filter: var(--blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-pill);
            padding: 8px 18px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            letter-spacing: 0.04em;
            box-shadow: var(--glass-shadow);
        }

        /* ── Stat cards ───────────────────────────────────────── */
        .ios-stats { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 12px; }
        .ios-stat {
            background: var(--glass-bg-strong);
            backdrop-filter: var(--blur);
            -webkit-backdrop-filter: var(--blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-card);
            box-shadow: var(--glass-shadow);
            padding: 24px;
            position: relative;
            overflow: hidden;
        }
        .ios-stat::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
        }
        .ios-stat-dot { position: absolute; top: 14px; right: 14px; width: 8px; height: 8px; border-radius: 50%; background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.2); }
        .ios-stat-icon { width: 36px; height: 36px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .ios-stat-icon svg { width: 16px; height: 16px; }
        .ios-icon-green  { background: rgba(34,197,94,0.15); }  .ios-icon-green  svg { stroke: #16a34a; }
        .ios-icon-blue   { background: rgba(59,130,246,0.15); } .ios-icon-blue   svg { stroke: #2563eb; }
        .ios-icon-amber  { background: rgba(245,158,11,0.15); } .ios-icon-amber  svg { stroke: #d97706; }
        .ios-icon-purple { background: rgba(168,85,247,0.15); } .ios-icon-purple svg { stroke: #9333ea; }
        .ios-stat-label { font-size: 13px; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-tertiary); margin-bottom: 4px; font-weight: 700; }
        .ios-stat-value { font-size: 32px; font-weight: 700; color: var(--text-primary); line-height: 1.1; letter-spacing: -0.3px; }
        .ios-stat-name  { font-size: 19px !important; letter-spacing: -0.1px !important; }

        /* ── Charts ───────────────────────────────────────────── */
        .ios-charts { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 12px; }
        .ios-card-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); margin-bottom: 16px; }
        .ios-chart-wrap { position: relative; height: 200px; }

        /* ── Bottom grid ──────────────────────────────────────── */
        .ios-bottom { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 12px; }
        .ios-list-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.06); }
        .ios-list-item:last-child { border-bottom: none; }
        .ios-list-main { font-size: 15px; font-weight: 600; color: var(--text-primary); }
        .ios-list-sub  { font-size: 13px; font-weight: 500; color: var(--text-tertiary); margin-top: 2px; }
        .ios-empty { font-size: 15px; font-weight: 500; color: var(--text-tertiary); text-align: center; padding: 16px 0; margin: 0; }

        /* ── Badges ───────────────────────────────────────────── */
        .ios-badge { font-size: 13px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); flex-shrink: 0; }
        .ios-badge-green  { background: rgba(34,197,94,0.15);  color: #15803d; }
        .ios-badge-amber  { background: rgba(245,158,11,0.15); color: #b45309; }
        .ios-badge-red    { background: rgba(239,68,68,0.15);  color: #b91c1c; }

        /* ── Activity ─────────────────────────────────────────── */
        .ios-activity-item { display: flex; align-items: flex-start; gap: 12px; padding: 9px 0; border-bottom: 1px solid rgba(0,0,0,0.06); }
        .ios-activity-item:last-child { border-bottom: none; }
        .ios-act-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
        .ios-act-time { font-size: 13px; font-weight: 500; color: var(--text-tertiary); margin-top: 2px; }

        /* ── Floating nav bar ─────────────────────────────────── */
        .ios-nav {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 2px;
            background: rgba(15, 15, 25, 0.75);
            backdrop-filter: var(--blur-nav);
            -webkit-backdrop-filter: var(--blur-nav);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 28px;
            padding: 8px 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
        }

        .ios-nav::before {
            content: '';
            position: absolute;
            top: 0; left: 16px; right: 16px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
        }

        .ios-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding: 8px 18px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 500;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.03em;
            min-width: 64px;
            position: relative;
            transition: background 0.2s, color 0.2s, transform 0.15s;
        }

        .ios-nav-item svg {
            width: 20px; height: 20px;
            stroke: currentColor;
            transition: transform 0.2s;
        }

        .ios-nav-item:hover {
            color: rgba(255,255,255,0.85);
            background: rgba(255,255,255,0.08);
            transform: translateY(-1px);
        }

        .ios-nav-item:hover svg { transform: scale(1.1); }

        .ios-nav-item.active {
            color: #fff;
            background: rgba(255,255,255,0.15);
        }

        .ios-nav-item.active svg { stroke: #60a5fa; }

        .ios-nav-active-dot {
            position: absolute;
            bottom: 4px;
            width: 4px; height: 4px;
            border-radius: 50%;
            background: #60a5fa;
        }

        .ios-notif-bubble {
            position: absolute;
            top: 5px; right: 10px;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #ef4444;
            border: 1.5px solid rgba(15,15,25,0.75);
        }

        /* ── Responsive ───────────────────────────────────────── */
        @media (max-width: 1024px) {
            .ios-stats  { grid-template-columns: repeat(2, 1fr); }
            .ios-charts { grid-template-columns: 1fr; }
            .ios-bottom { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .ios-main { padding: 16px 14px 110px; gap: 12px; }
            .ios-greeting { font-size: 26px; }
            .ios-nav { bottom: 14px; padding: 6px 8px; }
            .ios-nav-item { padding: 7px 12px; min-width: 52px; font-size: 9px; }
            .ios-nav-item svg { width: 18px; height: 18px; }
        }
    </style>

    {{-- Gradient mesh background --}}
    <div class="ios-bg" aria-hidden="true"></div>

    {{-- Page content --}}
    <div class="ios-main">

        {{-- Top bar --}}
        <div class="ios-topbar">
            <div>
                <h1 class="ios-greeting">Hello, {{ Auth::user()->first_name }}! 👋</h1>
                <p class="ios-date">{{ now()->format('l, j F Y') }}</p>
            </div>
            <div class="ios-code-badge">{{ $employee->code }}</div>
        </div>

        {{-- Stat cards --}}
        <div class="ios-stats">
            <div class="ios-stat">
                <div class="ios-stat-icon ios-icon-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0114 0"/></svg>
                </div>
                <div class="ios-stat-label">Name</div>
                <div class="ios-stat-value ios-stat-name">{{ $employee->first_name }} {{ $employee->last_name }}</div>
            </div>

            <div class="ios-stat">
                <div class="ios-stat-icon ios-icon-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="ios-stat-label">Active contracts</div>
                <div class="ios-stat-value">{{ $contracts->count() }}</div>
            </div>

            <div class="ios-stat">
                <div class="ios-stat-icon ios-icon-amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                </div>
                <div class="ios-stat-label">Years of service</div>
                <div class="ios-stat-value">
                    {{ $employee->join_date ? $employee->join_date->diffInYears(now()) : '0' }} yrs
                </div>
            </div>

            <div class="ios-stat">
                @if($notifications->count() > 0)
                    <span class="ios-stat-dot"></span>
                @endif
                <div class="ios-stat-icon ios-icon-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="ios-stat-label">Notifications</div>
                <div class="ios-stat-value">{{ $notifications->count() }}</div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="ios-charts">
            <div class="g-card">
                <div class="ios-card-title">Leave status</div>
                <div class="ios-chart-wrap"><canvas id="empLeaveChart"></canvas></div>
            </div>
            <div class="g-card">
                <div class="ios-card-title">Weekly attendance</div>
                <div class="ios-chart-wrap"><canvas id="empAttendanceChart"></canvas></div>
            </div>
            <div class="g-card">
                <div class="ios-card-title">Performance trend</div>
                <div class="ios-chart-wrap"><canvas id="empPerformanceChart"></canvas></div>
            </div>
        </div>

        {{-- Leave requests + Activity --}}
        <div class="ios-bottom">
            <div class="g-card">
                <div class="ios-card-title">Recent leave requests</div>
                @if($leaveRequests->count() > 0)
                    @foreach($leaveRequests as $request)
                        @php
                            $status = $request->status->value;
                            $badgeClass = match($status) {
                                'approved' => 'ios-badge-green',
                                'pending'  => 'ios-badge-amber',
                                default    => 'ios-badge-red',
                            };
                        @endphp
                        <div class="ios-list-item">
                            <div>
                                <div class="ios-list-main">{{ $request->leave_type ?? 'Leave' }}</div>
                                <div class="ios-list-sub">
                                    {{ $request->start_date?->format('M d, Y') }} – {{ $request->end_date?->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="ios-badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="ios-empty">No leave requests found</p>
                @endif
            </div>

            <div class="g-card">
                <div class="ios-card-title">Recent activity</div>
                @foreach($recentActivities as $activity)
                    @php
                        $dotColor = match($activity['type']) {
                            'login'   => '#22c55e',
                            'leave'   => '#f59e0b',
                            'profile' => '#3b82f6',
                            default   => '#94a3b8',
                        };
                    @endphp
                    <div class="ios-activity-item">
                        <span class="ios-act-dot" style="background:{{ $dotColor }}; box-shadow:0 0 0 3px {{ $dotColor }}26;"></span>
                        <div>
                            <div class="ios-list-main">{{ $activity['description'] }}</div>
                            <div class="ios-act-time">{{ $activity['time'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>{{-- /ios-main --}}

    {{-- Floating iOS 26 nav bar --}}
    <nav class="ios-nav">
        <a href="{{ route('employee.dashboard') }}" class="ios-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Home
            <span class="ios-nav-active-dot"></span>
        </a>
        <a href="{{ route('employee.profile') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0114 0"/></svg>
            Profile
        </a>
        <a href="{{ route('employee.attendance') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            Attendance
        </a>
        <a href="{{ route('employee.leave.request') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Leave
        </a>
        <a href="{{ route('leave-attendance.calendar') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Calendar
        </a>
        <a href="#" class="ios-nav-item" style="position:relative">
            @if($notifications->count() > 0)
                <span class="ios-notif-bubble"></span>
            @endif
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            Alerts
        </a>
    </nav>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    (function () {
        function initCharts() {
            if (typeof Chart === 'undefined') { setTimeout(initCharts, 100); return; }

            const tick = 'rgba(20,20,30,0.35)';
            const grid = 'rgba(20,20,30,0.06)';
            const font = { family: "'DM Sans', -apple-system, sans-serif", size: 11 };

            /* Leave doughnut */
            new Chart(document.getElementById('empLeaveChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($leaveChartData['labels']),
                    datasets: [{
                        data: @json($leaveChartData['data']),
                        backgroundColor: ['rgba(34,197,94,0.75)', 'rgba(245,158,11,0.75)', 'rgba(239,68,68,0.75)'],
                        borderColor:     ['rgba(34,197,94,0.2)',  'rgba(245,158,11,0.2)',  'rgba(239,68,68,0.2)'],
                        borderWidth: 3,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 8, boxHeight: 8, borderRadius: 4, useBorderRadius: true, padding: 14, font, color: tick } }
                    }
                }
            });

            /* Attendance bar */
            new Chart(document.getElementById('empAttendanceChart'), {
                type: 'bar',
                data: {
                    labels: @json($attendanceChartData['labels']),
                    datasets: [{ label: 'Present', data: @json($attendanceChartData['data']), backgroundColor: 'rgba(59,130,246,0.6)', borderColor: 'rgba(59,130,246,0.85)', borderWidth: 1, borderRadius: 6, borderSkipped: false, barPercentage: 0.55 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: tick, font } },
                        y: { beginAtZero: true, max: 1, grid: { color: grid }, border: { display: false }, ticks: { stepSize: 1, color: tick, font } }
                    }
                }
            });

            /* Performance line */
            new Chart(document.getElementById('empPerformanceChart'), {
                type: 'line',
                data: {
                    labels: @json($performanceChartData['labels']),
                    datasets: [{ label: 'Score', data: @json($performanceChartData['data']), borderColor: 'rgba(168,85,247,0.85)', backgroundColor: 'rgba(168,85,247,0.08)', borderWidth: 2, pointRadius: 4, pointBackgroundColor: 'rgba(168,85,247,0.9)', pointBorderColor: '#fff', pointBorderWidth: 2, tension: 0.45, fill: true }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: tick, font } },
                        y: { min: 80, max: 100, grid: { color: grid }, border: { display: false }, ticks: { color: tick, font } }
                    }
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCharts);
        } else {
            initCharts();
        }
    })();
    </script>

</div>{{-- /ios-root (single Livewire root element) --}}