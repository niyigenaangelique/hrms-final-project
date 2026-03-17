<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.huc-root {
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
.anim-4 { animation: fadeSlideUp 0.35s 0.21s ease both; }
.g-card { background:var(--glass-bg); backdrop-filter:var(--blur); -webkit-backdrop-filter:var(--blur); border:1px solid var(--glass-border); border-radius:var(--radius); box-shadow:var(--glass-shadow); position:relative; }
.g-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.9),transparent); pointer-events:none; border-radius:var(--radius) var(--radius) 0 0; }

/* Header */
.huc-header { padding:24px 30px; display:flex; justify-content:space-between; align-items:center; gap:20px; }
.huc-header h1 { font-size:24px; font-weight:700; color:var(--text-primary); letter-spacing:-0.4px; margin:0 0 3px; }
.huc-header p  { font-size:13.5px; font-weight:500; color:var(--text-secondary); margin:0; }
.huc-header-right { text-align:right; }
.huc-header-role { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.huc-header-name { font-size:14px; font-weight:700; color:var(--text-primary); }

/* View tabs */
.huc-tabs { padding:16px 24px; display:flex; gap:8px; }
.huc-tab {
    display:flex; align-items:center; gap:7px;
    padding:9px 16px; border-radius:var(--radius-sm);
    font-size:13px; font-weight:600; cursor:pointer;
    border:none; font-family:'DM Sans',sans-serif;
    transition:all .15s;
}
.huc-tab.inactive { background:rgba(255,255,255,0.5); color:var(--text-secondary); }
.huc-tab.inactive:hover { background:rgba(255,255,255,0.8); color:var(--text-primary); }
.huc-tab.active {
    background:linear-gradient(135deg,#0d9488,#0891b2);
    color:#fff; box-shadow:0 4px 14px rgba(13,148,136,0.3);
}
.huc-tab svg { width:15px; height:15px; stroke:currentColor; }

/* Filters */
.huc-filters { padding:18px 24px; display:grid; grid-template-columns:1fr 1fr auto; gap:14px; align-items:end; }
.huc-filter-field { display:flex; flex-direction:column; gap:5px; }
.huc-filter-field label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.huc-filter-field select {
    padding:10px 14px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important;
    border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500;
    color:var(--text-primary); outline:none; width:100%; box-sizing:border-box; transition:border-color .15s,box-shadow .15s;
    -webkit-appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat:no-repeat !important; background-position:right 14px center !important; padding-right:36px !important;
}
.huc-filter-field select:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; background:rgba(255,255,255,0.96) !important; }
.btn-refresh { padding:10px 18px; background:linear-gradient(135deg,#0d9488,#0891b2); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(13,148,136,0.3); display:flex; align-items:center; gap:7px; transition:transform .15s,box-shadow .15s; }
.btn-refresh:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(13,148,136,0.42); }
.btn-refresh svg { width:15px; height:15px; stroke:#fff; }

/* Calendar */
.huc-cal-body { padding:22px 26px 26px; }
.huc-nav { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
.huc-nav h2 { font-size:20px; font-weight:700; color:var(--text-primary); letter-spacing:-0.3px; margin:0; }
.huc-nav-btn { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.6); border:1px solid rgba(0,0,0,0.08); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s; }
.huc-nav-btn:hover { background:rgba(255,255,255,0.9); transform:scale(1.05); }
.huc-nav-btn svg { width:16px; height:16px; stroke:var(--text-secondary); }

.huc-legend { display:flex; flex-wrap:wrap; gap:14px; margin-bottom:18px; padding:12px 16px; background:rgba(255,255,255,0.4); border:1px solid rgba(255,255,255,0.7); border-radius:var(--radius-sm); }
.huc-legend-item { display:flex; align-items:center; gap:7px; font-size:12px; font-weight:500; color:var(--text-secondary); }
.huc-legend-dot { width:12px; height:12px; border-radius:4px; flex-shrink:0; }
.ld-green  { background:rgba(34,197,94,0.25);  border:1px solid rgba(34,197,94,0.4); }
.ld-amber  { background:rgba(245,158,11,0.25); border:1px solid rgba(245,158,11,0.4); }
.ld-red    { background:rgba(239,68,68,0.25);  border:1px solid rgba(239,68,68,0.4); }
.ld-purple { background:rgba(168,85,247,0.2);  border:1px solid rgba(168,85,247,0.4); }
.ld-blue   { background:rgba(37,99,235,0.2);   border:1px solid rgba(37,99,235,0.4); }
.ld-orange { background:rgba(249,115,22,0.2);  border:1px solid rgba(249,115,22,0.4); }
.ld-indigo { background:rgba(99,102,241,0.2);  border:1px solid rgba(99,102,241,0.4); }

.huc-cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:1px; background:rgba(0,0,0,0.06); border-radius:var(--radius); overflow:hidden; }
.huc-cal-header { background:rgba(0,0,0,0.03); padding:10px 6px; text-align:center; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.huc-cal-day { background:rgba(255,255,255,0.7); min-height:96px; padding:8px; cursor:pointer; transition:background .15s; }
.huc-cal-day:hover { background:rgba(255,255,255,0.95); }
.huc-cal-day.weekend { background:rgba(0,0,0,0.02); }
.huc-cal-day.today { background:rgba(37,99,235,0.07); box-shadow:inset 0 0 0 2px rgba(37,99,235,0.2); }
.huc-cal-day.today:hover { background:rgba(37,99,235,0.11); }
.huc-cal-day.empty { cursor:default; }
.huc-day-num { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:4px; }
.huc-cal-day.weekend .huc-day-num { color:var(--text-tertiary); }
.huc-cal-day.today   .huc-day-num { color:#2563eb; font-weight:700; }
.huc-events { display:flex; flex-direction:column; gap:2px; }
.huc-event { font-size:10px; font-weight:600; padding:2px 5px; border-radius:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.huc-event.approved { background:rgba(34,197,94,0.15);  color:#15803d; }
.huc-event.pending  { background:rgba(245,158,11,0.15); color:#92400e; }
.huc-event.rejected { background:rgba(239,68,68,0.15);  color:#b91c1c; }
.huc-event.holiday  { background:rgba(168,85,247,0.15); color:#7e22ce; }
.huc-event.period_start  { background:rgba(37,99,235,0.12);  color:#1d4ed8; }
.huc-event.period_end    { background:rgba(249,115,22,0.12); color:#c2410c; }
.huc-event.payday        { background:rgba(34,197,94,0.15);  color:#15803d; }
.huc-event.processed     { background:rgba(99,102,241,0.12); color:#4338ca; }
.huc-more { font-size:10px; color:var(--text-tertiary); font-weight:500; }

/* Details panel */
.huc-details-head { padding:18px 24px 14px; border-bottom:1px solid rgba(0,0,0,0.055); }
.huc-details-title { font-size:16px; font-weight:700; color:var(--text-primary); margin:0; }
.huc-details-body { padding:16px 24px 22px; display:flex; flex-direction:column; gap:16px; }
.huc-section-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); margin-bottom:10px; }
.huc-holiday-item { border-left:3px solid rgba(168,85,247,0.6); background:rgba(168,85,247,0.06); border-radius:0 var(--radius-sm) var(--radius-sm) 0; padding:12px 14px; margin-bottom:8px; }
.huc-holiday-name { font-size:14px; font-weight:700; color:#6b21a8; }
.huc-holiday-desc { font-size:12px; font-weight:500; color:#7e22ce; margin-top:3px; }
.huc-item { background:rgba(255,255,255,0.5); border:1px solid rgba(255,255,255,0.8); border-radius:var(--radius-sm); padding:14px 16px; margin-bottom:10px; transition:box-shadow .15s; }
.huc-item:hover { box-shadow:0 4px 14px rgba(0,0,0,0.07); }
.huc-item-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px; }
.huc-item-title { font-size:14px; font-weight:700; color:var(--text-primary); }
.huc-item-actions { display:flex; align-items:center; gap:8px; }
.huc-item-meta { font-size:12px; font-weight:500; color:var(--text-secondary); margin-bottom:4px; }
.huc-item-sub  { font-size:12px; color:var(--text-tertiary); line-height:1.4; }
.badge { display:inline-flex; font-size:10px; font-weight:700; padding:3px 8px; border-radius:var(--radius-pill); }
.badge-green  { background:rgba(34,197,94,0.14);  color:#15803d; }
.badge-amber  { background:rgba(245,158,11,0.14); color:#b45309; }
.badge-red    { background:rgba(239,68,68,0.14);  color:#b91c1c; }
.badge-blue   { background:rgba(37,99,235,0.12);  color:#1d4ed8; }
.badge-orange { background:rgba(249,115,22,0.12); color:#c2410c; }
.badge-indigo { background:rgba(99,102,241,0.12); color:#4338ca; }
.btn-link { font-size:11px; font-weight:600; color:#2563eb; background:rgba(37,99,235,0.09); border:none; border-radius:6px; padding:4px 10px; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .13s; text-decoration:none; }
.btn-link:hover { background:rgba(37,99,235,0.16); }
.huc-empty { text-align:center; padding:40px 24px; }
.huc-empty-icon { width:48px; height:48px; background:rgba(0,0,0,0.05); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; }
.huc-empty-icon svg { width:24px; height:24px; stroke:var(--text-tertiary); }
.huc-empty-title { font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 4px; }
.huc-empty-sub   { font-size:13px; font-weight:500; color:var(--text-secondary); margin:0 0 14px; }
.btn-cta { display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; background:linear-gradient(135deg,#0d9488,#0891b2); color:#fff; border:none; border-radius:var(--radius-sm); padding:9px 18px; cursor:pointer; text-decoration:none; box-shadow:0 4px 12px rgba(13,148,136,0.28); transition:transform .15s,box-shadow .15s; }
.btn-cta:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(13,148,136,0.38); }

/* Nav */
.ios-nav { position:fixed; bottom:24px; left:50%; transform:translateX(-50%); z-index:100; display:flex; align-items:center; gap:2px; background:rgba(15,15,25,0.75); backdrop-filter:blur(32px) saturate(2); -webkit-backdrop-filter:blur(32px) saturate(2); border:1px solid rgba(255,255,255,0.13); border-radius:28px; padding:8px 10px; box-shadow:0 20px 60px rgba(0,0,0,0.2),0 4px 16px rgba(0,0,0,0.1),inset 0 1px 0 rgba(255,255,255,0.1); }
.ios-nav::before { content:''; position:absolute; top:0; left:16px; right:16px; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.22),transparent); }
.ios-nav-item { display:flex; flex-direction:column; align-items:center; gap:3px; padding:8px 18px; border-radius:20px; text-decoration:none; font-size:10px; font-weight:500; color:rgba(255,255,255,0.45); letter-spacing:.03em; min-width:64px; position:relative; transition:background .2s,color .2s,transform .15s; }
.ios-nav-item svg { width:20px; height:20px; stroke:currentColor; transition:transform .2s; }
.ios-nav-item:hover { color:rgba(255,255,255,0.85); background:rgba(255,255,255,0.08); transform:translateY(-1px); }
.ios-nav-item:hover svg { transform:scale(1.1); }
.ios-nav-item.active { color:#fff; background:rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke:#60a5fa; }
.ios-nav-active-dot { position:absolute; bottom:4px; width:4px; height:4px; border-radius:50%; background:#60a5fa; }
@media (max-width:768px) { .huc-root { padding:18px 14px 100px; } .huc-filters { grid-template-columns:1fr; } .huc-tabs { flex-wrap:wrap; } .ios-nav-item { padding:7px 12px; min-width:48px; font-size:9px; } .ios-nav-item svg { width:18px; height:18px; } }
</style>

<div class="huc-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="huc-header">
            <div>
                <h1>HR Calendar</h1>
                <p>View team leave schedules and your personal calendar</p>
            </div>
            @if($hrEmployee)
                <div class="huc-header-right">
                    <div class="huc-header-role">HR Staff</div>
                    <div class="huc-header-name">{{ $hrEmployee->first_name }} {{ $hrEmployee->last_name }}</div>
                </div>
            @endif
        </div>
    </div>

    {{-- ── View toggle tabs ──────────────────────────── --}}
    <div class="g-card anim-2">
        <div class="huc-tabs">
            <button wire:click="switchView('team')" class="huc-tab {{ $activeView === 'team' ? 'active' : 'inactive' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Team Calendar
            </button>
            <button wire:click="switchView('personal')" class="huc-tab {{ $activeView === 'personal' ? 'active' : 'inactive' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                My Calendar
            </button>
            <button wire:click="switchView('payroll')" class="huc-tab {{ $activeView === 'payroll' ? 'active' : 'inactive' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                Payroll Calendar
            </button>
        </div>
    </div>

    {{-- ── Filters (team only) ───────────────────────── --}}
    @if($activeView === 'team')
        <div class="g-card anim-3">
            <div class="huc-filters">
                <div class="huc-filter-field">
                    <label>Filter by Employee</label>
                    <select wire:model.live="filterEmployee">
                        <option value="">All Employees</option>
                        @foreach(App\Models\Employee::where('approval_status','Approved')->orderBy('first_name')->get() as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="huc-filter-field">
                    <label>Filter by Status</label>
                    <select wire:model.live="filterStatus">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <button wire:click="loadData" class="btn-refresh">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Refresh
                </button>
            </div>
        </div>
    @endif

    {{-- ── Calendar grid ─────────────────────────────── --}}
    <div class="g-card {{ $activeView === 'team' ? 'anim-4' : 'anim-3' }}">
        <div class="huc-cal-body">

            <div class="huc-nav">
                <button wire:click="previousMonth" class="huc-nav-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <h2>
                    {{ $this->getMonthName() }} {{ $currentYear }}
                    @if($activeView === 'team') — Team @elseif($activeView === 'personal') — Personal @else — Payroll @endif
                </h2>
                <button wire:click="nextMonth" class="huc-nav-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            {{-- Legend --}}
            <div class="huc-legend">
                @if($activeView === 'team')
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-green"></div>Approved Leave</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-amber"></div>Pending Leave</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-red"></div>Rejected Leave</div>
                @elseif($activeView === 'personal')
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-green"></div>Approved Leave</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-amber"></div>Pending Leave</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-red"></div>Rejected Leave</div>
                @else
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-blue"></div>Pay Period Start</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-orange"></div>Pay Period End</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-green"></div>Payday</div>
                    <div class="huc-legend-item"><div class="huc-legend-dot ld-indigo"></div>Payment Processed</div>
                @endif
                <div class="huc-legend-item"><div class="huc-legend-dot ld-purple"></div>Holiday</div>
            </div>

            <div class="huc-cal-grid">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                    <div class="huc-cal-header">{{ $d }}</div>
                @endforeach

                @for($i = 0; $i < $this->getFirstDayOfMonth(); $i++)
                    <div class="huc-cal-day empty"></div>
                @endfor

                @for($day = 1; $day <= $this->getDaysInMonth(); $day++)
                    @php
                        $dayLeaves  = $activeView === 'team'
                            ? $this->getTeamLeaveRequestsForDate($day)
                            : ($activeView === 'personal' ? $this->getPersonalLeaveRequestsForDate($day) : collect());
                        $dayHols    = $this->getHolidaysForDate($day);
                        $dayPayroll = $this->getPayrollEventsForDate($day);
                        $isWeekend  = $this->isWeekend($day);
                        $isToday    = $this->isToday($day);
                        $dateStr    = $currentYear.'-'.str_pad($currentMonth,2,'0',STR_PAD_LEFT).'-'.str_pad($day,2,'0',STR_PAD_LEFT);
                        $maxLeaves  = $activeView === 'team' ? 2 : 3;
                    @endphp
                    <div class="huc-cal-day {{ $isWeekend ? 'weekend' : '' }} {{ $isToday ? 'today' : '' }}"
                         wire:click="selectDate('{{ $dateStr }}')">
                        <div class="huc-day-num">{{ $day }}</div>
                        <div class="huc-events">
                            @foreach($dayHols->take(1) as $hol)
                                <div class="huc-event holiday">{{ $hol->name }}</div>
                            @endforeach
                            @foreach($dayLeaves->take($maxLeaves) as $lr)
                                @php $ls = is_string($lr->status) ? $lr->status : $lr->status->value; @endphp
                                <div class="huc-event {{ $ls }}">
                                    @if($activeView === 'team'){{ $lr->employee->first_name }} · @endif{{ $lr->leaveType->name }}
                                </div>
                            @endforeach
                            @if($activeView === 'payroll')
                                @foreach($dayPayroll->take(3) as $ev)
                                    <div class="huc-event {{ $ev['type'] }}">
                                        @if($ev['type']==='payday')💰 @endif{{ $ev['title'] }}
                                    </div>
                                @endforeach
                            @endif
                            @php
                                $shown = $dayHols->count() + $dayLeaves->count() + ($activeView === 'payroll' ? $dayPayroll->count() : 0);
                                $shown = min($shown, 1 + $maxLeaves + 3);
                                $total = $dayHols->count() + $dayLeaves->count() + $dayPayroll->count();
                            @endphp
                            @if($total > $shown)
                                <div class="huc-more">+{{ $total - $shown }} more</div>
                            @endif
                        </div>
                    </div>
                @endfor

                @php
                    $totalCells = $this->getFirstDayOfMonth() + $this->getDaysInMonth();
                    $emptyCells = (7 - ($totalCells % 7)) % 7;
                @endphp
                @for($i = 0; $i < $emptyCells; $i++)
                    <div class="huc-cal-day empty"></div>
                @endfor
            </div>

        </div>
    </div>

    {{-- ── Selected date details ─────────────────────── --}}
    @if($selectedDate)
        @php
            $selDay     = \Carbon\Carbon::parse($selectedDate)->day;
            $selLeaves  = $activeView === 'team'
                ? $this->getTeamLeaveRequestsForDate($selDay)
                : ($activeView === 'personal' ? $this->getPersonalLeaveRequestsForDate($selDay) : collect());
            $selHols    = $this->getHolidaysForDate($selDay);
            $selPayroll = $this->getPayrollEventsForDate($selDay);
        @endphp
        <div class="g-card anim-4">
            <div class="huc-details-head">
                <h3 class="huc-details-title">{{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</h3>
            </div>
            <div class="huc-details-body">

                @if($selHols->count() > 0)
                    <div>
                        <div class="huc-section-title">Holidays</div>
                        @foreach($selHols as $hol)
                            <div class="huc-holiday-item">
                                <div class="huc-holiday-name">{{ $hol->name }}</div>
                                @if($hol->description)
                                    <div class="huc-holiday-desc">{{ $hol->description }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($selLeaves->count() > 0)
                    <div>
                        <div class="huc-section-title">{{ $activeView === 'team' ? 'Team Leave Requests' : 'Your Leave Requests' }}</div>
                        @foreach($selLeaves as $lr)
                            @php
                                $ls = is_string($lr->status) ? $lr->status : $lr->status->value;
                                $bc = match($ls) { 'approved' => 'badge-green', 'pending' => 'badge-amber', default => 'badge-red' };
                            @endphp
                            <div class="huc-item">
                                <div class="huc-item-header">
                                    <div>
                                        @if($activeView === 'team')
                                            <div class="huc-item-title">{{ $lr->employee->first_name }} {{ $lr->employee->last_name }}</div>
                                        @endif
                                        <div class="{{ $activeView === 'team' ? 'huc-item-meta' : 'huc-item-title' }}">{{ $lr->leaveType->name }}</div>
                                    </div>
                                    <div class="huc-item-actions">
                                        <span class="badge {{ $bc }}">{{ ucfirst($ls) }}</span>
                                        @if($activeView === 'team')
                                            <a href="{{ route('leave-attendance.hr-leave-management') }}" class="btn-link">Manage</a>
                                        @elseif($ls === 'pending')
                                            <a href="{{ route('employee.leave.request') }}" class="btn-link">Edit</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="huc-item-meta">{{ $lr->start_date }} → {{ $lr->end_date }}</div>
                                @if($lr->reason)
                                    <div class="huc-item-sub">{{ $lr->reason }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($activeView === 'payroll' && $selPayroll->count() > 0)
                    <div>
                        <div class="huc-section-title">Payroll Events</div>
                        @foreach($selPayroll as $ev)
                            @php
                                $evbc = match($ev['type']) {
                                    'period_start' => 'badge-blue',
                                    'period_end'   => 'badge-orange',
                                    'payday'       => 'badge-green',
                                    default        => 'badge-indigo',
                                };
                            @endphp
                            <div class="huc-item">
                                <div class="huc-item-header">
                                    <div class="huc-item-title">@if($ev['type']==='payday')💰 @endif{{ $ev['title'] }}</div>
                                    <div class="huc-item-actions">
                                        <span class="badge {{ $evbc }}">{{ ucfirst(str_replace('_',' ',$ev['type'])) }}</span>
                                        @if($ev['type']==='payday')
                                            <a href="{{ route('payroll.entries') }}" class="btn-link">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="huc-item-meta">{{ $ev['description'] }}</div>
                                @if($ev['type']==='payday' && isset($ev['data']->total_amount))
                                    <div class="huc-item-sub">Total: ${{ number_format($ev['data']->total_amount, 2) }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($selHols->count() === 0 && $selLeaves->count() === 0 && ($activeView !== 'payroll' || $selPayroll->count() === 0))
                    <div class="huc-empty">
                        <div class="huc-empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        </div>
                        <p class="huc-empty-title">Nothing scheduled</p>
                        <p class="huc-empty-sub">
                            @if($activeView === 'team') No team leaves or holidays for this date.
                            @elseif($activeView === 'personal') No personal leaves or holidays for this date.
                            @else No payroll events or holidays for this date. @endif
                        </p>
                        @if($activeView === 'personal')
                            <a href="{{ route('employee.leave.request') }}" class="btn-cta">Request Leave</a>
                        @elseif($activeView === 'payroll')
                            <a href="{{ route('payroll.dashboard') }}" class="btn-cta">Payroll Dashboard</a>
                        @endif
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
