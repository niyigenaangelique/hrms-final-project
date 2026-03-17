<div class="perf-root">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

/* ── Variables ────────────────────────────────────────── */
.perf-root {
    --glass-bg:       rgba(255,255,255,0.45);
    --glass-strong:   rgba(255,255,255,0.65);
    --glass-border:   rgba(255,255,255,0.65);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(24px) saturate(1.8);
    --radius:         20px;
    --radius-sm:      12px;
    --radius-pill:    100px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.72);
    --text-tertiary:  rgba(15,15,25,0.50);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 36px 40px 120px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 100%;
}

/* ── Glass card ───────────────────────────────────────── */
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
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}

/* ── Page header ──────────────────────────────────────── */
.perf-header {
    padding: 28px 32px;
    display: flex; justify-content: space-between; align-items: center; gap: 20px;
}

.perf-header-text h1 {
    font-size: 28px; font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.4px; margin: 0 0 4px;
}

.perf-header-text p {
    font-size: 14px; font-weight: 500;
    color: var(--text-secondary); margin: 0;
}

.perf-header-actions { display: flex; gap: 10px; flex-shrink: 0; }

.btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #0d9488, #0891b2);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 600; cursor: pointer;
    box-shadow: 0 4px 14px rgba(13,148,136,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
}

.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(13,148,136,0.4); }
.btn-primary svg   { width: 15px; height: 15px; stroke: #fff; }

.btn-blue {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px;
    background: rgba(37,99,235,0.12);
    color: #2563eb; border: 1px solid rgba(37,99,235,0.2);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 600; cursor: pointer;
    transition: background 0.15s;
}

.btn-blue:hover { background: rgba(37,99,235,0.18); }
.btn-blue svg   { width: 15px; height: 15px; stroke: currentColor; }

/* ── Stat cards row ───────────────────────────────────── */
.perf-stats { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 14px; }

.perf-stat {
    background: var(--glass-strong);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    padding: 22px;
    display: flex; justify-content: space-between; align-items: flex-start;
    position: relative; overflow: hidden;
}

.perf-stat::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
}

