<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.hlr-root {
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

/* ── Animations ───────────────────────────────────────── */
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

/* ── Page header ──────────────────────────────────────── */
.hlr-header { padding: 24px 30px; display: flex; align-items: center; gap: 14px; }
.hlr-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 14px rgba(13,148,136,0.35); flex-shrink: 0;
}
.hlr-header-icon svg { width: 21px; height: 21px; stroke: #fff; }
.hlr-header h1 { font-size: 24px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 3px; }
.hlr-header p  { font-size: 13.5px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Main layout ──────────────────────────────────────── */
.hlr-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items: start;
}

/* ── Form card ────────────────────────────────────────── */
.hlr-form-body { padding: 24px 28px 28px; }

.hlr-fields { display: flex; flex-direction: column; gap: 20px; }

.hlr-field { display: flex; flex-direction: column; gap: 6px; }
.hlr-field label {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary);
}

.hlr-field select,
.hlr-field input[type="date"],
.hlr-field input[type="file"],
.hlr-field textarea {
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

.hlr-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 14px center !important;
    padding-right: 36px !important;
}

.hlr-field select:focus,
.hlr-field input:focus,
.hlr-field textarea:focus {
    border-color: rgba(13,148,136,0.55) !important;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1) !important;
    background: rgba(255,255,255,0.96) !important;
}

.hlr-field textarea { resize: vertical; min-height: 110px; }

.hlr-field input[type="file"] {
    padding: 9px 14px;
    cursor: pointer;
    font-size: 13px;
}

.hlr-field-hint {
    font-size: 11.5px; font-weight: 500;
    color: var(--text-tertiary); margin-top: 2px;
}

.hlr-field-error {
    font-size: 11.5px; font-weight: 600;
    color: #dc2626; margin-top: 2px;
}

/* Date grid */
.hlr-date-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* ── Info banners ─────────────────────────────────────── */
.hlr-info-banner {
    display: flex; align-items: flex-start; gap: 11px;
    padding: 13px 16px; border-radius: var(--radius-sm);
}
.hlr-info-banner svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
.hlr-info-banner-text { font-size: 13.5px; font-weight: 500; }
.hlr-info-banner strong { font-weight: 700; }

