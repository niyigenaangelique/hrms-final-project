<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.tax-root {
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
.tax-header { padding:24px 30px; }
.tax-header h1 { font-size:24px; font-weight:700; color:var(--text-primary); letter-spacing:-0.4px; margin:0 0 3px; }
.tax-header p  { font-size:13.5px; font-weight:500; color:var(--text-secondary); margin:0; }

/* Layout grids */
.tax-grid-3 { display:grid; grid-template-columns:1fr 2fr; gap:20px; align-items:start; }
.tax-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start; }
.tax-col-gap { display:flex; flex-direction:column; gap:20px; }

/* Card sections */
.tax-card-head { padding:20px 24px 16px; border-bottom:1px solid rgba(0,0,0,0.055); display:flex; justify-content:space-between; align-items:center; }
.tax-card-title { font-size:15px; font-weight:700; color:var(--text-primary); margin:0; }
.tax-card-body { padding:20px 24px 24px; display:flex; flex-direction:column; gap:14px; }

/* Form fields */
.tax-field { display:flex; flex-direction:column; gap:5px; }
.tax-field label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); }
.tax-field select,
.tax-field input[type="number"],
.tax-field input[type="text"] {
    padding:10px 14px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important;
    border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500;
    color:var(--text-primary); outline:none; width:100%; box-sizing:border-box;
    transition:border-color .15s,box-shadow .15s; -webkit-appearance:none;
}
.tax-field select {
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat:no-repeat !important; background-position:right 14px center !important; padding-right:36px !important;
}
.tax-field select:focus,
.tax-field input:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; background:rgba(255,255,255,0.96) !important; }

/* Currency input wrapper */
.tax-currency-wrap { position:relative; }
.tax-currency-wrap span { position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:13.5px; font-weight:600; color:var(--text-tertiary); pointer-events:none; }
.tax-currency-wrap input { padding-left:26px !important; }

