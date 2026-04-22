<div class="ep-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.ep-root {
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
    --r:        12px;
    --r-lg:     18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
}

/* ══ Page shell ══════════════════════════════════════════ */
.ep-shell {
    display: flex;
    min-height: 100vh;
    gap: 0;
}

/* ══ LEFT SIDEBAR NAV ════════════════════════════════════ */
.ep-sidenav {
    width: 220px;
    min-width: 220px;
    background: var(--white);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    padding: 28px 14px;
    gap: 4px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    flex-shrink: 0;
}

.ep-sidenav-label {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.09em;
    color: var(--ink4);
    padding: 12px 10px 6px;
    margin-top: 4px;
}

.ep-sidenav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink3);
    cursor: pointer;
    border: none;
    background: transparent;
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    text-align: left;
    transition: background 0.15s, color 0.15s;
    text-decoration: none;
}
.ep-sidenav-item svg {
    width: 16px; height: 16px;
    stroke: currentColor; fill: none; stroke-width: 2;
    flex-shrink: 0; opacity: 0.75;
}
.ep-sidenav-item:hover {
    background: var(--blue-lt);
    color: var(--blue);
}
.ep-sidenav-item.active {
    background: var(--blue);
    color: #fff;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(59,111,232,0.28);
}
.ep-sidenav-item.active svg { opacity: 1; }

/* ══ MAIN CONTENT ════════════════════════════════════════ */
.ep-main {
    flex: 1;
    min-width: 0;
    padding: 28px 28px 80px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ══ Flash ═══════════════════════════════════════════════ */
.ep-flash {
    padding: 13px 18px;
    border-radius: var(--r);
    font-size: 13.5px; font-weight: 600;
    display: flex; align-items: center; gap: 9px;
}
.ep-flash-success { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.ep-flash-error   { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.ep-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ CARD base ═══════════════════════════════════════════ */
.ep-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}

/* ══ OVERVIEW LAYOUT ═════════════════════════════════════ */
.ep-ov-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
}
.ep-ov-left { display: flex; flex-direction: column; gap: 20px; }

/* ── Hero card ─────────────────────────────────────────── */
.ep-hero {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ep-hero-cover {
    height: 80px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.ep-hero-cover::before {
    content: '';
    position: absolute; top: -30px; right: 60px;
    width: 180px; height: 180px; border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.ep-hero-cover::after {
    content: '';
    position: absolute; bottom: -20px; left: 30px;
    width: 100px; height: 100px; border-radius: 50%;
    background: rgba(255,255,255,0.04);
}
.ep-hero-body { padding: 0 24px 22px; }
.ep-hero-row {
    display: flex; align-items: flex-end;
    justify-content: space-between;
    margin-top: -0px; margin-bottom: 16px; gap: 14px;
}
.ep-hero-left { display: flex; align-items: flex-end; gap: 14px; }

/* Avatar */
.ep-av {
    width: 72px; height: 72px; border-radius: 50%;
    border: 3px solid var(--white);
    box-shadow: 0 4px 14px rgba(59,111,232,0.22);
    background: linear-gradient(135deg, var(--blue), #6B4FDB);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif;
    font-size: 22px; font-weight: 800; color: #fff;
    flex-shrink: 0; position: relative; overflow: hidden;
}
.ep-av img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.ep-av-cam {
    position: absolute; inset: 0; background: transparent;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background 0.18s; border: none; padding: 0; width: 100%;
}
.ep-av-cam:hover { background: rgba(0,0,0,0.38); }
.ep-av-cam svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; opacity: 0; transition: opacity 0.18s; }
.ep-av-cam:hover svg { opacity: 1; }
.ep-av-online {
    position: absolute; bottom: 3px; right: 3px;
    width: 12px; height: 12px; border-radius: 50%;
    background: #22C55E; border: 2px solid var(--white);
}

.ep-hero-name-col { padding-bottom: 2px; }
.ep-hero-name {
    font-family: 'Sora', sans-serif;
    font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 3px;
}
.ep-hero-role { font-size: 13px; color: var(--ink3); font-weight: 500; }
.ep-hero-role strong { color: var(--blue-2); font-weight: 700; }

/* Contact pills on hero */
.ep-hero-contacts {
    display: flex; gap: 8px; flex-wrap: wrap; margin-top: 2px;
}
.ep-contact-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 100px;
    font-size: 12px; font-weight: 600;
    background: var(--blue-lt); color: var(--blue-2);
    border: 1px solid var(--blue-brd);
}
.ep-contact-pill svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2; }
.ep-contact-pill.green { background: var(--green-lt); color: #087A42; border-color: rgba(18,183,106,0.22); }

/* Hero actions */
.ep-hero-actions { display: flex; gap: 8px; align-items: flex-end; padding-bottom: 2px; }

/* ── Info sections ─────────────────────────────────────── */
.ep-info-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}
.ep-info-card-hd {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
}
.ep-info-card-title {
    font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink3);
    display: flex; align-items: center; gap: 6px;
}
.ep-info-card-title svg { width: 13px; height: 13px; stroke: var(--blue); fill: none; stroke-width: 2; }
.ep-info-card-body { padding: 20px; }

.ep-info-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 18px;
}
.ep-info-grid-2 { grid-template-columns: repeat(2, minmax(0,1fr)); }

.ep-info-item label {
    display: block;
    font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--ink4); margin-bottom: 4px;
}
.ep-info-item p {
    font-size: 13.5px; font-weight: 600; color: var(--ink2); margin: 0;
    display: flex; align-items: center; gap: 5px;
}
.ep-info-item p svg { width: 12px; height: 12px; stroke: var(--blue); fill: none; stroke-width: 2; flex-shrink: 0; }
.ep-info-dash { color: var(--ink4) !important; font-weight: 400 !important; font-style: italic; }
.col-span-2 { grid-column: span 2; }
.col-span-3 { grid-column: span 3; }

/* Stat strips */
.ep-stat-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--border);
    border-radius: 0 0 var(--r-lg) var(--r-lg);
    overflow: hidden;
}
.ep-stat-cell {
    background: var(--white);
    padding: 14px 16px;
    display: flex; flex-direction: column; gap: 3px;
}
.ep-stat-cell-label { font-size: 10.5px; font-weight: 700; color: var(--ink4); text-transform: uppercase; letter-spacing: 0.07em; }
.ep-stat-cell-val {
    font-family: 'Sora', sans-serif;
    font-size: 18px; font-weight: 800; color: var(--blue-2);
}

/* ══ RIGHT COLUMN ════════════════════════════════════════ */
.ep-ov-right { display: flex; flex-direction: column; gap: 20px; }

