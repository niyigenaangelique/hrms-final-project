<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Banks Management</div>
            <div class="ac-hero-sub">Financial institutions and disbursement configurations</div>
        </div>
        <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="openModal">
            <svg viewBox="0 0 24 24" style="stroke:#fff;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Bank
        </button>
    </div>

    {{-- ── STATS ── --}}
    <div class="ac-tiles">
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--blue);"></div>
            <div class="ac-tile-icon" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg></div>
            <div><div class="ac-tile-lbl">Registered Banks</div><div class="ac-tile-val">12</div><div class="ac-tile-sub">Verified Institutions</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--teal);"></div>
            <div class="ac-tile-icon" style="background:var(--teal-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--teal);"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
            <div><div class="ac-tile-lbl">Active Accounts</div><div class="ac-tile-val">156</div><div class="ac-tile-sub">Employee Linked</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--amber);"></div>
            <div class="ac-tile-icon" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <div><div class="ac-tile-lbl">Pending Sync</div><div class="ac-tile-val">0</div><div class="ac-tile-sub">All data up-to-date</div></div>
        </div>
    </div>

    {{-- ── MAIN TABLE ── --}}
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">Bank Institutions</div><div class="ac-card-sub">Active partners for payroll processing</div></div>
            <div style="display:flex; gap:10px;">
                <button class="ac-btn ac-btn-ghost ac-btn-sm">Export List</button>
                <button class="ac-btn ac-btn-primary ac-btn-sm">Sync Now</button>
            </div>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead>
                    <tr>
                        <th style="padding-left:24px;">Institution</th>
                        <th>Swift / Code</th>
                        <th>Accounts</th>
                        <th>Status</th>
                        <th style="text-align:right; padding-right:24px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $banks = [
                            ['name'=>'Bank of Kigali','code'=>'BK','accounts'=>45,'status'=>'Active','color'=>'var(--blue)'],
                            ['name'=>'BCR','code'=>'BCR','accounts'=>32,'status'=>'Active','color'=>'var(--teal)'],
                            ['name'=>'Cogebanque','code'=>'COGEB','accounts'=>28,'status'=>'Active','color'=>'var(--amber)'],
                            ['name'=>'Guaranty Trust Bank','code'=>'GTB','accounts'=>21,'status'=>'Active','color'=>'var(--indigo)'],
                            ['name'=>'KCB Bank Rwanda','code'=>'KCB','accounts'=>18,'status'=>'Inactive','color'=>'var(--red)'],
                        ];
                    @endphp
                    @foreach($banks as $b)
                        <tr>
                            <td style="padding-left:24px;">
                                <div class="ac-user-cell">
                                    <div class="ac-av" style="background:{{ $b['color'] }}15; color:{{ $b['color'] }};">{{ substr($b['name'],0,1) }}</div>
                                    <div>
                                        <div class="ac-user-name">{{ $b['name'] }}</div>
                                        <div class="ac-user-meta">Official Partner</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-family:'Sora',sans-serif; font-weight:700; color:var(--ink3);">{{ $b['code'] }}</td>
                            <td style="font-weight:800; color:var(--blue);">{{ $b['accounts'] }} <span style="font-size:10px; color:var(--ink4); font-weight:500;">Linked</span></td>
                            <td><span class="ac-badge {{ $b['status'] === 'Active' ? 'ab-green' : 'ab-red' }}">{{ strtoupper($b['status']) }}</span></td>
                            <td style="text-align:right; padding-right:24px;">
                                <button class="ac-btn ac-btn-ghost ac-btn-sm">Configure</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

