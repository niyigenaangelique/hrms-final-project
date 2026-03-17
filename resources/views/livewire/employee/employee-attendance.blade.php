<div class="att-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.att-root {
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
.att-header {
    padding: 26px 32px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
}

.att-header-left h1 { font-size: 28px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 3px; }
.att-header-left p  { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0; }

.att-clock-display {
    text-align: right; flex-shrink: 0;
}

.att-clock-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); margin-bottom: 4px; }
.att-clock-time  {
    font-size: 28px; font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.5px;
    font-variant-numeric: tabular-nums;
}

/* ── Two-column today section ─────────────────────────── */
.att-today-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
}

/* ── Today stat cards ─────────────────────────────────── */
.att-stats { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 12px; padding: 24px 28px; }

.att-stat {
    background: var(--glass-strong);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-sm);
    padding: 16px 18px;
    position: relative; overflow: hidden;
}

.att-stat::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
}

.att-stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
.att-stat-icon svg { width: 17px; height: 17px; }
.si-blue   { background: rgba(37,99,235,0.12); } .si-blue   svg { stroke: #2563eb; }
.si-green  { background: rgba(34,197,94,0.12); } .si-green  svg { stroke: #16a34a; }
.si-purple { background: rgba(168,85,247,0.12);} .si-purple svg { stroke: #9333ea; }

.att-stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-tertiary); margin-bottom: 4px; }
.att-stat-value { font-size: 16px; font-weight: 700; color: var(--text-primary); }

/* ── Clock in/out panel ───────────────────────────────── */
.att-clock-panel { padding: 24px 28px; border-top: 1px solid rgba(0,0,0,0.05); }

.att-flash-ok  { background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.3); border-radius: var(--radius-sm); padding: 12px 16px; font-size: 13.5px; font-weight: 600; color: #15803d; margin-bottom: 16px; }
.att-flash-err { background: rgba(239,68,68,0.10); border: 1px solid rgba(239,68,68,0.25); border-radius: var(--radius-sm); padding: 12px 16px; font-size: 13.5px; font-weight: 600; color: #b91c1c; margin-bottom: 16px; }

.att-form-row { display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: end; }

.att-field label {
    display: block; font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary); margin-bottom: 7px;
}

.att-field textarea {
    width: 100%; padding: 11px 15px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary);
    outline: none; resize: vertical;
    min-height: 80px; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
}

.att-field textarea:focus {
    border-color: rgba(13,148,136,0.5);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
}

/* Clock in/out buttons */
.btn-clock-in {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px; white-space: nowrap;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 16px rgba(13,148,136,0.35);
    transition: transform 0.15s, box-shadow 0.15s;
}

.btn-clock-in:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(13,148,136,0.45); }

.btn-clock-out {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px; white-space: nowrap;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 16px rgba(220,38,38,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
}

.btn-clock-out:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(220,38,38,0.4); }

.btn-clock-in svg,
.btn-clock-out svg { width: 17px; height: 17px; stroke: #fff; }

/* ── Clocked-in status card (sidebar) ─────────────────── */
.att-status-card { padding: 22px; display: flex; flex-direction: column; gap: 0; }

.att-status-head {
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary); margin-bottom: 16px;
}

.att-status-indicator {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px;
    background: var(--glass-strong);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-sm);
    margin-bottom: 14px;
}

.att-status-dot {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
}

.dot-in    { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.2); animation: pulse-green 2s infinite; }
.dot-out   { background: #94a3b8; }

@keyframes pulse-green {
    0%, 100% { box-shadow: 0 0 0 3px rgba(34,197,94,0.2); }
    50%       { box-shadow: 0 0 0 6px rgba(34,197,94,0.1); }
}

.att-status-text { font-size: 15px; font-weight: 700; color: var(--text-primary); }
.att-status-sub  { font-size: 12px; font-weight: 500; color: var(--text-secondary); margin-top: 2px; }

.att-detail-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.att-detail-row:last-child { border-bottom: none; }
.att-detail-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary); }
.att-detail-value { font-size: 14px; font-weight: 700; color: var(--text-primary); }

/* ── History table ────────────────────────────────────── */
.att-history-head { padding: 22px 28px 0; }
.att-history-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0 0 18px; }

