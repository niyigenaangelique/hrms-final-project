<div class="ep-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens Sync ══════════════════════════════════════════ */
.ep-root {
    --blue:     #3B6FE8;
    --blue-2:   #2755CC;
    --blue-3:   #1A3FA8;
    --blue-lt:  rgba(59,111,232,0.08);
    --blue-mid: rgba(59,111,232,0.16);
    --blue-brd: rgba(59,111,232,0.22);
    --bg:       #F0F4FA;
    --white:    #FFFFFF;
    --ink:      #0F1629;
    --ink2:     #2D3356;
    --ink3:     #6B7094;
    --ink4:     #A8ADCA;
    --border:   rgba(15,22,41,0.08);
    --shadow:   0 2px 12px rgba(59,111,232,0.07);
    --shadow-md:0 6px 28px rgba(59,111,232,0.12);
    --r:        12px;
    --r-lg:     18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
/* Reusing some specific dashboard styles but with new token values */
/* ══ Dashboard Specific Utilities ══════════════════════════ */
.dash-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); margin-bottom: 20px; }
.dash-card-hd { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.dash-card-title { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 800; color: var(--ink); }
.dash-tab-nav { display: flex; gap: 4px; background: var(--blue-lt); padding: 5px; border-radius: 14px; margin-bottom: 24px; overflow-x: auto; }
.dash-tab-btn { padding: 9px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; color: var(--ink3); cursor: pointer; border: none; background: transparent; transition: all 0.2s; white-space: nowrap; }
.dash-tab-btn.active { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.2); }

.adm-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 10px; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif; }
.adm-btn-outline { background: #fff; border: 1px solid var(--border); color: var(--ink2); }
.adm-btn-primary { background: var(--blue); color: #fff; }
.adm-btn-ghost { background: var(--blue-lt); color: var(--blue); }

.adm-table { width: 100%; border-collapse: collapse; }
.adm-table th { padding: 12px 16px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--ink4); text-align: left; border-bottom: 1px solid var(--border); }
.adm-table td { padding: 14px 16px; font-size: 13.5px; color: var(--ink2); border-bottom: 1px solid var(--border); }

.adm-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.ab-indigo { background: var(--blue-lt); color: var(--blue); }
.ab-green { background: rgba(18,183,106,0.1); color: #12B76A; }

.adm-search { display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 8px 12px; }
.adm-search input { border: none; background: transparent; outline: none; font-size: 13.5px; color: var(--ink); width: 100%; }

.perm-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.perm-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow); }
.perm-card-hd { padding: 14px 18px; background: #f8fafc; border-bottom: 1px solid var(--border); font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 800; color: var(--ink); }
.perm-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 18px; border-bottom: 1px solid #f1f5f9; }
.perm-toggle { width: 38px; height: 20px; border-radius: 100px; background: #e2e8f0; position: relative; border: none; cursor: pointer; transition: background 0.3s; }
.perm-toggle.on { background: #12B76A; }
.perm-toggle::after { content: ''; position: absolute; width: 14px; height: 14px; background: #fff; border-radius: 50%; left: 3px; top: 3px; transition: transform 0.3s; }
.perm-toggle.on::after { transform: translateX(18px); }

.log-row { padding: 12px 18px; border-bottom: 1px solid #f1f5f9; display: flex; gap: 12px; align-items: flex-start; }
.log-dot { width: 8px; height: 8px; border-radius: 50%; margin-top: 5px; flex-shrink: 0; }
.log-desc { font-size: 13px; color: var(--ink2); line-height: 1.5; }
.log-time { font-size: 11px; color: var(--ink4); font-family: monospace; }
</style>
hrink: 0;
}

.adm-admin-name { font-size: 12.5px; font-weight: 700; color: var(--ct); }
.adm-admin-role { font-size: 10.5px; color: var(--ct3); }

/* ══ MAIN CONTENT ═════════════════════════════════════════ */
.adm-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    min-height: 100vh;
}

.adm-topbar {
    padding: 16px 28px;
    border-bottom: 1px solid var(--cb);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--c1);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(12px);
}

.adm-topbar-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--ct);
    letter-spacing: -.02em;
}

.adm-topbar-sub {
    font-size: 12px;
    color: var(--ct3);
    margin-top: 1px;
}

.adm-topbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.adm-content { padding: 28px; display: flex; flex-direction: column; gap: 22px; }

/* ══ FLASH ════════════════════════════════════════════════ */
.dash-tile { background: var(--white); border: 1px solid var(--border); border-radius: var(--r); padding: 18px; display: flex; align-items: center; gap: 14px; box-shadow: var(--shadow); }
.dash-tile-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: var(--blue-lt); color: var(--blue); }
.dash-tile-val { font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 800; color: var(--ink); }
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table th { text-align: left; padding: 10px 16px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--ink4); border-bottom: 1px solid var(--border); }
.dash-table td { padding: 12px 16px; font-size: 13.5px; color: var(--ink2); border-bottom: 1px solid var(--border); }


