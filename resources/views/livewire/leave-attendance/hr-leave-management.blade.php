<div class="hlm-local-shell">
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

    .hlm-local-shell {
        --blue: #3B6FE8;
        --blue-2: #2755CC;
        --blue-lt: rgba(59, 111, 232, 0.08);
        --bg: #F8F9FE;
        --white: #FFFFFF;
        --ink: #1E293B;
        --ink2: #475569;
        --ink3: #64748B;
        --ink4: #94A3B8;
        --border: rgba(226, 232, 240, 0.8);
        --sh-sm: 0 4px 20px rgba(0, 0, 0, 0.02);
        --sh-md: 0 10px 30px rgba(59, 111, 232, 0.06);
        --r: 16px;
        --r-lg: 24px;

        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        display: grid; 
        grid-template-columns: 260px 1fr; 
        gap: 32px; 
        align-items: flex-start;
        padding: 32px 40px;
        background: var(--bg);
        min-height: 100vh;
    }

    /* ══ SIDE NAV ═════════════════════════════════════════════ */
    .hlm-local-sidebar { position: sticky; top: 32px; display: flex; flex-direction: column; gap: 24px; }
    .hlm-local-nav { display: flex; flex-direction: column; gap: 8px; background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 12px; box-shadow: var(--sh-sm); }
    .hlm-nav-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); padding: 12px 16px 4px; letter-spacing: 0.08em; }
    .hlm-nav-item {
        display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--r);
        font-size: 14px; font-weight: 700; color: var(--ink2); cursor: pointer; border: none; background: transparent; 
        font-family: 'DM Sans', sans-serif; transition: all .2s; text-align: left; width: 100%;
    }
    .hlm-nav-item svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2.2; opacity: 0.6; }
    .hlm-nav-item:hover { background: var(--blue-lt); color: var(--blue); }
    .hlm-nav-item.active { background: var(--blue); color: #fff; box-shadow: 0 8px 20px rgba(59, 111, 232, 0.25); }
    .hlm-nav-item.active svg { opacity: 1; stroke: #fff; }

    /* Main Content */
    .hlm-local-main { display: flex; flex-direction: column; gap: 32px; min-width: 0; }
    .hlm-header { display: flex; justify-content: space-between; align-items: center; }
    .hlm-title { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--ink); letter-spacing: -0.5px; }

    /* Card */
    .hlm-card { background: var(--white); border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
    .hlm-card-hd { padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    
    .hlm-filters { padding: 24px 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; background: var(--white); border-radius: var(--r); border: 1px solid var(--border); }
    .hlm-filter-field { display: flex; flex-direction: column; gap: 8px; }
    .hlm-filter-field label { font-size: 12px; font-weight: 700; color: var(--ink4); text-transform: uppercase; letter-spacing: 0.05em; }
    .hlm-input { padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); font-family: inherit; font-size: 14px; color: var(--ink); outline: none; transition: all .15s; }
    .hlm-input:focus { border-color: var(--blue); box-shadow: 0 0 0 4px var(--blue-lt); }

    .hlm-table { width: 100%; border-collapse: collapse; }
    .hlm-table th { text-align: left; padding: 16px 32px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); letter-spacing: 0.08em; border-bottom: 2px solid var(--border); }
    .hlm-table td { padding: 20px 32px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--ink2); }

    .badge { padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .badge-green { background: #E6F7F0; color: #12B76A; }
    .badge-amber { background: #FFF4ED; color: #F79009; }
    .badge-red { background: #FEECEB; color: #F04438; }

    .hlm-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; font-family: 'Sora', sans-serif; }
    .hlm-btn-primary { background: var(--blue); color: #fff; }
    .hlm-btn-ghost { background: var(--blue-lt); color: var(--blue); }
</style>
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

    <aside class="hlm-local-sidebar">
        <nav class="hlm-local-nav">
            <div class="hlm-nav-label">Leave & Attendance</div>
            <a href="{{ route('leave-attendance.dashboard') }}" class="hlm-nav-item">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('leave-attendance.requests') }}" class="hlm-nav-item">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>My Requests</span>
            </a>
            <a href="{{ route('leave-attendance.hr-leave-management') }}" class="hlm-nav-item active">
                <svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Manage Leaves</span>
            </a>
            <a href="{{ route('leave-attendance.hr-calendar') }}" class="hlm-nav-item">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <span>Team Calendar</span>
            </a>
            <div class="hlm-nav-label">Team</div>
            <a href="{{ route('employee-management') }}" class="hlm-nav-item">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                <span>Employees</span>
            </a>
        </nav>
    </aside>

    <main class="hlm-local-main">
        <div class="hlm-header">
            <div>
                <h1 class="hlm-title">Leave Management</h1>
                <p style="color:var(--ink4); font-size:14px; font-weight:500;">Review and process employee leave applications</p>
            </div>
            <div class="hlm-header-actions">
                <button class="hlm-btn hlm-btn-ghost" wire:click="$refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
        </div>

        <div class="hlm-filters">
            <div class="hlm-filter-field">
                <label>Filter by Status</label>
                <select wire:model.live="filterStatus" class="hlm-input">
                    <option value="all">All Requests</option>
                    <option value="pending">Pending Only</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="hlm-filter-field">
                <label>Search Employee</label>
                <input wire:model.live="searchTerm" type="text" class="hlm-input" placeholder="Search by name or ID..."/>
            </div>
        </div>

        <div class="hlm-card">
            @if(session()->has('success') || session()->has('error') || session()->has('warning'))
                <div style="padding: 16px 32px;">
                    @if(session()->has('success')) <div class="badge-green" style="padding:10px; border-radius:8px;">{{ session('success') }}</div> @endif
                    @if(session()->has('error')) <div class="badge-red" style="padding:10px; border-radius:8px;">{{ session('error') }}</div> @endif
                    @if(session()->has('warning')) <div class="badge-amber" style="padding:10px; border-radius:8px;">{{ session('warning') }}</div> @endif
                </div>
            @endif

            @if($leaveRequests->count() > 0)
                <table class="hlm-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $request)
                            @php
                                $s = $request->status->value;
                                $bc = match($s) { 'approved' => 'badge-green', 'pending' => 'badge-amber', 'rejected' => 'badge-red', default => 'badge-gray' };
                            @endphp
                            <tr wire:key="req-{{ $request->id }}">
                                <td>
                                    <div style="font-weight:700; color:var(--ink);">{{ $request->employee->full_name }}</div>
                                    <div style="font-size:11px; color:var(--ink4);">{{ $request->employee->code }}</div>
                                    <button class="hlm-btn hlm-btn-ghost" style="padding:4px 8px; font-size:10px; margin-top:4px;" wire:click="showEmployeeBalance('{{ $request->employee->id }}')">View Balance</button>
                                </td>
                                <td>{{ $request->leaveType->name }}</td>
                                <td style="font-size:13px; color:var(--ink3);">{{ $request->start_date->format('M d') }} — {{ $request->end_date->format('M d, Y') }}</td>
                                <td><span style="font-weight:700;">{{ $request->total_days }}</span> <span style="font-size:11px; color:var(--ink4);">DAYS</span></td>
                                <td><span class="badge {{ $bc }}">{{ ucfirst($s) }}</span></td>
                                <td>
                                    <div style="display:flex; gap:8px;">
                                        <button class="hlm-btn hlm-btn-ghost" style="padding:6px 12px; font-size:12px;" wire:click="setViewRequest('{{ $request->id }}')">View</button>
                                        @if($s === 'pending')
                                            <button class="hlm-btn hlm-btn-primary" style="padding:6px 12px; font-size:12px; background:#12B76A;" wire:click="setSelectedRequest('{{ $request->id }}')">Approve</button>
                                            <button class="hlm-btn hlm-btn-primary" style="padding:6px 12px; font-size:12px; background:#F04438;" wire:click="openRejectModal('{{ $request->id }}')">Reject</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="hlm-empty">
                    <p class="hlm-empty-title">No leave requests found</p>
                    <p class="hlm-empty-sub">No applications match your current filters.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- Modals --}}
    @if($selectedRequest)
        @php $req = $leaveRequests->where('id', $selectedRequest)->first(); @endphp
        @if($req)
            <div style="position:fixed; inset:0; background:rgba(0,0,0,0.3); backdrop-filter:blur(4px); z-index:1000; display:flex; align-items:center; justify-content:center;">
                <div class="hlm-card" style="width:480px; max-height:90vh; overflow-y:auto; padding:0;">
                    <div class="hlm-card-hd">
                        <h3 class="hlm-card-title">Request Details</h3>
                        <button wire:click="closeModal" style="background:none; border:none; cursor:pointer;"><i class="fas fa-times"></i></button>
                    </div>
                    <div style="padding:24px 32px; display:flex; flex-direction:column; gap:16px;">
                        <div>
                            <label style="font-size:11px; font-weight:800; color:var(--ink4); text-transform:uppercase;">Employee</label>
                            <div style="font-weight:700;">{{ $req->employee->full_name }}</div>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <label style="font-size:11px; font-weight:800; color:var(--ink4); text-transform:uppercase;">Type</label>
                                <div style="font-weight:600;">{{ $req->leaveType->name }}</div>
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:800; color:var(--ink4); text-transform:uppercase;">Duration</label>
                                <div style="font-weight:600;">{{ $req->total_days }} Days</div>
                            </div>
                        </div>
                        <div>
                            <label style="font-size:11px; font-weight:800; color:var(--ink4); text-transform:uppercase;">Dates</label>
                            <div style="font-weight:600;">{{ $req->start_date->format('M d, Y') }} — {{ $req->end_date->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <label style="font-size:11px; font-weight:800; color:var(--ink4); text-transform:uppercase;">Reason</label>
                            <div style="font-size:14px; color:var(--ink2); line-height:1.5;">{{ $req->reason }}</div>
                        </div>
                    </div>
                    <div style="padding:16px 32px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:12px;">
                        <button class="hlm-btn hlm-btn-ghost" wire:click="closeModal">Close</button>
                        @if($req->status->value === 'pending')
                            <button class="hlm-btn hlm-btn-primary" style="background:#12B76A;" wire:click="approveRequest({{ $req->id }})">Approve</button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if($rejectModalOpen)
        <div style="position:fixed; inset:0; background:rgba(0,0,0,0.3); backdrop-filter:blur(4px); z-index:1000; display:flex; align-items:center; justify-content:center;">
            <div class="hlm-card" style="width:400px; padding:0;">
                <div class="hlm-card-hd"><h3 class="hlm-card-title">Reject Request</h3></div>
                <div style="padding:24px 32px;">
                    <label style="font-size:12px; font-weight:700; color:var(--ink3); margin-bottom:8px; display:block;">Reason for Rejection</label>
                    <textarea wire:model="rejectionReason" class="hlm-input" style="width:100%; height:100px; resize:none;" placeholder="Optional..."></textarea>
                </div>
                <div style="padding:16px 32px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:12px;">
                    <button class="hlm-btn hlm-btn-ghost" wire:click="closeRejectModal">Cancel</button>
                    <button class="hlm-btn hlm-btn-primary" style="background:#F04438;" wire:click="confirmReject">Confirm Reject</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Leave Balance Modal --}}
    @if($showBalanceInfo && $selectedEmployeeBalance)
        <div style="position:fixed; inset:0; background:rgba(0,0,0,0.3); backdrop-filter:blur(4px); z-index:1000; display:flex; align-items:center; justify-content:center;">
            <div class="hlm-card" style="width:520px; max-height:90vh; overflow-y:auto; padding:0;">
                <div class="hlm-card-hd">
                    <h3 class="hlm-card-title">Leave Balance - {{ $selectedEmployeeBalance['employee']->full_name }}</h3>
                    <button wire:click="closeBalanceInfo" style="background:none; border:none; cursor:pointer;"><i class="fas fa-times"></i></button>
                </div>
                <div style="padding:24px 32px;">
                    @if($selectedEmployeeBalance['balances'])
                        <table style="width:100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align:left; padding:8px; font-size:12px; color:var(--ink4); border-bottom:1px solid var(--border);">Leave Type</th>
                                    <th style="text-align:center; padding:8px; font-size:12px; color:var(--ink4); border-bottom:1px solid var(--border);">Total</th>
                                    <th style="text-align:center; padding:8px; font-size:12px; color:var(--ink4); border-bottom:1px solid var(--border);">Used</th>
                                    <th style="text-align:center; padding:8px; font-size:12px; color:var(--ink4); border-bottom:1px solid var(--border);">Balance</th>
                                    <th style="text-align:center; padding:8px; font-size:12px; color:var(--ink4); border-bottom:1px solid var(--border);">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedEmployeeBalance['balances'] as $balance)
                                    <tr>
                                        <td style="padding:12px 8px; font-weight:600; color:var(--ink);">
                                            {{ $balance['leave_type'] }}
                                            @if(isset($balance['is_eligible']) && !$balance['is_eligible'])
                                                <span style="display:block; font-size:10px; color:#F04438; font-weight:500;">Not eligible</span>
                                            @endif
                                            @if($balance['auto_approve'])
                                                <span style="display:block; font-size:10px; color:#12B76A; font-weight:500;">Auto-approved</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center; padding:8px;">
                                            {{ $balance['total_days'] ?? 'Unlimited' }}
                                            @if($balance['max_days_per_year'])
                                                <div style="font-size:10px; color:var(--ink4);">Max: {{ $balance['max_days_per_year'] }}</div>
                                            @endif
                                        </td>
                                        <td style="text-align:center; padding:8px;">{{ $balance['used_days'] }}</td>
                                        <td style="text-align:center; padding:8px;">
                                            <span style="font-weight:700; color: {{ $balance['balance_days'] > 0 ? '#12B76A' : '#F04438' }};">
                                                {{ $balance['balance_days'] }}
                                            </span>
                                            @if($balance['carried_forward'] > 0)
                                                <div style="font-size:10px; color:var(--ink4);">+{{ $balance['carried_forward'] }} CF</div>
                                            @endif
                                        </td>
                                        <td style="text-align:center; padding:8px; font-size:11px;">
                                            @if($balance['requires_medical_document'])
                                                <span style="color:#F59E0B;">Medical required</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div style="margin-top:20px; padding:12px; background:#F8F9FE; border-radius:8px; font-size:11px; color:var(--ink4);">
                            <strong>Legend:</strong> CF = Carried Forward | Medical required = Medical document needed | Auto-approved = No HR approval needed | Not eligible = Gender-restricted leave type
                        </div>
                    @else
                        <div style="text-align:center; padding:40px; color:var(--ink4);">
                            <p>No leave balance records found for this employee.</p>
                        </div>
                    @endif
                </div>
                <div style="padding:16px 32px; border-top:1px solid var(--border); display:flex; justify-content:flex-end;">
                    <button class="hlm-btn hlm-btn-ghost" wire:click="closeBalanceInfo">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
</div>