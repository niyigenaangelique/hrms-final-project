<div>
<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.prl-root {
    --glass-bg:       rgba(255,255,255,0.50);
    --glass-border:   rgba(255,255,255,0.72);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(22px) saturate(1.7);
    --radius:         20px;
    --radius-sm:      13px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 32px 36px 110px;
    display: flex; flex-direction: column; gap: 20px;
}
@keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.anim-1 { animation: fadeSlideUp 0.35s ease both; }
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }
.anim-3 { animation: fadeSlideUp 0.35s 0.14s ease both; }
.anim-4 { animation: fadeSlideUp 0.35s 0.21s ease both; }
.anim-5 { animation: fadeSlideUp 0.35s 0.28s ease both; }

.g-card { background:var(--glass-bg); backdrop-filter:var(--blur); -webkit-backdrop-filter:var(--blur); border:1px solid var(--glass-border); border-radius:var(--radius); box-shadow:var(--glass-shadow); position:relative; }
.g-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.9),transparent); pointer-events:none; border-radius:var(--radius) var(--radius) 0 0; }

/* Header */
.prl-header { padding:24px 30px; display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap; }
.prl-header h1 { font-size:24px; font-weight:700; color:var(--text-primary); letter-spacing:-0.4px; margin:0 0 3px; }
.prl-header p  { font-size:13.5px; font-weight:500; color:var(--text-secondary); margin:0; }
.prl-header-actions { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

.btn-primary   { display:inline-flex; align-items:center; gap:7px; padding:10px 16px; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(37,99,235,0.3); transition:transform .15s,box-shadow .15s; }
.btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(37,99,235,0.4); }
.btn-success   { display:inline-flex; align-items:center; gap:7px; padding:10px 16px; background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(22,163,74,0.3); transition:transform .15s,box-shadow .15s; }
.btn-success:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(22,163,74,0.4); }
.btn-purple    { display:inline-flex; align-items:center; gap:7px; padding:10px 16px; background:linear-gradient(135deg,#7c3aed,#6d28d9); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(124,58,237,0.3); transition:transform .15s,box-shadow .15s; }
.btn-purple:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }
.btn-primary svg, .btn-success svg, .btn-purple svg { width:15px; height:15px; stroke:currentColor; }

.prl-select { padding:9px 32px 9px 12px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500; color:var(--text-primary); outline:none; -webkit-appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important; background-repeat:no-repeat !important; background-position:right 10px center !important; transition:border-color .15s,box-shadow .15s; }
.prl-select:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; }

