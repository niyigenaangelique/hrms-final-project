<x-admin-content-styles />
<div class="ac-root">
    <div class="ac-header">
        <div><div class="ac-header-title">Employee Accounts</div><div class="ac-header-sub">All users with employee role</div></div>
        <a href="{{ route('admin.users') }}" class="ac-btn ac-btn-primary" wire:navigate>
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create Account
        </a>
    </div>
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">Employees</div><div class="ac-card-sub">{{ $employees->total() }} accounts</div></div>
            <div class="ac-search" style="min-width:240px;">
                <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input wire:model.live.debounce.300ms="search" placeholder="Search employees…">
            </div>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead><tr><th>Employee</th><th>Email</th><th>Username</th><th>Phone</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($employees as $u)
                <tr>
                    <td>
                        <div class="ac-user-cell">
                            <div class="ac-av">{{ strtoupper(substr($u->first_name??'',0,1).substr($u->last_name??'',0,1)) }}</div>
                            <div>
                                <div class="ac-user-name">{{ trim(($u->first_name??'').' '.($u->last_name??'')) }}</div>
                                <div class="ac-user-meta">{{ $u->code }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12.5px;">{{ $u->email }}</td>
                    <td style="font-family:'DM Mono',monospace;font-size:12px;color:var(--teal);">@{{ $u->username }}</td>
                    <td style="font-size:12.5px;color:var(--ink4);">{{ $u->phone_number ?: '—' }}</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <a href="{{ route('admin.users') }}" class="ac-btn ac-btn-ghost ac-btn-sm" wire:navigate>Edit</a>
                            <button class="ac-btn ac-btn-purple ac-btn-sm" wire:click="$dispatch('open-reset','{{ $u->id }}')">Reset PW</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="ac-empty" style="padding:28px;"><div class="ac-empty-sub">No employees found.</div></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
        <div class="ac-pager">
            <div class="ac-pager-info">{{ $employees->firstItem() }}–{{ $employees->lastItem() }} of {{ $employees->total() }}</div>
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>
