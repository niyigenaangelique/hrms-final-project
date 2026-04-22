<div class="pr-shell">
    {{--
        Deep Ocean Payroll Dashboard
        Standardized to match the HRMS High-Fidelity Design System.
    --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

        .pr-shell {
            --blue: #3B6FE8;
            --blue-2: #2755CC;
            --blue-lt: rgba(59, 111, 232, 0.08);
            --blue-brd: rgba(59, 111, 232, 0.22);
            --green: #12B76A;
            --green-lt: rgba(18, 183, 106, 0.10);
            --amber: #F59E0B;
            --amber-lt: rgba(245, 158, 11, 0.10);
            --red: #EF4444;
            --red-lt: rgba(239, 68, 68, 0.10);
            --purple: #7C3AED;
            --purple-lt: rgba(124, 58, 237, 0.10);
            --bg: #F0F4FA;
            --white: #FFFFFF;
            --ink: #0F1629;
            --ink2: #2D3356;
            --ink3: #6B7094;
            --ink4: #A8ADCA;
            --border: rgba(15, 22, 41, 0.08);
            --sh-sm: 0 2px 12px rgba(59, 111, 232, 0.08);
            --sh-md: 0 8px 32px rgba(59, 111, 232, 0.12);
            --sh-lg: 0 16px 48px rgba(59, 111, 232, 0.15);
            --r: 14px;
            --r-lg: 24px;

            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            background: var(--bg);
            min-height: 100vh;
            padding: 32px 40px 120px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* Header */
        .pr-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .pr-h-title { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 900; letter-spacing: -0.8px; color: var(--ink); }
        .pr-h-sub { font-size: 14px; font-weight: 500; color: var(--ink3); margin-top: 4px; }

        .pr-actions { display: flex; gap: 12px; }
        .pr-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; border-radius: 14px; font-size: 13.5px; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
        .pr-btn-primary { background: var(--blue); color: #fff; box-shadow: var(--sh-sm); }
        .pr-btn-primary:hover { background: var(--blue-2); transform: translateY(-2px); box-shadow: var(--sh-md); }
        .pr-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); box-shadow: var(--sh-sm); }
        .pr-btn-outline:hover { background: var(--bg); transform: translateY(-2px); }

        /* Selects */
        .pr-select-group { display: flex; gap: 8px; }
        .pr-select { background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 10px 16px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; box-shadow: var(--sh-sm); }

        /* Stats Grid */
        .pr-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .pr-stat {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: var(--sh-sm);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .pr-stat:hover { transform: translateY(-4px); box-shadow: var(--sh-md); }

        .pr-stat-ico { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .pr-stat-ico svg { width: 22px; height: 22px; stroke-width: 2.5; }

        .pr-stat-val { font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 800; color: var(--ink); line-height: 1.1; }
        .pr-stat-lbl { font-size: 11px; font-weight: 700; color: var(--ink4); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px; }

        /* Main Grid */
        .pr-grid { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; }
        .pr-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
        .pr-card-hd { padding: 22px 28px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .pr-card-ttl { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: var(--ink); }
        .pr-card-bd { padding: 24px 28px; }

        /* Comparison Card */
        .pr-cmp-val { font-family: 'Sora', sans-serif; font-size: 42px; font-weight: 900; color: var(--blue); letter-spacing: -1.5px; }
        .pr-cmp-trend { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; margin-top: 8px; }
        .pr-trend-up { color: var(--green); }
        .pr-trend-down { color: var(--red); }

        /* Table */
        .pr-table-wrap { width: 100%; overflow-x: auto; }
        .pr-table { width: 100%; border-collapse: collapse; }
        .pr-table th { text-align: left; padding: 14px 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink4); border-bottom: 1px solid var(--border); }
        .pr-table td { padding: 16px 20px; font-size: 14px; color: var(--ink2); font-weight: 500; border-bottom: 1px solid var(--border); }
        .pr-table tr:last-child td { border-bottom: none; }

        /* Badges */
        .pr-badge { display: inline-flex; padding: 4px 12px; border-radius: 100px; font-size: 11.5px; font-weight: 700; }
        .pb-green { background: var(--green-lt); color: var(--green); }
        .pb-amber { background: var(--amber-lt); color: var(--amber); }

        /* Floating Nav */
        .pr-nav { position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%); z-index: 100; background: var(--ink); padding: 8px 12px; border-radius: 20px; display: flex; gap: 4px; box-shadow: var(--sh-lg); }
        .pr-nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 10px 18px; border-radius: 14px; text-decoration: none; color: rgba(255,255,255,0.5); transition: all 0.2s; min-width: 70px; }
        .pr-nav-item:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .pr-nav-item.active { color: var(--blue); background: rgba(59, 111, 232, 0.15); font-weight: 700; }
        .pr-nav-item svg { width: 20px; height: 20px; stroke: currentColor; stroke-width: 2.2; }
        .pr-nav-lbl { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; }

        /* Modal */
        .pr-modal-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(15, 22, 41, 0.4); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; padding: 24px; }
        .pr-modal { background: var(--white); border-radius: var(--r-lg); width: 100%; max-width: 600px; box-shadow: var(--sh-lg); overflow: hidden; }
        .pr-modal-hd { padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .pr-modal-ttl { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); }
        .pr-modal-bd { padding: 32px; display: flex; flex-direction: column; gap: 20px; }
        .pr-modal-ft { padding: 24px 32px; background: var(--bg); border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; }
    </style>

    <div class="pr-header">
        <div>
            <h1 class="pr-h-title">Payroll Hub</h1>
            <p class="pr-h-sub">Financial Intelligence & Compensation Management</p>
        </div>
        <div class="pr-actions">
            <div class="pr-select-group">
                <select wire:model.live="selectedMonth" class="pr-select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}">{{ Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}</option>
                    @endfor
                </select>
                <select wire:model.live="selectedYear" class="pr-select">
                    @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button wire:click="openProcessModal" class="pr-btn pr-btn-primary">Process Payroll</button>
            <button wire:click="generatePayslips" class="pr-btn pr-btn-outline">Generate Slips</button>
        </div>
    </div>

    <div class="pr-stats">
        <div class="pr-stat">
            <div class="pr-stat-ico" style="background: var(--blue-lt); color: var(--blue);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
            <div>
                <div class="pr-stat-val">${{ number_format($totalPayrollAmount, 2) }}</div>
                <div class="pr-stat-lbl">Total Disbursement</div>
            </div>
        </div>
        <div class="pr-stat">
            <div class="pr-stat-ico" style="background: var(--green-lt); color: var(--green);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
            <div>
                <div class="pr-stat-val">{{ $totalEmployees }}</div>
                <div class="pr-stat-lbl">Recipients</div>
            </div>
        </div>
        <div class="pr-stat">
            <div class="pr-stat-ico" style="background: var(--amber-lt); color: var(--amber);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div>
                <div class="pr-stat-val">{{ $pendingPayments }}</div>
                <div class="pr-stat-lbl">Pending Cycles</div>
            </div>
        </div>
        <div class="pr-stat">
            <div class="pr-stat-ico" style="background: var(--purple-lt); color: var(--purple);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg></div>
            <div>
                <div class="pr-stat-val">{{ $completedPayments }}</div>
                <div class="pr-stat-lbl">Finalized</div>
            </div>
        </div>
    </div>

    <div class="pr-grid">
        <div class="pr-card">
            <div class="pr-card-hd">
                <span class="pr-card-ttl">{{ Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1)->format('F Y') }} Intelligence</span>
            </div>
            <div class="pr-card-bd">
                <div class="pr-cmp-val">${{ number_format($monthlyComparison['current'], 2) }}</div>
                <div class="pr-cmp-trend {{ $monthlyComparison['change'] > 0 ? 'pr-trend-up' : 'pr-trend-down' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="{{ $monthlyComparison['change'] > 0 ? '18 15 12 9 6 15' : '6 9 12 15 18 9' }}"/></svg>
                    {{ abs(number_format($monthlyComparison['change'], 1)) }}% vs last month
                </div>
                
                <div style="margin-top: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                    <div>
                        <div class="pr-stat-lbl">Avg Salary</div>
                        <div style="font-size: 18px; font-weight: 800; color: var(--ink); margin-top: 4px;">${{ number_format($totalEmployees > 0 ? $totalPayrollAmount / $totalEmployees : 0, 2) }}</div>
                    </div>
                    <div>
                        <div class="pr-stat-lbl">Total Entries</div>
                        <div style="font-size: 18px; font-weight: 800; color: var(--ink); margin-top: 4px;">{{ $totalPayrollEntries }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pr-card">
            <div class="pr-card-hd"><span class="pr-card-ttl">Departmental Load</span></div>
            <div class="pr-card-bd">
                @if($departmentStats)
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <span style="font-size: 14px; font-weight: 700; color: var(--ink2);">{{ $departmentStats->department }}</span>
                            <span style="font-size: 12px; font-weight: 600; color: var(--ink4);">{{ $departmentStats->employee_count }} staff</span>
                        </div>
                        <div style="height: 8px; background: var(--bg); border-radius: 100px; overflow: hidden;">
                            <div style="width: 75%; height: 100%; background: var(--blue); border-radius: 100px;"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="pr-card">
        <div class="pr-card-hd">
            <span class="pr-card-ttl">Recent Disbursement History</span>
        </div>
        <div class="pr-table-wrap">
            <table class="pr-table">
                <thead><tr><th>Employee</th><th>Gross Amount</th><th>Method</th><th>Execution Status</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($recentPayments as $payment)
                        <tr>
                            <td style="font-weight: 700;">{{ $payment->employee->full_name }}</td>
                            <td style="font-family: 'Sora', sans-serif; font-weight: 800;">${{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ strtoupper($payment->payment_method ?? 'BANK') }}</td>
                            <td><span class="pr-badge {{ $payment->status->value === 'completed' ? 'pb-green' : 'pb-amber' }}">{{ strtoupper($payment->status->value) }}</span></td>
                            <td style="color: var(--ink4); font-size: 12px;">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'PENDING' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Floating Nav --}}
    <nav class="pr-nav">
        <a href="{{ route('payroll.dashboard') }}" class="pr-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            <span class="pr-nav-lbl">Dashboard</span>
        </a>
        <a href="{{ route('payroll.payslip-generator') }}" class="pr-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="pr-nav-lbl">Payslips</span>
        </a>
        <a href="{{ route('payroll.tax-calculator') }}" class="pr-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            <span class="pr-nav-lbl">Tax</span>
        </a>
    </nav>

    {{-- Modal: Process Payroll --}}
    @if($showProcessModal)
        <div class="pr-modal-overlay" wire:click="closeProcessModal">
            <div class="pr-modal" wire:click.stop>
                <div class="pr-modal-hd">
                    <span class="pr-modal-ttl">Execute Payroll Cycle</span>
                    <button wire:click="closeProcessModal" style="border:none; background:none; cursor:pointer; color:var(--ink4);"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
                </div>
                <div class="pr-modal-bd">
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <label style="font-size:12px; font-weight:800; text-transform:uppercase; color:var(--ink4);">Target Period</label>
                        <select wire:model.live="processingMonthId" class="pr-select" style="width:100%;">
                            <option value="">Select period...</option>
                            @foreach($upcomingPayrolls as $payroll)
                                <option value="{{ $payroll->id }}">{{ $payroll->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="pr-modal-ft">
                    <button wire:click="closeProcessModal" class="pr-btn pr-btn-outline">Cancel</button>
                    <button wire:click="processPayroll" class="pr-btn pr-btn-primary">Execute Cycle</button>
                </div>
            </div>
        </div>
    @endif
</div>
