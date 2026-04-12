<div class="pm-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.pm-root {
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
.pm-flash { padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 9px; }
.pm-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.pm-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.pm-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.pm-hero { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.pm-hero-cover {
    height: 68px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.pm-hero-cover::before { content:''; position:absolute; top:-30px; right:60px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,0.06); }
.pm-hero-body {
    padding: 0 24px 0;
    display: flex; align-items: flex-end; justify-content: space-between; gap:16px;
    margin-top: -2px;
}
.pm-hero-icon {
    width: 52px; height: 52px; border-radius: 15px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pm-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.pm-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.pm-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }

/* Stat strip */
.pm-stat-strip { display: grid; grid-template-columns: repeat(4,1fr); gap: 1px; background: var(--border); border-radius: 0 0 var(--r-lg) var(--r-lg); overflow: hidden; margin-top: 18px; }
.pm-stat-cell { background: var(--white); padding: 13px 18px; display: flex; flex-direction: column; gap: 2px; }
.pm-stat-cell-icon { width: 26px; height: 26px; border-radius: 7px; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.pm-stat-cell-icon svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }
.pm-stat-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.pm-stat-val   { font-family:'Sora',sans-serif; font-size: 20px; font-weight: 800; color: var(--ink2); }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.pm-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 14px 18px; }
.pm-search-box { display: flex; align-items: center; gap: 8px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 13px; flex: 1; min-width: 200px; transition: border-color 0.15s, box-shadow 0.15s; }
.pm-search-box:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); }
.pm-search-box svg { width: 14px; height: 14px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.pm-search-box input { border: none; background: transparent; font-size: 13.5px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.pm-search-box input::placeholder { color: var(--ink4); }
.pm-filter-select { background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 32px 8px 12px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; -webkit-appearance: none; transition: border-color 0.15s; }
.pm-filter-select:focus { border-color: var(--blue); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.pm-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 17px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all 0.15s; white-space: nowrap; }
.pm-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.pm-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.pm-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.pm-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.pm-btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.pm-btn-ghost { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.pm-btn-ghost:hover { background: var(--blue-mid); }
.pm-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.pm-btn-danger:hover { background: rgba(239,68,68,0.15); }
.pm-btn-sm { padding: 5px 11px; font-size: 12px; }

/* ══ TABLE ═══════════════════════════════════════════════ */
.pm-table-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.pm-table-wrap { overflow-x: auto; }
table.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead tr { border-bottom: 1px solid var(--border); background: #FAFBFF; }
.pm-table th { padding: 11px 16px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.pm-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s; }
.pm-table tbody tr:last-child { border-bottom: none; }
.pm-table tbody tr:hover { background: #F8FAFF; }
.pm-table td { padding: 14px 16px; font-size: 13px; font-weight: 500; color: var(--ink2); }
.pm-table td.bold { font-weight: 700; color: var(--ink); }

/* Position avatar cell */
.pm-pos-cell { display: flex; align-items: center; gap: 11px; }
.pm-pos-icon {
    width: 38px; height: 38px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 800; color: #fff;
    flex-shrink: 0;
}
.pm-pos-name { font-size: 13.5px; font-weight: 700; color: var(--ink); margin-bottom: 2px; }
.pm-pos-code { font-size: 11px; color: var(--ink4); font-weight: 600; }

/* Dept badge */
.pm-dept-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 100px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    font-size: 12px; font-weight: 700; color: var(--blue-2);
}
.pm-dept-badge svg { width: 11px; height: 11px; stroke: var(--blue); fill: none; stroke-width: 2; }

/* Staff count pill */
.pm-staff-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 100px; font-size: 12px; font-weight: 700;
}
.pm-staff-pill.has-staff { background: var(--green-lt); color: #087A42; }
.pm-staff-pill.vacant    { background: var(--amber-lt); color: #92400E; }
.pm-staff-pill svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2; }

/* Row actions */
.pm-actions { display: flex; gap: 6px; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.pm-empty { text-align: center; padding: 56px 24px; }
.pm-empty svg { width: 40px; height: 40px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 14px; display: block; opacity: 0.4; }
.pm-empty-title { font-size: 16px; font-weight: 700; color: var(--ink3); margin-bottom: 5px; }
.pm-empty-sub   { font-size: 13px; color: var(--ink4); font-weight: 500; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.pm-pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-top: 1px solid var(--border); }
.pm-page-info  { font-size: 12.5px; color: var(--ink4); font-weight: 500; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.pm-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.50); backdrop-filter: blur(8px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 16px; }
.pm-modal { background: var(--white); border-radius: var(--r-lg); box-shadow: 0 24px 64px rgba(15,22,41,0.22); border: 1px solid var(--border); width: 100%; max-width: 560px; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; }
.pm-modal-sm  { max-width: 460px; }
.pm-modal-hd { background: linear-gradient(105deg, var(--blue-3), var(--blue)); padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
.pm-modal-title { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 9px; }
.pm-modal-title svg { width: 18px; height: 18px; stroke: rgba(255,255,255,0.8); fill: none; stroke-width: 2; }
.pm-modal-close { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.18); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.15s; }
.pm-modal-close:hover { background: rgba(255,255,255,0.28); }
.pm-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }
.pm-modal-body { flex: 1; overflow-y: auto; padding: 22px; display: flex; flex-direction: column; gap: 14px; }
.pm-modal-footer { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }

/* Section label */
.pm-section-lbl { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
.pm-section-lbl::after { content: ''; flex: 1; height: 1px; background: var(--border); }
.pm-section-lbl svg { width: 12px; height: 12px; stroke: var(--blue); fill: none; stroke-width: 2; }

/* Fields */
.pm-field { display: flex; flex-direction: column; gap: 5px; }
.pm-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); }
.pm-field label .req { color: var(--red); margin-left: 2px; }
.pm-field input, .pm-field select, .pm-field textarea {
    width: 100%; padding: 10px 13px; box-sizing: border-box;
    background: #F6F8FC; border: 1.5px solid var(--border);
    border-radius: var(--r); font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    -webkit-appearance: none;
}
.pm-field input:focus, .pm-field select:focus, .pm-field textarea:focus {
    border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white);
}
.pm-field select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 11px center; padding-right: 32px; cursor: pointer; }
.pm-field textarea { resize: vertical; min-height: 90px; }
.pm-field-error { font-size: 11.5px; color: var(--red); font-weight: 600; }
.pm-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* View modal */
.pm-view-hero { padding: 22px 22px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 16px; }
.pm-view-icon { width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, var(--blue), #5A8BF5); display: flex; align-items: center; justify-content: center; font-family:'Sora',sans-serif; font-size: 20px; font-weight: 800; color: #fff; flex-shrink: 0; }
.pm-view-name { font-family:'Sora',sans-serif; font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
.pm-view-code-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 700; color: var(--blue-2); background: var(--blue-lt); border: 1px solid var(--blue-brd); padding: 3px 10px; border-radius: 7px; }
.pm-view-rows { padding: 14px 22px; display: flex; flex-direction: column; }
.pm-view-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid var(--border); gap: 12px; }
.pm-view-row:last-child { border-bottom: none; }
.pm-view-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); flex-shrink: 0; }
.pm-view-value { font-size: 13.5px; font-weight: 600; color: var(--ink2); text-align: right; }

