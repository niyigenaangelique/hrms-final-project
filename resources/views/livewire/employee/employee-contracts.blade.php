<div class="ctr-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.ctr-root {
    --glass-bg:       rgba(255,255,255,0.45);
    --glass-strong:   rgba(255,255,255,0.65);
    --glass-border:   rgba(255,255,255,0.65);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(24px) saturate(1.8);
    --radius:         20px;
    --radius-sm:      12px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.72);
    --text-tertiary:  rgba(15,15,25,0.50);
    --teal:           #0d9488;
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
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

/* ── Page header ──────────────────────────────────────── */
.ctr-header {
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.ctr-title {
    font-size: 28px; font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.4px; margin: 0 0 4px;
}

.ctr-subtitle {
    font-size: 14px; font-weight: 500;
    color: var(--text-secondary); margin: 0;
}

/* ── Table wrapper ────────────────────────────────────── */
.ctr-table-wrap { padding: 0 24px 24px; overflow-x: auto; }

table.ctr-table {
    width: 100%;
    border-collapse: collapse;
}

.ctr-table thead tr {
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.ctr-table th {
    padding: 12px 16px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary);
    text-align: left;
    white-space: nowrap;
}

.ctr-table tbody tr {
    border-bottom: 1px solid rgba(0,0,0,0.04);
    transition: background 0.15s;
}

.ctr-table tbody tr:last-child { border-bottom: none; }

.ctr-table tbody tr:hover {
    background: rgba(255,255,255,0.5);
}

.ctr-table td {
    padding: 14px 16px;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary);
    white-space: nowrap;
}

.ctr-table td.muted {
    color: var(--text-secondary);
    font-weight: 400;
}

.ctr-salary {
    font-size: 14px; font-weight: 700;
    color: #15803d;
}

/* ── Status badges ────────────────────────────────────── */
.badge {
    display: inline-flex;
    font-size: 12px; font-weight: 700;
    padding: 4px 12px; border-radius: var(--radius-pill);
}

.badge-green   { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-red     { background: rgba(239,68,68,0.14);  color: #b91c1c; }
.badge-amber   { background: rgba(245,158,11,0.14); color: #b45309; }
.badge-gray    { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }
.badge-blue    { background: rgba(37,99,235,0.12);  color: #1d4ed8; }

/* ── Action buttons ───────────────────────────────────── */
.ctr-btn-view {
    font-size: 13px; font-weight: 600;
    color: #2563eb; background: rgba(37,99,235,0.08);
    border: none; border-radius: 8px;
    padding: 6px 14px; cursor: pointer;
    transition: background 0.15s;
    font-family: 'DM Sans', sans-serif;
}

.ctr-btn-view:hover { background: rgba(37,99,235,0.15); }

.ctr-btn-dl {
    font-size: 13px; font-weight: 600;
    color: #0d9488; background: rgba(13,148,136,0.08);
    border: none; border-radius: 8px;
    padding: 6px 14px; cursor: pointer;
    transition: background 0.15s;
    font-family: 'DM Sans', sans-serif;
}

.ctr-btn-dl:hover { background: rgba(13,148,136,0.15); }

/* ── Empty state ──────────────────────────────────────── */
.ctr-empty {
    text-align: center;
    padding: 64px 24px;
}

.ctr-empty-icon {
    width: 56px; height: 56px;
    margin: 0 auto 16px;
    background: rgba(0,0,0,0.05);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
}

.ctr-empty-icon svg { width: 28px; height: 28px; stroke: var(--text-tertiary); }
.ctr-empty-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0 0 6px; }
.ctr-empty-sub   { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Modal backdrop ───────────────────────────────────── */
.ctr-modal-bg {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.30);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 50;
    display: flex; align-items: center; justify-content: center;
    padding: 24px;
}

.ctr-modal {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(32px) saturate(1.8);
    -webkit-backdrop-filter: blur(32px) saturate(1.8);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius);
    box-shadow: 0 32px 80px rgba(0,0,0,0.18);
    width: 100%; max-width: 820px;
    max-height: 90vh; overflow-y: auto;
    position: relative;
}

.ctr-modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 24px 28px 0;
    position: sticky; top: 0;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(20px);
    z-index: 1;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.ctr-modal-title {
    font-size: 20px; font-weight: 700;
    color: var(--text-primary); margin: 0;
}

.ctr-modal-close {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: rgba(0,0,0,0.06);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
    flex-shrink: 0;
}

.ctr-modal-close:hover { background: rgba(0,0,0,0.12); }
.ctr-modal-close svg { width: 16px; height: 16px; stroke: var(--text-secondary); }

.ctr-modal-body {
    padding: 24px 28px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap: 20px;
}

/* ── Modal section ────────────────────────────────────── */
.ctr-msection {
    background: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.85);
    border-radius: var(--radius-sm);
    padding: 18px 20px;
}

.ctr-msection-title {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-tertiary);
    margin: 0 0 14px;
}

