<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.hc-root {
    --glass-bg:       rgba(255,255,255,0.50);
    --glass-strong:   rgba(255,255,255,0.72);
    --glass-border:   rgba(255,255,255,0.72);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(22px) saturate(1.7);
    --radius:         20px;
    --radius-sm:      13px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 32px 36px 110px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeSlideUp 0.35s ease both; }
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }
.anim-3 { animation: fadeSlideUp 0.35s 0.14s ease both; }

/* ── Glass card ───────────────────────────────────────── */
.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    position: relative;
}
.g-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none; border-radius: var(--radius) var(--radius) 0 0;
}

/* ── Header ───────────────────────────────────────────── */
.hc-header {
    padding: 24px 30px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
}
.hc-header h1 { font-size: 24px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 3px; }
.hc-header p  { font-size: 13.5px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Filters ─────────────────────────────────────────── */
.hc-filters { padding: 20px 26px; display: grid; grid-template-columns: 1fr 1fr auto; gap: 16px; align-items: end; }

.hc-filter-field { display: flex; flex-direction: column; gap: 6px; }
.hc-filter-field label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); }

.hc-filter-field select {
    padding: 10px 14px;
    background: rgba(255,255,255,0.78) !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    border-radius: var(--radius-sm) !important;
    font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500;
    color: var(--text-primary); outline: none; width: 100%; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
    -webkit-appearance: none;
}
.hc-filter-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important; background-position: right 14px center !important; padding-right: 36px !important;
}
.hc-filter-field select:focus {
    border-color: rgba(13,148,136,0.55) !important;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1) !important;
    background: rgba(255,255,255,0.96) !important;
}

.btn-refresh {
    padding: 10px 20px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 600; cursor: pointer;
    box-shadow: 0 4px 14px rgba(13,148,136,0.32);
    transition: transform 0.15s, box-shadow 0.15s;
    display: flex; align-items: center; gap: 8px;
}
.btn-refresh:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(13,148,136,0.42); }

/* ── Calendar ─────────────────────────────────────────── */
.hc-calendar-body { padding: 24px 26px 26px; }

.hc-nav-month {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
}
.hc-nav-month h2 {
    font-size: 20px; font-weight: 700; color: var(--text-primary);
    letter-spacing: -0.3px; margin: 0;
}
.hc-nav-btn {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,0.6); border: 1px solid rgba(0,0,0,0.08);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s;
}
.hc-nav-btn:hover { background: rgba(255,255,255,0.9); transform: scale(1.05); }
.hc-nav-btn svg { width: 16px; height: 16px; stroke: var(--text-secondary); }

/* Calendar grid */
.hc-cal-grid {
    display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px;
    background: rgba(0,0,0,0.06); border-radius: var(--radius); overflow: hidden;
}
.hc-cal-header {
    background: rgba(0,0,0,0.03);
    padding: 12px 8px; text-align: center;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.07em; color: var(--text-tertiary);
}
.hc-cal-day {
    background: rgba(255,255,255,0.7);
    min-height: 100px; padding: 8px;
    cursor: pointer; transition: background 0.15s;
    position: relative;
}
.hc-cal-day:hover { background: rgba(255,255,255,0.95); }
.hc-cal-day.weekend { background: rgba(0,0,0,0.02); }
.hc-cal-day.today { 
    background: rgba(37,99,235,0.08); 
    box-shadow: inset 0 0 0 2px rgba(37,99,235,0.2);
}
.hc-cal-day.today:hover { background: rgba(37,99,235,0.12); }

