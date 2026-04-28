<style>
/* ══════════════════════════════════════════════════════════════
   ADMIN CONTENT STYLES (MATCHING EMPLOYEE PORTAL UI)
   Colors, Shadows, and Components
   ══════════════════════════════════════════════════════════════ */
:root {
    --blue:    #3B6FE8; --blue-2:  #2755CC; --blue-3:  #1A3FA8;
    --blue-lt: rgba(59,111,232,0.09); --blue-md: rgba(59,111,232,0.18);
    --indigo:  #6B4FDB; --indigo-lt:rgba(107,79,219,0.09);
    --green:   #12B76A; --green-lt: rgba(18,183,106,0.10);
    --amber:   #F59E0B; --amber-lt: rgba(245,158,11,0.10);
    --red:     #EF4444; --red-lt:   rgba(239,68,68,0.10);
    --teal:    #0BB5B5; --teal-lt:  rgba(11,181,181,0.10);
    --bg:#F0F4FA; --bg2:#E8EEF8; --white:#FFFFFF;
    --ink:#0F1629; --ink2:#2D3356; --ink3:#6B7094; --ink4:#A8ADCA;
    --border:rgba(15,22,41,0.08);
    --sh-sm:0 2px 10px rgba(59,111,232,0.08);
    --sh-md:0 6px 24px rgba(59,111,232,0.11);
    --sh-lg:0 16px 48px rgba(59,111,232,0.14);
    --r:12px; --r-lg:20px; --r-xl:28px;
}

html.tf-dark {
    --bg:#0E1220; --bg2:#161B2E; --white:rgba(255,255,255,0.04);
    --ink:#FFFFFF; --ink2:#E2E8F0; --ink3:#94A3B8; --ink4:#64748B;
    --border:rgba(255,255,255,0.08);
    --sh-sm:0 2px 10px rgba(0,0,0,0.2);
}

.ac-root {
    font-family:'DM Sans',-apple-system,sans-serif;
    padding: 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    color: var(--ink);
    background: var(--bg);
    min-height: 100vh;
}

/* ── Hero ── */
.ac-hero {
    background:linear-gradient(118deg,#1A3FA8 0%,#2755CC 36%,#3B6FE8 66%,#6B4FDB 100%);
    border-radius:var(--r-xl); padding:28px 34px;
    display:flex; align-items:center; justify-content:space-between; gap:20px;
    position:relative; overflow:hidden; box-shadow:var(--sh-lg);
}
.ac-hero::before { content:''; position:absolute; top:-60px; right:260px; width:280px; height:280px; border-radius:50%; background:rgba(255,255,255,0.06); pointer-events:none; }
.ac-hero-ttl { font-family:'Sora',sans-serif; font-size:26px; font-weight:900; color:#fff; letter-spacing:-0.4px; margin-bottom:4px; }
.ac-hero-sub { font-size:13px; font-weight:700; color:rgba(255,255,255,0.60); text-transform:uppercase; letter-spacing:.10em; }

/* ── Card ── */
.ac-card {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--sh-sm);
    overflow: hidden;
    transition: box-shadow 0.2s;
}
.ac-card:hover { box-shadow: var(--sh-md); }

.ac-card-hd {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ac-card-title {
    font-family: 'Sora', sans-serif;
    font-size: 14px;
    font-weight: 800;
    color: var(--ink);
}
.ac-card-sub {
    font-size: 11.5px;
    font-weight: 500;
    color: var(--ink4);
    margin-top: 1px;
}

/* ── Tables ── */
.ac-table-wrap { overflow-x: auto; }
.ac-table { width: 100%; border-collapse: collapse; }
.ac-table th { 
    text-align: left; padding: 12px 20px; 
    font-size: 10px; font-weight: 800; text-transform: uppercase; 
    letter-spacing: 0.08em; color: var(--ink4); 
    border-bottom: 1px solid var(--border);
    background: var(--bg2);
}
.ac-table td { padding: 14px 20px; font-size: 13.5px; color: var(--ink2); border-bottom: 1px solid var(--border); }
.ac-table tr:last-child td { border-bottom: none; }
.ac-table tr:hover td { background: var(--blue-lt); }

/* ── Buttons ── */
.ac-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    border-radius: 12px;
    font-size: 12.5px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
}
.ac-btn-primary {
    background: var(--blue);
    color: #fff;
    box-shadow: 0 4px 12px rgba(59, 111, 232, 0.2);
}
.ac-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(59, 111, 232, 0.3); }
.ac-btn-ghost { background: var(--bg2); color: var(--ink2); }
.ac-btn-ghost:hover { background: var(--blue-lt); color: var(--blue); }

