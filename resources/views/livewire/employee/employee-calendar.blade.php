<div class="cal-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.cal-root {
    --glass-bg:       rgba(255,255,255,0.45);
    --glass-strong:   rgba(255,255,255,0.65);
    --glass-border:   rgba(255,255,255,0.65);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(24px) saturate(1.8);
    --radius:         20px;
    --radius-sm:      12px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.72);
    --text-tertiary:  rgba(15,15,25,0.50);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 36px 40px 120px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

/* ── Glass card ───────────────────────────────────────── */
.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    position: relative;
}

.g-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

/* ── Page header ──────────────────────────────────────── */
.cal-header {
    padding: 24px 32px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
}

.cal-header-text h1 { font-size: 28px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 3px; }
.cal-header-text p  { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* Month navigator */
.cal-nav { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }

.cal-nav-btn {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.85);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s, transform 0.12s;
    backdrop-filter: var(--blur);
}

.cal-nav-btn:hover { background: rgba(255,255,255,0.9); transform: scale(1.05); }
.cal-nav-btn svg   { width: 18px; height: 18px; stroke: var(--text-primary); }

.cal-month-label { font-size: 17px; font-weight: 700; color: var(--text-primary); min-width: 140px; text-align: center; }

/* ── Two-column body layout ───────────────────────────── */
.cal-body {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items: start;
}

/* ── Calendar grid ────────────────────────────────────── */
.cal-grid-wrap { padding: 24px; }

.cal-weekdays {
    display: grid; grid-template-columns: repeat(7, 1fr);
    margin-bottom: 8px;
}

.cal-weekday {
    text-align: center;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-tertiary);
    padding: 8px 0;
}

.cal-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; }

.cal-day {
    border-radius: 10px;
    padding: 8px 6px;
    min-height: 86px;
    border: 1px solid rgba(0,0,0,0.05);
    background: rgba(255,255,255,0.3);
    transition: background 0.12s, box-shadow 0.12s;
    overflow: hidden;
}

.cal-day:hover { background: rgba(255,255,255,0.6); box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

.cal-day.other-month { background: rgba(0,0,0,0.02); border-color: transparent; }
.cal-day.other-month .cal-day-num { color: var(--text-tertiary); opacity: 0.5; }

.cal-day.today {
    background: rgba(37,99,235,0.08);
    border-color: rgba(37,99,235,0.25);
}

.cal-day.weekend {
    background: rgba(239,68,68,0.04);
    border-color: rgba(239,68,68,0.12);
}

.cal-day-num {
    font-size: 13px; font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 5px;
}

.cal-day.today    .cal-day-num { color: #2563eb; }
.cal-day.weekend  .cal-day-num { color: #dc2626; opacity: 0.8; }

.cal-day-events { display: flex; flex-direction: column; gap: 3px; }

.cal-event {
    font-size: 10px; font-weight: 600;
    padding: 2px 5px; border-radius: 5px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.cal-event-leave   { background: rgba(245,158,11,0.18); color: #b45309; }
.cal-event-holiday { background: rgba(34,197,94,0.16);  color: #15803d; }

/* ── Legend ───────────────────────────────────────────── */
.cal-legend {
    display: flex; flex-wrap: wrap; gap: 16px;
    padding: 16px 24px 20px;
    border-top: 1px solid rgba(0,0,0,0.05);
}

.cal-legend-item { display: flex; align-items: center; gap: 7px; font-size: 12px; font-weight: 600; color: var(--text-secondary); }

.cal-legend-dot {
    width: 12px; height: 12px; border-radius: 4px; flex-shrink: 0;
}

.leg-today   { background: rgba(37,99,235,0.2); border: 1px solid rgba(37,99,235,0.35); }
.leg-weekend { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); }
.leg-leave   { background: rgba(245,158,11,0.2); }
.leg-holiday { background: rgba(34,197,94,0.2); }

/* ── Upcoming leave sidebar ───────────────────────────── */
.cal-side-head {
    padding: 20px 22px 14px;
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary);
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.cal-side-body { padding: 12px 14px 16px; display: flex; flex-direction: column; gap: 10px; }

.cal-leave-item {
    background: rgba(255,255,255,0.55);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 13px 15px;
    backdrop-filter: var(--blur);
    transition: box-shadow 0.15s;
}

.cal-leave-item:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.07); }

.cal-leave-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 5px; }
.cal-leave-name { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; }
.cal-leave-dates { font-size: 12px; font-weight: 500; color: var(--text-secondary); margin: 0; }

.badge { display: inline-flex; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); flex-shrink: 0; }
.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-amber  { background: rgba(245,158,11,0.14); color: #b45309; }
.badge-red    { background: rgba(239,68,68,0.14);  color: #b91c1c; }
.badge-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }

.cal-empty { text-align: center; padding: 28px 16px; font-size: 13px; font-weight: 500; color: var(--text-tertiary); }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%;
    transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.75);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}

