<x-admin-content-styles />
<div class="ac-root">
 
    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif
 
    <div class="ac-header">
        <div><div class="ac-header-title">Permissions Matrix</div><div class="ac-header-sub">Toggle what each role can do across the system</div></div>
        <div style="display:flex;gap:10px;">
            <button class="ac-btn ac-btn-outline" wire:click="resetPermissions('admin'); resetPermissions('hr_manager'); resetPermissions('employee')">Reset All</button>
            <button class="ac-btn ac-btn-primary" wire:click="savePermissions">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                Save Permissions
            </button>
        </div>
    </div>
 
    <div class="ac-notice ac-notice-info">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Toggle each permission per role then save. Admins always have full access regardless of these settings.
    </div>
 
    <div class="ac-perm-grid">
        @foreach($roles as $rVal => $rLabel)
        @php $rColor = match($rVal) { 'admin'=>'var(--indigo)', 'hr_manager'=>'var(--teal)', default=>'var(--green)' }; @endphp
        <div class="ac-perm-card">
            <div class="ac-perm-card-hd" style="border-left:3px solid {{ $rColor }};">
                <div class="ac-perm-card-title" style="color:{{ $rColor }};">{{ $rLabel }}</div>
                <button class="ac-btn ac-btn-outline ac-btn-sm" wire:click="resetPermissions('{{ $rVal }}')">Reset</button>
            </div>
            @foreach($allPermissions as $category => $perms)
            <div class="ac-perm-category">
                <div class="ac-perm-cat-name">{{ ucfirst($category) }}</div>
                @foreach($perms as $permKey => $permLabel)
                <div class="ac-perm-row">
                    <div class="ac-perm-label">{{ $permLabel }}</div>
                    <button class="ac-perm-toggle {{ ($permissions[$rVal][$permKey] ?? false) ? 'on' : '' }}"
                        wire:click="togglePermission('{{ $rVal }}','{{ $permKey }}')"
                        title="{{ ($permissions[$rVal][$permKey] ?? false) ? 'Enabled' : 'Disabled' }}">
                    </button>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
 
</div>
 