.perf-stat-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-tertiary); margin-bottom: 8px; }
.perf-stat-value { font-size: 30px; font-weight: 700; color: var(--text-primary); line-height: 1; letter-spacing: -0.5px; }
.perf-stat-icon  { width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.perf-stat-icon svg { width: 20px; height: 20px; }

.si-blue   { background: rgba(37,99,235,0.12); }  .si-blue   svg { stroke: #2563eb; }
.si-green  { background: rgba(34,197,94,0.12); }  .si-green  svg { stroke: #16a34a; }
.si-amber  { background: rgba(245,158,11,0.12); } .si-amber  svg { stroke: #d97706; }

/* ── Section card header ──────────────────────────────── */
.s-head {
    padding: 22px 28px 0;
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 18px;
}

.s-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0; }

/* ── Review item ──────────────────────────────────────── */
.perf-item {
    margin: 0 16px 12px;
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.75);
    border-radius: var(--radius-sm);
    padding: 16px 20px;
    display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;
    transition: box-shadow 0.15s;
}

.perf-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
.perf-item:last-child { margin-bottom: 20px; }

.perf-item-title  { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.perf-item-sub    { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0 0 8px; }

/* ── Score badge ──────────────────────────────────────── */
.score-badge {
    display: inline-flex; font-size: 12px; font-weight: 700;
    padding: 4px 12px; border-radius: var(--radius-pill);
}

.score-5  { background: rgba(34,197,94,0.14);  color: #15803d; }
.score-4  { background: rgba(37,99,235,0.12);  color: #1d4ed8; }
.score-3  { background: rgba(245,158,11,0.14); color: #b45309; }
.score-low{ background: rgba(239,68,68,0.12);  color: #b91c1c; }

/* ── Status badges ────────────────────────────────────── */
.badge { display: inline-flex; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: var(--radius-pill); }
.badge-green  { background: rgba(34,197,94,0.14);  color: #15803d; }
.badge-blue   { background: rgba(37,99,235,0.12);  color: #1d4ed8; }
.badge-gray   { background: rgba(0,0,0,0.07);      color: var(--text-secondary); }
.badge-amber  { background: rgba(245,158,11,0.14); color: #b45309; }

/* ── Action link buttons ──────────────────────────────── */
.btn-link-blue  { font-size: 13px; font-weight: 600; color: #2563eb; background: rgba(37,99,235,0.08); border: none; border-radius: 8px; padding: 6px 14px; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.15s; }
.btn-link-blue:hover { background: rgba(37,99,235,0.15); }
.btn-link-green { font-size: 13px; font-weight: 600; color: #16a34a; background: rgba(34,197,94,0.08); border: none; border-radius: 8px; padding: 6px 14px; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.15s; }
.btn-link-green:hover { background: rgba(34,197,94,0.15); }

/* ── Goal item ────────────────────────────────────────── */
.goal-item {
    margin: 0 16px 12px;
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.75);
    border-radius: var(--radius-sm);
    padding: 16px 20px;
    transition: box-shadow 0.15s;
}

.goal-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
.goal-item:last-child { margin-bottom: 20px; }

.goal-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.goal-desc  { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0 0 10px; }

/* Progress bar */
.goal-progress-wrap { height: 6px; background: rgba(0,0,0,0.07); border-radius: 6px; overflow: hidden; margin-top: 10px; }
.goal-progress-bar  { height: 100%; background: linear-gradient(90deg, #0d9488, #0891b2); border-radius: 6px; transition: width 0.4s ease; }

/* ── Achievement cards ────────────────────────────────── */
.ach-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 12px; padding: 0 16px 20px; }

.ach-card {
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.75);
    border-radius: var(--radius-sm);
    padding: 20px 16px;
    text-align: center;
    transition: box-shadow 0.15s, transform 0.15s;
}

.ach-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-2px); }

.ach-icon {
    width: 52px; height: 52px;
    background: rgba(245,158,11,0.12);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
}

.ach-icon svg { width: 26px; height: 26px; stroke: #d97706; }
.ach-title { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.ach-desc  { font-size: 12px; font-weight: 500; color: var(--text-secondary); margin: 0 0 6px; }
.ach-date  { font-size: 11px; font-weight: 500; color: var(--text-tertiary); margin: 0; }

/* ── Empty state ──────────────────────────────────────── */
.perf-empty { text-align: center; padding: 48px 24px; }
.perf-empty-icon { width: 52px; height: 52px; background: rgba(0,0,0,0.05); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
.perf-empty-icon svg { width: 26px; height: 26px; stroke: var(--text-tertiary); }
.perf-empty-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.perf-empty-sub   { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin: 0; }

/* ── Modal ────────────────────────────────────────────── */
.perf-modal-bg {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.28);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 50;
    display: flex; align-items: center; justify-content: center; padding: 24px;
}

.perf-modal {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(32px) saturate(1.8);
    -webkit-backdrop-filter: blur(32px) saturate(1.8);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: var(--radius);
    box-shadow: 0 32px 80px rgba(0,0,0,0.18);
    width: 100%; max-width: 700px;
    max-height: 90vh; overflow-y: auto;
}

.perf-modal-lg { max-width: 860px; }

.perf-modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 22px 28px 16px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    position: sticky; top: 0;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(20px); z-index: 1;
}

.perf-modal-title { font-size: 20px; font-weight: 700; color: var(--text-primary); margin: 0; }

.perf-modal-close {
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(0,0,0,0.06); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s; flex-shrink: 0;
}

.perf-modal-close:hover { background: rgba(0,0,0,0.12); }
.perf-modal-close svg { width: 15px; height: 15px; stroke: var(--text-secondary); }

.perf-modal-body { padding: 24px 28px; }
.perf-modal-footer { padding: 16px 28px 24px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid rgba(0,0,0,0.06); }

/* ── Modal section ────────────────────────────────────── */
.m-section { background: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.85); border-radius: var(--radius-sm); padding: 18px 20px; margin-bottom: 16px; }
.m-section:last-child { margin-bottom: 0; }
.m-section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-tertiary); margin: 0 0 14px; }

.m-row { display: flex; justify-content: space-between; align-items: center; padding: 7px 0; border-bottom: 1px solid rgba(0,0,0,0.05); }
.m-row:last-child { border-bottom: none; }
.m-row-label { font-size: 13px; font-weight: 500; color: var(--text-secondary); }
.m-row-value { font-size: 14px; font-weight: 700; color: var(--text-primary); text-align: right; }

.m-prose { font-size: 14px; font-weight: 500; color: var(--text-secondary); line-height: 1.65; margin: 0; }

/* ── Form fields ──────────────────────────────────────── */
.m-field { margin-bottom: 16px; }
.m-field:last-child { margin-bottom: 0; }

.m-field label {
    display: block; font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.06em;
    color: var(--text-tertiary); margin-bottom: 6px;
}

.m-field input,
.m-field textarea,
.m-field select {
    width: 100%; padding: 10px 14px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500;
    color: var(--text-primary);
    outline: none; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
}

.m-field input:focus,
.m-field textarea:focus,
.m-field select:focus {
    border-color: rgba(13,148,136,0.5);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
}

/* Range slider row */
.range-row { display: flex; align-items: center; gap: 12px; }
.range-row input[type=range] { flex: 1; }
.range-val { width: 32px; text-align: center; font-size: 16px; font-weight: 700; color: var(--text-primary); }

.two-col { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; }

.m-error { font-size: 12px; color: #dc2626; margin-top: 4px; }

.btn-cancel {
    padding: 10px 20px; background: rgba(0,0,0,0.06);
    color: var(--text-secondary); border: none; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background 0.15s;
}

.btn-cancel:hover { background: rgba(0,0,0,0.1); }

/* ── Floating nav ─────────────────────────────────────── */
.ios-nav {
    position: fixed; bottom: 24px; left: 50%;
    transform: translateX(-50%); z-index: 100;
    display: flex; align-items: center; gap: 2px;
    background: rgba(15,15,25,0.75);
    backdrop-filter: blur(32px) saturate(2);
    -webkit-backdrop-filter: blur(32px) saturate(2);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: 28px; padding: 8px 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 4px 16px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.1);
}

.ios-nav::before {
    content: ''; position: absolute;
    top: 0; left: 16px; right: 16px; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
}

.ios-nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 8px 18px; border-radius: 20px; text-decoration: none;
    font-size: 10px; font-weight: 500; color: rgba(255,255,255,0.45);
    letter-spacing: 0.03em; min-width: 64px; position: relative;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.ios-nav-item svg { width: 20px; height: 20px; stroke: currentColor; transition: transform 0.2s; }
.ios-nav-item:hover { color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.08); transform: translateY(-1px); }
.ios-nav-item:hover svg { transform: scale(1.1); }
.ios-nav-item.active { color: #fff; background: rgba(255,255,255,0.15); }
.ios-nav-item.active svg { stroke: #60a5fa; }
.ios-nav-active-dot { position: absolute; bottom: 4px; width: 4px; height: 4px; border-radius: 50%; background: #60a5fa; }

/* ── Two column content grid ──────────────────────────── */
.perf-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.perf-grid-full { grid-column: span 2; }
@media (max-width: 1024px) {
    .perf-stats { grid-template-columns: repeat(3, 1fr); }
    .ach-grid   { grid-template-columns: repeat(2, 1fr); }
    .perf-grid  { grid-template-columns: 1fr; }
    .perf-grid-full { grid-column: span 1; }
}

@media (max-width: 768px) {
    .perf-root  { padding: 20px 16px 110px; }
    .perf-stats { grid-template-columns: 1fr; }
    .ach-grid   { grid-template-columns: 1fr; }
    .two-col    { grid-template-columns: 1fr; }
    .perf-header { flex-direction: column; align-items: flex-start; }
    .ios-nav-item { padding: 7px 12px; min-width: 48px; font-size: 9px; }
    .ios-nav-item svg { width: 18px; height: 18px; }
}
</style>

{{-- ── Page header + stat cards ─────────────────────── --}}
<div class="g-card">
    <div class="perf-header">
        <div class="perf-header-text">
            <h1>My Performance</h1>
            <p>Track your performance reviews, goals, and achievements</p>
        </div>
        <div class="perf-header-actions">
            <button class="btn-primary" wire:click="openSelfEvaluationForm">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Self Evaluation
            </button>
            <button class="btn-blue" wire:click="openGoalForm">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
                Add Goal
            </button>
        </div>
    </div>

    {{-- Stat cards inline inside header card --}}
    <div class="perf-stats" style="padding: 0 28px 28px;">
        <div class="perf-stat">
            <div>
                <div class="perf-stat-label">Latest Score</div>
                <div class="perf-stat-value">{{ $performanceReviews->first()?->overall_score ?? '—' }}</div>
            </div>
            <div class="perf-stat-icon si-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <div class="perf-stat">
            <div>
                <div class="perf-stat-label">Active Goals</div>
                <div class="perf-stat-value">{{ $goals->where('status', 'active')->count() }}</div>
            </div>
            <div class="perf-stat-icon si-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="perf-stat">
            <div>
                <div class="perf-stat-label">Achievements</div>
                <div class="perf-stat-value">{{ $achievements->count() }}</div>
            </div>
            <div class="perf-stat-icon si-amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- ── Two-column grid: Reviews left, Goals right ────── --}}
<div class="perf-grid">

    {{-- Performance Reviews --}}
    <div class="g-card">
        <div class="s-head">
            <h2 class="s-title">Performance Reviews</h2>
        </div>
        @if($performanceReviews->count() > 0)
            @foreach($performanceReviews as $review)
                @php
                    $sc = $review->overall_score;
                    $scClass = $sc >= 4.5 ? 'score-5' : ($sc >= 3.5 ? 'score-4' : ($sc >= 2.5 ? 'score-3' : 'score-low'));
                @endphp
                <div class="perf-item">
                    <div style="flex:1;">
                        <p class="perf-item-title">{{ $review->review_type ?? 'Performance Review' }}</p>
                        <p class="perf-item-sub">Reviewed by {{ $review->reviewer?->name ?? 'HR' }} · {{ $review->review_date->format('M d, Y') }}</p>
                        <span class="score-badge {{ $scClass }}">Score: {{ $review->overall_score }}/5.0</span>
                    </div>
                    <button class="btn-link-blue" wire:click="viewReview('{{ $review->id }}')">View</button>
                </div>
            @endforeach
        @else
            <div class="perf-empty">
                <div class="perf-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                <p class="perf-empty-title">No performance reviews yet</p>
                <p class="perf-empty-sub">Your performance reviews will appear here.</p>
            </div>
        @endif
    </div>

    {{-- Goals --}}
    <div class="g-card">
        <div class="s-head">
            <h2 class="s-title">My Goals</h2>
        </div>
        @if($goals->count() > 0)
            @foreach($goals as $goal)
                @php $gClass = match($goal->status) { 'completed' => 'badge-green', 'active' => 'badge-blue', default => 'badge-gray' }; @endphp
                <div class="goal-item">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
                        <div style="flex:1;">
                            <p class="goal-title">{{ $goal->title }}</p>
                            <p class="goal-desc">{{ $goal->description }}</p>
                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                                <span class="badge {{ $gClass }}">{{ ucfirst($goal->status) }}</span>
                                <span style="font-size:12px; font-weight:500; color:var(--text-tertiary);">Target: {{ $goal->end_date->format('M d, Y') }}</span>
                                @if($goal->progress_percentage)
                                    <span style="font-size:12px; font-weight:500; color:var(--text-tertiary);">{{ $goal->progress_percentage }}% complete</span>
                                @endif
                            </div>
                            @if($goal->progress_percentage)
                                <div class="goal-progress-wrap" style="margin-top:10px;">
                                    <div class="goal-progress-bar" style="width:{{ $goal->progress_percentage }}%"></div>
                                </div>
                            @endif
                        </div>
                        <div style="display:flex; gap:8px; flex-shrink:0;">
                            @if($goal->status === 'active')
                                <button class="btn-link-green" wire:click="updateGoalStatus('{{ $goal->id }}', 'completed')">Complete</button>
                            @endif
                            <button class="btn-link-blue" wire:click="viewGoal('{{ $goal->id }}')">View</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="perf-empty">
                <div class="perf-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                <p class="perf-empty-title">No goals set yet</p>
                <p class="perf-empty-sub">Start by creating your first goal.</p>
            </div>
        @endif
    </div>

    {{-- Achievements — full width --}}
    <div class="g-card perf-grid-full">
        <div class="s-head"><h2 class="s-title">Achievements</h2></div>
        @if($achievements->count() > 0)
            <div class="ach-grid">
                @foreach($achievements as $achievement)
                    <div class="ach-card">
                        <div class="ach-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <p class="ach-title">{{ $achievement->title }}</p>
                        <p class="ach-desc">{{ $achievement->description }}</p>
                        <p class="ach-date">{{ $achievement->achieved_date->format('M d, Y') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="perf-empty">
                <div class="perf-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></div>
                <p class="perf-empty-title">No achievements yet</p>
                <p class="perf-empty-sub">Your achievements will be displayed here.</p>
            </div>
        @endif
    </div>

</div>{{-- /perf-grid --}}

{{-- ── Review Details Modal ──────────────────────────── --}}
@if($selectedReview)
<div class="perf-modal-bg">
    <div class="perf-modal perf-modal-lg">
        <div class="perf-modal-header">
            <h3 class="perf-modal-title">Performance Review Details</h3>
            <button class="perf-modal-close" wire:click="closeModals"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="perf-modal-body">
            <div style="display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px;">
                <div class="m-section">
                    <div class="m-section-title">Review Information</div>
                    <div class="m-row"><span class="m-row-label">Review Type</span><span class="m-row-value">{{ $selectedReview->review_type ?? 'Performance Review' }}</span></div>
                    <div class="m-row"><span class="m-row-label">Review Date</span><span class="m-row-value">{{ $selectedReview->review_date->format('M d, Y') }}</span></div>
                    <div class="m-row"><span class="m-row-label">Reviewer</span><span class="m-row-value">{{ $selectedReview->reviewer?->name ?? 'HR' }}</span></div>
                    <div class="m-row"><span class="m-row-label">Overall Score</span><span class="m-row-value" style="color:#2563eb;">{{ $selectedReview->overall_score }}/5.0</span></div>
                </div>
                <div class="m-section">
                    <div class="m-section-title">Performance Areas</div>
                    @if($selectedReview->technical_skills)
                        <div class="m-row"><span class="m-row-label">Technical Skills</span><span class="m-row-value">{{ $selectedReview->technical_skills }}/5</span></div>
                    @endif
                    @if($selectedReview->communication)
                        <div class="m-row"><span class="m-row-label">Communication</span><span class="m-row-value">{{ $selectedReview->communication }}/5</span></div>
                    @endif
                    @if($selectedReview->teamwork)
                        <div class="m-row"><span class="m-row-label">Teamwork</span><span class="m-row-value">{{ $selectedReview->teamwork }}/5</span></div>
                    @endif
                    @if($selectedReview->leadership)
                        <div class="m-row"><span class="m-row-label">Leadership</span><span class="m-row-value">{{ $selectedReview->leadership }}/5</span></div>
                    @endif
                </div>
            </div>
            @if($selectedReview->strengths)
                <div class="m-section" style="margin-top:16px;">
                    <div class="m-section-title">Strengths</div>
                    <p class="m-prose">{{ $selectedReview->strengths }}</p>
                </div>
            @endif
            @if($selectedReview->areas_for_improvement)
                <div class="m-section" style="margin-top:16px;">
                    <div class="m-section-title">Areas for Improvement</div>
                    <p class="m-prose">{{ $selectedReview->areas_for_improvement }}</p>
                </div>
            @endif
            @if($selectedReview->comments)
                <div class="m-section" style="margin-top:16px;">
                    <div class="m-section-title">Additional Comments</div>
                    <p class="m-prose">{{ $selectedReview->comments }}</p>
                </div>
            @endif
        </div>
        <div class="perf-modal-footer">
            <button class="btn-cancel" wire:click="closeModals">Close</button>
        </div>
    </div>
</div>
@endif

{{-- ── Goal Details Modal ────────────────────────────── --}}
@if($selectedGoal)
    @php $gClass = match($selectedGoal->status) { 'completed' => 'badge-green', 'active' => 'badge-blue', default => 'badge-gray' }; @endphp
<div class="perf-modal-bg">
    <div class="perf-modal">
        <div class="perf-modal-header">
            <h3 class="perf-modal-title">Goal Details</h3>
            <button class="perf-modal-close" wire:click="closeModals"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="perf-modal-body">
            <div class="m-section">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:12px;">
                    <div class="m-section-title" style="margin:0;">{{ $selectedGoal->title }}</div>
                    <span class="badge {{ $gClass }}">{{ ucfirst($selectedGoal->status) }}</span>
                </div>
                <p class="m-prose" style="margin-bottom:14px;">{{ $selectedGoal->description }}</p>
                <div class="m-row"><span class="m-row-label">Start Date</span><span class="m-row-value">{{ $selectedGoal->start_date->format('M d, Y') }}</span></div>
                <div class="m-row"><span class="m-row-label">Target Date</span><span class="m-row-value">{{ $selectedGoal->end_date->format('M d, Y') }}</span></div>
                @if($selectedGoal->progress_percentage)
                    <div class="m-row"><span class="m-row-label">Progress</span><span class="m-row-value">{{ $selectedGoal->progress_percentage }}%</span></div>
                @endif
                <div class="m-row"><span class="m-row-label">Created</span><span class="m-row-value">{{ $selectedGoal->created_at->format('M d, Y') }}</span></div>
                @if($selectedGoal->progress_percentage)
                    <div class="goal-progress-wrap" style="margin-top:12px;">
                        <div class="goal-progress-bar" style="width:{{ $selectedGoal->progress_percentage }}%"></div>
                    </div>
                @endif
            </div>
            @if($selectedGoal->status === 'active')
                <button class="btn-primary" style="width:100%; justify-content:center; margin-top:12px;" wire:click="updateGoalStatus('{{ $selectedGoal->id }}', 'completed')">
                    Mark as Completed
                </button>
            @endif
        </div>
        <div class="perf-modal-footer">
            <button class="btn-cancel" wire:click="closeModals">Close</button>
        </div>
    </div>
</div>
@endif

{{-- ── Add Goal Modal ────────────────────────────────── --}}
@if($showGoalForm)
<div class="perf-modal-bg">
    <div class="perf-modal">
        <div class="perf-modal-header">
            <h3 class="perf-modal-title">Create New Goal</h3>
            <button class="perf-modal-close" wire:click="closeModals"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="perf-modal-body">
            <form wire:submit="createGoal">
                <div class="m-field">
                    <label>Goal Title</label>
                    <input wire:model="goalTitle" type="text" placeholder="Enter goal title">
                    @error('goalTitle') <span class="m-error">{{ $message }}</span> @enderror
                </div>
                <div class="m-field">
                    <label>Description</label>
                    <textarea wire:model="goalDescription" rows="3" placeholder="Describe your goal..."></textarea>
                    @error('goalDescription') <span class="m-error">{{ $message }}</span> @enderror
                </div>
                <div class="two-col">
                    <div class="m-field">
                        <label>Target Date</label>
                        <input wire:model="goalTargetDate" type="date">
                        @error('goalTargetDate') <span class="m-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="m-field">
                        <label>Status</label>
                        <select wire:model="goalStatus">
                            <option value="active">Active</option>
                            <option value="on_hold">On Hold</option>
                        </select>
                        @error('goalStatus') <span class="m-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="perf-modal-footer" style="padding:16px 0 0; margin-top:8px;">
                    <button type="button" class="btn-cancel" wire:click="closeModals">Cancel</button>
                    <button type="submit" class="btn-blue" style="border-radius:var(--radius-sm);">Create Goal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ── Self Evaluation Modal ─────────────────────────── --}}
@if($showSelfEvaluationForm)
<div class="perf-modal-bg">
    <div class="perf-modal perf-modal-lg">
        <div class="perf-modal-header">
            <h3 class="perf-modal-title">Self Performance Evaluation</h3>
            <button class="perf-modal-close" wire:click="closeModals"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="perf-modal-body">
            <form wire:submit="submitSelfEvaluation">
                <div class="m-field">
                    <label>Evaluation Period</label>
                    <input wire:model="selfEvaluationPeriod" type="month">
                    @error('selfEvaluationPeriod') <span class="m-error">{{ $message }}</span> @enderror
                </div>

                <div class="m-section">
                    <div class="m-section-title">Rate Your Performance (1–5)</div>
                    <div class="two-col">
                        <div class="m-field">
                            <label>Technical Skills</label>
                            <div class="range-row"><input wire:model="selfTechnicalSkills" type="range" min="1" max="5" step="1"><span class="range-val">{{ $selfTechnicalSkills }}</span></div>
                        </div>
                        <div class="m-field">
                            <label>Communication</label>
                            <div class="range-row"><input wire:model="selfCommunication" type="range" min="1" max="5" step="1"><span class="range-val">{{ $selfCommunication }}</span></div>
                        </div>
                        <div class="m-field">
                            <label>Teamwork</label>
                            <div class="range-row"><input wire:model="selfTeamwork" type="range" min="1" max="5" step="1"><span class="range-val">{{ $selfTeamwork }}</span></div>
                        </div>
                        <div class="m-field">
                            <label>Leadership</label>
                            <div class="range-row"><input wire:model="selfLeadership" type="range" min="1" max="5" step="1"><span class="range-val">{{ $selfLeadership }}</span></div>
                        </div>
                        <div class="m-field">
                            <label>Problem Solving</label>
                            <div class="range-row"><input wire:model="selfProblemSolving" type="range" min="1" max="5" step="1"><span class="range-val">{{ $selfProblemSolving }}</span></div>
                        </div>
                        <div class="m-field">
                            <label>Time Management</label>
                            <div class="range-row"><input wire:model="selfTimeManagement" type="range" min="1" max="5" step="1"><span class="range-val">{{ $selfTimeManagement }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="m-field" style="margin-top:16px;">
                    <label>Strengths</label>
                    <textarea wire:model="selfStrengths" rows="3" placeholder="Describe your key strengths and accomplishments..."></textarea>
                    @error('selfStrengths') <span class="m-error">{{ $message }}</span> @enderror
                </div>
                <div class="m-field">
                    <label>Areas for Improvement</label>
                    <textarea wire:model="selfAreasForImprovement" rows="3" placeholder="Describe areas where you can improve..."></textarea>
                    @error('selfAreasForImprovement') <span class="m-error">{{ $message }}</span> @enderror
                </div>
                <div class="m-field">
                    <label>Goals and Objectives</label>
                    <textarea wire:model="selfGoals" rows="3" placeholder="What are your professional goals for the next period?"></textarea>
                    @error('selfGoals') <span class="m-error">{{ $message }}</span> @enderror
                </div>
                <div class="m-field">
                    <label>Additional Comments</label>
                    <textarea wire:model="selfAdditionalComments" rows="2" placeholder="Any additional comments or feedback..."></textarea>
                    @error('selfAdditionalComments') <span class="m-error">{{ $message }}</span> @enderror
                </div>

                <div class="perf-modal-footer" style="padding:16px 0 0; margin-top:8px;">
                    <button type="button" class="btn-cancel" wire:click="closeModals">Cancel</button>
                    <button type="submit" class="btn-primary">Submit Evaluation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ── Floating nav ──────────────────────────────────── --}}
<nav class="ios-nav">
    <a href="{{ route('employee.dashboard') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Home
    </a>
    <a href="{{ route('employee.profile') }}" class="ios-nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0114 0"/></svg>
        Profile
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

</div>{{-- /perf-root --}}