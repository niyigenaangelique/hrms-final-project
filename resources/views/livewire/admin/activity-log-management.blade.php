<div class="ac-root">
    <x-admin-content-styles />

    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Activity Log</div>
            <div class="ac-hero-sub">{{ $total }} events recorded in the system audit trail</div>
        </div>
        <div style="background:rgba(255,255,255,0.1); padding:10px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.2); display:flex; gap:12px; align-items:center;">
             <svg viewBox="0 0 24 24" style="width:20px; height:20px; stroke:#fff; fill:none; stroke-width:2;"><path d="M21 12a9 9 0 11-6.219-8.56" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
             <span style="font-size:12px; color:#fff; font-weight:600;">Real-time monitoring active.</span>
        </div>
    </div>

    {{-- ── CONTENT ── --}}
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">System Events</div></div>
            <div style="display:flex; gap:12px; align-items:center;">
                <div class="ac-field" style="width:200px; margin:0;"><input type="text" wire:model.live.debounce.300ms="search" placeholder="Search events..." style="padding:8px 12px;"></div>
                <div class="ac-field" style="width:140px; margin:0;">
                    <select wire:model.live="filterType" style="padding:8px 12px;">
                        <option value="">All Types</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                        <option value="login">Login</option>
                    </select>
                </div>
                <div class="ac-field" style="width:140px; margin:0;"><input type="date" wire:model.live="dateFrom" style="padding:8px 12px;"></div>
                <div class="ac-field" style="width:140px; margin:0;"><input type="date" wire:model.live="dateTo" style="padding:8px 12px;"></div>
            </div>
        </div>

        @if($logs->isEmpty())
            <div class="ac-empty" style="padding:80px 20px;">
                <svg viewBox="0 0 24 24" style="width:48px; height:48px; stroke:var(--ink4); opacity:0.3; margin-bottom:16px;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <div class="ac-empty-ttl">No activity logs found</div>
                <div class="ac-empty-sub">Adjust your filters or check back later for new events.</div>
            </div>
        @else
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead><tr><th style="padding-left:24px;">Event Type</th><th>Description</th><th>Subject / ID</th><th>Network</th><th style="text-align:right; padding-right:24px;">Timestamp</th></tr></thead>
                    <tbody>
                    @foreach($logs as $log)
                    @php
                        $ev = $log->event ?? 'system';
                        $eCls = match(true) { str_contains($ev,'create')=>'ab-green',str_contains($ev,'delete')=>'ab-red',str_contains($ev,'update')=>'ab-blue',str_contains($ev,'login')=>'ab-indigo', default=>'ab-gray' };
                    @endphp
                    <tr>
                        <td style="padding-left:24px;"><span class="ac-badge {{ $eCls }}" style="font-size:10px;">{{ strtoupper($ev) }}</span></td>
                        <td style="max-width:350px; white-space:normal; line-height:1.5; font-size:13px; font-weight:600; color:var(--ink2);">{{ $log->description ?? '—' }}</td>
                        <td style="font-size:12px; color:var(--ink4);">{{ $log->causer_id ? 'UID: '.$log->causer_id : 'SYSTEM' }}</td>
                        <td style="font-family:'Sora',sans-serif; font-size:11px; color:var(--blue); font-weight:700;">{{ $log->ip_address ?? '0.0.0.0' }}</td>
                        <td style="text-align:right; padding-right:24px; font-size:12px; color:var(--ink4); font-weight:600;">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, H:i') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div style="padding:16px 24px; border-top:1px solid var(--border);">
                {{ $logs->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
 
