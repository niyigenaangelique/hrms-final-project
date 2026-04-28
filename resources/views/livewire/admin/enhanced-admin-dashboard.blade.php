<div class="ac-root">
    <x-admin-content-styles />

    {{-- ── HERO ── --}}
    @php
        $tz = 'Africa/Kigali';
        $now = \Carbon\Carbon::now($tz);
        $greeting = $now->hour < 12 ? 'Good Morning' : ($now->hour < 17 ? 'Good Afternoon' : 'Good Evening');
        $av = strtoupper(substr($admin->first_name ?? 'A', 0, 1) . substr($admin->last_name ?? 'D', 0, 1));
    @endphp
    <div class="ac-hero" style="margin-bottom: 24px; padding: 40px;">
        <div style="display:flex; align-items:center; gap:24px;">
            <div class="ac-av"
                style="width:72px; height:72px; font-size:24px; background:rgba(255,255,255,0.25); color:#fff; border:3px solid rgba(255,255,255,0.4); box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
                {{ $av }}</div>
            <div>
                <div class="ac-hero-ttl" style="font-size:32px; margin-bottom: 8px;">{{ $greeting }}, Administrator
                </div>
                <div class="ac-hero-sub" style="color: rgba(255,255,255,0.85); font-weight: 600;">System Governance &
                    Analytic Console</div>
            </div>
        </div>
        <div style="display:flex; gap:16px;">
            <a href="{{ route('admin.users') }}" class="ac-btn"
                style="background:rgba(255,255,255,0.2); color:#fff; border:1px solid rgba(255,255,255,0.3); padding: 12px 24px;"
                wire:navigate>
                <svg viewBox="0 0 24 24" style="width:1.4em; height:1.4em;">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                Identity Vault
            </a>
            <button class="ac-btn ac-btn-primary" style="padding: 12px 24px; background: #fff; color: var(--blue);"
                wire:click="$refresh">
                <svg viewBox="0 0 24 24" style="width:1.4em; height:1.4em;">
                    <path d="M23 4v6h-6M1 20v-6h6" />
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
                </svg>
                Sync Command
            </button>
        </div>
    </div>

    {{-- ── STATS TILES ── --}}
    <div class="ac-tiles" style="grid-template-columns: repeat(4, 1fr); gap:20px; margin-bottom:24px;">
        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--blue);"></div>
            <div class="ac-tile-icon" style="background:var(--blue-lt); color:var(--blue);">
                <svg viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div>
                <div class="ac-tile-lbl">Identity Count</div>
                <div class="ac-tile-val">{{ number_format($totalUsers) }}</div>
                <div class="ac-tile-sub">Provisioned accounts</div>
            </div>
        </div>

        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--indigo);"></div>
            <div class="ac-tile-icon" style="background:var(--indigo-lt); color:var(--indigo);">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <polyline points="8 12 11 15 16 9" />
                </svg>
            </div>
            <div>
                <div class="ac-tile-lbl">Command Audit</div>
                <div class="ac-tile-val">{{ number_format($auditCountToday) }}</div>
                <div class="ac-tile-sub">Logs captured today</div>
            </div>
        </div>

        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--amber);"></div>
            <div class="ac-tile-icon" style="background:var(--amber-lt); color:var(--amber);">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            </div>
            <div>
                <div class="ac-tile-lbl">Threat Vectors</div>
                <div class="ac-tile-val">{{ number_format($failedLoginsToday) }}</div>
                <div class="ac-tile-sub">Security blocking</div>
            </div>
        </div>

        <div class="ac-tile">
            <div class="ac-tile-accent" style="background:var(--teal);"></div>
            <div class="ac-tile-icon" style="background:var(--teal-lt); color:var(--teal);">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                    <line x1="12" y1="22.08" x2="12" y2="12" />
                </svg>
            </div>
            <div>
                <div class="ac-tile-lbl">Storage Delta</div>
                <div class="ac-tile-val">{{ $dbSize }}</div>
                <div class="ac-tile-sub">SQL footprint size</div>
            </div>
        </div>
    </div>

    {{-- ── CHARTS SECTION ── --}}
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; margin-bottom:24px;">
        <div class="ac-card">
            <div class="ac-card-hd">
                <div>
                    <div class="ac-card-title">Event Propagation</div>
                    <div class="ac-card-sub">7-day system activity intensity</div>
                </div>
            </div>
            <div style="padding:24px; height:320px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="ac-card">
            <div class="ac-card-hd">
                <div>
                    <div class="ac-card-title">Access Distribution</div>
                    <div class="ac-card-sub">Identity grouping by privilege level</div>
                </div>
            </div>
            <div style="padding:24px; height:320px; display:flex; align-items:center; justify-content:center;">
                <canvas id="roleChart"></canvas>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        {{-- Recent Users --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div>
                    <div class="ac-card-title">Identity Registry</div>
                    <div class="ac-card-sub">Most recent platform onboardings</div>
                </div>
                <a href="{{ route('admin.users') }}" class="ac-btn ac-btn-sm ac-btn-ghost" wire:navigate>Registry
                    Access</a>
            </div>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th>Principal</th>
                            <th>Clearance Level</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $u)
                            <tr>
                                <td>
                                    <div class="ac-user-cell">
                                        <div class="ac-av"
                                            style="width:36px; height:36px; font-size:12px; background:var(--blue-lt); border:none;">
                                            {{ substr($u->first_name, 0, 1) . substr($u->last_name, 0, 1) }}</div>
                                        <div>
                                            <div class="ac-user-name">{{ $u->first_name }} {{ $u->last_name }}</div>
                                            <div class="ac-user-meta">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $roleLabel = match ($u->role) {
                                            'admin', 'super_admin' => 'Global Administrator',
                                            'hr_manager' => 'Personnel Lead',
                                            'employee' => 'Core Operative',
                                            default => ucfirst(str_replace('_', ' ', $u->role))
                                        };
                                        $badgeClass = match ($u->role) {
                                            'admin', 'super_admin' => 'ab-red',
                                            'hr_manager' => 'ab-indigo',
                                            default => 'ab-teal'
                                        };
                                    @endphp
                                    <span class="ac-badge {{ $badgeClass }}">{{ $roleLabel }}</span>
                                </td>
                                <td><span class="ac-user-meta">{{ $u->created_at->diffForHumans() }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- System Health / Maintenance --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div>
                    <div class="ac-card-title">Maintenance Console</div>
                    <div class="ac-card-sub">Manual system optimization triggers</div>
                </div>
            </div>
            <div style="padding:24px; display:flex; flex-direction:column; gap:16px;">
                <div
                    style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg2); border-radius:16px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size:14px; font-weight:800;">Memory Flush</div>
                        <div style="font-size:11.5px; color:var(--ink4); font-weight: 500;">Purge all application state
                            caches</div>
                    </div>
                    <button class="ac-btn ac-btn-sm"
                        style="background:var(--blue); color:#fff; min-width: 90px;">Execute</button>
                </div>
                <div
                    style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg2); border-radius:16px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size:14px; font-weight:800;">Index Optimization</div>
                        <div style="font-size:11.5px; color:var(--ink4); font-weight: 500;">Re-balance SQL relational
                            weights</div>
                    </div>
                    <button class="ac-btn ac-btn-sm"
                        style="background:var(--indigo); color:#fff; min-width: 90px;">Optimize</button>
                </div>
                <div
                    style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg2); border-radius:16px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size:14px; font-weight:800;">Audit Indexing</div>
                        <div style="font-size:11.5px; color:var(--ink4); font-weight: 500;">Synchronize audit trail
                            searchable shards</div>
                    </div>
                    <button class="ac-btn ac-btn-sm"
                        style="background:var(--amber); color:#fff; min-width: 90px;">Sync</button>
                </div>
                <div
                    style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg2); border-radius:16px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size:14px; font-weight:800;">Logs Archive</div>
                        <div style="font-size:11.5px; color:var(--ink4); font-weight: 500;">Generate secure CSV snapshot
                            of logs</div>
                    </div>
                    <button class="ac-btn ac-btn-sm"
                        style="background:var(--teal); color:#fff; min-width: 90px;">Export</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function initCharts() {
            if (typeof Chart === 'undefined') {
                console.warn('Chart.js not loaded yet, retrying...');
                setTimeout(initCharts, 100);
                return;
            }

            // Activity Trend Chart
            const activityCtx = document.getElementById('activityChart');
            if (activityCtx && !activityCtx.chart) {
                activityCtx.chart = new Chart(activityCtx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Events',
                            data: @json($chartData),
                            borderColor: '#3B6FE8',
                            backgroundColor: 'rgba(59, 111, 232, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#3B6FE8'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Role Distribution Chart
            const roleCtx = document.getElementById('roleChart');
            if (roleCtx && !roleCtx.chart) {
                roleCtx.chart = new Chart(roleCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admins', 'HR', 'Employees', 'Others'],
                        datasets: [{
                            data: [{{ $adminCount }}, {{ $hrCount }}, {{ $empCount }}, {{ $othersCount }}],
                            backgroundColor: ['#EF4444', '#6B4FDB', '#0BB5B5', '#6B7094'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                        }
                    }
                });
            }
        }

        document.addEventListener('livewire:navigated', initCharts);
        document.addEventListener('DOMContentLoaded', initCharts);

        // Safety for Livewire refreshes
        window.addEventListener('load', initCharts);
    </script>
</div>