{{--
    manage.blade.php
    Accessible via app.blade layout.
    Contains its own side-nav shell that loads:
      - overview   (mini dashboard)
      - employees  (em-root content)
      - contracts  (cm-root content)
      - departments (dm-root content)
      - positions  (pm-root content)
    All Livewire wire:* bindings and variables preserved exactly.
--}}

<div class="mgr-shell">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

/* ══════════════════════════════════════════════════════
   TOKENS  (shared across every section)
══════════════════════════════════════════════════════ */
.mgr-shell {
    --blue:      #3B6FE8;
    --blue-2:    #2755CC;
    --blue-3:    #1A3FA8;
    --blue-lt:   rgba(59,111,232,0.09);
    --blue-mid:  rgba(59,111,232,0.18);
    --blue-brd:  rgba(59,111,232,0.22);
    --indigo:    #6B4FDB;
    --green:     #12B76A;
    --green-lt:  rgba(18,183,106,0.10);
    --amber:     #F59E0B;
    --amber-lt:  rgba(245,158,11,0.10);
    --red:       #EF4444;
    --red-lt:    rgba(239,68,68,0.10);
    --purple:    #7C3AED;
    --purple-lt: rgba(124,58,237,0.09);
    --teal:      #0BB5B5;
    --teal-lt:   rgba(11,181,181,0.10);

    --bg:     #F0F4FA;
    --bg2:    #E8EEF8;
    --white:  #FFFFFF;
    --ink:    #0F1629;
    --ink2:   #2D3356;
    --ink3:   #6B7094;
    --ink4:   #A8ADCA;
    --border: rgba(15,22,41,0.08);
    --sh-sm:  0 2px 10px rgba(59,111,232,0.08);
    --sh-md:  0 6px 24px rgba(59,111,232,0.11);
    --sh-lg:  0 16px 48px rgba(59,111,232,0.14);
    --r:      12px;
    --r-lg:   20px;

    font-family: 'DM Sans', -apple-system, sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    display: flex;
}

/* ══ SIDE NAV ═══════════════════════════════════════════ */
.mgr-nav {
    width: 240px;
    min-width: 240px;
    background: var(--white);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    box-shadow: 2px 0 20px rgba(59,111,232,0.06);
    flex-shrink: 0;
}

/* Nav logo strip */
.mgr-nav-logo {
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 11px;
    flex-shrink: 0;
}
.mgr-nav-logo-mark {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--blue), var(--indigo));
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(59,111,232,0.28);
}
.mgr-nav-logo-mark svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
.mgr-nav-brand {
    font-family: 'Sora', sans-serif;
    font-size: 14px; font-weight: 900; color: var(--ink);
    letter-spacing: -0.2px;
}
.mgr-nav-brand span { color: var(--blue); }

/* Nav section title */
.mgr-nav-section {
    font-size: 9.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.10em;
    color: var(--ink4); padding: 16px 20px 6px;
}

/* Nav item */
.mgr-nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 16px; margin: 1px 8px;
    border-radius: 10px; cursor: pointer;
    font-size: 13.5px; font-weight: 600; color: var(--ink3);
    border: none; background: none; text-align: left; width: calc(100% - 16px);
    font-family: 'DM Sans', sans-serif;
    transition: background 0.15s, color 0.15s;
    position: relative;
}
.mgr-nav-item svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.mgr-nav-item:hover { background: var(--bg); color: var(--ink2); }
.mgr-nav-item.active {
    background: var(--blue-lt);
    color: var(--blue-2);
    font-weight: 700;
}
.mgr-nav-item.active svg { stroke: var(--blue); }
.mgr-nav-item.active::before {
    content: '';
    position: absolute; left: -8px; top: 50%;
    transform: translateY(-50%);
    width: 3px; height: 22px; border-radius: 0 3px 3px 0;
    background: var(--blue);
}
.mgr-nav-badge {
    margin-left: auto;
    background: var(--blue-lt); color: var(--blue-2);
    font-size: 10px; font-weight: 800;
    padding: 2px 7px; border-radius: 100px;
    border: 1px solid var(--blue-brd);
}

/* Nav bottom */
.mgr-nav-bottom {
    margin-top: auto;
    padding: 16px 8px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}
