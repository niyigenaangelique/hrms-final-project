<div class="pf-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.pf-root {
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
    --shadow-md:0 6px 28px rgba(59,111,232,0.12);
    --r:        12px;
    --r-lg:     18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
}

/* ══ Shell ═══════════════════════════════════════════════ */
.pf-shell { display:flex; min-height:100vh; }

/* ══ LEFT SIDEBAR NAV ════════════════════════════════════ */
.pf-sidenav {
    width: 220px; min-width: 220px;
    background: var(--white);
    border-right: 1px solid var(--border);
    display: flex; flex-direction: column;
    padding: 28px 14px; gap: 3px;
    position: sticky; top: 0; height: 100vh;
    overflow-y: auto; flex-shrink: 0;
}
.pf-sidenav-label {
    font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--ink4); padding: 12px 10px 5px;
}
.pf-sidenav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: 10px;
    font-size: 13.5px; font-weight: 600; color: var(--ink3);
    cursor: pointer; border: none; background: transparent;
    font-family: 'DM Sans', sans-serif; width: 100%;
    text-align: left; transition: background 0.15s, color 0.15s;
}
.pf-sidenav-item svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; opacity: 0.75; }
.pf-sidenav-item:hover { background: var(--blue-lt); color: var(--blue); }
.pf-sidenav-item.active { background: var(--blue); color: #fff; font-weight: 700; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.pf-sidenav-item.active svg { opacity: 1; }
.pf-sidenav-badge {
    margin-left: auto; background: rgba(239,68,68,0.12); color: #DC2626;
    font-size: 10px; font-weight: 800; padding: 1px 7px; border-radius: 100px;
}
.pf-sidenav-item.active .pf-sidenav-badge { background: rgba(255,255,255,0.25); color: #fff; }

/* ══ MAIN ════════════════════════════════════════════════ */
.pf-main { flex:1; min-width:0; padding: 28px 28px 80px; display:flex; flex-direction:column; gap:20px; }

/* ══ FLASH ═══════════════════════════════════════════════ */
.pf-flash { padding:12px 18px; border-radius:var(--r); font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:9px; }
.pf-flash-ok  { background:var(--green-lt); border:1px solid rgba(18,183,106,0.22); color:#087A42; }
.pf-flash-err { background:var(--red-lt);   border:1px solid rgba(239,68,68,0.22);  color:#991B1B; }
.pf-flash svg { width:15px; height:15px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.pf-page-hero {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.pf-page-hero-cover {
    height: 72px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.pf-page-hero-cover::before {
    content:''; position:absolute; top:-30px; right:80px;
    width:180px; height:180px; border-radius:50%;
    background:rgba(255,255,255,0.06);
}
.pf-page-hero-body {
    padding: 16px 24px 20px;
    display: flex; align-items: flex-end; justify-content: space-between; gap:16px;
    margin-top: -18px;
}
.pf-page-hero-icon {
    width: 56px; height: 56px; border-radius: 16px;
    background: linear-gradient(135deg, var(--blue), #6B4FDB);
    border: 3px solid var(--white);
    box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pf-page-hero-icon svg { width:24px; height:24px; stroke:#fff; fill:none; stroke-width:1.75; }
.pf-page-hero-text { padding-bottom:2px; }
.pf-page-hero-title { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink); margin-bottom:3px; }
.pf-page-hero-sub { font-size:13px; color:var(--ink3); font-weight:500; }
.pf-page-hero-actions { display:flex; gap:8px; align-items:flex-end; padding-bottom:2px; }

/* Stat strip */
.pf-stat-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:1px; background:var(--border); border-radius:0 0 var(--r-lg) var(--r-lg); overflow:hidden; }
.pf-stat-cell { background:var(--white); padding:13px 18px; display:flex; flex-direction:column; gap:2px; }
.pf-stat-cell-label { font-size:10.5px; font-weight:700; color:var(--ink4); text-transform:uppercase; letter-spacing:0.07em; }
.pf-stat-cell-val { font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--blue-2); }
.pf-stat-cell-sub { font-size:11px; color:var(--ink4); font-weight:500; }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.pf-btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; border-radius:var(--r);
    font-family:'DM Sans',sans-serif; font-size:13px; font-weight:700;
    border:none; cursor:pointer; transition:all 0.15s; text-decoration:none;
}
.pf-btn svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }
.pf-btn-primary { background:var(--blue); color:#fff; box-shadow:0 4px 12px rgba(59,111,232,0.28); }
.pf-btn-primary:hover { background:var(--blue-2); transform:translateY(-1px); }
.pf-btn-outline { background:var(--white); color:var(--ink2); border:1px solid var(--border); }
.pf-btn-outline:hover { border-color:var(--blue); color:var(--blue); background:var(--blue-lt); }
.pf-btn-ghost { background:var(--blue-lt); color:var(--blue); border:1px solid var(--blue-brd); }
.pf-btn-ghost:hover { background:var(--blue-mid); }
.pf-btn-green { background:var(--green-lt); color:#087A42; border:1px solid rgba(18,183,106,0.25); }
.pf-btn-green:hover { background:rgba(18,183,106,0.18); }
.pf-btn-danger { background:var(--red-lt); color:var(--red); border:1px solid rgba(239,68,68,0.22); }
.pf-btn-danger:hover { background:rgba(239,68,68,0.16); }
.pf-btn-sm { padding:6px 12px; font-size:12px; }

/* ══ BADGES ══════════════════════════════════════════════ */
.pf-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:100px; font-size:11.5px; font-weight:700; flex-shrink:0; }
.pf-badge svg { width:9px; height:9px; stroke:currentColor; fill:none; stroke-width:2.5; }
.pf-badge-green  { background:var(--green-lt);  color:#087A42; }
.pf-badge-blue   { background:var(--blue-lt);   color:var(--blue-2); }
.pf-badge-gray   { background:var(--bg);         color:var(--ink3); border:1px solid var(--border); }
.pf-badge-amber  { background:var(--amber-lt);  color:#92400E; }
.pf-badge-red    { background:var(--red-lt);    color:#991B1B; }
.pf-badge-purple { background:var(--purple-lt); color:var(--purple); }

/* ══ SECTION TOOLBAR ═════════════════════════════════════ */
.pf-toolbar { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:20px; gap:16px; }
.pf-toolbar-title { font-family:'Sora',sans-serif; font-size:17px; font-weight:800; color:var(--ink); }
.pf-toolbar-sub { font-size:12.5px; color:var(--ink4); font-weight:500; margin-top:2px; }
.pf-toolbar-actions { display:flex; gap:8px; flex-shrink:0; }

/* ══ OVERVIEW — 2 col ════════════════════════════════════ */
.pf-ov-grid { display:grid; grid-template-columns:1fr 280px; gap:20px; align-items:start; }
.pf-ov-left { display:flex; flex-direction:column; gap:20px; }
.pf-ov-right { display:flex; flex-direction:column; gap:20px; }

/* ══ SCORE RING CARD ═════════════════════════════════════ */
.pf-score-card {
    background: var(--white); border-radius:var(--r-lg);
    border:1px solid var(--border); box-shadow:var(--shadow);
    padding:24px; text-align:center;
}
.pf-score-ring-wrap { position:relative; width:120px; height:120px; margin:0 auto 14px; }
.pf-score-ring-wrap svg { width:120px; height:120px; transform:rotate(-90deg); }
.pf-score-ring-bg { fill:none; stroke:var(--bg); stroke-width:10; }
.pf-score-ring-fill { fill:none; stroke:var(--blue); stroke-width:10; stroke-linecap:round; transition:stroke-dashoffset 0.8s ease; }
.pf-score-ring-text { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.pf-score-ring-num { font-family:'Sora',sans-serif; font-size:26px; font-weight:800; color:var(--ink); line-height:1; }
.pf-score-ring-max { font-size:11px; color:var(--ink4); font-weight:600; }
.pf-score-label { font-size:12.5px; font-weight:700; color:var(--ink3); }
.pf-score-rating { font-family:'Sora',sans-serif; font-size:15px; font-weight:800; color:var(--blue-2); margin-top:4px; }

/* ══ METRIC BARS ═════════════════════════════════════════ */
.pf-metrics-card {
    background:var(--white); border-radius:var(--r-lg);
    border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden;
}
.pf-metrics-hd {
    padding:16px 20px; border-bottom:1px solid var(--border);
    font-size:12px; font-weight:800; text-transform:uppercase;
    letter-spacing:0.09em; color:var(--ink3);
    display:flex; align-items:center; gap:6px;
}
.pf-metrics-hd svg { width:13px; height:13px; stroke:var(--blue); fill:none; stroke-width:2; }
.pf-metrics-body { padding:18px 20px; display:flex; flex-direction:column; gap:14px; }
.pf-metric-row { display:flex; flex-direction:column; gap:5px; }
.pf-metric-top { display:flex; align-items:center; justify-content:space-between; }
.pf-metric-label { font-size:13px; font-weight:600; color:var(--ink2); }
.pf-metric-score {
    font-family:'Sora',sans-serif; font-size:13px; font-weight:800; color:var(--blue-2);
    background:var(--blue-lt); padding:2px 8px; border-radius:6px;
}
.pf-metric-bar { height:7px; border-radius:100px; background:var(--bg); overflow:hidden; }
.pf-metric-fill { height:100%; border-radius:100px; transition:width 0.7s ease; }
.fill-blue   { background: linear-gradient(90deg, var(--blue-2), var(--blue)); }
.fill-green  { background: linear-gradient(90deg, #087A42, var(--green)); }
.fill-amber  { background: linear-gradient(90deg, #92400E, var(--amber)); }
.fill-purple { background: linear-gradient(90deg, #5B21B6, var(--purple)); }

/* ══ REVIEW CARD ═════════════════════════════════════════ */
.pf-review-card {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-lg); overflow:hidden; box-shadow:var(--shadow);
    margin-bottom:14px; transition:box-shadow 0.18s, border-color 0.18s;
}
.pf-review-card:hover { box-shadow:var(--shadow-md); border-color:var(--blue-brd); }
.pf-review-card:last-child { margin-bottom:0; }

.pf-review-hd {
    background:linear-gradient(105deg, var(--blue-3) 0%, var(--blue) 100%);
    padding:16px 22px; display:flex; align-items:center; justify-content:space-between; gap:12px;
}
.pf-review-hd-left { display:flex; align-items:center; gap:12px; }
.pf-review-icon {
    width:42px; height:42px; border-radius:12px;
    background:rgba(255,255,255,0.18);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pf-review-icon svg { width:20px; height:20px; stroke:#fff; fill:none; stroke-width:1.75; }
.pf-review-type { font-family:'Sora',sans-serif; font-size:14px; font-weight:800; color:#fff; margin-bottom:2px; }
.pf-review-period { font-size:11.5px; color:rgba(255,255,255,0.70); font-weight:600; }
.pf-review-score-pill {
    background:rgba(255,255,255,0.18); border:1px solid rgba(255,255,255,0.25);
    border-radius:100px; padding:6px 14px;
    display:flex; align-items:center; gap:8px;
}
.pf-review-score-num { font-family:'Sora',sans-serif; font-size:18px; font-weight:800; color:#fff; }
.pf-review-score-label { font-size:11px; color:rgba(255,255,255,0.75); font-weight:600; }

.pf-review-body { padding:18px 22px; }
.pf-review-meta {
    display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:16px;
}
.pf-review-meta-item label { display:block; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.09em; color:var(--ink4); margin-bottom:3px; }
.pf-review-meta-item p { font-size:13px; font-weight:700; color:var(--ink2); margin:0; }

.pf-review-metrics { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin-bottom:14px; }
.pf-review-metric-chip {
    background:var(--bg); border:1px solid var(--border);
    border-radius:10px; padding:10px 12px; text-align:center;
}
.pf-review-metric-chip-label { font-size:10.5px; font-weight:700; color:var(--ink4); margin-bottom:4px; }
.pf-review-metric-chip-val { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--blue-2); }
.pf-review-metric-chip-stars { display:flex; justify-content:center; gap:2px; margin-top:2px; }
.pf-review-metric-chip-stars span { font-size:9px; }

.pf-review-footer {
    padding:12px 22px; border-top:1px solid var(--border);
    background:var(--bg); display:flex; align-items:center; justify-content:space-between;
}
.pf-review-reviewer { display:flex; align-items:center; gap:8px; }
.pf-reviewer-av {
    width:28px; height:28px; border-radius:50%;
    background:linear-gradient(135deg, var(--blue), #6B4FDB);
    display:flex; align-items:center; justify-content:center;
    font-size:10px; font-weight:800; color:#fff;
}
.pf-reviewer-name { font-size:12px; font-weight:700; color:var(--ink2); }
.pf-reviewer-role { font-size:10.5px; color:var(--ink4); font-weight:500; }

/* ══ GOAL CARD ═══════════════════════════════════════════ */
.pf-goal-card {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-lg); overflow:hidden; box-shadow:var(--shadow);
    margin-bottom:14px; transition:box-shadow 0.18s, border-color 0.18s;
}
.pf-goal-card:hover { box-shadow:var(--shadow-md); border-color:var(--blue-brd); }
.pf-goal-card:last-child { margin-bottom:0; }

.pf-goal-hd { padding:16px 20px; display:flex; align-items:flex-start; gap:14px; border-bottom:1px solid var(--border); }
.pf-goal-icon-wrap {
    width:44px; height:44px; border-radius:13px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
}
.pf-goal-icon-wrap svg { width:20px; height:20px; stroke:currentColor; fill:none; stroke-width:1.75; }
.pf-goal-title { font-family:'Sora',sans-serif; font-size:15px; font-weight:800; color:var(--ink); margin-bottom:4px; }
.pf-goal-desc { font-size:13px; color:var(--ink3); font-weight:500; line-height:1.5; }

.pf-goal-body { padding:14px 20px; }
.pf-goal-meta { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:14px; }
.pf-goal-meta-item label { display:block; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); margin-bottom:3px; }
.pf-goal-meta-item p { font-size:12.5px; font-weight:700; color:var(--ink2); margin:0; display:flex; align-items:center; gap:5px; }
.pf-goal-meta-item p svg { width:11px; height:11px; stroke:var(--blue); fill:none; stroke-width:2; }

.pf-goal-progress-wrap { }
.pf-goal-progress-top { display:flex; justify-content:space-between; font-size:11px; font-weight:700; color:var(--ink4); margin-bottom:5px; }
.pf-goal-bar { height:8px; border-radius:100px; background:var(--bg); border:1px solid var(--border); overflow:hidden; }
.pf-goal-bar-fill { height:100%; border-radius:100px; background:linear-gradient(90deg, var(--blue-2), var(--blue)); transition:width 0.6s ease; }
.pf-goal-bar-fill.green  { background:linear-gradient(90deg, #087A42, var(--green)); }
.pf-goal-bar-fill.amber  { background:linear-gradient(90deg, #92400E, var(--amber)); }

.pf-goal-footer {
    padding:12px 20px; border-top:1px solid var(--border);
    background:var(--bg); display:flex; align-items:center; justify-content:space-between;
}

/* ══ ACHIEVEMENT CARD ════════════════════════════════════ */
.pf-ach-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:14px; }
.pf-ach-card {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-lg); padding:18px 16px; text-align:center;
    box-shadow:var(--shadow); transition:box-shadow 0.18s, border-color 0.18s;
    display:flex; flex-direction:column; align-items:center; gap:10px;
}
.pf-ach-card:hover { box-shadow:var(--shadow-md); border-color:var(--blue-brd); }
.pf-ach-badge-wrap {
    width:56px; height:56px; border-radius:50%;
    background:linear-gradient(135deg, var(--blue-lt), var(--blue-mid));
    border:2px solid var(--blue-brd);
    display:flex; align-items:center; justify-content:center;
}
.pf-ach-badge-wrap svg { width:26px; height:26px; stroke:var(--blue); fill:none; stroke-width:1.75; }
.pf-ach-name { font-family:'Sora',sans-serif; font-size:13px; font-weight:800; color:var(--ink); }
.pf-ach-date { font-size:11px; color:var(--ink4); font-weight:500; }
.pf-ach-desc { font-size:12px; color:var(--ink3); font-weight:500; line-height:1.5; }

/* ══ SELF EVAL CARD (right panel) ════════════════════════ */
.pf-selfeval-prompt {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-lg); box-shadow:var(--shadow); overflow:hidden;
}
.pf-selfeval-prompt-hd {
    background:linear-gradient(135deg, var(--purple-lt), var(--blue-lt));
    border-bottom:1px solid var(--border);
    padding:16px 18px; display:flex; align-items:center; gap:10px;
}
.pf-selfeval-prompt-icon {
    width:36px; height:36px; border-radius:10px;
    background:var(--purple-lt); border:1px solid rgba(124,58,237,0.20);
    display:flex; align-items:center; justify-content:center;
}
.pf-selfeval-prompt-icon svg { width:18px; height:18px; stroke:var(--purple); fill:none; stroke-width:2; }
.pf-selfeval-prompt-title { font-family:'Sora',sans-serif; font-size:13.5px; font-weight:800; color:var(--ink); }
.pf-selfeval-prompt-sub { font-size:11.5px; color:var(--ink4); font-weight:500; }
.pf-selfeval-prompt-body { padding:16px 18px; display:flex; flex-direction:column; gap:10px; }
.pf-selfeval-prompt-body p { font-size:13px; color:var(--ink3); font-weight:500; line-height:1.6; }

/* Quick stats right panel */
.pf-quick-stat {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-lg); box-shadow:var(--shadow); overflow:hidden;
}
.pf-quick-stat-hd {
    padding:14px 18px; border-bottom:1px solid var(--border);
    font-size:12px; font-weight:800; text-transform:uppercase;
    letter-spacing:0.09em; color:var(--ink3);
    display:flex; align-items:center; gap:6px;
}
.pf-quick-stat-hd svg { width:13px; height:13px; stroke:var(--blue); fill:none; stroke-width:2; }
.pf-quick-stat-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:12px 18px; border-bottom:1px solid var(--border);
    font-size:13px;
}
.pf-quick-stat-row:last-child { border-bottom:none; }
.pf-quick-stat-row-label { font-weight:600; color:var(--ink3); }
.pf-quick-stat-row-val { font-family:'Sora',sans-serif; font-weight:800; color:var(--blue-2); font-size:14px; }

/* ══ EMPTY STATE ═════════════════════════════════════════ */
.pf-empty { text-align:center; padding:48px 24px; }
.pf-empty svg { width:40px; height:40px; stroke:var(--ink4); fill:none; stroke-width:1.5; margin:0 auto 12px; display:block; opacity:0.4; }
.pf-empty strong { display:block; font-size:15px; font-weight:700; color:var(--ink3); margin-bottom:4px; }
.pf-empty p { font-size:13px; color:var(--ink4); font-weight:500; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.pf-modal-bg {
    position:fixed; inset:0; background:rgba(15,22,41,0.52);
    backdrop-filter:blur(8px); z-index:9999;
    display:flex; align-items:center; justify-content:center; padding:16px;
}
.pf-modal {
    background:var(--white); border-radius:var(--r-lg);
    box-shadow:0 24px 64px rgba(15,22,41,0.22);
    border:1px solid var(--border);
    width:100%; max-width:540px; max-height:90vh; overflow-y:auto;
}
.pf-modal-wide { max-width:680px; }
.pf-modal-hd {
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 24px; border-bottom:1px solid var(--border);
    position:sticky; top:0; background:var(--white); z-index:1;
}
.pf-modal-title { font-family:'Sora',sans-serif; font-size:16px; font-weight:800; color:var(--ink); }
.pf-modal-close {
    width:30px; height:30px; border-radius:8px;
    background:var(--bg); border:1px solid var(--border);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all 0.15s; color:var(--ink3);
}
.pf-modal-close:hover { background:var(--red-lt); color:var(--red); border-color:rgba(239,68,68,0.22); }
.pf-modal-close svg { width:14px; height:14px; stroke:currentColor; fill:none; stroke-width:2.5; }
.pf-modal-body { padding:24px; }
.pf-modal-footer { display:flex; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid var(--border); }

/* Review detail modal */
.pf-modal-section-title {
    font-size:11px; font-weight:800; text-transform:uppercase;
    letter-spacing:0.09em; color:var(--ink4);
    margin:20px 0 10px; display:flex; align-items:center; gap:6px;
}
.pf-modal-section-title:first-child { margin-top:0; }
.pf-modal-section-title svg { width:12px; height:12px; stroke:var(--blue); fill:none; stroke-width:2; }
.pf-modal-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px; }
.pf-modal-info-item label { display:block; font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); margin-bottom:3px; }
.pf-modal-info-item p { font-size:13.5px; font-weight:600; color:var(--ink2); margin:0; }
.pf-modal-text-block {
    background:var(--bg); border:1px solid var(--border);
    border-radius:var(--r); padding:12px 14px;
    font-size:13.5px; color:var(--ink2); font-weight:500; line-height:1.6; margin-bottom:12px;
}
.pf-modal-text-block:last-child { margin-bottom:0; }

/* ══ FORM FIELDS ═════════════════════════════════════════ */
.pf-field { margin-bottom:14px; }
.pf-field:last-child { margin-bottom:0; }
.pf-field label { display:block; font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.09em; color:var(--ink4); margin-bottom:5px; }
.pf-field input, .pf-field select, .pf-field textarea {
    width:100%; box-sizing:border-box; padding:10px 13px;
    background:var(--bg); border:1.5px solid var(--border);
    border-radius:var(--r); font-family:'DM Sans',sans-serif;
    font-size:13.5px; font-weight:500; color:var(--ink);
    outline:none; transition:border-color 0.15s, box-shadow 0.15s;
}
.pf-field input:focus, .pf-field select:focus, .pf-field textarea:focus {
    border-color:var(--blue); box-shadow:0 0 0 3px rgba(59,111,232,0.10); background:var(--white);
}
.pf-field textarea { resize:vertical; min-height:80px; }
.pf-field-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.pf-field-error { font-size:11.5px; color:var(--red); margin-top:4px; font-weight:600; }

/* Star rating slider */
.pf-rating-row { display:flex; flex-direction:column; gap:6px; margin-bottom:12px; }
.pf-rating-label { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink4); }
.pf-rating-ctrl { display:flex; align-items:center; gap:10px; }
.pf-rating-stars { display:flex; gap:4px; }
.pf-rating-star { font-size:18px; cursor:pointer; color:var(--ink4); transition:color 0.15s; }
.pf-rating-star.filled { color:var(--amber); }
.pf-rating-val {
    font-family:'Sora',sans-serif; font-size:14px; font-weight:800; color:var(--blue-2);
    background:var(--blue-lt); padding:2px 9px; border-radius:7px; min-width:36px; text-align:center;
}
.pf-rating-range { width:100%; accent-color:var(--blue); }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width:1100px) {
    .pf-ov-grid { grid-template-columns:1fr; }
    .pf-ov-right { flex-direction:row; flex-wrap:wrap; }
    .pf-ov-right > * { flex:1; min-width:220px; }
    .pf-stat-strip { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:840px) {
    .pf-sidenav { width:56px; min-width:56px; padding:20px 8px; }
    .pf-sidenav-label { display:none; }
    .pf-sidenav-item span { display:none; }
    .pf-sidenav-item { justify-content:center; padding:10px; }
    .pf-main { padding:16px 16px 80px; }
    .pf-review-meta,.pf-review-metrics { grid-template-columns:1fr 1fr; }
    .pf-goal-meta { grid-template-columns:1fr 1fr; }
}
@media (max-width:600px) {
    .pf-shell { flex-direction:column; }
    .pf-sidenav { width:100%; min-width:unset; height:auto; flex-direction:row; padding:10px; overflow-x:auto; position:static; }
    .pf-sidenav-label { display:none; }
    .pf-sidenav-item { flex-direction:column; gap:3px; padding:8px 10px; font-size:10px; min-width:56px; }
    .pf-sidenav-item span { display:block; font-size:10px; }
    .pf-stat-strip { grid-template-columns:1fr 1fr; }
    .pf-review-metrics { grid-template-columns:1fr 1fr; }
}
</style>

<div class="pf-shell">

{{-- ══ LEFT SIDEBAR NAV ══════════════════════════════════ --}}
<aside class="pf-sidenav">
    <div class="pf-sidenav-label">Performance</div>

    <button class="pf-sidenav-item {{ ($activeSection ?? 'overview') === 'overview' ? 'active' : '' }}"
            wire:click="$set('activeSection','overview')">
        <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        <span>Overview</span>
    </button>

    <button class="pf-sidenav-item {{ ($activeSection ?? '') === 'reviews' ? 'active' : '' }}"
            wire:click="$set('activeSection','reviews')">
        <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        <span>Reviews</span>
        @if(isset($performanceReviews) && $performanceReviews && $performanceReviews->count())
            <span class="pf-sidenav-badge">{{ $performanceReviews->count() }}</span>
        @endif
    </button>

    <div class="pf-sidenav-label">Goals</div>

    <button class="pf-sidenav-item {{ ($activeSection ?? '') === 'goals' ? 'active' : '' }}"
            wire:click="$set('activeSection','goals')">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
        <span>My Goals</span>
        @if(isset($goals) && $goals && $goals->count())
            <span class="pf-sidenav-badge">{{ $goals->count() }}</span>
        @endif
    </button>

    <div class="pf-sidenav-label">Recognition</div>

    <button class="pf-sidenav-item {{ ($activeSection ?? '') === 'achievements' ? 'active' : '' }}"
            wire:click="$set('activeSection','achievements')">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        <span>Achievements</span>
    </button>
</aside>

{{-- ══ MAIN CONTENT ═══════════════════════════════════════ --}}
<div class="pf-main">

    {{-- Flash --}}
    @if(session()->has('success'))
        <div class="pf-flash pf-flash-ok">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="pf-flash pf-flash-err">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- PAGE HERO --}}
    <div class="pf-page-hero">
        <div class="pf-page-hero-cover"></div>
        <div class="pf-page-hero-body">
            <div style="display:flex;align-items:flex-end;gap:14px;">
                <div class="pf-page-hero-icon">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <div class="pf-page-hero-text">
                    <div class="pf-page-hero-title">My Performance</div>
                    <div class="pf-page-hero-sub">
                        {{ $employee->full_name ?? 'Employee' }} &nbsp;·&nbsp;
                        <strong>{{ \App\Models\Position::find($employee->position_id)?->name ?? 'No Position' }}</strong>
                                    &nbsp;·&nbsp;
                                    {{ \App\Models\Department::find($employee->department_id)?->name ?? 'No Department' }}
                    </div>
                </div>
            </div>
            <div class="pf-page-hero-actions">
                <button class="pf-btn pf-btn-primary" wire:click="openSelfEvaluationForm">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Self Evaluation
                    </button>
                <button class="pf-btn pf-btn-primary pf-btn-sm" wire:click="openGoalForm">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Goal
                </button>
            </div>
        </div>
        <div class="pf-stat-strip">
            <div class="pf-stat-cell">
                <div class="pf-stat-cell-label">Reviews</div>
                <div class="pf-stat-cell-val">{{ isset($performanceReviews) && $performanceReviews ? $performanceReviews->count() : '0' }}</div>
                <div class="pf-stat-cell-sub">Total completed</div>
            </div>
            <div class="pf-stat-cell">
                <div class="pf-stat-cell-label">Active Goals</div>
                <div class="pf-stat-cell-val">{{ isset($goals) && $goals ? $goals->where('status','active')->count() : '0' }}</div>
                <div class="pf-stat-cell-sub">In progress</div>
            </div>
            <div class="pf-stat-cell">
                <div class="pf-stat-cell-label">Avg Score</div>
                <div class="pf-stat-cell-val">
                    {{ isset($performanceReviews) && $performanceReviews && $performanceReviews->count() ? number_format($performanceReviews->avg('overall_score'), 1) : '—' }}
                </div>
                <div class="pf-stat-cell-sub">Out of 5.0</div>
            </div>
            <div class="pf-stat-cell">
                <div class="pf-stat-cell-label">Achievements</div>
                <div class="pf-stat-cell-val">{{ isset($achievements) && $achievements ? $achievements->count() : '0' }}</div>
                <div class="pf-stat-cell-sub">Earned badges</div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════
         OVERVIEW SECTION
    ════════════════════════════════════════════════════ --}}
    @if(($activeSection ?? 'overview') === 'overview')

    @php
        $latestReview = isset($performanceReviews) && $performanceReviews ? $performanceReviews->first() : null;
        $avgScore = isset($performanceReviews) && $performanceReviews && $performanceReviews->count() ? $performanceReviews->avg('overall_score') : 0;
        $pct = round(($avgScore / 5) * 100);

        $metrics = [];
        if ($latestReview && $latestReview->items && $latestReview->items->count()) {
            foreach ($latestReview->items as $item) {
                $metrics[] = ['label' => $item->criteria, 'score' => $item->score];
            }
        } else {
            $metrics = [
                ['label'=>'Technical Skills',  'score'=>0],
                ['label'=>'Communication',     'score'=>0],
                ['label'=>'Teamwork',          'score'=>0],
                ['label'=>'Leadership',        'score'=>0],
                ['label'=>'Problem Solving',   'score'=>0],
                ['label'=>'Time Management',   'score'=>0],
            ];
        }
        $fillColors = ['fill-blue','fill-green','fill-blue','fill-purple','fill-green','fill-amber'];
    @endphp

    <div class="pf-ov-grid">
        {{-- LEFT --}}
        <div class="pf-ov-left">

            {{-- Metric bars card --}}
            <div class="pf-metrics-card">
                <div class="pf-metrics-hd">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Performance Metrics
                    @if($latestReview)
                        <span class="pf-badge pf-badge-blue" style="margin-left:auto;">{{ $latestReview->type ?? 'Latest Review' }}</span>
                    @endif
                </div>
                <div class="pf-metrics-body">
                    @foreach($metrics as $i => $m)
                        <div class="pf-metric-row">
                            <div class="pf-metric-top">
                                <span class="pf-metric-label">{{ $m['label'] }}</span>
                                <span class="pf-metric-score">{{ number_format($m['score'],1) }} / 5</span>
                            </div>
                            <div class="pf-metric-bar">
                                <div class="pf-metric-fill {{ $fillColors[$i % count($fillColors)] }}"
                                     style="width:{{ ($m['score']/5)*100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    @if(!$latestReview)
                        <div style="text-align:center;padding:20px 0;color:var(--ink4);font-size:13px;font-weight:500;">
                            No review data yet. Submit a self-evaluation to see your metrics.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Latest review card preview --}}
            @if($latestReview)
            <div style="background:var(--white);border-radius:var(--r-lg);border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                    <div style="font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:0.09em;color:var(--ink3);display:flex;align-items:center;gap:6px;">
                        <svg style="width:13px;height:13px;stroke:var(--blue);fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Latest Review
                    </div>
                    <button class="pf-btn pf-btn-ghost pf-btn-sm" wire:click="viewReview('{{ $latestReview->id }}')">View Details</button>
                </div>
                <div style="padding:18px 20px;">
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                        <div>
                            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--ink4);margin-bottom:4px;">Type</div>
                            <div style="font-size:13px;font-weight:700;color:var(--ink2);">{{ $latestReview->type ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--ink4);margin-bottom:4px;">Date</div>
                            <div style="font-size:13px;font-weight:700;color:var(--ink2);">{{ $latestReview->review_date ? $latestReview->review_date->format('M d, Y') : '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--ink4);margin-bottom:4px;">Score</div>
                            <div style="font-size:13px;font-weight:700;color:var(--blue-2);">{{ $latestReview->overall_score ? number_format($latestReview->overall_score,1) : '—' }} / 5</div>
                        </div>
                    </div>
                    @if($latestReview->strengths)
                    <div style="margin-top:14px;background:var(--bg);border-radius:var(--r);padding:12px 14px;font-size:13px;color:var(--ink3);font-weight:500;line-height:1.6;">
                        <strong style="color:var(--ink2);">Strengths:</strong> {{ Str::limit($latestReview->strengths, 180) }}
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Goals snapshot --}}
            <div style="background:var(--white);border-radius:var(--r-lg);border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                    <div style="font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:0.09em;color:var(--ink3);display:flex;align-items:center;gap:6px;">
                        <svg style="width:13px;height:13px;stroke:var(--blue);fill:none;stroke-width:2;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        Active Goals
                    </div>
                    <button class="pf-btn pf-btn-primary pf-btn-sm" wire:click="openGoalForm">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Add Goal
                    </button>
                </div>
                @if(isset($goals) && $goals && $goals->where('status','active')->count())
                    @foreach(isset($goals) && $goals ? $goals->where('status','active')->take(3) : collect() as $goal)
                    <div style="padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;">
                        <div style="width:8px;height:8px;border-radius:50%;background:var(--blue);flex-shrink:0;"></div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:700;color:var(--ink2);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $goal->title }}</div>
                            <div style="font-size:11px;color:var(--ink4);font-weight:500;margin-top:2px;">Due {{ $goal->end_date ? \Carbon\Carbon::parse($goal->end_date)->format('M d, Y') : 'No deadline' }}</div>
                        </div>
                        <div style="width:60px;height:6px;border-radius:100px;background:var(--bg);overflow:hidden;flex-shrink:0;">
                            <div style="height:100%;border-radius:100px;background:var(--blue);width:{{ $goal->progress_percentage ?? 0 }}%;"></div>
                        </div>
                        <span style="font-size:11px;font-weight:800;color:var(--blue-2);">{{ $goal->progress_percentage ?? 0 }}%</span>
                    </div>
                    @endforeach
                    @if($goals->where('status','active')->count() > 3)
                    <div style="padding:12px 20px;text-align:center;">
                        <button class="pf-btn pf-btn-ghost pf-btn-sm" wire:click="$set('activeSection','goals')">
                            View all {{ $goals->where('status','active')->count() }} goals
                        </button>
                    </div>
                    @endif
                @else
                    <div class="pf-empty" style="padding:28px;">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <strong>No active goals</strong>
                        <p>Set goals to track your progress</p>
                    </div>
                @endif
            </div>

        </div>{{-- /ov-left --}}

        {{-- RIGHT --}}
        <div class="pf-ov-right">

            {{-- Score ring --}}
            <div class="pf-score-card">
                <div class="pf-score-ring-wrap">
                    <svg viewBox="0 0 120 120">
                        <circle class="pf-score-ring-bg" cx="60" cy="60" r="50"/>
                        <circle class="pf-score-ring-fill" cx="60" cy="60" r="50"
                            stroke-dasharray="{{ round(2 * 3.14159 * 50) }}"
                            stroke-dashoffset="{{ round(2 * 3.14159 * 50 * (1 - $pct/100)) }}"
                            id="scoreRing"/>
                    </svg>
                    <div class="pf-score-ring-text">
                        <div class="pf-score-ring-num">{{ number_format($avgScore,1) }}</div>
                        <div class="pf-score-ring-max">/ 5.0</div>
                    </div>
                </div>
                <div class="pf-score-label">Overall Performance Score</div>
                <div class="pf-score-rating">
                    @if($avgScore >= 4.5) Outstanding
                    @elseif($avgScore >= 3.5) Good
                    @elseif($avgScore >= 2.5) Satisfactory
                    @elseif($avgScore > 0) Needs Improvement
                    @else No Data Yet
                    @endif
                </div>
            </div>

            {{-- Quick stats --}}
            <div class="pf-quick-stat">
                <div class="pf-quick-stat-hd">
                    <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Quick Stats
                </div>
                <div class="pf-quick-stat-row">
                    <span class="pf-quick-stat-row-label">Completed Goals</span>
                    <span class="pf-quick-stat-row-val">{{ isset($goals) && $goals ? $goals->where('status','completed')->count() : '0' }}</span>
                </div>
                <div class="pf-quick-stat-row">
                    <span class="pf-quick-stat-row-label">On Hold</span>
                    <span class="pf-quick-stat-row-val">{{ isset($goals) && $goals ? $goals->where('status','on_hold')->count() : '0' }}</span>
                </div>
                <div class="pf-quick-stat-row">
                    <span class="pf-quick-stat-row-label">Self Reviews</span>
                    <span class="pf-quick-stat-row-val">{{ isset($performanceReviews) && $performanceReviews ? $performanceReviews->where('type','Self Evaluation')->count() : '0' }}</span>
                </div>
                <div class="pf-quick-stat-row">
                    <span class="pf-quick-stat-row-label">Manager Reviews</span>
                    <span class="pf-quick-stat-row-val">{{ isset($performanceReviews) && $performanceReviews ? $performanceReviews->where('type','!=','Self Evaluation')->count() : '0' }}</span>
                </div>
            </div>

            {{-- Self eval prompt --}}
            <div class="pf-selfeval-prompt">
                <div class="pf-selfeval-prompt-hd">
                    <div class="pf-selfeval-prompt-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </div>
                    <div>
                        <div class="pf-selfeval-prompt-title">Self Evaluation</div>
                        <div class="pf-selfeval-prompt-sub">Rate your own performance</div>
                    </div>
                </div>
                <div class="pf-selfeval-prompt-body">
                    <p>Submit a self-evaluation to help your manager understand your perspective and track your growth over time.</p>
                    <button class="pf-btn pf-btn-primary" style="width:100%;justify-content:center;" wire:click="openSelfEvaluationForm">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Start Self Evaluation
                    </button>
                </div>
            </div>

        </div>{{-- /ov-right --}}
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         REVIEWS SECTION
    ════════════════════════════════════════════════════ --}}
    @if(($activeSection ?? '') === 'reviews')
    <div class="pf-toolbar">
        <div>
            <div class="pf-toolbar-title">Performance Reviews</div>
            <div class="pf-toolbar-sub">{{ isset($performanceReviews) && $performanceReviews ? $performanceReviews->count() : '0' }} review(s) on record</div>
        </div>
        <div class="pf-toolbar-actions">
            <button class="pf-btn pf-btn-primary" wire:click="openSelfEvaluationForm">
                <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                Submit Self Evaluation
            </button>
        </div>
    </div>

    @if(isset($performanceReviews) && $performanceReviews && $performanceReviews->count())
        @foreach($performanceReviews as $review)
            @php
                $score = $review->overall_score ?? 0;
                $rating = $review->overall_rating ?? 'unknown';
                $reviewerInitials = $review->reviewer
                    ? strtoupper(substr($review->reviewer->first_name??'R',0,1).substr($review->reviewer->last_name??'',0,1))
                    : 'HR';

                $items = $review->items ?? collect();
            @endphp
            <div class="pf-review-card">
                <div class="pf-review-hd">
                    <div class="pf-review-hd-left">
                        <div class="pf-review-icon">
                            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </div>
                        <div>
                            <div class="pf-review-type">{{ $review->type ?? 'Performance Review' }}</div>
                            <div class="pf-review-period">
                                {{ $review->review_period_start ? \Carbon\Carbon::parse($review->review_period_start)->format('M Y') : '' }}
                                @if($review->review_period_end && $review->review_period_end !== $review->review_period_start)
                                    – {{ \Carbon\Carbon::parse($review->review_period_end)->format('M Y') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pf-review-score-pill">
                        <div>
                            <div class="pf-review-score-num">{{ number_format($score,1) }}</div>
                            <div class="pf-review-score-label">/ 5.0</div>
                        </div>
                    </div>
                </div>

                <div class="pf-review-body">
                    <div class="pf-review-meta">
                        <div class="pf-review-meta-item">
                            <label>Review Date</label>
                            <p>{{ $review->review_date ? $review->review_date->format('M d, Y') : '—' }}</p>
                        </div>
                        <div class="pf-review-meta-item">
                            <label>Overall Rating</label>
                            <p>{{ ucfirst(str_replace('_',' ', $rating)) }}</p>
                        </div>
                        <div class="pf-review-meta-item">
                            <label>Status</label>
                            <p>
                                @php $st = $review->status ?? 'completed'; @endphp
                                <span class="pf-badge {{ $st === 'completed' ? 'pf-badge-green' : 'pf-badge-amber' }}">{{ ucfirst($st) }}</span>
                            </p>
                        </div>
                    </div>

                    @if($items->count())
                    <div class="pf-review-metrics">
                        @foreach($items->take(6) as $item)
                        <div class="pf-review-metric-chip">
                            <div class="pf-review-metric-chip-label">{{ $item->criteria }}</div>
                            <div class="pf-review-metric-chip-val">{{ number_format($item->score,1) }}</div>
                            <div class="pf-review-metric-chip-stars">
                                @for($s=1;$s<=5;$s++)
                                    <span style="color:{{ $s <= round($item->score) ? '#F59E0B' : '#DDE1EC' }};">★</span>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="pf-review-footer">
                    <div class="pf-review-reviewer">
                        <div class="pf-reviewer-av">{{ $reviewerInitials }}</div>
                        <div>
                            <div class="pf-reviewer-name">
                                {{ $review->reviewer ? ($review->reviewer->first_name.' '.$review->reviewer->last_name) : 'Self' }}
                            </div>
                            <div class="pf-reviewer-role">{{ $review->type === 'Self Evaluation' ? 'Self Evaluation' : 'Reviewer' }}</div>
                        </div>
                    </div>
                    <button class="pf-btn pf-btn-ghost pf-btn-sm" wire:click="viewReview('{{ $review->id }}')">
                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    View Full Review
                </button>
                </div>
            </div>
        @endforeach
    @else
        <div class="pf-metrics-card">
            <div class="pf-empty">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <strong>No reviews yet</strong>
                <p>Your manager will add performance reviews here. You can also submit a self-evaluation.</p>
            </div>
        </div>
    @endif
    @endif

    {{-- ════════════════════════════════════════════════════
         GOALS SECTION
    ════════════════════════════════════════════════════ --}}
    @if(($activeSection ?? '') === 'goals')
    <div class="pf-toolbar">
        <div>
            <div class="pf-toolbar-title">My Goals</div>
            <div class="pf-toolbar-sub">{{ isset($goals) && $goals ? $goals->count() : '0' }} goal(s) — {{ isset($goals) && $goals ? $goals->where('status','active')->count() : '0' }} active</div>
        </div>
        <div class="pf-toolbar-actions">
            <button class="pf-btn pf-btn-primary" wire:click="openGoalForm">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Create Goal
            </button>
        </div>
    </div>

    @if(isset($goals) && $goals && $goals->count())
        @foreach(isset($goals) && $goals ? $goals : collect() as $goal)
            @php
                $gs = $goal->status ?? 'active';
                $pct = $goal->progress_percentage ?? 0;
                $iconBg = $gs === 'completed' ? 'background:var(--green-lt);color:var(--green);' : ($gs === 'on_hold' ? 'background:var(--amber-lt);color:var(--amber);' : 'background:var(--blue-lt);color:var(--blue);');
                $barClass = $gs === 'completed' ? 'green' : ($gs === 'on_hold' ? 'amber' : '');
            @endphp
            <div class="pf-goal-card">
                <div class="pf-goal-hd">
                    <div class="pf-goal-icon-wrap" style="{{ $iconBg }}">
                        @if($gs === 'completed')
                            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        @elseif($gs === 'on_hold')
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="10" y1="15" x2="10" y2="9"/><line x1="14" y1="15" x2="14" y2="9"/></svg>
                        @else
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        @endif
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="pf-goal-title">{{ $goal->title }}</div>
                        <div class="pf-goal-desc">{{ Str::limit($goal->description, 120) }}</div>
                    </div>
                    <span class="pf-badge {{ $gs === 'completed' ? 'pf-badge-green' : ($gs === 'on_hold' ? 'pf-badge-amber' : 'pf-badge-blue') }}">
                        {{ ucfirst(str_replace('_',' ',$gs)) }}
                    </span>
                </div>

                <div class="pf-goal-body">
                    <div class="pf-goal-meta">
                        <div class="pf-goal-meta-item">
                            <label>Start Date</label>
                            <p>
                                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $goal->start_date ? \Carbon\Carbon::parse($goal->start_date)->format('M d, Y') : '—' }}
                            </p>
                        </div>
                        <div class="pf-goal-meta-item">
                            <label>Target Date</label>
                            <p>
                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $goal->end_date ? \Carbon\Carbon::parse($goal->end_date)->format('M d, Y') : 'No deadline' }}
                            </p>
                        </div>
                        <div class="pf-goal-meta-item">
                            <label>Priority</label>
                            <p>{{ ucfirst($goal->priority ?? 'medium') }}</p>
                        </div>
                    </div>

                    <div class="pf-goal-progress-wrap">
                        <div class="pf-goal-progress-top">
                            <span>Progress</span>
                            <span>{{ $pct }}%</span>
                        </div>
                        <div class="pf-goal-bar">
                            <div class="pf-goal-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pf-goal-footer">
                    <span style="font-size:12px;color:var(--ink4);font-weight:500;">
                        @if($goal->approval_status)
                            Approval: {{ ucfirst($goal->approval_status->value ?? $goal->approval_status) }}
                        @endif
                    </span>
                    <div style="display:flex;gap:8px;">
                        @if($gs !== 'completed')
                        <button class="pf-btn pf-btn-green pf-btn-sm"
                                wire:click="updateGoalStatus('{{ $goal->id }}', 'completed')">
                            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Mark Done
                        </button>
                        @endif
                        @if($gs === 'active')
                        <button class="pf-btn pf-btn-outline pf-btn-sm"
                                wire:click="updateGoalStatus('{{ $goal->id }}', 'on_hold')">
                            Pause
                        </button>
                        @endif
                        @if($gs === 'on_hold')
                        <button class="pf-btn pf-btn-ghost pf-btn-sm"
                                wire:click="updateGoalStatus('{{ $goal->id }}', 'active')">
                            Resume
                        </button>
                        @endif
                        <button class="pf-btn pf-btn-ghost pf-btn-sm" wire:click="viewGoal('{{ $goal->id }}')">
                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Details
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="pf-metrics-card">
            <div class="pf-empty">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                <strong>No goals set yet</strong>
                <p>Create your first goal to start tracking your progress.</p>
            </div>
        </div>
    @endif
    @endif

    {{-- ════════════════════════════════════════════════════
         ACHIEVEMENTS SECTION
    ════════════════════════════════════════════════════ --}}
    @if(($activeSection ?? '') === 'achievements')
    <div class="pf-toolbar">
        <div>
            <div class="pf-toolbar-title">Achievements & Recognition</div>
            <div class="pf-toolbar-sub">{{ $achievements ? $achievements->count() : '0' }} achievement(s) earned</div>
        </div>
    </div>

    @if($achievements && $achievements->count())
        <div class="pf-ach-grid">
            @foreach($achievements as $ach)
            <div class="pf-ach-card">
                <div class="pf-ach-badge-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                </div>
                <div class="pf-ach-name">{{ $ach->title ?? $ach->name }}</div>
                <div class="pf-ach-date">{{ $ach->achieved_date ? \Carbon\Carbon::parse($ach->achieved_date)->format('M d, Y') : '—' }}</div>
                @if($ach->description)
                    <div class="pf-ach-desc">{{ Str::limit($ach->description, 80) }}</div>
                @endif
            </div>
            @endforeach
        </div>
    @else
        <div class="pf-metrics-card">
            <div class="pf-empty">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                <strong>No achievements yet</strong>
                <p>Keep hitting your goals — achievements will appear here when awarded by HR or your manager.</p>
            </div>
        </div>
    @endif
    @endif

</div>{{-- /pf-main --}}
</div>{{-- /pf-shell --}}

{{-- ══ REVIEW DETAIL MODAL ══════════════════════════════════ --}}
@if(isset($selectedReview) && $selectedReview)
<div class="pf-modal-bg" wire:click.self="closeModals">
    <div class="pf-modal pf-modal-wide">
        <div class="pf-modal-hd">
            <div class="pf-modal-title">{{ $selectedReview->type ?? 'Performance Review' }}</div>
            <button class="pf-modal-close" wire:click="closeModals">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="pf-modal-body">
            <div class="pf-modal-section-title">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Review Details
            </div>
            <div class="pf-modal-info-grid">
                <div class="pf-modal-info-item">
                    <label>Review Date</label>
                    <p>{{ $selectedReview->review_date ? $selectedReview->review_date->format('M d, Y') : '—' }}</p>
                </div>
                <div class="pf-modal-info-item">
                    <label>Overall Score</label>
                    <p>{{ $selectedReview->overall_score ? number_format($selectedReview->overall_score,1).' / 5.0' : '—' }}</p>
                </div>
                <div class="pf-modal-info-item">
                    <label>Rating</label>
                    <p>{{ ucfirst(str_replace('_',' ', $selectedReview->overall_rating ?? '—')) }}</p>
                </div>
                <div class="pf-modal-info-item">
                    <label>Status</label>
                    <p>{{ ucfirst($selectedReview->status ?? '—') }}</p>
                </div>
            </div>

            @if($selectedReview->items && $selectedReview->items->count())
            <div class="pf-modal-section-title">
                <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Score Breakdown
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:16px;">
                @foreach($selectedReview->items as $item)
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:600;color:var(--ink2);margin-bottom:5px;">
                        <span>{{ $item->criteria }}</span>
                        <span style="color:var(--blue-2);font-family:'Sora',sans-serif;font-weight:800;">{{ number_format($item->score,1) }}</span>
                    </div>
                    <div class="pf-metric-bar">
                        <div class="pf-metric-fill fill-blue" style="width:{{ ($item->score/5)*100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if($selectedReview->strengths)
            <div class="pf-modal-section-title">
                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Strengths
            </div>
            <div class="pf-modal-text-block">{{ $selectedReview->strengths }}</div>
            @endif

            @if($selectedReview->areas_for_improvement)
            <div class="pf-modal-section-title">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Areas for Improvement
            </div>
            <div class="pf-modal-text-block">{{ $selectedReview->areas_for_improvement }}</div>
            @endif

            @if($selectedReview->development_plan)
            <div class="pf-modal-section-title">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Development Plan
            </div>
            <div class="pf-modal-text-block">{{ $selectedReview->development_plan }}</div>
            @endif

            @if($selectedReview->employee_comments)
            <div class="pf-modal-section-title">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Employee Comments
            </div>
            <div class="pf-modal-text-block">{{ $selectedReview->employee_comments }}</div>
            @endif
        </div>
        <div class="pf-modal-footer">
            <button class="pf-btn pf-btn-outline" wire:click="closeModals">Close</button>
        </div>
    </div>
</div>
@endif

{{-- ══ GOAL DETAIL MODAL ════════════════════════════════════ --}}
@if(isset($selectedGoal) && $selectedGoal)
<div class="pf-modal-bg" wire:click.self="closeModals">
    <div class="pf-modal">
        <div class="pf-modal-hd">
            <div class="pf-modal-title">Goal Details</div>
            <button class="pf-modal-close" wire:click="closeModals">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="pf-modal-body">
            <div style="font-family:'Sora',sans-serif;font-size:18px;font-weight:800;color:var(--ink);margin-bottom:6px;">{{ isset($selectedGoal) && $selectedGoal ? $selectedGoal->title : '' }}</div>
            <p style="font-size:13.5px;color:var(--ink3);font-weight:500;line-height:1.6;margin-bottom:18px;">{{ isset($selectedGoal) && $selectedGoal ? $selectedGoal->description : '' }}</p>
            <div class="pf-modal-info-grid">
                <div class="pf-modal-info-item">
                    <label>Status</label>
                    <p>{{ isset($selectedGoal) && $selectedGoal ? ($selectedGoal->status ?? '—') : '' }}</p>
                </div>
                <div class="pf-modal-info-item">
                    <label>Priority</label>
                    <p>{{ isset($selectedGoal) && $selectedGoal ? ($selectedGoal->priority ?? '—') : '' }}</p>
                </div>
                <div class="pf-modal-info-item">
                    <label>Start Date</label>
                    <p>{{ isset($selectedGoal) && $selectedGoal && $selectedGoal->start_date ? \Carbon\Carbon::parse($selectedGoal->start_date)->format('M d, Y') : '—' }}</p>
                </div>
                <div class="pf-modal-info-item">
                    <label>Target Date</label>
                    <p>{{ isset($selectedGoal) && $selectedGoal && $selectedGoal->end_date ? \Carbon\Carbon::parse($selectedGoal->end_date)->format('M d, Y') : '—' }}</p>
                </div>
            </div>
            <div class="pf-goal-progress-wrap" style="margin-top:8px;">
                <div class="pf-goal-progress-top">
                    <span>Progress</span>
                    <span>{{ isset($selectedGoal) && $selectedGoal ? ($selectedGoal->progress_percentage ?? 0) : 0 }}%</span>
                </div>
                <div class="pf-goal-bar">
                    <div class="pf-goal-bar-fill" style="width:{{ isset($selectedGoal) && $selectedGoal ? ($selectedGoal->progress_percentage ?? 0) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="pf-modal-footer">
            <button class="pf-btn pf-btn-outline" wire:click="closeModals">Close</button>
        </div>
    </div>
</div>
@endif

{{-- ══ CREATE GOAL MODAL ════════════════════════════════════ --}}
@if(isset($showGoalForm) && $showGoalForm)
<div class="pf-modal-bg" wire:click.self="closeModals">
    <div class="pf-modal">
        <div class="pf-modal-hd">
            <div class="pf-modal-title">Create New Goal</div>
            <button class="pf-modal-close" wire:click="closeModals">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="createGoal">
            <div class="pf-modal-body">
                <div class="pf-field">
                    <label>Goal Title</label>
                    <input type="text" wire:model="goalTitle" placeholder="e.g. Complete leadership training" required>
                    @error('goalTitle') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="pf-field">
                    <label>Description</label>
                    <textarea wire:model="goalDescription" placeholder="Describe what you want to achieve and how…" required></textarea>
                    @error('goalDescription') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="pf-field-grid">
                    <div class="pf-field">
                        <label>Target Date</label>
                        <input type="date" wire:model="goalTargetDate" required>
                        @error('goalTargetDate') <div class="pf-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="pf-field">
                        <label>Status</label>
                        <select wire:model="goalStatus">
                            <option value="active">Active</option>
                            <option value="on_hold">On Hold</option>
                        </select>
                        @error('goalStatus') <div class="pf-field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="pf-modal-footer">
                <button type="button" class="pf-btn pf-btn-outline" wire:click="closeModals">Cancel</button>
                <button type="submit" class="pf-btn pf-btn-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Create Goal
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ SELF EVALUATION MODAL ═══════════════════════════════ --}}
@if($showSelfEvaluationForm)
<div class="pf-modal-bg" wire:click.self="closeModals">
    <div class="pf-modal pf-modal-wide">
        <div class="pf-modal-hd">
            <div class="pf-modal-title">Self Evaluation</div>
            <button class="pf-modal-close" wire:click="closeModals">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="submitSelfEvaluation">
            <div class="pf-modal-body">

                <div class="pf-field">
                    <label>Evaluation Period</label>
                    <input type="date" wire:model="selfEvaluationPeriod" required>
                    @error('selfEvaluationPeriod') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-modal-section-title" style="margin-top:4px;">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Rate Your Skills (1 = Poor · 5 = Excellent)
                </div>

                @php
                    $evalFields = [
                        ['wire' => 'selfTechnicalSkills',  'label' => 'Technical Skills'],
                        ['wire' => 'selfCommunication',    'label' => 'Communication'],
                        ['wire' => 'selfTeamwork',         'label' => 'Teamwork'],
                        ['wire' => 'selfLeadership',       'label' => 'Leadership'],
                        ['wire' => 'selfProblemSolving',   'label' => 'Problem Solving'],
                        ['wire' => 'selfTimeManagement',   'label' => 'Time Management'],
                    ];
                @endphp

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    @foreach($evalFields as $ef)
                        @php
                            $fieldName = $ef['wire'];
                        @endphp
                    <div class="pf-rating-row">
                        <div class="pf-rating-label">{{ $ef['label'] }}</div>
                        <div class="pf-rating-ctrl">
                            <input type="range" class="pf-rating-range" wire:model="{{ $fieldName }}"
                                   min="1" max="5" step="1" style="flex:1;">
                            <span class="pf-rating-val">{{ $$fieldName }}/5</span>
                        </div>
                        @error($fieldName) <div class="pf-field-error">{{ $message }}</div> @enderror
                    </div>
                    @endforeach
                </div>

                <div class="pf-field">
                    <label>Key Strengths</label>
                    <textarea wire:model="selfStrengths" placeholder="What are your greatest strengths this period?" required></textarea>
                    @error('selfStrengths') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label>Areas for Improvement</label>
                    <textarea wire:model="selfAreasForImprovement" placeholder="Where do you want to grow?" required></textarea>
                    @error('selfAreasForImprovement') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label>Goals for Next Period</label>
                    <textarea wire:model="selfGoals" placeholder="What do you aim to achieve next?" required></textarea>
                    @error('selfGoals') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label>Additional Comments (optional)</label>
                    <textarea wire:model="selfAdditionalComments" placeholder="Anything else you'd like to share…"></textarea>
                    @error('selfAdditionalComments') <div class="pf-field-error">{{ $message }}</div> @enderror
                </div>

            </div>
            <div class="pf-modal-footer">
                <button type="button" class="pf-btn pf-btn-outline" wire:click="closeModals">Cancel</button>
                <button type="submit" class="pf-btn pf-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Submit Evaluation
                </button>
            </div>
        </form>
    </div>
</div>
@endif

</div>{{-- /pf-root --}}