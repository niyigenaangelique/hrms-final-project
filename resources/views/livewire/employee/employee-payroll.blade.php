<div class="pay-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.pay-root {
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
    padding: 24px 24px 100px;
    display: flex; flex-direction: column; gap: 18px;
}

/* ══ SHARED CARD ═════════════════════════════════════════ */
.pay-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.pay-card-hd { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.pay-card-hd-left { display: flex; align-items: center; gap: 9px; }
.pay-card-hd-icon { width: 30px; height: 30px; border-radius: 8px; background: var(--blue-lt); border: 1px solid var(--blue-brd); display: flex; align-items: center; justify-content: center; }
.pay-card-hd-icon svg { width: 14px; height: 14px; stroke: var(--blue); fill: none; stroke-width: 2; }
.pay-card-title { font-family:'Sora',sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.pay-card-sub   { font-size: 11.5px; color: var(--ink4); font-weight: 500; }
.pay-card-body  { padding: 20px; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.pay-hero { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.pay-hero-cover {
    height: 68px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.pay-hero-cover::before { content:''; position:absolute; top:-30px; right:60px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.06); }
.pay-hero-body { padding: 0 26px 0; display: flex; align-items: flex-end; justify-content: space-between; gap:16px; margin-top: -5px; }
.pay-hero-icon {
    width: 52px; height: 52px; border-radius: 15px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pay-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.pay-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.pay-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }
.pay-period-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    border-radius: 100px; padding: 6px 14px;
    font-size: 12px; font-weight: 700; color: var(--blue-2);
    margin-bottom: 18px; align-self: flex-end;
}
.pay-period-badge svg { width: 12px; height: 12px; stroke: var(--blue); fill: none; stroke-width: 2; }

/* ══ NET PAY BAND ════════════════════════════════════════ */
.pay-net-band {
    display: flex; align-items: center; justify-content: space-between;
    padding: 22px 26px;
    background: linear-gradient(105deg, var(--blue-3) 0%, var(--blue-2) 45%, var(--blue) 100%);
    gap: 20px; flex-wrap: wrap;
    border-top: 1px solid var(--border);
}
.pay-net-main { display: flex; flex-direction: column; }
.pay-net-label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.10em; color: rgba(255,255,255,0.65); margin-bottom: 4px; }
.pay-net-amount { font-family:'Sora',sans-serif; font-size: 36px; font-weight: 800; color: #fff; letter-spacing: -1px; line-height: 1; }
.pay-net-sub { font-size: 12.5px; color: rgba(255,255,255,0.65); margin-top: 4px; }

.pay-net-mini-stats { display: flex; gap: 24px; }
.pay-net-mini { display: flex; flex-direction: column; }
.pay-net-mini-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.55); margin-bottom: 3px; }
.pay-net-mini-val { font-family:'Sora',sans-serif; font-size: 18px; font-weight: 800; color: #fff; }

/* ══ STAT STRIP ══════════════════════════════════════════ */
.pay-stat-strip { display: grid; grid-template-columns: repeat(4,1fr); gap: 1px; background: var(--border); }
.pay-stat-cell { background: var(--white); padding: 14px 18px; display: flex; flex-direction: column; gap: 3px; }
.pay-stat-cell-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.pay-stat-cell-icon svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }
.pay-stat-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.pay-stat-val   { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: var(--ink2); }

/* ══ MAIN GRID ═══════════════════════════════════════════ */
.pay-main-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.pay-bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }

/* ══ INFO ROWS ═══════════════════════════════════════════ */
.pay-section-label {
    font-size: 10px; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.09em; color: var(--ink4); margin: 0 0 12px;
    display: flex; align-items: center; gap: 6px;
}
.pay-section-label::after { content:''; flex:1; height:1px; background: var(--border); }

.pay-info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; border-bottom: 1px solid var(--border);
}
.pay-info-row:last-child { border-bottom: none; }
.pay-info-label { font-size: 13px; color: var(--ink3); font-weight: 500; }
.pay-info-value { font-size: 13px; font-weight: 700; color: var(--ink2); text-align: right; }

