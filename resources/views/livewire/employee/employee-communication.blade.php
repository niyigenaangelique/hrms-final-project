<div class="msg-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.msg-root {
    --glass-bg:       rgba(255,255,255,0.45);
    --glass-strong:   rgba(255,255,255,0.70);
    --glass-border:   rgba(255,255,255,0.70);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(24px) saturate(1.8);
    --radius:         24px;
    --radius-sm:      14px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    --teal:           #0d9488;
    --teal-light:     rgba(13,148,136,0.12);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 36px 40px 120px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
    min-height: 100vh;
}

/* ── Glass card ───────────────────────────────────────── */
.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    position: relative;
}

.g-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.95), transparent);
    pointer-events: none; z-index: 1;
}

/* ── Animated entrance ────────────────────────────────── */
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateX(-12px); }
    to   { opacity: 1; transform: translateX(0); }
}

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.94); }
    to   { opacity: 1; transform: scale(1); }
}

@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
}

@keyframes pulse-teal {
    0%, 100% { box-shadow: 0 0 0 0 rgba(13,148,136,0.4); }
    50%       { box-shadow: 0 0 0 8px rgba(13,148,136,0); }
}

@keyframes bounce-in {
    0%   { transform: scale(0.8); opacity: 0; }
    60%  { transform: scale(1.05); }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
    30%            { transform: translateY(-4px); opacity: 1; }
}

.anim-1 { animation: fadeSlideUp 0.4s ease both; }
.anim-2 { animation: fadeSlideUp 0.4s 0.08s ease both; }
.anim-3 { animation: fadeSlideUp 0.4s 0.16s ease both; }

/* ── Page header ──────────────────────────────────────── */
.msg-header {
    padding: 26px 32px;
    display: flex; justify-content: space-between; align-items: center; gap: 16px;
}

.msg-header-left { display: flex; align-items: center; gap: 14px; }

.msg-icon-wrap {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(13,148,136,0.35), inset 0 1px 0 rgba(255,255,255,0.25);
    flex-shrink: 0;
}

.msg-icon-wrap svg { width: 22px; height: 22px; stroke: #fff; }

.msg-header-left h1 { font-size: 26px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 2px; }
.msg-header-left p  { font-size: 13.5px; font-weight: 500; color: var(--text-secondary); margin: 0; }

.msg-header-right { display: flex; align-items: center; gap: 12px; }

.msg-unread-pill {
    display: flex; align-items: center; gap: 7px;
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: var(--radius-pill);
    padding: 6px 16px;
    animation: bounce-in 0.5s 0.3s ease both;
}

.msg-unread-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #ef4444;
    animation: pulse-teal 1.8s infinite;
    box-shadow: 0 0 0 0 rgba(239,68,68,0.4);
}

