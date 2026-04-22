<div class="an-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

.an-root {
    --bg:      #F0F4FA;
    --white:   #FFFFFF;
    --ink:     #0F1629;
    --ink2:    #2D3356;
    --ink3:    #6B7094;
    --ink4:    #B0B5C8;
    --border:  rgba(15,22,41,0.08);
    --border2: rgba(15,22,41,0.12);
    --indigo:    #3B6FE8;
    --indigo-lt: rgba(59,111,232,0.08);
    --violet:    #6B4FDB;
    --violet-lt: rgba(107,79,219,0.08);
    --teal:      #10B981;
    --teal-lt:   rgba(16,185,129,0.08);
    --rose:      #F43F5E;
    --rose-lt:   rgba(244,63,94,0.08);
    --amber:     #F59E0B;
    --amber-lt:  rgba(245,158,11,0.08);
    --green:     #10B981;
    --green-lt:  rgba(16,185,129,0.08);
    --blue:      #3B82F6;
    --blue-lt:   rgba(59,130,246,0.08);
    --purple:    #8B5CF6;
    --purple-lt: rgba(139,92,246,0.08);
    --r:  12px;
    --r2: 18px;
    --sh: 0 4px 14px rgba(26,29,46,0.06);
    --sh2: 0 12px 40px rgba(26,29,46,0.12);
    font-family: 'DM Sans', 'Plus Jakarta Sans', system-ui, sans-serif;
    background: var(--bg);
    color: var(--ink);
    min-height: 100vh;
    padding: 28px 32px 56px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.an-topbar { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
.an-title { font-size: 24px; font-weight: 800; color: var(--ink); letter-spacing: -.04em; }
.an-sub   { font-size: 13px; color: var(--ink3); margin-top: 3px; }

.an-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.an-sel {
    background: var(--white); border: 1px solid var(--border2); border-radius: var(--r);
    padding: 8px 30px 8px 13px; font-size: 13px; font-weight: 600; color: var(--ink2);
    font-family: 'Plus Jakarta Sans', sans-serif; outline: none; cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238884A8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
    box-shadow: var(--sh); transition: border-color .15s;
}
.an-sel:focus { border-color: var(--indigo); }
.an-date-input {
    background: var(--white); border: 1px solid var(--border2); border-radius: var(--r);
    padding: 8px 13px; font-size: 13px; font-weight: 600; color: var(--ink2);
    font-family: 'Plus Jakarta Sans', sans-serif; outline: none; box-shadow: var(--sh);
}
.an-date-input:focus { border-color: var(--indigo); }

.an-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: var(--r);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700; border: none; cursor: pointer;
    transition: all .15s; white-space: nowrap;
}
.an-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.an-btn-primary { background: var(--indigo); color: #fff; box-shadow: 0 4px 14px rgba(59,111,232,0.32); }
.an-btn-primary:hover { background: #3730B0; transform: translateY(-1px); }
.an-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border2); box-shadow: var(--sh); }
.an-btn-outline:hover { border-color: var(--indigo); color: var(--indigo); }
.an-btn-teal  { background: var(--teal-lt); color: #0F766E; border: 1px solid rgba(20,184,166,0.25); }
.an-btn-teal:hover  { background: rgba(20,184,166,0.18); }
.an-btn-sm { padding: 6px 13px; font-size: 12px; }

.an-notify { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; animation: an-slide .22s ease; }
@keyframes an-slide { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }
.an-notify svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.an-notify-close { margin-left: auto; background: none; border: none; cursor: pointer; opacity:.6; transition: opacity .15s; display:flex; align-items:center; }
.an-notify-close:hover { opacity:1; }
.an-notify-ok  { background: var(--green-lt);  border: 1px solid rgba(16,185,129,0.25); color: #065F46; }
.an-notify-err { background: var(--rose-lt);   border: 1px solid rgba(244,63,94,0.25);  color: #9F1239; }

.an-tiles { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; }
.an-tile {
    background: var(--white); border: 1px solid var(--border); border-radius: var(--r2);
    padding: 18px 16px; position: relative; overflow: hidden;
    box-shadow: var(--sh); transition: box-shadow .18s, transform .18s;
}
.an-tile:hover { box-shadow: var(--sh2); transform: translateY(-2px); }
.an-tile::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: var(--r2) var(--r2) 0 0; }
.at-indigo::after { background: var(--indigo); }
.at-teal::after   { background: var(--teal); }
.at-rose::after   { background: var(--rose); }
.at-amber::after  { background: var(--amber); }
.at-green::after  { background: var(--green); }
.at-purple::after { background: var(--purple); }
.an-tile-icon { width: 38px; height: 38px; border-radius: 11px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0; }
.an-tile-icon svg { width: 18px; height: 18px; fill: none; stroke-width: 2; stroke-linecap: round; }
.at-indigo .an-tile-icon { background: var(--indigo-lt); }
.at-indigo .an-tile-icon svg { stroke: var(--indigo); }
.at-teal   .an-tile-icon { background: var(--teal-lt); }
.at-teal   .an-tile-icon svg { stroke: var(--teal); }
.at-rose   .an-tile-icon { background: var(--rose-lt); }
.at-rose   .an-tile-icon svg { stroke: var(--rose); }
.at-amber  .an-tile-icon { background: var(--amber-lt); }
.at-amber  .an-tile-icon svg { stroke: var(--amber); }
.at-green  .an-tile-icon { background: var(--green-lt); }
.at-green  .an-tile-icon svg { stroke: var(--green); }
.at-purple .an-tile-icon { background: var(--purple-lt); }
.at-purple .an-tile-icon svg { stroke: var(--purple); }
.an-tile-lbl { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--ink3); margin-bottom: 4px; }
.an-tile-val { font-size: 26px; font-weight: 800; letter-spacing: -.04em; line-height: 1; }
.an-tile-sub { font-size: 11.5px; color: var(--ink3); margin-top: 5px; }
.an-tile-trend { display: inline-flex; align-items: center; gap: 3px; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 100px; margin-top: 6px; }
.trend-up   { background: var(--green-lt); color: #065F46; }
.trend-down { background: var(--rose-lt);  color: #9F1239; }
.trend-neutral { background: var(--indigo-lt); color: var(--indigo); }
.at-indigo .an-tile-val { color: var(--indigo); }
.at-teal   .an-tile-val { color: var(--teal); }
.at-rose   .an-tile-val { color: var(--rose); }
.at-amber  .an-tile-val { color: var(--amber); }
.at-green  .an-tile-val { color: var(--green); }
.at-purple .an-tile-val { color: var(--purple); }

.an-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--r2); overflow: hidden; box-shadow: var(--sh); }
.an-card-hd { padding: 18px 22px 14px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.an-card-title { font-size: 15px; font-weight: 800; color: var(--ink); }
.an-card-sub   { font-size: 12px; color: var(--ink3); margin-top: 2px; }
.an-card-body  { padding: 22px; }

.an-chart-wrap { position: relative; width: 100%; }
.an-grid2   { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.an-grid3   { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
.an-grid21  { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; }
.an-grid12  { display: grid; grid-template-columns: 1fr 2fr; gap: 18px; }

.sg-table { width: 100%; }
.sg-row    { display: flex; align-items: center; gap: 14px; padding: 11px 0; border-bottom: 1px solid var(--border); }
.sg-row:last-child { border-bottom: none; }
.sg-skill  { font-size: 13px; font-weight: 600; color: var(--ink2); min-width: 160px; }
.sg-bar-wrap { flex: 1; background: var(--bg); border-radius: 100px; height: 8px; overflow: hidden; position: relative; }
.sg-bar-have { height: 100%; border-radius: 100px; background: var(--indigo); transition: width .6s ease; }
.sg-bar-need { position: absolute; top: 0; height: 100%; border-radius: 100px; background: rgba(59,111,232,0.15); }
.sg-nums   { font-size: 12px; font-weight: 700; font-family: 'JetBrains Mono', monospace; white-space: nowrap; }
.sg-gap    { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 100px; min-width: 50px; text-align: center; }
.gap-high  { background: var(--rose-lt);  color: #9F1239; }
.gap-med   { background: var(--amber-lt); color: #78350F; }
.gap-low   { background: var(--green-lt); color: #065F46; }

.div-legend { display: flex; flex-direction: column; gap: 12px; }
.div-leg-row { display: flex; align-items: center; gap: 10px; }
.div-leg-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.div-leg-lbl { font-size: 13px; font-weight: 600; color: var(--ink2); flex: 1; }
.div-leg-pct { font-size: 13px; font-weight: 800; font-family: 'JetBrains Mono', monospace; }

.pred-table { width: 100%; border-collapse: collapse; }
.pred-table th { padding: 9px 14px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink3); text-align: left; border-bottom: 1px solid var(--border); }
.pred-table td { padding: 12px 14px; font-size: 13px; color: var(--ink2); border-bottom: 1px solid var(--border); }
.pred-table tr:last-child td { border-bottom: none; }
.pred-table tr:hover td { background: var(--bg); }
.pred-num { font-family: 'JetBrains Mono', monospace; font-weight: 600; }
.pred-opt { color: var(--green); font-weight: 700; }
.pred-con { color: var(--rose); font-weight: 700; }
.pred-base { color: var(--indigo); font-weight: 700; }

.an-modal-bg { position: fixed; inset: 0; background: rgba(26,23,48,0.52); backdrop-filter: blur(10px); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.an-modal { background: var(--white); border-radius: var(--r2); box-shadow: var(--sh2); border: 1px solid var(--border); width: 100%; max-width: 560px; overflow: hidden; }
.an-modal-hd { background: linear-gradient(115deg, var(--ink) 0%, var(--indigo) 140%); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; }
.an-modal-title { font-size: 16px; font-weight: 800; color: #fff; }
.an-modal-sub   { font-size: 12px; color: rgba(255,255,255,.55); margin-top: 2px; }
.an-modal-close { background: rgba(255,255,255,0.12); border: none; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; }
.an-modal-close:hover { background: rgba(255,255,255,0.22); }
.an-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }
.an-modal-body { padding: 22px 24px; display: flex; flex-direction: column; gap: 16px; }
.an-modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

.an-field { display: flex; flex-direction: column; gap: 5px; }
.an-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .09em; color: var(--ink3); }
.an-field select, .an-field input { width: 100%; padding: 9px 13px; background: var(--bg); border: 1.5px solid var(--border); border-radius: var(--r); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--ink); outline: none; transition: border-color .15s, box-shadow .15s; appearance: none; }
.an-field select:focus, .an-field input:focus { border-color: var(--indigo); box-shadow: 0 0 0 3px rgba(59,111,232,0.10); }
.an-grid2-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

.an-export-row { display: flex; align-items: center; gap: 10px; padding: 16px 22px; border-top: 1px solid var(--border); background: var(--bg); flex-wrap: wrap; }
.an-export-lbl { font-size: 12px; font-weight: 700; color: var(--ink3); text-transform: uppercase; letter-spacing: .08em; }

.an-local-shell { display: grid; grid-template-columns: 240px 1fr; gap: 32px; align-items: flex-start; }
.an-local-sidebar { position: sticky; top: 28px; display: flex; flex-direction: column; gap: 20px; }
.an-local-nav { display: flex; flex-direction: column; gap: 6px; background: var(--white); border: 1px solid var(--border); border-radius: var(--r2); padding: 10px; box-shadow: var(--sh); }
.an-nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--r); font-size: 14px; font-weight: 700; color: var(--ink2); cursor: pointer; border: none; background: transparent; font-family: 'Plus Jakarta Sans', sans-serif; transition: all .2s; text-align: left; width: 100%; }
.an-nav-item svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.2; opacity: 0.6; transition: opacity .2s; }
.an-nav-item:hover { background: var(--indigo-lt); color: var(--indigo); }
.an-nav-item:hover svg { opacity: 1; }
.an-nav-item.active { background: var(--indigo); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.25); }
.an-nav-item.active svg { opacity: 1; }
.an-local-main { display: flex; flex-direction: column; gap: 24px; min-width: 0; }

/* FIX: section visibility — all sections stay in DOM, toggled via CSS */
.an-section { display: none; flex-direction: column; gap: 18px; }
.an-section.an-section-active { display: flex; }

@media (max-width: 1280px) { .an-tiles { grid-template-columns: repeat(3,1fr); } }
@media (max-width: 1024px) { .an-local-shell { grid-template-columns: 1fr; } .an-local-sidebar { position: static; } .an-local-nav { flex-direction: row; overflow-x: auto; white-space: nowrap; } .an-grid2,.an-grid21,.an-grid12 { grid-template-columns: 1fr; } .an-grid3 { grid-template-columns: 1fr 1fr; } }
@media (max-width: 640px)  { .an-tiles { grid-template-columns: 1fr 1fr; } .an-grid3 { grid-template-columns: 1fr; } }
    /* Standardized Hero (Deep Ocean) */
    .la-hero {
        background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 36%, #3B6FE8 68%, #6B4FDB 100%);
        border-radius: 20px;
        padding: 32px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 48px rgba(59,111,232,0.14);
        margin-bottom: 24px;
        color: #fff;
    }
    .la-hero::before { content: ''; position: absolute; top: -50px; right: 240px; width: 250px; height: 250px; border-radius: 50%; background: rgba(255,255,255,0.06); pointer-events: none; }
    .la-hero::after { content: ''; position: absolute; bottom: -40px; left: 60px; width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .la-hero-left { display: flex; align-items: center; gap: 24px; position: relative; z-index: 1; }
    .la-hero-icon { width: 64px; height: 64px; border-radius: 18px; background: rgba(255,255,255,0.18); border: 2px solid rgba(255,255,255,0.30); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .la-hero-icon svg { width: 30px; height: 30px; stroke: #fff; fill: none; stroke-width: 2; }
    .la-hero-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 900; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
    .la-hero-sub { font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500; }
    .la-hero-chips { display: flex; gap: 10px; margin-top: 14px; }
    .la-hero-chip { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.20); border-radius: 100px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.95); }
    .la-hero-right { display: flex; gap: 40px; position: relative; z-index: 1; flex-shrink: 0; }
    .la-hero-stat { text-align: center; }
    .la-hero-sv { font-family: 'Sora', sans-serif; font-size: 36px; font-weight: 900; color: #fff; line-height: 1; }
    .la-hero-sl { font-size: 11px; color: rgba(255,255,255,0.60); font-weight: 700; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.1em; }
</style>

{{-- HERO HEADER --}}
<div class="la-hero">
    <div class="la-hero-left">
        <div class="la-hero-icon">
            <svg viewBox="0 0 24 24"><path d="M21.21 15.89A10 10 0 1 1 8 2.83M22 12A10 10 0 0 0 12 2v10z"/></svg>
        </div>
        <div>
            <div class="la-hero-title">Analytics & Strategic Insights</div>
            <div class="la-hero-sub">Real-time HR metrics and data-driven organization planning · {{ now()->format('M Y') }}</div>
            <div class="la-hero-chips">
                <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>{{ $totalEmployees }} Active Staff</span>
                <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $openPositions }} Open Roles</span>
            </div>
        </div>
    </div>
    <div class="la-hero-right">
        <div class="la-hero-stat"><div class="la-hero-sv">{{ $totalEmployees }}</div><div class="la-hero-sl">Headcount</div></div>
        <div class="la-hero-stat"><div class="la-hero-sv">{{ $turnoverRate }}%</div><div class="la-hero-sl">Turnover</div></div>
        <div class="la-hero-stat"><div class="la-hero-sv">{{ $avgTenure }}y</div><div class="la-hero-sl">Avg Tenure</div></div>
    </div>
</div>

@if($notifyMessage)
<div class="an-notify {{ $notifyType==='error'?'an-notify-err':'an-notify-ok' }}">
    <svg viewBox="0 0 24 24">@if($notifyType==='error')<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>@else<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>@endif</svg>
    {{ $notifyMessage }}
    <button class="an-notify-close" wire:click="clearNotify"><svg viewBox="0 0 24 24" width="13" height="13"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
</div>
@endif

<div class="an-local-shell">

    {{-- Local Sidebar --}}
    <aside class="an-local-sidebar">
        <nav class="an-local-nav">
            @foreach([
                ['overview',   'Overview',   '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>'],
                ['turnover',   'Turnover',   '<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="18" y1="8" x2="23" y2="13"/><line x1="23" y1="8" x2="18" y2="13"/></svg>'],
                ['diversity',  'Diversity',  '<svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>'],
                ['skills',     'Skill Gaps', '<svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>'],
                ['predictive', 'Predictive', '<svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>'],
            ] as [$key,$label,$icon])
            <button class="an-nav-item {{ $activeSection===$key?'active':'' }}"
                    wire:click="setSection('{{ $key }}')"
                    onclick="switchSection('{{ $key }}')">
                {!! $icon !!}
                <span>{{ $label }}</span>
            </button>
            @endforeach
        </nav>

        <div class="an-card" style="padding:16px;background:linear-gradient(135deg,var(--indigo) 0%,var(--violet) 100%);color:#fff;border:none;">
            <div style="font-size:12px;font-weight:700;opacity:0.8;text-transform:uppercase;margin-bottom:8px;">Quick Export</div>
            <div style="font-size:14px;font-weight:500;line-height:1.4;margin-bottom:12px;">Get a complete report of current metrics.</div>
            <button class="an-btn an-btn-sm" style="width:100%;justify-content:center;background:rgba(255,255,255,0.2);color:#fff;border:1px solid rgba(255,255,255,0.3);" wire:click="exportReport('pdf')">
                Download PDF
            </button>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="an-local-main">

        {{-- TOOLBAR --}}
        <div class="an-toolbar">
            <select class="an-sel" wire:model.live="period">
                <option value="3">Last 3 months</option>
                <option value="6">Last 6 months</option>
                <option value="12">Last 12 months</option>
                <option value="24">Last 24 months</option>
            </select>
            <input type="date" class="an-date-input" wire:model.live="dateFrom">
            <input type="date" class="an-date-input" wire:model.live="dateTo">
            <select class="an-sel" wire:model.live="filterDept">
                <option value="">All Departments</option>
                @foreach($departments as $d)<option value="{{ $d }}">{{ $d }}</option>@endforeach
            </select>
            <button class="an-btn an-btn-outline" wire:click="$set('showBuilder',true)">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                Report Builder
            </button>
            <button class="an-btn an-btn-primary" wire:click="exportReport('pdf')">
                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export PDF
            </button>
            <button class="an-btn an-btn-teal" onclick="window.initAnalyticsCharts()" title="Refresh Charts" style="background: #10B981; color: white; font-weight: 600;">
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                Refresh Charts
            </button>
        </div>

        {{-- KPI TILES (always visible) --}}
        <div class="an-tiles">
            <div class="an-tile at-indigo">
                <div class="an-tile-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
                <div class="an-tile-lbl">Total Employees</div>
                <div class="an-tile-val">{{ number_format($totalEmployees) }}</div>
                <div class="an-tile-sub">Active headcount</div>
                <div class="an-tile-trend trend-up">↑ +3 this month</div>
            </div>
            <div class="an-tile at-rose">
                <div class="an-tile-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/></svg></div>
                <div class="an-tile-lbl">Turnover Rate</div>
                <div class="an-tile-val">{{ $turnoverRate }}%</div>
                <div class="an-tile-sub">Year to date</div>
                @if($turnoverRate > 15)
                    <div class="an-tile-trend trend-down">↑ Above 15% threshold</div>
                @else
                    <div class="an-tile-trend trend-up">✓ Within healthy range</div>
                @endif
            </div>
            <div class="an-tile at-teal">
                <div class="an-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div class="an-tile-lbl">Avg Tenure</div>
                <div class="an-tile-val">{{ $avgTenure }}y</div>
                <div class="an-tile-sub">Average years employed</div>
                <div class="an-tile-trend trend-neutral">→ Stable</div>
            </div>
            <div class="an-tile at-amber">
                <div class="an-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                <div class="an-tile-lbl">Open Positions</div>
                <div class="an-tile-val">{{ $openPositions }}</div>
                <div class="an-tile-sub">Vacancies unfilled</div>
                <div class="an-tile-trend trend-down">↑ Needs attention</div>
            </div>
            <div class="an-tile at-green">
                <div class="an-tile-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
                <div class="an-tile-lbl">Avg Salary</div>
                <div class="an-tile-val" style="font-size:18px;">{{ number_format($avgSalary,0) }}</div>
                <div class="an-tile-sub">RWF per month</div>
                <div class="an-tile-trend trend-up">↑ +4.2% vs last year</div>
            </div>
            <div class="an-tile at-purple">
                <div class="an-tile-icon"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <div class="an-tile-lbl">Training Completion</div>
                <div class="an-tile-val">{{ $trainingCompletion }}%</div>
                <div class="an-tile-sub">Employees certified</div>
                <div class="an-tile-trend trend-neutral">→ Target: 80%</div>
            </div>
        </div>

        {{-- ══ SECTION: OVERVIEW — always in DOM, shown/hidden via CSS ══ --}}
        <div class="an-section {{ $activeSection==='overview' ? 'an-section-active' : '' }}" id="an-sec-overview">
            <div class="an-grid21">
                <div class="an-card">
                    <div class="an-card-hd">
                        <div><div class="an-card-title">Hires vs. Separations</div><div class="an-card-sub">Monthly trend over selected period</div></div>
                    </div>
                    <div class="an-card-body">
                        <div class="an-chart-wrap" style="height:240px;">
                            <canvas id="hireExitChart" role="img" aria-label="Bar chart showing monthly hires vs exits"></canvas>
                        </div>
                    </div>
                </div>
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Headcount by Department</div><div class="an-card-sub">Current active employees</div></div></div>
                    <div class="an-card-body">
                        <div class="an-chart-wrap" style="height:240px;">
                            <canvas id="deptChart" role="img" aria-label="Horizontal bar chart of headcount by department"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="an-grid2">
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Gender Distribution</div><div class="an-card-sub">Workforce diversity snapshot</div></div></div>
                    <div class="an-card-body" style="display:flex;align-items:center;gap:32px;">
                        <div style="width:160px;height:160px;flex-shrink:0;">
                            <canvas id="genderChart" role="img" aria-label="Doughnut chart of gender distribution"></canvas>
                        </div>
                        <div class="div-legend" style="flex:1;">
                            @foreach($genderData as $i => $g)
                            @php $cols=['var(--indigo)','var(--teal)','var(--rose)','var(--amber)','var(--green)']; @endphp
                            <div class="div-leg-row">
                                <div class="div-leg-dot" style="background:{{ $cols[$i%count($cols)] }};"></div>
                                <div class="div-leg-lbl">{{ $g['label'] }}</div>
                                <div class="div-leg-pct" style="color:{{ $cols[$i%count($cols)] }};">{{ $g['percent'] }}%</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Age Distribution</div><div class="an-card-sub">Employee age brackets</div></div></div>
                    <div class="an-card-body">
                        <div class="an-chart-wrap" style="height:160px;">
                            <canvas id="ageChart" role="img" aria-label="Bar chart of age distribution"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION: TURNOVER ══ --}}
        <div class="an-section {{ $activeSection==='turnover' ? 'an-section-active' : '' }}" id="an-sec-turnover">
            <div class="an-card">
                <div class="an-card-hd">
                    <div><div class="an-card-title">Turnover Rate Trend</div><div class="an-card-sub">Monthly separation rate as % of total headcount</div></div>
                    <div style="display:flex;gap:8px;">
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:var(--ink3);">
                            <span style="width:12px;height:3px;background:var(--rose);border-radius:2px;display:inline-block;"></span>Turnover %
                        </span>
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:var(--ink3);">
                            <span style="width:12px;height:2px;background:var(--amber);border-radius:2px;display:inline-block;border-top:2px dashed var(--amber);"></span>15% Threshold
                        </span>
                    </div>
                </div>
                <div class="an-card-body">
                    <div class="an-chart-wrap" style="height:300px;">
                        <canvas id="turnoverChart" role="img" aria-label="Line chart of monthly turnover rate"></canvas>
                    </div>
                </div>
                <div class="an-export-row">
                    <span class="an-export-lbl">Export:</span>
                    <button class="an-btn an-btn-outline an-btn-sm" wire:click="exportReport('csv')">CSV</button>
                    <button class="an-btn an-btn-outline an-btn-sm" wire:click="exportReport('xlsx')">Excel</button>
                    <button class="an-btn an-btn-teal an-btn-sm" wire:click="exportReport('pdf')">PDF Report</button>
                </div>
            </div>
            <div class="an-grid2">
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Hires vs. Separations Detail</div><div class="an-card-sub">Monthly comparison</div></div></div>
                    <div class="an-card-body">
                        <div class="an-chart-wrap" style="height:220px;">
                            <canvas id="hireExitChart2" role="img" aria-label="Bar chart of hires vs exits detail"></canvas>
                        </div>
                    </div>
                </div>
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Turnover by Department</div><div class="an-card-sub">Which teams are most affected</div></div></div>
                    <div class="an-card-body">
                        <div class="an-chart-wrap" style="height:220px;">
                            <canvas id="deptTurnoverChart" role="img" aria-label="Bar chart of turnover rate by department"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION: DIVERSITY ══ --}}
        <div class="an-section {{ $activeSection==='diversity' ? 'an-section-active' : '' }}" id="an-sec-diversity">
            <div class="an-grid3">
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Gender Split</div><div class="an-card-sub">Overall workforce</div></div></div>
                    <div class="an-card-body" style="display:flex;flex-direction:column;align-items:center;gap:20px;">
                        <div style="width:180px;height:180px;">
                            <canvas id="genderChart2" role="img" aria-label="Doughnut chart of gender split"></canvas>
                        </div>
                        <div class="div-legend" style="width:100%;">
                            @foreach($genderData as $i => $g)
                            @php $cols=['#4A3FC0','#14B8A6','#F43F5E']; @endphp
                            <div class="div-leg-row">
                                <div class="div-leg-dot" style="background:{{ $cols[$i%3] }};"></div>
                                <div class="div-leg-lbl">{{ $g['label'] }}</div>
                                <div class="div-leg-pct" style="color:{{ $cols[$i%3] }};">{{ $g['percent'] }}% ({{ $g['value'] }})</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Age Brackets</div><div class="an-card-sub">Generational distribution</div></div></div>
                    <div class="an-card-body">
                        <div style="height:220px;">
                            <canvas id="ageChart2" role="img" aria-label="Bar chart of age brackets"></canvas>
                        </div>
                    </div>
                </div>
                <div class="an-card">
                    <div class="an-card-hd"><div><div class="an-card-title">Nationality Distribution</div><div class="an-card-sub">Top 5 nationalities</div></div></div>
                    <div class="an-card-body">
                        <div style="height:220px;">
                            <canvas id="nationalityChart" role="img" aria-label="Doughnut chart of nationality distribution"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION: SKILLS GAP ══ --}}
        <div class="an-section {{ $activeSection==='skills' ? 'an-section-active' : '' }}" id="an-sec-skills">
            <div class="an-grid21">
                <div class="an-card">
                    <div class="an-card-hd">
                        <div><div class="an-card-title">Skill Gap Analysis</div><div class="an-card-sub">Current capability vs. organizational need</div></div>
                        <button class="an-btn an-btn-outline an-btn-sm" wire:click="exportReport('csv')">
                            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Export
                        </button>
                    </div>
                    <div class="an-card-body">
                        <div style="display:flex;gap:16px;margin-bottom:14px;align-items:center;flex-wrap:wrap;">
                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--ink3);"><span style="width:14px;height:8px;background:var(--indigo);border-radius:2px;display:inline-block;"></span>Have</span>
                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--ink3);"><span style="width:14px;height:8px;background:var(--indigo-lt);border-radius:2px;display:inline-block;"></span>Need</span>
                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--rose);"><span style="width:8px;height:8px;border-radius:50%;background:var(--rose);display:inline-block;"></span>High gap ≥8</span>
                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--amber);"><span style="width:8px;height:8px;border-radius:50%;background:var(--amber);display:inline-block;"></span>Med gap 3-7</span>
                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--green);"><span style="width:8px;height:8px;border-radius:50%;background:var(--green);display:inline-block;"></span>Low gap &lt;3</span>
                        </div>
                        <div class="sg-table">
                            @foreach($skillGap as $s)
                            @php
                                $pctHave = min(($s['have'] / max($s['need'],1)) * 100, 100);
                                $gapCls  = $s['gap'] >= 8 ? 'gap-high' : ($s['gap'] >= 3 ? 'gap-med' : 'gap-low');
                            @endphp
                            <div class="sg-row">
                                <div class="sg-skill">{{ $s['skill'] }}</div>
                                <div class="sg-bar-wrap">
                                    <div class="sg-bar-need" style="width:100%;"></div>
                                    <div class="sg-bar-have" style="width:{{ $pctHave }}%;"></div>
                                </div>
                                <div class="sg-nums">
                                    <span style="color:var(--indigo);">{{ $s['have'] }}</span>
                                    <span style="color:var(--ink4);"> / {{ $s['need'] }}</span>
                                </div>
                                <div class="sg-gap {{ $gapCls }}">−{{ $s['gap'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:18px;">
                    <div class="an-card">
                        <div class="an-card-hd"><div><div class="an-card-title">Top Gaps</div><div class="an-card-sub">Critical skills to hire/train</div></div></div>
                        <div class="an-card-body">
                            <div style="height:200px;">
                                <canvas id="skillGapChart" role="img" aria-label="Stacked bar chart of top skill gaps"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="an-card">
                        <div class="an-card-hd"><div><div class="an-card-title">Recommended Actions</div></div></div>
                        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                            @foreach(collect($skillGap)->sortByDesc('gap')->take(4) as $s)
                            @php
                                $color    = $s['gap'] >= 8 ? 'var(--rose)' : ($s['gap'] >= 3 ? 'var(--amber)' : 'var(--green)');
                                $priority = $s['gap'] >= 8 ? 'High Priority' : ($s['gap'] >= 3 ? 'Medium' : 'Low');
                                $action   = $s['gap'] >= 8
                                    ? "Critical gap in {$s['skill']}. Upskill or hire immediately."
                                    : "Address {$s['skill']} gap through training.";
                            @endphp
                            <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 12px;background:var(--bg);border-radius:var(--r);border:1px solid var(--border);">
                                <span style="font-size:11px;font-weight:700;padding:2px 9px;border-radius:100px;background:{{ $color }};color:#fff;white-space:nowrap;margin-top:1px;">{{ $priority }}</span>
                                <span style="font-size:12.5px;color:var(--ink2);line-height:1.5;">{{ $action }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION: PREDICTIVE ══ --}}
        <div class="an-section {{ $activeSection==='predictive' ? 'an-section-active' : '' }}" id="an-sec-predictive">
            <div class="an-grid21">
                <div class="an-card">
                    <div class="an-card-hd">
                        <div><div class="an-card-title">Headcount Forecast — Next 6 Months</div><div class="an-card-sub">Based on historical growth trends · 3 scenarios</div></div>
                    </div>
                    <div class="an-card-body">
                        <div style="height:280px;">
                            <canvas id="predictChart" role="img" aria-label="Line chart of headcount forecast with 3 scenarios"></canvas>
                        </div>
                    </div>
                    <div class="an-export-row">
                        <span class="an-export-lbl">Scenarios:</span>
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:var(--ink3);"><span style="width:14px;height:3px;background:var(--green);display:inline-block;border-radius:2px;"></span>Optimistic</span>
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:var(--ink3);"><span style="width:14px;height:3px;background:var(--indigo);display:inline-block;border-radius:2px;"></span>Base</span>
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:var(--ink3);"><span style="width:14px;height:3px;background:var(--rose);display:inline-block;border-radius:2px;"></span>Conservative</span>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:18px;">
                    <div class="an-card">
                        <div class="an-card-hd"><div><div class="an-card-title">Projection Table</div></div></div>
                        <div style="overflow:auto;">
                            <table class="pred-table">
                                <thead><tr><th>Month</th><th>Optimistic</th><th>Base</th><th>Conservative</th></tr></thead>
                                <tbody>
                                @foreach($predicted as $p)
                                <tr>
                                    <td class="pred-num">{{ $p['label'] }}</td>
                                    <td class="pred-num pred-opt">{{ $p['optimistic'] }}</td>
                                    <td class="pred-num pred-base">{{ $p['projected'] }}</td>
                                    <td class="pred-num pred-con">{{ $p['conservative'] }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="an-card">
                        <div class="an-card-hd"><div><div class="an-card-title">Attrition Risk Score</div><div class="an-card-sub">Real-time risk based on 90-day trends</div></div></div>
                        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                            @foreach($riskScores as $rs)
                            <div>
                                <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                    <span style="font-size:13px;font-weight:600;color:var(--ink2);">{{ $rs['dept'] }}</span>
                                    <span style="font-size:12px;font-weight:800;font-family:'JetBrains Mono',monospace;color:{{ $rs['color'] }};">{{ $rs['risk'] }}/100</span>
                                </div>
                                <div style="background:var(--bg);border-radius:100px;height:6px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $rs['risk'] }}%;background:{{ $rs['color'] }};border-radius:100px;transition:width .6s;"></div>
                                </div>
                            </div>
                            @endforeach
                            <div style="font-size:11.5px;color:var(--ink3);margin-top:4px;">Risk score calculated from historical churn volatility.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

{{-- REPORT BUILDER MODAL --}}
@if($showBuilder)
<div class="an-modal-bg" wire:click.self="$set('showBuilder',false)">
    <div class="an-modal">
        <div class="an-modal-hd">
            <div>
                <div class="an-modal-title">Custom Report Builder</div>
                <div class="an-modal-sub">Configure and generate a tailored analytics report</div>
            </div>
            <button class="an-modal-close" wire:click="$set('showBuilder',false)">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="an-modal-body">
            <div class="an-grid2-fields">
                <div class="an-field">
                    <label>Report Type</label>
                    <select wire:model="reportType">
                        <option value="headcount">Headcount Summary</option>
                        <option value="turnover">Turnover Analysis</option>
                        <option value="payroll">Payroll Distribution</option>
                        <option value="diversity">Diversity Report</option>
                        <option value="skills">Skills Gap Report</option>
                        <option value="leave">Leave Utilization</option>
                        <option value="performance">Performance Overview</option>
                    </select>
                </div>
                <div class="an-field">
                    <label>Group By</label>
                    <select wire:model="reportGroupBy">
                        <option value="department">Department</option>
                        <option value="role">Job Role</option>
                        <option value="gender">Gender</option>
                        <option value="age_bracket">Age Bracket</option>
                        <option value="tenure">Tenure Group</option>
                        <option value="location">Location</option>
                    </select>
                </div>
                <div class="an-field">
                    <label>Date From</label>
                    <input type="date" wire:model="dateFrom">
                </div>
                <div class="an-field">
                    <label>Date To</label>
                    <input type="date" wire:model="dateTo">
                </div>
                <div class="an-field">
                    <label>Output Format</label>
                    <select wire:model="reportFormat">
                        <option value="table">Table</option>
                        <option value="bar_chart">Bar Chart</option>
                        <option value="line_chart">Line Chart</option>
                        <option value="pie_chart">Pie Chart</option>
                    </select>
                </div>
                <div class="an-field">
                    <label>Compare With</label>
                    <select wire:model="compareWith">
                        <option value="prev_period">Previous Period</option>
                        <option value="prev_year">Previous Year</option>
                        <option value="target">Target / Budget</option>
                        <option value="none">No Comparison</option>
                    </select>
                </div>
            </div>
            <div style="background:var(--bg);border-radius:var(--r);padding:14px 16px;border:1px solid var(--border);font-size:13px;color:var(--ink3);line-height:1.6;">
                <strong style="color:var(--ink2);">Preview:</strong>
                {{ ucfirst(str_replace('_',' ',$reportType)) }} grouped by {{ str_replace('_',' ',$reportGroupBy) }} ·
                {{ $reportFormat === 'table' ? 'Table view' : ucwords(str_replace('_',' ',$reportFormat)) }} ·
                Compared to {{ str_replace('_',' ',$compareWith) }}.
            </div>
        </div>
        <div class="an-modal-footer">
            <button class="an-btn an-btn-outline" wire:click="$set('showBuilder',false)">Cancel</button>
            <button class="an-btn an-btn-teal" wire:click="exportReport('csv')">
                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </button>
            <button class="an-btn an-btn-primary" wire:click="generateReport">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                Generate Report
            </button>
        </div>
    </div>
</div>
@endif

<script>
window.__an = {
    hireExit:        {!! json_encode($hireExitTrend) !!},
    turnData:        {!! json_encode($turnoverTrend) !!},
    deptData:        {!! json_encode($deptData) !!},
    genderData:      {!! json_encode($genderData) !!},
    ageData:         {!! json_encode($ageData) !!},
    skillGap:        {!! json_encode($skillGap) !!},
    predicted:       {!! json_encode($predicted) !!},
    nationalityData: {!! json_encode($nationalityData) !!}
};

window.initAnalyticsCharts = function() {
    if (typeof Chart === 'undefined') return;

    Chart.defaults.font.family = "'DM Sans',system-ui,sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#6B7094';
    Chart.defaults.plugins.legend.display = false;

    var C = {
        I:'#3B6FE8', V:'#6B4FDB', T:'#10B981',
        R:'#F43F5E', A:'#F59E0B', G:'#10B981',
        P:'#8B5CF6', B:'#3B82F6'
    };

    function sd(id) { var c = Chart.getChart(id); if (c) c.destroy(); }
    function g(id)  { return document.getElementById(id); }

    function dHE(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.hireExit || {});
        new Chart(el, {
            type: 'bar',
            data: {
                labels: d.map(function(r){ return r.label; }),
                datasets: [
                    { label:'Hires', data: d.map(function(r){ return r.hires; }), backgroundColor:'rgba(59,111,232,0.75)', borderRadius:6, borderSkipped:false },
                    { label:'Exits', data: d.map(function(r){ return r.exits; }), backgroundColor:'rgba(244,63,94,0.65)',  borderRadius:6, borderSkipped:false }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{ display:true, position:'top', labels:{ usePointStyle:true, pointStyle:'circle', padding:16, font:{ weight:'600' } } }, tooltip:{ mode:'index', intersect:false } },
                scales:{ x:{ grid:{ display:false }, ticks:{ maxRotation:0, font:{ size:11 } } }, y:{ grid:{ color:'rgba(59,111,232,0.06)' }, ticks:{ precision:0 }, beginAtZero:true } }
            }
        });
    }

    function dD(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.deptData || {});
        var K = [C.I,C.V,C.T,C.A,C.G,C.R,C.P,C.B];
        new Chart(el, {
            type: 'bar',
            data: {
                labels: d.map(function(r){ return r.label; }),
                datasets:[{ data: d.map(function(r){ return r.value; }), backgroundColor: d.map(function(_,i){ return K[i%K.length]; }), borderRadius:6, borderSkipped:false }]
            },
            options: {
                indexAxis:'y', responsive:true, maintainAspectRatio:false,
                plugins:{ tooltip:{ callbacks:{ label:function(c){ return ' '+c.raw+' employees'; } } } },
                scales:{ x:{ grid:{ color:'rgba(59,111,232,0.06)' }, ticks:{ precision:0 }, beginAtZero:true }, y:{ grid:{ display:false }, ticks:{ font:{ size:11, weight:'600' } } } }
            }
        });
    }

    function dG(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.genderData || {});
        new Chart(el, {
            type: 'doughnut',
            data: { labels: d.map(function(r){ return r.label; }), datasets:[{ data: d.map(function(r){ return r.value; }), backgroundColor:[C.I,C.T,C.R], borderWidth:0, hoverOffset:6 }] },
            options: { responsive:true, maintainAspectRatio:false, cutout:'68%', plugins:{ tooltip:{ callbacks:{ label:function(c){ return ' '+c.label+': '+c.raw+' ('+d[c.dataIndex].percent+'%)'; } } } } }
        });
    }

    function dA(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.ageData || {});
        var t = d.reduce(function(s,r){ return s+r.value; }, 0);
        new Chart(el, {
            type: 'bar',
            data: {
                labels: d.map(function(r){ return r.label; }),
                datasets:[{ data: d.map(function(r){ return r.value; }), backgroundColor:['rgba(59,111,232,0.50)','rgba(59,111,232,0.65)','rgba(59,111,232,0.85)','rgba(59,111,232,0.65)','rgba(59,111,232,0.45)'], borderRadius:6, borderSkipped:false }]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins:{ tooltip:{ callbacks:{ label:function(c){ return ' '+c.raw+' ('+Math.round(c.raw/t*100)+'%)'; } } } },
                scales:{ x:{ grid:{ display:false } }, y:{ grid:{ color:'rgba(59,111,232,0.06)' }, ticks:{ precision:0 }, beginAtZero:true } }
            }
        });
    }

    function dT(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.turnData || {});
        new Chart(el, {
            type: 'line',
            data: {
                labels: d.map(function(r){ return r.label; }),
                datasets: [
                    { label:'Turnover %', data: d.map(function(r){ return r.rate; }), borderColor:C.R, backgroundColor:'rgba(244,63,94,0.10)', tension:0.4, fill:true, pointRadius:4, pointBackgroundColor:C.R, borderWidth:2.5 },
                    { label:'15% Threshold', data: d.map(function(){ return 15; }), borderColor:C.A, borderDash:[6,4], borderWidth:2, pointRadius:0, fill:false }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{ display:true, position:'top', labels:{ usePointStyle:true, pointStyle:'circle', padding:16 } }, tooltip:{ mode:'index', intersect:false, callbacks:{ label:function(c){ return ' '+c.dataset.label+': '+c.raw+'%'; } } } },
                scales:{ x:{ grid:{ display:false } }, y:{ grid:{ color:'rgba(15,22,41,0.06)' }, ticks:{ callback:function(v){ return v+'%'; } }, beginAtZero:true } }
            }
        });
    }

    function dDT(id) {
        var el = g(id); if (!el) return; sd(id);
        var rawDept = Object.values(window.__an.deptData || {});
        var dp = rawDept.slice(0, 6);
        var rates = [18.2,14.5,9.8,12.1,7.4,11.6];
        var cols = dp.map(function(_,i){ return i===0 ? C.R : (rates[i]>12 ? C.A : C.G); });
        new Chart(el, {
            type: 'bar',
            data: { labels: dp.map(function(r){ return r.label; }), datasets:[{ data: rates.slice(0,dp.length), backgroundColor:cols, borderRadius:6, borderSkipped:false }] },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins:{ tooltip:{ callbacks:{ label:function(c){ return ' '+c.raw+'% turnover'; } } } },
                scales:{ x:{ grid:{ display:false } }, y:{ grid:{ color:'rgba(15,22,41,0.06)' }, ticks:{ callback:function(v){ return v+'%'; } }, beginAtZero:true } }
            }
        });
    }

    function dN(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.nationalityData || {});
        new Chart(el, {
            type: 'doughnut',
            data: { labels: d.map(function(r){ return r.label; }), datasets:[{ data: d.map(function(r){ return r.value; }), backgroundColor:[C.I,C.T,C.R,C.A,C.G,C.P], borderWidth:0, cutout:'65%' }] },
            options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:true, position:'bottom', labels:{ usePointStyle:true, boxWidth:8, padding:12 } } } }
        });
    }

    function dSG(id) {
        var el = g(id); if (!el) return; sd(id);
        var rawSkill = Object.values(window.__an.skillGap || {});
        var d = rawSkill.slice(0, 5);
        new Chart(el, {
            type: 'bar',
            data: {
                labels: d.map(function(s){ return s.skill; }),
                datasets: [
                    { label:'Have', data: d.map(function(s){ return s.have; }), backgroundColor:'rgba(59,111,232,0.75)', borderRadius:5 },
                    { label:'Gap',  data: d.map(function(s){ return s.gap; }),  backgroundColor: d.map(function(s){ return s.gap>=8?'rgba(244,63,94,0.7)':(s.gap>=3?'rgba(245,158,11,0.7)':'rgba(16,185,129,0.7)'); }), borderRadius:5 }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{ display:true, position:'top', labels:{ usePointStyle:true, pointStyle:'circle' } } },
                scales:{ x:{ stacked:true, grid:{ color:'rgba(59,111,232,0.06)' }, ticks:{ precision:0 } }, y:{ stacked:true, grid:{ display:false }, ticks:{ font:{ size:11 } } } }
            }
        });
    }

    function dP(id) {
        var el = g(id); if (!el) return; sd(id);
        var d = Object.values(window.__an.predicted || {});
        var labels = d.map(function(r){ return r.label || r.month || ''; });
        new Chart(el, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label:'Base',         data: d.map(function(r){ return r.projected;    }), borderColor:C.I, backgroundColor:'rgba(59,111,232,0.06)', tension:0.4, fill:true,  pointRadius:4, borderWidth:2.5 },
                    { label:'Optimistic',   data: d.map(function(r){ return r.optimistic;   }), borderColor:C.G, borderDash:[5,3], pointRadius:3, fill:false, tension:0.4, borderWidth:2 },
                    { label:'Conservative', data: d.map(function(r){ return r.conservative; }), borderColor:C.R, borderDash:[5,3], pointRadius:3, fill:false, tension:0.4, borderWidth:2 }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{ display:true, position:'top', labels:{ usePointStyle:true, pointStyle:'circle', padding:16 } }, tooltip:{ mode:'index', intersect:false } },
                scales:{ x:{ grid:{ display:false } }, y:{ grid:{ color:'rgba(59,111,232,0.06)' }, ticks:{ precision:0 } } }
            }
        });
    }

    dHE('hireExitChart'); dHE('hireExitChart2');
    dD('deptChart');
    dG('genderChart');    dG('genderChart2');
    dA('ageChart');       dA('ageChart2');
    dT('turnoverChart');
    dDT('deptTurnoverChart');
    dSG('skillGapChart');
    dN('nationalityChart');
    dP('predictChart');
};