/* Delete */
.pm-delete-icon { width: 56px; height: 56px; border-radius: 16px; background: var(--red-lt); border: 1px solid rgba(239,68,68,0.22); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.pm-delete-icon svg { width: 26px; height: 26px; stroke: var(--red); fill: none; stroke-width: 1.75; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 768px) {
    .pm-root { padding: 14px 12px 32px; }
    .pm-form-row { grid-template-columns: 1fr; }
    .pm-stat-strip { grid-template-columns: repeat(2,1fr); }
}
</style>

{{-- Flash --}}
@if(session()->has('success'))
    <div class="pm-flash pm-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="pm-flash pm-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ PAGE HERO ══════════════════════════════════════════ --}}
<div class="pm-hero">
    <div class="pm-hero-cover"></div>
    <div class="pm-hero-body">
        <div style="display:flex;align-items:flex-end;gap:13px;">
            <div class="pm-hero-icon">
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            </div>
            <div>
                <div class="pm-hero-title">Positions</div>
                <div class="pm-hero-sub">Define roles and job positions across your organisation</div>
            </div>
        </div>
        <button class="pm-btn pm-btn-primary" wire:click="openCreate" style="margin-bottom:4px;">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Position
        </button>
    </div>
    <div class="pm-stat-strip">
        <div class="pm-stat-cell">
            <div class="pm-stat-cell-icon" style="background:var(--blue-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--blue)"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            </div>
            <div class="pm-stat-label">Total Positions</div>
            <div class="pm-stat-val">{{ $totalCount }}</div>
        </div>
        <div class="pm-stat-cell">
            <div class="pm-stat-cell-icon" style="background:var(--green-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="pm-stat-label">Filled Positions</div>
            <div class="pm-stat-val" style="color:var(--green);">{{ $withStaffCount }}</div>
        </div>
        <div class="pm-stat-cell">
            <div class="pm-stat-cell-icon" style="background:var(--amber-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--amber)"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="pm-stat-label">Vacant</div>
            <div class="pm-stat-val" style="color:var(--amber);">{{ $vacantCount }}</div>
        </div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="pm-toolbar">
    <div class="pm-search-box">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, code or description…">
    </div>
    <select class="pm-filter-select" wire:model.live="perPage" style="min-width:90px;">
        <option value="15">15</option>
        <option value="25">25</option>
        <option value="50">50</option>
    </select>