.msg-unread-text { font-size: 13px; font-weight: 700; color: #b91c1c; }

.btn-compose {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 14px rgba(13,148,136,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
    animation: scaleIn 0.4s 0.2s ease both;
}

.btn-compose:hover { transform: translateY(-1px) scale(1.02); box-shadow: 0 6px 20px rgba(13,148,136,0.45); }
.btn-compose svg   { width: 15px; height: 15px; stroke: #fff; transition: transform 0.2s; }
.btn-compose:hover svg { transform: rotate(15deg) scale(1.1); }

/* ── Main layout ──────────────────────────────────────── */
.msg-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 20px;
    align-items: start;
}

/* ── Message feed ─────────────────────────────────────── */
.msg-feed-wrap { display: flex; flex-direction: column; gap: 14px; }

/* ── Conversation thread card ─────────────────────────── */
.msg-thread {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    position: relative;
    animation: fadeSlideIn 0.35s ease both;
}

.msg-thread::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

.msg-thread.unread {
    border-color: rgba(37,99,235,0.25);
    background: rgba(37,99,235,0.05);
}

.msg-thread.unread::after {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #3b82f6, #6366f1);
    border-radius: 0 3px 3px 0;
}

/* Thread header */
.msg-thread-head {
    display: flex; align-items: center; gap: 14px;
    padding: 16px 20px 12px;
}

.msg-avatar-lg {
    width: 42px; height: 42px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 14px; font-weight: 700;
    position: relative;
}

.avatar-sent     { background: linear-gradient(135deg, rgba(13,148,136,0.2), rgba(8,145,178,0.2)); color: #0d9488; border: 1.5px solid rgba(13,148,136,0.3); }
.avatar-received { background: linear-gradient(135deg, rgba(37,99,235,0.15), rgba(99,102,241,0.15)); color: #3b82f6; border: 1.5px solid rgba(37,99,235,0.25); }

.msg-avatar-lg svg { width: 18px; height: 18px; stroke: currentColor; }

.msg-thread-info { flex: 1; min-width: 0; }
.msg-thread-name { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 2px; }
.msg-thread-to   { font-size: 12px; font-weight: 500; color: var(--text-tertiary); margin: 0; }

.msg-thread-meta { text-align: right; flex-shrink: 0; display: flex; flex-direction: column; align-items: flex-end; gap: 6px; }
.msg-thread-time { font-size: 11.5px; font-weight: 500; color: var(--text-tertiary); }

.btn-mark-read {
    font-size: 11px; font-weight: 600; color: #3b82f6;
    background: rgba(37,99,235,0.08);
    border: none; border-radius: 6px; cursor: pointer;
    padding: 3px 9px;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.15s;
}

.btn-mark-read:hover { background: rgba(37,99,235,0.15); }

/* Chat bubble */
.msg-bubble-body {
    margin: 0 16px 16px;
    padding: 14px 18px;
    border-radius: 6px 18px 18px 18px;
    position: relative;
    transition: transform 0.15s;
}

.msg-thread.sent .msg-bubble-body {
    background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08));
    border: 1px solid rgba(13,148,136,0.18);
    border-radius: 18px 6px 18px 18px;
    margin-left: 40px;
}

.msg-thread.received .msg-bubble-body {
    background: rgba(255,255,255,0.65);
    border: 1px solid rgba(255,255,255,0.9);
    margin-right: 40px;
}

.msg-thread:hover .msg-bubble-body { transform: translateY(-1px); }

.msg-subject { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0 0 5px; }
.msg-body    { font-size: 13.5px; font-weight: 400; color: var(--text-secondary); margin: 0; line-height: 1.6; }

/* Thread footer */
.msg-thread-footer {
    display: flex; align-items: center; gap: 8px;
    padding: 0 20px 14px;
}

.badge { display: inline-flex; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: var(--radius-pill); }
.badge-green { background: rgba(34,197,94,0.14); color: #15803d; }
.badge-gray  { background: rgba(0,0,0,0.07);     color: var(--text-secondary); }
.badge-blue  { background: rgba(37,99,235,0.12); color: #1d4ed8; }

/* ── Empty feed ───────────────────────────────────────── */
.msg-empty {
    text-align: center; padding: 64px 24px;
    animation: fadeSlideUp 0.5s ease both;
}

.msg-empty-icon-wrap {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, rgba(13,148,136,0.1), rgba(8,145,178,0.08));
    border: 1px solid rgba(13,148,136,0.15);
    border-radius: 22px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
}

.msg-empty-icon-wrap svg { width: 32px; height: 32px; stroke: #0d9488; }
.msg-empty-title { font-size: 17px; font-weight: 700; color: var(--text-primary); margin: 0 0 6px; }
.msg-empty-sub   { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0 0 22px; }

/* ── Compose sidebar ──────────────────────────────────── */
.msg-compose {
    position: sticky;
    top: 24px;
}

.compose-inner {
    background: var(--glass-strong);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    position: relative;
    animation: scaleIn 0.4s 0.1s ease both;
}

.compose-inner::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.95), transparent);
    pointer-events: none;
}

/* Decorative glow inside compose */
.compose-glow {
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(13,148,136,0.12) 0%, transparent 70%);
    pointer-events: none;
}

