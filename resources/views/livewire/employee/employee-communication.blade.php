<div class="msg-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Reset & Root ─────────────────────────────────────── */
.msg-root {
    --accent:         #3B6FE8;
    --accent-light:   rgba(59,111,232,0.10);
    --accent-hover:   #3B6FE8;
    --bubble-sent:    #3B6FE8;
    --bubble-recv:    #f4f5ee;
    --sidebar-w:      250px; /* Reduced from 300px */
    --text-primary:   #1a1a1a;
    --text-secondary: #7d94c2;
    --text-tertiary:  #b1bbc9;
    --border:         #e8e8e8;
    --bg:             #ffffff;
    --nav-h:          72px;
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 12px 12px calc(var(--nav-h) + 16px); /* Reduced padding */
    display: flex;
    flex-direction: column;
    gap: 12px; /* Reduced gap */
    max-width: 100%;
    height: 95vh; /* Take 95% of viewport height */
    min-height: 700px; /* Increased minimum height */
    background: #f8f8f7f8;
}

/* ── Page header card ─────────────────────────────────── */
.msg-top-bar {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-shrink: 0;
    width: 75vw; 
    margin: 0 auto;
}

.msg-top-left { display: flex; align-items: center; gap: 12px; }

.msg-top-icon {
    width: 42px; height: 42px;
    background: var(--accent);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.msg-top-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; }

.msg-top-title { font-size: 20px; font-weight: 700; color: var(--text-primary); margin: 0 0 2px; }
.msg-top-sub   { font-size: 13px; color: var(--text-secondary); margin: 0; }

