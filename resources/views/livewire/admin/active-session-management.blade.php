<x-admin-content-styles />
<div class="ac-root">
 
    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif
 
    <div class="ac-header">
        <div><div class="ac-header-title">Active Sessions</div><div class="ac-header-sub">{{ $sessions->count() }} session{{ $sessions->count() !== 1 ? 's' : '' }} active</div></div>
        <button class="ac-btn ac-btn-danger" wire:click="terminateAll" wire:confirm="Terminate all other sessions? Your current session will be preserved.">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Terminate All Others
        </button>
    </div>
 
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">Session Registry</div><div class="ac-card-sub">All authenticated sessions on this server</div></div>
        </div>
        @if($sessions->isEmpty())
            <div class="ac-empty">
                <div class="ac-empty-icon"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/></svg></div>
                <div class="ac-empty-ttl">No sessions found</div>
                <div class="ac-empty-sub">Set SESSION_DRIVER=database in .env and run php artisan session:table && php artisan migrate</div>
            </div>
        @else
            @foreach($sessions as $sess)
            <div class="ac-sess-row">
                <div style="display:flex;align-items:center;gap:12px;flex:1;">
                    <div style="width:36px;height:36px;border-radius:10px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--ink4)" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div>
                        <div class="ac-sess-ip">{{ $sess->ip_address ?? '—' }}</div>
                        <div class="ac-sess-time">Last active {{ $sess->last_activity_human ?? '—' }}</div>
                    </div>
                </div>
                @if($sess->is_current ?? false)
                    <span class="ac-current-pill">Current Session</span>
                @else
                    <button class="ac-btn ac-btn-danger ac-btn-sm"
                        wire:click="terminateSession('{{ $sess->id }}')"
                        wire:confirm="Terminate this session? The user will be logged out immediately.">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Terminate
                    </button>
                @endif
            </div>
            @endforeach
        @endif
    </div>
</div>
 
