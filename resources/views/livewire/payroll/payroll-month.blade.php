<div class="pm-root">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

        /* ══ TOKENS ══════════════════════════════════════════════ */
        .pm-root {
            --blue: #3B6FE8;
            --blue-2: #2755CC;
            --blue-3: #1A3FA8;
            --blue-lt: rgba(59, 111, 232, 0.09);
            --blue-mid: rgba(59, 111, 232, 0.18);
            --blue-brd: rgba(59, 111, 232, 0.22);
            --green: #12B76A;
            --green-lt: rgba(18, 183, 106, 0.10);
            --amber: #F59E0B;
            --amber-lt: rgba(245, 158, 11, 0.10);
            --red: #EF4444;
            --red-lt: rgba(239, 68, 68, 0.09);
            --purple: #7C3AED;
            --purple-lt: rgba(124, 58, 237, 0.09);
            --bg: #F0F4FA;
            --white: #FFFFFF;
            --ink: #0F1629;
            --ink2: #2D3356;
            --ink3: #6B7094;
            --ink4: #A8ADCA;
            --border: rgba(15, 22, 41, 0.08);
            --sh-sm: 0 2px 10px rgba(59, 111, 232, 0.07);
            --sh-md: 0 8px 28px rgba(59, 111, 232, 0.12);
            --sh-lg: 0 18px 52px rgba(59, 111, 232, 0.16);
            --r: 12px;
            --r-lg: 18px;
            font-family: 'DM Sans', -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--ink);
            padding: 24px 28px 48px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ══ FLASH ═══════════════════════════════════════════════ */
        .pm-flash {
            padding: 12px 18px;
            border-radius: var(--r);
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .pm-flash-ok {
            background: var(--green-lt);
            border: 1px solid rgba(18, 183, 106, 0.22);
            color: #087A42;
        }

        .pm-flash-err {
            background: var(--red-lt);
            border: 1px solid rgba(239, 68, 68, 0.22);
            color: #991B1B;
        }

        .pm-flash svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        /* ══ HERO ════════════════════════════════════════════════ */
        .pm-hero {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--sh-sm);
            overflow: hidden;
        }

        .pm-hero-cover {
            height: 72px;
            background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 38%, #3B6FE8 68%, #5A8BF5 100%);
            position: relative;
            overflow: hidden;
        }

        .pm-hero-cover::before {
            content: '';
            position: absolute;
            top: -40px;
            right: 80px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .pm-hero-cover::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 40px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .pm-hero-body {
            padding: 0 24px 20px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-top: 2px; }
.pm-hero-icon { width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg,var(--blue),#5A8BF5); border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.30); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.pm-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.pm-hero-title { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 800; color: var(--ink); letter-spacing: -0.3px; }
.pm-hero-sub   { font-size: 12.5px; color: var(--ink3); margin-top: 2px; }
.pm-stat-strip { display: flex; gap: 0; }
.pm-stat { padding: 6px 18px; text-align: center; border-left: 1px solid var(--border); }
.pm-stat:first-child { border-left: none; }
.pm-stat-val { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 800; color: var(--ink); line-height: 1; }
.pm-stat-lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); margin-top: 2px; }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.pm-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); padding: 14px 18px; }
.pm-search { display: flex; align-items: center; gap: 8px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 13px; flex: 1; min-width: 200px; transition: border-color .15s, box-shadow .15s; }
.pm-search:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); }
.pm-search svg { width: 14px; height: 14px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.pm-search input { border: none; background: transparent; font-size: 13.5px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.pm-search input::placeholder { color: var(--ink4); }
.pm-sel { background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 32px 8px 12px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; -webkit-appearance: none; transition: border-color .15s; }
.pm-sel:focus { border-color: var(--blue); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.pm-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all .15s; white-space: nowrap; }
.pm-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.pm-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.pm-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.pm-btn-ghost   { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.pm-btn-ghost:hover   { background: var(--blue-mid); }
.pm-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.pm-btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.pm-btn-green  { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }
.pm-btn-green:hover  { background: rgba(18,183,106,0.16); }
.pm-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.pm-btn-danger:hover { background: rgba(239,68,68,0.15); }
.pm-btn-amber  { background: var(--amber-lt); color: #92400E; border: 1px solid rgba(245,158,11,0.22); }
.pm-btn-sm { padding: 5px 11px; font-size: 12px; }

/* ══ BADGE ═══════════════════════════════════════════════ */
.pm-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.pb-green  { background: var(--green-lt);  color: #087A42; }
.pb-amber  { background: var(--amber-lt);  color: #92400E; }
.pb-red    { background: var(--red-lt);    color: #991B1B; }
.pb-blue   { background: var(--blue-lt);   color: var(--blue-2); }
.pb-purple { background: var(--purple-lt); color: var(--purple); }
.pb-gray   { background: var(--bg); color: var(--ink3); border: 1px solid var(--border); }

/* ══ TABLE CARD ══════════════════════════════════════════ */
.pm-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
.pm-card-hd { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid var(--border); }
.pm-card-hd-left { display: flex; align-items: center; gap: 9px; }
.pm-card-ico { width: 30px; height: 30px; border-radius: 8px; background: var(--blue-lt); border: 1px solid var(--blue-brd); display: flex; align-items: center; justify-content: center; }
.pm-card-ico svg { width: 14px; height: 14px; stroke: var(--blue); fill: none; stroke-width: 2; }
.pm-card-title { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.pm-card-sub   { font-size: 11.5px; color: var(--ink4); margin-top: 1px; }

.pm-table-wrap { overflow-x: auto; }
table.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead tr { background: #FAFBFF; border-bottom: 1px solid var(--border); }
.pm-table th { padding: 10px 16px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.pm-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
.pm-table tbody tr:last-child { border-bottom: none; }
.pm-table tbody tr:hover { background: #F8FAFF; }
.pm-table td { padding: 12px 16px; font-size: 13px; color: var(--ink2); }

/* ── Code badge ─────────────────────────────────────── */
.pm-code { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 800; background: var(--blue-lt); color: var(--blue-2); border: 1px solid var(--blue-brd); padding: 3px 9px; border-radius: 7px; letter-spacing: .04em; }

/* ── Date range pill ──────────────────────────────────── */
.pm-date-range { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--ink3); font-weight: 600; }
.pm-date-range svg { width: 11px; height: 11px; stroke: var(--ink4); fill: none; stroke-width: 2; }

/* ── Row actions ─────────────────────────────────────── */
.pm-actions { display: flex; gap: 5px; align-items: center; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.pm-empty { padding: 56px 32px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 10px; }
.pm-empty-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--blue-lt); display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.pm-empty-icon svg { width: 22px; height: 22px; stroke: var(--blue); fill: none; stroke-width: 1.5; }
.pm-empty-ttl { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: var(--ink2); }
.pm-empty-sub { font-size: 13px; color: var(--ink4); }

/* ══ MODAL ═══════════════════════════════════════════════ */
.pm-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.52); backdrop-filter: blur(10px); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.pm-modal { background: var(--white); border-radius: var(--r-lg); box-shadow: var(--sh-lg); border: 1px solid var(--border); width: 100%; max-width: 580px; max-height: 92vh; overflow-y: auto; display: flex; flex-direction: column; }
.pm-modal-lg { max-width: 720px; }
.pm-modal-hd { background: linear-gradient(105deg,var(--blue-3),var(--blue)); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
.pm-modal-hd-left { display: flex; align-items: center; gap: 12px; }
.pm-modal-hd-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; }
.pm-modal-hd-icon svg { width: 17px; height: 17px; stroke: #fff; fill: none; stroke-width: 2; }
.pm-modal-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: #fff; }
.pm-modal-sub   { font-size: 12px; color: rgba(255,255,255,.65); margin-top: 1px; }
.pm-modal-close { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.18); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; flex-shrink: 0; }
.pm-modal-close:hover { background: rgba(255,255,255,0.30); }
.pm-modal-close svg { width: 14px; height: 14px; stroke: #fff; fill: none; stroke-width: 2.5; }
.pm-modal-body { padding: 22px 24px; display: flex; flex-direction: column; gap: 16px; }
.pm-modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; }

/* ── Fields ─────────────────────────────────────────── */
.pm-field { display: flex; flex-direction: column; gap: 5px; }
.pm-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .09em; color: var(--ink4); }
.pm-field label .req { color: var(--red); }
.pm-field input, .pm-field select, .pm-field textarea {
    width: 100%; padding: 9px 13px; box-sizing: border-box;
    background: #F6F8FC; border: 1.5px solid var(--border); border-radius: var(--r);
    font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color .15s, box-shadow .15s;
}
.pm-field input:focus, .pm-field select:focus, .pm-field textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white); }
.pm-field textarea { resize: vertical; min-height: 80px; }
.pm-field-err { font-size: 11.5px; color: var(--red); font-weight: 600; margin-top: 2px; }
.pm-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* ── Section divider ─────────────────────────────────── */
.pm-section-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .10em; color: var(--ink4); padding: 6px 0 2px; border-bottom: 1px solid var(--border); margin-bottom: 2px; }

/* ══ VIEW MODAL ══════════════════════════════════════════ */
.pm-view-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.pm-view-row  { display: flex; flex-direction: column; gap: 3px; padding: 10px 14px; background: var(--bg); border-radius: 10px; border: 1px solid var(--border); }
.pm-view-row.full { grid-column: 1 / -1; }
.pm-view-lbl  { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); }
.pm-view-val  { font-size: 13.5px; font-weight: 600; color: var(--ink); }

/* ══ DELETE CONFIRM ══════════════════════════════════════ */
.pm-del-modal { max-width: 420px; }
.pm-del-body  { padding: 28px 26px; text-align: center; }
.pm-del-icon  { width: 52px; height: 52px; border-radius: 50%; background: var(--red-lt); border: 1px solid rgba(239,68,68,0.22); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
.pm-del-icon svg { width: 22px; height: 22px; stroke: var(--red); fill: none; stroke-width: 2; }
.pm-del-ttl   { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 8px; }
.pm-del-sub   { font-size: 13px; color: var(--ink3); line-height: 1.6; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.pm-pager { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.pm-pager-info { font-size: 12.5px; color: var(--ink4); font-weight: 600; }

@media (max-width: 768px) { .pm-grid2 { grid-template-columns: 1fr; } .pm-view-grid { grid-template-columns: 1fr; } .pm-stat-strip { display: none; } }
</style>

{{-- ── Flash ────────────────────────────────────────────── --}}
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

{{-- ══ HERO ═══════════════════════════════════════════════ --}}
<div class="pm-hero">
    <div class="pm-hero-cover"></div>
    <div class="pm-hero-body">
        <div style="display:flex;align-items:flex-end;gap:14px;">
            <div class="pm-hero-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="pm-hero-title">Payroll Months</div>
                <div class="pm-hero-sub">Manage payroll periods, dates and approval status</div>
            </div>
        </div>
        <div class="pm-stat-strip">
            <div class="pm-stat"><div class="pm-stat-val">{{ $totalCount }}</div><div class="pm-stat-lbl">Total</div></div>
            <div class="pm-stat"><div class="pm-stat-val" style="color:var(--green)">{{ $approvedCount }}</div><div class="pm-stat-lbl">Approved</div></div>
            <div class="pm-stat"><div class="pm-stat-val" style="color:var(--amber)">{{ $pendingCount }}</div><div class="pm-stat-lbl">Pending</div></div>
            <div class="pm-stat"><div class="pm-stat-val" style="color:var(--ink3)">{{ $initiatedCount }}</div><div class="pm-stat-lbl">Initiated</div></div>
        </div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="pm-toolbar">
    <div class="pm-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search code, name or description…">
    </div>
    <select class="pm-sel" wire:model.live="filterStatus">
        <option value="">All Statuses</option>
        @foreach($approvalStatuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <button class="pm-btn pm-btn-primary" wire:click="openCreate">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Payroll Month
    </button>
</div>

{{-- ══ TABLE ═══════════════════════════════════════════════ --}}
<div class="pm-card">
    <div class="pm-card-hd">
        <div class="pm-card-hd-left">
            <div class="pm-card-ico">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="pm-card-title">Payroll Month Registry</div>
                <div class="pm-card-sub">{{ $records->total() }} record{{ $records->total() != 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>

    <div class="pm-table-wrap">
        <table class="pm-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Period</th>
                    <th>Entries</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $row)
                    @php
                        $st = $row->approval_status instanceof \BackedEnum
                            ? $row->approval_status->value : ($row->approval_status ?? 'draft');
                        $stClass = match ($st) {
                            'approved' => 'pb-green',
                            'pending' => 'pb-amber',
                            'rejected' => 'pb-red',
                            'cancelled' => 'pb-red',
                            default => 'pb-gray',
                        };
                    @endphp
                    <tr>
                        <td><span class="pm-code">{{ $row->code }}</span></td>
                        <td>
                            <div style="font-weight:700;color:var(--ink);">{{ $row->name }}</div>
                            @if($row->description)
                                <div style="font-size:11.5px;color:var(--ink4);margin-top:2px;">{{ Str::limit($row->description, 55) }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="pm-date-range">
                                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($row->start_date)->format('M d, Y') }}
                                <span style="color:var(--ink4);">→</span>
                                {{ \Carbon\Carbon::parse($row->end_date)->format('M d, Y') }}
                            </div>
                            <div style="font-size:11px;color:var(--ink4);margin-top:2px;">
                                {{ \Carbon\Carbon::parse($row->start_date)->diffInDays(\Carbon\Carbon::parse($row->end_date)) + 1 }} days
                            </div>
                        </td>
                        <td>
                            <span class="pm-badge pb-blue">{{ $row->payroll_entries_count ?? 0 }} entries</span>
                        </td>
                        <td><span class="pm-badge {{ $stClass }}">{{ ucfirst($st) }}</span></td>
                        <td>
                            <div class="pm-actions">
                                <button class="pm-btn pm-btn-ghost pm-btn-sm" wire:click="openView('{{ $row->id }}')" title="View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="pm-btn pm-btn-outline pm-btn-sm" wire:click="openEdit('{{ $row->id }}')" title="Edit">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                @if($st !== 'approved')
                                    <button class="pm-btn pm-btn-green pm-btn-sm" wire:click="approve('{{ $row->id }}')" title="Approve"
                                            wire:confirm="Approve this payroll month?">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                @endif
                                <button class="pm-btn pm-btn-danger pm-btn-sm" wire:click="confirmDelete('{{ $row->id }}')" title="Delete">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="pm-empty">
                                <div class="pm-empty-icon">
                                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div class="pm-empty-ttl">No payroll months found</div>
                                <div class="pm-empty-sub">{{ $search || $filterStatus ? 'Try adjusting your search or filters.' : 'Click "New Payroll Month" to get started.' }}</div>
                                @unless($search || $filterStatus)
                                    <button class="pm-btn pm-btn-primary" wire:click="openCreate" style="margin-top:8px;">
                                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Create First Payroll Month
                                    </button>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($records->hasPages())
        <div class="pm-pager">
            <div class="pm-pager-info">Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of {{ $records->total() }}</div>
            {{ $records->links() }}
        </div>
    @endif
</div>

{{-- ══ CREATE / EDIT MODAL ════════════════════════════════ --}}
@if($showModal)
    <div class="pm-modal-bg" wire:click.self="closeModal">
        <div class="pm-modal">

            <div class="pm-modal-hd">
                <div class="pm-modal-hd-left">
                    <div class="pm-modal-hd-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="pm-modal-title">{{ $editingId ? 'Edit Payroll Month' : 'New Payroll Month' }}</div>
                        <div class="pm-modal-sub">{{ $editingId ? 'Update period details and status' : 'Define a new payroll period' }}</div>
                    </div>
                </div>
                <button class="pm-modal-close" wire:click="closeModal">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="pm-modal-body">
                {{-- Code + Name --}}
                <div class="pm-grid2">
                    <div class="pm-field">
                        <label>Code <span class="req">*</span></label>
                        <input type="text" wire:model="code" placeholder="PM-0001" style="text-transform:uppercase;">
                        @error('code')<div class="pm-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="pm-field">
                        <label>Name <span class="req">*</span></label>
                        <input type="text" wire:model="name" placeholder="e.g. April 2025 Payroll">
                        @error('name')<div class="pm-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="pm-field">
                    <label>Description</label>
                    <textarea wire:model="description" placeholder="Optional notes about this payroll period…"></textarea>
                    @error('description')<div class="pm-field-err">{{ $message }}</div>@enderror
                </div>

                {{-- Project --}}
                <div class="pm-field">
                    <label>Project <span class="req">*</span></label>
                    <select wire:model="projectId">
                        <option value="">Select project...</option>
                        @foreach($this->projects as $project)
                            <option value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                        @endforeach
                    </select>
                    @error('projectId')<div class="pm-field-err">{{ $message }}</div>@enderror
                </div>

                {{-- Dates --}}
                <div class="pm-section-label">Period Dates</div>
                <div class="pm-grid2">
                    <div class="pm-field">
                        <label>Start Date <span class="req">*</span></label>
                        <input type="date" wire:model="startDate">
                        @error('startDate')<div class="pm-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="pm-field">
                        <label>End Date <span class="req">*</span></label>
                        <input type="date" wire:model="endDate">
                        @error('endDate')<div class="pm-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Approval status --}}
                <div class="pm-field">
                    <label>Approval Status <span class="req">*</span></label>
                    <select wire:model="approvalStatus">
                        @foreach($approvalStatuses as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('approvalStatus')<div class="pm-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="pm-modal-footer">
                <button class="pm-btn pm-btn-outline" wire:click="closeModal">Cancel</button>
                <button class="pm-btn pm-btn-primary" wire:click="save" wire:loading.attr="disabled">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update' : 'Create' }} Payroll Month</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>
    </div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewRecord)
    <div class="pm-modal-bg" wire:click.self="closeView">
        <div class="pm-modal pm-modal-lg">

            <div class="pm-modal-hd">
                <div class="pm-modal-hd-left">
                    <div class="pm-modal-hd-icon">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <div>
                        <div class="pm-modal-title">{{ $viewRecord->name }}</div>
                        <div class="pm-modal-sub">{{ $viewRecord->code }}</div>
                    </div>
                </div>
                <button class="pm-modal-close" wire:click="closeView">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="pm-modal-body">
                @php
                    $vSt = $viewRecord->approval_status instanceof \BackedEnum
                        ? $viewRecord->approval_status->value : ($viewRecord->approval_status ?? 'draft');
                    $vStClass = match ($vSt) {
                        'approved' => 'pb-green',
                        'pending' => 'pb-amber',
                        'rejected' => 'pb-red',
                        'cancelled' => 'pb-red',
                        default => 'pb-gray',
                    };
                @endphp
                <div class="pm-view-grid">
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">Code</div>
                        <div class="pm-view-val"><span class="pm-code">{{ $viewRecord->code }}</span></div>
                    </div>
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">Approval Status</div>
                        <div class="pm-view-val"><span class="pm-badge {{ $vStClass }}">{{ ucfirst($vSt) }}</span></div>
                    </div>
                    <div class="pm-view-row full">
                        <div class="pm-view-lbl">Name</div>
                        <div class="pm-view-val">{{ $viewRecord->name }}</div>
                    </div>
                    @if($viewRecord->description)
                        <div class="pm-view-row full">
                            <div class="pm-view-lbl">Description</div>
                            <div class="pm-view-val" style="font-size:13px;color:var(--ink3);">{{ $viewRecord->description }}</div>
                        </div>
                    @endif
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">Start Date</div>
                        <div class="pm-view-val">{{ \Carbon\Carbon::parse($viewRecord->start_date)->format('l, M d, Y') }}</div>
                    </div>
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">End Date</div>
                        <div class="pm-view-val">{{ \Carbon\Carbon::parse($viewRecord->end_date)->format('l, M d, Y') }}</div>
                    </div>
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">Duration</div>
                        <div class="pm-view-val">{{ \Carbon\Carbon::parse($viewRecord->start_date)->diffInDays(\Carbon\Carbon::parse($viewRecord->end_date)) + 1 }} days</div>
                    </div>
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">Payroll Entries</div>
                        <div class="pm-view-val"><span class="pm-badge pb-blue">{{ $viewRecord->payrollEntries?->count() ?? 0 }} entries</span></div>
                    </div>
                    <div class="pm-view-row">
                        <div class="pm-view-lbl">Created</div>
                        <div class="pm-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->created_at)->format('M d, Y · H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="pm-modal-footer">
                <button class="pm-btn pm-btn-outline" wire:click="closeView">Close</button>
                <button class="pm-btn pm-btn-ghost" wire:click="openEdit('{{ $viewRecord->id }}'); closeView()">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </button>
                @if($vSt !== 'approved')
                    <button class="pm-btn pm-btn-green" wire:click="approve('{{ $viewRecord->id }}'); closeView()"
                            wire:confirm="Approve this payroll month?">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Approve
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif

{{-- ══ DELETE CONFIRM ══════════════════════════════════════ --}}
@if($showDelete)
    <div class="pm-modal-bg" wire:click.self="cancelDelete">
        <div class="pm-modal pm-del-modal">
            <div class="pm-del-body">
                <div class="pm-del-icon">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                </div>
                <div class="pm-del-ttl">Delete Payroll Month?</div>
                <div class="pm-del-sub">This will permanently remove the payroll month and cannot be undone. Months with linked entries cannot be deleted.</div>
            </div>
            <div class="pm-modal-footer" style="justify-content:center;gap:12px;">
                <button class="pm-btn pm-btn-outline" wire:click="cancelDelete">Cancel</button>
                <button class="pm-btn pm-btn-danger" wire:click="deleteRecord" wire:loading.attr="disabled">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                    <span wire:loading.remove wire:target="deleteRecord">Yes, Delete</span>
                    <span wire:loading wire:target="deleteRecord">Deleting…</span>
                </button>
            </div>
        </div>
    </div>
@endif

</div>{{-- /pm-root --}}