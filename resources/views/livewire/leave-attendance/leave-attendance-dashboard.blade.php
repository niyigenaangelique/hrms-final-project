<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.lad-root {
    --glass-bg:       rgba(255,255,255,0.50);
    --glass-strong:   rgba(255,255,255,0.72);
    --glass-border:   rgba(255,255,255,0.72);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(22px) saturate(1.7);
    --radius:         22px;
    --radius-sm:      14px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 32px 36px 110px;
    display: flex;
    flex-direction: column;
    gap: 22px;
    max-width: 100%;
}

/* ── Animations ───────────────────────────────────────── */
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes countUp {
    from { opacity: 0; transform: scale(0.7); }
    to   { opacity: 1; transform: scale(1); }
}
@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
}
@keyframes pulseRing {
    0%, 100% { box-shadow: 0 0 0 0 rgba(13,148,136,0.3); }
    50%       { box-shadow: 0 0 0 8px rgba(13,148,136,0); }
}

.anim-1 { animation: fadeSlideUp 0.4s ease both; }
.anim-2 { animation: fadeSlideUp 0.4s 0.06s ease both; }
.anim-3 { animation: fadeSlideUp 0.4s 0.12s ease both; }
.anim-4 { animation: fadeSlideUp 0.4s 0.18s ease both; }
.anim-5 { animation: fadeSlideUp 0.4s 0.24s ease both; }

/* ── Glass card base ──────────────────────────────────── */
.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    position: relative;
}
.g-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.95), transparent);
    pointer-events: none; z-index: 1;
}

/* ── Hero header ──────────────────────────────────────── */
.lad-hero {
    background: linear-gradient(135deg, rgba(13,148,136,0.82) 0%, rgba(8,145,178,0.82) 50%, rgba(79,70,229,0.75) 100%);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: var(--radius);
    box-shadow: 0 16px 48px rgba(13,148,136,0.28), 0 4px 16px rgba(0,0,0,0.08);
    padding: 32px 36px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
    position: relative; overflow: hidden;
}

/* Hero decorative blobs */
.lad-hero-blob1 {
    position: absolute; top: -60px; right: -40px;
    width: 220px; height: 220px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    pointer-events: none;
}
.lad-hero-blob2 {
    position: absolute; bottom: -40px; left: 30%;
    width: 160px; height: 160px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
    pointer-events: none;
}
.lad-hero::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
}

.lad-hero-left { position: relative; z-index: 1; }
.lad-hero-eyebrow {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.12em;
    color: rgba(255,255,255,0.6);
    margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
}
.lad-hero-eyebrow::before {
    content: ''; width: 20px; height: 1.5px;
    background: rgba(255,255,255,0.4); border-radius: 2px;
}
.lad-hero-title { font-size: 28px; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin: 0 0 6px; }
.lad-hero-sub   { font-size: 14px; font-weight: 500; color: rgba(255,255,255,0.65); margin: 0; }

.lad-hero-right { position: relative; z-index: 1; text-align: right; }
.lad-hero-date-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.5); margin-bottom: 5px; }
.lad-hero-date-val   { font-size: 18px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }

/* ── 4 stat cards ─────────────────────────────────────── */
.lad-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0,1fr));
    gap: 16px;
}

.lad-stat {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    padding: 24px 22px 20px;
    position: relative; overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.lad-stat:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); }
.lad-stat::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.95), transparent);
}

