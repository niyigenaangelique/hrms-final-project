{{--
    Shared styles for all admin content pages.
    Include at top of every admin page blade:
    <x-admin-content-styles />
--}}
<style>
/* ══ THEME VARIABLES ════════════════════════════════════ */
:root {
    --blue:     #3B82F6; --blue-lt:  rgba(59,130,246,0.10); --blue-brd: rgba(59,130,246,0.22);
    --indigo:   #6366F1; --indigo-lt:rgba(99,102,241,0.10);
    --green:    #10B981; --green-lt: rgba(16,185,129,0.10);
    --amber:    #F59E0B; --amber-lt: rgba(245,158,11,0.10);
    --red:      #EF4444; --red-lt:   rgba(239,68,68,0.10);
    --purple:   #A855F7; --purple-lt:rgba(168,85,247,0.10);
    --cyan:     #06B6D4; --cyan-lt:  rgba(6,182,212,0.10);
    --teal:     #14B8A6; --teal-lt:  rgba(20,184,166,0.10);
    --r: 12px; --r-lg: 16px;
    --sh-sm: 0 1px 8px rgba(0,0,0,0.06);
    --sh-md: 0 4px 20px rgba(0,0,0,0.10);
}

/* ── Light theme (default) ───────────────────────────── */
[data-theme="light"] {
    --ink:    #0F172A; --ink2: #1E293B; --ink3: #475569; --ink4: #94A3B8;
    --border: rgba(15,23,42,0.08);
    --bg:     #F8FAFC;
    --surface:  #FFFFFF;
    --surface2: #F1F5F9;
    --toggle-track: rgba(15,23,42,0.12);
}

/* ── Dark theme ──────────────────────────────────────── */
[data-theme="dark"] {
    --ink:    #F1F5F9; --ink2: #CBD5E1; --ink3: #94A3B8; --ink4: #64748B;
    --border: rgba(255,255,255,0.09);
    --bg:     #0F172A;
    --surface:  #1E293B;
    --surface2: #0F172A;
    --toggle-track: rgba(255,255,255,0.12);
}

/* ══ ADMIN CONTENT ROOT ═════════════════════════════════ */
.ac-root {
    font-family: 'DM Sans', -apple-system, sans-serif;
    color: var(--ink);
    background: var(--bg);
    padding: 28px 32px 56px;
    display: flex; flex-direction: column; gap: 22px;
    min-height: 100vh;
    transition: background .25s, color .25s;
}

/* ── Page header ─────────────────────────────────────── */
.ac-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
.ac-header-title { font-size: 22px; font-weight: 800; color: var(--ink); letter-spacing: -.03em; font-family: 'DM Sans', sans-serif; }
.ac-header-sub { font-size: 13px; color: var(--ink3); margin-top: 3px; }

