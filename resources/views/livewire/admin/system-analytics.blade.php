<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">System Analytics & Insights</div>
            <div class="ac-hero-sub">Infrastructure health, security audit, and platform governance</div>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="ac-btn {{ $activeTab === 'security' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="{{ $activeTab === 'security' ? '' : 'background:rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.2);' }}" wire:click="$set('activeTab', 'security')">Security</button>
            <button class="ac-btn {{ $activeTab === 'infrastructure' ? 'active' : 'ac-btn-ghost' }}" style="{{ $activeTab === 'infrastructure' ? 'background:#fff; color:var(--blue);' : 'background:rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.2);' }}" wire:click="$set('activeTab', 'infrastructure')">Infrastructure</button>
            <button class="ac-btn {{ $activeTab === 'governance' ? 'active' : 'ac-btn-ghost' }}" style="{{ $activeTab === 'governance' ? 'background:#fff; color:var(--blue);' : 'background:rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.2);' }}" wire:click="$set('activeTab', 'governance')">Governance</button>
        </div>
    </div>

    @if($activeTab === 'security')
        <div class="ac-tiles">
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--blue);"></div>
                <div class="ac-tile-icon" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <div><div class="ac-tile-lbl">Total Logins</div><div class="ac-tile-val">{{ $securityData['total_logins'] }}</div><div class="ac-tile-sub">Past 30 days</div></div>
            </div>
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--red);"></div>
                <div class="ac-tile-icon" style="background:var(--red-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--red);"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                <div><div class="ac-tile-lbl">Failed Attempts</div><div class="ac-tile-val" style="color:var(--red);">{{ $securityData['failed_attempts'] }}</div><div class="ac-tile-sub">Blocked entries</div></div>
            </div>
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--amber);"></div>
                <div class="ac-tile-icon" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="8 12 11 15 16 9"/></svg></div>
                <div><div class="ac-tile-lbl">Password Resets</div><div class="ac-tile-val">{{ $securityData['password_resets'] }}</div><div class="ac-tile-sub">Security events</div></div>
            </div>
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--green);"></div>
                <div class="ac-tile-icon" style="background:var(--green-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--green);"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div><div class="ac-tile-lbl">Active Admins</div><div class="ac-tile-val" style="color:var(--green);">{{ $securityData['active_admins'] }}</div><div class="ac-tile-sub">Privileged users</div></div>
            </div>
        </div>

        <div class="ac-card">
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Recent Security Failures</div><div class="ac-card-sub">Login attempts with invalid credentials</div></div>
                <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="refreshAnalytics">Refresh</button>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th style="padding-left:24px;">Event Time</th>
                            <th>Identity / Username</th>
                            <th>Access Point</th>
                            <th style="text-align:right; padding-right:24px;">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($securityData['recent_failures'] as $log)
                            <tr>
                                <td style="padding-left:24px;">{{ $log->created_at->format('M d, H:i:s') }}</td>
                                <td><span class="ac-badge ab-red">{{ $log->user_id ? 'User ID: '.substr($log->user_id,0,8) : 'Anonymous' }}</span></td>
                                <td><div style="font-family:monospace; font-size:12px; color:var(--ink3);">{{ $log->ip_address ?? 'Hidden' }}</div></td>
                                <td style="text-align:right; padding-right:24px;"><div style="font-size:12px; font-weight:600; color:var(--ink2);">Potential Unauthorized Access</div></td>
                            </tr>
                        @empty
                            <tr><td colspan="4"><div class="ac-empty">No recent security threats detected.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($activeTab === 'infrastructure')
        <div class="ac-tiles">
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--blue);"></div>
                <div class="ac-tile-icon" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
                <div><div class="ac-tile-lbl">Database Size</div><div class="ac-tile-val">{{ $infrastructure['database_size'] }}</div><div class="ac-tile-sub">Physical footprint</div></div>
            </div>
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--indigo);"></div>
                <div class="ac-tile-icon" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div><div class="ac-tile-lbl">Total Records</div><div class="ac-tile-val">{{ number_format($infrastructure['total_records']) }}</div><div class="ac-tile-sub">Indexed objects</div></div>
            </div>
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--teal);"></div>
                <div class="ac-tile-icon" style="background:var(--teal-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--teal);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="8 12 11 15 16 9"/></svg></div>
                <div><div class="ac-tile-lbl">Cache Engine</div><div class="ac-tile-val">{{ $infrastructure['cache_status'] }}</div><div class="ac-tile-sub">Buffer status</div></div>
            </div>
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--amber);"></div>
                <div class="ac-tile-icon" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
                <div><div class="ac-tile-lbl">Environment</div><div class="ac-tile-val">{{ strtoupper($infrastructure['environment']) }}</div><div class="ac-tile-sub">Operational mode</div></div>
            </div>
        </div>

        <div class="ac-card">
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Database Integrity</div><div class="ac-card-sub">Current row counts across critical system tables</div></div>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th style="padding-left:24px;">Table Name</th>
                            <th>Record Count</th>
                            <th style="text-align:right; padding-right:24px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($infrastructure['row_counts'] as $table => $count)
                            <tr>
                                <td style="padding-left:24px; font-weight:800; color:var(--ink);">{{ $table }}</td>
                                <td style="font-weight:700; color:var(--blue);">{{ number_format($count) }}</td>
                                <td style="text-align:right; padding-right:24px;"><span class="ac-badge ab-green">Synchronized</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($activeTab === 'governance')
        <div class="ac-tiles">
            @foreach($governance['account_status'] as $status => $count)
                <div class="ac-tile">
                    <div class="ac-tile-accent" style="background:{{ $status === 'Active' ? 'var(--green)' : 'var(--red)' }};"></div>
                    <div class="ac-tile-icon" style="background:{{ $status === 'Active' ? 'var(--green-lt)' : 'var(--red-lt)' }};">
                        <svg viewBox="0 0 24 24" style="stroke:{{ $status === 'Active' ? 'var(--green)' : 'var(--red)' }};">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div><div class="ac-tile-lbl">{{ $status }} Accounts</div><div class="ac-tile-val">{{ $count }}</div><div class="ac-tile-sub">System-wide</div></div>
                </div>
            @endforeach
            <div class="ac-tile">
                <div class="ac-tile-accent" style="background:var(--indigo);"></div>
                <div class="ac-tile-icon" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <div><div class="ac-tile-lbl">Defined Roles</div><div class="ac-tile-val">{{ $governance['role_distribution']->count() }}</div><div class="ac-tile-sub">Access levels</div></div>
            </div>
        </div>

        <div class="ac-card">
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Privileged Access Logs</div><div class="ac-card-sub">Recent changes to system permissions or roles</div></div>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th style="padding-left:24px;">Timestamp</th>
                            <th>Administrator</th>
                            <th>Identity</th>
                            <th style="text-align:right; padding-right:24px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($governance['recent_permission_changes'] as $log)
                            <tr>
                                <td style="padding-left:24px;">{{ $log->created_at->diffForHumans() }}</td>
                                <td><div style="font-weight:800; color:var(--ink);">Admin Account</div></td>
                                <td><span class="ac-badge ab-indigo">#{{ substr($log->user_id,0,8) }}</span></td>
                                <td style="text-align:right; padding-right:24px;"><span class="ac-badge ab-teal">Matrix Update</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4"><div class="ac-empty">No administrative overrides recorded recently.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
