<div class="ac-root">
    <x-admin-content-styles />

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Admin Report Builder</div>
            <div class="ac-hero-sub">Generate unique system audits and security compliance reports</div>
        </div>
        <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="generatePdf" wire:loading.attr="disabled">
            <svg viewBox="0 0 24 24" wire:loading.remove style="stroke:#fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span wire:loading.remove style="color:#fff;">Export PDF</span>
            <span wire:loading style="color:#fff;">Generating...</span>
        </button>
    </div>

    <div style="display:grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start;">
        {{-- Configuration --}}
        <div class="ac-card">
            <div class="ac-card-hd"><div class="ac-card-title">Report Settings</div></div>
            <div style="padding:20px; display:flex; flex-direction:column; gap:16px;">
                <div class="ac-field">
                    <label>Report Type</label>
                    <select wire:model.live="reportCategory">
                        <option value="users">User Accounts List</option>
                        <option value="security">Security Audit (Logins/Fails)</option>
                        <option value="activity">System Activity Logs</option>
                        <option value="governance">Permission Matrix Audit</option>
                    </select>
                </div>
                <div class="ac-field">
                    <label>Start Date</label>
                    <input type="date" wire:model.live="startDate">
                </div>
                <div class="ac-field">
                    <label>End Date</label>
                    <input type="date" wire:model.live="endDate">
                </div>
                <div class="ac-field">
                    <label>Record Limit</label>
                    <select wire:model.live="limit">
                        <option value="50">Last 50 records</option>
                        <option value="100">Last 100 records</option>
                        <option value="500">Last 500 records</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div class="ac-card-title">Data Preview</div>
                <div class="ac-card-sub">Showing first 10 matching records</div>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        @if($reportCategory === 'users')
                            <tr><th>Identity</th><th>Role</th><th>Status</th><th>Created</th></tr>
                        @elseif($reportCategory === 'security' || $reportCategory === 'activity')
                            <tr><th>Timestamp</th><th>Action</th><th>User</th></tr>
                        @else
                            <tr><th>Role</th><th>Permission</th><th>Status</th></tr>
                        @endif
                    </thead>
                    <tbody>
                        @forelse($previewData as $item)
                            @if($reportCategory === 'users')
                                <tr>
                                    <td><strong>{{ $item->first_name }} {{ $item->last_name }}</strong><br><small>{{ $item->email }}</small></td>
                                    <td><span class="ac-badge ab-indigo">{{ $item->role }}</span></td>
                                    <td><span class="ac-badge {{ $item->is_active ? 'ab-green' : 'ab-red' }}">{{ $item->is_active ? 'Active' : 'Locked' }}</span></td>
                                    <td>{{ $item->created_at->format('M d, Y') }}</td>
                                </tr>
                            @elseif($reportCategory === 'security' || $reportCategory === 'activity')
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</td>
                                    <td><span class="ac-badge ab-teal">{{ $item->action }}</span></td>
                                    <td>User #{{ $item->user_id ?? 'Anon' }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $item->role }}</td>
                                    <td>{{ $item->permission }}</td>
                                    <td><span class="ac-badge {{ $item->allowed ? 'ab-green' : 'ab-red' }}">{{ $item->allowed ? 'Allowed' : 'Denied' }}</span></td>
                                </tr>
                            @endif
                        @empty
                            <tr><td colspan="4" style="text-align:center; padding:40px; color:var(--ac-ink4);">No records found for the selected criteria.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
