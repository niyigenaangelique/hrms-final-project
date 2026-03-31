<div class="msg-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.msg-root {
    --accent:       #3B6FE8;
    --accent-lt:    rgba(59,111,232,0.10);
    --accent-mid:   rgba(59,111,232,0.18);
    --bubble-sent:  #3B6FE8;
    --bubble-recv:  #f0f2f8;
    --text:         #1a1a2e;
    --text-2:       #6b7094;
    --text-3:       #b1bbc9;
    --border:       #e8eaf0;
    --bg:           #f0f4fa;
    --white:        #ffffff;
    font-family: 'DM Sans', -apple-system, sans-serif;
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding: 20px 20px 36px;
}

/* ── TOP BAR ─────────────────────────────────────────── */
.msg-top-bar {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-shrink: 0;
}
.msg-top-left { display: flex; align-items: center; gap: 12px; }
.msg-top-icon {
    width: 40px; height: 40px;
    background: var(--accent); border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
}
.msg-top-icon svg { width: 19px; height: 19px; stroke: #fff; fill: none; stroke-width: 2; }
.msg-top-title { font-size: 18px; font-weight: 700; color: var(--text); margin: 0 0 1px; }
.msg-top-sub   { font-size: 12.5px; color: var(--text-2); margin: 0; }
.msg-unread-pill {
    display: flex; align-items: center; gap: 6px;
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.2);
    border-radius: 100px; padding: 5px 13px;
}
.msg-unread-dot  { width: 7px; height: 7px; border-radius: 50%; background: #ef4444; }
.msg-unread-text { font-size: 12px; font-weight: 700; color: #b91c1c; }

/* ── MAIN SHELL ──────────────────────────────────────── */
.chat-shell {
    display: flex;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    flex: 1;
    min-height: calc(100vh - 140px);
    position: relative;
}

/* ══ USERS DRAWER ════════════════════════════════════════
   Hidden by default (translateX(-260px) + margin-left:-260px)
   .open class slides it into view
════════════════════════════════════════════════════════ */
.chat-users-drawer {
    width: 260px;
    min-width: 260px;
    background: var(--white);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    transform: translateX(-260px);
    margin-left: -260px;
    transition: transform 0.25s ease, margin-left 0.25s ease;
    overflow: hidden;
    z-index: 10;
}
.chat-users-drawer.open {
    transform: translateX(0);
    margin-left: 0;
}

.drawer-header {
    padding: 16px 16px 12px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.drawer-title { font-size: 13.5px; font-weight: 700; color: var(--text); }
.drawer-close {
    width: 28px; height: 28px; border-radius: 8px;
    background: var(--bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s;
}
.drawer-close:hover { background: rgba(239,68,68,0.08); }
.drawer-close svg { width: 13px; height: 13px; stroke: var(--text-2); fill: none; stroke-width: 2.5; }

.drawer-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--bg); border-radius: 9px;
    padding: 8px 12px; margin: 12px 12px 4px;
    flex-shrink: 0;
}
.drawer-search svg { width: 13px; height: 13px; stroke: var(--text-3); fill: none; flex-shrink: 0; }
.drawer-search input {
    border: none; background: transparent;
    font-size: 12.5px; color: var(--text);
    outline: none; width: 100%;
    font-family: 'DM Sans', sans-serif;
}
.drawer-search input::placeholder { color: var(--text-3); }

.users-list { overflow-y: auto; flex: 1; padding: 6px 10px 10px; }

.user-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 11px; border-radius: 10px;
    cursor: pointer; transition: background 0.15s; margin-bottom: 3px;
}
.user-item:hover { background: var(--accent-lt); }
.user-item.active { background: var(--accent); }
.user-item.active .user-name { color: #fff; }
.user-item.active .user-role { color: rgba(255,255,255,0.75); }

.user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--accent-lt); color: var(--accent);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; flex-shrink: 0;
}
.user-item.active .user-avatar { background: rgba(255,255,255,0.2); color: #fff; }
.user-name { font-size: 13px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-role { font-size: 11px; color: var(--text-2); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* ══ CONVERSATIONS COLUMN ════════════════════════════════ */
.chat-conversations {
    width: 260px; min-width: 260px;
    border-right: 1px solid var(--border);
    display: flex; flex-direction: column; flex-shrink: 0;
}
.conv-header {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 10px;
    flex-shrink: 0;
}

/* ── THE TOGGLE BUTTON ── small icon that opens the drawer */
.users-toggle-btn {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--accent-lt);
    border: 1.5px solid var(--accent-mid);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
    transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
    position: relative;
}
.users-toggle-btn:hover {
    background: var(--accent-mid);
    transform: scale(1.06);
    box-shadow: 0 2px 10px rgba(59,111,232,0.20);
}
.users-toggle-btn svg { width: 16px; height: 16px; stroke: var(--accent); fill: none; stroke-width: 2; }
/* Blue dot indicator */
.toggle-dot {
    position: absolute; top: -3px; right: -3px;
    width: 9px; height: 9px; border-radius: 50%;
    background: var(--accent); border: 2px solid var(--white);
    pointer-events: none;
}

.conv-header-title { font-size: 13.5px; font-weight: 700; color: var(--text); flex: 1; }

.conversations-list { overflow-y: auto; flex: 1; }
.conversation-item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 14px; cursor: pointer;
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
}
.conversation-item:last-child { border-bottom: none; }
.conversation-item:hover { background: var(--accent-lt); }
.conversation-item.active { background: var(--accent); }
.conversation-item.active .conv-name    { color: #fff; }
.conversation-item.active .conv-preview { color: rgba(255,255,255,0.75); }
.conversation-item.active .conv-time    { color: rgba(255,255,255,0.6); }

.conv-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--accent-lt); color: var(--accent);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; flex-shrink: 0;
}
.conversation-item.active .conv-avatar { background: rgba(255,255,255,0.2); color: #fff; }
.conv-info { flex: 1; min-width: 0; }
.conv-name    { font-size: 13px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
.conv-preview { font-size: 11.5px; color: var(--text-2); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.conv-meta { text-align: right; flex-shrink: 0; }
.conv-time  { font-size: 10.5px; color: var(--text-3); display: block; margin-bottom: 3px; }
.conv-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 17px; height: 17px; padding: 0 4px;
    border-radius: 100px; background: var(--accent);
    color: #fff; font-size: 9.5px; font-weight: 700;
}
.conversation-item.active .conv-badge { background: rgba(255,255,255,0.3); }

.conv-empty { padding: 36px 20px; text-align: center; color: var(--text-3); font-size: 13px; }
.conv-empty svg { width: 32px; height: 32px; stroke: var(--text-3); fill: none; stroke-width: 1.5; margin: 0 auto 10px; display: block; opacity: 0.5; }

/* ══ CHAT MAIN ═══════════════════════════════════════════ */
.chat-main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

.chat-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.chat-header-left { display: flex; align-items: center; gap: 10px; }
.chat-user-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: var(--accent-lt); color: var(--accent);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; flex-shrink: 0;
}
.chat-user-name   { font-size: 14px; font-weight: 700; color: var(--text); margin: 0 0 1px; }
.chat-user-status { font-size: 12px; color: var(--accent); }
.chat-header-actions { display: flex; gap: 8px; }
.chat-header-actions button {
    background: none; border: none; cursor: pointer; padding: 6px;
    border-radius: 8px; line-height: 0; transition: background 0.15s;
}
.chat-header-actions button:hover { background: var(--bg); }
.chat-header-actions svg { width: 17px; height: 17px; stroke: var(--text-3); fill: none; stroke-width: 1.75; }

.chat-messages {
    flex: 1; overflow-y: auto; padding: 20px 22px;
    display: flex; flex-direction: column; gap: 12px;
}
.chat-empty {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    color: var(--text-3); gap: 10px; text-align: center; padding: 40px 20px;
}
.chat-empty svg { width: 40px; height: 40px; stroke: #d4d8e8; fill: none; stroke-width: 1.5; }
.chat-empty p { font-size: 14px; margin: 0; color: var(--text-2); }
.chat-empty span { font-size: 12.5px; color: var(--text-3); }

.msg-row { display: flex; align-items: flex-end; gap: 8px; }
.msg-row.sent { flex-direction: row-reverse; }
.msg-wrap { display: flex; flex-direction: column; max-width: 65%; }
.msg-row.sent .msg-wrap { align-items: flex-end; }

.bubble {
    padding: 10px 15px; font-size: 13.5px; line-height: 1.55;
    border-radius: 18px; word-break: break-word;
}
.bubble.recv { background: var(--bubble-recv); color: var(--text); border-radius: 4px 18px 18px 18px; }
.bubble.sent { background: var(--bubble-sent); color: #fff; border-radius: 18px 4px 18px 18px; }

.msg-subject-label { font-size: 11px; font-weight: 700; margin-bottom: 3px; opacity: 0.7; }
.bubble-meta { display: flex; align-items: center; gap: 5px; margin-top: 4px; padding: 0 2px; flex-wrap: wrap; }
.bubble-time { font-size: 10.5px; color: var(--text-3); }
.badge-sm { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 100px; display: inline-flex; }
.badge-new  { background: var(--accent-lt); color: var(--accent); }
.badge-read { background: rgba(0,0,0,0.05); color: var(--text-2); }
.btn-mark-read {
    font-size: 10px; font-weight: 600; color: var(--accent);
    background: var(--accent-lt); border: none; border-radius: 6px;
    cursor: pointer; padding: 2px 8px; font-family: 'DM Sans', sans-serif;
    transition: background 0.15s;
}
.btn-mark-read:hover { background: var(--accent-mid); }

/* Compose */
.compose-area {
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    background: var(--white);
    flex-shrink: 0;
}
.flash-ok  { background: rgba(18,183,106,0.09); border: 1px solid rgba(18,183,106,0.22); border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 600; color: #087A42; margin-bottom: 10px; }
.flash-err { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.20); border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 600; color: #b91c1c; margin-bottom: 10px; }

.compose-inner {
    display: flex; align-items: flex-end; gap: 10px;
    background: var(--bg);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 10px 14px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.compose-inner:focus-within {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(59,111,232,0.09);
}
.compose-textarea {
    flex: 1; border: none; background: transparent;
    font-size: 13.5px; font-weight: 500; color: var(--text);
    font-family: 'DM Sans', sans-serif;
    outline: none; resize: none; min-height: 20px; max-height: 120px;
    line-height: 1.5;
}
.compose-textarea::placeholder { color: var(--text-3); }
.compose-action-btn {
    background: none; border: none; cursor: pointer; padding: 5px;
    border-radius: 7px; line-height: 0; transition: background 0.15s;
}
.compose-action-btn:hover { background: var(--accent-lt); }
.compose-action-btn svg { width: 17px; height: 17px; stroke: var(--text-3); fill: none; stroke-width: 2; transition: stroke 0.15s; }
.compose-action-btn:hover svg { stroke: var(--accent); }
.compose-send-btn {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--accent); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background 0.15s, transform 0.12s;
    box-shadow: 0 2px 8px rgba(59,111,232,0.30);
}
.compose-send-btn:hover  { background: #2755CC; transform: scale(1.06); }
.compose-send-btn:active { transform: scale(0.95); }
.compose-send-btn svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; }
.compose-hint { font-size: 11px; color: var(--text-3); margin-top: 6px; text-align: right; }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 20px; left: 50%;
    transform: translateX(-50%); z-index: 200;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.82);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.11);
    border-radius: 28px; padding: 7px 10px;
    box-shadow: 0 20px 56px rgba(15,22,41,0.24);
}
.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 7px 16px; border-radius: 18px; text-decoration: none;
    font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.40);
    letter-spacing: 0.04em; min-width: 58px; position: relative;
    transition: background 0.18s, color 0.18s, transform 0.14s;
}
.ios-nav-item svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.8; }
.ios-nav-item:hover { color: rgba(255,255,255,0.82); background: rgba(255,255,255,0.07); transform: translateY(-1px); }
.ios-nav-item.active { color: #fff; background: rgba(59,111,232,0.25); }
.ios-nav-item.active svg { stroke: #93C5FD; }
.ios-nav-active-dot { position: absolute; bottom: 3px; width: 4px; height: 4px; border-radius: 50%; background: #60A5FA; }
.ios-nav-unread { position: absolute; top: 4px; right: 9px; width: 7px; height: 7px; border-radius: 50%; background: #ef4444; border: 1.5px solid rgba(15,15,25,0.82); }

@media (max-width: 768px) {
    .chat-conversations { width: 200px; min-width: 200px; }
}
@media (max-width: 560px) {
    .chat-conversations { display: none; }
    .ios-nav-item { font-size: 9px; padding: 7px 10px; }
}
</style>

{{-- ── Page header ──────────────────────────────────────── --}}
<div class="msg-top-bar">
    <div class="msg-top-left">
        <div class="msg-top-icon">
            <svg viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="msg-top-title">Messages</p>
            <p class="msg-top-sub">Communicate with the team</p>
        </div>
    </div>
    @if($unreadCount > 0)
        <div class="msg-unread-pill">
            <span class="msg-unread-dot"></span>
            <span class="msg-unread-text">{{ $unreadCount }} unread</span>
        </div>
    @endif
</div>

{{-- ── Chat shell ───────────────────────────────────────── --}}
<div class="chat-shell">

    {{-- ══ USERS DRAWER — hidden until toggled ══ --}}
    <div class="chat-users-drawer" id="usersDrawer">
        <div class="drawer-header">
            <span class="drawer-title">Available User</span>
            <button class="drawer-close" onclick="toggleUsersDrawer()" title="Close panel">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="drawer-search">
            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Search people…" oninput="filterUsers(this.value)">
        </div>

        <div class="users-list" id="usersList">
            @foreach($hrUsers as $hrUser)
                @php
                    $initials = strtoupper(substr($hrUser->first_name,0,1).substr($hrUser->last_name,0,1));
                    $isActive = isset($selectedConversation) && $selectedConversation == $hrUser->id;
                @endphp
                <div class="user-item {{ $isActive ? 'active' : '' }}"
                     wire:click="selectConversation('{{ $hrUser->id }}')"
                     onclick="toggleUsersDrawer()"
                     data-name="{{ strtolower($hrUser->first_name.' '.$hrUser->last_name) }}"
                     data-role="{{ strtolower($hrUser->role->value) }}">
                    <div class="user-avatar">{{ $initials }}</div>
                    <div>
                        <div class="user-name">{{ $hrUser->first_name }} {{ $hrUser->last_name }}</div>
                        <div class="user-role">{{ ucfirst($hrUser->role->value) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ══ CONVERSATIONS COLUMN ══ --}}
    <div class="chat-conversations">
        <div class="conv-header">

            {{-- ★ THE TOGGLE ICON BUTTON ★ --}}
            <button class="users-toggle-btn"
                    id="usersToggleBtn"
                    onclick="toggleUsersDrawer()"
                    title="Available Users">
                <svg viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span class="toggle-dot"></span>
            </button>

            <span class="conv-header-title">Recent Messages</span>
        </div>

        <div class="conversations-list">
            @if($messageList->count() > 0)
                @php
                    $grouped = $messageList->groupBy(function($msg) {
                        return $msg->sender_id === Auth::id()
                            ? $msg->receiver_id
                            : $msg->sender_id;
                    });
                @endphp
                @foreach($grouped as $personId => $msgs)
                    @php
                        $latest   = $msgs->first();
                        $isSent   = $latest->sender_id === Auth::id();
                        $person   = $isSent ? $latest->receiver : $latest->sender;
                        $unread   = $msgs->where('receiver_id', Auth::id())->where('is_read', false)->count();
                        $initials = strtoupper(substr($person->first_name,0,1).substr($person->last_name,0,1));
                        $isActive = isset($selectedConversation) && $selectedConversation == $personId;
                    @endphp
                    <div class="conversation-item {{ $isActive ? 'active' : '' }}"
                         wire:click="selectConversation('{{ $personId }}')">
                        <div class="conv-avatar">{{ $initials }}</div>
                        <div class="conv-info">
                            <div class="conv-name">{{ $person->first_name }} {{ $person->last_name }}</div>
                            <div class="conv-preview">{{ Str::limit($latest->message, 32) }}</div>
                        </div>
                        <div class="conv-meta">
                            <span class="conv-time">{{ $latest->created_at->format('M d') }}</span>
                            @if($unread > 0)
                                <span class="conv-badge">{{ $unread }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="conv-empty">
                    <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    No conversations yet.<br>
                    <span>Tap the people icon above to find HR.</span>
                </div>
            @endif
        </div>
    </div>

    {{-- ══ CHAT MAIN ══ --}}
    <div class="chat-main">

        {{-- Header --}}
        @if(isset($selectedConversation) && $conversationMessages && $conversationMessages->count() > 0)
            @php
                $latest   = $conversationMessages->first();
                $isSent   = $latest->sender_id === Auth::id();
                $chatWith = $isSent ? $latest->receiver : $latest->sender;
                $chatInitials = strtoupper(substr($chatWith->first_name,0,1).substr($chatWith->last_name,0,1));
            @endphp
            <div class="chat-header">
                <div class="chat-header-left">
                    <div class="chat-user-avatar">{{ $chatInitials }}</div>
                    <div>
                        <p class="chat-user-name">{{ $chatWith->first_name }} {{ $chatWith->last_name }}</p>
                        <p class="chat-user-status">Online</p>
                    </div>
                </div>
                
            </div>
        @elseif(isset($selectedConversation))
            @php $selectedUser = $hrUsers->firstWhere('id', $selectedConversation); @endphp
            <div class="chat-header">
                <div class="chat-header-left">
                    @if($selectedUser)
                        <div class="chat-user-avatar">{{ strtoupper(substr($selectedUser->first_name,0,1).substr($selectedUser->last_name,0,1)) }}</div>
                        <div>
                            <p class="chat-user-name">{{ $selectedUser->first_name }} {{ $selectedUser->last_name }}</p>
                            <p class="chat-user-status">{{ ucfirst($selectedUser->role->value) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="chat-header">
                <div class="chat-header-left">
                    <div class="chat-user-avatar" style="background:var(--bg);color:var(--text-3);">
                        <svg style="width:18px;height:18px;stroke:var(--text-3);fill:none;stroke-width:1.75;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div>
                        <p class="chat-user-name" style="color:var(--text-2);">No conversation selected</p>
                        <p class="chat-user-status" style="color:var(--text-3);">Click the people icon to browse the HR team</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Messages --}}
        <div class="chat-messages" id="chatMessages">
            @if($conversationMessages && $conversationMessages->count() > 0)
                @foreach($conversationMessages as $message)
                    @php
                        $isSent   = $message->sender_id === Auth::id();
                        $isUnread = $message->receiver_id === Auth::id() && !$message->is_read;
                    @endphp
                    <div class="msg-row {{ $isSent ? 'sent' : 'recv' }}">
                        <div class="msg-wrap">
                            @if($message->subject)
                                <div class="msg-subject-label" style="color:{{ $isSent ? 'rgba(255,255,255,0.65)' : 'var(--text-3)' }}">
                                    {{ $message->subject }}
                                </div>
                            @endif
                            <div class="bubble {{ $isSent ? 'sent' : 'recv' }}">{{ $message->message }}</div>
                            <div class="bubble-meta">
                                <span class="bubble-time">{{ $message->created_at->format('M d · H:i') }}</span>
                                @if($isUnread)
                                    <span class="badge-sm badge-new">New</span>
                                    <button class="btn-mark-read" wire:click="markAsRead({{ $message->id }})">Mark read</button>
                                @else
                                    <span class="badge-sm badge-read">{{ ucfirst($message->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="chat-empty">
                    <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <p>No messages yet</p>
                    <span>Type a message below to start the conversation</span>
                </div>
            @endif
        </div>

        {{-- Compose --}}
        <div class="compose-area">
            @if(session()->has('success'))
                <div class="flash-ok">{{ session('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="flash-err">{{ session('error') }}</div>
            @endif

            <form wire:submit="sendMessage">
                <div class="compose-inner">
                    <textarea class="compose-textarea"
                              wire:model="messageContent"
                              placeholder="Type your message…"
                              rows="1"
                              onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.closest('form').requestSubmit();}"
                              oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,120)+'px'"></textarea>
                   
                    <button type="submit" class="compose-send-btn" title="Send">
                        <svg viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
                @error('messageContent') <div style="font-size:11.5px;color:#dc2626;margin-top:5px;font-weight:600;">{{ $message }}</div> @enderror
                <div class="compose-hint">Enter to send · Shift+Enter for new line</div>
            </form>
        </div>

    </div>{{-- /chat-main --}}
</div>{{-- /chat-shell --}}

{{-- ── Floating nav ─────────────────────────────────────── --}}
<nav class="ios-nav">
    <a href="{{ route('employee.dashboard') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
    </a>
    <a href="{{ route('employee.profile') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0114 0"/></svg>
        Profile
    </a>
    <a href="{{ route('employee.attendance') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
    </a>
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="{{ route('employee.communication') }}" class="ios-nav-item active" style="position:relative">
        @if($unreadCount > 0)
            <span class="ios-nav-unread"></span>
        @endif
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Messages
        <span class="ios-nav-active-dot"></span>
    </a>
</nav>

<script>
(function () {
    /* ── Drawer open / close ── */
    function toggleUsersDrawer() {
        var d = document.getElementById('usersDrawer');
        if (d) d.classList.toggle('open');
    }
    window.toggleUsersDrawer = toggleUsersDrawer;

    /* ── Live search ── */
    function filterUsers(q) {
        q = (q || '').toLowerCase().trim();
        document.querySelectorAll('#usersList .user-item').forEach(function (el) {
            var match = !q || (el.dataset.name || '').includes(q) || (el.dataset.role || '').includes(q);
            el.style.display = match ? '' : 'none';
        });
    }
    window.filterUsers = filterUsers;

    /* ── Click outside drawer closes it ── */
    document.addEventListener('click', function (e) {
        var d = document.getElementById('usersDrawer');
        var b = document.getElementById('usersToggleBtn');
        if (!d || !d.classList.contains('open')) return;
        if (!d.contains(e.target) && b && !b.contains(e.target)) {
            d.classList.remove('open');
        }
    });

    /* ── Auto-scroll to newest message ── */
    function scrollBottom() {
        var el = document.getElementById('chatMessages');
        if (el) el.scrollTop = el.scrollHeight;
    }
    scrollBottom();
    document.addEventListener('livewire:updated',   scrollBottom);
    document.addEventListener('livewire:navigated', scrollBottom);
})();
</script>

</div>{{-- /msg-root --}}