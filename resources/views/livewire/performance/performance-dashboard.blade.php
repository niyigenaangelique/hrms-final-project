<div class="performance-dashboard">
<style>
/* ── Fonts loaded via layout <head> ── */

/* ══ TOKENS ══════════════════════════════════════════ */
.performance-dashboard {
    --blue:      #3B6FE8; --blue-2:   #2755CC; --blue-3:   #1A3FA8;
    --blue-lt:   rgba(59,111,232,0.09); --blue-mid: rgba(59,111,232,0.18);
    --blue-brd:  rgba(59,111,232,0.22);
    --indigo:    #6B4FDB; --indigo-lt: rgba(107,79,219,0.09);
    --indigo-brd:rgba(107,79,219,0.20);
    --green:     #12B76A; --green-lt:  rgba(18,183,106,0.10);
    --amber:     #F59E0B; --amber-lt:  rgba(245,158,11,0.10);
    --red:       #EF4444; --red-lt:    rgba(239,68,68,0.09);
    --purple:    #7C3AED; --purple-lt: rgba(124,58,237,0.09);
    --teal:      #0891B2; --teal-lt:   rgba(8,145,178,0.09);
    --bg:        #F0F4FA; --white:     #FFFFFF;
    --ink:       #0F1629; --ink2:      #2D3356; --ink3:    #6B7094; --ink4: #A8ADCA;
    --border:    rgba(15,22,41,0.08);
    --sh-sm:     0 2px 10px rgba(59,111,232,0.07);
    --sh-md:     0 8px 28px rgba(59,111,232,0.12);
    --sh-lg:     0 18px 52px rgba(59,111,232,0.16);
    --r: 12px; --r-lg: 18px;
    font-family: 'DM Sans', -apple-system, sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    display: flex;
    flex-direction: column;
    flex: 1;
}

