<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">System Configuration</div>
            <div class="ac-hero-sub">Global settings for payroll, statutory rates, and company parameters</div>
        </div>
        <div style="background:rgba(255,255,255,0.1); padding:10px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.2); display:flex; gap:12px; align-items:center;">
             <svg viewBox="0 0 24 24" style="width:20px; height:20px; stroke:#fff; fill:none; stroke-width:2;"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
             <span style="font-size:12px; color:#fff; font-weight:600;">Technical Settings Console</span>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div style="display:flex; gap:8px; margin-bottom:24px; background:var(--white); padding:6px; border-radius:16px; border:1.5px solid var(--border); width:fit-content; overflow-x:auto; max-width:100%;">
        @foreach(['company_info'=>'Company','payroll'=>'Payroll','working_days'=>'Calendar','tax_brackets'=>'Taxation','holidays'=>'Holidays'] as $val => $lbl)
            <button wire:click="$set('activeTab', '{{ $val }}')" style="border:none; padding:10px 24px; border-radius:12px; font-size:13px; font-weight:700; cursor:pointer; transition:0.2s; white-space:nowrap; {{ $activeTab === $val ? 'background:var(--blue); color:#fff; box-shadow:var(--sh-sm);' : 'background:transparent; color:var(--ink3);' }}">{{ $lbl }}</button>
        @endforeach
    </div>

    {{-- ── CONTENT ── --}}
    <div class="ac-card">
        @if($activeTab === 'company_info')
            <div style="padding:40px; max-width:600px;">
                <div class="ac-card-title" style="margin-bottom:32px;">Company Identity</div>
                <div style="display:flex; flex-direction:column; gap:24px;">
                    <div class="ac-field"><label>Legal Entity Name</label><input type="text" wire:model="company_name"></div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                        <div class="ac-field"><label>Official Email</label><input type="email" wire:model="company_email"></div>
                        <div class="ac-field"><label>Contact Phone</label><input type="text" wire:model="company_phone"></div>
                    </div>
                    <div class="ac-field"><label>Physical Address</label><textarea wire:model="company_address" rows="3"></textarea></div>
                    <button class="ac-btn ac-btn-primary" wire:click="saveSettings" style="width:fit-content; padding:12px 32px;">Update Identity</button>
                </div>
            </div>
        @endif

        @if($activeTab === 'payroll')
            <div style="padding:40px; max-width:600px;">
                <div class="ac-card-title" style="margin-bottom:32px;">Statutory Rates & Contributions</div>
                <div style="display:flex; flex-direction:column; gap:24px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                        <div class="ac-field"><label>RSSB Employer (%)</label><input type="number" step="0.1" wire:model="rssb_employer_rate"></div>
                        <div class="ac-field"><label>RSSB Employee (%)</label><input type="number" step="0.1" wire:model="rssb_employee_rate"></div>
                    </div>
                    <div class="ac-field"><label>Maternity Fund Employer (%)</label><input type="number" step="0.1" wire:model="maternity_employer_rate"></div>
                    <button class="ac-btn ac-btn-primary" wire:click="saveSettings" style="width:fit-content; padding:12px 32px;">Update Rates</button>
                </div>
            </div>
        @endif

        @if($activeTab === 'working_days')
            <div style="padding:40px; max-width:600px;">
                <div class="ac-card-title" style="margin-bottom:12px;">Standard Work Week</div>
                <p style="color:var(--ink3); font-size:13px; margin-bottom:32px;">Define which days are considered billable working days for attendance and payroll.</p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                        <label style="display:flex; align-items:center; gap:12px; padding:16px; border-radius:12px; border:1.5px solid var(--border); cursor:pointer;">
                            <input type="checkbox" wire:model="work_{{ $day }}" style="width:18px; height:18px;">
                            <span style="font-size:14px; font-weight:700; color:var(--ink2);">{{ ucfirst($day) }}</span>
                        </label>
                    @endforeach
                </div>
                <button class="ac-btn ac-btn-primary" wire:click="saveSettings" style="margin-top:32px; padding:12px 32px;">Save Calendar</button>
            </div>
        @endif

        @if($activeTab === 'tax_brackets')
            <div class="ac-card-hd">
                <div><div class="ac-card-title">PAYE Tax Brackets</div><div class="ac-card-sub">Statutory income tax layers</div></div>
                <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="openTaxModal">
                    <svg viewBox="0 0 24 24" style="width:14px; height:14px; stroke:#fff;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    New Bracket
                </button>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead><tr><th style="padding-left:24px;">Income Range</th><th>Rate (%)</th><th>Fixed Amount</th><th>Status</th><th style="text-align:right; padding-right:24px;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($taxBrackets as $tax)
                            <tr>
                                <td style="padding-left:24px;">
                                    <div style="font-weight:800; color:var(--ink);">{{ number_format($tax->min_income) }} — {{ $tax->max_income ? number_format($tax->max_income) : '∞' }}</div>
                                    <div style="font-size:10px; color:var(--ink4);">Monthly Gross RWF</div>
                                </td>
                                <td style="font-weight:800; color:var(--blue);">{{ $tax->rate }}%</td>
                                <td style="font-weight:600; color:var(--ink2);">{{ number_format($tax->fixed_amount) }}</td>
                                <td><span class="ac-badge {{ $tax->is_active ? 'ab-green' : 'ab-gray' }}">{{ $tax->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td style="text-align:right; padding-right:24px;">
                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="openTaxModal('{{ $tax->id }}')">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding:60px; color:var(--ink4);">No tax brackets defined.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        @if($activeTab === 'holidays')
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Public Holidays</div><div class="ac-card-sub">Company-wide non-working days</div></div>
                <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="openHolidayModal">
                    <svg viewBox="0 0 24 24" style="width:14px; height:14px; stroke:#fff;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add Holiday
                </button>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead><tr><th style="padding-left:24px;">Holiday Name</th><th>Date</th><th>Recurring</th><th style="text-align:right; padding-right:24px;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($holidays as $h)
                            <tr>
                                <td style="padding-left:24px; font-weight:800; color:var(--ink);">{{ $h->name }}</td>
                                <td style="font-weight:600; color:var(--blue);">{{ $h->date ? $h->date->format('F d, Y') : '-' }}</td>
                                <td><span class="ac-badge {{ $h->is_recurring ? 'ab-teal' : 'ab-gray' }}">{{ $h->is_recurring ? 'Yearly' : 'One-time' }}</span></td>
                                <td style="text-align:right; padding-right:24px;">
                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="openHolidayModal('{{ $h->id }}')">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center; padding:60px; color:var(--ink4);">No holidays recorded.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modals --}}
    {{-- Modals --}}
    @if($showTaxModal)
        <div class="ac-modal-bg" wire:click.self="closeTaxModal" style="z-index: 9999;">
            <div class="ac-modal" style="max-width:520px; border: none; box-shadow: var(--sh-lg);">
                <div class="ac-modal-hd" style="background: var(--bg2);">
                    <div>
                        <div class="ac-modal-ttl">{{ $editingTaxId ? 'Modify' : 'Initialize' }} Tax Bracket</div>
                        <div class="ac-modal-sub">Define statutory PAYE income thresholds</div>
                    </div>
                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="closeTaxModal" style="font-size: 20px;">&times;</button>
                </div>
                <div class="ac-modal-body" style="padding: 32px; display:flex; flex-direction:column; gap:24px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="ac-field">
                            <label>Min Monthly Income</label>
                            <input type="number" wire:model="tax_min_income" style="@error('tax_min_income') border-color:var(--red); @enderror">
                            @error('tax_min_income') <span style="font-size:10px; color:var(--red); font-weight:700;">{{ $message }}</span> @enderror
                        </div>
                        <div class="ac-field">
                            <label>Max Monthly Income</label>
                            <input type="number" wire:model="tax_max_income" placeholder="∞" style="@error('tax_max_income') border-color:var(--red); @enderror">
                            @error('tax_max_income') <span style="font-size:10px; color:var(--red); font-weight:700;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="ac-field">
                            <label>Tax Rate (%)</label>
                            <input type="number" step="0.01" wire:model="tax_rate" style="@error('tax_rate') border-color:var(--red); @enderror">
                            @error('tax_rate') <span style="font-size:10px; color:var(--red); font-weight:700;">{{ $message }}</span> @enderror
                        </div>
                        <div class="ac-field">
                            <label>Fixed Base Amount</label>
                            <input type="number" wire:model="tax_fixed_amount" style="@error('tax_fixed_amount') border-color:var(--red); @enderror">
                            @error('tax_fixed_amount') <span style="font-size:10px; color:var(--red); font-weight:700;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div style="padding: 16px; background: var(--bg2); border-radius: 12px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size:13px; font-weight:800;">Active Status</div>
                            <div style="font-size:11px; color:var(--ink4);">Apply this bracket to payroll runs</div>
                        </div>
                        <input type="checkbox" wire:model="tax_is_active" style="width:24px; height:24px; accent-color: var(--blue);">
                    </div>
                </div>
                <div class="ac-modal-ft" style="background: var(--bg2); padding: 20px 32px;">
                    <button class="ac-btn ac-btn-ghost" wire:click="closeTaxModal" wire:loading.attr="disabled">Cancel</button>
                    <button class="ac-btn ac-btn-primary" wire:click="saveTaxBracket" wire:loading.attr="disabled" style="min-width: 120px; justify-content: center;">
                        <span wire:loading.remove>Save Changes</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showHolidayModal)
        <div class="ac-modal-bg" wire:click.self="closeHolidayModal">
            <div class="ac-modal" style="max-width:480px;">
                <div class="ac-modal-hd">
                    <div><div class="ac-modal-ttl">{{ $editingHolidayId ? 'Edit' : 'New' }} Holiday</div></div>
                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="closeHolidayModal">&times;</button>
                </div>
                <div class="ac-modal-body" style="display:flex; flex-direction:column; gap:20px;">
                    <div class="ac-field"><label>Holiday Name</label><input type="text" wire:model="holiday_name"></div>
                    <div class="ac-field"><label>Calendar Date</label><input type="date" wire:model="holiday_date"></div>
                    <label style="display:flex; align-items:center; gap:10px;"><input type="checkbox" wire:model="holiday_is_recurring"> <span style="font-size:14px; font-weight:700;">Repeats every year</span></label>
                </div>
                <div class="ac-modal-ft">
                    <button class="ac-btn ac-btn-ghost" wire:click="closeHolidayModal">Cancel</button>
                    <button class="ac-btn ac-btn-primary" wire:click="saveHoliday">Save Holiday</button>
                </div>
            </div>
        </div>
    @endif
</div>
