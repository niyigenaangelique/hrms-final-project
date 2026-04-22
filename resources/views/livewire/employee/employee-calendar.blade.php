<div class="ec-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.ec-root {
    --blue:     #3B6FE8;
    --blue-2:   #2755CC;
    --blue-3:   #1A3FA8;
    --blue-lt:  rgba(59,111,232,0.09);
    --blue-mid: rgba(59,111,232,0.18);
    --blue-brd: rgba(59,111,232,0.22);
    --green:    #12B76A;
    --green-lt: rgba(18,183,106,0.10);
    --amber:    #F59E0B;
    --amber-lt: rgba(245,158,11,0.10);
    --red:      #EF4444;
    --red-lt:   rgba(239,68,68,0.09);
    --purple:   #7C3AED;
    --purple-lt:rgba(124,58,237,0.09);
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
    display: flex;
    flex-direction: column;
    gap: 18px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.ec-flash {
    padding: 12px 18px; border-radius: var(--r);
    font-size: 13.5px; font-weight: 600;
    display: flex; align-items: center; gap: 9px;
}
.ec-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.ec-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.ec-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.ec-hero {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ec-hero-cover {
    height: 68px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.ec-hero-cover::before {
    content:''; position:absolute; top:-30px; right:60px;
    width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.06);
}
.ec-hero-body {
    padding: 0 24px 18px;
    display: flex; align-items: flex-end; justify-content: space-between; gap:16px;
    margin-top: 0px;
}
.ec-hero-icon {
    width: 52px; height: 52px; border-radius: 15px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white);
    box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ec-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.ec-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; padding-bottom: 2px; }
.ec-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }

/* Month nav */
.ec-month-nav { display: flex; align-items: center; gap: 8px; padding-bottom: 4px; }
.ec-month-btn {
    width: 32px; height: 32px; border-radius: 9px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s;
}
.ec-month-btn:hover { background: var(--blue-mid); }
.ec-month-btn svg { width: 15px; height: 15px; stroke: var(--blue); fill: none; stroke-width: 2; }
.ec-month-label {
    font-family:'Sora',sans-serif; font-size: 14px; font-weight: 800;
    color: var(--ink); min-width: 130px; text-align: center;
}

/* ══ MAIN LAYOUT ═════════════════════════════════════════ */
.ec-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 18px;
    align-items: start;
}
.ec-left  { display: flex; flex-direction: column; gap: 18px; }
.ec-right { display: flex; flex-direction: column; gap: 18px; }

/* ══ SHARED CARD ═════════════════════════════════════════ */
.ec-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ec-card-hd {
    padding: 15px 20px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.ec-card-hd-left { display: flex; align-items: center; gap: 9px; }
.ec-card-hd-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    display: flex; align-items: center; justify-content: center;
}
.ec-card-hd-icon svg { width: 14px; height: 14px; stroke: var(--blue); fill: none; stroke-width: 2; }
.ec-card-title { font-family:'Sora',sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.ec-card-sub   { font-size: 11.5px; color: var(--ink4); font-weight: 500; }

/* ══ MONTH GRID CALENDAR ═════════════════════════════════ */
.ec-grid-wrap { padding: 18px; }

.ec-dow-row {
    display: grid; grid-template-columns: repeat(7, 1fr);
    margin-bottom: 6px;
}
.ec-dow-cell {
    text-align: center; font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--ink4); padding: 5px 0;
}
.ec-dow-cell.weekend { color: var(--red); opacity: 0.7; }

.ec-days-grid {
    display: grid; grid-template-columns: repeat(7, 1fr);
    gap: 4px;
}

