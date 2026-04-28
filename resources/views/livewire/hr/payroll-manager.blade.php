<div class="ac-root">
    <x-admin-content-styles />
    
    {{-- ── HERO SECTION ── --}}
    <div class="ac-hero">
        <div style="display:flex; align-items:center; gap:20px;">
            <div style="width:64px; height:64px; border-radius:18px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; border:1px solid rgba(255,255,255,0.25);">
                <svg viewBox="0 0 24 24" style="width:32px; height:32px; stroke:#fff; fill:none; stroke-width:2;"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <div>
                <div class="ac-hero-greet">Financial Operations</div>
                <div class="ac-hero-ttl">Payroll Management</div>
                <div class="ac-hero-sub">Process salaries, statutory deductions, and generate payslips.</div>
            </div>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="ac-btn ac-btn-white" wire:click="loadAnalytics">
                <svg viewBox="0 0 24 24" style="width:16px; stroke:var(--blue);"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                Analytics
            </button>
            <button class="ac-btn ac-btn-white" wire:click="$toggle('showCreateModal')">
                <svg viewBox="0 0 24 24" style="width:16px; stroke:var(--blue);"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Period
            </button>
        </div>
    </div>


    {{-- ── ANALYTICS TILES ── --}}
    @if($showAnalytics)
        <div class="ac-tiles">
            <div class="ac-tile">
                <div class="at-bar" style="background:var(--blue);"></div>
                <div class="at-ico" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <div><div class="at-lbl">Total Cost</div><div class="at-val">{{ number_format($analytics['total_cost'] ?? 0, 0) }}</div><div class="at-sub">RWF This period</div></div>
            </div>
            <div class="ac-tile">
                <div class="at-bar" style="background:var(--green);"></div>
                <div class="at-ico" style="background:var(--green-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--green);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <div><div class="at-lbl">Active Staff</div><div class="at-val">{{ $analytics['active_employees'] ?? 0 }}</div><div class="at-sub">On payroll</div></div>
            </div>
            <div class="ac-tile">
                <div class="at-bar" style="background:var(--amber);"></div>
                <div class="at-ico" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
                <div><div class="at-lbl">Overtime</div><div class="at-val">{{ number_format($analytics['overtime_cost'] ?? 0, 0) }}</div><div class="at-sub">RWF Extra pay</div></div>
            </div>
            <div class="ac-tile">
                <div class="at-bar" style="background:var(--indigo);"></div>
                <div class="at-ico" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg></div>
                <div><div class="at-lbl">Avg. Net Pay</div><div class="at-val">{{ number_format($analytics['avg_net_pay'] ?? 0, 0) }}</div><div class="at-sub">RWF Per employee</div></div>
            </div>
        </div>
    @endif

    {{-- ── PAYROLL PERIODS ── --}}
    <div class="ac-card">
        <div class="ac-card-hd">
            <div class="ac-card-title">Payroll History</div>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead>
                    <tr>
                        <th style="padding-left:24px;">Period Name</th>
                        <th>Status</th>
                        <th>Employees</th>
                        <th>Total Gross</th>
                        <th>Total Net</th>
                        <th style="padding-right:24px; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $period)
                        <tr>
                            <td style="padding-left:24px;">
                                <div style="font-weight:700; color:var(--ink);">{{ $period->name }}</div>
                                <div style="font-size:11px; color:var(--ink4); font-weight:600;">{{ \Carbon\Carbon::parse($period->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('M d, Y') }}</div>
                            </td>
                            <td>
                                @php
                                    $sClass = match($period->status) {
                                        'locked' => 'ab-ink',
                                        'approved' => 'ab-green',
                                        'processing' => 'ab-amber',
                                        default => 'ab-blue'
                                    };
                                @endphp
                                <span class="ac-badge {{ $sClass }}">{{ ucfirst($period->status) }}</span>
                            </td>
                            <td><div style="font-weight:700; color:var(--ink2);">{{ $period->payrollEntries()->count() }}</div></td>
                            <td><div style="font-weight:700; color:var(--ink2);">{{ number_format($period->total_gross_pay, 0) }} RWF</div></td>
                            <td><div style="font-weight:800; color:var(--blue);">{{ number_format($period->total_net_pay, 0) }} RWF</div></td>
                            <td style="padding-right:24px; text-align:right;">
                                <div style="display:flex; justify-content:flex-end; gap:8px;">
                                    <button class="ac-btn-icon" wire:click="selectPeriod('{{ $period->id }}')"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                                    
                                    @if($period->status === 'draft')
                                        <button class="ac-btn-icon" style="color:var(--green);" wire:click="$set('runPeriodId', '{{ $period->id }}')" wire:click="$toggle('showRunPayrollModal')"><svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg></button>
                                        <button class="ac-btn-icon" style="color:var(--blue);" wire:click="approvePayroll('{{ $period->id }}')"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></button>
                                    @endif
                                    
                                    @if($period->status === 'approved')
                                        <button class="ac-btn-icon" wire:click="lockPayroll('{{ $period->id }}')"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                                    @endif
                                    
                                    @if($period->status !== 'locked')
                                        <button class="ac-btn-icon" style="color:var(--red);" onclick="showDeletePayrollConfirm('{{ $period->id }}')"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div style="padding:60px 24px; text-align:center;">
                                    <svg viewBox="0 0 24 24" style="width:48px; height:48px; stroke:var(--ink4); fill:none; stroke-width:1; margin-bottom:16px; opacity:0.3;"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                    <div style="font-size:16px; font-weight:700; color:var(--ink3);">No payroll history found</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($periods->hasPages())
            <div style="padding:16px 24px; border-top:1px solid var(--border);">{{ $periods->links() }}</div>
        @endif
    </div>

    {{-- ── PAYROLL ENTRIES ── --}}
    @if($selectedPeriod)
        <div class="ac-card" style="margin-top:32px;">
            <div class="ac-card-hd" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="ac-card-title">Employee Payouts</div>
                <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="generateBankFile('{{ $selectedPeriod }}')">
                    <svg viewBox="0 0 24 24" style="width:14px; margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Bank File
                </button>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th style="padding-left:24px;">Employee</th>
                            <th>Basic Salary</th>
                            <th>Gross Pay</th>
                            <th>Deductions</th>
                            <th>Net Payout</th>
                            <th style="padding-right:24px; text-align:right;">Slip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEntries as $entry)
                            <tr>
                                <td style="padding-left:24px;">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <div style="width:36px; height:36px; border-radius:10px; background:var(--blue-lt); display:flex; align-items:center; justify-content:center; font-family:'Sora',sans-serif; font-size:12px; font-weight:800; color:var(--blue);">
                                            {{ substr($entry->employee_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:700; color:var(--ink);">{{ $entry->employee_name }}</div>
                                            <div style="font-size:11px; color:var(--ink4); font-weight:600;">{{ $entry->employee_department ?? '—' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><div style="font-size:13px; color:var(--ink2);">{{ number_format($entry->basic_salary, 0) }} RWF</div></td>
                                <td><div style="font-size:13px; color:var(--ink2);">{{ number_format($entry->gross_pay, 0) }} RWF</div></td>
                                <td><div style="font-size:13px; color:var(--red);">{{ number_format($entry->total_deductions, 0) }} RWF</div></td>
                                <td><div style="font-size:14px; font-weight:800; color:var(--green);">{{ number_format($entry->net_pay, 0) }} RWF</div></td>
                                <td style="padding-right:24px; text-align:right;">
                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" style="padding:4px 10px;" wire:click="generatePayslip('{{ $entry->id }}')">
                                        <svg viewBox="0 0 24 24" style="width:12px; margin-right:4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 02 2h12a2 2 0 0 02-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        PDF
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div style="padding:40px 24px; text-align:center;">
                                        <div style="font-size:14px; color:var(--ink4);">No entries for this period.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recentEntries->hasPages())
                <div style="padding:16px 24px; border-top:1px solid var(--border);">{{ $recentEntries->links() }}</div>
            @endif
        </div>
    @endif

    {{-- ── CREATE PERIOD MODAL ── --}}
    @if($showCreateModal)
        <div class="ac-modal-bg" wire:click.self="$toggle('showCreateModal')" style="display:flex; align-items:center; justify-content:center;">
            <div class="ac-card" style="width:100%; max-width:480px; box-shadow:var(--sh-lg);">
                <div style="padding:24px; background:linear-gradient(118deg, var(--blue-3) 0%, var(--blue) 100%); color:#fff; display:flex; align-items:center; justify-content:space-between;">
                    <div style="font-family:'Sora',sans-serif; font-size:18px; font-weight:800;">New Payroll Period</div>
                    <button wire:click="$toggle('showCreateModal')" style="background:rgba(255,255,255,0.2); border:none; width:32px; height:32px; border-radius:10px; color:#fff; cursor:pointer;"><svg viewBox="0 0 24 24" style="width:16px; stroke:currentColor; fill:none; stroke-width:3;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
                </div>
                <div style="padding:32px; display:flex; flex-direction:column; gap:20px;">
                    <div class="ac-field"><label>Period Name</label><input type="text" wire:model="periodName" placeholder="e.g. April 2026">@error('periodName') <span class="ac-field-error">{{ $message }}</span> @enderror</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="ac-field"><label>Start Date</label><input type="date" wire:model="startDate"></div>
                        <div class="ac-field"><label>End Date</label><input type="date" wire:model="endDate"></div>
                    </div>
                </div>
                <div style="padding:24px; background:var(--bg2); border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:12px;">
                    <button wire:click="$toggle('showCreateModal')" class="ac-btn ac-btn-ghost">Cancel</button>
                    <button wire:click="createPayrollPeriod" class="ac-btn ac-btn-primary">Create Period</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── RUN PAYROLL MODAL ── --}}
    @if($showRunPayrollModal)
        <div class="ac-modal-bg" style="display:flex; align-items:center; justify-content:center;">
            <div class="ac-card" style="width:100%; max-width:480px; padding:32px; text-align:center; box-shadow:var(--sh-lg);">
                <div style="width:64px; height:64px; border-radius:50%; background:var(--blue-lt); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                    <svg viewBox="0 0 24 24" style="width:32px; stroke:var(--blue); fill:none; stroke-width:2;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </div>
                <div style="font-family:'Sora',sans-serif; font-size:20px; font-weight:800; color:var(--ink);">Run Calculations?</div>
                <p style="font-size:14px; color:var(--ink3); margin-top:12px; line-height:1.6;">
                    This will process all active contracts, calculate statutory deductions (RSSB, PAYE), and apply overtime for the selected period.
                </p>
                <div style="margin-top:32px; display:flex; gap:12px;">
                    <button wire:click="$toggle('showRunPayrollModal')" class="ac-btn ac-btn-ghost" style="flex:1;">Cancel</button>
                    <button wire:click="runPayroll('{{ $runPeriodId ?? '' }}')" class="ac-btn ac-btn-primary" style="flex:1; background:var(--green);">Execute Run</button>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Include custom confirm dialog component --}}
@include('components.confirm-dialog')

<script>
function showDeletePayrollConfirm(periodId) {
    showConfirmDialog({
        title: 'Delete Payroll Period',
        message: 'Are you sure you want to delete this payroll period? This action cannot be undone and will remove all associated calculations.',
        confirmText: 'Delete',
        cancelText: 'Cancel',
        type: 'danger',
        onConfirm: function() {
            @this.deletePayroll(periodId);
        }
    });
}
</script>