/* ── Theme toggle switch ─────────────────────────────── */
.ac-theme-switch { display: inline-flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; }
.ac-theme-switch-track { width: 52px; height: 28px; border-radius: 100px; background: var(--toggle-track); border: 1.5px solid var(--border); position: relative; transition: background .25s, border-color .25s; flex-shrink: 0; }
.ac-theme-switch-thumb { position: absolute; width: 20px; height: 20px; border-radius: 50%; background: #fff; top: 3px; left: 3px; transition: transform .25s; box-shadow: 0 1px 4px rgba(0,0,0,0.18); display: flex; align-items: center; justify-content: center; font-size: 11px; line-height: 1; }
[data-theme="dark"] .ac-theme-switch-track { background: var(--indigo); border-color: var(--indigo); }
[data-theme="dark"] .ac-theme-switch-thumb { transform: translateX(24px); }
.ac-theme-switch-lbl { font-size: 12px; font-weight: 700; color: var(--ink3); letter-spacing: .04em; text-transform: uppercase; transition: color .25s; }

/* ── Flash ───────────────────────────────────────────── */
.ac-flash { padding: 11px 16px; border-radius: var(--r); font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.ac-flash svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.ac-flash-ok  { background: var(--green-lt); border: 1px solid rgba(16,185,129,0.22); color: #065F46; }
.ac-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #7F1D1D; }

/* ── Stat tiles ──────────────────────────────────────── */
.ac-tiles { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
.ac-tile { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 18px 20px; display: flex; align-items: flex-start; gap: 14px; box-shadow: var(--sh-sm); position: relative; overflow: hidden; transition: box-shadow .15s, transform .15s, background .25s; }
.ac-tile:hover { box-shadow: var(--sh-md); transform: translateY(-1px); }
.ac-tile::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius: var(--r-lg) var(--r-lg) 0 0; }
.ac-tile-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ac-tile-icon svg { width: 19px; height: 19px; fill: none; stroke-width: 2; }
.ac-tile-lbl { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); margin-bottom: 4px; }
.ac-tile-val { font-size: 28px; font-weight: 800; letter-spacing: -.04em; line-height: 1; }
.ac-tile-sub { font-size: 11.5px; color: var(--ink4); margin-top: 4px; }

.ac-t-blue::before   { background: var(--blue); }    .ac-t-blue   .ac-tile-icon { background: var(--blue-lt); }    .ac-t-blue   .ac-tile-icon svg { stroke: var(--blue); }    .ac-t-blue   .ac-tile-val { color: var(--blue); }
.ac-t-indigo::before { background: var(--indigo); }  .ac-t-indigo .ac-tile-icon { background: var(--indigo-lt); }  .ac-t-indigo .ac-tile-icon svg { stroke: var(--indigo); }  .ac-t-indigo .ac-tile-val { color: var(--indigo); }
.ac-t-green::before  { background: var(--green); }   .ac-t-green  .ac-tile-icon { background: var(--green-lt); }   .ac-t-green  .ac-tile-icon svg { stroke: var(--green); }   .ac-t-green  .ac-tile-val { color: var(--green); }
.ac-t-amber::before  { background: var(--amber); }   .ac-t-amber  .ac-tile-icon { background: var(--amber-lt); }   .ac-t-amber  .ac-tile-icon svg { stroke: var(--amber); }   .ac-t-amber  .ac-tile-val { color: var(--amber); }
.ac-t-teal::before   { background: var(--teal); }    .ac-t-teal   .ac-tile-icon { background: var(--teal-lt); }    .ac-t-teal   .ac-tile-icon svg { stroke: var(--teal); }    .ac-t-teal   .ac-tile-val { color: var(--teal); }
.ac-t-cyan::before   { background: var(--cyan); }    .ac-t-cyan   .ac-tile-icon { background: var(--cyan-lt); }    .ac-t-cyan   .ac-tile-icon svg { stroke: var(--cyan); }    .ac-t-cyan   .ac-tile-val { color: var(--cyan); }
.ac-t-red::before    { background: var(--red); }     .ac-t-red    .ac-tile-icon { background: var(--red-lt); }     .ac-t-red    .ac-tile-icon svg { stroke: var(--red); }     .ac-t-red    .ac-tile-val { color: var(--red); }
.ac-t-purple::before { background: var(--purple); }  .ac-t-purple .ac-tile-icon { background: var(--purple-lt); }  .ac-t-purple .ac-tile-icon svg { stroke: var(--purple); }  .ac-t-purple .ac-tile-val { color: var(--purple); }

/* ── Card ────────────────────────────────────────────── */
.ac-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--sh-sm); overflow: hidden; transition: background .25s; }
.ac-card-hd { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.ac-card-title { font-size: 14px; font-weight: 800; color: var(--ink); }
.ac-card-sub   { font-size: 12px; color: var(--ink4); margin-top: 1px; }

/* ── Table ───────────────────────────────────────────── */
.ac-table-wrap { overflow-x: auto; }
table.ac-table { width: 100%; border-collapse: collapse; }
.ac-table thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
.ac-table th { padding: 10px 16px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.ac-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
.ac-table tbody tr:last-child { border-bottom: none; }
.ac-table tbody tr:hover { background: var(--surface2); }
.ac-table td { padding: 13px 16px; font-size: 13px; color: var(--ink2); vertical-align: middle; }

/* ── Avatar ──────────────────────────────────────────── */
.ac-av { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,var(--indigo),var(--blue)); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; color: #fff; flex-shrink: 0; }
.ac-user-cell { display: flex; align-items: center; gap: 10px; }
.ac-user-name { font-size: 13.5px; font-weight: 700; color: var(--ink); }
.ac-user-meta { font-size: 11.5px; color: var(--ink4); margin-top: 1px; }

/* ── Buttons ─────────────────────────────────────────── */
.ac-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all .15s; white-space: nowrap; }
.ac-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.ac-btn-primary { background: var(--indigo); color: #fff; box-shadow: 0 3px 12px rgba(99,102,241,0.30); }
.ac-btn-primary:hover { background: #4F46E5; transform: translateY(-1px); }
.ac-btn-teal    { background: var(--teal);   color: #fff; box-shadow: 0 3px 12px rgba(20,184,166,0.28); }
.ac-btn-teal:hover    { background: #0D9488; transform: translateY(-1px); }
.ac-btn-outline { background: var(--surface); color: var(--ink2); border: 1px solid var(--border); }
.ac-btn-outline:hover { border-color: var(--indigo); color: var(--indigo); }
.ac-btn-ghost   { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.ac-btn-ghost:hover   { background: rgba(59,130,246,0.18); }
.ac-btn-green   { background: var(--green-lt); color: #065F46; border: 1px solid rgba(16,185,129,0.22); }
.ac-btn-green:hover   { background: rgba(16,185,129,0.18); }
.ac-btn-amber   { background: var(--amber-lt); color: #78350F; border: 1px solid rgba(245,158,11,0.22); }
.ac-btn-amber:hover   { background: rgba(245,158,11,0.18); }
.ac-btn-danger  { background: var(--red-lt);  color: #7F1D1D; border: 1px solid rgba(239,68,68,0.22); }
.ac-btn-danger:hover  { background: rgba(239,68,68,0.18); }
.ac-btn-purple  { background: var(--purple-lt); color: #4C1D95; border: 1px solid rgba(168,85,247,0.22); }
.ac-btn-purple:hover  { background: rgba(168,85,247,0.18); }
.ac-btn-sm { padding: 5px 11px; font-size: 12px; }

/* ── Badge ───────────────────────────────────────────── */
.ac-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.ab-indigo { background: var(--indigo-lt); color: var(--indigo); }
.ab-blue   { background: var(--blue-lt);   color: var(--blue);   }
.ab-green  { background: var(--green-lt);  color: #065F46; }
.ab-amber  { background: var(--amber-lt);  color: #78350F; }
.ab-red    { background: var(--red-lt);    color: #7F1D1D; }
.ab-purple { background: var(--purple-lt); color: #4C1D95; }
.ab-teal   { background: var(--teal-lt);   color: #0F766E; }
.ab-cyan   { background: var(--cyan-lt);   color: #0E7490; }
.ab-gray   { background: var(--surface2);  color: var(--ink4); border: 1px solid var(--border); }

/* ── Search + Select ─────────────────────────────────── */
.ac-search { display: flex; align-items: center; gap: 8px; background: var(--surface2); border: 1.5px solid var(--border); border-radius: var(--r); padding: 8px 13px; min-width: 200px; flex: 1; transition: border-color .15s; }
.ac-search:focus-within { border-color: var(--indigo); box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.ac-search svg { width: 14px; height: 14px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.ac-search input { border: none; background: transparent; font-size: 13.5px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.ac-search input::placeholder { color: var(--ink4); }
.ac-sel { background: var(--surface2); border: 1.5px solid var(--border); border-radius: var(--r); padding: 8px 30px 8px 12px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; -webkit-appearance: none; }
.ac-sel:focus { border-color: var(--indigo); outline: none; }

/* ── Fields ──────────────────────────────────────────── */
.ac-field { display: flex; flex-direction: column; gap: 5px; }
.ac-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .09em; color: var(--ink4); }
.ac-field label .req { color: var(--red); }
.ac-field input, .ac-field select, .ac-field textarea { width: 100%; padding: 9px 13px; box-sizing: border-box; background: var(--surface2); border: 1.5px solid var(--border); border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--ink); outline: none; transition: border-color .15s, box-shadow .15s, background .25s; }
.ac-field input:focus, .ac-field select:focus, .ac-field textarea:focus { border-color: var(--indigo); box-shadow: 0 0 0 3px rgba(99,102,241,0.09); background: var(--surface); }
.ac-field input::placeholder, .ac-field textarea::placeholder { color: var(--ink4); }
.ac-field textarea { resize: vertical; min-height: 80px; }
.ac-field-err  { font-size: 11.5px; color: var(--red); font-weight: 600; }
.ac-field-hint { font-size: 11px; color: var(--ink4); }
.ac-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.ac-grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.ac-section-lbl { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .12em; color: var(--ink4); padding: 4px 0 2px; border-bottom: 1px solid var(--border); }

/* ── Toggle ──────────────────────────────────────────── */
.ac-toggle { width: 44px; height: 24px; border-radius: 100px; border: none; cursor: pointer; position: relative; transition: background .2s; flex-shrink: 0; background: var(--toggle-track); }
.ac-toggle::after { content:''; position:absolute; width:18px; height:18px; border-radius:50%; background:#fff; top:3px; left:3px; transition: transform .2s; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
.ac-toggle.on { background: var(--green); }
.ac-toggle.on::after { transform: translateX(20px); }
.ac-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); }
.ac-toggle-row:last-child { border-bottom: none; }
.ac-toggle-label { font-size: 13.5px; font-weight: 600; color: var(--ink); }
.ac-toggle-desc  { font-size: 12px; color: var(--ink4); margin-top: 2px; }

/* ── Modal ───────────────────────────────────────────── */
.ac-modal-bg { position: fixed; inset: 0; background: rgba(15,23,42,0.50); backdrop-filter: blur(8px); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.ac-modal { background: var(--surface); border-radius: var(--r-lg); box-shadow: var(--sh-md); border: 1px solid var(--border); width: 100%; max-width: 560px; max-height: 92vh; overflow-y: auto; display: flex; flex-direction: column; }
.ac-modal-sm { max-width: 420px; }
.ac-modal-hd { background: linear-gradient(105deg,#1E3A5F,var(--indigo) 80%); padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 2; border-radius: var(--r-lg) var(--r-lg) 0 0; }
.ac-modal-hd-left { display: flex; align-items: center; gap: 11px; }
.ac-modal-hd-icon { width: 36px; height: 36px; border-radius: 9px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; }
.ac-modal-hd-icon svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; }
.ac-modal-title { font-size: 15px; font-weight: 800; color: #fff; }
.ac-modal-sub   { font-size: 11.5px; color: rgba(255,255,255,.55); margin-top: 1px; }
.ac-modal-close { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.12); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; }
.ac-modal-close:hover { background: rgba(255,255,255,0.22); }
.ac-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }
.ac-modal-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 14px; }
.ac-modal-footer { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; position: sticky; bottom: 0; background: var(--surface); z-index: 2; }

/* ── Pager ───────────────────────────────────────────── */
.ac-pager { padding: 13px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
.ac-pager-info { font-size: 12px; color: var(--ink4); font-weight: 600; }

/* ── Notice ──────────────────────────────────────────── */
.ac-notice { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--r); font-size: 12.5px; font-weight: 600; }
.ac-notice svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; margin-top: 1px; }
.ac-notice-info  { background: var(--blue-lt);  border: 1px solid rgba(59,130,246,0.22);  color: #1E40AF; }
.ac-notice-warn  { background: var(--amber-lt); border: 1px solid rgba(245,158,11,0.22);  color: #78350F; }
.ac-notice-teal  { background: var(--teal-lt);  border: 1px solid rgba(20,184,166,0.22);  color: #0F766E; }

/* ── Log row ─────────────────────────────────────────── */
.ac-log-row { display: flex; align-items: flex-start; gap: 12px; padding: 13px 20px; border-bottom: 1px solid var(--border); }
.ac-log-row:last-child { border-bottom: none; }
.ac-log-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
.ac-log-desc { flex: 1; font-size: 13px; color: var(--ink2); line-height: 1.5; }
.ac-log-desc strong { color: var(--ink); font-weight: 700; }
.ac-log-time { font-size: 11.5px; color: var(--ink4); white-space: nowrap; font-family: 'DM Mono', monospace; }

/* ── Empty ───────────────────────────────────────────── */
.ac-empty { padding: 56px 32px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 10px; }
.ac-empty-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--indigo-lt); display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.ac-empty-icon svg { width: 22px; height: 22px; stroke: var(--indigo); fill: none; stroke-width: 1.5; }
.ac-empty-ttl { font-size: 15px; font-weight: 800; color: var(--ink2); }
.ac-empty-sub { font-size: 13px; color: var(--ink4); }

/* ── Password display ────────────────────────────────── */
.ac-pw-display { font-family: 'DM Mono', 'Courier New', monospace; font-size: 22px; font-weight: 700; color: var(--teal); letter-spacing: .14em; text-align: center; padding: 16px; background: linear-gradient(135deg,#F0FDFA,#ECFEFF); border: 1.5px dashed rgba(20,184,166,0.35); border-radius: var(--r); margin: 8px 0; }
.ac-pw-copy { background: rgba(20,184,166,0.12); border: 1px solid rgba(20,184,166,0.25); color: #0F766E; border-radius: 8px; padding: 5px 14px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: 'DM Sans',sans-serif; transition: background .15s; }
.ac-pw-copy:hover { background: rgba(20,184,166,0.22); }

/* ── Perm grid ───────────────────────────────────────── */
.ac-perm-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
.ac-perm-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--sh-sm); }
.ac-perm-card-hd { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.ac-perm-card-title { font-size: 13.5px; font-weight: 800; color: var(--ink); }
.ac-perm-category { padding: 12px 18px; border-bottom: 1px solid var(--border); }
.ac-perm-category:last-child { border-bottom: none; }
.ac-perm-cat-name { font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .12em; color: var(--ink4); margin-bottom: 8px; }
.ac-perm-row { display: flex; align-items: center; justify-content: space-between; padding: 5px 0; }
.ac-perm-label { font-size: 12.5px; color: var(--ink2); }
.ac-perm-toggle { width: 36px; height: 20px; background: rgba(15,23,42,0.10); border-radius: 100px; border: none; cursor: pointer; position: relative; transition: background .2s; flex-shrink: 0; }
.ac-perm-toggle::after { content:''; position:absolute; width:14px; height:14px; border-radius:50%; background:#fff; top:3px; left:3px; transition: transform .2s; }
.ac-perm-toggle.on { background: var(--green); }
.ac-perm-toggle.on::after { transform: translateX(16px); }

/* ── Session row ─────────────────────────────────────── */
.ac-sess-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 20px; border-bottom: 1px solid var(--border); }
.ac-sess-row:last-child { border-bottom: none; }
.ac-sess-ip   { font-family: 'DM Mono', monospace; font-size: 12.5px; color: var(--teal); font-weight: 600; }
.ac-sess-time { font-size: 12px; color: var(--ink4); }
.ac-current-pill { background: var(--green-lt); border: 1px solid rgba(16,185,129,0.22); border-radius: 6px; padding: 2px 9px; font-size: 10px; font-weight: 700; color: #065F46; }

/* ── Num input ───────────────────────────────────────── */
.ac-num-input { width: 80px; padding: 6px 10px; background: var(--surface2); border: 1.5px solid var(--border); border-radius: 8px; color: var(--ink); font-family: 'DM Mono',monospace; font-size: 13px; font-weight: 600; outline: none; text-align: center; }
.ac-num-input:focus { border-color: var(--indigo); }

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 1024px) { .ac-tiles { grid-template-columns: 1fr 1fr; } .ac-perm-grid { grid-template-columns: 1fr; } }
@media (max-width: 640px)  { .ac-grid2, .ac-grid3 { grid-template-columns: 1fr; } .ac-tiles { grid-template-columns: 1fr 1fr; } }
@media (max-width: 400px)  { .ac-tiles { grid-template-columns: 1fr; } }
</style>

{{--
  ═══════════════════════════════════════════════════════
  THEME TOGGLE — drop this wherever you want the switch
  ═══════════════════════════════════════════════════════

  <label class="ac-theme-switch" id="acThemeSwitch">
      <div class="ac-theme-switch-track">
          <div class="ac-theme-switch-thumb" id="acThemeThumb">☀️</div>
      </div>
      <span class="ac-theme-switch-lbl" id="acThemeLbl">Light</span>
  </label>

  ═══════════════════════════════════════════════════════
  JS — place before </body> or in your app.js
  ═══════════════════════════════════════════════════════

  <script>
  (function () {
      const root  = document.querySelector('.ac-root');
      const sw    = document.getElementById('acThemeSwitch');
      const lbl   = document.getElementById('acThemeLbl');
      const thumb = document.getElementById('acThemeThumb');

      // Restore saved preference
      const saved = localStorage.getItem('ac-theme') || 'light';
      apply(saved);

      sw.addEventListener('click', function () {
          const next = root.dataset.theme === 'dark' ? 'light' : 'dark';
          apply(next);
          localStorage.setItem('ac-theme', next);
      });

      function apply(theme) {
          root.dataset.theme = theme;
          lbl.textContent    = theme === 'dark' ? 'Dark' : 'Light';
          thumb.textContent  = theme === 'dark' ? '🌙' : '☀️';
      }
  })();
  </script>

  ═══════════════════════════════════════════════════════
  USAGE — add data-theme="light" to your root element
  ═══════════════════════════════════════════════════════

  <div class="ac-root" data-theme="light">
      ...your page content...
  </div>

--}}