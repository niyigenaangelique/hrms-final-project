<div class="dm-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.dm-root {
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
    --shadow-md:0 8px 32px rgba(59,111,232,0.13);
    --r:        12px;
    --r-lg:     18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    padding: 24px 24px 40px;
    display: flex; flex-direction: column; gap: 18px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.dm-flash { padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 9px; }
.dm-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.dm-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.dm-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.dm-hero { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.dm-hero-cover {
    height: 68px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.dm-hero-cover::before { content:''; position:absolute; top:-30px; right:60px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,0.06); }
.dm-hero-body {
    padding: 0 24px 0;
    display: flex; align-items: flex-end; justify-content: space-between; gap:16px;
    margin-top: -2px;
}
.dm-hero-icon {
    width: 52px; height: 52px; border-radius: 15px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dm-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.dm-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.dm-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }

/* Stat strip */
.dm-stat-strip { display: grid; grid-template-columns: repeat(3,1fr); gap:1px; background:var(--border); border-radius:0 0 var(--r-lg) var(--r-lg); overflow:hidden; margin-top:18px; }
.dm-stat-cell { background:var(--white); padding:13px 18px; display:flex; flex-direction:column; gap:2px; }
.dm-stat-cell-icon { width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; margin-bottom:4px; }
.dm-stat-cell-icon svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:2; }
.dm-stat-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--ink4); }
.dm-stat-val   { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink2); }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.dm-toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--shadow); padding:14px 18px; }
.dm-search-box { display:flex; align-items:center; gap:8px; background:var(--bg); border:1.5px solid var(--border); border-radius:10px; padding:8px 13px; flex:1; min-width:200px; transition:border-color 0.15s,box-shadow 0.15s; }
.dm-search-box:focus-within { border-color:var(--blue); box-shadow:0 0 0 3px rgba(59,111,232,0.09); }
.dm-search-box svg { width:14px; height:14px; stroke:var(--ink4); fill:none; flex-shrink:0; }
.dm-search-box input { border:none; background:transparent; font-size:13.5px; color:var(--ink); outline:none; width:100%; font-family:'DM Sans',sans-serif; }
.dm-search-box input::placeholder { color:var(--ink4); }
.dm-per-page { background:var(--bg); border:1.5px solid var(--border); border-radius:10px; padding:8px 32px 8px 12px; font-size:13px; font-weight:600; color:var(--ink2); outline:none; cursor:pointer; font-family:'DM Sans',sans-serif; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; -webkit-appearance:none; }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.dm-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 17px; border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:700; border:none; cursor:pointer; transition:all 0.15s; white-space:nowrap; }
.dm-btn svg { width:14px; height:14px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }
.dm-btn-primary { background:var(--blue); color:#fff; box-shadow:0 4px 12px rgba(59,111,232,0.28); }
.dm-btn-primary:hover { background:var(--blue-2); transform:translateY(-1px); }
.dm-btn-outline { background:var(--white); color:var(--ink2); border:1px solid var(--border); }
.dm-btn-outline:hover { border-color:var(--blue); color:var(--blue); }
.dm-btn-ghost  { background:var(--blue-lt); color:var(--blue); border:1px solid var(--blue-brd); }
.dm-btn-ghost:hover { background:var(--blue-mid); }
.dm-btn-danger { background:var(--red-lt); color:var(--red); border:1px solid rgba(239,68,68,0.22); }
.dm-btn-danger:hover { background:rgba(239,68,68,0.15); }
.dm-btn-sm { padding:5px 11px; font-size:12px; }

/* ══ DEPARTMENT CARDS ════════════════════════════════════ */
.dm-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px; }

.dm-card {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-lg); box-shadow:var(--shadow); overflow:hidden;
    display:flex; flex-direction:column;
    transition:box-shadow 0.18s, border-color 0.18s, transform 0.15s;
}
.dm-card:hover { box-shadow:var(--shadow-md); border-color:var(--blue-brd); transform:translateY(-2px); }

/* Top accent bar with unique color per card */
.dm-card-bar { height: 4px; }

.dm-card-hd { padding:18px 18px 12px; display:flex; align-items:flex-start; gap:13px; }
.dm-card-icon {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family:'Sora',sans-serif; font-size: 15px; font-weight: 800; color: #fff;
}
.dm-card-name  { font-family:'Sora',sans-serif; font-size: 15px; font-weight: 800; color: var(--ink); margin-bottom: 3px; line-height: 1.2; }
.dm-card-code  { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; color: var(--ink4); background: var(--bg); border: 1px solid var(--border); padding: 2px 8px; border-radius: 6px; }

