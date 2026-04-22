<div class="ep-root">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

        /* ══ Tokens ══════════════════════════════════════════════ */
        .ep-root {
            --blue: #3B6FE8;
            --blue-2: #2755CC;
            --blue-3: #1A3FA8;
            --blue-lt: rgba(59, 111, 232, 0.08);
            --blue-mid: rgba(59, 111, 232, 0.16);
            --blue-brd: rgba(59, 111, 232, 0.22);
            --green: #12B76A;
            --green-lt: rgba(18, 183, 106, 0.10);
            --amber: #F59E0B;
            --amber-lt: rgba(245, 158, 11, 0.10);
            --red: #EF4444;
            --red-lt: rgba(239, 68, 68, 0.09);
            --bg: #F0F4FA;
            --white: #FFFFFF;
            --ink: #0F1629;
            --ink2: #2D3356;
            --ink3: #6B7094;
            --ink4: #A8ADCA;
            --border: rgba(15, 22, 41, 0.08);
            --shadow: 0 2px 12px rgba(59, 111, 232, 0.07);
            --shadow-md: 0 6px 28px rgba(59, 111, 232, 0.12);
            --r: 12px;
            --r-lg: 18px;
            font-family: 'DM Sans', -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--ink);
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ══ HERO SECTION ════════════════════════════════════════ */
        .ep-hero {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .ep-hero-cover {
            height: 80px;
            background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
            position: relative;
        }

        .ep-hero-body {
            padding: 0 24px 22px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-top: -20px;
        }

        .ep-hero-title-wrap {
            display: flex;
            align-items: flex-end;
            gap: 16px;
        }

        .ep-hero-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: var(--white);
            border: 2px solid var(--white);
            box-shadow: 0 4px 14px rgba(59, 111, 232, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ep-hero-icon svg {
            width: 32px;
            height: 32px;
            stroke: var(--blue);
            fill: none;
            stroke-width: 1.5;
        }

        .ep-hero-title {
            font-family: 'Sora', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .ep-hero-sub {
            font-size: 13px;
            color: var(--ink3);
            font-weight: 500;
        }

        /* ══ STATS ═══════════════════════════════════════════════ */
        .ep-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .ep-stat-card {
            background: var(--white);
            border-radius: var(--r);
            border: 1px solid var(--border);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: var(--shadow);
            transition: transform 0.2s;
        }

        .ep-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .ep-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ep-stat-icon svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
            fill: none;
        }

        .ep-stat-info {
            display: flex;
            flex-direction: column;
        }

        .ep-stat-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--ink4);
            letter-spacing: 0.08em;
        }

        .ep-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--ink);
        }

        .bg-blue-soft {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .bg-green-soft {
            background: var(--green-lt);
            color: var(--green);
        }

        .bg-amber-soft {
            background: var(--amber-lt);
            color: var(--amber);
        }

        /* ══ TOOLBAR ═════════════════════════════════════════════ */
        .ep-toolbar {
            background: var(--white);
            border-radius: var(--r);
            border: 1px solid var(--border);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow);
        }

        .ep-search {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
            transition: border-color 0.2s;
        }

        .ep-search:focus-within {
            border-color: var(--blue);
        }

        .ep-search input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink);
        }

        .ep-select {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 30px 8px 12px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink2);
            cursor: pointer;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        /* ══ TABLE ═══════════════════════════════════════════════ */
        .ep-card-table {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-premium {
            width: 100%;
            border-collapse: collapse;
        }

        .table-premium th {
            background: #F8FAFD;
            padding: 12px 20px;
            text-align: left;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--ink4);
            letter-spacing: 0.08em;
            border-bottom: 1px solid var(--border);
        }

        .table-premium td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .table-premium tr:last-child td {
            border-bottom: none;
        }

        .table-premium tr:hover {
            background: #FBFCFE;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--blue-2));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .user-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
        }

        .user-meta {
            font-size: 11px;
            color: var(--ink4);
            font-weight: 600;
            margin-top: 1px;
        }

        /* ══ BADGES ══════════════════════════════════════════════ */
        .ep-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-blue {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .badge-green {
            background: var(--green-lt);
            color: var(--green);
        }

        .badge-amber {
            background: var(--amber-lt);
            color: var(--amber);
        }

        .badge-red {
            background: var(--red-lt);
            color: var(--red);
        }

        /* ══ BUTTONS ═════════════════════════════════════════════ */
        .ep-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--r);
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }

        .ep-btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 111, 232, 0.25);
        }

        .btn-primary:hover {
            background: var(--blue-2);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: var(--white);
            color: var(--ink2);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            color: var(--blue);
            border-color: var(--blue);
        }

        /* ══ FLASH ═══════════════════════════════════════════════ */
        .ep-flash {
            padding: 12px 18px;
            border-radius: var(--r);
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .flash-ok {
            background: var(--green-lt);
            color: #087A42;
            border: 1px solid rgba(18, 183, 106, 0.2);
        }

        .flash-err {
            background: var(--red-lt);
            color: #991B1B;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* ══ MODALS ══════════════════════════════════════════════ */
        .ep-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(15, 22, 41, 0.5);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .ep-modal {
            background: var(--white);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 540px;
            box-shadow: 0 20px 60px rgba(15, 22, 41, 0.2);
            overflow: hidden;
            animation: epModalShow 0.3s ease-out;
        }

        @keyframes epModalShow {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ep-modal-hd {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #F9FAFB;
        }

        .ep-modal-title {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--ink);
        }

        .ep-modal-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .ep-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--ink4);
            letter-spacing: 0.08em;
        }

        .form-control {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13.5px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--blue);
            background: #fff;
        }

        .um-role-sel {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 5px 24px 5px 9px;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink2);
            outline: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 7px center;
            -webkit-appearance: none;
            transition: border-color .15s;
        }

        .um-role-sel:focus {
            border-color: var(--blue);
        }
    </style>

    {{-- Flash --}}
    @if(session()->has('success'))
        <div class="ep-flash flash-ok">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="ep-flash flash-err">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Hero --}}
    <div class="ep-hero">
        <div class="ep-hero-cover"></div>
        <div class="ep-hero-body">
            <div class="ep-hero-title-wrap">
                <div class="ep-hero-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87" />
                        <path d="M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </div>
                <div>
                    <div class="ep-hero-title">User Management</div>
                    <div class="ep-hero-sub">Control employee portal access and manage system credentials.</div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- Stats --}}
    <div class="ep-stats-grid">
        <div class="ep-stat-card">
            <div class="ep-stat-icon bg-blue-soft">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-label">Total Entities</div>
                <div class="ep-stat-value">{{ $totalCount }}</div>
            </div>
        </div>
        <div class="ep-stat-card">
            <div class="ep-stat-icon" style="background:rgba(124,58,237,0.1);color:#7C3AED;">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-label">Admins</div>
                <div class="ep-stat-value">{{ $adminCount }}</div>
            </div>
        </div>
        <div class="ep-stat-card">
            <div class="ep-stat-icon bg-amber-soft">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16" />
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-label">HR Managers</div>
                <div class="ep-stat-value">{{ $hrCount }}</div>
            </div>
        </div>
        <div class="ep-stat-card">
            <div class="ep-stat-icon bg-green-soft">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-label">Employees</div>
                <div class="ep-stat-value">{{ $empCount }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="ep-toolbar">
        <div class="ep-search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email or code...">
        </div>
        <select class="ep-select" wire:model.live="filterType">
            <option value="all">All Records</option>
            <option value="employees">Unlinked Employees</option>
            <option value="users">System Admins</option>
        </select>
        <select class="ep-select" wire:model.live="filterRole">
            <option value="">All Roles</option>
            <option value="admin">Admin</option>
            <option value="hr_manager">HR Manager</option>
            <option value="employee">Employee</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="ep-card-table">
        <table class="table-premium">
            <thead>
                <tr>
                    <th>Profile & Identity</th>
                    <th>Contacts</th>
                    <th>System Access</th>
                    <th>Access Role</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $row)
                    @php
                        $isUser = $row instanceof \App\Models\User;
                        $userObj = $isUser ? $row : $row->user;
                        $hasAccount = (bool) $userObj;

                        $fName = $row->first_name;
                        $lName = $row->last_name;
                        $initials = strtoupper(substr($fName, 0, 1) . substr($lName, 0, 1));
                        $email = $row->email;
                        $code = $row->code;
                        $role = $userObj ? $userObj->role : 'employee';
                    @endphp
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">{{ $initials }}</div>
                                <div>
                                    <div class="user-name">{{ $fName }} {{ $lName }}</div>
                                    <div class="user-meta">CODE: <span
                                            style="color:var(--blue);font-weight:700;">{{ $code }}</span></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:var(--ink2);">{{ $email }}</div>
                            <div class="user-meta">{{ $row->phone_number ?: 'No Phone' }}</div>
                        </td>
                        <td>
                            @if($hasAccount)
                                <div style="font-family:'Sora',sans-serif;font-size:12px;font-weight:700;color:var(--blue-2);">
                                    @ {{ $userObj->username }}
                                </div>
                            @else
                                <span class="ep-badge badge-amber">No Access</span>
                            @endif
                        </td>
                        <td>
                            @if($hasAccount)
                                <select class="um-role-sel" wire:change="assignRole('{{ $userObj->id }}', $event.target.value)">
                                    <option value="admin" @selected($role === 'admin')>Admin</option>
                                    <option value="hr_manager" @selected($role === 'hr_manager')>HR Manager</option>
                                    <option value="employee" @selected($role === 'employee')>Employee</option>
                                </select>
                            @else
                                <span style="font-size:11px;color:var(--ink4);font-style:italic;">External</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                @if($hasAccount)
                                    <button class="ep-btn ep-btn-sm btn-outline" wire:click="openEdit('{{ $userObj->id }}')"
                                        title="Edit">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <button class="ep-btn ep-btn-sm btn-outline"
                                        wire:click="viewCredentials('{{ $userObj->id }}')" title="Keys">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <rect x="3" y="11" width="18" height="11" rx="2" />
                                            <path d="M7 11V7a5 5 0 0110 0v4" />
                                        </svg>
                                    </button>
                                    <button class="ep-btn ep-btn-sm btn-outline" style="color:var(--red);"
                                        wire:click="confirmDelete('{{ $userObj->id }}')" title="Delete">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path
                                                d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" />
                                        </svg>
                                    </button>
                                @else
                                    <button class="ep-btn ep-btn-sm btn-primary"
                                        wire:click="openCreateCredentials('{{ $row->id }}')">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <line x1="19" y1="8" x2="19" y2="14" />
                                            <line x1="22" y1="11" x2="16" y2="11" />
                                        </svg>
                                        Link Account
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($records->hasPages())
            <div
                style="padding:16px 20px;background:#F9FAFB;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <div style="font-size:12px;color:var(--ink4);font-weight:600;">Showing page {{ $records->currentPage() }} of
                    {{ $records->lastPage() }}</div>
                {{ $records->links('pagination::simple-tailwind') }}
            </div>
        @endif
    </div>

    {{-- Modal --}}
    @if($showModal)
        <div class="ep-modal-bg" wire:click.self="closeModal">
            <div class="ep-modal">
                <div class="ep-modal-hd">
                    <span class="ep-modal-title">{{ $editingId ? 'Edit Credentials' : 'Link System Access' }}</span>
                    <button style="background:none;border:none;cursor:pointer;color:var(--ink4);" wire:click="closeModal">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
                <div class="ep-modal-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div class="form-group">
                            <label>Internal Code</label>
                            <input type="text" class="form-control" wire:model="code" placeholder="USR-0001">
                            @error('code')<span style="font-size:11px;color:var(--red);">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Access Role</label>
                            <select class="form-control" wire:model="role">
                                <option value="admin">Admin</option>
                                <option value="hr_manager">HR Manager</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" wire:model.live="firstName">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" wire:model.live="lastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>System Username</label>
                        <input type="text" class="form-control" wire:model="username" placeholder="j.doe">
                    </div>
                    <div class="form-group">
                        <label>Login Email</label>
                        <input type="email" class="form-control" wire:model="email" placeholder="email@company.com">
                        @error('email')<span style="font-size:11px;color:var(--red);">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Password {{ $editingId ? '(Leave blank to stay same)' : '' }}</label>
                        <input type="password" class="form-control" wire:model="password" placeholder="••••••••">
                        @error('password')<span style="font-size:11px;color:var(--red);">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="ep-modal-footer">
                    <button class="ep-btn btn-outline" wire:click="closeModal">Cancel</button>
                    <button class="ep-btn btn-primary" wire:click="save">
                        {{ $editingId ? 'Update' : 'Confirm Access' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Credentials Modal --}}
    @if($showCredentials && $credRecord)
        <div class="ep-modal-bg" wire:click.self="closeCredentials">
            <div class="ep-modal" style="max-width:400px;">
                <div class="ep-modal-hd">
                    <span class="ep-modal-title">Security Check</span>
                    <button style="background:none;border:none;cursor:pointer;color:var(--ink4);"
                        wire:click="closeCredentials">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
                <div class="ep-modal-body" style="text-align:center;">
                    <div
                        style="width:50px;height:50px;background:var(--blue-lt);color:var(--blue);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                    </div>
                    <div style="font-weight:700;color:var(--ink);">Credentials for {{ $credRecord->first_name }}</div>
                    <div style="font-size:13px;color:var(--ink3);margin-top:4px;">Login via: <strong
                            style="color:var(--blue-2);">{{ $credRecord->email }}</strong></div>

                    @if($plainPassword)
                        <div
                            style="margin-top:20px;padding:12px;background:#fff9eb;border:1px dashed #f59e0b;border-radius:8px;">
                            <div style="font-size:10px;text-transform:uppercase;font-weight:800;color:#92400e;">New Password
                            </div>
                            <div
                                style="font-family:'Sora',sans-serif;font-size:20px;font-weight:800;color:#92400e;letter-spacing:1px;margin:4px 0;">
                                {{ $plainPassword }}</div>
                            <div style="font-size:11px;color:#b45309;">Please share this once. It won't be shown again.</div>
                        </div>
                    @endif
                </div>
                <div class="ep-modal-footer" style="justify-content:center;">
                    @if(!$plainPassword)
                        <button class="ep-btn btn-primary" wire:click="resetPassword('{{ $credRecord->id }}')">Generate New
                            Password</button>
                    @endif
                    <button class="ep-btn btn-outline" wire:click="closeCredentials">Dismiss</button>
                </div>
            </div>
        </div>
    @endif

</div>