.mgr-nav-back {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 16px; border-radius: 10px;
    font-size: 13px; font-weight: 600; color: var(--ink3);
    text-decoration: none; transition: all 0.15s;
}
.mgr-nav-back:hover { background: var(--bg); color: var(--ink2); }
.mgr-nav-back svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }

/* ══ CONTENT AREA ════════════════════════════════════════ */
.mgr-content {
    flex: 1;
    min-width: 0;
    overflow-y: auto;
}

/* Each section wrapper */
.mgr-section { display: none; }
.mgr-section.active { display: block; }

/* ══ OVERVIEW SECTION ════════════════════════════════════ */
.ov-wrap {
    padding: 28px 30px;
    max-width: 1400px;
    display: flex; flex-direction: column; gap: 20px;
}

/* Overview hero */
.ov-hero {
    background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 36%, #3B6FE8 68%, #6B4FDB 100%);
    border-radius: var(--r-lg);
    padding: 26px 32px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 20px; position: relative; overflow: hidden;
    box-shadow: var(--sh-lg);
}
.ov-hero::before { content:''; position:absolute; top:-50px; right:240px; width:250px; height:250px; border-radius:50%; background:rgba(255,255,255,0.06); pointer-events:none; }
.ov-hero::after  { content:''; position:absolute; bottom:-40px; left:60px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.04); pointer-events:none; }
.ov-hero-left    { display:flex; align-items:center; gap:18px; position:relative; z-index:1; }
.ov-hero-av      { width:60px; height:60px; border-radius:50%; border:3px solid rgba(255,255,255,0.25); background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:20px; font-weight:900; color:#fff; flex-shrink:0; }
.ov-hero-title   { font-family:'Sora',sans-serif; font-size:22px; font-weight:900; color:#fff; letter-spacing:-0.3px; margin-bottom:5px; }
.ov-hero-sub     { font-size:12.5px; color:rgba(255,255,255,0.65); font-weight:500; }
.ov-hero-chips   { display:flex; gap:8px; margin-top:8px; flex-wrap:wrap; }
.ov-hero-chip    { display:inline-flex; align-items:center; gap:5px; background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.20); border-radius:100px; padding:3px 11px; font-size:12px; font-weight:600; color:rgba(255,255,255,0.90); }
.ov-hero-chip svg { width:10px; height:10px; stroke:rgba(255,255,255,0.7); fill:none; stroke-width:2; }
.ov-hero-right   { display:flex; gap:0; position:relative; z-index:1; flex-shrink:0; }
.ov-hero-stat    { padding:8px 20px; text-align:center; border-left:1px solid rgba(255,255,255,0.14); }
.ov-hero-stat:first-child { border-left:none; }
.ov-hero-sv      { font-family:'Sora',sans-serif; font-size:22px; font-weight:900; color:#fff; letter-spacing:-0.4px; line-height:1; }
.ov-hero-sl      { font-size:10px; font-weight:700; color:rgba(255,255,255,0.50); text-transform:uppercase; letter-spacing:.08em; margin-top:3px; }

/* Stat tiles */
.ov-tiles {
    display: grid;
    grid-template-columns: repeat(5, minmax(0,1fr));
    gap: 12px;
}
.ov-tile {
    background: var(--white);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    box-shadow: var(--sh-sm);
    padding: 18px 16px;
    display: flex; align-items: flex-start; gap: 12px;
    position: relative; overflow: hidden;
    cursor: pointer;
    transition: box-shadow 0.18s, transform 0.18s, border-color 0.18s;
}
.ov-tile:hover { box-shadow: var(--sh-md); transform: translateY(-2px); border-color: var(--blue-brd); }
.ov-tile-bar   { position:absolute; top:0; left:0; width:4px; height:100%; border-radius:20px 0 0 20px; }
.ov-tile-icon  { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.ov-tile-icon svg { width:17px; height:17px; fill:none; stroke-width:2; }
.ov-tile-lbl   { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--ink4); margin-bottom:4px; }
.ov-tile-val   { font-family:'Sora',sans-serif; font-size:24px; font-weight:800; color:var(--ink); letter-spacing:-0.5px; line-height:1; }
.ov-tile-sub   { font-size:11px; color:var(--ink4); font-weight:500; margin-top:3px; }

.ov-t-blue   .ov-tile-bar{background:var(--blue);}   .ov-t-blue  .ov-tile-icon{background:var(--blue-lt);}   .ov-t-blue   .ov-tile-icon svg{stroke:var(--blue);}   .ov-t-blue  .ov-tile-val{color:var(--blue-2);}
.ov-t-green  .ov-tile-bar{background:var(--green);}  .ov-t-green .ov-tile-icon{background:var(--green-lt);}  .ov-t-green  .ov-tile-icon svg{stroke:var(--green);}
.ov-t-amber  .ov-tile-bar{background:var(--amber);}  .ov-t-amber .ov-tile-icon{background:var(--amber-lt);}  .ov-t-amber  .ov-tile-icon svg{stroke:var(--amber);}
.ov-t-red    .ov-tile-bar{background:var(--red);}    .ov-t-red   .ov-tile-icon{background:var(--red-lt);}    .ov-t-red    .ov-tile-icon svg{stroke:var(--red);}
.ov-t-indigo .ov-tile-bar{background:var(--indigo);} .ov-t-indigo .ov-tile-icon{background:rgba(107,79,219,.09);} .ov-t-indigo .ov-tile-icon svg{stroke:var(--indigo);}

/* Overview 2-col grid */
.ov-grid { display:grid; grid-template-columns:1fr 320px; gap:18px; align-items:start; }
.ov-col  { display:flex; flex-direction:column; gap:18px; }

/* Overview card */
.ov-card { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); }
.ov-card-hd { display:flex; align-items:center; justify-content:space-between; padding:15px 20px; border-bottom:1px solid var(--border); }
.ov-card-hdl { display:flex; align-items:center; gap:9px; }
.ov-card-ico { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
.ov-card-ico svg { width:13px; height:13px; fill:none; stroke-width:2; stroke:currentColor; }
.ov-card-ttl { font-family:'Sora',sans-serif; font-size:13px; font-weight:800; color:var(--ink); }
.ov-card-sub { font-size:11px; color:var(--ink4); margin-top:1px; }
.ov-card-tag { background:var(--bg); border:1px solid var(--border); border-radius:100px; padding:2px 9px; font-size:10.5px; font-weight:700; color:var(--ink3); }
.ov-card-lnk { font-size:11.5px; font-weight:700; color:var(--blue); cursor:pointer; border:none; background:none; font-family:'DM Sans',sans-serif; display:flex; align-items:center; gap:3px; padding:0; transition:gap .14s; }
.ov-card-lnk:hover { gap:6px; }
.ov-card-lnk svg { width:10px; height:10px; stroke:currentColor; fill:none; stroke-width:2.5; }
.ov-card-bd { padding:18px 20px; }

/* Recent employee row */
.ov-emp-row { display:flex; align-items:center; gap:11px; padding:9px 0; border-bottom:1px solid var(--border); }
.ov-emp-row:last-child { border-bottom:none; }
.ov-emp-av  { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--blue),var(--indigo)); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11px; font-weight:800; color:#fff; flex-shrink:0; }
.ov-emp-name { font-size:13px; font-weight:700; color:var(--ink); margin-bottom:1px; }
.ov-emp-role { font-size:11.5px; color:var(--ink4); font-weight:500; }
.ov-emp-badge { margin-left:auto; display:inline-flex; padding:2px 8px; border-radius:100px; font-size:10.5px; font-weight:700; }

/* Dept list */
.ov-dept-row { display:flex; align-items:center; gap:11px; padding:10px 0; border-bottom:1px solid var(--border); }
.ov-dept-row:last-child { border-bottom:none; }
.ov-dept-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
.ov-dept-name { font-size:13px; font-weight:700; color:var(--ink); flex:1; }
.ov-dept-count { font-size:12px; color:var(--ink4); font-weight:600; }

/* Quick action links */
.ov-action { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:var(--r); background:var(--bg); border:1px solid var(--border); cursor:pointer; margin-bottom:8px; border:none; background:var(--bg); width:100%; font-family:'DM Sans',sans-serif; transition:all .14s; }
.ov-action:hover { background:var(--blue-lt); border:1px solid var(--blue-brd); }
.ov-action:last-child { margin-bottom:0; }
.ov-action-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.ov-action-icon svg { width:14px; height:14px; fill:none; stroke-width:2; stroke:currentColor; }
.ov-action-lbl  { font-size:13px; font-weight:700; color:var(--ink2); }
.ov-action-sub  { font-size:11px; color:var(--ink4); font-weight:500; margin-top:1px; }
.ov-action-arr  { margin-left:auto; width:12px; height:12px; stroke:var(--ink4); fill:none; stroke-width:2.5; }
.ov-action:hover .ov-action-arr { stroke:var(--blue); }

/* ══ SHARED SECTION BADGE / BUTTON resets ════════════════ */
/* All the existing em-root / dm-root / pm-root / cm-root CSS
   lives inside the blade sections below — each section scopes
   its own CSS just like the standalone pages. */

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1100px) {
    .ov-tiles { grid-template-columns: repeat(3,1fr); }
    .ov-grid  { grid-template-columns: 1fr; }
}
@media (max-width: 900px) {
    .mgr-nav { width: 64px; min-width: 64px; }
    .mgr-nav-logo-mark { margin: 0 auto; }
    .mgr-nav-brand, .mgr-nav-section, .mgr-nav-item span,
    .mgr-nav-badge, .mgr-nav-back span { display: none; }
    .mgr-nav-item { justify-content: center; padding: 10px; margin: 2px 4px; width: calc(100% - 8px); }
    .mgr-nav-item.active::before { display: none; }
    .mgr-nav-logo { justify-content: center; padding: 16px 8px; }
    .mgr-nav-back { justify-content: center; padding: 10px; }
    .ov-tiles { grid-template-columns: repeat(2,1fr); }
    .ov-hero-right { display: none; }
}
@media (max-width: 640px) {
    .mgr-shell { flex-direction: column; }
    .mgr-nav { width: 100%; min-width: 100%; height: auto; flex-direction: row; border-right: none; border-bottom: 1px solid var(--border); position: sticky; overflow-x: auto; overflow-y: hidden; }
    .mgr-nav-logo, .mgr-nav-section, .mgr-nav-bottom { display: none; }
    .mgr-nav-items-wrap { display: flex; flex-direction: row; padding: 6px 8px; gap: 2px; width: 100%; overflow-x: auto; }
    .mgr-nav-item { flex-direction: column; gap: 3px; padding: 8px 12px; font-size: 9px; min-width: 60px; flex-shrink: 0; }
    .mgr-nav-item svg { width: 18px; height: 18px; }
    .mgr-nav-item span { display: block; }
    .mgr-nav-brand, .mgr-nav-badge { display: none; }
    .ov-tiles { grid-template-columns: 1fr 1fr; gap:10px; }
    .ov-wrap { padding: 14px 14px; }
}
</style>

