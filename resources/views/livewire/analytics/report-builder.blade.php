<div class="rp-local-shell">
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

    .rp-local-shell {
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
    .rp-local-sidebar { position: sticky; top: 32px; display: flex; flex-direction: column; gap: 24px; }
    .rp-local-nav { display: flex; flex-direction: column; gap: 8px; background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 12px; box-shadow: var(--sh-sm); }
    .rp-nav-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); padding: 12px 16px 4px; letter-spacing: 0.08em; }
    .rp-nav-item {
        display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--r);
        font-size: 14px; font-weight: 700; color: var(--ink2); cursor: pointer; border: none; background: transparent; 
        font-family: 'DM Sans', sans-serif; transition: all .2s; text-align: left; width: 100%;
    }
    .rp-nav-item svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2.2; opacity: 0.6; }
    .rp-nav-item:hover { background: var(--blue-lt); color: var(--blue); }
    .rp-nav-item.active { background: var(--blue); color: #fff; box-shadow: 0 8px 20px rgba(59, 111, 232, 0.25); }
    .rp-nav-item.active svg { opacity: 1; stroke: #fff; }

    /* Main Content */
    .rp-local-main { display: flex; flex-direction: column; gap: 32px; min-width: 0; }
    .rp-header { display: flex; justify-content: space-between; align-items: center; }
    .rp-title { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--ink); letter-spacing: -0.5px; }

    /* Card */
    .rp-card { background: var(--white); border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; padding: 32px; }
    .rp-card-hd { padding-bottom: 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    
    .rp-form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
    .rp-group { display: flex; flex-direction: column; gap: 8px; }
    .rp-label { font-size: 12px; font-weight: 700; color: var(--ink4); text-transform: uppercase; letter-spacing: 0.05em; }
    .rp-input { padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); font-family: inherit; font-size: 14px; background: var(--white); color: var(--ink); transition: border-color .15s; }
    .rp-input:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 4px var(--blue-lt); }

    .rp-table { width: 100%; border-collapse: collapse; }
    .rp-table th { text-align: left; padding: 16px 24px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); letter-spacing: 0.08em; border-bottom: 2px solid var(--border); }
    .rp-table td { padding: 20px 24px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--ink2); }

    .rp-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; font-family: 'Sora', sans-serif; }
    .rp-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 8px 20px rgba(59, 111, 232, 0.25); }
    .rp-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
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
    <aside class="rp-local-sidebar">
        <nav class="rp-local-nav">
            <div class="rp-nav-label">Reports</div>
            <button class="rp-nav-item {{ $reportCategory === 'employee' ? 'active' : '' }}" wire:click="$set('reportCategory', 'employee')">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>Employee List</span>
            </button>
            <button class="rp-nav-item {{ $reportCategory === 'attendance' ? 'active' : '' }}" wire:click="$set('reportCategory', 'attendance')">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Attendance</span>
            </button>
            <button class="rp-nav-item {{ $reportCategory === 'performance' ? 'active' : '' }}" wire:click="$set('reportCategory', 'performance')">
                <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Performance</span>
            </button>
            <button class="rp-nav-item {{ $reportCategory === 'leave' ? 'active' : '' }}" wire:click="$set('reportCategory', 'leave')">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Leaves</span>
            </button>
            <button class="rp-nav-item {{ $reportCategory === 'payroll' ? 'active' : '' }}" wire:click="$set('reportCategory', 'payroll')">
                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                <span>Payroll</span>
            </button>
        </nav>
    </aside>
    <main class="rp-local-main">
        <div class="la-hero">
            <div class="la-hero-left">
                <div class="la-hero-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <div class="la-hero-title">Unified HR Reporting</div>
                    <div class="la-hero-sub">Custom reports and data exports for all modules · {{ now()->format('Y') }}</div>
                    <div class="la-hero-chips">
                        <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>{{ ucfirst($reportCategory) }} Report</span>
                        <span class="la-hero-chip"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>{{ count($previewData) }} Records Found</span>
                    </div>
                </div>
            </div>
            <div class="la-hero-right">
                <button class="rp-btn rp-btn-primary" wire:click="generatePdf" style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.30);box-shadow:none;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Export PDF
                </button>
            </div>
        </div>

        <div class="rp-card">
            <div class="rp-form-grid">
                <div class="rp-group">
                    <label class="rp-label">Start Date</label>
                    <input type="date" class="rp-input" wire:model.live="startDate">
                </div>
                <div class="rp-group">
                    <label class="rp-label">End Date</label>
                    <input type="date" class="rp-input" wire:model.live="endDate">
                </div>
                <div class="rp-group">
                    <label class="rp-label">Department</label>
                    <select class="rp-input" wire:model.live="selectedDepartment">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="rp-nav-label">Preview (Top 10)</div>
            <table class="rp-table">
                <thead>
                    @if($reportCategory === 'employee')
                        <tr><th>Name</th><th>Email</th><th>Dept</th><th>Status</th></tr>
                    @elseif($reportCategory === 'attendance')
                        <tr><th>Employee</th><th>Date</th><th>Status</th></tr>
                    @elseif($reportCategory === 'performance')
                        <tr><th>Employee</th><th>Type</th><th>Score</th></tr>
                    @else
                        <tr><th>ID</th><th>Name</th><th>Date</th></tr>
                    @endif
                </thead>
                <tbody>
                    @foreach($previewData as $item)
                        @if($reportCategory === 'employee')
                            <tr><td>{{ $item->full_name }}</td><td>{{ $item->email }}</td><td>{{ $item->department->name ?? '—' }}</td><td>Active</td></tr>
                        @elseif($reportCategory === 'attendance')
                            <tr><td>{{ $item->employee->full_name }}</td><td>{{ $item->date->format('M d') }}</td><td>{{ $item->status }}</td></tr>
                        @elseif($reportCategory === 'performance')
                            <tr><td>{{ $item->employee->full_name }}</td><td>{{ $item->type }}</td><td>{{ $item->overall_score }}</td></tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
</div>