.att-table-wrap { padding: 0 20px 20px; overflow-x: auto; }

table.att-table { width: 100%; border-collapse: collapse; }

.att-table thead tr { border-bottom: 1px solid rgba(0,0,0,0.06); }

.att-table th {
    padding: 11px 14px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary); text-align: left; white-space: nowrap;
}

.att-table tbody tr {
    border-bottom: 1px solid rgba(0,0,0,0.04);
    transition: background 0.12s;
}

.att-table tbody tr:last-child { border-bottom: none; }
.att-table tbody tr:hover { background: rgba(255,255,255,0.5); }

.att-table td {
    padding: 13px 14px;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary); white-space: nowrap;
}

.att-table td.muted { color: var(--text-secondary); font-weight: 400; }

/* ── Status badges ────────────────────────────────────── */
.badge { display: inline-flex; font-size: 12px; font-weight: 700; padding: 4px 11px; border-radius: var(--radius-pill); }
.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-red    { background: rgba(239,68,68,0.14);  color: #b91c1c; }
.badge-amber  { background: rgba(245,158,11,0.14); color: #b45309; }
.badge-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }

/* ── Empty state ──────────────────────────────────────── */
.att-empty { text-align: center; padding: 52px 24px; }
.att-empty-icon { width: 52px; height: 52px; background: rgba(0,0,0,0.05); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
.att-empty-icon svg { width: 26px; height: 26px; stroke: var(--text-tertiary); }
.att-empty-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 5px; }
.att-empty-sub   { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0; }

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
    .att-today-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .att-root { padding: 20px 16px 110px; }
    .att-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    .att-stats { grid-template-columns: 1fr; }
    .att-form-row { grid-template-columns: 1fr; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header ──────────────────────────────────── --}}
