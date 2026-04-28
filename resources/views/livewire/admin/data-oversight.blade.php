<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session()->has('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ session('error') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Data Integrity Oversight</div>
            <div class="ac-hero-sub">Audit inconsistencies and repair fragmented relations</div>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="syncUserStatuses">
                Global Status Sync
            </button>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="ac-card">
        <div class="ac-card-hd" style="padding:0; border-bottom:none;">
            <div style="display:flex; padding:0 24px;">
                <div class="ac-btn {{ $activeTab === 'checker' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'checker' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'checker' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'checker')">Integrity Audit</div>
                <div class="ac-btn {{ $activeTab === 'viewer' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'viewer' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'viewer' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'viewer')">Master Inspector</div>
                <div class="ac-btn {{ $activeTab === 'repair' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'repair' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'repair' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'repair')">Repair Toolkit</div>
            </div>
        </div>

        <div style="padding:24px; border-top:1px solid var(--border);">
            @if($activeTab === 'checker')
                <div style="display:grid; gap:30px;">
                    <div>
                        <div class="ac-card-title" style="margin-bottom:12px;">Unlinked Employee Entities</div>
                        <div class="ac-table-wrap">
                            <table class="ac-table">
                                <thead>
                                    <tr>
                                        <th style="padding-left:24px;">Employee Identity</th>
                                        <th>Department</th>
                                        <th>Issue Detected</th>
                                        <th style="text-align:right; padding-right:24px;">Remediation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orphanedEmployees as $emp)
                                        <tr>
                                            <td style="padding-left:24px;">
                                                <div style="font-weight:800; color:var(--ink);">{{ $emp->full_name }}</div>
                                                <div style="font-size:10px; color:var(--ink4);">CODE: {{ $emp->code }}</div>
                                            </td>
                                            <td><div style="font-size:12px; font-weight:600; color:var(--ink3);">{{ $emp->departmentAssignment ? $emp->departmentAssignment->name : 'N/A' }}</div></td>
                                            <td><span class="ac-badge ab-red">NO SYSTEM ACCOUNT</span></td>
                                            <td style="text-align:right; padding-right:24px;">
                                                <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="fixOrphanedEmployee('{{ $emp->id }}')">Provision Access</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4"><div class="ac-empty">All employees have valid system accounts.</div></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <div class="ac-card-title" style="margin-bottom:12px;">Floating User Accounts</div>
                        <div class="ac-table-wrap">
                            <table class="ac-table">
                                <thead>
                                    <tr>
                                        <th style="padding-left:24px;">Username</th>
                                        <th>Electronic Mail</th>
                                        <th>Credential Status</th>
                                        <th style="text-align:right; padding-right:24px;">Discovery Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orphanedUsers as $user)
                                        <tr>
                                            <td style="padding-left:24px;"><div style="font-weight:800; color:var(--ink);">{{ $user->username }}</div></td>
                                            <td><div style="font-size:12px; font-weight:600; color:var(--ink3);">{{ $user->email }}</div></td>
                                            <td>
                                                @if($user->is_active) <span class="ac-badge ab-teal">ACTIVE</span>
                                                @else <span class="ac-badge ab-red">LOCKED</span> @endif
                                            </td>
                                            <td style="text-align:right; padding-right:24px;">
                                                <div style="display:flex; justify-content:flex-end; gap:8px; align-items:center;">
                                                    <span style="font-size:11px; color:var(--ink4);">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'Unknown' }}</span>
                                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" style="color:var(--red);" 
                                                            onclick="showDeleteOrphanedUserConfirm('{{ $user->id }}')"
                                                            wire:click="deleteOrphanedUser('{{ $user->id }}')">
                                                        <svg viewBox="0 0 24 24" style="width:14px; height:14px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4"><div class="ac-empty">No orphaned user entities found.</div></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'viewer')
                <div style="display:flex; gap:16px; margin-bottom:24px; align-items:center;">
                    <div class="ac-field" style="width:250px; margin-bottom:0;">
                        <select wire:model.live="selectedTable">
                            <option value="users">System Users</option>
                            <option value="employees">Employee Master</option>
                            <option value="departments">Organizational Units</option>
                            <option value="projects">Project Portfolio</option>
                            <option value="leave_requests">Leave Ledger</option>
                            <option value="attendances">Entry/Exit Logs</option>
                        </select>
                    </div>
                    <div class="ac-field" style="flex:1; margin-bottom:0;">
                        <input type="text" wire:model.live.debounce.300ms="viewerSearch" placeholder="Search rows across the current object...">
                    </div>
                </div>

                <div class="ac-table-wrap" style="border:1px solid var(--border); border-radius:12px;">
                    <table class="ac-table">
                        <thead style="position:sticky; top:0; z-index:5;">
                            <tr>
                                <th style="padding-left:24px; width:150px;">Control</th>
                                @foreach($viewerColumns as $col)
                                    <th>{{ strtoupper($col) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($viewerRecords as $record)
                                <tr>
                                    <td style="padding-left:24px;">
                                        <div style="display:flex; gap:8px;">
                                            <button class="ac-btn ac-btn-ghost ac-btn-sm" style="color:var(--red); padding:4px 8px;" onclick="showForceDeleteRecordConfirm('{{ $record->id }}')" wire:click="forceDeleteRecord('{{ $record->id }}')">
                                                <svg viewBox="0 0 24 24" style="width:14px; height:14px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                            @if(isset($record->deleted_at))
                                                <button class="ac-btn ac-btn-ghost ac-btn-sm" style="color:var(--teal); padding:4px 8px;" wire:click="restoreRecord('{{ $record->id }}')">
                                                    <svg viewBox="0 0 24 24" style="width:14px; height:14px;"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    @foreach($viewerColumns as $col)
                                        <td>
                                            <div style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:12px; font-weight:600; color:var(--ink2);" title="{{ $record->$col }}">
                                                {{ $record->$col ?? 'null' }} East End
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr><td colspan="{{ count($viewerColumns) + 1 }}"><div class="ac-empty">No objects found in table: {{ $selectedTable }}</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="margin-top:24px;">
                    {{ $viewerRecords->links('pagination::simple-tailwind') }}
                </div>
            @endif

            @if($activeTab === 'repair')
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                    <div class="ac-card" style="background:var(--bg2); border:1px solid var(--border); padding:24px;">
                        <div style="width:40px; height:40px; border-radius:10px; background:var(--blue-lt); display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
                            <svg viewBox="0 0 24 24" style="width:20px; height:20px; stroke:var(--blue);"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3y-3.5"/></svg>
                        </div>
                        <div class="ac-card-title">Access Status Synchronization</div>
                        <p style="font-size:13px; color:var(--ink3); margin:12px 0 20px;">Ensures all User credentials match their Employee employment status. Locks terminated users instantly.</p>
                        <button class="ac-btn ac-btn-primary" wire:click="syncUserStatuses">Initiate Scan & Sync</button>
                    </div>

                    <div class="ac-card" style="background:var(--bg2); border:1px solid var(--border); padding:24px;">
                        <div style="width:40px; height:40px; border-radius:10px; background:var(--teal-lt); display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
                            <svg viewBox="0 0 24 24" style="width:20px; height:20px; stroke:var(--teal);"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        </div>
                        <div class="ac-card-title">Balance Drift Recalculation</div>
                        <p style="font-size:13px; color:var(--ink3); margin:12px 0 20px;">Re-process all leave histories to fix mathematical balance errors caused by edge-case overlap.</p>
                        <button class="ac-btn ac-btn-ghost" wire:click="recalculateLeaveBalances">Rebuild Balances</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Include custom confirm dialog component --}}
@include('components.confirm-dialog')

<script>
function showDeleteOrphanedUserConfirm(userId) {
    showConfirmDialog({
        title: 'Delete Orphaned User',
        message: 'Are you sure you want to permanently remove this floating user account? This action cannot be undone.',
        confirmText: 'Delete',
        cancelText: 'Cancel',
        type: 'danger',
        onConfirm: function() {
            @this.deleteOrphanedUser(userId);
        }
    });
}

function showForceDeleteRecordConfirm(recordId) {
    showConfirmDialog({
        title: 'Permanent Purge',
        message: 'Are you sure you want to permanently purge this record? This action cannot be undone.',
        confirmText: 'Purge',
        cancelText: 'Cancel',
        type: 'danger',
        onConfirm: function() {
            @this.forceDeleteRecord(recordId);
        }
    });
}
</script>

