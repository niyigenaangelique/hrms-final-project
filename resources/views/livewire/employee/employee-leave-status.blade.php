<div class="ls-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.ls-root {
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

/* ── Page header ──────────────────────────────────────── */
.ls-header {
    padding: 28px 32px;
    display: flex; justify-content: space-between; align-items: center;
}

.ls-title    { font-size: 28px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.4px; margin: 0 0 4px; }
.ls-subtitle { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0; }

.btn-new-leave {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 600; cursor: pointer;
    box-shadow: 0 4px 14px rgba(13,148,136,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
    text-decoration: none; flex-shrink: 0;
}

.btn-new-leave:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(13,148,136,0.4); }
.btn-new-leave svg   { width: 15px; height: 15px; stroke: #fff; }

/* ── Table ────────────────────────────────────────────── */
.ls-table-wrap { padding: 0 24px 24px; overflow-x: auto; }

table.ls-table { width: 100%; border-collapse: collapse; }

.ls-table thead tr { border-bottom: 1px solid rgba(0,0,0,0.06); }

.ls-table th {
    padding: 12px 16px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--text-tertiary); text-align: left; white-space: nowrap;
}

.ls-table tbody tr {
    border-bottom: 1px solid rgba(0,0,0,0.04);
    transition: background 0.15s;
}

.ls-table tbody tr:last-child { border-bottom: none; }
.ls-table tbody tr:hover { background: rgba(255,255,255,0.5); }

.ls-table td {
    padding: 14px 16px;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary); white-space: nowrap;
}

.ls-table td.muted { color: var(--text-secondary); font-weight: 400; }

/* ── Status badges ────────────────────────────────────── */
.badge {
    display: inline-flex; font-size: 12px; font-weight: 700;
    padding: 4px 12px; border-radius: var(--radius-pill);
}

.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-amber  { background: rgba(245,158,11,0.14); color: #b45309; }
.badge-red    { background: rgba(239,68,68,0.14);  color: #b91c1c; }
.badge-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }

/* ── View button ──────────────────────────────────────── */
.btn-view {
    font-size: 13px; font-weight: 600; color: #2563eb;
    background: rgba(37,99,235,0.08); border: none; border-radius: 8px;
    padding: 6px 14px; cursor: pointer;
    font-family: 'DM Sans', sans-serif; transition: background 0.15s;
}

.btn-view:hover { background: rgba(37,99,235,0.15); }

/* ── Empty state ──────────────────────────────────────── */
.ls-empty { text-align: center; padding: 60px 24px; }
.ls-empty-icon { width: 56px; height: 56px; background: rgba(0,0,0,0.05); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
.ls-empty-icon svg { width: 28px; height: 28px; stroke: var(--text-tertiary); }
.ls-empty-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0 0 6px; }
.ls-empty-sub   { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0 0 20px; }

/* ── Modal ────────────────────────────────────────────── */
.ls-modal-bg {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.28);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 50;
    display: flex; align-items: center; justify-content: center; padding: 24px;
}

.ls-modal {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(32px) saturate(1.8);
    -webkit-backdrop-filter: blur(32px) saturate(1.8);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius);
    box-shadow: 0 32px 80px rgba(0,0,0,0.18);
    width: 100%; max-width: 460px;
    overflow: hidden;
}

.ls-modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 22px 26px 18px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.ls-modal-title { font-size: 20px; font-weight: 700; color: var(--text-primary); margin: 0; }

.ls-modal-close {
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(0,0,0,0.06); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s; flex-shrink: 0;
}

.ls-modal-close:hover { background: rgba(0,0,0,0.12); }
.ls-modal-close svg   { width: 15px; height: 15px; stroke: var(--text-secondary); }

.ls-modal-body { padding: 22px 26px 26px; display: flex; flex-direction: column; gap: 0; }

.ls-detail-row {
    display: flex; flex-direction: column; gap: 2px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.ls-detail-row:last-child { border-bottom: none; }

.ls-detail-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-tertiary); }
.ls-detail-value { font-size: 14px; font-weight: 600; color: var(--text-primary); }
.ls-detail-prose { font-size: 14px; font-weight: 500; color: var(--text-secondary); line-height: 1.6; }

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
@media (max-width: 640px) {
    .ls-root { padding: 20px 16px 110px; }
    .ls-header { flex-direction: column; align-items: flex-start; gap: 14px; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header ──────────────────────────────────── --}}