.hp-nav-badge { margin-left: auto; background: var(--amber-lt); color: #92400E; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 100px; border: 1px solid rgba(245,158,11,0.22); }
.hp-nav-badge.green { background: var(--green-lt); color: #087A42; border-color: rgba(18,183,106,0.22); }
.hp-nav-bottom { margin-top: auto; padding: 12px 8px; border-top: 1px solid var(--border); }

/* ══ CONTENT ═════════════════════════════════════════════ */
.hp-content { flex: 1; min-width: 0; overflow-y: auto; }
.hp-wrap { padding: 26px 28px 48px; max-width: 1400px; display: flex; flex-direction: column; gap: 18px; }

/* ══ FLASH ═══════════════════════════════════════════════ */
.hp-flash { padding: 11px 16px; border-radius: var(--r); font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.hp-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.hp-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.hp-flash svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ HERO BANNER ═════════════════════════════════════════ */
.hp-hero { background: linear-gradient(115deg,#1A3FA8 0%,var(--indigo) 42%,var(--blue) 74%,#5A8BF5 100%); border-radius: var(--r-lg); padding: 24px 30px; display: flex; align-items: center; justify-content: space-between; gap: 16px; position: relative; overflow: hidden; box-shadow: var(--sh-lg); }
.hp-hero::before { content:''; position:absolute; top:-50px; right:180px; width:250px; height:250px; border-radius:50%; background:rgba(255,255,255,0.05); pointer-events:none; }
.hp-hero-left { display: flex; align-items: center; gap: 16px; z-index: 1; }
.hp-hero-icon { width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.18); border: 2px solid rgba(255,255,255,0.28); display: flex; align-items: center; justify-content: center; }
.hp-hero-icon svg { width: 24px; height: 24px; stroke: #fff; fill: none; stroke-width: 1.75; }
.hp-hero-title { font-family: 'Sora', sans-serif; font-size: 21px; font-weight: 900; color: #fff; margin-bottom: 4px; }
.hp-hero-sub { font-size: 12.5px; color: rgba(255,255,255,0.65); font-weight: 500; }
.hp-hero-stats { display: flex; z-index: 1; }
.hp-hero-stat { padding: 6px 18px; text-align: center; border-left: 1px solid rgba(255,255,255,0.15); }
.hp-hero-stat:first-child { border-left: none; }
.hp-hero-stat-v { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 900; color: #fff; line-height: 1; }
.hp-hero-stat-l { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.50); text-transform: uppercase; letter-spacing: .08em; margin-top: 3px; }

/* ══ TILES ════════════════════════════════════════════════ */
.hp-tiles { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
.hp-tile { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); padding: 16px 14px; display: flex; align-items: flex-start; gap: 12px; position: relative; overflow: hidden; cursor: pointer; transition: box-shadow .18s, transform .18s, border-color .18s; }
.hp-tile:hover { box-shadow: var(--sh-md); transform: translateY(-2px); border-color: var(--blue-brd); }
.hp-tile-bar { position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 20px 0 0 20px; }
.hp-tile-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.hp-tile-icon svg { width: 16px; height: 16px; fill: none; stroke-width: 2; }
.hp-tile-lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--ink4); margin-bottom: 3px; }
.hp-tile-val { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -.4px; line-height: 1; }
.hp-tile-sub { font-size: 10.5px; color: var(--ink4); margin-top: 3px; }
.hp-t-indigo .hp-tile-bar{background:var(--indigo);}  .hp-t-indigo .hp-tile-icon{background:var(--indigo-lt);}  .hp-t-indigo .hp-tile-icon svg{stroke:var(--indigo);}  .hp-t-indigo .hp-tile-val{color:var(--indigo);}
.hp-t-green  .hp-tile-bar{background:var(--green);}   .hp-t-green  .hp-tile-icon{background:var(--green-lt);}   .hp-t-green  .hp-tile-icon svg{stroke:var(--green);}   .hp-t-green  .hp-tile-val{color:var(--green);}
.hp-t-amber  .hp-tile-bar{background:var(--amber);}   .hp-t-amber  .hp-tile-icon{background:var(--amber-lt);}   .hp-t-amber  .hp-tile-icon svg{stroke:var(--amber);}   .hp-t-amber  .hp-tile-val{color:#92400E;}
.hp-t-blue   .hp-tile-bar{background:var(--blue);}    .hp-t-blue   .hp-tile-icon{background:var(--blue-lt);}    .hp-t-blue   .hp-tile-icon svg{stroke:var(--blue);}    .hp-t-blue   .hp-tile-val{color:var(--blue-2);}
.hp-t-purple .hp-tile-bar{background:var(--purple);}  .hp-t-purple .hp-tile-icon{background:var(--purple-lt);}  .hp-t-purple .hp-tile-icon svg{stroke:var(--purple);}  .hp-t-purple .hp-tile-val{color:var(--purple);}
.hp-t-teal   .hp-tile-bar{background:var(--teal);}    .hp-t-teal   .hp-tile-icon{background:var(--teal-lt);}    .hp-t-teal   .hp-tile-icon svg{stroke:var(--teal);}    .hp-t-teal   .hp-tile-val{color:var(--teal);}

/* ══ CARD ════════════════════════════════════════════════ */
.hp-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
.hp-card-hd { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--border); }
.hp-card-hdl { display: flex; align-items: center; gap: 8px; }
.hp-card-ico { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
.hp-card-ico svg { width: 13px; height: 13px; fill: none; stroke-width: 2; stroke: currentColor; }
.hp-card-title { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 800; color: var(--ink); }
.hp-card-sub { font-size: 11px; color: var(--ink4); margin-top: 1px; }
.hp-card-bd { padding: 16px 18px; }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.hp-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); padding: 12px 16px; }
.hp-search { display: flex; align-items: center; gap: 8px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 7px 12px; flex: 1; min-width: 180px; transition: border-color .15s; }
.hp-search:focus-within { border-color: var(--indigo); }
.hp-search svg { width: 13px; height: 13px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.hp-search input { border: none; background: transparent; font-size: 13px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.hp-sel { background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 7px 30px 7px 10px; font-size: 12.5px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; -webkit-appearance: none; }
.hp-sel:focus { border-color: var(--indigo); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.hp-btn { display: inline-flex; align-items: center; gap: 5px; padding: 8px 15px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; transition: all .15s; white-space: nowrap; }
.hp-btn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.hp-btn-primary { background: var(--indigo); color: #fff; box-shadow: 0 4px 12px rgba(107,79,219,0.28); }
.hp-btn-primary:hover { background: #5A3EC4; transform: translateY(-1px); }
.hp-btn-ghost   { background: var(--indigo-lt); color: var(--indigo); border: 1px solid var(--indigo-brd); }
.hp-btn-ghost:hover { background: rgba(107,79,219,0.16); }
.hp-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.hp-btn-outline:hover { border-color: var(--indigo); color: var(--indigo); }
.hp-btn-green  { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }
.hp-btn-green:hover { background: rgba(18,183,106,0.16); }
.hp-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.hp-btn-danger:hover { background: rgba(239,68,68,0.15); }
.hp-btn-sm { padding: 5px 10px; font-size: 11.5px; }

/* ══ BADGES ══════════════════════════════════════════════ */
.hp-badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.hb-green  { background: var(--green-lt);  color: #087A42; }
.hb-amber  { background: var(--amber-lt);  color: #92400E; }
.hb-red    { background: var(--red-lt);    color: #991B1B; }
.hb-blue   { background: var(--blue-lt);   color: var(--blue-2); }
.hb-indigo { background: var(--indigo-lt); color: var(--indigo); }
.hb-purple { background: var(--purple-lt); color: var(--purple); }
.hb-teal   { background: var(--teal-lt);   color: var(--teal); }
.hb-gray   { background: var(--bg); color: var(--ink3); border: 1px solid var(--border); }

/* ══ TABLE ════════════════════════════════════════════════ */
.hp-table-wrap { overflow-x: auto; }
table.hp-table { width: 100%; border-collapse: collapse; }
.hp-table thead tr { background: #FAFBFF; border-bottom: 1px solid var(--border); }
.hp-table th { padding: 9px 14px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.hp-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
.hp-table tbody tr:last-child { border-bottom: none; }
.hp-table tbody tr:hover { background: #F8FAFF; }
.hp-table td { padding: 11px 14px; font-size: 13px; color: var(--ink2); }
.hp-emp-cell { display: flex; align-items: center; gap: 9px; }
.hp-emp-av { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,var(--indigo),var(--blue)); display: flex; align-items: center; justify-content: center; font-family: 'Sora', sans-serif; font-size: 10.5px; font-weight: 800; color: #fff; flex-shrink: 0; }
.hp-emp-name { font-size: 13px; font-weight: 700; color: var(--ink); }
.hp-emp-sub { font-size: 11px; color: var(--ink4); }
.hp-code { font-family: 'Sora', sans-serif; font-size: 10.5px; font-weight: 800; background: var(--indigo-lt); color: var(--indigo); border: 1px solid var(--indigo-brd); padding: 2px 8px; border-radius: 6px; }

/* ══ SCORE BAR ═══════════════════════════════════════════ */
.hp-score-bar { height: 6px; border-radius: 100px; background: var(--bg); overflow: hidden; margin-top: 4px; }
.hp-score-fill { height: 100%; border-radius: 100px; }
.hp-score-num { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 800; color: var(--indigo); }

/* ══ MODAL ═══════════════════════════════════════════════ */
.hp-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.54); backdrop-filter: blur(10px); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.hp-modal { background: var(--white); border-radius: var(--r-lg); box-shadow: var(--sh-lg); border: 1px solid var(--border); width: 100%; max-width: 640px; max-height: 92vh; overflow-y: auto; display: flex; flex-direction: column; }
.hp-modal-xl { max-width: 820px; }
.hp-modal-sm { max-width: 420px; }
.hp-modal-hd { background: linear-gradient(105deg,#0C4A6E,var(--indigo)); padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
.hp-modal-hd.green-hd { background: linear-gradient(105deg,#065F46,var(--green)); }
.hp-modal-hd-left { display: flex; align-items: center; gap: 11px; }
.hp-modal-hd-icon { width: 36px; height: 36px; border-radius: 9px; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; }
.hp-modal-hd-icon svg { width: 17px; height: 17px; stroke: #fff; fill: none; stroke-width: 2; }
.hp-modal-title { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 800; color: #fff; }
.hp-modal-sub { font-size: 11.5px; color: rgba(255,255,255,.65); margin-top: 1px; }
.hp-modal-close { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.18); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
.hp-modal-close:hover { background: rgba(255,255,255,0.30); }
.hp-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }
.hp-modal-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 13px; }
.hp-modal-footer { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; flex-shrink: 0; }

/* ── Fields ──────────────────────────────────────────── */
.hp-field { display: flex; flex-direction: column; gap: 4px; }
.hp-field label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .09em; color: var(--ink4); }
.hp-field label .req { color: var(--red); }
.hp-field input, .hp-field select, .hp-field textarea { background: #F6F8FC; border: 1.5px solid var(--border); border-radius: 9px; color: var(--ink); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500; padding: 8px 11px; width: 100%; outline: none; transition: border-color .15s; }
.hp-field input:focus, .hp-field select:focus, .hp-field textarea:focus { border-color: var(--indigo); box-shadow: 0 0 0 3px rgba(107,79,219,0.09); background: var(--white); }
.hp-field textarea { resize: vertical; min-height: 75px; }
.hp-field-err { font-size: 11px; color: var(--red); font-weight: 600; }
.hp-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.hp-grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
.hp-section-lbl { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .10em; color: var(--ink4); padding: 4px 0 2px; border-bottom: 1px solid var(--border); }

/* ── Metric slider row ───────────────────────────────── */
.hp-metric-row { display: flex; align-items: center; gap: 10px; }
.hp-metric-name { font-size: 12px; font-weight: 700; color: var(--ink2); min-width: 130px; }
.hp-metric-slider { flex: 1; accent-color: var(--indigo); }
.hp-metric-val { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 800; color: var(--indigo); background: var(--indigo-lt); padding: 2px 8px; border-radius: 6px; min-width: 36px; text-align: center; }

/* ── Score preview ───────────────────────────────────── */
.hp-score-preview { background: var(--indigo-lt); border: 1px solid var(--indigo-brd); border-radius: var(--r); padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; }
.hp-score-preview-lbl { font-size: 12px; font-weight: 700; color: var(--indigo); }
.hp-score-preview-val { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 900; color: var(--indigo); }

/* ══ DETAIL GRID (view modal) ════════════════════════════ */
.hp-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.hp-detail-item { background: var(--bg); border-radius: 9px; border: 1px solid var(--border); padding: 9px 13px; }
.hp-detail-item.full { grid-column: span 2; }
.hp-detail-lbl { font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); margin-bottom: 3px; }
.hp-detail-val { font-size: 13px; font-weight: 600; color: var(--ink); }

/* ── Finance strip ───────────────────────────────────── */
.hp-fin-strip { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; }
.hp-fin-card { background: var(--bg); border: 1px solid var(--border); border-radius: 9px; padding: 10px 13px; }
.hp-fin-lbl { font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--ink4); }
.hp-fin-val { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; margin-top: 3px; }

/* ══ EMPLOYEE DETAIL VIEW ════════════════════════════════ */
.hp-emp-detail-header { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
.hp-emp-detail-cover { height: 70px; background: linear-gradient(118deg,var(--indigo),var(--blue),#5A8BF5); position: relative; overflow: hidden; }
.hp-emp-detail-cover::before { content:''; position:absolute; top:-30px; right:60px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.06); }
.hp-emp-detail-body { padding: 0 22px 20px; display: flex; align-items: flex-end; justify-content: space-between; gap: 14px; margin-top: -22px; }
.hp-emp-av-lg { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg,var(--indigo),var(--blue)); border: 3px solid var(--white); display: flex; align-items: center; justify-content: center; font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 900; color: #fff; flex-shrink: 0; }

/* ══ TABS ════════════════════════════════════════════════ */
.hp-tabs { display: flex; gap: 0; border-bottom: 1px solid var(--border); background: var(--white); border-radius: var(--r-lg) var(--r-lg) 0 0; overflow: hidden; padding: 0 18px; }
.hp-tab { padding: 12px 16px; font-size: 13px; font-weight: 700; color: var(--ink3); cursor: pointer; border: none; background: none; font-family: 'DM Sans', sans-serif; border-bottom: 2px solid transparent; transition: color .15s, border-color .15s; margin-bottom: -1px; }
.hp-tab:hover { color: var(--indigo); }
.hp-tab.active { color: var(--indigo); border-bottom-color: var(--indigo); }

/* ══ PROGRESS BAR ════════════════════════════════════════ */
.hp-prog-bar { height: 6px; background: var(--bg); border-radius: 100px; overflow: hidden; margin-top: 5px; }
.hp-prog-fill { height: 100%; border-radius: 100px; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.hp-empty { text-align: center; padding: 40px 20px; }
.hp-empty svg { width: 34px; height: 34px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 10px; display: block; opacity: .4; }
.hp-empty-ttl { font-size: 14px; font-weight: 700; color: var(--ink3); margin-bottom: 3px; }
.hp-empty-sub { font-size: 12.5px; color: var(--ink4); }

/* ══ DELETE CONFIRM ══════════════════════════════════════ */
.hp-del-body { padding: 26px 24px; text-align: center; }
.hp-del-icon { width: 50px; height: 50px; border-radius: 50%; background: var(--red-lt); border: 1px solid rgba(239,68,68,0.22); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.hp-del-icon svg { width: 20px; height: 20px; stroke: var(--red); fill: none; stroke-width: 2; }
.hp-del-ttl { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: var(--ink); margin-bottom: 6px; }
.hp-del-sub { font-size: 13px; color: var(--ink3); line-height: 1.6; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.hp-pager { padding: 12px 18px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
.hp-pager-info { font-size: 12px; color: var(--ink4); font-weight: 600; }

@media (max-width: 1100px) { .hp-tiles { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 900px)  {
    .hp-nav { width: 60px; min-width: 60px; }
    .hp-nav-brand, .hp-nav-section, .hp-nav-item span, .hp-nav-badge, .hp-nav-bottom span { display: none; }
    .hp-nav-item { justify-content: center; padding: 10px; margin: 2px 4px; width: calc(100% - 8px); }
    .hp-nav-item.active::before { display: none; }
    .hp-nav-logo { justify-content: center; padding: 14px 8px; }
    .hp-hero-stats { display: none; }
}
@media (max-width: 640px)  {
    .hp-root { flex-direction: column; }
    .hp-grid2, .hp-grid3 { grid-template-columns: 1fr; }
    .hp-detail-grid, .hp-fin-strip { grid-template-columns: 1fr; }
    .hp-detail-item.full { grid-column: span 1; }
    .hp-wrap { padding: 14px 14px; }
{{-- ════ SHELL ═════════════════════════════════════════════ --}}

{{-- Flash --}}
@if(session()->has('success'))
    <div class="hp-flash hp-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="hp-flash hp-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ CONTENT ═════════════════════════════════════════════ --}}
<div class="hp-content">
<div class="hp-wrap">

{{-- ══ HERO ════════════════════════════════════════════════ --}}
<div class="hp-hero">
    <div class="hp-hero-left">
        <div class="hp-hero-icon">
            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        </div>
        <div>
            <div class="hp-hero-title">HR Performance Management</div>
            <div class="hp-hero-sub">{{ \Carbon\Carbon::now('Africa/Kigali')->format('l, j F Y') }} · Evaluate, track and grow your team</div>
        </div>
    </div>
    <div class="hp-hero-stats">
        <div class="hp-hero-stat"><div class="hp-hero-stat-v">{{ $totalEmployees }}</div><div class="hp-hero-stat-l">Employees</div></div>
        <div class="hp-hero-stat"><div class="hp-hero-stat-v">{{ $totalReviews }}</div><div class="hp-hero-stat-l">Reviews</div></div>
        <div class="hp-hero-stat"><div class="hp-hero-stat-v">{{ $avgScore }}</div><div class="hp-hero-stat-l">Avg Score</div></div>
        <div class="hp-hero-stat"><div class="hp-hero-stat-v">{{ $pendingReviews }}</div><div class="hp-hero-stat-l">Pending</div></div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════ --}}
     DASHBOARD
════════════════════════════════════════════════════════════════════════ --}}
{{-- DEBUG: Active Section = {{ $activeSection }} --}}
@if($activeSection === 'dashboard')

<div class="hp-tiles">
    <div class="hp-tile hp-t-indigo" wire:click="$set('activeSection','employees')">
        <div class="hp-tile-bar"></div>
        <div class="hp-tile-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div><div class="hp-tile-lbl">Total Employees</div><div class="hp-tile-val">{{ $totalEmployees }}</div><div class="hp-tile-sub">Across all departments</div></div>
    </div>
    <div class="hp-tile hp-t-blue" wire:click="$set('activeSection','evaluations')">
        <div class="hp-tile-bar"></div>
        <div class="hp-tile-icon"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg></div>
        <div><div class="hp-tile-lbl">Total Reviews</div><div class="hp-tile-val">{{ $totalReviews }}</div><div class="hp-tile-sub">{{ $approvedReviews }} approved</div></div>
    </div>
    <div class="hp-tile hp-t-amber" wire:click="$set('activeSection','evaluations')">
        <div class="hp-tile-bar"></div>
        <div class="hp-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="hp-tile-lbl">Pending Approval</div><div class="hp-tile-val">{{ $pendingReviews }}</div><div class="hp-tile-sub">Awaiting review</div></div>
    </div>
    <div class="hp-tile hp-t-green">
        <div class="hp-tile-bar"></div>
        <div class="hp-tile-icon"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
        <div><div class="hp-tile-lbl">Average Score</div><div class="hp-tile-val">{{ $avgScore }}</div><div class="hp-tile-sub">Out of 5.0</div></div>
    </div>
    <div class="hp-tile hp-t-purple" wire:click="$set('activeSection','self_evals')">
        <div class="hp-tile-bar"></div>
        <div class="hp-tile-icon"><svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></div>
        <div><div class="hp-tile-lbl">Self Evaluations</div><div class="hp-tile-val">{{ $selfEvalCount }}</div><div class="hp-tile-sub">Submitted by employees</div></div>
    </div>
    <div class="hp-tile hp-t-teal">
        <div class="hp-tile-bar"></div>
        <div class="hp-tile-icon"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        <div><div class="hp-tile-lbl">Approved Reviews</div><div class="hp-tile-val">{{ $approvedReviews }}</div><div class="hp-tile-sub">Fully processed</div></div>
    </div>
</div>

{{-- Recent reviews table --}}
<div class="hp-card">
    <div class="hp-card-hd">
        <div class="hp-card-hdl">
            <div class="hp-card-ico" style="background:var(--indigo-lt);border:1px solid var(--indigo-brd);">
                <svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
            </div>
            <div><div class="hp-card-title">Recent Evaluations</div><div class="hp-card-sub">Latest submitted</div></div>
        </div>
        <div style="display:flex;gap:8px;">
            <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="$set('activeSection','evaluations')">View All</button>
            <button class="hp-btn hp-btn-primary hp-btn-sm" wire:click="openCreateEval()">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Evaluation
            </button>
        </div>
    </div>
    <div class="hp-table-wrap">
        <table class="hp-table">
            <thead><tr><th>Employee</th><th>Type</th><th>Score</th><th>Rating</th><th>Date</th><th>Approval</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($recentReviews as $rv)
                    @php
                        $rvEmp  = $rv->employee;
                        $rvInit = $rvEmp ? strtoupper(substr($rvEmp->first_name??'',0,1).substr($rvEmp->last_name??'',0,1)) : '??';
                        $rvAp   = $rv->approval_status instanceof \BackedEnum ? $rv->approval_status->value : ($rv->approval_status ?? 'draft');
                        $rvRat  = $rv->overall_rating instanceof \BackedEnum  ? $rv->overall_rating->value  : ($rv->overall_rating  ?? 'good');
                        $rvApCls = match($rvAp){ 'approved'=>'hb-green','rejected'=>'hb-red','pending'=>'hb-amber',default=>'hb-gray' };
                        $rvRatCls = match($rvRat){ 'excellent'=>'hb-green','good'=>'hb-teal','satisfactory'=>'hb-blue','needs_improvement'=>'hb-amber',default=>'hb-red' };
                        $rvScore = (float)($rv->overall_score ?? 0);
                    @endphp
                    <tr>
                        <td>
                            <div class="hp-emp-cell">
                                <div class="hp-emp-av">{{ $rvInit }}</div>
                                <div>
                                    <div class="hp-emp-name">{{ $rvEmp ? trim(($rvEmp->first_name??'').' '.($rvEmp->last_name??'')) : '—' }}</div>
                                    <div class="hp-emp-sub"><span class="hp-code">{{ $rv->code }}</span></div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $rv->type }}</td>
                        <td>
                            <div class="hp-score-num">{{ number_format($rvScore,1) }}</div>
                            <div class="hp-score-bar"><div class="hp-score-fill" style="width:{{ ($rvScore/5)*100 }}%;background:var(--indigo);"></div></div>
                        </td>
                        <td><span class="hp-badge {{ $rvRatCls }}">{{ ucfirst(str_replace('_',' ',$rvRat)) }}</span></td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $rv->review_date ? \Carbon\Carbon::parse($rv->review_date)->format('M d, Y') : '—' }}</td>
                        <td><span class="hp-badge {{ $rvApCls }}">{{ ucfirst($rvAp) }}</span></td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="openViewReview({{ $rv->id }})">View</button>
                                @if($rvAp !== 'approved')
                                    <button class="hp-btn hp-btn-green hp-btn-sm" wire:click="approveReview({{ $rv->id }})"
                                            wire:confirm="Approve this review?">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="hp-empty">
                        <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                        <div class="hp-empty-ttl">No evaluations yet</div>
                        <div class="hp-empty-sub">Create the first employee evaluation</div>
                    </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif {{-- /dashboard --}}


{{-- ══════════════════════════════════════════════════════════
     ALL EVALUATIONS
══════════════════════════════════════════════════════════ --}}
@if($activeSection === 'evaluations')

<div class="hp-toolbar">
    <div class="hp-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by employee or code…">
    </div>
    <select class="hp-sel" wire:model.live="filterReviewType">
        <option value="">All Types</option>
        @foreach($reviewTypes as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="hp-sel" wire:model.live="filterRating">
        <option value="">All Ratings</option>
        @foreach($ratings as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="hp-sel" wire:model.live="filterStatus">
        <option value="">All Approvals</option>
        @foreach($approvalStatuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="hp-sel" wire:model.live="filterDept">
        <option value="">All Departments</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select>
    <button class="hp-btn hp-btn-primary" wire:click="openCreateEval()">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Evaluation
    </button>
</div>

<div class="hp-card">
    <div class="hp-card-hd">
        <div class="hp-card-hdl">
            <div class="hp-card-ico" style="background:var(--indigo-lt);border:1px solid var(--indigo-brd);">
                <svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
            </div>
            <div>
                <div class="hp-card-title">Evaluation Registry</div>
                <div class="hp-card-sub">{{ $reviews->total() ?? 0 }} record{{ ($reviews->total() ?? 0) != 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>
    <div class="hp-table-wrap">
        <table class="hp-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Score</th>
                    <th>Rating</th>
                    <th>Review Date</th>
                    <th>Approval</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $rv)
                    @php
                        $rvEmp   = $rv->employee;
                        $rvInit  = $rvEmp ? strtoupper(substr($rvEmp->first_name??'',0,1).substr($rvEmp->last_name??'',0,1)) : '??';
                        $rvAp    = $rv->approval_status instanceof \BackedEnum ? $rv->approval_status->value : ($rv->approval_status ?? 'draft');
                        $rvRat   = $rv->overall_rating instanceof \BackedEnum  ? $rv->overall_rating->value  : ($rv->overall_rating  ?? 'good');
                        $rvApCls = match($rvAp){ 'approved'=>'hb-green','rejected'=>'hb-red','pending'=>'hb-amber',default=>'hb-gray' };
                        $rvRatCls= match($rvRat){ 'excellent'=>'hb-green','good'=>'hb-teal','satisfactory'=>'hb-blue','needs_improvement'=>'hb-amber',default=>'hb-red' };
                        $rvScore = (float)($rv->overall_score ?? 0);
                    @endphp
                    <tr>
                        <td>
                            <div class="hp-emp-cell">
                                <div class="hp-emp-av">{{ $rvInit }}</div>
                                <div>
                                    <div class="hp-emp-name">{{ $rvEmp ? trim(($rvEmp->first_name??'').' '.($rvEmp->last_name??'')) : '—' }}</div>
                                    <div class="hp-emp-sub">{{ $rvEmp->department?->name ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="hp-code">{{ $rv->code }}</span></td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $rv->type }}</td>
                        <td>
                            <div class="hp-score-num">{{ number_format($rvScore,1) }}</div>
                            <div class="hp-score-bar"><div class="hp-score-fill" style="width:{{ ($rvScore/5)*100 }}%;background:var(--indigo);"></div></div>
                        </td>
                        <td><span class="hp-badge {{ $rvRatCls }}">{{ ucfirst(str_replace('_',' ',$rvRat)) }}</span></td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $rv->review_date ? \Carbon\Carbon::parse($rv->review_date)->format('M d, Y') : '—' }}</td>
                        <td><span class="hp-badge {{ $rvApCls }}">{{ ucfirst($rvAp) }}</span></td>
                        <td>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="openViewReview({{ $rv->id }})">View</button>
                                <button class="hp-btn hp-btn-outline hp-btn-sm" wire:click="openEditEval({{ $rv->id }})">Edit</button>
                                @if($rvAp !== 'approved')
                                    <button class="hp-btn hp-btn-green hp-btn-sm" wire:click="approveReview({{ $rv->id }})"
                                            wire:confirm="Approve this review?">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                @endif
                                <button class="hp-btn hp-btn-danger hp-btn-sm" wire:click="confirmDelete({{ $rv->id }})">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">
                        <div class="hp-empty">
                            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                            <div class="hp-empty-ttl">No evaluations found</div>
                            <div class="hp-empty-sub">{{ $search || $filterReviewType || $filterRating || $filterStatus ? 'Try adjusting your filters.' : 'Create the first evaluation.' }}</div>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($reviews,'hasPages') && $reviews->hasPages())
        <div class="hp-pager">
            <div class="hp-pager-info">Showing {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} of {{ $reviews->total() }}</div>
            {{ $reviews->links() }}
        </div>
    @endif
</div>

@endif {{-- /evaluations --}}


{{-- ══════════════════════════════════════════════════════════
     EMPLOYEES LIST
══════════════════════════════════════════════════════════ --}}
@if($activeSection === 'employees')

<div class="hp-toolbar">
    <div class="hp-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search employees…">
    </div>
    <select class="hp-sel" wire:model.live="filterDept">
        <option value="">All Departments</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select>
</div>

<div class="hp-card">
    <div class="hp-card-hd">
        <div class="hp-card-hdl">
            <div class="hp-card-ico" style="background:var(--indigo-lt);border:1px solid var(--indigo-brd);">
                <svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><div class="hp-card-title">Employee Directory</div><div class="hp-card-sub">{{ $employees->total() ?? 0 }} employees</div></div>
        </div>
    </div>
    <div class="hp-table-wrap">
        <table class="hp-table">
            <thead><tr><th>Employee</th><th>Department</th><th>Position</th><th>Reviews</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($employees as $emp)
                    @php
                        $empInit = strtoupper(substr($emp->first_name??'',0,1).substr($emp->last_name??'',0,1));
                    @endphp
                    <tr>
                        <td>
                            <div class="hp-emp-cell">
                                <div class="hp-emp-av">{{ $empInit }}</div>
                                <div>
                                    <div class="hp-emp-name">{{ trim(($emp->first_name??'').' '.($emp->last_name??'')) }}</div>
                                    <div class="hp-emp-sub"><span class="hp-code">{{ $emp->code }}</span></div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12.5px;color:var(--ink3);">{{ $emp->department?->name ?? '—' }}</td>
                        <td style="font-size:12.5px;color:var(--ink3);">{{ $emp->position?->name ?? '—' }}</td>
                        <td><span class="hp-badge hb-blue">{{ $emp->performance_reviews_count ?? 0 }} reviews</span></td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="openViewEmployee({{ $emp->id }})">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Profile
                                </button>
                                <button class="hp-btn hp-btn-primary hp-btn-sm" wire:click="openCreateEval({{ $emp->id }})">
                                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Evaluate
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="hp-empty">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/></svg>
                        <div class="hp-empty-ttl">No employees found</div>
                    </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($employees,'hasPages') && $employees->hasPages())
        <div class="hp-pager">
            <div class="hp-pager-info">Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }} of {{ $employees->total() }}</div>
            {{ $employees->links() }}
        </div>
    @endif
</div>

@endif {{-- /employees --}}


{{-- ══════════════════════════════════════════════════════════
     EMPLOYEE DETAIL
══════════════════════════════════════════════════════════ --}}
@if($activeSection === 'employee_detail' && $selectedEmployee)
@php
    $selInit = strtoupper(substr($selectedEmployee->first_name??'',0,1).substr($selectedEmployee->last_name??'',0,1));
    $selAvgScore = $employeeReviews->count() ? round($employeeReviews->avg('overall_score'),2) : 0;
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
    <button class="hp-btn hp-btn-outline hp-btn-sm" wire:click="backToList()">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Employees
    </button>
</div>

{{-- Employee header --}}
<div class="hp-emp-detail-header">
    <div class="hp-emp-detail-cover"></div>
    <div class="hp-emp-detail-body">
        <div style="display:flex;align-items:flex-end;gap:12px;">
            <div class="hp-emp-av-lg">{{ $selInit }}</div>
            <div>
                <div style="font-family:'Sora',sans-serif;font-size:18px;font-weight:800;color:var(--ink);">
                    {{ trim(($selectedEmployee->first_name??'').' '.($selectedEmployee->last_name??'')) }}
                </div>
                <div style="font-size:12.5px;color:var(--ink3);margin-top:2px;">
                    {{ $selectedEmployee->position?->name ?? 'No Position' }} · {{ $selectedEmployee->department?->name ?? 'No Department' }}
                </div>
            </div>
        </div>
        <div style="display:flex;gap:8px;padding-bottom:2px;">
            <button class="hp-btn hp-btn-primary" wire:click="openCreateEval({{ $selectedEmployee->id }})">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Evaluate Employee
            </button>
        </div>
    </div>
    {{-- Stats strip --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:var(--border);border-top:1px solid var(--border);">
        @foreach([['Reviews',$employeeReviews->count()],['Avg Score',$selAvgScore.' / 5'],['Goals',$employeeGoals->count()],['Self Evals',$employeeSelfEvals->count()]] as [$l,$v])
        <div style="background:var(--white);padding:12px 16px;">
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--ink4);">{{ $l }}</div>
            <div style="font-family:'Sora',sans-serif;font-size:18px;font-weight:800;color:var(--indigo);margin-top:2px;">{{ $v }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Tab content --}}
<div style="background:var(--white);border-radius:var(--r-lg);border:1px solid var(--border);box-shadow:var(--sh-sm);overflow:hidden;">
    <div class="hp-tabs">
        <button class="hp-tab active" id="tab-reviews-btn" onclick="hpTab('reviews')">All Reviews</button>
        <button class="hp-tab" id="tab-self-btn"    onclick="hpTab('self')">Self Evaluations</button>
        <button class="hp-tab" id="tab-goals-btn"   onclick="hpTab('goals')">Goals</button>
    </div>

    {{-- All reviews --}}
    <div id="tab-reviews" style="display:block;">
        <table class="hp-table" style="margin:0;">
            <thead><tr><th>Code</th><th>Type</th><th>Score</th><th>Rating</th><th>Date</th><th>Approval</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($employeeReviews as $er)
                    @php
                        $erAp    = $er->approval_status instanceof \BackedEnum ? $er->approval_status->value : ($er->approval_status ?? 'draft');
                        $erRat   = $er->overall_rating instanceof \BackedEnum  ? $er->overall_rating->value  : ($er->overall_rating  ?? 'good');
                        $erApCls = match($erAp){ 'approved'=>'hb-green','rejected'=>'hb-red','pending'=>'hb-amber',default=>'hb-gray' };
                        $erRatCls= match($erRat){ 'excellent'=>'hb-green','good'=>'hb-teal','satisfactory'=>'hb-blue','needs_improvement'=>'hb-amber',default=>'hb-red' };
                        $erScore = (float)($er->overall_score ?? 0);
                    @endphp
                    <tr>
                        <td><span class="hp-code">{{ $er->code }}</span></td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $er->type }}</td>
                        <td>
                            <div class="hp-score-num">{{ number_format($erScore,1) }}</div>
                            <div class="hp-score-bar"><div class="hp-score-fill" style="width:{{ ($erScore/5)*100 }}%;background:var(--indigo);"></div></div>
                        </td>
                        <td><span class="hp-badge {{ $erRatCls }}">{{ ucfirst(str_replace('_',' ',$erRat)) }}</span></td>
                        <td style="font-size:12px;">{{ $er->review_date ? \Carbon\Carbon::parse($er->review_date)->format('M d, Y') : '—' }}</td>
                        <td><span class="hp-badge {{ $erApCls }}">{{ ucfirst($erAp) }}</span></td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="openViewReview({{ $er->id }})">View</button>
                                <button class="hp-btn hp-btn-outline hp-btn-sm" wire:click="openEditEval({{ $er->id }})">Edit</button>
                                @if($erAp !== 'approved')
                                    <button class="hp-btn hp-btn-green hp-btn-sm" wire:click="approveReview({{ $er->id }})"
                                            wire:confirm="Approve?">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="hp-empty">
                        <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                        <div class="hp-empty-ttl">No reviews yet</div>
                    </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Self evaluations --}}
    <div id="tab-self" style="display:none;">
        @forelse($employeeSelfEvals as $se)
            @php
                $seScore = (float)($se->overall_score ?? 0);
                $seAp = $se->approval_status instanceof \BackedEnum ? $se->approval_status->value : ($se->approval_status ?? 'draft');
                $seApCls = match($seAp){ 'approved'=>'hb-green','rejected'=>'hb-red','pending'=>'hb-amber',default=>'hb-gray' };
            @endphp
            <div style="padding:16px 18px;border-bottom:1px solid var(--border);">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <div>
                        <div style="font-size:13.5px;font-weight:700;color:var(--ink);">Self Evaluation</div>
                        <div style="font-size:11.5px;color:var(--ink4);margin-top:2px;">
                            {{ $se->review_date ? \Carbon\Carbon::parse($se->review_date)->format('M d, Y') : '—' }}
                            · <span class="hp-code">{{ $se->code }}</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="text-align:right;">
                            <div style="font-family:'Sora',sans-serif;font-size:20px;font-weight:900;color:var(--indigo);">{{ number_format($seScore,1) }}</div>
                            <div style="font-size:10px;color:var(--ink4);">/ 5.0</div>
                        </div>
                        <span class="hp-badge {{ $seApCls }}">{{ ucfirst($seAp) }}</span>
                        <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="openViewReview({{ $se->id }})">View</button>
                        @if($seAp !== 'approved')
                            <button class="hp-btn hp-btn-green hp-btn-sm" wire:click="approveReview({{ $se->id }})"
                                    wire:confirm="Approve this self evaluation?">
                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Approve
                            </button>
                        @endif
                    </div>
                </div>
                {{-- Metrics bar grid --}}
                @if($se->items && $se->items->count())
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                        @foreach($se->items as $si)
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:11px;font-weight:600;color:var(--ink3);margin-bottom:3px;">
                                    <span>{{ $si->criteria }}</span>
                                    <span style="color:var(--indigo);font-weight:800;">{{ $si->score }}/5</span>
                                </div>
                                <div class="hp-prog-bar"><div class="hp-prog-fill" style="width:{{ ($si->score/5)*100 }}%;background:var(--indigo);"></div></div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if($se->strengths)
                    <div style="margin-top:10px;background:var(--bg);border-radius:8px;padding:10px 12px;font-size:12.5px;color:var(--ink3);line-height:1.6;">
                        <strong style="color:var(--ink2);">Strengths:</strong> {{ Str::limit($se->strengths,200) }}
                    </div>
                @endif
            </div>
        @empty
            <div class="hp-empty">
                <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                <div class="hp-empty-ttl">No self evaluations submitted</div>
                <div class="hp-empty-sub">Employee hasn't submitted a self evaluation yet</div>
            </div>
        @endforelse
    </div>

    {{-- Goals --}}
    <div id="tab-goals" style="display:none;padding:16px 18px;">
        @forelse($employeeGoals as $eg)
            @php
                $egSt  = $eg->status instanceof \BackedEnum ? $eg->status->value : ($eg->status ?? 'active');
                $egCls = match($egSt){ 'completed'=>'hb-green','on_hold'=>'hb-amber',default=>'hb-blue' };
                $egPct = $eg->progress_percentage ?? 0;
            @endphp
            <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border);">
                <div style="width:8px;height:8px;border-radius:50%;background:{{ $egSt==='completed'?'var(--green)':($egSt==='on_hold'?'var(--amber)':'var(--indigo)') }};flex-shrink:0;"></div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:var(--ink);">{{ $eg->title }}</div>
                    <div style="font-size:11px;color:var(--ink4);margin-top:2px;">Due {{ $eg->end_date ? \Carbon\Carbon::parse($eg->end_date)->format('M d, Y') : 'No deadline' }}</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
                        <div style="flex:1;height:5px;border-radius:100px;background:var(--bg);overflow:hidden;">
                            <div style="height:100%;border-radius:100px;background:var(--indigo);width:{{ $egPct }}%;"></div>
                        </div>
                        <span style="font-size:11px;font-weight:800;color:var(--indigo);">{{ $egPct }}%</span>
                    </div>
                </div>
                <span class="hp-badge {{ $egCls }}">{{ ucfirst(str_replace('_',' ',$egSt)) }}</span>
            </div>
        @empty
            <div class="hp-empty" style="padding:28px 0;">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                <div class="hp-empty-ttl">No goals found</div>
            </div>
        @endforelse
    </div>
</div>

@endif {{-- /employee_detail --}}


{{-- ══════════════════════════════════════════════════════════
     ALL SELF EVALUATIONS (HR view)
══════════════════════════════════════════════════════════ --}}
@if($activeSection === 'self_evals')

<div class="hp-toolbar">
    <div class="hp-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by employee or code…">
    </div>
    <select class="hp-sel" wire:model.live="filterStatus">
        <option value="">All Approvals</option>
        @foreach($approvalStatuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="hp-sel" wire:model.live="filterDept">
        <option value="">All Departments</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select>
</div>

<div class="hp-card">
    <div class="hp-card-hd">
        <div class="hp-card-hdl">
            <div class="hp-card-ico" style="background:var(--purple-lt);border:1px solid rgba(124,58,237,0.22);">
                <svg style="stroke:var(--purple)" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
            </div>
            <div><div class="hp-card-title">Employee Self Evaluations</div><div class="hp-card-sub">Submitted by employees — review and approve below</div></div>
        </div>
    </div>
    <div class="hp-table-wrap">
        <table class="hp-table">
            <thead><tr><th>Employee</th><th>Code</th><th>Score</th><th>Submitted</th><th>Approval</th><th>Actions</th></tr></thead>
            <tbody>
                @php
                    try {
                        $selfEvalQuery = \App\Models\PerformanceReview::with(['employee.department','items'])
                            ->where('type','Self Evaluation')
                            ->when($search, fn($q) => $q->where(function($q2) use ($search) {
                                $q2->where('code','like',"%{$search}%")
                                   ->orWhereHas('employee', fn($q3) =>
                                       $q3->where('first_name','like',"%{$search}%")
                                          ->orWhere('last_name','like',"%{$search}%")
                                   );
                            }))
                            ->when($filterStatus, fn($q) => $q->where('approval_status',$filterStatus))
                            ->when($filterDept, fn($q) => $q->whereHas('employee.department', fn($q2) => $q2->where('id',$filterDept)))
                            ->orderBy('review_date','desc');
                        $selfEvals = $selfEvalQuery->get();
                    } catch(\Exception $e) { $selfEvals = collect(); }
                @endphp
                @forelse($selfEvals as $se)
                    @php
                        $seEmp   = $se->employee;
                        $seInit  = $seEmp ? strtoupper(substr($seEmp->first_name??'',0,1).substr($seEmp->last_name??'',0,1)) : '??';
                        $seAp    = $se->approval_status instanceof \BackedEnum ? $se->approval_status->value : ($se->approval_status ?? 'draft');
                        $seApCls = match($seAp){ 'approved'=>'hb-green','rejected'=>'hb-red','pending'=>'hb-amber',default=>'hb-gray' };
                        $seScore = (float)($se->overall_score ?? 0);
                    @endphp
                    <tr>
                        <td>
                            <div class="hp-emp-cell">
                                <div class="hp-emp-av">{{ $seInit }}</div>
                                <div>
                                    <div class="hp-emp-name">{{ $seEmp ? trim(($seEmp->first_name??'').' '.($seEmp->last_name??'')) : '—' }}</div>
                                    <div class="hp-emp-sub">{{ $seEmp->department?->name ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="hp-code">{{ $se->code }}</span></td>
                        <td>
                            <div class="hp-score-num">{{ number_format($seScore,1) }}</div>
                            <div class="hp-score-bar"><div class="hp-score-fill" style="width:{{ ($seScore/5)*100 }}%;background:var(--purple);"></div></div>
                        </td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $se->review_date ? \Carbon\Carbon::parse($se->review_date)->format('M d, Y') : '—' }}</td>
                        <td><span class="hp-badge {{ $seApCls }}">{{ ucfirst($seAp) }}</span></td>
                        <td>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                <button class="hp-btn hp-btn-ghost hp-btn-sm" wire:click="openViewReview({{ $se->id }})">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    View
                                </button>
                                <button class="hp-btn hp-btn-outline hp-btn-sm" wire:click="openViewEmployee({{ $se->employee_id }})">Profile</button>
                                @if($seAp !== 'approved')
                                    <button class="hp-btn hp-btn-green hp-btn-sm" wire:click="approveReview({{ $se->id }})"
                                            wire:confirm="Approve this self evaluation?">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                        Approve
                                    </button>
                                    <button class="hp-btn hp-btn-danger hp-btn-sm" wire:click="rejectReview({{ $se->id }})"
                                            wire:confirm="Reject this self evaluation?">Reject</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="hp-empty">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        <div class="hp-empty-ttl">No self evaluations found</div>
                        <div class="hp-empty-sub">Employees haven't submitted self evaluations yet</div>
                    </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif {{-- /self_evals --}}


</div>{{-- /hp-wrap --}}
</div>{{-- /hp-content --}}


{{-- ══════════════════════════════════════════════════════════
     CREATE / EDIT EVALUATION MODAL
══════════════════════════════════════════════════════════ --}}
@if($showEvalModal)
<div class="hp-modal-bg" wire:click.self="closeModals">
    <div class="hp-modal hp-modal-xl">
        <div class="hp-modal-hd">
            <div class="hp-modal-hd-left">
                <div class="hp-modal-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                </div>
                <div>
                    <div class="hp-modal-title">{{ $editingId ? 'Edit Evaluation' : 'New Employee Evaluation' }}</div>
                    <div class="hp-modal-sub">{{ $editingId ? 'Update performance review details' : 'Conduct a performance evaluation' }}</div>
                </div>
            </div>
            <button class="hp-modal-close" wire:click="closeModals">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="hp-modal-body">
            {{-- Basic info --}}
            <div class="hp-section-lbl">Basic Information</div>
            <div class="hp-grid2">
                <div class="hp-field">
                    <label>Code</label>
                    <input type="text" wire:model="evalCode" readonly style="background:#EEF2F8;color:var(--ink3);cursor:default;">
                </div>
                <div class="hp-field">
                    <label>Employee <span class="req">*</span></label>
                    <select wire:model="evalEmployeeId">
                        <option value="">— Select employee —</option>
                        @foreach($employeeList as $el)
                            <option value="{{ $el->id }}">{{ trim(($el->first_name??'').' '.($el->last_name??'')) }} ({{ $el->code }})</option>
                        @endforeach
                    </select>
                    @error('evalEmployeeId')<div class="hp-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="hp-field">
                    <label>Review Type <span class="req">*</span></label>
                    <select wire:model="evalType">
                        @foreach($reviewTypes as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="hp-field">
                    <label>Review Date <span class="req">*</span></label>
                    <input type="date" wire:model="evalReviewDate">
                    @error('evalReviewDate')<div class="hp-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="hp-field">
                    <label>Period Start <span class="req">*</span></label>
                    <input type="date" wire:model="evalPeriodStart">
                    @error('evalPeriodStart')<div class="hp-field-err">{{ $message }}</div>@enderror
                </div>
                <div class="hp-field">
                    <label>Period End <span class="req">*</span></label>
                    <input type="date" wire:model="evalPeriodEnd">
                    @error('evalPeriodEnd')<div class="hp-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Metrics --}}
            <div class="hp-section-lbl" style="margin-top:4px;">Performance Metrics (1 = Poor · 5 = Excellent)</div>
            @foreach($metrics as $prop => $label)
                <div class="hp-metric-row">
                    <span class="hp-metric-name">{{ $label }}</span>
                    <input type="range" class="hp-metric-slider" wire:model.live="{{ $prop }}" min="1" max="5" step="1">
                    <span class="hp-metric-val">{{ $$prop }}/5</span>
                </div>
            @endforeach

            {{-- Auto score preview --}}
            <div class="hp-score-preview">
                <span class="hp-score-preview-lbl">Computed Overall Score</span>
                <span class="hp-score-preview-val">{{ number_format($this->computedScore,2) }} / 5.0</span>
            </div>

            {{-- Narrative --}}
            <div class="hp-section-lbl">Narrative Feedback</div>
            <div class="hp-field">
                <label>Strengths <span class="req">*</span></label>
                <textarea wire:model="evalStrengths" placeholder="Describe what the employee does well…"></textarea>
                @error('evalStrengths')<div class="hp-field-err">{{ $message }}</div>@enderror
            </div>
            <div class="hp-field">
                <label>Areas for Improvement <span class="req">*</span></label>
                <textarea wire:model="evalAreasForImprove" placeholder="Where can the employee grow?"></textarea>
                @error('evalAreasForImprove')<div class="hp-field-err">{{ $message }}</div>@enderror
            </div>
            <div class="hp-field">
                <label>Development Plan</label>
                <textarea wire:model="evalDevelopmentPlan" placeholder="Action steps for improvement…"></textarea>
            </div>
            <div class="hp-field">
                <label>Employee Comments</label>
                <textarea wire:model="evalEmployeeComments" placeholder="Any comments from the employee…"></textarea>
            </div>

            {{-- Status --}}
            <div class="hp-section-lbl">Status</div>
            <div class="hp-grid2">
                <div class="hp-field">
                    <label>Review Status</label>
                    <select wire:model="evalStatus">
                        <option value="draft">Draft</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="hp-field">
                    <label>Approval Status</label>
                    <select wire:model="evalApprovalStatus">
                        @foreach($approvalStatuses as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="hp-modal-footer">
            <button class="hp-btn hp-btn-outline" wire:click="closeModals">Cancel</button>
            <button class="hp-btn hp-btn-primary" wire:click="saveEvaluation" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                <span wire:loading.remove wire:target="saveEvaluation">{{ $editingId ? 'Update' : 'Save' }} Evaluation</span>
                <span wire:loading wire:target="saveEvaluation">Saving…</span>
            </button>
        </div>
    </div>
</div>
@endif


{{-- ══════════════════════════════════════════════════════════
     VIEW REVIEW MODAL
══════════════════════════════════════════════════════════ --}}
@if($showViewModal && $viewingReview)
<div class="hp-modal-bg" wire:click.self="closeModals">
    <div class="hp-modal hp-modal-xl">
        <div class="hp-modal-hd {{ $viewingReview->type === 'Self Evaluation' ? 'green-hd' : '' }}">
            <div class="hp-modal-hd-left">
                <div class="hp-modal-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <div>
                    <div class="hp-modal-title">{{ $viewingReview->type ?? 'Performance Review' }}</div>
                    <div class="hp-modal-sub">
                        {{ $viewingReview->employee ? trim(($viewingReview->employee->first_name??'').' '.($viewingReview->employee->last_name??'')) : '—' }}
                        · {{ $viewingReview->code }}
                    </div>
                </div>
            </div>
            <button class="hp-modal-close" wire:click="closeModals">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="hp-modal-body">
            @php
                $vrScore = (float)($viewingReview->overall_score ?? 0);
                $vrAp    = $viewingReview->approval_status instanceof \BackedEnum ? $viewingReview->approval_status->value : ($viewingReview->approval_status ?? 'draft');
                $vrApCls = match($vrAp){ 'approved'=>'hb-green','rejected'=>'hb-red','pending'=>'hb-amber',default=>'hb-gray' };
            @endphp

            {{-- Score strip --}}
            <div class="hp-fin-strip">
                <div class="hp-fin-card">
                    <div class="hp-fin-lbl">Overall Score</div>
                    <div class="hp-fin-val" style="color:var(--indigo);">{{ number_format($vrScore,2) }} <span style="font-size:12px;color:var(--ink4);font-family:'DM Sans',sans-serif;font-weight:500;">/ 5.0</span></div>
                </div>
                <div class="hp-fin-card">
                    <div class="hp-fin-lbl">Rating</div>
                    <div class="hp-fin-val" style="font-size:14px;color:var(--ink2);margin-top:6px;">{{ ucfirst(str_replace('_',' ',$viewingReview->overall_rating instanceof \BackedEnum ? $viewingReview->overall_rating->value : ($viewingReview->overall_rating??'—'))) }}</div>
                </div>
                <div class="hp-fin-card">
                    <div class="hp-fin-lbl">Approval</div>
                    <div style="margin-top:6px;"><span class="hp-badge {{ $vrApCls }}">{{ ucfirst($vrAp) }}</span></div>
                </div>
            </div>

            {{-- Details grid --}}
            <div class="hp-detail-grid">
                <div class="hp-detail-item"><div class="hp-detail-lbl">Employee</div><div class="hp-detail-val">{{ $viewingReview->employee ? trim(($viewingReview->employee->first_name??'').' '.($viewingReview->employee->last_name??'')) : '—' }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Department</div><div class="hp-detail-val">{{ $viewingReview->employee?->department?->name ?? '—' }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Review Type</div><div class="hp-detail-val">{{ $viewingReview->type }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Review Date</div><div class="hp-detail-val">{{ $viewingReview->review_date ? \Carbon\Carbon::parse($viewingReview->review_date)->format('M d, Y') : '—' }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Period Start</div><div class="hp-detail-val">{{ $viewingReview->review_period_start ? \Carbon\Carbon::parse($viewingReview->review_period_start)->format('M d, Y') : '—' }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Period End</div><div class="hp-detail-val">{{ $viewingReview->review_period_end ? \Carbon\Carbon::parse($viewingReview->review_period_end)->format('M d, Y') : '—' }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Reviewer</div><div class="hp-detail-val">{{ $viewingReview->reviewer ? trim(($viewingReview->reviewer->first_name??'').' '.($viewingReview->reviewer->last_name??'')) : 'Self' }}</div></div>
                <div class="hp-detail-item"><div class="hp-detail-lbl">Status</div><div class="hp-detail-val">{{ ucfirst($viewingReview->status ?? '—') }}</div></div>
            </div>

            {{-- Metric items --}}
            @if($viewingReview->items && $viewingReview->items->count())
                <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-top:2px;">Score Breakdown</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($viewingReview->items as $vi)
                        <div>
                            <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:600;color:var(--ink2);margin-bottom:4px;">
                                <span>{{ $vi->criteria }}</span>
                                <span style="color:var(--indigo);font-family:'Sora',sans-serif;font-weight:800;">{{ number_format($vi->score,1) }}/5</span>
                            </div>
                            <div class="hp-prog-bar"><div class="hp-prog-fill" style="width:{{ ($vi->score/5)*100 }}%;background:var(--indigo);"></div></div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Narrative --}}
            @if($viewingReview->strengths)
                <div>
                    <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:5px;">Strengths</div>
                    <div style="background:var(--bg);border:1px solid var(--border);border-radius:9px;padding:11px 13px;font-size:13px;color:var(--ink3);line-height:1.7;">{{ $viewingReview->strengths }}</div>
                </div>
            @endif
            @if($viewingReview->areas_for_improvement)
                <div>
                    <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:5px;">Areas for Improvement</div>
                    <div style="background:var(--bg);border:1px solid var(--border);border-radius:9px;padding:11px 13px;font-size:13px;color:var(--ink3);line-height:1.7;">{{ $viewingReview->areas_for_improvement }}</div>
                </div>
            @endif
            @if($viewingReview->development_plan)
                <div>
                    <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:5px;">Development Plan</div>
                    <div style="background:var(--bg);border:1px solid var(--border);border-radius:9px;padding:11px 13px;font-size:13px;color:var(--ink3);line-height:1.7;">{{ $viewingReview->development_plan }}</div>
                </div>
            @endif
            @if($viewingReview->employee_comments)
                <div>
                    <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--ink4);margin-bottom:5px;">Employee Comments</div>
                    <div style="background:var(--bg);border:1px solid var(--border);border-radius:9px;padding:11px 13px;font-size:13px;color:var(--ink3);line-height:1.7;">{{ $viewingReview->employee_comments }}</div>
                </div>
            @endif
        </div>

        <div class="hp-modal-footer">
            <button class="hp-btn hp-btn-outline" wire:click="closeModals">Close</button>
            <button class="hp-btn hp-btn-ghost" wire:click="openEditEval({{ $viewingReview->id }}); closeModals()">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </button>
            @if($vrAp !== 'approved')
                <button class="hp-btn hp-btn-green" wire:click="approveReview({{ $viewingReview->id }}); closeModals()"
                        wire:confirm="Approve this review?">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Approve
                </button>
            @endif
        </div>
    </div>
</div>
@endif


{{-- ══════════════════════════════════════════════════════════
     DELETE CONFIRM MODAL
══════════════════════════════════════════════════════════ --}}
@if($showDeleteModal)
<div class="hp-modal-bg" wire:click.self="closeModals">
    <div class="hp-modal hp-modal-sm">
        <div class="hp-del-body">
            <div class="hp-del-icon">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            </div>
            <div class="hp-del-ttl">Delete Review?</div>
            <div class="hp-del-sub">This will permanently remove the review and all its metric items. This action cannot be undone.</div>
        </div>
        <div class="hp-modal-footer" style="justify-content:center;gap:10px;">
            <button class="hp-btn hp-btn-outline" wire:click="closeModals">Cancel</button>
            <button class="hp-btn hp-btn-danger" wire:click="deleteReview" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                <span wire:loading.remove wire:target="deleteReview">Yes, Delete</span>
                <span wire:loading wire:target="deleteReview">Deleting…</span>
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function hpTab(name) {
    ['reviews','self','goals'].forEach(function(t) {
        var el = document.getElementById('tab-' + t);
        var btn = document.getElementById('tab-' + t + '-btn');
        if (el)  el.style.display  = t === name ? 'block' : 'none';
        if (btn) btn.classList.toggle('active', t === name);
    });
}
</script>
@endpush