.ctr-mfield { margin-bottom: 12px; }
.ctr-mfield:last-child { margin-bottom: 0; }

.ctr-mfield label {
    display: block;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.06em;
    color: var(--text-tertiary);
    margin-bottom: 3px;
}

.ctr-mfield p {
    font-size: 14px; font-weight: 600;
    color: var(--text-primary); margin: 0;
}

/* ── Modal footer ─────────────────────────────────────── */
.ctr-modal-footer {
    padding: 16px 28px 24px;
    display: flex; justify-content: flex-end; gap: 10px;
    border-top: 1px solid rgba(0,0,0,0.06);
}

.btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(13,148,136,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
}

.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(13,148,136,0.4); }
.btn-primary svg   { width: 15px; height: 15px; stroke: #fff; }

.btn-cancel {
    padding: 10px 20px;
    background: rgba(0,0,0,0.06);
    color: var(--text-secondary);
    border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
}

.btn-cancel:hover { background: rgba(0,0,0,0.1); }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%;
    transform: translateX(-50%);
    z-index: 100;
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
    font-size: 10px; font-weight: 500;
    color: rgba(255,255,255,0.45);
    letter-spacing: 0.03em; min-width: 64px; position: relative;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.ios-nav-item svg { width: 20px; height: 20px; stroke: currentColor; transition: transform 0.2s; }
.ios-nav-item:hover { color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.08); transform: translateY(-1px); }
.ios-nav-item:hover svg { transform: scale(1.1); }
.ios-nav-item.active { color: #fff; background: rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke: #60a5fa; }

.ios-nav-active-dot {
    position: absolute; bottom: 4px;
    width: 4px; height: 4px; border-radius: 50%;
    background: #60a5fa;
}

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 768px) {
    .ctr-root { padding: 20px 16px 110px; }
    .ctr-modal-body { grid-template-columns: 1fr; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header ──────────────────────────────────── --}}
<div class="g-card">
    <div class="ctr-header">
        <div>
            <h1 class="ctr-title">My Contracts</h1>
            <p class="ctr-subtitle">View and manage your employment contracts</p>
        </div>
    </div>
</div>

{{-- ── Contracts table ───────────────────────────────── --}}
<div class="g-card">
    @if($contracts && $contracts->count() > 0)
        <div class="ctr-table-wrap">
            <table class="ctr-table">
                <thead>
                    <tr>
                        <th>Contract Code</th>
                        <th>Position</th>
                        <th>Current Salary</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $contract)
                        @php
                            $s = $contract->status->value;
                            $badgeClass = match($s) {
                                'active'     => 'badge-green',
                                'expired'    => 'badge-red',
                                'pending'    => 'badge-amber',
                                'terminated' => 'badge-gray',
                                default      => 'badge-blue',
                            };
                        @endphp
                        <tr>
                            <td>{{ $contract->code }}</td>
                            <td class="muted">{{ $contract->position->name ?? 'Not specified' }}</td>
                            <td>
                                @if($employee && $employee->basic_salary)
                                    <span class="ctr-salary">
                                        {{ number_format($employee->basic_salary, 2) }} {{ $employee->salary_currency ?? 'RWF' }}
                                    </span>
                                @else
                                    <span style="color:var(--text-tertiary); font-weight:500;">Not set</span>
                                @endif
                            </td>
                            <td class="muted">
                                {{ $contract->start_date->format('M d, Y') }} — {{ $contract->end_date->format('M d, Y') }}
                            </td>
                            <td>
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($s) }}</span>
                            </td>
                            <td>
                                <div style="display:flex; gap:8px;">
                                    <button class="ctr-btn-view" wire:click="viewContract('{{ $contract->id }}')">View</button>
                                    <button class="ctr-btn-dl" wire:click="downloadContract('{{ $contract->id }}')">Download</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="ctr-empty">
            <div class="ctr-empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="ctr-empty-title">No contracts found</p>
            <p class="ctr-empty-sub">You don't have any contracts assigned yet.</p>
        </div>
    @endif