.ios-nav::before {
    content: ''; position: absolute;
    top: 0; left: 16px; right: 16px; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
}

.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 8px 18px; border-radius: 20px; text-decoration: none;
    font-size: 10px; font-weight: 500; color: rgba(255,255,255,0.45);
    letter-spacing: 0.03em; min-width: 64px; position: relative;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.ios-nav-item svg { width: 20px; height: 20px; stroke: currentColor; transition: transform 0.2s; }
.ios-nav-item:hover { color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.08); transform: translateY(-1px); }
.ios-nav-item:hover svg { transform: scale(1.1); }
.ios-nav-item.active { color: #fff; background: rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke: #60a5fa; }
.ios-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #60a5fa; }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1100px) {
    .cal-body { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .cal-root { padding: 20px 16px 110px; }
    .cal-header { flex-direction: column; align-items: flex-start; gap: 14px; }
    .cal-day { min-height: 60px; padding: 6px 4px; }
    .cal-day-num { font-size: 11px; }
    .cal-event { font-size: 9px; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header ──────────────────────────────────── --}}
<div class="g-card">
    <div class="cal-header">
        <div class="cal-header-text">
            <h1>My Calendar</h1>
            <p>View your personal calendar with leave requests and holidays</p>
        </div>
        <div class="cal-nav">
            <button class="cal-nav-btn" wire:click="previousMonth">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="cal-month-label">
                {{ \Carbon\Carbon::create($this->currentYear, $this->currentMonth)->format('F Y') }}
            </div>
            <button class="cal-nav-btn" wire:click="nextMonth">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- ── Two-column body ───────────────────────────────── --}}
<div class="cal-body">

    {{-- Calendar --}}
    <div class="g-card">
        <div class="cal-grid-wrap">

            {{-- Weekday headers --}}
            <div class="cal-weekdays">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                    <div class="cal-weekday">{{ $d }}</div>
                @endforeach
            </div>

            {{-- Days grid --}}
            <div class="cal-days">
                @foreach($calendarDays as $day)
                    @php
                        $cls = 'cal-day';
                        if (!$day['isCurrentMonth']) $cls .= ' other-month';
                        elseif ($day['isToday'])     $cls .= ' today';
                        elseif ($day['isWeekend'])   $cls .= ' weekend';
                    @endphp
                    <div class="{{ $cls }}">
                        <div class="cal-day-num">{{ $day['date'] }}</div>
                        <div class="cal-day-events">
                            @foreach($day['leaveRequests'] as $lr)
                                <div class="cal-event cal-event-leave" title="{{ $lr->leaveType->name }}">
                                    {{ $lr->leaveType->name }}
                                </div>
                            @endforeach
                            @foreach($day['holidays'] as $h)
                                <div class="cal-event cal-event-holiday" title="{{ $h->name }}">
                                    {{ $h->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- Legend --}}
        <div class="cal-legend">
            <div class="cal-legend-item"><div class="cal-legend-dot leg-today"></div>Today</div>
            <div class="cal-legend-item"><div class="cal-legend-dot leg-weekend"></div>Weekend</div>
            <div class="cal-legend-item"><div class="cal-legend-dot leg-leave"></div>Leave</div>
            <div class="cal-legend-item"><div class="cal-legend-dot leg-holiday"></div>Holiday</div>
        </div>
    </div>

    {{-- Upcoming leave sidebar --}}
    <div class="g-card">
        <div class="cal-side-head">Upcoming Leave</div>
        <div class="cal-side-body">
            @php $upcoming = $this->leaveRequests->sortBy('start_date')->take(5); @endphp
            @if($upcoming->count() > 0)
                @foreach($upcoming as $lr)
                    @php
                        $s = $lr->status->value;
                        $bc = match($s) { 'approved' => 'badge-green', 'pending' => 'badge-amber', 'rejected' => 'badge-red', default => 'badge-gray' };
                    @endphp
                    <div class="cal-leave-item">
                        <div class="cal-leave-top">
                            <p class="cal-leave-name">{{ $lr->leaveType->name }}</p>
                            <span class="badge {{ $bc }}">{{ ucfirst($s) }}</span>
                        </div>
                        <p class="cal-leave-dates">
                            {{ $lr->start_date->format('M d') }} — {{ $lr->end_date->format('M d, Y') }}
                            @if($lr->total_days) · {{ $lr->total_days }} day{{ $lr->total_days > 1 ? 's' : '' }} @endif
                        </p>
                    </div>
                @endforeach
            @else
                <div class="cal-empty">No upcoming leave requests this month</div>
            @endif
        </div>
    </div>

</div>{{-- /cal-body --}}

{{-- ── Floating nav ──────────────────────────────────── --}}
<nav class="ios-nav">
    <a href="{{ route('employee.dashboard') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
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
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="#" class="ios-nav-item" style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

</div>{{-- /cal-root --}}