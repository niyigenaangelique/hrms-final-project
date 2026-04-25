<div class="lv-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.lv-root {
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
    --r:        14px;
    --r-lg:     20px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    padding: 28px 28px 110px;
    display: flex;
    flex-direction: column;
    gap: 22px;
}

/* ══ Flash ═══════════════════════════════════════════════ */
.lv-flash {
    padding: 13px 18px; border-radius: var(--r);
    font-size: 13.5px; font-weight: 600;
    display: flex; align-items: center; gap: 9px;
}
.lv-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.lv-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.lv-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.lv-hero {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.lv-hero-cover {
    height: 72px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.lv-hero-cover::before {
    content:''; position:absolute; top:-30px; right:80px;
    width:180px; height:180px; border-radius:50%;
    background:rgba(255,255,255,0.06);
}
.lv-hero-cover::after {
    content:''; position:absolute; bottom:-20px; left:30px;
    width:100px; height:100px; border-radius:50%;
    background:rgba(255,255,255,0.04);
}
.lv-hero-body {
    padding: 0 26px 22px;
    display: flex; align-items: flex-end; justify-content: space-between; gap:16px;
    margin-top: -0px;
}
.lv-hero-icon {
    width: 56px; height: 56px; border-radius: 16px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white);
    box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.lv-hero-icon svg { width: 24px; height: 24px; stroke: #fff; fill: none; stroke-width: 1.75; }
.lv-hero-text { padding-bottom: 2px; }
.lv-hero-title { font-family:'Sora',sans-serif; font-size: 20px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.lv-hero-sub   { font-size: 13px; color: var(--ink3); font-weight: 500; }

/* ══ LEAVE BALANCE SECTION ═══════════════════════════════ */
.lv-balances {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1px;
    background: var(--border);
    border-radius: 0 0 var(--r-lg) var(--r-lg);
    overflow: hidden;
}
.lv-balance-card {
    background: var(--white);
    padding: 18px 20px 16px;
    display: flex; flex-direction: column; gap: 8px;
    transition: background 0.15s;
}
.lv-balance-card:hover { background: #FAFBFF; }

.lv-balance-icon-row { display: flex; align-items: center; gap: 10px; margin-bottom: 2px; }
.lv-balance-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.lv-balance-icon svg { width: 17px; height: 17px; stroke: var(--blue); fill: none; stroke-width: 2; }

.lv-balance-name { font-size: 13.5px; font-weight: 700; color: var(--ink2); }
.lv-balance-desc { font-size: 11.5px; color: var(--ink4); font-weight: 500; line-height: 1.45; }

.lv-balance-pills { display: flex; gap: 5px; flex-wrap: wrap; }
.lv-pill {
    font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 100px;
    display: inline-flex; align-items: center; gap: 4px;
}
.lv-pill svg { width: 9px; height: 9px; stroke: currentColor; fill: none; stroke-width: 2.5; }
.lv-pill-blue  { background: var(--blue-lt);  color: var(--blue-2); border: 1px solid var(--blue-brd); }
.lv-pill-green { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }
.lv-pill-amber { background: var(--amber-lt); color: #92400E; border: 1px solid rgba(245,158,11,0.22); }
.lv-pill-gray  { background: var(--bg);        color: var(--ink3); border: 1px solid var(--border); }

/* ══ MAIN GRID: form left, status right ══════════════════ */
.lv-main-grid {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 22px;
    align-items: start;
}

/* ══ SHARED CARD ═════════════════════════════════════════ */
.lv-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.lv-card-hd {
    padding: 18px 22px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
.lv-card-hd-left { display: flex; align-items: center; gap: 10px; }
.lv-card-hd-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    display: flex; align-items: center; justify-content: center;
}
.lv-card-hd-icon svg { width: 16px; height: 16px; stroke: var(--blue); fill: none; stroke-width: 2; }
.lv-card-title { font-family:'Sora',sans-serif; font-size: 15px; font-weight: 800; color: var(--ink); }
.lv-card-sub   { font-size: 12px; color: var(--ink4); font-weight: 500; margin-top: 1px; }
.lv-card-body  { padding: 22px; }

/* ══ FORM FIELDS ═════════════════════════════════════════ */
.lv-fields { display: flex; flex-direction: column; gap: 14px; }
.lv-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

.lv-field { display: flex; flex-direction: column; gap: 5px; }
.lv-field label {
    font-size: 10.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--ink4);
}
.lv-field input,
.lv-field select,
.lv-field textarea {
    width: 100%; padding: 10px 13px;
    background: #F6F8FC;
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    -webkit-appearance: none;
}
.lv-field input:focus,
.lv-field select:focus,
.lv-field textarea:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59,111,232,0.09);
    background: var(--white);
}
.lv-field textarea { resize: vertical; min-height: 100px; }
.lv-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    padding-right: 34px;
}
.lv-field-error { font-size: 11.5px; color: var(--red); font-weight: 600; }

/* ── Date picker with icon ─────────────────────────────── */
.lv-date-wrap { position: relative; }
.lv-date-wrap input { padding-left: 36px; }
.lv-date-icon {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; stroke: var(--ink4); fill: none; stroke-width: 2;
    pointer-events: none;
}

/* ── Summary strip ─────────────────────────────────────── */
.lv-summary-strip {
    display: flex; align-items: center; gap: 10px;
    background: var(--blue-lt);
    border: 1px solid var(--blue-brd);
    border-radius: var(--r);
    padding: 11px 14px;
    margin-top: 4px;
}
.lv-summary-strip svg { width: 16px; height: 16px; stroke: var(--blue); fill: none; stroke-width: 2; flex-shrink: 0; }
.lv-summary-text { font-size: 13px; font-weight: 600; color: var(--blue-2); }

/* ══ SUBMIT BUTTON ═══════════════════════════════════════ */
.lv-submit-row { margin-top: 18px; }
.lv-btn-submit {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px;
    background: var(--blue);
    color: #fff; border: none; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 14px rgba(59,111,232,0.30);
    transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
    width: 100%; justify-content: center;
}
.lv-btn-submit:hover { background: var(--blue-2); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(59,111,232,0.38); }
.lv-btn-submit:active { transform: scale(0.98); }
.lv-btn-submit svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; }

/* ══ LEAVE STATUS TABLE ══════════════════════════════════ */
.lv-table-wrap { overflow-x: auto; }
table.lv-table { width: 100%; border-collapse: collapse; }
.lv-table thead tr { border-bottom: 1px solid var(--border); }
.lv-table th {
    padding: 10px 14px;
    font-size: 10.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--ink4); text-align: left; white-space: nowrap;
}
.lv-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background 0.12s;
}
.lv-table tbody tr:last-child { border-bottom: none; }
.lv-table tbody tr:hover { background: #F8FAFF; }
.lv-table td { padding: 13px 14px; font-size: 13px; font-weight: 500; color: var(--ink2); white-space: nowrap; }
.lv-table td.muted { color: var(--ink4); font-size: 12px; }
.lv-table td.bold { font-weight: 700; color: var(--ink); }

/* ── Status badges ─────────────────────────────────────── */
.lv-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 100px;
    font-size: 11.5px; font-weight: 700;
}
.lv-badge svg { width: 8px; height: 8px; stroke: currentColor; fill: currentColor; }
.lv-badge-green  { background: var(--green-lt);  color: #087A42; }
.lv-badge-amber  { background: var(--amber-lt);  color: #92400E; }
.lv-badge-red    { background: var(--red-lt);    color: #991B1B; }
.lv-badge-gray   { background: var(--bg);         color: var(--ink3); border: 1px solid var(--border); }

/* ── View button ───────────────────────────────────────── */
.lv-btn-view {
    font-size: 12px; font-weight: 700; color: var(--blue);
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    border-radius: 8px; padding: 5px 12px; cursor: pointer;
    font-family: 'DM Sans', sans-serif; transition: background 0.15s;
}
.lv-btn-view:hover { background: var(--blue-mid); }

/* ── Empty state ───────────────────────────────────────── */
.lv-empty { text-align: center; padding: 44px 20px; }
.lv-empty svg { width: 36px; height: 36px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 12px; display: block; opacity: 0.4; }
.lv-empty-title { font-size: 15px; font-weight: 700; color: var(--ink3); margin-bottom: 4px; }
.lv-empty-sub { font-size: 13px; color: var(--ink4); font-weight: 500; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.lv-modal-bg {
    position: fixed; inset: 0;
    background: rgba(15,22,41,0.45);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center; padding: 16px;
}
.lv-modal {
    background: var(--white);
    border-radius: var(--r-lg);
    box-shadow: 0 24px 64px rgba(15,22,41,0.22);
    border: 1px solid var(--border);
    width: 100%; max-width: 480px;
    overflow: hidden;
}
.lv-modal-hd {
    background: linear-gradient(105deg, var(--blue-3), var(--blue));
    padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between;
}
.lv-modal-title { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: #fff; }
.lv-modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(255,255,255,0.18); border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s;
}
.lv-modal-close:hover { background: rgba(255,255,255,0.28); }
.lv-modal-close svg { width: 14px; height: 14px; stroke: #fff; fill: none; stroke-width: 2.5; }
.lv-modal-body { padding: 22px 24px; display: flex; flex-direction: column; gap: 0; }
.lv-modal-row {
    display: flex; flex-direction: column; gap: 3px;
    padding: 12px 0; border-bottom: 1px solid var(--border);
}
.lv-modal-row:last-child { border-bottom: none; }
.lv-modal-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); }
.lv-modal-value { font-size: 14px; font-weight: 700; color: var(--ink2); }
.lv-modal-prose { font-size: 13.5px; font-weight: 500; color: var(--ink3); line-height: 1.6; }
.lv-modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; }

/* ══ FLOATING NAV ════════════════════════════════════════ */
.ios-nav {
    position: fixed; bottom: 22px; left: 50%;
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
    padding: 7px 16px; border-radius: 18px; text-decoration: none;
    font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.40);
    letter-spacing: 0.04em; min-width: 58px; position: relative;
    transition: background 0.18s, color 0.18s, transform 0.14s;
}
.ios-nav-item svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.8; }
.ios-nav-item:hover { color: rgba(255,255,255,0.82); background: rgba(255,255,255,0.07); transform: translateY(-1px); }
.ios-nav-item.active { color: #fff; background: rgba(59,111,232,0.25); }
.ios-nav-item.active svg { stroke: #93C5FD; }
.ios-nav-active-dot { position: absolute; bottom: 3px; width: 4px; height: 4px; border-radius: 50%; background: #60A5FA; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .lv-main-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .lv-root { padding: 16px 14px 100px; gap: 16px; }
    .lv-field-row { grid-template-columns: 1fr; }
    .lv-balances { grid-template-columns: 1fr 1fr; }
    .ios-nav-item { padding: 7px 11px; min-width: 48px; font-size: 9px; }
}
</style>

{{-- Flash --}}
@if(session()->has('success'))
    <div class="lv-flash lv-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="lv-flash lv-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ PAGE HERO + LEAVE BALANCES ══════════════════════════ --}}