.banner-blue   { background: rgba(37,99,235,0.08); border: 1px solid rgba(37,99,235,0.2); }
.banner-blue   svg { stroke: #2563eb; }
.banner-blue   .hlr-info-banner-text { color: #1e40af; }

.banner-amber  { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.22); }
.banner-amber  svg { stroke: #d97706; }
.banner-amber  .hlr-info-banner-text { color: #92400e; }

.banner-red    { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); }
.banner-red    svg { stroke: #dc2626; }
.banner-red    .hlr-info-banner-text { color: #991b1b; }

/* Conflict list */
.hlr-conflict-list { margin: 8px 0 0; padding-left: 16px; }
.hlr-conflict-list li { font-size: 12.5px; font-weight: 500; color: #92400e; margin-bottom: 3px; }

/* ── Submit button ────────────────────────────────────── */
.hlr-submit-row { display: flex; justify-content: flex-end; margin-top: 4px; }

.btn-submit-leave {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 16px rgba(13,148,136,0.32);
    transition: transform 0.15s, box-shadow 0.15s;
}
.btn-submit-leave:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(13,148,136,0.42); }
.btn-submit-leave:active { transform: scale(0.98); }
.btn-submit-leave svg { width: 16px; height: 16px; stroke: #fff; }

/* Spinner */
@keyframes spin { to { transform: rotate(360deg); } }
.hlr-spinner { animation: spin 0.7s linear infinite; }

/* ── Sidebar cards ────────────────────────────────────── */
.hlr-sidebar { display: flex; flex-direction: column; gap: 16px; }

.hlr-side-head { padding: 18px 22px 14px; border-bottom: 1px solid rgba(0,0,0,0.055); }
.hlr-side-title { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; }
.hlr-side-body  { padding: 14px 22px 18px; }

/* Balance rows */
.hlr-bal-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);
}
.hlr-bal-row:last-child { border-bottom: none; }
.hlr-bal-label { font-size: 13px; font-weight: 500; color: var(--text-secondary); }
.hlr-bal-value { font-size: 14px; font-weight: 700; color: var(--text-primary); }
.hlr-bal-value.blue   { color: #2563eb; font-size: 18px; }
.hlr-bal-value.green  { color: #15803d; }
.hlr-bal-value.red    { color: #b91c1c; }

.hlr-bal-divider { border-top: 1px solid rgba(0,0,0,0.08); margin: 8px 0; }

/* Holiday rows */
.hlr-holiday-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);
}
.hlr-holiday-row:last-child { border-bottom: none; }
.hlr-holiday-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
.hlr-holiday-date { font-size: 11.5px; font-weight: 500; color: var(--text-tertiary); margin-top: 1px; }
.hlr-holiday-icon { width: 28px; height: 28px; background: rgba(239,68,68,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.hlr-holiday-icon svg { width: 14px; height: 14px; stroke: #dc2626; }

/* Policy list */
.hlr-policy-list { display: flex; flex-direction: column; gap: 8px; }
.hlr-policy-item { display: flex; align-items: flex-start; gap: 9px; font-size: 12.5px; font-weight: 500; color: var(--text-secondary); line-height: 1.5; }
.hlr-policy-dot { width: 6px; height: 6px; border-radius: 50%; background: #0d9488; flex-shrink: 0; margin-top: 6px; }

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
@media (max-width: 1024px) { .hlr-layout { grid-template-columns: 1fr; } }
@media (max-width: 640px)  { .hlr-root { padding: 18px 14px 100px; } .hlr-date-grid { grid-template-columns: 1fr; } .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; } .ios-nav-item svg { width: 18px; height: 18px; } }
</style>

<div class="hlr-root">

    {{-- ── Page header ──────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="hlr-header">
            <div class="hlr-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <h1>Leave Request</h1>
                <p>Submit a new leave request for approval</p>
            </div>
        </div>
    </div>

    {{-- ── Two-column layout ─────────────────────────── --}}
    <div class="hlr-layout">

        {{-- ── Form ─────────────────────────────────── --}}
        <div class="g-card anim-2">
            <div class="hlr-form-body">
                <form wire:submit="submit">
                    <div class="hlr-fields">

                        {{-- Leave type --}}
                        <div class="hlr-field">
                            <label>Leave Type</label>
                            <select id="selectedLeaveType" wire:model.live="selectedLeaveType" required>
                                <option value="">Select a leave type</option>
                                @foreach($leaveTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->default_days }} days)</option>
                                @endforeach
                            </select>
                            @error('selectedLeaveType') <span class="hlr-field-error">{{ $message }}</span> @enderror
                        </div>

                        {{-- Date range --}}
                        <div class="hlr-date-grid">
                            <div class="hlr-field">
                                <label>Start Date</label>
                                <input type="date" id="start_date" wire:model.live="start_date" required/>
                                @error('start_date') <span class="hlr-field-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="hlr-field">
                                <label>End Date</label>
                                <input type="date" id="end_date" wire:model.live="end_date" required/>
                                @error('end_date') <span class="hlr-field-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Total days banner --}}
                        @if($total_days)
                            <div class="hlr-info-banner banner-blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M12 12v4"/></svg>
                                <span class="hlr-info-banner-text">
                                    Total leave days: <strong>{{ $total_days }}</strong> (excluding weekends and holidays)
                                </span>
                            </div>
                        @endif

                        {{-- Reason --}}
                        <div class="hlr-field">
                            <label>Reason for Leave</label>
                            <textarea id="reason" wire:model="reason" placeholder="Please provide a detailed reason for your leave request..." required></textarea>
                            @error('reason') <span class="hlr-field-error">{{ $message }}</span> @enderror
                        </div>

                        {{-- Attachment --}}
                        <div class="hlr-field">
                            <label>Attachment (Optional)</label>
                            <input type="file" id="attachment" wire:model="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"/>
                            @error('attachment') <span class="hlr-field-error">{{ $message }}</span> @enderror
                            <span class="hlr-field-hint">Supported: PDF, DOC, DOCX, JPG, PNG — Max 5MB</span>
                        </div>

                        {{-- Conflict warning --}}
                        @if($conflictingRequests && $conflictingRequests->isNotEmpty())
                            <div class="hlr-info-banner banner-amber">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                <div>
                                    <div class="hlr-info-banner-text"><strong>Conflicting Leave Requests</strong></div>
                                    <div class="hlr-info-banner-text" style="margin-top:4px;">The following requests overlap with your selected period:</div>
                                    <ul class="hlr-conflict-list">
                                        @foreach($conflictingRequests as $conflict)
                                            <li>{{ $conflict->leaveType->name }} · {{ $conflict->start_date->format('M d') }} – {{ $conflict->end_date->format('M d, Y') }} ({{ $conflict->total_days }} days)</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- Conflict error --}}
                        @error('conflict')
                            <div class="hlr-info-banner banner-red">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
                                <span class="hlr-info-banner-text">{{ $message }}</span>
                            </div>
                        @enderror

                        {{-- Submit --}}
                        <div class="hlr-submit-row">
                            <button type="submit" class="btn-submit-leave">
                                <span wire:loading wire:target="submit">
                                    <svg class="hlr-spinner" width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.3)" stroke-width="4"/><path d="M12 2a10 10 0 0110 10" stroke="#fff" stroke-width="4" stroke-linecap="round"/></svg>
                                </span>
                                <span wire:loading.remove wire:target="submit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" style="width:16px;height:16px;stroke:#fff;display:inline;vertical-align:middle;margin-right:4px;"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                </span>
                                Submit Leave Request
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- ── Sidebar ───────────────────────────────── --}}
        <div class="hlr-sidebar anim-3">

            {{-- Leave balance --}}
            @if($leaveBalance)
                <div class="g-card">
                    <div class="hlr-side-head">
                        <p class="hlr-side-title">Leave Balance</p>
                    </div>
                    <div class="hlr-side-body">
                        <div class="hlr-bal-row">
                            <span class="hlr-bal-label">Total Days</span>
                            <span class="hlr-bal-value">{{ $leaveBalance->total_days + $leaveBalance->carried_forward_days }}</span>
                        </div>
                        <div class="hlr-bal-row">
                            <span class="hlr-bal-label">Used Days</span>
                            <span class="hlr-bal-value">{{ $leaveBalance->used_days }}</span>
                        </div>
                        <div class="hlr-bal-row">
                            <span class="hlr-bal-label">Available</span>
                            <span class="hlr-bal-value blue">{{ $leaveBalance->balance_days }}</span>
                        </div>
                        @if($total_days)
                            <div class="hlr-bal-divider"></div>
                            <div class="hlr-bal-row">
                                <span class="hlr-bal-label">After Request</span>
                                <span class="hlr-bal-value {{ $leaveBalance->balance_days >= $total_days ? 'green' : 'red' }}">
                                    {{ $leaveBalance->balance_days - $total_days }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Upcoming holidays --}}
            <div class="g-card">
                <div class="hlr-side-head">
                    <p class="hlr-side-title">Upcoming Holidays</p>
                </div>
                <div class="hlr-side-body">
                    @foreach($holidays->take(5) as $holiday)
                        <div class="hlr-holiday-row">
                            <div>
                                <div class="hlr-holiday-name">{{ $holiday->name }}</div>
                                <div class="hlr-holiday-date">{{ $holiday->date->format('M d, Y') }}</div>
                            </div>
                            <div class="hlr-holiday-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Leave policy --}}
            <div class="g-card">
                <div class="hlr-side-head">
                    <p class="hlr-side-title">Leave Policy</p>
                </div>
                <div class="hlr-side-body">
                    <div class="hlr-policy-list">
                        @foreach([
                            'Weekends are excluded from leave calculations',
                            'Public holidays are automatically excluded',
                            'Leave requests require manager approval',
                            'Attach supporting documents when required',
                            'Submit requests at least 3 days in advance',
                        ] as $policy)
                            <div class="hlr-policy-item">
                                <div class="hlr-policy-dot"></div>
                                {{ $policy }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>{{-- /hlr-sidebar --}}

    </div>{{-- /hlr-layout --}}

    {{-- ── Floating nav ──────────────────────────────── --}}
    <nav class="ios-nav">
        <a href="{{ route('leave-attendance.dashboard') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Dashboard
        </a>
        <a href="{{ route('leave-attendance.requests') }}" class="ios-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Leave
            <span class="ios-nav-active-dot"></span>
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
        <a href="{{ route('leave-attendance.hr-communication') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Messages
        </a>
    </nav>

</div>
</div>