.msg-unread-pill {
    display: flex; align-items: center; gap: 6px;
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.2);
    border-radius: 100px;
    padding: 5px 14px;
}
.msg-unread-dot  { width: 7px; height: 7px; border-radius: 50%; background: #ef4444; flex-shrink: 0; }
.msg-unread-text { font-size: 12.5px; font-weight: 700; color: #b91c1c; }

/* ── Chat shell ───────────────────────────────────────── */
.chat-shell {
    display: flex;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    height: 85vh; /* Much larger - 85% of viewport height */
    min-height: 700px; /* Increased minimum */
    flex: 1;
    width: 75vw; /* Use 95% of viewport width */
    max-width: none; /* Remove max-width constraint */
    margin: 0 auto; /* Center the whole chat */
}

/* ── LEFT: Available Users Section ─────────────────────── */
.chat-users {
    width: 280px;
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    background: #fff;
}

.users-header {
    padding: 16px 16px 12px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}

.users-title {
    font-size: 14px; font-weight: 700; color: var(--text-primary);
    margin: 0 0 8px;
}

.users-search {
    display: flex; align-items: center; gap: 8px;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 8px 12px;
}
.users-search svg { width: 14px; height: 14px; stroke: #999; flex-shrink: 0; }
.users-search input {
    border: none; background: transparent;
    font-size: 12px; color: var(--text-primary);
    outline: none; width: 100%;
    font-family: 'DM Sans', sans-serif;
}
.users-search input::placeholder { color: #999; }

.users-list { overflow-y: auto; flex: 1; padding: 8px; }

.user-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.15s;
    margin-bottom: 4px;
}
.user-item:hover { background: var(--accent-light); }
.user-item.active { background: var(--accent); color: #fff; }
.user-item.active .user-name { color: #fff; }
.user-item.active .user-role { color: rgba(255,255,255,0.8); }

.user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    flex-shrink: 0; position: relative;
    background: var(--accent-light); color: var(--accent);
}
.user-item.active .user-avatar { background: rgba(255,255,255,0.2); color: #fff; }

.user-info { flex: 1; min-width: 0; }
.user-name    { font-size: 13px; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-role { font-size: 11px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* ── MIDDLE: Recent Messages Section ───────────────────── */
.chat-conversations {
    width: 320px;
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    background: #fff;
}

.conversations-header {
    padding: 16px 16px 12px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}

.conversations-title {
    font-size: 14px; font-weight: 700; color: var(--text-primary);
    margin: 0;
}

.conversations-list { overflow-y: auto; flex: 1; }

.conversation-item {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px;
    cursor: pointer;
    border-radius: 8px;
    margin: 4px 8px;
    transition: background 0.15s;
    position: relative;
}
.conversation-item:hover { background: var(--accent-light); }
.conversation-item.active { background: var(--accent); color: #fff; }
.conversation-item.active .conv-name { color: #fff; }
.conversation-item.active .conv-preview { color: rgba(255,255,255,0.8); }
.conversation-item.active .conv-time { color: rgba(255,255,255,0.8); }

.conv-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700;
    flex-shrink: 0; position: relative;
    background: var(--accent-light); color: var(--accent);
}
.conversation-item.active .conv-avatar { background: rgba(255,255,255,0.2); color: #fff; }

.conv-info { flex: 1; min-width: 0; }
.conv-name    { font-size: 13px; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
.conv-preview { font-size: 11.5px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.conv-meta { text-align: right; flex-shrink: 0; }
.conv-time  { font-size: 10.5px; color: var(--text-tertiary); display: block; margin-bottom: 3px; }
.conv-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 17px; height: 17px; padding: 0 4px;
    border-radius: 100px; background: var(--accent);
    color: #fff; font-size: 9.5px; font-weight: 700;
}
.conversation-item.active .conv-badge { background: rgba(255,255,255,0.3); }

/* ── RIGHT CHAT AREA ──────────────────────────────────── */
.chat-main {
    flex: 1; display: flex; flex-direction: column;
    overflow: hidden; background: #fff;
}

/* Chat header */
.chat-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.chat-header-left { display: flex; align-items: center; gap: 10px; }

.chat-user-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700;
    background: #f6f7f4; color: #5377da;
    flex-shrink: 0;
}
.chat-user-name   { font-size: 14.5px; font-weight: 700; color: var(--text-primary); margin: 0 0 1px; }
.chat-user-status { font-size: 12px; color: var(--accent); }

.chat-actions { display: flex; gap: 12px; }
.chat-actions button {
    background: none; border: none; cursor: pointer; padding: 6px;
    border-radius: 8px; transition: background 0.15s; line-height: 0;
}
.chat-actions button:hover { background: #f5f5ee; }
.chat-actions svg { width: 18px; height: 18px; stroke: #bbb; fill: none; stroke-width: 1.75; transition: stroke 0.15s; }
.chat-actions button:hover svg { stroke: var(--accent); }

/* Messages area */
.chat-messages {
    flex: 1; overflow-y: auto;
    padding: 20px 24px;
    display: flex; flex-direction: column; gap: 12px;
    background: #fff;
}

/* No messages state */
.chat-empty {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    color: var(--text-tertiary); gap: 10px;
    text-align: center;
}
.chat-empty svg { width: 40px; height: 40px; stroke: #ddd; fill: none; stroke-width: 1.5; }
.chat-empty p   { font-size: 14px; margin: 0; }

/* Message rows */
.msg-row { display: flex; align-items: flex-end; gap: 8px; }
.msg-row.sent { flex-direction: row-reverse; }

.msg-wrap { display: flex; flex-direction: column; max-width: 62%; }
.msg-row.sent .msg-wrap { align-items: flex-end; }

.bubble {
    padding: 10px 15px;
    font-size: 13.5px; line-height: 1.55;
    border-radius: 18px;
    word-break: break-word;
}
.bubble.recv {
    background: var(--bubble-recv);
    color: var(--text-primary);
    border-radius: 4px 18px 18px 18px;
}
.bubble.sent {
    background: var(--bubble-sent);
    color: #fff;
    border-radius: 18px 4px 18px 18px;
}

.msg-subject-label {
    font-size: 11px; font-weight: 700;
    margin-bottom: 2px;
    opacity: 0.75;
}

.bubble-meta {
    display: flex; align-items: center; gap: 5px;
    margin-top: 4px; padding: 0 2px;
}
.bubble-time { font-size: 10.5px; color: var(--text-tertiary); }

.badge-sm {
    font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 100px;
    display: inline-flex;
}
.badge-new  { background: rgba(124,143,58,0.15); color: var(--accent); }
.badge-read { background: rgba(0,0,0,0.06); color: var(--text-secondary); }

.btn-mark-read {
    font-size: 10.5px; font-weight: 600; color: var(--accent);
    background: rgba(124,143,58,0.1);
    border: none; border-radius: 6px; cursor: pointer;
    padding: 2px 8px;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.15s;
    white-space: nowrap;
}
.btn-mark-read:hover { background: rgba(124,143,58,0.2); }

/* ── COMPOSE PANEL (right side, inside chat-main) ─────── */
/* Compose bar at bottom when a thread is selected */
.compose-bar {
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    background: #fff;
    flex-shrink: 0;
}

.compose-new-msg {
    padding: 16px;
    border-top: 1px solid var(--border);
    background: #fff;
    flex-shrink: 0;
    max-width: 800px; /* Increased from 500px */
    margin: 0 auto; /* Center within available space */
}

.compose-new-msg-title {
    font-size: 13px; font-weight: 700; color: var(--text-primary);
    margin: 0 0 14px;
    display: flex; align-items: center; gap: 8px;
}
.compose-new-msg-title svg { width: 15px; height: 15px; stroke: var(--accent); fill: none; stroke-width: 2; }

.cmp-row { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px; }

.cmp-field { display: flex; flex-direction: column; gap: 4px; flex: 1; }
.cmp-field label {
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-tertiary);
}
.cmp-field input,
.cmp-field select,
.cmp-field textarea {
    width: 100%; padding: 9px 12px;
    background: #fff;
    border: 1px solid #eff0f7;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 500;
    color: var(--text-primary);
    outline: none; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
    -webkit-appearance: none;
}
.cmp-field input:focus,
.cmp-field select:focus,
.cmp-field textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(124,143,58,0.12);
    background: #fff;
}
.cmp-field textarea { 
    resize: none; 
    height: 60px; 
    font-size: 14px;
    width: 100% !important; 
    min-width: 700px !important; /* Force minimum width */
}
.cmp-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    padding-right: 32px; cursor: pointer;
}
.cmp-error { font-size: 11px; color: #dc2626; }

.compose-bottom-row {
    display: flex; align-items: center; gap: 10px;
    margin-top: 10px;
}

.compose-actions { display: flex; gap: 6px; }
.compose-actions button {
    background: none; border: none; cursor: pointer; padding: 7px;
    border-radius: 8px; transition: background 0.15s; line-height: 0;
}
.compose-actions button:hover { background: #f0f0e8; }
.compose-actions svg { width: 17px; height: 17px; stroke: #bbb; fill: none; stroke-width: 2; transition: stroke 0.15s; }
.compose-actions button:hover svg { stroke: var(--accent); }

.btn-send {
    margin-left: auto;
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px;
    background: var(--accent);
    color: #fff; border: none; border-radius: 100px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700; cursor: pointer;
    transition: background 0.15s, transform 0.12s;
}
.btn-send:hover  { background: var(--accent-hover); transform: translateY(-1px); }
.btn-send:active { transform: scale(0.97); }
.btn-send svg { width: 15px; height: 15px; stroke: #fff; fill: none; stroke-width: 2; }

/* Flash messages */
.flash-ok  { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 600; color: #15803d; margin-bottom: 10px; }
.flash-err { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 600; color: #b91c1c; margin-bottom: 10px; }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 55%;
    transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.80);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1);
  
 
}
.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 8px 18px; border-radius: 20px; text-decoration: none;
    font-size: 10px; font-weight: 500; color: rgba(255,255,255,0.45);
    letter-spacing: 0.03em; min-width: 64px; position: relative;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}
.ios-nav-item svg { width: 20px; height: 20px; stroke: currentColor; transition: transform 0.2s; }
.ios-nav-item:hover { color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.08); transform: translateY(-1px); }
.ios-nav-item.active { color: #fff; background: rgba(255,255,255,0.12); }
.ios-nav-item.active svg { stroke: #a3b855; }
.ios-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #a3b855; }
.ios-nav-unread { position: absolute; top: 5px; right: 10px; width: 7px; height: 7px; border-radius: 50%; background: #ef4444; border: 1.5px solid rgba(15,15,25,0.8); }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 768px) {
    .msg-root { padding: 16px 12px calc(var(--nav-h) + 24px); }
    .chat-sidebar { width: 240px; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
}
@media (max-width: 580px) {
    .chat-sidebar { display: none; }
}
</style>

{{-- ── Page header ───────────────────────────────────────── --}}
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

{{-- ── Chat shell ────────────────────────────────────────── --}}
<div class="chat-shell">

    {{-- LEFT: Available users section --}}
    <div class="chat-users">
        <div class="users-header">
            <h3 class="users-title">Available Users</h3>
            <div class="users-search">
                <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Search users...">
            </div>
        </div>

        <div class="users-list">
            @foreach($hrUsers as $hrUser)
                @php
                    $initials = strtoupper(substr($hrUser->first_name, 0, 1) . substr($hrUser->last_name, 0, 1));
                    $isActive = $selectedConversation === $hrUser->id;
                @endphp
                <div class="user-item {{ $isActive ? 'active' : '' }}" 
                     wire:click="selectConversation('{{ $hrUser->id }}')"
                     style="cursor: pointer;">
                    <div class="user-avatar">{{ $initials }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ $hrUser->first_name }} {{ $hrUser->last_name }}</div>
                        <div class="user-role">{{ ucfirst($hrUser->role->value) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- MIDDLE: Recent conversations section --}}
    <div class="chat-conversations">
        <div class="conversations-header">
            <h3 class="conversations-title">Recent Messages</h3>
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
                        $latest  = $msgs->first();
                        $isSent  = $latest->sender_id === Auth::id();
                        $person  = $isSent ? $latest->receiver : $latest->sender;
                        $unread  = $msgs->where('receiver_id', Auth::id())->where('is_read', false)->count();
                        $initials = strtoupper(substr($person->first_name, 0, 1) . substr($person->last_name, 0, 1));
                        $isActive = $selectedConversation === $personId;
                    @endphp
                    <div class="conversation-item {{ $isActive ? 'active' : '' }}" 
                         wire:click="selectConversation('{{ $personId }}')"
                         style="cursor: pointer;">
                        <div class="conv-avatar">{{ $initials }}</div>
                        <div class="conv-info">
                            <div class="conv-name">{{ $person->first_name }} {{ $person->last_name }}</div>
                            <div class="conv-preview">{{ Str::limit($latest->message, 35) }}</div>
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
                <div style="padding: 32px 16px; text-align:center; color:#999; font-size:13px;">
                    No recent messages
                </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: chat main area --}}
    <div class="chat-main">

        {{-- Chat header (shows selected person) --}}
        @if($selectedConversation && $conversationMessages && $conversationMessages->count() > 0)
            @php
                $latest   = $conversationMessages->first();
                $isSent   = $latest->sender_id === Auth::id();
                $chatWith = $isSent ? $latest->receiver : $latest->sender;
                $chatInitials = strtoupper(substr($chatWith->first_name, 0, 1) . substr($chatWith->last_name, 0, 1));
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
        @else
            <div class="chat-header">
                <div class="chat-header-left">
                    <div class="chat-user-avatar" style="background:#f0f0ea;color:#aaa">HR</div>
                    <div>
                        <p class="chat-user-name" style="color:#aaa">No conversation selected</p>
                        <p class="chat-user-status" style="color:#ccc">Send a message to start</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Messages feed --}}
        <div class="chat-messages">
            @if($conversationMessages && $conversationMessages->count() > 0)
                @foreach($conversationMessages as $message)
                    @php
                        $isSent   = $message->sender_id === Auth::id();
                        $isUnread = $message->receiver_id === Auth::id() && !$message->is_read;
                    @endphp
                    <div class="msg-row {{ $isSent ? 'sent' : 'recv' }}">
                        <div class="msg-wrap">
                            @if($message->subject)
                                <div class="msg-subject-label" style="color: {{ $isSent ? '#a9b2e4' : '#888' }}">
                                    {{ $message->subject }}
                                </div>
                            @endif
                            <div class="bubble {{ $isSent ? 'sent' : 'recv' }}">
                                {{ $message->message }}
                            </div>
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
                    <svg viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p>Select a conversation to view messages</p>
                    <p style="font-size:12px">Click on a contact from the left sidebar to start chatting</p>
                </div>
            @endif
        </div>

        {{-- Compose new message --}}
        <div class="compose-new-msg">
           

            @if(session()->has('success'))
                <div class="flash-ok">{{ session('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="flash-err">{{ session('error') }}</div>
            @endif

            <form wire:submit="sendMessage">
                <div class="cmp-field" style="margin-bottom:0">
                    <label>Message</label>
                    <textarea wire:model="messageContent" placeholder="Type your message here..."></textarea>
                    @error('messageContent') <span class="cmp-error">{{ $message }}</span> @enderror
                </div>

                <div class="compose-bottom-row">
                   
                    <button type="submit" class="btn-send">
                        <svg viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Send Message
                    </button>
                </div>
            </form>
        </div>

    </div>{{-- /chat-main --}}
</div>{{-- /chat-shell --}}

{{-- ── Floating nav ──────────────────────────────────────── --}}
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

</div>{{-- /msg-root --}}