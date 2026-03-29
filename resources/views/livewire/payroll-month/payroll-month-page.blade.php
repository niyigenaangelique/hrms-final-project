<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.ppm-root {
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
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }
.anim-3 { animation: fadeSlideUp 0.35s 0.14s ease both; }

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

.ppm-header {
    padding: 24px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.ppm-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.4px;
    margin: 0 0 3px;
}

.ppm-header p {
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-secondary);
    margin: 0;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 16px;
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(37,99,235,0.3);
    transition: transform .15s,box-shadow .15s;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(37,99,235,0.4);
}

.btn-primary svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
}

.flash-ok {
    background: rgba(34,197,94,0.1);
    border: 1px solid rgba(34,197,94,0.28);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #15803d;
    margin-bottom: 4px;
}

.flash-err {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.22);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #b91c1c;
    margin-bottom: 4px;
}

.ppm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.ppm-card {
    background: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    padding: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.ppm-card:hover {
    background: rgba(255,255,255,0.8);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.ppm-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
    gap: 12px;
}

.ppm-card-title h3 {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.ppm-card-title p {
    font-size: 12px;
    font-weight: 500;
    color: var(--text-tertiary);
    margin: 0;
}

.ppm-status {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 600;
    flex-shrink: 0;
}

.ppm-status.active {
    background: rgba(34,197,94,0.12);
    color: #15803d;
}

.ppm-status.locked {
    background: rgba(245,158,11,0.12);
    color: #b45309;
}

.ppm-status svg {
    width: 12px;
    height: 12px;
}

.ppm-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 16px;
}

.ppm-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}

.ppm-detail-label {
    color: var(--text-tertiary);
    font-weight: 500;
}

.ppm-detail-value {
    color: var(--text-primary);
    font-weight: 600;
}

.ppm-actions {
    display: flex;
    gap: 8px;
}

.ppm-btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.ppm-btn svg {
    width: 12px;
    height: 12px;
}

.ppm-btn-edit {
    background: rgba(37,99,235,0.1);
    color: #2563eb;
}

.ppm-btn-edit:hover {
    background: rgba(37,99,235,0.2);
}

.ppm-btn-delete {
    background: rgba(239,68,68,0.1);
    color: #b91c1c;
}

.ppm-btn-delete:hover {
    background: rgba(239,68,68,0.2);
}

.ppm-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 40px;
    background: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius);
}

.ppm-empty-icon {
    width: 64px;
    height: 64px;
    background: rgba(0,0,0,0.05);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.ppm-empty-icon svg {
    width: 32px;
    height: 32px;
    stroke: var(--text-tertiary);
}

.ppm-empty h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 8px;
}

.ppm-empty p {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-secondary);
    margin: 0 0 20px;
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
    .ppm-root { padding: 18px 14px 100px; }
    .ppm-header { flex-direction: column; align-items: flex-start; }
    .ppm-grid { grid-template-columns: 1fr; }
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

