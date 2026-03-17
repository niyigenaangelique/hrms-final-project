<div class="lr-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.lr-root {
    --glass-bg:       rgba(255,255,255,0.45);
    --glass-strong:   rgba(255,255,255,0.65);
    --glass-border:   rgba(255,255,255,0.65);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(24px) saturate(1.8);
    --radius:         20px;
    --radius-sm:      12px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.72);
    --text-tertiary:  rgba(15,15,25,0.50);
    --teal:           #0d9488;
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 36px 40px 120px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
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
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

/* ── Two column layout ────────────────────────────────── */
.lr-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 20px;
    align-items: start;
}

/* ── Page header ──────────────────────────────────────── */
.lr-header { padding: 28px 32px; }
.lr-title { font-size: 28px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 4px; }
.lr-subtitle { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Flash messages ───────────────────────────────────── */
.lr-flash-ok  { background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.3); border-radius: var(--radius-sm); padding: 13px 18px; font-size: 14px; font-weight: 600; color: #15803d; }
.lr-flash-err { background: rgba(239,68,68,0.10); border: 1px solid rgba(239,68,68,0.25); border-radius: var(--radius-sm); padding: 13px 18px; font-size: 14px; font-weight: 600; color: #b91c1c; }

/* ── Form ─────────────────────────────────────────────── */
.lr-form-body { padding: 28px 32px; }

.lr-fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap: 18px;
}

.lr-field { display: flex; flex-direction: column; gap: 6px; }
.lr-field.full { grid-column: span 2; }

.lr-field label {
    font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary);
}

.lr-field input,
.lr-field select,
.lr-field textarea {
    width: 100%; padding: 11px 15px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary);
    outline: none; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
    -webkit-appearance: none;
}

.lr-field input:focus,
.lr-field select:focus,
.lr-field textarea:focus {
    border-color: rgba(13,148,136,0.5);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
    background: rgba(255,255,255,0.9);
}

.lr-field textarea { resize: vertical; min-height: 110px; }

.lr-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
}

.lr-error { font-size: 12px; font-weight: 500; color: #dc2626; margin-top: 2px; }

/* ── Submit button ────────────────────────────────────── */
.lr-submit-row { margin-top: 22px; }

.btn-submit {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(13,148,136,0.35);
    transition: transform 0.15s, box-shadow 0.15s;
}

.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(13,148,136,0.45); }
.btn-submit svg { width: 16px; height: 16px; stroke: #fff; }

/* ── Balance sidebar ──────────────────────────────────── */
.lr-balance-head {
    padding: 22px 24px 16px;
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary);
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.lr-balance-list { padding: 12px 16px 16px; display: flex; flex-direction: column; gap: 10px; }

.lr-balance-item {
    background: rgba(255,255,255,0.55);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 14px 16px;
    backdrop-filter: var(--blur);
    transition: box-shadow 0.15s;
}

.lr-balance-item:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.06); }

.lr-balance-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 4px; }
.lr-balance-name { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; }
.lr-balance-desc { font-size: 12px; font-weight: 500; color: var(--text-secondary); margin: 4px 0 0; line-height: 1.4; }

.lr-balance-meta { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }

.lr-pill {
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: var(--radius-pill);
}

.lr-pill-teal   { background: rgba(13,148,136,0.12); color: #0d9488; }
.lr-pill-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }
.lr-pill-blue   { background: rgba(37,99,235,0.10);  color: #2563eb; }
.lr-pill-amber  { background: rgba(245,158,11,0.12); color: #b45309; }

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

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1024px) {
    .lr-grid { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .lr-root { padding: 20px 16px 110px; }
    .lr-fields { grid-template-columns: 1fr; }
    .lr-field.full { grid-column: span 1; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- Flash messages --}}
@if(session()->has('success'))
    <div class="lr-flash-ok">{{ session('success') }}</div>
@endif

@if(session()->has('error'))
    <div class="lr-flash-err">{{ session('error') }}</div>
@endif

{{-- ── Page header ──────────────────────────────────── --}}
<div class="g-card">
    <div class="lr-header">
        <h1 class="lr-title">Request Leave</h1>
        <p class="lr-subtitle">Submit your leave request for approval</p>
    </div>
</div>

{{-- ── Two-column: form left, balance right ─────────── --}}
<div class="lr-grid">

    {{-- Leave request form --}}
    <div class="g-card">
        <div class="lr-form-body">
            <form wire:submit="submit">
                <div class="lr-fields">

                    {{-- Leave type --}}
                    <div class="lr-field">
                        <label>Leave Type</label>
                        <select wire:model="leave_type_id">
                            <option value="">Select leave type</option>
                            @foreach($leaveTypes as $leaveType)
                                <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id') <span class="lr-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Empty cell to keep grid aligned --}}
                    <div></div>

                    {{-- Start date --}}
                    <div class="lr-field">
                        <label>Start Date</label>
                        <input type="date" wire:model="start_date">
                        @error('start_date') <span class="lr-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- End date --}}
                    <div class="lr-field">
                        <label>End Date</label>
                        <input type="date" wire:model="end_date">
                        @error('end_date') <span class="lr-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Reason --}}
                    <div class="lr-field full">
                        <label>Reason</label>
                        <textarea wire:model="reason" placeholder="Please provide a reason for your leave request..."></textarea>
                        @error('reason') <span class="lr-error">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="lr-submit-row">
                    <button type="submit" class="btn-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
                        Submit Leave Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Leave balance sidebar --}}
    <div class="g-card">
        <div class="lr-balance-head">Leave Balance</div>
        <div class="lr-balance-list">
            @foreach($leaveTypes as $leaveType)
                <div class="lr-balance-item">
                    <div class="lr-balance-top">
                        <p class="lr-balance-name">{{ $leaveType->name }}</p>
                    </div>
                    @if($leaveType->description)
                        <p class="lr-balance-desc">{{ $leaveType->description }}</p>
                    @endif
                    <div class="lr-balance-meta">
                        @if($leaveType->requires_approval)
                            <span class="lr-pill lr-pill-amber">Requires approval</span>
                        @else
                            <span class="lr-pill lr-pill-teal">Auto-approved</span>
                        @endif
                        @if($leaveType->allow_carry_forward)
                            <span class="lr-pill lr-pill-blue">Carry forward {{ $leaveType->max_carry_forward_days }}d</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>{{-- /lr-grid --}}

{{-- ── Floating nav ──────────────────────────────────── --}}
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
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Leave
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="#" class="ios-nav-item" style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

</div>{{-- /lr-root --}}