.compose-head {
    padding: 20px 22px 16px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    display: flex; align-items: center; gap: 10px;
    position: relative; z-index: 1;
}

.compose-head-icon {
    width: 32px; height: 32px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(13,148,136,0.3);
    flex-shrink: 0;
}

.compose-head-icon svg { width: 15px; height: 15px; stroke: #fff; }
.compose-head-title { font-size: 14px; font-weight: 700; color: var(--text-primary); }

.compose-form { padding: 18px 22px 22px; display: flex; flex-direction: column; gap: 14px; position: relative; z-index: 1; }

/* Flash messages inside compose */
.cmp-flash-ok  { background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.3); border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 600; color: #15803d; animation: bounce-in 0.4s ease; }
.cmp-flash-err { background: rgba(239,68,68,0.10); border: 1px solid rgba(239,68,68,0.25); border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 600; color: #b91c1c; animation: bounce-in 0.4s ease; }

.cmp-field { display: flex; flex-direction: column; gap: 5px; }

.cmp-field label {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-tertiary);
}

.cmp-field input,
.cmp-field select,
.cmp-field textarea {
    width: 100%; padding: 10px 13px;
    background: rgba(255,255,255,0.65);
    border: 1px solid rgba(0,0,0,0.09);
    border-radius: 11px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500;
    color: var(--text-primary);
    outline: none; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    -webkit-appearance: none;
}

.cmp-field input:focus,
.cmp-field select:focus,
.cmp-field textarea:focus {
    border-color: rgba(13,148,136,0.55);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
    background: rgba(255,255,255,0.9);
}

.cmp-field textarea { resize: vertical; min-height: 100px; }

.cmp-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 32px;
}

.cmp-error { font-size: 11.5px; font-weight: 500; color: #dc2626; }

.btn-send-msg {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px;
    background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
    color: #fff; border: none; border-radius: 13px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 16px rgba(13,148,136,0.35);
    transition: transform 0.15s, box-shadow 0.15s;
    width: 100%;
    position: relative; overflow: hidden;
}

/* Shimmer effect on button */
.btn-send-msg::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.18) 50%, transparent 100%);
    background-size: 200% 100%;
    opacity: 0;
    transition: opacity 0.2s;
}

.btn-send-msg:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,0.45); }
.btn-send-msg:hover::after { opacity: 1; animation: shimmer 1.2s infinite; }
.btn-send-msg:active { transform: translateY(0) scale(0.98); }
.btn-send-msg svg { width: 17px; height: 17px; stroke: #fff; transition: transform 0.2s; }
.btn-send-msg:hover svg { transform: translateX(3px) rotate(-30deg); }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%;
    transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.75);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}

.ios-nav::before {
    content: ''; position: absolute;
    top: 0; left: 16px; right: 16px; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
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
.ios-nav-item:hover svg { transform: scale(1.1); }
.ios-nav-item.active { color: #fff; background: rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke: #60a5fa; }
.ios-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #60a5fa; }
.ios-nav-unread { position: absolute; top: 5px; right: 10px; width: 7px; height: 7px; border-radius: 50%; background: #ef4444; border: 1.5px solid rgba(15,15,25,0.75); }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1024px) {
    .msg-layout { grid-template-columns: 1fr; }
    .msg-compose { position: static; }
}

@media (max-width: 640px) {
    .msg-root { padding: 20px 16px 110px; }
    .msg-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header ──────────────────────────────────────── --}}
<div class="g-card anim-1">
    <div class="msg-header">
        <div class="msg-header-left">
            <div class="msg-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h1>Messages</h1>
                <p>Communicate with the HR team</p>
            </div>
        </div>
        <div class="msg-header-right">
            @if($unreadCount > 0)
                <div class="msg-unread-pill">
                    <span class="msg-unread-dot"></span>
                    <span class="msg-unread-text">{{ $unreadCount }} unread</span>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Main layout: feed left, compose right ────────────── --}}