<div class="g-card">
    <div class="ls-header">
        <div>
            <h1 class="ls-title">Leave Status</h1>
            <p class="ls-subtitle">Track the status of your leave requests</p>
        </div>
        <a href="{{ route('employee.leave.request') }}" class="btn-new-leave">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
            New Request
        </a>
    </div>
</div>

{{-- ── Leave requests table ──────────────────────────── --}}
<div class="g-card">
    @if($leaveRequests->count() > 0)
        <div class="ls-table-wrap">
            <table class="ls-table">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Duration</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveRequests as $request)
                        @php
                            $s = $request->status->value;
                            $bClass = match($s) {
                                'approved' => 'badge-green',
                                'pending'  => 'badge-amber',
                                'rejected' => 'badge-red',
                                default    => 'badge-gray',
                            };
                            $days = $request->start_date && $request->end_date
                                ? $request->start_date->diffInDays($request->end_date) + 1
                                : null;
                        @endphp
                        <tr>
                            <td style="font-weight:600;">{{ $request->leaveType->name ?? 'N/A' }}</td>
                            <td class="muted">{{ $request->start_date?->format('M d, Y') }} — {{ $request->end_date?->format('M d, Y') }}</td>
                            <td>{{ $days ? $days . ' day' . ($days > 1 ? 's' : '') : 'N/A' }}</td>
                            <td><span class="badge {{ $bClass }}">{{ ucfirst($s) }}</span></td>
                            <td class="muted">{{ $request->created_at?->format('M d, Y') }}</td>
                            <td><button class="btn-view" wire:click="viewRequest({{ $request->id }})">View Details</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="ls-empty">
            <div class="ls-empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="ls-empty-title">No leave requests yet</p>
            <p class="ls-empty-sub">You haven't submitted any leave requests yet.</p>
            <a href="{{ route('employee.leave.request') }}" class="btn-new-leave" style="display:inline-flex;">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
                Request Leave
            </a>
        </div>
    @endif
</div>

{{-- ── Leave request details modal ──────────────────── --}}
@if($selectedRequest)
    @php
        $ms = $selectedRequest->status->value;
        $mbClass = match($ms) {
            'approved' => 'badge-green',
            'pending'  => 'badge-amber',
            'rejected' => 'badge-red',
            default    => 'badge-gray',
        };
        $mDays = $selectedRequest->start_date && $selectedRequest->end_date
            ? $selectedRequest->start_date->diffInDays($selectedRequest->end_date) + 1
            : null;
    @endphp
    <div class="ls-modal-bg" wire:click="closeModal">
        <div class="ls-modal" wire:click.stop>
            <div class="ls-modal-header">
                <h3 class="ls-modal-title">Leave Request Details</h3>
                <button class="ls-modal-close" wire:click="closeModal">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="ls-modal-body">
                <div class="ls-detail-row">
                    <span class="ls-detail-label">Leave Type</span>
                    <span class="ls-detail-value">{{ $selectedRequest->leaveType->name ?? 'N/A' }}</span>
                </div>
                <div class="ls-detail-row">
                    <span class="ls-detail-label">Duration</span>
                    <span class="ls-detail-value">{{ $selectedRequest->start_date?->format('M d, Y') }} — {{ $selectedRequest->end_date?->format('M d, Y') }}</span>
                </div>
                <div class="ls-detail-row">
                    <span class="ls-detail-label">Total Days</span>
                    <span class="ls-detail-value">{{ $mDays ? $mDays . ' day' . ($mDays > 1 ? 's' : '') : 'N/A' }}</span>
                </div>
                <div class="ls-detail-row">
                    <span class="ls-detail-label">Reason</span>
                    <p class="ls-detail-prose">{{ $selectedRequest->reason }}</p>
                </div>
                <div class="ls-detail-row">
                    <span class="ls-detail-label">Status</span>
                    <span class="badge {{ $mbClass }}" style="margin-top:4px;">{{ ucfirst($ms) }}</span>
                </div>
                <div class="ls-detail-row">
                    <span class="ls-detail-label">Applied On</span>
                    <span class="ls-detail-value">{{ $selectedRequest->created_at?->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
@endif

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

</div>{{-- /ls-root --}}