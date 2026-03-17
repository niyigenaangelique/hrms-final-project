<div class="pay-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.pay-root {
    --glass-bg:       rgba(255,255,255,0.45);
    --glass-strong:   rgba(255,255,255,0.68);
    --glass-border:   rgba(255,255,255,0.68);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(24px) saturate(1.8);
    --radius:         22px;
    --radius-sm:      13px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 36px 40px 120px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

/* ── Glass card ───────────────────────────────────────── */
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
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

/* ── Page header ──────────────────────────────────────── */
.pay-header {
    padding: 26px 32px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
}

.pay-header h1 { font-size: 28px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 4px; }
.pay-header p  { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0; }

.pay-period-badge {
    background: var(--glass-strong);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-pill);
    padding: 8px 18px;
    font-size: 13px; font-weight: 600;
    color: var(--text-secondary);
    flex-shrink: 0;
}

/* ── Hero net pay + stat cards row ───────────────────── */
.pay-hero-row {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 16px;
    align-items: stretch;
}

/* Net pay hero card */
.pay-net-hero {
    background: linear-gradient(145deg, rgba(13,148,136,0.85) 0%, rgba(8,145,178,0.85) 100%);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: var(--radius);
    box-shadow: 0 12px 40px rgba(13,148,136,0.3), 0 4px 16px rgba(0,0,0,0.08);
    padding: 28px 24px;
    display: flex; flex-direction: column; justify-content: space-between;
    position: relative; overflow: hidden;
}

.pay-net-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
}

.pay-net-glow {
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    pointer-events: none;
}

.pay-net-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.7); margin-bottom: 8px; }
.pay-net-amount { font-size: 38px; font-weight: 700; color: #fff; letter-spacing: -1px; line-height: 1; margin-bottom: 6px; }
.pay-net-sub { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.65); }

.pay-net-icon {
    width: 44px; height: 44px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
}

.pay-net-icon svg { width: 22px; height: 22px; stroke: #fff; }

/* Stat cards */
.pay-stats { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 12px; }

.pay-stat {
    background: var(--glass-strong);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-sm);
    box-shadow: var(--glass-shadow);
    padding: 18px;
    position: relative; overflow: hidden;
}

.pay-stat::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
}

