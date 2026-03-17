<div class="prof-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

/* ── Variables ────────────────────────────────────────── */
.prof-root {
    --glass-bg:        rgba(255,255,255,0.45);
    --glass-strong:    rgba(255,255,255,0.65);
    --glass-border:    rgba(255,255,255,0.65);
    --glass-shadow:    0 8px 32px rgba(0,0,0,0.07), 0 2px 8px rgba(0,0,0,0.04);
    --blur:            blur(24px) saturate(1.8);
    --radius:          20px;
    --radius-sm:       12px;
    --radius-pill:     100px;
    --text-primary:    rgba(15,15,25,0.96);
    --text-secondary:  rgba(15,15,25,0.72);
    --text-tertiary:   rgba(15,15,25,0.50);
    --teal:            #0d9488;
    --teal-light:      rgba(13,148,136,0.12);
    --blue:            #2563eb;
    --blue-light:      rgba(37,99,235,0.12);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 36px 40px 100px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

/* ── Glass card base ──────────────────────────────────── */
.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    position: relative;
}

.g-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

/* ── Flash message ────────────────────────────────────── */
.prof-flash {
    background: rgba(34,197,94,0.12);
    border: 1px solid rgba(34,197,94,0.3);
    border-radius: var(--radius-sm);
    padding: 12px 18px;
    color: #15803d;
    font-size: 15px;
    font-weight: 600;
    backdrop-filter: var(--blur);
}

/* ── Profile header ───────────────────────────────────── */
.prof-header {
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

.prof-header-left { display: flex; align-items: center; gap: 20px; }

.prof-avatar-wrap { position: relative; flex-shrink: 0; }

.prof-avatar {
    width: 72px; height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.8);
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

.prof-avatar-placeholder {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 600; color: #fff;
    border: 3px solid rgba(255,255,255,0.8);
    box-shadow: 0 4px 16px rgba(13,148,136,0.35);
}

.prof-avatar-btn {
    position: absolute;
    bottom: 0; right: 0;
    width: 26px; height: 26px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    border: 2px solid rgba(255,255,255,0.9);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(13,148,136,0.4);
    transition: transform 0.15s;
}

.prof-avatar-btn:hover { transform: scale(1.1); }
.prof-avatar-btn svg { width: 12px; height: 12px; stroke: #fff; }

.prof-name {
    font-size: 28px; font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.4px;
    margin: 0 0 4px;
}

.prof-role {
    font-size: 15px; font-weight: 500; color: var(--text-secondary);
    margin: 0 0 8px;
}

.prof-meta {
    display: flex; gap: 16px; flex-wrap: wrap;
}

.prof-meta-item {
    font-size: 13px; font-weight: 500; color: var(--text-tertiary);
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.7);
    border-radius: var(--radius-pill);
    padding: 3px 12px;
    backdrop-filter: var(--blur);
}

.prof-actions { display: flex; gap: 10px; flex-shrink: 0; }

.btn-primary {
    padding: 10px 20px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(13,148,136,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(13,148,136,0.4);
}

.btn-ghost {
    padding: 10px 20px;
    background: rgba(255,255,255,0.55);
    color: var(--text-secondary);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    cursor: pointer;
    backdrop-filter: var(--blur);
    transition: background 0.15s;
}

.btn-ghost:hover { background: rgba(255,255,255,0.8); }

/* ── Tabs ─────────────────────────────────────────────── */
.prof-tabs-wrap {
    border-bottom: 1px solid rgba(0,0,0,0.06);
    padding: 0 28px;
}

.prof-tabs {
    display: flex;
    gap: 4px;
    overflow-x: auto;
}

.prof-tab {
    padding: 14px 18px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    color: var(--text-tertiary);
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: color 0.15s, border-color 0.15s;
    margin-bottom: -1px;
}

.prof-tab:hover { color: var(--text-secondary); }

.prof-tab.active {
    color: var(--teal);
    border-bottom-color: var(--teal);
}

/* ── Tab content ──────────────────────────────────────── */
.prof-tab-body { padding: 28px 32px; }

/* ── Section headings ─────────────────────────────────── */
.prof-section-title {
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--text-tertiary);
    margin: 0 0 16px;
}

/* ── Info grid ────────────────────────────────────────── */
.prof-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap: 20px;
}

.prof-info-item label {
    display: block;
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.06em;
    color: var(--text-tertiary);
    margin-bottom: 4px;
}

.prof-info-item p {
    font-size: 14px; font-weight: 500;
    color: var(--text-primary);
    margin: 0;
}

.col-span-2 { grid-column: span 2; }

