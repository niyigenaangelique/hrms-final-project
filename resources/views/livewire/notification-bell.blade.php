<div>
    <style>
        .nb-bell-wrap { position: relative; display: inline-block; }

        .nb-bell-btn {
            background: rgba(255, 255, 255, 0.18);
            border: 1.5px solid rgba(255, 255, 255, 0.30);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: #fff;
            outline: none;
            position: relative;
        }

        .nb-bell-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nb-bell-btn svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }

        .nb-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #EF4444;
            color: white;
            font-size: 10px;
            font-weight: 800;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
            animation: nb-pulse 2s infinite;
            font-family: 'DM Sans', sans-serif;
        }

        @keyframes nb-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        /* FIXED-position dropdown — escapes all overflow:hidden parents */
        .nb-dropdown {
            position: fixed;
            width: 340px;
            background: #FFFFFF;
            border: 1px solid rgba(15, 22, 41, 0.10);
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(15, 22, 41, 0.18), 0 4px 16px rgba(59, 111, 232, 0.10);
            z-index: 99999;
            overflow: hidden;
            display: none;
            flex-direction: column;
            font-family: 'DM Sans', sans-serif;
        }

        .nb-dropdown.nb-open {
            display: flex;
            animation: nb-slide-in 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes nb-slide-in {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .nb-header {
            padding: 16px 18px;
            background: linear-gradient(135deg, #F8FAFF 0%, #EEF3FF 100%);
            border-bottom: 1px solid rgba(15, 22, 41, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nb-title {
            font-size: 14px;
            font-weight: 800;
            color: #0F1629;
            letter-spacing: -0.2px;
        }

        .nb-unread-chip {
            background: #EF4444;
            color: white;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 100px;
            margin-left: 6px;
        }

        .nb-mark-all {
            font-size: 11px;
            font-weight: 700;
            color: #3B6FE8;
            cursor: pointer;
            text-decoration: none;
            padding: 4px 10px;
            border-radius: 8px;
            background: rgba(59, 111, 232, 0.08);
            transition: background 0.15s;
        }

        .nb-mark-all:hover { background: rgba(59, 111, 232, 0.15); }

        .nb-list {
            max-height: 380px;
            overflow-y: auto;
        }

        .nb-list::-webkit-scrollbar { width: 4px; }
        .nb-list::-webkit-scrollbar-track { background: transparent; }
        .nb-list::-webkit-scrollbar-thumb { background: rgba(59,111,232,0.15); border-radius: 4px; }

        .nb-item {
            padding: 13px 18px;
            border-bottom: 1px solid rgba(15, 22, 41, 0.04);
            display: flex;
            gap: 12px;
            cursor: pointer;
            transition: background 0.12s;
            position: relative;
        }

        .nb-item:hover { background: #F8FAFF; }

        .nb-item.unread { background: rgba(59, 111, 232, 0.03); }

        .nb-item.unread::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: #3B6FE8;
            border-radius: 0 2px 2px 0;
        }

        .nb-icon-box {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .nb-icon-box svg { width: 16px; height: 16px; }

        .nb-content { flex: 1; min-width: 0; }

        .nb-notif-title {
            font-size: 13px; font-weight: 700;
            color: #0F1629; margin-bottom: 3px;
        }

        .nb-notif-body {
            font-size: 12px; color: #6B7094;
            line-height: 1.45;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .nb-notif-time {
            font-size: 10px; font-weight: 600;
            color: #A8ADCA; margin-top: 5px;
        }

        .nb-footer {
            padding: 12px 18px;
            text-align: center;
            border-top: 1px solid rgba(15, 22, 41, 0.05);
            background: #FAFBFF;
        }

        .nb-view-all {
            font-size: 12.5px; font-weight: 700;
            color: #3B6FE8; text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px;
        }

        .nb-view-all:hover { text-decoration: underline; }

        .nb-empty {
            padding: 36px 20px;
            text-align: center; color: #A8ADCA;
        }

        .nb-empty svg {
            width: 36px; height: 36px;
            margin: 0 auto 12px; display: block; opacity: 0.4;
        }

        .nb-empty-title { font-size: 13px; font-weight: 700; color: #6B7094; margin-bottom: 4px; }
        .nb-empty-sub   { font-size: 11.5px; }

        /* Priority colours */
        .nb-prio-urgent { background: #FEE2E2; color: #EF4444; }
        .nb-prio-high   { background: #FEF3C7; color: #D97706; }
        .nb-prio-normal { background: #E0E7FF; color: #3B6FE8; }
        .nb-prio-low    { background: #D1FAE5; color: #12B76A; }
    </style>

    {{-- Bell button --}}
    <div class="nb-bell-wrap" id="nb-wrap-{{ $this->getId() }}">
        <button
            wire:click="toggleDropdown"
            class="nb-bell-btn"
            id="nb-btn-{{ $this->getId() }}"
            aria-label="Notifications"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            @if($unreadCount > 0)
                <span class="nb-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            @endif
        </button>
    </div>

    {{-- Fixed-position dropdown — rendered at body level via JS portal --}}
    <div
        class="nb-dropdown {{ $showDropdown ? 'nb-open' : '' }}"
        id="nb-dropdown-{{ $this->getId() }}"
    >
        <div class="nb-header">
            <span class="nb-title">
                Notifications
                @if($unreadCount > 0)
                    <span class="nb-unread-chip">{{ $unreadCount }}</span>
                @endif
            </span>
            @if($unreadCount > 0)
                <a href="#" wire:click.prevent="markAllAsRead" class="nb-mark-all">Mark all read</a>
            @endif
        </div>

        <div class="nb-list">
            @forelse($notifications as $notif)
                @php
                    $prioClass = 'nb-prio-' . ($notif->priority ?? 'normal');
                    $icon = match($notif->type) {
                        'contract_expiry' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
                        'holiday'         => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',
                        'pay_reminder'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><circle cx="12" cy="15" r="2"/></svg>',
                        default           => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
                    };
                @endphp
                <div class="nb-item {{ !$notif->is_read ? 'unread' : '' }}" wire:click="markAsRead('{{ $notif->id }}')">
                    <div class="nb-icon-box {{ $prioClass }}">{!! $icon !!}</div>
                    <div class="nb-content">
                        <div class="nb-notif-title">{{ $notif->title }}</div>
                        <div class="nb-notif-body" title="{{ $notif->body }}">{{ $notif->body }}</div>
                        <div class="nb-notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="nb-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <div class="nb-empty-title">All caught up!</div>
                    <div class="nb-empty-sub">Holidays, paydays & contract alerts will appear here.</div>
                </div>
            @endforelse
        </div>

        <div class="nb-footer">
            <a href="{{ route('hr.notifications') }}" class="nb-view-all">
                View Notification Center
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </div>

    <script>
    (function () {
        var btnId      = 'nb-btn-{{ $this->getId() }}';
        var dropId     = 'nb-dropdown-{{ $this->getId() }}';
        var isOpen     = {{ $showDropdown ? 'true' : 'false' }};

        function positionDrop() {
            var btn  = document.getElementById(btnId);
            var drop = document.getElementById(dropId);
            if (!btn || !drop) return;

            // Move to body so no ancestor clips it
            if (drop.parentElement !== document.body) {
                document.body.appendChild(drop);
            }

            var rect = btn.getBoundingClientRect();
            var dropW = 340;
            var gutter = 8;

            var top  = rect.bottom + gutter;
            var left = rect.right - dropW;

            // Keep within viewport
            if (left < gutter) left = gutter;
            if (top + 480 > window.innerHeight) top = rect.top - 480 - gutter;

            drop.style.top  = top  + 'px';
            drop.style.left = left + 'px';
        }

        function applyState() {
            var drop = document.getElementById(dropId);
            if (!drop) return;
            if (isOpen) {
                positionDrop();
                drop.classList.add('nb-open');
            } else {
                drop.classList.remove('nb-open');
            }
        }

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            var btn  = document.getElementById(btnId);
            var drop = document.getElementById(dropId);
            if (!btn || !drop) return;
            if (!btn.contains(e.target) && !drop.contains(e.target)) {
                drop.classList.remove('nb-open');
            }
        }, true);

        // Re-position on scroll/resize
        window.addEventListener('scroll', function () {
            var drop = document.getElementById(dropId);
            if (drop && drop.classList.contains('nb-open')) positionDrop();
        }, true);
        window.addEventListener('resize', function () {
            var drop = document.getElementById(dropId);
            if (drop && drop.classList.contains('nb-open')) positionDrop();
        });

        // After Livewire re-render, re-sync state
        document.addEventListener('livewire:updated', applyState);
        document.addEventListener('livewire:navigated', applyState);

        // Initial
        applyState();
    })();
    </script>
</div>
