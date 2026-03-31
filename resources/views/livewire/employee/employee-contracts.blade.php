<div class="ctr-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ TOKENS ══════════════════════════════════════════════ */
.ctr-root {
    --blue:     #3B6FE8;
    --blue-2:   #2755CC;
    --blue-3:   #1A3FA8;
    --blue-lt:  rgba(59,111,232,0.09);
    --blue-mid: rgba(59,111,232,0.18);
    --indigo:   #6B4FDB;
    --green:    #12B76A;
    --green-lt: rgba(18,183,106,0.10);
    --amber:    #F59E0B;
    --amber-lt: rgba(245,158,11,0.10);
    --red:      #EF4444;
    --red-lt:   rgba(239,68,68,0.10);
    --bg:       #F0F4FA;
    --white:    #FFFFFF;
    --ink:      #0F1629;
    --ink2:     #2D3356;
    --ink3:     #6B7094;
    --ink4:     #A8ADCA;
    --border:   rgba(15,22,41,0.08);
    --shadow:   0 2px 10px rgba(59,111,232,0.08);
    --shadow-md:0 6px 24px rgba(59,111,232,0.11);
    --r:        14px;
    --r-lg:     20px;

    font-family: 'DM Sans', -apple-system, sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    padding: 28px 32px 110px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

/* ══ PAGE HEADER ═════════════════════════════════════════ */
.ctr-pg-hd {
    display: flex; align-items: center; justify-content: space-between;
}
.ctr-pg-title {
    font-family: 'Sora', sans-serif;
    font-size: 24px; font-weight: 800; color: var(--ink);
    letter-spacing: -0.3px; margin: 0;
}
.ctr-pg-sub { font-size: 13.5px; color: var(--ink3); font-weight: 500; margin: 3px 0 0; }

/* ══ EMPTY STATE ═════════════════════════════════════════ */
.ctr-empty {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    text-align: center;
    padding: 72px 24px;
}
.ctr-empty-icon {
    width: 60px; height: 60px; margin: 0 auto 18px;
    background: var(--blue-lt); border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
}
.ctr-empty-icon svg { width: 28px; height: 28px; stroke: var(--blue); fill: none; stroke-width: 1.8; }
.ctr-empty-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: var(--ink); margin: 0 0 6px; }
.ctr-empty-sub   { font-size: 14px; color: var(--ink3); font-weight: 500; margin: 0; }

/* ══ CONTRACT CARD ═══════════════════════════════════════ */
.ctr-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: box-shadow 0.15s;
}

/* ── Contract header banner ── */
.ctr-card-banner {
    background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 38%, #3B6FE8 70%, #6B4FDB 100%);
    padding: 22px 28px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}
.ctr-card-banner::before {
    content: '';
    position: absolute; top: -50px; right: 120px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(255,255,255,0.06); pointer-events: none;
}
.ctr-card-banner::after {
    content: '';
    position: absolute; bottom: -40px; left: 40px;
    width: 130px; height: 130px; border-radius: 50%;
    background: rgba(255,255,255,0.04); pointer-events: none;
}
.ctr-banner-left { position: relative; z-index: 1; }
.ctr-banner-label {
    font-size: 11px; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.12em; color: rgba(255,255,255,0.60); margin-bottom: 4px;
}
.ctr-banner-code {
    font-family: 'Sora', sans-serif;
    font-size: 22px; font-weight: 900; color: #fff;
    letter-spacing: -0.3px; margin-bottom: 8px;
}
.ctr-banner-chips { display: flex; gap: 8px; flex-wrap: wrap; }
.ctr-banner-chip {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 100px; padding: 4px 11px;
    font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.90);
}
.ctr-banner-chip svg { width: 11px; height: 11px; stroke: rgba(255,255,255,0.75); fill: none; stroke-width: 2; }

.ctr-banner-right {
    display: flex; flex-direction: column; align-items: flex-end; gap: 10px;
    position: relative; z-index: 1;
}
.ctr-banner-status {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 100px;
    font-size: 12.5px; font-weight: 800;
}
.ctr-banner-actions { display: flex; gap: 8px; }