/* ── Mini calendar ─────────────────────────────────────── */
.ep-cal {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ep-cal-hd {
    background: var(--blue);
    padding: 14px 16px;
    display: flex; align-items: center; justify-content: space-between;
}
.ep-cal-month {
    font-family: 'Sora', sans-serif;
    font-size: 14px; font-weight: 800; color: #fff;
}
.ep-cal-nav { background: rgba(255,255,255,0.15); border: none; border-radius: 6px; cursor: pointer; padding: 4px 8px; color: #fff; font-size: 12px; }
.ep-cal-nav:hover { background: rgba(255,255,255,0.25); }
.ep-cal-body { padding: 12px; }
.ep-cal-dow {
    display: grid; grid-template-columns: repeat(7, 1fr);
    margin-bottom: 4px;
}
.ep-cal-dow span {
    text-align: center; font-size: 9.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.06em; color: var(--ink4);
    padding: 3px 0;
}
.ep-cal-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
.ep-cal-day {
    text-align: center; font-size: 12px; font-weight: 600;
    color: var(--ink3); padding: 5px 2px; border-radius: 6px;
    cursor: pointer; transition: background 0.15s;
}
.ep-cal-day:hover { background: var(--blue-lt); color: var(--blue); }
.ep-cal-day.other { color: var(--ink4); opacity: 0.5; }
.ep-cal-day.today {
    background: var(--blue); color: #fff;
    font-weight: 800; border-radius: 8px;
    box-shadow: 0 2px 8px rgba(59,111,232,0.35);
}
.ep-cal-day.has-event::after {
    content: '';
    display: block; width: 4px; height: 4px; border-radius: 50%;
    background: var(--amber); margin: 1px auto 0;
}
.ep-cal-day.today::after { background: rgba(255,255,255,0.8); }

/* Tasks */
.ep-tasks {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}
.ep-tasks-hd {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink3);
    display: flex; align-items: center; gap: 6px;
}
.ep-tasks-hd svg { width: 13px; height: 13px; stroke: var(--blue); fill: none; stroke-width: 2; }
.ep-task-item {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 11px 16px;
    border-bottom: 1px solid var(--border);
}
.ep-task-item:last-child { border-bottom: none; }
.ep-task-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 4px;
}
.ep-task-dot.blue  { background: var(--blue); }
.ep-task-dot.green { background: var(--green); }
.ep-task-dot.amber { background: var(--amber); }
.ep-task-text { font-size: 12.5px; font-weight: 600; color: var(--ink2); line-height: 1.4; }
.ep-task-when { font-size: 11px; color: var(--ink4); font-weight: 500; margin-top: 1px; }

/* ── Employment history (right) ────────────────────────── */
.ep-hist-right {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ep-hist-hd {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink3);
}
.ep-hist-hd svg { width: 13px; height: 13px; stroke: var(--blue); fill: none; stroke-width: 2; }
.ep-hist-item {
    display: flex; gap: 12px; padding: 14px 16px;
    border-bottom: 1px solid var(--border); position: relative;
}
.ep-hist-item:last-child { border-bottom: none; }
.ep-hist-line {
    display: flex; flex-direction: column; align-items: center; gap: 0; flex-shrink: 0;
}
.ep-hist-dot {
    width: 10px; height: 10px; border-radius: 50; border-radius: 50%;
    background: var(--blue); flex-shrink: 0; margin-top: 4px;
    box-shadow: 0 0 0 3px rgba(59,111,232,0.15);
}
.ep-hist-connector {
    flex: 1; width: 2px; background: var(--border); margin-top: 4px;
    min-height: 20px;
}
.ep-hist-body { flex: 1; min-width: 0; }
.ep-hist-title { font-size: 13px; font-weight: 700; color: var(--ink2); margin-bottom: 1px; }
.ep-hist-company { font-size: 11.5px; color: var(--blue); font-weight: 600; margin-bottom: 1px; }
.ep-hist-period { font-size: 11px; color: var(--ink4); font-weight: 500; }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.ep-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    border: none; cursor: pointer; transition: all 0.15s;
    text-decoration: none;
}
.ep-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.ep-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.ep-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.ep-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.ep-btn-outline:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
.ep-btn-ghost { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.ep-btn-ghost:hover { background: var(--blue-mid); }
.ep-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.ep-btn-danger:hover { background: rgba(239,68,68,0.16); }
.ep-btn-sm { padding: 6px 12px; font-size: 12px; }

/* ══ BADGES ══════════════════════════════════════════════ */
.ep-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 100px;
    font-size: 11.5px; font-weight: 700; flex-shrink: 0;
}
.ep-badge svg { width: 10px; height: 10px; stroke: currentColor; fill: none; stroke-width: 2.5; }
.ep-badge-green  { background: var(--green-lt); color: #087A42; }
.ep-badge-blue   { background: var(--blue-lt);  color: var(--blue-2); }
.ep-badge-gray   { background: var(--bg);        color: var(--ink3); border: 1px solid var(--border); }
.ep-badge-amber  { background: var(--amber-lt); color: #92400E; }
.ep-badge-red    { background: var(--red-lt);   color: #991B1B; }

/* ══ CONTRACT DESIGN ═════════════════════════════════════ */
.ep-contract-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    margin-bottom: 14px;
    box-shadow: var(--shadow);
    transition: box-shadow 0.18s, border-color 0.18s;
}
.ep-contract-card:hover { box-shadow: var(--shadow-md); border-color: var(--blue-brd); }
.ep-contract-card:last-child { margin-bottom: 0; }

.ep-contract-hd {
    background: linear-gradient(105deg, var(--blue-3) 0%, var(--blue) 100%);
    padding: 16px 22px;
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
.ep-contract-hd-left { display: flex; align-items: center; gap: 12px; }
.ep-contract-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: rgba(255,255,255,0.18);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ep-contract-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; }
.ep-contract-type { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 800; color: #fff; margin-bottom: 2px; }
.ep-contract-num { font-size: 11.5px; color: rgba(255,255,255,0.70); font-weight: 600; }

.ep-contract-body { padding: 20px 22px; }
.ep-contract-meta {
    display: grid;
    grid-template-columns: repeat(4, minmax(0,1fr));
    gap: 16px;
    margin-bottom: 16px;
}
.ep-contract-meta-item label {
    display: block; font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--ink4); margin-bottom: 3px;
}
.ep-contract-meta-item p {
    font-size: 13px; font-weight: 700; color: var(--ink2); margin: 0;
}

.ep-contract-progress-wrap { margin-bottom: 14px; }
.ep-contract-progress-label {
    display: flex; justify-content: space-between;
    font-size: 11px; font-weight: 700; color: var(--ink4); margin-bottom: 6px;
}
.ep-contract-bar {
    height: 6px; border-radius: 100px;
    background: var(--bg); overflow: hidden;
}
.ep-contract-bar-fill {
    height: 100%; border-radius: 100px;
    background: linear-gradient(90deg, var(--blue-2), var(--blue));
    transition: width 0.5s ease;
}

.ep-contract-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 22px;
    border-top: 1px solid var(--border);
    background: var(--bg);
}

/* ══ DOCUMENT DESIGN ═════════════════════════════════════ */
.ep-doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 14px;
}
.ep-doc-card-v2 {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: box-shadow 0.18s, border-color 0.18s;
    display: flex; flex-direction: column;
}
.ep-doc-card-v2:hover { box-shadow: var(--shadow-md); border-color: var(--blue-brd); }
.ep-doc-card-top {
    height: 80px;
    background: linear-gradient(135deg, var(--blue-lt), rgba(59,111,232,0.04));
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center; position: relative;
}
.ep-doc-card-top svg { width: 32px; height: 32px; stroke: var(--blue); fill: none; stroke-width: 1.5; }
.ep-doc-ext {
    position: absolute; bottom: 8px; right: 10px;
    background: var(--blue); color: #fff;
    font-size: 9px; font-weight: 800; letter-spacing: 0.06em;
    padding: 2px 7px; border-radius: 4px;
    text-transform: uppercase;
}
.ep-doc-card-info { padding: 14px 14px 10px; flex: 1; }
.ep-doc-card-name {
    font-size: 13px; font-weight: 700; color: var(--ink);
    margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    display: block; text-decoration: none;
}
.ep-doc-card-name:hover { color: var(--blue); }
.ep-doc-card-date { font-size: 11px; color: var(--ink4); font-weight: 500; }
.ep-doc-card-footer {
    padding: 10px 14px;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}

