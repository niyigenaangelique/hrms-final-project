<div class="pf-local-shell">
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

    .pf-local-shell {
        --blue: #3B6FE8;
        --blue-2: #2755CC;
        --blue-lt: rgba(59, 111, 232, 0.08);
        --indigo: #6B4FDB;
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
    .pf-local-sidebar { position: sticky; top: 32px; display: flex; flex-direction: column; gap: 24px; }
    .pf-local-nav { display: flex; flex-direction: column; gap: 8px; background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 12px; box-shadow: var(--sh-sm); }
    .pf-nav-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); padding: 12px 16px 4px; letter-spacing: 0.08em; }
    .pf-nav-item {
        display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--r);
        font-size: 14px; font-weight: 700; color: var(--ink2); cursor: pointer; border: none; background: transparent; 
        font-family: 'DM Sans', sans-serif; transition: all .2s; text-align: left; width: 100%;
    }
    .pf-nav-item svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2.2; opacity: 0.6; }
    .pf-nav-item:hover { background: var(--blue-lt); color: var(--blue); }
    .pf-nav-item.active { background: var(--blue); color: #fff; box-shadow: 0 8px 20px rgba(59, 111, 232, 0.25); }
    .pf-nav-item.active svg { opacity: 1; stroke: #fff; }

    /* Main Content */
    .pf-local-main { display: flex; flex-direction: column; gap: 32px; min-width: 0; }
    .pf-header { display: flex; justify-content: space-between; align-items: center; }
    .pf-title { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--ink); letter-spacing: -0.5px; }

    /* Stats Grid */
    .pf-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .pf-stat-card { background: var(--white); padding: 24px; border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--sh-sm); }
    .pf-stat-label { font-size: 12px; font-weight: 700; color: var(--ink4); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.05em; }
    .pf-stat-val { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--ink); }

    /* Card */
    .pf-card { background: var(--white); border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
    .pf-card-hd { padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .pf-card-title { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); }

    /* Table */
    .pf-table { width: 100%; border-collapse: collapse; }
    .pf-table th { text-align: left; padding: 16px 32px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); letter-spacing: 0.08em; border-bottom: 2px solid var(--border); }
    .pf-table td { padding: 20px 32px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--ink2); }
