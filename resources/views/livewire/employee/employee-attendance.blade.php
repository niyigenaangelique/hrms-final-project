<div class="att-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.att-root {
    --blue:     #3B6FE8;
    --blue-2:   #2755CC;
    --blue-3:   #1A3FA8;
    --blue-lt:  rgba(59,111,232,0.08);
    --blue-mid: rgba(59,111,232,0.16);
    --blue-brd: rgba(59,111,232,0.22);
    --green:    #12B76A;
    --green-lt: rgba(18,183,106,0.10);
    --amber:    #F59E0B;
    --amber-lt: rgba(245,158,11,0.10);
    --red:      #EF4444;
    --red-lt:   rgba(239,68,68,0.09);
    --bg:       #F0F4FA;
    --white:    #FFFFFF;
    --ink:      #0F1629;
    --ink2:     #2D3356;
    --ink3:     #6B7094;
    --ink4:     #A8ADCA;
    --border:   rgba(15,22,41,0.08);
    --shadow:   0 2px 12px rgba(59,111,232,0.07);
    --shadow-md:0 6px 28px rgba(59,111,232,0.12);
    --r:        12px;
    --r-lg:     18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    padding: 24px 24px 100px;
    display: flex; flex-direction: column; gap: 18px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.att-flash { padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 9px; }
.att-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.att-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.att-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.att-hero {
    background: var(--white); border-radius: var(--r-lg);
    border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden;
}
.att-hero-cover {
    height: 68px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.att-hero-cover::before {
    content:''; position:absolute; top:-30px; right:60px;
    width:160px; height:150px; border-radius:50%; background:rgba(255,255,255,0.06);
}
.att-hero-body {
    padding: 0 26px 20px;
    display: flex; align-items: flex-end; justify-content: space-between; gap: 16px;
    margin-top: 0;
}
.att-hero-icon {
    width: 52px; height: 52px; border-radius: 15px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white);
    box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.att-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.att-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.att-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }

/* Live clock */
.att-clock-wrap { display: flex; flex-direction: column; align-items: flex-end; padding-bottom: 4px; }
.att-clock-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); margin-bottom: 2px; }
.att-clock-time {
    font-family: 'Sora', sans-serif;
    font-size: 24px; font-weight: 800; color: var(--ink);
    letter-spacing: -0.5px; font-variant-numeric: tabular-nums;
}
.att-clock-tz {
    font-size: 10px; font-weight: 700; color: var(--blue);
    text-transform: uppercase; letter-spacing: 0.06em; margin-top: 1px; text-align: right;
}

/* ══ STAT STRIP ══════════════════════════════════════════ */
.att-stat-strip {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 1px; background: var(--border);
    border-radius: 0 0 var(--r-lg) var(--r-lg); overflow: hidden;
}
.att-stat-cell { background: var(--white); padding: 14px 18px; display: flex; flex-direction: column; gap: 3px; }
.att-stat-cell-icon {
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; margin-bottom: 4px;
}
.att-stat-cell-icon svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
.att-stat-cell-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.att-stat-cell-val   { font-family:'Sora',sans-serif; font-size: 17px; font-weight: 800; color: var(--ink2); }

/* ══ MAIN GRID ═══════════════════════════════════════════ */
.att-grid { display: grid; grid-template-columns: 1fr 280px; gap: 18px; align-items: start; }

/* ══ SHARED CARD ═════════════════════════════════════════ */
.att-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.att-card-hd { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.att-card-hd-left { display: flex; align-items: center; gap: 9px; }
.att-card-hd-icon { width: 30px; height: 30px; border-radius: 8px; background: var(--blue-lt); border: 1px solid var(--blue-brd); display: flex; align-items: center; justify-content: center; }
.att-card-hd-icon svg { width: 14px; height: 14px; stroke: var(--blue); fill: none; stroke-width: 2; }
.att-card-title { font-family:'Sora',sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.att-card-sub   { font-size: 11.5px; color: var(--ink4); font-weight: 500; }
.att-card-body  { padding: 20px; }

/* ══ CLOCK IN/OUT PANEL ══════════════════════════════════ */
.att-notes-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
.att-notes-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); }
.att-notes-field textarea {
    width: 100%; padding: 10px 13px; box-sizing: border-box;
    background: #F6F8FC; border: 1.5px solid var(--border);
    border-radius: var(--r); font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; resize: vertical; min-height: 80px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.att-notes-field textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white); }