/* ══ NOTICE BOX ═══════════════════════════════════════════ */
.adm-notice { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--r); font-size: 12.5px; font-weight: 600; }
.adm-notice svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; margin-top: 1px; }
.adm-notice-warn { background: var(--amber-lt); border: 1px solid rgba(245,158,11,0.25); color: #FCD34D; }
.adm-notice-info { background: var(--blue-lt);  border: 1px solid var(--blue-brd); color: #93C5FD; }

/* ══ RESPONSIVE ═══════════════════════════════════════════ */
@media (max-width: 1024px) { .adm-tiles { grid-template-columns: 1fr 1fr; } .perm-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px)  { .adm-sidebar { display: none; } .adm-grid2,.adm-grid3 { grid-template-columns: 1fr; } .adm-view-grid { grid-template-columns: 1fr; } }
</style>

{{-- ══ SIDEBAR ════════════════════════════════════════════ --}}
{{-- Unified Tab Navigation for Console --}}
<div class="dash-tab-nav">
    @foreach($tabs as $key => $tab)
        <button class="dash-tab-btn {{ $activeTab === $key ? 'active' : '' }}" wire:click="setTab('{{ $key }}')">
            {{ $tab['label'] }}
        </button>
    @endforeach
</div>

<div class="dash-content-area">

    {{-- Topbar --}}
    <div class="ep-hero" style="margin-bottom:20px;">
        <div class="ep-hero-cover" style="height:60px;"></div>
        <div class="ep-hero-body" style="padding:0 20px 15px; margin-top:-15px;">
            <div class="ep-hero-title-wrap">
                <div class="ep-hero-icon" style="width:48px;height:48px;border-radius:12px;">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <div class="ep-hero-title" style="font-size:18px;">Admin Console</div>
                    <div class="ep-hero-sub">System Management & Security Operations</div>
                </div>
            </div>
            @if($activeTab === 'users')
                <button class="ep-btn btn-primary" href="{{ route('admin.users') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Go to User Manager
                </button>
            @endif
        </div>
    </div>

    <div class="adm-content">

        {{-- Flash --}}
        @if(session()->has('success'))
            <div class="adm-flash adm-flash-ok">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="adm-flash adm-flash-err">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ▸ TAB: USERS ─────────────────────────────────── --}}
        @if($activeTab === 'users')

        <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
            <div class="dash-tile">
                <div class="dash-tile-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                <div><div style="font-size:10px;font-weight:800;text-transform:uppercase;color:var(--ink4);letter-spacing:.05em;">Total Users</div><div class="dash-tile-val">{{ $totalUsers }}</div></div>
            </div>
            <div class="dash-tile">
                <div class="dash-tile-icon" style="background:rgba(124,58,237,0.1);color:#7C3AED;"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <div><div style="font-size:10px;font-weight:800;text-transform:uppercase;color:var(--ink4);letter-spacing:.05em;">Admins</div><div class="dash-tile-val">{{ $adminCount }}</div></div>
            </div>
            <div class="dash-tile">
                <div class="dash-tile-icon" style="background:rgba(14,165,233,0.1);color:#0EA5E9;"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg></div>
                <div><div style="font-size:10px;font-weight:800;text-transform:uppercase;color:var(--ink4);letter-spacing:.05em;">HR Managers</div><div class="dash-tile-val">{{ $hrCount }}</div></div>
            </div>
            <div class="dash-tile">
                <div class="dash-tile-icon" style="background:rgba(16,185,129,0.1);color:#10B981;"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <div><div style="font-size:10px;font-weight:800;text-transform:uppercase;color:var(--ink4);letter-spacing:.05em;">Employees</div><div class="dash-tile-val">{{ $empCount }}</div></div>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-hd">
                <div>
                    <div class="dash-card-title">User Registry</div>
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <div class="ep-search" style="min-width:220px; background:#f8fafc;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input wire:model.live.debounce.300ms="search" placeholder="Search accounts...">
                    </div>
                </div>
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr>
                        <th>User</th><th>Email</th><th>Username</th><th>Phone</th><th>Role</th><th>Actions</th>
                    </tr></thead>
                    <tbody>
                    @forelse($users as $u)
                        @php
                            $init = strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1));
                            $full = trim(($u->first_name??'').' '.($u->last_name??''));
                            $r    = $u->role ?? 'employee';
                            $rCls = match($r) { 'admin'=>'ab-indigo','hr_manager'=>'ab-cyan', default=>'ab-green' };
                        @endphp
                        <tr>
                            <td>
                                <div class="adm-user-cell">
                                    <div class="adm-av">{{ $init }}</div>
                                    <div>
                                        <div class="adm-user-name">{{ $full }}</div>
                                        <div class="adm-user-meta"><span class="adm-code">{{ $u->code }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--ct2);">{{ $u->email }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--cyan);">@{{ $u->username }}</td>
                            <td style="font-size:12.5px;color:var(--ct3);">{{ $u->phone_number ?: '—' }}</td>
                            <td>
                                <select class="adm-role-sel" wire:change="assignRole('{{ $u->id }}', $event.target.value)">
                                    @foreach($roles as $val => $label)
                                        <option value="{{ $val }}" @selected($u->role === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div style="display:flex;gap:4px;">
                                    <button class="adm-btn adm-btn-ghost adm-btn-sm" wire:click="openView('{{ $u->id }}')" title="View">
                                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                    <button class="adm-btn adm-btn-outline adm-btn-sm" wire:click="openEdit('{{ $u->id }}')" title="Edit">
                                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="adm-btn adm-btn-amber adm-btn-sm" wire:click="viewCredentials('{{ $u->id }}')" title="Credentials">
                                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    </button>
                                    <button class="adm-btn adm-btn-purple adm-btn-sm" wire:click="openResetModal('{{ $u->id }}')" title="Reset Password">
                                        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                                    </button>
                                    <button class="adm-btn adm-btn-danger adm-btn-sm" wire:click="confirmDelete('{{ $u->id }}')" title="Delete">
                                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="adm-empty">
                                <div class="adm-empty-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                                <div class="adm-empty-ttl">No users found</div>
                                <div class="adm-empty-sub">{{ $search || $filterRole ? 'Adjust your filters.' : 'Create the first account.' }}</div>
                            </div>
                        </td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="adm-pager">
                    <div class="adm-pager-info">{{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</div>
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        {{-- ▸ TAB: ROLES ──────────────────────────────────── --}}
        @elseif($activeTab === 'roles')

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
            @foreach($roles as $rVal => $rLabel)
            @php
                $rIcon = match($rVal) { 'admin' => 'shield', 'hr_manager' => 'briefcase', default => 'user' };
                $rColor = match($rVal) { 'admin' => 'var(--indigo)', 'hr_manager' => 'var(--cyan)', default => 'var(--green)' };
                $rCount = \App\Models\User::where('role', $rVal)->count();
            @endphp
            <div class="adm-card">
                <div class="adm-card-hd" style="border-left:3px solid {{ $rColor }};">
                    <div>
                        <div class="adm-card-title" style="color:{{ $rColor }};">{{ $rLabel }}</div>
                        <div class="adm-card-sub">{{ $rCount }} user{{ $rCount !== 1 ? 's' : '' }} assigned</div>
                    </div>
                    <span class="adm-badge {{ match($rVal) { 'admin'=>'ab-indigo','hr_manager'=>'ab-cyan',default=>'ab-green' } }}">
                        {{ strtoupper($rVal) }}
                    </span>
                </div>
                <div style="padding:16px;display:flex;flex-direction:column;gap:8px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.10em;color:var(--ct3);margin-bottom:4px;">Capabilities</div>
                    @foreach(self::DEFAULT_PERMISSIONS[$rVal] ?? [] as $perm => $allowed)
                        @if($allowed)
                        <div style="display:flex;align-items:center;gap:8px;font-size:12.5px;color:var(--ct2);">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="{{ $rColor }}" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ collect(self::ALL_PERMISSIONS)->flatten()->get($perm, $perm) }}
                        </div>
                        @endif
                    @endforeach
                </div>
                <div style="padding:12px 16px;border-top:1px solid var(--cb);">
                    <button class="adm-btn adm-btn-outline adm-btn-sm" wire:click="setTab('permissions')" style="width:100%;justify-content:center;">
                        Edit Permissions →
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="adm-card">
            <div class="adm-card-hd">
                <div><div class="adm-card-title">Users by Role</div><div class="adm-card-sub">Quick overview of all assignments</div></div>
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>User</th><th>Email</th><th>Current Role</th><th>Assign Role</th></tr></thead>
                    <tbody>
                    @foreach(\App\Models\User::orderBy('role')->orderBy('first_name')->get() as $u)
                        @php $r = $u->role ?? 'employee'; $rCls = match($r) { 'admin'=>'ab-indigo','hr_manager'=>'ab-cyan', default=>'ab-green' }; @endphp
                        <tr>
                            <td>
                                <div class="adm-user-cell">
                                    <div class="adm-av">{{ strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)) }}</div>
                                    <div class="adm-user-name">{{ trim(($u->first_name??'').' '.($u->last_name??'')) }}</div>
                                </div>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:12px;">{{ $u->email }}</td>
                            <td><span class="adm-badge {{ $rCls }}">{{ $roles[$r] ?? $r }}</span></td>
                            <td>
                                <select class="adm-role-sel" wire:change="assignRole('{{ $u->id }}', $event.target.value)">
                                    @foreach($roles as $val => $label)
                                        <option value="{{ $val }}" @selected($u->role === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ▸ TAB: PERMISSIONS ────────────────────────────── --}}
        @elseif($activeTab === 'permissions')

        <div class="adm-notice adm-notice-info">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Toggle permissions per role then click Save. Changes take effect on the user's next request.
        </div>

        <div class="perm-grid">
            @foreach($roles as $rVal => $rLabel)
            @php $rColor = match($rVal) { 'admin' => 'var(--indigo)', 'hr_manager' => 'var(--cyan)', default => 'var(--green)' }; @endphp
            <div class="perm-card">
                <div class="perm-card-hd">
                    <div class="perm-card-title" style="color:{{ $rColor }};">{{ $rLabel }}</div>
                    <button class="adm-btn adm-btn-outline adm-btn-sm" wire:click="resetPermissions('{{ $rVal }}')">Reset</button>
                </div>
                @foreach($allPermissions as $category => $perms)
                <div class="perm-category">
                    <div class="perm-category-name">{{ ucfirst($category) }}</div>
                    @foreach($perms as $permKey => $permLabel)
                    <div class="perm-row">
                        <div class="perm-label">{{ $permLabel }}</div>
                        <button
                            class="perm-toggle {{ ($permissions[$rVal][$permKey] ?? false) ? 'on' : '' }}"
                            wire:click="togglePermission('{{ $rVal }}', '{{ $permKey }}')"
                            title="{{ ($permissions[$rVal][$permKey] ?? false) ? 'Enabled — click to disable' : 'Disabled — click to enable' }}"
                        ></button>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;">
            <button class="adm-btn adm-btn-outline" wire:click="resetPermissions('admin'); resetPermissions('hr_manager'); resetPermissions('employee')">Reset All</button>
            <button class="adm-btn adm-btn-primary" wire:click="savePermissions">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                Save Permissions
            </button>
        </div>

        {{-- ▸ TAB: ACTIVITY LOG ───────────────────────────── --}}
        @elseif($activeTab === 'activity')

        <div class="adm-card">
            <div class="adm-card-hd">
                <div><div class="adm-card-title">Activity Log</div><div class="adm-card-sub">Real-time system events</div></div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <div class="adm-search">
                        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input wire:model.live.debounce.300ms="auditSearch" placeholder="Search events…">
                    </div>
                    <input type="date" wire:model.live="auditDateFrom" style="background:var(--c4);border:1px solid var(--cb);border-radius:var(--r);padding:7px 11px;color:var(--ct);font-family:'Outfit',sans-serif;font-size:13px;outline:none;">
                    <input type="date" wire:model.live="auditDateTo" style="background:var(--c4);border:1px solid var(--cb);border-radius:var(--r);padding:7px 11px;color:var(--ct);font-family:'Outfit',sans-serif;font-size:13px;outline:none;">
                </div>
            </div>
            @if($activityLogs->isEmpty())
                <div class="adm-empty">
                    <div class="adm-empty-icon"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                    <div class="adm-empty-ttl">No activity logs found</div>
                    <div class="adm-empty-sub">Events will appear here as users interact with the system.</div>
                </div>
            @else
                @foreach($activityLogs as $log)
                @php
                    $ev    = $log->event ?? 'system';
                    $color = match(true) {
                        str_contains($ev,'create') => 'green',
                        str_contains($ev,'update') => 'blue',
                        str_contains($ev,'delete') => 'red',
                        str_contains($ev,'login')  => 'purple',
                        str_contains($ev,'logout') => 'amber',
                        default                    => 'gray',
                    };
                @endphp
                <div class="log-row">
                    <div class="log-dot log-dot-{{ $color }}"></div>
                    <div style="flex:1;">
                        <span class="log-event-badge adm-badge ab-{{ $color === 'gray' ? 'gray' : $color }}">{{ $ev }}</span>
                        <div class="log-desc">{{ $log->description ?? 'System event' }}</div>
                    </div>
                    <div class="log-time">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, H:i') }}</div>
                </div>
                @endforeach
                @if(method_exists($activityLogs,'hasPages') && $activityLogs->hasPages())
                    <div class="adm-pager">
                        <div class="adm-pager-info">{{ $activityLogs->firstItem() }}–{{ $activityLogs->lastItem() }} of {{ $activityLogs->total() }}</div>
                        {{ $activityLogs->links() }}
                    </div>
                @endif
            @endif
        </div>

        {{-- ▸ TAB: AUDIT TRAIL ────────────────────────────── --}}
        @elseif($activeTab === 'audit')

        <div class="adm-notice adm-notice-info">
            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            The audit trail records all sensitive actions including role changes, deletions, and permission updates.
        </div>

        <div class="adm-card">
            <div class="adm-card-hd">
                <div><div class="adm-card-title">Audit Trail</div><div class="adm-card-sub">Immutable record of all administrative actions</div></div>
                <div style="display:flex;gap:10px;">
                    <div class="adm-search">
                        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input wire:model.live.debounce.300ms="auditSearch" placeholder="Search audit records…">
                    </div>
                    <select class="adm-sel" wire:model.live="auditFilterType">
                        <option value="">All Events</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                        <option value="login">Login</option>
                        <option value="logout">Logout</option>
                    </select>
                </div>
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>Event</th><th>Description</th><th>User</th><th>IP Address</th><th>Timestamp</th></tr></thead>
                    <tbody>
                    @if($activityLogs->isEmpty())
                        <tr><td colspan="5">
                            <div class="adm-empty">
                                <div class="adm-empty-icon"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                                <div class="adm-empty-ttl">No audit records</div>
                                <div class="adm-empty-sub">Add the spatie/laravel-activitylog package to populate this trail.</div>
                            </div>
                        </td></tr>
                    @else
                        @foreach($activityLogs as $log)
                        @php
                            $ev = $log->event ?? 'system';
                            $eCls = match(true) { str_contains($ev,'create')=>'ab-green',str_contains($ev,'delete')=>'ab-red',str_contains($ev,'update')=>'ab-blue',str_contains($ev,'login')=>'ab-purple', default=>'ab-gray' };
                        @endphp
                        <tr>
                            <td><span class="adm-badge {{ $eCls }}">{{ strtoupper($ev) }}</span></td>
                            <td style="max-width:280px;white-space:normal;line-height:1.5;">{{ $log->description ?? '—' }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:12px;">{{ $log->causer_id ?? '—' }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--cyan);">{{ $log->properties['ip'] ?? '—' }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:11.5px;color:var(--ct3);">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ▸ TAB: SESSIONS ───────────────────────────────── --}}
        @elseif($activeTab === 'sessions')

        <div class="adm-tiles" style="grid-template-columns:1fr 1fr 1fr;">
            <div class="adm-tile at-blue">
                <div class="adm-tile-icon"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
                <div><div class="adm-tile-lbl">Active Sessions</div><div class="adm-tile-val">{{ $sessions->count() }}</div><div class="adm-tile-sub">right now</div></div>
            </div>
            <div class="adm-tile at-green">
                <div class="adm-tile-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <div><div class="adm-tile-lbl">Current Session</div><div class="adm-tile-val">You</div><div class="adm-tile-sub">protected</div></div>
            </div>
            <div class="adm-tile at-indigo">
                <div class="adm-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><div class="adm-tile-lbl">Timeout</div><div class="adm-tile-val">{{ $sessionTimeoutMinutes }}m</div><div class="adm-tile-sub">auto-expire</div></div>
            </div>
        </div>

        <div class="adm-card">
            <div class="adm-card-hd">
                <div><div class="adm-card-title">Active Sessions</div><div class="adm-card-sub">All currently authenticated sessions</div></div>
                <button class="adm-btn adm-btn-danger" wire:click="terminateAllSessions" wire:confirm="Terminate all other sessions?">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Kill All Others
                </button>
            </div>
            @if($sessions->isEmpty())
                <div class="adm-empty">
                    <div class="adm-empty-icon"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/></svg></div>
                    <div class="adm-empty-ttl">No sessions found</div>
                    <div class="adm-empty-sub">Sessions appear here when users are logged in via database driver.</div>
                </div>
            @else
                @foreach($sessions as $sess)
                <div class="sess-row">
                    <div class="sess-icon">
                        <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div style="flex:1;">
                        <div class="sess-ip">{{ $sess->ip_address ?? '—' }}</div>
                        <div class="sess-time">Last active: {{ $sess->last_activity_human ?? '—' }}</div>
                    </div>
                    @if($sess->is_current ?? false)
                        <span class="sess-current">Current</span>
                    @else
                        <button class="adm-btn adm-btn-danger adm-btn-sm" wire:click="terminateSession('{{ $sess->id }}')"
                                wire:confirm="Terminate this session?">
                            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Terminate
                        </button>
                    @endif
                </div>
                @endforeach
            @endif
        </div>

        {{-- ▸ TAB: PASSWORD RESET ─────────────────────────── --}}
        @elseif($activeTab === 'password')

        <div class="adm-grid2" style="align-items:start;">

            <div class="adm-card">
                <div class="adm-card-hd">
                    <div><div class="adm-card-title">Select User</div><div class="adm-card-sub">Search and pick an account to reset</div></div>
                </div>
                <div style="padding:14px 16px;border-bottom:1px solid var(--cb);">
                    <div class="adm-search">
                        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input wire:model.live.debounce.300ms="resetSearch" placeholder="Search by name or email…">
                    </div>
                </div>
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead><tr><th>User</th><th>Role</th><th>Action</th></tr></thead>
                        <tbody>
                        @forelse($resetUsers as $u)
                            @php $r = $u->role ?? 'employee'; $rCls = match($r) { 'admin'=>'ab-indigo','hr_manager'=>'ab-cyan', default=>'ab-green' }; @endphp
                            <tr>
                                <td>
                                    <div class="adm-user-cell">
                                        <div class="adm-av">{{ strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)) }}</div>
                                        <div>
                                            <div class="adm-user-name">{{ trim(($u->first_name??'').' '.($u->last_name??'')) }}</div>
                                            <div style="font-size:11px;color:var(--ct3);font-family:'JetBrains Mono',monospace;">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="adm-badge {{ $rCls }}">{{ $roles[$r] ?? $r }}</span></td>
                                <td>
                                    <button class="adm-btn adm-btn-purple adm-btn-sm" wire:click="openResetModal('{{ $u->id }}')">
                                        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                                        Reset
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3"><div class="adm-empty" style="padding:24px;">
                                <div class="adm-empty-sub">No users match your search.</div>
                            </div></td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($resetUsers->hasPages())
                    <div class="adm-pager">{{ $resetUsers->links() }}</div>
                @endif
            </div>

            <div style="display:flex;flex-direction:column;gap:14px;">
                <div class="adm-card">
                    <div class="adm-card-hd">
                        <div><div class="adm-card-title">How It Works</div></div>
                    </div>
                    <div style="padding:16px;display:flex;flex-direction:column;gap:10px;">
                        @foreach(['Select a user from the list','Click Reset and enter a new password or generate one','The new password is hashed and saved immediately','Share the plain password securely with the employee'] as $i => $step)
                        <div style="display:flex;align-items:flex-start;gap:10px;">
                            <div style="width:22px;height:22px;border-radius:50%;background:var(--indigo-lt);border:1px solid rgba(99,102,241,0.3);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#A5B4FC;flex-shrink:0;">{{ $i+1 }}</div>
                            <div style="font-size:13px;color:var(--ct2);padding-top:2px;">{{ $step }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="adm-notice adm-notice-warn">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Passwords are one-way hashed. The plain text is shown only once immediately after reset. Store it securely.
                </div>
            </div>

        </div>

        {{-- ▸ TAB: SECURITY SETTINGS ─────────────────────── --}}
        @elseif($activeTab === 'security')

        <div class="adm-grid2" style="align-items:start;">

            <div style="display:flex;flex-direction:column;gap:14px;">
                <div class="adm-card">
                    <div class="adm-card-hd"><div><div class="adm-card-title">Authentication</div><div class="adm-card-sub">Login and session controls</div></div></div>

                    <div class="sec-toggle-row">
                        <div>
                            <div class="sec-toggle-label">Two-Factor Authentication</div>
                            <div class="sec-toggle-desc">Require 2FA for all admin accounts</div>
                        </div>
                        <button class="sec-toggle {{ $twoFactorEnabled ? 'on' : '' }}" wire:click="$toggle('twoFactorEnabled')"></button>
                    </div>
                    <div class="sec-toggle-row">
                        <div>
                            <div class="sec-toggle-label">Session Timeout</div>
                            <div class="sec-toggle-desc">Auto-logout after inactivity</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <input type="number" class="sec-number-input" wire:model.defer="sessionTimeoutMinutes" min="5" max="1440">
                            <span style="font-size:12px;color:var(--ct3);">min</span>
                            <button class="sec-toggle {{ $sessionTimeoutEnabled ? 'on' : '' }}" wire:click="$toggle('sessionTimeoutEnabled')"></button>
                        </div>
                    </div>
                    <div class="sec-toggle-row">
                        <div>
                            <div class="sec-toggle-label">Login Audit</div>
                            <div class="sec-toggle-desc">Log all login attempts to audit trail</div>
                        </div>
                        <button class="sec-toggle {{ $loginAuditEnabled ? 'on' : '' }}" wire:click="$toggle('loginAuditEnabled')"></button>
                    </div>
                    <div class="sec-toggle-row">
                        <div>
                            <div class="sec-toggle-label">Max Login Attempts</div>
                            <div class="sec-toggle-desc">Lock account after failed attempts</div>
                        </div>
                        <input type="number" class="sec-number-input" wire:model.defer="maxLoginAttempts" min="3" max="20">
                    </div>
                </div>

                <div class="adm-card">
                    <div class="adm-card-hd"><div><div class="adm-card-title">IP Whitelist</div><div class="adm-card-sub">Restrict admin access by IP</div></div>
                        <button class="sec-toggle {{ $ipWhitelistEnabled ? 'on' : '' }}" wire:click="$toggle('ipWhitelistEnabled')"></button>
                    </div>
                    <div style="padding:16px;">
                        <div class="adm-field">
                            <label>Allowed IP Addresses</label>
                            <textarea wire:model.defer="ipWhitelist" placeholder="One IP per line&#10;192.168.1.1&#10;10.0.0.0/24" style="min-height:100px;{{ !$ipWhitelistEnabled ? 'opacity:.4;pointer-events:none;' : '' }}"></textarea>
                            <div class="adm-field-hint">CIDR notation supported. Leave empty to allow all IPs.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:14px;">
                <div class="adm-card">
                    <div class="adm-card-hd"><div><div class="adm-card-title">Password Policy</div><div class="adm-card-sub">Enforce strong passwords</div></div></div>

                    <div class="sec-toggle-row">
                        <div>
                            <div class="sec-toggle-label">Password Expiry</div>
                            <div class="sec-toggle-desc">Force password change periodically</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <input type="number" class="sec-number-input" wire:model.defer="passwordExpiryDays" min="30" max="365">
                            <span style="font-size:12px;color:var(--ct3);">days</span>
                            <button class="sec-toggle {{ $passwordExpiry ? 'on' : '' }}" wire:click="$toggle('passwordExpiry')"></button>
                        </div>
                    </div>
                    @foreach(['Minimum 8 characters','Uppercase + lowercase required','At least one number','At least one special character'] as $policy)
                    <div class="sec-toggle-row">
                        <div class="sec-toggle-label">{{ $policy }}</div>
                        <button class="sec-toggle on"></button>
                    </div>
                    @endforeach
                </div>

                <div class="adm-card">
                    <div class="adm-card-hd"><div><div class="adm-card-title">Security Overview</div></div></div>
                    <div style="padding:14px 18px;display:flex;flex-direction:column;gap:10px;">
                        @foreach([
                            ['2FA', $twoFactorEnabled, 'Two-factor authentication'],
                            ['Session', $sessionTimeoutEnabled, 'Session timeout active'],
                            ['Audit', $loginAuditEnabled, 'Login auditing enabled'],
                            ['IP', $ipWhitelistEnabled, 'IP whitelist enforced'],
                            ['PwExp', $passwordExpiry, 'Password expiry policy'],
                        ] as [$tag, $on, $label])
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="font-size:13px;color:var(--ct2);">{{ $label }}</div>
                            <span class="adm-badge {{ $on ? 'ab-green' : 'ab-red' }}">{{ $on ? 'ON' : 'OFF' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="adm-btn adm-btn-primary" wire:click="saveSecuritySettings" style="align-self:flex-end;">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    Save Security Settings
                </button>
            </div>

        </div>
        @endif

    </div>{{-- /adm-content --}}
</main>

{{-- ══════════════════════════════════════════════════════════
     MODALS
══════════════════════════════════════════════════════════ --}}

{{-- CREATE / EDIT USER --}}
@if($showModal)
<div class="adm-modal-bg" wire:click.self="closeModal">
    <div class="adm-modal adm-modal-lg">
        <div class="adm-modal-hd">
            <div class="adm-modal-hd-left">
                <div class="adm-modal-hd-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <div>
                    <div class="adm-modal-title">{{ $editingId ? 'Edit Account' : 'New Employee Account' }}</div>
                    <div class="adm-modal-sub">{{ $editingId ? 'Update account details' : 'Create system login credentials' }}</div>
                </div>
            </div>
            <button class="adm-modal-close" wire:click="closeModal"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="adm-modal-body">
            <div class="adm-grid2">
                <div class="adm-field">
                    <label>Account Code <span class="req">*</span></label>
                    <input type="text" wire:model="code" placeholder="USR-00001" style="text-transform:uppercase;">
                </div>
                <div class="adm-field">
                    <label>Role <span class="req">*</span></label>
                    <select wire:model="role">
                        @foreach($roles as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="adm-section-lbl">Personal Information</div>
            <div class="adm-grid3">
                <div class="adm-field">
                    <label>First Name <span class="req">*</span></label>
                    <input type="text" wire:model.live="firstName" placeholder="Jean">
                </div>
                <div class="adm-field">
                    <label>Middle Name</label>
                    <input type="text" wire:model="middleName" placeholder="Optional">
                </div>
                <div class="adm-field">
                    <label>Last Name <span class="req">*</span></label>
                    <input type="text" wire:model.live="lastName" placeholder="Uwimana">
                </div>
            </div>
            <div class="adm-section-lbl">Login Credentials</div>
            <div class="adm-grid2">
                <div class="adm-field">
                    <label>Username <span class="req">*</span></label>
                    <input type="text" wire:model="username" placeholder="jean.uwimana">
                    <div class="adm-field-hint">Auto-suggested from name</div>
                </div>
                <div class="adm-field">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" wire:model="email" placeholder="jean@company.rw">
                </div>
            </div>
            <div class="adm-grid2">
                <div class="adm-field">
                    <label>Password {{ $editingId ? '' : '*' }}</label>
                    <div class="adm-pw-wrap">
                        <input type="password" id="admPwInput" wire:model="password" placeholder="{{ $editingId ? 'Leave blank to keep current' : 'Min. 6 characters' }}">
                        <button type="button" class="adm-pw-eye" onclick="admTogglePw('admPwInput','admEyeIco')">
                            <svg viewBox="0 0 24 24" id="admEyeIco"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div class="adm-field">
                    <label>Phone Number</label>
                    <input type="text" wire:model="phoneNumber" placeholder="+250 7XX XXX XXX">
                </div>
            </div>
        </div>
        <div class="adm-modal-footer">
            <button class="adm-btn adm-btn-outline" wire:click="closeModal">Cancel</button>
            <button class="adm-btn adm-btn-primary" wire:click="saveUser" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                <span wire:loading.remove wire:target="saveUser">{{ $editingId ? 'Update Account' : 'Create Account' }}</span>
                <span wire:loading wire:target="saveUser">Saving…</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- VIEW USER --}}
@if($showView && $viewRecord)
<div class="adm-modal-bg" wire:click.self="closeView">
    <div class="adm-modal">
        <div class="adm-modal-hd">
            <div class="adm-modal-hd-left">
                <div class="adm-modal-hd-icon"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                <div>
                    <div class="adm-modal-title">{{ trim(($viewRecord->first_name??'').' '.($viewRecord->last_name??'')) }}</div>
                    <div class="adm-modal-sub">{{ $viewRecord->code }}</div>
                </div>
            </div>
            <button class="adm-modal-close" wire:click="closeView"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="adm-modal-body">
            @php
                $vInit  = strtoupper(substr($viewRecord->first_name??'',0,1).substr($viewRecord->last_name??'',0,1));
                $vR     = $viewRecord->role ?? 'employee';
                $vRCls  = match($vR) { 'admin'=>'ab-indigo','hr_manager'=>'ab-cyan', default=>'ab-green' };
            @endphp
            <div class="adm-av adm-av-lg">{{ $vInit }}</div>
            <div class="adm-view-grid">
                <div class="adm-view-row"><div class="adm-view-lbl">Code</div><div class="adm-view-val"><span class="adm-code">{{ $viewRecord->code }}</span></div></div>
                <div class="adm-view-row"><div class="adm-view-lbl">Role</div><div class="adm-view-val"><span class="adm-badge {{ $vRCls }}">{{ $roles[$vR] ?? $vR }}</span></div></div>
                <div class="adm-view-row full"><div class="adm-view-lbl">Full Name</div><div class="adm-view-val">{{ trim(($viewRecord->first_name??'').' '.($viewRecord->middle_name ? $viewRecord->middle_name.' ' : '').($viewRecord->last_name??'')) }}</div></div>
                <div class="adm-view-row"><div class="adm-view-lbl">Username</div><div class="adm-view-val" style="font-family:'JetBrains Mono',monospace;">@{{ $viewRecord->username }}</div></div>
                <div class="adm-view-row"><div class="adm-view-lbl">Email</div><div class="adm-view-val">{{ $viewRecord->email }}</div></div>
                <div class="adm-view-row"><div class="adm-view-lbl">Phone</div><div class="adm-view-val">{{ $viewRecord->phone_number ?: '—' }}</div></div>
                <div class="adm-view-row"><div class="adm-view-lbl">Created</div><div class="adm-view-val" style="font-size:12px;font-family:'JetBrains Mono',monospace;">{{ \Carbon\Carbon::parse($viewRecord->created_at)->format('M d, Y · H:i') }}</div></div>
                <div class="adm-view-row"><div class="adm-view-lbl">Updated</div><div class="adm-view-val" style="font-size:12px;font-family:'JetBrains Mono',monospace;">{{ \Carbon\Carbon::parse($viewRecord->updated_at)->format('M d, Y · H:i') }}</div></div>
            </div>
        </div>
        <div class="adm-modal-footer">
            <button class="adm-btn adm-btn-outline" wire:click="closeView">Close</button>
            <button class="adm-btn adm-btn-amber" wire:click="viewCredentials('{{ $viewRecord->id }}')">
                <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Credentials
            </button>
            <button class="adm-btn adm-btn-ghost" wire:click="openEditFromView('{{ $viewRecord->id }}')">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </button>
        </div>
    </div>
</div>
@endif

{{-- CREDENTIALS --}}
@if($showCredentials && $credRecord)
<div class="adm-modal-bg" wire:click.self="closeCredentials">
    <div class="adm-modal adm-modal-sm">
        <div class="adm-modal-hd">
            <div class="adm-modal-hd-left">
                <div class="adm-modal-hd-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div>
                <div>
                    <div class="adm-modal-title">Account Credentials</div>
                    <div class="adm-modal-sub">{{ trim(($credRecord->first_name??'').' '.($credRecord->last_name??'')) }}</div>
                </div>
            </div>
            <button class="adm-modal-close" wire:click="closeCredentials"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="adm-modal-body">
            <div class="adm-notice adm-notice-warn">
                <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Passwords are hashed and cannot be retrieved. Use "Reset Password" to generate a new one.
            </div>
            <div class="adm-cred-card">
                <div class="adm-cred-row">
                    <div class="adm-cred-lbl">Username</div>
                    <div class="adm-cred-actions">
                        <div class="adm-cred-val" id="crdUsr">{{ $credRecord->username }}</div>
                        <button class="pw-copy-btn" onclick="admCopy('crdUsr',this)">Copy</button>
                    </div>
                </div>
                <hr class="adm-cred-divider">
                <div class="adm-cred-row">
                    <div class="adm-cred-lbl">Email</div>
                    <div class="adm-cred-actions">
                        <div class="adm-cred-val" id="crdEml">{{ $credRecord->email }}</div>
                        <button class="pw-copy-btn" onclick="admCopy('crdEml',this)">Copy</button>
                    </div>
                </div>
                @if($plainPassword)
                <hr class="adm-cred-divider">
                <div class="adm-cred-row">
                    <div class="adm-cred-lbl">Generated Password</div>
                    <div class="adm-cred-actions">
                        <div class="adm-cred-val" id="crdPw" style="color:var(--cyan);font-size:18px;letter-spacing:.12em;">{{ $plainPassword }}</div>
                        <button class="pw-copy-btn" onclick="admCopy('crdPw',this)">Copy</button>
                    </div>
                </div>
                @else
                <hr class="adm-cred-divider">
                <div class="adm-cred-row">
                    <div class="adm-cred-lbl">Password</div>
                    <div class="adm-cred-val" style="letter-spacing:.25em;opacity:.35;">••••••••••••</div>
                </div>
                @endif
            </div>
        </div>
        <div class="adm-modal-footer">
            <button class="adm-btn adm-btn-outline" wire:click="closeCredentials">Close</button>
            <button class="adm-btn adm-btn-purple" wire:click="openResetModal('{{ $credRecord->id }}')" wire:click="closeCredentials">
                <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                Reset Password
            </button>
        </div>
    </div>
</div>
@endif

{{-- PASSWORD RESET MODAL --}}
@if($showResetModal && $resetUser)
<div class="adm-modal-bg" wire:click.self="closeResetModal">
    <div class="adm-modal adm-modal-sm">
        <div class="adm-modal-hd">
            <div class="adm-modal-hd-left">
                <div class="adm-modal-hd-icon"><svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg></div>
                <div>
                    <div class="adm-modal-title">Reset Password</div>
                    <div class="adm-modal-sub">{{ trim(($resetUser->first_name??'').' '.($resetUser->last_name??'')) }}</div>
                </div>
            </div>
            <button class="adm-modal-close" wire:click="closeResetModal"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="adm-modal-body">
            <div class="adm-field">
                <label>New Password <span class="req">*</span></label>
                <div class="adm-pw-wrap">
                    <input type="password" id="rstPwInput" wire:model="newPassword" placeholder="Enter or generate below…">
                    <button type="button" class="adm-pw-eye" onclick="admTogglePw('rstPwInput','rstEyeIco')">
                        <svg viewBox="0 0 24 24" id="rstEyeIco"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <button class="adm-btn adm-btn-cyan" wire:click="generatePassword" style="width:100%;justify-content:center;">
                <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                Auto-Generate Strong Password
            </button>
            @if($resetGenerated)
            <div class="pw-card">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.10em;color:var(--cyan);margin-bottom:4px;">Generated Password</div>
                <div class="pw-generated" id="genPw">{{ $resetGenerated }}</div>
                <div style="display:flex;justify-content:center;">
                    <button class="pw-copy-btn" onclick="admCopy('genPw',this)">Copy to Clipboard</button>
                </div>
                <div style="font-size:11.5px;color:var(--ct3);text-align:center;margin-top:10px;">Share this password securely with the employee. It will not be shown again.</div>
            </div>
            @endif
        </div>
        <div class="adm-modal-footer">
            <button class="adm-btn adm-btn-outline" wire:click="closeResetModal">Cancel</button>
            <button class="adm-btn adm-btn-primary" wire:click="doResetPassword" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span wire:loading.remove wire:target="doResetPassword">Apply Reset</span>
                <span wire:loading wire:target="doResetPassword">Resetting…</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- DELETE CONFIRM --}}
