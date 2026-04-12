<div class="kpi-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ TOKENS ══════════════════════════════════════════════ */
.kpi-root {
    --blue:    #3B6FE8; --blue-2:  #2755CC; --blue-3: #1A3FA8;
    --blue-lt: rgba(59,111,232,0.09); --blue-mid:rgba(59,111,232,0.18); --blue-brd:rgba(59,111,232,0.22);
    --green:   #12B76A; --green-2: #0D9A57; --green-lt:rgba(18,183,106,0.10); --green-brd:rgba(18,183,106,0.22);
    --amber:   #F59E0B; --amber-lt:rgba(245,158,11,0.10);
    --red:     #EF4444; --red-lt:  rgba(239,68,68,0.09);
    --purple:  #7C3AED; --purple-lt:rgba(124,58,237,0.09);
    --indigo:  #6B4FDB; --indigo-lt:rgba(107,79,219,0.09);
    --bg:    #F0F4FA; --white:#FFFFFF;
    --ink:   #0F1629; --ink2:#2D3356; --ink3:#6B7094; --ink4:#A8ADCA;
    --border:rgba(15,22,41,0.08);
    --sh-sm: 0 2px 10px rgba(18,183,106,0.07); --sh-md:0 8px 28px rgba(18,183,106,0.12); --sh-lg:0 18px 52px rgba(18,183,106,0.16);
    --r:12px; --r-lg:18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background:var(--bg); min-height:100vh; color:var(--ink);
    padding:24px 28px 48px; display:flex; flex-direction:column; gap:20px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.kpi-flash { padding:12px 18px; border-radius:var(--r); font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:9px; }
.kpi-flash-ok  { background:var(--green-lt); border:1px solid var(--green-brd); color:#087A42; }
.kpi-flash-err { background:var(--red-lt);   border:1px solid rgba(239,68,68,0.22); color:#991B1B; }
.kpi-flash svg { width:15px; height:15px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }

/* ══ HERO ════════════════════════════════════════════════ */
.kpi-hero { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); overflow:hidden; }
.kpi-hero-cover { height:72px; background:linear-gradient(118deg,#1A3FA8 0%,var(--green-2) 50%,var(--green) 100%); position:relative; overflow:hidden; }
.kpi-hero-cover::before { content:''; position:absolute; top:-40px; right:80px; width:200px; height:200px; border-radius:50%; background:rgba(255,255,255,0.07); }
.kpi-hero-cover::after  { content:''; position:absolute; bottom:-30px; left:40px; width:130px; height:130px; border-radius:50%; background:rgba(255,255,255,0.04); }
.kpi-hero-body { padding:0 24px 20px; display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin-top:-26px; }
.kpi-hero-icon { width:52px; height:52px; border-radius:14px; background:linear-gradient(135deg,var(--green-2),var(--green)); border:3px solid var(--white); box-shadow:0 4px 14px rgba(18,183,106,0.32); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.kpi-hero-icon svg { width:22px; height:22px; stroke:#fff; fill:none; stroke-width:1.75; }
.kpi-hero-title { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink); letter-spacing:-0.3px; }
.kpi-hero-sub   { font-size:12.5px; color:var(--ink3); margin-top:2px; }
.kpi-stat-strip { display:flex; gap:0; }
.kpi-stat { padding:6px 18px; text-align:center; border-left:1px solid var(--border); }
.kpi-stat:first-child { border-left:none; }
.kpi-stat-val { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink); line-height:1; }
.kpi-stat-lbl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); margin-top:2px; }

/* ══ TILES ═══════════════════════════════════════════════ */
.kpi-tiles { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; }
.kpi-tile  { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:16px; display:flex; align-items:flex-start; gap:12px; position:relative; overflow:hidden; transition:box-shadow .18s,transform .18s; }
.kpi-tile:hover { box-shadow:var(--sh-md); transform:translateY(-2px); }
.kpi-tile-bar { position:absolute; top:0; left:0; width:4px; height:100%; border-radius:20px 0 0 20px; }
.kpi-tile-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.kpi-tile-icon svg { width:16px; height:16px; fill:none; stroke-width:2; }
.kpi-tile-lbl { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--ink4); margin-bottom:3px; }
.kpi-tile-val { font-family:'Sora',sans-serif; font-size:22px; font-weight:800; letter-spacing:-0.4px; line-height:1; }
.kpi-tile-sub { font-size:11px; color:var(--ink4); margin-top:3px; }
.kpi-t-green .kpi-tile-bar{background:var(--green);}  .kpi-t-green .kpi-tile-icon{background:var(--green-lt);}  .kpi-t-green .kpi-tile-icon svg{stroke:var(--green);}  .kpi-t-green .kpi-tile-val{color:var(--green-2);}
.kpi-t-blue  .kpi-tile-bar{background:var(--blue);}   .kpi-t-blue  .kpi-tile-icon{background:var(--blue-lt);}   .kpi-t-blue  .kpi-tile-icon svg{stroke:var(--blue);}   .kpi-t-blue  .kpi-tile-val{color:var(--blue-2);}
.kpi-t-amber .kpi-tile-bar{background:var(--amber);}  .kpi-t-amber .kpi-tile-icon{background:var(--amber-lt);}  .kpi-t-amber .kpi-tile-icon svg{stroke:var(--amber);}  .kpi-t-amber .kpi-tile-val{color:var(--amber);}
.kpi-t-indigo.kpi-tile-bar{background:var(--indigo);} .kpi-t-indigo.kpi-tile-icon{background:var(--indigo-lt);}
.kpi-t-red   .kpi-tile-bar{background:var(--red);}    .kpi-t-red   .kpi-tile-icon{background:var(--red-lt);}    .kpi-t-red   .kpi-tile-icon svg{stroke:var(--red);}    .kpi-t-red   .kpi-tile-val{color:var(--red);}

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.kpi-toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:14px 18px; }
.kpi-search { display:flex; align-items:center; gap:8px; background:var(--bg); border:1.5px solid var(--border); border-radius:10px; padding:8px 13px; flex:1; min-width:200px; transition:border-color .15s,box-shadow .15s; }
.kpi-search:focus-within { border-color:var(--green); box-shadow:0 0 0 3px rgba(18,183,106,0.09); }
.kpi-search svg { width:14px; height:14px; stroke:var(--ink4); fill:none; flex-shrink:0; }
.kpi-search input { border:none; background:transparent; font-size:13.5px; color:var(--ink); outline:none; width:100%; font-family:'DM Sans',sans-serif; }
.kpi-search input::placeholder { color:var(--ink4); }
.kpi-sel { background:var(--bg); border:1.5px solid var(--border); border-radius:10px; padding:8px 30px 8px 12px; font-size:13px; font-weight:600; color:var(--ink2); outline:none; cursor:pointer; font-family:'DM Sans',sans-serif; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; -webkit-appearance:none; transition:border-color .15s; }
.kpi-sel:focus { border-color:var(--green); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.kpi-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:700; border:none; cursor:pointer; transition:all .15s; white-space:nowrap; }
.kpi-btn svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }
.kpi-btn-primary { background:var(--green); color:#fff; box-shadow:0 4px 12px rgba(18,183,106,0.30); }
.kpi-btn-primary:hover { background:var(--green-2); transform:translateY(-1px); }
.kpi-btn-ghost   { background:var(--green-lt); color:var(--green-2); border:1px solid var(--green-brd); }
.kpi-btn-ghost:hover { background:rgba(18,183,106,0.16); }
.kpi-btn-outline { background:var(--white); color:var(--ink2); border:1px solid var(--border); }
.kpi-btn-outline:hover { border-color:var(--green); color:var(--green-2); }
.kpi-btn-blue    { background:var(--blue-lt); color:var(--blue-2); border:1px solid var(--blue-brd); }
.kpi-btn-blue:hover { background:var(--blue-mid); }
.kpi-btn-danger  { background:var(--red-lt); color:var(--red); border:1px solid rgba(239,68,68,0.22); }
.kpi-btn-danger:hover { background:rgba(239,68,68,0.15); }
.kpi-btn-sm { padding:5px 11px; font-size:12px; }

/* ══ BADGES ══════════════════════════════════════════════ */
.kpi-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:100px; font-size:11px; font-weight:700; }
.kb-green  { background:var(--green-lt);  color:#087A42; }
.kb-amber  { background:var(--amber-lt);  color:#92400E; }
.kb-red    { background:var(--red-lt);    color:#991B1B; }
.kb-blue   { background:var(--blue-lt);   color:var(--blue-2); }
.kb-indigo { background:var(--indigo-lt); color:var(--indigo); }
.kb-purple { background:var(--purple-lt); color:var(--purple); }
.kb-gray   { background:var(--bg); color:var(--ink3); border:1px solid var(--border); }

/* ══ PERIOD PILL ═════════════════════════════════════════ */
.kpi-period-pill { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:8px; font-size:11.5px; font-weight:700; }
.kpi-period-pill svg { width:10px; height:10px; stroke:currentColor; fill:none; stroke-width:2; }
.kpp-monthly   { background:var(--blue-lt);   color:var(--blue-2); }
.kpp-quarterly { background:var(--indigo-lt); color:var(--indigo); }
.kpp-annual    { background:var(--purple-lt); color:var(--purple); }
.kpp-weekly    { background:var(--green-lt);  color:#087A42; }
.kpp-daily     { background:var(--amber-lt);  color:#92400E; }

/* ══ SCORE RING ══════════════════════════════════════════ */
.kpi-score-cell { display:flex; flex-direction:column; align-items:flex-start; gap:4px; }
.kpi-score-val  { font-family:'Sora',sans-serif; font-size:15px; font-weight:800; color:var(--green-2); }
.kpi-score-bar  { width:72px; height:5px; background:var(--bg); border-radius:100px; overflow:hidden; }
.kpi-score-fill { height:100%; border-radius:100px; transition:width .4s; }

/* ══ TABLE CARD ══════════════════════════════════════════ */
.kpi-card { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); overflow:hidden; }
.kpi-card-hd { display:flex; align-items:center; justify-content:space-between; padding:15px 20px; border-bottom:1px solid var(--border); }
.kpi-card-hd-left { display:flex; align-items:center; gap:9px; }
.kpi-card-ico { width:30px; height:30px; border-radius:8px; background:var(--green-lt); border:1px solid var(--green-brd); display:flex; align-items:center; justify-content:center; }
.kpi-card-ico svg { width:14px; height:14px; stroke:var(--green-2); fill:none; stroke-width:2; }
.kpi-card-title { font-family:'Sora',sans-serif; font-size:14px; font-weight:800; color:var(--ink); }
.kpi-card-sub   { font-size:11.5px; color:var(--ink4); margin-top:1px; }
.kpi-table-wrap { overflow-x:auto; }
table.kpi-table { width:100%; border-collapse:collapse; }
.kpi-table thead tr { background:#FAFBFF; border-bottom:1px solid var(--border); }
.kpi-table th { padding:10px 16px; font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); text-align:left; white-space:nowrap; }
.kpi-table tbody tr { border-bottom:1px solid var(--border); transition:background .12s; }
.kpi-table tbody tr:last-child { border-bottom:none; }
.kpi-table tbody tr:hover { background:#F8FFF9; }
.kpi-table td { padding:12px 16px; font-size:13px; color:var(--ink2); }
.kpi-code { font-family:'Sora',sans-serif; font-size:11px; font-weight:800; background:var(--green-lt); color:var(--green-2); border:1px solid var(--green-brd); padding:3px 9px; border-radius:7px; letter-spacing:.04em; }
.kpi-emp-cell { display:flex; align-items:center; gap:9px; }
.kpi-emp-av   { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,var(--green-2),var(--blue)); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11px; font-weight:800; color:#fff; flex-shrink:0; }
.kpi-emp-name { font-size:13px; font-weight:700; color:var(--ink); }
.kpi-emp-dept { font-size:11px; color:var(--ink4); }
.kpi-actions  { display:flex; gap:5px; align-items:center; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.kpi-empty { padding:56px 32px; text-align:center; display:flex; flex-direction:column; align-items:center; gap:10px; }
.kpi-empty-icon { width:52px; height:52px; border-radius:14px; background:var(--green-lt); display:flex; align-items:center; justify-content:center; margin-bottom:4px; }
.kpi-empty-icon svg { width:22px; height:22px; stroke:var(--green-2); fill:none; stroke-width:1.5; }
.kpi-empty-ttl { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--ink2); }
.kpi-empty-sub { font-size:13px; color:var(--ink4); }

/* ══ MODAL ═══════════════════════════════════════════════ */
.kpi-modal-bg { position:fixed; inset:0; background:rgba(15,22,41,0.52); backdrop-filter:blur(10px); z-index:9000; display:flex; align-items:center; justify-content:center; padding:16px; }
.kpi-modal { background:var(--white); border-radius:var(--r-lg); box-shadow:var(--sh-lg); border:1px solid var(--border); width:100%; max-width:680px; max-height:93vh; overflow-y:auto; display:flex; flex-direction:column; }
.kpi-modal-lg { max-width:760px; }
.kpi-modal-hd { background:linear-gradient(105deg,#1A3FA8 0%,var(--green-2) 60%,var(--green) 100%); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; position:sticky; top:0; z-index:2; }
.kpi-modal-hd-left { display:flex; align-items:center; gap:12px; }
.kpi-modal-hd-icon { width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.18); display:flex; align-items:center; justify-content:center; }
.kpi-modal-hd-icon svg { width:17px; height:17px; stroke:#fff; fill:none; stroke-width:2; }
.kpi-modal-title { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:#fff; }
.kpi-modal-sub   { font-size:12px; color:rgba(255,255,255,.65); margin-top:1px; }
.kpi-modal-close { width:32px; height:32px; border-radius:9px; background:rgba(255,255,255,0.18); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .15s; flex-shrink:0; }
.kpi-modal-close:hover { background:rgba(255,255,255,0.30); }
.kpi-modal-close svg { width:14px; height:14px; stroke:#fff; fill:none; stroke-width:2.5; }
.kpi-modal-body { padding:22px 24px; display:flex; flex-direction:column; gap:16px; }
.kpi-modal-footer { padding:16px 24px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px; flex-shrink:0; position:sticky; bottom:0; background:var(--white); z-index:2; }

/* ── Fields ──────────────────────────────────────────── */
.kpi-field { display:flex; flex-direction:column; gap:5px; }
.kpi-field label { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.09em; color:var(--ink4); }
.kpi-field label .req { color:var(--red); }
.kpi-field input, .kpi-field select, .kpi-field textarea { width:100%; padding:9px 13px; box-sizing:border-box; background:#F6F8FC; border:1.5px solid var(--border); border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--ink); outline:none; transition:border-color .15s,box-shadow .15s; }
.kpi-field input:focus, .kpi-field select:focus { border-color:var(--green); box-shadow:0 0 0 3px rgba(18,183,106,0.09); background:var(--white); }
.kpi-field input[readonly] { background:var(--bg); color:var(--ink3); cursor:default; }
.kpi-field-err { font-size:11.5px; color:var(--red); font-weight:600; margin-top:2px; }
.kpi-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.kpi-grid3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
.kpi-section-lbl { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.10em; color:var(--ink4); padding:4px 0 2px; border-bottom:1px solid var(--border); }

/* ── Calc preview ────────────────────────────────────── */
.kpi-calc-preview { background:linear-gradient(105deg,rgba(18,183,106,0.06),rgba(59,111,232,0.06)); border:1px solid var(--green-brd); border-radius:var(--r); padding:14px 16px; display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.kpi-calc-item { text-align:center; }
.kpi-calc-lbl  { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); margin-bottom:4px; }
.kpi-calc-val  { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--green-2); }
.kpi-calc-item.kpi-calc-score .kpi-calc-val { color:var(--blue-2); font-size:18px; }

/* ══ VIEW MODAL ══════════════════════════════════════════ */
.kpi-view-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.kpi-view-row  { display:flex; flex-direction:column; gap:3px; padding:10px 14px; background:var(--bg); border-radius:10px; border:1px solid var(--border); }
.kpi-view-row.full { grid-column:1 / -1; }
.kpi-view-lbl  { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); }
.kpi-view-val  { font-size:13.5px; font-weight:600; color:var(--ink); }

/* ── Achievement breakdown ───────────────────────────── */
.kpi-breakdown { background:linear-gradient(105deg,rgba(18,183,106,0.07),rgba(59,111,232,0.05)); border:1px solid var(--green-brd); border-radius:var(--r); padding:16px 18px; grid-column:1 / -1; }
.kpi-bd-title  { font-family:'Sora',sans-serif; font-size:12px; font-weight:800; color:var(--green-2); margin-bottom:12px; text-transform:uppercase; letter-spacing:.06em; }
.kpi-bd-row    { display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:1px solid rgba(18,183,106,0.10); font-size:13px; }
.kpi-bd-row:last-child { border-bottom:none; font-weight:800; font-size:14px; }
.kpi-bd-row span:first-child { color:var(--ink3); font-weight:600; }
.kpi-bd-row span:last-child  { font-family:'Sora',sans-serif; font-weight:800; color:var(--ink); }
.kpi-pct-bar { width:100%; height:8px; background:var(--bg); border-radius:100px; overflow:hidden; margin-top:10px; }
.kpi-pct-fill{ height:100%; border-radius:100px; transition:width .5s; }

/* ══ DELETE ══════════════════════════════════════════════ */
.kpi-del-modal { max-width:420px; }
.kpi-del-body  { padding:28px 26px; text-align:center; }
.kpi-del-icon  { width:52px; height:52px; border-radius:50%; background:var(--red-lt); border:1px solid rgba(239,68,68,0.22); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.kpi-del-icon svg { width:22px; height:22px; stroke:var(--red); fill:none; stroke-width:2; }
.kpi-del-ttl   { font-family:'Sora',sans-serif; font-size:17px; font-weight:800; color:var(--ink); margin-bottom:8px; }
.kpi-del-sub   { font-size:13px; color:var(--ink3); line-height:1.6; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.kpi-pager { padding:14px 20px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.kpi-pager-info { font-size:12.5px; color:var(--ink4); font-weight:600; }

@media (max-width:768px) { .kpi-grid2,.kpi-grid3{grid-template-columns:1fr;} .kpi-view-grid{grid-template-columns:1fr;} .kpi-tiles{grid-template-columns:1fr 1fr;} .kpi-calc-preview{grid-template-columns:1fr;} }
@media (max-width:480px) { .kpi-tiles{grid-template-columns:1fr;} }
</style>

{{-- ── Flash ────────────────────────────────────────────── --}}
@if(session()->has('success'))
    <div class="kpi-flash kpi-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="kpi-flash kpi-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ HERO ════════════════════════════════════════════════ --}}
<div class="kpi-hero">
    <div class="kpi-hero-cover"></div>
    <div class="kpi-hero-body">
        <div style="display:flex;align-items:flex-end;gap:14px;">
            <div class="kpi-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <div class="kpi-hero-title">KPI Management</div>
                <div class="kpi-hero-sub">Define, track and approve key performance indicators per employee and period</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;padding-bottom:4px;">
            <div class="kpi-stat-strip">
                <div class="kpi-stat"><div class="kpi-stat-val">{{ $totalCount }}</div><div class="kpi-stat-lbl">Total</div></div>
                <div class="kpi-stat"><div class="kpi-stat-val" style="color:var(--green-2)">{{ $approvedCount }}</div><div class="kpi-stat-lbl">Approved</div></div>
                <div class="kpi-stat"><div class="kpi-stat-val" style="color:var(--amber)">{{ $pendingCount }}</div><div class="kpi-stat-lbl">Pending</div></div>
                <div class="kpi-stat"><div class="kpi-stat-val" style="color:var(--blue-2)">{{ $avgAchievement }}%</div><div class="kpi-stat-lbl">Avg. Achievement</div></div>
            </div>
            <button class="kpi-btn kpi-btn-primary" wire:click="openCreate">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New KPI
            </button>
        </div>
    </div>
</div>

{{-- ══ STAT TILES ══════════════════════════════════════════ --}}
<div class="kpi-tiles">
    <div class="kpi-tile kpi-t-green">
        <div class="kpi-tile-bar"></div>
        <div class="kpi-tile-icon"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
        <div><div class="kpi-tile-lbl">Total KPIs</div><div class="kpi-tile-val">{{ $totalCount }}</div><div class="kpi-tile-sub">all records</div></div>
    </div>
    <div class="kpi-tile kpi-t-green">
        <div class="kpi-tile-bar"></div>
        <div class="kpi-tile-icon"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div><div class="kpi-tile-lbl">Approved</div><div class="kpi-tile-val">{{ $approvedCount }}</div><div class="kpi-tile-sub">approved KPIs</div></div>
    </div>
    <div class="kpi-tile kpi-t-blue">
        <div class="kpi-tile-bar"></div>
        <div class="kpi-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="kpi-tile-lbl">Avg. Achievement</div><div class="kpi-tile-val">{{ $avgAchievement }}%</div><div class="kpi-tile-sub">across approved KPIs</div></div>
    </div>
    <div class="kpi-tile kpi-t-amber">
        <div class="kpi-tile-bar"></div>
        <div class="kpi-tile-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
        <div><div class="kpi-tile-lbl">Avg. Score</div><div class="kpi-tile-val">{{ $avgScore }}</div><div class="kpi-tile-sub">out of 10</div></div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="kpi-toolbar">
    <div class="kpi-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search code or employee name…">
    </div>
    <select class="kpi-sel" wire:model.live="filterEmployee">
        <option value="">All Employees</option>
        @foreach($employees as $emp)
            <option value="{{ $emp['id'] }}">{{ $emp['first_name'] }} {{ $emp['last_name'] }}</option>
        @endforeach
    </select>
    <select class="kpi-sel" wire:model.live="filterPeriod">
        <option value="">All Periods</option>
        @foreach($periodTypes as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="kpi-sel" wire:model.live="filterApproval">
        <option value="">All Approvals</option>
        @foreach($approvalStatuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
</div>

{{-- ══ TABLE ═══════════════════════════════════════════════ --}}
<div class="kpi-card">
    <div class="kpi-card-hd">
        <div class="kpi-card-hd-left">
            <div class="kpi-card-ico">
                <svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <div class="kpi-card-title">KPI Register</div>
                <div class="kpi-card-sub">{{ $records->total() }} record{{ $records->total() != 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>

    <div class="kpi-table-wrap">
        <table class="kpi-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Target</th>
                    <th>Actual</th>
                    <th>Achievement</th>
                    <th>Score</th>
                    <th>Approval</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $row)
                    @php
                        $emp     = $row->employee;
                        $empInit = $emp ? strtoupper(substr($emp->first_name??'',0,1).substr($emp->last_name??'',0,1)) : '??';
                        $pt      = $row->period_type instanceof \BackedEnum ? $row->period_type->value : ($row->period_type ?? '');
                        $ap      = $row->approval_status instanceof \BackedEnum ? $row->approval_status->value : ($row->approval_status ?? 'pending');
                        $apCls   = match($ap) { 'approved'=>'kb-green','rejected'=>'kb-red','cancelled'=>'kb-red','draft'=>'kb-gray', default=>'kb-amber' };
                        $ppCls   = 'kpp-'.($pt ?: 'monthly');
                        $pct     = (float)($row->achievement_percentage ?? 0);
                        $pctColor= $pct >= 100 ? 'var(--green)' : ($pct >= 70 ? 'var(--amber)' : 'var(--red)');
                        $score   = (float)($row->score ?? 0);
                    @endphp
                    <tr>
                        <td><span class="kpi-code">{{ $row->code }}</span></td>
                        <td>
                            <div class="kpi-emp-cell">
                                <div class="kpi-emp-av">{{ $empInit }}</div>
                                <div>
                                    <div class="kpi-emp-name">{{ $emp ? trim(($emp->first_name??'').' '.($emp->last_name??'')) : '—' }}</div>
                                    <div class="kpi-emp-dept">{{ $emp?->department?->name ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="kpi-period-pill {{ $ppCls }}">
                                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ ucfirst($pt) }}
                            </span>
                            <div style="font-size:11px;color:var(--ink4);margin-top:3px;">
                                {{ \Carbon\Carbon::parse($row->period_start)->format('M d') }} – {{ \Carbon\Carbon::parse($row->period_end)->format('M d, Y') }}
                            </div>
                        </td>
                        <td>
                            <div style="font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--ink);">{{ number_format($row->target_value, 2) }}</div>
                        </td>
                        <td>
                            @if($row->actual_value !== null)
                                <div style="font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--blue-2);">{{ number_format($row->actual_value, 2) }}</div>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($row->achievement_percentage !== null)
                                <div class="kpi-score-cell">
                                    <div class="kpi-score-val" style="color:{{ $pctColor }};">{{ number_format($pct, 1) }}%</div>
                                    <div class="kpi-score-bar">
                                        <div class="kpi-score-fill" style="width:{{ min($pct,100) }}%;background:{{ $pctColor }};"></div>
                                    </div>
                                </div>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($row->score !== null)
                                <span style="font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--indigo);">{{ number_format($score, 1) }}<span style="font-size:10px;color:var(--ink4);font-family:'DM Sans',sans-serif;">/10</span></span>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td><span class="kpi-badge {{ $apCls }}">{{ ucfirst($ap) }}</span></td>
                        <td>
                            <div class="kpi-actions">
                                <button class="kpi-btn kpi-btn-ghost kpi-btn-sm" wire:click="openView('{{ $row->id }}')" title="View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="kpi-btn kpi-btn-outline kpi-btn-sm" wire:click="openEdit('{{ $row->id }}')" title="Edit">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                @if($ap !== 'approved')
                                    <button class="kpi-btn kpi-btn-blue kpi-btn-sm" wire:click="approve('{{ $row->id }}')" wire:confirm="Approve this KPI?" title="Approve">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                @endif
                                <button class="kpi-btn kpi-btn-danger kpi-btn-sm" wire:click="confirmDelete('{{ $row->id }}')" title="Delete">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="kpi-empty">
                                <div class="kpi-empty-icon"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
                                <div class="kpi-empty-ttl">No KPIs found</div>
                                <div class="kpi-empty-sub">{{ $search || $filterApproval || $filterPeriod || $filterEmployee ? 'Try adjusting your filters.' : 'Click "New KPI" to get started.' }}</div>
                                @unless($search || $filterApproval || $filterPeriod || $filterEmployee)
                                    <button class="kpi-btn kpi-btn-primary" wire:click="openCreate" style="margin-top:8px;">
                                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Create First KPI
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
        <div class="kpi-pager">
            <div class="kpi-pager-info">Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of {{ $records->total() }}</div>
            {{ $records->links() }}
        </div>
    @endif
</div>

{{-- ══ CREATE / EDIT MODAL ════════════════════════════════ --}}
@if($showModal)
<div class="kpi-modal-bg" wire:click.self="closeModal">
    <div class="kpi-modal kpi-modal-lg">

        <div class="kpi-modal-hd">
            <div class="kpi-modal-hd-left">
                <div class="kpi-modal-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <div>
                    <div class="kpi-modal-title">{{ $editingId ? 'Edit KPI' : 'New KPI' }}</div>
                    <div class="kpi-modal-sub">Achievement % and score are auto-calculated from target and actual values</div>
                </div>
            </div>
            <button class="kpi-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="kpi-modal-body">

            {{-- Identifiers --}}
            <div class="kpi-grid2">
                <div class="kpi-field">
                    <label>KPI Code <span class="req">*</span></label>
                    <input type="text" wire:model="code" placeholder="KPI-0001" style="text-transform:uppercase;">
                    @error('code')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpi-field">
                    <label>Employee <span class="req">*</span></label>
                    <select wire:model="employeeId">
                        <option value="">— Select employee —</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp['id'] }}">{{ $emp['first_name'] }} {{ $emp['last_name'] }}</option>
                        @endforeach
                    </select>
                    @error('employeeId')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="kpi-field">
                <label>Parent KPI (optional)</label>
                <select wire:model="kpiId">
                    <option value="">— None —</option>
                    @foreach($parentKpis as $pk)
                        <option value="{{ $pk['id'] }}">{{ $pk['code'] }}</option>
                    @endforeach
                </select>
                @error('kpiId')<div class="kpi-field-err">{{ $message }}</div>@enderror
            </div>

            {{-- Period --}}
            <div class="kpi-section-lbl">Period</div>
            <div class="kpi-grid3">
                <div class="kpi-field">
                    <label>Period Type <span class="req">*</span></label>
                    <select wire:model="periodType">
                        <option value="">— Select —</option>
                        @foreach($periodTypes as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('periodType')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpi-field">
                    <label>Period Start <span class="req">*</span></label>
                    <input type="date" wire:model="periodStart">
                    @error('periodStart')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpi-field">
                    <label>Period End <span class="req">*</span></label>
                    <input type="date" wire:model="periodEnd">
                    @error('periodEnd')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Values --}}
            <div class="kpi-section-lbl">Values</div>
            <div class="kpi-grid2">
                <div class="kpi-field">
                    <label>Target Value <span class="req">*</span></label>
                    <input type="number" wire:model.live="targetValue" placeholder="0.00" step="0.01" min="0">
                    @error('targetValue')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpi-field">
                    <label>Actual Value</label>
                    <input type="number" wire:model.live="actualValue" placeholder="0.00" step="0.01" min="0">
                    @error('actualValue')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Calc preview --}}
            <div class="kpi-calc-preview">
                <div class="kpi-calc-item">
                    <div class="kpi-calc-lbl">Achievement %</div>
                    <div class="kpi-calc-val">{{ $achievementPercentage !== '' ? number_format((float)$achievementPercentage, 1).'%' : '—' }}</div>
                </div>
                <div class="kpi-calc-item kpi-calc-score">
                    <div class="kpi-calc-lbl">Score (0–10)</div>
                    <div class="kpi-calc-val">{{ $score !== '' ? number_format((float)$score, 1) : '—' }}</div>
                </div>
            </div>

            {{-- Auto-filled fields --}}
            <div class="kpi-grid2">
                <div class="kpi-field">
                    <label>Achievement % (auto-calculated)</label>
                    <input type="number" wire:model="achievementPercentage" placeholder="—" step="0.01" readonly>
                    @error('achievementPercentage')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpi-field">
                    <label>Score (auto-calculated)</label>
                    <input type="number" wire:model="score" placeholder="—" step="0.01" readonly>
                    @error('score')<div class="kpi-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="kpi-section-lbl">Status</div>
            <div class="kpi-field">
                <label>Approval Status <span class="req">*</span></label>
                <select wire:model="approvalStatus">
                    @foreach($approvalStatuses as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('approvalStatus')<div class="kpi-field-err">{{ $message }}</div>@enderror
            </div>

        </div>{{-- /body --}}

        <div class="kpi-modal-footer">
            <button class="kpi-btn kpi-btn-outline" wire:click="closeModal">Cancel</button>
            <button class="kpi-btn kpi-btn-primary" wire:click="save" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update' : 'Create' }} KPI</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewRecord)
<div class="kpi-modal-bg" wire:click.self="closeView">
    <div class="kpi-modal kpi-modal-lg">
        <div class="kpi-modal-hd">
            <div class="kpi-modal-hd-left">
                <div class="kpi-modal-hd-icon"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                <div>
                    <div class="kpi-modal-title">{{ $viewRecord->code }}</div>
                    <div class="kpi-modal-sub">{{ $viewRecord->employee ? trim(($viewRecord->employee->first_name??'').' '.($viewRecord->employee->last_name??'')) : '—' }}</div>
                </div>
            </div>
            <button class="kpi-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="kpi-modal-body" style="padding-top:20px;">
            @php
                $vAp   = $viewRecord->approval_status instanceof \BackedEnum ? $viewRecord->approval_status->value : ($viewRecord->approval_status ?? 'pending');
                $vApCls= match($vAp){ 'approved'=>'kb-green','rejected'=>'kb-red','cancelled'=>'kb-red','draft'=>'kb-gray', default=>'kb-amber' };
                $vPt   = $viewRecord->period_type instanceof \BackedEnum ? $viewRecord->period_type->value : ($viewRecord->period_type ?? '');
                $vPct  = (float)($viewRecord->achievement_percentage ?? 0);
                $vPctColor = $vPct >= 100 ? 'var(--green)' : ($vPct >= 70 ? 'var(--amber)' : 'var(--red)');
            @endphp
            <div class="kpi-view-grid">
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Code</div>
                    <div class="kpi-view-val"><span class="kpi-code">{{ $viewRecord->code }}</span></div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Approval Status</div>
                    <div class="kpi-view-val"><span class="kpi-badge {{ $vApCls }}">{{ ucfirst($vAp) }}</span></div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Employee</div>
                    <div class="kpi-view-val">{{ $viewRecord->employee ? trim(($viewRecord->employee->first_name??'').' '.($viewRecord->employee->last_name??'')) : '—' }}</div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Period Type</div>
                    <div class="kpi-view-val">{{ ucfirst($vPt) }}</div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Period Start</div>
                    <div class="kpi-view-val">{{ \Carbon\Carbon::parse($viewRecord->period_start)->format('l, M d, Y') }}</div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Period End</div>
                    <div class="kpi-view-val">{{ \Carbon\Carbon::parse($viewRecord->period_end)->format('l, M d, Y') }}</div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Parent KPI</div>
                    <div class="kpi-view-val">{{ $viewRecord->parentKpi?->code ?? '—' }}</div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Linked Targets</div>
                    <div class="kpi-view-val"><span class="kpi-badge kb-blue">{{ $viewRecord->targets?->count() ?? 0 }} target(s)</span></div>
                </div>

                {{-- Breakdown --}}
                <div class="kpi-breakdown">
                    <div class="kpi-bd-title">Performance Breakdown</div>
                    <div class="kpi-bd-row">
                        <span>Target Value</span>
                        <span>{{ number_format($viewRecord->target_value, 2) }}</span>
                    </div>
                    <div class="kpi-bd-row">
                        <span>Actual Value</span>
                        <span>{{ $viewRecord->actual_value !== null ? number_format($viewRecord->actual_value, 2) : '—' }}</span>
                    </div>
                    <div class="kpi-bd-row">
                        <span>Achievement</span>
                        <span style="color:{{ $vPctColor }};">{{ $viewRecord->achievement_percentage !== null ? number_format($viewRecord->achievement_percentage, 2).'%' : '—' }}</span>
                    </div>
                    <div class="kpi-bd-row">
                        <span>Score</span>
                        <span style="color:var(--indigo);">{{ $viewRecord->score !== null ? number_format($viewRecord->score, 2).' / 10' : '—' }}</span>
                    </div>
                    @if($viewRecord->achievement_percentage !== null)
                        <div class="kpi-pct-bar">
                            <div class="kpi-pct-fill" style="width:{{ min($vPct,100) }}%;background:{{ $vPctColor }};"></div>
                        </div>
                    @endif
                </div>

                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Created</div>
                    <div class="kpi-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->created_at)->format('M d, Y · H:i') }}</div>
                </div>
                <div class="kpi-view-row">
                    <div class="kpi-view-lbl">Last Updated</div>
                    <div class="kpi-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->updated_at)->format('M d, Y · H:i') }}</div>
                </div>
            </div>
        </div>
        <div class="kpi-modal-footer">
            <button class="kpi-btn kpi-btn-outline" wire:click="closeView">Close</button>
            <button class="kpi-btn kpi-btn-ghost" wire:click="openEdit('{{ $viewRecord->id }}'); closeView()">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </button>
            @if($vAp !== 'approved')
                <button class="kpi-btn kpi-btn-blue" wire:click="approve('{{ $viewRecord->id }}'); closeView()" wire:confirm="Approve this KPI?">
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
<div class="kpi-modal-bg" wire:click.self="cancelDelete">
    <div class="kpi-modal kpi-del-modal">
        <div class="kpi-del-body">
            <div class="kpi-del-icon"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></div>
            <div class="kpi-del-ttl">Delete KPI?</div>
            <div class="kpi-del-sub">This will permanently remove this KPI. KPIs with linked targets cannot be deleted — remove targets first.</div>
        </div>
        <div class="kpi-modal-footer" style="justify-content:center;gap:12px;">
            <button class="kpi-btn kpi-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="kpi-btn kpi-btn-danger" wire:click="deleteRecord" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                <span wire:loading.remove wire:target="deleteRecord">Yes, Delete</span>
                <span wire:loading wire:target="deleteRecord">Deleting…</span>
            </button>
        </div>
    </div>
</div>
@endif

</div>{{-- /kpi-root --}}