.att-btn-clock-in {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 12px 24px; width: 100%;
    background: var(--blue); color: #fff; border: none; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 14px rgba(59,111,232,0.30);
    transition: background 0.15s, transform 0.12s;
}
.att-btn-clock-in:hover  { background: var(--blue-2); transform: translateY(-1px); }
.att-btn-clock-in:active { transform: scale(0.98); }
.att-btn-clock-in svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; }

.att-btn-clock-out {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 12px 24px; width: 100%;
    background: var(--red); color: #fff; border: none; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 14px rgba(239,68,68,0.28);
    transition: background 0.15s, transform 0.12s;
}
.att-btn-clock-out:hover  { background: #dc2626; transform: translateY(-1px); }
.att-btn-clock-out:active { transform: scale(0.98); }
.att-btn-clock-out svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; }

/* Loading indicator for Livewire actions */
.att-btn-clock-in[wire\:loading],
.att-btn-clock-out[wire\:loading] { opacity: 0.7; cursor: wait; }

/* ══ STATUS SIDEBAR ══════════════════════════════════════ */
.att-status-indicator {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px; border-radius: var(--r);
    margin-bottom: 16px;
}
.att-status-indicator.in-status  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); }
.att-status-indicator.out-status { background: var(--bg); border: 1px solid var(--border); }

.att-status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.dot-in  { background: var(--green); box-shadow: 0 0 0 3px rgba(18,183,106,0.2); animation: pulse-in 2s infinite; }
.dot-out { background: var(--ink4); }
@keyframes pulse-in {
    0%,100% { box-shadow: 0 0 0 3px rgba(18,183,106,0.2); }
    50%      { box-shadow: 0 0 0 7px rgba(18,183,106,0.06); }
}

.att-status-text { font-size: 14px; font-weight: 700; color: var(--ink); }
.att-status-sub  { font-size: 11.5px; color: var(--ink3); font-weight: 500; margin-top: 1px; }

.att-detail-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; border-bottom: 1px solid var(--border);
}
.att-detail-row:last-child { border-bottom: none; }
.att-detail-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.att-detail-value { font-size: 13.5px; font-weight: 700; color: var(--ink2); }