<div class="msg-layout">

    {{-- ── Message feed ──────────────────────────────────── --}}
    <div class="msg-feed-wrap anim-2">
        @if($messageList->count() > 0)
            @foreach($messageList as $i => $message)
                @php
                    $isSent   = $message->sender_id === Auth::id();
                    $isUnread = $message->receiver_id === Auth::id() && !$message->is_read;
                @endphp
                <div class="msg-thread {{ $isSent ? 'sent' : 'received' }} {{ $isUnread ? 'unread' : '' }}"
                     style="animation-delay: {{ $i * 0.06 }}s">

                    {{-- Thread header --}}
                    <div class="msg-thread-head">
                        <div class="msg-avatar-lg {{ $isSent ? 'avatar-sent' : 'avatar-received' }}">
                            @if($isSent)
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="msg-thread-info">
                            <p class="msg-thread-name">
                                {{ $isSent ? 'You → ' . $message->receiver->first_name . ' ' . $message->receiver->last_name : $message->sender->first_name . ' ' . $message->sender->last_name }}
                            </p>
                            <p class="msg-thread-to">
                                {{ $isSent ? 'Sent message' : 'Received message' }}
                            </p>
                        </div>
                        <div class="msg-thread-meta">
                            <span class="msg-thread-time">{{ $message->created_at->format('M d · H:i') }}</span>
                            @if($isUnread)
                                <button class="btn-mark-read" wire:click="markAsRead({{ $message->id }})">Mark read</button>
                            @endif
                        </div>
                    </div>

                    {{-- Chat bubble --}}
                    <div class="msg-bubble-body">
                        <p class="msg-subject">{{ $message->subject }}</p>
                        <p class="msg-body">{{ $message->message }}</p>
                    </div>

                    {{-- Footer badges --}}
                    <div class="msg-thread-footer">
                        <span class="badge {{ $message->status === 'sent' ? 'badge-green' : 'badge-gray' }}">
                            {{ ucfirst($message->status) }}
                        </span>
                        @if($isUnread)
                            <span class="badge badge-blue">New</span>
                        @endif
                    </div>

                </div>
            @endforeach
        @else
            <div class="g-card">
                <div class="msg-empty">
                    <div class="msg-empty-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="msg-empty-title">No messages yet</p>
                    <p class="msg-empty-sub">Send your first message to the HR team using the form →</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ── Compose sidebar ───────────────────────────────── --}}
    <div class="msg-compose anim-3">
        <div class="compose-inner">
            <div class="compose-glow"></div>

            <div class="compose-head">
                <div class="compose-head-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </div>
                <span class="compose-head-title">New Message</span>
            </div>

            @if(session()->has('success'))
                <div style="padding: 0 22px;">
                    <div class="cmp-flash-ok">{{ session('success') }}</div>
                </div>
            @endif
            @if(session()->has('error'))
                <div style="padding: 0 22px;">
                    <div class="cmp-flash-err">{{ session('error') }}</div>
                </div>
            @endif

            <form wire:submit="sendMessage" class="compose-form">
                <div class="cmp-field">
                    <label>Send To</label>
                    <select wire:model="selectedHrUser">
                        <option value="">Select HR Personnel</option>
                        @foreach($hrUsers as $hrUser)
                            <option value="{{ $hrUser->id }}">
                                {{ $hrUser->first_name }} {{ $hrUser->last_name }} ({{ $hrUser->role->value }})
                            </option>
                        @endforeach
                    </select>
                    @error('selectedHrUser') <span class="cmp-error">{{ $message }}</span> @enderror
                </div>

                <div class="cmp-field">
                    <label>Subject</label>
                    <input type="text" wire:model="subject" placeholder="What's this about?">
                    @error('subject') <span class="cmp-error">{{ $message }}</span> @enderror
                </div>

                <div class="cmp-field">
                    <label>Message</label>
                    <textarea wire:model="messageContent" placeholder="Type your message here..."></textarea>
                    @error('messageContent') <span class="cmp-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-send-msg">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Send Message
                </button>
            </form>
        </div>
    </div>

</div>{{-- /msg-layout --}}

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