.pay-stat-icon { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
.pay-stat-icon svg { width: 16px; height: 16px; }
.si-blue   { background: rgba(37,99,235,0.12); }  .si-blue   svg { stroke: #2563eb; }
.si-green  { background: rgba(34,197,94,0.12); }  .si-green  svg { stroke: #16a34a; }
.si-purple { background: rgba(168,85,247,0.12); } .si-purple svg { stroke: #9333ea; }
.si-amber  { background: rgba(245,158,11,0.12); } .si-amber  svg { stroke: #d97706; }

.pay-stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-tertiary); margin-bottom: 5px; }
.pay-stat-value { font-size: 18px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.2px; }

/* ── Employee info + breakdown row ───────────────────── */
.pay-info-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* Section title */
.pay-section-title {
    font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-tertiary);
    margin-bottom: 14px;
}

.pay-card-body { padding: 22px 26px; }

/* Info rows */
.pay-info-group { margin-bottom: 20px; }
.pay-info-group:last-child { margin-bottom: 0; }

.pay-info-row-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 0;
    border-bottom: 1px solid rgba(0,0,0,0.04);
}

.pay-info-row-item:last-child { border-bottom: none; }
.pay-info-label { font-size: 13px; font-weight: 500; color: var(--text-secondary); }
.pay-info-value { font-size: 13.5px; font-weight: 700; color: var(--text-primary); text-align: right; }

/* Active badge */
.badge-active   { background: rgba(34,197,94,0.14); color: #15803d; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); }
.badge-inactive { background: rgba(239,68,68,0.12); color: #b91c1c; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); }

/* Earnings / Deductions breakdown */
.pay-breakdown-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    font-size: 13.5px;
}

.pay-breakdown-item:last-child { border-bottom: none; }
.pay-breakdown-label { font-weight: 500; color: var(--text-secondary); }
.pay-breakdown-value { font-weight: 700; color: var(--text-primary); }
.pay-breakdown-value.positive { color: #15803d; }
.pay-breakdown-value.negative { color: #b91c1c; }

.pay-breakdown-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0 0;
    margin-top: 6px;
    border-top: 1.5px solid rgba(0,0,0,0.08);
    font-size: 14px; font-weight: 700; color: var(--text-primary);
}

/* ── Two-column bottom section ────────────────────────── */
.pay-bottom-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* Table shared styles */
.pay-table-wrap { overflow-x: auto; }

table.pay-table { width: 100%; border-collapse: collapse; }
.pay-table thead tr { border-bottom: 1px solid rgba(0,0,0,0.06); }
.pay-table th { padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); text-align: left; white-space: nowrap; }
.pay-table tbody tr { border-bottom: 1px solid rgba(0,0,0,0.04); transition: background 0.12s; }
.pay-table tbody tr:last-child { border-bottom: none; }
.pay-table tbody tr:hover { background: rgba(255,255,255,0.5); }
.pay-table td { padding: 11px 14px; font-size: 13.5px; font-weight: 500; color: var(--text-primary); white-space: nowrap; }
.pay-table td.muted { color: var(--text-secondary); font-weight: 400; }

/* Leave balance bars */
.pay-leave-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 0; border-bottom: 1px solid rgba(0,0,0,0.05);
}

.pay-leave-item:last-child { border-bottom: none; }
.pay-leave-name  { font-size: 13.5px; font-weight: 700; color: var(--text-primary); margin-bottom: 3px; }
.pay-leave-year  { font-size: 11px; font-weight: 500; color: var(--text-tertiary); }
.pay-leave-days  { font-size: 18px; font-weight: 700; color: var(--text-primary); text-align: right; }
.pay-leave-total { font-size: 11px; font-weight: 500; color: var(--text-tertiary); text-align: right; }

.pay-leave-bar-wrap { height: 4px; background: rgba(0,0,0,0.07); border-radius: 4px; overflow: hidden; margin-top: 6px; width: 100px; }
.pay-leave-bar { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #0d9488, #0891b2); }

/* ── Payroll history table ────────────────────────────── */
.badge { display: inline-flex; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); }
.badge-green  { background: rgba(34,197,94,0.14); color: #15803d; }
.badge-amber  { background: rgba(245,158,11,0.14); color: #b45309; }
.badge-gray   { background: rgba(0,0,0,0.07); color: var(--text-secondary); }

.btn-payslip {
    font-size: 12px; font-weight: 600; color: #2563eb;
    background: rgba(37,99,235,0.08); border: none; border-radius: 7px;
    padding: 5px 12px; cursor: pointer;
    font-family: 'DM Sans', sans-serif; transition: background 0.15s;
}

.btn-payslip:hover { background: rgba(37,99,235,0.15); }

/* Empty states */
.pay-empty { text-align: center; padding: 40px 24px; }
.pay-empty-icon { width: 48px; height: 48px; background: rgba(0,0,0,0.05); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.pay-empty-icon svg { width: 24px; height: 24px; stroke: var(--text-tertiary); }
.pay-empty-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.pay-empty-sub   { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0; }

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
    .pay-hero-row { grid-template-columns: 1fr; }
    .pay-stats { grid-template-columns: repeat(2,1fr); }
    .pay-info-row { grid-template-columns: 1fr; }
    .pay-bottom-row { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .pay-root { padding: 20px 16px 110px; }
    .pay-stats { grid-template-columns: repeat(2,1fr); }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header ──────────────────────────────────── --}}
<div class="g-card">
    <div class="pay-header">
        <div>
            <h1>My Payroll</h1>
            <p>View your salary information, deductions, and payslips</p>
        </div>
        @if($currentPayrollEntry)
            <div class="pay-period-badge">{{ $currentPayrollEntry->payrollMonth->name ?? 'Current Period' }}</div>
        @endif
    </div>
</div>

{{-- ── Hero net pay + stat cards ────────────────────── --}}
@if($currentPayrollEntry)
<div class="pay-hero-row">

    {{-- Net pay hero --}}
    <div class="pay-net-hero">
        <div class="pay-net-glow"></div>
        <div class="pay-net-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
        </div>
        <div>
            <div class="pay-net-label">Net Pay</div>
            <div class="pay-net-amount">${{ number_format($netPay, 2) }}</div>
            <div class="pay-net-sub">{{ $currentPayrollEntry->payrollMonth->name ?? 'Current Period' }}</div>
        </div>
    </div>

    {{-- Four stat cards --}}
    <div class="pay-stats">
        <div class="pay-stat">
            <div class="pay-stat-icon si-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
            </div>
            <div class="pay-stat-label">Daily Rate</div>
            <div class="pay-stat-value">${{ number_format($currentPayrollEntry->daily_rate, 2) }}</div>
        </div>
        <div class="pay-stat">
            <div class="pay-stat-icon si-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div class="pay-stat-label">Work Days Pay</div>
            <div class="pay-stat-value">${{ number_format($currentPayrollEntry->work_days_pay, 2) }}</div>
        </div>
        <div class="pay-stat">
            <div class="pay-stat-icon si-purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            </div>
            <div class="pay-stat-label">Overtime</div>
            <div class="pay-stat-value">${{ number_format($currentPayrollEntry->overtime_total_amount, 2) }}</div>
        </div>
        <div class="pay-stat">
            <div class="pay-stat-icon si-amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="pay-stat-label">Deductions</div>
            <div class="pay-stat-value">${{ number_format($totalDeductions, 2) }}</div>
        </div>
    </div>

</div>

{{-- ── Employee info + Earnings + Deductions ────────── --}}
<div class="pay-info-row">

    {{-- Employee information --}}
    <div class="g-card">
        <div class="pay-card-body">
            <div class="pay-section-title">Personal Details</div>
            <div class="pay-info-group">
                <div class="pay-info-row-item"><span class="pay-info-label">Name</span><span class="pay-info-value">{{ $employee->full_name }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">Employee ID</span><span class="pay-info-value">{{ $employee->code }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">Email</span><span class="pay-info-value">{{ $employee->email }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">Phone</span><span class="pay-info-value">{{ $employee->phone_number ?? '—' }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">Hire Date</span><span class="pay-info-value">{{ $employee->join_date?->format('M d, Y') ?? 'N/A' }}</span></div>
            </div>

            <div class="pay-section-title" style="margin-top:20px;">Position & Status</div>
            <div class="pay-info-group">
                <div class="pay-info-row-item"><span class="pay-info-label">Department</span><span class="pay-info-value">{{ $employee->department?->name ?? '—' }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">Position</span><span class="pay-info-value">{{ $employee->position?->name ?? '—' }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">National ID</span><span class="pay-info-value">{{ $employee->national_id ?? '—' }}</span></div>
                <div class="pay-info-row-item"><span class="pay-info-label">RSS Number</span><span class="pay-info-value">{{ $employee->rss_number ?? '—' }}</span></div>
                <div class="pay-info-row-item">
                    <span class="pay-info-label">Status</span>
                    <span class="{{ $employee->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Earnings + Deductions breakdown --}}
    <div style="display:flex; flex-direction:column; gap:16px;">
        <div class="g-card">
            <div class="pay-card-body">
                <div class="pay-section-title">Earnings Breakdown</div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Work Days ({{ $currentPayrollEntry->work_days }} days)</span>
                    <span class="pay-breakdown-value">${{ number_format($currentPayrollEntry->work_days_pay, 2) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Overtime ({{ $currentPayrollEntry->overtime_hours_worked }}h @ ${{ number_format($currentPayrollEntry->overtime_hour_rate, 2) }}/hr)</span>
                    <span class="pay-breakdown-value">${{ number_format($currentPayrollEntry->overtime_total_amount, 2) }}</span>
                </div>
                @if($totalBenefits > 0)
                    <div class="pay-breakdown-item">
                        <span class="pay-breakdown-label">Benefits</span>
                        <span class="pay-breakdown-value positive">+${{ number_format($totalBenefits, 2) }}</span>
                    </div>
                @endif
                <div class="pay-breakdown-total">
                    <span>Gross Pay</span>
                    <span>${{ number_format($currentPayrollEntry->work_days_pay + $currentPayrollEntry->overtime_total_amount + ($totalBenefits ?? 0), 2) }}</span>
                </div>
            </div>
        </div>

        <div class="g-card">
            <div class="pay-card-body">
                <div class="pay-section-title">Deductions Breakdown</div>
                @if($currentPayrollEntry->deductionEntries->count() > 0)
                    @foreach($currentPayrollEntry->deductionEntries as $deduction)
                        <div class="pay-breakdown-item">
                            <span class="pay-breakdown-label">{{ $deduction->deduction->name }}</span>
                            <span class="pay-breakdown-value negative">-${{ number_format($deduction->amount, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="pay-breakdown-total">
                        <span>Total Deductions</span>
                        <span style="color:#b91c1c;">${{ number_format($totalDeductions, 2) }}</span>
                    </div>
                @else
                    <p style="font-size:13px; font-weight:500; color:var(--text-tertiary);">No deductions for this period</p>
                @endif
            </div>
        </div>
    </div>

</div>

@else
{{-- No payroll data --}}
<div class="g-card">
    <div class="pay-empty">
        <div class="pay-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
        <p class="pay-empty-title">No payroll data for current period</p>
        <p class="pay-empty-sub">Payroll information will appear once processed by HR.</p>
    </div>
</div>
@endif

{{-- ── Recent attendance + Leave balances ───────────── --}}
<div class="pay-bottom-row">

    {{-- Recent attendance --}}
    <div class="g-card">
        <div class="pay-card-body">
            <div class="pay-section-title">Recent Attendance — Last 30 Days</div>
            @if($recentAttendances->count() > 0)
                <div class="pay-table-wrap">
                    <table class="pay-table">
                        <thead><tr>
                            <th>Date</th><th>Clock In</th><th>Clock Out</th><th>Hours</th>
                        </tr></thead>
                        <tbody>
                            @foreach($recentAttendances as $att)
                                @php
                                    $hrs = $att->check_in && $att->check_out
                                        ? \Carbon\Carbon::parse($att->check_in)->diffInHours(\Carbon\Carbon::parse($att->check_out)) . 'h'
                                        : '—';
                                @endphp
                                <tr>
                                    <td style="font-weight:600;">{{ $att->date->format('M d') }}</td>
                                    <td class="muted">{{ $att->check_in ?? '—' }}</td>
                                    <td class="muted">{{ $att->check_out ?? '—' }}</td>
                                    <td>{{ $hrs }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="font-size:13px; font-weight:500; color:var(--text-tertiary);">No attendance records found</p>
            @endif
        </div>
    </div>

    {{-- Leave balances --}}
    <div class="g-card">
        <div class="pay-card-body">
            <div class="pay-section-title">Leave Balances</div>
            @if($leaveBalances->count() > 0)
                @foreach($leaveBalances as $balance)
                    @php $pct = $balance->total_days > 0 ? min(100, round(($balance->remaining_days / $balance->total_days) * 100)) : 0; @endphp
                    <div class="pay-leave-item">
                        <div style="flex:1;">
                            <div class="pay-leave-name">{{ ucfirst($balance->leave_type) }}</div>
                            <div class="pay-leave-year">{{ $balance->year }}</div>
                            <div class="pay-leave-bar-wrap" style="margin-top:6px;">
                                <div class="pay-leave-bar" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                        <div style="margin-left:16px; text-align:right;">
                            <div class="pay-leave-days">{{ $balance->remaining_days }}</div>
                            <div class="pay-leave-total">of {{ $balance->total_days }} days</div>
                        </div>
                    </div>
                @endforeach
            @else
                <p style="font-size:13px; font-weight:500; color:var(--text-tertiary);">No leave balance information available</p>
            @endif
        </div>
    </div>

</div>

{{-- ── Payroll history ───────────────────────────────── --}}
<div class="g-card">
    <div class="pay-card-body">
        <div class="pay-section-title">Payroll History</div>
        @if($payrollEntries->count() > 0)
            <div class="pay-table-wrap">
                <table class="pay-table">
                    <thead><tr>
                        <th>Period</th>
                        <th>Work Days Pay</th>
                        <th>Overtime</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th>Status</th>
                        <th>Payslip</th>
                    </tr></thead>
                    <tbody>
                        @foreach($payrollEntries as $entry)
                            @php
                                $es = $entry->status->value;
                                $ec = match($es) { 'processed' => 'badge-green', 'pending' => 'badge-amber', default => 'badge-gray' };
                                $entryDeductions = $entry->deductionEntries->sum('amount');
                                $entryNet = $entry->total_amount - $entryDeductions;
                            @endphp
                            <tr>
                                <td style="font-weight:600;">{{ $entry->payrollMonth->name ?? 'N/A' }}</td>
                                <td class="muted">${{ number_format($entry->work_days_pay, 2) }}</td>
                                <td class="muted">${{ number_format($entry->overtime_total_amount, 2) }}</td>
                                <td class="muted" style="color:#b91c1c;">${{ number_format($entryDeductions, 2) }}</td>
                                <td style="font-weight:700; color:#15803d;">${{ number_format($entryNet, 2) }}</td>
                                <td><span class="badge {{ $ec }}">{{ ucfirst($es) }}</span></td>
                                <td>
                                    @if($entry->payslipEntry)
                                        <button class="btn-payslip">View Payslip</button>
                                    @else
                                        <span style="font-size:12px; color:var(--text-tertiary);">Not available</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="pay-empty" style="padding:32px 24px;">
                <div class="pay-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                <p class="pay-empty-title">No payroll history</p>
                <p class="pay-empty-sub">Your payroll records will appear here once processed.</p>
            </div>
        @endif
    </div>
</div>

{{-- ── Floating nav ──────────────────────────────────── --}}
<nav class="ios-nav">
    <a href="{{ route('employee.dashboard') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
    </a>
    <a href="{{ route('employee.profile') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0114 0"/></svg>
        Profile
    </a>
    <a href="{{ route('employee.attendance') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
    </a>
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="{{ route('employee.payroll') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
        Payroll
        <span class="ios-nav-active-dot"></span>
    </a>
</nav>

</div>{{-- /pay-root --}}