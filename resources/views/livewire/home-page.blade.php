<div class="db-root">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

        /* ══ DEEP OCEAN TOKENS ══════════════════════════════ */
        .db-root {
            /* Ocean depth palette */
            --ocean-950:  #020B18;
            --ocean-900:  #051628;
            --ocean-800:  #0A2540;
            --ocean-700:  #0F3460;
            --ocean-600:  #1A4F8A;
            --ocean-500:  #1E6FBF;
            --ocean-400:  #2D8FE8;
            --ocean-300:  #5BAEF0;
            --ocean-200:  #3B82F6;
            --ocean-100:  #C8E8FD;
            --ocean-50:   #EBF6FF;

            /* Surface layers — light mode */
            --surf-1:     #F0F5FF;   /* table header / card header */
            --surf-2:     #FFFFFF;   /* card bg */
            --surf-3:     #F4F8FF;   /* hover/raised */
            --surf-4:     #E2EAF8;   /* border/divider */

            /* Accent — electric cyan → deep blue on white */
            --cyan:       #0284C7;
            --cyan-lt:    rgba(2,132,199,0.08);
            --cyan-glow:  rgba(2,132,199,0.15);

            /* Accent 2 — teal */
            --teal:       #0D9488;
            --teal-lt:    rgba(13,148,136,0.08);

            /* Accent 3 — electric blue */
            --elec:       #3B82F6;
            --elec-lt:    rgba(59,130,246,0.08);

            /* Status */
            --green:      #059669;
            --green-lt:   rgba(5,150,105,0.08);
            --red:        #DC2626;
            --red-lt:     rgba(220,38,38,0.08);
            --amber:      #D97706;
            --amber-lt:   rgba(217,119,6,0.08);

            /* Text */
            --txt-1:      #0F172A;   /* headings */
            --txt-2:      #334155;   /* body */
            --txt-3:      #64748B;   /* muted */
            --txt-4:      #94A3B8;   /* very muted */

            /* Structure */
            --border:     rgba(148,163,184,0.20);
            --border-bright: rgba(2,132,199,0.20);

            font-family: 'DM Sans', sans-serif;
            color: var(--txt-1);
            min-height: 100vh;
            padding: 32px 40px;
            display: flex;
            flex-direction: column;
            gap: 28px;
            background: #F8FAFF;
        }

        /* ══ HEADER ════════════════════════════════════════ */
        .db-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .db-h-greet {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--txt-1);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .db-h-greet span {
            background: linear-gradient(90deg, var(--elec), var(--cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .db-h-sub {
            font-size: 14px;
            color: var(--txt-3);
            font-weight: 500;
            margin-top: 5px;
        }

        .db-h-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .db-search {
            position: relative;
            width: 280px;
        }

        .db-search input {
            width: 100%;
            padding: 11px 16px 11px 42px;
            background: var(--surf-2);
            border: 1px solid var(--border);
            border-radius: 100px;
            font-size: 13.5px;
            color: var(--txt-2);
            outline: none;
            transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }

        .db-search input::placeholder { color: var(--txt-4); }

        .db-search input:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px var(--cyan-glow);
        }

        .db-search svg {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--txt-3);
        }

        .db-btn-primary {
            background: linear-gradient(135deg, var(--ocean-500), var(--elec));
            color: #fff;
            padding: 11px 22px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 13.5px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(59,130,246,0.35);
            transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.01em;
        }

        .db-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(59,130,246,0.50);
        }

        /* ══ HERO DESIGN (Standardized) ═════════════════════ */
        .db-hero {
            background: linear-gradient(118deg, #1A3FA8 0%, #2755CC 36%, #3B6FE8 68%, #6B4FDB 100%);
            border-radius: 20px;
            padding: 32px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 48px rgba(59,111,232,0.14);
            margin-bottom: 8px;
        }

        .db-hero::before {
            content: ''; position: absolute; top: -50px; right: 240px;
            width: 250px; height: 250px; border-radius: 50%;
            background: rgba(255,255,255,0.06); pointer-events: none;
        }

        .db-hero::after {
            content: ''; position: absolute; bottom: -40px; left: 60px;
            width: 160px; height: 160px; border-radius: 50%;
            background: rgba(255,255,255,0.04); pointer-events: none;
        }

        .db-hero-left { display: flex; align-items: center; gap: 20px; position: relative; z-index: 1; }
        .db-hero-icon {
            width: 64px; height: 64px; border-radius: 18px;
            background: rgba(255,255,255,0.18); border: 2px solid rgba(255,255,255,0.30);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .db-hero-icon svg { width: 30px; height: 30px; stroke: #fff; fill: none; stroke-width: 1.75; }
        .db-hero-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 900; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
        .db-hero-sub { font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500; }
        .db-hero-chips { display: flex; gap: 10px; margin-top: 12px; }
        .db-hero-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.20);
            border-radius: 100px; padding: 4px 14px; font-size: 12.5px;
            font-weight: 600; color: rgba(255,255,255,0.95);
        }

        .db-hero-right { display: flex; gap: 32px; position: relative; z-index: 1; flex-shrink: 0; }
        .db-hero-stat { text-align: center; }
        .db-hero-sv { font-family: 'Sora', sans-serif; font-size: 32px; font-weight: 900; color: #fff; line-height: 1; }
        .db-hero-sl { font-size: 11px; color: rgba(255,255,255,0.60); font-weight: 700; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.1em; }

        /* ══ STAT CARDS ════════════════════════════════════ */
        .db-overview {
            display: grid;
            grid-template-columns: repeat(4, 1fr) 1.1fr;
            gap: 18px;
        }

        .db-stat-card {
            background: var(--surf-2);
            border-radius: 18px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 12px rgba(59,130,246,0.06);
        }

        .db-stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--cyan), var(--elec));
            opacity: 0;
            transition: opacity 0.2s;
        }

        .db-stat-card:hover { border-color: var(--border-bright); }
        .db-stat-card:hover::before { opacity: 1; }

        .db-stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .db-stat-ico {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ico-cyan   { background: var(--cyan-lt);  color: var(--cyan); }
        .ico-teal   { background: var(--teal-lt);  color: var(--teal); }
        .ico-red    { background: var(--red-lt);   color: var(--red);  }
        .ico-amber  { background: var(--amber-lt); color: var(--amber);}
        .ico-elec   { background: var(--elec-lt);  color: var(--elec); }

        .db-stat-trend {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 9px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .trend-up   { background: var(--green-lt); color: var(--green); }
        .trend-down { background: var(--red-lt);   color: var(--red);   }

        .db-stat-val {
            font-family: 'Sora', sans-serif;
            font-size: 34px;
            font-weight: 900;
            color: var(--txt-1);
            line-height: 1;
            letter-spacing: -1px;
        }

        .db-stat-lbl {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--txt-3);
            letter-spacing: 0.02em;
        }

        /* Gender / donut card */
        .db-gender-card {
            background: var(--surf-2);
            border-radius: 18px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .db-gender-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--teal), var(--cyan));
        }

        .db-gender-ttl {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--txt-2);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        .db-gender-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--txt-3);
            margin-bottom: 7px;
        }

        .dot { width: 8px; height: 8px; border-radius: 50%; }

        .db-chart-container {
            width: 82px;
            height: 82px;
            position: relative;
            flex-shrink: 0;
        }

        .chart-overlay {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 900;
            color: var(--txt-1);
        }

        /* ══ SECTION HEADER ════════════════════════════════ */
        .db-card {
            background: var(--surf-2);
            border-radius: 18px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(59,130,246,0.06);
        }

        .db-card-hd {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--surf-1);
            box-shadow: 0 1px 0 var(--border);
        }

        .db-card-ttl {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--txt-1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .db-card-ttl-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--cyan);
        }

        .db-badge-count {
            background: var(--cyan-lt);
            color: var(--cyan);
            font-size: 11px;
            font-weight: 800;
            padding: 3px 9px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
        }

        /* ══ TABLE ════════════════════════════════════════ */
        .db-table { width: 100%; border-collapse: collapse; }

        .db-table th {
            text-align: left;
            padding: 13px 28px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--txt-3);
            background: var(--surf-1);
            border-bottom: 1px solid var(--border);
        }

        .db-table td {
            padding: 16px 28px;
            font-size: 13.5px;
            color: var(--txt-2);
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .db-table tr:last-child td { border-bottom: none; }

        .db-table tr:hover td { background: var(--surf-3); }

        .db-emp-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .db-emp-av {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12.5px;
            flex-shrink: 0;
        }

        .av-blue  { background: var(--elec-lt);  color: var(--ocean-200); }
        .av-teal  { background: var(--teal-lt);  color: var(--teal); }
        .av-cyan  { background: var(--cyan-lt);  color: var(--cyan); }

        .db-emp-name { font-weight: 700; color: var(--txt-1); }

        .db-emp-id {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--txt-4);
            background: var(--surf-3);
            padding: 3px 8px;
            border-radius: 6px;
            font-family: 'DM Sans', monospace;
        }

        .db-leave-type {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 7px;
            background: var(--elec-lt);
            color: var(--ocean-200);
        }

        .db-action-btns { display: flex; gap: 8px; }

        .btn-sm {
            padding: 6px 13px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-accept {
            background: var(--green-lt);
            color: var(--green);
            border: 1px solid rgba(16,217,140,0.20);
        }

        .btn-reject {
            background: var(--red-lt);
            color: var(--red);
            border: 1px solid rgba(241,91,91,0.20);
        }

        .btn-accept:hover { background: var(--green); color: #051628; }
        .btn-reject:hover { background: var(--red);   color: #fff; }

        /* ══ TRIPLE GRID ═══════════════════════════════════ */
        .db-triple-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .list-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .list-item:last-child { border-bottom: none; }

        .list-info { flex: 1; min-width: 0; }

        .list-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--txt-1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .list-sub {
            font-size: 11.5px;
            color: var(--txt-3);
            margin-top: 2px;
            font-weight: 500;
        }

        .badge-time {
            padding: 5px 11px;
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .bg-time-ok   { background: var(--green-lt); color: var(--green); }
        .bg-time-warn { background: var(--red-lt);   color: var(--red);   }
        .bg-time-blue { background: var(--elec-lt);  color: var(--ocean-200); }
        .bg-time-cyan { background: var(--cyan-lt);  color: var(--cyan); }

        /* ══ SUMMARY ROWS (Workforce) ══════════════════════ */
        .wf-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
        }

        .wf-row-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--txt-2);
        }

        .wf-row-label.parent { color: var(--txt-1); font-weight: 700; font-size: 13.5px; }
        .wf-row-label.child  { color: var(--txt-3); font-size: 12px; padding-left: 12px; }

        .wf-val {
            font-size: 13px;
            font-weight: 800;
            font-family: 'Sora', sans-serif;
        }

        .wf-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 0;
        }

        /* ══ SECTION LABELS ════════════════════════════════ */
        .section-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--txt-4);
        }

        /* ══ EMPTY STATE ═══════════════════════════════════ */
        .db-empty {
            padding: 36px 0;
            text-align: center;
            color: var(--txt-4);
            font-size: 13px;
            font-weight: 500;
        }
    </style>

    @php
        $user = auth()->user();
        $employeeCount = \App\Models\Employee::count();
        $maleCount = \App\Models\Employee::where('gender', 'male')->count();
        $femaleCount = \App\Models\Employee::where('gender', 'female')->count();
        $pendingLeaves = \App\Models\LeaveRequest::with('employee')->where('status', 'pending')->latest()->take(5)->get();
        $attendanceToday = \App\Models\Attendance::whereDate('date', today())->count();
        $lateArrivals = \App\Models\Attendance::whereDate('date', today())->whereTime('check_in', '>', '08:30:00')->count();
        $absentToday = $employeeCount - $attendanceToday;
        $earlyRisers = \App\Models\Attendance::with('employee')->whereDate('date', today())->whereTime('check_in', '<=', '08:30:00')->orderBy('check_in', 'asc')->take(3)->get();
        $lateList = \App\Models\Attendance::with('employee')->whereDate('date', today())->whereTime('check_in', '>', '08:30:00')->orderBy('check_in', 'desc')->take(3)->get();
        $activeEmp = \App\Models\Employee::where('is_active', true)->count();
        $inactiveEmp = $employeeCount - $activeEmp;
        $deptCount = \App\Models\Department::count();
        $posCount = \App\Models\Position::count();
        $vacantPos = \App\Models\Position::doesntHave('employees')->count();
        $filledPos = $posCount - $vacantPos;
        $totalContracts = \App\Models\Contract::count();
        $activeContracts = \App\Models\Contract::where('status', 'active')->count();
        // Get recent messages for HR user
        $hrUser = auth()->user();
        $recentMessages = \App\Models\Message::where(function($query) use ($hrUser) {
                $query->where('sender_id', $hrUser->id)
                      ->orWhere('receiver_id', $hrUser->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Comprehensive Daily Schedule for TODAY only (no leaves)
        $dailySchedule = collect();
        try {
            // Tasks for TODAY (not by weekday)
            $todayTasks = \App\Models\Task::with('employee')
                ->whereDate('created_at', today())
                ->orWhere(function($query) {
                    $query->where('assign_date', today())
                          ->orWhere('due_date', today());
                })
                ->get();
            foreach($todayTasks as $t) {
                $dailySchedule->push((object)[
                    'title' => $t->title . ($t->employee ? ' (' . $t->employee->first_name . ')' : ''),
                    'time'  => $t->hour ? str_pad($t->hour, 2, '0', STR_PAD_LEFT) . ':00' : 'All Day',
                    'icon'  => 'task'
                ]);
            }
        } catch(\Exception $e) {}
        $dailySchedule = $dailySchedule->sortBy('time');

        // Chart data for system analytics
        $deptChartData = \App\Models\Department::withCount('employees')
            ->orderBy('employees_count', 'desc')
            ->take(6)
            ->get();
            
        $attendanceChartData = \App\Models\Attendance::selectRaw('DATE(date) as date, COUNT(*) as count')
            ->where('date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $genderChartData = [
            ['label' => 'Male', 'value' => \App\Models\Employee::where('gender', 'male')->count()],
            ['label' => 'Female', 'value' => \App\Models\Employee::where('gender', 'female')->count()],
            ['label' => 'Other', 'value' => \App\Models\Employee::where('gender', 'other')->count()],
        ];
        
        $avatarColors = ['av-blue', 'av-teal', 'av-cyan'];
    @endphp

    {{-- ══ HERO HEADER ══ --}}
    <div class="db-hero">
        <div class="db-hero-left">
            <div class="db-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div>
                <div class="db-hero-title">Welcome back, {{ explode(' ', $user->name ?? 'HR Manager')[0] }}!</div>
                <div class="db-hero-sub">Here's a snapshot of your organization for today · {{ now()->format('l, j F Y') }}</div>
                <div class="db-hero-chips">
                    <span class="db-hero-chip"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>{{ $employeeCount }} Staff</span>
                    <span class="db-hero-chip"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>{{ round(($attendanceToday/max(1,$employeeCount))*100) }}% Present</span>
                </div>
            </div>
        </div>
        <div class="db-hero-right">
            <div class="db-hero-stat"><div class="db-hero-sv">{{ $attendanceToday }}</div><div class="db-hero-sl">Present</div></div>
            <div class="db-hero-stat"><div class="db-hero-sv">{{ $absentToday }}</div><div class="db-hero-sl">Absent</div></div>
            <div class="db-hero-stat"><div class="db-hero-sv">{{ $pendingLeaves->count() }}</div><div class="db-hero-sl">Leaves</div></div>
        </div>
    </div>

    {{-- ══ STAT OVERVIEW ══ --}}
    <section class="db-overview">

        <div class="db-stat-card">
            <div class="db-stat-top">
                <div class="db-stat-ico ico-cyan">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <div class="db-stat-trend trend-up">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                    2.5%
                </div>
            </div>
            <div class="db-stat-val">{{ $attendanceToday }}</div>
            <div class="db-stat-lbl">Present Today</div>
        </div>

        <div class="db-stat-card">
            <div class="db-stat-top">
                <div class="db-stat-ico ico-amber">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="db-stat-trend trend-down">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="6 9 12 15 18 9"/></svg>
                    1.5%
                </div>
            </div>
            <div class="db-stat-val">{{ $lateArrivals }}</div>
            <div class="db-stat-lbl">Late Arrivals</div>
        </div>

        <div class="db-stat-card">
            <div class="db-stat-top">
                <div class="db-stat-ico ico-red">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <line x1="18" y1="8" x2="23" y2="13"/><line x1="23" y1="8" x2="18" y2="13"/>
                    </svg>
                </div>
                <div class="db-stat-trend trend-up">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                    0.8%
                </div>
            </div>
            <div class="db-stat-val">{{ $absentToday }}</div>
            <div class="db-stat-lbl">Absent Today</div>
        </div>

        <div class="db-stat-card">
            <div class="db-stat-top">
                <div class="db-stat-ico ico-teal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="db-stat-trend trend-down">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="6 9 12 15 18 9"/></svg>
                    3.2%
                </div>
            </div>
            <div class="db-stat-val">{{ $pendingLeaves->count() }}</div>
            <div class="db-stat-lbl">Pending Leaves</div>
        </div>

        <div class="db-gender-card">
            <div style="flex:1;">
                <div class="db-gender-ttl">Total Workforce</div>
                <div class="db-gender-row">
                    <span class="dot" style="background:var(--cyan);"></span>
                    Male — {{ $maleCount }}
                </div>
                <div class="db-gender-row">
                    <span class="dot" style="background:var(--teal);"></span>
                    Female — {{ $femaleCount }}
                </div>
            </div>
            <div class="db-chart-container">
                <canvas id="genderChart" role="img" aria-label="Donut chart: {{ $maleCount }} male, {{ $femaleCount }} female employees">
                    {{ $maleCount }} male, {{ $femaleCount }} female.
                </canvas>
                <div class="chart-overlay">{{ $employeeCount }}</div>
            </div>
        </div>

    </section>

    {{-- ══ LEAVE REQUEST TABLE ══ --}}
    <section class="db-card">
        <div class="db-card-hd">
            <h2 class="db-card-ttl">
                <span class="db-card-ttl-dot"></span>
                Leave Requests
            </h2>
            <span class="db-badge-count">{{ $pendingLeaves->count() }} pending</span>
        </div>
        <table class="db-table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingLeaves as $i => $leave)
                    <tr>
                        <td><span class="db-emp-id">{{ $leave->employee->code ?? 'EMP-00' . ($i+1) }}</span></td>
                        <td>
                            <div class="db-emp-cell">
                                <div class="db-emp-av {{ $avatarColors[$i % 3] }}">
                                    {{ strtoupper(substr($leave->employee->first_name, 0, 1)) }}{{ strtoupper(substr($leave->employee->last_name ?? '', 0, 1)) }}
                                </div>
                                <span class="db-emp-name">{{ $leave->employee->full_name }}</span>
                            </div>
                        </td>
                        <td><span class="db-leave-type">{{ $leave->leave_type }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}</td>
                        <td style="color:var(--txt-3); font-size:13px;">{{ Str::limit($leave->reason, 24) }}</td>
                        <td>
                            <div class="db-action-btns">
                                <button class="btn-sm btn-accept">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Accept
                                </button>
                                <button class="btn-sm btn-reject">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="db-empty">No pending leave requests.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>

    {{-- ══ ATTENDANCE TRIPLE ══ --}}
    <section class="db-triple-grid">

        <div class="db-card" style="padding: 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <h3 class="db-card-ttl" style="font-size:15px;">
                    <span class="db-card-ttl-dot" style="background:var(--green);"></span>
                    Early Risers
                </h3>
                <span class="section-label">{{ now()->format('d M') }}</span>
            </div>
            @forelse($earlyRisers as $i => $att)
                <div class="list-item">
                    <div class="db-emp-av {{ $avatarColors[$i % 3] }}" style="width:32px;height:32px;border-radius:9px;">
                        {{ strtoupper(substr($att->employee->first_name, 0, 1)) }}
                    </div>
                    <div class="list-info">
                        <div class="list-name">{{ $att->employee->full_name }}</div>
                        <div class="list-sub">{{ $att->employee->code }}</div>
                    </div>
                    <div class="badge-time bg-time-ok">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>
                        {{ \Carbon\Carbon::parse($att->check_in)->format('H:i') }}
                    </div>
                </div>
            @empty
                <div class="db-empty">No early arrivals recorded yet.</div>
            @endforelse
        </div>

        <div class="db-card" style="padding: 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <h3 class="db-card-ttl" style="font-size:15px;">
                    <span class="db-card-ttl-dot" style="background:var(--red);"></span>
                    Late Arrivals
                </h3>
                <span class="section-label">{{ now()->format('d M') }}</span>
            </div>
            @forelse($lateList as $i => $att)
                <div class="list-item">
                    <div class="db-emp-av {{ $avatarColors[$i % 3] }}" style="width:32px;height:32px;border-radius:9px;">
                        {{ strtoupper(substr($att->employee->first_name, 0, 1)) }}
                    </div>
                    <div class="list-info">
                        <div class="list-name">{{ $att->employee->full_name }}</div>
                        <div class="list-sub">{{ $att->employee->code }}</div>
                    </div>
                    <div class="badge-time bg-time-warn">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/></svg>
                        +{{ \Carbon\Carbon::parse($att->check_in)->diffForHumans(\Carbon\Carbon::today()->setHour(8)->setMinute(30), true) }}
                    </div>
                </div>
            @empty
                <div class="db-empty">Everyone arrived on time!</div>
            @endforelse
        </div>

        <div class="db-card" style="padding: 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <h3 class="db-card-ttl" style="font-size:15px;">
                    <span class="db-card-ttl-dot" style="background:var(--cyan);"></span>
                    Quick Analytics
                </h3>
                <span class="db-badge-count" style="background:var(--blue-lt);color:var(--blue);">Live</span>
            </div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <!-- Mini Department Chart -->
                <div>
                    <div style="font-size:11px;color:var(--txt-3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">Departments</div>
                    <div style="height:80px;position:relative;">
                        <canvas id="miniDeptChart"></canvas>
                    </div>
                </div>
                
                <!-- Mini Gender Chart -->
                <div>
                    <div style="font-size:11px;color:var(--txt-3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">Gender</div>
                    <div style="height:80px;position:relative;">
                        <canvas id="miniGenderChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Mini Attendance Trend -->
            <div style="margin-top:16px;">
                <div style="font-size:11px;color:var(--txt-3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">7-Day Trend</div>
                <div style="height:60px;position:relative;">
                    <canvas id="miniAttendanceChart"></canvas>
                </div>
            </div>
        </div>

    </section>

    {{-- ══ SCHEDULE / MESSAGES / WORKFORCE ══ --}}
    <section class="db-triple-grid">

        <div class="db-card" style="padding: 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <h3 class="db-card-ttl" style="font-size:15px;">
                    <span class="db-card-ttl-dot" style="background:var(--teal);"></span>
                    Daily Schedule
                </h3>
                <span class="section-label">Today</span>
            </div>
            @forelse($dailySchedule as $sch)
                <div class="list-item">
                    <div class="db-emp-av" style="width:32px;height:32px;border-radius:9px;background:{{ $sch->icon==='leave'?'var(--red-lt)':'var(--elec-lt)' }};color:{{ $sch->icon==='leave'?'var(--red)':'var(--elec)' }};">
                        @if($sch->icon === 'leave')
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @else
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        @endif
                    </div>
                    <div class="list-info">
                        <div class="list-name">{{ $sch->title }}</div>
                        <div class="list-sub">{{ $sch->time }}</div>
                    </div>
                    <div class="badge-time bg-time-cyan">{{ $sch->time === 'All Day' ? 'Active' : $sch->time }}</div>
                </div>
            @empty
                <div style="padding:40px 20px;text-align:center;color:var(--txt-4);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;opacity:0.5;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div style="font-size:13px;font-weight:600;">No scheduled events for today.</div>
                </div>
            @endforelse
        </div>

        <div class="db-card" style="padding: 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <h3 class="db-card-ttl" style="font-size:15px;">
                    <span class="db-card-ttl-dot"></span>
                    Recent Messages
                </h3>
                <span class="section-label">Inbox</span>
            </div>
            @forelse($recentMessages as $i => $msg)
                <div class="list-item">
                    <div class="db-emp-av" style="width:32px;height:32px;border-radius:9px;background:var(--surf-3);">
                        @php
                            $otherPerson = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender;
                            $initials = strtoupper(substr($otherPerson->first_name ?? 'U', 0, 1) . substr($otherPerson->last_name ?? 'N', 0, 1));
                        @endphp
                        <span style="color:var(--txt-2);font-weight:700;font-size:12px;">{{ $initials }}</span>
                    </div>
                    <div class="list-info">
                        <div class="list-name">{{ Str::limit($msg->subject, 22) }}</div>
                        <div class="list-sub">{{ $msg->created_at->diffForHumans() }} {{ $msg->sender_id === auth()->id() ? 'to ' . $otherPerson->first_name : 'from ' . $otherPerson->first_name }}</div>
                    </div>
                    @if(!$msg->is_read && $msg->receiver_id === auth()->id())
                        <div style="width:8px;height:8px;background:var(--cyan);border-radius:50%;margin-left:8px;"></div>
                    @endif
                </div>
            @empty
                <div class="db-empty">Your inbox is empty.</div>
            @endforelse
        </div>

        <div class="db-card" style="padding: 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <h3 class="db-card-ttl" style="font-size:15px;">
                    <span class="db-card-ttl-dot" style="background:var(--elec);"></span>
                    Workforce Summary
                </h3>
                <span class="section-label">At a glance</span>
            </div>

            <div class="wf-row">
                <span class="wf-row-label parent">Total Employees</span>
                <span class="wf-val" style="color:var(--cyan);">{{ $employeeCount }}</span>
            </div>
            <div class="wf-row">
                <span class="wf-row-label child">Active</span>
                <span class="wf-val" style="color:var(--green);font-size:12px;">{{ $activeEmp }}</span>
            </div>
            <div class="wf-row">
                <span class="wf-row-label child">Inactive</span>
                <span class="wf-val" style="color:var(--red);font-size:12px;">{{ $inactiveEmp }}</span>
            </div>
            <div class="wf-divider"></div>
            <div class="wf-row">
                <span class="wf-row-label parent">Departments</span>
                <span class="wf-val" style="color:var(--teal);">{{ $deptCount }}</span>
            </div>
            <div class="wf-row">
                <span class="wf-row-label parent">Positions</span>
                <span class="wf-val" style="color:var(--ocean-300);">{{ $posCount }}</span>
            </div>
            <div class="wf-row">
                <span class="wf-row-label child">Filled</span>
                <span class="wf-val" style="color:var(--green);font-size:12px;">{{ $filledPos }}</span>
            </div>
            <div class="wf-row">
                <span class="wf-row-label child">Vacant</span>
                <span class="wf-val" style="color:var(--txt-3);font-size:12px;">{{ $vacantPos }}</span>
            </div>
            <div class="wf-divider"></div>
            <div class="wf-row">
                <span class="wf-row-label parent">Contracts</span>
                <span class="wf-val" style="color:var(--elec);">{{ $totalContracts }}</span>
            </div>
            <div class="wf-row">
                <span class="wf-row-label child">Active</span>
                <span class="wf-val" style="color:var(--green);font-size:12px;">{{ $activeContracts }}</span>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function initDashboardCharts() {
            // Mini Department Bar Chart
            var miniDeptCtx = document.getElementById('miniDeptChart');
            if (miniDeptCtx) {
                if (miniDeptCtx._chartInstance) { miniDeptCtx._chartInstance.destroy(); }
                miniDeptCtx._chartInstance = new Chart(miniDeptCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($deptChartData->pluck('name')->take(3)),
                        datasets: [{
                            data: @json($deptChartData->pluck('employees_count')->take(3)),
                            backgroundColor: '#3B6FE8',
                            borderWidth: 0,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(15, 22, 41, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 8,
                                borderRadius: 6,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                display: false,
                                beginAtZero: true
                            },
                            x: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Mini Gender Doughnut Chart
            var miniGenderCtx = document.getElementById('miniGenderChart');
            if (miniGenderCtx) {
                if (miniGenderCtx._chartInstance) { miniGenderCtx._chartInstance.destroy(); }
                miniGenderCtx._chartInstance = new Chart(miniGenderCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @json(array_column($genderChartData, 'label')),
                        datasets: [{
                            data: @json(array_column($genderChartData, 'value')),
                            backgroundColor: ['#3B6FE8', '#12B76A', '#F59E0B'],
                            borderWidth: 0,
                            cutout: '65%',
                            borderRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(15, 22, 41, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 8,
                                borderRadius: 6
                            }
                        }
                    }
                });
            }

            // Mini Attendance Line Chart
            var miniAttendanceCtx = document.getElementById('miniAttendanceChart');
            if (miniAttendanceCtx) {
                if (miniAttendanceCtx._chartInstance) { miniAttendanceCtx._chartInstance.destroy(); }
                miniAttendanceCtx._chartInstance = new Chart(miniAttendanceCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($attendanceChartData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('D'))),
                        datasets: [{
                            data: @json($attendanceChartData->pluck('count')),
                            borderColor: '#12B76A',
                            backgroundColor: 'rgba(18, 183, 106, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(15, 22, 41, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 8,
                                borderRadius: 6,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                display: false,
                                beginAtZero: true
                            },
                            x: {
                                display: false
                            }
                        }
                    }
                });
            }
        }
        document.addEventListener('livewire:navigated', initDashboardCharts);
        initDashboardCharts();
    </script>
</div>