@if($showDelete)
<div class="adm-modal-bg" wire:click.self="cancelDelete">
    <div class="adm-modal adm-modal-sm">
        <div class="adm-del-body">
            <div class="adm-del-icon"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></div>
            <div class="adm-del-ttl">Delete Account?</div>
            <div class="adm-del-sub">This permanently removes the user's account and all access. This cannot be undone.</div>
        </div>
        <div class="adm-modal-footer" style="justify-content:center;gap:12px;">
            <button class="adm-btn adm-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="adm-btn adm-btn-danger" wire:click="deleteRecord" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                <span wire:loading.remove wire:target="deleteRecord">Yes, Delete</span>
                <span wire:loading wire:target="deleteRecord">Deleting…</span>
            </button>
        </div>
    </div>
</div>
@endif

<script>
function admTogglePw(inputId, iconId) {
    const inp = document.getElementById(inputId);
    const ico = document.getElementById(iconId);
    if (!inp) return;
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        inp.type = 'password';
        ico.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
function admCopy(elId, btn) {
    const el = document.getElementById(elId);
    if (!el) return;
    navigator.clipboard.writeText(el.textContent.trim()).then(() => {
        const orig = btn.textContent;
        btn.textContent = '✓ Copied';
        setTimeout(() => btn.textContent = orig, 1800);
    });
}
</script>

</div>{{-- /adm-root --}}
