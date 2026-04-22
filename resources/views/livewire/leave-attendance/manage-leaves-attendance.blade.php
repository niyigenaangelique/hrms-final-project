{{--
    manage-leaves-attendance.blade.php
    Sections: overview | leaves | communication | calendar | attendance
--}}

<div class="la-local-shell">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

/* ══ TOKENS ══════════════════════════════════════════════ */
.la-local-shell {
    --blue:    #3B6FE8; --blue-2:  #2755CC; --blue-3:  #1A3FA8;
    --blue-lt: rgba(59,111,232,0.09); --blue-mid: rgba(59,111,232,0.18);
    --blue-brd:rgba(59,111,232,0.22); --indigo:   #6B4FDB;
    --green:   #12B76A; --green-lt: rgba(18,183,106,0.10);
    --amber:   #F59E0B; --amber-lt: rgba(245,158,11,0.10);
    --red:     #EF4444; --red-lt:   rgba(239,68,68,0.10);
    --purple:  #7C3AED; --purple-lt:rgba(124,58,237,0.09);
    --teal:    #0BB5B5; --teal-lt:  rgba(11,181,181,0.10);
    --bg: #F0F4FA; --white:#FFFFFF;
    --ink:#0F1629; --ink2:#2D3356; --ink3:#6B7094; --ink4:#A8ADCA;
    --border:rgba(15,22,41,0.08);
    --sh-sm: 0 2px 10px rgba(59,111,232,0.08);
    --sh-md: 0 6px 24px rgba(59,111,232,0.11);
    --sh-lg: 0 16px 48px rgba(59,111,232,0.14);
    --r:12px; --r-lg:20px;
    font-family:'DM Sans',-apple-system,sans-serif;
    color:var(--ink);
    
    display: grid; 
    grid-template-columns: 240px 1fr; 
    gap: 32px; 
    align-items: flex-start;
    padding: 32px 36px;
    max-width: 100%;
    margin: 0 auto;
    background: var(--bg);
    min-height: 100vh;
}

