<div x-data class="db-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

.db-root {
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
    font-family:'DM Sans',-apple-system,sans-serif;
    background:var(--bg); 
    min-height:100vh; 
    color:var(--ink);
    display: flex;
    justify-content: center;
    align-items: flex-start;
}
.db-wrap { 
    padding:26px 30px 110px; 
    max-width:1420px; 
    display:flex; 
    flex-direction:column; 
    gap:20px; 
    margin: 0 auto; 
    width: 100%;
    box-sizing: border-box;
}

/* HERO */
.db-hero {
    background:linear-gradient(118deg,#1A3FA8 0%,#2755CC 36%,#3B6FE8 66%,#6B4FDB 100%);
    border-radius:var(--r-xl); padding:28px 34px;
    display:flex; align-items:center; justify-content:space-between; gap:20px;
    position:relative; overflow:hidden; box-shadow:var(--sh-lg); min-height:130px;
}
.db-hero::before { content:''; position:absolute; top:-60px; right:260px; width:280px; height:280px; border-radius:50%; background:rgba(255,255,255,0.06); pointer-events:none; }
.db-hero::after  { content:''; position:absolute; bottom:-50px; left:80px; width:200px; height:200px; border-radius:50%; background:rgba(255,255,255,0.04); pointer-events:none; }
.db-hero-deco    { position:absolute; top:18px; right:310px; width:110px; height:110px; border-radius:50%; border:1.5px solid rgba(255,255,255,0.10); pointer-events:none; }
.db-hero-left    { display:flex; align-items:center; gap:22px; position:relative; z-index:1; }
.db-hero-av      { width:70px; height:70px; border-radius:50%; border:3px solid rgba(255,255,255,0.30); padding:2px; flex-shrink:0; }
.db-hero-av-in   { width:100%; height:100%; border-radius:50%; background:rgba(255,255,255,0.18); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:22px; font-weight:900; color:#fff; }
.db-hero-greet   { font-size:12px; font-weight:700; color:rgba(255,255,255,0.60); text-transform:uppercase; letter-spacing:.10em; margin-bottom:4px; }
.db-hero-name    { font-family:'Sora',sans-serif; font-size:24px; font-weight:900; color:#fff; letter-spacing:-0.4px; margin-bottom:8px; line-height:1.1; }
.db-hero-chips   { display:flex; gap:8px; flex-wrap:wrap; }
.db-hero-chip    { display:inline-flex; align-items:center; gap:5px; background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.22); border-radius:100px; padding:4px 12px; font-size:12px; font-weight:600; color:rgba(255,255,255,0.90); }
.db-hero-chip svg { width:11px; height:11px; stroke:rgba(255,255,255,0.75); fill:none; stroke-width:2; }
.db-hero-right   { display:flex; gap:0; position:relative; z-index:1; flex-shrink:0; }
.db-hero-stat    { padding:10px 22px; text-align:center; border-left:1px solid rgba(255,255,255,0.14); }
.db-hero-stat:first-child { border-left:none; }
.db-hero-sv      { font-family:'Sora',sans-serif; font-size:24px; font-weight:900; color:#fff; letter-spacing:-0.5px; line-height:1; }
.db-hero-sl      { font-size:10px; font-weight:700; color:rgba(255,255,255,0.52); text-transform:uppercase; letter-spacing:.08em; margin-top:4px; }

/* TILES */
.db-tiles { display:grid; grid-template-columns:repeat(6,minmax(0,1fr)); gap:12px; }
.db-tile  { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:18px 16px; display:flex; align-items:flex-start; gap:13px; position:relative; overflow:hidden; transition:box-shadow .18s,transform .18s; }
.db-tile:hover { box-shadow:var(--sh-md); transform:translateY(-2px); }
.db-tile-accent { position:absolute; top:0; left:0; width:4px; height:100%; border-radius:20px 0 0 20px; }
.db-tile-icon   { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.db-tile-icon svg { width:18px; height:18px; fill:none; stroke-width:2; }
.db-tile-lbl    { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--ink4); margin-bottom:4px; }
.db-tile-val    { font-family:'Sora',sans-serif; font-size:22px; font-weight:800; color:var(--ink); letter-spacing:-0.4px; line-height:1.1; }
.db-tile-val-sm { font-size:14px !important; line-height:1.35 !important; }
.db-tile-sub    { font-size:11px; color:var(--ink4); font-weight:500; margin-top:3px; }
.db-t-blue   .db-tile-accent{background:var(--blue);}   .db-t-blue   .db-tile-icon{background:var(--blue-lt);}   .db-t-blue   .db-tile-icon svg{stroke:var(--blue);}   .db-t-blue   .db-tile-val{color:var(--blue-2);}
.db-t-green  .db-tile-accent{background:var(--green);}  .db-t-green  .db-tile-icon{background:var(--green-lt);}  .db-t-green  .db-tile-icon svg{stroke:var(--green);}
.db-t-amber  .db-tile-accent{background:var(--amber);}  .db-t-amber  .db-tile-icon{background:var(--amber-lt);}  .db-t-amber  .db-tile-icon svg{stroke:var(--amber);}
.db-t-red    .db-tile-accent{background:var(--red);}    .db-t-red    .db-tile-icon{background:var(--red-lt);}    .db-t-red    .db-tile-icon svg{stroke:var(--red);}
.db-t-indigo .db-tile-accent{background:var(--indigo);} .db-t-indigo .db-tile-icon{background:var(--indigo-lt);} .db-t-indigo .db-tile-icon svg{stroke:var(--indigo);}
.db-t-teal   .db-tile-accent{background:var(--teal);}   .db-t-teal   .db-tile-icon{background:var(--teal-lt);}   .db-t-teal   .db-tile-icon svg{stroke:var(--teal);}

/* MAIN 2-COL GRID */
.db-grid { display:grid; grid-template-columns:1fr 280px; gap:18px; align-items:start; }
.db-col  { display:flex; flex-direction:column; gap:18px; }

/* CARD */
.db-card     { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); }
.db-card-hd  { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid var(--border); }
.db-card-hdl { display:flex; align-items:center; gap:10px; }
.db-card-ico { width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.db-card-ico svg { width:14px; height:14px; fill:none; stroke-width:2; stroke:currentColor; }
.db-card-ttl { font-family:'Sora',sans-serif; font-size:13.5px; font-weight:800; color:var(--ink); }
.db-card-stt { font-size:11.5px; color:var(--ink4); font-weight:500; margin-top:1px; }
.db-card-tag { background:var(--bg); border:1px solid var(--border); border-radius:100px; padding:2px 9px; font-size:10.5px; font-weight:700; color:var(--ink3); }
.db-card-lnk { font-size:11.5px; font-weight:700; color:var(--blue); text-decoration:none; display:flex; align-items:center; gap:3px; transition:gap .14s; }
.db-card-lnk:hover { gap:6px; }
.db-card-lnk svg { width:11px; height:11px; stroke:currentColor; fill:none; stroke-width:2.5; }
.db-card-bd  { padding:18px 20px; }

/* CHARTS */
.db-charts { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
.db-chart-h { position:relative; height:170px; }

/* TASKS */
.db-task { display:flex; align-items:flex-start; gap:12px; padding:11px 0; border-bottom:1px solid var(--border); }
.db-task:last-child { border-bottom:none; }
.db-task-cb { width:17px; height:17px; border-radius:5px; flex-shrink:0; border:2px solid var(--border); margin-top:2px; display:flex; align-items:center; justify-content:center; cursor:pointer; }
.db-task-cb.done { background:var(--green); border-color:var(--green); }
.db-task-cb svg  { display:none; width:9px; height:9px; stroke:#fff; fill:none; stroke-width:3; }
.db-task-cb.done svg { display:block; }
.db-task-ttl { font-size:13.5px; font-weight:700; color:var(--ink); margin-bottom:2px; }
.db-task-ttl.done-t { text-decoration:line-through; opacity:.5; }
.db-task-dsc { font-size:11.5px; color:var(--ink3); margin-bottom:5px; }
.db-task-meta { display:flex; align-items:center; gap:7px; flex-wrap:wrap; }
.db-task-pri { padding:2px 7px; border-radius:5px; font-size:10.5px; font-weight:800; text-transform:uppercase; }
.db-pri-high   { background:var(--red-lt);   color:var(--red); }
.db-pri-medium { background:var(--amber-lt); color:#92400E; }
.db-pri-low    { background:var(--blue-lt);  color:var(--blue-2); }
.db-task-chp { display:inline-flex; align-items:center; gap:4px; font-size:11px; color:var(--ink4); font-weight:500; }
.db-task-chp svg { width:10px; height:10px; stroke:var(--ink4); fill:none; stroke-width:2; }

/* CALENDAR */
.db-cal { display:grid; grid-template-columns:repeat(7,1fr); gap:2px; }
.db-cal-lbl { font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; color:var(--ink4); text-align:center; padding:4px 0; }
.db-cal-day { aspect-ratio:1; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; border-radius:7px; color:var(--ink2); position:relative; transition:background .12s; }
.db-cal-day:hover { background:var(--bg); }
.db-cal-day.dim   { color:var(--ink4); opacity:.4; }
.db-cal-day.today { background:var(--blue); color:#fff; font-weight:800; }
.db-cal-day.has-ev::after { content:''; position:absolute; bottom:2px; width:4px; height:4px; border-radius:50%; background:var(--amber); }

/* EVENTS */
.db-ev { display:flex; align-items:center; gap:13px; padding:10px 0; border-bottom:1px solid var(--border); }
.db-ev:last-child { border-bottom:none; }
.db-ev-date { width:38px; text-align:center; flex-shrink:0; }
.db-ev-d { font-family:'Sora',sans-serif; font-size:18px; font-weight:900; color:var(--ink); line-height:1; }
.db-ev-m { font-size:9px; font-weight:700; color:var(--ink4); text-transform:uppercase; }
.db-ev-bar { width:3px; height:36px; border-radius:3px; flex-shrink:0; }
.db-ev-ttl { font-size:12.5px; font-weight:700; color:var(--ink); margin-bottom:2px; }
.db-ev-meta { font-size:11px; color:var(--ink4); font-weight:500; }

/* ANNOUNCEMENTS */
.db-ann { padding:12px 14px; border-radius:10px; margin-bottom:10px; border-left:3.5px solid var(--blue); }
.db-ann:last-child { margin-bottom:0; }
.db-ann.high   { border-color:var(--red);   background:var(--red-lt); }
.db-ann.medium { border-color:var(--amber); background:var(--amber-lt); }
.db-ann-ttl  { font-size:12.5px; font-weight:800; color:var(--ink); margin-bottom:4px; }
.db-ann-body { font-size:12px; color:var(--ink2); margin-bottom:5px; line-height:1.55; }
.db-ann-meta { font-size:10.5px; color:var(--ink4); font-weight:500; }

/* MESSAGES */
.db-msg { display:flex; align-items:flex-start; gap:11px; padding:11px 0; border-bottom:1px solid var(--border); }
.db-msg:last-child { border-bottom:none; }
.db-msg-av   { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:11.5px; font-weight:800; color:#fff; flex-shrink:0; }
.db-msg-sndr { font-size:13px; font-weight:700; color:var(--ink); margin-bottom:2px; }
.db-msg-subj { font-size:12px; font-weight:500; color:var(--ink2); margin-bottom:2px; }
.db-msg-prev { font-size:11px; color:var(--ink4); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:180px; }
.db-msg-time { font-size:10px; color:var(--ink4); margin-top:3px; }
.db-msg.unread .db-msg-sndr { font-weight:800; }

/* ATTENDANCE ROWS */
.db-att { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); }
.db-att:last-child { border-bottom:none; }
.db-att-dot  { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
.db-att-date { font-size:13px; font-weight:700; color:var(--ink); }
.db-att-t    { font-size:11.5px; color:var(--ink4); font-weight:500; margin-top:1px; }
.db-att-b    { margin-left:auto; display:inline-flex; padding:3px 9px; border-radius:100px; font-size:11px; font-weight:800; }

/* LEAVES */
.db-leave { display:flex; align-items:center; padding:10px 0; border-bottom:1px solid var(--border); }
.db-leave:last-child { border-bottom:none; }
.db-leave-ico { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-right:10px; }
.db-leave-ico svg { width:14px; height:14px; fill:none; stroke-width:2; }
.db-leave-ttl  { font-size:13px; font-weight:700; color:var(--ink); }
.db-leave-dts  { font-size:11.5px; color:var(--ink4); font-weight:500; margin-top:1px; }
.db-badge { display:inline-flex; padding:3px 9px; border-radius:100px; font-size:11.5px; font-weight:800; flex-shrink:0; }
.db-bg-green { background:var(--green-lt); color:#087A42; }
.db-bg-amber { background:var(--amber-lt); color:#92400E; }
.db-bg-red   { background:var(--red-lt);   color:#991B1B; }

.db-empty { text-align:center; padding:28px 16px; color:var(--ink4); font-size:13px; font-weight:500; }

/* NAV */
.db-nav { 
    position:fixed; 
    bottom:20px; 
    left:50%; 
    transform:translateX(-50%); 
    z-index:200; 
    display:flex; 
    align-items:center; 
    gap:2px; 
    background:rgba(15,22,41,0.88); 
    backdrop-filter:blur(28px) saturate(2); 
    -webkit-backdrop-filter:blur(28px) saturate(2); 
    border:1px solid rgba(255,255,255,0.11); 
    border-radius:26px; 
    padding:7px 10px; 
    box-shadow:0 20px 56px rgba(15,22,41,0.26),inset 0 1px 0 rgba(255,255,255,0.08);
    margin: 0 auto;
    width: fit-content;
}
.db-nav::before { content:''; position:absolute; top:0; left:20px; right:20px; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent); }
.db-nav-item { display:flex; flex-direction:column; align-items:center; gap:3px; padding:8px 16px; border-radius:18px; text-decoration:none; font-size:10px; font-weight:600; color:rgba(255,255,255,0.40); letter-spacing:.04em; min-width:62px; position:relative; transition:background .18s,color .18s,transform .14s; }
.db-nav-item svg { width:19px; height:19px; stroke:currentColor; fill:none; stroke-width:1.8; }
.db-nav-item:hover { color:rgba(255,255,255,0.82); background:rgba(255,255,255,0.07); transform:translateY(-1px); }
.db-nav-item.active { color:#fff; background:rgba(59,111,232,0.30); }
.db-nav-item.active svg { stroke:#93C5FD; }
.db-nav-dot    { position:absolute; bottom:4px; width:4px; height:4px; border-radius:50%; background:#60A5FA; }
.db-nav-notif  { position:absolute; top:5px; right:9px; width:7px; height:7px; border-radius:50%; background:var(--red); border:1.5px solid rgba(15,22,41,0.88); }

@media (max-width:1260px) {
    .db-tiles { grid-template-columns:repeat(3,1fr); }
    .db-grid  { grid-template-columns:1fr; }
}
@media (max-width:900px) {
    .db-tiles { grid-template-columns:repeat(2,1fr); }
    .db-grid  { grid-template-columns:1fr; }
    .db-charts { grid-template-columns:1fr 1fr; }
}
@media (max-width:640px) {
    .db-wrap { padding:14px 14px 100px; gap:14px; }
    .db-hero-right { display:none; }
    .db-tiles { grid-template-columns:repeat(2,1fr); gap:10px; }
    .db-charts { grid-template-columns:1fr; }
    .db-nav { bottom:12px; padding:6px 8px; }
    .db-nav-item { padding:7px 11px; min-width:52px; font-size:9px; }
    .db-nav-item svg { width:17px; height:17px; }
}
</style>

<div class="db-wrap">

{{-- HERO --}}
@php
    $tz = 'Africa/Kigali';
    $now = \Carbon\Carbon::now($tz);
    $greeting = $now->hour < 12 ? 'Good Morning' : ($now->hour < 17 ? 'Good Afternoon' : 'Good Evening');
    $av1 = strtoupper(substr($employee->first_name ?? 'E', 0, 1));
    $av2 = strtoupper(substr($employee->last_name  ?? 'U', 0, 1));
@endphp
<div class="db-hero">
    <div class="db-hero-deco" aria-hidden="true"></div>
    <div class="db-hero-left">
        <div class="db-hero-av"><div class="db-hero-av-in">{{ $av1 }}{{ $av2 }}</div></div>
        <div>
            <div class="db-hero-greet">{{ $greeting }}</div>
            <div class="db-hero-name">{{ $employee->first_name }} {{ $employee->last_name }}</div>
            <div class="db-hero-chips">
                <span class="db-hero-chip"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>{{ $employee->code }}</span>
                <span class="db-hero-chip"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ $now->format('l, j F Y') }}</span>
            </div>
        </div>
    </div>
    <div class="db-hero-right">
        <div class="db-hero-stat"><div class="db-hero-sv">{{ $quickStats['tasks_completed'] }}/{{ $quickStats['total_tasks'] }}</div><div class="db-hero-sl">Tasks</div></div>
        <div class="db-hero-stat"><div class="db-hero-sv">{{ $quickStats['present_days'] }}</div><div class="db-hero-sl">Days In</div></div>
        <div class="db-hero-stat"><div class="db-hero-sv">{{ $quickStats['pending_leaves'] }}</div><div class="db-hero-sl">Leaves</div></div>
        <div class="db-hero-stat"><div class="db-hero-sv">{{ $quickStats['active_contracts'] }}</div><div class="db-hero-sl">Contracts</div></div>
    </div>
</div>

{{-- TILES --}}
<div class="db-tiles">
    <div class="db-tile db-t-blue">
        <div class="db-tile-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
        <div><div class="db-tile-lbl">Employee</div><div class="db-tile-val db-tile-val-sm">{{ $employee->first_name }} {{ $employee->last_name }}</div></div>
    </div>
    <div class="db-tile db-t-green">
        <div class="db-tile-icon"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
        <div><div class="db-tile-lbl">Tasks Done</div><div class="db-tile-val">{{ $quickStats['tasks_completed'] }}/{{ $quickStats['total_tasks'] }}</div><div class="db-tile-sub">{{ $dailyTasks->where('completed',false)->count() }} pending</div></div>
    </div>
    <div class="db-tile db-t-teal">
        <div class="db-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
        <div><div class="db-tile-lbl">Days Present</div><div class="db-tile-val">{{ $quickStats['present_days'] }}</div><div class="db-tile-sub">This month</div></div>
    </div>
    <div class="db-tile db-t-red">
        <div class="db-tile-icon"><svg viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg></div>
        <div><div class="db-tile-lbl">Unread</div><div class="db-tile-val">{{ $quickStats['unread_messages'] }}</div><div class="db-tile-sub">Messages</div></div>
    </div>
    <div class="db-tile db-t-amber">
        <div class="db-tile-icon"><svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg></div>
        <div><div class="db-tile-lbl">Pending Leaves</div><div class="db-tile-val">{{ $quickStats['pending_leaves'] }}</div><div class="db-tile-sub">Awaiting review</div></div>
    </div>
    <div class="db-tile db-t-indigo">
        <div class="db-tile-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
        <div><div class="db-tile-lbl">Contracts</div><div class="db-tile-val">{{ $quickStats['active_contracts'] }}</div><div class="db-tile-sub">Active</div></div>
    </div>
</div>

{{-- MAIN GRID --}}
<div class="db-grid">

    {{-- LEFT: charts + tasks + attendance --}}
    <div class="db-col">
        {{-- Charts --}}
        <div class="db-charts">
            <div class="db-card">
                <div class="db-card-hd">
                    <div class="db-card-hdl">
                        <div class="db-card-ico" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <div><div class="db-card-ttl">Leave Status</div><div class="db-card-stt">{{ $leaveRequests->count() }} total</div></div>
                    </div>
                </div>
                <div class="db-card-bd"><div class="db-chart-h"><canvas id="empLeaveChart"></canvas></div></div>
            </div>
            <div class="db-card">
                <div class="db-card-hd">
                    <div class="db-card-hdl">
                        <div class="db-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div><div class="db-card-ttl">Attendance</div><div class="db-card-stt">Last 7 days</div></div>
                    </div>
                </div>
                <div class="db-card-bd"><div class="db-chart-h"><canvas id="empAttendanceChart"></canvas></div></div>
            </div>
            <div class="db-card">
                <div class="db-card-hd">
                    <div class="db-card-hdl">
                        <div class="db-card-ico" style="background:var(--indigo-lt);"><svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
                        <div><div class="db-card-ttl">Performance</div><div class="db-card-stt">6 months</div></div>
                    </div>
                </div>
                <div class="db-card-bd"><div class="db-chart-h"><canvas id="empPerformanceChart"></canvas></div></div>
            </div>
        </div>

        {{-- Tasks --}}
        <div class="db-card">
            <div class="db-card-hd">
                <div class="db-card-hdl">
                    <div class="db-card-ico" style="background:var(--green-lt);"><svg style="stroke:var(--green)" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><rect x="3" y="3" width="18" height="18" rx="2"/></svg></div>
                    <div><div class="db-card-ttl">Daily Tasks</div><div class="db-card-stt">{{ $dailyTasks->where('completed',false)->count() }} remaining</div></div>
                </div>
                <span class="db-card-tag">{{ $dailyTasks->count() }} total</span>
            </div>
            <div class="db-card-bd">
                @forelse($dailyTasks as $task)
                    <div class="db-task">
                        <div class="db-task-cb {{ $task['completed'] ? 'done' : '' }}">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div style="flex:1;">
                            <div class="db-task-ttl {{ $task['completed'] ? 'done-t' : '' }}">{{ $task['title'] }}</div>
                            <div class="db-task-dsc">{{ $task['description'] }}</div>
                            <div class="db-task-meta">
                                <span class="db-task-pri db-pri-{{ $task['priority'] }}">{{ $task['priority'] }}</span>
                                <span class="db-task-chp"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ $task['due_time'] }}</span>
                                <span class="db-task-chp"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>{{ $task['category'] }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="db-empty">No tasks for today</div>
                @endforelse
            </div>
        </div>

        {{-- Attendance history --}}
        <div class="db-card">
            <div class="db-card-hd">
                <div class="db-card-hdl">
                    <div class="db-card-ico" style="background:var(--teal-lt);"><svg style="stroke:var(--teal)" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
                    <div><div class="db-card-ttl">Attendance History</div><div class="db-card-stt">Recent records</div></div>
                </div>
                <a href="{{ route('employee.attendance') }}" class="db-card-lnk">View all <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            </div>
            <div class="db-card-bd">
                @if($attendances->count() > 0)
                    @foreach($attendances->take(5) as $att)
                        @php
                            $as = $att->status?->value ?? 'unknown';
                            $ac = match($as) { 'present'=>'#12B76A','absent'=>'#EF4444','late'=>'#F59E0B','half_day'=>'#3B6FE8',default=>'#A8ADCA' };
                            $ab = match($as) { 'present'=>['var(--green-lt)','#087A42'],'absent'=>['var(--red-lt)','#991B1B'],'late'=>['var(--amber-lt)','#92400E'],default=>['var(--bg)','var(--ink3)'] };
                            
                            // Calculate hours worked
                            $hoursWorked = '';
                            if ($att->check_in && $att->check_out) {
                                $checkIn = \Carbon\Carbon::parse($att->date->format('Y-m-d') . ' ' . $att->check_in->format('H:i:s'));
                                $checkOut = \Carbon\Carbon::parse($att->date->format('Y-m-d') . ' ' . $att->check_out->format('H:i:s'));
                                $totalMinutes = $checkOut->diffInMinutes($checkIn);
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                                $hoursWorked = $hours . 'h ' . $minutes . 'm';
                            }
                        @endphp
                        <div class="db-att">
                            <div class="db-att-dot" style="background:{{ $ac }};box-shadow:0 0 0 3px {{ $ac }}26;"></div>
                            <div style="flex:1;">
                                <div class="db-att-date">{{ $att->date->format('M d, Y') }}</div>
                                <div class="db-att-t">
                                    @if($att->check_in) In: {{ $att->check_in->format('H:i:s') }}@endif
                                    @if($att->check_out) &nbsp;&middot;&nbsp; Out: {{ $att->check_out->format('H:i:s') }}@endif
                                    @if($hoursWorked) &nbsp;&middot;&nbsp; <strong>{{ $hoursWorked }}</strong>@endif
                                </div>
                            </div>
                            <span class="db-att-b" style="background:{{ $ab[0] }};color:{{ $ab[1] }};">{{ ucfirst($as) }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="db-empty">No attendance records yet</div>
                @endif
            </div>
        </div>
    </div>

    {{-- MID: calendar + messages + leave --}}
    <div class="db-col">
        {{-- Calendar --}}
        <div class="db-card">
            <div class="db-card-hd">
                <div class="db-card-hdl">
                    <div class="db-card-ico" style="background:var(--blue-lt);"><svg style="stroke:var(--blue)" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                    <div><div class="db-card-ttl">{{ $now->format('F Y') }}</div></div>
                </div>
            </div>
            <div class="db-card-bd" style="padding-top:14px;">
                <div class="db-cal">
                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)
                        <div class="db-cal-lbl">{{ $d }}</div>
                    @endforeach
                    @foreach($calendarDays as $day)
                        <div class="db-cal-day {{ !$day['is_current_month']?'dim':'' }} {{ $day['is_today']?'today':'' }} {{ $day['has_events']?'has-ev':'' }}">{{ $day['date'] }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="db-card">
            <div class="db-card-hd">
                <div class="db-card-hdl">
                    <div class="db-card-ico" style="background:var(--indigo-lt);"><svg style="stroke:var(--indigo)" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                    <div><div class="db-card-ttl">Messages</div><div class="db-card-stt">{{ $quickStats['unread_messages'] }} unread</div></div>
                </div>
                <a href="{{ route('employee.communication') }}" class="db-card-lnk">All <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            </div>
            <div class="db-card-bd">
                @php $avc=['#3B6FE8','#12B76A','#F59E0B','#EF4444','#6B4FDB','#0BB5B5']; @endphp
                @forelse($recentMessages as $i => $msg)
                    <div class="db-msg {{ !$msg['read'] ? 'unread' : '' }}">
                        <div class="db-msg-av" style="background:{{ $avc[$i % count($avc)] }}">{{ $msg['avatar'] }}</div>
                        <div style="flex:1;min-width:0;">
                            <div class="db-msg-sndr">{{ $msg['sender'] }}</div>
                            <div class="db-msg-subj">{{ $msg['subject'] }}</div>
                            <div class="db-msg-prev">{{ $msg['message'] }}</div>
                            <div class="db-msg-time">{{ $msg['time'] }}</div>
                        </div>
                        @if(!$msg['read'])<div style="width:7px;height:7px;border-radius:50%;background:var(--blue);flex-shrink:0;margin-top:4px;"></div>@endif
                    </div>
                @empty
                    <div class="db-empty">No messages</div>
                @endforelse
            </div>
        </div>

        {{-- Leave requests --}}
        <div class="db-card">
            <div class="db-card-hd">
                <div class="db-card-hdl">
                    <div class="db-card-ico" style="background:var(--amber-lt);"><svg style="stroke:var(--amber)" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg></div>
                    <div><div class="db-card-ttl">Leave Requests</div><div class="db-card-stt">Recent</div></div>
                </div>
                <a href="{{ route('employee.leave.request') }}" class="db-card-lnk">All <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            </div>
            <div class="db-card-bd">
                @if($leaveRequests->count() > 0)
                    @foreach($leaveRequests->take(4) as $req)
                        @php
                            $ls = $req->status->value;
                            $lc = match($ls) { 'approved'=>'db-bg-green','pending'=>'db-bg-amber',default=>'db-bg-red' };
                            $li = match($ls) { 'approved'=>['var(--green-lt)','var(--green)'],'pending'=>['var(--amber-lt)','var(--amber)'],default=>['var(--red-lt)','var(--red)'] };
                        @endphp
                        <div class="db-leave">
                            <div class="db-leave-ico" style="background:{{ $li[0] }};"><svg viewBox="0 0 24 24" style="stroke:{{ $li[1] }};"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg></div>
                            <div style="flex:1;min-width:0;">
                                <div class="db-leave-ttl">{{ $req->leave_type ?? 'Leave Request' }}</div>
                                <div class="db-leave-dts">{{ $req->start_date?->format('M d') }} &ndash; {{ $req->end_date?->format('M d, Y') }}</div>
                            </div>
                            <span class="db-badge {{ $lc }}">{{ ucfirst($ls) }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="db-empty">No leave requests</div>
                @endif
            </div>
        </div>
    </div>

    </div>{{-- /db-grid --}}
</div>{{-- /db-wrap --}}

{{-- NAV --}}
<nav class="db-nav">
    <a href="{{ route('employee.dashboard') }}" class="db-nav-item active">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home<span class="db-nav-dot"></span>
    </a>
    <a href="{{ route('employee.profile') }}" class="db-nav-item">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>
        Profile
    </a>
    <a href="{{ route('employee.attendance') }}" class="db-nav-item">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
    </a>
    <a href="{{ route('employee.leave.request') }}" class="db-nav-item">
        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="db-nav-item">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="#" class="db-nav-item" style="position:relative">
        @if($notifications->count() > 0)<span class="db-nav-notif"></span>@endif
        <svg viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    function init(){
        if(typeof Chart==='undefined'){setTimeout(init,100);return;}
        const tick='rgba(15,22,41,0.32)',grid='rgba(59,111,232,0.06)';
        const font={family:"'DM Sans',-apple-system,sans-serif",size:11,weight:'600'};
        new Chart(document.getElementById('empLeaveChart'),{
            type:'doughnut',
            data:{labels:@json($leaveChartData['labels']),datasets:[{data:@json($leaveChartData['data']),backgroundColor:['rgba(18,183,106,0.85)','rgba(245,158,11,0.85)','rgba(239,68,68,0.85)'],borderColor:['#fff','#fff','#fff'],borderWidth:2.5,hoverOffset:5}]},
            options:{responsive:true,maintainAspectRatio:false,cutout:'70%',plugins:{legend:{position:'bottom',labels:{boxWidth:8,boxHeight:8,borderRadius:4,useBorderRadius:true,padding:11,font,color:tick}}}}
        });
        new Chart(document.getElementById('empAttendanceChart'),{
            type:'bar',
            data:{labels:@json($attendanceChartData['labels']),datasets:[{label:'Present',data:@json($attendanceChartData['data']),backgroundColor:(ctx)=>{const g=ctx.chart.ctx.createLinearGradient(0,0,0,180);g.addColorStop(0,'rgba(59,111,232,0.90)');g.addColorStop(1,'rgba(59,111,232,0.28)');return g;},borderWidth:0,borderRadius:7,borderSkipped:false,barPercentage:0.52}]},
            options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false},border:{display:false},ticks:{color:tick,font}},y:{beginAtZero:true,max:1,grid:{color:grid},border:{display:false},ticks:{stepSize:1,color:tick,font,callback:v=>v===0?'':''}}}}
        });
        new Chart(document.getElementById('empPerformanceChart'),{
            type:'line',
            data:{labels:@json($performanceChartData['labels']),datasets:[{label:'Score',data:@json($performanceChartData['data']),borderColor:'#6B4FDB',backgroundColor:'rgba(107,79,219,0.08)',borderWidth:2.5,pointRadius:4,pointBackgroundColor:'#6B4FDB',pointBorderColor:'#fff',pointBorderWidth:2.5,tension:0.42,fill:true}]},
            options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false},border:{display:false},ticks:{color:tick,font}},y:{min:80,max:100,grid:{color:grid},border:{display:false},ticks:{color:tick,font}}}}
        });
    }
    document.readyState==='loading'?document.addEventListener('DOMContentLoaded',init):init();
})();
</script>
</div>