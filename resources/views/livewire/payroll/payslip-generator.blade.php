<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.psg-root {
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

.g-card { background:var(--glass-bg); backdrop-filter:var(--blur); -webkit-backdrop-filter:var(--blur); border:1px solid var(--glass-border); border-radius:var(--radius); box-shadow:var(--glass-shadow); position:relative; }
.g-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.9),transparent); pointer-events:none; border-radius:var(--radius) var(--radius) 0 0; }

.psg-header { padding:24px 30px; }
.psg-header h1 { font-size:24px; font-weight:700; color:var(--text-primary); letter-spacing:-0.4px; margin:0 0 3px; }
.psg-header p  { font-size:13.5px; font-weight:500; color:var(--text-secondary); margin:0; }

.psg-filters { padding:20px 26px; display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.psg-filter-field { display:flex; flex-direction:column; gap:6px; }
.psg-filter-field label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.psg-filter-field select { padding:10px 36px 10px 14px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--text-primary); outline:none; width:100%; box-sizing:border-box; -webkit-appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important; background-repeat:no-repeat !important; background-position:right 14px center !important; transition:border-color .15s,box-shadow .15s; }
.psg-filter-field select:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; }

.psg-filter-actions { padding:0 26px 20px; }
.btn-generate-all { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(37,99,235,0.3); transition:transform .15s,box-shadow .15s; }
.btn-generate-all:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(37,99,235,0.4); }
.btn-generate-all svg { width:15px; height:15px; stroke:#fff; }

.psg-card-head { padding:18px 24px 14px; border-bottom:1px solid rgba(0,0,0,0.055); }
.psg-card-title { font-size:15px; font-weight:700; color:var(--text-primary); margin:0; }

.psg-table-wrap { overflow-x:auto; }
table.psg-table { width:100%; border-collapse:collapse; }
.psg-table thead tr { border-bottom:1px solid rgba(0,0,0,0.07); }
.psg-table th { padding:11px 18px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); text-align:left; white-space:nowrap; }
.psg-table tbody tr { border-bottom:1px solid rgba(0,0,0,0.04); transition:background .12s; }
.psg-table tbody tr:last-child { border-bottom:none; }
.psg-table tbody tr:hover { background:rgba(255,255,255,0.55); }
.psg-table td { padding:13px 18px; font-size:13.5px; font-weight:500; color:var(--text-primary); white-space:nowrap; vertical-align:middle; }
.psg-emp-name { font-size:14px; font-weight:700; color:var(--text-primary); margin-bottom:2px; }
.psg-emp-num  { font-size:11.5px; font-weight:500; color:var(--text-tertiary); }