.dm-card-desc { padding: 0 18px 14px; font-size: 13px; color: var(--ink3); font-weight: 500; line-height: 1.6; flex: 1; }

/* Manager row */
.dm-card-manager {
    margin: 0 18px 14px;
    display: flex; align-items: center; gap: 9px;
    padding: 9px 12px; border-radius: 10px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
}
.dm-card-manager-av {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), #6B4FDB);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.dm-card-manager-name { font-size: 12.5px; font-weight: 700; color: var(--blue-2); }
.dm-card-manager-role { font-size: 10.5px; color: var(--ink4); font-weight: 500; }

/* Stats row */
.dm-card-stats { display: flex; gap: 1px; background: var(--border); border-top: 1px solid var(--border); }
.dm-card-stat  { flex: 1; background: #FAFBFF; padding: 10px 12px; display: flex; flex-direction: column; gap: 1px; }
.dm-card-stat-label { font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.dm-card-stat-val   { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: var(--ink2); }

/* Card footer */
.dm-card-footer { padding: 11px 18px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 6px; }

/* ══ BADGES ══════════════════════════════════════════════ */
.dm-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:100px; font-size:11px; font-weight:700; }
.dm-badge svg { width:7px; height:7px; fill:currentColor; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.dm-empty { text-align:center; padding:64px 24px; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); }
.dm-empty svg { width:40px; height:40px; stroke:var(--ink4); fill:none; stroke-width:1.5; margin:0 auto 14px; display:block; opacity:0.4; }
.dm-empty-title { font-size:16px; font-weight:700; color:var(--ink3); margin-bottom:5px; }
.dm-empty-sub   { font-size:13px; color:var(--ink4); font-weight:500; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.dm-pagination { display:flex; align-items:center; justify-content:space-between; padding:14px 18px; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); }
.dm-page-info  { font-size:12.5px; color:var(--ink4); font-weight:500; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.dm-modal-bg { position:fixed; inset:0; background:rgba(15,22,41,0.50); backdrop-filter:blur(8px); z-index:9999; display:flex; align-items:center; justify-content:center; padding:16px; }
.dm-modal { background:var(--white); border-radius:var(--r-lg); box-shadow:0 24px 64px rgba(15,22,41,0.22); border:1px solid var(--border); width:100%; max-width:560px; max-height:92vh; display:flex; flex-direction:column; overflow:hidden; }
.dm-modal-sm  { max-width:460px; }
.dm-modal-hd { background:linear-gradient(105deg,var(--blue-3),var(--blue)); padding:18px 22px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.dm-modal-title { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:#fff; display:flex; align-items:center; gap:9px; }
.dm-modal-title svg { width:18px; height:18px; stroke:rgba(255,255,255,0.8); fill:none; stroke-width:2; }
.dm-modal-close { width:30px; height:30px; border-radius:8px; background:rgba(255,255,255,0.18); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background 0.15s; }
.dm-modal-close:hover { background:rgba(255,255,255,0.28); }
.dm-modal-close svg { width:13px; height:13px; stroke:#fff; fill:none; stroke-width:2.5; }
.dm-modal-body  { flex:1; overflow-y:auto; padding:22px; display:flex; flex-direction:column; gap:14px; }
.dm-modal-footer { padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; flex-shrink:0; }

/* Section label */
.dm-section-lbl { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.09em; color:var(--ink4); margin-bottom:12px; display:flex; align-items:center; gap:6px; }
.dm-section-lbl::after { content:''; flex:1; height:1px; background:var(--border); }
.dm-section-lbl svg { width:12px; height:12px; stroke:var(--blue); fill:none; stroke-width:2; }

/* Fields */
.dm-field { display:flex; flex-direction:column; gap:5px; }
.dm-field label { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); }
.dm-field label .req { color:var(--red); margin-left:2px; }
.dm-field input, .dm-field select, .dm-field textarea {
    width:100%; padding:10px 13px; box-sizing:border-box;
    background:#F6F8FC; border:1.5px solid var(--border);
    border-radius:var(--r); font-family:'DM Sans',sans-serif;
    font-size:13.5px; font-weight:500; color:var(--ink);
    outline:none; transition:border-color 0.15s, box-shadow 0.15s, background 0.15s;
    -webkit-appearance:none;
}
.dm-field input:focus, .dm-field select:focus, .dm-field textarea:focus {
    border-color:var(--blue); box-shadow:0 0 0 3px rgba(59,111,232,0.09); background:var(--white);
}
.dm-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 11px center; padding-right:32px; cursor:pointer; }
.dm-field textarea { resize:vertical; min-height:90px; }
.dm-field-error { font-size:11.5px; color:var(--red); font-weight:600; }
.dm-form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

/* View modal */
.dm-view-hero { padding:22px 22px 16px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:16px; }
.dm-view-av { width:60px; height:60px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:18px; font-weight:800; color:#fff; flex-shrink:0; }
.dm-view-name { font-family:'Sora',sans-serif; font-size:17px; font-weight:800; color:var(--ink); margin-bottom:4px; }
.dm-view-code-badge { display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:var(--blue-2); background:var(--blue-lt); border:1px solid var(--blue-brd); padding:3px 10px; border-radius:7px; }
.dm-view-rows { padding:16px 22px; display:flex; flex-direction:column; gap:0; }
.dm-view-row { display:flex; justify-content:space-between; align-items:flex-start; padding:11px 0; border-bottom:1px solid var(--border); gap:12px; }
.dm-view-row:last-child { border-bottom:none; }
.dm-view-label { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); flex-shrink:0; }
.dm-view-value { font-size:13.5px; font-weight:600; color:var(--ink2); text-align:right; }

/* Delete modal */
.dm-delete-icon { width:56px; height:56px; border-radius:16px; background:var(--red-lt); border:1px solid rgba(239,68,68,0.22); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.dm-delete-icon svg { width:26px; height:26px; stroke:var(--red); fill:none; stroke-width:1.75; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 768px) {
    .dm-root { padding:14px 12px 32px; }
    .dm-grid { grid-template-columns:1fr; }
    .dm-form-row { grid-template-columns:1fr; }
    .dm-stat-strip { grid-template-columns:1fr 1fr; }
}
</style>

{{-- Flash --}}
@if(session()->has('success'))
    <div class="dm-flash dm-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="dm-flash dm-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ PAGE HERO ══════════════════════════════════════════ --}}
<div class="dm-hero">
    <div class="dm-hero-cover"></div>
    <div class="dm-hero-body">
        <div style="display:flex;align-items:flex-end;gap:13px;">
            <div class="dm-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div>
                <div class="dm-hero-title">Departments</div>
                <div class="dm-hero-sub">Organise your workforce into departments with assigned managers</div>
            </div>
        </div>
        <button class="dm-btn dm-btn-primary" wire:click="openCreate" style="margin-bottom:0px;">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Department
        </button>
    </div>
    <div class="dm-stat-strip">
        <div class="dm-stat-cell">
            <div class="dm-stat-cell-icon" style="background:var(--blue-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--blue)"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            </div>
            <div class="dm-stat-label">Total Departments</div>
            <div class="dm-stat-val">{{ $totalCount }}</div>
        </div>
        <div class="dm-stat-cell">
            <div class="dm-stat-cell-icon" style="background:var(--green-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="dm-stat-label">With Manager</div>
            <div class="dm-stat-val" style="color:var(--green);">{{ $withManagerCount }}</div>
        </div>
        <div class="dm-stat-cell">
            <div class="dm-stat-cell-icon" style="background:var(--purple-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--purple)"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div class="dm-stat-label">Total Employees</div>
            <div class="dm-stat-val" style="color:var(--purple);">{{ $totalEmployees }}</div>
        </div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="dm-toolbar">
    <div class="dm-search-box">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search departments by name or code…">
    </div>
    <select class="dm-per-page" wire:model.live="perPage">
        <option value="15">15 per page</option>
        <option value="25">25 per page</option>
        <option value="50">50 per page</option>
    </select>
</div>

{{-- ══ DEPARTMENT CARDS ════════════════════════════════════ --}}
@php
    $cardColors = [
        ['bar'=>'#3B6FE8','icon'=>'linear-gradient(135deg,#3B6FE8,#5A8BF5)'],
        ['bar'=>'#12B76A','icon'=>'linear-gradient(135deg,#12B76A,#34D399)'],
        ['bar'=>'#7C3AED','icon'=>'linear-gradient(135deg,#7C3AED,#A78BFA)'],
        ['bar'=>'#F59E0B','icon'=>'linear-gradient(135deg,#D97706,#F59E0B)'],
        ['bar'=>'#EF4444','icon'=>'linear-gradient(135deg,#DC2626,#EF4444)'],
        ['bar'=>'#0891B2','icon'=>'linear-gradient(135deg,#0E7490,#0891B2)'],
        ['bar'=>'#BE185D','icon'=>'linear-gradient(135deg,#9D174D,#EC4899)'],
        ['bar'=>'#065F46','icon'=>'linear-gradient(135deg,#065F46,#059669)'],
    ];
@endphp

@if($departments->count() > 0)
    <div class="dm-grid">
        @foreach($departments as $i => $dept)
            @php
                $color   = $cardColors[$i % count($cardColors)];
                $initial = strtoupper(substr($dept->name, 0, 1));
                $empCount = $dept->employees_count ?? 0;
                $mgr      = $dept->manager;
                $mgrInit  = $mgr ? strtoupper(substr($mgr->first_name,0,1).substr($mgr->last_name,0,1)) : null;
            @endphp
            <div class="dm-card">
                <div class="dm-card-bar" style="background:{{ $color['bar'] }};"></div>

                <div class="dm-card-hd">
                    <div class="dm-card-icon" style="background:{{ $color['icon'] }};">
                        {{ $initial }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="dm-card-name">{{ $dept->name }}</div>
                        <div class="dm-card-code">
                            <svg viewBox="0 0 24 24" style="width:9px;height:9px;stroke:var(--ink4);fill:none;stroke-width:2;"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                            {{ $dept->code }}
                        </div>
                    </div>
                </div>

                @if($dept->description)
                    <div class="dm-card-desc">{{ Str::limit($dept->description, 120) }}</div>
                @else
                    <div class="dm-card-desc" style="color:var(--ink4);font-style:italic;">No description provided</div>
                @endif

                {{-- Manager --}}
                @if($mgr)
                    <div class="dm-card-manager">
                        <div class="dm-card-manager-av">{{ $mgrInit }}</div>
                        <div>
                            <div class="dm-card-manager-name">{{ $mgr->first_name }} {{ $mgr->last_name }}</div>
                            <div class="dm-card-manager-role">Department Manager</div>
                        </div>
                    </div>
                @else
                    <div style="margin:0 18px 14px;padding:9px 12px;border-radius:10px;background:var(--bg);border:1px dashed var(--border);font-size:12.5px;color:var(--ink4);font-weight:600;text-align:center;">
                        No manager assigned
                    </div>
                @endif

                {{-- Stats --}}
                <div class="dm-card-stats">
                    <div class="dm-card-stat">
                        <div class="dm-card-stat-label">Employees</div>
                        <div class="dm-card-stat-val">{{ $empCount }}</div>
                    </div>
                </div>

                <div class="dm-card-footer">
                    <button class="dm-btn dm-btn-ghost dm-btn-sm" wire:click="openView('{{ $dept->id }}')" title="View">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        View
                    </button>
                    <button class="dm-btn dm-btn-outline dm-btn-sm" wire:click="openEdit('{{ $dept->id }}')" title="Edit">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Edit
                    </button>
                    <button class="dm-btn dm-btn-danger dm-btn-sm" wire:click="confirmDelete('{{ $dept->id }}')" title="Delete">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @if($departments->hasPages())
        <div class="dm-pagination">
            <div class="dm-page-info">Showing {{ $departments->firstItem() }}–{{ $departments->lastItem() }} of {{ $departments->total() }}</div>
            {{ $departments->links() }}
        </div>
    @endif
@else
    <div class="dm-empty">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <div class="dm-empty-title">No departments yet</div>
        <div class="dm-empty-sub">{{ $search ? 'No results for "'.$search.'"' : 'Click "Add Department" to create your first one.' }}</div>
    </div>
@endif

{{-- ══ CREATE / EDIT MODAL ════════════════════════════════ --}}
@if($showModal)
<div class="dm-modal-bg" wire:click.self="closeModal">
    <div class="dm-modal">
        <div class="dm-modal-hd">
            <div class="dm-modal-title">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                {{ $editingId ? 'Edit Department' : 'New Department' }}
                @if($code)
                    <span style="font-size:12px;font-weight:600;background:rgba(255,255,255,0.18);padding:2px 10px;border-radius:100px;">{{ $code }}</span>
                @endif
            </div>
            <button class="dm-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="dm-modal-body">
            <div class="dm-section-lbl">
                <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/></svg>
                Basic Information
            </div>

            <div class="dm-form-row">
                <div class="dm-field">
                    <label>Department Code <span class="req">*</span></label>
                    <input type="text" wire:model="code" placeholder="e.g. DEPT-001" style="text-transform:uppercase;">
                    @error('code') <span class="dm-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="dm-field">
                    <label>Department Name <span class="req">*</span></label>
                    <input type="text" wire:model="name" placeholder="e.g. Human Resources">
                    @error('name') <span class="dm-field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="dm-field">
                <label>Description</label>
                <textarea wire:model="description" placeholder="Describe the purpose and responsibilities of this department…"></textarea>
                @error('description') <span class="dm-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="dm-section-lbl" style="margin-top:4px;">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Department Manager
            </div>

            <div class="dm-field">
                <label>Assign Manager (optional)</label>
                <select wire:model="managerId">
                    <option value="">No manager assigned</option>
                    @foreach($managers as $mgr)
                        <option value="{{ $mgr['id'] }}">{{ $mgr['name'] }}</option>
                    @endforeach
                </select>
                @error('managerId') <span class="dm-field-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="dm-modal-footer">
            <div style="font-size:12.5px;color:var(--ink4);">Fields marked <span style="color:var(--red);font-weight:800;">*</span> are required</div>
            <div style="display:flex;gap:8px;">
                <button class="dm-btn dm-btn-outline" wire:click="closeModal">Cancel</button>
                <button class="dm-btn dm-btn-primary" wire:click="save">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    {{ $editingId ? 'Update Department' : 'Create Department' }}
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewDepartment)
<div class="dm-modal-bg" wire:click.self="closeView">
    <div class="dm-modal">
        <div class="dm-modal-hd">
            <div class="dm-modal-title">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Department Details
            </div>
            <button class="dm-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="dm-view-hero">
            <div class="dm-view-av" style="background:linear-gradient(135deg,var(--blue),#5A8BF5);">
                {{ strtoupper(substr($viewDepartment->name,0,1)) }}
            </div>
            <div>
                <div class="dm-view-name">{{ $viewDepartment->name }}</div>
                <div class="dm-view-code-badge">{{ $viewDepartment->code }}</div>
            </div>
        </div>

        <div class="dm-view-rows">
            <div class="dm-view-row">
                <span class="dm-view-label">Description</span>
                <span class="dm-view-value" style="font-weight:500;color:var(--ink3);text-align:right;max-width:280px;">
                    {{ $viewDepartment->description ?: 'No description provided' }}
                </span>
            </div>
            <div class="dm-view-row">
                <span class="dm-view-label">Manager</span>
                <span class="dm-view-value">
                    {{ $viewDepartment->manager ? $viewDepartment->manager->first_name.' '.$viewDepartment->manager->last_name : '—' }}
                </span>
            </div>
            <div class="dm-view-row">
                <span class="dm-view-label">Total Employees</span>
                <span class="dm-view-value" style="color:var(--blue-2);">{{ $viewDepartment->employees->count() }}</span>
            </div>
            <div class="dm-view-row">
                <span class="dm-view-label">Total Positions</span>
                <span class="dm-view-value" style="color:var(--blue-2);">
                    {{ isset($viewDepartment->positions) ? $viewDepartment->positions->count() : '—' }}
                </span>
            </div>
            <div class="dm-view-row">
                <span class="dm-view-label">Created</span>
                <span class="dm-view-value">{{ $viewDepartment->created_at?->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="dm-modal-footer" style="justify-content:flex-end;">
            <button class="dm-btn dm-btn-outline" wire:click="closeView">Close</button>
            <button class="dm-btn dm-btn-primary" wire:click="openEdit('{{ $viewDepartment->id }}'); closeView()">
                <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                Edit
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══ DELETE MODAL ════════════════════════════════════════ --}}
@if($showDelete)
<div class="dm-modal-bg" wire:click.self="cancelDelete">
    <div class="dm-modal dm-modal-sm">
        <div class="dm-modal-hd" style="background:linear-gradient(105deg,#991B1B,var(--red));">
            <div class="dm-modal-title">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Delete Department
            </div>
            <button class="dm-modal-close" wire:click="cancelDelete">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="dm-modal-body" style="text-align:center;">
            <div class="dm-delete-icon">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><line x1="12" y1="12" x2="12" y2="17"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:800;color:var(--ink);margin-bottom:8px;">Delete this department?</div>
            <p style="font-size:13.5px;color:var(--ink3);font-weight:500;line-height:1.6;margin:0;">
                This will permanently remove the department. Employees assigned to it will lose their department reference. This cannot be undone.
            </p>
        </div>
        <div class="dm-modal-footer" style="justify-content:center;gap:12px;">
            <button class="dm-btn dm-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="dm-btn dm-btn-danger" wire:click="deleteDepartment">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>
@endif

</div>{{-- /dm-root --}}