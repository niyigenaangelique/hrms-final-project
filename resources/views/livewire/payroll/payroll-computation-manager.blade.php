<div>
    <div class="ac-card" style="padding: 28px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.8); background: rgba(255,255,255,0.7); backdrop-filter: blur(20px);">
        
        <!-- HEADER / ACTIONS -->
        @if(session()->has('success'))
            <div style="padding: 12px 20px; background: rgba(18, 183, 106, 0.1); border: 1px solid rgba(18, 183, 106, 0.2); border-radius: 12px; color: #087A42; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div style="padding: 12px 20px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 12px; color: #991B1B; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @if(session()->has('warning'))
            <div style="padding: 12px 20px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 12px; color: #92400E; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            </div>
        @endif
        
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px; gap:24px;">
            <div style="display:flex; gap:20px; align-items:center; flex:1;">
                <div style="width:320px;">
                    <label class="ac-label" style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--ink4);">Select Payroll Period</label>
                    <div style="position:relative;">
                        <select wire:model.live="selectedPeriodId" class="ac-input" style="padding-left:40px; height:48px; border-radius:12px; font-weight:700;">
                            <option value="">-- Choose Period --</option>
                            @foreach($periods as $period)
                                <option value="{{ $period['id'] }}">{{ $period['name'] }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-calendar-alt" style="position:absolute; left:16px; top:16px; color:var(--blue); opacity:0.6;"></i>
                    </div>
                </div>

                <div style="flex:1; max-width:400px;">
                    <label class="ac-label" style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--ink4);">Quick Search</label>
                    <div style="position:relative;">
                        <input type="text" wire:model.live.debounce.300ms="search" class="ac-input" style="padding-left:40px; height:48px; border-radius:12px;" placeholder="Search name or employee code...">
                        <i class="fas fa-search" style="position:absolute; left:16px; top:16px; color:var(--ink4);"></i>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <button wire:click="exportExcel" class="ac-btn-outline" style="height:48px; border-radius:12px; padding:0 20px; border:1px solid var(--blue-brd); background:var(--white);">
                    <i class="fas fa-file-excel" style="margin-right:8px; color:#1D6F42;"></i> Export
                </button>
                
                <button wire:click="calculateAll" wire:loading.attr="disabled" class="custom-btn-blue">
                    <span wire:loading.remove><i class="fas fa-sync-alt" style="margin-right:8px;"></i> Recalculate All</span>
                    <span wire:loading><i class="fas fa-circle-notch fa-spin"></i> Processing...</span>
                </button>

                <button wire:click="generatePayslips" class="custom-btn-gradient">
                    <i class="fas fa-envelope-open-text" style="margin-right:8px;"></i> Generate Payslips
                </button>

                <button wire:click="$set('showCreateModal', true)" class="ac-btn-outline" style="height:48px; width:48px; border-radius:12px; padding:0; display:flex; align-items:center; justify-content:center; border:1px solid var(--indigo-brd); color:var(--indigo);">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <!-- MATRIX TABLE -->
        <div class="matrix-scroll-container">
            <table class="ac-table" style="font-size:12px; border-spacing:0; border-collapse:separate;">
                <thead>
                    <tr style="background:var(--bg2);">
                        <th style="padding-left:24px; min-width:90px; position:sticky; left:0; background:var(--bg2); z-index:11; border-bottom:2px solid var(--border);">CODE</th>
                        <th style="min-width:190px; position:sticky; left:90px; background:var(--bg2); z-index:11; border-bottom:2px solid var(--border);">FULL NAME</th>
                        <th style="min-width:140px; border-bottom:2px solid var(--border);">POSITION</th>
                        <th style="min-width:120px; border-bottom:2px solid var(--border);">BANK</th>
                        <th style="min-width:150px; border-bottom:2px solid var(--border);">ACCOUNT</th>
                        <th style="min-width:100px; border-bottom:2px solid var(--border);">DAYS</th>
                        <th style="min-width:135px; background:rgba(59,111,232,0.04); border-bottom:2px solid var(--border);">BASIC SALARY</th>
                        <th style="min-width:125px; border-bottom:2px solid var(--border);">HOUSE ALL.</th>
                        <th style="min-width:125px; border-bottom:2px solid var(--border);">TRANS. ALL.</th>
                        <th style="min-width:125px; border-bottom:2px solid var(--border);">OTHER ALL.</th>
                        <th style="min-width:145px; font-weight:800; color:var(--ink); border-bottom:2px solid var(--border);">GROSS PAY</th>
                        <th style="min-width:115px; color:var(--red); border-bottom:2px solid var(--border);">PAYE</th>
                        <th style="min-width:115px; color:var(--red); border-bottom:2px solid var(--border);">RSSB (3%)</th>
                        <th style="min-width:115px; color:var(--ink4); border-bottom:2px solid var(--border);">RSSB (5%)</th>
                        <th style="min-width:115px; color:var(--red); border-bottom:2px solid var(--border);">MATERNITY</th>
                        <th style="min-width:140px; color:var(--red); font-weight:700; border-bottom:2px solid var(--border);">DEDUCTIONS</th>
                        <th style="min-width:140px; color:var(--amber); border-bottom:2px solid var(--border);">BEFORE CBHI</th>
                        <th style="min-width:115px; color:var(--red); border-bottom:2px solid var(--border);">CBHI (4.5%)</th>
                        <th style="min-width:130px; border-bottom:2px solid var(--border);">ADVANCE</th>
                        <th style="min-width:160px; font-weight:900; color:var(--blue); font-size:13px; text-align:right; padding-right:24px; background:rgba(59,111,232,0.04); border-bottom:2px solid var(--border);">NET PAY RWF</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                        <tr wire:key="row-{{ $entry->id }}" class="matrix-row">
                            <td style="padding-left:24px; font-weight:700; position:sticky; left:0; background:inherit; z-index:5;">{{ $entry->employee_code }}</td>
                            <td style="font-weight:800; position:sticky; left:90px; background:inherit; z-index:5;">{{ $entry->employee_name }}</td>
                            <td style="font-size:11px; font-weight:600; color:var(--ink3);">{{ $entry->position ?? '—' }}</td>
                            <td style="font-size:11px; color:var(--ink3);">{{ $entry->bank_name ?? '—' }}</td>
                            <td style="font-family:'Sora'; color:var(--ink2);">{{ $entry->bank_account ?? '—' }}</td>
                            <td style="text-align:center; font-weight:700;">{{ $entry->present_days }}</td>
                            <td style="background:rgba(59,111,232,0.01);">
                                <input type="number" wire:change="updateEntry('{{ $entry->id }}', 'basic_salary', $event.target.value)" value="{{ (float)$entry->basic_salary }}" class="matrix-field-input">
                            </td>
                            <td><input type="number" wire:change="updateEntry('{{ $entry->id }}', 'house_allowance', $event.target.value)" value="{{ (float)$entry->house_allowance }}" class="matrix-field-input"></td>
                            <td><input type="number" wire:change="updateEntry('{{ $entry->id }}', 'transport_allowance', $event.target.value)" value="{{ (float)$entry->transport_allowance }}" class="matrix-field-input"></td>
                            <td><input type="number" wire:change="updateEntry('{{ $entry->id }}', 'other_allowances', $event.target.value)" value="{{ (float)$entry->other_allowances }}" class="matrix-field-input"></td>
                            <td style="font-weight:900; background:rgba(59,111,232,0.02);">{{ number_format($entry->gross_pay, 0) }}</td>
                            <td style="color:var(--red); font-weight:600;">{{ number_format($entry->paye_tax, 0) }}</td>
                            <td style="color:var(--red);">{{ number_format($entry->rssb_employee, 0) }}</td>
                            <td style="color:var(--ink4); font-size:10px;">{{ number_format($entry->rssb_employer, 0) }}</td>
                            <td style="color:var(--red);">{{ number_format($entry->maternity_fund, 0) }}</td>
                            <td style="color:var(--red); font-weight:800;">{{ number_format($entry->total_deductions, 0) }}</td>
                            <td style="color:var(--amber); font-weight:800;">{{ number_format($entry->net_before_cbhi, 0) }}</td>
                            <td style="color:var(--red);">{{ number_format($entry->cbhi, 0) }}</td>
                            <td><input type="number" wire:change="updateEntry('{{ $entry->id }}', 'salary_advance', $event.target.value)" value="{{ (float)$entry->salary_advance }}" class="matrix-field-input" style="background:rgba(245,158,11,0.04);"></td>
                            <td style="padding-right:24px; text-align:right; font-weight:900; color:var(--blue); font-size:15px; background:rgba(59,111,232,0.06); box-shadow:inset -1px 0 0 var(--blue-brd);">
                                {{ number_format($entry->net_pay, 0) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" style="padding:80px; text-align:center; background:var(--white);">
                                <div style="font-size:32px; color:var(--ink4); margin-bottom:16px;"><i class="fas fa-file-invoice-dollar"></i></div>
                                <div style="font-weight:800; color:var(--ink2); font-size:18px;">No payroll records found.</div>
                                <p style="color:var(--ink4); margin-top:8px;">Initiate a new period to start the Rwanda statutory calculation.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:32px; display:flex; justify-content:center;">
            {{ $entries->links() }}
        </div>
    </div>

    <!-- MODAL -->
    @if($showCreateModal)
        <div style="position:fixed; inset:0; background:rgba(15,22,41,0.6); backdrop-filter:blur(8px); display:flex; align-items:center; justify-content:center; z-index:1000;">
            <div class="ac-card" style="width:480px; padding:40px; border-radius:24px; box-shadow:var(--sh-lg);">
                <div style="text-align:center; margin-bottom:32px;">
                    <div style="width:64px; height:64px; background:var(--blue-lt); color:var(--blue); border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px;">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h2 style="font-family:'Sora'; font-weight:900; font-size:22px;">Initiate Period</h2>
                    <p style="color:var(--ink4); font-size:14px;">Setup a new calculation cycle for the team.</p>
                </div>
                
                <div style="display:flex; flex-direction:column; gap:20px;">
                    <div>
                        <label class="ac-label">Period Description</label>
                        <input type="text" wire:model="newPeriodName" class="ac-input" style="height:48px; border-radius:12px;" placeholder="e.g. May 2026 Monthly Payroll">
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div>
                            <label class="ac-label">Start Date</label>
                            <input type="date" wire:model="newStartDate" class="ac-input" style="height:48px; border-radius:12px;">
                        </div>
                        <div>
                            <label class="ac-label">End Date</label>
                            <input type="date" wire:model="newEndDate" class="ac-input" style="height:48px; border-radius:12px;">
                        </div>
                    </div>
                    <div style="display:flex; gap:12px; margin-top:12px;">
                        <button wire:click="$set('showCreateModal', false)" class="ac-btn-outline" style="flex:1; height:48px; border-radius:12px;">Dismiss</button>
                        <button wire:click="initiatePayroll" class="ac-btn" style="flex:2; height:48px; border-radius:12px; background:var(--blue); border:none; box-shadow:0 4px 14px rgba(59,111,232,0.4);">Launch Period</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .matrix-scroll-container {
            overflow-x: auto;
            max-width: 100%;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            background: var(--white);
        }

        .matrix-row {
            background: var(--white);
            transition: all 0.1s;
        }

        .matrix-row:hover {
            background: rgba(59,111,232,0.03) !important;
        }

        .matrix-field-input {
            width: 100%;
            border: 1px solid transparent;
            background: transparent;
            padding: 8px 12px;
            border-radius: 8px;
            font-family: 'Sora';
            font-size: 13px;
            font-weight: 700;
            color: var(--ink2);
            text-align: right;
            transition: all 0.2s;
        }

        .matrix-field-input:hover {
            background: rgba(59,111,232,0.06);
            border-color: var(--blue-brd);
        }

        .matrix-field-input:focus {
            background: var(--white);
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(59,111,232,0.1);
            outline: none;
            color: var(--blue);
        }

        .custom-btn-blue {
            height: 48px;
            border-radius: 12px;
            padding: 0 24px;
            background: #2D4ED3;
            color: #fff;
            border: none;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(45, 78, 211, 0.25);
            transition: all 0.2s;
        }

        .custom-btn-blue:hover {
            background: #1E3BB1;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(45, 78, 211, 0.35);
        }

        .custom-btn-gradient {
            height: 48px;
            border-radius: 12px;
            padding: 0 24px;
            background: linear-gradient(135deg, #6B4FDB 0%, #3B6FE8 100%);
            color: #fff;
            border: none;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(107, 79, 219, 0.35);
            transition: all 0.2s;
        }

        .custom-btn-gradient:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(107, 79, 219, 0.45);
        }
        
        .ac-table th {
            padding: 16px 12px;
            letter-spacing: 0.05em;
            color: var(--ink3);
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 800;
        }

        .ac-table td {
            padding: 4px 8px;
            border-bottom: 1px solid rgba(15,22,41,0.04);
        }
    </style>
</div>
