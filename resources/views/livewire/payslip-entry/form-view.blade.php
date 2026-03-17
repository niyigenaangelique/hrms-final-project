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

</div>