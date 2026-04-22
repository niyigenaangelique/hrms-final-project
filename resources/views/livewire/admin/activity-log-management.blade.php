<x-admin-content-styles />
<div class="ac-root">
 
    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
 
    <div class="ac-header">
        <div><div class="ac-header-title">Activity Log</div><div class="ac-header-sub">{{ $total }} events recorded</div></div>
    </div>
 
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">System Events</div></div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <div class="ac-search">
                    <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input wire:model.live.debounce.300ms="search" placeholder="Search events…">
                </div>
                <select class="ac-sel" wire:model.live="filterType">
                    <option value="">All Events</option>
                    <option value="create">Create</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                </select>
                <input type="date" wire:model.live="dateFrom" style="background:var(--bg);border:1.5px solid var(--border);border-radius:var(--r);padding:7px 11px;color:var(--ink);font-family:'DM Sans',sans-serif;font-size:13px;outline:none;">
                <input type="date" wire:model.live="dateTo"   style="background:var(--bg);border:1.5px solid var(--border);border-radius:var(--r);padding:7px 11px;color:var(--ink);font-family:'DM Sans',sans-serif;font-size:13px;outline:none;">
            </div>
        </div>
 
        @if($logs->isEmpty())
            <div class="ac-empty">
                <div class="ac-empty-icon"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div class="ac-empty-ttl">No activity logs found</div>
                <div class="ac-empty-sub">Install spatie/laravel-activitylog or use the AuditLogger service to populate this view.</div>
            </div>
        @else
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead><tr><th>Event</th><th>Description</th><th>User</th><th>IP</th><th>Time</th></tr></thead>
                    <tbody>
                    @foreach($logs as $log)
                    @php
                        $ev   = $log->event ?? 'system';
                        $eCls = match(true) { str_contains($ev,'create')=>'ab-green',str_contains($ev,'delete')=>'ab-red',str_contains($ev,'update')=>'ab-blue',str_contains($ev,'login')=>'ab-indigo', default=>'ab-gray' };
                    @endphp
                    <tr>
                        <td><span class="ac-badge {{ $eCls }}">{{ strtoupper($ev) }}</span></td>
                        <td style="max-width:300px;white-space:normal;line-height:1.5;font-size:12.5px;">{{ $log->description ?? '—' }}</td>
                        <td style="font-size:12px;color:var(--ink3);">{{ $log->causer_id ? Str::limit($log->causer_id,12) : '—' }}</td>
                        <td style="font-family:'DM Mono',monospace;font-size:12px;color:var(--teal);">{{ $log->ip_address ?? '—' }}</td>
                        <td style="font-size:12px;color:var(--ink4);white-space:nowrap;">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, H:i') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="ac-pager">
                <div class="ac-pager-info">{{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }}</div>
                {{ $logs->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
 
