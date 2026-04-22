<x-layouts.app>
    @push('styles')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

            /* ══ TOKENS ══════════════════════════════════════════════ */
            .mp-local-shell {
                --blue: #3B6FE8;
                --blue-2: #2755CC;
                --blue-3: #1A3FA8;
                --blue-lt: rgba(59, 111, 232, 0.09);
                --blue-mid: rgba(59, 111, 232, 0.18);
                --blue-brd: rgba(59, 111, 232, 0.22);
                --indigo: #5026f7ff;
                --indigo-lt: rgba(107, 79, 219, 0.09);
                --indigo-brd: rgba(107, 79, 219, 0.20);
                --green: #12B76A;
                --green-lt: rgba(18, 183, 106, 0.10);
                --amber: #F59E0B;
                --amber-lt: rgba(245, 158, 11, 0.10);
                --red: #EF4444;
                --red-lt: rgba(239, 68, 68, 0.10);
                --purple: #3d3aedff;
                --purple-lt: rgba(124, 58, 237, 0.09);
                --teal: #0BB5B5;
                --teal-lt: rgba(11, 181, 181, 0.10);
                --bg: #F0F4FA;
                --bg2: #F0F4FA;
                --white: #FFFFFF;
                --ink: #0F1629;
                --ink2: #2D3356;
                --ink3: #6B7094;
                --ink4: #A8ADCA;
                --border: rgba(15, 22, 41, 0.08);
                --sh-sm: 0 2px 10px rgba(59, 111, 232, 0.08);
                --sh-md: 0 6px 24px rgba(59, 111, 232, 0.11);
                --sh-lg: 0 16px 48px rgba(59, 111, 232, 0.14);
                --r: 12px;
                --r-lg: 20px;
                font-family: 'DM Sans', -apple-system, sans-serif;
                color: var(--ink);

                display: grid;
                grid-template-columns: 240px 1fr;
                gap: 32px;
                align-items: flex-start;
                padding: 32px 36px;
                max-width: 100%;
                margin: 0 auto;
                background: var(--bg);
                min-height: 100vh;
            }

            /* ══ SIDE NAV ══════════════════════════════════════════════ */
            .mp-local-sidebar {
                position: sticky;
                top: 28px;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .mp-local-nav {
                display: flex;
                flex-direction: column;
                gap: 6px;
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: var(--r-lg);
                padding: 10px;
                box-shadow: var(--sh-sm);
            }

            .mp-nav-logo {
                padding: 20px 20px 16px;
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                gap: 11px;
                flex-shrink: 0;
            }

            .mp-nav-logo-mark {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: linear-gradient(135deg, var(--indigo), var(--blue));
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                box-shadow: 0 3px 10px rgba(107, 79, 219, 0.32);
            }

            .mp-nav-logo-mark svg {
                width: 18px;
                height: 18px;
                stroke: #fff;
                fill: none;
                stroke-width: 2;
            }

            .mp-nav-brand {
                font-family: 'Sora', sans-serif;
                font-size: 14px;
                font-weight: 900;
                color: var(--ink);
                letter-spacing: -0.2px;
            }

            .mp-nav-brand span {
                color: var(--indigo);
            }

            .mp-nav-section {
                font-size: 9.5px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.10em;
                color: var(--ink4);
                padding: 16px 20px 6px;
            }

            .mp-nav-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 16px;
                border-radius: var(--r);
                font-size: 14px;
                font-weight: 700;
                color: var(--ink2);
                cursor: pointer;
                border: none;
                background: transparent;
                font-family: 'DM Sans', sans-serif;
                transition: all .2s;
                text-align: left;
                width: 100%;
                margin: 0;
            }

            .mp-nav-item svg {
                width: 18px;
                height: 18px;
                stroke: currentColor;
                fill: none;
                stroke-width: 2.2;
                opacity: 0.6;
                transition: opacity .2s;
                flex-shrink: 0;
            }

            .mp-nav-item:hover {
                background: rgba(59, 111, 232, 0.09);
                color: var(--blue-2);
            }

            .mp-nav-item:hover svg {
                opacity: 1;
            }

            .mp-nav-item.active {
                background: #2949d4ff;
                color: #fff;
                box-shadow: 0 4px 12px rgba(59, 111, 232, 0.25);
                font-weight: 700;
            }

            .mp-nav-item.active svg {
                opacity: 1;
                stroke: #fff;
            }

            .mp-nav-badge {
                margin-left: auto;
                background: rgba(255, 255, 255, 0.2);
                color: #fff;
                font-size: 10px;
                font-weight: 800;
                padding: 2px 7px;
                border-radius: 100px;
            }

            .mp-nav-item:not(.active) .mp-nav-badge.amber {
                background: var(--amber-lt);
                color: #92400E;
                border: 1px solid rgba(245, 158, 11, 0.22);
            }

            .mp-nav-item:not(.active) .mp-nav-badge.green {
                background: var(--green-lt);
                color: #087A42;
                border: 1px solid rgba(18, 183, 106, 0.22);
            }

            .mp-nav-bottom {
                margin-top: auto;
                padding: 16px 8px;
                border-top: 1px solid var(--border);
                flex-shrink: 0;
            }

            .mp-nav-back {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 9px 16px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                color: var(--ink3);
                text-decoration: none;
                transition: all 0.15s;
            }

            .mp-nav-back:hover {
                background: var(--bg);
                color: var(--ink2);
            }

            .mp-nav-back svg {
                width: 15px;
                height: 15px;
                stroke: currentColor;
                fill: none;
                stroke-width: 2;
            }

            /* ══ CONTENT ════════════════════════════════════════════════ */
            .mp-local-main {
                display: flex;
                flex-direction: column;
                gap: 24px;
                min-width: 0;
            }

            .mp-section {
                display: none;
            }

            .mp-section.active {
                display: block;
            }

            .mp-wrap {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            /* Styles for HERO, TILES, etc. abbreviated for token limits if needed, 
                               but user expects the full visual experience. */
            .la-hero {
                background: linear-gradient(118deg, #1A3FA8 0%, var(--indigo) 36%, var(--blue) 68%, #6B4FDB 100%);
                border-radius: var(--r-lg);
                padding: 32px 40px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                position: relative;
                overflow: hidden;
                box-shadow: var(--sh-lg);
                margin-bottom: 24px;
                color: #fff;
            }

            .la-hero::before {
                content: '';
                position: absolute;
                top: -50px;
                right: 240px;
                width: 250px;
                height: 250px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.06);
                pointer-events: none;
            }

            .la-hero::after {
                content: '';
                position: absolute;
                bottom: -40px;
                left: 60px;
                width: 160px;
                height: 160px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.04);
                pointer-events: none;
            }

            .la-hero-left {
                display: flex;
                align-items: center;
                gap: 24px;
                position: relative;
                z-index: 1;
            }

            .la-hero-icon {
                width: 64px;
                height: 64px;
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.18);
                border: 2px solid rgba(255, 255, 255, 0.30);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .la-hero-icon svg {
                width: 30px;
                height: 30px;
                stroke: #fff;
                fill: none;
                stroke-width: 2;
            }

            .la-hero-title {
                font-family: 'Sora', sans-serif;
                font-size: 26px;
                font-weight: 900;
                color: #fff;
                letter-spacing: -0.5px;
                margin-bottom: 6px;
            }

            .la-hero-sub {
                font-size: 14px;
                color: rgba(255, 255, 255, 0.7);
                font-weight: 500;
            }

            .la-hero-chips {
                display: flex;
                gap: 10px;
                margin-top: 14px;
            }

            .la-hero-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(255, 255, 255, 0.14);
                border: 1px solid rgba(255, 255, 255, 0.20);
                border-radius: 100px;
                padding: 5px 14px;
                font-size: 12.5px;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.95);
            }

            .la-hero-right {
                display: flex;
                gap: 40px;
                position: relative;
                z-index: 1;
                flex-shrink: 0;
            }

            .la-hero-stat {
                text-align: center;
            }

            .la-hero-sv {
                font-family: 'Sora', sans-serif;
                font-size: 36px;
                font-weight: 900;
                color: #fff;
                line-height: 1;
            }

            .la-hero-sl {
                font-size: 11px;
                color: rgba(255, 255, 255, 0.60);
                font-weight: 700;
                margin-top: 8px;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }

            .mp-tiles {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .mp-tile {
                background: var(--white);
                border-radius: var(--r-lg);
                border: 1px solid var(--border);
                box-shadow: var(--sh-sm);
                padding: 18px 16px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
                position: relative;
                overflow: hidden;
                cursor: pointer;
            }

            .mp-tile-bar {
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                border-radius: 12px 0 0 12px;
            }

            .mp-tile-v {
                font-family: 'Sora', sans-serif;
                font-size: 24px;
                font-weight: 800;
                color: var(--ink);
            }

            .mp-ov-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 18px;
            }

            .mp-card {
                background: var(--white);
                border-radius: var(--r-lg);
                border: 1px solid var(--border);
                box-shadow: var(--sh-sm);
                overflow: hidden;
            }

            .mp-card-hd {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 15px 20px;
                border-bottom: 1px solid var(--border);
            }

            .mp-card-bd {
                padding: 18px 20px;
            }

            /* ══ UTILITIES ═════════════════════════════════════════════ */
            .la-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            .la-table th {
                text-align: left;
                padding: 12px 16px;
                font-size: 10.5px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: var(--ink4);
                border-bottom: 1px solid var(--border);
            }

            .la-table td {
                padding: 14px 16px;
                border-bottom: 1px solid var(--border);
                vertical-align: middle;
                color: var(--ink);
            }

            .la-table tr:last-child td {
                border-bottom: none;
            }

            .la-badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 3px 9px;
                border-radius: 100px;
                font-size: 11px;
                font-weight: 700;
            }

            .lb-green {
                background: var(--green-lt);
                color: #087A42;
            }

            .lb-amber {
                background: var(--amber-lt);
                color: #92400E;
            }

            .lb-blue {
                background: var(--blue-lt);
                color: var(--blue-2);
            }

            .la-card-lnk {
                background: none;
                border: none;
                padding: 0;
                font-size: 12px;
                font-weight: 700;
                color: var(--blue);
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 4px;
                transition: color 0.15s;
            }

            .la-card-lnk:hover {
                color: var(--blue-2);
                text-decoration: underline;
            }

            .la-card-lnk svg {
                width: 12px;
                height: 12px;
                stroke: currentColor;
                fill: none;
                stroke-width: 3;
            }

            .la-tile-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: var(--bg);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                margin-bottom: 12px;
            }

            .la-tile-icon svg {
                width: 20px;
                height: 20px;
                stroke: currentColor;
                fill: none;
                stroke-width: 2.2;
            }

            .mp-tile-lbl {
                font-size: 10px;
                font-weight: 800;
                color: var(--ink4);
                letter-spacing: 0.05em;
                margin-bottom: 4px;
            }
        </style>
    @endpush

    <div class="mp-local-shell">

        @php
            $mpPendingMonths = 0;
            $mpPendingEntries = 0;
            $mpPendingPayments = 0;
            try {
                $mpPendingMonths = \App\Models\PayrollMonth::where('approval_status', 'pending')->count();
            } catch (\Exception) {
            }
            try {
                $mpPendingEntries = \App\Models\PayrollEntry::where('approval_status', 'pending')->count();
            } catch (\Exception) {
            }
            try {
                $mpPendingPayslips = \App\Models\PayslipEntry::where('approval_status', 'pending')->count();
            } catch (\Exception) {
            }
            try {
                $mpPendingPayments = \App\Models\PaymentHistory::where('status', 'pending')->count();
            } catch (\Exception) {
            }
        @endphp

        <aside class="mp-local-sidebar">
            <nav class="mp-local-nav">

                <button class="mp-nav-item active" data-section="overview"
                    onclick="mpSwitch('overview',this)"><span>Overview</span></button>
                <button class="mp-nav-item" data-section="months" onclick="mpSwitch('months',this)"><span>Payroll
                        Months</span>@if($mpPendingMonths > 0)<span
                        class="mp-nav-badge amber">{{$mpPendingMonths}}</span>@endif</button>
                <button class="mp-nav-item" data-section="entries" onclick="mpSwitch('entries',this)"><span>Payroll
                        Entries</span>@if($mpPendingEntries > 0)<span
                        class="mp-nav-badge amber">{{$mpPendingEntries}}</span>@endif</button>
                <button class="mp-nav-item" data-section="payslips" onclick="mpSwitch('payslips',this)"><span>Payslip
                        Entries</span>@if($mpPendingPayslips ?? 0 > 0)<span
                        class="mp-nav-badge amber">{{$mpPendingPayslips}}</span>@endif</button>
                <button class="mp-nav-item" data-section="payments" onclick="mpSwitch('payments',this)"><span>Payment
                        History</span>@if($mpPendingPayments > 0)<span
                        class="mp-nav-badge amber">{{$mpPendingPayments}}</span>@endif</button>
            </nav>
        </aside>

        <main class="mp-local-main">
            <div class="mp-section active" id="mp-section-overview">
                @php
                    $ov = ['months' => 0, 'entries' => 0, 'payments_done' => 0, 'total_gross' => 0, 'pending_approval' => 0];
                    try {
                        $ov['months'] = \App\Models\PayrollMonth::count();
                        $ov['entries'] = \App\Models\PayrollEntry::count();
                        $ov['payments_done'] = \App\Models\PaymentHistory::where('status', 'completed')->count();
                        $ov['total_gross'] = \App\Models\PayrollEntry::where('approval_status', 'approved')->sum('total_amount');
                        $ov['pending_approval'] = \App\Models\PayrollEntry::where('approval_status', 'pending')->count()
                            + \App\Models\PayrollMonth::where('approval_status', 'pending')->count();
                    } catch (\Exception $e) {
                    }
                @endphp
                <div class="mp-wrap">
                    <div class="la-hero">
                        <div class="la-hero-left">
                            <div class="la-hero-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                            </div>
                            <div>
                                <div class="la-hero-title">Financial & Payroll Management</div>
                                <div class="la-hero-sub">System-wide expenditure tracking and salary disbursements ·
                                    {{ now()->format('M Y') }}
                                </div>
                                <div class="la-hero-chips">
                                    <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14"
                                            fill="none" stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 8v4" />
                                            <path d="M12 16h.01" />
                                        </svg>{{ $ov['pending_approval'] }} Pending Approval</span>
                                    <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14"
                                            fill="none" stroke="currentColor" stroke-width="2.5">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                        </svg>{{ $ov['payments_done'] }} Payments Done</span>
                                </div>
                            </div>
                        </div>
                        <div class="la-hero-right">
                            <div class="la-hero-stat">
                                <div class="la-hero-sv">{{ number_format($ov['total_gross'] / 1000, 1) }}k</div>
                                <div class="la-hero-sl">Gross (USD)</div>
                            </div>
                            <div class="la-hero-stat">
                                <div class="la-hero-sv">{{ $ov['entries'] }}</div>
                                <div class="la-hero-sl">Records</div>
                            </div>
                        </div>
                    </div>

                    <div class="mp-tiles">
                        <div class="mp-tile" onclick="mpSwitch('months')">
                            <div class="mp-tile-bar" style="background:var(--indigo);"></div>
                            <div class="la-tile-icon" style="color:var(--indigo);"><svg viewBox="0 0 24 24" width="20"
                                    height="20" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg></div>
                            <div>
                                <div class="mp-tile-lbl">MONTHS</div>
                                <div class="mp-tile-v">{{$ov['months']}}</div>
                            </div>
                        </div>
                        <div class="mp-tile" onclick="mpSwitch('entries')">
                            <div class="mp-tile-bar" style="background:var(--green);"></div>
                            <div class="la-tile-icon" style="color:var(--green);"><svg viewBox="0 0 24 24" width="20"
                                    height="20" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg></div>
                            <div>
                                <div class="mp-tile-lbl">ENTRIES</div>
                                <div class="mp-tile-v">{{$ov['entries']}}</div>
                            </div>
                        </div>
                        <div class="mp-tile" onclick="mpSwitch('payslips')">
                            <div class="mp-tile-bar" style="background:var(--purple);"></div>
                            <div class="la-tile-icon" style="color:var(--purple);"><svg viewBox="0 0 24 24" width="20"
                                    height="20" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></div>
                            <div>
                                <div class="mp-tile-lbl">PAYSLIPS</div>
                                <div class="mp-tile-v">{{\App\Models\PayslipEntry::count()}}</div>
                            </div>
                        </div>
                        <div class="mp-tile" onclick="mpSwitch('payments')">
                            <div class="mp-tile-bar" style="background:var(--teal);"></div>
                            <div class="la-tile-icon" style="color:var(--teal);"><svg viewBox="0 0 24 24" width="20"
                                    height="20" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg></div>
                            <div>
                                <div class="mp-tile-lbl">PAYMENTS</div>
                                <div class="mp-tile-v">{{$ov['payments_done']}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mp-ov-grid">
                        <div class="mp-card">
                            <div class="mp-card-hd">
                                <div class="mp-card-ttl">Recent Payroll Months</div>
                                <button class="la-card-lnk" onclick="mpSwitch('months')">View All <svg
                                        viewBox="0 0 24 24">
                                        <polyline points="9 18 15 12 9 6" />
                                    </svg></button>
                            </div>
                            <div class="mp-card-bd" style="padding:0;">
                                <table class="la-table">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\App\Models\PayrollMonth::latest()->take(5)->get() as $m)
                                            <tr>
                                                <td style="font-weight:700;">{{ $m->name }}</td>
                                                <td><span
                                                        class="la-badge {{ $m->approval_status === 'approved' ? 'lb-green' : 'lb-amber' }}">{{ ucfirst($m->approval_status->value ?? $m->approval_status) }}</span>
                                                </td>
                                                <td style="font-family:'Sora';font-weight:800;">
                                                    ${{ number_format($m->entries?->sum('total_amount') ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mp-card">
                            <div class="mp-card-hd">
                                <div class="mp-card-ttl">Latest Payroll Entries</div>
                                <button class="la-card-lnk" onclick="mpSwitch('entries')">View All <svg
                                        viewBox="0 0 24 24">
                                        <polyline points="9 18 15 12 9 6" />
                                    </svg></button>
                            </div>
                            <div class="mp-card-bd" style="padding:0;">
                                <table class="la-table">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Month</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\App\Models\PayrollEntry::with(['employee', 'payrollMonth'])->latest()->take(5)->get() as $e)
                                            <tr>
                                                <td style="font-weight:700;">{{ $e->employee->full_name ?? 'Unknown' }}</td>
                                                <td style="font-size:12px;color:var(--ink3);">
                                                    {{ $e->payrollMonth->name ?? '—' }}
                                                </td>
                                                <td style="font-family:'Sora';font-weight:800;color:var(--blue-2);">
                                                    ${{ number_format($e->total_amount, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mp-section" id="mp-section-months">@livewire('payroll.payroll-month-manager')</div>
            <div class="mp-section" id="mp-section-entries">@livewire('payroll.payroll-entry-manager')</div>
            <div class="mp-section" id="mp-section-payslips">@livewire('payroll.payslip-entry-manager')</div>
            <div class="mp-section" id="mp-section-payments">@livewire('payroll.payment-history-manager')</div>
        </main>

        <script>
            function mpSwitch(name, btnEl) {
                document.querySelectorAll('.mp-section').forEach(s => s.classList.remove('active'));
                document.getElementById('mp-section-' + name).classList.add('active');
                document.querySelectorAll('.mp-nav-item').forEach(b => b.classList.remove('active'));
                if (btnEl) btnEl.classList.add('active');
                else document.querySelector('.mp-nav-item[data-section="' + name + '"]')?.classList.add('active');
            }
        </script>
    </div>
</x-layouts.app>