/* ── Info section card ────────────────────────────────── */
.prof-section {
    background: rgba(255,255,255,0.82);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius-sm);
    padding: 22px;
    margin-bottom: 16px;
    backdrop-filter: var(--blur);
}

/* ── Quick stats ──────────────────────────────────────── */
.prof-stats {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.prof-stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: rgba(255,255,255,0.82);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius-sm);
    backdrop-filter: var(--blur);
}

.prof-stat-label { font-size: 15px; font-weight: 600; color: var(--text-secondary); }
.prof-stat-value { font-size: 18px; font-weight: 700; color: var(--text-primary); }

/* ── Contract / history items ─────────────────────────── */
.prof-item {
    background: rgba(255,255,255,0.82);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius-sm);
    padding: 18px 22px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    backdrop-filter: var(--blur);
    transition: box-shadow 0.15s;
}

.prof-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }

.prof-item-title { font-size: 17px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.prof-item-sub   { font-size: 14px; font-weight: 500; color: var(--text-secondary); margin: 0 0 2px; }
.prof-item-meta  { font-size: 13px; font-weight: 500; color: var(--text-tertiary); margin: 0; }

/* ── Status badges ────────────────────────────────────── */
.badge {
    font-size: 13px; font-weight: 700;
    padding: 4px 11px; border-radius: var(--radius-pill);
    flex-shrink: 0;
}

.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-gray   { background: rgba(0,0,0,0.07);       color: var(--text-secondary); }
.badge-blue   { background: rgba(37,99,235,0.12);   color: #1d4ed8; }

/* ── Document cards ───────────────────────────────────── */
.prof-docs-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 12px;
}

.prof-doc-card {
    background: rgba(255,255,255,0.82);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius-sm);
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    backdrop-filter: var(--blur);
    transition: box-shadow 0.15s;
}

.prof-doc-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }

.prof-doc-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(37,99,235,0.1);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.prof-doc-icon svg { width: 18px; height: 18px; stroke: #2563eb; }

.prof-doc-name { font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0 0 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.prof-doc-date { font-size: 13px; font-weight: 500; color: var(--text-tertiary); margin: 0; }

.prof-doc-del { margin-left: auto; background: none; border: none; cursor: pointer; color: rgba(239,68,68,0.5); transition: color 0.15s; padding: 4px; flex-shrink: 0; }
.prof-doc-del:hover { color: #dc2626; }
.prof-doc-del svg { width: 15px; height: 15px; }

/* ── History timeline ─────────────────────────────────── */
.prof-timeline-item {
    display: flex;
    gap: 16px;
    padding-bottom: 20px;
    position: relative;
}

.prof-timeline-item::before {
    content: '';
    position: absolute;
    left: 7px; top: 22px; bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, rgba(13,148,136,0.4), transparent);
}

.prof-timeline-item:last-child::before { display: none; }

.prof-timeline-dot {
    width: 16px; height: 16px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    flex-shrink: 0;
    margin-top: 4px;
    box-shadow: 0 0 0 4px rgba(13,148,136,0.15);
}

/* ── Toolbar (Upload / Add buttons) ──────────────────── */
.prof-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

/* ── Empty state ──────────────────────────────────────── */
.prof-empty {
    text-align: center;
    padding: 48px 24px;
    color: var(--text-tertiary);
    font-size: 14px;
}

/* ── Modal backdrop ───────────────────────────────────── */
.prof-modal-bg {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    backdrop-filter: blur(8px);
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: center;
}

.prof-modal {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(32px) saturate(1.8);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius);
    box-shadow: 0 32px 80px rgba(0,0,0,0.2);
    padding: 28px 32px;
    width: 100%;
    max-width: 440px;
    position: relative;
}

.prof-modal-title {
    font-size: 20px; font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 20px;
}

.prof-field { margin-bottom: 16px; }

.prof-field label {
    display: block;
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.06em;
    color: var(--text-tertiary);
    margin-bottom: 6px;
}

.prof-field input {
    width: 100%;
    padding: 10px 14px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 500;
    color: var(--text-primary);
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
}

.prof-field input:focus {
    border-color: rgba(13,148,136,0.5);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
}

.prof-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.btn-cancel {
    padding: 9px 18px;
    background: rgba(0,0,0,0.06);
    color: var(--text-secondary);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
}

.btn-cancel:hover { background: rgba(0,0,0,0.1); }

/* ── Error text ───────────────────────────────────────── */
.prof-error { font-size: 13px; color: #dc2626; margin-top: 4px; }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1024px) {
    .prof-root { padding: 20px 16px 120px; }
    .prof-overview-grid { grid-template-columns: 1fr !important; }
    .prof-docs-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .prof-header { flex-direction: column; align-items: flex-start; }
    .prof-info-grid { grid-template-columns: 1fr; }
    .prof-docs-grid { grid-template-columns: 1fr; }
    .col-span-2 { grid-column: span 1; }
}

/* ── Floating nav bar ─────────────────────────────────── */
.ios-nav {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 100;
    display: flex;
    align-items: center;
    gap: 2px;
    background: rgba(15, 15, 25, 0.75);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: 28px;
    padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}

.ios-nav::before {
    content: '';
    position: absolute;
    top: 0; left: 16px; right: 16px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
}

.ios-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    padding: 8px 18px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 10px;
    font-weight: 500;
    color: rgba(255,255,255,0.45);
    letter-spacing: 0.03em;
    min-width: 64px;
    position: relative;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.ios-nav-item svg {
    width: 20px; height: 20px;
    stroke: currentColor;
    transition: transform 0.2s;
}

.ios-nav-item:hover {
    color: rgba(255,255,255,0.85);
    background: rgba(255,255,255,0.08);
    transform: translateY(-1px);
}

.ios-nav-item:hover svg { transform: scale(1.1); }

.ios-nav-item.active {
    color: #fff;
    background: rgba(255,255,255,0.15);
}

.ios-nav-item.active svg { stroke: #60a5fa; }

.ios-nav-active-dot {
    position: absolute;
    bottom: 4px;
    width: 4px; height: 4px;
    border-radius: 50%;
    background: #60a5fa;
}

.ios-notif-bubble {
    position: absolute;
    top: 5px; right: 10px;
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #ef4444;
    border: 1.5px solid rgba(15,15,25,0.75);
}
</style>

{{-- Flash message --}}
@if(session()->has('message'))
    <div class="prof-flash">{{ session('message') }}</div>
@endif

{{-- ── Profile Header ────────────────────────────────── --}}
<div class="g-card">
    <div class="prof-header">
        <div class="prof-header-left">
            <div class="prof-avatar-wrap">
                @if($employee->profile_photo)
                    <img src="{{ asset('storage/' . $employee->profile_photo) }}"
                         alt="{{ $employee->full_name }}"
                         class="prof-avatar">
                @else
                    <div class="prof-avatar-placeholder">
                        {{ substr($employee->first_name,0,1) . substr($employee->last_name,0,1) }}
                    </div>
                @endif
                <button class="prof-avatar-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
            </div>
            <div>
                <h1 class="prof-name">{{ $employee->full_name }}</h1>
                <p class="prof-role">{{ $employee->position->name ?? 'No Position' }} · {{ $employee->department->name ?? 'No Department' }}</p>
                <div class="prof-meta">
                    <span class="prof-meta-item">{{ $employee->employee_number ?? $employee->code }}</span>
                    <span class="prof-meta-item">Joined {{ $employee->join_date ? $employee->join_date->format('M Y') : '—' }}</span>
                </div>
            </div>
        </div>
        <div class="prof-actions">
            <button class="btn-primary">Edit Profile</button>
            <button class="btn-ghost">Export</button>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="prof-tabs-wrap">
        <div class="prof-tabs">
            <button wire:click="setActiveTab('overview')"
                    class="prof-tab {{ $activeTab === 'overview' ? 'active' : '' }}">Overview</button>
            <button wire:click="setActiveTab('contracts')"
                    class="prof-tab {{ $activeTab === 'contracts' ? 'active' : '' }}">Contracts</button>
            <button wire:click="setActiveTab('documents')"
                    class="prof-tab {{ $activeTab === 'documents' ? 'active' : '' }}">Documents</button>
            <button wire:click="setActiveTab('emergency')"
                    class="prof-tab {{ $activeTab === 'emergency' ? 'active' : '' }}">Emergency Contacts</button>
            <button wire:click="setActiveTab('history')"
                    class="prof-tab {{ $activeTab === 'history' ? 'active' : '' }}">Employment History</button>
        </div>
    </div>

    {{-- Tab body --}}
    <div class="prof-tab-body">

        {{-- ── Overview ──────────────────────────────── --}}
        @if($activeTab === 'overview')
            <div class="prof-overview-grid" style="display:grid; grid-template-columns: 1fr 300px; gap: 20px;">
                <div>
                    <div class="prof-section">
                        <div class="prof-section-title">Personal Information</div>
                        <div class="prof-info-grid">
                            <div class="prof-info-item">
                                <label>First Name</label>
                                <p>{{ $employee->first_name }}</p>
                            </div>
                            <div class="prof-info-item">
                                <label>Last Name</label>
                                <p>{{ $employee->last_name }}</p>
                            </div>
                            <div class="prof-info-item">
                                <label>Gender</label>
                                <p>{{ ucfirst($employee->gender) }}</p>
                            </div>
                            <div class="prof-info-item">
                                <label>Date of Birth</label>
                                <p>{{ $employee->birth_date ? $employee->birth_date->format('M d, Y') : '—' }}</p>
                            </div>
                            <div class="prof-info-item">
                                <label>Nationality</label>
                                <p>{{ $employee->nationality ?? '—' }}</p>
                            </div>
                            <div class="prof-info-item">
                                <label>National ID</label>
                                <p>{{ $employee->national_id ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="prof-section">
                        <div class="prof-section-title">Contact Information</div>
                        <div class="prof-info-grid">
                            <div class="prof-info-item">
                                <label>Email</label>
                                <p>{{ $employee->email }}</p>
                            </div>
                            <div class="prof-info-item">
                                <label>Phone</label>
                                <p>{{ $employee->phone_number ?? '—' }}</p>
                            </div>
                            <div class="prof-info-item col-span-2">
                                <label>Address</label>
                                <p>{{ implode(', ', array_filter([$employee->address, $employee->city, $employee->state, $employee->country])) ?: '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick stats sidebar --}}
                <div class="prof-stats">
                    <div class="prof-section-title" style="padding-left:4px">Quick Stats</div>
                    <div class="prof-stat-row">
                        <span class="prof-stat-label">Years of Service</span>
                        <span class="prof-stat-value">{{ $employee->join_date ? $employee->join_date->diffInYears(now()) : '0' }} yrs</span>
                    </div>
                    <div class="prof-stat-row">
                        <span class="prof-stat-label">Active Contracts</span>
                        <span class="prof-stat-value">{{ $contracts->where('status', 'active')->count() }}</span>
                    </div>
                    <div class="prof-stat-row">
                        <span class="prof-stat-label">Documents</span>
                        <span class="prof-stat-value">{{ $documents->count() }}</span>
                    </div>
                    <div class="prof-stat-row">
                        <span class="prof-stat-label">Emergency Contacts</span>
                        <span class="prof-stat-value">{{ $emergencyContacts->count() }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Contracts ─────────────────────────────── --}}
        @if($activeTab === 'contracts')
            <div style="display:flex; flex-direction:column; gap:12px;">
                @if($contracts->isNotEmpty())
                    @foreach($contracts as $contract)
                        <div class="prof-item">
                            <div>
                                <p class="prof-item-title">{{ $contract->contract_type ?? 'Employment Contract' }}</p>
                                <p class="prof-item-sub">
                                    {{ $contract->start_date->format('M d, Y') }} —
                                    {{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'Present' }}
                                </p>
                                <p class="prof-item-meta">{{ $contract->position->name ?? 'Position not specified' }}</p>
                            </div>
                            @php $s = $contract->status->value ?? 'unknown'; @endphp
                            <span class="badge {{ $s === 'active' ? 'badge-green' : 'badge-gray' }}">
                                {{ ucfirst($s) }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="prof-empty">No contracts found</div>
                @endif
            </div>
        @endif

        {{-- ── Documents ─────────────────────────────── --}}
        @if($activeTab === 'documents')
            <div class="prof-toolbar">
                <div class="prof-section-title" style="margin:0">Documents</div>
                <button class="btn-primary" wire:click="showDocumentModal = true; showContactModal = false">
                    Upload Document
                </button>
            </div>
            @if($documents->isNotEmpty())
                <div class="prof-docs-grid">
                    @foreach($documents as $document)
                        <div class="prof-doc-card">
                            <div class="prof-doc-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div style="flex:1; min-width:0;">
                                <p class="prof-doc-name">{{ $document->name }}</p>
                                <p class="prof-doc-date">{{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <button class="prof-doc-del" wire:click="deleteDocument({{ $document->id }})">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="prof-empty">No documents uploaded yet</div>
            @endif
        @endif

        {{-- ── Emergency Contacts ────────────────────── --}}
        @if($activeTab === 'emergency')
            <div class="prof-toolbar">
                <div class="prof-section-title" style="margin:0">Emergency Contacts</div>
                <button class="btn-primary" wire:click="showDocumentModal = false; showContactModal = true">
                    Add Contact
                </button>
            </div>
            <div style="display:flex; flex-direction:column; gap:12px;">
                @if($emergencyContacts->isNotEmpty())
                    @foreach($emergencyContacts as $contact)
                        <div class="prof-item">
                            <div>
                                <p class="prof-item-title">{{ $contact->name }}</p>
                                <p class="prof-item-sub">{{ $contact->relationship }}</p>
                                <p class="prof-item-meta">{{ $contact->phone }}</p>
                            </div>
                            <div style="display:flex; gap:8px; flex-shrink:0;">
                                <button class="btn-ghost" style="padding:6px 14px; font-size:12px;">Edit</button>
                                <button wire:click="deleteEmergencyContact({{ $contact->id }})"
                                        class="badge badge-gray" style="cursor:pointer; border:none; font-size:12px; padding:6px 14px; border-radius:8px;">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="prof-empty">No emergency contacts added</div>
                @endif
            </div>
        @endif

        {{-- ── Employment History ────────────────────── --}}
        @if($activeTab === 'history')
            <div class="prof-section-title">Employment History</div>
            @if($employmentHistory->isNotEmpty())
                <div style="padding-left: 8px;">
                    @foreach($employmentHistory as $item)
                        <div class="prof-timeline-item">
                            <div class="prof-timeline-dot"></div>
                            <div class="prof-item" style="flex:1; margin-bottom:0;">
                                <div>
                                    <p class="prof-item-title">{{ $item['title'] }}</p>
                                    <p class="prof-item-sub">{{ $item['company'] }}</p>
                                    <p class="prof-item-meta">{{ $item['period'] }} · {{ $item['type'] }}</p>
                                    @if(!empty($item['description']))
                                        <p class="prof-item-meta" style="margin-top:6px;">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="prof-empty">No employment history available</div>
            @endif
        @endif

    </div>{{-- /prof-tab-body --}}
</div>{{-- /g-card --}}

{{-- ── Document Upload Modal ────────────────────────── --}}
@if($showDocumentModal)
<div class="prof-modal-bg">
    <div class="prof-modal">
        <h3 class="prof-modal-title">Upload Document</h3>
        <form wire:submit="uploadDocument">
            <div class="prof-field">
                <label>Document Name</label>
                <input type="text" wire:model="documentName" required>
                @error('documentName') <span class="prof-error">{{ $message }}</span> @enderror
            </div>
            <div class="prof-field">
                <label>File</label>
                <input type="file" wire:model="documentFile" required>
                @error('documentFile') <span class="prof-error">{{ $message }}</span> @enderror
            </div>
            <div class="prof-modal-footer">
                <button type="button" class="btn-cancel" wire:click="showDocumentModal = false">Cancel</button>
                <button type="submit" class="btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ── Emergency Contact Modal ──────────────────────── --}}
@if($showContactModal)
<div class="prof-modal-bg">
    <div class="prof-modal">
        <h3 class="prof-modal-title">Add Emergency Contact</h3>
        <form wire:submit="addEmergencyContact">
            <div class="prof-field">
                <label>Name</label>
                <input type="text" wire:model="contactName" required>
                @error('contactName') <span class="prof-error">{{ $message }}</span> @enderror
            </div>
            <div class="prof-field">
                <label>Relationship</label>
                <input type="text" wire:model="contactRelationship" required>
                @error('contactRelationship') <span class="prof-error">{{ $message }}</span> @enderror
            </div>
            <div class="prof-field">
                <label>Phone</label>
                <input type="text" wire:model="contactPhone" required>
                @error('contactPhone') <span class="prof-error">{{ $message }}</span> @enderror
            </div>
            <div class="prof-field">
                <label>Email (Optional)</label>
                <input type="email" wire:model="contactEmail">
                @error('contactEmail') <span class="prof-error">{{ $message }}</span> @enderror
            </div>
            <div class="prof-modal-footer">
                <button type="button" class="btn-cancel" wire:click="showContactModal = false">Cancel</button>
                <button type="submit" class="btn-primary">Add Contact</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ── Floating iOS 26 nav bar ─────────────────────────── --}}
<nav class="ios-nav">
    <a href="{{ route('employee.dashboard') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
    </a>
    <a href="{{ route('employee.profile') }}" class="ios-nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0114 0"/></svg>
        Profile
        <span class="ios-nav-active-dot"></span>
    </a>
    <a href="{{ route('employee.attendance') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Attendance
    </a>
    <a href="{{ route('employee.leave.request') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Leave
    </a>
    <a href="{{ route('employee.calendar') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Calendar
    </a>
    <a href="#" class="ios-nav-item" style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Alerts
    </a>
</nav>

</div>{{-- /prof-root --}}