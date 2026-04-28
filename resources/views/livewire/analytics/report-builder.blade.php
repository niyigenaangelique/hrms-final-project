<div class="ac-root" style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; padding: 32px 40px; align-items: flex-start;">
    <x-admin-content-styles />
    
    <style>
        .hr-sidebar {
            position: sticky;
            top: 32px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 16px;
            box-shadow: var(--sh-sm);
        }
        .hr-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--r);
            font-size: 14px;
            font-weight: 700;
            color: var(--ink2);
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: transparent;
            text-align: left;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }
        .hr-nav-item svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.2;
            opacity: 0.6;
        }
        .hr-nav-item:hover {
            background: var(--blue-lt);
            color: var(--blue);
        }
        .hr-nav-item.active {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 8px 20px rgba(59, 111, 232, 0.25);
        }
        .hr-nav-item.active svg {
            opacity: 1;
            stroke: #fff;
        }
    </style>

    <aside class="hr-sidebar">
        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); padding: 0 16px 8px; letter-spacing: 0.08em;">Reports</div>
        <button class="hr-nav-item {{ $reportCategory === 'employee' ? 'active' : '' }}" wire:click="$set('reportCategory', 'employee')">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
            <span>Employee List</span>
        </button>
        <button class="hr-nav-item {{ $reportCategory === 'attendance' ? 'active' : '' }}" wire:click="$set('reportCategory', 'attendance')">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <span>Attendance</span>
        </button>
        <button class="hr-nav-item {{ $reportCategory === 'performance' ? 'active' : '' }}" wire:click="$set('reportCategory', 'performance')">
            <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            <span>Performance</span>
        </button>
        <button class="hr-nav-item {{ $reportCategory === 'leave' ? 'active' : '' }}" wire:click="$set('reportCategory', 'leave')">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Leaves</span>
        </button>
        <button class="hr-nav-item {{ $reportCategory === 'payroll' ? 'active' : '' }}" wire:click="$set('reportCategory', 'payroll')">
            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            <span>Payroll</span>
        </button>
    </aside>

    <main style="display: flex; flex-direction: column; gap: 32px; min-width: 0;">
        <div class="ac-hero">
            <div>
                <div class="ac-hero-ttl">HR Report Builder</div>
                <div class="ac-hero-sub">Custom reports and data exports for all HR modules · {{ now()->year }}</div>
                <div style="display:flex; gap:10px; margin-top:16px;">
                    <span class="ac-badge" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.2);">{{ count($previewData) }} Records Found</span>
                    <span class="ac-badge" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.2);">{{ ucfirst($reportCategory) }} Module</span>
                </div>
            </div>
            <button class="ac-btn ac-btn-primary" wire:click="generatePdf" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);">
                <svg viewBox="0 0 24 24" style="stroke:#fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span style="color:#fff;">Export PDF</span>
            </button>
        </div>

        <div class="ac-card" style="padding:32px;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px;">
                <div class="ac-field">
                    <label>Start Date</label>
                    <input type="date" wire:model.live="startDate">
                </div>
                <div class="ac-field">
                    <label>End Date</label>
                    <input type="date" wire:model.live="endDate">
                </div>
                <div class="ac-field">
                    <label>Department</label>
                    <select wire:model.live="selectedDepartment">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); letter-spacing: 0.1em; margin-bottom: 16px;">Preview (Top 10 Records)</div>
            <table class="ac-table">
                <thead>
                    @if($reportCategory === 'employee')
                        <tr><th>Full Name</th><th>Email</th><th>Department</th><th>Status</th></tr>
                    @elseif($reportCategory === 'attendance')
                        <tr><th>Employee</th><th>Date</th><th>Status</th></tr>
                    @elseif($reportCategory === 'performance')
                        <tr><th>Employee</th><th>Type</th><th>Score</th></tr>
                    @else
                        <tr><th>ID</th><th>Name</th><th>Date</th></tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($previewData as $item)
                        @if($reportCategory === 'employee')
                            <tr><td>{{ $item->full_name }}</td><td>{{ $item->email }}</td><td>{{ $item->department->name ?? '—' }}</td><td><span class="ac-badge ab-green">Active</span></td></tr>
                        @elseif($reportCategory === 'attendance')
                            <tr><td>{{ $item->employee->full_name }}</td><td>{{ $item->date->format('M d, Y') }}</td><td><span class="ac-badge ab-{{ $item->status === 'present' ? 'green' : 'red' }}">{{ strtoupper($item->status) }}</span></td></tr>
                        @elseif($reportCategory === 'performance')
                            <tr><td>{{ $item->employee->full_name }}</td><td>{{ $item->type }}</td><td><strong>{{ $item->overall_score }}</strong></td></tr>
                        @endif
                    @empty
                        <tr><td colspan="4" style="text-align:center; padding:40px; color:var(--ink4);">No records found for the selected filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</div>
