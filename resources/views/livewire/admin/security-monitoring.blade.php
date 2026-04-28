<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session()->has('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Security Operations</div>
            <div class="ac-hero-sub">Monitor system health, view deep-level audits, and manage IT maintenance</div>
        </div>
        <div style="display:flex; gap:12px;">
            <div style="background:rgba(255,255,255,0.1); padding:10px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.2); text-align:center;">
                <div style="font-size:18px; font-weight:800; color:#fff;">{{ number_format($stats['locked_users']) }}</div>
                <div style="font-size:10px; color:rgba(255,255,255,0.7); font-weight:700; text-transform:uppercase;">Locked</div>
            </div>
            <div style="background:rgba(255,255,255,0.1); padding:10px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.2); text-align:center;">
                <div style="font-size:18px; font-weight:800; color:#fff;">{{ number_format($stats['total_audits']) }}</div>
                <div style="font-size:10px; color:rgba(255,255,255,0.7); font-weight:700; text-transform:uppercase;">Audits</div>
            </div>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div style="display:flex; gap:8px; margin-bottom:24px; background:var(--white); padding:6px; border-radius:16px; border:1.5px solid var(--border); width:fit-content;">
        <button wire:click="$set('activeTab', 'dashboard')" style="border:none; padding:10px 24px; border-radius:12px; font-size:13px; font-weight:700; cursor:pointer; transition:0.2s; {{ $activeTab === 'dashboard' ? 'background:var(--blue); color:#fff; box-shadow:var(--sh-sm);' : 'background:transparent; color:var(--ink3);' }}">Dashboard</button>
        <button wire:click="$set('activeTab', 'audits')" style="border:none; padding:10px 24px; border-radius:12px; font-size:13px; font-weight:700; cursor:pointer; transition:0.2s; {{ $activeTab === 'audits' ? 'background:var(--blue); color:#fff; box-shadow:var(--sh-sm);' : 'background:transparent; color:var(--ink3);' }}">Audit Logs</button>
        <button wire:click="$set('activeTab', 'activities')" style="border:none; padding:10px 24px; border-radius:12px; font-size:13px; font-weight:700; cursor:pointer; transition:0.2s; {{ $activeTab === 'activities' ? 'background:var(--blue); color:#fff; box-shadow:var(--sh-sm);' : 'background:transparent; color:var(--ink3);' }}">User Activity</button>
        <button wire:click="$set('activeTab', 'maintenance')" style="border:none; padding:10px 24px; border-radius:12px; font-size:13px; font-weight:700; cursor:pointer; transition:0.2s; {{ $activeTab === 'maintenance' ? 'background:var(--blue); color:#fff; box-shadow:var(--sh-sm);' : 'background:transparent; color:var(--ink3);' }}">Maintenance</button>
    </div>

    {{-- ── CONTENT ── --}}
    <div class="ac-card">
        @if($activeTab === 'dashboard')
            <div style="padding:40px; text-align:center;">
                <div style="width:80px; height:80px; border-radius:100px; background:var(--blue-lt); display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <svg viewBox="0 0 24 24" style="width:40px; height:40px; stroke:var(--blue); fill:none; stroke-width:2;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="ac-card-title" style="font-size:24px;">System Integrity Report</div>
                <p style="color:var(--ink3); max-width:500px; margin:16px auto; line-height:1.6;">
                    The core security engine is monitoring all data mutations and authentication attempts. Switch between tabs to view detailed forensic logs.
                </p>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin-top:40px;">
                    <div style="padding:24px; border-radius:16px; background:var(--bg); border:1.5px solid var(--border);">
                        <div style="font-size:12px; font-weight:700; color:var(--ink4); text-transform:uppercase; margin-bottom:8px;">Database Changes</div>
                        <div style="font-size:32px; font-weight:800; font-family:'Sora',sans-serif; color:var(--blue);">{{ number_format($stats['total_audits']) }}</div>
                    </div>
                    <div style="padding:24px; border-radius:16px; background:var(--bg); border:1.5px solid var(--border);">
                        <div style="font-size:12px; font-weight:700; color:var(--ink4); text-transform:uppercase; margin-bottom:8px;">Session Events</div>
                        <div style="font-size:32px; font-weight:800; font-family:'Sora',sans-serif; color:var(--teal);">{{ number_format($stats['total_activities']) }}</div>
                    </div>
                    <div style="padding:24px; border-radius:16px; background:var(--bg); border:1.5px solid var(--border);">
                        <div style="font-size:12px; font-weight:700; color:var(--ink4); text-transform:uppercase; margin-bottom:8px;">Security Locks</div>
                        <div style="font-size:32px; font-weight:800; font-family:'Sora',sans-serif; color:var(--red);">{{ number_format($stats['locked_users']) }}</div>
                    </div>
                </div>
            </div>
        @endif

        @if($activeTab === 'audits')
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Audit Trail</div><div class="ac-card-sub">Deep-level database modifications</div></div>
                <div class="ac-field" style="width:300px; margin:0;"><input wire:model.live.debounce.300ms="auditSearch" placeholder="Filter models or events..." style="padding:10px 14px;"></div>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead><tr><th style="padding-left:24px;">Timestamp</th><th>Event</th><th>Subject</th><th>Causer</th><th>Mutation Summary</th></tr></thead>
                    <tbody>
                        @forelse($auditLogs as $audit)
                            <tr>
                                <td style="padding-left:24px; white-space:nowrap; font-size:12px; color:var(--ink4);">{{ $audit->created_at->format('M d, H:i:s') }}</td>
                                <td>
                                    @php $ec = match($audit->event){'created'=>'ab-green','updated'=>'ab-teal','deleted'=>'ab-red',default=>'ab-gray'}; @endphp
                                    <span class="ac-badge {{ $ec }}">{{ strtoupper($audit->event) }}</span>
                                </td>
                                <td>
                                    <div style="font-weight:700; font-size:13px; color:var(--ink);">{{ class_basename($audit->subject_type) }}</div>
                                    <div style="font-size:11px; color:var(--ink4);">ID: {{ $audit->subject_id }}</div>
                                </td>
                                <td>
                                    <div style="font-weight:700; font-size:13px;">{{ $audit->causer->name ?? 'System' }}</div>
                                    <div style="font-family:'Sora',sans-serif; font-size:10px; color:var(--blue);">IP: {{ $audit->ip_address }}</div>
                                </td>
                                <td>
                                    <div style="max-width:350px; font-size:10px; font-family:'DM Mono',monospace; background:var(--bg); padding:10px; border-radius:8px; line-height:1.4; color:var(--ink3);">
                                        @if(isset($audit->properties['attributes'])) <strong>+</strong> {{ Str::limit(json_encode($audit->properties['attributes']), 80) }} @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding:60px; color:var(--ink4);">No audit records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($auditLogs->hasPages()) <div style="padding:16px 24px; border-top:1px solid var(--border);">{{ $auditLogs->links() }}</div> @endif
        @endif

        @if($activeTab === 'activities')
            <div class="ac-card-hd">
                <div><div class="ac-card-title">User Interactions</div><div class="ac-card-sub">Application level actions and sessions</div></div>
                <div class="ac-field" style="width:300px; margin:0;"><input wire:model.live.debounce.300ms="activitySearch" placeholder="Search activities..." style="padding:10px 14px;"></div>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead><tr><th style="padding-left:24px;">Session Time</th><th>Account</th><th>Action Detail</th><th>Connectivity</th><th style="text-align:right; padding-right:24px;">Response</th></tr></thead>
                    <tbody>
                        @forelse($activityLogs as $activity)
                            <tr>
                                <td style="padding-left:24px; font-size:12px; color:var(--ink4);">{{ $activity->created_at->format('M d, H:i') }}</td>
                                <td>
                                    @if($activity->user)
                                        <div style="font-weight:700; font-size:13px; color:var(--ink);">{{ $activity->user->name }}</div>
                                        @if(!$activity->user->is_active) <span class="ac-badge ab-red" style="font-size:9px;">ACCOUNT LOCKED</span> @endif
                                    @else System @endif
                                </td>
                                <td>
                                    <div style="font-weight:800; color:var(--blue); font-size:12px;">{{ strtoupper($activity->action) }}</div>
                                    <div style="font-size:11px; color:var(--ink4);">{{ $activity->module }} · {{ Str::limit($activity->description, 50) }}</div>
                                </td>
                                <td style="font-family:'Sora',sans-serif; font-size:10px; color:var(--ink3);">{{ $activity->ip_address }}</td>
                                <td style="text-align:right; padding-right:24px;">
                                    @if($activity->user && $activity->user->is_active)
                                        <button class="ac-btn ac-btn-danger ac-btn-sm" wire:click="lockAccount('{{ $activity->user_id }}')">Lock</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding:60px; color:var(--ink4);">No activity logs found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($activityLogs->hasPages()) <div style="padding:16px 24px; border-top:1px solid var(--border);">{{ $activityLogs->links() }}</div> @endif
        @endif

        @if($activeTab === 'maintenance')
            <div style="padding:40px; max-width:700px;">
                <div class="ac-card-title" style="margin-bottom:24px;">System & Infrastructure Management</div>
                
                <div style="display:flex; flex-direction:column; gap:32px;">
                    <div>
                        <div style="font-size:11px; font-weight:800; color:var(--ink4); text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">Critical Operations</div>
                        <div style="display:flex; gap:16px;">
                            <button wire:click="clearCache" class="ac-btn ac-btn-ghost" style="flex:1;">Flush System Cache</button>
                            <button wire:click="backupSystem" class="ac-btn ac-btn-primary" style="flex:1;">Snapshot Database</button>
                        </div>
                    </div>

                    <div style="padding:24px; border-radius:16px; background:rgba(239, 68, 68, 0.04); border:1.5px solid rgba(239, 68, 68, 0.1);">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <div style="font-size:14px; font-weight:800; color:var(--red);">Maintenance Mode</div>
                            <input type="checkbox" wire:model="maintenance_mode" style="width:20px; height:20px;">
                        </div>
                        <p style="font-size:12px; color:var(--ink3); line-height:1.5; margin-bottom:16px;">When enabled, only authorized administrators can access the system. All other users will see the maintenance notice.</p>
                        @if($maintenance_mode)
                            <div class="ac-field">
                                <label>Public Message</label>
                                <textarea wire:model="maintenance_message" rows="3" placeholder="Explain the downtime to users..."></textarea>
                            </div>
                        @endif
                    </div>

                    <button wire:click="saveITSettings" class="ac-btn ac-btn-primary" style="width:fit-content; padding:12px 32px;">Commit Changes</button>
                </div>

                <div style="margin-top:48px; display:grid; grid-template-columns:1fr 1fr; gap:24px; font-family:'Sora',sans-serif; font-size:11px; background:var(--bg); padding:24px; border-radius:16px;">
                    <div><span style="color:var(--ink4);">LARAVEL:</span> <span style="font-weight:800; color:var(--ink);">{{ $systemInfo['laravel_version'] }}</span></div>
                    <div><span style="color:var(--ink4);">PHP ENGINE:</span> <span style="font-weight:800; color:var(--ink);">{{ $systemInfo['php_version'] }}</span></div>
                    <div><span style="color:var(--ink4);">DB DRIVER:</span> <span style="font-weight:800; color:var(--ink);">{{ $systemInfo['database'] }}</span></div>
                    <div><span style="color:var(--ink4);">ENVIRONMENT:</span> <span style="font-weight:800; color:var(--blue);">{{ strtoupper(config('app.env')) }}</span></div>
                </div>
            </div>
        @endif
    </div>
</div>
