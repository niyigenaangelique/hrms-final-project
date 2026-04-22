{{--
    notification-bell.blade.php
    Drop-in notification bell widget for Employee, HR and Admin layouts.
    Usage: @livewire('notification-bell')
    Shows unread count, drop-down feed, mark-read, quick send (HR/Admin only).
--}}
<div class="nb-wrap" x-data="{ open: false }" @click.outside="open = false" style="position:relative;display:inline-flex;">

<style>
.nb-wrap{--blue:#3B6FE8;--blue-lt:rgba(59,111,232,0.09);--blue-mid:rgba(59,111,232,0.18);--blue-brd:rgba(59,111,232,0.22);--green:#12B76A;--green-lt:rgba(18,183,106,0.10);--amber:#F59E0B;--amber-lt:rgba(245,158,11,0.10);--red:#EF4444;--red-lt:rgba(239,68,68,0.09);--purple:#7C3AED;--purple-lt:rgba(124,58,237,0.09);--bg:#F0F4FA;--white:#fff;--ink:#0F1629;--ink2:#2D3356;--ink3:#6B7094;--ink4:#A8ADCA;--border:rgba(15,22,41,0.08);font-family:'DM Sans',-apple-system,sans-serif;}
/* Bell button */
.nb-btn{width:38px;height:38px;border-radius:11px;border:1px solid var(--border);background:var(--white);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:all .15s;}
.nb-btn:hover{background:var(--blue-lt);border-color:var(--blue-brd);}
.nb-btn svg{width:18px;height:18px;stroke:var(--ink3);fill:none;stroke-width:1.75;transition:stroke .15s;}
.nb-btn:hover svg{stroke:var(--blue);}
.nb-count{position:absolute;top:-5px;right:-5px;min-width:18px;height:18px;background:var(--red);color:#fff;border-radius:100px;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 4px;border:2px solid var(--white);font-family:'Sora',sans-serif;}
/* Dropdown panel */
.nb-panel{position:absolute;top:calc(100% + 10px);right:0;width:380px;background:var(--white);border:1px solid var(--border);border-radius:18px;box-shadow:0 20px 60px rgba(15,22,41,0.18);z-index:9000;overflow:hidden;display:flex;flex-direction:column;max-height:540px;}
.nb-panel-hd{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:#FAFBFF;flex-shrink:0;}
.nb-panel-title{font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--ink);}
.nb-panel-actions{display:flex;gap:6px;}
.nb-panel-btn{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:7px;font-size:11.5px;font-weight:700;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .12s;}
.nb-panel-btn svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;}
.nb-pb-ghost{background:var(--blue-lt);color:var(--blue);border:1px solid var(--blue-brd);}
.nb-pb-ghost:hover{background:var(--blue-mid);}
/* Filter tabs */
.nb-ftabs{display:flex;gap:2px;padding:8px 12px;border-bottom:1px solid var(--border);flex-shrink:0;background:var(--white);}
.nb-ftab{padding:4px 12px;border-radius:8px;font-size:11.5px;font-weight:700;cursor:pointer;border:none;background:transparent;color:var(--ink4);font-family:'DM Sans',sans-serif;transition:all .12s;}
.nb-ftab:hover{background:var(--bg);color:var(--ink3);}
.nb-ftab.active{background:var(--blue);color:#fff;}
.nb-ftab-count{background:rgba(255,255,255,0.3);color:inherit;font-size:9.5px;padding:0 5px;border-radius:100px;margin-left:3px;}
.nb-ftab:not(.active) .nb-ftab-count{background:var(--red-lt);color:var(--red);}
/* Notif items */
.nb-list{overflow-y:auto;flex:1;}
.nb-item{display:flex;align-items:flex-start;gap:10px;padding:11px 16px;border-bottom:1px solid var(--border);cursor:default;transition:background .12s;position:relative;}
.nb-item:last-child{border-bottom:none;}
.nb-item:hover{background:#F8FAFF;}
.nb-item.unread{background:rgba(59,111,232,0.03);}
.nb-item.unread::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--blue);border-radius:0 2px 2px 0;}
.nb-item-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.nb-item-icon svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;}
.nb-item-body{flex:1;min-width:0;}
.nb-item-title{font-size:13px;font-weight:700;color:var(--ink);margin-bottom:2px;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.nb-item-msg{font-size:11.5px;color:var(--ink3);line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.nb-item-time{font-size:10px;color:var(--ink4);margin-top:4px;display:flex;align-items:center;gap:5px;}
.nb-prio{width:6px;height:6px;border-radius:50%;flex-shrink:0;}
.nb-item-actions{display:flex;flex-direction:column;gap:3px;flex-shrink:0;}
.nb-ia-btn{width:22px;height:22px;border-radius:6px;border:none;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .12s;}
.nb-ia-btn:hover{background:var(--bg);}
.nb-ia-btn svg{width:11px;height:11px;stroke:var(--ink4);fill:none;stroke-width:2;}
/* Empty */
.nb-empty{text-align:center;padding:36px 20px;}
.nb-empty svg{width:32px;height:32px;stroke:var(--ink4);fill:none;stroke-width:1.5;margin:0 auto 10px;display:block;opacity:.4;}
.nb-empty p{font-size:13px;font-weight:600;color:var(--ink3);margin:0;}
.nb-empty span{font-size:11.5px;color:var(--ink4);}
/* Footer */
.nb-panel-ft{padding:10px 16px;border-top:1px solid var(--border);background:#FAFBFF;flex-shrink:0;display:flex;justify-content:center;}
.nb-ft-link{font-size:12.5px;font-weight:700;color:var(--blue);text-decoration:none;display:inline-flex;align-items:center;gap:4px;}
.nb-ft-link svg{width:11px;height:11px;stroke:var(--blue);fill:none;stroke-width:2.5;}
.nb-ft-link:hover{text-decoration:underline;}
@media(max-width:440px){.nb-panel{width:320px;right:-80px;}}
</style>

{{-- Bell trigger --}}
<button class="nb-btn" @click="open = !open" wire:click="loadNotifications" title="Notifications">
    <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    @if($unreadCount > 0)<span class="nb-count">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>@endif
</button>

{{-- Drop-down panel --}}
<div class="nb-panel" x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" style="display:none;">

    <div class="nb-panel-hd">
        <div class="nb-panel-title">
            Notifications
            @if($unreadCount > 0)<span style="font-size:11px;background:var(--red-lt);color:var(--red);padding:2px 8px;border-radius:100px;margin-left:6px;font-weight:800;">{{ $unreadCount }} new</span>@endif
        </div>
        <div class="nb-panel-actions">
            @if($unreadCount > 0)
                <button class="nb-panel-btn nb-pb-ghost" wire:click="markAllRead">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    All read
                </button>
            @endif
            @if($isHrOrAdmin)
                <a href="{{ route('hr.notifications') }}" class="nb-panel-btn nb-pb-ghost" style="text-decoration:none;">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82"/></svg>
                    Manage
                </a>
            @endif
        </div>
    </div>

    {{-- Filter tabs --}}
    <div class="nb-ftabs">
        <button wire:click="$set('filterTab','all')" class="nb-ftab {{ $filterTab==='all'?'active':'' }}">
            All @if($totalCount > 0)<span class="nb-ftab-count">{{ $totalCount }}</span>@endif
        </button>
        <button wire:click="$set('filterTab','unread')" class="nb-ftab {{ $filterTab==='unread'?'active':'' }}">
            Unread @if($unreadCount > 0)<span class="nb-ftab-count">{{ $unreadCount }}</span>@endif
        </button>
        <button wire:click="$set('filterTab','pay')" class="nb-ftab {{ $filterTab==='pay'?'active':'' }}">Pay</button>
        <button wire:click="$set('filterTab','leave')" class="nb-ftab {{ $filterTab==='leave'?'active':'' }}">Leave</button>
        <button wire:click="$set('filterTab','contract')" class="nb-ftab {{ $filterTab==='contract'?'active':'' }}">Contract</button>
    </div>

    <div class="nb-list">
        @forelse($notifications as $notif)
            @php
                $prio = $notif->priority ?? 'normal';
                $prioBg = match($prio){'urgent'=>'var(--red)','high'=>'var(--amber)','low'=>'var(--ink4)',default=>'var(--blue)'};
                $typeColors = ['pay_reminder'=>'#12B76A','contract_expiry'=>'#F59E0B','holiday'=>'#0BB5B5','leave_update'=>'#7C3AED','attendance_alert'=>'#EF4444','payslip_ready'=>'#12B76A','announcement'=>'#6B4FDB'];
                $iconColor = $typeColors[$notif->type] ?? '#3B6FE8';
            @endphp
            <div class="nb-item {{ !$notif->is_read ? 'unread' : '' }}">
                <div class="nb-item-icon" style="background:{{ $iconColor }}18;">
                    <svg style="stroke:{{ $iconColor }}" viewBox="0 0 24 24">
                        @switch($notif->type)
                            @case('pay_reminder') @case('payslip_ready')
                                <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
                                @break
                            @case('contract_expiry')
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>
                                @break
                            @case('holiday')
                                <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                                @break
                            @case('leave_update')
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                @break
                            @case('attendance_alert')
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                @break
                            @default
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        @endswitch
                    </svg>
                </div>
                <div class="nb-item-body">
                    <div class="nb-item-title">{{ $notif->title }}</div>
                    <div class="nb-item-msg">{{ $notif->body }}</div>
                    <div class="nb-item-time">
                        <div class="nb-prio" style="background:{{ $prioBg }};"></div>
                        {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                        @if($prio === 'urgent')<span style="font-size:9.5px;background:var(--red-lt);color:var(--red);padding:1px 5px;border-radius:4px;font-weight:800;">URGENT</span>@endif
                    </div>
                </div>
                <div class="nb-item-actions">
                    @if(!$notif->is_read)
                        <button class="nb-ia-btn" wire:click="markOne({{ $notif->id }})" title="Mark read">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </button>
                    @endif
                    <button class="nb-ia-btn" wire:click="dismiss({{ $notif->id }})" title="Dismiss">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="nb-empty">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <p>You're all caught up!</p>
                <span>No {{ $filterTab !== 'all' ? $filterTab : '' }} notifications</span>
            </div>
        @endforelse
    </div>

    <div class="nb-panel-ft">
        @if($isHrOrAdmin)
            <a href="{{ route('hr.notifications') }}" class="nb-ft-link">
                View Notification Center
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        @else
            <span style="font-size:12px;color:var(--ink4);">{{ $totalCount }} total notification(s)</span>
        @endif
    </div>
</div>

</div>