<div class="ppm-root">

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="ppm-header">
            <div>
                <h1>Payroll Months</h1>
                <p>Manage payroll periods and generate entries</p>
            </div>
            <div>
                <button wire:click="createMonth" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create Month
                </button>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <div class="flash-ok anim-2">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="flash-err anim-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- Payroll Months Grid --}}
    <div class="ppm-grid anim-3">
        @forelse(App\Models\PayrollMonth::withCount('payrollEntries')->orderBy('start_date', 'desc')->get() as $month)
            <div class="ppm-card" wire:click="editMonth('{{ $month->id }}')">
                <div class="ppm-card-header">
                    <div class="ppm-card-title">
                        <h3>{{ $month->name }}</h3>
                        <p>{{ $month->description }}</p>
                    </div>
                    <div class="ppm-status {{ $month->is_locked ? 'locked' : 'active' }}">
                        @if($month->is_locked)
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4"/>
                            </svg>
                            Locked
                        @else
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4"/>
                            </svg>
                            Active
                        @endif
                    </div>
                </div>
                
                <div class="ppm-details">
                    <div class="ppm-detail-row">
                        <span class="ppm-detail-label">Period:</span>
                        <span class="ppm-detail-value">
                            {{ Carbon\Carbon::parse($month->start_date)->format('M d') }} - 
                            {{ Carbon\Carbon::parse($month->end_date)->format('M d, Y') }}
                        </span>
                    </div>
                    <div class="ppm-detail-row">
                        <span class="ppm-detail-label">Code:</span>
                        <span class="ppm-detail-value">{{ $month->code }}</span>
                    </div>
                    <div class="ppm-detail-row">
                        <span class="ppm-detail-label">Entries:</span>
                        <span class="ppm-detail-value">{{ $month->payroll_entries_count }}</span>
                    </div>
                </div>
                
                <div class="ppm-actions">
                    <button wire:click.stop="editMonth('{{ $month->id }}')" class="ppm-btn ppm-btn-edit">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                    </button>
                    <button wire:click.stop="deleteMonth('{{ $month->id }}')" class="ppm-btn ppm-btn-delete">
                        <svg viewBox="0 0 24 24" fill="none">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="ppm-empty">
                <div class="ppm-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>
                <h3>No payroll months found</h3>
                <p>Create your first payroll period to get started.</p>
                <button wire:click="createMonth" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create First Month
                </button>
            </div>
        @endforelse
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


    {{-- ── Create Modal ──────────────────────────────── --}}
    @if($showCreateModal)
        <div style="position:fixed;inset:0;z-index:60;background:rgba(0,0,0,0.28);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;padding:24px;" wire:click="$set('showCreateModal', false)">
            <div style="background:rgba(255,255,255,0.97);border-radius:20px;box-shadow:0 32px 80px rgba(0,0,0,0.18);width:100%;max-width:480px;" wire:click.stop>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:20px 24px 16px;border-bottom:1px solid rgba(0,0,0,0.06);">
                    <h3 style="font-size:18px;font-weight:700;color:var(--text-primary);margin:0;">New Payroll Month</h3>
                    <button wire:click="$set('showCreateModal', false)" style="width:30px;height:30px;border-radius:50%;background:rgba(0,0,0,0.06);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div style="padding:20px 24px;display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">Name</label>
                        <input wire:model="name" type="text" placeholder="e.g. January 2025"
                            style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;"/>
                        @error('name') <span style="font-size:11px;font-weight:600;color:#dc2626;">{{ $message }}</span> @enderror
                    </div>
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">Description (optional)</label>
                        <textarea wire:model="description" placeholder="Any notes about this period..."
                            style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;resize:vertical;min-height:72px;"></textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div style="display:flex;flex-direction:column;gap:5px;">
                            <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">Start Date</label>
                            <input wire:model="start_date" type="date"
                                style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;"/>
                            @error('start_date') <span style="font-size:11px;font-weight:600;color:#dc2626;">{{ $message }}</span> @enderror
                        </div>
                        <div style="display:flex;flex-direction:column;gap:5px;">
                            <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">End Date</label>
                            <input wire:model="end_date" type="date"
                                style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;"/>
                            @error('end_date') <span style="font-size:11px;font-weight:600;color:#dc2626;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div style="padding:16px 24px 22px;border-top:1px solid rgba(0,0,0,0.06);display:flex;justify-content:flex-end;gap:10px;">
                    <button wire:click="$set('showCreateModal', false)" style="padding:10px 18px;background:rgba(0,0,0,0.06);color:rgba(15,15,25,0.68);border:none;border-radius:13px;font-size:14px;font-weight:600;cursor:pointer;">Cancel</button>
                    <button wire:click="storeMonth" style="padding:10px 22px;background:linear-gradient(135deg,#0d9488,#0891b2);color:#fff;border:none;border-radius:13px;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(13,148,136,0.3);">Create Month</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Edit Modal ────────────────────────────────── --}}
    @if($showEditModal)
        <div style="position:fixed;inset:0;z-index:60;background:rgba(0,0,0,0.28);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;padding:24px;" wire:click="$set('showEditModal', false)">
            <div style="background:rgba(255,255,255,0.97);border-radius:20px;box-shadow:0 32px 80px rgba(0,0,0,0.18);width:100%;max-width:480px;" wire:click.stop>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:20px 24px 16px;border-bottom:1px solid rgba(0,0,0,0.06);">
                    <h3 style="font-size:18px;font-weight:700;color:var(--text-primary);margin:0;">Edit Payroll Month</h3>
                    <button wire:click="$set('showEditModal', false)" style="width:30px;height:30px;border-radius:50%;background:rgba(0,0,0,0.06);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div style="padding:20px 24px;display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">Name</label>
                        <input wire:model="name" type="text"
                            style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;"/>
                        @error('name') <span style="font-size:11px;font-weight:600;color:#dc2626;">{{ $message }}</span> @enderror
                    </div>
                    <div style="display:flex;flex-direction:column;gap:5px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">Description (optional)</label>
                        <textarea wire:model="description"
                            style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;resize:vertical;min-height:72px;"></textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div style="display:flex;flex-direction:column;gap:5px;">
                            <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">Start Date</label>
                            <input wire:model="start_date" type="date"
                                style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;"/>
                            @error('start_date') <span style="font-size:11px;font-weight:600;color:#dc2626;">{{ $message }}</span> @enderror
                        </div>
                        <div style="display:flex;flex-direction:column;gap:5px;">
                            <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-tertiary);">End Date</label>
                            <input wire:model="end_date" type="date"
                                style="padding:10px 14px;background:rgba(255,255,255,0.78);border:1px solid rgba(0,0,0,0.1);border-radius:13px;font-size:13.5px;font-weight:500;color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;"/>
                            @error('end_date') <span style="font-size:11px;font-weight:600;color:#dc2626;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div style="padding:16px 24px 22px;border-top:1px solid rgba(0,0,0,0.06);display:flex;justify-content:flex-end;gap:10px;">
                    <button wire:click="$set('showEditModal', false)" style="padding:10px 18px;background:rgba(0,0,0,0.06);color:rgba(15,15,25,0.68);border:none;border-radius:13px;font-size:14px;font-weight:600;cursor:pointer;">Cancel</button>
                    <button wire:click="updateMonth" style="padding:10px 22px;background:linear-gradient(135deg,#0d9488,#0891b2);color:#fff;border:none;border-radius:13px;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(13,148,136,0.3);">Save Changes</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Delete Modal ──────────────────────────────── --}}
    @if($showDeleteModal)
        <div style="position:fixed;inset:0;z-index:60;background:rgba(0,0,0,0.28);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;padding:24px;" wire:click="$set('showDeleteModal', false)">
            <div style="background:rgba(255,255,255,0.97);border-radius:20px;box-shadow:0 32px 80px rgba(0,0,0,0.18);width:100%;max-width:440px;" wire:click.stop>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:20px 24px 16px;border-bottom:1px solid rgba(0,0,0,0.06);">
                    <h3 style="font-size:18px;font-weight:700;color:var(--text-primary);margin:0;">Delete Payroll Month</h3>
                    <button wire:click="$set('showDeleteModal', false)" style="width:30px;height:30px;border-radius:50%;background:rgba(0,0,0,0.06);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div style="padding:20px 24px;">
                    <div style="background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.18);border-radius:13px;padding:14px 16px;font-size:13.5px;font-weight:500;color:#7f1d1d;line-height:1.6;">
                        This payroll month will be permanently deleted. If it has payroll entries, deletion will be blocked.
                    </div>
                </div>
                <div style="padding:0 24px 22px;display:flex;justify-content:flex-end;gap:10px;">
                    <button wire:click="$set('showDeleteModal', false)" style="padding:10px 18px;background:rgba(0,0,0,0.06);color:rgba(15,15,25,0.68);border:none;border-radius:13px;font-size:14px;font-weight:600;cursor:pointer;">Cancel</button>
                    <button wire:click="confirmDelete" style="padding:10px 22px;background:linear-gradient(135deg,#dc2626,#b91c1c);color:#fff;border:none;border-radius:13px;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(220,38,38,0.3);">Yes, Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>