/* ══ BREAKDOWN ROWS ══════════════════════════════════════ */
.pay-breakdown-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; border-bottom: 1px solid var(--border); font-size: 13px;
}
.pay-breakdown-item:last-child { border-bottom: none; }
.pay-breakdown-label { color: var(--ink3); font-weight: 500; }
.pay-breakdown-val   { font-weight: 700; color: var(--ink2); }
.pay-breakdown-val.plus  { color: #087A42; }
.pay-breakdown-val.minus { color: #991B1B; }

.pay-breakdown-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 0 0; margin-top: 6px;
    border-top: 2px solid var(--border);
    font-size: 14px; font-weight: 800; color: var(--ink);
}

/* ══ LEAVE BALANCE BARS ══════════════════════════════════ */
.pay-leave-item {
    display: flex; align-items: center; gap: 14px;
    padding: 11px 0; border-bottom: 1px solid var(--border);
}
.pay-leave-item:last-child { border-bottom: none; }
.pay-leave-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pay-leave-icon svg { width: 15px; height: 15px; stroke: var(--blue); fill: none; stroke-width: 2; }
.pay-leave-info { flex: 1; min-width: 0; }
.pay-leave-name { font-size: 13px; font-weight: 700; color: var(--ink2); margin-bottom: 3px; }
.pay-leave-year { font-size: 11px; color: var(--ink4); font-weight: 500; }
.pay-leave-bar-wrap { height: 5px; border-radius: 100px; background: var(--bg); overflow: hidden; margin-top: 5px; }
.pay-leave-bar { height: 100%; border-radius: 100px; background: linear-gradient(90deg, var(--blue-2), var(--blue)); }
.pay-leave-days { text-align: right; flex-shrink: 0; }
.pay-leave-rem   { font-family:'Sora',sans-serif; font-size: 18px; font-weight: 800; color: var(--blue-2); line-height: 1; }
.pay-leave-total { font-size: 10.5px; color: var(--ink4); font-weight: 500; margin-top: 1px; }

/* ══ TABLE ═══════════════════════════════════════════════ */
.pay-table-wrap { overflow-x: auto; }
table.pay-table { width: 100%; border-collapse: collapse; }
.pay-table thead tr { border-bottom: 1px solid var(--border); }
.pay-table th { padding: 10px 14px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.pay-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s; }
.pay-table tbody tr:last-child { border-bottom: none; }
.pay-table tbody tr:hover { background: #F8FAFF; }
.pay-table td { padding: 12px 14px; font-size: 13px; font-weight: 500; color: var(--ink2); white-space: nowrap; }
.pay-table td.bold { font-weight: 700; color: var(--ink); }
.pay-table td.muted { color: var(--ink4); font-size: 12px; }
.pay-table td.pos { color: #087A42; font-weight: 700; }
.pay-table td.neg { color: #991B1B; font-weight: 700; }

/* Badges */
.pay-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700; }
.pay-badge svg { width: 8px; height: 8px; stroke: currentColor; fill: currentColor; }
.badge-green  { background: var(--green-lt); color: #087A42; }
.badge-amber  { background: var(--amber-lt); color: #92400E; }
.badge-gray   { background: var(--bg); color: var(--ink3); border: 1px solid var(--border); }
.badge-active { background: var(--green-lt); color: #087A42; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }
.badge-inactive { background: var(--red-lt); color: #991B1B; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }

/* View payslip btn */
.btn-payslip {
    font-size: 12px; font-weight: 700; color: var(--blue);
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    border-radius: 8px; padding: 5px 12px; cursor: pointer;
    font-family: 'DM Sans', sans-serif; transition: background 0.15s;
}
.btn-payslip:hover { background: var(--blue-mid); }

/* Empty */
.pay-empty { text-align: center; padding: 40px 24px; }
.pay-empty svg { width: 36px; height: 36px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 12px; display: block; opacity: 0.4; }
.pay-empty-title { font-size: 15px; font-weight: 700; color: var(--ink3); margin-bottom: 4px; }
.pay-empty-sub   { font-size: 13px; color: var(--ink4); font-weight: 500; }

/* ══ FLOATING NAV ════════════════════════════════════════ */
.ios-nav {
    position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 200;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.82); backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.11); border-radius: 28px; padding: 7px 10px;
    box-shadow: 0 20px 56px rgba(15,22,41,0.24);
}
.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 7px 15px; border-radius: 18px; text-decoration: none;
    font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.40);
    letter-spacing: 0.04em; min-width: 56px; position: relative;
    transition: background 0.18s, color 0.18s, transform 0.14s;
}
.ios-nav-item svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.8; }
.ios-nav-item:hover { color: rgba(255,255,255,0.82); background: rgba(255,255,255,0.07); transform: translateY(-1px); }
.ios-nav-item.active { color: #fff; background: rgba(59,111,232,0.25); }
.ios-nav-item.active svg { stroke: #93C5FD; }
.ios-nav-active-dot { position: absolute; bottom: 3px; width: 4px; height: 4px; border-radius: 50%; background: #60A5FA; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .pay-main-grid   { grid-template-columns: 1fr; }
    .pay-bottom-grid { grid-template-columns: 1fr; }
    .pay-stat-strip  { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 640px) {
    .pay-root { padding: 14px 12px 90px; }
    .pay-net-band { padding: 16px 18px; }
    .pay-net-amount { font-size: 28px; }
    .pay-net-mini-stats { gap: 16px; }
    .ios-nav-item { padding: 7px 10px; min-width: 46px; font-size: 9px; }
}
</style>

{{-- ══ PAGE HERO + NET PAY BAND ══════════════════════════ --}}
<div class="pay-hero">
    <div class="pay-hero-cover"></div>
    <div class="pay-hero-body">
        <div style="display:flex;align-items:flex-end;gap:13px;">
            <div class="pay-hero-icon">
                <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <div>
                <div class="pay-hero-title">My Payroll</div>
                <div class="pay-hero-sub">Salary details, deductions &amp; payslip history</div>
            </div>
        </div>
        @if($currentPayrollEntry)
            <div class="pay-period-badge">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $currentPayrollEntry->period_name }}
            </div>
        @endif
    </div>

    @if($currentPayrollEntry)
        {{-- Net pay gradient band --}}
        <div class="pay-net-band">
            <div class="pay-net-main">
                <div class="pay-net-label">Net Pay This Period</div>
                <div class="pay-net-amount">RWF {{ number_format($netPay, 0) }}</div>
                <div class="pay-net-sub">{{ $currentPayrollEntry->period_name }}</div>
            </div>
            <div class="pay-net-mini-stats">
                <div class="pay-net-mini">
                    <div class="pay-net-mini-label">Gross (RWF)</div>
                    <div class="pay-net-mini-val">{{ number_format($currentPayrollEntry->gross_pay, 0) }}</div>
                </div>
                <div class="pay-net-mini">
                    <div class="pay-net-mini-label">Deductions</div>
                    <div class="pay-net-mini-val" style="color:rgba(255,200,200,0.9);">-{{ number_format($totalDeductions, 0) }}</div>
                </div>
                <div class="pay-net-mini">
                    <div class="pay-net-mini-label">Work Days</div>
                    <div class="pay-net-mini-val">{{ $currentPayrollEntry->present_days }}</div>
                </div>
                <div class="pay-net-mini">
                    <div class="pay-net-mini-label">Late Deduct.</div>
                    <div class="pay-net-mini-val" style="color:rgba(255,200,200,0.7);">-{{ number_format($currentPayrollEntry->late_deduction, 0) }}</div>
                </div>
            </div>
        </div>

        {{-- Stat strip --}}
        <div class="pay-stat-strip">
            <div class="pay-stat-cell">
                <div class="pay-stat-cell-icon" style="background:var(--blue-lt);">
                    <svg viewBox="0 0 24 24" style="stroke:var(--blue)"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
                <div class="pay-stat-label">Basic Salary</div>
                <div class="pay-stat-val">{{ number_format($currentPayrollEntry->basic_salary, 0) }}</div>
            </div>
            <div class="pay-stat-cell">
                <div class="pay-stat-cell-icon" style="background:var(--green-lt);">
                    <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                </div>
                <div class="pay-stat-label">Total Allowances</div>
                <div class="pay-stat-val">{{ number_format($totalBenefits, 0) }}</div>
            </div>
            <div class="pay-stat-cell">
                <div class="pay-stat-cell-icon" style="background:var(--amber-lt);">
                    <svg viewBox="0 0 24 24" style="stroke:var(--amber)"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                </div>
                <div class="pay-stat-label">Overtime Pay</div>
                <div class="pay-stat-val">{{ number_format($currentPayrollEntry->overtime_pay, 0) }}</div>
            </div>
            <div class="pay-stat-cell">
                <div class="pay-stat-cell-icon" style="background:var(--red-lt);">
                    <svg viewBox="0 0 24 24" style="stroke:var(--red)"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                </div>
                <div class="pay-stat-label">Net Receive</div>
                <div class="pay-stat-val" style="color:var(--blue-2);">{{ number_format($netPay, 0) }}</div>
            </div>
        </div>
    @endif
</div>

@if($currentPayrollEntry)

{{-- ══ EMPLOYEE INFO + BREAKDOWNS ═════════════════════════ --}}
<div class="pay-main-grid">

    {{-- Employee info --}}
    <div class="pay-card">
        <div class="pay-card-hd">
            <div class="pay-card-hd-left">
                <div class="pay-card-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <div class="pay-card-title">Employee Details</div>
                    <div class="pay-card-sub">Personal &amp; employment info</div>
                </div>
            </div>
        </div>
        <div class="pay-card-body">
            <div class="pay-section-label">Personal</div>
            <div class="pay-info-row"><span class="pay-info-label">Full Name</span><span class="pay-info-value">{{ $employee->full_name }}</span></div>
            <div class="pay-info-row"><span class="pay-info-label">Employee ID</span><span class="pay-info-value">{{ $employee->code }}</span></div>
            <div class="pay-info-row"><span class="pay-info-label">Nationality</span><span class="pay-info-value">{{ $currentPayrollEntry->nationality }}</span></div>
            <div class="pay-info-row"><span class="pay-info-label">Bank Name</span><span class="pay-info-value">{{ $currentPayrollEntry->bank_name ?? '—' }}</span></div>
            <div class="pay-info-row"><span class="pay-info-label">Account No.</span><span class="pay-info-value">{{ $currentPayrollEntry->bank_account ?? '—' }}</span></div>

            <div class="pay-section-label" style="margin-top:16px;">Position</div>
            <div class="pay-info-row"><span class="pay-info-label">Department</span><span class="pay-info-value">{{ $currentPayrollEntry->department ?? '—' }}</span></div>
            <div class="pay-info-row"><span class="pay-info-label">Position</span><span class="pay-info-value">{{ $currentPayrollEntry->position ?? '—' }}</span></div>
            <div class="pay-info-row"><span class="pay-info-label">Days Present</span><span class="pay-info-value">{{ $currentPayrollEntry->present_days }} / {{ $currentPayrollEntry->working_days }}</span></div>
            <div class="pay-info-row">
                <span class="pay-info-label">Payroll Status</span>
                <span class="badge-active">{{ ucfirst($currentPayrollEntry->status) }}</span>
            </div>
        </div>
    </div>

    {{-- Earnings + Deductions --}}
    <div style="display:flex;flex-direction:column;gap:18px;">

        {{-- Earnings --}}
        <div class="pay-card">
            <div class="pay-card-hd">
                <div class="pay-card-hd-left">
                    <div class="pay-card-hd-icon" style="background:var(--green-lt);border-color:rgba(18,183,106,0.22);">
                        <svg viewBox="0 0 24 24" style="stroke:var(--green)"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    </div>
                    <div>
                        <div class="pay-card-title">Earnings Breakdown</div>
                        <div class="pay-card-sub">Gross income details</div>
                    </div>
                </div>
            </div>
            <div class="pay-card-body">
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Basic Salary</span>
                    <span class="pay-breakdown-val plus">{{ number_format($currentPayrollEntry->basic_salary, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">House Allowance</span>
                    <span class="pay-breakdown-val plus">{{ number_format($currentPayrollEntry->house_allowance, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Transport Allowance</span>
                    <span class="pay-breakdown-val plus">{{ number_format($currentPayrollEntry->transport_allowance, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Other Allowances</span>
                    <span class="pay-breakdown-val plus">{{ number_format($currentPayrollEntry->other_allowances, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Overtime Pay</span>
                    <span class="pay-breakdown-val plus">{{ number_format($currentPayrollEntry->overtime_pay, 0) }}</span>
                </div>
                <div class="pay-breakdown-total">
                    <span>Total Gross Income</span>
                    <span>{{ number_format($currentPayrollEntry->gross_pay, 0) }}</span>
                </div>
            </div>
        </div>

        {{-- Deductions --}}
        <div class="pay-card">
            <div class="pay-card-hd">
                <div class="pay-card-hd-left">
                    <div class="pay-card-hd-icon" style="background:var(--red-lt);border-color:rgba(239,68,68,0.22);">
                        <svg viewBox="0 0 24 24" style="stroke:var(--red)"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                    </div>
                    <div>
                        <div class="pay-card-title">Statutory Deductions</div>
                        <div class="pay-card-sub">Rwanda tax compliance</div>
                    </div>
                </div>
            </div>
            <div class="pay-card-body">
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">PAYE Tax</span>
                    <span class="pay-breakdown-val minus">-{{ number_format($currentPayrollEntry->paye_tax, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">RSSB (Employee 3%)</span>
                    <span class="pay-breakdown-val minus">-{{ number_format($currentPayrollEntry->rssb_employee, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">Maternity Fund</span>
                    <span class="pay-breakdown-val minus">-{{ number_format($currentPayrollEntry->maternity_fund, 0) }}</span>
                </div>
                <div class="pay-breakdown-item">
                    <span class="pay-breakdown-label">CBHI (4.5%)</span>
                    <span class="pay-breakdown-val minus">-{{ number_format($currentPayrollEntry->cbhi, 0) }}</span>
                </div>
                @if($currentPayrollEntry->salary_advance > 0)
                    <div class="pay-breakdown-item">
                        <span class="pay-breakdown-label">Salary Advance</span>
                        <span class="pay-breakdown-val minus">-{{ number_format($currentPayrollEntry->salary_advance, 0) }}</span>
                    </div>
                @endif
                <div class="pay-breakdown-total">
                    <span>Total Deducted</span>
                    <span style="color:#991B1B;">-{{ number_format($totalDeductions, 0) }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ══ ATTENDANCE + LEAVE BALANCES ════════════════════════ --}}
<div class="pay-bottom-grid">

    {{-- Recent attendance --}}
    <div class="pay-card">
        <div class="pay-card-hd">
            <div class="pay-card-hd-left">
                <div class="pay-card-hd-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                </div>
                <div>
                    <div class="pay-card-title">Recent Attendance</div>
                    <div class="pay-card-sub">Last 30 days</div>
                </div>
            </div>
        </div>
        @if($recentAttendances->count() > 0)
            <div class="pay-table-wrap">
                <table class="pay-table">
                    <thead><tr><th>Date</th><th>In</th><th>Out</th><th>Hours</th></tr></thead>
                    <tbody>
                        @foreach($recentAttendances as $att)
                            @php
                                $hrs = $att->check_in && $att->check_out
                                    ? \Carbon\Carbon::parse($att->check_in)->diffInHours(\Carbon\Carbon::parse($att->check_out)).'h'
                                    : '—';
                            @endphp
                            <tr>
                                <td class="bold">{{ $att->date->format('M d') }}</td>
                                <td class="muted">{{ $att->check_in ?? '—' }}</td>
                                <td class="muted">{{ $att->check_out ?? '—' }}</td>
                                <td style="font-weight:700;color:var(--blue-2);">{{ $hrs }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="pay-card-body">
                <div style="font-size:13px;color:var(--ink4);font-weight:500;">No attendance records found.</div>
            </div>
        @endif
    </div>

    {{-- Leave balances --}}
    <div class="pay-card">
        <div class="pay-card-hd">
            <div class="pay-card-hd-left">
                <div class="pay-card-hd-icon" style="background:var(--green-lt);border-color:rgba(18,183,106,0.22);">
                    <svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <div class="pay-card-title">Leave Balances</div>
                    <div class="pay-card-sub">Remaining days by type</div>
                </div>
            </div>
        </div>
        <div class="pay-card-body">
            @if($leaveBalances->count() > 0)
                @foreach($leaveBalances as $lb)
                    @php $pct = $lb->total_days > 0 ? min(100, round(($lb->remaining_days / $lb->total_days) * 100)) : 0; @endphp
                    <div class="pay-leave-item">
                        <div class="pay-leave-icon">
                            <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        </div>
                        <div class="pay-leave-info">
                            <div class="pay-leave-name">{{ ucfirst($lb->leave_type) }}</div>
                            <div class="pay-leave-year">{{ $lb->year }}</div>
                            <div class="pay-leave-bar-wrap">
                                <div class="pay-leave-bar" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                        <div class="pay-leave-days">
                            <div class="pay-leave-rem">{{ $lb->remaining_days }}</div>
                            <div class="pay-leave-total">of {{ $lb->total_days }}d</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="font-size:13px;color:var(--ink4);font-weight:500;">No leave balance data available.</div>
            @endif
        </div>
    </div>
</div>

@else
{{-- No payroll --}}
<div class="pay-card">
    <div class="pay-card-body">
        <div class="pay-empty">
            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            <div class="pay-empty-title">No payroll data for this period</div>
            <div class="pay-empty-sub">Payroll information will appear once processed by HR.</div>
        </div>
    </div>
</div>
@endif

{{-- ══ PAYROLL HISTORY ══════════════════════════════════════ --}}
<div class="pay-card">
    <div class="pay-card-hd">
        <div class="pay-card-hd-left">
            <div class="pay-card-hd-icon">
                <svg viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <div class="pay-card-title">Payroll History</div>
                <div class="pay-card-sub">{{ $payrollEntries->count() }} period(s) on record</div>
            </div>
        </div>
    </div>
    @if($payrollEntries->count() > 0)
        <div class="pay-table-wrap">
            <table class="pay-table">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Gross Pay</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrollEntries as $entry)
                        <tr>
                            <td class="bold">{{ $entry->period_name }}</td>
                            <td class="muted">{{ number_format($entry->gross_pay, 0) }}</td>
                            <td class="neg">-{{ number_format($entry->total_deductions, 0) }}</td>
                            <td class="pos">{{ number_format($entry->net_pay, 0) }}</td>
                            <td>
                                <span class="pay-badge badge-active">
                                    <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                                    {{ ucfirst($entry->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex; gap:8px;">
                                    <button class="btn-payslip" wire:click="selectEntry('{{ $entry->id }}')">View Results</button>
                                    @if($entry->payslipEntry)
                                        <a href="{{ route('employee.payroll.download', ['entryId' => $entry->payslipEntry->id]) }}" target="_blank" class="btn-payslip" style="color:var(--red); border-color:var(--red-lt); background:var(--red-lt);">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="pay-card-body">
            <div class="pay-empty" style="padding:32px 0;">
                <svg viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <div class="pay-empty-title">No payroll history</div>
                <div class="pay-empty-sub">Your records will appear here once payroll is processed.</div>
            </div>
        </div>
    @endif
</div>

{{-- ══ FLOATING NAV ════════════════════════════════════════ --}}
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
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        Payroll
        <span class="ios-nav-active-dot"></span>
    </a>
</nav>

</div>