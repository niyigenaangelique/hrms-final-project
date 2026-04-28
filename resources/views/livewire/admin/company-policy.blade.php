<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Company Policy Setup</div>
            <div class="ac-hero-sub">Attendance rules, overtime multipliers, and leave logic</div>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="saveSettings">
                Save All Changes
            </button>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="ac-card">
        <div class="ac-card-hd" style="padding:0; border-bottom:none;">
            <div style="display:flex; padding:0 24px;">
                <div class="ac-btn {{ $activeTab === 'general' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'general' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'general' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'general')">General Policies</div>
                <div class="ac-btn {{ $activeTab === 'leave_types' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'leave_types' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'leave_types' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'leave_types')">Leave Types</div>
            </div>
        </div>

        <div style="padding:24px; border-top:1px solid var(--border);">
            @if($activeTab === 'general')
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px; max-width:900px;">
                    <div class="ac-field">
                        <label>Attendance Grace Period (Minutes)</label>
                        <input type="number" wire:model="grace_period" placeholder="15">
                        <div style="font-size:11px; color:var(--ink4);">Allowed lateness before penalty</div>
                    </div>
                    <div class="ac-field">
                        <label>Overtime Multiplier (x)</label>
                        <input type="number" step="0.1" wire:model="ot_multiplier" placeholder="1.5">
                        <div style="font-size:11px; color:var(--ink4);">Calculation factor for extra hours</div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'leave_types')
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <div class="ac-card-title">Leave Classification Matrix</div>
                    <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="openLeaveModal">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Define New Type
                    </button>
                </div>
                <div class="ac-table-wrap">
                    <table class="ac-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Allowance</th>
                                <th>Remuneration</th>
                                <th>Protocol</th>
                                <th>Status</th>
                                <th style="text-align:right;">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveTypes as $leave)
                                <tr>
                                    <td><div style="font-weight:800; color:var(--ink);">{{ $leave->name }}</div></td>
                                    <td><span style="font-family:'Sora',sans-serif; font-weight:700;">{{ $leave->default_days }}</span> <span style="font-size:11px; color:var(--ink4);">Days/Year</span></td>
                                    <td>
                                        @if($leave->is_paid) <span class="ac-badge ab-teal">PAID</span>
                                        @else <span class="ac-badge ab-red">UNPAID</span> @endif
                                    </td>
                                    <td>
                                        <div style="font-size:12px; font-weight:600; color:var(--ink3);">
                                            {{ $leave->requires_approval ? 'Approval Required' : 'Self-Certified' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($leave->is_active) <span class="ac-badge ab-green">ACTIVE</span>
                                        @else <span class="ac-badge ab-red">INACTIVE</span> @endif
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                                            <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="openLeaveModal('{{ $leave->id }}')">Edit</button>
                                            <button class="ac-btn ac-btn-ghost ac-btn-sm" style="color:var(--red);" wire:click="deleteLeaveType('{{ $leave->id }}')">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6"><div class="ac-empty">No leave categories defined.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ── MODAL ── --}}
    @if($showLeaveModal)
        <div class="ac-modal-bg" wire:click.self="closeLeaveModal">
            <div class="ac-modal" style="max-width:500px;">
                <div class="ac-modal-hd">
                    <div class="ac-modal-ttl">{{ $editingLeaveId ? 'Update' : 'Register' }} Leave Category</div>
                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="closeLeaveModal" style="padding:4px;">&times;</button>
                </div>
                <div class="ac-modal-body" style="display:flex; flex-direction:column; gap:20px;">
                    <div class="ac-field">
                        <label>Category Name</label>
                        <input type="text" wire:model="leave_name" placeholder="e.g. Annual Leave">
                        @error('leave_name')<span style="color:var(--red); font-size:11px; font-weight:700;">{{$message}}</span>@enderror
                    </div>
                    
                    <div class="ac-field">
                        <label>Default Allowance (Days)</label>
                        <input type="number" wire:model="leave_default_days">
                        @error('leave_default_days')<span style="color:var(--red); font-size:11px; font-weight:700;">{{$message}}</span>@enderror
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                            <input type="checkbox" wire:model="leave_is_paid" style="width:18px; height:18px; border-radius:4px;">
                            <span style="font-size:13px; font-weight:700; color:var(--ink2);">Paid Leave</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                            <input type="checkbox" wire:model="leave_requires_approval" style="width:18px; height:18px; border-radius:4px;">
                            <span style="font-size:13px; font-weight:700; color:var(--ink2);">Req. Approval</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; cursor:pointer; grid-column:span 2;">
                            <input type="checkbox" wire:model="leave_is_active" style="width:18px; height:18px; border-radius:4px;">
                            <span style="font-size:13px; font-weight:700; color:var(--ink2);">Category is Active</span>
                        </label>
                    </div>
                </div>
                <div class="ac-modal-ft">
                    <button class="ac-btn ac-btn-ghost" wire:click="closeLeaveModal">Discard</button>
                    <button class="ac-btn ac-btn-primary" wire:click="saveLeaveType">Save Configuration</button>
                </div>
            </div>
        </div>
    @endif
</div>