{{-- ══ SIDE NAV ══ --}}
<nav class="mgr-nav">
    <div class="mgr-nav-logo">
        <div class="mgr-nav-logo-mark">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
        </div>
        <div class="mgr-nav-brand">Talent<span>Flow</span></div>
    </div>

    <div id="mgr-items-wrap" class="mgr-nav-items-wrap" style="display:flex;flex-direction:column;flex:1;overflow-y:auto;padding:8px 0;">
        <div class="mgr-nav-section">Management</div>

        <button class="mgr-nav-item active" data-section="overview" onclick="mgrSwitch('overview',this)">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            <span>Overview</span>
        </button>

        <button class="mgr-nav-item" data-section="employees" onclick="mgrSwitch('employees',this)">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Employees</span>
            <span class="mgr-nav-badge" id="nav-emp-badge">{{ \App\Models\Employee::count() }}</span>
        </button>

        <button class="mgr-nav-item" data-section="contracts" onclick="mgrSwitch('contracts',this)">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span>Contracts</span>
            <span class="mgr-nav-badge" id="nav-ctr-badge">{{ \App\Models\Contract::count() }}</span>
        </button>

        <button class="mgr-nav-item" data-section="departments" onclick="mgrSwitch('departments',this)">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Departments</span>
            <span class="mgr-nav-badge" id="nav-dept-badge">{{ \App\Models\Department::count() }}</span>
        </button>

        <button class="mgr-nav-item" data-section="positions" onclick="mgrSwitch('positions',this)">
            <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            <span>Positions</span>
            <span class="mgr-nav-badge" id="nav-pos-badge">{{ \App\Models\Position::count() }}</span>
        </button>
    </div>

    <div class="mgr-nav-bottom">
        <a href="{{ url()->previous() }}" class="mgr-nav-back">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            <span>Back</span>
        </a>
    </div>