/* ══ SIDE NAV ═════════════════════════════════════════════ */
.la-local-sidebar { position: sticky; top: 28px; display: flex; flex-direction: column; gap: 20px; }
.la-local-nav { display: flex; flex-direction: column; gap: 6px; background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 10px; box-shadow: var(--sh-sm); }
.la-nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--r); font-size: 14px; font-weight: 700; color: var(--ink2); cursor: pointer; border: none; background: transparent; font-family: 'DM Sans', sans-serif; transition: all .2s; text-align: left; width: 100%; margin: 0; }
.la-nav-item svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.2; opacity: 0.6; transition: opacity .2s; flex-shrink:0; }
.la-nav-item:hover { background: rgba(59,111,232,0.09); color: var(--blue-2); }
.la-nav-item:hover svg { opacity: 1; }
.la-nav-item.active { background: #3b59e0ff; color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.25); }
.la-nav-item.active svg { opacity: 1; stroke: #fff; }

.la-nav-badge { margin-left:auto; background:rgba(255,255,255,0.2); color:#fff; font-size:10px; font-weight:800; padding:2px 7px; border-radius:100px; }
.la-nav-item:not(.active) .la-nav-badge.amber { background:var(--amber-lt); color:#92400E; border:1px solid rgba(245,158,11,0.22); }

/* ══ CONTENT ══════════════════════════════════════════════ */
.la-local-main { display: flex; flex-direction: column; gap: 24px; min-width: 0; }
.la-section  { display:none; }
.la-section.active { display:block; }
.la-wrap { display:flex; flex-direction:column; gap:20px; }

/* ══ HERO ══════════════════════════════════════════════════ */
.la-hero {
    background:linear-gradient(118deg,#1A3FA8 0%,#2755CC 36%,#3B6FE8 68%,#6B4FDB 100%);
    border-radius:var(--r-lg); padding:26px 32px;
    display:flex; align-items:center; justify-content:space-between;
    gap:20px; position:relative; overflow:hidden; box-shadow:var(--sh-lg);
}
.la-hero::before {
    content:''; position:absolute; top:-50px; right:240px;
    width:250px; height:250px; border-radius:50%;
    background:rgba(255,255,255,0.06); pointer-events:none;
}
.la-hero::after {
    content:''; position:absolute; bottom:-40px; left:60px;
    width:160px; height:160px; border-radius:50%;
    background:rgba(255,255,255,0.04); pointer-events:none;
}
.la-hero-left  { display:flex; align-items:center; gap:18px; position:relative; z-index:1; }
.la-hero-icon  {
    width:56px; height:56px; border-radius:16px;
    background:rgba(255,255,255,0.18); border:2px solid rgba(255,255,255,0.30);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.la-hero-icon svg { width:26px; height:26px; stroke:#fff; fill:none; stroke-width:1.75; }
.la-hero-title { font-family:'Sora',sans-serif; font-size:22px; font-weight:900; color:#fff; letter-spacing:-0.3px; margin-bottom:5px; }
.la-hero-sub   { font-size:12.5px; color:rgba(255,255,255,0.65); font-weight:500; }
.la-hero-chips { display:flex; gap:8px; margin-top:8px; flex-wrap:wrap; }
.la-hero-chip  {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.20);
    border-radius:100px; padding:3px 11px; font-size:12px;
    font-weight:600; color:rgba(255,255,255,0.90);
}
.la-hero-chip svg { width:10px; height:10px; stroke:rgba(255,255,255,0.7); fill:none; stroke-width:2; }
.la-hero-right { display:flex; gap:24px; position:relative; z-index:1; flex-shrink:0; }
.la-hero-stat  { text-align:center; }
.la-hero-sv    { font-family:'Sora',sans-serif; font-size:26px; font-weight:900; color:#fff; line-height:1; }
.la-hero-sl    { font-size:11px; color:rgba(255,255,255,0.60); font-weight:600; margin-top:4px; text-transform:uppercase; letter-spacing:0.06em; }

/* ══ STAT TILES ═══════════════════════════════════════════ */
.la-tiles { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; }
.la-tile  {
    background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border);
    box-shadow:var(--sh-sm); padding:18px 16px;
    display:flex; align-items:flex-start; gap:12px; position:relative;
    overflow:hidden; cursor:pointer; transition:box-shadow 0.18s,transform 0.18s,border-color 0.18s;
}
.la-tile:hover { box-shadow:var(--sh-md); transform:translateY(-2px); border-color:var(--blue-brd); }
.la-tile-bar  { position:absolute; top:0; left:0; width:4px; height:100%; border-radius:20px 0 0 20px; }
.la-tile-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.la-tile-icon svg { width:17px; height:17px; fill:none; stroke-width:2; }
.la-tile-lbl  { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--ink4); margin-bottom:4px; }
.la-tile-val  { font-family:'Sora',sans-serif; font-size:24px; font-weight:800; color:var(--ink); letter-spacing:-0.5px; line-height:1; }
.la-tile-sub  { font-size:11px; color:var(--ink4); font-weight:500; margin-top:3px; }

.la-t-blue  .la-tile-bar{background:var(--blue);}   .la-t-blue  .la-tile-icon{background:var(--blue-lt);}   .la-t-blue  .la-tile-icon svg{stroke:var(--blue);}   .la-t-blue  .la-tile-val{color:var(--blue-2);}
.la-t-green .la-tile-bar{background:var(--green);}  .la-t-green .la-tile-icon{background:var(--green-lt);}  .la-t-green .la-tile-icon svg{stroke:var(--green);}  .la-t-green .la-tile-val{color:var(--green);}
.la-t-amber .la-tile-bar{background:var(--amber);}  .la-t-amber .la-tile-icon{background:var(--amber-lt);}  .la-t-amber .la-tile-icon svg{stroke:var(--amber);}  .la-t-amber .la-tile-val{color:var(--amber);}
.la-t-red   .la-tile-bar{background:var(--red);}    .la-t-red   .la-tile-icon{background:var(--red-lt);}    .la-t-red   .la-tile-icon svg{stroke:var(--red);}    .la-t-red   .la-tile-val{color:var(--red);}

/* ══ CARD ══════════════════════════════════════════════════ */
.la-card { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); overflow:hidden; }
.la-card-hd { display:flex; align-items:center; gap:9px; padding:16px 20px; border-bottom:1px solid var(--border); }
.la-card-hdl { display:flex; align-items:center; gap:9px; flex:1; min-width:0; }
.la-card-ico { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
.la-card-ico svg { width:13px; height:13px; fill:none; stroke-width:2; stroke:currentColor; }
.la-card-ttl { font-family:'Sora',sans-serif; font-size:13px; font-weight:800; color:var(--ink); }
.la-card-sub { font-size:11px; color:var(--ink4); margin-top:1px; }
.la-card-lnk {
    font-size:11.5px; font-weight:700; color:var(--blue); cursor:pointer;
    border:none; background:none; font-family:'DM Sans',sans-serif;
    display:flex; align-items:center; gap:3px; padding:0;
    transition:gap .14s; margin-left:auto; flex-shrink:0;
}
.la-card-lnk:hover { gap:6px; }
.la-card-lnk svg { width:10px; height:10px; stroke:currentColor; fill:none; stroke-width:2.5; }
.la-card-bd { padding:18px 20px; }

/* ══ TABLE ══════════════════════════════════════════════════ */
.la-table-wrap { overflow-x:auto; }
table.la-table { width:100%; border-collapse:collapse; }
.la-table thead tr { border-bottom:1px solid var(--border); background:#FAFBFF; }
.la-table th { padding:10px 16px; font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); text-align:left; white-space:nowrap; }
.la-table tbody tr { border-bottom:1px solid var(--border); transition:background 0.12s; }
.la-table tbody tr:last-child { border-bottom:none; }
.la-table tbody tr:hover { background:#F8FAFF; }
.la-table td { padding:12px 16px; font-size:13px; color:var(--ink2); font-weight:500; }

/* ══ EMPLOYEE CELL ════════════════════════════════════════ */
.la-emp-cell  { display:flex; align-items:center; gap:10px; }
.la-emp-av    { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--blue),var(--indigo)); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11px; font-weight:800; color:#fff; flex-shrink:0; }
.la-emp-name  { font-size:13px; font-weight:700; color:var(--ink); }
.la-emp-role  { font-size:11px; color:var(--ink4); }

/* ══ BADGES ═══════════════════════════════════════════════ */
.la-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:100px; font-size:11px; font-weight:700; }
.la-badge svg { width:7px; height:7px; fill:currentColor; stroke:none; }
.lb-green  { background:var(--green-lt); color:#087A42; }
.lb-amber  { background:var(--amber-lt); color:#92400E; }
.lb-red    { background:var(--red-lt);   color:#991B1B; }
.lb-blue   { background:var(--blue-lt);  color:var(--blue-2); }
.lb-purple { background:var(--purple-lt);color:var(--purple); }
.lb-teal   { background:var(--teal-lt);  color:#0E7490; }
.lb-gray   { background:var(--bg);       color:var(--ink3); border:1px solid var(--border); }

/* ══ ATTENDANCE STATUS BADGES ════════════════════════════ */
.la-att-status   { display:inline-flex; align-items:center; padding:3px 10px; border-radius:100px; font-size:11px; font-weight:700; }
.la-att-present  { background:var(--green-lt);  color:#087A42; }
.la-att-absent   { background:var(--red-lt);    color:#991B1B; }
.la-att-late     { background:var(--amber-lt);  color:#92400E; }
.la-att-leave    { background:var(--purple-lt); color:var(--purple); }
.la-att-half     { background:var(--teal-lt);   color:#0E7490; }

/* ══ BUTTONS ══════════════════════════════════════════════ */
.la-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 15px; border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:700; border:none; cursor:pointer; transition:all 0.15s; white-space:nowrap; text-decoration:none; }
.la-btn svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }
.la-btn-primary { background:var(--blue); color:#fff; box-shadow:0 4px 12px rgba(59,111,232,0.28); }
.la-btn-primary:hover { background:var(--blue-2); transform:translateY(-1px); }
.la-btn-green   { background:var(--green-lt); color:#087A42; border:1px solid rgba(18,183,106,0.22); }
.la-btn-green:hover { background:rgba(18,183,106,0.18); }
.la-btn-ghost   { background:var(--blue-lt);  color:var(--blue); border:1px solid var(--blue-brd); }
.la-btn-ghost:hover { background:var(--blue-mid); }
.la-btn-danger  { background:var(--red-lt);   color:var(--red); border:1px solid rgba(239,68,68,0.22); }
.la-btn-danger:hover { background:rgba(239,68,68,0.15); }
.la-btn-sm { padding:5px 11px; font-size:11.5px; }

/* ══ FORM FIELDS ══════════════════════════════════════════ */
.la-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.la-field  { display:flex; flex-direction:column; gap:5px; }
.la-field label { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); }
.la-field label .req { color:var(--red); margin-left:2px; }
.la-field input,.la-field select,.la-field textarea {
    width:100%; padding:9px 12px; box-sizing:border-box;
    background:#F6F8FC; border:1.5px solid var(--border); border-radius:var(--r);
    font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--ink);
    outline:none; transition:border-color 0.15s,box-shadow 0.15s; -webkit-appearance:none;
}
.la-field input:focus,.la-field select:focus,.la-field textarea:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(59,111,232,0.09); background:#fff; }
.la-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 11px center; padding-right:32px; cursor:pointer; }
.la-field textarea { resize:vertical; min-height:80px; }

/* ══ EMPTY STATE ══════════════════════════════════════════ */
.la-empty { text-align:center; padding:48px 24px; }
.la-empty svg { width:36px; height:36px; stroke:var(--ink4); fill:none; stroke-width:1.5; margin:0 auto 12px; display:block; opacity:0.4; }
.la-empty-ttl { font-size:15px; font-weight:700; color:var(--ink3); margin-bottom:4px; }
.la-empty-sub { font-size:12.5px; color:var(--ink4); font-weight:500; }

/* ══ QUICK ACTIONS ════════════════════════════════════════ */
.la-quick-action {
    display:flex; align-items:center; gap:12px; width:100%;
    padding:12px 14px; border-radius:var(--r); border:1px solid var(--border);
    background:var(--white); cursor:pointer; margin-bottom:8px;
    font-family:'DM Sans',sans-serif; transition:all 0.15s;
}
.la-quick-action:last-child { margin-bottom:0; }
.la-quick-action:hover { border-color:var(--blue-brd); background:var(--blue-lt); }
.la-qa-icon { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.la-qa-icon svg { width:14px; height:14px; fill:none; stroke-width:2; stroke:currentColor; }
.la-qa-lbl  { font-size:13px; font-weight:700; color:var(--ink); text-align:left; }
.la-qa-sub  { font-size:11px; color:var(--ink4); font-weight:500; text-align:left; }
.la-qa-arr  { width:14px; height:14px; stroke:var(--ink4); fill:none; stroke-width:2.5; margin-left:auto; flex-shrink:0; }

/* ══ OVERVIEW GRID ════════════════════════════════════════ */
.la-ov-grid { display:grid; grid-template-columns:1fr 320px; gap:18px; align-items:start; }
.la-ov-col  { display:flex; flex-direction:column; gap:18px; }

/* ══ LEAVE BALANCE STRIP ══════════════════════════════════ */
.la-balance-strip { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:12px; }
.la-balance-card  { background:var(--white); border:1px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--sh-sm); padding:16px; }
.la-balance-top   { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.la-balance-lbl   { font-size:12px; font-weight:700; color:var(--ink2); }
.la-balance-val   { font-family:'Sora',sans-serif; font-size:28px; font-weight:800; color:var(--blue-2); line-height:1; margin-bottom:2px; }
.la-balance-sub   { font-size:11px; color:var(--ink4); font-weight:500; margin-bottom:10px; }
.la-balance-bar   { height:5px; border-radius:100px; background:var(--bg); overflow:hidden; }
.la-balance-fill  { height:100%; border-radius:100px; background:linear-gradient(90deg,var(--blue-2),var(--blue)); transition:width .5s; }
.la-balance-fill.amber { background:linear-gradient(90deg,#D97706,var(--amber)); }
.la-balance-fill.green { background:linear-gradient(90deg,#087A42,var(--green)); }

/* ══ COMMUNICATION ════════════════════════════════════════ */
.la-comm-grid { display:grid; grid-template-columns:1fr 340px; gap:18px; align-items:start; }
.la-comm-card { background:var(--white); border:1px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--sh-sm); overflow:hidden; }

.la-ann-item  { display:flex; gap:12px; padding:14px 18px; border-bottom:1px solid var(--border); }
.la-ann-item:last-child { border-bottom:none; }
.la-ann-ico   { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.la-ann-ico svg { width:14px; height:14px; fill:none; stroke-width:2; stroke:currentColor; }
.la-ann-ttl   { font-size:13px; font-weight:700; color:var(--ink); margin-bottom:3px; }
.la-ann-body  { font-size:12.5px; color:var(--ink3); font-weight:500; line-height:1.5; margin-bottom:5px; }
.la-ann-meta  { display:flex; gap:10px; font-size:11px; color:var(--ink4); font-weight:600; }

.la-policy-row { display:flex; align-items:center; gap:12px; padding:12px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:background 0.12s; }
.la-policy-row:last-child { border-bottom:none; }
.la-policy-row:hover { background:var(--bg); }
.la-policy-ico { width:32px; height:32px; border-radius:9px; background:var(--purple-lt); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.la-policy-ico svg { width:14px; height:14px; fill:none; stroke:var(--purple); stroke-width:2; }
.la-policy-ttl { font-size:13px; font-weight:700; color:var(--ink); }
.la-policy-sub { font-size:11px; color:var(--ink4); font-weight:500; }
.la-policy-arr { width:14px; height:14px; stroke:var(--ink4); fill:none; stroke-width:2.5; margin-left:auto; flex-shrink:0; }

.la-contact-row { display:flex; align-items:center; gap:12px; padding:12px 18px; border-bottom:1px solid var(--border); }
.la-contact-row:last-child { border-bottom:none; }
.la-contact-av   { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--blue),var(--indigo)); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11px; font-weight:800; color:#fff; flex-shrink:0; }
.la-contact-name { font-size:13px; font-weight:700; color:var(--ink); }
.la-contact-role { font-size:11px; color:var(--ink4); font-weight:500; }

/* ══ CALENDAR ═════════════════════════════════════════════ */
.la-cal-grid    { display:grid; grid-template-columns:1fr 280px; gap:18px; align-items:start; }
.la-cal-sidebar { display:flex; flex-direction:column; gap:14px; }
.la-cal-nav     { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.la-cal-nav-title { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--ink); }
.la-cal-nav-btn { width:32px; height:32px; border-radius:9px; background:var(--bg); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.15s; }
.la-cal-nav-btn:hover { border-color:var(--blue-brd); background:var(--blue-lt); }
.la-cal-nav-btn svg { width:14px; height:14px; stroke:var(--ink3); fill:none; stroke-width:2.5; }
.la-cal-month { display:grid; grid-template-columns:repeat(7,1fr); gap:2px; }
.la-cal-dow   { font-size:10.5px; font-weight:800; text-align:center; color:var(--ink4); padding:6px 2px; text-transform:uppercase; letter-spacing:0.05em; }
.la-cal-day   { min-height:60px; border-radius:9px; padding:6px; position:relative; border:1px solid transparent; transition:all 0.12s; }
.la-cal-day:hover { background:var(--bg); border-color:var(--border); }
.la-cal-day.today { background:var(--blue); border-color:var(--blue-2); }
.la-cal-day.today .la-cal-dn { color:#fff; font-weight:800; }
.la-cal-day.has-event { background:rgba(245,158,11,0.06); border-color:rgba(245,158,11,0.20); }
.la-cal-day.other-month { opacity:0.25; }
.la-cal-dn    { font-size:13px; font-weight:600; color:var(--ink2); margin-bottom:2px; text-align:right; }
.la-cal-ev    { display:block; font-size:9px; font-weight:700; padding:1px 4px; border-radius:4px; margin-bottom:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.leave-ev     { background:var(--amber-lt); color:#92400E; }
.holiday-ev   { background:var(--green-lt); color:#087A42; }

.la-cal-legend      { background:var(--white); border:1px solid var(--border); border-radius:var(--r-lg); padding:16px 18px; }
.la-cal-legend-ttl  { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); margin-bottom:12px; }
.la-cal-legend-row  { display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:600; color:var(--ink3); margin-bottom:7px; }
.la-cal-legend-row:last-child { margin-bottom:0; }
.la-cal-legend-dot  { width:10px; height:10px; border-radius:50%; flex-shrink:0; }

.la-events-list { display:flex; flex-direction:column; gap:10px; }
.la-event-item  { display:flex; align-items:flex-start; gap:10px; }
.la-event-dot   { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:4px; }
.la-event-ttl   { font-size:13px; font-weight:700; color:var(--ink); }
.la-event-sub   { font-size:11px; color:var(--ink4); font-weight:500; margin-top:1px; }

/* ══ RESPONSIVE ═══════════════════════════════════════════ */
@media (max-width:1100px) {
    .la-tiles      { grid-template-columns:repeat(2,1fr); }
    .la-ov-grid    { grid-template-columns:1fr; }
    .la-comm-grid  { grid-template-columns:1fr; }
    .la-cal-grid   { grid-template-columns:1fr; }
}
@media (max-width:900px) {
    .la-local-shell { grid-template-columns: 1fr; padding: 20px; }
    .la-local-sidebar { position: static; top: auto; flex-direction: row; align-items: center; justify-content: space-between; }
    .la-local-nav { flex-direction: row; overflow-x: auto; padding: 6px; flex: 1; }
    .la-nav-item { min-width: max-content; padding: 8px 12px; font-size: 12px; width: auto; border-radius: 8px; }
    .la-nav-item span { display: inline-block; }
    .la-tiles { grid-template-columns: 1fr 1fr; }
    .la-grid2 { grid-template-columns: 1fr; }
}
@media (max-width:640px) {
    .la-local-shell { padding: 14px; gap: 16px; }
    .la-hero  { padding:18px 16px; flex-direction:column; gap:12px; align-items:flex-start; }
    .la-hero-right { gap:16px; }
}
/* ══ EMPTY STATE ════════════════════════════════════════════ */
.la-empty { text-align:center; padding:48px 24px; }
.la-empty svg { width:36px; height:36px; stroke:var(--ink4); fill:none; stroke-width:1.5; margin:0 auto 12px; display:block; opacity:0.4; }
.la-empty-ttl { font-size:15px; font-weight:700; color:var(--ink3); margin-bottom:4px; }
.la-empty-sub { font-size:12.5px; color:var(--ink4); font-weight:500; }

/* ══ FORM FIELDS ════════════════════════════════════════════ */
.la-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.la-field { display:flex; flex-direction:column; gap:5px; }
.la-field label { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); }
.la-field label .req { color:var(--red); margin-left:2px; }
.la-field input, .la-field select, .la-field textarea { width:100%; padding:9px 12px; box-sizing:border-box; background:#F6F8FC; border:1.5px solid var(--border); border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--ink); outline:none; transition:border-color 0.15s,box-shadow 0.15s,background 0.15s; -webkit-appearance:none; }
.la-field input:focus, .la-field select:focus, .la-field textarea:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(59,111,232,0.09); background:var(--white); }
.la-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 11px center; padding-right:32px; cursor:pointer; }
.la-field textarea { resize:vertical; min-height:80px; }

/* ══ LEAVE BALANCE CARDS ════════════════════════════════════ */
.la-balance-strip { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:12px; }
.la-balance-card { background:var(--white); border:1px solid var(--border); border-radius:var(--r-lg); box-shadow:var(--sh-sm); padding:16px 18px; }
.la-balance-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.la-balance-lbl { font-size:12px; font-weight:700; color:var(--ink3); }
.la-balance-val { font-family:'Sora',sans-serif; font-size:28px; font-weight:800; color:var(--blue-2); line-height:1; margin-bottom:2px; }
.la-balance-sub { font-size:11px; color:var(--ink4); font-weight:500; margin-bottom:10px; }
.la-balance-bar { height:5px; border-radius:100px; background:var(--bg); overflow:hidden; }
.la-balance-fill { height:100%; border-radius:100px; background:linear-gradient(90deg,var(--blue-2),var(--blue)); transition:width .5s; }
.la-balance-fill.amber { background:linear-gradient(90deg,#D97706,var(--amber)); }
.la-balance-fill.green { background:linear-gradient(90deg,#087A42,var(--green)); }

/* ══ SIMPLE CALENDAR (section 4 fallback grid) ═════════════ */
.la-cal-month { display:grid; grid-template-columns:repeat(7,1fr); gap:2px; }
.la-cal-dow { font-size:10.5px; font-weight:800; text-align:center; color:var(--ink4); padding:6px 2px; text-transform:uppercase; letter-spacing:0.05em; }
.la-cal-day { min-height:60px; border-radius:9px; padding:6px; position:relative; border:1px solid transparent; transition:all 0.12s; }
.la-cal-day:hover { background:var(--bg); border-color:var(--border); }
.la-cal-day.today { background:var(--blue); border-color:var(--blue-2); }
.la-cal-day.today .la-cal-dn { color:#fff; font-weight:800; }
.la-cal-day.has-event { background:rgba(245,158,11,0.06); border-color:rgba(245,158,11,0.20); }
.la-cal-day.other-month { opacity:0.25; pointer-events:none; }
.la-cal-dn { font-size:13px; font-weight:600; color:var(--ink2); margin-bottom:2px; text-align:right; }
.la-cal-ev { display:block; font-size:9px; font-weight:700; padding:1px 4px; border-radius:4px; margin-bottom:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.la-cal-ev.leave-ev { background:var(--amber-lt); color:#92400E; }
.la-cal-ev.holiday-ev { background:var(--green-lt); color:#087A42; }

/* ══ MODAL (task add modal in calendar) ═════════════════════ */
.la-modal { background:var(--white); border-radius:var(--r-lg); box-shadow:0 24px 64px rgba(15,22,41,0.22); border:1px solid var(--border); width:100%; max-width:520px; max-height:92vh; display:flex; flex-direction:column; overflow:hidden; }
.la-modal-hd { background:linear-gradient(105deg,var(--blue-3),var(--blue)); padding:18px 22px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.la-modal-title { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:#fff; display:flex; align-items:center; gap:9px; }
.la-modal-title svg { width:17px; height:17px; stroke:rgba(255,255,255,0.8); fill:none; stroke-width:2; }
.la-modal-close { width:30px; height:30px; border-radius:8px; background:rgba(255,255,255,0.18); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background 0.15s; }
.la-modal-close:hover { background:rgba(255,255,255,0.28); }
.la-modal-close svg { width:13px; height:13px; stroke:#fff; fill:none; stroke-width:2.5; }
.la-modal-body { flex:1; overflow-y:auto; padding:22px; display:flex; flex-direction:column; gap:14px; }
.la-modal-footer { padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; align-items:center; flex-shrink:0; }

/* ══ CHAT (Communication section) ═══════════════════════ */
.la-chat-topbar { background:var(--blue2); border:1px solid var(--border); border-radius:var(--r-lg); padding:15px 22px; display:flex; align-items:center; justify-content:space-between; gap:16px; }
.la-chat-topbar-icon { width:38px; height:38px; background:var(--blue); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.la-chat-topbar-icon svg { width:18px; height:18px; stroke:#fff; fill:none; stroke-width:2; }
.la-chat-topbar-title { font-size:17px; font-weight:800; color:var(--ink); font-family:'Sora',sans-serif; }
.la-chat-topbar-sub { font-size:12.5px; color:var(--ink3); }
.la-chat-unread-pill { display:flex; align-items:center; gap:6px; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2); border-radius:100px; padding:5px 13px; }
.la-chat-unread-dot { width:7px; height:7px; border-radius:50%; background:var(--red); }
.la-chat-unread-text { font-size:12px; font-weight:700; color:#B91C1C; }

.la-chat-shell { display:flex; background:var(--white); border:1px solid var(--border); border-radius:var(--r-lg); overflow:hidden; height:calc(100vh - 260px); min-height:520px; position:relative; }
.la-chat-users-drawer { width:250px; min-width:250px; background:var(--white); border-right:1px solid var(--border); display:flex; flex-direction:column; flex-shrink:0; transform:translateX(-250px); margin-left:-250px; transition:transform 0.25s ease,margin-left 0.25s ease; overflow:hidden; z-index:10; }
.la-chat-users-drawer.open { transform:translateX(0); margin-left:0; }
.la-chat-drawer-hd { padding:14px 16px 12px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.la-chat-drawer-title { font-size:13.5px; font-weight:700; color:var(--ink); }
.la-chat-drawer-close { width:26px; height:26px; border-radius:7px; background:var(--bg); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; }
.la-chat-drawer-close:hover { background:var(--red-lt); }
.la-chat-drawer-close svg { width:12px; height:12px; stroke:var(--ink3); fill:none; stroke-width:2.5; }
.la-chat-drawer-search { display:flex; align-items:center; gap:8px; background:var(--bg); border-radius:9px; padding:8px 12px; margin:10px 10px 4px; }
.la-chat-drawer-search svg { width:13px; height:13px; stroke:var(--ink4); fill:none; flex-shrink:0; }
.la-chat-drawer-search input { border:none; background:transparent; font-size:12.5px; color:var(--ink); outline:none; width:100%; font-family:'DM Sans',sans-serif; }
.la-chat-drawer-search input::placeholder { color:var(--ink4); }
.la-chat-users-list { overflow-y:auto; flex:1; padding:6px 10px 10px; }
.la-chat-user-item { display:flex; align-items:center; gap:10px; padding:9px 11px; border-radius:10px; cursor:pointer; margin-bottom:3px; transition:background .15s; }
.la-chat-user-item:hover { background:var(--blue-lt); }
.la-chat-user-av { width:34px; height:34px; border-radius:50%; background:var(--blue-lt); color:var(--blue-2); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11px; font-weight:800; flex-shrink:0; }
.la-chat-user-name { font-size:13px; font-weight:600; color:var(--ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.la-chat-user-role { font-size:11px; color:var(--ink3); }

.la-chat-conv-col { width:250px; min-width:250px; border-right:1px solid var(--border); display:flex; flex-direction:column; flex-shrink:0; }
.la-chat-conv-hd { padding:12px 14px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; flex-shrink:0; }
.la-chat-toggle-btn { width:32px; height:32px; border-radius:9px; background:var(--blue-lt); border:1.5px solid var(--blue-brd); display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; position:relative; transition:background .15s; }
.la-chat-toggle-btn:hover { background:var(--blue-mid); }
.la-chat-toggle-btn svg { width:15px; height:15px; stroke:var(--blue); fill:none; stroke-width:2; }
.la-chat-toggle-dot { position:absolute; top:-3px; right:-3px; width:9px; height:9px; border-radius:50%; background:var(--blue); border:2px solid var(--white); }
.la-chat-conv-title { font-size:13px; font-weight:800; color:var(--ink); flex:1; }
.la-chat-conv-list { overflow-y:auto; flex:1; }
.la-chat-conv-item { display:flex; align-items:center; gap:9px; padding:11px 14px; cursor:pointer; border-bottom:1px solid var(--border); transition:background .15s; }
.la-chat-conv-item:last-child { border-bottom:none; }
.la-chat-conv-item:hover { background:var(--blue-lt); }
.la-chat-conv-item.active { background:var(--blue); }
.la-chat-conv-item.active .la-chat-conv-name,.la-chat-conv-item.active .la-chat-conv-preview,.la-chat-conv-item.active .la-chat-conv-time { color:#fff; }
.la-chat-conv-av { width:38px; height:38px; border-radius:50%; background:var(--blue-lt); color:var(--blue-2); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:12px; font-weight:800; flex-shrink:0; }
.la-chat-conv-item.active .la-chat-conv-av { background:rgba(255,255,255,0.2); color:#fff; }
.la-chat-conv-info { flex:1; min-width:0; }
.la-chat-conv-name { font-size:13px; font-weight:600; color:var(--ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px; }
.la-chat-conv-preview { font-size:11.5px; color:var(--ink3); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.la-chat-conv-meta { text-align:right; flex-shrink:0; }
.la-chat-conv-time { font-size:10.5px; color:var(--ink4); display:block; margin-bottom:3px; }
.la-chat-conv-badge { display:inline-flex; align-items:center; justify-content:center; min-width:16px; height:16px; padding:0 4px; border-radius:100px; background:var(--blue); color:#fff; font-size:9px; font-weight:800; }
.la-chat-conv-empty { padding:32px 18px; text-align:center; color:var(--ink4); font-size:12.5px; }
.la-chat-conv-empty svg { width:28px; height:28px; stroke:var(--ink4); fill:none; stroke-width:1.5; margin:0 auto 8px; display:block; opacity:0.5; }

.la-chat-main { flex:1; display:flex; flex-direction:column; overflow:hidden; min-width:0; }
.la-chat-hd { padding:12px 18px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.la-chat-hd-left { display:flex; align-items:center; gap:10px; }
.la-chat-hd-av { width:36px; height:36px; border-radius:50%; background:var(--blue-lt); color:var(--blue-2); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:12px; font-weight:800; flex-shrink:0; }
.la-chat-hd-name { font-size:14px; font-weight:700; color:var(--ink); margin:0 0 1px; }
.la-chat-hd-status { font-size:11.5px; color:var(--blue); }
.la-chat-msgs { flex:1; overflow-y:auto; padding:18px 20px; display:flex; flex-direction:column; gap:11px; }
.la-chat-empty { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--ink4); gap:8px; text-align:center; padding:40px 20px; }
.la-chat-empty svg { width:38px; height:38px; stroke:var(--ink4); fill:none; stroke-width:1.5; opacity:0.4; }
.la-chat-empty p { font-size:14px; color:var(--ink3); margin:0; font-weight:600; }
.la-chat-empty span { font-size:12px; color:var(--ink4); }
.la-chat-msg-row { display:flex; align-items:flex-end; gap:7px; }
.la-chat-msg-row.sent { flex-direction:row-reverse; }
.la-chat-msg-wrap { display:flex; flex-direction:column; max-width:65%; }
.la-chat-msg-row.sent .la-chat-msg-wrap { align-items:flex-end; }
.la-chat-bubble { padding:10px 14px; font-size:13.5px; line-height:1.55; border-radius:18px; word-break:break-word; }
.la-chat-bubble.recv { background:#F0F2F8; color:var(--ink); border-radius:4px 18px 18px 18px; }
.la-chat-bubble.sent { background:var(--blue); color:#fff; border-radius:18px 4px 18px 18px; }
.la-chat-bubble-meta { display:flex; align-items:center; gap:5px; margin-top:4px; padding:0 2px; }
.la-chat-bubble-time { font-size:10.5px; color:var(--ink4); }
.la-chat-badge { font-size:10px; font-weight:700; padding:2px 7px; border-radius:100px; display:inline-flex; }
.la-chat-badge-new  { background:var(--blue-lt); color:var(--blue-2); }
.la-chat-badge-read { background:var(--bg); color:var(--ink4); }
.la-chat-compose { padding:12px 18px; border-top:1px solid var(--border); background:var(--white); flex-shrink:0; }
.la-chat-compose-inner { display:flex; align-items:flex-end; gap:9px; background:var(--bg); border:1.5px solid var(--border); border-radius:13px; padding:10px 14px; transition:border-color .15s,box-shadow .15s; }
.la-chat-compose-inner:focus-within { border-color:var(--blue); box-shadow:0 0 0 3px rgba(59,111,232,0.09); }
.la-chat-compose-ta { flex:1; border:none; background:transparent; font-size:13.5px; font-weight:500; color:var(--ink); font-family:'DM Sans',sans-serif; outline:none; resize:none; min-height:20px; max-height:120px; line-height:1.5; }
.la-chat-compose-ta::placeholder { color:var(--ink4); }
.la-chat-send-btn { width:34px; height:34px; border-radius:50%; background:var(--blue); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:background .15s,transform .12s; box-shadow:0 2px 8px rgba(59,111,232,0.30); }
.la-chat-send-btn:hover { background:var(--blue-2); transform:scale(1.06); }
.la-chat-send-btn svg { width:15px; height:15px; stroke:#fff; fill:none; stroke-width:2; }
.la-chat-compose-hint { font-size:11px; color:var(--ink4); margin-top:5px; text-align:right; }

/* ══ HR CALENDAR (tabs + grid + timeline) ════════════════ */
.la-hrcal-tabs { display:flex; gap:8px; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:12px 16px; flex-wrap:wrap; }
.la-hrcal-tab { display:inline-flex; align-items:center; gap:7px; padding:8px 15px; border-radius:var(--r); font-size:13px; font-weight:700; cursor:pointer; border:none; font-family:'DM Sans',sans-serif; transition:all .15s; background:var(--bg); color:var(--ink3); }
.la-hrcal-tab svg { width:14px; height:14px; stroke:currentColor; fill:none; stroke-width:2; }
.la-hrcal-tab:hover { background:var(--blue-lt); color:var(--blue-2); }
.la-hrcal-tab.active { background:var(--blue); color:#fff; box-shadow:0 4px 12px rgba(59,111,232,0.28); }
.la-hrcal-view { display:none; }
.la-hrcal-view.active { display:block; }
.la-hrcal-2col { display:grid; grid-template-columns:1fr 280px; gap:18px; align-items:start; }
.la-hrcal-sidebar { display:flex; flex-direction:column; gap:14px; }
.la-hrcal-nav-btn { width:28px; height:28px; border-radius:7px; background:var(--bg); border:1px solid var(--border); display:inline-flex; align-items:center; justify-content:center; cursor:pointer; transition:all .12s; text-decoration:none; }
.la-hrcal-nav-btn:hover { background:var(--blue-lt); border-color:var(--blue-brd); }
.la-hrcal-nav-btn svg { width:13px; height:13px; stroke:var(--ink3); fill:none; stroke-width:2; }

/* Calendar day grid */
.la-hrcal-dow-row { display:grid; grid-template-columns:repeat(7,1fr); margin-bottom:5px; }
.la-hrcal-dow { text-align:center; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:var(--ink4); padding:4px 0; }
.la-hrcal-dow.wknd { color:var(--red); opacity:0.7; }
.la-hrcal-days { display:grid; grid-template-columns:repeat(7,1fr); gap:3px; }
.la-hrcal-cell { border-radius:9px; border:1px solid transparent; min-height:72px; padding:6px 7px 4px; display:flex; flex-direction:column; cursor:pointer; transition:all .15s; background:var(--bg); }
.la-hrcal-cell:hover { background:#EEF3FD; border-color:var(--blue-brd); }
.la-hrcal-cell.other { opacity:.3; cursor:default; pointer-events:none; }
.la-hrcal-cell.today { background:var(--blue-lt); border-color:var(--blue); }
.la-hrcal-cell.wknd  { background:#F8F9FD; }
.la-hrcal-cell.has-leave  { background:rgba(18,183,106,0.07); border-color:rgba(18,183,106,0.22); }
.la-hrcal-cell.has-hol    { background:rgba(245,158,11,0.07); border-color:rgba(245,158,11,0.22); }
.la-hrcal-cell.has-pay    { background:rgba(59,111,232,0.07); border-color:rgba(59,111,232,0.22); }
.la-hrcal-num { font-size:12px; font-weight:700; color:var(--ink2); margin-bottom:4px; width:22px; height:22px; display:flex; align-items:center; justify-content:center; border-radius:6px; }
.la-hrcal-cell.today .la-hrcal-num { background:var(--blue); color:#fff; box-shadow:0 2px 6px rgba(59,111,232,0.35); }
.la-hrcal-cell.other .la-hrcal-num { color:var(--ink4); }
.la-hrcal-chips { display:flex; flex-direction:column; gap:1.5px; flex:1; overflow:hidden; }
.la-hrcal-chip { font-size:9px; font-weight:700; padding:1.5px 5px; border-radius:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; line-height:1.6; }
.la-hrcal-chip.lv  { background:rgba(18,183,106,0.18); color:#087A42; }
.la-hrcal-chip.hol { background:rgba(245,158,11,0.18); color:#92400E; }
.la-hrcal-chip.pay { background:var(--blue-lt); color:var(--blue-2); }
.la-hrcal-chip.more{ background:var(--bg); color:var(--ink4); border:1px solid var(--border); }
.la-hrcal-legend { display:flex; flex-wrap:wrap; gap:12px; padding:11px 16px; border-top:1px solid var(--border); background:#FAFBFF; }
.la-hrcal-legend-item { display:flex; align-items:center; gap:5px; font-size:11px; font-weight:600; color:var(--ink3); }
.la-hrcal-legend-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }

/* Weekly timeline */
.la-hrcal-timeline { display:grid; grid-template-columns:52px repeat(5,1fr); min-width:500px; }
.la-hrcal-tl-corner { background:var(--bg); border-right:1px solid var(--border); border-bottom:1px solid var(--border); padding:10px 8px; }
.la-hrcal-tl-dayhd { background:var(--bg); padding:10px 8px; text-align:center; font-size:10.5px; font-weight:800; color:var(--ink3); text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--border); border-left:1px solid var(--border); }
.la-hrcal-tl-dayhd.today-col { color:var(--blue); background:var(--blue-lt); }
.la-hrcal-tl-time { border-right:1px solid var(--border); border-bottom:1px solid var(--border); padding:6px 8px; font-size:10.5px; font-weight:600; color:var(--ink4); text-align:right; background:var(--white); }
.la-hrcal-tl-cell { border-left:1px solid var(--border); border-bottom:1px solid var(--border); background:var(--white); min-height:40px; padding:3px; cursor:pointer; transition:background .12s; }
.la-hrcal-tl-cell:hover { background:var(--blue-lt); }
.la-hrcal-tl-task { background:var(--blue); color:#fff; border-radius:5px; font-size:10px; font-weight:700; padding:3px 7px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:flex; align-items:center; gap:4px; margin-bottom:2px; }

/* ══ ATTENDANCE TOOLBAR ══════════════════════════════════ */
.la-att-toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:12px 16px; }
.la-att-month-nav { display:flex; align-items:center; gap:8px; flex-shrink:0; }
.la-att-month-btn { width:30px; height:30px; border-radius:8px; background:var(--bg); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .12s; }
.la-att-month-btn:hover { background:var(--blue-lt); border-color:var(--blue-brd); }
.la-att-month-btn svg { width:13px; height:13px; stroke:var(--ink3); fill:none; stroke-width:2; }
.la-att-month-label { font-family:'Sora',sans-serif; font-size:14px; font-weight:800; color:var(--ink); min-width:130px; text-align:center; }

@media (max-width:1100px) { .la-hrcal-2col{grid-template-columns:1fr;} .la-hrcal-sidebar{display:grid;grid-template-columns:1fr 1fr;gap:14px;} }
@media (max-width:768px)  { .la-chat-conv-col{display:none;} .la-hrcal-2col{grid-template-columns:1fr;} .la-hrcal-sidebar{grid-template-columns:1fr;} }
@media (max-width:560px)  { .la-hrcal-tabs{gap:4px;} .la-hrcal-tab{padding:7px 10px;font-size:11.5px;} }

</style>

{{-- ══ SIDE NAV ══════════════════════════════════════════════ --}}
@php
    $pendingLeaveCount = 0;
    try { $pendingLeaveCount = \App\Models\LeaveRequest::where('status','pending')->count(); } catch(\Exception $e){}
@endphp
<aside class="la-local-sidebar">
    <nav class="la-local-nav">
        <button class="la-nav-item {{ $activeSection==='overview'?'active':'' }}" data-section="overview" onclick="laSwitch('overview',this)">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            <span>Overview</span>
        </button>

        <button class="la-nav-item {{ $activeSection==='leaves'?'active':'' }}" data-section="leaves" onclick="laSwitch('leaves',this)">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Leave Management</span>
            @if($pendingLeaveCount > 0)
                <span class="la-nav-badge amber">{{ $pendingLeaveCount }}</span>
            @endif
        </button>

        <button class="la-nav-item {{ $activeSection==='communication'?'active':'' }}" data-section="communication" onclick="laSwitch('communication',this)">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span>Communication</span>
            @if(($msgUnread??0) > 0)<span class="la-nav-badge amber">{{ $msgUnread }}</span>@endif
        </button>

        <button class="la-nav-item {{ $activeSection==='calendar'?'active':'' }}" data-section="calendar" onclick="laSwitch('calendar',this)">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span>Calendar</span>
        </button>

        <button class="la-nav-item {{ $activeSection==='attendance'?'active':'' }}" data-section="attendance" onclick="laSwitch('attendance',this)">
            <svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <span>Attendance</span>
        </button>
    </nav>
</aside>

{{-- ══ CONTENT ════════════════════════════════════════════════ --}}
<main class="la-local-main">


{{-- ════════════════════════════════════════════════════════
     SECTION 1 — OVERVIEW
════════════════════════════════════════════════════════ --}}
<div class="la-section {{ $activeSection==='overview'?'active':'' }}" id="section-overview">
@php
    $empTotal=0; $empPresent=0; $leavePending=0; $leaveApproved=0; $leaveTaken=0;
    $recentLeaves=collect(); $todayAtt=collect(); $attRate=0;
    try {
        $empTotal      = \App\Models\Employee::count();
        $empPresent    = \App\Models\Attendance::whereDate('date',today())->whereNotNull('check_in')->count();
        $leavePending  = \App\Models\LeaveRequest::where('status','pending')->count();
        $leaveApproved = \App\Models\LeaveRequest::where('status','approved')->whereMonth('start_date',now()->month)->count();
        $leaveTaken    = \App\Models\LeaveRequest::where('status','approved')->whereDate('start_date','<=',today())->whereDate('end_date','>=',today())->count();
        $recentLeaves  = \App\Models\LeaveRequest::with(['employee','leaveType'])->orderBy('created_at','desc')->take(5)->get();
        $todayAtt      = \App\Models\Attendance::with('employee')->whereDate('date',today())->orderBy('check_in','asc')->take(8)->get();
        $attRate = $empTotal > 0 ? round(($empPresent/$empTotal)*100) : 0;
    } catch(\Exception $e){}
@endphp
<div class="la-wrap">

    <div class="la-hero">
        <div class="la-hero-left">
            <div class="la-hero-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="la-hero-title">Leaves &amp; Attendance</div>
                <div class="la-hero-sub">{{ \Carbon\Carbon::now('Africa/Kigali')->format('l, j F Y') }} &mdash; Kigali, Rwanda</div>
                <div class="la-hero-chips">
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>{{ $empTotal }} Employees</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg>{{ $attRate }}% Present Today</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $leavePending }} Pending Leaves</span>
                </div>
            </div>
        </div>
        <div class="la-hero-right">
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $empPresent }}</div><div class="la-hero-sl">Present</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $leaveTaken }}</div><div class="la-hero-sl">On Leave</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $leavePending }}</div><div class="la-hero-sl">Pending</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $attRate }}%</div><div class="la-hero-sl">Rate</div></div>
        </div>
    </div>

    <div class="la-tiles">
        <div class="la-tile la-t-blue" onclick="laSwitch('attendance',document.querySelector('[data-section=attendance]'))">
            <div class="la-tile-bar"></div>
            <div class="la-tile-icon"><svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
            <div><div class="la-tile-lbl">Present Today</div><div class="la-tile-val">{{ $empPresent }}</div><div class="la-tile-sub">of {{ $empTotal }} employees</div></div>
        </div>
        <div class="la-tile la-t-amber" onclick="laSwitch('leaves',document.querySelector('[data-section=leaves]'))">
            <div class="la-tile-bar"></div>
            <div class="la-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <div><div class="la-tile-lbl">Pending Leaves</div><div class="la-tile-val">{{ $leavePending }}</div><div class="la-tile-sub">awaiting approval</div></div>
        </div>
        <div class="la-tile la-t-green" onclick="laSwitch('leaves',document.querySelector('[data-section=leaves]'))">
            <div class="la-tile-bar"></div>
            <div class="la-tile-icon"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><div class="la-tile-lbl">Approved (Month)</div><div class="la-tile-val">{{ $leaveApproved }}</div><div class="la-tile-sub">this month</div></div>
        </div>
        <div class="la-tile la-t-red">
            <div class="la-tile-bar"></div>
            <div class="la-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
            <div><div class="la-tile-lbl">On Leave Today</div><div class="la-tile-val">{{ $leaveTaken }}</div><div class="la-tile-sub">currently absent</div></div>
        </div>
    </div>

    <div class="la-ov-grid">
        <div class="la-ov-col">
            {{-- Recent leave requests --}}
            <div class="la-card">
                <div class="la-card-hd">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                        <div><div class="la-card-ttl">Recent Leave Requests</div><div class="la-card-sub">Latest submissions</div></div>
                    </div>
                    <button class="la-card-lnk" onclick="laSwitch('leaves',document.querySelector('[data-section=leaves]'))">View all <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
                </div>
                <div class="la-table-wrap">
                    <table class="la-table">
                        <thead><tr><th>Employee</th><th>Leave Type</th><th>Duration</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($recentLeaves as $lr)
                                @php
                                    $emp = $lr->employee;
                                    $initials = $emp ? strtoupper(substr($emp->first_name??'',0,1).substr($emp->last_name??'',0,1)) : '??';
                                    $lrStatus = $lr->status instanceof \BackedEnum ? $lr->status->value : ($lr->status ?? '');
                                    $statusClass = match($lrStatus){ 'approved'=>'lb-green','pending'=>'lb-amber','rejected'=>'lb-red', default=>'lb-gray' };
                                    $days = \Carbon\Carbon::parse($lr->start_date)->diffInDays(\Carbon\Carbon::parse($lr->end_date)) + 1;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="la-emp-cell">
                                            <div class="la-emp-av">{{ $initials }}</div>
                                            <div><div class="la-emp-name">{{ $emp ? $emp->first_name.' '.$emp->last_name : '—' }}</div><div class="la-emp-role">{{ $emp?->department?->name ?? '' }}</div></div>
                                        </div>
                                    </td>
                                    <td>{{ $lr->leaveType?->name ?? $lr->leave_type ?? '—' }}</td>
                                    <td>{{ $days }} day{{ $days!=1?'s':'' }}</td>
                                    <td><span class="la-badge {{ $statusClass }}">{{ ucfirst($lrStatus) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4"><div class="la-empty"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg><div class="la-empty-ttl">No leave requests</div></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Today's attendance --}}
            <div class="la-card">
                <div class="la-card-hd">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg></div>
                        <div><div class="la-card-ttl">Today's Attendance</div><div class="la-card-sub">{{ today()->format('l, F j') }}</div></div>
                    </div>
                    <button class="la-card-lnk" onclick="laSwitch('attendance',document.querySelector('[data-section=attendance]'))">Full log <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
                </div>
                <div class="la-table-wrap">
                    <table class="la-table">
                        <thead><tr><th>Employee</th><th>Check In</th><th>Check Out</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($todayAtt as $att)
                                @php
                                    $attEmp = $att->employee;
                                    $attInit = $attEmp ? strtoupper(substr($attEmp->first_name??'',0,1).substr($attEmp->last_name??'',0,1)) : '??';
                                    $attStatus = $att->status instanceof \BackedEnum ? $att->status->value : ($att->status ?? 'present');
                                    $attCls = match($attStatus){'present'=>'la-att-present','absent'=>'la-att-absent','late'=>'la-att-late','leave'=>'la-att-leave','half_day'=>'la-att-half',default=>'la-att-present'};
                                @endphp
                                <tr>
                                    <td><div class="la-emp-cell"><div class="la-emp-av">{{ $attInit }}</div><div class="la-emp-name">{{ $attEmp ? trim($attEmp->first_name.' '.$attEmp->last_name) : '—' }}</div></div></td>
                                    <td style="font-weight:700;color:var(--blue-2);">{{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('H:i') : '—' }}</td>
                                    <td style="color:var(--ink3);">{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('H:i') : '—' }}</td>
                                    <td><span class="la-att-status {{ $attCls }}">{{ ucfirst(str_replace('_',' ',$attStatus)) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4"><div class="la-empty"><svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg><div class="la-empty-ttl">No records yet</div></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="la-ov-col">
            {{-- Summary card --}}
            <div class="la-card">
                <div class="la-card-hd">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div><div class="la-card-ttl">Today's Summary</div></div>
                    </div>
                </div>
                <div class="la-card-bd">
                    @php
                        $rows = [
                            ['label'=>'Total Employees',  'val'=>$empTotal,     'color'=>'#3B6FE8'],
                            ['label'=>'Present',           'val'=>$empPresent,   'color'=>'#12B76A'],
                            ['label'=>'On Leave',          'val'=>$leaveTaken,   'color'=>'#7C3AED'],
                            ['label'=>'Absent',            'val'=>max(0,$empTotal-$empPresent-$leaveTaken), 'color'=>'#EF4444'],
                            ['label'=>'Pending Approvals', 'val'=>$leavePending, 'color'=>'#F59E0B'],
                        ];
                    @endphp
                    @foreach($rows as $row)
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:9px 0;border-bottom:1px solid var(--border);">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:8px;height:8px;border-radius:50%;background:{{ $row['color'] }};flex-shrink:0;"></div>
                                <span style="font-size:13px;font-weight:600;color:var(--ink3);">{{ $row['label'] }}</span>
                            </div>
                            <span style="font-family:'Sora',sans-serif;font-size:16px;font-weight:800;color:{{ $row['color'] }};">{{ $row['val'] }}</span>
                        </div>
                    @endforeach
                    <div style="margin-top:14px;">
                        <div style="display:flex;justify-content:space-between;font-size:11px;font-weight:700;color:var(--ink4);margin-bottom:6px;"><span>Attendance Rate</span><span>{{ $attRate }}%</span></div>
                        <div style="height:8px;background:var(--bg);border-radius:100px;overflow:hidden;">
                            <div style="height:100%;border-radius:100px;background:linear-gradient(90deg,var(--blue-2),var(--blue));width:{{ $attRate }}%;transition:width .5s;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="la-card">
                <div class="la-card-hd">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
                        <div><div class="la-card-ttl">Quick Actions</div></div>
                    </div>
                </div>
                <div class="la-card-bd">
                    <button class="la-quick-action" onclick="laSwitch('leaves',document.querySelector('[data-section=leaves]'))">
                        <div class="la-qa-icon" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                        <div><div class="la-qa-lbl">New Leave Request</div><div class="la-qa-sub">Submit a leave application</div></div>
                        <svg class="la-qa-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <button class="la-quick-action" onclick="laSwitch('leaves',document.querySelector('[data-section=leaves]'))">
                        <div class="la-qa-icon" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg></div>
                        <div><div class="la-qa-lbl">Approve Leaves</div><div class="la-qa-sub">{{ $leavePending }} awaiting review</div></div>
                        <svg class="la-qa-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <button class="la-quick-action" onclick="laSwitch('attendance',document.querySelector('[data-section=attendance]'))">
                        <div class="la-qa-icon" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg></div>
                        <div><div class="la-qa-lbl">View Attendance Log</div><div class="la-qa-sub">Full attendance history</div></div>
                        <svg class="la-qa-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <button class="la-quick-action" onclick="laSwitch('calendar',document.querySelector('[data-section=calendar]'))">
                        <div class="la-qa-icon" style="background:var(--purple-lt);"><svg style="stroke:var(--purple)" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div><div class="la-qa-lbl">Open Calendar</div><div class="la-qa-sub">Leaves &amp; holidays view</div></div>
                        <svg class="la-qa-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>{{-- /section-overview --}}


{{--
    SECTION 2 — LEAVE MANAGEMENT  (drop-in replacement for the existing section-leaves block)

    Key fixes:
    • Total leave entitlement is capped at 30 days per year regardless of leave type
    • Leave types share the same 30-day annual pool — used days are summed across ALL types
    • A dedicated "Leave Balance" tab is added inside the section so it has its own clear view
    • Logic no longer reads max_days/days_allowed from individual leave types for the total
--}}

{{-- ════════════════════════════════════════════════════════
     SECTION 2 — LEAVE MANAGEMENT
════════════════════════════════════════════════════════ --}}
<div class="la-section {{ $activeSection==='leaves'?'active':'' }}" id="section-leaves">
@php
    /* ── Constants ─────────────────────────────────────── */
    const ANNUAL_LEAVE_CAP = 30;          // Rwanda Labour Law: 30 days/year max

    $leaveRequests = collect();
    $leaveTypes    = collect();
    $allEmployees  = collect();
    $pendingAll = $approvedAll = $rejectedAll = 0;
    $pendingLeaves = collect();

    try {
        $leaveRequests = \App\Models\LeaveRequest::with(['employee','leaveType'])
            ->orderBy('created_at','desc')
            ->paginate(20, ['*'], 'leavePage');
        $leaveTypes    = \App\Models\LeaveType::all();
        $allEmployees  = \App\Models\Employee::orderBy('first_name')->get(['id','first_name','last_name']);
        $pendingAll    = \App\Models\LeaveRequest::where('status','pending')->count();
        $approvedAll   = \App\Models\LeaveRequest::where('status','approved')->count();
        $rejectedAll   = \App\Models\LeaveRequest::where('status','rejected')->count();
        $pendingLeaves = \App\Models\LeaveRequest::with(['employee','leaveType'])
            ->where('status','pending')
            ->orderBy('created_at','asc')
            ->get();
    } catch(\Exception $e) {}

    /* ── Leave balance query for the selected employee ── */
    $balYear      = (int) request('bal_year', now()->year);
    $balEmpId     = request('bal_emp', '');
    $balEmployee  = null;
    $empLeaveData = collect();        // per-type breakdown
    $totalUsedAll = $totalRemAll = 0; // across ALL types (capped pool)

    if ($balEmpId) {
        try {
            $balEmployee = \App\Models\Employee::with('department')->find($balEmpId);

            if ($balEmployee && $leaveTypes->count()) {

                /* Sum every approved request across ALL leave types for this year */
                $allApprovedDays = \App\Models\LeaveRequest::where('employee_id', $balEmpId)
                    ->where('status', 'approved')
                    ->whereYear('start_date', $balYear)
                    ->get()
                    ->sum(function ($r) {
                        // prefer the stored total_days field; fall back to date diff
                        if (!empty($r->total_days) && $r->total_days > 0) {
                            return (int) $r->total_days;
                        }
                        return \Carbon\Carbon::parse($r->start_date)
                            ->diffInDays(\Carbon\Carbon::parse($r->end_date)) + 1;
                    });

                /* Pool is 30 days; can never go negative */
                $totalUsedAll = min($allApprovedDays, ANNUAL_LEAVE_CAP);
                $totalRemAll  = max(0, ANNUAL_LEAVE_CAP - $totalUsedAll);

                /* Per-type breakdown (used only for the detail table rows) */
                $empLeaveData = $leaveTypes->map(function ($lt) use ($balEmpId, $balYear) {
                    $reqs = \App\Models\LeaveRequest::with('leaveType')
                        ->where('employee_id', $balEmpId)
                        ->where('leave_type_id', $lt->id)
                        ->whereYear('start_date', $balYear)
                        ->orderBy('start_date', 'desc')
                        ->get();

                    $used = $reqs->where('status', 'approved')
                        ->sum(function ($r) {
                            if (!empty($r->total_days) && $r->total_days > 0) return (int) $r->total_days;
                            return \Carbon\Carbon::parse($r->start_date)
                                ->diffInDays(\Carbon\Carbon::parse($r->end_date)) + 1;
                        });

                    return [
                        'type'     => $lt,
                        'requests' => $reqs,
                        'used'     => $used,
                    ];
                });
            }
        } catch(\Exception $e) {}
    }

    /* ── Active leave sub-tab (requests | balance | submit) ── */
    $leaveTab = request('leave_tab', 'requests');
@endphp

<div class="la-wrap">

    {{-- ── Hero ── --}}
    <div class="la-hero">
        <div class="la-hero-left">
            <div class="la-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <div class="la-hero-title">Leave Management</div>
                <div class="la-hero-sub">30-day annual entitlement · Rwanda Labour Law</div>
                <div class="la-hero-chips">
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>{{ $pendingAll }} Pending</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ $approvedAll }} Approved</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $rejectedAll }} Rejected</span>
                </div>
            </div>
        </div>
        <div class="la-hero-right">
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $pendingAll }}</div><div class="la-hero-sl">Pending</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $approvedAll }}</div><div class="la-hero-sl">Approved</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ ANNUAL_LEAVE_CAP }}</div><div class="la-hero-sl">Days/Year</div></div>
        </div>
    </div>

    {{-- ══ INNER TABS ═══════════════════════════════════════════════════════════ --}}
    <div style="display:flex;gap:6px;background:var(--white);border:1px solid var(--border);border-radius:var(--r-lg);box-shadow:var(--sh-sm);padding:10px 14px;flex-wrap:wrap;">
        @foreach([
            ['requests', 'Requests', '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
            ['balance',  'Leave Balance', '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
            ['pending',  'Pending Approvals', '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'],
            ['submit',   'Submit Request', '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>'],
        ] as [$tab, $label, $icon])
            <a href="?leave_tab={{ $tab }}#section-leaves"
               style="display:inline-flex;align-items:center;gap:7px;padding:8px 14px;border-radius:var(--r);font-size:13px;font-weight:700;cursor:pointer;border:none;font-family:'DM Sans',sans-serif;transition:all .15s;text-decoration:none;
                      {{ $leaveTab===$tab ? 'background:var(--blue);color:#fff;box-shadow:0 4px 12px rgba(59,111,232,0.28);' : 'background:var(--bg);color:var(--ink3);' }}">
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;">{!! $icon !!}</svg>
                {{ $label }}
                @if($tab==='pending' && $pendingAll>0)
                    <span style="background:{{ $leaveTab==='pending'?'rgba(255,255,255,0.25)':'var(--amber-lt)' }};color:{{ $leaveTab==='pending'?'#fff':'#92400E' }};font-size:10px;font-weight:800;padding:1px 7px;border-radius:100px;">{{ $pendingAll }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════
         TAB 1 — ALL REQUESTS
    ══════════════════════════════════════════════════════ --}}
    @if($leaveTab === 'requests')
    <div class="la-card">
        <div class="la-card-hd">
            <div class="la-card-hdl">
                <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <div><div class="la-card-ttl">All Leave Requests</div><div class="la-card-sub">Full history · paginated</div></div>
            </div>
        </div>
        <div class="la-table-wrap">
            <table class="la-table">
                <thead><tr><th>Employee</th><th>Type</th><th>Period</th><th>Days</th><th>Applied</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($leaveRequests as $lr)
                        @php
                            $lre    = $lr->employee;
                            $lrInit = $lre ? strtoupper(substr($lre->first_name??'',0,1).substr($lre->last_name??'',0,1)) : '??';
                            $lrStat = $lr->status instanceof \BackedEnum ? $lr->status->value : ($lr->status ?? '');
                            $lrCls  = match($lrStat){ 'approved'=>'lb-green','pending'=>'lb-amber','rejected'=>'lb-red', default=>'lb-gray' };
                            $lrDays = !empty($lr->total_days) && $lr->total_days > 0
                                ? (int)$lr->total_days
                                : \Carbon\Carbon::parse($lr->start_date)->diffInDays(\Carbon\Carbon::parse($lr->end_date)) + 1;
                        @endphp
                        <tr>
                            <td>
                                <div class="la-emp-cell">
                                    <div class="la-emp-av">{{ $lrInit }}</div>
                                    <div>
                                        <div class="la-emp-name">{{ $lre ? $lre->first_name.' '.$lre->last_name : '—' }}</div>
                                        <div class="la-emp-role">{{ $lre?->department?->name ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $lr->leaveType?->name ?? $lr->leave_type ?? '—' }}</td>
                            <td style="font-size:12.5px;color:var(--ink3);">
                                {{ \Carbon\Carbon::parse($lr->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($lr->end_date)->format('M d, Y') }}
                            </td>
                            <td><span class="la-badge lb-blue">{{ $lrDays }}d</span></td>
                            <td style="color:var(--ink4);font-size:12px;">{{ \Carbon\Carbon::parse($lr->created_at)->format('M d, Y') }}</td>
                            <td><span class="la-badge {{ $lrCls }}">{{ ucfirst($lrStat) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="la-empty">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
                                <div class="la-empty-ttl">No leave requests</div>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($leaveRequests,'hasPages') && $leaveRequests->hasPages())
            <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
                <span style="font-size:12.5px;color:var(--ink4);">Showing {{ $leaveRequests->firstItem() }}–{{ $leaveRequests->lastItem() }} of {{ $leaveRequests->total() }}</span>
                {{ $leaveRequests->links() }}
            </div>
        @endif
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         TAB 2 — LEAVE BALANCE (per employee, 30-day pool)
    ══════════════════════════════════════════════════════ --}}
    @if($leaveTab === 'balance')
    <div class="la-card" id="la-emp-balance-card">
        <div class="la-card-hd">
            <div class="la-card-hdl">
                <div class="la-card-ico" style="background:var(--purple-lt);border:1px solid rgba(124,58,237,0.22);">
                    <svg style="stroke:var(--purple)" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <div class="la-card-ttl">Employee Leave Balance</div>
                    <div class="la-card-sub">30-day annual pool · all leave types combined</div>
                </div>
            </div>
        </div>
        <div class="la-card-bd">

            {{-- ── Selector ── --}}
            <form method="GET" action="" id="la-bal-form"
                  style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;margin-bottom:20px;"
                  onsubmit="this.action=window.location.pathname+'?leave_tab=balance#section-leaves';">
                <input type="hidden" name="leave_tab" value="balance">
                <div class="la-field" style="flex:1;min-width:200px;">
                    <label>Employee</label>
                    <select name="bal_emp" onchange="document.getElementById('la-bal-form').submit()">
                        <option value="">— Select employee —</option>
                        @foreach($allEmployees as $emp)
                            <option value="{{ $emp->id }}" {{ $balEmpId == $emp->id ? 'selected' : '' }}>
                                {{ $emp->first_name }} {{ $emp->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="la-field" style="min-width:120px;">
                    <label>Year</label>
                    <select name="bal_year" onchange="document.getElementById('la-bal-form').submit()">
                        @for($y = now()->year; $y >= now()->year - 4; $y--)
                            <option value="{{ $y }}" {{ $balYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </form>

            @if($balEmployee && $empLeaveData->count())

                {{-- ── Employee header + 30-day summary ── --}}
                <div style="display:flex;align-items:center;gap:14px;padding:14px 16px;background:var(--bg);border-radius:var(--r);margin-bottom:18px;flex-wrap:wrap;">
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--blue),var(--indigo));display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:#fff;flex-shrink:0;">
                        {{ strtoupper(substr($balEmployee->first_name,0,1).substr($balEmployee->last_name,0,1)) }}
                    </div>
                    <div>
                        <div style="font-family:'Sora',sans-serif;font-size:15px;font-weight:800;color:var(--ink);">
                            {{ $balEmployee->first_name }} {{ $balEmployee->last_name }}
                        </div>
                        <div style="font-size:12px;color:var(--ink3);font-weight:500;">
                            {{ $balEmployee->department?->name ?? '—' }} · {{ $balYear }} Leave Summary
                        </div>
                    </div>
                    <div style="margin-left:auto;display:flex;gap:20px;flex-wrap:wrap;">
                        <div style="text-align:center;">
                            <div style="font-family:'Sora',sans-serif;font-size:22px;font-weight:800;color:var(--red);">{{ $totalUsedAll }}</div>
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--ink4);">Days Used</div>
                        </div>
                        <div style="text-align:center;">
                            <div style="font-family:'Sora',sans-serif;font-size:22px;font-weight:800;color:var(--green);">{{ $totalRemAll }}</div>
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--ink4);">Remaining</div>
                        </div>
                        <div style="text-align:center;">
                            <div style="font-family:'Sora',sans-serif;font-size:22px;font-weight:800;color:var(--blue-2);">{{ ANNUAL_LEAVE_CAP }}</div>
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--ink4);">Annual Cap</div>
                        </div>
                    </div>
                </div>

                {{-- ── Master progress bar (30-day pool) ── --}}
                @php
                    $masterPct  = min(100, round(($totalUsedAll / ANNUAL_LEAVE_CAP) * 100));
                    $masterColor= $masterPct >= 90 ? 'var(--red)' : ($masterPct >= 60 ? 'var(--amber)' : 'var(--green)');
                @endphp
                <div style="margin-bottom:20px;">
                    <div style="display:flex;justify-content:space-between;font-size:11.5px;font-weight:700;color:var(--ink3);margin-bottom:7px;">
                        <span>Annual Leave Pool Usage</span>
                        <span style="color:{{ $masterColor }};">{{ $totalUsedAll }} of {{ ANNUAL_LEAVE_CAP }} days used ({{ $masterPct }}%)</span>
                    </div>
                    <div style="height:12px;background:var(--bg);border-radius:100px;border:1px solid var(--border);overflow:hidden;">
                        <div style="height:100%;border-radius:100px;background:{{ $masterColor }};width:{{ $masterPct }}%;transition:width .5s;"></div>
                    </div>
                    @if($totalUsedAll >= ANNUAL_LEAVE_CAP)
                        <div style="margin-top:8px;padding:8px 13px;background:var(--red-lt);border:1px solid rgba(239,68,68,0.22);border-radius:var(--r);font-size:12.5px;font-weight:600;color:#991B1B;display:flex;align-items:center;gap:7px;">
                            <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Annual entitlement fully used — no more leave days available for {{ $balYear }}.
                        </div>
                    @elseif($totalRemAll <= 5)
                        <div style="margin-top:8px;padding:8px 13px;background:var(--amber-lt);border:1px solid rgba(245,158,11,0.22);border-radius:var(--r);font-size:12.5px;font-weight:600;color:#92400E;display:flex;align-items:center;gap:7px;">
                            <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            Only {{ $totalRemAll }} day{{ $totalRemAll != 1 ? 's' : '' }} remaining for {{ $balYear }}.
                        </div>
                    @endif
                </div>

                {{-- ── Per-type breakdown cards ── --}}
                <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:10px;">
                    Breakdown by Leave Type
                </div>
                @foreach($empLeaveData as $ld)
                    @if($ld['requests']->count() === 0) @continue @endif
                    @php
                        $ldPct   = ANNUAL_LEAVE_CAP > 0 ? min(100, round(($ld['used'] / ANNUAL_LEAVE_CAP) * 100)) : 0;
                        $ldColor = $ldPct >= 90 ? 'var(--red)' : ($ldPct >= 60 ? 'var(--amber)' : 'var(--blue)');
                    @endphp
                    <div style="border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;margin-bottom:12px;">
                        {{-- Type header --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:var(--white);">
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div style="width:9px;height:9px;border-radius:50%;background:{{ $ldColor }};flex-shrink:0;"></div>
                                <div>
                                    <div style="font-size:13.5px;font-weight:700;color:var(--ink);">{{ $ld['type']->name }}</div>
                                    <div style="font-size:11px;color:var(--ink4);">{{ $ld['type']->is_paid ? 'Paid leave' : 'Unpaid leave' }} · {{ $ld['used'] }}d drawn from 30-day pool</div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <span class="la-badge {{ $ld['used'] > 0 ? 'lb-blue' : 'lb-gray' }}">{{ $ld['used'] }} day{{ $ld['used'] != 1 ? 's' : '' }} used</span>
                            </div>
                        </div>
                        {{-- Thin progress strip --}}
                        <div style="height:4px;background:var(--bg);">
                            <div style="height:100%;background:{{ $ldColor }};width:{{ $ldPct }}%;transition:width .5s;"></div>
                        </div>
                        {{-- Individual request rows --}}
                        <div style="background:#FAFBFF;">
                            <table class="la-table" style="font-size:12.5px;">
                                <thead>
                                    <tr>
                                        <th style="padding:8px 18px;font-size:10px;">From</th>
                                        <th style="padding:8px 16px;font-size:10px;">To</th>
                                        <th style="padding:8px 16px;font-size:10px;">Days</th>
                                        <th style="padding:8px 16px;font-size:10px;">Reason</th>
                                        <th style="padding:8px 16px;font-size:10px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ld['requests'] as $req)
                                        @php
                                            $reqStat = $req->status instanceof \BackedEnum ? $req->status->value : ($req->status ?? '');
                                            $reqCls  = match($reqStat){ 'approved'=>'lb-green','pending'=>'lb-amber','rejected'=>'lb-red', default=>'lb-gray' };
                                            $reqDays = !empty($req->total_days) && $req->total_days > 0
                                                ? (int)$req->total_days
                                                : \Carbon\Carbon::parse($req->start_date)->diffInDays(\Carbon\Carbon::parse($req->end_date)) + 1;
                                        @endphp
                                        <tr>
                                            <td style="padding:9px 18px;font-weight:600;color:var(--ink2);">{{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</td>
                                            <td style="padding:9px 16px;color:var(--ink3);">{{ \Carbon\Carbon::parse($req->end_date)->format('M d, Y') }}</td>
                                            <td style="padding:9px 16px;"><span class="la-badge lb-blue">{{ $reqDays }}d</span></td>
                                            <td style="padding:9px 16px;color:var(--ink3);max-width:220px;">{{ \Illuminate\Support\Str::limit($req->reason ?? $req->notes ?? '—', 55) }}</td>
                                            <td style="padding:9px 16px;"><span class="la-badge {{ $reqCls }}">{{ ucfirst($reqStat) }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                {{-- If all leave types have 0 requests but we still have data --}}
                @if($empLeaveData->sum(fn($l) => $l['requests']->count()) === 0)
                    <div class="la-empty" style="padding:28px 0;">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
                        <div class="la-empty-ttl">No leave requests in {{ $balYear }}</div>
                        <div class="la-empty-sub">All {{ ANNUAL_LEAVE_CAP }} days are available</div>
                    </div>
                @endif

            @elseif($balEmpId && !$balEmployee)
                <div class="la-empty">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div class="la-empty-ttl">Employee not found</div>
                </div>
            @else
                <div class="la-empty" style="padding:36px;">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div class="la-empty-ttl">Select an employee above</div>
                    <div class="la-empty-sub">Choose an employee and year to view their 30-day leave balance and full request history</div>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         TAB 3 — PENDING APPROVALS
    ══════════════════════════════════════════════════════ --}}
    @if($leaveTab === 'pending')
    @if($pendingLeaves->count())
    <div class="la-card">
        <div class="la-card-hd">
            <div class="la-card-hdl">
                <div class="la-card-ico" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                <div>
                    <div class="la-card-ttl">Pending Approvals</div>
                    <div class="la-card-sub">{{ $pendingLeaves->count() }} request{{ $pendingLeaves->count() != 1 ? 's' : '' }} awaiting decision</div>
                </div>
            </div>
            <span class="la-badge lb-amber">{{ $pendingLeaves->count() }} pending</span>
        </div>
        <div class="la-table-wrap">
            <table class="la-table">
                <thead><tr><th>Employee</th><th>Leave Type</th><th>From</th><th>To</th><th>Days</th><th>Reason</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($pendingLeaves as $pl)
                        @php
                            $plEmp  = $pl->employee;
                            $plInit = $plEmp ? strtoupper(substr($plEmp->first_name??'',0,1).substr($plEmp->last_name??'',0,1)) : '??';
                            $plDays = !empty($pl->total_days) && $pl->total_days > 0
                                ? (int)$pl->total_days
                                : \Carbon\Carbon::parse($pl->start_date)->diffInDays(\Carbon\Carbon::parse($pl->end_date)) + 1;

                            /* Check how many days this employee has already used this year */
                            $plUsed = 0;
                            try {
                                $plUsed = \App\Models\LeaveRequest::where('employee_id', $plEmp?->id)
                                    ->where('status','approved')
                                    ->whereYear('start_date', now()->year)
                                    ->get()
                                    ->sum(fn($r) => !empty($r->total_days) && $r->total_days > 0
                                        ? (int)$r->total_days
                                        : \Carbon\Carbon::parse($r->start_date)->diffInDays(\Carbon\Carbon::parse($r->end_date)) + 1
                                    );
                            } catch(\Exception $e) {}
                            $plRemaining = max(0, ANNUAL_LEAVE_CAP - $plUsed);
                            $plExceeds   = $plDays > $plRemaining;
                        @endphp
                        <tr>
                            <td>
                                <div class="la-emp-cell">
                                    <div class="la-emp-av">{{ $plInit }}</div>
                                    <div>
                                        <div class="la-emp-name">{{ $plEmp ? $plEmp->first_name.' '.$plEmp->last_name : '—' }}</div>
                                        <div class="la-emp-role">{{ $plEmp?->department?->name ?? '' }} · {{ $plRemaining }}d remaining</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $pl->leaveType?->name ?? $pl->leave_type ?? '—' }}</td>
                            <td style="font-weight:600;">{{ \Carbon\Carbon::parse($pl->start_date)->format('M d, Y') }}</td>
                            <td style="font-weight:600;">{{ \Carbon\Carbon::parse($pl->end_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="la-badge {{ $plExceeds ? 'lb-red' : 'lb-blue' }}">{{ $plDays }}d</span>
                                @if($plExceeds)
                                    <div style="font-size:10px;color:var(--red);font-weight:700;margin-top:2px;">Exceeds balance!</div>
                                @endif
                            </td>
                            <td style="max-width:180px;color:var(--ink3);font-size:12.5px;">{{ \Illuminate\Support\Str::limit($pl->reason ?? $pl->notes ?? '—', 50) }}</td>
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                    @if(\Illuminate\Support\Facades\Route::has('hr.leaves.approve'))
                                        <a href="{{ route('hr.leaves.approve', $pl->id) }}"
                                           class="la-btn la-btn-green la-btn-sm"
                                           onclick="return confirm('Approve this leave request?')">
                                            <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> Approve
                                        </a>
                                        <a href="{{ route('hr.leaves.reject', $pl->id) }}"
                                           class="la-btn la-btn-danger la-btn-sm"
                                           onclick="return confirm('Reject this leave request?')">Reject</a>
                                    @else
                                        <span class="la-badge lb-amber">Pending</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="la-card">
            <div class="la-empty" style="padding:48px;">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div class="la-empty-ttl">All clear — no pending requests</div>
                <div class="la-empty-sub">Every leave request has been actioned</div>
            </div>
        </div>
    @endif
    @endif

    {{-- ══════════════════════════════════════════════════════
         TAB 4 — SUBMIT REQUEST
    ══════════════════════════════════════════════════════ --}}
    @if($leaveTab === 'submit')
    <div class="la-card">
        <div class="la-card-hd">
            <div class="la-card-hdl">
                <div class="la-card-ico" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                <div><div class="la-card-ttl">Submit Leave Request</div><div class="la-card-sub">Max 30 days per year across all leave types</div></div>
            </div>
        </div>
        <div class="la-card-bd">
            @if(\Illuminate\Support\Facades\Route::has('employee.leave.store'))
                <form action="{{ route('employee.leave.store') }}" method="POST">
                    @csrf
                    <div class="la-grid2" style="margin-bottom:14px;">
                        <div class="la-field">
                            <label>Employee <span class="req">*</span></label>
                            <select name="employee_id" required>
                                <option value="">Select employee…</option>
                                @foreach($allEmployees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="la-field">
                            <label>Leave Type <span class="req">*</span></label>
                            <select name="leave_type_id" required>
                                <option value="">Select type…</option>
                                @foreach($leaveTypes as $lt)
                                    <option value="{{ $lt->id }}">{{ $lt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="la-field">
                            <label>Start Date <span class="req">*</span></label>
                            <input type="date" name="start_date" required>
                        </div>
                        <div class="la-field">
                            <label>End Date <span class="req">*</span></label>
                            <input type="date" name="end_date" required>
                        </div>
                    </div>
                    <div class="la-field" style="margin-bottom:16px;">
                        <label>Reason / Notes</label>
                        <textarea name="reason" placeholder="Briefly explain the reason for your leave…"></textarea>
                    </div>
                    <div style="background:var(--blue-lt);border:1px solid var(--blue-brd);border-radius:var(--r);padding:10px 14px;margin-bottom:16px;font-size:12.5px;color:var(--blue-2);font-weight:600;display:flex;align-items:center;gap:8px;">
                        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Employees are entitled to a maximum of <strong>30 days</strong> of leave per year across all leave types combined (Rwanda Labour Law).
                    </div>
                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="la-btn la-btn-primary">
                            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                            Submit Request
                        </button>
                    </div>
                </form>
            @else
                <p style="color:var(--ink4);font-size:13px;">Leave submission form not available — route not configured.</p>
            @endif
        </div>
    </div>
    @endif

</div>
</div>{{-- /section-leaves --}}


{{-- ════════════════════════════════════════════════════════
     SECTION 3 — COMMUNICATION  (chat-style, HR version)
════════════════════════════════════════════════════════ --}}
<div class="la-section {{ $activeSection==='communication'?'active':'' }}" id="section-communication">
<div class="la-wrap" style="gap:14px;">

    {{-- Standardized Hero (Deep Ocean) --}}
    <div class="la-hero">
        <div class="la-hero-left">
            <div class="la-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <div class="la-hero-title">HR Communications</div>
                <div class="la-hero-sub">Direct messaging and team announcements · High-Fidelity Design</div>
                <div class="la-hero-chips">
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>{{ $msgList->count() }} Total Messages</span>
                    @if($msgUnread > 0)
                        <span class="la-hero-chip" style="background:rgba(239,68,68,0.2);border-color:rgba(239,68,68,0.3);color:#fff;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                            {{ $msgUnread }} Unread
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="la-hero-right">
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $hrUsers->count() }}</div><div class="la-hero-sl">Staff</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $msgUnread }}</div><div class="la-hero-sl">New</div></div>
        </div>
    </div>

    {{-- Chat shell --}}
    <div class="la-chat-shell">

        {{-- Users drawer --}}
        <div class="la-chat-users-drawer" id="laChatUsersDrawer">
            <div class="la-chat-drawer-hd">
                <span class="la-chat-drawer-title">All Staff</span>
                <button class="la-chat-drawer-close" onclick="laToggleChatDrawer()">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="la-chat-drawer-search">
                <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Search people…" oninput="laChatFilterUsers(this.value)">
            </div>
            <div class="la-chat-users-list" id="laChatUsersList">
                @forelse($hrUsers as $u)
                    @php $uInit = strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)); @endphp
                    <div class="la-chat-user-item"
                         data-name="{{ strtolower(($u->first_name??'').' '.($u->last_name??'')) }}"
                         wire:click="selectConversation('{{ $u->user_id }}')"
                         onclick="laToggleChatDrawer();">
                        <div class="la-chat-user-av">{{ $uInit }}</div>
                        <div>
                            <div class="la-chat-user-name">{{ $u->first_name }} {{ $u->last_name }}</div>
                            <div class="la-chat-user-role">{{ $u->department?->name ?? $u->position?->name ?? 'Employee' }}</div>
                        </div>
                    </div>
                @empty
                    <div style="padding:20px;text-align:center;color:var(--ink4);font-size:12.5px;">No staff found</div>
                @endforelse
            </div>
        </div>

        {{-- Conversations column --}}
        <div class="la-chat-conv-col">
            <div class="la-chat-conv-hd">
                <button class="la-chat-toggle-btn" id="laChatToggleBtn" onclick="laToggleChatDrawer()" title="Browse staff">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span class="la-chat-toggle-dot"></span>
                </button>
                <span class="la-chat-conv-title">Recent Messages</span>
            </div>
            <div class="la-chat-conv-list">
                @if($msgList->count())
                    @php $grouped = $msgList->groupBy(fn($m)=>$m->sender_id===auth()->id()?$m->receiver_id:$m->sender_id); @endphp
                    @foreach($grouped as $pid => $msgs)
                        @php
                            $latest = $msgs->first();
                            $isSent = $latest->sender_id === auth()->id();
                            $person = $isSent ? $latest->receiver : $latest->sender;
                            if(!$person) continue;
                            $unread = $msgs->where('receiver_id',auth()->id())->where('is_read',false)->count();
                            $pInit  = strtoupper(substr($person->first_name??'',0,1).substr($person->last_name??'',0,1));
                            $pName  = trim(($person->first_name??'').' '.($person->last_name??''));
                        @endphp
                        <div class="la-chat-conv-item {{ $selectedConversation == $pid ? 'active' : '' }}" wire:click="selectConversation('{{ $pid }}')">
                            <div class="la-chat-conv-av">{{ $pInit }}</div>
                            <div class="la-chat-conv-info">
                                <div class="la-chat-conv-name">{{ $pName }}</div>
                                <div class="la-chat-conv-preview">{{ \Illuminate\Support\Str::limit($latest->message??'',32) }}</div>
                            </div>
                            <div class="la-chat-conv-meta">
                                <span class="la-chat-conv-time">{{ $latest->created_at->diffForHumans(null, true) }}</span>
                                @if($unread > 0)<span class="la-chat-conv-badge">{{ $unread }}</span>@endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="la-chat-conv-empty">
                        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        No conversations yet.<br>
                        <span>Tap the people icon to start one.</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Chat main --}}
        <div class="la-chat-main">
            @if($selectedConversation)
                @php
                    $peer = \App\Models\User::find($selectedConversation);
                    $pInit = strtoupper(substr($peer->first_name??'',0,1).substr($peer->last_name??'',0,1));
                    $pName = trim(($peer->first_name??'').' '.($peer->last_name??''));
                @endphp
                <div class="la-chat-hd">
                    <div class="la-chat-hd-left">
                        <div class="la-chat-hd-av">{{ $pInit }}</div>
                        <div>
                            <div class="la-chat-hd-name">{{ $pName }}</div>
                            <div class="la-chat-hd-status">Online</div>
                        </div>
                    </div>
                </div>
                <div class="la-chat-msgs" id="laChatMsgs">
                    @if($conversationMessages && $conversationMessages->count())
                        @foreach($conversationMessages as $msg)
                            @php
                                $isSent = $msg->sender_id === auth()->id();
                                $isUnread = $msg->receiver_id === auth()->id() && !$msg->is_read;
                            @endphp
                            <div class="la-chat-msg-row {{ $isSent?'sent':'' }}">
                                <div class="la-chat-msg-wrap">
                                    <div class="la-chat-bubble {{ $isSent?'sent':'recv' }}">{{ $msg->message }}</div>
                                    <div class="la-chat-bubble-meta">
                                        <span class="la-chat-bubble-time">{{ $msg->created_at->diffForHumans() }}</span>
                                        @if($isSent)
                                            <span class="la-chat-badge {{ $msg->is_read ? 'badge-read' : 'badge-new' }}">{{ $msg->is_read ? 'Read' : 'Sent' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="la-chat-empty">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            <p>No messages yet</p>
                            <span>Type a message below to start the conversation</span>
                        </div>
                    @endif
                </div>
            @else
                <div class="la-chat-hd">
                    <div class="la-chat-hd-left">
                        <div class="la-chat-hd-av" style="background:var(--bg);color:var(--ink4);">
                            <svg style="width:17px;height:17px;stroke:var(--ink4);fill:none;stroke-width:1.75;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <div>
                            <div class="la-chat-hd-name" style="color:var(--ink3);">No conversation selected</div>
                            <div class="la-chat-hd-status" style="color:var(--ink4);">Select an employee to start chatting</div>
                        </div>
                    </div>
                </div>
                <div class="la-chat-msgs">
                    <div class="la-chat-empty">
                        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <p>No messages yet</p>
                        <span>Type a message below to start a conversation</span>
                    </div>
                </div>
            @endif

            <div class="la-chat-compose">
                @if(session()->has('success'))
                    <div style="background:var(--green-lt);border:1px solid rgba(18,183,106,0.22);border-radius:9px;padding:8px 13px;font-size:13px;font-weight:600;color:#087A42;margin-bottom:9px;">{{ session('success') }}</div>
                @endif
                <div id="laMsgComposeArea" style="{{ $selectedConversation ? 'display:block;' : 'display:none;' }}">
                    <form wire:submit.prevent="sendMessage">
                        <div class="la-chat-compose-inner">
                            <textarea class="la-chat-compose-ta" wire:model="messageText" id="laMsgText"
                                      placeholder="Type your message…"
                                      rows="1"
                                      onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault(); @this.call('sendMessage');}"
                                      oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,120)+'px'"></textarea>
                            <button type="submit" class="la-chat-send-btn">
                                <svg viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </div>
                        <div class="la-chat-compose-hint">Enter to send · Shift+Enter for new line</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
(function(){
    function laToggleChatDrawer(){
        var d=document.getElementById('laChatUsersDrawer');
        if(d)d.classList.toggle('open');
    }
    window.laToggleChatDrawer=laToggleChatDrawer;

    function laChatFilterUsers(q){
        q=(q||'').toLowerCase().trim();
        document.querySelectorAll('#laChatUsersList .la-chat-user-item').forEach(function(el){
            el.style.display=!q||(el.dataset.name||'').includes(q)?'':'none';
        });
    }
    window.laChatFilterUsers=laChatFilterUsers;

    window.laChatSelectUser=function(uid,name,initials){
        var av=document.getElementById('laChatHdAv');
        if(av){av.style.background='var(--blue-lt)';av.style.color='var(--blue-2)';av.innerHTML='<span style="font-family:Sora,sans-serif;font-size:12px;font-weight:800;">'+initials+'</span>';}
        var nm=document.getElementById('laChatHdName');
        if(nm){nm.style.color='';nm.textContent=name;}
        var st=document.getElementById('laChatHdStatus');
        if(st){st.style.color='';st.textContent='Online';}
        var empty=document.getElementById('laChatEmptyState');
        if(empty)empty.style.display='none';
        var anyVisible=false;
        document.querySelectorAll('.la-chat-msg-row[data-peer]').forEach(function(el){
            var show=el.dataset.peer==uid;
            el.style.display=show?'':'none';
            if(show)anyVisible=true;
        });
        if(!anyVisible&&empty){empty.style.display='flex';var p=empty.querySelector('p');if(p)p.textContent='No messages yet';}
        var r=document.getElementById('laMsgReceiver');
        if(r)r.value=uid;
        var comp=document.getElementById('laMsgComposeArea');
        if(comp)comp.style.display='block';
        @this.call('markAsRead', uid);
        document.querySelectorAll('.la-chat-conv-item').forEach(function(el){el.classList.remove('active');});
        var msgs=document.getElementById('laChatMsgs');
        if(msgs)msgs.scrollTop=msgs.scrollHeight;
    };

    document.addEventListener('click',function(e){
        var d=document.getElementById('laChatUsersDrawer');
        var b=document.getElementById('laChatToggleBtn');
        if(!d||!d.classList.contains('open'))return;
        if(!d.contains(e.target)&&b&&!b.contains(e.target))d.classList.remove('open');
    });

    var msgs=document.getElementById('laChatMsgs');
    if(msgs)msgs.scrollTop=msgs.scrollHeight;
})();
</script>
</div>{{-- /section-communication --}}


{{-- ════════════════════════════════════════════════════════
     SECTION 4 — CALENDAR  (Team | Personal | Weekly)
════════════════════════════════════════════════════════ --}}
<div class="la-section {{ $activeSection==='calendar'?'active':'' }}" id="section-calendar">
@php
    $calYear  = (int)request('cal_year',  now()->year);
    $calMonth = (int)request('cal_month', now()->month);
    $calFirst = \Carbon\Carbon::create($calYear,$calMonth,1);
    $calLast  = $calFirst->copy()->endOfMonth();
    $calPad   = $calFirst->dayOfWeek;
    $calTrail = (7-(($calPad+$calLast->day)%7))%7;

    $calLeaves=collect(); $calHols=collect(); $calPaydays=collect();
    $teamMap=[]; $personalMap=[]; $payrollMap=[];
    $upcomingHols=collect(); $upcomingLeaves=collect(); $upcomingPay=collect();
    $personalLeaves=collect(); $weeklyTasks=[];
    $todayDow=now()->dayOfWeek;

    try {
        $calLeaves = \App\Models\LeaveRequest::with('employee')
            ->where('status','approved')
            ->where(fn($q)=>$q->whereBetween('start_date',[$calFirst,$calLast])->orWhereBetween('end_date',[$calFirst,$calLast]))
            ->get();
        $calHols = \App\Models\Holiday::whereBetween('date',[$calFirst,$calLast])->get();
        try {
            if(class_exists('\App\Models\Payroll'))
                $calPaydays = \App\Models\Payroll::whereBetween('payment_date',[$calFirst,$calLast])->get();
        } catch(\Exception){}

        foreach($calLeaves as $lv){
            $s=max(\Carbon\Carbon::parse($lv->start_date),$calFirst);
            $e=min(\Carbon\Carbon::parse($lv->end_date),$calLast);
            for($d=$s->copy();$d->lte($e);$d->addDay()){
                $k=$d->day;
                $teamMap[$k][]=['type'=>'lv','label'=>($lv->employee?$lv->employee->first_name.' L':'Leave')];
            }
        }
        foreach($calHols as $h){
            $k=\Carbon\Carbon::parse($h->date)->day;
            $teamMap[$k][]=['type'=>'hol','label'=>$h->name];
            $personalMap[$k][]=['type'=>'hol','label'=>$h->name];
            $payrollMap[$k][]=['type'=>'hol','label'=>$h->name];
        }
        foreach($calPaydays as $pay){
            $k=\Carbon\Carbon::parse($pay->payment_date)->day;
            $payrollMap[$k][]=['type'=>'pay','label'=>'Payday'];
        }
        try {
            $hrEmp=\App\Models\Employee::where('user_id',auth()->id())->first();
            if($hrEmp){
                $personalLeaves=\App\Models\LeaveRequest::where('employee_id',$hrEmp->id)
                    ->where(fn($q)=>$q->whereBetween('start_date',[$calFirst,$calLast])->orWhereBetween('end_date',[$calFirst,$calLast]))->get();
            }
        } catch(\Exception){}
        foreach($personalLeaves as $pl){
            $s=max(\Carbon\Carbon::parse($pl->start_date),$calFirst);
            $e=min(\Carbon\Carbon::parse($pl->end_date),$calLast);
            for($d=$s->copy();$d->lte($e);$d->addDay()){
                $k=$d->day;
                $ls=$pl->status instanceof \BackedEnum?$pl->status->value:$pl->status;
                $personalMap[$k][]=['type'=>'lv','label'=>($pl->leaveType?$pl->leaveType->name:'Leave').' ('.$ls.')'];
            }
        }
        $upcomingHols   = $calHols->filter(fn($h)=>\Carbon\Carbon::parse($h->date)->gte(today()))->take(5);
        $upcomingLeaves = $calLeaves->filter(fn($l)=>\Carbon\Carbon::parse($l->start_date)->gte(today()))->take(5);
        $upcomingPay    = $calPaydays->filter(fn($p)=>\Carbon\Carbon::parse($p->payment_date)->gte(today()))->take(4);
    } catch(\Exception){}

    // Helper to render month grid
    function hrRenderCalGrid($map,$pad,$last,$yr,$mo,$trail){
        $out='<div class="la-hrcal-dow-row">';
        foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $i=>$d)
            $out.='<div class="la-hrcal-dow '.($i===0||$i===6?'wknd':'').'">'.$d.'</div>';
        $out.='</div><div class="la-hrcal-days">';
        for($i=0;$i<$pad;$i++) $out.='<div class="la-hrcal-cell other"></div>';
        for($day=1;$day<=$last->day;$day++){
            $dow=\Carbon\Carbon::create($yr,$mo,$day)->dayOfWeek;
            $isToday=($day===now()->day&&$mo===now()->month&&$yr===now()->year);
            $isWknd=($dow===0||$dow===6);
            $evs=$map[$day]??[];
            $cls='la-hrcal-cell';
            if($isToday) $cls.=' today'; elseif($isWknd) $cls.=' wknd';
            $hasLv=collect($evs)->where('type','lv')->count()>0;
            $hasHol=collect($evs)->where('type','hol')->count()>0;
            $hasPay=collect($evs)->where('type','pay')->count()>0;
            if($hasLv)  $cls.=' has-leave';
            if($hasHol) $cls.=' has-hol';
            if($hasPay) $cls.=' has-pay';
            $out.='<div class="'.$cls.'">';
            $out.='<div class="la-hrcal-num">'.$day.'</div>';
            $out.='<div class="la-hrcal-chips">';
            foreach(array_slice($evs,0,3) as $ev){
                $cc=match($ev['type']){'lv'=>'lv','hol'=>'hol','pay'=>'pay',default=>'att'};
                $out.='<span class="la-hrcal-chip '.$cc.'">'.htmlspecialchars($ev['label']).'</span>';
            }
            if(count($evs)>3) $out.='<span class="la-hrcal-chip more">+'.(count($evs)-3).'</span>';
            $out.='</div></div>';
        }
        for($i=0;$i<$trail;$i++) $out.='<div class="la-hrcal-cell other"></div>';
        $out.='</div>';
        return $out;
    }
@endphp
<div class="la-wrap" style="gap:16px;">

    {{-- Hero --}}
    <div class="la-hero">
        <div class="la-hero-left">
            <div class="la-hero-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
            <div>
                <div class="la-hero-title">HR Calendar — {{ $calFirst->format('F Y') }}</div>
                <div class="la-hero-sub">Team leaves, holidays, payroll events &amp; personal schedule</div>
                <div class="la-hero-chips">
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/></svg>{{ $calLeaves->count() }} team leaves</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>{{ $calHols->count() }} holidays</span>
                    @if($calPaydays->count())<span class="la-hero-chip"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>{{ $calPaydays->count() }} paydays</span>@endif
                </div>
            </div>
        </div>
        <div class="la-hero-right">
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $calLeaves->count() }}</div><div class="la-hero-sl">On Leave</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $calHols->count() }}</div><div class="la-hero-sl">Holidays</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $calPaydays->count() }}</div><div class="la-hero-sl">Paydays</div></div>
        </div>
    </div>

    {{-- View tabs --}}
    <div class="la-hrcal-tabs">
        <button onclick="laHrCalTab('team',this)" class="la-hrcal-tab active" id="laHrCalTabTeam">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Team Calendar
        </button>
        <button onclick="laHrCalTab('personal',this)" class="la-hrcal-tab" id="laHrCalTabPersonal">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            My Calendar
        </button>
        <button onclick="laHrCalTab('payroll',this)" class="la-hrcal-tab" id="laHrCalTabPayroll">
            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            Payroll Calendar
        </button>
        <button onclick="laHrCalTab('weekly',this)" class="la-hrcal-tab" id="laHrCalTabWeekly">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Weekly Schedule
        </button>
    </div>

    {{-- ── TEAM CALENDAR ── --}}
    <div class="la-hrcal-view active" id="laHrCalViewTeam">
        <div class="la-hrcal-2col">
            <div class="la-card">
                <div class="la-card-hd" style="justify-content:space-between;">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div><div class="la-card-ttl">{{ $calFirst->format('F Y') }} — Team</div></div>
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="?cal_year={{ $calFirst->copy()->subMonth()->year }}&cal_month={{ $calFirst->copy()->subMonth()->month }}#section-calendar" class="la-hrcal-nav-btn"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                        <span style="font-size:12px;font-weight:700;color:var(--ink3);min-width:64px;text-align:center;">{{ $calFirst->format('M Y') }}</span>
                        <a href="?cal_year={{ $calFirst->copy()->addMonth()->year }}&cal_month={{ $calFirst->copy()->addMonth()->month }}#section-calendar" class="la-hrcal-nav-btn"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                    </div>
                </div>
                <div style="padding:16px 18px 18px;">
                    {!! hrRenderCalGrid($teamMap,$calPad,$calLast,$calYear,$calMonth,$calTrail) !!}
                </div>
                <div class="la-hrcal-legend">
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--blue)"></div>Today</div>
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--green)"></div>Leave</div>
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--amber)"></div>Holiday</div>
                </div>
            </div>
            <div class="la-hrcal-sidebar">
                <div class="la-card">
                    <div class="la-card-hd"><div class="la-card-hdl"><div class="la-card-ico" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><div><div class="la-card-ttl">Team on Leave</div><div class="la-card-sub">{{ $upcomingLeaves->count() }} upcoming</div></div></div></div>
                    <div style="padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px;max-height:260px;overflow-y:auto;">
                        @forelse($upcomingLeaves as $ul)
                            @php $ulEmp=$ul->employee; @endphp
                            <div class="la-event-item">
                                <div class="la-event-dot" style="background:var(--green);"></div>
                                <div><div class="la-event-ttl">{{ $ulEmp?trim($ulEmp->first_name.' '.$ulEmp->last_name):'—' }}</div><div class="la-event-sub">{{ \Carbon\Carbon::parse($ul->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($ul->end_date)->format('M d, Y') }}</div></div>
                                @php $uls=$ul->status instanceof \BackedEnum?$ul->status->value:($ul->status??''); @endphp
                                <span class="la-badge {{ match($uls){'approved'=>'lb-green','pending'=>'lb-amber',default=>'lb-red'} }}" style="align-self:flex-start;flex-shrink:0;">{{ ucfirst($uls) }}</span>
                            </div>
                        @empty
                            <div class="la-empty" style="padding:20px;"><div class="la-empty-ttl">No upcoming leaves</div></div>
                        @endforelse
                    </div>
                </div>
                <div class="la-card">
                    <div class="la-card-hd"><div class="la-card-hdl"><div class="la-card-ico" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/></svg></div><div><div class="la-card-ttl">Holidays</div></div></div></div>
                    <div style="padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px;max-height:200px;overflow-y:auto;">
                        @forelse($upcomingHols as $h)
                            <div class="la-event-item">
                                <div class="la-event-dot" style="background:var(--amber);"></div>
                                <div><div class="la-event-ttl">{{ $h->name }}</div><div class="la-event-sub">{{ \Carbon\Carbon::parse($h->date)->format('l, M d, Y') }}</div></div>
                            </div>
                        @empty
                            <div class="la-empty" style="padding:16px;"><div class="la-empty-ttl">No upcoming holidays</div></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── PERSONAL CALENDAR ── --}}
    <div class="la-hrcal-view" id="laHrCalViewPersonal">
        <div class="la-hrcal-2col">
            <div class="la-card">
                <div class="la-card-hd" style="justify-content:space-between;">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--purple-lt);"><svg style="stroke:var(--purple)" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                        <div><div class="la-card-ttl">{{ $calFirst->format('F Y') }} — My Calendar</div></div>
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="?cal_year={{ $calFirst->copy()->subMonth()->year }}&cal_month={{ $calFirst->copy()->subMonth()->month }}#section-calendar" class="la-hrcal-nav-btn"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                        <span style="font-size:12px;font-weight:700;color:var(--ink3);min-width:64px;text-align:center;">{{ $calFirst->format('M Y') }}</span>
                        <a href="?cal_year={{ $calFirst->copy()->addMonth()->year }}&cal_month={{ $calFirst->copy()->addMonth()->month }}#section-calendar" class="la-hrcal-nav-btn"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                    </div>
                </div>
                <div style="padding:16px 18px 18px;">
                    {!! hrRenderCalGrid($personalMap,$calPad,$calLast,$calYear,$calMonth,$calTrail) !!}
                </div>
                <div class="la-hrcal-legend">
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--blue)"></div>Today</div>
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--green)"></div>My Leave</div>
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--amber)"></div>Holiday</div>
                </div>
            </div>
            <div class="la-hrcal-sidebar">
                <div class="la-card">
                    <div class="la-card-hd"><div class="la-card-hdl"><div class="la-card-ico" style="background:var(--purple-lt);"><svg style="stroke:var(--purple)" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div><div><div class="la-card-ttl">My Leaves</div><div class="la-card-sub">{{ $personalLeaves->count() }} this period</div></div></div></div>
                    <div style="padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px;max-height:280px;overflow-y:auto;">
                        @forelse($personalLeaves as $pl)
                            @php $pls=$pl->status instanceof \BackedEnum?$pl->status->value:($pl->status??''); $plDays=\Carbon\Carbon::parse($pl->start_date)->diffInDays(\Carbon\Carbon::parse($pl->end_date))+1; @endphp
                            <div class="la-event-item">
                                <div class="la-event-dot" style="background:var(--purple);"></div>
                                <div style="flex:1;"><div class="la-event-ttl">{{ $pl->leaveType?->name??'Leave' }}</div><div class="la-event-sub">{{ \Carbon\Carbon::parse($pl->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($pl->end_date)->format('M d, Y') }} · {{ $plDays }}d</div></div>
                                <span class="la-badge {{ match($pls){'approved'=>'lb-green','pending'=>'lb-amber',default=>'lb-red'} }}" style="align-self:flex-start;flex-shrink:0;">{{ ucfirst($pls) }}</span>
                            </div>
                        @empty
                            <div class="la-empty" style="padding:20px;"><div class="la-empty-ttl">No leaves this month</div></div>
                        @endforelse
                    </div>
                </div>
                <div class="la-card">
                    <div class="la-card-hd"><div class="la-card-hdl"><div class="la-card-ico" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/></svg></div><div><div class="la-card-ttl">Holidays</div></div></div></div>
                    <div style="padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px;max-height:200px;overflow-y:auto;">
                        @forelse($upcomingHols as $h)
                            <div class="la-event-item">
                                <div class="la-event-dot" style="background:var(--amber);"></div>
                                <div><div class="la-event-ttl">{{ $h->name }}</div><div class="la-event-sub">{{ \Carbon\Carbon::parse($h->date)->format('l, M d, Y') }}</div></div>
                            </div>
                        @empty
                            <div class="la-empty" style="padding:16px;"><div class="la-empty-ttl">No upcoming holidays</div></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── PAYROLL CALENDAR ── --}}
    <div class="la-hrcal-view" id="laHrCalViewPayroll">
        <div class="la-hrcal-2col">
            <div class="la-card">
                <div class="la-card-hd" style="justify-content:space-between;">
                    <div class="la-card-hdl">
                        <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div>
                        <div><div class="la-card-ttl">{{ $calFirst->format('F Y') }} — Payroll</div></div>
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="?cal_year={{ $calFirst->copy()->subMonth()->year }}&cal_month={{ $calFirst->copy()->subMonth()->month }}#section-calendar" class="la-hrcal-nav-btn"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                        <span style="font-size:12px;font-weight:700;color:var(--ink3);min-width:64px;text-align:center;">{{ $calFirst->format('M Y') }}</span>
                        <a href="?cal_year={{ $calFirst->copy()->addMonth()->year }}&cal_month={{ $calFirst->copy()->addMonth()->month }}#section-calendar" class="la-hrcal-nav-btn"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                    </div>
                </div>
                <div style="padding:16px 18px 18px;">
                    {!! hrRenderCalGrid($payrollMap,$calPad,$calLast,$calYear,$calMonth,$calTrail) !!}
                </div>
                <div class="la-hrcal-legend">
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--blue)"></div>Today</div>
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--blue-2)"></div>Payday</div>
                    <div class="la-hrcal-legend-item"><div class="la-hrcal-legend-dot" style="background:var(--amber)"></div>Holiday</div>
                </div>
            </div>
            <div class="la-hrcal-sidebar">
                <div class="la-card">
                    <div class="la-card-hd"><div class="la-card-hdl"><div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div><div><div class="la-card-ttl">Upcoming Paydays</div></div></div></div>
                    <div style="padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px;max-height:260px;overflow-y:auto;">
                        @forelse($upcomingPay as $pay)
                            <div class="la-event-item">
                                <div class="la-event-dot" style="background:var(--blue);"></div>
                                <div style="flex:1;"><div class="la-event-ttl">Payday</div><div class="la-event-sub">{{ \Carbon\Carbon::parse($pay->payment_date)->format('l, M d, Y') }}</div>@if($pay->total_amount??false)<div class="la-event-sub" style="color:var(--green);font-weight:700;">RWF {{ number_format($pay->total_amount,0) }}</div>@endif</div>
                                <span class="la-badge lb-blue" style="align-self:flex-start;flex-shrink:0;">Pay</span>
                            </div>
                        @empty
                            <div class="la-empty" style="padding:20px;"><div class="la-empty-ttl">No paydays this month</div></div>
                        @endforelse
                    </div>
                </div>
                <div class="la-card">
                    <div class="la-card-hd"><div class="la-card-hdl"><div class="la-card-ico" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/></svg></div><div><div class="la-card-ttl">Holidays</div></div></div></div>
                    <div style="padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px;max-height:200px;overflow-y:auto;">
                        @forelse($upcomingHols as $h)
                            <div class="la-event-item"><div class="la-event-dot" style="background:var(--amber);"></div><div><div class="la-event-ttl">{{ $h->name }}</div><div class="la-event-sub">{{ \Carbon\Carbon::parse($h->date)->format('l, M d, Y') }}</div></div></div>
                        @empty
                            <div class="la-empty" style="padding:16px;"><div class="la-empty-ttl">No upcoming holidays</div></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── WEEKLY SCHEDULE ── --}}
    <div class="la-hrcal-view" id="laHrCalViewWeekly">
        <div class="la-card">
            <div class="la-card-hd">
                <div class="la-card-hdl">
                    <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div><div class="la-card-ttl">Weekly Schedule — Week of {{ now()->startOfWeek()->format('M d, Y') }}</div><div class="la-card-sub">Click a slot to add a task · Click × to remove</div></div>
                </div>
                <button class="la-btn la-btn-primary" onclick="laHrWeeklyAddTask()">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Task
                </button>
            </div>
            <div style="padding:16px;">
                <div style="overflow-x:auto;">
                    <div class="la-hrcal-timeline" id="laHrTimeline">
                        <div class="la-hrcal-tl-corner"></div>
                        @foreach(['Mon','Tue','Wed','Thu','Fri'] as $di => $dn)
                            <div class="la-hrcal-tl-dayhd {{ $todayDow===$di+1?'today-col':'' }}">
                                {{ $dn }}@if($todayDow===$di+1)<span style="font-size:9px;background:var(--blue);color:#fff;padding:1px 5px;border-radius:4px;margin-left:4px;">Today</span>@endif
                            </div>
                        @endforeach
                        @foreach(range(8,18) as $hr)
                            <div class="la-hrcal-tl-time">{{ str_pad($hr,2,'0',STR_PAD_LEFT) }}:00</div>
                            @foreach(range(1,5) as $di)
                                <div class="la-hrcal-tl-cell" onclick="laHrWeeklyAddTaskSlot({{ $hr }},{{ $di }})" id="laHrCell_{{ $hr }}_{{ $di }}"></div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Weekly task modal --}}
<div id="laHrTaskModal" style="display:none;position:fixed;inset:0;background:rgba(15,22,41,0.50);backdrop-filter:blur(8px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
    <div class="la-modal">
        <div class="la-modal-hd">
            <div class="la-modal-title"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Add Weekly Task</div>
            <button class="la-modal-close" onclick="document.getElementById('laHrTaskModal').style.display='none'"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="la-modal-body">
            <div class="la-field"><label>Task Title <span class="req">*</span></label><input type="text" id="laHrTaskTitle" placeholder="e.g. Team standup"></div>
            <div class="la-grid2">
                <div class="la-field"><label>Day <span class="req">*</span></label><select id="laHrTaskDay"><option value="1">Monday</option><option value="2">Tuesday</option><option value="3">Wednesday</option><option value="4">Thursday</option><option value="5">Friday</option></select></div>
                <div class="la-field"><label>Time <span class="req">*</span></label><select id="laHrTaskHour">@foreach(range(8,18) as $h)<option value="{{ $h }}">{{ str_pad($h,2,'0',STR_PAD_LEFT) }}:00</option>@endforeach</select></div>
            </div>
        </div>
        <div class="la-modal-footer">
            <button class="la-btn la-btn-outline" onclick="document.getElementById('laHrTaskModal').style.display='none'">Cancel</button>
            <button class="la-btn la-btn-primary" onclick="laHrSaveTask()">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                Add Task
            </button>
        </div>
    </div>
</div>

<script>
(function(){
    // ── Calendar tabs ──
    var hrCalTabs=['team','personal','payroll','weekly'];
    window.laHrCalTab=function(name,btn){
        hrCalTabs.forEach(function(t){
            var v=document.getElementById('laHrCalView'+t.charAt(0).toUpperCase()+t.slice(1));
            var b=document.getElementById('laHrCalTab'+t.charAt(0).toUpperCase()+t.slice(1));
            if(v){v.classList.toggle('active',t===name);}
            if(b){b.classList.toggle('active',t===name);}
        });
    };

    // ── Weekly tasks (localStorage) ──
    var hrTasks={};
    try{hrTasks=JSON.parse(localStorage.getItem('hr_cal_tasks')||'{}');}catch(e){}
    function saveHrTasks(){try{localStorage.setItem('hr_cal_tasks',JSON.stringify(hrTasks));}catch(e){}}
    function renderHrCell(hr,di){
        var cell=document.getElementById('laHrCell_'+hr+'_'+di);
        if(!cell)return;
        cell.innerHTML='';
        var slot=(hrTasks[hr]||{})[di]||[];
        slot.forEach(function(t,ti){
            var d=document.createElement('div');
            d.className='la-hrcal-tl-task';
            d.innerHTML='<span style="overflow:hidden;text-overflow:ellipsis;flex:1;">'+t+'</span><button style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.7);font-size:13px;flex-shrink:0;" onclick="event.stopPropagation();laHrDeleteTask('+hr+','+di+','+ti+')">×</button>';
            cell.appendChild(d);
        });
    }
    Object.keys(hrTasks).forEach(function(hr){Object.keys(hrTasks[hr]).forEach(function(di){renderHrCell(hr,di);});});

    window.laHrWeeklyAddTask=function(){
        document.getElementById('laHrTaskModal').style.display='flex';
        setTimeout(function(){var i=document.getElementById('laHrTaskTitle');if(i)i.focus();},100);
    };
    window.laHrWeeklyAddTaskSlot=function(hr,di){
        document.getElementById('laHrTaskHour').value=hr;
        document.getElementById('laHrTaskDay').value=di;
        document.getElementById('laHrTaskModal').style.display='flex';
        setTimeout(function(){var i=document.getElementById('laHrTaskTitle');if(i)i.focus();},100);
    };
    window.laHrSaveTask=function(){
        var t=document.getElementById('laHrTaskTitle').value.trim();
        var hr=parseInt(document.getElementById('laHrTaskHour').value);
        var di=parseInt(document.getElementById('laHrTaskDay').value);
        if(!t)return;
        if(!hrTasks[hr])hrTasks[hr]={};
        if(!hrTasks[hr][di])hrTasks[hr][di]=[];
        hrTasks[hr][di].push(t);
        saveHrTasks();renderHrCell(hr,di);
        document.getElementById('laHrTaskTitle').value='';
        document.getElementById('laHrTaskModal').style.display='none';
    };
    window.laHrDeleteTask=function(hr,di,ti){
        if(hrTasks[hr]&&hrTasks[hr][di]){hrTasks[hr][di].splice(ti,1);saveHrTasks();renderHrCell(hr,di);}
    };
    var titleInput=document.getElementById('laHrTaskTitle');
    if(titleInput)titleInput.addEventListener('keydown',function(e){if(e.key==='Enter'){e.preventDefault();laHrSaveTask();}});
})();
</script>
</div>{{-- /section-calendar --}}


{{-- ════════════════════════════════════════════════════════
     SECTION 5 — ATTENDANCE  (with month filter)
════════════════════════════════════════════════════════ --}}
<div class="la-section {{ $activeSection==='attendance'?'active':'' }}" id="section-attendance">
@php
    $attYear  = (int)request('att_year',  now()->year);
    $attMonth = (int)request('att_month', now()->month);
    $attFirst = \Carbon\Carbon::create($attYear, $attMonth, 1);
    $attLast  = $attFirst->copy()->endOfMonth();

    $attRecords=collect(); $totalPresent=0; $totalAbsent=0; $totalLate=0; $totalOnLeave=0;
    $monthPresent=0; $monthAbsent=0; $monthLate=0; $monthTotal=0; $attRate=0; $allEmployees=collect();

    try {
        $attQuery = \App\Models\Attendance::with('employee')->whereBetween('date',[$attFirst,$attLast]);
        $attRecords   = $attQuery->orderBy('date','desc')->orderBy('check_in','asc')->paginate(30,['*'],'attPage');
        $totalPresent = \App\Models\Attendance::whereDate('date',today())->whereNotNull('check_in')->count();
        $totalAbsent  = \App\Models\Attendance::whereDate('date',today())->where('status','absent')->count();
        $totalLate    = \App\Models\Attendance::whereDate('date',today())->where('status','late')->count();
        $totalOnLeave = \App\Models\Attendance::whereDate('date',today())->where('status','leave')->count();
        $monthPresent = \App\Models\Attendance::whereBetween('date',[$attFirst,$attLast])->whereNotNull('check_in')->count();
        $monthAbsent  = \App\Models\Attendance::whereBetween('date',[$attFirst,$attLast])->where('status','absent')->count();
        $monthLate    = \App\Models\Attendance::whereBetween('date',[$attFirst,$attLast])->where('status','late')->count();
        $monthTotal   = \App\Models\Attendance::whereBetween('date',[$attFirst,$attLast])->count();
        $attRate      = $monthTotal>0?round(($monthPresent/$monthTotal)*100):0;
        $allEmployees = \App\Models\Employee::orderBy('first_name')->get(['id','first_name','last_name']);
    } catch(\Exception $e){}
@endphp
<div class="la-wrap">

    <div class="la-hero">
        <div class="la-hero-left">
            <div class="la-hero-icon"><svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
            <div>
                <div class="la-hero-title">Attendance — {{ $attFirst->format('F Y') }}</div>
                <div class="la-hero-sub">{{ today()->format('l, F j, Y') }} &mdash; Filter by month, employee or status</div>
                <div class="la-hero-chips">
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/></svg>{{ $totalPresent }} Present today</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/></svg>{{ $totalAbsent }} Absent</span>
                    <span class="la-hero-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $totalLate }} Late</span>
                </div>
            </div>
        </div>
        <div class="la-hero-right">
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $totalPresent }}</div><div class="la-hero-sl">Present</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $totalAbsent }}</div><div class="la-hero-sl">Absent</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $totalLate }}</div><div class="la-hero-sl">Late</div></div>
            <div class="la-hero-stat"><div class="la-hero-sv">{{ $totalOnLeave }}</div><div class="la-hero-sl">On Leave</div></div>
        </div>
    </div>

    <div class="la-tiles">
        <div class="la-tile la-t-green"><div class="la-tile-bar"></div><div class="la-tile-icon"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><div><div class="la-tile-lbl">Present ({{ $attFirst->format('M') }})</div><div class="la-tile-val">{{ $monthPresent }}</div><div class="la-tile-sub">attendance records</div></div></div>
        <div class="la-tile la-t-red"><div class="la-tile-bar"></div><div class="la-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div><div><div class="la-tile-lbl">Absent ({{ $attFirst->format('M') }})</div><div class="la-tile-val">{{ $monthAbsent }}</div><div class="la-tile-sub">absent days</div></div></div>
        <div class="la-tile la-t-amber"><div class="la-tile-bar"></div><div class="la-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div><div class="la-tile-lbl">Late ({{ $attFirst->format('M') }})</div><div class="la-tile-val">{{ $monthLate }}</div><div class="la-tile-sub">late arrivals</div></div></div>
        <div class="la-tile la-t-blue"><div class="la-tile-bar"></div><div class="la-tile-icon"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><div><div class="la-tile-lbl">Rate ({{ $attFirst->format('M') }})</div><div class="la-tile-val">{{ $attRate }}%</div><div class="la-tile-sub" style="margin-top:5px;"><div style="height:4px;border-radius:100px;background:var(--bg);overflow:hidden;"><div style="height:100%;border-radius:100px;background:{{ $attRate>=90?'var(--green)':($attRate>=70?'var(--amber)':'var(--red)') }};width:{{ $attRate }}%;transition:width .5s;"></div></div></div></div></div>
    </div>

    {{-- Month filter toolbar --}}
    <div class="la-att-toolbar">
        <div class="la-att-month-nav">
            <button class="la-att-month-btn" onclick="laAttNav(-1)"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></button>
            <div class="la-att-month-label" id="laAttMonthLabel">{{ $attFirst->format('F Y') }}</div>
            <button class="la-att-month-btn" onclick="laAttNav(1)"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
        <div style="width:1px;height:28px;background:var(--border);flex-shrink:0;"></div>
        <div class="la-search-box" style="max-width:220px;">
            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" id="laAttSearch" placeholder="Search employee…" oninput="laAttFilter()">
        </div>
        <select class="la-sel" id="laAttStatusSel" onchange="laAttFilter()">
            <option value="">All Statuses</option>
            <option value="present">Present</option>
            <option value="absent">Absent</option>
            <option value="late">Late</option>
            <option value="leave">On Leave</option>
            <option value="half_day">Half Day</option>
        </select>
        <select class="la-sel" id="laAttEmpSel" onchange="laAttFilter()">
            <option value="">All Employees</option>
            @foreach($allEmployees as $emp)
                <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
            @endforeach
        </select>
        <span style="font-size:12px;color:var(--ink4);font-weight:600;margin-left:auto;">
            {{ $attRecords instanceof \Illuminate\Pagination\LengthAwarePaginator ? $attRecords->total() : (is_object($attRecords)?$attRecords->count():0) }} records
        </span>
    </div>

    <div class="la-card">
        <div class="la-card-hd">
            <div class="la-card-hdl">
                <div class="la-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg></div>
                <div><div class="la-card-ttl">Attendance Log — {{ $attFirst->format('F Y') }}</div><div class="la-card-sub">{{ $attFirst->format('M d') }} – {{ $attLast->format('M d, Y') }}</div></div>
            </div>
        </div>
        <div class="la-table-wrap">
            <table class="la-table">
                <thead><tr><th>Employee</th><th>Department</th><th>Date</th><th>Check In</th><th>Check Out</th><th>Hours</th><th>Status</th><th>Note</th></tr></thead>
                <tbody id="laAttTbody">
                    @forelse($attRecords as $att)
                        @php
                            $attE    = $att->employee;
                            $attInit = $attE?strtoupper(substr($attE->first_name??'',0,1).substr($attE->last_name??'',0,1)):'??';
                            $attStat = $att->status instanceof \BackedEnum?$att->status->value:($att->status??'present');
                            $attCls  = match($attStat){'present'=>'la-att-present','absent'=>'la-att-absent','late'=>'la-att-late','leave'=>'la-att-leave','half_day'=>'la-att-half',default=>'la-att-present'};
                            $ci = $att->check_in  ? \Carbon\Carbon::parse($att->check_in)  : null;
                            $co = $att->check_out ? \Carbon\Carbon::parse($att->check_out) : null;
                            $hrs = ($ci&&$co&&$co->gt($ci))?round($ci->diffInMinutes($co)/60,1).'h':'—';
                        @endphp
                        <tr data-emp="{{ strtolower(($attE?->first_name??'').' '.($attE?->last_name??'')) }}"
                            data-status="{{ $attStat }}"
                            data-empid="{{ $attE?->id }}">
                            <td><div class="la-emp-cell"><div class="la-emp-av">{{ $attInit }}</div><div><div class="la-emp-name">{{ $attE?trim($attE->first_name.' '.$attE->last_name):'—' }}</div><div class="la-emp-role">{{ $attE?->department?->name??'' }}</div></div></div></td>
                            <td style="font-size:12.5px;color:var(--ink3);">{{ $attE?->department?->name??'—' }}</td>
                            <td style="font-weight:700;color:var(--ink2);">
                                {{ \Carbon\Carbon::parse($att->date)->format('D, M d') }}
                                @if(\Carbon\Carbon::parse($att->date)->isToday())<span class="la-badge lb-blue" style="margin-left:5px;font-size:9.5px;">Today</span>@endif
                            </td>
                            <td style="font-weight:700;color:var(--blue-2);">{{ $ci?$ci->format('H:i'):'—' }}</td>
                            <td style="color:var(--ink3);">{{ $co?$co->format('H:i'):'—' }}</td>
                            <td style="font-family:'Sora',sans-serif;font-size:12.5px;font-weight:800;color:var(--ink2);">{{ $hrs }}</td>
                            <td><span class="la-att-status {{ $attCls }}">{{ ucfirst(str_replace('_',' ',$attStat)) }}</span></td>
                            <td style="font-size:12px;color:var(--ink4);">{{ \Illuminate\Support\Str::limit($att->note??$att->notes??'',40) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8"><div class="la-empty"><svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg><div class="la-empty-ttl">No records for {{ $attFirst->format('F Y') }}</div><div class="la-empty-sub">Try a different month or adjust filters</div></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($attRecords,'hasPages') && $attRecords->hasPages())
            <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                <span style="font-size:12.5px;color:var(--ink4);">Showing {{ $attRecords->firstItem() }}–{{ $attRecords->lastItem() }} of {{ $attRecords->total() }}</span>
                {{ $attRecords->links() }}
            </div>
        @endif
    </div>

</div>

<script>
(function(){
    var attYear={{ $attYear }}, attMonth={{ $attMonth }};
    var monthNames=['January','February','March','April','May','June','July','August','September','October','November','December'];
    window.laAttNav=function(dir){
        attMonth+=dir;
        if(attMonth>12){attMonth=1;attYear++;}
        if(attMonth<1){attMonth=12;attYear--;}
        document.getElementById('laAttMonthLabel').textContent=monthNames[attMonth-1]+' '+attYear;
        var url=new URL(window.location.href);
        url.searchParams.set('att_year',attYear);
        url.searchParams.set('att_month',attMonth);
        url.hash='section-attendance'; window.location.href=url.toString();
    };
    window.laAttFilter=function(){
        var q=(document.getElementById('laAttSearch').value||'').toLowerCase().trim();
        var stat=(document.getElementById('laAttStatusSel').value||'').toLowerCase();
        var empId=(document.getElementById('laAttEmpSel').value||'');
        document.querySelectorAll('#laAttTbody tr[data-emp]').forEach(function(tr){
            var em=!q||(tr.dataset.emp||'').includes(q);
            var st=!stat||tr.dataset.status===stat;
            var eid=!empId||tr.dataset.empid===empId;
            tr.style.display=(em&&st&&eid)?'':'none';
        });
    };
})();
</script>
</div>{{-- /section-attendance --}}

</main>{{-- /la-local-main --}}

<script>
function laSwitch(name, btnEl) {
    if (!name) return;
    document.querySelectorAll('.la-section').forEach(function(s){ s.classList.remove('active'); });
    var sec = document.getElementById('section-' + name);
    if (sec) sec.classList.add('active');
    document.querySelectorAll('.la-nav-item').forEach(function(b){ b.classList.remove('active'); });
    var navBtn = document.querySelector('.la-nav-item[data-section="' + name + '"]');
    if (navBtn) navBtn.classList.add('active');
    var content = document.querySelector('.la-local-main');
    if (content) content.scrollTop = 0;
    if (history.replaceState) {
        var url = new URL(window.location.href);
        url.hash = 'section-' + name;
        history.replaceState(null, '', url.toString());
    }
    // Sync Livewire state so re-renders remember the section
    if (window.Livewire) {
        var comp = Livewire.find(document.querySelector('[wire\\:id]') && document.querySelector('[wire\\:id]').getAttribute('wire:id'));
        if (comp) comp.set('activeSection', name);
    }
}

// After every Livewire re-render, restore the active section
document.addEventListener('livewire:init', function () {
    Livewire.on('sectionChanged', function (params) {
        var section = params.section || params[0] || 'overview';
        setTimeout(function(){ laSwitch(section, null); }, 10);
    });
    Livewire.on('chatUpdated', function () {
        setTimeout(function(){
            var msgs = document.getElementById('laChatMsgs');
            if (msgs) msgs.scrollTop = msgs.scrollHeight;
        }, 50);
    });
});

// On page load: restore section from URL hash
(function(){
    var hash = window.location.hash;
    if (hash && hash.startsWith('#section-')) {
        var name = hash.replace('#section-', '');
        setTimeout(function(){ laSwitch(name, null); }, 0);
    }
})();
</script>

</div>{{-- /la-local-shell --}}