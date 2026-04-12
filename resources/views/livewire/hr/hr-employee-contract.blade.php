<div class="cm-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

.cm-root {
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
.cm-flash { padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 9px; }
.cm-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.cm-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.cm-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.cm-hero { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.cm-hero-cover { height: 68px; background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%); position: relative; }
.cm-hero-cover::before { content:''; position:absolute; top:-30px; right:60px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,0.06); }
.cm-hero-body { padding: 0 24px 0; display: flex; align-items: flex-end; justify-content: space-between; gap:16px; margin-top: -2px; }
.cm-hero-icon { width: 52px; height: 52px; border-radius: 15px; background: linear-gradient(135deg, var(--blue), #5A8BF5); border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.28); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.cm-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.cm-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.cm-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }
.cm-hero-actions { display: flex; gap: 8px; padding-bottom: 4px; }

/* Stat strip */
.cm-stat-strip { display: grid; grid-template-columns: repeat(4,1fr); gap: 1px; background: var(--border); border-radius: 0 0 var(--r-lg) var(--r-lg); overflow: hidden; margin-top: 18px; }
.cm-stat-cell { background: var(--white); padding: 13px 18px; display: flex; flex-direction: column; gap: 2px; }
.cm-stat-cell-icon { width: 26px; height: 26px; border-radius: 7px; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.cm-stat-cell-icon svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }
.cm-stat-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.cm-stat-val   { font-family:'Sora',sans-serif; font-size: 20px; font-weight: 800; color: var(--ink2); }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.cm-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 14px 18px; }
.cm-search-box { display: flex; align-items: center; gap: 8px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 13px; flex: 1; min-width: 200px; transition: border-color 0.15s, box-shadow 0.15s; }
.cm-search-box:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); }
.cm-search-box svg { width: 14px; height: 14px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.cm-search-box input { border: none; background: transparent; font-size: 13.5px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.cm-search-box input::placeholder { color: var(--ink4); }
.cm-filter-select { background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 32px 8px 12px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; -webkit-appearance: none; transition: border-color 0.15s; }
.cm-filter-select:focus { border-color: var(--blue); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.cm-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 17px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all 0.15s; white-space: nowrap; }
.cm-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.cm-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.cm-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.cm-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.cm-btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.cm-btn-ghost  { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.cm-btn-ghost:hover { background: var(--blue-mid); }
.cm-btn-green  { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }
.cm-btn-green:hover { background: rgba(18,183,106,0.16); }
.cm-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.cm-btn-danger:hover { background: rgba(239,68,68,0.15); }
.cm-btn-sm { padding: 5px 11px; font-size: 11.5px; }

/* ══ CONTRACT CARD GRID ══════════════════════════════════ */
.cm-cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; }
.cm-contract-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow); overflow: hidden; transition: box-shadow 0.18s, border-color 0.18s, transform 0.15s; display: flex; flex-direction: column; }
.cm-contract-card:hover { box-shadow: var(--shadow-md); border-color: var(--blue-brd); transform: translateY(-2px); }
.cm-card-stripe { height: 5px; background: linear-gradient(90deg, var(--blue-2), var(--blue), #5A8BF5); }
.cm-card-stripe.expired    { background: linear-gradient(90deg, #6B7280, #9CA3AF); }
.cm-card-stripe.terminated { background: linear-gradient(90deg, #991B1B, var(--red)); }
.cm-card-stripe.draft      { background: linear-gradient(90deg, #D97706, var(--amber)); }
.cm-card-stripe.suspended  { background: linear-gradient(90deg, #7C3AED, #A78BFA); }
.cm-card-hd { padding: 16px 18px 12px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
.cm-card-hd-left { display: flex; align-items: flex-start; gap: 11px; }
.cm-card-av { width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, var(--blue), #6B4FDB); display: flex; align-items: center; justify-content: center; font-family:'Sora',sans-serif; font-size: 13px; font-weight: 800; color: #fff; flex-shrink: 0; }
.cm-card-name  { font-family:'Sora',sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
.cm-card-code  { font-size: 11px; color: var(--ink4); font-weight: 600; display: flex; align-items: center; gap: 4px; }
.cm-card-code svg { width: 10px; height: 10px; stroke: var(--ink4); fill: none; stroke-width: 2; }
.cm-card-badges { display: flex; gap: 5px; flex-wrap: wrap; }
.cm-card-meta { padding: 0 18px 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.cm-card-meta-item label { display: block; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); margin-bottom: 2px; }
.cm-card-meta-item p { font-size: 12.5px; font-weight: 700; color: var(--ink2); margin: 0; display: flex; align-items: center; gap: 4px; }
.cm-card-meta-item p svg { width: 11px; height: 11px; stroke: var(--blue); fill: none; stroke-width: 2; }
.cm-card-progress { padding: 0 18px 12px; }
.cm-card-progress-label { display: flex; justify-content: space-between; font-size: 10.5px; font-weight: 700; color: var(--ink4); margin-bottom: 5px; }
.cm-card-bar { height: 5px; border-radius: 100px; background: var(--bg); overflow: hidden; }
.cm-card-bar-fill { height: 100%; border-radius: 100px; background: linear-gradient(90deg, var(--blue-2), var(--blue)); transition: width 0.5s ease; }
.cm-card-bar-fill.warning { background: linear-gradient(90deg, #D97706, var(--amber)); }
.cm-card-bar-fill.danger  { background: linear-gradient(90deg, #991B1B, var(--red)); }
.cm-card-footer { padding: 11px 18px; border-top: 1px solid var(--border); background: #FAFBFF; display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: auto; }
.cm-card-actions { display: flex; gap: 6px; }
.cm-approval-banner { margin: 0 18px 12px; padding: 8px 12px; border-radius: 9px; display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; }
.cm-approval-banner svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.approval-pending  { background: var(--amber-lt); color: #92400E; border: 1px solid rgba(245,158,11,0.22); }
.approval-approved { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }

/* ══ BADGES ══════════════════════════════════════════════ */
.cm-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.cm-badge svg { width: 7px; height: 7px; stroke: currentColor; fill: currentColor; }
.b-active     { background: var(--green-lt);  color: #087A42; }
.b-expired    { background: var(--bg); color: var(--ink3); border: 1px solid var(--border); }
.b-terminated { background: var(--red-lt); color: #991B1B; }
.b-draft      { background: var(--amber-lt); color: #92400E; }
.b-suspended  { background: var(--purple-lt); color: var(--purple); }
.b-blue       { background: var(--blue-lt); color: var(--blue-2); }
.b-approved   { background: var(--green-lt); color: #087A42; }
.b-pending    { background: var(--amber-lt); color: #92400E; }
.b-initiated  { background: var(--blue-lt); color: var(--blue-2); }
.b-rejected   { background: var(--red-lt); color: #991B1B; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.cm-empty { text-align: center; padding: 64px 24px; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); }
.cm-empty svg { width: 40px; height: 40px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 14px; display: block; opacity: 0.4; }
.cm-empty-title { font-size: 16px; font-weight: 700; color: var(--ink3); margin-bottom: 5px; }
.cm-empty-sub   { font-size: 13px; color: var(--ink4); font-weight: 500; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.cm-pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); }
.cm-page-info  { font-size: 12.5px; color: var(--ink4); font-weight: 500; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.cm-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.50); backdrop-filter: blur(8px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 16px; }
.cm-modal { background: var(--white); border-radius: var(--r-lg); box-shadow: 0 24px 64px rgba(15,22,41,0.22); border: 1px solid var(--border); width: 100%; max-width: 760px; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; }
.cm-modal-sm { max-width: 480px; }
.cm-modal-hd { background: linear-gradient(105deg, var(--blue-3), var(--blue)); padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
.cm-modal-title { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 9px; }
.cm-modal-title svg { width: 18px; height: 18px; stroke: rgba(255,255,255,0.8); fill: none; stroke-width: 2; }
.cm-modal-close { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.18); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.15s; }
.cm-modal-close:hover { background: rgba(255,255,255,0.28); }
.cm-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }
.cm-modal-body { flex: 1; overflow-y: auto; padding: 22px; }
.cm-modal-footer { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }

/* Section labels */
.cm-slbl { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); margin: 18px 0 10px; display: flex; align-items: center; gap: 6px; }
.cm-slbl:first-child { margin-top: 0; }
.cm-slbl::after { content:''; flex:1; height:1px; background: var(--border); }
.cm-slbl svg { width: 12px; height: 12px; stroke: var(--blue); fill: none; stroke-width: 2; }

/* Form grids */
.cm-fg  { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
.cm-fg2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; }
.cm-fg4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; }
.cm-c2  { grid-column: span 2; }
.cm-c3  { grid-column: span 3; }

/* Fields */
.cm-field { display: flex; flex-direction: column; gap: 5px; }
.cm-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); }
.cm-field label .req { color: var(--red); margin-left: 2px; }
.cm-field input, .cm-field select, .cm-field textarea { width: 100%; padding: 9px 12px; box-sizing: border-box; background: #F6F8FC; border: 1.5px solid var(--border); border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--ink); outline: none; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s; -webkit-appearance: none; }
.cm-field input:focus, .cm-field select:focus, .cm-field textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white); }
.cm-field select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 11px center; padding-right: 32px; cursor: pointer; }
.cm-field textarea { resize: vertical; min-height: 72px; }
.cm-field-error { font-size: 11.5px; color: var(--red); font-weight: 600; }

/* Preview boxes */
.cm-preview { display: flex; align-items: center; gap: 8px; border-radius: var(--r); padding: 10px 13px; font-size: 13px; font-weight: 700; }
.cm-preview svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.cm-preview-blue  { background: var(--blue-lt); color: var(--blue-2); border: 1px solid var(--blue-brd); }
.cm-preview-green { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }

/* View modal */
.cm-view-hero { padding: 22px 22px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 16px; }
.cm-view-av { width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, var(--blue), #6B4FDB); display: flex; align-items: center; justify-content: center; font-family:'Sora',sans-serif; font-size: 18px; font-weight: 800; color: #fff; flex-shrink: 0; box-shadow: 0 4px 14px rgba(59,111,232,0.28); }
.cm-view-name { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
.cm-view-code-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 700; color: var(--blue-2); background: var(--blue-lt); border: 1px solid var(--blue-brd); padding: 3px 10px; border-radius: 7px; }
.cm-view-meta-row { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 6px; }
.cm-view-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
.cm-view-row { display: flex; flex-direction: column; gap: 2px; padding: 10px 0; border-bottom: 1px solid var(--border); }
.cm-view-row:last-child { border-bottom: none; }
.cm-view-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); }
.cm-view-value { font-size: 13.5px; font-weight: 600; color: var(--ink2); }

/* Delete modal */
.cm-delete-icon { width: 56px; height: 56px; border-radius: 16px; background: var(--red-lt); border: 1px solid rgba(239,68,68,0.22); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.cm-delete-icon svg { width: 26px; height: 26px; stroke: var(--red); fill: none; stroke-width: 1.75; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .cm-fg  { grid-template-columns: repeat(2,1fr); }
    .cm-fg4 { grid-template-columns: repeat(2,1fr); }
    .cm-c3  { grid-column: span 2; }
    .cm-stat-strip { grid-template-columns: repeat(2,1fr); }
    .cm-cards-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .cm-root { padding: 14px 12px 32px; }
    .cm-fg, .cm-fg2, .cm-fg4 { grid-template-columns: 1fr; }
    .cm-c2, .cm-c3 { grid-column: span 1; }
    .cm-view-grid { grid-template-columns: 1fr; }
}
</style>

{{-- Flash --}}
@if(session()->has('success'))
    <div class="cm-flash cm-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="cm-flash cm-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ PAGE HERO ══════════════════════════════════════════ --}}
<div class="cm-hero">
    <div class="cm-hero-cover"></div>
    <div class="cm-hero-body">
        <div style="display:flex;align-items:flex-end;gap:13px;">
            <div class="cm-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div>
                <div class="cm-hero-title">Contracts</div>
                <div class="cm-hero-sub">Manage employee contracts, remuneration and approval workflows</div>
            </div>
        </div>
        <div class="cm-hero-actions">
            <button class="cm-btn cm-btn-primary" wire:click="openCreate">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Contract
            </button>
        </div>
    </div>

    <div class="cm-stat-strip">
        <div class="cm-stat-cell">
            <div class="cm-stat-cell-icon" style="background:var(--blue-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--blue)"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
            </div>
            <div class="cm-stat-label">Total Contracts</div>
            <div class="cm-stat-val">{{ $totalCount }}</div>
        </div>
        <div class="cm-stat-cell">
            <div class="cm-stat-cell-icon" style="background:var(--green-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="cm-stat-label">Active</div>
            <div class="cm-stat-val" style="color:var(--green);">{{ $activeCount }}</div>
        </div>
        <div class="cm-stat-cell">
            <div class="cm-stat-cell-icon" style="background:var(--bg);">
                <svg viewBox="0 0 24 24" style="stroke:var(--ink3)"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="cm-stat-label">Expired</div>
            <div class="cm-stat-val" style="color:var(--ink3);">{{ $expiredCount }}</div>
        </div>
        <div class="cm-stat-cell">
            <div class="cm-stat-cell-icon" style="background:var(--amber-lt);">
                <svg viewBox="0 0 24 24" style="stroke:var(--amber)"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="cm-stat-label">Pending Approval</div>
            <div class="cm-stat-val" style="color:var(--amber);">{{ $pendingApproval }}</div>
        </div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="cm-toolbar">
    <div class="cm-search-box">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by code or employee name…">
    </div>
    <select class="cm-filter-select" wire:model.live="filterEmployee">
        <option value="">All Employees</option>
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}">{{ $emp->first_name . ' ' . $emp->last_name }}</option>
        @endforeach
    </select>
    <select class="cm-filter-select" wire:model.live="filterStatus">
        <option value="">All Statuses</option>
        @foreach($statuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="cm-filter-select" wire:model.live="filterCategory">
        <option value="">All Categories</option>
        @foreach($employeeCategories as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="cm-filter-select" wire:model.live="perPage" style="min-width:80px;">
        <option value="15">15</option>
        <option value="25">25</option>
        <option value="50">50</option>
    </select>
</div>

{{-- ══ CONTRACT CARDS ═════════════════════════════════════ --}}
@if($contracts->count() > 0)
<div class="cm-cards-grid">
    @foreach($contracts as $contract)
        @php
            $emp     = $contract->employee;
            $pos     = $contract->position;
            $proj    = $contract->project;
            $status  = $contract->status instanceof \BackedEnum
                ? $contract->status->value : ($contract->status ?? 'active');
            $appStat = $contract->approval_status instanceof \BackedEnum
                ? $contract->approval_status->value : ($contract->approval_status ?? '');
            $initials = $emp
                ? strtoupper(substr($emp->first_name ?? '', 0, 1).substr($emp->last_name ?? '', 0, 1))
                : 'N/A';
            $start = $contract->start_date ? \Carbon\Carbon::parse($contract->start_date) : null;
            $end   = $contract->end_date   ? \Carbon\Carbon::parse($contract->end_date)   : null;
            $pct   = 0;
            $daysLeft = null;
            if ($start && $end) {
                $totalDays   = max(1, $start->diffInDays($end));
                $elapsedDays = min($start->diffInDays(now()), $totalDays);
                $pct         = round(($elapsedDays / $totalDays) * 100);
                $daysLeft    = max(0, now()->diffInDays($end, false));
            }
            $statusBadge = match($status) {
                'active'     => 'b-active',
                'expired'    => 'b-expired',
                'terminated' => 'b-terminated',
                'draft'      => 'b-draft',
                'suspended'  => 'b-suspended',
                default      => 'b-pending',
            };
            $appBadge = match($appStat) {
                'approved'  => 'b-approved',
                'rejected'  => 'b-rejected',
                'initiated' => 'b-initiated',
                default     => 'b-pending',
            };
            $barClass = $pct >= 90 ? 'danger' : ($pct >= 70 ? 'warning' : '');
        @endphp

        <div class="cm-contract-card">
            <div class="cm-card-stripe {{ $status }}"></div>

            <div class="cm-card-hd">
                <div class="cm-card-hd-left">
                    <div class="cm-card-av">{{ $initials }}</div>
                    <div>
                        <div class="cm-card-name">{{ $emp ? ($emp->first_name.' '.$emp->last_name) : 'Unknown Employee' }}</div>
                        <div class="cm-card-code">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
                            {{ $contract->code }}
                        </div>
                    </div>
                </div>
                <div class="cm-card-badges">
                    <span class="cm-badge {{ $statusBadge }}">
                        <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                        {{ ucfirst($status) }}
                    </span>
                    <span class="cm-badge {{ $appBadge }}">{{ ucfirst($appStat) }}</span>
                </div>
            </div>

            {{-- Approval action banner --}}
            @if($appStat === 'initiated' || $appStat === 'pending')
                <div class="cm-approval-banner approval-pending">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Awaiting approval
                    <div style="margin-left:auto;display:flex;gap:5px;">
                        <button class="cm-btn cm-btn-green cm-btn-sm" wire:click="approveContract('{{ $contract->id }}')">
                            <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> Approve
                        </button>
                        <button class="cm-btn cm-btn-danger cm-btn-sm" wire:click="rejectContract('{{ $contract->id }}')">Reject</button>
                    </div>
                </div>
            @elseif($appStat === 'approved')
                <div class="cm-approval-banner approval-approved">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Contract approved
                </div>
            @endif

            <div class="cm-card-meta">
                <div class="cm-card-meta-item">
                    <label>Position</label>
                    <p>{{ $pos?->name ?? '—' }}</p>
                </div>
                <div class="cm-card-meta-item">
                    <label>Category</label>
                    <p>{{ $employeeCategories[$contract->employee_category instanceof \BackedEnum ? $contract->employee_category->value : $contract->employee_category] ?? ucfirst($contract->employee_category instanceof \BackedEnum ? $contract->employee_category->value : $contract->employee_category) }}</p>
                </div>
                <div class="cm-card-meta-item">
                    <label>Remuneration</label>
                    <p>
                        <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        {{ number_format($contract->remuneration, 0) }}
                        <span style="font-size:10px;color:var(--ink4);font-weight:500;">/ {{ $remunerationTypes[$contract->remuneration_type instanceof \BackedEnum ? $contract->remuneration_type->value : $contract->remuneration_type] ?? $contract->remuneration_type instanceof \BackedEnum ? $contract->remuneration_type->value : $contract->remuneration_type }}</span>
                    </p>
                </div>
                <div class="cm-card-meta-item">
                    <label>Daily Hours</label>
                    <p>
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                        {{ $contract->daily_working_hours }}h / day
                    </p>
                </div>
                <div class="cm-card-meta-item">
                    <label>Start Date</label>
                    <p>{{ $start ? $start->format('M d, Y') : '—' }}</p>
                </div>
                <div class="cm-card-meta-item">
                    <label>End Date</label>
                    <p>
                        {{ $end ? $end->format('M d, Y') : 'Open-ended' }}
                        @if($daysLeft !== null && $daysLeft <= 30 && $status === 'active')
                            <span style="font-size:10px;color:var(--red);font-weight:700;background:var(--red-lt);padding:1px 5px;border-radius:4px;margin-left:4px;">{{ $daysLeft }}d left</span>
                        @endif
                    </p>
                </div>
                @if($proj)
                    <div class="cm-card-meta-item" style="grid-column:span 2;">
                        <label>Project</label>
                        <p>{{ $proj->name }}</p>
                    </div>
                @endif
            </div>

            @if($start && $end)
                <div class="cm-card-progress">
                    <div class="cm-card-progress-label">
                        <span>Duration progress</span>
                        <span>{{ $pct }}%</span>
                    </div>
                    <div class="cm-card-bar">
                        <div class="cm-card-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            @endif

            <div class="cm-card-footer">
                <div style="font-size:11px;color:var(--ink4);font-weight:600;">
                    Contract
                </div>
                <div class="cm-card-actions">
                    <button class="cm-btn cm-btn-ghost cm-btn-sm" wire:click="openView('{{ $contract->id }}')">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <button class="cm-btn cm-btn-outline cm-btn-sm" wire:click="openEdit('{{ $contract->id }}')">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </button>
                    <button class="cm-btn cm-btn-danger cm-btn-sm" wire:click="deleteContract('{{ $contract->id }}')">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($contracts->hasPages())
    <div class="cm-pagination">
        <div class="cm-page-info">Showing {{ $contracts->firstItem() }}–{{ $contracts->lastItem() }} of {{ $contracts->total() }}</div>
        {{ $contracts->links() }}
    </div>
@endif

@else
<div class="cm-empty">
    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
    <div class="cm-empty-title">No contracts found</div>
    <div class="cm-empty-sub">{{ $search ? 'Try a different search term.' : 'Click "New Contract" to create your first one.' }}</div>
</div>
@endif

{{-- ══ CREATE / EDIT MODAL ════════════════════════════════ --}}
@if($showModal)
<div class="cm-modal-bg" wire:click.self="closeModal">
    <div class="cm-modal">
        <div class="cm-modal-hd">
            <div class="cm-modal-title">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                {{ $editingId ? 'Edit Contract' : 'New Contract' }}
                @if($code)
                    <span style="font-size:12px;font-weight:600;background:rgba(255,255,255,0.18);padding:2px 10px;border-radius:100px;">{{ $code }}</span>
                @endif
            </div>
            <button class="cm-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="cm-modal-body">

            {{-- Parties --}}
            <div class="cm-slbl">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Contract Parties
            </div>
            <div class="cm-fg">
                <div class="cm-field cm-c2">
                    <label>Employee <span class="req">*</span></label>
                    <select wire:model="employeeId">
                        <option value="">Select employee…</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->first_name . ' ' . $emp->last_name }}</option>
                        @endforeach
                    </select>
                    @error('employeeId') <span class="cm-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="cm-field">
                    <label>Position <span class="req">*</span></label>
                    <select wire:model="positionId">
                        <option value="">Select position…</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                        @endforeach
                    </select>
                    @error('positionId') <span class="cm-field-error">{{ $message }}</span> @enderror
                </div>
                @if(count($projects))
                    <div class="cm-field cm-c3">
                        <label>Project (optional)</label>
                        <select wire:model="projectId">
                            <option value="">No project assigned</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj['id'] }}">{{ $proj['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            {{-- Terms --}}
            <div class="cm-slbl">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Contract Terms
            </div>
            <div class="cm-fg4">
                <div class="cm-field cm-c2">
                    <label>Contract Type <span class="req">*</span></label>
                    <select wire:model="contractType">
                        @foreach($contractTypes as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cm-field">
                    <label>Employee Category <span class="req">*</span></label>
                    <select wire:model="employeeCategory">
                        @foreach($employeeCategories as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cm-field">
                    <label>Daily Hours <span class="req">*</span></label>
                    <input type="number" wire:model="dailyWorkingHours" placeholder="8" min="1" max="24" step="0.5">
                    @error('dailyWorkingHours') <span class="cm-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="cm-field">
                    <label>Start Date <span class="req">*</span></label>
                    <input type="date" wire:model.live="startDate">
                    @error('startDate') <span class="cm-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="cm-field">
                    <label>End Date</label>
                    <input type="date" wire:model.live="endDate">
                    @error('endDate') <span class="cm-field-error">{{ $message }}</span> @enderror
                </div>
                @if($startDate)
                    <div class="cm-field cm-c2">
                        <label>&nbsp;</label>
                        <div class="cm-preview cm-preview-blue">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                            Duration: <strong>{{ $this->duration }}</strong>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Remuneration --}}
            <div class="cm-slbl">
                <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                Remuneration
            </div>
            <div class="cm-fg">
                <div class="cm-field">
                    <label>Amount (RWF) <span class="req">*</span></label>
                    <input type="number" wire:model.live="remuneration" placeholder="0" min="0" step="100">
                    @error('remuneration') <span class="cm-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="cm-field">
                    <label>Payment Frequency <span class="req">*</span></label>
                    <select wire:model="remunerationType">
                        @foreach($remunerationTypes as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @if($remuneration)
                    <div class="cm-field">
                        <label>&nbsp;</label>
                        <div class="cm-preview cm-preview-green">
                            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            RWF {{ number_format((float)$remuneration, 0) }} / {{ $remunerationType }}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Status & Approval --}}
            <div class="cm-slbl">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Status &amp; Approval
            </div>
            <div class="cm-fg">
                <div class="cm-field">
                    <label>Contract Status <span class="req">*</span></label>
                    <select wire:model="status">
                        @foreach($statuses as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cm-field">
                    <label>Approval Status</label>
                    <select wire:model="approvalStatus">
                        @foreach($approvalStatuses as $as)
                            <option value="{{ $as->value }}">{{ ucfirst($as->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cm-field cm-c3" style="margin-top:0;">
                    <label>Notes (optional)</label>
                    <textarea wire:model="notes" placeholder="Any additional notes about this contract…"></textarea>
                </div>
            </div>

        </div>{{-- /cm-modal-body --}}

        <div class="cm-modal-footer">
            <div style="font-size:12.5px;color:var(--ink4);">Fields marked <span style="color:var(--red);font-weight:800;">*</span> are required</div>
            <div style="display:flex;gap:8px;">
                <button class="cm-btn cm-btn-outline" wire:click="closeModal">Cancel</button>
                <button class="cm-btn cm-btn-primary" wire:click="save">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    {{ $editingId ? 'Update Contract' : 'Create Contract' }}
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewContract)
<div class="cm-modal-bg" wire:click.self="closeView">
    <div class="cm-modal">
        <div class="cm-modal-hd">
            <div class="cm-modal-title">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Contract Details
            </div>
            <button class="cm-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        @php
            $vc     = $viewContract;
            $vcEmp  = $vc->employee;
            $vcInit = $vcEmp ? strtoupper(substr($vcEmp->first_name,0,1).substr($vcEmp->last_name,0,1)) : 'N/A';
            $vcStatus = $vc->status instanceof \BackedEnum ? $vc->status->value : ($vc->status ?? 'active');
            $vcApp    = $vc->approval_status instanceof \BackedEnum ? $vc->approval_status->value : ($vc->approval_status ?? '');
            $vcStatusBadge = match($vcStatus) { 'active'=>'b-active','expired'=>'b-expired','terminated'=>'b-terminated','draft'=>'b-draft','suspended'=>'b-suspended', default=>'b-pending' };
            $vcAppBadge    = match($vcApp)    { 'approved'=>'b-approved','rejected'=>'b-rejected','initiated'=>'b-initiated', default=>'b-pending' };
        @endphp

        <div class="cm-view-hero">
            <div class="cm-view-av">{{ $vcInit }}</div>
            <div style="flex:1;min-width:0;">
                <div class="cm-view-name">{{ $vcEmp ? $vcEmp->first_name.' '.$vcEmp->last_name : 'Unknown Employee' }}</div>
                <div class="cm-view-code-badge">{{ $vc->code }}</div>
                <div class="cm-view-meta-row">
                    <span class="cm-badge {{ $vcStatusBadge }}"><svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>{{ ucfirst($vcStatus) }}</span>
                    <span class="cm-badge {{ $vcAppBadge }}">{{ ucfirst($vcApp) }}</span>
                    @if($vc->position)<span class="cm-badge b-blue">{{ $vc->position->name }}</span>@endif
                    @if($vc->project)<span class="cm-badge b-initiated">{{ $vc->project->name }}</span>@endif
                </div>
            </div>
        </div>

        <div style="padding:16px 22px;overflow-y:auto;max-height:440px;">
            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.09em;color:var(--ink4);margin-bottom:12px;">Contract Terms</div>
            <div class="cm-view-grid">
                <div class="cm-view-row"><div class="cm-view-label">Contract Type</div><div class="cm-view-value">Contract</div></div>
                <div class="cm-view-row"><div class="cm-view-label">Employee Category</div><div class="cm-view-value">{{ $employeeCategories[$vc->employee_category instanceof \BackedEnum ? $vc->employee_category->value : $vc->employee_category] ?? ucfirst($vc->employee_category instanceof \BackedEnum ? $vc->employee_category->value : $vc->employee_category ?? '—') }}</div></div>
                <div class="cm-view-row"><div class="cm-view-label">Start Date</div><div class="cm-view-value">{{ $vc->start_date ? \Carbon\Carbon::parse($vc->start_date)->format('M d, Y') : '—' }}</div></div>
                <div class="cm-view-row"><div class="cm-view-label">End Date</div><div class="cm-view-value">{{ $vc->end_date ? \Carbon\Carbon::parse($vc->end_date)->format('M d, Y') : 'Open-ended' }}</div></div>
                <div class="cm-view-row"><div class="cm-view-label">Daily Hours</div><div class="cm-view-value">{{ $vc->daily_working_hours }}h / day</div></div>
                <div class="cm-view-row"><div class="cm-view-label">Position</div><div class="cm-view-value">{{ $vc->position?->name ?? '—' }}</div></div>
            </div>

            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.09em;color:var(--ink4);margin:16px 0 12px;">Remuneration</div>
            <div class="cm-view-grid">
                <div class="cm-view-row"><div class="cm-view-label">Amount</div><div class="cm-view-value" style="color:var(--green);font-size:16px;">RWF {{ number_format($vc->remuneration, 0) }}</div></div>
                <div class="cm-view-row"><div class="cm-view-label">Frequency</div><div class="cm-view-value">{{ $remunerationTypes[$vc->remuneration_type instanceof \BackedEnum ? $vc->remuneration_type->value : $vc->remuneration_type] ?? ucfirst($vc->remuneration_type instanceof \BackedEnum ? $vc->remuneration_type->value : $vc->remuneration_type ?? '—') }}</div></div>
            </div>

            @if($vc->notes)
                <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.09em;color:var(--ink4);margin:16px 0 8px;">Notes</div>
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;font-size:13.5px;color:var(--ink3);font-weight:500;line-height:1.6;">{{ $vc->notes }}</div>
            @endif
        </div>

        <div class="cm-modal-footer" style="justify-content:flex-end;">
            <button class="cm-btn cm-btn-outline" wire:click="closeView">Close</button>
            <button class="cm-btn cm-btn-primary" wire:click="openEdit('{{ $vc->id }}'); closeView()">
                <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                Edit Contract
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══ DELETE MODAL ════════════════════════════════════════ --}}
@if($showDelete)
<div class="cm-modal-bg" wire:click.self="cancelDelete">
    <div class="cm-modal cm-modal-sm">
        <div class="cm-modal-hd" style="background:linear-gradient(105deg,#991B1B,var(--red));">
            <div class="cm-modal-title">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Delete Contract
            </div>
            <button class="cm-modal-close" wire:click="cancelDelete">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="cm-modal-body" style="text-align:center;padding:28px 24px;">
            <div class="cm-delete-icon">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:800;color:var(--ink);margin-bottom:8px;">Delete this contract?</div>
            <p style="font-size:13.5px;color:var(--ink3);font-weight:500;line-height:1.6;margin:0;">
                This will permanently remove the contract record. Associated payroll or attendance data may be affected. This cannot be undone.
            </p>
        </div>
        <div class="cm-modal-footer" style="justify-content:center;gap:12px;">
            <button class="cm-btn cm-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="cm-btn cm-btn-danger" wire:click="deleteContract">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>
@endif

</div>{{-- /cm-root --}}