/* Document Viewer Modal */
.ep-modal-large { max-width: 900px; width: 90%; }
.ep-doc-viewer { }
.ep-doc-viewer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border);
}
.ep-doc-viewer-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: var(--ink);
}
.ep-doc-viewer-actions {
    display: flex;
    gap: 8px;
}
.ep-doc-viewer-content {
    margin-bottom: 20px;
}
.ep-doc-viewer-footer {
    padding-top: 15px;
    border-top: 1px solid var(--border);
}

/* Modal Styles */
.ep-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(2px);
}
.ep-modal-content {
    background: var(--white);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-md);
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}
.ep-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
}
.ep-modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: var(--ink);
}
.ep-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--ink3);
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: background 0.15s;
}
.ep-modal-close:hover {
    background: var(--border);
    color: var(--ink);
}
.ep-modal-body {
    padding: 24px;
}

/* Upload drop zone */
.ep-upload-zone {
    border: 2px dashed var(--blue-brd);
    border-radius: var(--r-lg);
    padding: 32px 20px;
    text-align: center;
    background: var(--blue-lt);
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    margin-bottom: 20px;
}
.ep-upload-zone:hover { border-color: var(--blue); background: var(--blue-mid); }
.ep-upload-zone svg { width: 36px; height: 36px; stroke: var(--blue); fill: none; stroke-width: 1.5; margin-bottom: 10px; }
.ep-upload-zone p { font-size: 13.5px; font-weight: 600; color: var(--blue-2); margin: 0 0 4px; }
.ep-upload-zone span { font-size: 11.5px; color: var(--ink4); }

/* ══ EMERGENCY CONTACT DESIGN ════════════════════════════ */
.ep-ec-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: var(--shadow);
    margin-bottom: 14px;
    transition: box-shadow 0.18s, border-color 0.18s;
}
.ep-ec-card:hover { box-shadow: var(--shadow-md); border-color: var(--blue-brd); }
.ep-ec-card:last-child { margin-bottom: 0; }
.ep-ec-hd {
    padding: 16px 20px;
    display: flex; align-items: center; gap: 14px;
    border-bottom: 1px solid var(--border);
}
.ep-ec-av {
    width: 46px; height: 46px; border-radius: 14px;
    background: linear-gradient(135deg, var(--blue-lt), var(--blue-mid));
    border: 1.5px solid var(--blue-brd);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif;
    font-size: 14px; font-weight: 800; color: var(--blue-2);
    flex-shrink: 0;
}
.ep-ec-name { font-size: 15px; font-weight: 800; color: var(--ink); font-family: 'Sora', sans-serif; margin-bottom: 2px; }
.ep-ec-rel {
    display: inline-flex; align-items: center; gap: 4px;
    background: var(--blue-lt); color: var(--blue-2);
    border: 1px solid var(--blue-brd);
    font-size: 11px; font-weight: 700;
    padding: 2px 9px; border-radius: 100px;
}
.ep-ec-body {
    padding: 14px 20px;
    display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 14px;
}
.ep-ec-field label {
    display: block; font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); margin-bottom: 3px;
}
.ep-ec-field p {
    font-size: 13px; font-weight: 600; color: var(--ink2); margin: 0;
    display: flex; align-items: center; gap: 5px;
}
.ep-ec-field p svg { width: 12px; height: 12px; stroke: var(--blue); fill: none; stroke-width: 2; }
.ep-ec-footer {
    padding: 10px 20px;
    border-top: 1px solid var(--border);
    background: var(--bg);
    display: flex; justify-content: flex-end; gap: 8px;
}

/* ══ HISTORY DESIGN ══════════════════════════════════════ */
.ep-hist-full { padding: 4px 0; }
.ep-hist-full-item {
    display: flex; gap: 18px; padding-bottom: 0;
    position: relative;
}
.ep-hist-full-item + .ep-hist-full-item { margin-top: 0; }
.ep-hist-timeline {
    display: flex; flex-direction: column; align-items: center;
    flex-shrink: 0; width: 18px;
}
.ep-hist-full-dot {
    width: 14px; height: 14px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), var(--blue-2));
    flex-shrink: 0; margin-top: 6px;
    box-shadow: 0 0 0 4px rgba(59,111,232,0.12);
}
.ep-hist-full-line {
    flex: 1; width: 2px;
    background: linear-gradient(180deg, var(--blue-mid), transparent);
    margin: 4px 0;
    min-height: 24px;
}
.ep-hist-full-card {
    flex: 1; background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: var(--shadow);
    margin-bottom: 16px;
    transition: box-shadow 0.18s, border-color 0.18s;
}
.ep-hist-full-card:hover { box-shadow: var(--shadow-md); border-color: var(--blue-brd); }
.ep-hist-full-card-hd {
    padding: 14px 18px;
    display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
    border-bottom: 1px solid var(--border);
}
.ep-hist-full-role { font-size: 15px; font-weight: 800; color: var(--ink); font-family: 'Sora', sans-serif; margin-bottom: 3px; }
.ep-hist-full-company { font-size: 13px; font-weight: 700; color: var(--blue); }
.ep-hist-full-body { padding: 14px 18px; display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
.ep-hist-full-field label {
    display: block; font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); margin-bottom: 3px;
}
.ep-hist-full-field p { font-size: 13px; font-weight: 600; color: var(--ink2); margin: 0; }
.ep-hist-desc {
    padding: 0 18px 14px;
    font-size: 12.5px; color: var(--ink3); font-weight: 500; line-height: 1.6;
}

/* ══ SECTION TOOLBAR ═════════════════════════════════════ */
.ep-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px;
}
.ep-toolbar-title {
    font-family: 'Sora', sans-serif;
    font-size: 16px; font-weight: 800; color: var(--ink);
}
.ep-toolbar-sub { font-size: 12.5px; color: var(--ink4); font-weight: 500; margin-top: 1px; }

/* ══ EMPTY STATE ═════════════════════════════════════════ */
.ep-empty {
    text-align: center; padding: 48px 24px;
    color: var(--ink4); font-size: 13.5px; font-weight: 500;
}
.ep-empty svg {
    width: 40px; height: 40px; stroke: var(--ink4);
    fill: none; stroke-width: 1.5; margin: 0 auto 12px; display: block; opacity: 0.4;
}
.ep-empty strong { display: block; font-size: 15px; font-weight: 700; color: var(--ink3); margin-bottom: 4px; }

/* ══ MODAL ═══════════════════════════════════════════════ */
.ep-modal-bg {
    position: fixed; inset: 0;
    background: rgba(15,22,41,0.52);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center; padding: 16px;
}
.ep-modal {
    background: var(--white);
    border-radius: var(--r-lg);
    box-shadow: 0 24px 64px rgba(15,22,41,0.22);
    border: 1px solid var(--border);
    width: 100%; max-width: 500px;
    max-height: 90vh; overflow-y: auto;
}
.ep-modal-wide { max-width: 640px; }
.ep-modal-hd {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 24px; border-bottom: 1px solid var(--border);
    position: sticky; top: 0; background: var(--white); z-index: 1;
}
.ep-modal-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: var(--ink); }
.ep-modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s; color: var(--ink3);
}
.ep-modal-close:hover { background: var(--red-lt); color: var(--red); border-color: rgba(239,68,68,0.22); }
.ep-modal-close svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; }
.ep-modal-body { padding: 24px; }
.ep-modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 16px 24px; border-top: 1px solid var(--border);
}

/* ══ FORM FIELDS ═════════════════════════════════════════ */
.ep-field { margin-bottom: 14px; }
.ep-field:last-child { margin-bottom: 0; }
.ep-field label {
    display: block; font-size: 10.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--ink4); margin-bottom: 5px;
}
.ep-field input, .ep-field select, .ep-field textarea {
    width: 100%; box-sizing: border-box;
    padding: 10px 13px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color 0.15s, box-shadow 0.15s;
}
.ep-field input:focus, .ep-field select:focus, .ep-field textarea:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59,111,232,0.10); background: var(--white);
}
.ep-field textarea { resize: vertical; min-height: 76px; }
.ep-field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.ep-field-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
.ep-field-error { font-size: 11.5px; color: var(--red); margin-top: 4px; font-weight: 600; }

