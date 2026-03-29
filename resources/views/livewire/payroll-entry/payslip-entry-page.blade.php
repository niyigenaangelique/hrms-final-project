<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.pse-main-root {
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
    padding: 32px 36px 110px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    height: 100vh;
    overflow-y: auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.pse-main-header {
    padding: 24px 30px;
    text-align: center;
}

.pse-main-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.4px;
    margin: 0 0 6px;
}

.pse-main-header p {
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-secondary);
    margin: 0;
}

.pse-content {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 20px;
    flex-grow: 1;
    min-height: 0;
}

.pse-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-height: 0;
}

.pse-main-area {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-height: 0;
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

@media (max-width: 1024px) {
    .pse-content { grid-template-columns: 1fr; }
    .pse-sidebar { order: 2; }
    .pse-main-area { order: 1; }
}

@media (max-width: 768px) {
    .pse-main-root { padding: 18px 14px 100px; }
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

<div class="pse-main-root">

    {{-- DEBUG MESSAGE - This should be visible if the file is loading --}}
    <div style="background: linear-gradient(135deg, #ff6b6b, #ee5a24); color: white; padding: 20px; border-radius: 15px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 18px; box-shadow: 0 10px 30px rgba(238, 90, 36, 0.3);">
        🔥 DESIGN UPDATE TEST - IF YOU SEE THIS, THE FILE IS LOADING! 🔥
    </div>

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="pse-main-header">
            <h1>Payslip Entry Management</h1>
            <p>Create, edit, and manage employee payslip entries</p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="pse-content anim-2">
        {{-- Sidebar - List View --}}
        <div class="pse-sidebar">
            <livewire:payslip_entry.list-view wire:debug="payslipEntry" />
        </div>

        {{-- Main Area - Form View --}}
        <div class="pse-main-area">
            <livewire:payslip_entry.form-view />
        </div>
    </div>

    {{-- Commands Section --}}
    @section('commands')
        <livewire:crud-commands model-type="PayslipEntry" />
    @endsection

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

</div>
