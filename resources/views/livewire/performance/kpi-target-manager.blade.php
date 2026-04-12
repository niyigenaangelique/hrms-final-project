<div class="kpit-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ TOKENS ══════════════════════════════════════════════ */
.kpit-root {
    --blue:    #3B6FE8; --blue-2:  #2755CC; --blue-3: #1A3FA8;
    --blue-lt: rgba(59,111,232,0.09); --blue-mid:rgba(59,111,232,0.18); --blue-brd:rgba(59,111,232,0.22);
    --teal:    #0BB5B5; --teal-2:  #099494; --teal-lt:rgba(11,181,181,0.10); --teal-brd:rgba(11,181,181,0.22);
    --green:   #12B76A; --green-lt:rgba(18,183,106,0.10);
    --amber:   #F59E0B; --amber-lt:rgba(245,158,11,0.10);
    --red:     #EF4444; --red-lt:  rgba(239,68,68,0.09);
    --indigo:  #6B4FDB; --indigo-lt:rgba(107,79,219,0.09); --indigo-brd:rgba(107,79,219,0.20);
    --purple:  #7C3AED; --purple-lt:rgba(124,58,237,0.09);
    --bg:    #F0F4FA; --white:#FFFFFF;
    --ink:   #0F1629; --ink2:#2D3356; --ink3:#6B7094; --ink4:#A8ADCA;
    --border:rgba(15,22,41,0.08);
    --sh-sm: 0 2px 10px rgba(11,181,181,0.07); --sh-md:0 8px 28px rgba(11,181,181,0.12); --sh-lg:0 18px 52px rgba(11,181,181,0.16);
    --r:12px; --r-lg:18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background:var(--bg); min-height:100vh; color:var(--ink);
    padding:24px 28px 48px; display:flex; flex-direction:column; gap:20px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.kpit-flash { padding:12px 18px; border-radius:var(--r); font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:9px; }
.kpit-flash-ok  { background:var(--teal-lt); border:1px solid var(--teal-brd); color:#0E7490; }
.kpit-flash-err { background:var(--red-lt);  border:1px solid rgba(239,68,68,0.22); color:#991B1B; }
.kpit-flash svg { width:15px; height:15px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }

/* ══ HERO ════════════════════════════════════════════════ */
.kpit-hero { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); overflow:hidden; }
.kpit-hero-cover { height:72px; background:linear-gradient(118deg,#1A3FA8 0%,var(--teal-2) 50%,var(--teal) 100%); position:relative; overflow:hidden; }
.kpit-hero-cover::before { content:''; position:absolute; top:-40px; right:80px; width:200px; height:200px; border-radius:50%; background:rgba(255,255,255,0.07); }
.kpit-hero-cover::after  { content:''; position:absolute; bottom:-30px; left:40px; width:130px; height:130px; border-radius:50%; background:rgba(255,255,255,0.04); }
.kpit-hero-body { padding:0 24px 20px; display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin-top:-26px; }
.kpit-hero-icon { width:52px; height:52px; border-radius:14px; background:linear-gradient(135deg,var(--teal-2),var(--teal)); border:3px solid var(--white); box-shadow:0 4px 14px rgba(11,181,181,0.32); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.kpit-hero-icon svg { width:22px; height:22px; stroke:#fff; fill:none; stroke-width:1.75; }
.kpit-hero-title { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink); letter-spacing:-0.3px; }
.kpit-hero-sub   { font-size:12.5px; color:var(--ink3); margin-top:2px; }
.kpit-stat-strip { display:flex; gap:0; }
.kpit-stat { padding:6px 18px; text-align:center; border-left:1px solid var(--border); }
.kpit-stat:first-child { border-left:none; }
.kpit-stat-val { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink); line-height:1; }
.kpit-stat-lbl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); margin-top:2px; }

/* ══ TILES ═══════════════════════════════════════════════ */
.kpit-tiles { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; }
.kpit-tile  { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:16px; display:flex; align-items:flex-start; gap:12px; position:relative; overflow:hidden; transition:box-shadow .18s,transform .18s; }
.kpit-tile:hover { box-shadow:var(--sh-md); transform:translateY(-2px); }
.kpit-tile-bar { position:absolute; top:0; left:0; width:4px; height:100%; border-radius:20px 0 0 20px; }
.kpit-tile-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.kpit-tile-icon svg { width:16px; height:16px; fill:none; stroke-width:2; }
.kpit-tile-lbl { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--ink4); margin-bottom:3px; }
.kpit-tile-val { font-family:'Sora',sans-serif; font-size:22px; font-weight:800; letter-spacing:-0.4px; line-height:1; }
.kpit-tile-sub { font-size:11px; color:var(--ink4); margin-top:3px; }
.kpit-t-teal   .kpit-tile-bar{background:var(--teal);}   .kpit-t-teal   .kpit-tile-icon{background:var(--teal-lt);}   .kpit-t-teal   .kpit-tile-icon svg{stroke:var(--teal-2);}   .kpit-t-teal   .kpit-tile-val{color:var(--teal-2);}
.kpit-t-blue   .kpit-tile-bar{background:var(--blue);}   .kpit-t-blue   .kpit-tile-icon{background:var(--blue-lt);}   .kpit-t-blue   .kpit-tile-icon svg{stroke:var(--blue);}   .kpit-t-blue   .kpit-tile-val{color:var(--blue-2);}
.kpit-t-green  .kpit-tile-bar{background:var(--green);}  .kpit-t-green  .kpit-tile-icon{background:var(--green-lt);}  .kpit-t-green  .kpit-tile-icon svg{stroke:var(--green);}  .kpit-t-green  .kpit-tile-val{color:var(--green);}
.kpit-t-amber  .kpit-tile-bar{background:var(--amber);}  .kpit-t-amber  .kpit-tile-icon{background:var(--amber-lt);}  .kpit-t-amber  .kpit-tile-icon svg{stroke:var(--amber);}  .kpit-t-amber  .kpit-tile-val{color:var(--amber);}
.kpit-t-indigo .kpit-tile-bar{background:var(--indigo);} .kpit-t-indigo .kpit-tile-icon{background:var(--indigo-lt);} .kpit-t-indigo .kpit-tile-icon svg{stroke:var(--indigo);} .kpit-t-indigo .kpit-tile-val{color:var(--indigo);}

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.kpit-toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:14px 18px; }
.kpit-search { display:flex; align-items:center; gap:8px; background:var(--bg); border:1.5px solid var(--border); border-radius:10px; padding:8px 13px; flex:1; min-width:180px; transition:border-color .15s,box-shadow .15s; }
.kpit-search:focus-within { border-color:var(--teal); box-shadow:0 0 0 3px rgba(11,181,181,0.09); }
.kpit-search svg { width:14px; height:14px; stroke:var(--ink4); fill:none; flex-shrink:0; }
.kpit-search input { border:none; background:transparent; font-size:13.5px; color:var(--ink); outline:none; width:100%; font-family:'DM Sans',sans-serif; }
.kpit-search input::placeholder { color:var(--ink4); }
.kpit-sel { background:var(--bg); border:1.5px solid var(--border); border-radius:10px; padding:8px 30px 8px 12px; font-size:13px; font-weight:600; color:var(--ink2); outline:none; cursor:pointer; font-family:'DM Sans',sans-serif; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; -webkit-appearance:none; transition:border-color .15s; }
.kpit-sel:focus { border-color:var(--teal); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.kpit-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:700; border:none; cursor:pointer; transition:all .15s; white-space:nowrap; }
.kpit-btn svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }
.kpit-btn-primary { background:var(--teal); color:#fff; box-shadow:0 4px 12px rgba(11,181,181,0.30); }
.kpit-btn-primary:hover { background:var(--teal-2); transform:translateY(-1px); }
.kpit-btn-ghost   { background:var(--teal-lt); color:var(--teal-2); border:1px solid var(--teal-brd); }
.kpit-btn-ghost:hover { background:rgba(11,181,181,0.16); }
.kpit-btn-outline { background:var(--white); color:var(--ink2); border:1px solid var(--border); }
.kpit-btn-outline:hover { border-color:var(--teal); color:var(--teal-2); }
.kpit-btn-green  { background:var(--green-lt); color:#087A42; border:1px solid rgba(18,183,106,0.22); }
.kpit-btn-green:hover { background:rgba(18,183,106,0.16); }
.kpit-btn-danger { background:var(--red-lt); color:var(--red); border:1px solid rgba(239,68,68,0.22); }
.kpit-btn-danger:hover { background:rgba(239,68,68,0.15); }
.kpit-btn-sm { padding:5px 11px; font-size:12px; }

/* ══ BADGES ══════════════════════════════════════════════ */
.kpit-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:100px; font-size:11px; font-weight:700; }
.ktb-teal   { background:var(--teal-lt);  color:#0E7490; }
.ktb-green  { background:var(--green-lt); color:#087A42; }
.ktb-amber  { background:var(--amber-lt); color:#92400E; }
.ktb-red    { background:var(--red-lt);   color:#991B1B; }
.ktb-blue   { background:var(--blue-lt);  color:var(--blue-2); }
.ktb-indigo { background:var(--indigo-lt);color:var(--indigo); }
.ktb-gray   { background:var(--bg); color:var(--ink3); border:1px solid var(--border); }

/* ══ PERIOD PILL ═════════════════════════════════════════ */
.kpit-period-pill { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:8px; font-size:11.5px; font-weight:700; }
.kpit-period-pill svg { width:10px; height:10px; stroke:currentColor; fill:none; stroke-width:2; }
.kptp-monthly   { background:var(--blue-lt);   color:var(--blue-2); }
.kptp-quarterly { background:var(--indigo-lt); color:var(--indigo); }
.kptp-annual    { background:var(--purple-lt); color:var(--purple); }
.kptp-weekly    { background:var(--teal-lt);   color:#0E7490; }
.kptp-daily     { background:var(--amber-lt);  color:#92400E; }

/* ══ SCORE DISPLAY ═══════════════════════════════════════ */
.kpit-score-cell { display:flex; flex-direction:column; align-items:flex-start; gap:4px; }
.kpit-score-val  { font-family:'Sora',sans-serif; font-size:15px; font-weight:800; }
.kpit-score-bar  { width:72px; height:5px; background:var(--bg); border-radius:100px; overflow:hidden; }
.kpit-score-fill { height:100%; border-radius:100px; transition:width .4s; }

/* ══ TABLE CARD ══════════════════════════════════════════ */
.kpit-card { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); overflow:hidden; }
.kpit-card-hd { display:flex; align-items:center; justify-content:space-between; padding:15px 20px; border-bottom:1px solid var(--border); }
.kpit-card-hd-left { display:flex; align-items:center; gap:9px; }
.kpit-card-ico { width:30px; height:30px; border-radius:8px; background:var(--teal-lt); border:1px solid var(--teal-brd); display:flex; align-items:center; justify-content:center; }
.kpit-card-ico svg { width:14px; height:14px; stroke:var(--teal-2); fill:none; stroke-width:2; }
.kpit-card-title { font-family:'Sora',sans-serif; font-size:14px; font-weight:800; color:var(--ink); }
.kpit-card-sub   { font-size:11.5px; color:var(--ink4); margin-top:1px; }
.kpit-table-wrap { overflow-x:auto; }
table.kpit-table { width:100%; border-collapse:collapse; }
.kpit-table thead tr { background:#FAFBFF; border-bottom:1px solid var(--border); }
.kpit-table th { padding:10px 16px; font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); text-align:left; white-space:nowrap; }
.kpit-table tbody tr { border-bottom:1px solid var(--border); transition:background .12s; }
.kpit-table tbody tr:last-child { border-bottom:none; }
.kpit-table tbody tr:hover { background:#F8FDFD; }
.kpit-table td { padding:12px 16px; font-size:13px; color:var(--ink2); }
.kpit-code { font-family:'Sora',sans-serif; font-size:11px; font-weight:800; background:var(--teal-lt); color:var(--teal-2); border:1px solid var(--teal-brd); padding:3px 9px; border-radius:7px; letter-spacing:.04em; }
.kpit-kpi-tag { font-family:'Sora',sans-serif; font-size:10.5px; font-weight:800; background:var(--indigo-lt); color:var(--indigo); border:1px solid var(--indigo-brd); padding:2px 8px; border-radius:6px; letter-spacing:.04em; }
.kpit-emp-cell { display:flex; align-items:center; gap:9px; }
.kpit-emp-av   { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,var(--teal-2),var(--blue)); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11px; font-weight:800; color:#fff; flex-shrink:0; }
.kpit-emp-name { font-size:13px; font-weight:700; color:var(--ink); }
.kpit-emp-dept { font-size:11px; color:var(--ink4); }
.kpit-actions  { display:flex; gap:5px; align-items:center; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.kpit-empty { padding:56px 32px; text-align:center; display:flex; flex-direction:column; align-items:center; gap:10px; }
.kpit-empty-icon { width:52px; height:52px; border-radius:14px; background:var(--teal-lt); display:flex; align-items:center; justify-content:center; margin-bottom:4px; }
.kpit-empty-icon svg { width:22px; height:22px; stroke:var(--teal-2); fill:none; stroke-width:1.5; }
.kpit-empty-ttl { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--ink2); }
.kpit-empty-sub { font-size:13px; color:var(--ink4); }

/* ══ MODAL ═══════════════════════════════════════════════ */
.kpit-modal-bg { position:fixed; inset:0; background:rgba(15,22,41,0.52); backdrop-filter:blur(10px); z-index:9000; display:flex; align-items:center; justify-content:center; padding:16px; }
.kpit-modal { background:var(--white); border-radius:var(--r-lg); box-shadow:var(--sh-lg); border:1px solid var(--border); width:100%; max-width:680px; max-height:93vh; overflow-y:auto; display:flex; flex-direction:column; }
.kpit-modal-lg { max-width:760px; }
.kpit-modal-hd { background:linear-gradient(105deg,#1A3FA8 0%,var(--teal-2) 60%,var(--teal) 100%); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; position:sticky; top:0; z-index:2; }
.kpit-modal-hd-left { display:flex; align-items:center; gap:12px; }
.kpit-modal-hd-icon { width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.18); display:flex; align-items:center; justify-content:center; }
.kpit-modal-hd-icon svg { width:17px; height:17px; stroke:#fff; fill:none; stroke-width:2; }
.kpit-modal-title { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:#fff; }
.kpit-modal-sub   { font-size:12px; color:rgba(255,255,255,.65); margin-top:1px; }
.kpit-modal-close { width:32px; height:32px; border-radius:9px; background:rgba(255,255,255,0.18); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .15s; flex-shrink:0; }
.kpit-modal-close:hover { background:rgba(255,255,255,0.30); }
.kpit-modal-close svg { width:14px; height:14px; stroke:#fff; fill:none; stroke-width:2.5; }
.kpit-modal-body { padding:22px 24px; display:flex; flex-direction:column; gap:16px; }
.kpit-modal-footer { padding:16px 24px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px; flex-shrink:0; position:sticky; bottom:0; background:var(--white); z-index:2; }

/* ── Fields ──────────────────────────────────────────── */
.kpit-field { display:flex; flex-direction:column; gap:5px; }
.kpit-field label { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.09em; color:var(--ink4); }
.kpit-field label .req { color:var(--red); }
.kpit-field input,.kpit-field select,.kpit-field textarea { width:100%; padding:9px 13px; box-sizing:border-box; background:#F6F8FC; border:1.5px solid var(--border); border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--ink); outline:none; transition:border-color .15s,box-shadow .15s; }
.kpit-field input:focus,.kpit-field select:focus { border-color:var(--teal); box-shadow:0 0 0 3px rgba(11,181,181,0.09); background:var(--white); }
.kpit-field input[readonly] { background:var(--bg); color:var(--ink3); cursor:default; }
.kpit-field-err { font-size:11.5px; color:var(--red); font-weight:600; margin-top:2px; }
.kpit-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.kpit-grid3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
.kpit-section-lbl { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.10em; color:var(--ink4); padding:4px 0 2px; border-bottom:1px solid var(--border); }

/* ── Calc preview ────────────────────────────────────── */
.kpit-calc-preview { background:linear-gradient(105deg,rgba(11,181,181,0.07),rgba(59,111,232,0.05)); border:1px solid var(--teal-brd); border-radius:var(--r); padding:14px 16px; display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.kpit-calc-item { text-align:center; }
.kpit-calc-lbl  { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); margin-bottom:4px; }
.kpit-calc-val  { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--teal-2); }
.kpit-calc-item.kpit-calc-score .kpit-calc-val { color:var(--indigo); font-size:18px; }

/* ══ VIEW MODAL ══════════════════════════════════════════ */
.kpit-view-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.kpit-view-row  { display:flex; flex-direction:column; gap:3px; padding:10px 14px; background:var(--bg); border-radius:10px; border:1px solid var(--border); }
.kpit-view-row.full { grid-column:1 / -1; }
.kpit-view-lbl  { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--ink4); }
.kpit-view-val  { font-size:13.5px; font-weight:600; color:var(--ink); }

/* ── Breakdown ───────────────────────────────────────── */
.kpit-breakdown { background:linear-gradient(105deg,rgba(11,181,181,0.07),rgba(59,111,232,0.05)); border:1px solid var(--teal-brd); border-radius:var(--r); padding:16px 18px; grid-column:1 / -1; }
.kpit-bd-title  { font-family:'Sora',sans-serif; font-size:12px; font-weight:800; color:var(--teal-2); margin-bottom:12px; text-transform:uppercase; letter-spacing:.06em; }
.kpit-bd-row    { display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:1px solid rgba(11,181,181,0.10); font-size:13px; }
.kpit-bd-row:last-child { border-bottom:none; font-weight:800; font-size:14px; }
.kpit-bd-row span:first-child { color:var(--ink3); font-weight:600; }
.kpit-bd-row span:last-child  { font-family:'Sora',sans-serif; font-weight:800; color:var(--ink); }
.kpit-pct-bar { width:100%; height:8px; background:var(--bg); border-radius:100px; overflow:hidden; margin-top:10px; }
.kpit-pct-fill{ height:100%; border-radius:100px; transition:width .5s; }

/* ══ DELETE ══════════════════════════════════════════════ */
.kpit-del-modal { max-width:420px; }
.kpit-del-body  { padding:28px 26px; text-align:center; }
.kpit-del-icon  { width:52px; height:52px; border-radius:50%; background:var(--red-lt); border:1px solid rgba(239,68,68,0.22); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.kpit-del-icon svg { width:22px; height:22px; stroke:var(--red); fill:none; stroke-width:2; }
.kpit-del-ttl   { font-family:'Sora',sans-serif; font-size:17px; font-weight:800; color:var(--ink); margin-bottom:8px; }
.kpit-del-sub   { font-size:13px; color:var(--ink3); line-height:1.6; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.kpit-pager { padding:14px 20px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.kpit-pager-info { font-size:12.5px; color:var(--ink4); font-weight:600; }

@media (max-width:768px) { .kpit-grid2,.kpit-grid3{grid-template-columns:1fr;} .kpit-view-grid{grid-template-columns:1fr;} .kpit-tiles{grid-template-columns:1fr 1fr;} .kpit-calc-preview{grid-template-columns:1fr;} }
@media (max-width:480px) { .kpit-tiles{grid-template-columns:1fr;} }
</style>

{{-- ── Flash ────────────────────────────────────────────── --}}
@if(session()->has('success'))
    <div class="kpit-flash kpit-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="kpit-flash kpit-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ HERO ════════════════════════════════════════════════ --}}
<div class="kpit-hero">
    <div class="kpit-hero-cover"></div>
    <div class="kpit-hero-body">
        <div style="display:flex;align-items:flex-end;gap:14px;">
            <div class="kpit-hero-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="kpit-hero-title">KPI Targets</div>
                <div class="kpit-hero-sub">Set, track and approve KPI targets per employee, period and parent KPI</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;padding-bottom:4px;">
            <div class="kpit-stat-strip">
                <div class="kpit-stat"><div class="kpit-stat-val">{{ $totalCount }}</div><div class="kpit-stat-lbl">Total</div></div>
                <div class="kpit-stat"><div class="kpit-stat-val" style="color:var(--teal-2)">{{ $approvedCount }}</div><div class="kpit-stat-lbl">Approved</div></div>
                <div class="kpit-stat"><div class="kpit-stat-val" style="color:var(--amber)">{{ $pendingCount }}</div><div class="kpit-stat-lbl">Pending</div></div>
                <div class="kpit-stat"><div class="kpit-stat-val" style="color:var(--blue-2)">{{ $avgAchievement }}%</div><div class="kpit-stat-lbl">Avg. Achievement</div></div>
            </div>
            <button class="kpit-btn kpit-btn-primary" wire:click="openCreate">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Target
            </button>
        </div>
    </div>
</div>

{{-- ══ STAT TILES ══════════════════════════════════════════ --}}
<div class="kpit-tiles">
    <div class="kpit-tile kpit-t-teal">
        <div class="kpit-tile-bar"></div>
        <div class="kpit-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="kpit-tile-lbl">Total Targets</div><div class="kpit-tile-val">{{ $totalCount }}</div><div class="kpit-tile-sub">all records</div></div>
    </div>
    <div class="kpit-tile kpit-t-green">
        <div class="kpit-tile-bar"></div>
        <div class="kpit-tile-icon"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div><div class="kpit-tile-lbl">Approved</div><div class="kpit-tile-val">{{ $approvedCount }}</div><div class="kpit-tile-sub">approved targets</div></div>
    </div>
    <div class="kpit-tile kpit-t-blue">
        <div class="kpit-tile-bar"></div>
        <div class="kpit-tile-icon"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
        <div><div class="kpit-tile-lbl">Avg. Achievement</div><div class="kpit-tile-val">{{ $avgAchievement }}%</div><div class="kpit-tile-sub">across all targets</div></div>
    </div>
    <div class="kpit-tile kpit-t-indigo">
        <div class="kpit-tile-bar"></div>
        <div class="kpit-tile-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
        <div><div class="kpit-tile-lbl">Avg. Score</div><div class="kpit-tile-val">{{ $avgScore }}</div><div class="kpit-tile-sub">out of 10</div></div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="kpit-toolbar">
    <div class="kpit-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search code, employee or KPI…">
    </div>
    <select class="kpit-sel" wire:model.live="filterKpi">
        <option value="">All KPIs</option>
        @foreach($kpis as $k)
            <option value="{{ $k['id'] }}">{{ $k['code'] }}</option>
        @endforeach
    </select>
    <select class="kpit-sel" wire:model.live="filterEmployee">
        <option value="">All Employees</option>
        @foreach($employees as $emp)
            <option value="{{ $emp['id'] }}">{{ $emp['first_name'] }} {{ $emp['last_name'] }}</option>
        @endforeach
    </select>
    <select class="kpit-sel" wire:model.live="filterPeriod">
        <option value="">All Periods</option>
        @foreach($periodTypes as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="kpit-sel" wire:model.live="filterApproval">
        <option value="">All Approvals</option>
        @foreach($approvalStatuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
</div>

{{-- ══ TABLE ═══════════════════════════════════════════════ --}}
<div class="kpit-card">
    <div class="kpit-card-hd">
        <div class="kpit-card-hd-left">
            <div class="kpit-card-ico">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="kpit-card-title">KPI Target Register</div>
                <div class="kpit-card-sub">{{ $records->total() }} record{{ $records->total() != 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>

    <div class="kpit-table-wrap">
        <table class="kpit-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Employee</th>
                    <th>KPI</th>
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
                        $apCls   = match($ap) { 'approved'=>'ktb-green','rejected'=>'ktb-red','cancelled'=>'ktb-red','draft'=>'ktb-gray', default=>'ktb-amber' };
                        $ppCls   = 'kptp-'.($pt ?: 'monthly');
                        $pct     = (float)($row->achievement_percentage ?? 0);
                        $pctColor= $pct >= 100 ? 'var(--green)' : ($pct >= 70 ? 'var(--amber)' : 'var(--red)');
                    @endphp
                    <tr>
                        <td><span class="kpit-code">{{ $row->code }}</span></td>
                        <td>
                            <div class="kpit-emp-cell">
                                <div class="kpit-emp-av">{{ $empInit }}</div>
                                <div>
                                    <div class="kpit-emp-name">{{ $emp ? trim(($emp->first_name??'').' '.($emp->last_name??'')) : '—' }}</div>
                                    <div class="kpit-emp-dept">{{ $emp?->department?->name ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($row->kpi)
                                <span class="kpit-kpi-tag">{{ $row->kpi->code }}</span>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="kpit-period-pill {{ $ppCls }}">
                                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ ucfirst($pt) }}
                            </span>
                            <div style="font-size:11px;color:var(--ink4);margin-top:3px;">
                                {{ \Carbon\Carbon::parse($row->period_start)->format('M d') }} – {{ \Carbon\Carbon::parse($row->period_end)->format('M d, Y') }}
                            </div>
                        </td>
                        <td style="font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--ink);">{{ number_format($row->target_value, 2) }}</td>
                        <td>
                            @if($row->actual_value !== null)
                                <span style="font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--teal-2);">{{ number_format($row->actual_value, 2) }}</span>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($row->achievement_percentage !== null)
                                <div class="kpit-score-cell">
                                    <div class="kpit-score-val" style="color:{{ $pctColor }};">{{ number_format($pct, 1) }}%</div>
                                    <div class="kpit-score-bar">
                                        <div class="kpit-score-fill" style="width:{{ min($pct,100) }}%;background:{{ $pctColor }};"></div>
                                    </div>
                                </div>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($row->score !== null)
                                <span style="font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--indigo);">{{ number_format($row->score, 1) }}<span style="font-size:10px;color:var(--ink4);font-family:'DM Sans',sans-serif;">/10</span></span>
                            @else
                                <span style="color:var(--ink4);">—</span>
                            @endif
                        </td>
                        <td><span class="kpit-badge {{ $apCls }}">{{ ucfirst($ap) }}</span></td>
                        <td>
                            <div class="kpit-actions">
                                <button class="kpit-btn kpit-btn-ghost kpit-btn-sm" wire:click="openView('{{ $row->id }}')" title="View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="kpit-btn kpit-btn-outline kpit-btn-sm" wire:click="openEdit('{{ $row->id }}')" title="Edit">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                @if($ap !== 'approved')
                                    <button class="kpit-btn kpit-btn-green kpit-btn-sm" wire:click="approve('{{ $row->id }}')" wire:confirm="Approve this target?" title="Approve">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                @endif
                                <button class="kpit-btn kpit-btn-danger kpit-btn-sm" wire:click="confirmDelete('{{ $row->id }}')" title="Delete">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="kpit-empty">
                                <div class="kpit-empty-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                                <div class="kpit-empty-ttl">No KPI targets found</div>
                                <div class="kpit-empty-sub">{{ $search || $filterApproval || $filterPeriod || $filterEmployee || $filterKpi ? 'Try adjusting your filters.' : 'Click "New Target" to get started.' }}</div>
                                @unless($search || $filterApproval || $filterPeriod || $filterEmployee || $filterKpi)
                                    <button class="kpit-btn kpit-btn-primary" wire:click="openCreate" style="margin-top:8px;">
                                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Create First Target
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
        <div class="kpit-pager">
            <div class="kpit-pager-info">Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of {{ $records->total() }}</div>
            {{ $records->links() }}
        </div>
    @endif
</div>

{{-- ══ CREATE / EDIT MODAL ════════════════════════════════ --}}
@if($showModal)
<div class="kpit-modal-bg" wire:click.self="closeModal">
    <div class="kpit-modal kpit-modal-lg">
        <div class="kpit-modal-hd">
            <div class="kpit-modal-hd-left">
                <div class="kpit-modal-hd-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="kpit-modal-title">{{ $editingId ? 'Edit KPI Target' : 'New KPI Target' }}</div>
                    <div class="kpit-modal-sub">Achievement % and score auto-calculated from target and actual values</div>
                </div>
            </div>
            <button class="kpit-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="kpit-modal-body">

            {{-- Identifiers --}}
            <div class="kpit-grid2">
                <div class="kpit-field">
                    <label>Target Code <span class="req">*</span></label>
                    <input type="text" wire:model="code" placeholder="KPIT-0001" style="text-transform:uppercase;">
                    @error('code')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpit-field">
                    <label>KPI <span class="req">*</span></label>
                    <select wire:model="kpiId">
                        <option value="">— Select KPI —</option>
                        @foreach($kpis as $k)
                            <option value="{{ $k['id'] }}">{{ $k['code'] }}</option>
                        @endforeach
                    </select>
                    @error('kpiId')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="kpit-field">
                <label>Employee <span class="req">*</span></label>
                <select wire:model="employeeId">
                    <option value="">— Select employee —</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp['id'] }}">{{ $emp['first_name'] }} {{ $emp['last_name'] }}</option>
                    @endforeach
                </select>
                @error('employeeId')<div class="kpit-field-err">{{ $message }}</div>@enderror
            </div>

            {{-- Period --}}
            <div class="kpit-section-lbl">Period</div>
            <div class="kpit-grid3">
                <div class="kpit-field">
                    <label>Period Type <span class="req">*</span></label>
                    <select wire:model="periodType">
                        <option value="">— Select —</option>
                        @foreach($periodTypes as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('periodType')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpit-field">
                    <label>Period Start <span class="req">*</span></label>
                    <input type="date" wire:model="periodStart">
                    @error('periodStart')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpit-field">
                    <label>Period End <span class="req">*</span></label>
                    <input type="date" wire:model="periodEnd">
                    @error('periodEnd')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Values --}}
            <div class="kpit-section-lbl">Values</div>
            <div class="kpit-grid2">
                <div class="kpit-field">
                    <label>Target Value <span class="req">*</span></label>
                    <input type="number" wire:model.live="targetValue" placeholder="0.00" step="0.01" min="0">
                    @error('targetValue')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpit-field">
                    <label>Actual Value</label>
                    <input type="number" wire:model.live="actualValue" placeholder="0.00" step="0.01" min="0">
                    @error('actualValue')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Live calc preview --}}
            <div class="kpit-calc-preview">
                <div class="kpit-calc-item">
                    <div class="kpit-calc-lbl">Achievement %</div>
                    <div class="kpit-calc-val">{{ $achievementPercentage !== '' ? number_format((float)$achievementPercentage, 1).'%' : '—' }}</div>
                </div>
                <div class="kpit-calc-item kpit-calc-score">
                    <div class="kpit-calc-lbl">Score (0–10)</div>
                    <div class="kpit-calc-val">{{ $score !== '' ? number_format((float)$score, 1) : '—' }}</div>
                </div>
            </div>

            <div class="kpit-grid2">
                <div class="kpit-field">
                    <label>Achievement % (auto-calculated)</label>
                    <input type="number" wire:model="achievementPercentage" placeholder="—" step="0.01" readonly>
                    @error('achievementPercentage')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="kpit-field">
                    <label>Score (auto-calculated)</label>
                    <input type="number" wire:model="score" placeholder="—" step="0.01" readonly>
                    @error('score')<div class="kpit-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="kpit-section-lbl">Status</div>
            <div class="kpit-field">
                <label>Approval Status <span class="req">*</span></label>
                <select wire:model="approvalStatus">
                    @foreach($approvalStatuses as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('approvalStatus')<div class="kpit-field-err">{{ $message }}</div>@enderror
            </div>

        </div>{{-- /body --}}

        <div class="kpit-modal-footer">
            <button class="kpit-btn kpit-btn-outline" wire:click="closeModal">Cancel</button>
            <button class="kpit-btn kpit-btn-primary" wire:click="save" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update' : 'Create' }} Target</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewRecord)
<div class="kpit-modal-bg" wire:click.self="closeView">
    <div class="kpit-modal kpit-modal-lg">
        <div class="kpit-modal-hd">
            <div class="kpit-modal-hd-left">
                <div class="kpit-modal-hd-icon"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                <div>
                    <div class="kpit-modal-title">{{ $viewRecord->code }}</div>
                    <div class="kpit-modal-sub">
                        {{ $viewRecord->kpi?->code ?? '—' }} · {{ $viewRecord->employee ? trim(($viewRecord->employee->first_name??'').' '.($viewRecord->employee->last_name??'')) : '—' }}
                    </div>
                </div>
            </div>
            <button class="kpit-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="kpit-modal-body" style="padding-top:20px;">
            @php
                $vAp    = $viewRecord->approval_status instanceof \BackedEnum ? $viewRecord->approval_status->value : ($viewRecord->approval_status ?? 'pending');
                $vApCls = match($vAp){ 'approved'=>'ktb-green','rejected'=>'ktb-red','cancelled'=>'ktb-red','draft'=>'ktb-gray', default=>'ktb-amber' };
                $vPt    = $viewRecord->period_type instanceof \BackedEnum ? $viewRecord->period_type->value : ($viewRecord->period_type ?? '');
                $vPct   = (float)($viewRecord->achievement_percentage ?? 0);
                $vPctColor = $vPct >= 100 ? 'var(--green)' : ($vPct >= 70 ? 'var(--amber)' : 'var(--red)');
            @endphp
            <div class="kpit-view-grid">
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Code</div>
                    <div class="kpit-view-val"><span class="kpit-code">{{ $viewRecord->code }}</span></div>
                </div>
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Approval Status</div>
                    <div class="kpit-view-val"><span class="kpit-badge {{ $vApCls }}">{{ ucfirst($vAp) }}</span></div>
                </div>
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Employee</div>
                    <div class="kpit-view-val">{{ $viewRecord->employee ? trim(($viewRecord->employee->first_name??'').' '.($viewRecord->employee->last_name??'')) : '—' }}</div>
                </div>
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Parent KPI</div>
                    <div class="kpit-view-val">{{ $viewRecord->kpi?->code ?? '—' }}</div>
                </div>
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Period Type</div>
                    <div class="kpit-view-val">{{ ucfirst($vPt) }}</div>
                </div>
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Period</div>
                    <div class="kpit-view-val" style="font-size:13px;">{{ \Carbon\Carbon::parse($viewRecord->period_start)->format('M d, Y') }} – {{ \Carbon\Carbon::parse($viewRecord->period_end)->format('M d, Y') }}</div>
                </div>

                {{-- Breakdown --}}
                <div class="kpit-breakdown">
                    <div class="kpit-bd-title">Performance Breakdown</div>
                    <div class="kpit-bd-row"><span>Target Value</span><span>{{ number_format($viewRecord->target_value, 2) }}</span></div>
                    <div class="kpit-bd-row"><span>Actual Value</span><span>{{ $viewRecord->actual_value !== null ? number_format($viewRecord->actual_value, 2) : '—' }}</span></div>
                    <div class="kpit-bd-row"><span>Achievement</span><span style="color:{{ $vPctColor }};">{{ $viewRecord->achievement_percentage !== null ? number_format($viewRecord->achievement_percentage, 2).'%' : '—' }}</span></div>
                    <div class="kpit-bd-row"><span>Score</span><span style="color:var(--indigo);">{{ $viewRecord->score !== null ? number_format($viewRecord->score, 2).' / 10' : '—' }}</span></div>
                    @if($viewRecord->achievement_percentage !== null)
                        <div class="kpit-pct-bar">
                            <div class="kpit-pct-fill" style="width:{{ min($vPct,100) }}%;background:{{ $vPctColor }};"></div>
                        </div>
                    @endif
                </div>

                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Created</div>
                    <div class="kpit-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->created_at)->format('M d, Y · H:i') }}</div>
                </div>
                <div class="kpit-view-row">
                    <div class="kpit-view-lbl">Last Updated</div>
                    <div class="kpit-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->updated_at)->format('M d, Y · H:i') }}</div>
                </div>
            </div>
        </div>
        <div class="kpit-modal-footer">
            <button class="kpit-btn kpit-btn-outline" wire:click="closeView">Close</button>
            <button class="kpit-btn kpit-btn-ghost" wire:click="openEdit('{{ $viewRecord->id }}'); closeView()">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </button>
            @if($vAp !== 'approved')
                <button class="kpit-btn kpit-btn-green" wire:click="approve('{{ $viewRecord->id }}'); closeView()" wire:confirm="Approve this target?">
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
<div class="kpit-modal-bg" wire:click.self="cancelDelete">
    <div class="kpit-modal kpit-del-modal">
        <div class="kpit-del-body">
            <div class="kpit-del-icon"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></div>
            <div class="kpit-del-ttl">Delete KPI Target?</div>
            <div class="kpit-del-sub">This will permanently remove this KPI target record. This action cannot be undone.</div>
        </div>
        <div class="kpit-modal-footer" style="justify-content:center;gap:12px;">
            <button class="kpit-btn kpit-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="kpit-btn kpit-btn-danger" wire:click="deleteRecord" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                <span wire:loading.remove wire:target="deleteRecord">Yes, Delete</span>
                <span wire:loading wire:target="deleteRecord">Deleting…</span>
            </button>
        </div>
    </div>
</div>
@endif

</div>{{-- /kpit-root --}}
