<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.pse-root {
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
}

@keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.anim-1 { animation: fadeSlideUp 0.35s ease both; }

.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    position: relative;
    padding: 28px 30px 32px;
}
.g-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
    border-radius: var(--radius) var(--radius) 0 0;
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

/* Fieldset legend override */
.g-card legend,
.g-card [data-flux-legend] {
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.1em !important;
    color: var(--text-tertiary) !important;
    margin-bottom: 20px !important;
    font-family: 'DM Sans', sans-serif !important;
}

/* Flux input override — glass style */
.g-card [data-flux-input] input,
.g-card input[wire\:model\\.blur],
.g-card input[type="text"],
.g-card input[type="number"],
.g-card input[type="email"],
.g-card textarea,
.g-card select {
    background: rgba(255,255,255,0.78) !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    border-radius: var(--radius-sm) !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
    transition: border-color 0.15s, box-shadow 0.15s !important;
}
.g-card input:focus,
.g-card textarea:focus,
.g-card select:focus {
    border-color: rgba(13,148,136,0.55) !important;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1) !important;
    background: rgba(255,255,255,0.96) !important;
    outline: none !important;
}

/* Dirty state */
.g-card .border-yellow,
.g-card [class*="border-yellow"] {
    border-color: rgba(245,158,11,0.6) !important;
    box-shadow: 0 0 0 3px rgba(245,158,11,0.1) !important;
}

/* Flux label override */
.g-card label,
.g-card [data-flux-label] {
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.07em !important;
    color: var(--text-tertiary) !important;
    font-family: 'DM Sans', sans-serif !important;
    margin-bottom: 5px !important;
}

/* Badge (Required) */
.g-card [data-flux-badge],
.g-card .badge {
    font-size: 10px !important;
    font-weight: 700 !important;
    background: rgba(13,148,136,0.12) !important;
    color: #0d9488 !important;
    border-radius: 99px !important;
    padding: 2px 8px !important;
}

/* Fields wrap */
.pse-fields {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

@media (max-width: 768px) {
    .pse-root { padding: 18px 14px 100px; }
    .pse-fields > * { width: 100% !important; }
}
</style>

<div class="pse-root">
    <div class="g-card anim-1">
        <flux:fieldset class="px-0">
            <flux:legend>PayslipEntry</flux:legend>

            @if($errors->any())
                <div style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.22);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:600;color:#b91c1c;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="pse-fields">

                <!-- Code -->
                <flux:input
                    wire:model.blur="form.code"
                    label="Code"
                    readonly
                    copyable
                    class="!w-[200px]"
                />

                <!-- First Name -->
                <flux:input
                    badge="Required"
                    wire:model.blur="form.first_name"
                    wire:dirty.class="border-yellow"
                    label="First Name"
                    required
                    class="!w-[300px]"
                />

            </div>
        </flux:fieldset>
    </div>
</div>

{{-- Delete confirmation modal --}}
<flux:modal name="DeleteConfirm" :dismissible="false">
    <div style="padding:4px;">
        <div style="margin-bottom:20px;">
            <flux:heading size="lg">Delete Payslip Entry</flux:heading>
            <flux:text style="margin-top:8px;font-size:13.5px;color:rgba(15,15,25,0.68);line-height:1.6;">
                <p>Are you sure you want to delete <strong style="color:#0d9488;">{{ $form->code }}</strong>?</p>
                <p style="margin-top:4px;">This action is permanent and cannot be undone.</p>
            </flux:text>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;">
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button wire:click="deletePayslipEntry" variant="danger">Delete</flux:button>
        </div>
    </div>
</flux:modal>

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