.ec-day-cell {
    border-radius: 10px;
    border: 1px solid transparent;
    min-height: 80px;
    padding: 7px 8px 5px;
    position: relative;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    display: flex; flex-direction: column;
    background: var(--bg);
}
.ec-day-cell:hover {
    background: #EEF3FD;
    border-color: var(--blue-brd);
    box-shadow: 0 2px 8px rgba(59,111,232,0.10);
}
.ec-day-cell.other-month {
    background: transparent; opacity: 0.45;
}
.ec-day-cell.today {
    background: var(--blue-lt);
    border-color: var(--blue);
}
.ec-day-cell.weekend { background: #F8F9FD; }
.ec-day-cell.has-leave {
    background: rgba(18,183,106,0.07);
    border-color: rgba(18,183,106,0.25);
}
.ec-day-cell.has-holiday {
    background: rgba(245,158,11,0.07);
    border-color: rgba(245,158,11,0.25);
}

.ec-day-num {
    font-size: 13px; font-weight: 700;
    color: var(--ink2); line-height: 1;
    margin-bottom: 5px;
    width: 24px; height: 24px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 6px;
}
.ec-day-cell.today .ec-day-num {
    background: var(--blue); color: #fff;
    box-shadow: 0 2px 6px rgba(59,111,232,0.35);
}
.ec-day-cell.other-month .ec-day-num { color: var(--ink4); }

/* Event chips on grid */
.ec-day-events { display: flex; flex-direction: column; gap: 2px; flex: 1; }

.ec-day-chip {
    font-size: 9.5px; font-weight: 700;
    padding: 1.5px 5px; border-radius: 4px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    line-height: 1.5;
}
.ec-day-chip.leave    { background: rgba(18,183,106,0.18); color: #087A42; }
.ec-day-chip.holiday  { background: rgba(245,158,11,0.18); color: #92400E; }
.ec-day-chip.attended { background: var(--blue-lt); color: var(--blue-2); }
.ec-day-chip.absent   { background: var(--red-lt);  color: #991B1B; }

/* Attendance dot */
.ec-att-dot {
    position: absolute; top: 7px; right: 7px;
    width: 7px; height: 7px; border-radius: 50%;
}
.ec-att-dot.present { background: var(--green); }
.ec-att-dot.absent  { background: var(--red); }

/* ══ WEEKLY TIMELINE ═════════════════════════════════════ */
.ec-timeline-wrap { overflow-x: auto; }

.ec-timeline {
    display: grid;
    grid-template-columns: 52px repeat(5, 1fr);
    min-width: 500px;
}

.ec-tl-corner {
    background: var(--bg); border-right: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 10px 8px;
}
.ec-tl-day-hd {
    background: var(--bg);
    padding: 10px 8px; text-align: center;
    font-size: 11px; font-weight: 800; color: var(--ink3);
    text-transform: uppercase; letter-spacing: 0.06em;
    border-bottom: 1px solid var(--border);
    border-left: 1px solid var(--border);
}
.ec-tl-day-hd.today-col { color: var(--blue); background: var(--blue-lt); }

.ec-tl-time {
    border-right: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 6px 8px;
    font-size: 10.5px; font-weight: 600; color: var(--ink4);
    text-align: right; background: var(--white);
}

.ec-tl-cell {
    border-left: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    background: var(--white);
    min-height: 40px; padding: 3px;
    position: relative; cursor: pointer;
    transition: background 0.12s;
}
.ec-tl-cell:hover { background: var(--blue-lt); }

.ec-tl-task {
    background: var(--blue);
    color: #fff; border-radius: 5px;
    font-size: 10px; font-weight: 700;
    padding: 3px 7px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    cursor: pointer; transition: background 0.12s;
    display: flex; align-items: center; justify-content: space-between; gap: 4px;
}
.ec-tl-task:hover { background: var(--blue-2); }
.ec-tl-task-del {
    background: none; border: none; cursor: pointer; padding: 0;
    color: rgba(255,255,255,0.7); font-size: 12px; line-height: 1;
    flex-shrink: 0;
}
.ec-tl-task-del:hover { color: #fff; }

/* ══ RIGHT SIDEBAR ═══════════════════════════════════════ */

/* Mini calendar */
.ec-mini-hd { display: flex; align-items: center; justify-content: space-between; padding: 15px 16px 10px; }
.ec-mini-title { font-family:'Sora',sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.ec-mini-nav { display: flex; gap: 4px; }
.ec-mini-btn {
    width: 26px; height: 26px; border-radius: 7px;
    background: var(--bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.12s;
}
.ec-mini-btn:hover { background: var(--blue-lt); }
.ec-mini-btn svg { width: 13px; height: 13px; stroke: var(--ink3); fill: none; stroke-width: 2; }

.ec-mini-grid-wrap { padding: 0 12px 14px; }
.ec-mini-dow {
    display: grid; grid-template-columns: repeat(7,1fr);
    margin-bottom: 3px;
}
.ec-mini-dow span {
    text-align: center; font-size: 9.5px; font-weight: 800;
    color: var(--ink4); text-transform: uppercase; padding: 3px 0;
}
.ec-mini-days { display: grid; grid-template-columns: repeat(7,1fr); gap: 2px; }

.ec-mini-day {
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 600; color: var(--ink3);
    border-radius: 6px; cursor: pointer; transition: background 0.12s;
    position: relative;
}
.ec-mini-day:hover { background: var(--blue-lt); color: var(--blue); }
.ec-mini-day.today-d { background: var(--blue); color: #fff; }
.ec-mini-day.other   { color: var(--ink4); opacity: 0.45; }
.ec-mini-day.has-ev::after {
    content: ''; position: absolute; bottom: 2px;
    width: 4px; height: 4px; border-radius: 50%; background: var(--amber);
}
.ec-mini-day.today-d::after { background: rgba(255,255,255,0.8); }

/* ── Leave & Holidays sidebar list ─────────────────────── */
.ec-events-list { padding: 6px 14px 14px; display: flex; flex-direction: column; gap: 8px; max-height: 400px; overflow-y: auto; }

.ec-event-item {
    display: flex; gap: 10px; align-items: flex-start;
    padding: 10px 12px; border-radius: 11px;
    border: 1px solid var(--border);
    background: var(--bg);
    transition: border-color 0.15s, box-shadow 0.15s;
}
.ec-event-item:hover { border-color: var(--blue-brd); box-shadow: var(--shadow); }

.ec-event-dot {
    width: 9px; height: 9px; border-radius: 50%;
    flex-shrink: 0; margin-top: 4px;
}
.ec-event-dot.leave-dot    { background: var(--green); }
.ec-event-dot.holiday-dot  { background: var(--amber); }

.ec-event-body { flex: 1; min-width: 0; }
.ec-event-name { font-size: 12.5px; font-weight: 700; color: var(--ink2); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ec-event-date { font-size: 11px; color: var(--ink4); font-weight: 500; }
.ec-event-badge {
    font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 100px;
    flex-shrink: 0; align-self: flex-start;
}
.badge-approved { background: var(--green-lt);  color: #087A42; }
.badge-pending  { background: var(--amber-lt);  color: #92400E; }
.badge-rejected { background: var(--red-lt);    color: #991B1B; }
.badge-holiday  { background: var(--amber-lt);  color: #92400E; }

.ec-events-empty { text-align: center; padding: 28px 16px; color: var(--ink4); font-size: 12.5px; }
.ec-events-empty svg { width: 28px; height: 28px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 8px; display: block; opacity: 0.4; }

/* ══ LEGEND ══════════════════════════════════════════════ */
.ec-legend { padding: 13px 16px; border-top: 1px solid var(--border); display: flex; flex-wrap: wrap; gap: 12px; }
.ec-legend-item { display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600; color: var(--ink3); }
.ec-legend-dot { width: 8px; height: 8px; border-radius: 50%; }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.ec-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 12.5px; font-weight: 700;
    border: none; cursor: pointer; transition: all 0.15s;
}
.ec-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.ec-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 3px 10px rgba(59,111,232,0.28); }
.ec-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.ec-btn-ghost { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.ec-btn-ghost:hover { background: var(--blue-mid); }
.ec-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.ec-btn-outline:hover { border-color: var(--blue); color: var(--blue); }

/* ══ FAB ═════════════════════════════════════════════════ */
.ec-fab {
    position: fixed; bottom: 100px; right: 28px; z-index: 99;
    width: 50px; height: 50px; border-radius: 50%;
    background: var(--blue); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(59,111,232,0.40);
    transition: background 0.15s, transform 0.15s;
}
.ec-fab:hover { background: var(--blue-2); transform: scale(1.08); }
.ec-fab svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.ec-modal-bg {
    position: fixed; inset: 0; background: rgba(15,22,41,0.48);
    backdrop-filter: blur(8px); z-index: 9999;
    display: flex; align-items: center; justify-content: center; padding: 16px;
}
.ec-modal {
    background: var(--white); border-radius: var(--r-lg);
    box-shadow: 0 24px 64px rgba(15,22,41,0.22);
    border: 1px solid var(--border);
    width: 100%; max-width: 460px; overflow: hidden;
}
.ec-modal-hd {
    background: linear-gradient(105deg, var(--blue-3), var(--blue));
    padding: 18px 22px; display: flex; align-items: center; justify-content: space-between;
}
.ec-modal-title { font-family:'Sora',sans-serif; font-size: 15px; font-weight: 800; color: #fff; }
.ec-modal-close {
    width: 28px; height: 28px; border-radius: 8px;
    background: rgba(255,255,255,0.18); border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s;
}
.ec-modal-close:hover { background: rgba(255,255,255,0.28); }
.ec-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }
.ec-modal-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 13px; }
.ec-modal-footer { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 9px; }

.ec-field { display: flex; flex-direction: column; gap: 5px; }
.ec-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); }
.ec-field input, .ec-field select, .ec-field textarea {
    width: 100%; padding: 9px 12px; box-sizing: border-box;
    background: #F6F8FC; border: 1.5px solid var(--border);
    border-radius: var(--r); font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color 0.15s, box-shadow 0.15s;
}
.ec-field input:focus, .ec-field select:focus, .ec-field textarea:focus {
    border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white);
}
.ec-field textarea { resize: vertical; min-height: 70px; }
.ec-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.ec-field-error { font-size: 11.5px; color: var(--red); font-weight: 600; }

/* ══ FLOATING NAV ════════════════════════════════════════ */
.ios-nav {
    position: fixed; bottom: 20px; left: 50%;
    transform: translateX(-50%); z-index: 200;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.82);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.11);
    border-radius: 28px; padding: 7px 10px;
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
@media (max-width: 1080px) {
    .ec-layout { grid-template-columns: 1fr; }
    .ec-right { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
}
@media (max-width: 640px) {
    .ec-root { padding: 14px 12px 90px; }
    .ec-right { grid-template-columns: 1fr; }
    .ec-day-cell { min-height: 56px; }
    .ios-nav-item { padding: 7px 10px; min-width: 46px; font-size: 9px; }
}
</style>

{{-- Flash --}}
@if(session()->has('success'))
    <div class="ec-flash ec-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="ec-flash ec-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ PAGE HERO ══════════════════════════════════════════ --}}
<div class="ec-hero">
    <div class="ec-hero-cover"></div>
    <div class="ec-hero-body">
        <div style="display:flex;align-items:flex-end;gap:12px;">
            <div class="ec-hero-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="ec-hero-title">My Calendar</div>
                <div class="ec-hero-sub">Leave schedule, holidays &amp; weekly tasks</div>
            </div>
        </div>
        <div class="ec-month-nav">
            <button class="ec-month-btn" wire:click="previousMonth">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="ec-month-label">{{ $currentMonth->format('F Y') }}</div>
            <button class="ec-month-btn" wire:click="nextMonth">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- ══ MAIN LAYOUT ════════════════════════════════════════ --}}
<div class="ec-layout">

    {{-- LEFT --}}
    <div class="ec-left">

        {{-- ── Full Month Grid ────────────────────────────── --}}
        <div class="ec-card">
            <div class="ec-card-hd">
                <div class="ec-card-hd-left">
                    <div class="ec-card-hd-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="ec-card-title">{{ $currentMonth->format('F Y') }}</div>
                        <div class="ec-card-sub">Click any day to add a schedule entry</div>
                    </div>
                </div>
            </div>

            <div class="ec-grid-wrap">
                <div class="ec-dow-row">
                    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $i => $d)
                        <div class="ec-dow-cell {{ in_array($i,[0,6]) ? 'weekend' : '' }}">{{ $d }}</div>
                    @endforeach
                </div>

                <div class="ec-days-grid">
                    @foreach($calendarDays as $day)
                        @php
                            $hasLeave   = !empty($day['leaveRequests']);
                            $hasHoliday = !empty($day['holidays']);
                            $cls = 'ec-day-cell';
                            if (!$day['isCurrentMonth']) $cls .= ' other-month';
                            elseif ($day['isToday'])      $cls .= ' today';
                            elseif ($day['isWeekend'])    $cls .= ' weekend';
                            if ($hasLeave && $day['isCurrentMonth'])   $cls .= ' has-leave';
                            if ($hasHoliday && $day['isCurrentMonth']) $cls .= ' has-holiday';
                        @endphp
                        <div class="{{ $cls }}"
                             wire:click="openScheduleModal({{ $day['date'] }})"
                             title="{{ $day['dateObj']->format('l, M d Y') }}">

                            <div class="ec-day-num">{{ $day['date'] }}</div>

                            {{-- Attendance dot --}}
                            @if($day['attendance'] && $day['isCurrentMonth'])
                                <div class="ec-att-dot present" title="Present"></div>
                            @elseif(!$day['isWeekend'] && $day['isCurrentMonth'] && $day['dateObj']->isPast() && !$day['isToday'] && !$hasLeave && !$hasHoliday)
                                <div class="ec-att-dot absent" title="No attendance recorded"></div>
                            @endif

                            <div class="ec-day-events">
                                @foreach($day['holidays'] as $h)
                                    @php $hName = is_string($h->name) ? $h->name : ($h->name ?? 'Holiday'); @endphp
                                    <div class="ec-day-chip holiday" title="{{ $hName }}">{{ Str::limit($hName, 14) }}</div>
                                @endforeach

                                @foreach($day['leaveRequests'] as $lv)
                                    @php
                                        $lvType = $lv->leaveType->name ?? ($lv->type ?? 'Leave');
                                        $lvStatus = $lv->status ? $lv->status->value : 'unknown';
                                    @endphp
                                    <div class="ec-day-chip leave" title="{{ $lvType }} ({{ $lvStatus }})">{{ Str::limit($lvType, 14) }}</div>
                                @endforeach

                                @if($day['attendance'] && $day['isCurrentMonth'])
                                    <div class="ec-day-chip attended">
                                        {{ $day['attendance']->check_in ? \Carbon\Carbon::parse($day['attendance']->check_in)->format('H:i') : 'In' }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Legend --}}
            <div class="ec-legend">
                <div class="ec-legend-item"><div class="ec-legend-dot" style="background:var(--blue)"></div> Today</div>
                <div class="ec-legend-item"><div class="ec-legend-dot" style="background:var(--green)"></div> Leave approved</div>
                <div class="ec-legend-item"><div class="ec-legend-dot" style="background:var(--amber)"></div> Holiday</div>
                <div class="ec-legend-item"><div class="ec-legend-dot" style="background:var(--green);opacity:0.55;"></div> Attended</div>
                <div class="ec-legend-item"><div class="ec-legend-dot" style="background:var(--red);opacity:0.55;"></div> No record</div>
            </div>
        </div>

        {{-- ── Weekly Timeline ─────────────────────────────── --}}
        <div class="ec-card">
            <div class="ec-card-hd">
                <div class="ec-card-hd-left">
                    <div class="ec-card-hd-icon">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="ec-card-title">Weekly Schedule</div>
                        <div class="ec-card-sub">Click a slot to add a task</div>
                    </div>
                </div>
                <button class="ec-btn ec-btn-primary" wire:click="openTaskModal">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Task
                </button>
            </div>

            @php
                $todayDow = now()->dayOfWeek; // 0=Sun,1=Mon...5=Fri,6=Sat
                $days = ['Mon','Tue','Wed','Thu','Fri'];
            @endphp

            <div style="padding:16px;">
                <div class="ec-timeline-wrap">
                    <div class="ec-timeline">
                        {{-- Header row --}}
                        <div class="ec-tl-corner"></div>
                        @foreach($days as $di => $dname)
                            @php $isTodayCol = ($todayDow == $di + 1); @endphp
                            <div class="ec-tl-day-hd {{ $isTodayCol ? 'today-col' : '' }}">
                                {{ $dname }}
                                @if($isTodayCol)
                                    <span style="font-size:9px;background:var(--blue);color:#fff;padding:1px 5px;border-radius:4px;margin-left:4px;">Today</span>
                                @endif
                            </div>
                        @endforeach

                        {{-- Time rows --}}
                        @foreach(range(8,18) as $hour)
                            <div class="ec-tl-time">
                                {{ str_pad($hour,2,'0',STR_PAD_LEFT) }}:00
                            </div>
                            @foreach(range(1,5) as $dayIdx)
                                @php
                                    // Get the calendar day data for this day index
                                    $dayData = $calendarDays[$dayIdx - 1] ?? [];
                                    $hasWorkSchedule = $dayData['hasWorkSchedule'] ?? false;
                                @endphp
                                <div class="ec-tl-cell {{ $hasWorkSchedule ? '' : 'no-schedule' }}" 
                                     @if($hasWorkSchedule) wire:click="addTask({{ $hour }}, {{ $dayIdx }})" @endif>
                                    @if($hasWorkSchedule)
                                        @foreach($tasks->where('hour', $hour)->where('day', $dayIdx) as $task)
                                            <div class="ec-tl-task"
                                                 wire:click.stop="editTask('{{ $task->id }}')"
                                                 title="{{ $task->title }}{{ $task->description ? ': '.$task->description : '' }}">
                                                <span style="overflow:hidden;text-overflow:ellipsis;">{{ $task->title }}</span>
                                                <button class="ec-tl-task-del" wire:click.stop="deleteTask('{{ $task->id }}')" title="Remove">×</button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /ec-left --}}

    {{-- RIGHT --}}
    <div class="ec-right">

        {{-- ── Mini Calendar ──────────────────────────────── --}}
        <div class="ec-card">
            <div class="ec-mini-hd">
                <div class="ec-mini-title">{{ $currentMonth->format('F Y') }}</div>
                <div class="ec-mini-nav">
                    <button class="ec-mini-btn" wire:click="previousMonth">
                        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button class="ec-mini-btn" wire:click="nextMonth">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
            <div class="ec-mini-grid-wrap">
                <div class="ec-mini-dow">
                    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                        <span>{{ $d }}</span>
                    @endforeach
                </div>
                <div class="ec-mini-days">
                    @foreach($miniCalendarDays as $md)
                        @php
                            $mc = 'ec-mini-day';
                            if ($md['isToday'])        $mc .= ' today-d';
                            if (!$md['isCurrentMonth'])$mc .= ' other';
                            if ($md['hasEvents'])      $mc .= ' has-ev';
                        @endphp
                        <div class="{{ $mc }}"
                             wire:click="selectDate('{{ $md['date']->format('Y-m-d') }}')">
                            {{ $md['date']->day }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Holidays ────────────────────────────────────── --}}
        <div class="ec-card">
            <div class="ec-card-hd">
                <div class="ec-card-hd-left">
                    <div class="ec-card-hd-icon" style="background:rgba(245,158,11,0.10);border-color:rgba(245,158,11,0.25);">
                        <svg viewBox="0 0 24 24" style="stroke:var(--amber)"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    </div>
                    <div>
                        <div class="ec-card-title">Holidays</div>
                        <div class="ec-card-sub">{{ $holidays->count() }} this period</div>
                    </div>
                </div>
            </div>
            <div class="ec-events-list">
                @forelse($holidays as $h)
                    @php
                        $hDate = $h->date instanceof \Carbon\Carbon ? $h->date : \Carbon\Carbon::parse($h->date);
                        $hName = $h->name ?? 'Public Holiday';
                    @endphp
                    <div class="ec-event-item">
                        <div class="ec-event-dot holiday-dot"></div>
                        <div class="ec-event-body">
                            <div class="ec-event-name">{{ $hName }}</div>
                            <div class="ec-event-date">
                                {{ $hDate->format('l, M d Y') }}
                                @if($hDate->isToday()) · <span style="color:var(--blue);font-weight:700;">Today</span>
                                @elseif($hDate->isFuture()) · <span style="color:var(--green);font-weight:700;">Upcoming</span>
                                @else · <span style="color:var(--ink4);">Past</span>
                                @endif
                            </div>
                        </div>
                        <span class="ec-event-badge badge-holiday">Holiday</span>
                    </div>
                @empty
                    <div class="ec-events-empty">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/></svg>
                        No holidays in this period
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ── Leave Requests ──────────────────────────────── --}}
        <div class="ec-card">
            <div class="ec-card-hd">
                <div class="ec-card-hd-left">
                    <div class="ec-card-hd-icon" style="background:var(--green-lt);border-color:rgba(18,183,106,0.22);">
                        <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="ec-card-title">Leave Requests</div>
                        <div class="ec-card-sub">
                            {{ $upcomingLeave->count() }} request(s) · recent &amp; upcoming
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-events-list">
                @forelse($upcomingLeave as $lv)
                    @php
                        $lvStatus  = $lv->status ? $lv->status->value : 'unknown';
                        $lvType    = $lv->leaveType->name ?? ($lv->type ?? 'Leave');
                        $lvStart   = $lv->start_date instanceof \Carbon\Carbon ? $lv->start_date : \Carbon\Carbon::parse($lv->start_date);
                        $lvEnd     = $lv->end_date   instanceof \Carbon\Carbon ? $lv->end_date   : \Carbon\Carbon::parse($lv->end_date);
                        $lvDays    = $lvStart->diffInDays($lvEnd) + 1;
                        $isPast    = $lvEnd->isPast();
                        $badgeClass = match($lvStatus) {
                            'approved' => 'badge-approved',
                            'pending'  => 'badge-pending',
                            'rejected' => 'badge-rejected',
                            default    => 'badge-pending',
                        };
                    @endphp
                    <div class="ec-event-item" style="{{ $isPast ? 'opacity:0.65;' : '' }}">
                        <div class="ec-event-dot leave-dot"></div>
                        <div class="ec-event-body">
                            <div class="ec-event-name">{{ $lvType }}</div>
                            <div class="ec-event-date">
                                {{ $lvStart->format('M d') }}
                                @if($lvDays > 1) – {{ $lvEnd->format('M d, Y') }} · {{ $lvDays }} days
                                @else , {{ $lvStart->format('Y') }} · 1 day
                                @endif
                                @if($isPast)
                                    · <span style="color:var(--ink4);">Past</span>
                                @elseif($lvStart->isToday() || ($lvStart->isPast() && $lvEnd->isFuture()))
                                    · <span style="color:var(--blue);font-weight:700;">Active</span>
                                @else
                                    · <span style="color:var(--green);font-weight:700;">Upcoming</span>
                                @endif
                            </div>
                        </div>
                        <span class="ec-event-badge {{ $badgeClass }}">{{ ucfirst($lvStatus) }}</span>
                    </div>
                @empty
                    <div class="ec-events-empty">
                        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                        No leave requests in this window
                    </div>
                @endforelse
            </div>
        </div>

    </div>{{-- /ec-right --}}
