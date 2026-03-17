<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.hcom-root {
    --glass-bg:       rgba(255,255,255,0.50);
    --glass-strong:   rgba(255,255,255,0.72);
    --glass-border:   rgba(255,255,255,0.72);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(22px) saturate(1.7);
    --radius:         20px;
    --radius-sm:      13px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 32px 36px 110px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeSlideUp 0.35s ease both; }
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }
.anim-3 { animation: fadeSlideUp 0.35s 0.14s ease both; }

/* ── Glass card ───────────────────────────────────────── */
.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    position: relative;
}
.g-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none; border-radius: var(--radius) var(--radius) 0 0;
}

/* ── Header ───────────────────────────────────────────── */
.hcom-header {
    padding: 24px 30px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
}
.hcom-header h1 { font-size: 24px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 3px; }
.hcom-header p  { font-size: 13.5px; font-weight: 500; color: var(--text-secondary); margin: 0; }

.hcom-badge {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: #fff; padding: 6px 12px; border-radius: var(--radius-pill);
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
    box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}

/* ── Layout ─────────────────────────────────────────── */
.hcom-layout {
    display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
}

/* ── Form card ───────────────────────────────────────── */
.hcom-form-head { padding: 20px 24px 16px; border-bottom: 1px solid rgba(0,0,0,0.055); }
.hcom-form-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0; }
.hcom-form-body { padding: 20px 24px 24px; }

.hcom-fields { display: flex; flex-direction: column; gap: 16px; }

.hcom-field { display: flex; flex-direction: column; gap: 6px; }
.hcom-field label {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary);
}

.hcom-field select,
.hcom-field input,
.hcom-field textarea {
    width: 100%; padding: 11px 14px;
    background: rgba(255,255,255,0.78) !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    border-radius: var(--radius-sm) !important;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary);
    outline: none; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    -webkit-appearance: none;
}

.hcom-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 14px center !important;
    padding-right: 36px !important;
}

.hcom-field select:focus,
.hcom-field input:focus,
.hcom-field textarea:focus {
    border-color: rgba(13,148,136,0.55) !important;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1) !important;
    background: rgba(255,255,255,0.96) !important;
}

.hcom-field textarea { resize: vertical; min-height: 110px; }

.hcom-field-error {
    font-size: 11px; font-weight: 600;
    color: #dc2626; margin-top: 2px;
}

.btn-send {
    width: 100%; padding: 13px 24px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 16px rgba(13,148,136,0.32);
    transition: transform 0.15s, box-shadow 0.15s;
}
.btn-send:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(13,148,136,0.42); }

/* ── Message history ───────────────────────────────────── */
.hcom-history-head { padding: 20px 24px 16px; border-bottom: 1px solid rgba(0,0,0,0.055); }
.hcom-history-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0; }
.hcom-history-body { padding: 16px 24px 24px; }

.hcom-message {
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 14px 16px; margin-bottom: 12px;
    transition: box-shadow 0.15s;
}
.hcom-message:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.07); }
.hcom-message.unread { background: rgba(59,130,246,0.08); border-color: rgba(59,130,246,0.2); }
.hcom-message:last-child { margin-bottom: 0; }

.hcom-message-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 8px;
}
.hcom-message-sender { font-size: 14px; font-weight: 700; color: var(--text-primary); }
.hcom-message-subject { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin-top: 2px; }
.hcom-message-meta { text-align: right; flex-shrink: 0; margin-left: 16px; }
.hcom-message-date { font-size: 11px; font-weight: 500; color: var(--text-tertiary); }
.hcom-message-read { font-size: 11px; font-weight: 600; color: #2563eb; cursor: pointer; margin-top: 4px; transition: color 0.15s; }
.hcom-message-read:hover { color: #1d4ed8; }

.hcom-message-content {
    font-size: 13px; font-weight: 500; color: var(--text-secondary);
    line-height: 1.5; margin-bottom: 8px;
}

.hcom-message-status { display: inline-block; margin-top: 4px; }

/* Badges */
.badge { display: inline-flex; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: var(--radius-pill); }
.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }

/* Flash messages */
.hcom-flash { padding: 0 24px; margin-bottom: 4px; }
.flash-ok  { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.28); border-radius: var(--radius-sm); padding: 12px 16px; font-size: 13px; font-weight: 600; color: #15803d; }
.flash-err { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.22); border-radius: var(--radius-sm); padding: 12px 16px; font-size: 13px; font-weight: 600; color: #b91c1c; }

/* Empty state */
.hcom-empty { text-align: center; padding: 40px 24px; }
.hcom-empty-icon { width: 48px; height: 48px; background: rgba(0,0,0,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.hcom-empty-icon svg { width: 24px; height: 24px; stroke: var(--text-tertiary); }
.hcom-empty-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.hcom-empty-sub   { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.75);
    backdrop-filter: blur(32px) saturate(2); -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13); border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}
.ios-nav::before { content: ''; position: absolute; top: 0; left: 16px; right: 16px; height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent); }
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

