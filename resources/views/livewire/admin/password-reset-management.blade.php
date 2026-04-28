<div class="ac-root">
    <x-admin-content-styles />

    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Password Resets</div>
            <div class="ac-hero-sub">Reset any user's password and share new credentials safely</div>
        </div>
        <div style="background:rgba(255,255,255,0.1); padding:10px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.2); display:flex; gap:12px; align-items:center;">
             <svg viewBox="0 0 24 24" style="width:20px; height:20px; stroke:#fff; fill:none; stroke-width:2;"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
             <span style="font-size:12px; color:#fff; font-weight:600;">Plain-text passwords shown only once.</span>
        </div>
    </div>

    {{-- ── CONTENT ── --}}
    <div class="ac-card">
        <div class="ac-card-hd">
            <div>
                <div class="ac-card-title">System Users</div>
                <div class="ac-card-sub">{{ $users->total() }} accounts mapped</div>
            </div>
            <div class="ac-field" style="width:280px; margin:0;">
                <input wire:model.live.debounce.300ms="search" placeholder="Search by name or email…" style="padding:10px 14px;">
            </div>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead><tr><th style="padding-left:24px;">Identity</th><th>Email Address</th><th>Access Role</th><th style="text-align:right; padding-right:24px;">Actions</th></tr></thead>
                <tbody>
                @forelse($users as $u)
                @php $r=$u->role??'employee'; $rc=match($r){'admin'=>'ab-indigo','hr_manager'=>'ab-teal',default=>'ab-green'}; @endphp
                <tr>
                    <td style="padding-left:24px;">
                        <div class="ac-user-cell">
                            <div class="ac-av">{{ strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)) }}</div>
                            <div>
                                <div class="ac-user-name">{{ $u->first_name }} {{ $u->last_name }}</div>
                                <div class="ac-user-meta">@ {{ $u->username }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:600; color:var(--ink2);">{{ $u->email }}</td>
                    <td><span class="ac-badge {{ $rc }}">{{ ['admin'=>'Admin','hr_manager'=>'HR Manager','employee'=>'Employee'][$r]??$r }}</span></td>
                    <td style="text-align:right; padding-right:24px;">
                        <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="openReset('{{ $u->id }}')">
                            <svg viewBox="0 0 24 24" style="width:14px; height:14px; stroke:#fff;"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 1 2.13-9.36L1 10"/></svg>
                            Reset Password
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:60px; color:var(--ink4);">No users found matching your criteria.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div style="padding:16px 24px; border-top:1px solid var(--border);">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- Reset Modal --}}
    @if($showModal && $resetUser)
    <div class="ac-modal-bg" wire:click.self="closeModal">
        <div class="ac-modal" style="max-width:460px;">
            <div class="ac-modal-hd">
                <div>
                    <div class="ac-modal-ttl">Initialize Reset</div>
                    <div class="ac-modal-sub">{{ $resetUser->first_name }} {{ $resetUser->last_name }}</div>
                </div>
                <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="closeModal"><svg viewBox="0 0 24 24" style="width:20px; height:20px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="ac-modal-body" style="display:flex; flex-direction:column; gap:20px;">
                <div class="ac-field">
                    <label>New Password</label>
                    <input type="text" wire:model="newPassword" placeholder="Custom password or generate…">
                </div>
                <button class="ac-btn ac-btn-ghost" style="width:100%; border-style:dashed;" wire:click="generate">
                    <svg viewBox="0 0 24 24" style="width:16px; height:16px; stroke:var(--blue);"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                    Generate Strong Password
                </button>
                @if($generatedPw)
                <div style="background:var(--bg2); padding:16px; border-radius:12px; border:1.5px solid var(--border); text-align:center;">
                    <div id="genPwDisplay" style="font-family:'Sora',sans-serif; font-size:24px; font-weight:800; color:var(--blue); letter-spacing:1px; margin-bottom:8px;">{{ $generatedPw }}</div>
                    <div style="font-size:11px; color:var(--ink4); font-weight:600;">Copy this now. It won't be shown again.</div>
                </div>
                @endif
            </div>
            <div class="ac-modal-ft">
                <button class="ac-btn ac-btn-ghost" wire:click="closeModal">Cancel</button>
                <button class="ac-btn ac-btn-primary" wire:click="doReset" wire:loading.attr="disabled">
                    <span wire:loading.remove>Update Credentials</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

</div>