</div>{{-- /ec-layout --}}

{{-- ══ FAB ════════════════════════════════════════════════ --}}
<button class="ec-fab" wire:click="openTaskModal" title="Add task">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
</button>

{{-- ══ TASK MODAL ══════════════════════════════════════════ --}}
@if($showTaskModal)
<div class="ec-modal-bg" wire:click="closeTaskModal">
    <div class="ec-modal" wire:click.stop>
        <div class="ec-modal-hd">
            <div class="ec-modal-title">{{ $editingTaskId ? 'Edit Task' : 'Add Task' }}</div>
            <button class="ec-modal-close" wire:click="closeTaskModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="saveTask">
            <div class="ec-modal-body">
                <div class="ec-field">
                    <label>Task Title</label>
                    <input type="text" wire:model="taskTitle" placeholder="e.g. Team standup" required autofocus>
                    @error('taskTitle') <span class="ec-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="ec-field-row">
                    <div class="ec-field">
                        <label>Day</label>
                        <select wire:model="taskDay" required>
                            <option value="">Select day</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                        </select>
                        @error('taskDay') <span class="ec-field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="ec-field">
                        <label>Time</label>
                        <select wire:model="taskHour" required>
                            <option value="">Select time</option>
                            @foreach(range(8,18) as $h)
                                <option value="{{ $h }}">{{ str_pad($h,2,'0',STR_PAD_LEFT) }}:00</option>
                            @endforeach
                        </select>
                        @error('taskHour') <span class="ec-field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="ec-field">
                    <label>Description (optional)</label>
                    <textarea wire:model="taskDescription" placeholder="Add any notes…"></textarea>
                </div>
            </div>
            <div class="ec-modal-footer">
                <button type="button" class="ec-btn ec-btn-outline" wire:click="closeTaskModal">Cancel</button>
                <button type="submit" class="ec-btn ec-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    {{ $editingTaskId ? 'Update Task' : 'Add Task' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ SCHEDULE MODAL ══════════════════════════════════════ --}}
