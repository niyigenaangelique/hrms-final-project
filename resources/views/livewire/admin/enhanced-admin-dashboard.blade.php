{{-- ═══════════════════════════════════════════════════════════════
     resources/views/livewire/admin/enhanced-dashboard.blade.php
═══════════════════════════════════════════════════════════════ --}}
<x-admin-content-styles />
<div class="ac-root">

    <div class="ac-header">
        <div>
            <div class="ac-header-title">Admin Dashboard</div>
            <div class="ac-header-sub">System overview · {{ now()->format('l, F j, Y') }}</div>
        </div>
        <a href="{{ route('admin.users') }}" class="ac-btn ac-btn-primary" wire:navigate>
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Account
        </a>
    </div>

    {{-- Stat tiles --}}
    <div class="ac-tiles">
        <div class="ac-tile ac-t-indigo">
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--indigo);border-radius:var(--r-lg) var(--r-lg) 0 0;"></div>
            <div class="ac-tile-icon" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
            <div><div class="ac-tile-lbl">Total Users</div><div class="ac-tile-val" style="color:var(--indigo);">{{ $totalUsers }}</div><div class="ac-tile-sub">{{ $adminCount }} admin · {{ $hrCount }} HR · {{ $empCount }} employee</div></div>
        </div>
        <div class="ac-tile ac-t-teal">
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--teal);border-radius:var(--r-lg) var(--r-lg) 0 0;"></div>
            <div class="ac-tile-icon" style="background:var(--teal-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--teal);"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
            <div><div class="ac-tile-lbl">Approved Payroll</div><div class="ac-tile-val" style="color:var(--teal);font-size:18px;">{{ number_format($payrollTotal,0) }}</div><div class="ac-tile-sub">RWF · {{ $payrollCount }} entries</div></div>
        </div>
        <div class="ac-tile ac-t-blue">
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--blue);border-radius:var(--r-lg) var(--r-lg) 0 0;"></div>
            <div class="ac-tile-icon" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
            <div><div class="ac-tile-lbl">Active Sessions</div><div class="ac-tile-val" style="color:var(--blue);">{{ $sessionCount }}</div><div class="ac-tile-sub">live right now</div></div>
        </div>
        <div class="ac-tile ac-t-amber">
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--amber);border-radius:var(--r-lg) var(--r-lg) 0 0;"></div>
            <div class="ac-tile-icon" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
            <div><div class="ac-tile-lbl">Today's Events</div><div class="ac-tile-val" style="color:var(--amber);">{{ $auditCount }}</div><div class="ac-tile-sub">audit log entries</div></div>
        </div>
    </div>

    {{-- Two-column layout --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">

        {{-- Recent users --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Recent Users</div><div class="ac-card-sub">Latest accounts created</div></div>
                <a href="{{ route('admin.users') }}" class="ac-btn ac-btn-ghost ac-btn-sm" wire:navigate>View all →</a>
            </div>
            @forelse($recentUsers as $u)
            @php $r=$u->role??'employee'; $rc=match($r){'admin'=>'ab-indigo','hr_manager'=>'ab-teal',default=>'ab-green'}; @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);">
                <div class="ac-user-cell">
                    <div class="ac-av">{{ strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)) }}</div>
                    <div>
                        <div class="ac-user-name">{{ trim(($u->first_name??'').' '.($u->last_name??'')) }}</div>
                        <div class="ac-user-meta">{{ $u->email }}</div>
                    </div>
                </div>
                <span class="ac-badge {{ $rc }}">{{ ['admin'=>'Admin','hr_manager'=>'HR Mgr','employee'=>'Employee'][$r]??$r }}</span>
            </div>
            @empty
            <div class="ac-empty" style="padding:28px;"><div class="ac-empty-sub">No users yet.</div></div>
            @endforelse
        </div>

        {{-- Recent activity --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Recent Activity</div><div class="ac-card-sub">Latest audit events</div></div>
                <a href="{{ route('admin.dashboard') }}" class="ac-btn ac-btn-ghost ac-btn-sm" wire:navigate>View all →</a>
            </div>
            @forelse($recentActivity as $log)
            @php
                $ev    = $log->event ?? 'system';
                $color = match(true) { str_contains($ev,'create')=>'#10B981',str_contains($ev,'update')=>'#3B82F6',str_contains($ev,'delete')=>'#EF4444',str_contains($ev,'login')=>'#A855F7', default=>'#94A3B8' };
            @endphp
            <div class="ac-log-row">
                <div class="ac-log-dot" style="background:{{ $color }};margin-top:6px;"></div>
                <div class="ac-log-desc">{{ $log->description ?? 'System event' }}</div>
                <div class="ac-log-time">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}</div>
            </div>
            @empty
            <div class="ac-empty" style="padding:28px;"><div class="ac-empty-sub">No activity logged yet.</div></div>
            @endforelse
        </div>

    </div>

    {{-- Quick links --}}
    <div class="ac-card">
        <div class="ac-card-hd"><div><div class="ac-card-title">Quick Navigation</div><div class="ac-card-sub">Jump to any admin section</div></div></div>
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:0;">
            @foreach([
                ['route'=>'admin.users',              'icon'=>'users',       'label'=>'Users'],
                ['route'=>'admin.dashboard',          'icon'=>'activity',    'label'=>'Dashboard'],
                ['route'=>'admin.notifications',      'icon'=>'bell',        'label'=>'Notifications'],
            ] as $link)
            <a href="{{ route($link['route']) }}" wire:navigate
               style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:18px 12px;border-right:1px solid var(--border);border-bottom:1px solid var(--border);text-decoration:none;color:var(--ink2);font-size:12.5px;font-weight:700;transition:background .12s;"
               onmouseover="this.style.background='#F0F9FF'" onmouseout="this.style.background=''">
                <div style="width:38px;height:38px;border-radius:10px;background:var(--indigo-lt);display:flex;align-items:center;justify-content:center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--indigo)" stroke-width="2">
                        @if($link['icon']==='users')<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        @elseif($link['icon']==='key')<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                        @elseif($link['icon']==='shield')<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        @elseif($link['icon']==='monitor')<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                        @elseif($link['icon']==='refresh')<polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>
                        @elseif($link['icon']==='bell')<path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                        @else<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        @endif
                    </svg>
                </div>
                {{ $link['label'] }}
            </a>
            @endforeach
        </div>
    </div>

</div>
