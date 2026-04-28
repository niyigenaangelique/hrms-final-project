<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Imports & Data Bridge</div>
            <div class="ac-hero-sub">Mass record updates and external data synchronization</div>
        </div>
        <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);">
            <svg viewBox="0 0 24 24" style="stroke:#fff;"><polyline points="21 15 16 10 11 15"/><line x1="16" y1="10" x2="16" y2="22"/><path d="M18 13V9a6 6 0 0 0-12 0v4a5 5 0 0 0 1 10h4"/></svg>
            Export All Data
        </button>
    </div>

    {{-- ── UPLOAD ZONE ── --}}
    <div class="ac-card" style="padding:40px; text-align:center; border:2px dashed var(--border); background:var(--bg);">
        <div style="width:80px; height:80px; border-radius:100px; background:var(--blue-lt); display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
            <svg viewBox="0 0 24 24" style="width:40px; height:40px; stroke:var(--blue); fill:none; stroke-width:2;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <div class="ac-card-title" style="font-size:20px; margin-bottom:8px;">Ready to Import?</div>
        <p style="color:var(--ink3); max-width:400px; margin:0 auto 24px; font-size:14px;">Drop your CSV, Excel or JSON files here to start the ingestion process. System will auto-map known headers.</p>
        <div style="display:flex; justify-content:center; gap:12px;">
            <button class="ac-btn ac-btn-primary">Browse Files</button>
            <button class="ac-btn ac-btn-ghost">Download Template</button>
        </div>
    </div>

    {{-- ── RECENT IMPORTS ── --}}
    <div class="ac-card">
        <div class="ac-card-hd">
            <div><div class="ac-card-title">Recent Ingestion Jobs</div><div class="ac-card-sub">History of data updates and syncs</div></div>
            <button class="ac-btn ac-btn-ghost ac-btn-sm">Clear History</button>
        </div>
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead>
                    <tr>
                        <th style="padding-left:24px;">File Identity</th>
                        <th>Type</th>
                        <th>Volume</th>
                        <th>Outcome</th>
                        <th style="text-align:right; padding-right:24px;">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $jobs = [
                            ['file'=>'employees_data.csv','type'=>'CSV','records'=>156,'status'=>'Success','time'=>'2 hours ago'],
                            ['file'=>'payroll_data.xlsx','type'=>'Excel','records'=>89,'status'=>'Processing','time'=>'Just now'],
                            ['file'=>'bank_accounts.json','type'=>'JSON','records'=>45,'status'=>'Success','time'=>'Yesterday'],
                            ['file'=>'departments.csv','type'=>'CSV','records'=>0,'status'=>'Failed','time'=>'3 days ago'],
                        ];
                    @endphp
                    @foreach($jobs as $j)
                        <tr>
                            <td style="padding-left:24px;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="padding:8px; border-radius:8px; background:var(--bg2); color:var(--ink3);"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                    <div style="font-weight:800; color:var(--ink);">{{ $j['file'] }}</div>
                                </div>
                            </td>
                            <td><span style="font-family:'Sora',sans-serif; font-size:11px; font-weight:800; color:var(--blue);">{{ $j['type'] }}</span></td>
                            <td style="font-weight:700;">{{ $j['records'] }} <span style="font-size:11px; color:var(--ink4); font-weight:500;">Rows</span></td>
                            <td>
                                @php $cls = match($j['status']){'Success'=>'ab-green','Processing'=>'ab-teal',default=>'ab-red'}; @endphp
                                <span class="ac-badge {{ $cls }}">{{ strtoupper($j['status']) }}</span>
                            </td>
                            <td style="text-align:right; padding-right:24px; font-size:12px; color:var(--ink4);">{{ $j['time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