window.switchSection = function(key) {
    document.querySelectorAll('.an-section').forEach(function(el) {
        el.classList.remove('an-section-active');
    });
    var target = document.getElementById('an-sec-' + key);
    if (target) {
        target.classList.add('an-section-active');
        requestAnimationFrame(function() { window.initAnalyticsCharts(); });
    }
    document.querySelectorAll('.an-nav-item').forEach(function(btn) {
        btn.classList.remove('active');
        if (btn.getAttribute('onclick') && btn.getAttribute('onclick').indexOf("'"+key+"'") !== -1) {
            btn.classList.add('active');
        }
    });
};

window.__an_doInit = function() {
    console.log('Analytics init attempt...');
    
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') { 
        console.log('Chart.js not loaded, retrying...');
        setTimeout(window.__an_doInit, 200); 
        return; 
    }
    
    // Check if charts container exists
    if (!document.getElementById('hireExitChart')) {
        console.log('Chart container not found, retrying...');
        setTimeout(window.__an_doInit, 200);
        return;
    }
    
    console.log('Chart.js loaded, container found, initializing...');
    
    // Force destroy any existing charts first
    try {
        var chartIds = ['hireExitChart', 'hireExitChart2', 'deptChart', 'genderChart', 'genderChart2', 'ageChart', 'ageChart2', 'turnoverChart', 'deptTurnoverChart', 'skillGapChart', 'nationalityChart', 'predictChart'];
        chartIds.forEach(function(id) {
            var existingChart = Chart.getChart(id);
            if (existingChart) {
                existingChart.destroy();
            }
        });
    } catch (e) {
        console.log('Error destroying existing charts:', e);
    }
    
    // Multiple initialization attempts with different delays
    var attempts = [
        { delay: 0, label: 'immediate' },
        { delay: 100, label: '100ms' },
        { delay: 300, label: '300ms' },
        { delay: 500, label: '500ms' },
        { delay: 1000, label: '1s' }
    ];
    
    attempts.forEach(function(attempt, index) {
        setTimeout(function() {
            requestAnimationFrame(function() {
                try {
                    console.log('Initializing analytics charts - attempt ' + (index + 1) + ' (' + attempt.label + ')');
                    window.initAnalyticsCharts();
                    console.log('Charts initialized successfully on attempt ' + (index + 1));
                    // Stop further attempts once successful
                    window.__an_initSuccess = true;
                } catch (e) {
                    console.error('Chart initialization failed on attempt ' + (index + 1) + ':', e);
                    if (index === attempts.length - 1) {
                        console.log('All initialization attempts failed, will retry on page interaction');
                        // Set up retry on user interaction
                        setupUserInteractionRetry();
                    }
                }
            });
        }, attempt.delay);
    });
};