.badge { display:inline-flex; font-size:11px; font-weight:700; padding:4px 11px; border-radius:var(--radius-pill); }
.badge-green  { background:rgba(34,197,94,0.14);  color:#15803d; }
.badge-amber  { background:rgba(245,158,11,0.14); color:#b45309; }

.btn-action { font-size:12px; font-weight:600; border:none; border-radius:8px; padding:5px 12px; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .13s; margin-right:4px; }
.btn-action-blue   { color:#2563eb; background:rgba(37,99,235,0.09); }
.btn-action-blue:hover   { background:rgba(37,99,235,0.16); }
.btn-action-green  { color:#15803d; background:rgba(34,197,94,0.1); }
.btn-action-green:hover  { background:rgba(34,197,94,0.18); }
.btn-action-indigo { color:#4338ca; background:rgba(99,102,241,0.1); }
.btn-action-indigo:hover { background:rgba(99,102,241,0.18); }

/* Modal */
.psg-modal-bg { position:fixed; inset:0; z-index:60; background:rgba(0,0,0,0.28); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); display:flex; align-items:center; justify-content:center; padding:24px; }
.psg-modal { background:rgba(255,255,255,0.97); border:1px solid rgba(255,255,255,0.92); border-radius:var(--radius); box-shadow:0 32px 80px rgba(0,0,0,0.18); width:100%; max-width:700px; max-height:90vh; overflow-y:auto; }
.psg-modal-head { display:flex; justify-content:space-between; align-items:center; padding:20px 24px 16px; border-bottom:1px solid rgba(0,0,0,0.06); position:sticky; top:0; background:rgba(255,255,255,0.97); z-index:1; }
.psg-modal-title { font-size:18px; font-weight:700; color:var(--text-primary); margin:0; }
.psg-modal-close { width:30px; height:30px; border-radius:50%; background:rgba(0,0,0,0.06); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .15s; }
.psg-modal-close:hover { background:rgba(0,0,0,0.12); }
.psg-modal-close svg { width:14px; height:14px; stroke:var(--text-secondary); }
.psg-modal-body { padding:24px; }
.psg-modal-footer { padding:16px 24px 22px; border-top:1px solid rgba(0,0,0,0.06); display:flex; justify-content:flex-end; gap:10px; }

/* Payslip content */
.payslip-wrap { border:1px solid rgba(0,0,0,0.1); border-radius:var(--radius-sm); padding:28px; }
.payslip-company { text-align:center; margin-bottom:24px; padding-bottom:20px; border-bottom:2px solid rgba(0,0,0,0.08); }
.payslip-company h2 { font-size:22px; font-weight:700; color:var(--text-primary); margin:0 0 4px; letter-spacing:-0.5px; }
.payslip-company p  { font-size:13px; font-weight:500; color:var(--text-secondary); margin:0; }
.payslip-info { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
.payslip-info-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--text-tertiary); margin-bottom:8px; }
.payslip-info-row { font-size:13.5px; font-weight:500; color:var(--text-primary); margin-bottom:4px; }
.payslip-section { margin-bottom:20px; }
.payslip-section-title { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); margin-bottom:10px; }
table.payslip-table { width:100%; border-collapse:collapse; }
.payslip-table tr { border-bottom:1px solid rgba(0,0,0,0.05); }
.payslip-table tr:last-child { border-bottom:none; }
.payslip-table td { padding:7px 0; font-size:13.5px; font-weight:500; color:var(--text-primary); }
.payslip-table td:last-child { text-align:right; font-weight:600; }
.payslip-table tr.total td { font-size:14px; font-weight:700; border-top:1px solid rgba(0,0,0,0.12); padding-top:10px; }
.payslip-net { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; background:linear-gradient(135deg,rgba(13,148,136,0.08),rgba(8,145,178,0.06)); border:1px solid rgba(13,148,136,0.2); border-radius:var(--radius-sm); margin-top:20px; }
.payslip-net-label { font-size:16px; font-weight:700; color:var(--text-primary); }
.payslip-net-value { font-size:22px; font-weight:700; color:#0d9488; letter-spacing:-0.5px; }

.btn-modal-cancel { padding:10px 18px; background:rgba(0,0,0,0.06); color:var(--text-secondary); border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .15s; }
.btn-modal-cancel:hover { background:rgba(0,0,0,0.1); }
.btn-modal-download { padding:10px 20px; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(37,99,235,0.3); transition:transform .15s,box-shadow .15s; }
.btn-modal-download:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(37,99,235,0.4); }

@media (max-width:768px) { .psg-root { padding:18px 14px 100px; } .psg-filters { grid-template-columns:1fr; } .payslip-info { grid-template-columns:1fr; } }

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
<div class="psg-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="psg-header">
            <h1>Payslip Generator</h1>
            <p>Generate and manage employee payslips</p>
        </div>
    </div>

    {{-- ── Filters ───────────────────────────────────── --}}
    <div class="g-card anim-2">
        <div class="psg-filters">
            <div class="psg-filter-field">
                <label>Payroll Month</label>
                <select wire:model.live="selectedPayrollMonth">
                    <option value="">All Months</option>
                    @foreach(\App\Models\PayrollMonth::orderBy('start_date', 'desc')->get() as $month)
                        <option value="{{ $month->id }}">{{ $month->name }} ({{ \Carbon\Carbon::parse($month->start_date)->format('M Y') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="psg-filter-field">
                <label>Employee</label>
                <select wire:model.live="selectedEmployee">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="psg-filter-actions">
            <button wire:click="bulkGeneratePayslips" class="btn-generate-all">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Generate All Payslips
            </button>
        </div>
    </div>

    {{-- ── Table ─────────────────────────────────────── --}}
    <div class="g-card anim-3">
        <div class="psg-card-head">
            <p class="psg-card-title">Payroll Entries</p>
        </div>
        <div class="psg-table-wrap">
            <table class="psg-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Payroll Month</th>
                        <th>Gross Pay</th>
                        <th>Net Pay</th>
                        <th>Payslip Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrollEntries as $entry)
                        <tr>
                            <td>
                                <div class="psg-emp-name">{{ $entry->employee->first_name }} {{ $entry->employee->last_name }}</div>
                                <div class="psg-emp-num">{{ $entry->employee->employee_number }}</div>
                            </td>
                            <td>{{ $entry->payrollMonth->name }}</td>
                            <td>${{ number_format($entry->total_amount, 2) }}</td>
                            <td>
                                @if($entry->payslipEntry)
                                    ${{ number_format($entry->payslipEntry->net_pay, 2) }}
                                @else
                                    <span style="color:var(--text-tertiary);">—</span>
                                @endif
                            </td>
                            <td>
                                @if($entry->payslipEntry)
                                    <span class="badge badge-green">Generated</span>
                                @else
                                    <span class="badge badge-amber">Not Generated</span>
                                @endif
                            </td>
                            <td>
                                @if(!$entry->payslipEntry)
                                    <button wire:click="generatePayslip('{{ $entry->id }}')" class="btn-action btn-action-blue">Generate</button>
                                @else
                                    <button wire:click="previewPayslip('{{ $entry->id }}')" class="btn-action btn-action-green">Preview</button>
                                    <button wire:click="downloadPayslip('{{ $entry->id }}')" class="btn-action btn-action-indigo">Download</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Payslip Preview Modal ─────────────────────── --}}
    @if($payslipData)
        <div class="psg-modal-bg" wire:click="$set('payslipData', null)">
            <div class="psg-modal" wire:click.stop>
                <div class="psg-modal-head">
                    <h3 class="psg-modal-title">Payslip Preview</h3>
                    <button class="psg-modal-close" wire:click="$set('payslipData', null)">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="psg-modal-body">
                    <div class="payslip-wrap">

                        {{-- Company header --}}
                        <div class="payslip-company">
                            <h2>ZIBITECH</h2>
                            <p>Payslip for {{ $payslipData->payrollMonth->name }}</p>
                        </div>

                        {{-- Employee + Pay Period info --}}
                        <div class="payslip-info">
                            <div>
                                <div class="payslip-info-label">Employee Details</div>
                                <div class="payslip-info-row" style="font-weight:700;">{{ $payslipData->employee->first_name }} {{ $payslipData->employee->last_name }}</div>
                                <div class="payslip-info-row">No: {{ $payslipData->employee->employee_number }}</div>
                                <div class="payslip-info-row">{{ $payslipData->employee->department->name ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="payslip-info-label">Pay Period</div>
                                <div class="payslip-info-row">{{ \Carbon\Carbon::parse($payslipData->payrollMonth->start_date)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($payslipData->payrollMonth->end_date)->format('M d, Y') }}</div>
                                <div class="payslip-info-row">Pay Date: {{ now()->format('M d, Y') }}</div>
                            </div>
                        </div>

                        {{-- Earnings --}}
                        <div class="payslip-section">
                            <div class="payslip-section-title">Earnings</div>
                            <table class="payslip-table">
                                <tr><td>Basic Salary</td><td>${{ number_format($payslipData->work_days_pay, 2) }}</td></tr>
                                <tr><td>Overtime</td><td>${{ number_format($payslipData->overtime_total_amount, 2) }}</td></tr>
                                <tr class="total"><td>Gross Pay</td><td>${{ number_format($payslipData->total_amount, 2) }}</td></tr>
                            </table>
                        </div>

                        {{-- Deductions --}}
                        <div class="payslip-section">
                            <div class="payslip-section-title">Deductions</div>
                            <table class="payslip-table">
                                <tr><td>PAYE Tax</td><td>${{ number_format($payslipData->payslipEntry->paye, 2) }}</td></tr>
                                <tr><td>Pension</td><td>${{ number_format($payslipData->payslipEntry->pension, 2) }}</td></tr>
                                <tr><td>Maternity</td><td>${{ number_format($payslipData->payslipEntry->maternity, 2) }}</td></tr>
                                <tr><td>CBHI</td><td>${{ number_format($payslipData->payslipEntry->cbhi, 2) }}</td></tr>
                                <tr class="total">
                                    <td>Total Deductions</td>
                                    <td>${{ number_format($payslipData->payslipEntry->paye + $payslipData->payslipEntry->pension + $payslipData->payslipEntry->maternity + $payslipData->payslipEntry->cbhi, 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- Net Pay --}}
                        <div class="payslip-net">
                            <span class="payslip-net-label">Net Pay</span>
                            <span class="payslip-net-value">${{ number_format($payslipData->payslipEntry->net_pay, 2) }}</span>
                        </div>

                    </div>
                </div>
                <div class="psg-modal-footer">
                    <button class="btn-modal-cancel" wire:click="$set('payslipData', null)">Close</button>
                    <button class="btn-modal-download" wire:click="downloadPayslip('{{ $payslipData->id }}')">
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
</div>

<div class="floating-nav">
    <a href="{{ route('payroll.dashboard') }}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        <span class="nav-label">Dashboard</span>
    </a>
    
    <a href="{{ route('payroll.payslip-generator') }}" class="nav-item active">
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

</div>