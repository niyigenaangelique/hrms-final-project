<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.hpc-root {
    --glass-bg:       rgba(255,255,255,0.50);
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
    display: flex; flex-direction: column; gap: 20px; max-width: 100%;
}
@keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.anim-1 { animation: fadeSlideUp 0.35s ease both; }
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }
.anim-3 { animation: fadeSlideUp 0.35s 0.14s ease both; }
.g-card {
    background: var(--glass-bg); backdrop-filter: var(--blur); -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border); border-radius: var(--radius);
    box-shadow: var(--glass-shadow); position: relative;
}
.g-card::before { content: ''; position: absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.9),transparent); pointer-events:none; border-radius: var(--radius) var(--radius) 0 0; }
.hpc-header { padding: 24px 30px; display:flex; justify-content:space-between; align-items:center; gap:20px; }
.hpc-header h1 { font-size:24px; font-weight:700; color:var(--text-primary); letter-spacing:-0.4px; margin:0 0 3px; }
.hpc-header p  { font-size:13.5px; font-weight:500; color:var(--text-secondary); margin:0; }
.hpc-header-role { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.hpc-header-name { font-size:14px; font-weight:700; color:var(--text-primary); }
.hpc-cal-body { padding: 24px 26px 26px; }
.hpc-nav { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
.hpc-nav h2 { font-size:20px; font-weight:700; color:var(--text-primary); letter-spacing:-0.3px; margin:0; }
.hpc-nav-btn { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.6); border:1px solid rgba(0,0,0,0.08); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s; }
.hpc-nav-btn:hover { background:rgba(255,255,255,0.9); transform:scale(1.05); }
.hpc-nav-btn svg { width:16px; height:16px; stroke:var(--text-secondary); }
.hpc-legend { display:flex; flex-wrap:wrap; gap:14px; margin-bottom:20px; padding:13px 16px; background:rgba(255,255,255,0.4); border:1px solid rgba(255,255,255,0.7); border-radius:var(--radius-sm); }
.hpc-legend-item { display:flex; align-items:center; gap:7px; font-size:12px; font-weight:500; color:var(--text-secondary); }
.hpc-legend-dot { width:12px; height:12px; border-radius:4px; flex-shrink:0; }
.ld-green  { background:rgba(34,197,94,0.25);  border:1px solid rgba(34,197,94,0.4); }
.ld-amber  { background:rgba(245,158,11,0.25); border:1px solid rgba(245,158,11,0.4); }
.ld-red    { background:rgba(239,68,68,0.25);  border:1px solid rgba(239,68,68,0.4); }
.ld-purple { background:rgba(168,85,247,0.2);  border:1px solid rgba(168,85,247,0.4); }
.hpc-cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:1px; background:rgba(0,0,0,0.06); border-radius:var(--radius); overflow:hidden; }
.hpc-cal-header { background:rgba(0,0,0,0.03); padding:10px 6px; text-align:center; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.hpc-cal-day { background:rgba(255,255,255,0.7); min-height:96px; padding:8px; cursor:pointer; transition:background .15s; }
.hpc-cal-day:hover { background:rgba(255,255,255,0.95); }
.hpc-cal-day.weekend { background:rgba(0,0,0,0.02); }
.hpc-cal-day.today { background:rgba(37,99,235,0.07); box-shadow:inset 0 0 0 2px rgba(37,99,235,0.2); }
.hpc-cal-day.today:hover { background:rgba(37,99,235,0.11); }
.hpc-cal-day.empty { cursor:default; }
.hpc-day-num { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:4px; }
.hpc-cal-day.weekend .hpc-day-num { color:var(--text-tertiary); }
.hpc-cal-day.today   .hpc-day-num { color:#2563eb; font-weight:700; }
.hpc-events { display:flex; flex-direction:column; gap:2px; }
.hpc-event { font-size:10px; font-weight:600; padding:2px 5px; border-radius:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.hpc-event.approved { background:rgba(34,197,94,0.15);  color:#15803d; }
.hpc-event.pending  { background:rgba(245,158,11,0.15); color:#92400e; }
.hpc-event.rejected { background:rgba(239,68,68,0.15);  color:#b91c1c; }
.hpc-event.holiday  { background:rgba(168,85,247,0.15); color:#7e22ce; }
.hpc-more { font-size:10px; color:var(--text-tertiary); font-weight:500; }
.hpc-details-head { padding:18px 24px 14px; border-bottom:1px solid rgba(0,0,0,0.055); }
.hpc-details-title { font-size:16px; font-weight:700; color:var(--text-primary); margin:0; }
.hpc-details-body { padding:16px 24px 22px; display:flex; flex-direction:column; gap:16px; }
.hpc-section-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); margin-bottom:10px; }
.hpc-holiday-item { border-left:3px solid rgba(168,85,247,0.6); background:rgba(168,85,247,0.06); border-radius:0 var(--radius-sm) var(--radius-sm) 0; padding:12px 14px; margin-bottom:8px; }
.hpc-holiday-name { font-size:14px; font-weight:700; color:#6b21a8; }
.hpc-holiday-desc { font-size:12px; font-weight:500; color:#7e22ce; margin-top:3px; }
.hpc-leave-item { background:rgba(255,255,255,0.5); border:1px solid rgba(255,255,255,0.8); border-radius:var(--radius-sm); padding:14px 16px; margin-bottom:10px; transition:box-shadow .15s; }
.hpc-leave-item:hover { box-shadow:0 4px 14px rgba(0,0,0,0.07); }
.hpc-leave-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px; }
.hpc-leave-type { font-size:14px; font-weight:700; color:var(--text-primary); }
.hpc-leave-actions { display:flex; align-items:center; gap:8px; }
.hpc-leave-dates { font-size:12px; font-weight:500; color:var(--text-secondary); margin-bottom:4px; }
.hpc-leave-reason { font-size:12px; color:var(--text-tertiary); line-height:1.4; }
.badge { display:inline-flex; font-size:10px; font-weight:700; padding:3px 8px; border-radius:var(--radius-pill); }
.badge-green  { background:rgba(34,197,94,0.14);  color:#15803d; }
.badge-amber  { background:rgba(245,158,11,0.14); color:#b45309; }
.badge-red    { background:rgba(239,68,68,0.14);  color:#b91c1c; }
.btn-edit { font-size:11px; font-weight:600; color:#2563eb; background:rgba(37,99,235,0.09); border:none; border-radius:6px; padding:4px 10px; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .13s; text-decoration:none; }
.btn-edit:hover { background:rgba(37,99,235,0.16); }
.hpc-empty { text-align:center; padding:40px 24px; }
.hpc-empty-icon { width:48px; height:48px; background:rgba(0,0,0,0.05); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; }
.hpc-empty-icon svg { width:24px; height:24px; stroke:var(--text-tertiary); }
.hpc-empty-title { font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 4px; }
.hpc-empty-sub   { font-size:13px; font-weight:500; color:var(--text-secondary); margin:0 0 14px; }
.btn-request-leave { display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; background:linear-gradient(135deg,#0d9488,#0891b2); color:#fff; border:none; border-radius:var(--radius-sm); padding:9px 18px; cursor:pointer; text-decoration:none; box-shadow:0 4px 12px rgba(13,148,136,0.28); transition:transform .15s,box-shadow .15s; }
.btn-request-leave:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(13,148,136,0.38); }
.ios-nav { position:fixed; bottom:24px; left:50%; transform:translateX(-50%); z-index:100; display:flex; align-items:center; gap:2px; background:rgba(15,15,25,0.75); backdrop-filter:blur(32px) saturate(2); -webkit-backdrop-filter:blur(32px) saturate(2); border:1px solid rgba(255,255,255,0.13); border-radius:28px; padding:8px 10px; box-shadow:0 20px 60px rgba(0,0,0,0.2),0 4px 16px rgba(0,0,0,0.1),inset 0 1px 0 rgba(255,255,255,0.1); }
.ios-nav::before { content:''; position:absolute; top:0; left:16px; right:16px; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.22),transparent); }
.ios-nav-item { display:flex; flex-direction:column; align-items:center; gap:3px; padding:8px 18px; border-radius:20px; text-decoration:none; font-size:10px; font-weight:500; color:rgba(255,255,255,0.45); letter-spacing:.03em; min-width:64px; position:relative; transition:background .2s,color .2s,transform .15s; }
.ios-nav-item svg { width:20px; height:20px; stroke:currentColor; transition:transform .2s; }
.ios-nav-item:hover { color:rgba(255,255,255,0.85); background:rgba(255,255,255,0.08); transform:translateY(-1px); }
.ios-nav-item:hover svg { transform:scale(1.1); }
.ios-nav-item.active { color:#fff; background:rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke:#60a5fa; }
.ios-nav-active-dot { position:absolute; bottom:4px; width:4px; height:4px; border-radius:50%; background:#60a5fa; }
@media (max-width:768px) { .hpc-root { padding:18px 14px 100px; } .ios-nav-item { padding:7px 12px; min-width:48px; font-size:9px; } .ios-nav-item svg { width:18px; height:18px; } }
</style>

<div class="hpc-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="hpc-header">
            <div>
                <h1>My Calendar</h1>
                <p>View your personal leave schedule and company holidays</p>
            </div>
            @if($hrEmployee)
                <div style="text-align:right;">
                    <div class="hpc-header-role">HR Staff</div>
                    <div class="hpc-header-name">{{ $hrEmployee->first_name }} {{ $hrEmployee->last_name }}</div>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Calendar ──────────────────────────────────── --}}
    <div class="g-card anim-2">
        <div class="hpc-cal-body">
            <div class="hpc-nav">
                <button wire:click="previousMonth" class="hpc-nav-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <h2>{{ $this->getMonthName() }} {{ $currentYear }}</h2>
                <button wire:click="nextMonth" class="hpc-nav-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <div class="hpc-legend">
                <div class="hpc-legend-item"><div class="hpc-legend-dot ld-green"></div>Approved Leave</div>
                <div class="hpc-legend-item"><div class="hpc-legend-dot ld-amber"></div>Pending Leave</div>
                <div class="hpc-legend-item"><div class="hpc-legend-dot ld-red"></div>Rejected Leave</div>
                <div class="hpc-legend-item"><div class="hpc-legend-dot ld-purple"></div>Holiday</div>
            </div>

            <div class="hpc-cal-grid">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                    <div class="hpc-cal-header">{{ $day }}</div>
                @endforeach

                @for($i = 0; $i < $this->getFirstDayOfMonth(); $i++)
                    <div class="hpc-cal-day empty"></div>
                @endfor

                @for($day = 1; $day <= $this->getDaysInMonth(); $day++)
                    @php
                        $dayLeaves = $this->getLeaveRequestsForDate($day);
                        $dayHols   = $this->getHolidaysForDate($day);
                        $isWeekend = $this->isWeekend($day);
                        $isToday   = $this->isToday($day);
                        $dateStr   = $currentYear.'-'.str_pad($currentMonth,2,'0',STR_PAD_LEFT).'-'.str_pad($day,2,'0',STR_PAD_LEFT);
                    @endphp
                    <div class="hpc-cal-day {{ $isWeekend ? 'weekend' : '' }} {{ $isToday ? 'today' : '' }}"
                         wire:click="selectDate('{{ $dateStr }}')">
                        <div class="hpc-day-num">{{ $day }}</div>
                        <div class="hpc-events">
                            @foreach($dayHols->take(1) as $hol)
                                <div class="hpc-event holiday">{{ $hol->name }}</div>
                            @endforeach
                            @foreach($dayLeaves->take(2) as $lr)
                                @php $ls = is_string($lr->status) ? $lr->status : $lr->status->value; @endphp
                                <div class="hpc-event {{ $ls }}">{{ $lr->leaveType->name }}</div>
                            @endforeach
                            @php $total = $dayLeaves->count() + $dayHols->count(); @endphp
                            @if($total > 3)
                                <div class="hpc-more">+{{ $total - 3 }} more</div>
                            @endif
                        </div>
                    </div>
                @endfor

                @php
                    $totalCells = $this->getFirstDayOfMonth() + $this->getDaysInMonth();
                    $emptyCells = (7 - ($totalCells % 7)) % 7;
                @endphp
                @for($i = 0; $i < $emptyCells; $i++)
                    <div class="hpc-cal-day empty"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ── Date details ──────────────────────────────── --}}
    @if($selectedDate)
        @php
            $selDay    = \Carbon\Carbon::parse($selectedDate)->day;
            $selLeaves = $this->getLeaveRequestsForDate($selDay);
            $selHols   = $this->getHolidaysForDate($selDay);
        @endphp
        <div class="g-card anim-3">
            <div class="hpc-details-head">
                <h3 class="hpc-details-title">{{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</h3>
            </div>
            <div class="hpc-details-body">

                @if($selHols->count() > 0)
                    <div>
                        <div class="hpc-section-title">Holidays</div>
                        @foreach($selHols as $hol)
                            <div class="hpc-holiday-item">
                                <div class="hpc-holiday-name">{{ $hol->name }}</div>
                                @if($hol->description)
                                    <div class="hpc-holiday-desc">{{ $hol->description }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($selLeaves->count() > 0)
                    <div>
                        <div class="hpc-section-title">Your Leave Requests</div>
                        @foreach($selLeaves as $lr)
                            @php
                                $ls = is_string($lr->status) ? $lr->status : $lr->status->value;
                                $bc = match($ls) { 'approved' => 'badge-green', 'pending' => 'badge-amber', default => 'badge-red' };
                            @endphp
                            <div class="hpc-leave-item">
                                <div class="hpc-leave-header">
                                    <div class="hpc-leave-type">{{ $lr->leaveType->name }}</div>
                                    <div class="hpc-leave-actions">
                                        <span class="badge {{ $bc }}">{{ ucfirst($ls) }}</span>
                                        @if($ls === 'pending')
                                            <a href="{{ route('employee.leave.request') }}" class="btn-edit">Edit</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="hpc-leave-dates">{{ $lr->start_date }} → {{ $lr->end_date }}</div>
                                @if($lr->reason)
                                    <div class="hpc-leave-reason">{{ $lr->reason }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($selHols->count() === 0 && $selLeaves->count() === 0)
                    <div class="hpc-empty">
                        <div class="hpc-empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        </div>
                        <p class="hpc-empty-title">Nothing scheduled</p>
                        <p class="hpc-empty-sub">No leaves or holidays on this date.</p>
                        <a href="{{ route('employee.leave.request') }}" class="btn-request-leave">Request Leave</a>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ── Floating nav ──────────────────────────────── --}}
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