/* Hours worked progress ring */
.att-hours-ring { display: flex; flex-direction: column; align-items: center; padding: 16px 0; }
.att-ring-wrap { position: relative; width: 88px; height: 88px; margin-bottom: 8px; }
.att-ring-wrap svg { width: 88px; height: 88px; transform: rotate(-90deg); }
.att-ring-bg   { fill: none; stroke: var(--bg); stroke-width: 8; }
.att-ring-fill { fill: none; stroke: var(--blue); stroke-width: 8; stroke-linecap: round; transition: stroke-dashoffset 0.6s ease; }
.att-ring-text { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.att-ring-num { font-family:'Sora',sans-serif; font-size: 13px; font-weight: 800; color: var(--ink); line-height: 1; }
.att-ring-label { font-size: 9.5px; color: var(--ink4); font-weight: 600; }

/* ══ HISTORY TABLE ═══════════════════════════════════════ */
.att-table-wrap { overflow-x: auto; }
table.att-table { width: 100%; border-collapse: collapse; }
.att-table thead tr { border-bottom: 1px solid var(--border); }
.att-table th { padding: 10px 14px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.att-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s; }
.att-table tbody tr:last-child { border-bottom: none; }
.att-table tbody tr:hover { background: #F8FAFF; }
.att-table td { padding: 12px 14px; font-size: 13px; font-weight: 500; color: var(--ink2); white-space: nowrap; }
.att-table td.bold  { font-weight: 700; color: var(--ink); }
.att-table td.muted { color: var(--ink4); font-size: 12px; }

/* Badges */
.att-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700; }
.att-badge svg { width: 8px; height: 8px; stroke: currentColor; fill: currentColor; }
.badge-green  { background: var(--green-lt);  color: #087A42; }
.badge-red    { background: var(--red-lt);    color: #991B1B; }
.badge-amber  { background: var(--amber-lt);  color: #92400E; }
.badge-gray   { background: var(--bg);         color: var(--ink3); border: 1px solid var(--border); }

/* Empty */
.att-empty { text-align: center; padding: 48px 24px; }
.att-empty svg { width: 36px; height: 36px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 12px; display: block; opacity: 0.4; }
.att-empty-title { font-size: 15px; font-weight: 700; color: var(--ink3); margin-bottom: 4px; }
.att-empty-sub   { font-size: 13px; color: var(--ink4); font-weight: 500; }

/* ══ FLOATING NAV ════════════════════════════════════════ */
.ios-nav {
    position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 200;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.82); backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.11); border-radius: 28px; padding: 7px 10px;
    box-shadow: 0 20px 56px rgba(15,22,41,0.24);
}
.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 7px 15px; border-radius: 18px; text-decoration: none;
    font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.40);
    letter-spacing: 0.04em; min-width: 56px; position: relative;
    transition: background 0.18s, color 0.18s, transform 0.14s;
}
.ios-nav-item svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.8; }
.ios-nav-item:hover { color: rgba(255,255,255,0.82); background: rgba(255,255,255,0.07); transform: translateY(-1px); }
.ios-nav-item.active { color: #fff; background: rgba(59,111,232,0.25); }
.ios-nav-item.active svg { stroke: #93C5FD; }
.ios-nav-active-dot { position: absolute; bottom: 3px; width: 4px; height: 4px; border-radius: 50%; background: #60A5FA; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .att-grid { grid-template-columns: 1fr; }
    .att-stat-strip { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 640px) {
    .att-root { padding: 14px 12px 90px; }
    .att-stat-strip { grid-template-columns: repeat(2,1fr); }
    .ios-nav-item { padding: 7px 10px; min-width: 46px; font-size: 9px; }
}
</style>

{{-- ══ Flash messages ══ --}}
@if(session()->has('success'))
    <div class="att-flash att-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="att-flash att-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ PAGE HERO ══ --}}
@php
    $kigali = \Carbon\Carbon::now('Africa/Kigali');

    // todayMinutes comes from the component (public $todayMinutes).
    // Fallback: recalculate in blade using Carbon::parse (handles full datetimes).
    if (!isset($todayMinutes) || $todayMinutes === 0) {
        $todayMinutes = 0;
        if (!empty($todayAttendance->check_in) && !empty($todayAttendance->check_out)) {
            try {
                $ci = \Carbon\Carbon::parse($todayAttendance->check_in,  'Africa/Kigali');
                $co = \Carbon\Carbon::parse($todayAttendance->check_out, 'Africa/Kigali');
                if ($co->gt($ci)) {
                    $todayMinutes = (int) $ci->diffInMinutes($co);
                }
            } catch (\Exception $e) { $todayMinutes = 0; }
        }
    }

    $todayH   = (int) floor($todayMinutes / 60);
    $todayM   = (int) ($todayMinutes % 60);
    $todayFmt = ($todayH > 0 || $todayM > 0)
        ? $todayH . 'h' . ($todayM > 0 ? ' ' . $todayM . 'm' : '')
        : '—';

    // Counts come from the component (already correct).
    // monthPresentCount counts any record with check_in (status = "Entered" = showed up).
@endphp

<div class="att-hero">
    <div class="att-hero-cover"></div>
    <div class="att-hero-body">
        <div style="display:flex;align-items:flex-end;gap:13px;">
            <div class="att-hero-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            </div>
            <div>
                <div class="att-hero-title">My Attendance</div>
                <div class="att-hero-sub">{{ $kigali->format('l, F j, Y') }}</div>
            </div>
        </div>
        <div class="att-clock-wrap">
            <div class="att-clock-label">Current Time</div>
            {{-- Server-rendered initial value in Kigali time; JS will then tick it live --}}
            <div class="att-clock-time" id="att-live-clock">{{ $kigali->format('H:i:s') }}</div>
            <div class="att-clock-tz">Kigali (UTC+2)</div>
        </div>
    </div>

    {{-- Stat strip --}}
    @php
        $statCiDisplay = '—';
        $statCoDisplay = '—';
        if ($todayAttendance?->check_in) {
            try { $statCiDisplay = \Carbon\Carbon::parse($todayAttendance->check_in, 'Africa/Kigali')->format('H:i'); }
            catch (\Exception $e) { $statCiDisplay = $todayAttendance->check_in; }
        }
        if ($todayAttendance?->check_out) {
            try { $statCoDisplay = \Carbon\Carbon::parse($todayAttendance->check_out, 'Africa/Kigali')->format('H:i'); }
            catch (\Exception $e) { $statCoDisplay = $todayAttendance->check_out; }
        }
    @endphp
    <div class="att-stat-strip">
        <div class="att-stat-cell">
            <div class="att-stat-cell-icon" style="background:var(--blue-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--blue)"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            </div>
            <div class="att-stat-cell-label">Clocked In</div>
            <div class="att-stat-cell-val">{{ $statCiDisplay }}</div>
        </div>
        <div class="att-stat-cell">
            <div class="att-stat-cell-icon" style="background:var(--red-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--red)"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="att-stat-cell-label">Absent (Month)</div>
            <div class="att-stat-cell-val">{{ $monthAbsentCount }}</div>
        </div>
        <div class="att-stat-cell">
            <div class="att-stat-cell-icon" style="background:var(--green-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="att-stat-cell-label">Present (Month)</div>
            <div class="att-stat-cell-val">{{ $monthPresentCount }}</div>
        </div>
        <div class="att-stat-cell">
            <div class="att-stat-cell-icon" style="background:var(--amber-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--amber)"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="att-stat-cell-label">Late (Month)</div>
            <div class="att-stat-cell-val">{{ $monthLateCount }}</div>
        </div>
    </div>
</div>

{{-- ══ MAIN GRID ══ --}}
<div class="att-grid">

    {{-- LEFT: Clock panel + History --}}
    <div style="display:flex;flex-direction:column;gap:18px;">

        {{-- Clock In / Out card --}}
        <div class="att-card">
            <div class="att-card-hd">
                <div class="att-card-hd-left">
                    <div class="att-card-hd-icon"
                         style="background:{{ $isClockedIn ? 'var(--red-lt)' : 'var(--blue-lt)' }};
                                border-color:{{ $isClockedIn ? 'rgba(239,68,68,0.22)' : 'var(--blue-brd)' }};">
                        <svg viewBox="0 0 24 24"
                             style="stroke:{{ $isClockedIn ? 'var(--red)' : 'var(--blue)' }}">
                            @if($isClockedIn)
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                            @else
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                            @endif
                        </svg>
                    </div>
                    <div>
                        <div class="att-card-title">{{ $isClockedIn ? 'Clock Out' : 'Clock In' }}</div>
                        <div class="att-card-sub">
                            {{ $isClockedIn ? 'End your working session' : 'Start your working day' }}
                            &mdash; Kigali time (UTC+2)
                        </div>
                    </div>
                </div>
                <div style="font-family:'Sora',sans-serif;font-size:13px;font-weight:800;
                            color:var(--blue);letter-spacing:-0.3px;" id="att-card-clock">
                    {{ $kigali->format('H:i') }}
                </div>
            </div>

            <div class="att-card-body">
                <div class="att-notes-field">
                    <label>Notes (optional)</label>
                    <textarea wire:model="notes"
                              placeholder="Add any notes about your attendance today…"></textarea>
                </div>

                @if($isClockedIn)
                    <div style="display:grid;grid-template-columns: 1fr 1fr;gap:12px;margin-top:10px;">
                        @if($isOnBreak)
                            <button class="att-btn-clock-in" 
                                    wire:click="endBreak" 
                                    style="background:var(--amber);box-shadow:0 4px 14px rgba(245,158,11,0.3);">
                                <svg viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"/></svg>
                                End Break
                            </button>
                        @else
                            <button class="att-btn-clock-in" 
                                    wire:click="startBreak" 
                                    style="background:var(--ink2);box-shadow:0 4px 14px rgba(45,51,86,0.3);">
                                <svg viewBox="0 0 24 24"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                                Start Break
                            </button>
                        @endif

                        <button class="att-btn-clock-out"
                                onclick="confirmClockAction('out')"
                                wire:loading.attr="disabled">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            <span wire:loading.remove wire:target="clockOut">Clock Out</span>
                            <span wire:loading wire:target="clockOut">...</span>
                        </button>
                    </div>
                @else
                    <button class="att-btn-clock-in"
                            onclick="confirmClockAction('in')"
                            wire:loading.attr="disabled">
                        <svg viewBox="0 0 24 24">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        <span wire:loading.remove wire:target="clockIn">Clock In Now</span>
                        <span wire:loading wire:target="clockIn">Saving…</span>
                    </button>
                @endif

                <div id="gps-status" style="margin-top:12px;font-size:11px;color:var(--ink4);text-align:center;display:none;">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;vertical-align:middle;margin-right:4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span id="gps-text">Detecting location...</span>
                </div>

                @if($isClockedIn && $todayAttendance?->check_in)
                    <div style="margin-top:12px;padding:10px 13px;background:var(--green-lt);
                                border:1px solid rgba(18,183,106,0.22);border-radius:var(--r);
                                font-size:12.5px;font-weight:600;color:#087A42;
                                display:flex;align-items:center;gap:7px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path d="M12 7v5l3 3"/>
                        </svg>
                        Session started at {{ $statCiDisplay }}
                    </div>
                @endif
            </div>
        </div>

        <div class="att-card">
            <div class="att-card-hd">
                <div class="att-card-hd-left">
                    <div class="att-card-hd-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                        </svg>
                    </div>
                    <div>
                        <div class="att-card-title">Attendance History</div>
                        <div class="att-card-sub">{{ isset($attendances) ? $attendances->count() : '0' }} record(s) this month</div>
                    </div>
                </div>
            </div>

            @if(isset($attendances) && $attendances->count() > 0)
                <div class="att-table-wrap">
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Hours</th>
                                <th>Status</th>
                                <th>OT/Late</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $att)
                                @php
                                    $as = $att->daily_status ?? 'Present';
                                    $ac = match(strtolower($as)) {
                                        'present'         => 'badge-green',
                                        'absent'          => 'badge-red',
                                        'late'            => 'badge-amber',
                                        'half-day'        => 'badge-amber',
                                        'requires review' => 'badge-amber',
                                        'rejected'        => 'badge-red',
                                        default           => 'badge-gray',
                                    };

                                    $ciDisplay = $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('H:i') : '—';
                                    $coDisplay = $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('H:i') : '—';
                                    
                                    if ($att->total_worked_minutes > 0) {
                                        $totalHours = $att->total_worked_minutes / 60;
                                        $standardHours = 8; // Standard workday
                                        $overtimeHours = max(0, $totalHours - $standardHours);
                                        
                                        if ($overtimeHours > 0) {
                                            $h = floor($standardHours);
                                            $m = round(($standardHours - $h) * 60);
                                            $otH = floor($overtimeHours);
                                            $otM = round(($overtimeHours - $otH) * 60);
                                            
                                            $standardPart = $h > 0 ? "{$h}h" : "";
                                            $standardPart .= $m > 0 ? " {$m}m" : "";
                                            $overtimePart = $otH > 0 ? "{$otH}h" : "";
                                            $overtimePart .= $otM > 0 ? " {$otM}m" : "";
                                            
                                            $hrsFmt = $standardPart . " + " . $overtimePart . " OT";
                                        } else {
                                            $displayHours = min($totalHours, $standardHours);
                                            $h = floor($displayHours);
                                            $m = round(($displayHours - $h) * 60);
                                            $hrsFmt = $h > 0 ? "{$h}h" : "";
                                            $hrsFmt .= $m > 0 ? " {$m}m" : "";
                                        }
                                    } else {
                                        $hrsFmt = '—';
                                    }
                                @endphp
                                <tr>
                                    <td class="bold">{{ $att->date->format('M d, Y') }}</td>
                                    <td class="muted">{{ $ciDisplay }}</td>
                                    <td class="muted">{{ $coDisplay }}</td>
                                    <td style="font-weight:700;color:var(--blue-2);">{{ $hrsFmt }}</td>
                                    <td>
                                        <span class="att-badge {{ $ac }}">
                                            <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                                            {{ $as }}
                                        </span>
                                    </td>
                                    <td class="muted">
                                        @if($att->late_minutes > 0)
                                            <span style="color:var(--amber);">Late: {{ $this->formatMinutes($att->late_minutes) }}</span>
                                        @endif
                                        @if($att->overtime_minutes > 0)
                                            <span style="color:var(--green); margin-left:5px;">OT: {{ $this->formatMinutes($att->overtime_minutes) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="att-card-body">
                    <div class="att-empty">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                        <div class="att-empty-title">No attendance records yet</div>
                        <div class="att-empty-sub">Clock in to start building your history.</div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <div class="att-card">
        <div class="att-card-hd">
            <div class="att-card-hd-left">
                <div class="att-card-hd-icon"
                     style="background:{{ $isClockedIn ? 'var(--green-lt)' : 'var(--bg)' }};
                            border-color:{{ $isClockedIn ? 'rgba(18,183,106,0.22)' : 'var(--border)' }};">
                    <svg viewBox="0 0 24 24"
                         style="stroke:{{ $isClockedIn ? 'var(--green)' : 'var(--ink4)' }}">
                        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>
                    </svg>
                </div>
                <div>
                    <div class="att-card-title">Today's Status</div>
                    <div class="att-card-sub">Live session info</div>
                </div>
            </div>
        </div>
        <div class="att-card-body">

            <div class="att-status-indicator {{ $isClockedIn ? 'in-status' : 'out-status' }}">
                <div class="att-status-dot {{ $isClockedIn ? ($isOnBreak ? 'dot-out' : 'dot-in') : 'dot-out' }}"></div>
                <div>
                    <div class="att-status-text">
                        @if($isOnBreak)
                            On Break
                        @elseif($isClockedIn)
                            Clocked In
                        @else
                            Not Clocked In
                        @endif
                    </div>
                    <div class="att-status-sub">
                        @if($isOnBreak)
                            Taking a rest session
                        @elseif($isClockedIn)
                            Active at {{ $statCiDisplay }}
                        @else
                            Click "Clock In" to begin
                        @endif
                    </div>
                </div>
            </div>

            @php
                $maxMinutes    = 8 * 60;
                $ringPct       = min(100, round(($todayMinutes / max(1, $maxMinutes)) * 100));
                $circumference = round(2 * 3.14159 * 34);
                $offset        = round($circumference * (1 - $ringPct / 100));
            @endphp
            <div class="att-hours-ring">
                <div class="att-ring-wrap">
                    <svg viewBox="0 0 88 88">
                        <circle class="att-ring-bg" cx="44" cy="44" r="34"/>
                        <circle class="att-ring-fill" cx="44" cy="44" r="34"
                            stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $offset }}"/>
                    </svg>
                    <div class="att-ring-text">
                        <div class="att-ring-num">{{ $todayFmt }}</div>
                        <div class="att-ring-label">of 8h target</div>
                    </div>
                </div>
                <div style="font-size:12px;font-weight:600;color:var(--ink3);">Today's hours</div>
            </div>

            <div class="att-detail-row">
                <span class="att-detail-label">Assigned Shift</span>
                <span class="att-detail-value">{{ $employee->shift->name ?? 'None' }}</span>
            </div>
            
            @if($employee->shift)
            <div class="att-detail-row">
                <span class="att-detail-label">Shift Hours</span>
                <span class="att-detail-value">{{ $employee->shift->start_time->format('H:i') }} - {{ $employee->shift->end_time->format('H:i') }}</span>
            </div>
            @endif

            @if($todayAttendance)
                <div class="att-detail-row">
                    <span class="att-detail-label">Worked (Net)</span>
                    <span class="att-detail-value" style="color:var(--green);">{{ $todayFmt }}</span>
                </div>
                <div class="att-detail-row">
                    <span class="att-detail-label">Breaks</span>
                    <span class="att-detail-value">{{ $todayBreakMinutes }} min</span>
                </div>
                @if($todayAttendance->late_minutes > 0)
                <div class="att-detail-row">
                    <span class="att-detail-label">Lateness</span>
                    <span class="att-detail-value" style="color:var(--amber);">{{ $todayAttendance->late_minutes }} min</span>
                </div>
                @endif
                @if($todayAttendance->overtime_minutes > 0)
                <div class="att-detail-row">
                    <span class="att-detail-label">Overtime</span>
                    <span class="att-detail-value" style="color:var(--green);">{{ $todayAttendance->overtime_minutes }} min</span>
                </div>
                @endif
            @endif

        </div>
    </div>