/* ── Buttons ── */
.ctr-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    border: none; cursor: pointer; transition: all 0.15s;
}
.ctr-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.ctr-btn-white {
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.30);
    color: #fff;
}
.ctr-btn-white:hover { background: rgba(255,255,255,0.28); }
.ctr-btn-solid {
    background: #fff; color: var(--blue-2);
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
}
.ctr-btn-solid:hover { background: #F0F4FA; }
.ctr-btn-blue { background: var(--blue); color: #fff; box-shadow: 0 4px 14px rgba(59,111,232,0.28); }
.ctr-btn-blue:hover { background: var(--blue-2); transform: translateY(-1px); }
.ctr-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.ctr-btn-outline:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }

/* ── Two-column body ── */
.ctr-body { padding: 24px 28px; }
.ctr-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
.ctr-3col {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 16px;
    margin-bottom: 0;
}

/* ── Section panels ── */
.ctr-panel {
    background: var(--bg);
    border-radius: var(--r);
    border: 1px solid var(--border);
    padding: 18px 20px;
}
.ctr-panel-hd {
    display: flex; align-items: center; gap: 7px;
    margin-bottom: 16px; padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
}
.ctr-panel-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ctr-panel-icon svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
.ctr-panel-title {
    font-family: 'Sora', sans-serif;
    font-size: 12.5px; font-weight: 800; color: var(--ink2);
    text-transform: uppercase; letter-spacing: 0.07em;
}

/* ── Field rows inside panels ── */
.ctr-field {
    display: flex; align-items: baseline;
    justify-content: space-between;
    padding: 7px 0;
    border-bottom: 1px solid rgba(15,22,41,0.05);
    gap: 12px;
}
.ctr-field:last-child { border-bottom: none; padding-bottom: 0; }
.ctr-field:first-child { padding-top: 0; }
.ctr-field-label {
    font-size: 11.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--ink4); flex-shrink: 0;
}
.ctr-field-val {
    font-size: 13.5px; font-weight: 700; color: var(--ink2);
    text-align: right; word-break: break-word;
}
.ctr-field-val-dash { color: var(--ink4) !important; font-weight: 500 !important; }
.ctr-field-val-green { color: #087A42 !important; font-family: 'Sora', sans-serif; font-size: 15px !important; }
.ctr-field-val-blue  { color: var(--blue-2) !important; }

/* ── Status badges ── */
.ctr-badge {
    display: inline-flex; align-items: center;
    padding: 3px 11px; border-radius: 100px;
    font-size: 11.5px; font-weight: 800;
}
.ctr-badge-green  { background: var(--green-lt);  color: #087A42; }
.ctr-badge-blue   { background: var(--blue-lt);   color: var(--blue-2); }
.ctr-badge-amber  { background: var(--amber-lt);  color: #92400E; }
.ctr-badge-red    { background: var(--red-lt);    color: #991B1B; }
.ctr-badge-gray   { background: var(--bg);        color: var(--ink3); border: 1px solid var(--border); }

/* Banner status colours */
.ctr-status-active     { background: rgba(18,183,106,0.25);  color: #A7F3D0; }
.ctr-status-expired    { background: rgba(239,68,68,0.25);   color: #FCA5A5; }
.ctr-status-pending    { background: rgba(245,158,11,0.25);  color: #FDE68A; }
.ctr-status-terminated { background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.70); }
.ctr-status-default    { background: rgba(255,255,255,0.15); color: #fff; }

/* ── Divider ── */
.ctr-divider { height: 1px; background: var(--border); margin: 16px 0; }

/* ══ PDF PRINT MODAL ═════════════════════════════════════ */
.ctr-modal-bg {
    position: fixed; inset: 0;
    background: rgba(15,22,41,0.50);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
}
.ctr-modal {
    background: var(--white);
    border-radius: var(--r-lg);
    box-shadow: 0 24px 64px rgba(15,22,41,0.20);
    border: 1px solid var(--border);
    width: 100%; max-width: 720px;
    max-height: 90vh; overflow-y: auto;
}
.ctr-modal-hd {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 24px; border-bottom: 1px solid var(--border);
    position: sticky; top: 0; background: var(--white); z-index: 1;
}
.ctr-modal-title {
    font-family: 'Sora', sans-serif;
    font-size: 16px; font-weight: 800; color: var(--ink);
}
.ctr-modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s; color: var(--ink3);
}
.ctr-modal-close:hover { background: var(--red-lt); color: var(--red); border-color: rgba(239,68,68,0.22); }
.ctr-modal-close svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; }
.ctr-modal-body  { padding: 24px; }
.ctr-modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 16px 24px; border-top: 1px solid var(--border);
}

/* PDF preview area */
.ctr-pdf-preview {
    background: var(--bg);
    border-radius: var(--r);
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 20px;
}

/* PDF page (A4 proportions, scaled for preview) */
.ctr-pdf-page {
    background: #fff;
    margin: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 16px rgba(15,22,41,0.10);
    padding: 40px;
    font-family: 'DM Sans', sans-serif;
    color: #0F1629;
    font-size: 13px;
    line-height: 1.6;
}

/* PDF header */
.ctr-pdf-top {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 28px; padding-bottom: 20px;
    border-bottom: 2px solid #3B6FE8;
}
.ctr-pdf-logo-mark {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #3B6FE8, #6B4FDB);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 6px;
}
.ctr-pdf-logo-mark svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
.ctr-pdf-org-name { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 800; color: #0F1629; }
.ctr-pdf-org-sub  { font-size: 11px; color: #6B7094; font-weight: 600; margin-top: 1px; }
.ctr-pdf-doc-type {
    text-align: right;
}
.ctr-pdf-doc-label { font-size: 11px; color: #6B7094; font-weight: 700; text-transform: uppercase; letter-spacing: 0.09em; }
.ctr-pdf-doc-code  { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 900; color: #3B6FE8; margin-top: 2px; }

/* PDF section */
.ctr-pdf-section { margin-bottom: 20px; }
.ctr-pdf-section-title {
    font-size: 10px; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.10em; color: #6B7094;
    margin-bottom: 10px; padding-bottom: 6px;
    border-bottom: 1px solid #E8EEF8;
    display: flex; align-items: center; gap: 6px;
}
.ctr-pdf-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 20px;
}
.ctr-pdf-grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 8px 16px;
}
.ctr-pdf-field { }
.ctr-pdf-label { font-size: 10px; font-weight: 700; color: #A8ADCA; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 2px; }
.ctr-pdf-value { font-size: 12.5px; font-weight: 700; color: #2D3356; }
.ctr-pdf-value-green { color: #087A42; font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800; }

/* Signature row */
.ctr-pdf-sigs {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 20px; margin-top: 28px;
}
.ctr-pdf-sig {
    padding-top: 48px;
    border-top: 1.5px solid #2755CC;
}
.ctr-pdf-sig-label { font-size: 11px; font-weight: 700; color: #6B7094; margin-bottom: 2px; }
.ctr-pdf-sig-name  { font-size: 13px; font-weight: 700; color: #0F1629; }

/* PDF badge */
.ctr-pdf-badge {
    display: inline-flex; padding: 2px 10px; border-radius: 100px;
    font-size: 11px; font-weight: 800;
}
.ctr-pdf-badge-green  { background: rgba(18,183,106,0.12);  color: #087A42; }
.ctr-pdf-badge-red    { background: rgba(239,68,68,0.12);   color: #991B1B; }
.ctr-pdf-badge-amber  { background: rgba(245,158,11,0.12);  color: #92400E; }
.ctr-pdf-badge-gray   { background: #F0F4FA; color: #6B7094; }
.ctr-pdf-badge-blue   { background: rgba(59,111,232,0.10);  color: #2755CC; }

/* Modify PDF settings */
.ctr-pdf-settings { display: flex; flex-direction: column; gap: 12px; }
.ctr-pdf-setting-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.ctr-pdf-field-set { }
.ctr-pdf-field-set label {
    display: block; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--ink4); margin-bottom: 5px;
}
.ctr-pdf-field-set input,
.ctr-pdf-field-set select {
    width: 100%; box-sizing: border-box;
    padding: 9px 13px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: var(--r); font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color 0.15s;
}
.ctr-pdf-field-set input:focus,
.ctr-pdf-field-set select:focus { border-color: var(--blue); background: var(--white); }
.ctr-pdf-toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px; background: var(--bg); border-radius: var(--r);
    border: 1px solid var(--border);
}
.ctr-pdf-toggle-lbl { font-size: 13px; font-weight: 700; color: var(--ink2); }
.ctr-pdf-toggle-sub { font-size: 11.5px; color: var(--ink4); font-weight: 500; }
.ctr-pdf-toggle-sw {
    width: 40px; height: 22px; border-radius: 100px; border: none;
    cursor: pointer; position: relative; flex-shrink: 0; transition: background 0.2s;
}
.ctr-pdf-toggle-sw.on  { background: var(--blue); }
.ctr-pdf-toggle-sw.off { background: var(--border); }
.ctr-pdf-toggle-sw::after {
    content: '';
    position: absolute; top: 3px;
    width: 16px; height: 16px; border-radius: 50%;
    background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    transition: left 0.2s;
}
.ctr-pdf-toggle-sw.on::after  { left: 20px; }
.ctr-pdf-toggle-sw.off::after { left: 3px; }

/* ══ NAV ═════════════════════════════════════════════════ */
.ctr-nav {
    position: fixed; bottom: 22px; left: 50%; transform: translateX(-50%);
    z-index: 200; display: flex; align-items: center; gap: 2px;
    background: rgba(15,22,41,0.88);
    backdrop-filter: blur(28px) saturate(2);
    -webkit-backdrop-filter: blur(28px) saturate(2);
    border: 1px solid rgba(255,255,255,0.11);
    border-radius: 26px; padding: 7px 10px;
    box-shadow: 0 20px 56px rgba(15,22,41,0.26), 0 4px 14px rgba(15,22,41,0.14),
                inset 0 1px 0 rgba(255,255,255,0.08);
}
.ctr-nav::before {
    content: '';
    position: absolute; top: 0; left: 20px; right: 20px; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
}
.ctr-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 8px 16px; border-radius: 18px; text-decoration: none;
    font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.40);
    letter-spacing: 0.04em; min-width: 62px; position: relative;
    transition: background 0.18s, color 0.18s, transform 0.14s;
}
.ctr-nav-item svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.8; transition: transform 0.18s; }
.ctr-nav-item:hover { color: rgba(255,255,255,0.82); background: rgba(255,255,255,0.07); transform: translateY(-1px); }
.ctr-nav-item:hover svg { transform: scale(1.08); }
.ctr-nav-item.active { color: #fff; background: rgba(59,111,232,0.28); }
.ctr-nav-item.active svg { stroke: #93C5FD; }
.ctr-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #60A5FA; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 900px) {
    .ctr-2col, .ctr-3col { grid-template-columns: 1fr; }
    .ctr-pdf-grid, .ctr-pdf-grid-3, .ctr-pdf-sigs { grid-template-columns: 1fr; }
    .ctr-pdf-setting-row { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .ctr-root { padding: 14px 14px 100px; gap: 14px; }
    .ctr-banner-right { flex-direction: row; align-items: center; }
    .ctr-nav { bottom: 12px; padding: 6px 8px; }
    .ctr-nav-item { padding: 7px 11px; min-width: 52px; font-size: 9px; }
    .ctr-nav-item svg { width: 17px; height: 17px; }
}

/* ══ PRINT STYLES ════════════════════════════════════════ */
@media print {
    .ctr-root { padding: 0; background: #fff; }
    .ctr-pg-hd, .ctr-nav, .ctr-modal-bg { display: none !important; }
    .ctr-card { box-shadow: none; border: none; }
    .ctr-card-banner { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .ctr-panel { background: #F8FAFF; border: 1px solid #E0E8F5; }
    .ctr-pdf-page { margin: 0; padding: 28px; box-shadow: none; }
}
</style>

{{-- ══ PAGE HEADER ══ --}}
<div class="ctr-pg-hd">
    <div>
        <h1 class="ctr-pg-title">My Contracts</h1>
        <p class="ctr-pg-sub">Detailed view of your employment contracts and compensation</p>
    </div>
</div>

{{-- ══ CONTRACT CARDS ══ --}}
@if($contracts && $contracts->count() > 0)
    @foreach($contracts as $contract)
        @php
            $s = $contract->status->value;
            $badgeCls = match($s) {
                'active'     => 'ctr-badge-green',
                'expired'    => 'ctr-badge-red',
                'pending'    => 'ctr-badge-amber',
                'terminated' => 'ctr-badge-gray',
                default      => 'ctr-badge-blue',
            };
            $bannerStatus = match($s) {
                'active'     => 'ctr-status-active',
                'expired'    => 'ctr-status-expired',
                'pending'    => 'ctr-status-pending',
                'terminated' => 'ctr-status-terminated',
                default      => 'ctr-status-default',
            };
            $as = $contract->approval_status->value ?? '';
            $approvalCls = match($as) {
                'approved' => 'ctr-badge-green',
                'rejected' => 'ctr-badge-red',
                'pending'  => 'ctr-badge-amber',
                default    => 'ctr-badge-gray',
            };
        @endphp

        <div class="ctr-card">

            {{-- ── Banner: contract header ── --}}
            <div class="ctr-card-banner">
                <div class="ctr-banner-left">
                    <div class="ctr-banner-label">Employee Contract</div>
                    <div class="ctr-banner-code">{{ $contract->code }}</div>
                    <div class="ctr-banner-chips">
                        <span class="ctr-banner-chip">
                            <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                            {{ $contract->position->name ?? 'No Position' }}
                        </span>
                        <span class="ctr-banner-chip">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $contract->start_date->format('M d, Y') }} &ndash; {{ $contract->end_date->format('M d, Y') }}
                        </span>
                        @if($contract->daily_working_hours ?? null)
                        <span class="ctr-banner-chip">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                            {{ $contract->daily_working_hours }}h / day
                        </span>
                        @endif
                    </div>
                </div>
                <div class="ctr-banner-right">
                    <span class="ctr-banner-status {{ $bannerStatus }}">
                        {{ ucfirst($s) }}
                    </span>
                    <div class="ctr-banner-actions">
                        <button class="ctr-btn ctr-btn-white" wire:click="openPdfModal('{{ $contract->id }}')">
                            <svg viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                            PDF
                        </button>
                        <button class="ctr-btn ctr-btn-solid" wire:click="downloadContract('{{ $contract->id }}')">
                            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Body ── --}}
            <div class="ctr-body">

                {{-- Row 1: Employee info (left) + Contract details (right) --}}
                <div class="ctr-2col">

                    {{-- Employee Information --}}
                    <div class="ctr-panel">
                        <div class="ctr-panel-hd">
                            <div class="ctr-panel-icon" style="background:var(--blue-lt);">
                                <svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div class="ctr-panel-title">Employee Information</div>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Full Name</span>
                            <span class="ctr-field-val">{{ $employee?->full_name ?? '—' }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Employee ID</span>
                            <span class="ctr-field-val">{{ $employee?->code ?? '—' }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Email</span>
                            <span class="ctr-field-val" style="font-size:12.5px;">{{ $employee?->email ?? '—' }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Phone</span>
                            <span class="ctr-field-val">{{ $employee?->phone_number ?? '—' }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Department</span>
                            <span class="ctr-field-val">{{ $employee?->department?->name ?? '—' }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">National ID</span>
                            <span class="ctr-field-val">{{ $employee?->national_id ?? '—' }}</span>
                        </div>
                    </div>

                    {{-- Contract Details --}}
                    <div class="ctr-panel">
                        <div class="ctr-panel-hd">
                            <div class="ctr-panel-icon" style="background:var(--indigo-lt,rgba(107,79,219,0.09));">
                                <svg viewBox="0 0 24 24" style="stroke:#6B4FDB;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </div>
                            <div class="ctr-panel-title">Contract Details</div>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Contract Code</span>
                            <span class="ctr-field-val ctr-field-val-blue">{{ $contract->code }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Position</span>
                            <span class="ctr-field-val">{{ $contract->position->name ?? '—' }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Employee Category</span>
                            <span class="ctr-field-val">{{ ucfirst($contract->employee_category->value ?? '—') }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Working Hours</span>
                            <span class="ctr-field-val">{{ $contract->daily_working_hours ?? '—' }} hrs / day</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Contract Status</span>
                            <span class="ctr-badge {{ $badgeCls }}">{{ ucfirst($s) }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Approval Status</span>
                            <span class="ctr-badge {{ $approvalCls }}">{{ $as ? ucfirst($as) : '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="ctr-divider"></div>

                {{-- Row 2: Period (left) + Compensation (center) + Approval (right) --}}
                <div class="ctr-3col">

                    {{-- Employment Period --}}
                    <div class="ctr-panel">
                        <div class="ctr-panel-hd">
                            <div class="ctr-panel-icon" style="background:var(--green-lt);">
                                <svg viewBox="0 0 24 24" style="stroke:var(--green);"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <div class="ctr-panel-title">Employment Period</div>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Start Date</span>
                            <span class="ctr-field-val">{{ $contract->start_date->format('M d, Y') }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">End Date</span>
                            <span class="ctr-field-val">{{ $contract->end_date->format('M d, Y') }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Duration</span>
                            <span class="ctr-field-val">
                                {{ $contract->start_date->diffInMonths($contract->end_date) }} months
                            </span>
                        </div>
                        @if($contract->approved_at ?? null)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Approved On</span>
                            <span class="ctr-field-val">{{ $contract->approved_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Compensation --}}
                    <div class="ctr-panel">
                        <div class="ctr-panel-hd">
                            <div class="ctr-panel-icon" style="background:var(--amber-lt);">
                                <svg viewBox="0 0 24 24" style="stroke:var(--amber);"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            </div>
                            <div class="ctr-panel-title">Compensation</div>
                        </div>
                        @if($employee?->basic_salary)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Basic Salary</span>
                            <span class="ctr-field-val ctr-field-val-green">
                                {{ number_format($employee->basic_salary, 2) }} {{ $employee->salary_currency ?? 'RWF' }}
                            </span>
                        </div>
                        @endif
                        <div class="ctr-field">
                            <span class="ctr-field-label">Remuneration</span>
                            <span class="ctr-field-val">{{ number_format($contract->remuneration, 2) }}</span>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Remuneration Type</span>
                            <span class="ctr-field-val">{{ ucfirst($contract->remuneration_type->value ?? '—') }}</span>
                        </div>
                        @if($employee?->daily_rate)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Daily Rate</span>
                            <span class="ctr-field-val">{{ number_format($employee->daily_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</span>
                        </div>
                        @endif
                        @if($employee?->hourly_rate)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Hourly Rate</span>
                            <span class="ctr-field-val">{{ number_format($employee->hourly_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</span>
                        </div>
                        @endif
                        @if($employee?->is_taxable !== null)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Tax Status</span>
                            <span class="ctr-badge {{ $employee->is_taxable ? 'ctr-badge-green' : 'ctr-badge-gray' }}">
                                {{ $employee->is_taxable ? 'Taxable' : 'Non-Taxable' }}
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Approval + Payment --}}
                    <div class="ctr-panel">
                        <div class="ctr-panel-hd">
                            <div class="ctr-panel-icon" style="background:var(--blue-lt);">
                                <svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                            <div class="ctr-panel-title">Approval &amp; Payment</div>
                        </div>
                        <div class="ctr-field">
                            <span class="ctr-field-label">Approval</span>
                            <span class="ctr-badge {{ $approvalCls }}">{{ $as ? ucfirst($as) : '—' }}</span>
                        </div>
                        @if($contract->approved_at ?? null)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Approved At</span>
                            <span class="ctr-field-val">{{ $contract->approved_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                        @if($employee?->payment_method)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Pay Method</span>
                            <span class="ctr-field-val">{{ ucfirst(str_replace('_',' ', $employee->payment_method)) }}</span>
                        </div>
                        @endif
                        @if($employee?->bank_name)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Bank</span>
                            <span class="ctr-field-val">{{ $employee->bank_name }}</span>
                        </div>
                        @endif
                        @if($employee?->bank_account_number)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Account No.</span>
                            <span class="ctr-field-val">{{ $employee->bank_account_number }}</span>
                        </div>
                        @endif
                        @if($employee?->mobile_money_provider)
                        <div class="ctr-field">
                            <span class="ctr-field-label">Mobile Money</span>
                            <span class="ctr-field-val">{{ $employee->mobile_money_provider }}</span>
                        </div>
                        @endif
                        @if($employee?->rssb_rate)
                        <div class="ctr-field">
                            <span class="ctr-field-label">RSSB Rate</span>
                            <span class="ctr-field-val">{{ number_format($employee->rssb_rate, 2) }}%</span>
                        </div>
                        @endif
                    </div>

                </div>

            </div>{{-- /ctr-body --}}
        </div>{{-- /ctr-card --}}

    @endforeach

@else
    <div class="ctr-empty">
        <div class="ctr-empty-icon">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <p class="ctr-empty-title">No contracts found</p>
        <p class="ctr-empty-sub">You don't have any contracts assigned yet. Contact HR.</p>
    </div>
@endif

{{-- ══ PDF MODAL — view, modify settings & download ══ --}}
@if($selectedContract ?? null)
    @php
        $ps = $selectedContract->status->value;
        $pBadgeCls = match($ps) { 'active'=>'ctr-pdf-badge-green','expired'=>'ctr-pdf-badge-red','pending'=>'ctr-pdf-badge-amber','terminated'=>'ctr-pdf-badge-gray',default=>'ctr-pdf-badge-blue' };
        $pas = $selectedContract->approval_status->value ?? '';
        $pABadgeCls = match($pas) { 'approved'=>'ctr-pdf-badge-green','rejected'=>'ctr-pdf-badge-red','pending'=>'ctr-pdf-badge-amber',default=>'ctr-pdf-badge-gray' };
    @endphp
    <div class="ctr-modal-bg">
        <div class="ctr-modal">
            <div class="ctr-modal-hd">
                <div class="ctr-modal-title">Contract PDF — {{ $selectedContract->code }}</div>
                <button class="ctr-modal-close" wire:click="closeModal">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="ctr-modal-body">

                {{-- PDF Settings --}}
                <div style="margin-bottom:20px;">
                    <div style="font-family:'Sora',sans-serif;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:12px;">
                        Modify PDF Settings
                    </div>
                    <div class="ctr-pdf-settings">
                        <div class="ctr-pdf-setting-row">
                            <div class="ctr-pdf-field-set">
                                <label>Organization Name</label>
                                <input type="text" id="pdf_org_name" value="ZIBITECH" oninput="updatePdfPreview()">
                            </div>
                            <div class="ctr-pdf-field-set">
                                <label>Document Title</label>
                                <input type="text" id="pdf_doc_title" value="Employment Contract" oninput="updatePdfPreview()">
                            </div>
                        </div>
                        <div class="ctr-pdf-setting-row">
                            <div class="ctr-pdf-field-set">
                                <label>Footer Note</label>
                                <input type="text" id="pdf_footer" value="This document is confidential." oninput="updatePdfPreview()">
                            </div>
                            <div class="ctr-pdf-field-set">
                                <label>Paper Size</label>
                                <select id="pdf_paper">
                                    <option value="A4">A4</option>
                                    <option value="Letter">Letter</option>
                                </select>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <div class="ctr-pdf-toggle-row" style="flex:1;">
                                <div><div class="ctr-pdf-toggle-lbl">Show Salary Details</div><div class="ctr-pdf-toggle-sub">Include compensation info</div></div>
                                <button class="ctr-pdf-toggle-sw on" id="tog_salary" onclick="toggleSetting(this,'tog_salary')"></button>
                            </div>
                            <div class="ctr-pdf-toggle-row" style="flex:1;">
                                <div><div class="ctr-pdf-toggle-lbl">Show Payment Info</div><div class="ctr-pdf-toggle-sub">Bank / mobile money</div></div>
                                <button class="ctr-pdf-toggle-sw on" id="tog_payment" onclick="toggleSetting(this,'tog_payment')"></button>
                            </div>
                            <div class="ctr-pdf-toggle-row" style="flex:1;">
                                <div><div class="ctr-pdf-toggle-lbl">Signature Lines</div><div class="ctr-pdf-toggle-sub">Employee &amp; employer sign</div></div>
                                <button class="ctr-pdf-toggle-sw on" id="tog_sigs" onclick="toggleSetting(this,'tog_sigs')"></button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Live PDF Preview --}}
                <div style="font-family:'Sora',sans-serif;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:10px;">
                    PDF Preview
                </div>
                <div class="ctr-pdf-preview">
                    <div class="ctr-pdf-page" id="pdfPreviewPage">

                        {{-- PDF top --}}
                        <div class="ctr-pdf-top">
                            <div>
                                <div class="ctr-pdf-logo-mark">
                                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </div>
                                <div class="ctr-pdf-org-name" id="prev_org_name">ZIBITECH</div>
                                <div class="ctr-pdf-org-sub">Human Resources</div>
                            </div>
                            <div class="ctr-pdf-doc-type">
                                <div class="ctr-pdf-doc-label" id="prev_doc_title">Employment Contract</div>
                                <div class="ctr-pdf-doc-code">{{ $selectedContract->code }}</div>
                                <span class="ctr-pdf-badge {{ $pBadgeCls }}" style="margin-top:4px;display:inline-flex;">{{ ucfirst($ps) }}</span>
                            </div>
                        </div>

                        {{-- Employee section --}}
                        <div class="ctr-pdf-section">
                            <div class="ctr-pdf-section-title">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Employee Information
                            </div>
                            <div class="ctr-pdf-grid">
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Full Name</div><div class="ctr-pdf-value">{{ $employee?->full_name ?? '—' }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Employee ID</div><div class="ctr-pdf-value">{{ $employee?->code ?? '—' }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Department</div><div class="ctr-pdf-value">{{ $employee?->department?->name ?? '—' }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Position</div><div class="ctr-pdf-value">{{ $selectedContract->position->name ?? '—' }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">National ID</div><div class="ctr-pdf-value">{{ $employee?->national_id ?? '—' }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Category</div><div class="ctr-pdf-value">{{ ucfirst($selectedContract->employee_category->value ?? '—') }}</div></div>
                            </div>
                        </div>

                        {{-- Contract period --}}
                        <div class="ctr-pdf-section">
                            <div class="ctr-pdf-section-title">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Employment Period
                            </div>
                            <div class="ctr-pdf-grid-3">
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Start Date</div><div class="ctr-pdf-value">{{ $selectedContract->start_date->format('M d, Y') }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">End Date</div><div class="ctr-pdf-value">{{ $selectedContract->end_date->format('M d, Y') }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Duration</div><div class="ctr-pdf-value">{{ $selectedContract->start_date->diffInMonths($selectedContract->end_date) }} months</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Working Hours</div><div class="ctr-pdf-value">{{ $selectedContract->daily_working_hours ?? '—' }} hrs / day</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Contract Status</div><div><span class="ctr-pdf-badge {{ $pBadgeCls }}">{{ ucfirst($ps) }}</span></div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Approval</div><div><span class="ctr-pdf-badge {{ $pABadgeCls }}">{{ $pas ? ucfirst($pas) : '—' }}</span></div></div>
                            </div>
                        </div>

                        {{-- Compensation --}}
                        <div class="ctr-pdf-section" id="prev_salary_section">
                            <div class="ctr-pdf-section-title">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                Compensation
                            </div>
                            <div class="ctr-pdf-grid">
                                @if($employee?->basic_salary)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Basic Salary</div><div class="ctr-pdf-value ctr-pdf-value-green">{{ number_format($employee->basic_salary, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</div></div>
                                @endif
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Remuneration</div><div class="ctr-pdf-value">{{ number_format($selectedContract->remuneration, 2) }}</div></div>
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Remuneration Type</div><div class="ctr-pdf-value">{{ ucfirst($selectedContract->remuneration_type->value ?? '—') }}</div></div>
                                @if($employee?->daily_rate)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Daily Rate</div><div class="ctr-pdf-value">{{ number_format($employee->daily_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</div></div>
                                @endif
                                @if($employee?->is_taxable !== null)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Tax Status</div><div><span class="ctr-pdf-badge {{ $employee->is_taxable ? 'ctr-pdf-badge-green' : 'ctr-pdf-badge-gray' }}">{{ $employee->is_taxable ? 'Taxable' : 'Non-Taxable' }}</span></div></div>
                                @endif
                                @if($employee?->rssb_rate)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">RSSB Rate</div><div class="ctr-pdf-value">{{ number_format($employee->rssb_rate, 2) }}%</div></div>
                                @endif
                            </div>
                        </div>

                        {{-- Payment info --}}
                        @if($employee?->payment_method)
                        <div class="ctr-pdf-section" id="prev_payment_section">
                            <div class="ctr-pdf-section-title">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                Payment Information
                            </div>
                            <div class="ctr-pdf-grid">
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Payment Method</div><div class="ctr-pdf-value">{{ ucfirst(str_replace('_',' ',$employee->payment_method)) }}</div></div>
                                @if($employee->bank_name)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Bank Name</div><div class="ctr-pdf-value">{{ $employee->bank_name }}</div></div>
                                @endif
                                @if($employee->bank_account_number)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Account Number</div><div class="ctr-pdf-value">{{ $employee->bank_account_number }}</div></div>
                                @endif
                                @if($employee->mobile_money_provider)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Mobile Provider</div><div class="ctr-pdf-value">{{ $employee->mobile_money_provider }}</div></div>
                                @endif
                                @if($employee->mobile_money_number)
                                <div class="ctr-pdf-field"><div class="ctr-pdf-label">Mobile Number</div><div class="ctr-pdf-value">{{ $employee->mobile_money_number }}</div></div>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Signature lines --}}
                        <div class="ctr-pdf-sigs" id="prev_sigs_section">
                            <div class="ctr-pdf-sig">
                                <div class="ctr-pdf-sig-label">Employee Signature</div>
                                <div class="ctr-pdf-sig-name">{{ $employee?->full_name ?? '________________' }}</div>
                            </div>
                            <div class="ctr-pdf-sig">
                                <div class="ctr-pdf-sig-label">Employer / HR Representative</div>
                                <div class="ctr-pdf-sig-name">ZIBITECH HR Department</div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div style="margin-top:24px;padding-top:14px;border-top:1px solid #E8EEF8;
                                    font-size:10px;color:#A8ADCA;display:flex;justify-content:space-between;">
                            <span id="prev_footer">This document is confidential.</span>
                            <span>Generated {{ now()->format('M d, Y') }}</span>
                        </div>

                    </div>{{-- /ctr-pdf-page --}}
                </div>{{-- /ctr-pdf-preview --}}

            </div>{{-- /ctr-modal-body --}}

            <div class="ctr-modal-footer">
                <button class="ctr-btn ctr-btn-outline" wire:click="closeModal">Close</button>
                <button class="ctr-btn ctr-btn-blue" onclick="printPdfPreview()">
                    <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Print / Save PDF
                </button>
                <button class="ctr-btn ctr-btn-blue" wire:click="downloadContract('{{ $selectedContract->id }}')">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Download
                </button>
            </div>
        </div>
    </div>
@endif

{{-- ══ FLOATING NAV ══ --}}
<nav class="ctr-nav">
    <a href="{{ route('employee.dashboard') }}" class="ctr-nav-item">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
    </a>
    <a href="{{ route('employee.profile') }}" class="ctr-nav-item">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>
        Profile
    </a>
    <a href="{{ route('employee.attendance') }}" class="ctr-nav-item">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
    </a>
    <a href="{{ route('employee.leave.request') }}" class="ctr-nav-item">
        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="ctr-nav-item">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="#" class="ctr-nav-item" style="position:relative">
        <svg viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

<script>
/* ── PDF Settings live update ── */
function updatePdfPreview() {
    const org = document.getElementById('pdf_org_name')?.value || '';
    const ttl = document.getElementById('pdf_doc_title')?.value || '';
    const ftr = document.getElementById('pdf_footer')?.value || '';
    const pOrg = document.getElementById('prev_org_name');
    const pTtl = document.getElementById('prev_doc_title');
    const pFtr = document.getElementById('prev_footer');
    if (pOrg) pOrg.textContent = org;
    if (pTtl) pTtl.textContent = ttl;
    if (pFtr) pFtr.textContent = ftr;
}

function toggleSetting(btn, id) {
    const isOn = btn.classList.contains('on');
    btn.classList.toggle('on',  !isOn);
    btn.classList.toggle('off',  isOn);

    const sections = {
        'tog_salary':  'prev_salary_section',
        'tog_payment': 'prev_payment_section',
        'tog_sigs':    'prev_sigs_section',
    };
    const targetId = sections[id];
    if (!targetId) return;
    const el = document.getElementById(targetId);
    if (el) el.style.display = isOn ? 'none' : '';
}

/* ── Print / Save PDF ── */
function printPdfPreview() {
    const page = document.getElementById('pdfPreviewPage');
    if (!page) return;

    const orgName = document.getElementById('pdf_org_name')?.value || 'ZIBITECH';
    const docTitle = document.getElementById('pdf_doc_title')?.value || 'Employment Contract';
    const paper = document.getElementById('pdf_paper')?.value || 'A4';

    const w = window.open('', '_blank',
        'width=900,height=700,menubar=yes,toolbar=yes,location=no,scrollbars=yes');

    w.document.write(`<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>${docTitle} — ${orgName}</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
<style>
  @page { size: ${paper}; margin: 18mm 20mm; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', Arial, sans-serif; font-size: 12px; color: #0F1629; line-height: 1.55; background: #fff; }
  ${page.closest('.ctr-pdf-page').style.cssText || ''}
</style>
</head>
<body>
${page.innerHTML}
</body>
</html>`);
    w.document.close();
    w.focus();
    setTimeout(() => { w.print(); }, 600);
}

/* ── Handle Livewire download event ── */
document.addEventListener('livewire:init', () => {
    Livewire.on('downloadContract', (e) => {
        console.log('downloadContract event received:', e);
        
        // Use window.open to avoid CSRF issues
        const downloadUrl = `/employee/contracts/download/${e.contractId}`;
        console.log('Opening download URL:', downloadUrl);
        
        // Open in new window/tab to trigger download
        window.open(downloadUrl, '_blank');
    });
});
</script>

</div>{{-- /ctr-root --}}