<div class="lv-hero">
    <div class="lv-hero-cover"></div>
    <div class="lv-hero-body">
        <div style="display:flex;align-items:flex-end;gap:14px;">
            <div class="lv-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="lv-hero-text">
                <div class="lv-hero-title">Leave Management</div>
                <div class="lv-hero-sub">Request leave and track your applications in one place</div>
            </div>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;padding-bottom:2px;">
            @php
                $totalTypes = $leaveTypes->count();
                $pendingCount = isset($leaveRequests) ? $leaveRequests->filter(fn($r) => $r->status->value === 'pending')->count() : 0;
                $approvedCount = isset($leaveRequests) ? $leaveRequests->filter(fn($r) => $r->status->value === 'approved')->count() : 0;
            @endphp
            @if($pendingCount > 0)
                <span class="lv-pill lv-pill-amber">{{ $pendingCount }} pending</span>
            @endif
            @if($approvedCount > 0)
                <span class="lv-pill lv-pill-green">{{ $approvedCount }} approved</span>
            @endif
        </div>
    </div>

    {{-- Leave type balance cards --}}
    <div class="lv-balances">
        @foreach($leaveTypes as $leaveType)
            <div class="lv-balance-card">
                <div class="lv-balance-icon-row">
                    <div class="lv-balance-icon">
                        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span class="lv-balance-name">{{ $leaveType->name }}</span>
                </div>
                @if($leaveType->description)
                    <div class="lv-balance-desc">{{ Str::limit($leaveType->description, 60) }}</div>
                @endif
                <div class="lv-balance-pills">
                    @if($leaveType->requires_approval)
                        <span class="lv-pill lv-pill-amber">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Needs approval
                        </span>
                    @else
                        <span class="lv-pill lv-pill-green">
                            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Auto-approved
                        </span>
                    @endif
                    @if($leaveType->allow_carry_forward)
                        <span class="lv-pill lv-pill-blue">
                            +{{ $leaveType->max_carry_forward_days }}d carry
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- ══ MAIN GRID: Request Left · Status Right ══════════════ --}}
<div class="lv-main-grid">

    {{-- ── LEFT: Request Leave ──────────────────────────── --}}
    <div class="lv-card">
        <div class="lv-card-hd">
            <div class="lv-card-hd-left">
                <div class="lv-card-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <div class="lv-card-title">Request Leave</div>
                    <div class="lv-card-sub">Fill in the details below to submit</div>
                </div>
            </div>
        </div>
        <div class="lv-card-body">
            <form wire:submit="submit">
                <div class="lv-fields">

                    {{-- Leave type --}}
                    <div class="lv-field">
                        <label>Leave Type</label>
                        <select wire:model.live="leave_type_id">
                            <option value="">Select leave type…</option>
                            @foreach($leaveTypes as $lt)
                                <option value="{{ $lt->id }}">{{ $lt->name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id') <span class="lv-field-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Dates --}}
                    <div class="lv-field-row">
                        <div class="lv-field">
                            <label>Start Date</label>
                            <div class="lv-date-wrap">
                                <svg class="lv-date-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <input type="date" wire:model.live="start_date">
                            </div>
                            @error('start_date') <span class="lv-field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="lv-field">
                            <label>End Date</label>
                            <div class="lv-date-wrap">
                                <svg class="lv-date-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <input type="date" wire:model.live="end_date">
                            </div>
                            @error('end_date') <span class="lv-field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Duration summary --}}
                    @if(isset($start_date) && isset($end_date) && $start_date && $end_date)
                        @php
                            try {
                                $startD = \Carbon\Carbon::parse($start_date);
                                $endD   = \Carbon\Carbon::parse($end_date);
                                $days   = $endD->diffInDays($startD) + 1;
                            } catch(\Exception $e) { $days = null; }
                        @endphp
                        @if(isset($days) && $days > 0)
                            <div class="lv-summary-strip">
                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span class="lv-summary-text">{{ $days }} {{ $days === 1 ? 'day' : 'days' }} of leave requested</span>
                            </div>
                        @endif
                    @endif

                    {{-- Reason --}}
                    <div class="lv-field">
                        <label>Reason</label>
                        <textarea wire:model="reason" placeholder="Please describe the reason for your leave request…"></textarea>
                        @error('reason') <span class="lv-field-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Document Upload (Medical) --}}
                    @php
                        $selType = $leaveTypes->firstWhere('id', $leave_type_id);
                    @endphp
                    @if($selType && $selType->requires_medical_document)
                        <div class="lv-field">
                            <label>Medical Document / Evidence (Required)</label>
                            <input type="file" wire:model="attachment" class="lv-file-input">
                            <div style="font-size:11px;color:var(--ink4);margin-top:4px;">Please upload a doctor's note or medical report (PDF, JPG, PNG)</div>
                            @error('attachment') <span class="lv-field-error">{{ $message }}</span> @enderror
                            <div wire:loading wire:target="attachment" style="font-size:11px;color:var(--blue);margin-top:4px;">Uploading...</div>
                        </div>
                    @endif

                </div>

                <div class="lv-submit-row">
                    <button type="submit" class="lv-btn-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">
                            <svg viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Submit Leave Request
                        </span>
                        <span wire:loading wire:target="submit">Processing...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── RIGHT: Leave Status ───────────────────────────── --}}
    <div class="lv-card">
        <div class="lv-card-hd">
            <div class="lv-card-hd-left">
                <div class="lv-card-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <div>
                    <div class="lv-card-title">Leave Status</div>
                    <div class="lv-card-sub">
                        {{ isset($leaveRequests) ? $leaveRequests->count() : '0' }} request(s) submitted
                    </div>
                </div>
            </div>
        </div>

        @if(isset($leaveRequests) && $leaveRequests->count() > 0)
            <div class="lv-table-wrap">
                <table class="lv-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $req)
                            @php
                                $sv = $req->status->value;
                                $bc = match($sv) {
                                    'approved' => 'lv-badge-green',
                                    'pending'  => 'lv-badge-amber',
                                    'rejected' => 'lv-badge-red',
                                    default    => 'lv-badge-gray',
                                };
                                $d = $req->start_date && $req->end_date
                                    ? $req->start_date->diffInDays($req->end_date) + 1
                                    : null;
                            @endphp
                            <tr>
                                <td class="bold">
                                    {{ $req->leaveType->name ?? 'N/A' }}
                                    @if($req->attachment_path)
                                        <svg style="width:12px;height:12px;stroke:var(--ink4);fill:none;margin-left:4px;" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    @endif
                                </td>
                                <td class="muted">
                                    {{ $req->start_date?->format('M d') }}
                                    @if($req->end_date && $req->end_date->ne($req->start_date))
                                        – {{ $req->end_date?->format('M d, Y') }}
                                    @else
                                        {{ $req->start_date?->format(', Y') }}
                                    @endif
                                </td>
                                <td style="font-weight:700;color:var(--blue-2);">{{ $d ? $d.'d' : '—' }}</td>
                                <td>
                                    <span class="lv-badge {{ $bc }}">
                                        <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                                        {{ ucfirst($sv) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="lv-btn-view" wire:click="viewRequest('{{ $req->id }}')">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="lv-card-body">
                <div class="lv-empty">
                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <div class="lv-empty-title">No requests yet</div>
                    <div class="lv-empty-sub">Submit your first leave request using the form on the left.</div>
                </div>
            </div>
        @endif
    </div>

</div>{{-- /lv-main-grid --}}

{{-- ══ DETAIL MODAL ════════════════════════════════════════ --}}
@if(isset($selectedRequest) && $selectedRequest)
    @php
        $ms  = $selectedRequest->status->value;
        $mbc = match($ms) {
            'approved' => 'lv-badge-green',
            'pending'  => 'lv-badge-amber',
            'rejected' => 'lv-badge-red',
            default    => 'lv-badge-gray',
        };
        $md = $selectedRequest->start_date && $selectedRequest->end_date
            ? $selectedRequest->start_date->diffInDays($selectedRequest->end_date) + 1
            : null;
    @endphp
    <div class="lv-modal-bg" wire:click="closeModal">
        <div class="lv-modal" wire:click.stop>
            <div class="lv-modal-hd">
                <div class="lv-modal-title">Leave Request Details</div>
                <button class="lv-modal-close" wire:click="closeModal">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="lv-modal-body">
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Leave Type</span>
                    <span class="lv-modal-value">{{ $selectedRequest->leaveType->name ?? 'N/A' }}</span>
                </div>
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Period</span>
                    <span class="lv-modal-value">
                        {{ $selectedRequest->start_date?->format('M d, Y') }}
                        —
                        {{ $selectedRequest->end_date?->format('M d, Y') }}
                    </span>
                </div>
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Duration</span>
                    <span class="lv-modal-value">{{ $md ? $md . ' ' . ($md === 1 ? 'day' : 'days') : 'N/A' }}</span>
                </div>
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Reason</span>
                    <p class="lv-modal-prose">{{ $selectedRequest->reason }}</p>
                </div>
                @if($selectedRequest->attachment_path)
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Attachment</span>
                    <a href="{{ Storage::url($selectedRequest->attachment_path) }}" target="_blank" class="lv-btn-view" style="margin-top:6px;display:inline-flex;align-items:center;gap:6px;text-decoration:none;">
                        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                        View Medical Document
                    </a>
                </div>
                @endif
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Status</span>
                    <span class="lv-badge {{ $mbc }}" style="margin-top:4px;">
                        <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                        {{ ucfirst($ms) }}
                    </span>
                </div>
                <div class="lv-modal-row">
                    <span class="lv-modal-label">Applied On</span>
                    <span class="lv-modal-value">{{ $selectedRequest->created_at?->format('M d, Y · H:i') }}</span>
                </div>
            </div>
            <div class="lv-modal-footer">
                <button class="lv-btn-view" wire:click="closeModal" style="padding:8px 20px;font-size:13px;">Close</button>
            </div>
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
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Leave
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="{{ route('employee.communication') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Messages
    </a>
</nav>

</div>{{-- /lv-root --}}