</div>

{{-- ══ POSITIONS TABLE ═════════════════════════════════════ --}}
@php
    $posColors = [
        'linear-gradient(135deg,#3B6FE8,#5A8BF5)',
        'linear-gradient(135deg,#12B76A,#34D399)',
        'linear-gradient(135deg,#7C3AED,#A78BFA)',
        'linear-gradient(135deg,#D97706,#F59E0B)',
        'linear-gradient(135deg,#DC2626,#EF4444)',
        'linear-gradient(135deg,#0E7490,#0891B2)',
        'linear-gradient(135deg,#9D174D,#EC4899)',
    ];
@endphp

<div class="pm-table-card">
    <div class="pm-table-wrap">
        <table class="pm-table">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Description</th>
                    <th>Staff Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $i => $pos)
                    @php
                        $iconBg     = $posColors[$i % count($posColors)];
                        $initial    = strtoupper(substr($pos->name, 0, 1));
                        $empCount   = $pos->employees_count ?? 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="pm-pos-cell">
                                <div class="pm-pos-icon" style="background:{{ $iconBg }};">{{ $initial }}</div>
                                <div>
                                    <div class="pm-pos-name">{{ $pos->name }}</div>
                                    <div class="pm-pos-code">{{ $pos->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="max-width:200px;white-space:normal;font-size:12.5px;color:var(--ink3);">
                            {{ $pos->description ? Str::limit($pos->description, 80) : '—' }}
                        </td>
                        <td>
                            <span class="pm-staff-pill {{ $empCount > 0 ? 'has-staff' : 'vacant' }}">
                                <svg viewBox="0 0 24 24">
                                    @if($empCount > 0)
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                    @else
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    @endif
                                </svg>
                                {{ $empCount }} {{ $empCount === 1 ? 'employee' : ($empCount > 1 ? 'employees' : 'Vacant') }}
                            </span>
                        </td>
                        <td>
                            <div class="pm-actions">
                                <button class="pm-btn pm-btn-ghost pm-btn-sm" wire:click="openView('{{ $pos->id }}')" title="View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="pm-btn pm-btn-outline pm-btn-sm" wire:click="openEdit('{{ $pos->id }}')" title="Edit">
                                    <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                </button>
                                <button class="pm-btn pm-btn-danger pm-btn-sm" wire:click="confirmDelete('{{ $pos->id }}')" title="Delete">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="pm-empty">
                                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                                <div class="pm-empty-title">No positions found</div>
                                <div class="pm-empty-sub">{{ $search ? 'Try a different search term.' : 'Click "Add Position" to create your first role.' }}</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($positions->hasPages())
        <div class="pm-pagination">
            <div class="pm-page-info">Showing {{ $positions->firstItem() }}–{{ $positions->lastItem() }} of {{ $positions->total() }}</div>
            {{ $positions->links() }}
        </div>
    @endif
</div>

{{-- ══ CREATE / EDIT MODAL ════════════════════════════════ --}}
@if($showModal)
<div class="pm-modal-bg" wire:click.self="closeModal">
    <div class="pm-modal">
        <div class="pm-modal-hd">
            <div class="pm-modal-title">
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                {{ $editingId ? 'Edit Position' : 'New Position' }}
                @if($code)
                    <span style="font-size:12px;font-weight:600;background:rgba(255,255,255,0.18);padding:2px 10px;border-radius:100px;">{{ $code }}</span>
                @endif
            </div>
            <button class="pm-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="pm-modal-body">
            <div class="pm-section-lbl">
                <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/></svg>
                Position Details
            </div>

            <div class="pm-form-row">
                <div class="pm-field">
                    <label>Position Code <span class="req">*</span></label>
                    <input type="text" wire:model="code" placeholder="e.g. POS-001" style="text-transform:uppercase;">
                    @error('code') <span class="pm-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="pm-field">
                    <label>Position Name <span class="req">*</span></label>
                    <input type="text" wire:model="name" placeholder="e.g. Software Engineer">
                    @error('name') <span class="pm-field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pm-field">
                <label>Description</label>
                <textarea wire:model="description" placeholder="Describe the key responsibilities and requirements for this position…"></textarea>
                @error('description') <span class="pm-field-error">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="pm-modal-footer">
            <div style="font-size:12.5px;color:var(--ink4);">Fields marked <span style="color:var(--red);font-weight:800;">*</span> are required</div>
            <div style="display:flex;gap:8px;">
                <button class="pm-btn pm-btn-outline" wire:click="closeModal">Cancel</button>
                <button class="pm-btn pm-btn-primary" wire:click="save">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    {{ $editingId ? 'Update Position' : 'Create Position' }}
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewPosition)
<div class="pm-modal-bg" wire:click.self="closeView">
    <div class="pm-modal">
        <div class="pm-modal-hd">
            <div class="pm-modal-title">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Position Details
            </div>
            <button class="pm-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="pm-view-hero">
            <div class="pm-view-icon">{{ strtoupper(substr($viewPosition->name,0,1)) }}</div>
            <div>
                <div class="pm-view-name">{{ $viewPosition->name }}</div>
                <div class="pm-view-code-badge">{{ $viewPosition->code }}</div>
            </div>
        </div>

        <div class="pm-view-rows">
            <div class="pm-view-row">
                <span class="pm-view-label">Description</span>
                <span class="pm-view-value" style="font-weight:500;color:var(--ink3);max-width:300px;text-align:right;">
                    {{ $viewPosition->description ?: 'No description provided' }}
                </span>
            </div>
            <div class="pm-view-row">
                <span class="pm-view-label">Employees in Role</span>
                <span class="pm-view-value" style="color:var(--blue-2);">
                    {{ $viewPosition->employees ? $viewPosition->employees->count() : '0' }}
                </span>
            </div>
            <div class="pm-view-row">
                <span class="pm-view-label">Created</span>
                <span class="pm-view-value">{{ $viewPosition->created_at?->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="pm-modal-footer" style="justify-content:flex-end;">
            <button class="pm-btn pm-btn-outline" wire:click="closeView">Close</button>
            <button class="pm-btn pm-btn-primary" wire:click="openEdit('{{ $viewPosition->id }}'); closeView()">
                <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                Edit
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══ DELETE MODAL ════════════════════════════════════════ --}}
@if($showDelete)
<div class="pm-modal-bg" wire:click.self="cancelDelete">
    <div class="pm-modal pm-modal-sm">
        <div class="pm-modal-hd" style="background:linear-gradient(105deg,#991B1B,var(--red));">
            <div class="pm-modal-title">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Delete Position
            </div>
            <button class="pm-modal-close" wire:click="cancelDelete">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="pm-modal-body" style="text-align:center;padding:28px 24px;">
            <div class="pm-delete-icon">
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><line x1="12" y1="12" x2="12" y2="17"/></svg>
            </div>
            <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:800;color:var(--ink);margin-bottom:8px;">Delete this position?</div>
            <p style="font-size:13.5px;color:var(--ink3);font-weight:500;line-height:1.6;margin:0;">
                This will permanently remove the position record. Employees assigned to it will lose their position reference. This cannot be undone.
            </p>
        </div>
        <div class="pm-modal-footer" style="justify-content:center;gap:12px;">
            <button class="pm-btn pm-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="pm-btn pm-btn-danger" wire:click="deletePosition">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>
@endif

</div>{{-- /pm-root --}}