.pf-user-cell { display: flex; align-items: center; gap: 10px; }
.pf-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--blue-lt); color: #6B4FDB; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; }
.pf-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; font-family: 'Sora', sans-serif; }
.pf-btn-primary { background: #6B4FDB; color: #fff; box-shadow: 0 4px 14px rgba(107,79,219,0.3); }
.pf-btn-primary:hover { background: #5739c9; transform: translateY(-1px); }
.pf-btn-ghost { background: var(--blue-lt); color: #6B4FDB; }
.pf-btn-sm { padding: 6px 12px; font-size: 12px; }
.pf-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.4); backdrop-filter: blur(4px); z-index: 1000; display: flex; align-items: center; justify-content: center; }
.pf-modal { background: var(--white); border-radius: var(--r-lg); width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: var(--sh-lg); border: 1px solid var(--border); }
.pf-modal-hd { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.pf-modal-body { padding: 24px; }
.pf-modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; }
.pf-group { margin-bottom: 16px; }
.pf-label { display: block; font-size: 12px; font-weight: 800; color: var(--ink3); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.03em; }
.pf-input { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid var(--border); background: var(--white); font-family: inherit; font-size: 14px; color: var(--ink); transition: border-color .15s; }
.pf-input:focus { border-color: var(--blue); outline: none; }
.pf-rating-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.pf-rating-item { background: var(--bg); padding: 12px; border-radius: 12px; border: 1px solid var(--border); }
.pf-badge { padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
.pf-badge-green { background: #E6F7F0; color: #12B76A; }
.pf-badge-blue { background: #E8F1FD; color: #3B6FE8; }
.pf-badge-gray { background: #F2F4F7; color: #667085; }
    /* Standardized Hero (Deep Ocean) */
    .la-hero {
        background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 36%, #3B6FE8 68%, #6B4FDB 100%);
        border-radius: 20px;
        padding: 32px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 48px rgba(59,111,232,0.14);
        margin-bottom: 24px;
        color: #fff;
    }
    .la-hero::before { content: ''; position: absolute; top: -50px; right: 240px; width: 250px; height: 250px; border-radius: 50%; background: rgba(255,255,255,0.06); pointer-events: none; }
    .la-hero::after { content: ''; position: absolute; bottom: -40px; left: 60px; width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .la-hero-left { display: flex; align-items: center; gap: 24px; position: relative; z-index: 1; }
    .la-hero-icon { width: 64px; height: 64px; border-radius: 18px; background: rgba(255,255,255,0.18); border: 2px solid rgba(255,255,255,0.30); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .la-hero-icon svg { width: 30px; height: 30px; stroke: #fff; fill: none; stroke-width: 2; }
    .la-hero-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 900; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
    .la-hero-sub { font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500; }
    .la-hero-chips { display: flex; gap: 10px; margin-top: 14px; }
    .la-hero-chip { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.20); border-radius: 100px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.95); }
    .la-hero-right { display: flex; gap: 40px; position: relative; z-index: 1; flex-shrink: 0; }
    .la-hero-stat { text-align: center; }
    .la-hero-sv { font-family: 'Sora', sans-serif; font-size: 36px; font-weight: 900; color: #fff; line-height: 1; }
    .la-hero-sl { font-size: 11px; color: rgba(255,255,255,0.60); font-weight: 700; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.1em; }
</style>
    <aside class="pf-local-sidebar">
        <nav class="pf-local-nav">
            <div class="pf-nav-label">Management</div>
            <button class="pf-nav-item {{ $activeSection === 'dashboard' ? 'active' : '' }}" wire:click="selectSection('dashboard')">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                <span>Dashboard</span>
            </button>
            <button class="pf-nav-item {{ $activeSection === 'employees' ? 'active' : '' }}" wire:click="selectSection('employees')">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>Evaluations</span>
            </button>
            <button class="pf-nav-item {{ $activeSection === 'kpis' ? 'active' : '' }}" wire:click="selectSection('kpis')">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>KPI Settings</span>
            </button>
            <button class="pf-nav-item {{ $activeSection === 'goals' ? 'active' : '' }}" wire:click="selectSection('goals')">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                <span>Goal Tracking</span>
            </button>
            <div class="pf-nav-label">Feedback & Self</div>
            <button class="pf-nav-item {{ $activeSection === 'feedback' ? 'active' : '' }}" wire:click="selectSection('feedback')">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span>360 Feedback</span>
            </button>
            <button class="pf-nav-item" wire:click="initiateSelfAssessment">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Self Assessment</span>
            </button>
            <button class="pf-nav-item {{ $activeSection === 'history' ? 'active' : '' }}" wire:click="selectSection('history')">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <span>Review History</span>
            </button>
        </nav>
    </aside>
    <main class="pf-local-main">
        @if($activeSection === 'dashboard')
            <div class="la-hero">
                <div class="la-hero-left">
                    <div class="la-hero-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
                    </div>
                    <div>
                        <div class="la-hero-title">Performance Analytics</div>
                        <div class="la-hero-sub">Organization-wide talent and growth insights · {{ now()->format('F Y') }}</div>
                        <div class="la-hero-chips">
                            <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>{{ $stats['total_employees'] }} Staff</span>
                            <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>{{ $stats['pending_reviews'] }} Pending Reviews</span>
                        </div>
                    </div>
                </div>
                <div class="la-hero-right">
                    <div class="la-hero-stat"><div class="la-hero-sv">{{ $stats['avg_performance'] }}</div><div class="la-hero-sl">Avg Score</div></div>
                    <div class="la-hero-stat"><div class="la-hero-sv">{{ $stats['completed_goals'] }}</div><div class="la-hero-sl">Goals Done</div></div>
                    <div class="la-hero-stat"><div class="la-hero-sv">{{ count($recentReviews) }}</div><div class="la-hero-sl">Recent</div></div>
                </div>
            </div>
            <div style="margin-top: 32px; margin-bottom: 16px;">
                <h2 style="font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700;">Strategic KPIs</h2>
            </div>
            <div class="pf-stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));">
                @foreach($kpiSummaries as $kpi)
                    <div class="pf-stat-card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <div class="pf-stat-label" style="margin-bottom: 0;">{{ $kpi['name'] }}</div>
                            <span style="font-size: 14px; color: {{ $kpi['onTarget'] ? '#12B76A' : '#F04438' }};"><i class="fas fa-arrow-{{ $kpi['trend'] }}"></i></span>
                        </div>
                        <div style="display: flex; align-items: baseline; gap: 8px;">
                            <div class="pf-stat-val" style="font-size: 24px;">{{ number_format($kpi['current'], 1) }}{{ $kpi['unit'] }}</div>
                            <div style="font-size: 12px; color: var(--ink3);">Target: {{ $kpi['target'] }}{{ $kpi['unit'] }}</div>
                        </div>
                        <div style="margin-top: 12px; height: 4px; background: #E8EEF8; border-radius: 2px; overflow: hidden;">
                            <div style="height: 100%; width: {{ min(($kpi['current'] / ($kpi['target'] ?: 1)) * 100, 100) }}%; background: {{ $kpi['onTarget'] ? 'var(--blue)' : '#F04438' }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-top: 24px;">
                <div class="pf-card" style="padding: 24px;">
                    <div class="pf-card-hd" style="border: none; padding: 0 0 20px 0;"><span class="pf-card-title">Performance Score Trend</span></div>
                    <div style="height: 250px;"><canvas id="perfTrendChart"></canvas></div>
                </div>
                <div class="pf-card" style="padding: 24px;">
                    <div class="pf-card-hd" style="border: none; padding: 0 0 20px 0;"><span class="pf-card-title">Rating Distribution</span></div>
                    <div style="height: 250px;"><canvas id="ratingDistChart"></canvas></div>
                </div>
            </div>
            <div class="pf-card" style="margin-top: 24px;">
                <div class="pf-card-hd"><span class="pf-card-title">Recent Reviews</span><button class="pf-btn pf-btn-ghost pf-btn-sm" wire:click="selectSection('history')">View All</button></div>
                <table class="pf-table">
                    <thead><tr><th>Employee</th><th>Review Type</th><th>Date</th><th>Score</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($recentReviews as $review)
                            <tr wire:key="rev-{{ $review->id }}">
                                <td><div class="pf-user-cell"><div class="pf-avatar">{{ strtoupper(substr($review->employee->first_name, 0, 1)) }}</div><span>{{ $review->employee->full_name }}</span></div></td>
                                <td>{{ $review->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($review->review_date)->format('M d, Y') }}</td>
                                <td><strong>{{ number_format($review->overall_score, 1) }}</strong></td>
                                <td><span class="pf-badge pf-badge-green">Completed</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if($activeSection === 'employees')
            <div class="pf-header"><h1 class="pf-title">Employee Evaluations</h1><div class="pf-search-wrap"><input type="text" class="pf-input" placeholder="Search employees..." wire:model.live="search" style="width: 300px;"></div></div>
            <div class="pf-card">
                <table class="pf-table">
                    <thead><tr><th>Employee</th><th>Department</th><th>Position</th><th>Actions</th></tr></thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr wire:key="emp-{{ $employee->id }}">
                                <td><div class="pf-user-cell"><div class="pf-avatar">{{ strtoupper(substr($employee->first_name, 0, 1)) }}</div><div><div style="font-weight: 700;">{{ $employee->full_name }}</div><div style="font-size: 11px; color: var(--ink4);">{{ $employee->code }}</div></div></div></td>
                                <td>{{ $employee->department->name ?? '—' }}</td>
                                <td>{{ $employee->position->name ?? '—' }}</td>
                                <td><div style="display: flex; gap: 8px;"><button class="pf-btn pf-btn-ghost pf-btn-sm" wire:click="viewEmployeeDetails('{{ $employee->id }}')">View Profile</button><button class="pf-btn pf-btn-primary pf-btn-sm" wire:click="openEvaluationForm('{{ $employee->id }}')">Evaluate</button></div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding: 16px;">{{ $employees->links() }}</div>
            </div>
        @endif
        @if($activeSection === 'employee_detail')
            @if($selectedEmployee)
                <div class="pf-header"><div style="display: flex; align-items: center; gap: 16px;"><button class="pf-btn pf-btn-ghost" wire:click="selectSection('employees')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polyline points="15 18 9 12 15 6"></polyline></svg></button><h1 class="pf-title">{{ $selectedEmployee->full_name }}</h1></div><button class="pf-btn pf-btn-primary" wire:click="openEvaluationForm('{{ $selectedEmployee->id }}')">Create Review</button></div>
                <div class="pf-stats-grid"><div class="pf-stat-card"><div class="pf-stat-label">Review Count</div><div class="pf-stat-val">{{ $selectedEmployee->performanceReviews->count() }}</div></div><div class="pf-stat-card"><div class="pf-stat-label">Current Avg</div><div class="pf-stat-val">{{ number_format($selectedEmployee->performanceReviews->avg('overall_score') ?? 0, 1) }}</div></div></div>
                <div class="pf-card" style="margin-top: 24px;"><div class="pf-card-hd"><span class="pf-card-title">Performance History</span></div>
                    <table class="pf-table">
                        <thead><tr><th>Date</th><th>Type</th><th>Reviewer</th><th>Score</th><th>Actions</th></tr></thead>
                        <tbody>
                            @foreach($selectedEmployee->performanceReviews as $review)
                                <tr><td>{{ \Carbon\Carbon::parse($review->review_date)->format('M d, Y') }}</td><td>{{ $review->type }}</td><td>{{ $review->reviewer->full_name ?? 'N/A' }}</td><td><strong>{{ number_format($review->overall_score, 1) }}</strong></td><td><button class="pf-btn pf-btn-ghost pf-btn-sm">View Report</button></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
        @if($activeSection === 'feedback')
            <div class="pf-header"><h1 class="pf-title">360° Feedback</h1><button class="pf-btn pf-btn-primary" wire:click="$set('showFeedbackModal', true)">Request Feedback</button></div>
            <div class="pf-card">
                <div class="pf-card-hd"><span class="pf-card-title">Recent Feedback</span></div>
                <table class="pf-table">
                    <thead><tr><th>From</th><th>To</th><th>Relation</th><th>Rating</th><th>Comments</th></tr></thead>
                    <tbody>
                        @foreach(\App\Models\Feedback::with(['giver', 'receiver'])->take(10)->get() as $fb)
                            <tr wire:key="fb-{{ $fb->id }}"><td>{{ $fb->giver->full_name ?? 'Anonymous' }}</td><td>{{ $fb->receiver->full_name ?? 'N/A' }}</td><td><span class="pf-badge pf-badge-blue">{{ $fb->relationship }}</span></td><td><strong>{{ $fb->rating }}/5</strong></td><td>{{ Str::limit($fb->comments, 50) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if($activeSection === 'kpis')
            <div class="pf-header"><h1 class="pf-title">KPI Settings</h1><button class="pf-btn pf-btn-primary" wire:click="openKPIForm">Add New KPI</button></div>
            <div class="pf-card">
                <table class="pf-table">
                    <thead><tr><th>Code</th><th>Name</th><th>Category</th><th>Target</th><th>Weight</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($kpis as $kpi)
                            <tr wire:key="kpi-{{ $kpi->id }}"><td><span style="font-family: monospace; font-weight: 600; color: var(--blue);">{{ $kpi->code }}</span></td><td><div style="font-weight: 700;">{{ $kpi->name }}</div><div style="font-size: 11px; color: var(--ink4);">{{ Str::limit($kpi->description, 40) }}</div></td><td><span class="pf-badge pf-badge-blue">{{ $kpi->category }}</span></td><td><strong>{{ $kpi->target_value }}{{ $kpi->measurement_unit === 'percentage' ? '%' : '' }}</strong></td><td>{{ $kpi->weight_percentage }}%</td><td><span class="pf-badge {{ $kpi->is_active ? 'pf-badge-green' : 'pf-badge-gray' }}">{{ $kpi->is_active ? 'Active' : 'Inactive' }}</span></td><td><button class="pf-btn pf-btn-ghost pf-btn-sm" style="padding: 4px 8px;">Edit</button></td></tr>
                        @empty
                            <tr><td colspan="7" style="text-align: center; padding: 40px; color: var(--ink3);">No KPIs defined yet. Click "Add New KPI" to get started.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
        @if($activeSection === 'goals')
            <div class="pf-header"><h1 class="pf-title">Goal Tracking</h1><button class="pf-btn pf-btn-primary" wire:click="openGoalModal">Set New Goal</button></div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                @forelse($goals as $goal)
                    <div class="pf-card" style="padding: 20px;"><div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;"><div><div style="font-family: 'Sora', sans-serif; font-weight: 700; font-size: 15px;">{{ $goal->title }}</div><div style="font-size: 12px; color: var(--ink3);">Assigned to: {{ $goal->employee->full_name }}</div></div><span class="pf-badge {{ $goal->status === 'completed' ? 'pf-badge-green' : 'pf-badge-blue' }}">{{ ucfirst($goal->status) }}</span></div><div style="font-size: 13px; color: var(--ink2); margin-bottom: 16px;">{{ Str::limit($goal->description, 100) }}</div><div style="margin-bottom: 8px; display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: var(--ink3);"><span>Progress</span><span>{{ $goal->current_value }}%</span></div><div style="height: 6px; background: #EEF2F7; border-radius: 3px; overflow: hidden; margin-bottom: 16px;"><div style="height: 100%; width: {{ $goal->current_value }}%; background: var(--blue);"></div></div><div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px;"><div style="color: var(--ink4);"><i class="far fa-calendar-alt"></i> Due {{ \Carbon\Carbon::parse($goal->end_date)->format('M d, Y') }}</div><button class="pf-btn pf-btn-ghost pf-btn-sm" style="padding: 4px 8px;">Update</button></div></div>
                @empty
                    <div class="pf-card" style="grid-column: 1 / -1; padding: 40px; text-align: center; color: var(--ink3);">No active goals found.</div>
                @endforelse
            </div>
        @endif
        @if($activeSection === 'history')
            <div class="pf-header"><h1 class="pf-title">Review History</h1></div>
            <div class="pf-card"><div class="pf-card-hd"><span class="pf-card-title">Completed Reviews Archive</span></div>
                <table class="pf-table">
                    <thead><tr><th>ID</th><th>Employee</th><th>Type</th><th>Date</th><th>Score</th></tr></thead>
                    <tbody>
                        @foreach(\App\Models\PerformanceReview::with('employee')->where('status', 'completed')->orderBy('review_date', 'desc')->take(20)->get() as $rev)
                            <tr><td>{{ $rev->code }}</td><td>{{ $rev->employee->full_name }}</td><td>{{ $rev->type }}</td><td>{{ $rev->review_date->format('M d, Y') }}</td><td><strong>{{ $rev->overall_score }}</strong></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
    @if($showReviewModal)
        <div class="pf-modal-bg"><div class="pf-modal"><div class="pf-modal-hd"><span class="pf-modal-title">Performance Evaluation</span><button wire:click="$set('showReviewModal', false)" style="background: none; border: none; cursor: pointer;"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div><div class="pf-modal-body"><div class="pf-group"><label class="pf-label">Evaluation Type</label><select class="pf-input" wire:model="evalType"><option value="Annual Review">Annual Review</option><option value="Mid-Year Review">Mid-Year Review</option><option value="Quarterly Review">Quarterly Review</option></select></div><div class="pf-group"><label class="pf-label">Review Date</label><input type="date" class="pf-input" wire:model="evalReviewDate"></div><div class="pf-rating-grid">@foreach($metricScores as $metric => $score)<div class="pf-rating-item"><label class="pf-label">{{ $metric }}</label><input type="range" min="1" max="5" step="1" wire:model.live="metricScores.{{ $metric }}" style="width: 100%; accent-color: var(--blue);"><div style="text-align: right; font-weight: 800; color: var(--blue); font-size: 14px;">{{ $score }}/5</div></div>@endforeach</div><div class="pf-group" style="margin-top: 20px;"><label class="pf-label">Key Strengths</label><textarea class="pf-input" rows="3" wire:model="evalStrengths"></textarea></div><div class="pf-group"><label class="pf-label">Areas for Improvement</label><textarea class="pf-input" rows="3" wire:model="evalImprovements"></textarea></div></div><div class="pf-modal-footer"><button class="pf-btn pf-btn-ghost" wire:click="$set('showReviewModal', false)">Cancel</button><button class="pf-btn pf-btn-primary" wire:click="saveEvaluation">Submit Evaluation</button></div></div></div>
    @endif
    @if($showKPIModal)
        <div class="pf-modal-bg"><div class="pf-modal"><div class="pf-modal-hd"><span class="pf-modal-title">Create New KPI</span><button wire:click="$set('showKPIModal', false)" style="background: none; border: none; cursor: pointer;"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div><div class="pf-modal-body"><div class="pf-group"><label class="pf-label">KPI Name</label><input type="text" class="pf-input" wire:model="kpiName" placeholder="e.g. Sales Growth"></div><div class="pf-group"><label class="pf-label">Description</label><textarea class="pf-input" wire:model="kpiDescription" rows="2"></textarea></div><div class="pf-rating-grid"><div class="pf-group"><label class="pf-label">Target Value</label><input type="number" class="pf-input" wire:model="kpiTarget"></div><div class="pf-group"><label class="pf-label">Unit</label><select class="pf-input" wire:model="kpiUnit"><option value="percentage">Percentage (%)</option><option value="numeric">Numeric</option><option value="currency">Currency</option></select></div></div></div><div class="pf-modal-footer"><button class="pf-btn pf-btn-ghost" wire:click="$set('showKPIModal', false)">Cancel</button><button class="pf-btn pf-btn-primary" wire:click="saveKPI">Save KPI</button></div></div></div>
    @endif
    @if($showFeedbackModal)
        <div class="pf-modal-bg"><div class="pf-modal"><div class="pf-modal-hd"><span class="pf-modal-title">360° Feedback Form</span><button wire:click="$set('showFeedbackModal', false)" style="background: none; border: none; cursor: pointer;"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div><div class="pf-modal-body"><div class="pf-group"><label class="pf-label">Select Employee (Receiver)</label><select class="pf-input" wire:model="feedbackReceiverId"><option value="">Select Employee</option>@foreach($allEmployees as $emp)<option value="{{ $emp->id }}">{{ $emp->full_name }}</option>@endforeach</select></div><div class="pf-group"><label class="pf-label">Your Relationship</label><select class="pf-input" wire:model="feedbackRelation"><option value="Peer">Peer</option><option value="Direct Report">Direct Report</option><option value="Manager">Manager</option></select></div><div class="pf-group"><label class="pf-label">Rating (1-5)</label><input type="range" min="1" max="5" class="pf-input" wire:model="feedbackRating"></div><div class="pf-group"><label class="pf-label">Feedback Comments</label><textarea class="pf-input" rows="4" wire:model="feedbackComments" placeholder="Enter your constructive feedback..."></textarea></div></div><div class="pf-modal-footer"><button class="pf-btn pf-btn-ghost" wire:click="$set('showFeedbackModal', false)">Cancel</button><button class="pf-btn pf-btn-primary" wire:click="saveFeedback">Submit Feedback</button></div></div></div>
    @endif
    @if($showGoalModal)
        <div class="pf-modal-bg"><div class="pf-modal"><div class="pf-modal-hd"><span class="pf-modal-title">Set Performance Goal</span><button wire:click="$set('showGoalModal', false)" style="background: none; border: none; cursor: pointer;"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div><div class="pf-modal-body"><div class="pf-group"><label class="pf-label">Goal Title</label><input type="text" class="pf-input" wire:model="goalTitle" placeholder="e.g. Complete Advanced Laravel Cert"></div><div class="pf-group"><label class="pf-label">Description</label><textarea class="pf-input" wire:model="goalDescription" rows="3"></textarea></div><div class="pf-rating-grid"><div class="pf-group"><label class="pf-label">Due Date</label><input type="date" class="pf-input" wire:model="goalDueDate"></div><div class="pf-group"><label class="pf-label">Initial Progress (%)</label><input type="number" class="pf-input" wire:model="goalProgress"></div></div></div><div class="pf-modal-footer"><button class="pf-btn pf-btn-ghost" wire:click="$set('showGoalModal', false)">Cancel</button><button class="pf-btn pf-btn-primary" wire:click="saveGoal">Save Goal</button></div></div></div>
    @endif
    <script>
    document.addEventListener('livewire:navigated', () => { initPerformanceCharts(); });
    function initPerformanceCharts() {
        const trendCtx = document.getElementById('perfTrendChart')?.getContext('2d');
        if (trendCtx) {
            new Chart(trendCtx, { type: 'line', data: { labels: @json($performanceTrend->pluck('month')), datasets: [{ label: 'Avg Score', data: @json($performanceTrend->pluck('avg_score')), borderColor: '#3B6FE8', backgroundColor: 'rgba(59,111,232,0.1)', tension: 0.4, fill: true }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { min: 0, max: 5 } } } });
        }
        const distCtx = document.getElementById('ratingDistChart')?.getContext('2d');
        if (distCtx) {
            new Chart(distCtx, { type: 'doughnut', data: { labels: ['Excellent', 'Good', 'Satisfactory', 'Needs Imp.'], datasets: [{ data: [15, 45, 25, 15], backgroundColor: ['#12B76A', '#3B6FE8', '#F79009', '#F04438'] }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } } });
        }
    }
    initPerformanceCharts();
    </script>
</div>