</div>

<nav class="ios-nav">
    <a href="{{ route('employee.dashboard') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
    </a>
    <a href="{{ route('employee.profile') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>
        Profile
    </a>
    <a href="{{ route('employee.attendance') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="{{ route('employee.communication') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
        Messages
    </a>
</nav>

<script>
function confirmClockAction(type) {
    const statusDiv = document.getElementById('gps-status');
    const statusText = document.getElementById('gps-text');
    
    if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser.");
        return;
    }

    statusDiv.style.display = 'block';
    statusText.innerText = "Capturing secure location...";

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            statusText.innerText = "Location verified. Processing...";
            
            if (type === 'in') {
                @this.clockIn(lat, lng);
            } else {
                @this.clockOut(lat, lng);
            }
        },
        (error) => {
            statusText.innerText = "Location access denied.";
            alert("Error: Location access is required to clock " + type + ".");
            console.error(error);
        },
        { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
    );
}

(function () {
    var TZ_OFFSET_MS = 2 * 60 * 60 * 1000;
    function getKigaliDate() {
        var utc = new Date().getTime() + new Date().getTimezoneOffset() * 60000;
        return new Date(utc + TZ_OFFSET_MS);
    }

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function tick() {
        var d = getKigaliDate();
        var hms = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
        var hm  = pad(d.getHours()) + ':' + pad(d.getMinutes());

        var hero = document.getElementById('att-live-clock');
        var card = document.getElementById('att-card-clock');
        if (hero) hero.textContent = hms;
        if (card) card.textContent = hm;
    }

    tick();
    setInterval(tick, 1000);
})();
</script>

</div>{{-- /att-root --}}