/* Color accent bar on top */
.lad-stat::after {
    content: '';
    position: absolute; top: 0; left: 24px; right: 24px; height: 3px;
    border-radius: 0 0 4px 4px;
}
.lad-stat.s-green::after { background: linear-gradient(90deg, #22c55e, #16a34a); }
.lad-stat.s-red::after   { background: linear-gradient(90deg, #f87171, #dc2626); }
.lad-stat.s-blue::after  { background: linear-gradient(90deg, #60a5fa, #2563eb); }
.lad-stat.s-amber::after { background: linear-gradient(90deg, #fbbf24, #d97706); }

.lad-stat-icon {
    width: 44px; height: 44px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
}
.lad-stat-icon svg { width: 20px; height: 20px; }
.si-green { background: rgba(34,197,94,0.14);  } .si-green  svg { stroke: #16a34a; }
.si-red   { background: rgba(239,68,68,0.12);  } .si-red    svg { stroke: #dc2626; }
.si-blue  { background: rgba(37,99,235,0.12);  } .si-blue   svg { stroke: #2563eb; }
.si-amber { background: rgba(245,158,11,0.12); } .si-amber  svg { stroke: #d97706; }

.lad-stat-label { font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); margin-bottom: 8px; }
.lad-stat-value {
    font-size: 38px; font-weight: 700; color: var(--text-primary);
    letter-spacing: -1.5px; line-height: 1;
    animation: countUp 0.5s ease both;
}

/* Decorative glow blob */
.lad-stat-glow {
    position: absolute; bottom: -20px; right: -20px;
    width: 90px; height: 90px; border-radius: 50%;
    pointer-events: none; opacity: 0.5;
}
.s-green .lad-stat-glow { background: radial-gradient(circle, rgba(34,197,94,0.3), transparent 70%); }
.s-red   .lad-stat-glow { background: radial-gradient(circle, rgba(239,68,68,0.25), transparent 70%); }
.s-blue  .lad-stat-glow { background: radial-gradient(circle, rgba(37,99,235,0.25), transparent 70%); }
.s-amber .lad-stat-glow { background: radial-gradient(circle, rgba(245,158,11,0.25), transparent 70%); }

/* ── Two-column row ───────────────────────────────────── */
.lad-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* ── Card header ──────────────────────────────────────── */
.lad-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 24px 16px;
    border-bottom: 1px solid rgba(0,0,0,0.055);
}
.lad-card-head-left { display: flex; align-items: center; gap: 11px; }
.lad-card-icon {
    width: 36px; height: 36px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.lad-card-icon svg { width: 17px; height: 17px; }
.ci-teal   { background: rgba(13,148,136,0.12); } .ci-teal   svg { stroke: #0d9488; }
.ci-blue   { background: rgba(37,99,235,0.12);  } .ci-blue   svg { stroke: #2563eb; }
.ci-green  { background: rgba(34,197,94,0.12);  } .ci-green  svg { stroke: #16a34a; }
.ci-red    { background: rgba(239,68,68,0.1);   } .ci-red    svg { stroke: #dc2626; }
.ci-purple { background: rgba(168,85,247,0.1);  } .ci-purple svg { stroke: #9333ea; }

.lad-card-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 2px; }
.lad-card-sub   { font-size: 11.5px; font-weight: 500; color: var(--text-tertiary); margin: 0; }

/* ── Attendance rate ──────────────────────────────────── */
.lad-rate-body { padding: 24px 26px 26px; }

.lad-rate-display {
    display: flex; align-items: center; justify-content: space-between; gap: 20px;
    margin-bottom: 20px;
}

.lad-rate-big {
    font-size: 64px; font-weight: 700; letter-spacing: -3px; line-height: 1;
    flex-shrink: 0;
}
.rate-great  { color: #16a34a; }
.rate-ok     { color: #d97706; }
.rate-poor   { color: #dc2626; }

.lad-rate-info { flex: 1; }
.lad-rate-month { font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; }
.lad-rate-desc { font-size: 12px; font-weight: 500; color: var(--text-tertiary); }

/* Segmented progress bar */
.lad-progress-track {
    height: 10px; border-radius: 10px;
    background: rgba(0,0,0,0.07); overflow: hidden;
}
.lad-progress-fill {
    height: 100%; border-radius: 10px;
    transition: width 1s cubic-bezier(0.4,0,0.2,1);
    position: relative; overflow: hidden;
}
.lad-progress-fill::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}

.lad-progress-labels {
    display: flex; justify-content: space-between;
    margin-top: 6px;
    font-size: 10.5px; font-weight: 600; color: var(--text-tertiary);
}

/* ── Leave balances ───────────────────────────────────── */
.lad-balances-body { padding: 16px 22px 22px; display: flex; flex-direction: column; gap: 10px; }

.lad-balance-item {
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 13px 16px;
    display: flex; justify-content: space-between; align-items: center;
    transition: box-shadow 0.15s;
}
.lad-balance-item:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.07); }

.lad-balance-name  { font-size: 14px; font-weight: 700; color: var(--text-primary); margin-bottom: 2px; }
.lad-balance-used  { font-size: 11.5px; font-weight: 500; color: var(--text-secondary); }
.lad-balance-right { text-align: right; flex-shrink: 0; }
.lad-balance-days  { font-size: 24px; font-weight: 700; color: #2563eb; line-height: 1; }
.lad-balance-left  { font-size: 11px; font-weight: 500; color: var(--text-tertiary); }

/* Mini progress inside balance item */
.lad-balance-bar-track {
    height: 3px; border-radius: 3px;
    background: rgba(0,0,0,0.07); overflow: hidden; margin-top: 6px;
}
.lad-balance-bar-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg, #2563eb, #0891b2); }

.lad-empty-text { font-size: 13px; font-weight: 500; color: var(--text-tertiary); text-align: center; padding: 24px 0; }

/* ── Tables ───────────────────────────────────────────── */
.lad-table-wrap { overflow-x: auto; }
table.lad-table { width: 100%; border-collapse: collapse; }
.lad-table thead tr { border-bottom: 1px solid rgba(0,0,0,0.06); }
.lad-table th { padding: 10px 18px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); text-align: left; white-space: nowrap; }
.lad-table tbody tr { border-bottom: 1px solid rgba(0,0,0,0.04); transition: background 0.12s; }
.lad-table tbody tr:last-child { border-bottom: none; }
.lad-table tbody tr:hover { background: rgba(255,255,255,0.55); }
.lad-table td { padding: 12px 18px; font-size: 13.5px; font-weight: 500; color: var(--text-primary); white-space: nowrap; }
.lad-table td.muted { color: var(--text-secondary); font-weight: 400; }

/* Employee name with avatar */
.lad-emp-cell { display: flex; align-items: center; gap: 10px; }
.lad-emp-av {
    width: 30px; height: 30px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(13,148,136,0.18), rgba(8,145,178,0.15));
    border: 1.5px solid rgba(13,148,136,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #0d9488; flex-shrink: 0;
}
.lad-emp-name { font-size: 13.5px; font-weight: 700; color: var(--text-primary); }

/* Badges */
.badge { display: inline-flex; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); }
.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-amber  { background: rgba(245,158,11,0.14); color: #b45309; }
.badge-red    { background: rgba(239,68,68,0.14);  color: #b91c1c; }
.badge-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }
.badge-blue   { background: rgba(37,99,235,0.12);  color: #1d4ed8; }

/* ── Holidays ─────────────────────────────────────────── */
.lad-holidays-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 12px; padding: 0 20px 22px; }

.lad-holiday-card {
    background: rgba(255,255,255,0.52);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 16px;
    display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;
    transition: transform 0.15s, box-shadow 0.15s;
    position: relative; overflow: hidden;
}
.lad-holiday-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
.lad-holiday-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, #ef4444, #f97316);
}

.lad-holiday-name { font-size: 14px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
.lad-holiday-date { font-size: 12px; font-weight: 600; color: var(--text-secondary); }
.lad-holiday-desc { font-size: 11.5px; font-weight: 500; color: var(--text-tertiary); margin-top: 3px; }
.lad-holiday-icon { width: 36px; height: 36px; background: rgba(239,68,68,0.1); border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.lad-holiday-icon svg { width: 18px; height: 18px; stroke: #dc2626; }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%;
    transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.75);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}
.ios-nav::before {
    content: ''; position: absolute;
    top: 0; left: 16px; right: 16px; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
}
.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 8px 18px; border-radius: 20px; text-decoration: none;
    font-size: 10px; font-weight: 500; color: rgba(255,255,255,0.45);
    letter-spacing: 0.03em; min-width: 64px; position: relative;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}
.ios-nav-item svg { width: 20px; height: 20px; stroke: currentColor; transition: transform 0.2s; }
.ios-nav-item:hover { color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.08); transform: translateY(-1px); }
.ios-nav-item:hover svg { transform: scale(1.1); }
.ios-nav-item.active { color: #fff; background: rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke: #60a5fa; }
.ios-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #60a5fa; }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1100px) {
    .lad-stats { grid-template-columns: repeat(2,1fr); }
    .lad-holidays-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 768px) {
    .lad-root { padding: 18px 14px 100px; }
    .lad-two-col { grid-template-columns: 1fr; }
    .lad-stats { grid-template-columns: repeat(2,1fr); gap: 12px; }
    .lad-holidays-grid { grid-template-columns: 1fr; }
    .lad-hero { padding: 22px 20px; flex-direction: column; align-items: flex-start; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

<div class="lad-root">

    {{-- ── Hero header ──────────────────────────────── --}}
    <div class="lad-hero anim-1">
        <div class="lad-hero-blob1"></div>
        <div class="lad-hero-blob2"></div>
        <div class="lad-hero-left">
            <div class="lad-hero-eyebrow">Leave & Attendance</div>
            <h1 class="lad-hero-title">HR Dashboard</h1>
            <p class="lad-hero-sub">Overview of leave and attendance management</p>
        </div>
        <div class="lad-hero-right">
            <div class="lad-hero-date-label">Today</div>
            <div class="lad-hero-date-val">{{ now()->format('l, F j') }}</div>
        </div>
    </div>

    {{-- ── 4 Stat cards ──────────────────────────────── --}}
    <div class="lad-stats anim-2">

        <div class="lad-stat s-green" style="animation: fadeSlideUp 0.4s 0.06s ease both;">
            <div class="lad-stat-icon si-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="lad-stat-label">Present Today</div>
            <div class="lad-stat-value">{{ $presentToday }}</div>
            <div class="lad-stat-glow"></div>
        </div>

        <div class="lad-stat s-red" style="animation: fadeSlideUp 0.4s 0.10s ease both;">
            <div class="lad-stat-icon si-red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="lad-stat-label">Absent Today</div>
            <div class="lad-stat-value">{{ $absentToday }}</div>
            <div class="lad-stat-glow"></div>
        </div>

        <div class="lad-stat s-blue" style="animation: fadeSlideUp 0.4s 0.14s ease both;">
            <div class="lad-stat-icon si-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div class="lad-stat-label">On Leave Today</div>
            <div class="lad-stat-value">{{ $onLeaveToday }}</div>
            <div class="lad-stat-glow"></div>
        </div>

        <div class="lad-stat s-amber" style="animation: fadeSlideUp 0.4s 0.18s ease both;">
            <div class="lad-stat-icon si-amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            </div>
            <div class="lad-stat-label">Pending Leave</div>
            <div class="lad-stat-value">{{ $pendingLeaveRequests }}</div>
            <div class="lad-stat-glow"></div>
        </div>

    </div>

    {{-- ── Attendance rate + Leave balances ──────────── --}}
    <div class="lad-two-col anim-3">

        {{-- Attendance rate --}}
        <div class="g-card">
            <div class="lad-card-head">
                <div class="lad-card-head-left">
                    <div class="lad-card-icon ci-teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <p class="lad-card-title">Attendance Rate</p>
                        <p class="lad-card-sub">{{ now()->format('F Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="lad-rate-body">
                @php
                    $rateClass = $thisMonthAttendance >= 90 ? 'rate-great' : ($thisMonthAttendance >= 75 ? 'rate-ok' : 'rate-poor');
                    $rateGrad  = $thisMonthAttendance >= 90
                        ? 'linear-gradient(90deg,#16a34a,#22c55e)'
                        : ($thisMonthAttendance >= 75
                            ? 'linear-gradient(90deg,#d97706,#f59e0b)'
                            : 'linear-gradient(90deg,#dc2626,#ef4444)');
                @endphp
                <div class="lad-rate-display">
                    <div class="lad-rate-big {{ $rateClass }}">{{ $thisMonthAttendance }}%</div>
                    <div class="lad-rate-info">
                        <div class="lad-rate-month">{{ now()->format('F Y') }}</div>
                        <div class="lad-rate-desc">
                            @if($thisMonthAttendance >= 90) Excellent attendance this month
                            @elseif($thisMonthAttendance >= 75) Good — room for improvement
                            @else Needs attention
                            @endif
                        </div>
                    </div>
                </div>
                <div class="lad-progress-track">
                    <div class="lad-progress-fill" style="width:{{ $thisMonthAttendance }}%; background: {{ $rateGrad }};"></div>
                </div>
                <div class="lad-progress-labels">
                    <span>0%</span><span>50%</span><span>100%</span>
                </div>
            </div>
        </div>

        {{-- Leave balances --}}
        <div class="g-card">
            <div class="lad-card-head">
                <div class="lad-card-head-left">
                    <div class="lad-card-icon ci-blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="lad-card-title">Leave Balances</p>
                        <p class="lad-card-sub">My available days</p>
                    </div>
                </div>
            </div>
            <div class="lad-balances-body">
                @forelse($leaveBalanceSummary as $balance)
                    @php
                        $total = $balance->total_days + $balance->carried_forward_days;
                        $pct   = $total > 0 ? round(($balance->balance_days / $total) * 100) : 0;
                    @endphp
                    <div class="lad-balance-item">
                        <div style="flex:1; min-width:0;">
                            <div class="lad-balance-name">{{ $balance->leaveType->name }}</div>
                            <div class="lad-balance-used">{{ $balance->used_days }} used · {{ $total }} total</div>
                            <div class="lad-balance-bar-track" style="width:120px;">
                                <div class="lad-balance-bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                        <div class="lad-balance-right" style="margin-left:14px;">
                            <div class="lad-balance-days">{{ $balance->balance_days }}</div>
                            <div class="lad-balance-left">days left</div>
                        </div>
                    </div>
                @empty
                    <p class="lad-empty-text">No leave balances available</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── Recent attendance + Leave requests ────────── --}}
    <div class="lad-two-col anim-4">

        {{-- Recent attendance --}}
        <div class="g-card">
            <div class="lad-card-head">
                <div class="lad-card-head-left">
                    <div class="lad-card-icon ci-green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                    </div>
                    <div>
                        <p class="lad-card-title">Recent Attendance</p>
                        <p class="lad-card-sub">Latest check-ins</p>
                    </div>
                </div>
            </div>
            <div class="lad-table-wrap">
                <table class="lad-table">
                    <thead><tr>
                        <th>Employee</th><th>Date</th><th>In</th><th>Status</th>
                    </tr></thead>
                    <tbody>
                        @foreach($recentAttendance as $att)
                            @php
                                $s  = $att->status->value;
                                $bc = match(strtolower($s)) { 'approved','present' => 'badge-green', 'pending' => 'badge-amber', default => 'badge-red' };
                                $name = $att->employee ? $att->employee->first_name . ' ' . $att->employee->last_name : 'Unknown';
                                $initials = $att->employee ? strtoupper(substr($att->employee->first_name,0,1).substr($att->employee->last_name,0,1)) : '??';
                            @endphp
                            <tr>
                                <td>
                                    <div class="lad-emp-cell">
                                        <div class="lad-emp-av">{{ $initials }}</div>
                                        <span class="lad-emp-name">{{ $name }}</span>
                                    </div>
                                </td>
                                <td class="muted">{{ $att->date->format('M d') }}</td>
                                <td class="muted">{{ $att->check_in ? $att->check_in->format('H:i') : '—' }}</td>
                                <td><span class="badge {{ $bc }}">{{ $s }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent leave requests --}}
        <div class="g-card">
            <div class="lad-card-head">
                <div class="lad-card-head-left">
                    <div class="lad-card-icon ci-purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="lad-card-title">Recent Leave Requests</p>
                        <p class="lad-card-sub">Latest submissions</p>
                    </div>
                </div>
            </div>
            <div class="lad-table-wrap">
                <table class="lad-table">
                    <thead><tr>
                        <th>Employee</th><th>Type</th><th>Days</th><th>Status</th>
                    </tr></thead>
                    <tbody>
                        @foreach($recentLeaveRequests as $leave)
                            @php
                                $ls = $leave->status->value;
                                $lc = match($ls) { 'approved' => 'badge-green', 'pending' => 'badge-amber', 'rejected' => 'badge-red', default => 'badge-gray' };
                                $lname = $leave->employee ? $leave->employee->first_name . ' ' . $leave->employee->last_name : 'Unknown';
                                $linit = $leave->employee ? strtoupper(substr($leave->employee->first_name,0,1).substr($leave->employee->last_name,0,1)) : '??';
                            @endphp
                            <tr>
                                <td>
                                    <div class="lad-emp-cell">
                                        <div class="lad-emp-av">{{ $linit }}</div>
                                        <span class="lad-emp-name">{{ $lname }}</span>
                                    </div>
                                </td>
                                <td class="muted">{{ $leave->leaveType->name }}</td>
                                <td>{{ $leave->total_days }}d</td>
                                <td><span class="badge {{ $lc }}">{{ $leave->status->getLabel() }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ── Upcoming holidays ─────────────────────────── --}}
    <div class="g-card anim-5">
        <div class="lad-card-head">
            <div class="lad-card-head-left">
                <div class="lad-card-icon ci-red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </div>
                <div>
                    <p class="lad-card-title">Upcoming Holidays</p>
                    <p class="lad-card-sub">Next 30 days</p>
                </div>
            </div>
        </div>
        @if($upcomingHolidays->isNotEmpty())
            <div class="lad-holidays-grid">
                @foreach($upcomingHolidays as $holiday)
                    <div class="lad-holiday-card">
                        <div>
                            <div class="lad-holiday-name">{{ $holiday->name }}</div>
                            <div class="lad-holiday-date">{{ $holiday->date->format('l, F d') }}</div>
                            @if($holiday->description)
                                <div class="lad-holiday-desc">{{ $holiday->description }}</div>
                            @endif
                        </div>
                        <div class="lad-holiday-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="lad-empty-text" style="padding: 0 20px 22px;">No upcoming holidays in the next 30 days</p>
        @endif
    </div>

    {{-- ── Floating nav ──────────────────────────────── --}}
    <nav class="ios-nav">
        <a href="{{ route('leave-attendance.dashboard') }}" class="ios-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Dashboard
            <span class="ios-nav-active-dot"></span>
        </a>
        <a href="{{ route('leave-attendance.requests') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Leave
        </a>
        <a href="{{ route('leave-attendance.hr-leave-management') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Manage
        </a>
        <a href="{{ route('leave-attendance.hr-calendar') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Calendar
        </a>
        <a href="{{ route('employees') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            Employees
        </a>
        <a href="{{ route('leave-attendance.hr-communication') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Messages
        </a>
    </nav>

</div>