<div class="g-card">
    <div class="att-header">
        <div class="att-header-left">
            <h1>My Attendance</h1>
            <p>{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="att-clock-display">
            <div class="att-clock-label">Current Time</div>
            <div class="att-clock-time" id="att-current-time">{{ now()->format('H:i:s') }}</div>
        </div>
    </div>
</div>

{{-- ── Two-column: today stats + clock action │ status sidebar ── --}}
<div class="att-today-grid">

    {{-- Left: stat cards + clock form --}}
    <div class="g-card">
        {{-- Flash messages --}}
        @if(session()->has('success') || session()->has('error'))
            <div style="padding: 16px 28px 0;">
                @if(session()->has('success'))
                    <div class="att-flash-ok">{{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="att-flash-err">{{ session('error') }}</div>
                @endif
            </div>
        @endif

        {{-- Today stat cards --}}
        @if($todayAttendance)
            <div class="att-stats">
                <div class="att-stat">
                    <div class="att-stat-icon si-blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                    </div>
                    <div class="att-stat-label">Clock In</div>
                    <div class="att-stat-value">{{ $todayAttendance->check_in ?? '—' }}</div>
                </div>
                <div class="att-stat">
                    <div class="att-stat-icon si-green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                    </div>
                    <div class="att-stat-label">Clock Out</div>
                    <div class="att-stat-value">{{ $todayAttendance->check_out ?? '—' }}</div>
                </div>
                <div class="att-stat">
                    <div class="att-stat-icon si-purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="att-stat-label">Status</div>
                    <div class="att-stat-value">{{ ucfirst($todayAttendance->status->value ?? 'Pending') }}</div>
                </div>
            </div>
        @endif

        {{-- Clock in/out form --}}
        <div class="att-clock-panel">
            <div class="att-form-row">
                <div class="att-field">
                    <label>Notes (Optional)</label>
                    <textarea wire:model="notes" placeholder="Add any notes about your attendance..."></textarea>
                </div>
                <div>
                    @if($isClockedIn)
                        <button class="btn-clock-out" wire:click="clockOut">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Clock Out
                        </button>
                    @else
                        <button class="btn-clock-in" wire:click="clockIn">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Clock In
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Right: live status card --}}
    <div class="g-card">
        <div class="att-status-card">
            <div class="att-status-head">Today's Status</div>

            {{-- Live indicator --}}
            <div class="att-status-indicator">
                <div class="att-status-dot {{ $isClockedIn ? 'dot-in' : 'dot-out' }}"></div>
                <div>
                    <div class="att-status-text">{{ $isClockedIn ? 'Currently Clocked In' : 'Not Clocked In' }}</div>
                    <div class="att-status-sub">{{ $isClockedIn ? 'Session in progress' : 'Clock in to start your day' }}</div>
                </div>
            </div>

            {{-- Detail rows --}}
            @if($todayAttendance)
                <div class="att-detail-row">
                    <span class="att-detail-label">Date</span>
                    <span class="att-detail-value">{{ now()->format('M d, Y') }}</span>
                </div>
                <div class="att-detail-row">
                    <span class="att-detail-label">Clock In</span>
                    <span class="att-detail-value">{{ $todayAttendance->check_in ?? '—' }}</span>
                </div>
                <div class="att-detail-row">
                    <span class="att-detail-label">Clock Out</span>
                    <span class="att-detail-value">{{ $todayAttendance->check_out ?? '—' }}</span>
                </div>
                @if($todayAttendance->check_in && $todayAttendance->check_out)
                    <div class="att-detail-row">
                        <span class="att-detail-label">Hours Worked</span>
                        <span class="att-detail-value">
                            {{ \Carbon\Carbon::parse($todayAttendance->check_in)->diffInHours(\Carbon\Carbon::parse($todayAttendance->check_out)) }}h
                        </span>
                    </div>
                @endif
                <div class="att-detail-row">
                    <span class="att-detail-label">Status</span>
                    @php
                        $ts = $todayAttendance->status->value ?? 'pending';
                        $tc = match($ts) { 'present' => 'badge-green', 'absent' => 'badge-red', 'late' => 'badge-amber', default => 'badge-gray' };
                    @endphp
                    <span class="badge {{ $tc }}">{{ ucfirst($ts) }}</span>
                </div>
            @else
                <div class="att-detail-row">
                    <span class="att-detail-label">Date</span>
                    <span class="att-detail-value">{{ now()->format('M d, Y') }}</span>
                </div>
                <div class="att-detail-row">
                    <span class="att-detail-label">Clock In</span>
                    <span class="att-detail-value" style="color:var(--text-tertiary);">Not yet</span>
                </div>
            @endif
        </div>
    </div>

</div>{{-- /att-today-grid --}}

{{-- ── Attendance history table ──────────────────────── --}}
<div class="g-card">
    <div class="att-history-head">
        <h3 class="att-history-title">Attendance History</h3>
    </div>

    @if($attendances->count() > 0)
        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Hours</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                        @php
                            $as = $attendance->status->value;
                            $ac = match($as) { 'present' => 'badge-green', 'absent' => 'badge-red', 'late' => 'badge-amber', default => 'badge-gray' };
                            $hours = $attendance->check_in && $attendance->check_out
                                ? \Carbon\Carbon::parse($attendance->check_in)->diffInHours(\Carbon\Carbon::parse($attendance->check_out)) . 'h'
                                : '—';
                        @endphp
                        <tr>
                            <td style="font-weight:600;">{{ $attendance->date->format('M d, Y') }}</td>
                            <td class="muted">{{ $attendance->check_in ?? '—' }}</td>
                            <td class="muted">{{ $attendance->check_out ?? '—' }}</td>
                            <td>{{ $hours }}</td>
                            <td><span class="badge {{ $ac }}">{{ ucfirst($as) }}</span></td>
                            <td class="muted" style="max-width:180px; white-space:normal; font-size:13px;">{{ $attendance->notes ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="att-empty">
            <div class="att-empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            </div>
            <p class="att-empty-title">No attendance records yet</p>
            <p class="att-empty-sub">Start clocking in to build your attendance history.</p>
        </div>
    @endif
</div>

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
    <a href="{{ route('employee.attendance') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="#" class="ios-nav-item" style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

{{-- Live clock script (inline — no @push needed) --}}
<script>
(function() {
    function tick() {
        const el = document.getElementById('att-current-time');
        if (!el) return;
        const now = new Date();
        el.textContent = now.toLocaleTimeString('en-GB', { hour12: false });
    }
    tick();
    setInterval(tick, 1000);
})();
</script>

</div>{{-- /att-root --}}