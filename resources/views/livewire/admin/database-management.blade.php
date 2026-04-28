<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session()->has('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ session('error') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Database Infrastructure</div>
            <div class="ac-hero-sub">Maintenance, Query execution, and Disaster recovery</div>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="createBackup">
                <svg viewBox="0 0 24 24" style="stroke:#fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Create Instant Backup
            </button>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="ac-tiles">
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--blue);"></div>
            <div class="ac-tile-icon" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
            <div><div class="ac-tile-lbl">Total Tables</div><div class="ac-tile-val">{{ $dbStats['total_tables'] ?? 0 }}</div><div class="ac-tile-sub">Active Schema</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--teal);"></div>
            <div class="ac-tile-icon" style="background:var(--teal-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--teal);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <div><div class="ac-tile-lbl">Engine Health</div><div class="ac-tile-val">Optimum</div><div class="ac-tile-sub">{{ $dbStats['database_size'] ?? '0 MB' }} Size</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--indigo);"></div>
            <div class="ac-tile-icon" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
            <div><div class="ac-tile-lbl">Active Links</div><div class="ac-tile-val">{{ $dbStats['active_connections'] ?? 0 }}</div><div class="ac-tile-sub">Pool utilization</div></div>
        </div>
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--amber);"></div>
            <div class="ac-tile-icon" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><path d="M11 21H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v7"/><path d="M19 16V22"/><path d="M16 19H22"/></svg></div>
            <div><div class="ac-tile-lbl">Last Recovery Pt</div><div class="ac-tile-val" style="font-size:16px; margin-top:8px;">{{ $dbStats['last_backup'] ?? 'Never' }}</div><div class="ac-tile-sub">G-Storage Encrypted</div></div>
        </div>
    </div>

    {{-- ── ACTIONS ── --}}
    <div style="display:flex; gap:12px; margin-bottom:10px;">
        <button class="ac-btn ac-btn-ghost" wire:click="optimizeDatabase">Optimize All</button>
        <button class="ac-btn ac-btn-ghost" wire:click="repairDatabase">Repair Schema</button>
        <button class="ac-btn ac-btn-ghost" wire:click="refreshTableList">Refresh List</button>
    </div>

    <div style="display:grid; grid-template-columns:1fr 400px; gap:20px; align-items:start;">
        <div style="display:flex; flex-direction:column; gap:20px;">
            {{-- TABLES LIST --}}
            <div class="ac-card">
                <div class="ac-card-hd">
                    <div><div class="ac-card-title">Schema Tables</div><div class="ac-card-sub">Object breakdown and row counts</div></div>
                </div>
                <div class="ac-table-wrap">
                    <table class="ac-table">
                        <thead>
                            <tr>
                                <th style="padding-left:24px;">Table Name</th>
                                <th>Rows</th>
                                <th>Size</th>
                                <th style="text-align:right; padding-right:24px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tables as $table)
                                <tr>
                                    <td style="padding-left:24px;"><div style="font-weight:800; color:var(--ink);">{{ $table['name'] }}</div><div style="font-size:10px; color:var(--ink4);">{{ $table['engine'] ?? 'InnoDB' }}</div></td>
                                    <td style="font-family:'Sora',sans-serif; font-weight:700;">{{ number_format($table['rows']) }}</td>
                                    <td style="font-weight:700; color:var(--blue);">{{ $table['size'] }}</td>
                                    <td style="text-align:right; padding-right:24px;">
                                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                                            <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="viewTableStructure('{{ $table['name'] }}')">Structure</button>
                                            <button class="ac-btn ac-btn-ghost ac-btn-sm" style="color:var(--red);" onclick="showTruncateTableConfirm('{{ $table['name'] }}')">Truncate</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4"><div class="ac-empty">No tables detected.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- QUERY EXECUTOR --}}
            <div class="ac-card">
                <div class="ac-card-hd">
                    <div><div class="ac-card-title">Raw SQL Executor</div><div class="ac-card-sub">Run commands directly against the database</div></div>
                    <div style="display:flex; gap:10px;">
                        <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="clearQuery">Reset</button>
                        <button class="ac-btn ac-btn-primary ac-btn-sm" wire:click="executeQuery">Execute Command</button>
                    </div>
                </div>
                <div style="padding:24px;">
                    <textarea wire:model="customQuery" rows="5" style="width:100%; background:var(--bg); border:1px solid var(--border); border-radius:12px; padding:15px; font-family:monospace; font-size:13px; outline:none; color:var(--ink);" placeholder="SELECT * FROM users WHERE role = 'admin' LIMIT 10;"></textarea>
                    
                    @if($queryError)
                        <div style="margin-top:20px; padding:15px; border-radius:12px; background:var(--red-lt); color:var(--red); font-size:12px; font-family:monospace; border:1px solid var(--red-lt);">
                            <strong>Query Error:</strong> {{ $queryError }}
                        </div>
                    @endif

                    @if($queryResults && count($queryResults) > 0)
                        <div style="margin-top:24px;">
                            <div class="ac-card-title" style="margin-bottom:12px;">Result Set ({{ count($queryResults) }} Rows)</div>
                            <div class="ac-table-wrap" style="max-height:400px; border:1px solid var(--border); border-radius:12px;">
                                <table class="ac-table">
                                    <thead style="position:sticky; top:0; z-index:10;">
                                        <tr>
                                            @foreach(array_keys((array)$queryResults[0]) as $column)
                                                <th>{{ $column }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($queryResults as $row)
                                            <tr>
                                                @foreach((array)$row as $value)
                                                    <td>{{ is_null($value) ? 'NULL' : $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- BACKUPS SIDEBAR --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div><div class="ac-card-title">Storage Snapshots</div><div class="ac-card-sub">Recent recovery points</div></div>
            </div>
            <div style="padding:20px; display:flex; flex-direction:column; gap:12px;">
                @forelse($backups as $backup)
                    <div style="padding:15px; border-radius:14px; background:var(--bg2); border:1px solid var(--border);">
                        <div style="font-weight:800; color:var(--ink); font-size:13px; margin-bottom:4px;">{{ $backup['name'] }}</div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div style="font-size:11px; color:var(--ink4); font-weight:600;">{{ $backup['size'] }} • {{ $backup['created_at'] }}</div>
                            <div style="display:flex; gap:8px;">
                                <button class="ac-btn ac-btn-ghost ac-btn-sm" style="padding:4px 8px;" wire:click="downloadBackup('{{ $backup['name'] }}')"><svg viewBox="0 0 24 24" style="width:14px; height:14px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
                                <button class="ac-btn ac-btn-ghost ac-btn-sm" style="padding:4px 8px; color:var(--red);" wire:click="deleteBackup('{{ $backup['name'] }}')"><svg viewBox="0 0 24 24" style="width:14px; height:14px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ac-empty">No recovery points.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>


 
 { { - -   I n c l u d e   c u s t o m   c o n f i r m   d i a l o g   c o m p o n e n t   - - } } 
 @ i n c l u d e ( ' c o m p o n e n t s . c o n f i r m - d i a l o g ' ) 
 
 < s c r i p t > 
 f u n c t i o n   s h o w T r u n c a t e T a b l e C o n f i r m ( t a b l e N a m e )   { 
         s h o w C o n f i r m D i a l o g ( { 
                 t i t l e :   ' T r u n c a t e   T a b l e ' , 
                 m e s s a g e :   \ A r e   y o u   s u r e   y o u   w a n t   t o   t r u n c a t e   t h e   t a b l e   \  
 \ \ ?   T h i s   w i l l   p e r m a n e n t l y   d e l e t e   A L L   d a t a   i n   t h i s   t a b l e   a n d   c a n n o t   b e   u n d o n e . \ , 
                 c o n f i r m T e x t :   ' T r u n c a t e ' , 
                 c a n c e l T e x t :   ' C a n c e l ' , 
                 t y p e :   ' d a n g e r ' , 
                 o n C o n f i r m :   f u n c t i o n ( )   { 
                         @ t h i s . t r u n c a t e T a b l e ( t a b l e N a m e ) ; 
                 } 
         } ) ; 
 } 
 < / s c r i p t >  
 