/* Checkbox */
.tax-checkbox-row { display:flex; align-items:center; gap:10px; padding:10px 14px; background:rgba(255,255,255,0.5); border:1px solid rgba(255,255,255,0.8); border-radius:var(--radius-sm); cursor:pointer; }
.tax-checkbox-row input[type="checkbox"] { width:16px; height:16px; accent-color:#0d9488; cursor:pointer; flex-shrink:0; }
.tax-checkbox-row span { font-size:13px; font-weight:500; color:var(--text-primary); }

/* Info banners */
.banner-blue   { background:rgba(37,99,235,0.07);  border:1px solid rgba(37,99,235,0.18);  border-radius:var(--radius-sm); padding:12px 14px; font-size:13px; font-weight:500; color:#1e40af; }
.banner-amber  { background:rgba(245,158,11,0.07); border:1px solid rgba(245,158,11,0.2);  border-radius:var(--radius-sm); padding:12px 14px; font-size:13px; font-weight:500; color:#92400e; line-height:1.7; }
.banner-amber strong { font-weight:700; }

/* Tax rates grid */
.tax-rates-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }

/* Error */
.field-error { font-size:11px; font-weight:600; color:#dc2626; }

/* Buttons */
.btn-add-blue { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:rgba(37,99,235,0.1); color:#2563eb; border:none; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:12px; font-weight:600; cursor:pointer; transition:background .13s; }
.btn-add-blue:hover { background:rgba(37,99,235,0.18); }
.btn-add-green { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:rgba(34,197,94,0.1); color:#15803d; border:none; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:12px; font-weight:600; cursor:pointer; transition:background .13s; }
.btn-add-green:hover { background:rgba(34,197,94,0.18); }
.btn-remove { padding:5px 10px; background:rgba(239,68,68,0.08); color:#b91c1c; border:none; border-radius:6px; font-family:'DM Sans',sans-serif; font-size:12px; font-weight:600; cursor:pointer; transition:background .13s; flex-shrink:0; }
.btn-remove:hover { background:rgba(239,68,68,0.15); }
.btn-calc-all { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; background:linear-gradient(135deg,#7c3aed,#6d28d9); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; box-shadow:0 4px 14px rgba(124,58,237,0.3); transition:transform .15s,box-shadow .15s; }
.btn-calc-all:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }
.btn-calc-all svg { width:15px; height:15px; stroke:#fff; }

/* Custom deduction/benefit rows */
.custom-row { display:flex; gap:8px; align-items:center; }
.custom-row input[type="text"]   { flex:1; padding:9px 12px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500; color:var(--text-primary); outline:none; -webkit-appearance:none; }
.custom-row input[type="number"] { width:100px; padding:9px 12px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500; color:var(--text-primary); outline:none; -webkit-appearance:none; }
.custom-row input:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; }
.empty-text { font-size:13px; font-weight:500; color:var(--text-tertiary); padding:8px 0; }

/* Tax breakdown ledger */
.breakdown-row { display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid rgba(0,0,0,0.05); }
.breakdown-row:last-child { border-bottom:none; }
.breakdown-label { font-size:13.5px; font-weight:500; color:var(--text-secondary); }
.breakdown-value { font-size:13.5px; font-weight:600; color:var(--text-primary); }
.breakdown-value.deduct { color:#b91c1c; }
.breakdown-value.credit { color:#15803d; }
.breakdown-row.net { margin-top:6px; padding:14px 18px; background:linear-gradient(135deg,rgba(13,148,136,0.08),rgba(8,145,178,0.05)); border:1px solid rgba(13,148,136,0.2); border-radius:var(--radius-sm); }
.breakdown-row.net .breakdown-label { font-size:15px; font-weight:700; color:var(--text-primary); }
.breakdown-row.net .breakdown-value { font-size:18px; font-weight:700; color:#0d9488; }

/* Summary stat boxes */
.summary-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.summary-stat { text-align:center; padding:18px 14px; border-radius:var(--radius-sm); }
.summary-stat-value { font-size:26px; font-weight:700; letter-spacing:-1px; line-height:1; margin-bottom:5px; }
.summary-stat-label { font-size:12px; font-weight:500; color:var(--text-secondary); }
.s-blue   { background:rgba(37,99,235,0.07);  border:1px solid rgba(37,99,235,0.12);  } .s-blue   .summary-stat-value { color:#2563eb; }
.s-green  { background:rgba(34,197,94,0.07);  border:1px solid rgba(34,197,94,0.12);  } .s-green  .summary-stat-value { color:#15803d; }
.s-purple { background:rgba(124,58,237,0.07); border:1px solid rgba(124,58,237,0.12); } .s-purple .summary-stat-value { color:#7c3aed; }

/* Bulk table */
.bulk-table-wrap { overflow-x:auto; }
table.bulk-table { width:100%; border-collapse:collapse; }
.bulk-table thead tr { border-bottom:1px solid rgba(0,0,0,0.07); }
.bulk-table th { padding:11px 18px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-tertiary); text-align:left; white-space:nowrap; }
.bulk-table tbody tr { border-bottom:1px solid rgba(0,0,0,0.04); }
.bulk-table tbody tr:last-child { border-bottom:none; }
.bulk-table td { padding:13px 18px; font-size:13.5px; font-weight:500; color:var(--text-primary); white-space:nowrap; }
.bulk-empty { text-align:center; padding:36px 24px; font-size:13px; font-weight:500; color:var(--text-tertiary); }

@media (max-width:1024px) { .tax-grid-3 { grid-template-columns:1fr; } .tax-grid-2 { grid-template-columns:1fr; } }
@media (max-width:768px) { .tax-root { padding:18px 14px 100px; } .tax-rates-grid { grid-template-columns:1fr; } .summary-grid { grid-template-columns:1fr; } }

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
<div class="tax-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="tax-header">
            <h1>Employee Tax Calculator</h1>
            <p>Calculate individual employee taxes and net salary</p>
        </div>
    </div>

    {{-- ── Employee selection + Salary/Rates ───────── --}}
    <div class="tax-grid-3 anim-2">

        {{-- Employee selection --}}
        <div class="g-card">
            <div class="tax-card-head">
                <p class="tax-card-title">Employee Selection</p>
            </div>
            <div class="tax-card-body">
                <div class="tax-field">
                    <label>Select Employee</label>
                    <select wire:model.live="selectedEmployee">
                        <option value="">Manual Entry</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->employee_number }})</option>
                        @endforeach
                    </select>
                </div>

                <label class="tax-checkbox-row">
                    <input type="checkbox" wire:model.live="useRwandanTax"/>
                    <span>Use Rwandan Progressive Tax</span>
                </label>

                @if($selectedEmployee)
                    <div class="banner-blue">
                        Employee salary loaded: ${{ $this->formattedGrossSalary() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Salary + Rates --}}
        <div class="tax-col-gap">
            <div class="g-card">
                <div class="tax-card-head">
                    <p class="tax-card-title">Salary Information</p>
                </div>
                <div class="tax-card-body">
                    <div class="tax-field">
                        <label>Gross Salary</label>
                        <div class="tax-currency-wrap">
                            <span>$</span>
                            <input type="number" wire:model.live="grossSalary" placeholder="0.00" step="0.01" min="0"/>
                        </div>
                        @error('grossSalary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="g-card">
                <div class="tax-card-head">
                    <p class="tax-card-title">Tax Rates (%)</p>
                </div>
                <div class="tax-card-body">
                    <div class="tax-rates-grid">
                        @if(!$useRwandanTax)
                            <div class="tax-field">
                                <label>PAYE Rate</label>
                                <input type="number" wire:model.live="payeRate" step="0.1" min="0" max="100"/>
                            </div>
                        @endif
                        <div class="tax-field">
                            <label>Pension Rate</label>
                            <input type="number" wire:model.live="pensionRate" step="0.1" min="0" max="100"/>
                        </div>
                        <div class="tax-field">
                            <label>Maternity Rate</label>
                            <input type="number" wire:model.live="maternityRate" step="0.1" min="0" max="100"/>
                        </div>
                        <div class="tax-field">
                            <label>CBHI Rate</label>
                            <input type="number" wire:model.live="cbhiRate" step="0.1" min="0" max="100"/>
                        </div>
                    </div>
                    @if($useRwandanTax)
                        <div class="banner-amber">
                            <strong>Rwandan Progressive Tax Rates:</strong><br>
                            Up to 30,000: 0% &nbsp;·&nbsp; 30,001–100,000: 20%<br>
                            100,001–500,000: 30% &nbsp;·&nbsp; Above 500,000: 35%
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ── Custom Deductions + Benefits ─────────────── --}}
    <div class="tax-grid-2 anim-3">

        {{-- Custom Deductions --}}
        <div class="g-card">
            <div class="tax-card-head">
                <p class="tax-card-title">Custom Deductions</p>
                <button type="button" wire:click="addCustomDeduction" class="btn-add-blue">
                    + Add Deduction
                </button>
            </div>
            <div class="tax-card-body">
                @forelse($customDeductions as $index => $deduction)
                    <div class="custom-row">
                        <input type="text" wire:model.live="customDeductions.{{ $index }}.name" placeholder="Deduction name"/>
                        <input type="number" wire:model.live="customDeductions.{{ $index }}.amount" placeholder="Amount" step="0.01" min="0"/>
                        <button type="button" wire:click="removeCustomDeduction('{{ $index }}')" class="btn-remove">✕</button>
                    </div>
                @empty
                    <p class="empty-text">No custom deductions added</p>
                @endforelse
            </div>
        </div>

        {{-- Custom Benefits --}}
        <div class="g-card">
            <div class="tax-card-head">
                <p class="tax-card-title">Custom Benefits</p>
                <button type="button" wire:click="addCustomBenefit" class="btn-add-green">
                    + Add Benefit
                </button>
            </div>
            <div class="tax-card-body">
                @forelse($customBenefits as $index => $benefit)
                    <div class="custom-row">
                        <input type="text" wire:model.live="customBenefits.{{ $index }}.name" placeholder="Benefit name"/>
                        <input type="number" wire:model.live="customBenefits.{{ $index }}.amount" placeholder="Amount" step="0.01" min="0"/>
                        <button type="button" wire:click="removeCustomBenefit('{{ $index }}')" class="btn-remove">✕</button>
                    </div>
                @empty
                    <p class="empty-text">No custom benefits added</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── Results ────────────────────────────────────── --}}
    <div class="tax-grid-2 anim-4">

        {{-- Tax Breakdown --}}
        <div class="g-card">
            <div class="tax-card-head">
                <p class="tax-card-title">Tax Breakdown</p>
            </div>
            <div class="tax-card-body">
                <div class="breakdown-row">
                    <span class="breakdown-label">Gross Salary</span>
                    <span class="breakdown-value">${{ number_format(is_numeric($grossSalary) ? (float)$grossSalary : 0, 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">Pension Deduction</span>
                    <span class="breakdown-value deduct">-${{ number_format($pensionAmount, 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">Custom Deductions</span>
                    <span class="breakdown-value deduct">-${{ number_format(collect($customDeductions)->sum('amount'), 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">Taxable Income</span>
                    <span class="breakdown-value">${{ number_format(is_numeric($taxableIncome) ? (float)$taxableIncome : 0, 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">PAYE Tax</span>
                    <span class="breakdown-value deduct">-${{ number_format($payeAmount, 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">Maternity Contribution</span>
                    <span class="breakdown-value deduct">-${{ number_format($maternityAmount, 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">CBHI Contribution</span>
                    <span class="breakdown-value deduct">-${{ number_format(is_numeric($cbhiAmount) ? (float)$cbhiAmount : 0, 2) }}</span>
                </div>
                <div class="breakdown-row">
                    <span class="breakdown-label">Custom Benefits</span>
                    <span class="breakdown-value credit">+${{ number_format(collect($customBenefits)->sum('amount'), 2) }}</span>
                </div>
                <div class="breakdown-row net">
                    <span class="breakdown-label">Net Salary</span>
                    <span class="breakdown-value">${{ number_format(is_numeric($netSalary) ? (float)$netSalary : 0, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="g-card">
            <div class="tax-card-head">
                <p class="tax-card-title">Summary</p>
            </div>
            <div class="tax-card-body">
                <div class="summary-grid">
                    <div class="summary-stat s-blue">
                        <div class="summary-stat-value">{{ $grossSalary > 0 ? number_format(($totalDeductions / $grossSalary) * 100, 1) : '0.0' }}%</div>
                        <div class="summary-stat-label">Total Deduction Rate</div>
                    </div>
                    <div class="summary-stat s-green">
                        <div class="summary-stat-value">{{ $grossSalary > 0 ? number_format(($netSalary / $grossSalary) * 100, 1) : '0.0' }}%</div>
                        <div class="summary-stat-label">Take Home Rate</div>
                    </div>
                </div>
                @if($useRwandanTax)
                    <div class="summary-stat s-purple" style="margin-top:4px;">
                        <div class="summary-stat-value">${{ number_format(is_numeric($employerPensionContribution) ? (float)$employerPensionContribution : 0, 2) }}</div>
                        <div class="summary-stat-label">Employer Pension (7%)</div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Bulk Calculation ───────────────────────────── --}}
    <div class="g-card anim-5">
        <div class="tax-card-head">
            <p class="tax-card-title">Bulk Employee Calculation</p>
            <button wire:click="calculateForAllEmployees" class="btn-calc-all">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Calculate All Employees
            </button>
        </div>
        <div class="bulk-table-wrap">
            <table class="bulk-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Gross Salary</th>
                        <th>PAYE</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Effective Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="bulk-empty">
                            Click "Calculate All Employees" to see tax calculations for all employees
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

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
    
    <a href="{{ route('payroll.tax-calculator') }}" class="nav-item active">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
        <span class="nav-label">Tax Calc</span>
    </a>
</div>

</div>

</div>