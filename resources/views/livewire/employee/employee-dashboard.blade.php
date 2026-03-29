<div x-data class="tf-root">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@600;700;800&display=swap');

        /* ── Design Tokens ───────────────────────────────────── */
        .tf-root {
            --blue:      #3B6FE8;
            --blue-lt:   rgba(59,111,232,0.10);
            --green:     #12B76A;
            --teal:      #0BB5B5;
            --teal-lt:   rgba(11,181,181,0.10);
            --amber:     #F4A83A;
            --amber-lt:  rgba(244,168,58,0.10);
            --red:       #F04438;
            --red-lt:    rgba(240,68,56,0.10);
            --purple:    #6B4FDB;
            --purple-lt: rgba(107,79,219,0.10);

            --bg:        #EEF2F7;
            --white:     #FFFFFF;
            --ink:       #1A1D2E;
            --ink2:      #3A3D52;
            --ink3:      #8A8FA8;
            --border:    rgba(26,29,46,0.09);
            --shadow:    0 2px 12px rgba(26,29,46,0.07);
            --shadow-lg: 0 8px 32px rgba(26,29,46,0.10);

            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            position: relative;
        }

        /* ── Layout ─────────────────────────────────────────── */
        .tf-main {
            padding: 32px 36px 110px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto; /* Center the content */
        }

        /* ── Page header ─────────────────────────────────────── */
        .tf-page-hd {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .tf-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.3px;
            margin: 0;
        }
        .tf-page-sub {
            font-size: 14px;
            color: var(--ink3);
            margin: 3px 0 0;
            font-weight: 500;
        }
        .tf-code-pill {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink3);
            letter-spacing: 0.06em;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .tf-code-pill svg { width: 13px; height: 13px; stroke: var(--ink3); }

        /* ── Stat tiles ──────────────────────────────────────── */
        .tf-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0,1fr));
            gap: 14px;
        }
        .tf-stat {
            border-radius: 16px;
            padding: 22px 22px 20px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        .tf-stat::after {
            content: '';
            position: absolute;
            right: -18px; bottom: -18px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
        }
        .tf-stat-gradient-blue   { background: linear-gradient(135deg, #3B6FE8 0%, #6B4FDB 100%); }
        .tf-stat-gradient-green  { background: linear-gradient(135deg, #12B76A 0%, #0BB5B5 100%); }
        .tf-stat-gradient-amber  { background: linear-gradient(135deg, #F4A83A 0%, #F7CB6A 100%); }
        .tf-stat-gradient-red    { background: linear-gradient(135deg, #F04438 0%, #FF7B7B 100%); }
        .tf-stat-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.22);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .tf-stat-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
        .tf-stat-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: rgba(255,255,255,0.70);
            margin-bottom: 4px;
        }
        .tf-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }
        .tf-stat-value-sm { font-size: 18px !important; letter-spacing: -0.1px !important; line-height: 1.3 !important; }
        .tf-stat-notif-dot {
            position: absolute;
            top: 14px; right: 14px;
            width: 9px; height: 9px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.30);
        }

        /* ── White card base ─────────────────────────────────── */
        .tf-card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 22px 24px;
        }
        .tf-card-hd {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .tf-card-title {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
        }
        .tf-card-tag {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            color: var(--ink3);
            letter-spacing: 0.03em;
        }

        /* ── Charts grid ─────────────────────────────────────── */
        .tf-charts {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 14px;
        }
        .tf-chart-wrap { position: relative; height: 190px; }

        /* ── Bottom 2-col ────────────────────────────────────── */
        .tf-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ── List items ──────────────────────────────────────── */
        .tf-list-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .tf-list-row:last-child { border-bottom: none; }
        .tf-list-main { font-size: 14px; font-weight: 600; color: var(--ink); }
        .tf-list-sub  { font-size: 12px; color: var(--ink3); margin-top: 2px; font-weight: 500; }
        .tf-empty {
            font-size: 14px;
            color: var(--ink3);
            text-align: center;
            padding: 24px 0;
            font-weight: 500;
        }

        /* ── Status badges ───────────────────────────────────── */
        .tf-badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .tf-badge-green  { background: rgba(18,183,106,0.12); color: #0a7a45; }
        .tf-badge-amber  { background: rgba(244,168,58,0.15); color: #b45309; }
        .tf-badge-red    { background: var(--red-lt);          color: var(--red); }

        /* ── Activity items ──────────────────────────────────── */
        .tf-act-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .tf-act-row:last-child { border-bottom: none; }
        .tf-act-dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 4px;
        }
        .tf-act-time { font-size: 12px; color: var(--ink3); font-weight: 500; margin-top: 2px; }

        /* ── Section label ───────────────────────────────────── */
        .tf-section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--ink3);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tf-section-label svg { width: 12px; height: 12px; stroke: var(--ink3); }

        /* ── Floating nav ────────────────────────────────────── */
        .tf-nav {
            position: fixed;
            bottom: 22px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 200;
            display: flex;
            align-items: center;
            gap: 2px;
            background: rgba(20, 22, 38, 0.82);
            backdrop-filter: blur(28px) saturate(2);
            -webkit-backdrop-filter: blur(28px) saturate(2);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 26px;
            padding: 7px 10px;
            box-shadow: 0 20px 56px rgba(0,0,0,0.22), 0 4px 14px rgba(0,0,0,0.12),
                        inset 0 1px 0 rgba(255,255,255,0.09);
        }
        .tf-nav::before {
            content: '';
            position: absolute;
            top: 0; left: 20px; right: 20px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.20), transparent);
        }
        .tf-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding: 8px 16px;
            border-radius: 18px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,0.42);
            letter-spacing: 0.04em;
            min-width: 62px;
            position: relative;
            transition: background 0.18s, color 0.18s, transform 0.14s;
        }
        .tf-nav-item svg {
            width: 19px; height: 19px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            transition: transform 0.18s;
        }
        .tf-nav-item:hover { color: rgba(255,255,255,0.80); background: rgba(255,255,255,0.07); transform: translateY(-1px); }
        .tf-nav-item:hover svg { transform: scale(1.08); }
        .tf-nav-item.active { color: #fff; background: rgba(255,255,255,0.14); }
        .tf-nav-item.active svg { stroke: #60a5fa; }
        .tf-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #60a5fa; }
        .tf-notif-bubble {
            position: absolute; top: 5px; right: 9px;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--red);
            border: 1.5px solid rgba(20,22,38,0.82);
        }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 1100px) {
            .tf-stats  { grid-template-columns: repeat(2,1fr); }
            .tf-charts { grid-template-columns: 1fr; }
            .tf-bottom { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .tf-main   { padding: 16px 14px 100px; gap: 14px; }
            .tf-stats  { grid-template-columns: repeat(2,1fr); gap: 10px; }
            .tf-nav    { bottom: 12px; padding: 6px 8px; }
            .tf-nav-item { padding: 7px 11px; min-width: 52px; font-size: 9px; }
            .tf-nav-item svg { width: 17px; height: 17px; }
        }
    </style>

    {{-- Page content --}}
    <div class="tf-main">

        {{-- ── Page header ── --}}
        <div class="tf-page-hd">
            <div>
                <h1 class="tf-page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ Auth::user()->first_name }}</h1>
                <p class="tf-page-sub">{{ now()->format('l, j F Y') }} &mdash; Here&rsquo;s your overview</p>
            </div>
            <div class="tf-code-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                </svg>
                {{ $employee->code }}
            </div>
        </div>

        {{-- ── Stat tiles ── --}}
        <div class="tf-stats">

            {{-- Name --}}
            <div class="tf-stat tf-stat-gradient-blue">
                <div class="tf-stat-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>
                </div>
                <div class="tf-stat-label">Employee</div>
                <div class="tf-stat-value tf-stat-value-sm">{{ $employee->first_name }} {{ $employee->last_name }}</div>
            </div>

            {{-- Contracts --}}
            <div class="tf-stat tf-stat-gradient-green">
                <div class="tf-stat-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="tf-stat-label">Active contracts</div>
                <div class="tf-stat-value">{{ $contracts->count() }}</div>
            </div>

            {{-- Years of service --}}
            <div class="tf-stat tf-stat-gradient-amber">
                <div class="tf-stat-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                </div>
                <div class="tf-stat-label">Years of service</div>
                <div class="tf-stat-value">
                    {{ $employee->join_date ? $employee->join_date->diffInYears(now()) : '0' }}
                    <span style="font-size:14px;font-weight:600;opacity:.8;"> yrs</span>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="tf-stat tf-stat-gradient-red">
                @if($notifications->count() > 0)
                    <span class="tf-stat-notif-dot"></span>
                @endif
                <div class="tf-stat-icon">
                    <svg viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="tf-stat-label">Notifications</div>
                <div class="tf-stat-value">{{ $notifications->count() }}</div>
            </div>

        </div>

        {{-- ── Charts ── --}}
        <div class="tf-charts">

            <div class="tf-card">
                <div class="tf-card-hd">
                    <div class="tf-card-title">Leave Status</div>
                    <span class="tf-card-tag">{{ $leaveRequests->count() }} requests</span>
                </div>
                <div class="tf-chart-wrap"><canvas id="empLeaveChart"></canvas></div>
            </div>

            <div class="tf-card">
                <div class="tf-card-hd">
                    <div class="tf-card-title">Weekly Attendance</div>
                    <span class="tf-card-tag">Last 7 days</span>
                </div>
                <div class="tf-chart-wrap"><canvas id="empAttendanceChart"></canvas></div>
            </div>

            <div class="tf-card">
                <div class="tf-card-hd">
                    <div class="tf-card-title">Performance Trend</div>
                    <span class="tf-card-tag">6 months</span>
                </div>
                <div class="tf-chart-wrap"><canvas id="empPerformanceChart"></canvas></div>
            </div>

        </div>

        {{-- ── Bottom grid ── --}}
        <div class="tf-bottom">

            {{-- Leave requests --}}
            <div class="tf-card">
                <div class="tf-card-hd">
                    <div class="tf-card-title">Recent Leave Requests</div>
                    <a href="{{ route('employee.leave.request') }}"
                       style="font-size:12px;font-weight:700;color:var(--blue);text-decoration:none;display:flex;align-items:center;gap:4px;">
                        View all
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>

                @if($leaveRequests->count() > 0)
                    @foreach($leaveRequests as $request)
                        @php
                            $status     = $request->status->value;
                            $badgeCls   = match($status) {
                                'approved' => 'tf-badge-green',
                                'pending'  => 'tf-badge-amber',
                                default    => 'tf-badge-red',
                            };
                        @endphp
                        <div class="tf-list-row">
                            <div>
                                <div class="tf-list-main">{{ $request->leave_type ?? 'Leave Request' }}</div>
                                <div class="tf-list-sub">
                                    {{ $request->start_date?->format('M d') }} &ndash; {{ $request->end_date?->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="tf-badge {{ $badgeCls }}">{{ ucfirst($status) }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="tf-empty">No leave requests found</p>
                @endif
            </div>

            {{-- Recent activity --}}
            <div class="tf-card">
                <div class="tf-card-hd">
                    <div class="tf-card-title">Recent Activity</div>
                </div>

                @foreach($recentActivities as $activity)
                    @php
                        $dotColor = match($activity['type']) {
                            'login'   => '#12B76A',
                            'leave'   => '#F4A83A',
                            'profile' => '#3B6FE8',
                            default   => '#8A8FA8',
                        };
                    @endphp
                    <div class="tf-act-row">
                        <span class="tf-act-dot" style="background:{{ $dotColor }};box-shadow:0 0 0 3px {{ $dotColor }}26;"></span>
                        <div>
                            <div class="tf-list-main">{{ $activity['description'] }}</div>
                            <div class="tf-act-time">{{ $activity['time'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>{{-- /tf-main --}}

    {{-- ── Floating nav bar (unchanged) ── --}}
    <nav class="tf-nav">
        <a href="{{ route('employee.dashboard') }}" class="tf-nav-item active">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Home
            <span class="tf-nav-active-dot"></span>
        </a>
        <a href="{{ route('employee.profile') }}" class="tf-nav-item">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>
            Profile
        </a>
        <a href="{{ route('employee.attendance') }}" class="tf-nav-item">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            Attendance
        </a>
        <a href="{{ route('employee.leave.request') }}" class="tf-nav-item">
            <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/></svg>
            Leave
        </a>
        <a href="{{ route('leave-attendance.calendar') }}" class="tf-nav-item">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Calendar
        </a>
        <a href="#" class="tf-nav-item" style="position:relative">
            @if($notifications->count() > 0)
                <span class="tf-notif-bubble"></span>
            @endif
            <svg viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
            Alerts
        </a>
    </nav>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    (function () {
        function initCharts() {
            if (typeof Chart === 'undefined') { setTimeout(initCharts, 100); return; }

            const tick  = 'rgba(26,29,46,0.38)';
            const grid  = 'rgba(26,29,46,0.06)';
            const font  = { family: "'DM Sans', -apple-system, sans-serif", size: 11, weight: '500' };

            /* ── Leave doughnut ── */
            new Chart(document.getElementById('empLeaveChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($leaveChartData['labels']),
                    datasets: [{
                        data: @json($leaveChartData['data']),
                        backgroundColor: [
                            'rgba(18,183,106,0.80)',
                            'rgba(244,168,58,0.80)',
                            'rgba(240,68,56,0.80)'
                        ],
                        borderColor: ['#fff','#fff','#fff'],
                        borderWidth: 2,
                        hoverOffset: 5
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 8, boxHeight: 8, borderRadius: 4, useBorderRadius: true, padding: 14, font, color: tick }
                        }
                    }
                }
            });

            /* ── Attendance bar ── */
            new Chart(document.getElementById('empAttendanceChart'), {
                type: 'bar',
                data: {
                    labels: @json($attendanceChartData['labels']),
                    datasets: [{
                        label: 'Present',
                        data: @json($attendanceChartData['data']),
                        backgroundColor: 'rgba(59,111,232,0.65)',
                        borderColor: 'rgba(59,111,232,0.90)',
                        borderWidth: 0,
                        borderRadius: 7,
                        borderSkipped: false,
                        barPercentage: 0.52
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: tick, font } },
                        y: { beginAtZero: true, max: 1, grid: { color: grid }, border: { display: false },
                             ticks: { stepSize: 1, color: tick, font } }
                    }
                }
            });

            /* ── Performance line ── */
            new Chart(document.getElementById('empPerformanceChart'), {
                type: 'line',
                data: {
                    labels: @json($performanceChartData['labels']),
                    datasets: [{
                        label: 'Score',
                        data: @json($performanceChartData['data']),
                        borderColor: 'rgba(107,79,219,0.90)',
                        backgroundColor: 'rgba(107,79,219,0.08)',
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgba(107,79,219,1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        tension: 0.40,
                        fill: true
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: tick, font } },
                        y: { min: 80, max: 100, grid: { color: grid }, border: { display: false },
                             ticks: { color: tick, font } }
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

</div>{{-- /tf-root --}}