/* Flash */
.flash-ok  { background:rgba(34,197,94,0.1);  border:1px solid rgba(34,197,94,0.28);  border-radius:var(--radius-sm); padding:12px 16px; font-size:13px; font-weight:600; color:#15803d; margin-bottom:4px; }
.flash-err { background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.22);  border-radius:var(--radius-sm); padding:12px 16px; font-size:13px; font-weight:600; color:#b91c1c; margin-bottom:4px; }

/* Stats grid */
.prl-stats { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:16px; }
.prl-stat { background:var(--glass-bg); backdrop-filter:var(--blur); -webkit-backdrop-filter:var(--blur); border:1px solid var(--glass-border); border-radius:var(--radius); box-shadow:var(--glass-shadow); padding:22px 20px; position:relative; transition:transform .2s,box-shadow .2s; }
.prl-stat:hover { transform:translateY(-2px); box-shadow:0 16px 40px rgba(0,0,0,0.1); }
.prl-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.9),transparent); pointer-events:none; border-radius:var(--radius) var(--radius) 0 0; }
.prl-stat-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:14px; }
.prl-stat-icon svg { width:19px; height:19px; }
.si-blue   { background:rgba(37,99,235,0.12);  } .si-blue   svg { stroke:#2563eb; }
.si-green  { background:rgba(34,197,94,0.12);  } .si-green  svg { stroke:#16a34a; }
.si-amber  { background:rgba(245,158,11,0.12); } .si-amber  svg { stroke:#d97706; }
.si-purple { background:rgba(124,58,237,0.12); } .si-purple svg { stroke:#7c3aed; }
.prl-stat-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); margin-bottom:6px; }
.prl-stat-value { font-size:26px; font-weight:700; color:var(--text-primary); letter-spacing:-1px; line-height:1; }

/* Two col */
.prl-two-col { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.prl-card-head { padding:18px 24px 14px; border-bottom:1px solid rgba(0,0,0,0.055); }
.prl-card-title { font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 2px; }
.prl-card-sub   { font-size:11.5px; font-weight:500; color:var(--text-tertiary); margin:0; }
.prl-card-body  { padding:18px 24px 22px; }

.prl-big-amount { font-size:38px; font-weight:700; color:#2563eb; letter-spacing:-2px; line-height:1; margin-bottom:8px; }
.prl-change { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; }
.prl-change.up   { color:#15803d; }
.prl-change.down { color:#b91c1c; }
.prl-change.flat { color:var(--text-tertiary); }
.prl-change svg  { width:14px; height:14px; stroke:currentColor; }

.prl-kv-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid rgba(0,0,0,0.05); }
.prl-kv-row:last-child { border-bottom:none; }
.prl-kv-label { font-size:13px; font-weight:500; color:var(--text-secondary); }
.prl-kv-value { font-size:14px; font-weight:700; color:var(--text-primary); }

/* Upcoming payrolls */
.prl-upcoming-item { display:flex; justify-content:space-between; align-items:center; padding:14px 16px; background:rgba(255,255,255,0.5); border:1px solid rgba(255,255,255,0.8); border-radius:var(--radius-sm); margin-bottom:10px; transition:box-shadow .15s; }
.prl-upcoming-item:hover { box-shadow:0 4px 14px rgba(0,0,0,0.07); }
.prl-upcoming-item:last-child { margin-bottom:0; }
.prl-upcoming-name { font-size:14px; font-weight:700; color:var(--text-primary); margin-bottom:2px; }
.prl-upcoming-dates { font-size:12px; font-weight:500; color:var(--text-secondary); }
.prl-upcoming-count { font-size:12px; font-weight:500; color:var(--text-tertiary); margin-bottom:2px; text-align:right; }
.prl-upcoming-amount { font-size:15px; font-weight:700; color:var(--text-primary); text-align:right; }

/* Table */
.prl-table-wrap { overflow-x:auto; }
table.prl-table { width:100%; border-collapse:collapse; }
.prl-table thead tr { border-bottom:1px solid rgba(0,0,0,0.07); }
.prl-table th { padding:11px 18px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); text-align:left; white-space:nowrap; }
.prl-table tbody tr { border-bottom:1px solid rgba(0,0,0,0.04); transition:background .12s; }
.prl-table tbody tr:last-child { border-bottom:none; }
.prl-table tbody tr:hover { background:rgba(255,255,255,0.55); }
.prl-table td { padding:12px 18px; font-size:13.5px; font-weight:500; color:var(--text-primary); white-space:nowrap; vertical-align:middle; }

.badge { display:inline-flex; font-size:11px; font-weight:700; padding:3px 10px; border-radius:var(--radius-pill); }
.badge-green  { background:rgba(34,197,94,0.14);  color:#15803d; }
.badge-amber  { background:rgba(245,158,11,0.14); color:#b45309; }
.badge-red    { background:rgba(239,68,68,0.14);  color:#b91c1c; }

/* Trends */
.prl-trend-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid rgba(0,0,0,0.05); }
.prl-trend-row:last-child { border-bottom:none; }
.prl-trend-left { display:flex; align-items:center; gap:10px; }
.prl-trend-dot { width:8px; height:8px; border-radius:50%; background:#2563eb; flex-shrink:0; }
.prl-trend-label { font-size:13.5px; font-weight:500; color:var(--text-primary); }
.prl-trend-count { font-size:11.5px; font-weight:500; color:var(--text-tertiary); }
.prl-trend-amount { font-size:14px; font-weight:700; color:var(--text-primary); }

/* Empty */
.prl-empty { text-align:center; padding:40px 24px; }
.prl-empty-icon { width:48px; height:48px; background:rgba(0,0,0,0.05); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; }
.prl-empty-icon svg { width:24px; height:24px; stroke:var(--text-tertiary); }
.prl-empty-text { font-size:14px; font-weight:500; color:var(--text-secondary); }

/* Modal */
.prl-modal-bg { position:fixed; inset:0; z-index:60; background:rgba(0,0,0,0.28); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); display:flex; align-items:center; justify-content:center; padding:24px; }
.prl-modal { background:rgba(255,255,255,0.95); backdrop-filter:blur(32px) saturate(1.8); -webkit-backdrop-filter:blur(32px) saturate(1.8); border:1px solid rgba(255,255,255,0.92); border-radius:var(--radius); box-shadow:0 32px 80px rgba(0,0,0,0.18); width:100%; max-width:560px; max-height:90vh; overflow-y:auto; }
.prl-modal-head { display:flex; justify-content:space-between; align-items:center; padding:20px 24px 16px; border-bottom:1px solid rgba(0,0,0,0.06); position:sticky; top:0; background:rgba(255,255,255,0.95); z-index:1; }
.prl-modal-title { font-size:18px; font-weight:700; color:var(--text-primary); margin:0; }
.prl-modal-close { width:30px; height:30px; border-radius:50%; background:rgba(0,0,0,0.06); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .15s; }
.prl-modal-close:hover { background:rgba(0,0,0,0.12); }
.prl-modal-close svg { width:14px; height:14px; stroke:var(--text-secondary); }
.prl-modal-body { padding:20px 24px; display:flex; flex-direction:column; gap:16px; }
.prl-modal-footer { padding:16px 24px 22px; border-top:1px solid rgba(0,0,0,0.06); display:flex; justify-content:flex-end; gap:10px; }

.prl-field { display:flex; flex-direction:column; gap:5px; }
.prl-field label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.prl-field select { padding:10px 36px 10px 14px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--text-primary); outline:none; width:100%; box-sizing:border-box; -webkit-appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important; background-repeat:no-repeat !important; background-position:right 14px center !important; transition:border-color .15s,box-shadow .15s; }
.prl-field select:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; }

.prl-employee-list { border:1px solid rgba(0,0,0,0.1); border-radius:var(--radius-sm); padding:8px; max-height:160px; overflow-y:auto; background:rgba(255,255,255,0.6); }
.prl-employee-item { display:flex; align-items:center; gap:10px; padding:8px 10px; border-radius:8px; cursor:pointer; transition:background .12s; }
.prl-employee-item:hover { background:rgba(0,0,0,0.04); }
.prl-employee-item input[type="checkbox"] { width:16px; height:16px; accent-color:#0d9488; cursor:pointer; flex-shrink:0; }
.prl-employee-name { font-size:13.5px; font-weight:600; color:var(--text-primary); }
.prl-employee-code { font-size:11.5px; font-weight:500; color:var(--text-tertiary); margin-left:6px; }

.prl-progress-wrap { background:rgba(37,99,235,0.07); border:1px solid rgba(37,99,235,0.18); border-radius:var(--radius-sm); padding:14px 16px; }
.prl-progress-label { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:13px; font-weight:600; color:#1d4ed8; }
.prl-progress-track { height:8px; border-radius:8px; background:rgba(37,99,235,0.15); overflow:hidden; }
.prl-progress-fill { height:100%; border-radius:8px; background:linear-gradient(90deg,#2563eb,#0891b2); transition:width .3s; }

.btn-modal-cancel { padding:10px 18px; background:rgba(0,0,0,0.06); color:var(--text-secondary); border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .15s; }
.btn-modal-cancel:hover { background:rgba(0,0,0,0.1); }
.btn-modal-primary { padding:10px 20px; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(37,99,235,0.3); transition:transform .15s,box-shadow .15s; }
.btn-modal-primary:hover:not(:disabled) { transform:translateY(-1px); box-shadow:0 6px 20px rgba(37,99,235,0.4); }
.btn-modal-primary:disabled { opacity:0.5; cursor:not-allowed; }
.btn-modal-success { padding:10px 20px; background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(22,163,74,0.3); transition:transform .15s,box-shadow .15s; }
.btn-modal-success:hover:not(:disabled) { transform:translateY(-1px); }
.btn-modal-success:disabled { opacity:0.5; cursor:not-allowed; }

@media (max-width:1100px) { .prl-stats { grid-template-columns:repeat(2,1fr); } }
@media (max-width:768px) { .prl-root { padding:18px 14px 100px; } .prl-two-col { grid-template-columns:1fr; } .prl-stats { grid-template-columns:repeat(2,1fr); gap:12px; } .prl-header { flex-direction:column; align-items:flex-start; } }

/* Floating Navigation */
.floating-nav {
    position: fixed;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 50;
    display: flex;
    gap: 12px;
    padding: 12px;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(24px) saturate(1.8);
    -webkit-backdrop-filter: blur(24px) saturate(1.8);
    border: 1px solid rgba(255,255,255,0.88);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 8px 24px rgba(0,0,0,0.08);
    font-family: 'DM Sans', -apple-system, sans-serif;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 10px 16px;
    border-radius: 16px;
    text-decoration: none;
    color: rgba(15,15,25,0.68);
    transition: all 0.2s ease;
    position: relative;
    min-width: 64px;
}

.nav-item:hover {
    background: rgba(37,99,235,0.08);
    color: #2563eb;
    transform: translateY(-2px);
}

.nav-item.active {
    background: linear-gradient(135deg, rgba(37,99,235,0.12), rgba(99,102,241,0.08));
    color: #2563eb;
    font-weight: 600;
}

.nav-item.active::before {
    content: '';
    position: absolute;
    top: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 32px;
    height: 3px;
    background: linear-gradient(90deg, #2563eb, #6366f1);
    border-radius: 2px;
}

.nav-icon {
    width: 20px;
    height: 20px;
    stroke: currentColor;
    stroke-width: 2;
}

.nav-label {
    font-size: 11px;
    font-weight: 500;
    text-align: center;
    line-height: 1.2;
}

@media (max-width: 768px) {
    .floating-nav {
        bottom: 20px;
        left: 20px;
        right: 20px;
        transform: none;
        padding: 10px;
        gap: 8px;
        border-radius: 20px;
    }
    
    .nav-item {
        padding: 8px 12px;
        min-width: 56px;
    }
    
    .nav-icon {
        width: 18px;
        height: 18px;
    }
    
    .nav-label {
        font-size: 10px;
    }
}
</style>

<div>
<div class="prl-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="prl-header">
            <div>
                <h1>Payroll Dashboard</h1>
                <p>Process employee payroll and manage payments</p>
            </div>
            <div class="prl-header-actions">
                <button wire:click="openProcessModal" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    Process Payroll
                </button>
                <button wire:click="openBulkProcessModal" class="btn-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    Bulk Process All
                </button>
                <button wire:click="generatePayslips" class="btn-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Generate Payslips
                </button>
                <select wire:model.live="selectedMonth" class="prl-select">
                    @for($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}">{{ Carbon\Carbon::createFromDate(null, $month, 1)->format('F') }}</option>
                    @endfor
                </select>
                <select wire:model.live="selectedYear" class="prl-select">
                    @for($year = now()->year - 2; $year <= now()->year + 1; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    {{-- ── Flash ─────────────────────────────────────── --}}
    @if(session()->has('success') || session()->has('error'))
        <div>
            @if(session()->has('success')) <div class="flash-ok">{{ session('success') }}</div> @endif
            @if(session()->has('error'))   <div class="flash-err">{{ session('error') }}</div> @endif
        </div>
    @endif

    {{-- ── Stats ─────────────────────────────────────── --}}
    <div class="prl-stats anim-2">
        <div class="prl-stat">
            <div class="prl-stat-icon si-blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
            <div class="prl-stat-label">Total Payroll</div>
            <div class="prl-stat-value">${{ number_format($totalPayrollAmount, 2) }}</div>
        </div>
        <div class="prl-stat">
            <div class="prl-stat-icon si-green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></div>
            <div class="prl-stat-label">Total Employees</div>
            <div class="prl-stat-value">{{ $totalEmployees }}</div>
        </div>
        <div class="prl-stat">
            <div class="prl-stat-icon si-amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div class="prl-stat-label">Pending Payments</div>
            <div class="prl-stat-value">{{ $pendingPayments }}</div>
        </div>
        <div class="prl-stat">
            <div class="prl-stat-icon si-purple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div class="prl-stat-label">Completed Payments</div>
            <div class="prl-stat-value">{{ $completedPayments }}</div>
        </div>
    </div>

    {{-- ── Monthly overview + Department ────────────── --}}
    <div class="prl-two-col anim-3">
        <div class="g-card">
            <div class="prl-card-head">
                <p class="prl-card-title">{{ Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1)->format('F Y') }} Payroll</p>
                <p class="prl-card-sub">Current month total</p>
            </div>
            <div class="prl-card-body">
                <div class="prl-big-amount">${{ number_format($monthlyComparison['current'], 2) }}</div>
                <div class="prl-change {{ $monthlyComparison['change'] > 0 ? 'up' : ($monthlyComparison['change'] < 0 ? 'down' : 'flat') }}">
                    @if($monthlyComparison['change'] > 0)
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
                        +{{ number_format($monthlyComparison['change'], 1) }}% from previous month
                    @elseif($monthlyComparison['change'] < 0)
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        {{ number_format($monthlyComparison['change'], 1) }}% from previous month
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        No change from previous month
                    @endif
                </div>
            </div>
        </div>
        <div class="g-card">
            <div class="prl-card-head">
                <p class="prl-card-title">Department Overview</p>
            </div>
            <div class="prl-card-body">
                @if($departmentStats)
                    <div class="prl-kv-row">
                        <span class="prl-kv-label">{{ $departmentStats->department }}</span>
                        <span class="prl-kv-value">{{ $departmentStats->employee_count }} employees</span>
                    </div>
                @endif
                <div class="prl-kv-row">
                    <span class="prl-kv-label">Avg. Salary</span>
                    <span class="prl-kv-value">${{ number_format($totalEmployees > 0 ? $totalPayrollAmount / $totalEmployees : 0, 2) }}</span>
                </div>
                <div class="prl-kv-row">
                    <span class="prl-kv-label">Payroll Entries</span>
                    <span class="prl-kv-value">{{ $totalPayrollEntries }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Upcoming payrolls ─────────────────────────── --}}
    <div class="g-card anim-4">
        <div class="prl-card-head">
            <p class="prl-card-title">Upcoming Payroll Periods</p>
        </div>
        <div class="prl-card-body">
            @if($upcomingPayrolls->count() > 0)
                @foreach($upcomingPayrolls as $payroll)
                    <div class="prl-upcoming-item">
                        <div>
                            <div class="prl-upcoming-name">{{ $payroll->name }}</div>
                            <div class="prl-upcoming-dates">{{ Carbon\Carbon::parse($payroll->start_date)->format('M d') }} — {{ Carbon\Carbon::parse($payroll->end_date)->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="prl-upcoming-count">{{ $payroll->payrollEntries->count() }} employees</div>
                            <div class="prl-upcoming-amount">${{ number_format($payroll->payrollEntries->sum('total_amount'), 2) }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="prl-empty">
                    <div class="prl-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
                    <p class="prl-empty-text">No upcoming payroll periods</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Recent payments ───────────────────────────── --}}
    <div class="g-card anim-4">
        <div class="prl-card-head">
            <p class="prl-card-title">Recent Payments</p>
        </div>
        <div class="prl-table-wrap">
            <table class="prl-table">
                <thead><tr>
                    <th>Employee</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th>
                </tr></thead>
                <tbody>
                    @foreach($recentPayments as $payment)
                        @php $ps = $payment->status->value; $pc = match($ps) { 'completed' => 'badge-green', 'pending' => 'badge-amber', default => 'badge-red' }; @endphp
                        <tr>
                            <td>{{ $payment->employee->first_name }} {{ $payment->employee->last_name }}</td>
                            <td>${{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_method ?? 'bank') }}</td>
                            <td><span class="badge {{ $pc }}">{{ ucfirst($ps) }}</span></td>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Payroll trends ────────────────────────────── --}}
    <div class="g-card anim-5">
        <div class="prl-card-head">
            <p class="prl-card-title">Payroll Trends</p>
            <p class="prl-card-sub">Last 6 months</p>
        </div>
        <div class="prl-card-body">
            @foreach($payrollTrends as $trend)
                <div class="prl-trend-row">
                    <div class="prl-trend-left">
                        <div class="prl-trend-dot"></div>
                        <span class="prl-trend-label">{{ Carbon\Carbon::createFromDate($trend->year, $trend->month, 1)->format('F Y') }}</span>
                        <span class="prl-trend-count">({{ $trend->count }} entries)</span>
                    </div>
                    <span class="prl-trend-amount">${{ number_format($trend->total, 2) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── Process Payroll Modal ─────────────────────── --}}
    @if($showProcessModal)
        <div class="prl-modal-bg" wire:click="closeProcessModal">
            <div class="prl-modal" wire:click.stop>
                <div class="prl-modal-head">
                    <h3 class="prl-modal-title">Process Employee Payroll</h3>
                    <button class="prl-modal-close" wire:click="closeProcessModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="prl-modal-body">
                    <div class="prl-field">
                        <label>Select Payroll Month</label>
                        <select wire:model.live="processingMonth.id">
                            <option value="">Select a payroll month</option>
                            @foreach($upcomingPayrolls as $payroll)
                                <option value="{{ $payroll->id }}">{{ $payroll->name }} ({{ Carbon\Carbon::parse($payroll->start_date)->format('M Y') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="prl-field">
                        <label>Select Employees</label>
                        <div class="prl-employee-list">
                            @foreach(App\Models\Employee::where('approval_status', 'approved')->get() as $employee)
                                <div class="prl-employee-item">
                                    <input type="checkbox" wire:model="processingEmployees.{{ $employee->id }}" id="emp_{{ $employee->id }}">
                                    <label for="emp_{{ $employee->id }}" style="cursor:pointer;">
                                        <span class="prl-employee-name">{{ $employee->first_name }} {{ $employee->last_name }}</span>
                                        <span class="prl-employee-code">{{ $employee->code }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if($processingStatus === 'processing')
                        <div class="prl-progress-wrap">
                            <div class="prl-progress-label">
                                <span>Processing payroll...</span>
                                <span>{{ $processedCount }} / {{ $totalCount }}</span>
                            </div>
                            <div class="prl-progress-track">
                                <div class="prl-progress-fill" style="width:{{ $processingProgress }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="prl-modal-footer">
                    <button class="btn-modal-cancel" wire:click="closeProcessModal">Cancel</button>
                    <button class="btn-modal-primary" wire:click="processPayroll" @disabled($processingStatus === 'processing')>
                        {{ $processingStatus === 'processing' ? 'Processing...' : 'Process Payroll' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Bulk Process Modal ────────────────────────── --}}
    @if($showBulkProcessModal)
        <div class="prl-modal-bg" wire:click="closeBulkProcessModal">
            <div class="prl-modal" wire:click.stop>
                <div class="prl-modal-head">
                    <h3 class="prl-modal-title">Bulk Process All Employees</h3>
                    <button class="prl-modal-close" wire:click="closeBulkProcessModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="prl-modal-body">
                    <div class="prl-field">
                        <label>Select Payroll Month</label>
                        <select wire:model.live="processingMonth.id">
                            <option value="">Select a payroll month</option>
                            @foreach($upcomingPayrolls as $payroll)
                                <option value="{{ $payroll->id }}">{{ $payroll->name }} ({{ Carbon\Carbon::parse($payroll->start_date)->format('M Y') }})</option>
                            @endforeach
                        </select>
                    </div>
                    @if($processingStatus === 'processing')
                        <div class="prl-progress-wrap">
                            <div class="prl-progress-label">
                                <span>Processing all employees...</span>
                                <span>{{ $processedCount }} / {{ $totalCount }}</span>
                            </div>
                            <div class="prl-progress-track">
                                <div class="prl-progress-fill" style="width:{{ $processingProgress }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="prl-modal-footer">
                    <button class="btn-modal-cancel" wire:click="closeBulkProcessModal">Cancel</button>
                    <button class="btn-modal-success" wire:click="bulkProcessAllEmployees" @disabled($processingStatus === 'processing')>
                        {{ $processingStatus === 'processing' ? 'Processing...' : 'Bulk Process All' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
</div>
</div>

<div class="floating-nav">
    <a href="{{ route('payroll.dashboard') }}" class="nav-item active">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        <span class="nav-label">Dashboard</span>
    </a>
    
    <a href="{{ route('payroll.payslip-generator') }}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        <span class="nav-label">Payslips</span>
    </a>
    
    <a href="{{ route('payroll.tax-calculator') }}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
        <span class="nav-label">Tax Calc</span>
    </a>
</div>

</div>