</div>

{{-- ── Contract details modal ────────────────────────── --}}
@if($selectedContract)
    @php
        $ss = $selectedContract->status->value;
        $sClass = match($ss) { 'active' => 'badge-green', 'expired' => 'badge-red', 'pending' => 'badge-amber', 'terminated' => 'badge-gray', default => 'badge-blue' };
        $as = $selectedContract->approval_status->value ?? '';
        $aClass = match($as) { 'approved' => 'badge-green', 'rejected' => 'badge-red', 'pending' => 'badge-amber', default => 'badge-gray' };
    @endphp
    <div class="ctr-modal-bg">
        <div class="ctr-modal">

            <div class="ctr-modal-header">
                <h3 class="ctr-modal-title">Contract Details</h3>
                <button class="ctr-modal-close" wire:click="closeModal">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="ctr-modal-body">

                {{-- Contract Information --}}
                <div class="ctr-msection">
                    <div class="ctr-msection-title">Contract Information</div>
                    <div class="ctr-mfield"><label>Contract Code</label><p>{{ $selectedContract->code }}</p></div>
                    <div class="ctr-mfield"><label>Position</label><p>{{ $selectedContract->position->name ?? 'Not specified' }}</p></div>
                    <div class="ctr-mfield"><label>Project</label><p>Not assigned</p></div>
                    <div class="ctr-mfield"><label>Employee Category</label><p>{{ ucfirst($selectedContract->employee_category->value ?? 'Not specified') }}</p></div>
                </div>

                {{-- Employment Details --}}
                <div class="ctr-msection">
                    <div class="ctr-msection-title">Employment Details</div>
                    <div class="ctr-mfield"><label>Start Date</label><p>{{ $selectedContract->start_date->format('M d, Y') }}</p></div>
                    <div class="ctr-mfield"><label>End Date</label><p>{{ $selectedContract->end_date->format('M d, Y') }}</p></div>
                    <div class="ctr-mfield"><label>Daily Working Hours</label><p>{{ $selectedContract->daily_working_hours }} hours</p></div>
                    <div class="ctr-mfield">
                        <label>Status</label>
                        <span class="badge {{ $sClass }}">{{ ucfirst($ss) }}</span>
                    </div>
                </div>

                {{-- Compensation --}}
                <div class="ctr-msection">
                    <div class="ctr-msection-title">Compensation</div>
                    <div class="ctr-mfield"><label>Contract Remuneration</label><p>{{ number_format($selectedContract->remuneration, 2) }}</p></div>
                    <div class="ctr-mfield"><label>Remuneration Type</label><p>{{ ucfirst($selectedContract->remuneration_type->value ?? 'Not specified') }}</p></div>
                </div>

                {{-- Current Salary Details --}}
                @if($employee && ($employee->basic_salary || $employee->daily_rate || $employee->hourly_rate))
                    <div class="ctr-msection">
                        <div class="ctr-msection-title">Current Salary Details</div>
                        @if($employee->basic_salary)
                            <div class="ctr-mfield"><label>Basic Salary</label><p style="color:#15803d;">{{ number_format($employee->basic_salary, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</p></div>
                        @endif
                        @if($employee->daily_rate)
                            <div class="ctr-mfield"><label>Daily Rate</label><p>{{ number_format($employee->daily_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</p></div>
                        @endif
                        @if($employee->hourly_rate)
                            <div class="ctr-mfield"><label>Hourly Rate</label><p>{{ number_format($employee->hourly_rate, 2) }} {{ $employee->salary_currency ?? 'RWF' }}</p></div>
                        @endif
                        @if($employee->salary_effective_date)
                            <div class="ctr-mfield"><label>Salary Effective Date</label><p>{{ $employee->salary_effective_date->format('M d, Y') }}</p></div>
                        @endif
                        @if($employee->is_taxable !== null)
                            <div class="ctr-mfield">
                                <label>Tax Status</label>
                                <span class="badge {{ $employee->is_taxable ? 'badge-green' : 'badge-gray' }}">
                                    {{ $employee->is_taxable ? 'Taxable' : 'Non-Taxable' }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Payment Information --}}
                @if($employee && $employee->payment_method)
                    <div class="ctr-msection">
                        <div class="ctr-msection-title">Payment Information</div>
                        <div class="ctr-mfield"><label>Payment Method</label><p>{{ ucfirst($employee->payment_method) }}</p></div>
                        @if($employee->payment_method === 'bank' && $employee->bank_name)
                            <div class="ctr-mfield"><label>Bank Name</label><p>{{ $employee->bank_name }}</p></div>
                        @endif
                        @if($employee->payment_method === 'bank' && $employee->bank_account_number)
                            <div class="ctr-mfield"><label>Account Number</label><p>{{ $employee->bank_account_number }}</p></div>
                        @endif
                        @if($employee->payment_method === 'bank' && $employee->bank_branch)
                            <div class="ctr-mfield"><label>Bank Branch</label><p>{{ $employee->bank_branch }}</p></div>
                        @endif
                        @if($employee->payment_method === 'mobile_money' && $employee->mobile_money_provider)
                            <div class="ctr-mfield"><label>Mobile Money Provider</label><p>{{ $employee->mobile_money_provider }}</p></div>
                        @endif
                        @if($employee->payment_method === 'mobile_money' && $employee->mobile_money_number)
                            <div class="ctr-mfield"><label>Mobile Money Number</label><p>{{ $employee->mobile_money_number }}</p></div>
                        @endif
                    </div>
                @endif

                {{-- RSSB Information --}}
                @if($employee && ($employee->rssb_rate || $employee->pension_rate))
                    <div class="ctr-msection">
                        <div class="ctr-msection-title">RSSB Information</div>
                        @if($employee->rssb_rate)
                            <div class="ctr-mfield"><label>RSSB Rate</label><p>{{ number_format($employee->rssb_rate, 2) }}%</p></div>
                        @endif
                        @if($employee->pension_rate)
                            <div class="ctr-mfield"><label>Pension Rate</label><p>{{ number_format($employee->pension_rate, 2) }}%</p></div>
                        @endif
                        @if($employee->rss_number)
                            <div class="ctr-mfield"><label>RSSB Number</label><p>{{ $employee->rss_number }}</p></div>
                        @endif
                    </div>
                @endif

                {{-- Approval Status --}}
                <div class="ctr-msection">
                    <div class="ctr-msection-title">Approval Status</div>
                    <div class="ctr-mfield">
                        <label>Contract Status</label>
                        <span class="badge {{ $aClass }}">{{ ucfirst($as) }}</span>
                    </div>
                    @if($selectedContract->approved_at)
                        <div class="ctr-mfield"><label>Approved Date</label><p>{{ $selectedContract->approved_at->format('M d, Y H:i') }}</p></div>
                    @endif
                </div>

            </div>{{-- /ctr-modal-body --}}

            <div class="ctr-modal-footer">
                <button class="btn-primary" wire:click="downloadContract('{{ $selectedContract->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download Contract
                </button>
                <button class="btn-cancel" wire:click="closeModal">Close</button>
            </div>

        </div>
    </div>
@endif

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
    <a href="#" class="ios-nav-item" style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

</div>{{-- /ctr-root --}}
