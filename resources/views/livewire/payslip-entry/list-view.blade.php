<div class="pse-list-root">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

        .pse-list-root {
            --glass-bg:       rgba(255,255,255,0.50);
            --glass-border:   rgba(255,255,255,0.72);
            --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
            --blur:           blur(22px) saturate(1.7);
            --radius:         20px;
            --radius-sm:      13px;
            --text-primary:   rgba(15,15,25,0.96);
            --text-secondary: rgba(15,15,25,0.68);
            --text-tertiary:  rgba(15,15,25,0.44);
            font-family: 'DM Sans', -apple-system, sans-serif;
            padding: 32px 24px 110px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100vh;
            overflow-y: auto;
        }

        @keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
        .anim-1 { animation: fadeSlideUp 0.35s ease both; }
        .anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }

        .g-card {
            background: var(--glass-bg);
            backdrop-filter: var(--blur);
            -webkit-backdrop-filter: var(--blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius);
            box-shadow: var(--glass-shadow);
            position: relative;
        }

        .g-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
            pointer-events: none;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .pse-header {
            padding: 24px 26px;
            text-align: center;
        }

        .pse-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 6px;
            letter-spacing: -0.3px;
        }

        .pse-header p {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-secondary);
            margin: 0;
        }

        .pse-search {
            padding: 20px 26px;
        }

        .pse-search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            background: rgba(255,255,255,0.78) !important;
            border: 1px solid rgba(0,0,0,0.1) !important;
            border-radius: var(--radius-sm) !important;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-primary);
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s, box-shadow 0.15s;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 16px center !important;
        }

        .pse-search-input:focus {
            border-color: rgba(13,148,136,0.55) !important;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.1) !important;
        }

        .pse-list {
            padding: 0 26px 20px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .pse-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            margin-bottom: 10px;
            background: rgba(255,255,255,0.6);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .pse-item:hover {
            background: rgba(255,255,255,0.8);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .pse-item.active {
            background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08));
            border-color: rgba(13,148,136,0.2);
        }

        .pse-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: linear-gradient(180deg, #0d9488, #0891b2);
            border-radius: 0 2px 2px 0;
        }

        .pse-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pse-avatar svg {
            width: 20px;
            height: 20px;
            stroke: white;
            stroke-width: 2;
        }

        .pse-info {
            flex-grow: 1;
            min-width: 0;
        }

        .pse-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pse-details {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-tertiary);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pse-empty {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-tertiary);
            font-size: 14px;
            font-weight: 500;
        }

        /* Floating Navigation */
        .floating-nav {
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 50;
            display: flex;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            border: 1px solid rgba(255,255,255,0.88);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 8px 24px rgba(0,0,0,0.08);
            font-family: 'DM Sans', -apple-system, sans-serif;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 10px 16px;
            border-radius: 16px;
            text-decoration: none;
            color: rgba(15,15,25,0.68);
            transition: all 0.2s ease;
            position: relative;
            min-width: 64px;
        }

        .nav-item:hover {
            background: rgba(37,99,235,0.08);
            color: #2563eb;
            transform: translateY(-2px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(37,99,235,0.12), rgba(99,102,241,0.08));
            color: #2563eb;
            font-weight: 600;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 32px;
            height: 3px;
            background: linear-gradient(90deg, #2563eb, #6366f1);
            border-radius: 2px;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
        }

        .nav-label {
            font-size: 11px;
            font-weight: 500;
            text-align: center;
            line-height: 1.2;
        }

        @media (max-width: 768px) {
            .pse-list-root { padding: 20px 16px 100px; }
            .floating-nav {
                bottom: 20px;
                left: 20px;
                right: 20px;
                transform: none;
                padding: 10px;
                gap: 8px;
                border-radius: 20px;
            }
            
            .nav-item {
                padding: 8px 12px;
                min-width: 56px;
            }
            
            .nav-icon {
                width: 18px;
                height: 18px;
            }
            
            .nav-label {
                font-size: 10px;
            }
        }
    </style>

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="pse-header">
            <h2>Payslip Entries</h2>
            <p>Manage employee payslip records</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="g-card anim-2">
        <div class="pse-search">
            <input 
                type="text" 
                class="pse-search-input" 
                placeholder="Search payslip entries..."
                wire:model.live="search"
            >
        </div>
    </div>

    {{-- List --}}
    <div class="pse-list" wire:poll>
        @forelse($this->payslipEntries as $index => $payslipEntry)
            <div 
                class="pse-item {{ $selectedId === $payslipEntry->id ? 'active' : '' }}"
                wire:click.prevent="dispatchSelectPayslipEntry('{{ $payslipEntry->id }}')"
                wire:key="{{ $payslipEntry->id }}"
            >
                <div class="pse-avatar">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="pse-info">
                    <p class="pse-name">{{ $payslipEntry->employee->first_name }} {{ $payslipEntry->employee->last_name }}</p>
                    <p class="pse-details">{{ $payslipEntry->employee->code }} • {{ $payslipEntry->payrollMonth->name }}</p>
                </div>
            </div>
        @empty
            <div class="pse-empty">
                <p>No payslip entries found</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div wire:key="payslipEntries-pagination">
        {{ $this->payslipEntries->links() }}
    </div>
</div>

<div class="floating-nav">
    <a href="{{ route('payroll.dashboard') }}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        <span class="nav-label">Dashboard</span>
    </a>
    
    <a href="{{ route('payroll.payslip-generator') }}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        <span class="nav-label">Payslips</span>
    </a>
    
    <a href="{{ route('payroll.tax-calculator') }}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
        <span class="nav-label">Tax Calc</span>
    </a>
</div>