@media (max-width: 1024px) { .hcom-layout { grid-template-columns: 1fr; } }
@media (max-width: 768px) { 
    .hcom-root { padding: 18px 14px 100px; } 
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; } 
    .ios-nav-item svg { width: 18px; height: 18px; } 
}
</style>

<div class="hcom-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="hcom-header">
            <div>
                <h1>HR Communication</h1>
                <p>Communicate with employees</p>
            </div>
            @if($unreadCount > 0)
                <div class="hcom-badge">{{ $unreadCount }} unread message{{ $unreadCount > 1 ? 's' : '' }}</div>
            @endif
        </div>
    </div>

    {{-- ── Two-column layout ─────────────────────────── --}}
    <div class="hcom-layout">

        {{-- ── Send message form ─────────────────────── --}}
        <div class="g-card anim-2">
            <div class="hcom-form-head">
                <h3 class="hcom-form-title">Send Message</h3>
            </div>
            <div class="hcom-form-body">
                {{-- Flash messages --}}
                @if(session()->has('success') || session()->has('error'))
                    <div class="hcom-flash" style="padding-top:16px;">
                        @if(session()->has('success')) <div class="flash-ok">{{ session('success') }}</div> @endif
                        @if(session()->has('error'))   <div class="flash-err">{{ session('error') }}</div> @endif
                    </div>
                @endif

                <form wire:submit="sendMessage">
                    <div class="hcom-fields">
                        {{-- Employee selection --}}
                        <div class="hcom-field">
                            <label>Send To</label>
                            <select wire:model="selectedEmployee">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->code }})</option>
                                @endforeach
                            </select>
                            @error('selectedEmployee') <span class="hcom-field-error">{{ $message }}</span> @enderror
                        </div>

                        {{-- Subject --}}
                        <div class="hcom-field">
                            <label>Subject</label>
                            <input wire:model="subject" type="text" placeholder="Enter message subject"/>
                            @error('subject') <span class="hcom-field-error">{{ $message }}</span> @enderror
                        </div>

                        {{-- Message --}}
                        <div class="hcom-field">
                            <label>Message</label>
                            <textarea wire:model="messageContent" placeholder="Type your message here..."></textarea>
                            @error('messageContent') <span class="hcom-field-error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn-send">Send Message</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Message history ───────────────────────── --}}
        <div class="g-card anim-3">
            <div class="hcom-history-head">
                <h3 class="hcom-history-title">Message History</h3>
            </div>
            <div class="hcom-history-body">
                @if($messageList->count() > 0)
                    @foreach($messageList as $message)
                        <div class="hcom-message @if(!$message->is_read && $message->receiver_id === auth()->id()) unread @endif">
                            <div class="hcom-message-header">
                                <div>
                                    <div class="hcom-message-sender">
                                        @if($message->sender_id === auth()->id())
                                            To: {{ $message->receiver->first_name }} {{ $message->receiver->last_name }}
                                        @else
                                            From: {{ $message->sender->first_name }} {{ $message->sender->last_name }}
                                        @endif
                                    </div>
                                    <div class="hcom-message-subject">{{ $message->subject }}</div>
                                </div>
                                <div class="hcom-message-meta">
                                    <div class="hcom-message-date">{{ $message->created_at->format('M d, Y H:i') }}</div>
                                    @if(!$message->is_read && $message->receiver_id === auth()->id())
                                        <button wire:click="markAsRead({{ $message->id }})" class="hcom-message-read">
                                            Mark as read
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="hcom-message-content">{{ $message->message }}</div>
                            <div class="hcom-message-status">
                                <span class="badge badge-{{ $message->status === 'sent' ? 'green' : 'gray' }}">
                                    {{ ucfirst($message->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="hcom-empty">
                        <div class="hcom-empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="hcom-empty-title">No messages found</p>
                        <p class="hcom-empty-sub">Start a conversation with an employee.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Floating nav ───────────────────────────────────── --}}
    <nav class="ios-nav">
        <a href="{{ route('leave-attendance.dashboard') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Dashboard
        </a>
        <a href="{{ route('leave-attendance.requests') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Leave
        </a>
        <a href="{{ route('leave-attendance.hr-leave-management') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Manage
        </a>
        <a href="{{ route('leave-attendance.hr-calendar') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Calendar
        </a>
        <a href="{{ route('employees') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            Employees
        </a>
        <a href="{{ route('leave-attendance.hr-communication') }}" class="ios-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Messages
            <span class="ios-nav-active-dot"></span>
        </a>
    </nav>

</div>
</div>
