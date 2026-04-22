<x-admin-content-styles />
<div class="ac-root">
 
    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif
 
    <div class="ac-header">
        <div><div class="ac-header-title">Password Resets</div><div class="ac-header-sub">Reset any user's password and share new credentials</div></div>
    </div>
 
    <div class="ac-notice ac-notice-warn">
        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Passwords are one-way hashed. The plain-text password is shown only once immediately after reset. Share it securely with the employee.
    </div>
 
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">All Users</div><div class="ac-card-sub">{{ $users->total() }} accounts</div></div>
            <div class="ac-search" style="min-width:240px;">
                <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input wire:model.live.debounce.300ms="search" placeholder="Search by name or email…">
            </div>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
                <tbody>
                @forelse($users as $u)
                @php $r=$u->role??'employee'; $rc=match($r){'admin'=>'ab-indigo','hr_manager'=>'ab-teal',default=>'ab-green'}; @endphp
                <tr>
                    <td>
                        <div class="ac-user-cell">
                            <div class="ac-av">{{ strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)) }}</div>
                            <div>
                                <div class="ac-user-name">{{ trim(($u->first_name??'').' '.($u->last_name??'')) }}</div>
                                <div class="ac-user-meta" style="font-family:'DM Mono',monospace;">{{ $u->username }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12.5px;color:var(--ink3);">{{ $u->email }}</td>
                    <td><span class="ac-badge {{ $rc }}">{{ ['admin'=>'Admin','hr_manager'=>'HR Mgr','employee'=>'Employee'][$r]??$r }}</span></td>
                    <td>
                        <button class="ac-btn ac-btn-purple ac-btn-sm" wire:click="openReset('{{ $u->id }}')">
                            <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                            Reset Password
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="ac-empty" style="padding:24px;"><div class="ac-empty-sub">No users match your search.</div></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="ac-pager">
            <div class="ac-pager-info">{{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</div>
            {{ $users->links() }}
        </div>
        @endif
    </div>
 
    {{-- Reset Modal --}}
    @if($showModal && $resetUser)
    <div class="ac-modal-bg" wire:click.self="closeModal">
        <div class="ac-modal">
            <div class="ac-modal-hd">
                <div class="ac-modal-hd-left">
                    <div class="ac-modal-hd-icon"><svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg></div>
                    <div>
                        <div class="ac-modal-title">Reset Password</div>
                        <div class="ac-modal-sub">{{ trim(($resetUser->first_name??'').' '.($resetUser->last_name??'')) }} · {{ $resetUser->email }}</div>
                    </div>
                </div>
                <button class="ac-modal-close" wire:click="closeModal"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="ac-modal-body">
                <div class="ac-field">
                    <label>New Password <span class="req">*</span></label>
                    <input type="text" wire:model="newPassword" placeholder="Type or generate below…">
                </div>
                <button class="ac-btn ac-btn-teal" wire:click="generate" style="width:100%;justify-content:center;">
                    <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                    Auto-Generate Strong Password
                </button>
                @if($generatedPw)
                <div>
                    <div class="ac-pw-display" id="genPwDisplay">{{ $generatedPw }}</div>
                    <div style="text-align:center;margin-top:6px;">
                        <button class="ac-pw-copy" onclick="acCopy('genPwDisplay',this)">Copy to Clipboard</button>
                    </div>
                    <div style="font-size:12px;color:var(--ink4);text-align:center;margin-top:8px;">This password will not be shown again after you close this modal.</div>
                </div>
                @endif
            </div>
            <div class="ac-modal-footer">
                <button class="ac-btn ac-btn-outline" wire:click="closeModal">Cancel</button>
                <button class="ac-btn ac-btn-primary" wire:click="doReset" wire:loading.attr="disabled">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span wire:loading.remove wire:target="doReset">Apply Reset</span>
                    <span wire:loading wire:target="doReset">Resetting…</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
