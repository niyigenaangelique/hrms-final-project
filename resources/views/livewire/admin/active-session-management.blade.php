<div class="ac-root">
    <x-admin-content-styles />

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div style="display:flex; align-items:center; gap:24px;">
            <div class="ac-av" style="width:72px; height:72px; font-size:24px; background:rgba(255,255,255,0.25); color:#fff; border:3px solid rgba(255,255,255,0.4);">
                <svg viewBox="0 0 24 24" style="width:1.4em; height:1.4em;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="ac-hero-ttl">Session Monitoring</div>
                <div class="ac-hero-sub">Live User Connection Registry</div>
            </div>
        </div>
        <div>
            <button wire:click="terminateAll" class="ac-btn" style="background:rgba(255,255,255,0.2); color:#fff; border:1px solid rgba(255,255,255,0.3);" onclick="showTerminateAllConfirm()">
                <svg viewBox="0 0 24 24"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                Kill All Other Connections
            </button>
        </div>
    </div>

    {{-- ── ALERTS ── --}}
    @if (session()->has('success'))
        <div class="ac-flash ac-flash-ok" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── MAIN TABLE ── --}}
    <div class="ac-card">
        <div class="ac-card-hd">
            <div>
                <div class="ac-card-title">Connected Principals</div>
                <div class="ac-card-sub">Real-time session state and telemetry</div>
            </div>
            <div class="ac-badge ab-indigo">{{ count($sessions) }} Active Shards</div>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead>
                    <tr>
                        <th>Identity Hash</th>
                        <th>IP Address</th>
                        <th>Browser / OS</th>
                        <th>Last Pulse</th>
                        <th>Status</th>
                        <th>Command</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $s)
                        <tr style="{{ $s->is_current ? 'background: var(--blue-lt);' : '' }}">
                            <td>
                                <div style="font-family: monospace; font-size: 11px; color: var(--ink3);">
                                    {{ substr($s->id, 0, 16) }}...
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--ink2);">{{ $s->ip_address ?? '0.0.0.0' }}</div>
                            </td>
                            <td>
                                <div style="font-size: 12px; color: var(--ink3); max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $s->user_agent ?? 'Terminal Interface' }}
                                </div>
                            </td>
                            <td>
                                <div class="ac-user-meta">{{ $s->last_activity_human }}</div>
                            </td>
                            <td>
                                @if($s->is_current)
                                    <span class="ac-badge ab-green">CURRENT NODE</span>
                                @else
                                    <span class="ac-badge ab-teal">ACTIVE</span>
                                @endif
                            </td>
                            <td>
                                @if(!$s->is_current)
                                    <button wire:click="terminateSession('{{ $s->id }}')" class="ac-btn ac-btn-sm" style="background: var(--red-lt); color: var(--red);">
                                        Terminate
                                    </button>
                                @else
                                    <span style="font-size: 11px; font-weight: 700; color: var(--green);">Secure Connection</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="ac-empty">No active connections detected.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Include custom confirm dialog component --}}
@include('components.confirm-dialog')

<script>
function showTerminateAllConfirm() {
    showConfirmDialog({
        title: 'Terminate All Sessions',
        message: 'Are you sure you want to terminate all other active sessions? This will force all users to log out immediately.',
        confirmText: 'Terminate All',
        cancelText: 'Cancel',
        type: 'warning',
        onConfirm: function() {
            @this.terminateAll();
        }
    });
}
</script>
