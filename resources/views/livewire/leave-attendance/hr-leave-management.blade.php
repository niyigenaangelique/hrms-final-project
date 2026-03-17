<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.hlm-root {
    --glass-bg:       rgba(255,255,255,0.50);
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
    display: flex; flex-direction: column; gap: 20px;
}
@keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.anim-1 { animation: fadeSlideUp 0.35s ease both; }
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }
.anim-3 { animation: fadeSlideUp 0.35s 0.14s ease both; }
.g-card { background:var(--glass-bg); backdrop-filter:var(--blur); -webkit-backdrop-filter:var(--blur); border:1px solid var(--glass-border); border-radius:var(--radius); box-shadow:var(--glass-shadow); position:relative; }
.g-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.9),transparent); pointer-events:none; border-radius:var(--radius) var(--radius) 0 0; }
.hlm-header { padding:24px 30px; display:flex; justify-content:space-between; align-items:center; gap:20px; }
.hlm-header h1 { font-size:24px; font-weight:700; color:var(--text-primary); letter-spacing:-0.4px; margin:0 0 3px; }
.hlm-header p  { font-size:13.5px; font-weight:500; color:var(--text-secondary); margin:0; }
.hlm-filters { padding:20px 26px; display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.hlm-filter-field { display:flex; flex-direction:column; gap:6px; }
.hlm-filter-field label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--text-tertiary); }
.hlm-filter-field select,
.hlm-filter-field input { padding:10px 14px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:var(--radius-sm) !important; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--text-primary); outline:none; width:100%; box-sizing:border-box; transition:border-color .15s,box-shadow .15s; -webkit-appearance:none; }
.hlm-filter-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important; background-repeat:no-repeat !important; background-position:right 14px center !important; padding-right:36px !important; }
.hlm-filter-field select:focus,
.hlm-filter-field input:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; background:rgba(255,255,255,0.96) !important; }
.hlm-flash { padding:0 24px; margin-bottom:4px; }
.flash-ok   { background:rgba(34,197,94,0.1);  border:1px solid rgba(34,197,94,0.28);  border-radius:var(--radius-sm); padding:12px 16px; font-size:13px; font-weight:600; color:#15803d; }
.flash-err  { background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.22);  border-radius:var(--radius-sm); padding:12px 16px; font-size:13px; font-weight:600; color:#b91c1c; }
.flash-info { background:rgba(37,99,235,0.08); border:1px solid rgba(37,99,235,0.2);   border-radius:var(--radius-sm); padding:12px 16px; font-size:13px; font-weight:600; color:#1e40af; }
.hlm-table-wrap { overflow-x:auto; padding:0 4px 4px; }
table.hlm-table { width:100%; border-collapse:collapse; }
.hlm-table thead tr { border-bottom:1px solid rgba(0,0,0,0.07); }
.hlm-table th { padding:11px 18px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--text-tertiary); text-align:left; white-space:nowrap; }
.hlm-table tbody tr { border-bottom:1px solid rgba(0,0,0,0.04); transition:background .12s; }
.hlm-table tbody tr:last-child { border-bottom:none; }
.hlm-table tbody tr:hover { background:rgba(255,255,255,0.55); }
.hlm-table td { padding:13px 18px; font-size:13.5px; font-weight:500; color:var(--text-primary); white-space:nowrap; vertical-align:middle; }
.hlm-table td.muted { color:var(--text-secondary); font-size:13px; }
.hlm-emp-name { font-size:14px; font-weight:700; color:var(--text-primary); margin-bottom:2px; }
.hlm-emp-code { font-size:11.5px; font-weight:500; color:var(--text-tertiary); }
.badge { display:inline-flex; font-size:11px; font-weight:700; padding:4px 11px; border-radius:var(--radius-pill); }
.badge-green  { background:rgba(34,197,94,0.14);  color:#15803d; }
.badge-amber  { background:rgba(245,158,11,0.14); color:#b45309; }
.badge-red    { background:rgba(239,68,68,0.14);  color:#b91c1c; }
.badge-gray   { background:rgba(0,0,0,0.07);      color:var(--text-secondary); }
.btn-view    { font-size:12px; font-weight:600; color:#2563eb; background:rgba(37,99,235,0.09); border:none; border-radius:8px; padding:5px 12px; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .13s; margin-right:6px; }
.btn-view:hover { background:rgba(37,99,235,0.16); }
.btn-approve { font-size:12px; font-weight:600; color:#15803d; background:rgba(34,197,94,0.1);  border:none; border-radius:8px; padding:5px 12px; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .13s; margin-right:6px; }
.btn-approve:hover { background:rgba(34,197,94,0.18); }
.btn-reject  { font-size:12px; font-weight:600; color:#b91c1c; background:rgba(239,68,68,0.08); border:none; border-radius:8px; padding:5px 12px; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .13s; }
.btn-reject:hover { background:rgba(239,68,68,0.15); }
.hlm-empty { text-align:center; padding:52px 24px; }
.hlm-empty-icon { width:52px; height:52px; background:rgba(0,0,0,0.05); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.hlm-empty-icon svg { width:26px; height:26px; stroke:var(--text-tertiary); }
.hlm-empty-title { font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 4px; }
.hlm-empty-sub   { font-size:13px; font-weight:500; color:var(--text-secondary); margin:0; }
.hlm-modal-bg { position:fixed; inset:0; z-index:60; background:rgba(0,0,0,0.28); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); display:flex; align-items:center; justify-content:center; padding:24px; }
.hlm-modal { background:rgba(255,255,255,0.92); backdrop-filter:blur(32px) saturate(1.8); -webkit-backdrop-filter:blur(32px) saturate(1.8); border:1px solid rgba(255,255,255,0.92); border-radius:var(--radius); box-shadow:0 32px 80px rgba(0,0,0,0.18); width:100%; max-width:480px; }
.hlm-modal-head { display:flex; justify-content:space-between; align-items:center; padding:20px 24px 16px; border-bottom:1px solid rgba(0,0,0,0.06); }
.hlm-modal-title { font-size:18px; font-weight:700; color:var(--text-primary); margin:0; }
.hlm-modal-close { width:30px; height:30px; border-radius:50%; background:rgba(0,0,0,0.06); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .15s; }
.hlm-modal-close:hover { background:rgba(0,0,0,0.12); }
.hlm-modal-close svg { width:14px; height:14px; stroke:var(--text-secondary); }
.hlm-modal-body { padding:20px 24px; display:flex; flex-direction:column; gap:0; }
.hlm-detail-row { display:flex; flex-direction:column; gap:2px; padding:10px 0; border-bottom:1px solid rgba(0,0,0,0.05); }
.hlm-detail-row:last-child { border-bottom:none; }
.hlm-detail-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--text-tertiary); }
.hlm-detail-value { font-size:14px; font-weight:600; color:var(--text-primary); }
.hlm-detail-prose { font-size:13.5px; font-weight:500; color:var(--text-secondary); line-height:1.6; }
.hlm-modal-actions { padding:16px 24px 22px; display:flex; flex-direction:column; gap:10px; border-top:1px solid rgba(0,0,0,0.06); }
.btn-modal-approve { width:100%; padding:12px; background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(22,163,74,0.3); transition:transform .15s,box-shadow .15s; }
.btn-modal-approve:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(22,163,74,0.4); }
.btn-modal-reject { width:100%; padding:12px; background:rgba(239,68,68,0.1); color:#b91c1c; border:1px solid rgba(239,68,68,0.22); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:background .15s; }
.btn-modal-reject:hover { background:rgba(239,68,68,0.16); }
.btn-modal-close { width:100%; padding:11px; background:rgba(0,0,0,0.06); color:var(--text-secondary); border:none; border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .15s; }
.btn-modal-close:hover { background:rgba(0,0,0,0.1); }
.hlm-reject-field { display:flex; flex-direction:column; gap:5px; }
.hlm-reject-field label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--text-tertiary); }
.hlm-reject-field textarea { padding:10px 13px; background:rgba(255,255,255,0.78) !important; border:1px solid rgba(0,0,0,0.1) !important; border-radius:10px !important; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; color:var(--text-primary); outline:none; resize:vertical; min-height:80px; transition:border-color .15s,box-shadow .15s; }
.hlm-reject-field textarea:focus { border-color:rgba(13,148,136,0.55) !important; box-shadow:0 0 0 3px rgba(13,148,136,0.1) !important; }
.hlm-field-error { font-size:11px; font-weight:600; color:#dc2626; }
.ios-nav { position:fixed; bottom:24px; left:50%; transform:translateX(-50%); z-index:100; display:flex; align-items:center; gap:2px; background:rgba(15,15,25,0.75); backdrop-filter:blur(32px) saturate(2); -webkit-backdrop-filter:blur(32px) saturate(2); border:1px solid rgba(255,255,255,0.13); border-radius:28px; padding:8px 10px; box-shadow:0 20px 60px rgba(0,0,0,0.2),0 4px 16px rgba(0,0,0,0.1),inset 0 1px 0 rgba(255,255,255,0.1); }
.ios-nav::before { content:''; position:absolute; top:0; left:16px; right:16px; height:1px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.22),transparent); }
.ios-nav-item { display:flex; flex-direction:column; align-items:center; gap:3px; padding:8px 18px; border-radius:20px; text-decoration:none; font-size:10px; font-weight:500; color:rgba(255,255,255,0.45); letter-spacing:.03em; min-width:64px; position:relative; transition:background .2s,color .2s,transform .15s; }
.ios-nav-item svg { width:20px; height:20px; stroke:currentColor; transition:transform .2s; }
.ios-nav-item:hover { color:rgba(255,255,255,0.85); background:rgba(255,255,255,0.08); transform:translateY(-1px); }
.ios-nav-item:hover svg { transform:scale(1.1); }
.ios-nav-item.active { color:#fff; background:rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke:#60a5fa; }
.ios-nav-active-dot { position:absolute; bottom:4px; width:4px; height:4px; border-radius:50%; background:#60a5fa; }
@media (max-width:768px) { .hlm-root { padding:18px 14px 100px; } .hlm-filters { grid-template-columns:1fr; } .ios-nav-item { padding:7px 12px; min-width:48px; font-size:9px; } .ios-nav-item svg { width:18px; height:18px; } }
</style>

<div class="hlm-root">

    {{-- ── Header ────────────────────────────────────── --}}
    <div class="g-card anim-1">
        <div class="hlm-header">
            <div>
                <h1>HR Leave Management</h1>
                <p>Approve or reject employee leave requests</p>
            </div>
        </div>
    </div>

    {{-- ── Filters ───────────────────────────────────── --}}
    <div class="g-card anim-2">
        <div class="hlm-filters">
            <div class="hlm-filter-field">
                <label>Filter by Status</label>
                <select wire:model.live="filterStatus">
                    <option value="all">All Requests</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="hlm-filter-field">
                <label>Search</label>
                <input wire:model.live="searchTerm" type="text" placeholder="Search by employee name or leave type"/>
            </div>
        </div>
    </div>

    {{-- ── Table ─────────────────────────────────────── --}}
    <div class="g-card anim-3">

        @if(session()->has('test') || session()->has('success') || session()->has('error'))
            <div class="hlm-flash" style="padding-top:16px;">
                @if(session()->has('test'))    <div class="flash-info">{{ session('test') }}</div> @endif
                @if(session()->has('success')) <div class="flash-ok">{{ session('success') }}</div> @endif
                @if(session()->has('error'))   <div class="flash-err">{{ session('error') }}</div> @endif
            </div>
        @endif

        @if($leaveRequests->count() > 0)
            <div class="hlm-table-wrap">
                <table class="hlm-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Applied</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $request)
                            @php
                                $s  = $request->status->value;
                                $bc = match($s) { 'approved' => 'badge-green', 'pending' => 'badge-amber', 'rejected' => 'badge-red', default => 'badge-gray' };
                            @endphp
                            <tr>
                                <td>
                                    <div class="hlm-emp-name">{{ $request->employee->first_name }} {{ $request->employee->last_name }}</div>
                                    <div class="hlm-emp-code">{{ $request->employee->code }}</div>
                                </td>
                                <td>{{ $request->leaveType->name }}</td>
                                <td class="muted">{{ $request->start_date->format('M d, Y') }} — {{ $request->end_date->format('M d, Y') }}</td>
                                <td>{{ $request->total_days }}d</td>
                                <td><span class="badge {{ $bc }}">{{ ucfirst($s) }}</span></td>
                                <td class="muted">{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button type="button" class="btn-view" wire:click="setViewRequest('{{ $request->id }}')">View</button>
                                    @if($s === 'pending')
                                        <button type="button" class="btn-approve" wire:click="setSelectedRequest('{{ $request->id }}')">Approve</button>
                                        <button type="button" class="btn-reject" wire:click="openRejectModal('{{ $request->id }}')">Reject</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="hlm-empty">
                <div class="hlm-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p class="hlm-empty-title">No leave requests found</p>
                <p class="hlm-empty-sub">Try adjusting your filters or search term.</p>
            </div>
        @endif
    </div>

    {{-- ── Details modal ─────────────────────────────── --}}
    @if($selectedRequest)
        @php $req = $leaveRequests->where('id', $selectedRequest)->first(); @endphp
        @if($req)
            <div class="hlm-modal-bg" wire:click="closeModal">
                <div class="hlm-modal" wire:click.stop>
                    <div class="hlm-modal-head">
                        <h3 class="hlm-modal-title">Leave Request Details</h3>
                        <button class="hlm-modal-close" wire:click="closeModal">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="hlm-modal-body">
                        <div class="hlm-detail-row"><span class="hlm-detail-label">Employee</span><span class="hlm-detail-value">{{ $req->employee->first_name }} {{ $req->employee->last_name }} · {{ $req->employee->code }}</span></div>
                        <div class="hlm-detail-row"><span class="hlm-detail-label">Leave Type</span><span class="hlm-detail-value">{{ $req->leaveType->name }}</span></div>
                        <div class="hlm-detail-row"><span class="hlm-detail-label">Duration</span><span class="hlm-detail-value">{{ $req->start_date->format('M d, Y') }} — {{ $req->end_date->format('M d, Y') }}</span></div>
                        <div class="hlm-detail-row"><span class="hlm-detail-label">Total Days</span><span class="hlm-detail-value">{{ $req->total_days }} days</span></div>
                        <div class="hlm-detail-row"><span class="hlm-detail-label">Reason</span><p class="hlm-detail-prose">{{ $req->reason }}</p></div>
                        <div class="hlm-detail-row">
                            <span class="hlm-detail-label">Status</span>
                            @php $ms = $req->status->value; $mc = match($ms) { 'approved' => 'badge-green', 'pending' => 'badge-amber', 'rejected' => 'badge-red', default => 'badge-gray' }; @endphp
                            <span class="badge {{ $mc }}" style="margin-top:4px;">{{ ucfirst($ms) }}</span>
                        </div>
                        @if($ms === 'pending')
                            <div class="hlm-reject-field" style="margin-top:12px;">
                                <label>Rejection Reason</label>
                                <textarea wire:model="rejectionReason" placeholder="Enter reason for rejection..."></textarea>
                                @error('rejectionReason') <span class="hlm-field-error">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>
                    <div class="hlm-modal-actions">
                        @if($ms === 'pending')
                            <button class="btn-modal-approve" wire:click="approveRequest({{ $req->id }})">✓ Approve Request</button>
                            <button class="btn-modal-reject" wire:click="rejectRequest">✕ Reject Request</button>
                        @endif
                        <button class="btn-modal-close" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- ── Reject modal ───────────────────────────────── --}}
    @if($rejectModalOpen)
        <div class="hlm-modal-bg" wire:click="closeRejectModal">
            <div class="hlm-modal" wire:click.stop>
                <div class="hlm-modal-head">
                    <h3 class="hlm-modal-title">Reject Leave Request</h3>
                    <button class="hlm-modal-close" wire:click="closeRejectModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="hlm-modal-body">
                    <div class="hlm-reject-field">
                        <label>Rejection Reason</label>
                        <textarea wire:model="rejectionReason" placeholder="Enter reason for rejection..."></textarea>
                        @error('rejectionReason') <span class="hlm-field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="hlm-modal-actions">
                    <button class="btn-modal-reject" wire:click="confirmReject">✕ Confirm Rejection</button>
                    <button class="btn-modal-close" wire:click="closeRejectModal">Cancel</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Floating nav ──────────────────────────────── --}}
    <nav class="ios-nav">
        <a href="{{ route('leave-attendance.dashboard') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            Dashboard
        </a>
        <a href="{{ route('leave-attendance.requests') }}" class="ios-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Leave
        </a>
        <a href="{{ route('leave-attendance.hr-leave-management') }}" class="ios-nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Manage
            <span class="ios-nav-active-dot"></span>
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