@if($showScheduleModal)
<div class="ec-modal-bg" wire:click="closeScheduleModal">
    <div class="ec-modal" wire:click.stop>
        <div class="ec-modal-hd">
            <div class="ec-modal-title">Add Schedule · {{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('M d, Y') : '' }}</div>
            <button class="ec-modal-close" wire:click="closeScheduleModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="saveWorkSchedule">
            <div class="ec-modal-body">
                <div class="ec-field">
                    <label>Title</label>
                    <input type="text" wire:model="scheduleTitle" placeholder="e.g. Client meeting" required>
                    @error('scheduleTitle') <span class="ec-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="ec-field-row">
                    <div class="ec-field">
                        <label>Start Time</label>
                        <input type="time" wire:model="scheduleStartTime" required>
                        @error('scheduleStartTime') <span class="ec-field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="ec-field">
                        <label>End Time</label>
                        <input type="time" wire:model="scheduleEndTime" required>
                        @error('scheduleEndTime') <span class="ec-field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="ec-field">
                    <label>Description (optional)</label>
                    <textarea wire:model="scheduleDescription" placeholder="Add notes…"></textarea>
                    @error('scheduleDescription') <span class="ec-field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="ec-modal-footer">
                <button type="button" class="ec-btn ec-btn-outline" wire:click="closeScheduleModal">Cancel</button>
                <button type="submit" class="ec-btn ec-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                    Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ FLOATING NAV ════════════════════════════════════════ --}}
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
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item active" style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="{{ route('employee.communication') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Messages
    </a>
</nav>

</div>{{-- /ec-root --}}