// Setup retry on user interaction as fallback
function setupUserInteractionRetry() {
    var events = ['click', 'scroll', 'mousemove', 'keydown'];
    var retrySetup = false;
    
    events.forEach(function(eventType) {
        document.addEventListener(eventType, function() {
            if (!retrySetup && !window.__an_initSuccess) {
                retrySetup = true;
                setTimeout(function() {
                    if (!window.__an_initSuccess && document.getElementById('hireExitChart')) {
                        console.log('Retrying chart initialization due to user interaction');
                        window.__an_doInit();
                    }
                }, 100);
            }
        }, { once: true });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.__an_doInit);
} else {
    window.__an_doInit();
}

if (!window.__an_nav_listener) {
    document.addEventListener('livewire:navigated', function() {
        // Wait for Livewire navigation to complete
        setTimeout(function() {
            if (document.getElementById('hireExitChart')) {
                window.__an_doInit();
            }
        }, 300);
    });
    
    document.addEventListener('livewire:updated', function() {
        // Wait for Livewire updates to complete
        setTimeout(function() {
            if (document.getElementById('hireExitChart')) {
                window.__an_doInit();
            }
        }, 200);
    });
    
    // Listen for analytics data updates from Livewire
    document.addEventListener('analytics-updated', function(e) {
        // Update the global data with new values
        if (e.detail) {
            Object.assign(window.__an, e.detail);
        }
        // Reinitialize charts with new data
        setTimeout(function() {
            if (document.getElementById('hireExitChart')) {
                window.initAnalyticsCharts();
            }
        }, 100);
    });
    
    // Also listen via Livewire's event system
    if (window.Livewire) {
        window.Livewire.on('analytics-updated', function(data) {
            // Update the global data with new values
            if (data) {
                Object.assign(window.__an, data);
            }
            // Reinitialize charts with new data
            setTimeout(function() {
                if (document.getElementById('hireExitChart')) {
                    window.initAnalyticsCharts();
                }
            }, 100);
        });
    }
    
    window.__an_nav_listener = true;
}
</script>

{{-- Direct initialization fallback --}}
<script>
// Force initialization after everything is loaded
setTimeout(function() {
    if (typeof Chart !== 'undefined' && document.getElementById('hireExitChart')) {
        console.log('Direct fallback initialization...');
        try {
            // Initialize charts directly
            window.initAnalyticsCharts();
            console.log('Direct initialization successful');
        } catch (e) {
            console.error('Direct initialization failed:', e);
        }
    }
}, 2000);

// Also try on window load
window.addEventListener('load', function() {
    setTimeout(function() {
        if (typeof Chart !== 'undefined' && document.getElementById('hireExitChart')) {
            console.log('Window load initialization...');
            try {
                window.initAnalyticsCharts();
                console.log('Window load initialization successful');
            } catch (e) {
                console.error('Window load initialization failed:', e);
            }
        }
    }, 500);
});
</script>

</div>