</nav>

{{-- ══ CONTENT ══ --}}
<div class="mgr-content">

    {{-- ════════════════════════════════════════════════════
         OVERVIEW
    ════════════════════════════════════════════════════ --}}
    <div class="mgr-section active" id="section-overview">
        @php
            $empTotal    = \App\Models\Employee::count();
            $empActive   = \App\Models\Employee::where('is_active', true)->count();
            $deptTotal   = \App\Models\Department::count();
            $posTotal    = \App\Models\Position::count();
            $ctrlTotal   = \App\Models\Contract::count();
            $ctrlActive  = \App\Models\Contract::where('status','active')->count();
            $recentEmps  = \App\Models\Employee::orderBy('created_at','desc')->take(6)->get();
            $depts       = \App\Models\Department::withCount('employees')->orderBy('employees_count','desc')->take(6)->get();
            $deptColors  = ['#3B6FE8','#12B76A','#7C3AED','#F59E0B','#EF4444','#0BB5B5'];
        @endphp

        <div class="ov-wrap">

            {{-- Hero --}}
            <div class="ov-hero">
                <div class="ov-hero-left">
                    <div class="ov-hero-av">HR</div>
                    <div>
                        <div class="ov-hero-title">HR Management Overview</div>
                        <div class="ov-hero-sub">{{ \Carbon\Carbon::now('Africa/Kigali')->format('l, j F Y') }} &mdash; Kigali, Rwanda</div>
                        <div class="ov-hero-chips">
                            <span class="ov-hero-chip">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                {{ $empTotal }} Employees
                            </span>
                            <span class="ov-hero-chip">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                {{ $deptTotal }} Departments
                            </span>
                            <span class="ov-hero-chip">
                                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                {{ $posTotal }} Positions
                            </span>
                        </div>
                    </div>
                </div>
                <div class="ov-hero-right">
                    <div class="ov-hero-stat"><div class="ov-hero-sv">{{ $empActive }}</div><div class="ov-hero-sl">Active</div></div>
                    <div class="ov-hero-stat"><div class="ov-hero-sv">{{ $ctrlActive }}</div><div class="ov-hero-sl">Contracts</div></div>
                    <div class="ov-hero-stat"><div class="ov-hero-sv">{{ $deptTotal }}</div><div class="ov-hero-sl">Depts</div></div>
                    <div class="ov-hero-stat"><div class="ov-hero-sv">{{ $posTotal }}</div><div class="ov-hero-sl">Roles</div></div>
                </div>
            </div>

            {{-- Tiles --}}
            <div class="ov-tiles">
                <div class="ov-tile ov-t-blue" onclick="mgrSwitch('employees',document.querySelector('[data-section=employees]'))">
                    <div class="ov-tile-bar"></div>
                    <div class="ov-tile-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                    <div><div class="ov-tile-lbl">Total Employees</div><div class="ov-tile-val">{{ $empTotal }}</div><div class="ov-tile-sub">{{ $empActive }} active</div></div>
                </div>
                <div class="ov-tile ov-t-green" onclick="mgrSwitch('contracts',document.querySelector('[data-section=contracts]'))">
                    <div class="ov-tile-bar"></div>
                    <div class="ov-tile-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                    <div><div class="ov-tile-lbl">Total Contracts</div><div class="ov-tile-val">{{ $ctrlTotal }}</div><div class="ov-tile-sub">{{ $ctrlActive }} active</div></div>
                </div>
                <div class="ov-tile ov-t-indigo" onclick="mgrSwitch('departments',document.querySelector('[data-section=departments]'))">
                    <div class="ov-tile-bar"></div>
                    <div class="ov-tile-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                    <div><div class="ov-tile-lbl">Departments</div><div class="ov-tile-val">{{ $deptTotal }}</div><div class="ov-tile-sub">With managers: {{ \App\Models\Department::whereNotNull('manager_id')->count() }}</div></div>
                </div>
                <div class="ov-tile ov-t-amber" onclick="mgrSwitch('positions',document.querySelector('[data-section=positions]'))">
                    <div class="ov-tile-bar"></div>
                    <div class="ov-tile-icon"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></div>
                    <div><div class="ov-tile-lbl">Positions</div><div class="ov-tile-val">{{ $posTotal }}</div><div class="ov-tile-sub">Vacant: {{ \App\Models\Position::doesntHave('employees')->count() }}</div></div>
                </div>
                <div class="ov-tile ov-t-red">
                    <div class="ov-tile-bar"></div>
                    <div class="ov-tile-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                    <div><div class="ov-tile-lbl">Inactive Staff</div><div class="ov-tile-val">{{ \App\Models\Employee::where('is_active',false)->count() }}</div><div class="ov-tile-sub">Needs review</div></div>
                </div>
            </div>

            {{-- Main grid --}}
            <div class="ov-grid">
                {{-- Left --}}
                <div class="ov-col">
                    {{-- Recent employees --}}
                    <div class="ov-card">
                        <div class="ov-card-hd">
                            <div class="ov-card-hdl">
                                <div class="ov-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                                <div><div class="ov-card-ttl">Recent Employees</div><div class="ov-card-sub">Latest additions</div></div>
                            </div>
                            <button class="ov-card-lnk" onclick="mgrSwitch('employees',document.querySelector('[data-section=employees]'))">
                                View all <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                        <div class="ov-card-bd">
                            @forelse($recentEmps as $emp)
                                @php
                                    $ini = strtoupper(substr($emp->first_name,0,1).substr($emp->last_name,0,1));
                                    $isActive = $emp->is_active ?? true;
                                @endphp
                                <div class="ov-emp-row">
                                    <div class="ov-emp-av">{{ $ini }}</div>
                                    <div style="flex:1;min-width:0;">
                                        <div class="ov-emp-name">{{ $emp->first_name }} {{ $emp->last_name }}</div>
                                        <div class="ov-emp-role">{{ $emp->code }}</div>
                                    </div>
                                    <span class="ov-emp-badge" style="{{ $isActive ? 'background:var(--green-lt);color:#087A42;' : 'background:var(--red-lt);color:#991B1B;' }}">
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            @empty
                                <div style="text-align:center;padding:28px;color:var(--ink4);font-size:13px;">No employees yet</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Department overview --}}
                    <div class="ov-card">
                        <div class="ov-card-hd">
                            <div class="ov-card-hdl">
                                <div class="ov-card-ico" style="background:rgba(107,79,219,.09);"><svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                                <div><div class="ov-card-ttl">Departments by Headcount</div><div class="ov-card-sub">Employee distribution</div></div>
                            </div>
                            <button class="ov-card-lnk" onclick="mgrSwitch('departments',document.querySelector('[data-section=departments]'))">
                                Manage <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                        <div class="ov-card-bd">
                            @forelse($depts as $i => $dept)
                                <div class="ov-dept-row">
                                    <div class="ov-dept-dot" style="background:{{ $deptColors[$i % count($deptColors)] }};box-shadow:0 0 0 3px {{ $deptColors[$i % count($deptColors)] }}28;"></div>
                                    <div class="ov-dept-name">{{ $dept->name }}</div>
                                    <div class="ov-dept-count">{{ $dept->employees_count }} staff</div>
                                </div>
                            @empty
                                <div style="text-align:center;padding:24px;color:var(--ink4);font-size:13px;">No departments yet</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div class="ov-col">
                    {{-- Quick actions --}}
                    <div class="ov-card">
                        <div class="ov-card-hd">
                            <div class="ov-card-hdl">
                                <div class="ov-card-ico" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
                                <div><div class="ov-card-ttl">Quick Actions</div></div>
                            </div>
                        </div>
                        <div class="ov-card-bd">
                            <button class="ov-action" onclick="mgrSwitch('employees',document.querySelector('[data-section=employees]'))">
                                <div class="ov-action-icon" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                                <div><div class="ov-action-lbl">Add Employee</div><div class="ov-action-sub">Register a new staff member</div></div>
                                <svg class="ov-action-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                            <button class="ov-action" onclick="mgrSwitch('contracts',document.querySelector('[data-section=contracts]'))">
                                <div class="ov-action-icon" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                <div><div class="ov-action-lbl">New Contract</div><div class="ov-action-sub">Create employment contract</div></div>
                                <svg class="ov-action-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                            <button class="ov-action" onclick="mgrSwitch('departments',document.querySelector('[data-section=departments]'))">
                                <div class="ov-action-icon" style="background:rgba(107,79,219,.09);"><svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                                <div><div class="ov-action-lbl">Add Department</div><div class="ov-action-sub">Create a new department</div></div>
                                <svg class="ov-action-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                            <button class="ov-action" onclick="mgrSwitch('positions',document.querySelector('[data-section=positions]'))">
                                <div class="ov-action-icon" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></div>
                                <div><div class="ov-action-lbl">Add Position</div><div class="ov-action-sub">Define a new job role</div></div>
                                <svg class="ov-action-arr" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Summary stats --}}
                    <div class="ov-card">
                        <div class="ov-card-hd">
                            <div class="ov-card-hdl">
                                <div class="ov-card-ico" style="background:var(--teal-lt);"><svg style="stroke:var(--teal)" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                                <div><div class="ov-card-ttl">Summary</div><div class="ov-card-sub">At a glance</div></div>
                            </div>
                        </div>
                        <div class="ov-card-bd">
                            @php
                                $rows = [
                                    ['Total Employees',      $empTotal,                                        '#3B6FE8'],
                                    ['Active',               $empActive,                                       '#12B76A'],
                                    ['Inactive',             \App\Models\Employee::where('is_active',false)->count(), '#EF4444'],
                                    ['Departments',          $deptTotal,                                       '#6B4FDB'],
                                    ['Positions',            $posTotal,                                        '#F59E0B'],
                                    ['Filled Positions',     \App\Models\Position::has('employees')->count(),  '#12B76A'],
                                    ['Vacant Positions',     \App\Models\Position::doesntHave('employees')->count(), '#F59E0B'],
                                    ['Total Contracts',      $ctrlTotal,                                       '#0BB5B5'],
                                    ['Active Contracts',     $ctrlActive,                                      '#12B76A'],
                                ];
                            @endphp
                            @foreach($rows as [$lbl, $val, $color])
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);">
                                    <span style="font-size:13px;font-weight:600;color:var(--ink3);">{{ $lbl }}</span>
                                    <span style="font-family:'Sora',sans-serif;font-size:15px;font-weight:800;color:{{ $color }};">{{ $val }}</span>
                                </div>
                            @endforeach
                            <div style="height:4px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /ov-wrap --}}
    </div>{{-- /section-overview --}}

    {{--  EMPLOYEES  (em-root content pasted in, scoped)
    ════════════════════════════════════════════════════ --}}
    <div class="mgr-section" id="section-employees">
        @livewire('hr.employee-manager')
    </div>
 
    {{-- ════════════════════════════════════════════════════
         CONTRACTS  (cm-root content)
    ════════════════════════════════════════════════════ --}}
    <div class="mgr-section" id="section-contracts">
        @livewire('hr.hr-employee-contract')
    </div>
 
    {{-- ════════════════════════════════════════════════════
         DEPARTMENTS  (dm-root content)
    ════════════════════════════════════════════════════ --}}
    <div class="mgr-section" id="section-departments">
        @livewire('hr.department-manager')
    </div>
 
    {{-- ════════════════════════════════════════════════════
         POSITIONS  (pm-root content)
    ════════════════════════════════════════════════════ --}}
    <div class="mgr-section" id="section-positions">
        @livewire('hr.position-manager')
    </div>
 
</div>{{-- /mgr-content --}}

{{-- ══ Section switcher script ══ --}}
<script>
function mgrSwitch(name, btnEl) {
    // hide all sections
    document.querySelectorAll('.mgr-section').forEach(s => s.classList.remove('active'));
    // show target
    var sec = document.getElementById('section-' + name);
    if (sec) sec.classList.add('active');

    // update nav active state
    document.querySelectorAll('.mgr-nav-item').forEach(b => b.classList.remove('active'));
    // find the correct nav item by data-section
    var navBtn = document.querySelector('.mgr-nav-item[data-section="' + name + '"]');
    if (navBtn) navBtn.classList.add('active');

    // scroll content to top
    var content = document.querySelector('.mgr-content');
    if (content) content.scrollTop = 0;
}
</script>

</div>{{-- /mgr-shell --}}