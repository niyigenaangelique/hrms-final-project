<div class="ac-root">
    <x-admin-content-styles />
    
    <style>
        .ac-matrix-wrap {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--sh-sm);
        }
        .ac-matrix-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ac-matrix-table th, .ac-matrix-table td {
            border: 1px solid var(--border);
            padding: 12px 16px;
            text-align: center;
            font-size: 13px;
        }
        .ac-matrix-table thead th {
            background: var(--bg2);
            color: var(--ink);
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .ac-matrix-table td:first-child {
            text-align: left;
            font-weight: 700;
            color: var(--ink);
            background: var(--white);
            position: sticky;
            left: 0;
            z-index: 9;
            width: 300px;
            min-width: 300px;
        }
        .ac-matrix-toggle {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            color: var(--ink4);
            transition: all 0.2s;
        }
        .ac-matrix-toggle.on {
            color: var(--blue);
            font-weight: 900;
            background: var(--blue-lt);
        }
        .ac-matrix-toggle:hover {
            background: var(--bg2);
        }
        .ac-cat-header {
            background: var(--bg2);
            font-weight: 800;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--ink4);
            text-align: left !important;
        }
    </style>

    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Access Control Matrix</div>
            <div class="ac-hero-sub">Configure granular capabilities across every system role</div>
        </div>
        <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="savePermissions" wire:loading.attr="disabled">
            <svg wire:loading.remove viewBox="0 0 24 24" style="stroke:#fff;"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
            <span wire:loading.remove style="color:#fff;">Save Changes</span>
            <span wire:loading style="color:#fff;">Saving...</span>
        </button>
    </div>

    <div class="ac-matrix-wrap">
        <div style="overflow-x:auto; max-height:70vh;">
            <table class="ac-matrix-table">
                <thead>
                    <tr>
                        <th style="text-align:left; left:0; z-index:11;">Permissions</th>
                        @foreach($roles as $rVal => $rLabel)
                            <th>{{ $rLabel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($allPermissions as $category => $perms)
                        <tr>
                            <td colspan="{{ count($roles) + 1 }}" class="ac-cat-header">{{ strtoupper($category) }} MODULE</td>
                        </tr>
                        @foreach($perms as $permKey => $permLabel)
                            <tr wire:key="row-{{ $category }}-{{ $permKey }}">
                                <td>{{ $permLabel }}</td>
                                @foreach($roles as $rVal => $rLabel)
                                    <td wire:key="cell-{{ $rVal }}-{{ $permKey }}">
                                        <button 
                                            type="button"
                                            class="ac-matrix-toggle {{ ($permissions[$rVal][$permKey] ?? false) ? 'on' : '' }}"
                                            wire:click="togglePermission('{{ $rVal }}','{{ $permKey }}')"
                                        >
                                            @if($permissions[$rVal][$permKey] ?? false)
                                                <svg viewBox="0 0 24 24" style="width:16px; height:16px; stroke:currentColor; fill:none; stroke-width:3.5;"><polyline points="20 6 9 17 4 12"/></svg>
                                            @else
                                                <span style="opacity:0.2;">-</span>
                                            @endif
                                        </button>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