/* Avatar upload */
.ep-upload-av { display: flex; flex-direction: column; align-items: center; gap: 8px; margin-bottom: 20px; }
.ep-upload-av-circle {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), #6B4FDB);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 800; color: #fff;
    border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.22);
    position: relative; overflow: hidden;
}
.ep-upload-av-circle img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.ep-upload-av-lbl {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 13px; border-radius: var(--r);
    background: var(--blue-lt); color: var(--blue-2);
    border: 1px solid var(--blue-brd);
    font-size: 12px; font-weight: 700; cursor: pointer; transition: background 0.15s;
}
.ep-upload-av-lbl:hover { background: var(--blue-mid); }
.ep-upload-av-lbl svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2; }
.ep-upload-av-hint { font-size: 11.5px; color: var(--ink4); font-weight: 500; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1100px) {
    .ep-ov-grid { grid-template-columns: 1fr; }
    .ep-ov-right { flex-direction: row; flex-wrap: wrap; }
    .ep-ov-right > * { flex: 1; min-width: 240px; }
    .ep-contract-meta { grid-template-columns: repeat(2,1fr); }
    .ep-hist-full-body { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 840px) {
    .ep-sidenav { width: 56px; min-width: 56px; padding: 20px 8px; }
    .ep-sidenav-label { display: none; }
    .ep-sidenav-item span { display: none; }
    .ep-sidenav-item { justify-content: center; padding: 10px; }
    .ep-sidenav-item svg { opacity: 1; }
    .ep-main { padding: 16px 16px 80px; }
    .ep-info-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 600px) {
    .ep-shell { flex-direction: column; }
    .ep-sidenav { width: 100%; min-width: unset; height: auto; flex-direction: row; padding: 10px; overflow-x: auto; position: static; }
    .ep-sidenav-label { display: none; }
    .ep-sidenav-item { flex-direction: column; gap: 3px; padding: 8px 10px; font-size: 10px; min-width: 56px; }
    .ep-sidenav-item span { display: block; font-size: 10px; }
    .ep-hero-row { flex-direction: column; align-items: flex-start; margin-top: -28px; }
    .ep-info-grid { grid-template-columns: 1fr; }
    .ep-ec-body { grid-template-columns: 1fr; }
    .ep-hist-full-body { grid-template-columns: 1fr; }
    .ep-contract-meta { grid-template-columns: 1fr; }
    .ep-stat-strip { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="ep-shell">

{{-- ══════════════════════════════════════════════════════
     LEFT SIDEBAR NAVIGATION
══════════════════════════════════════════════════════ --}}
<aside class="ep-sidenav">
    <div class="ep-sidenav-label">Profile</div>

    <button class="ep-sidenav-item {{ $activeTab === 'overview' ? 'active' : '' }}"
            wire:click="setActiveTab('overview')">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        <span>Overview</span>
    </button>

    <div class="ep-sidenav-label">Work</div>

    <button class="ep-sidenav-item {{ $activeTab === 'contracts' ? 'active' : '' }}"
            wire:click="setActiveTab('contracts')">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        <span>Contracts</span>
    </button>

    <button class="ep-sidenav-item {{ $activeTab === 'documents' ? 'active' : '' }}"
            wire:click="setActiveTab('documents')">
        <svg viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
        <span>Documents</span>
    </button>

    <button class="ep-sidenav-item {{ $activeTab === 'history' ? 'active' : '' }}"
            wire:click="setActiveTab('history')">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span>History</span>
    </button>

    <div class="ep-sidenav-label">Personal</div>

    <button class="ep-sidenav-item {{ $activeTab === 'emergency' ? 'active' : '' }}"
            wire:click="setActiveTab('emergency')">
        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.27 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8a16 16 0 0 0 7.92 7.92l1.35-1.35a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <span>Emergency</span>
    </button>
</aside>

{{-- ══════════════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════════════ --}}
<div class="ep-main">

    {{-- Flash --}}
    @if(session()->has('message'))
        <div class="ep-flash ep-flash-success">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('message') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="ep-flash ep-flash-error">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         OVERVIEW TAB
    ════════════════════════════════════════════════════ --}}
    @if($activeTab === 'overview')

    <div class="ep-ov-grid">

        {{-- LEFT COLUMN --}}
        <div class="ep-ov-left">

            {{-- HERO CARD --}}
            <div class="ep-hero">
                <div class="ep-hero-cover"></div>
                <div class="ep-hero-body">
                    <div class="ep-hero-row">
                        <div class="ep-hero-left">
                            <div class="ep-av">
                                @if($employee && $employee->profile_photo)
                                    <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="{{ $employee->full_name }}">
                                @elseif($employee)
                                    {{ substr($employee->first_name,0,1) }}{{ substr($employee->last_name,0,1) }}
                                @else
                                    NA
                                @endif
                                <button class="ep-av-cam" type="button" onclick="document.getElementById('avatarFileInput').click()">
                                    <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                </button>
                                <span class="ep-av-online"></span>
                            </div>
                            <div class="ep-hero-name-col">
                                <div class="ep-hero-name">
                                    @if($employee)
                                        {{ $employee->full_name }}
                                    @else
                                        No Employee Data
                                    @endif
                                </div>
                                <div class="ep-hero-role">
                                    <strong>{{ \App\Models\Position::find($employee->position_id)?->name ?? 'No Position' }}</strong>
                                    &nbsp;·&nbsp;
                                    {{ \App\Models\Department::find($employee->department_id)?->name ?? 'No Department' }}
                                </div>
                                <div class="ep-hero-contacts" style="margin-top:8px;">
                                    @if($employee->email)
                                    <span class="ep-contact-pill">
                                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                        {{ $employee->email }}
                                    </span>
                                    @endif
                                    @if($employee->phone_number)
                                    <span class="ep-contact-pill">
                                        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.27 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8a16 16 0 0 0 7.92 7.92l1.35-1.35a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        {{ $employee->phone_number }}
                                    </span>
                                    @endif
                                    <span class="ep-contact-pill green">
                                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>

                {{-- Stats strip --}}
                <div class="ep-stat-strip">
                    <div class="ep-stat-cell">
                        <div class="ep-stat-cell-label">Employee ID</div>
                        <div class="ep-stat-cell-val" style="font-size:14px;font-weight:700;color:var(--ink2);">{{ $employee->employee_number ?? $employee->code }}</div>
                    </div>
                    <div class="ep-stat-cell">
                        <div class="ep-stat-cell-label">Hire Date</div>
                        <div class="ep-stat-cell-val" style="font-size:14px;font-weight:700;color:var(--ink2);">{{ $employee->join_date ? $employee->join_date->format('M d, Y') : '—' }}</div>
                    </div>
                    <div class="ep-stat-cell">
                        <div class="ep-stat-cell-label">Years of Service</div>
                        <div class="ep-stat-cell-val">
                            @if($employee->join_date)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $years = intval($employee->join_date->diffInYears($now));
                                    $totalMonths = intval($employee->join_date->diffInMonths($now));
                                    $months = $totalMonths - ($years * 12);
                                @endphp
                               @if($years > 0)
    {{ $years }} yr{{ $years != 1 ? 's' : '' }}
@endif
@if($years > 0 && $months > 0)
    {{ $months }} month{{ $months != 1 ? 's' : '' }}
@endif
@if($years == 0 && $months > 0)
    {{ $months }} month{{ $months != 1 ? 's' : '' }}
@endif
                            @else
                                0 yrs
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- BASIC INFORMATION --}}
            <div class="ep-info-card">
                <div class="ep-info-card-hd">
                    <div class="ep-info-card-title">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Personal Information
                    </div>
                </div>
                <div class="ep-info-card-body">
                    <div class="ep-info-grid">
                        <div class="ep-info-item">
                            <label>First Name</label>
                            <p>{{ $employee->first_name ?: '—' }}</p>
                        </div>
                        <div class="ep-info-item">
                            <label>Last Name</label>
                            <p>{{ $employee->last_name ?: '—' }}</p>
                        </div>
                        <div class="ep-info-item">
                            <label>Gender</label>
                            <p>{{ $employee->gender ? ucfirst($employee->gender) : '—' }}</p>
                        </div>
                        <div class="ep-info-item">
                            <label>Date of Birth</label>
                            <p>
                                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $employee->birth_date ? $employee->birth_date->format('M d, Y') : '—' }}
                            </p>
                        </div>
                        <div class="ep-info-item">
                            <label>Nationality</label>
                            <p>{{ $employee->nationality ?: '—' }}</p>
                        </div>
                        <div class="ep-info-item">
                            <label>National ID</label>
                            <p>{{ $employee->national_id ?: '—' }}</p>
                        </div>
                        <div class="ep-info-item col-span-3">
                            <label>Address</label>
                            <p>{{ implode(', ', array_filter([$employee->address, $employee->city, $employee->state, $employee->country])) ?: '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- OCCUPATION INFORMATION --}}
            <div class="ep-info-card">
                <div class="ep-info-card-hd">
                    <div class="ep-info-card-title">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        Occupation Information
                    </div>
                    <button class="ep-btn ep-btn-primary ep-btn-sm" wire:click="openEditModal">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Edit Profile
                    </button>
                </div>
                <div class="ep-info-card-body">
                    <div class="ep-info-grid ep-info-grid-2">
                        <div class="ep-info-item">
                            <label>Department</label>
                            <p>
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                {{ \App\Models\Department::find($employee->department_id)?->name ?? '—' }}
                            </p>
                        </div>
                        <div class="ep-info-item">
                            <label>Position / Role</label>
                            <p>
                                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                {{ \App\Models\Position::find($employee->position_id)?->name ?? '—' }}
                            </p>
                        </div>
                        <div class="ep-info-item">
                            <label>Contract Type</label>
                            <p>
                                @php
                                    $firstContract = $contracts->first();
                                    $category = $firstContract ? $firstContract->employee_category : null;
                                    $categoryValue = $category instanceof \App\Enum\EmployeeCategory ? $category->value : ($category ?? 'Not specified');
                                @endphp
                                @if($categoryValue === 'full_time')Full Time
                                @elseif($categoryValue === 'part_time')Part Time
                                @elseif($categoryValue === 'contract')Contract
                                @elseif($categoryValue === 'intern')Intern
                                @elseif($categoryValue === 'consultant')Consultant
                                @elseif($categoryValue === 'temporary')Temporary
                                @elseif($categoryValue === 'freelance')Freelance
                                @else{{ ucfirst($categoryValue ?? '—') }}
                                @endif
                            </p>
                        </div>
                        <div class="ep-info-item">
                            <label>Employment Status</label>
                            <p><span class="ep-badge ep-badge-green">Active</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /ep-ov-left --}}

        {{-- RIGHT COLUMN --}}
        <div class="ep-ov-right">

            {{-- MINI CALENDAR --}}
            <div class="ep-cal">
                <div class="ep-cal-hd">
                    <button class="ep-cal-nav" id="calPrev">‹</button>
                    <div class="ep-cal-month" id="calTitle">March 2026</div>
                    <button class="ep-cal-nav" id="calNext">›</button>
                </div>
                <div class="ep-cal-body">
                    <div class="ep-cal-dow">
                        <span>Su</span><span>Mo</span><span>Tu</span><span>We</span>
                        <span>Th</span><span>Fr</span><span>Sa</span>
                    </div>
                    <div class="ep-cal-days" id="calDays"></div>
                </div>
            </div>

            {{-- TODAY'S TASKS --}}
            <div class="ep-tasks">
                <div class="ep-tasks-hd">
                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12l2 2 4-4"/></svg>
                    Today's Tasks
                </div>
                <div class="ep-task-item">
                    <div class="ep-task-dot blue"></div>
                    <div>
                        <div class="ep-task-text">Submit Q1 performance report</div>
                        <div class="ep-task-when">Due today · HR Dept</div>
                    </div>
                </div>
                <div class="ep-task-item">
                    <div class="ep-task-dot green"></div>
                    <div>
                        <div class="ep-task-text">Team standup meeting</div>
                        <div class="ep-task-when">9:00 AM · Conference Room B</div>
                    </div>
                </div>
                <div class="ep-task-item">
                    <div class="ep-task-dot amber"></div>
                    <div>
                        <div class="ep-task-text">Update emergency contact info</div>
                        <div class="ep-task-when">Pending · HR Request</div>
                    </div>
                </div>
                <div class="ep-task-item">
                    <div class="ep-task-dot blue"></div>
                    <div>
                        <div class="ep-task-text">Sign renewed contract</div>
                        <div class="ep-task-when">Deadline: end of week</div>
                    </div>
                </div>
            </div>

            {{-- EMPLOYMENT HISTORY (mini) --}}
            <div class="ep-hist-right">
                <div class="ep-hist-hd">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Employment History
                </div>
                @if($employmentHistory->isNotEmpty())
                    @foreach($employmentHistory->take(3) as $item)
                        <div class="ep-hist-item">
                            <div class="ep-hist-line">
                                <div class="ep-hist-dot"></div>
                                @if(!$loop->last)<div class="ep-hist-connector"></div>@endif
                            </div>
                            <div class="ep-hist-body">
                                <div class="ep-hist-title">{{ $item['title'] }}</div>
                                <div class="ep-hist-company">{{ $item['company'] }}</div>
                                <div class="ep-hist-period">{{ $item['period'] }}</div>
                            </div>
                        </div>
                    @endforeach
                    @if($employmentHistory->count() > 3)
                        <div style="padding:10px 16px;text-align:center;">
                            <button class="ep-btn ep-btn-ghost ep-btn-sm" wire:click="setActiveTab('history')">
                                View all {{ $employmentHistory->count() }} roles
                            </button>
                        </div>
                    @endif
                @else
                    <div class="ep-empty" style="padding:24px 16px;">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <strong>No history yet</strong>
                    </div>
                @endif
            </div>

        </div>{{-- /ep-ov-right --}}
    </div>{{-- /ep-ov-grid --}}
    @endif

    {{-- ════════════════════════════════════════════════════
         CONTRACTS TAB
    ════════════════════════════════════════════════════ --}}
    @if($activeTab === 'contracts')
    <div class="ep-toolbar">
        <div>
            <div class="ep-toolbar-title">Employment Contracts</div>
            <div class="ep-toolbar-sub">{{ $contracts->count() }} contract(s) on file</div>
        </div>
    </div>

    @if($contracts->isNotEmpty())
        @foreach($contracts as $contract)
            @php
                $s = $contract->status->value ?? 'unknown';
                $start = $contract->start_date;
                $end   = $contract->end_date;
                $totalDays = $end ? $start->diffInDays($end) : null;
                $elapsed   = $end ? min($start->diffInDays(now()), $totalDays) : null;
                $pct       = ($totalDays && $totalDays > 0) ? round(($elapsed / $totalDays) * 100) : null;
            @endphp
            <div class="ep-contract-card">
                <div class="ep-contract-hd">
                    <div class="ep-contract-hd-left">
                        <div class="ep-contract-icon">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div>
                            <div class="ep-contract-type">
                                @php
                                    $category = $contract->employee_category;
                                    $categoryValue = $category instanceof \App\Enum\EmployeeCategory ? $category->value : $category;
                                @endphp
                                @if($categoryValue === 'full_time')Full Time
                                @elseif($categoryValue === 'part_time')Part Time
                                @elseif($categoryValue === 'contract')Contract
                                @elseif($categoryValue === 'intern')Intern
                                @elseif($categoryValue === 'consultant')Consultant
                                @elseif($categoryValue === 'temporary')Temporary
                                @elseif($categoryValue === 'freelance')Freelance
                                @else{{ ucfirst($categoryValue ?? 'Employment Contract') }}
                                @endif
                            </div>
                            <div class="ep-contract-num">{{ $employee->employee_number ?? $employee->code }}</div>
                        </div>
                    </div>
                    <span class="ep-badge {{ $s === 'active' ? 'ep-badge-green' : 'ep-badge-gray' }}" style="align-self:center;">
                        @if($s === 'active')<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>@endif
                        {{ ucfirst($s) }}
                    </span>
                </div>
                <div class="ep-contract-body">
                    <div class="ep-contract-meta">
                        <div class="ep-contract-meta-item">
                            <label>Start Date</label>
                            <p>{{ $start->format('M d, Y') }}</p>
                        </div>
                        <div class="ep-contract-meta-item">
                            <label>End Date</label>
                            <p>{{ $end ? $end->format('M d, Y') : 'Present' }}</p>
                        </div>
                        <div class="ep-contract-meta-item">
                            <label>Position</label>
                            <p>{{ \App\Models\Position::find($contract->position_id)?->name ?? '—' }}</p>
                        </div>
                        <div class="ep-contract-meta-item">
                            <label>Duration</label>
                            <p>{{ $end ? $start->diffInMonths($end) . ' months' : 'Ongoing' }}</p>
                        </div>
                    </div>
                    @if($pct !== null)
                    <div class="ep-contract-progress-wrap">
                        <div class="ep-contract-progress-label">
                            <span>Contract progress</span>
                            <span>{{ $pct }}%</span>
                        </div>
                        <div class="ep-contract-bar">
                            <div class="ep-contract-bar-fill" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="ep-contract-footer">
                    <span style="font-size:12px;color:var(--ink4);font-weight:500;">
                        @if($end && $end->isFuture())
                            Expires {{ $end->diffForHumans() }}
                        @elseif($end && $end->isPast())
                            Expired {{ $end->diffForHumans() }}
                        @else
                            Open-ended contract
                        @endif
                    </span>
                   
                </div>
            </div>
        @endforeach
    @else
        <div class="ep-card">
            <div class="ep-empty">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <strong>No contracts on file</strong>
                Contact HR to add your employment contract.
            </div>
        </div>
    @endif
    @endif

    {{-- ════════════════════════════════════════════════════
         DOCUMENTS TAB
    ════════════════════════════════════════════════════ --}}
    @if($activeTab === 'documents')
    <div class="ep-toolbar">
        <div>
            <div class="ep-toolbar-title">My Documents</div>
            <div class="ep-toolbar-sub">{{ $documents->count() }} document(s) uploaded</div>
        </div>
        <div style="display: flex; gap: 8px;">
           
            <button class="ep-btn ep-btn-primary" wire:click="$set('showDocumentModal', true)">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Upload Document
            </button>
        </div>
    </div>

   

    @if($documents->isNotEmpty())
        <div class="ep-doc-grid">
            @foreach($documents as $document)
                @php
                    $ext = pathinfo($document->file_path ?? '', PATHINFO_EXTENSION);
                @endphp
                <div class="ep-doc-card-v2">
                    <div class="ep-doc-card-top">
                        <svg viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                        @if($ext)<span class="ep-doc-ext">{{ strtoupper($ext) }}</span>@endif
                    </div>
                    <div class="ep-doc-card-info">
                        <a href="{{ asset('storage/' . $document->file_path) }}"
                           target="_blank" class="ep-doc-card-name"
                           title="{{ $document->name }}">
                           {{ $document->name }}
                        </a>
                        <div class="ep-doc-card-date">Uploaded {{ $document->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="ep-doc-card-footer">
                        <button class="ep-btn ep-btn-ghost ep-btn-sm"
                                wire:click="viewDocument('{{ $document->id }}')">
                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            View
                        </button>
                        
                        <button class="ep-btn ep-btn-danger ep-btn-sm"
                                wire:click="deleteDocument('{{ $document->id }}')">
                            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="ep-card">
            <div class="ep-empty">
                <svg viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                <strong>No documents uploaded yet</strong>
                Use the upload button or drag files above.
            </div>
        </div>
    @endif
    @endif

    {{-- ════════════════════════════════════════════════════
         EMERGENCY CONTACTS TAB
    ════════════════════════════════════════════════════ --}}
    @if($activeTab === 'emergency')
    <div class="ep-toolbar">
        <div>
            <div class="ep-toolbar-title">Emergency Contacts</div>
            <div class="ep-toolbar-sub">{{ $emergencyContacts->count() }} contact(s) on file</div>
        </div>
        <button class="ep-btn ep-btn-primary" wire:click="$set('showContactModal', true)">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Contact
        </button>
    </div>

    @if($emergencyContacts->isNotEmpty())
        @foreach($emergencyContacts as $contact)
            @php $initials = strtoupper(substr($contact->name, 0, 1)) . (strpos($contact->name, ' ') !== false ? strtoupper(substr($contact->name, strpos($contact->name,' ')+1, 1)) : ''); @endphp
            <div class="ep-ec-card">
                <div class="ep-ec-hd">
                    <div class="ep-ec-av">{{ $initials }}</div>
                    <div style="flex:1;">
                        <div class="ep-ec-name">{{ $contact->name }}</div>
                        <span class="ep-ec-rel">{{ $contact->relationship }}</span>
                    </div>
                    <span class="ep-badge ep-badge-blue">Primary</span>
                </div>
                <div class="ep-ec-body">
                    <div class="ep-ec-field">
                        <label>Phone Number</label>
                        <p>
                            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.27 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8a16 16 0 0 0 7.92 7.92l1.35-1.35a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $contact->phone }}
                        </p>
                    </div>
                    <div class="ep-ec-field">
                        <label>Email Address</label>
                        <p>
                            @if($contact->email)
                                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                {{ $contact->email }}
                            @else
                                <span style="color:var(--ink4);font-style:italic;font-weight:400;">Not provided</span>
                            @endif
                        </p>
                    </div>
                    <div class="ep-ec-field">
                        <label>Relationship</label>
                        <p>{{ $contact->relationship }}</p>
                    </div>
                </div>
                <div class="ep-ec-footer">
                    <button class="ep-btn ep-btn-ghost ep-btn-sm"
                            wire:click="editEmergencyContact('{{ $contact->id }}')">
                        <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Edit
                    </button>
                    <button class="ep-btn ep-btn-danger ep-btn-sm"
                            wire:click="deleteEmergencyContact('{{ $contact->id }}')">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    @else
        <div class="ep-card">
            <div class="ep-empty">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <strong>No emergency contacts added</strong>
                Add a contact so HR can reach someone in an emergency.
            </div>
        </div>
    @endif
    @endif

    {{-- ════════════════════════════════════════════════════
         EMPLOYMENT HISTORY TAB
    ════════════════════════════════════════════════════ --}}
    @if($activeTab === 'history')
    <div class="ep-toolbar">
        <div>
            <div class="ep-toolbar-title">Employment History</div>
            <div class="ep-toolbar-sub">{{ $employmentHistory->count() }} role(s) on record</div>
        </div>
    </div>

    @if($employmentHistory->isNotEmpty())
        <div class="ep-hist-full">
            @foreach($employmentHistory as $item)
                <div class="ep-hist-full-item">
                    <div class="ep-hist-timeline">
                        <div class="ep-hist-full-dot"></div>
                        @if(!$loop->last)<div class="ep-hist-full-line"></div>@endif
                    </div>
                    <div class="ep-hist-full-card">
                        <div class="ep-hist-full-card-hd">
                            <div>
                                <div class="ep-hist-full-role">{{ $item['title'] }}</div>
                                <div class="ep-hist-full-company">{{ $item['company'] }}</div>
                            </div>
                            <span class="ep-badge {{ $loop->first ? 'ep-badge-green' : 'ep-badge-gray' }}">
                                {{ $loop->first ? 'Current' : 'Past' }}
                            </span>
                        </div>
                        <div class="ep-hist-full-body">
                            <div class="ep-hist-full-field">
                                <label>Period</label>
                                <p>{{ $item['period'] }}</p>
                            </div>
                            <div class="ep-hist-full-field">
                                <label>Employment Type</label>
                                <p>{{ $item['type'] }}</p>
                            </div>
                            <div class="ep-hist-full-field">
                                <label>Department</label>
                                <p>{{ $item['department'] ?? \App\Models\Department::find($employee->department_id)?->name ?? '—' }}</p>
                            </div>
                        </div>
                        @if(!empty($item['description']))
                            <div class="ep-hist-desc">{{ $item['description'] }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="ep-card">
            <div class="ep-empty">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <strong>No employment history recorded</strong>
                Your work history will appear here once added by HR.
            </div>
        </div>
    @endif
    @endif

</div>{{-- /ep-main --}}
</div>{{-- /ep-shell --}}

{{-- ══ DOCUMENT UPLOAD MODAL ══ --}}
@if($showDocumentModal)
<div class="ep-modal-bg">
    <div class="ep-modal">
        <div class="ep-modal-hd">
            <div class="ep-modal-title">Upload Document</div>
            <button class="ep-modal-close" wire:click="$set('showDocumentModal', false)">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="uploadDocument">
            <div class="ep-modal-body">
                <div class="ep-field">
                    <label>Document Name</label>
                    <input type="text" wire:model="documentName" placeholder="e.g. Offer Letter, ID Copy…" required>
                    @error('documentName') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="ep-field">
                    <label>File</label>
                    <input type="file" wire:model="documentFile" required>
                    @error('documentFile') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="ep-modal-footer">
                <button type="button" class="ep-btn ep-btn-outline" wire:click="$set('showDocumentModal', false)">Cancel</button>
                <button type="submit" class="ep-btn ep-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ EMERGENCY CONTACT MODAL ══ --}}
@if($showContactModal)
<div class="ep-modal-bg">
    <div class="ep-modal">
        <div class="ep-modal-hd">
            <div class="ep-modal-title">
    {{ $editingContactId ? 'Edit Emergency Contact' : 'Add Emergency Contact' }}
</div>
            <button class="ep-modal-close" wire:click="$set('showContactModal', false)">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="addEmergencyContact">
            <div class="ep-modal-body">
                <div class="ep-field">
                    <label>Full Name</label>
                    <input type="text" wire:model="contactName" placeholder="Contact's full name" required>
                    @error('contactName') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="ep-field-grid">
                    <div class="ep-field">
                        <label>Relationship</label>
                        <input type="text" wire:model="contactRelationship" placeholder="e.g. Spouse, Parent…" required>
                        @error('contactRelationship') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="ep-field">
                        <label>Phone Number</label>
                        <input type="text" wire:model="contactPhone" placeholder="+250 700 000 000" required>
                        @error('contactPhone') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="ep-field">
                    <label>Email Address (optional)</label>
                    <input type="email" wire:model="contactEmail" placeholder="contact@email.com">
                    @error('contactEmail') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="ep-modal-footer">
                <button type="button" class="ep-btn ep-btn-outline" wire:click="$set('showContactModal', false)">Cancel</button>
                <button type="submit" class="ep-btn ep-btn-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Contact
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ EDIT PROFILE MODAL ══ --}}
@if($showEditModal)
<div class="ep-modal-bg">
    <div class="ep-modal ep-modal-wide">
        <div class="ep-modal-hd">
            <div class="ep-modal-title">Edit Profile</div>
            <button class="ep-modal-close" wire:click="$set('showEditModal', false)">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form wire:submit="updateProfile" enctype="multipart/form-data">
            <div class="ep-modal-body">
                <div class="ep-upload-av">
                    <div class="ep-upload-av-circle">
                        @if($employee->profile_photo)
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="">
                        @else
                            {{ substr($employee->first_name,0,1) }}{{ substr($employee->last_name,0,1) }}
                        @endif
                    </div>
                    <label for="profilePhoto" class="ep-upload-av-lbl">
                        <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        Change Photo
                    </label>
                    <input type="file" id="profilePhoto" wire:model="profilePhoto" style="display:none;" accept="image/*">
                    @if($profilePhoto)
                        <div class="ep-upload-av-hint" style="color:var(--blue-2);">{{ $profilePhoto->getClientOriginalName() }}</div>
                    @else
                        <div class="ep-upload-av-hint">JPG, PNG — max 2 MB</div>
                    @endif
                    @error('profilePhoto') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>

                <div class="ep-field-grid">
                    <div class="ep-field">
                        <label>First Name</label>
                        <input type="text" wire:model="editFirstName" required>
                        @error('editFirstName') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="ep-field">
                        <label>Last Name</label>
                        <input type="text" wire:model="editLastName" required>
                        @error('editLastName') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="ep-field">
                    <label>Email Address</label>
                    <input type="email" wire:model="editEmail" required>
                    @error('editEmail') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="ep-field">
                    <label>Phone Number</label>
                    <input type="text" wire:model="editPhone">
                    @error('editPhone') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="ep-field-grid">
                    <div class="ep-field">
                        <label>Gender</label>
                        <select wire:model="editGender">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @error('editGender') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="ep-field">
                        <label>Date of Birth</label>
                        <input type="date" wire:model="editBirthDate">
                        @error('editBirthDate') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="ep-field">
                    <label>Address</label>
                    <input type="text" wire:model="editAddress" placeholder="Street address">
                    @error('editAddress') <div class="ep-field-error">{{ $message }}</div> @enderror
                </div>
                <div class="ep-field-grid-3">
                    <div class="ep-field">
                        <label>City</label>
                        <input type="text" wire:model="editCity">
                        @error('editCity') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="ep-field">
                        <label>State / Province</label>
                        <input type="text" wire:model="editState">
                        @error('editState') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="ep-field">
                        <label>Country</label>
                        <input type="text" wire:model="editCountry">
                        @error('editCountry') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="ep-field-grid">
                    <div class="ep-field">
                        <label>Nationality</label>
                        <input type="text" wire:model="editNationality">
                        @error('editNationality') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="ep-field">
                        <label>National ID</label>
                        <input type="text" wire:model="editNationalId">
                        @error('editNationalId') <div class="ep-field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="ep-modal-footer">
                <button type="button" class="ep-btn ep-btn-outline" wire:click="$set('showEditModal', false)">Cancel</button>
                <button type="submit" class="ep-btn ep-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ CALENDAR SCRIPT ══ --}}
<script>
(function(){
    var today = new Date();
    var cur   = new Date(today.getFullYear(), today.getMonth(), 1);

    var events = [5, 12, 18, 25, 29]; // demo event days

    function render() {
        var y = cur.getFullYear();
        var m = cur.getMonth();
        var firstDay = new Date(y, m, 1).getDay();
        var daysInMonth = new Date(y, m+1, 0).getDate();
        var daysInPrev  = new Date(y, m, 0).getDate();

        var names = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        var title = document.getElementById('calTitle');
        var grid  = document.getElementById('calDays');
        if (!title || !grid) return;

        title.textContent = names[m] + ' ' + y;
        grid.innerHTML = '';

        // Prev month tail
        for (var i = firstDay - 1; i >= 0; i--) {
            var d = document.createElement('div');
            d.className = 'ep-cal-day other';
            d.textContent = daysInPrev - i;
            grid.appendChild(d);
        }

        // Current month
        for (var day = 1; day <= daysInMonth; day++) {
            var d = document.createElement('div');
            var cls = 'ep-cal-day';
            if (day === today.getDate() && m === today.getMonth() && y === today.getFullYear()) cls += ' today';
            if (events.indexOf(day) !== -1) cls += ' has-event';
            d.className = cls;
            d.textContent = day;
            grid.appendChild(d);
        }

        // Next month fill
        var total = firstDay + daysInMonth;
        var remaining = total % 7 === 0 ? 0 : 7 - (total % 7);
        for (var j = 1; j <= remaining; j++) {
            var d = document.createElement('div');
            d.className = 'ep-cal-day other';
            d.textContent = j;
            grid.appendChild(d);
        }
    }

    function init() {
        render();
        var prev = document.getElementById('calPrev');
        var next = document.getElementById('calNext');
        if (prev) prev.onclick = function() { cur.setMonth(cur.getMonth()-1); render(); };
        if (next) next.onclick = function() { cur.setMonth(cur.getMonth()+1); render(); };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    document.addEventListener('livewire:navigated', init);
})();

/* ── Handle Document Download Events ── */
document.addEventListener('livewire:init', () => {
    Livewire.on('downloadDocument', (e) => {
        console.log('downloadDocument event received:', e);
        
        // Method 1: Try direct download link (no CSRF needed for GET)
        const downloadUrl = `/employee/documents/download/${e.documentId}`;
        console.log('Attempting download via:', downloadUrl);
        
        // Create a temporary link element
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.style.display = 'none';
        link.download = ''; // This suggests it's a download
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Fallback: If direct link doesn't work, try form submission
        setTimeout(() => {
            console.log('Fallback: trying POST method');
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/employee/documents/download';
            form.style.display = 'none';
            
            // Add CSRF token from multiple possible sources
            let csrfToken = null;
            
            // Try meta tag first
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                csrfToken = metaTag.getAttribute('content');
            }
            
            // Try input field
            if (!csrfToken) {
                const csrfInput = document.querySelector('input[name="_token"]');
                if (csrfInput) {
                    csrfToken = csrfInput.value;
                }
            }
            
            // Try Livewire's CSRF token
            if (!csrfToken && window.Livewire) {
                const livewireCsrf = document.querySelector('[data-csrf]');
                if (livewireCsrf) {
                    csrfToken = livewireCsrf.getAttribute('data-csrf');
                }
            }
            
            console.log('CSRF token found:', csrfToken ? 'yes' : 'no');
            
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
            }
            
            // Add document ID
            const documentIdInput = document.createElement('input');
            documentIdInput.type = 'hidden';
            documentIdInput.name = 'document_id';
            documentIdInput.value = e.documentId;
            form.appendChild(documentIdInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }, 1000);
    });
});
</script>

{{-- Document View Modal --}}
@if($selectedDocument)
<div class="ep-modal-overlay" wire:click="closeDocumentModal">
    <div class="ep-modal-content ep-modal-large" wire:click.stop>
        <div class="ep-modal-header">
            <h3>Document Viewer</h3>
            <button class="ep-modal-close" wire:click="closeDocumentModal">×</button>
        </div>
        <div class="ep-modal-body">
            <div class="ep-doc-viewer">
                <div class="ep-doc-viewer-header">
                    <h4>{{ $selectedDocument->name }}</h4>
                    <div class="ep-doc-viewer-actions">
                        <button class="ep-btn ep-btn-ghost ep-btn-sm" wire:click="downloadDocument('{{ $selectedDocument->id }}')">
                            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download PDF
                        </button>
                        <a href="{{ asset('storage/' . $selectedDocument->file_path) }}" 
                           target="_blank" class="ep-btn ep-btn-primary ep-btn-sm">
                            <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Open Original
                        </a>
                    </div>
                </div>
                <div class="ep-doc-viewer-content">
                    @php
                        $ext = strtolower(pathinfo($selectedDocument->file_path, PATHINFO_EXTENSION));
                    @endphp
                    
                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                        <div class="ep-doc-image-view">
                            @php
                                $imagePath = storage_path('app/public/' . $selectedDocument->file_path);
                                $imageUrl = asset('storage/' . $selectedDocument->file_path);
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $selectedDocument->name }}" 
                                 style="max-width: 100%; max-height: 500px; border-radius: 8px;" />
                        </div>
                    @elseif($ext === 'pdf')
                        <div class="ep-doc-pdf-view">
                            <iframe src="{{ asset('storage/' . $selectedDocument->file_path) }}" 
                                    style="width: 100%; height: 500px; border: 1px solid #e8eaf0; border-radius: 8px;"
                                    title="{{ $selectedDocument->name }}"></iframe>
                        </div>
                    @elseif(in_array($ext, ['txt', 'rtf', 'doc', 'docx']))
                        <div class="ep-doc-text-view">
                            <div class="ep-doc-preview">
                                @php
                                    $filePath = storage_path('app/public/' . $selectedDocument->file_path);
                                    if (file_exists($filePath)) {
                                        $content = file_get_contents($filePath);
                                        if ($ext === 'txt' || $ext === 'rtf') {
                                            $content = preg_replace('/\\{\\\\[^}]*\\}/', '', $content);
                                            $content = strip_tags($content);
                                        }
                                        $preview = substr($content, 0, 2000);
                                    } else {
                                        $preview = 'File not found or cannot be read.';
                                    }
                                @endphp
                                <pre style="white-space: pre-wrap; word-wrap: break-word; font-family: monospace; font-size: 12px; line-height: 1.4;">{{ $preview }}</pre>
                                @if(isset($content) && strlen($content) > 2000)
                                    <p style="margin-top: 10px; color: #6B7094; font-size: 11px;">
                                        <em>Document preview truncated. Download to view full content.</em>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="ep-doc-unsupported">
                            <div style="text-align: center; padding: 40px; color: #6B7094;">
                                <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; margin-bottom: 16px; opacity: 0.5;">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                                </svg>
                                <p><strong>Preview not available</strong></p>
                                <p>This file type ({{ strtoupper($ext) }}) cannot be previewed in the browser.</p>
                                <p style="margin-top: 16px;">
                                    <button class="ep-btn ep-btn-primary" wire:click="downloadDocument('{{ $selectedDocument->id }}')">
                                        Download to View
                                    </button>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="ep-doc-viewer-footer">
                    <div style="font-size: 11px; color: #6B7094;">
                        @php
                            $filePath = storage_path('app/public/' . $selectedDocument->file_path);
                            $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                        @endphp
                        Uploaded: {{ $selectedDocument->created_at->format('M d, Y H:i') }} | 
                        Size: {{ number_format($fileSize / 1024, 2) }} KB
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

</div>{{-- /ep-root --}}