.ac-btn-sm { padding: 6px 12px; font-size: 11.5px; border-radius: 9px; }

/* ── Badges ── */
.ac-badge { display: inline-flex; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 800; }
.ab-green { background: var(--green-lt); color: #087A42; }
.ab-red   { background: var(--red-lt);   color: #991B1B; }
.ab-amber { background: var(--amber-lt); color: #92400E; }
.ab-indigo { background: var(--indigo-lt); color: var(--indigo); }
.ab-teal { background: var(--teal-lt); color: #087A7A; }

/* ── Form Elements ── */
.ac-field { margin-bottom: 16px; display: flex; flex-direction: column; gap: 7px; }
.ac-field label { font-size: 12px; font-weight: 700; color: var(--ink2); text-transform: uppercase; letter-spacing: 0.05em; }
.ac-field input, .ac-field select, .ac-field textarea {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 11px 15px;
    font-size: 14px;
    color: var(--ink);
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.ac-field input:focus, .ac-field select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 4px var(--blue-lt);
}

/* ── Tiles (Dashboard) ── */
.ac-tiles { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 24px; }
.ac-tile {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--sh-sm);
    transition: transform 0.2s, box-shadow 0.2s;
}
.ac-tile:hover { transform: translateY(-3px); box-shadow: var(--sh-md); }
.ac-tile-accent { position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
.ac-tile-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ac-tile-icon svg { width: 22px; height: 22px; stroke-width: 2; fill: none; }
.ac-tile-lbl { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); margin-bottom: 4px; }
.ac-tile-val { font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 900; color: var(--ink); letter-spacing: -0.5px; }
.ac-tile-sub { font-size: 11px; color: var(--ink4); font-weight: 600; margin-top: 3px; }

/* ── Logs / Rows ── */
.ac-log-row { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--border); }
.ac-log-row:last-child { border-bottom: none; }
.ac-log-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.ac-log-desc { font-size: 13.5px; font-weight: 700; color: var(--ink2); flex: 1; }
.ac-log-time { font-size: 11.5px; color: var(--ink4); font-weight: 600; }

/* ── Flashes ── */
.ac-flash {
    position: fixed; top: 24px; right: 24px; z-index: 3000;
    padding: 12px 20px; border-radius: 12px;
    display: flex; align-items: center; gap: 10px;
    font-size: 13.5px; font-weight: 700;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    animation: acSlideIn 0.4s ease forwards;
}
.ac-flash-ok  { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
.ac-flash-err { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
@keyframes acSlideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

/* ── Modals ── */
.ac-modal-bg {
    position: fixed; inset: 0; background: rgba(15,22,41,0.6);
    backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center;
    padding: 20px; z-index: 2500;
}
.ac-modal {
    background: var(--white); border-radius: var(--r-xl); border: 1px solid var(--border);
    box-shadow: var(--sh-lg); width: 100%; max-width: 600px; overflow: hidden;
    animation: acModalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes acModalPop { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.ac-modal-hd { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.ac-modal-ttl { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); }
.ac-modal-sub { font-size: 12px; color: var(--ink4); font-weight: 500; }
.ac-modal-body { padding: 24px; }
.ac-modal-ft { padding: 16px 24px; background: var(--bg2); display: flex; justify-content: flex-end; gap: 12px; }

/* ── Misc ── */
.ac-user-cell { display: flex; align-items: center; gap: 12px; }
.ac-av {
    width: 38px; height: 38px; border-radius: 50%;
    background: var(--blue-lt); color: var(--blue);
    font-family: 'Sora', sans-serif; font-weight: 800; font-size: 13px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid #fff; box-shadow: var(--sh-sm);
}
.ac-user-name { font-weight: 800; color: var(--ink); font-size: 13.5px; }
.ac-user-meta { font-size: 11.5px; color: var(--ink4); font-weight: 500; }

.ac-empty { text-align: center; padding: 40px 20px; color: var(--ink4); font-size: 13px; font-weight: 600; }

/* ── Global SVG Constraint (Fixes "Black Blob" issue) ── */
.ac-root svg, .ac-modal svg, .ac-flash svg { 
    width: 1.35em; height: 1.35em; 
    stroke: currentColor; fill: none; stroke-width: 2; 
    flex-shrink: 0; 
}
.ac-hero svg { width: 1.5em; height: 1.5em; }
.ac-tile-icon svg { width: 22px; height: 22px; }


</style>
<script>
function acCopy(id, btn) {
    const text = document.getElementById(id).innerText;
    navigator.clipboard.writeText(text);
    const orig = btn.innerText;
    btn.innerText = 'Copied!';
    setTimeout(() => { btn.innerText = orig; }, 2000);
}
</script>
