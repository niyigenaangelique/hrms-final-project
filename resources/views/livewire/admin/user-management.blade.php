<div class="ac-root">
    <x-admin-content-styles />

    {{-- Flash --}}
    @if(session()->has('success'))
        <div class="ac-flash ac-flash-ok">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" /><polyline points="22 4 12 14.01 9 11.01" /></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="ac-flash ac-flash-err">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><line x1="15" y1="9" x2="9" y2="15" /><line x1="9" y1="9" x2="15" y2="15" /></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">User Management</div>
            <div class="ac-hero-sub">Control employee portal access and manage system credentials</div>
        </div>
        <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="openCreate">
            <svg viewBox="0 0 24 24" style="stroke:#fff;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Account
        </button>
    </div>

    {{-- ── TILES ── --}}
    <div class="ac-tiles">
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--blue);"></div>
            <div class="ac-tile-icon" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
            <div><div class="ac-tile-lbl">Total Entities</div><div class="ac-tile-val">{{ $totalCount }}</div><div class="ac-tile-sub">Users & Employees</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--indigo);"></div>
            <div class="ac-tile-icon" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <div><div class="ac-tile-lbl">Admins</div><div class="ac-tile-val">{{ $adminCount }}</div><div class="ac-tile-sub">System-wide access</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--amber);"></div>
            <div class="ac-tile-icon" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><rect x="2" y="7" width="20" height="14" rx="2" /><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16" /></svg></div>
            <div><div class="ac-tile-lbl">HR Managers</div><div class="ac-tile-val">{{ $hrCount }}</div><div class="ac-tile-sub">Operational access</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--teal);"></div>
            <div class="ac-tile-icon" style="background:var(--teal-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--teal);"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" /><circle cx="12" cy="7" r="4" /></svg></div>
            <div><div class="ac-tile-lbl">Employees</div><div class="ac-tile-val">{{ $empCount }}</div><div class="ac-tile-sub">Self-service access</div></div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="ac-card" style="padding:16px 24px; display:flex; gap:16px; align-items:center;">
        <div class="ac-field" style="flex:1; margin:0;">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email or code..." style="padding:10px 14px;">
        </div>
        <div class="ac-field" style="width:200px; margin:0;">
            <select wire:model.live="filterType" style="padding:10px 14px;">
                <option value="all">All Records</option>
                <option value="employees">Unlinked Employees</option>
                <option value="users">System Admins Only</option>
            </select>
        </div>
        <div class="ac-field" style="width:200px; margin:0;">
            <select wire:model.live="filterRole" style="padding:10px 14px;">
                <option value="">All Access Roles</option>
                @foreach($roles as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ── TABLE ── --}}
    <div class="ac-card">
        <table class="ac-table">
            <thead>
                <tr>
                    <th style="padding-left:24px;">Identity</th>
                    <th>Contacts</th>
                    <th>System Credentials</th>
                    <th>Access Role</th>
                    <th style="text-align:right; padding-right:24px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $row)
                    @php
                        $isUser = $row instanceof \App\Models\User;
                        $userObj = $isUser ? $row : $row->user;
                        $hasAccount = (bool) $userObj;
                        $initials = strtoupper(substr($row->first_name,0,1).substr($row->last_name,0,1));
                    @endphp
                    <tr>
                        <td style="padding-left:24px;">
                            <div class="ac-user-cell">
                                <div class="ac-av">{{ $initials }}</div>
                                <div>
                                    <div class="ac-user-name">{{ $row->first_name }} {{ $row->last_name }}</div>
                                    <div class="ac-user-meta">ID: {{ $row->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:700; color:var(--ink2);">{{ $row->email }}</div>
                            <div class="ac-user-meta">{{ $row->phone_number ?: 'No phone' }}</div>
                        </td>
                        <td>
                            @if($hasAccount)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-family:'Sora',sans-serif; font-size:12px; font-weight:700; color:var(--blue);">@ {{ $userObj->username }}</span>
                                    <span class="ac-badge {{ $userObj->is_active ? 'ab-green' : 'ab-red' }}" style="font-size:9px; padding:2px 6px;">{{ $userObj->is_active ? 'ACTIVE' : 'INACTIVE' }}</span>
                                </div>
                            @else
                                <span class="ac-badge ab-amber">NO ACCOUNT</span>
                            @endif
                        </td>
                        <td>
                            @if($hasAccount)
                                <select class="ac-input-sm" style="padding:4px 8px; border-radius:6px; font-weight:700;" wire:change="assignRole('{{ $userObj->id }}', $event.target.value)">
                                    @foreach($roles as $key => $label)
                                        <option value="{{ $key }}" @selected($userObj->role === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="ac-user-meta">Unlinked</span>
                            @endif
                        </td>
                        <td style="text-align:right; padding-right:24px;">
                            <div style="display:flex; gap:8px; justify-content:flex-end;">
                                @if($hasAccount)
                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="openEdit('{{ $userObj->id }}')" title="Edit"><svg viewBox="0 0 24 24" style="width:14px; height:14px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="toggleStatus('{{ $userObj->id }}')" title="Toggle Status"><svg viewBox="0 0 24 24" style="width:14px; height:14px; stroke:{{ $userObj->is_active ? 'var(--amber)' : 'var(--green)' }};"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg></button>
                                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="resetPassword('{{ $userObj->id }}')" title="Reset Password"><svg viewBox="0 0 24 24" style="width:14px; height:14px; stroke:var(--blue);"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg></button>
                                @else
                                    <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="openCreateCredentials('{{ $row->id }}')">Link Account</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($records->hasPages())
            <div style="padding:16px 24px; border-top:1px solid var(--border);">
                {{ $records->links() }}
            </div>
        @endif
    </div>

    {{-- ── MODAL ── --}}
    @if($showModal)
        <div class="ac-modal-bg" wire:click.self="closeModal">
            <div class="ac-modal" style="max-width:500px;">
                <div class="ac-modal-hd">
                    <div>
                        <div class="ac-modal-ttl">{{ $editingId ? 'Edit Credentials' : 'Link System Access' }}</div>
                        <div class="ac-modal-sub">Credentials grant access to the employee portal</div>
                    </div>
                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="closeModal"><svg viewBox="0 0 24 24" style="width:20px; height:20px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
                </div>
                <div class="ac-modal-body" style="display:flex; flex-direction:column; gap:16px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="ac-field"><label>Username</label><input type="text" wire:model="username">@error('username')<span class="ac-err">{{ $message }}</span>@enderror</div>
                        <div class="ac-field"><label>Access Role</label><select wire:model="role">@foreach($roles as $k=>$v)<option value="{{$k}}">{{$v}}</option>@endforeach</select></div>
                    </div>
                    <div class="ac-field"><label>Email Address</label><input type="email" wire:model="email">@error('email')<span class="ac-err">{{ $message }}</span>@enderror</div>
                    @if(!$editingId)
                        <div class="ac-field"><label>Initial Password</label><input type="password" wire:model="password">@error('password')<span class="ac-err">{{ $message }}</span>@enderror</div>
                    @endif
                </div>
                <div class="ac-modal-ft">
                    <button class="ac-btn ac-btn-ghost" wire:click="closeModal">Cancel</button>
                    <button class="ac-btn ac-btn-primary" wire:click="save">Save Account</button>
                </div>
            </div>
        </div>
    @endif

</div>
</div>