.hc-day-number {
    font-size: 13px; font-weight: 600; color: var(--text-primary);
    margin-bottom: 4px;
}
.hc-cal-day.weekend .hc-day-number { color: var(--text-tertiary); }
.hc-cal-day.today .hc-day-number { color: #2563eb; font-weight: 700; }

/* Calendar events */
.hc-events { display: flex; flex-direction: column; gap: 2px; }
.hc-event {
    font-size: 10px; font-weight: 600; padding: 2px 4px;
    border-radius: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.hc-event.approved { background: rgba(34,197,94,0.15); color: #15803d; }
.hc-event.pending { background: rgba(245,158,11,0.15); color: #92400e; }
.hc-event.rejected { background: rgba(239,68,68,0.15); color: #b91c1c; }
.hc-more { font-size: 10px; color: var(--text-tertiary); font-weight: 500; }

/* ── Selected date details ───────────────────────────── */
.hc-details {
    margin-top: 20px;
}
.hc-details-head {
    padding: 18px 24px 14px; border-bottom: 1px solid rgba(0,0,0,0.055);
}
.hc-details-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0; }
.hc-details-body { padding: 16px 24px 20px; }

.hc-leave-item {
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 14px 16px; margin-bottom: 12px;
    transition: box-shadow 0.15s;
}
.hc-leave-item:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.07); }
.hc-leave-item:last-child { margin-bottom: 0; }

.hc-leave-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 8px;
}
.hc-leave-name { font-size: 14px; font-weight: 700; color: var(--text-primary); }
.hc-leave-actions { display: flex; align-items: center; gap: 8px; }

.hc-leave-meta {
    font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;
}
.hc-leave-reason {
    font-size: 12px; color: var(--text-tertiary); line-height: 1.4;
}

/* Badges */
.badge { display: inline-flex; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: var(--radius-pill); }
.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-amber  { background: rgba(245,158,11,0.14); color: #92400e; }
.badge-red    { background: rgba(239,68,68,0.14);  color: #b91c1c; }

.btn-manage {
    font-size: 11px; font-weight: 600; color: #2563eb;
    background: rgba(37,99,235,0.09); border: none; border-radius: 6px;
    padding: 4px 10px; cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: background 0.13s;
}
.btn-manage:hover { background: rgba(37,99,235,0.16); }

/* Empty state */
.hc-empty { text-align: center; padding: 40px 24px; }
.hc-empty-icon { width: 48px; height: 48px; background: rgba(0,0,0,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.hc-empty-icon svg { width: 24px; height: 24px; stroke: var(--text-tertiary); }
.hc-empty-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.hc-empty-sub   { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.75);
    backdrop-filter: blur(32px) saturate(2); -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13); border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}
.ios-nav::before { content: ''; position: absolute; top: 0; left: 16px; right: 16px; height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent); }
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

@media (max-width: 768px) { 
    .hc-root { padding: 18px 14px 100px; } 
    .hc-filters { grid-template-columns: 1fr; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; } 
    .ios-nav-item svg { width: 18px; height: 18px; } 
}
</style>

<div class="hc-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="hc-header">
            <div>
                <h1>HR Calendar</h1>
                <p>View and manage employee leave schedules</p>
            </div>
        </div>
    </div>

    {{-- ── Filters ───────────────────────────────────── --}}
    <div class="g-card anim-2">
        <div class="hc-filters">
            <div class="hc-filter-field">
                <label>Filter by Employee</label>
                <select wire:model.live="filterEmployee">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="hc-filter-field">
                <label>Filter by Status</label>
                <select wire:model.live="filterStatus">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <button wire:click="loadLeaveRequests" class="btn-refresh">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Refresh
            </button>
        </div>
    </div>

    {{-- ── Calendar ───────────────────────────────────── --}}
    <div class="g-card anim-3">
        <div class="hc-calendar-body">
            <!-- Month Navigation -->
            <div class="hc-nav-month">
                <button wire:click="previousMonth" class="hc-nav-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <h2>{{ $this->getMonthName() }} {{ $currentYear }}</h2>
                <button wire:click="nextMonth" class="hc-nav-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Calendar Grid -->
            <div class="hc-cal-grid">
                <!-- Weekday Headers -->
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="hc-cal-header">{{ $day }}</div>
                @endforeach

                <!-- Empty Days for Month Start -->
                @for($i = 0; $i < $this->getFirstDayOfMonth(); $i++)
                    <div class="hc-cal-day"></div>
                @endfor

                <!-- Calendar Days -->
                @for($day = 1; $day <= $this->getDaysInMonth(); $day++)
                    <?php
                    $dayLeaveRequests = $this->getLeaveRequestsForDate($day);
                    $isWeekend = $this->isWeekend($day);
                    $isToday = $this->isToday($day);
                    ?>
                    <div class="hc-cal-day @if($isWeekend) weekend @endif @if($isToday) today @endif"
                         wire:click="selectDate('{{ $currentYear }}-{{ str_pad($currentMonth, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}')">
                        <div class="hc-day-number">{{ $day }}</div>
                        @if($dayLeaveRequests->count() > 0)
                            <div class="hc-events">
                                @foreach($dayLeaveRequests->take(2) as $leaveRequest)
                                    <div class="hc-event {{ $leaveRequest->status }}">
                                        {{ $leaveRequest->employee->first_name }} - {{ $leaveRequest->leaveType->name }}
                                    </div>
                                @endforeach
                                @if($dayLeaveRequests->count() > 2)
                                    <div class="hc-more">+{{ $dayLeaveRequests->count() - 2 }} more</div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endfor

                <!-- Empty Days for Month End -->
                @php
                $totalCells = $this->getFirstDayOfMonth() + $this->getDaysInMonth();
                $emptyCells = (7 - ($totalCells % 7)) % 7;
                @endphp
                @for($i = 0; $i < $emptyCells; $i++)
                    <div class="hc-cal-day"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ── Selected Date Details ───────────────────────────── --}}
    @if($selectedDate)
        <div class="g-card hc-details anim-3">
            <div class="hc-details-head">
                <h3 class="hc-details-title">
                    Leave Requests for {{ Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                </h3>
            </div>
            <div class="hc-details-body">
                @php
                $selectedDay = Carbon\Carbon::parse($selectedDate)->day;
                $selectedLeaveRequests = $this->getLeaveRequestsForDate($selectedDay);
                @endphp
                
                @if($selectedLeaveRequests->count() > 0)
                    @foreach($selectedLeaveRequests as $leaveRequest)
                        <div class="hc-leave-item">
                            <div class="hc-leave-header">
                                <div class="hc-leave-name">
                                    {{ $leaveRequest->employee->first_name }} {{ $leaveRequest->employee->last_name }}
                                </div>
                                <div class="hc-leave-actions">
                                    <span class="badge badge-{{ $leaveRequest->status === 'approved' ? 'green' : ($leaveRequest->status === 'pending' ? 'amber' : 'red') }}">
                                        {{ ucfirst($leaveRequest->status) }}
                                    </span>
                                    <a href="{{ route('leave-attendance.hr-leave-management') }}" class="btn-manage">
                                        Manage
                                    </a>
                                </div>
                            </div>
                            <div class="hc-leave-meta">
                                {{ $leaveRequest->leaveType->name }} - {{ $leaveRequest->start_date }} to {{ $leaveRequest->end_date }}
                            </div>
                            @if($leaveRequest->reason)
                                <div class="hc-leave-reason">{{ $leaveRequest->reason }}</div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="hc-empty">
                        <div class="hc-empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        </div>
                        <p class="hc-empty-title">No leave requests for this date</p>
                        <p class="hc-empty-sub">Try selecting a different date.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ── Floating nav ───────────────────────────────────── --}}
    <nav class="ios-nav">
        <a href="{{ route('leave-attendance.dashboard') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Dashboard
        </a>
        <a href="{{ route('leave-attendance.requests') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Leave
        </a>
        <a href="{{ route('leave-attendance.hr-leave-management') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Manage
        </a>
        <a href="{{ route('leave-attendance.hr-calendar') }}" class="ios-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Calendar
            <span class="ios-nav-active-dot"></span>
        </a>
        <a href="{{ route('employees') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            Employees
        </a>
        <a href="{{ route('leave-attendance.hr-communication') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Messages
        </a>
    </nav>

</div>
</div>
