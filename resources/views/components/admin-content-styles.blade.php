<style>
/* ══ ADMIN CONTENT STYLES ═════════════════════════════════ */
:root {
    --ac-card-bg: #FFFFFF;
    --ac-header-bg: #F8FAFC;
    --ac-border: rgba(15, 22, 41, 0.08);
    --ac-shadow: 0 4px 20px rgba(59, 111, 232, 0.06);
    --ac-ink: #0F1629;
    --ac-ink2: #2D3356;
    --ac-ink3: #6B7094;
    --ac-ink4: #A8ADCA;
    --ac-input-bg: #FFFFFF;
    --ac-hover-bg: #F8FAFC;
    --indigo: #6366F1;
    --indigo-lt: rgba(99, 102, 241, 0.1);
    --teal: #14B8A6;
    --teal-lt: rgba(20, 184, 166, 0.1);
    --amber: #F59E0B;
    --amber-lt: rgba(245, 158, 11, 0.1);
    --blue: #3B82F6;
    --blue-lt: rgba(59, 130, 246, 0.1);
}

html.tf-dark {
    --ac-card-bg: rgba(18, 22, 42, 0.6);
    --ac-header-bg: rgba(255, 255, 255, 0.03);
    --ac-border: rgba(255, 255, 255, 0.08);
    --ac-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    --ac-ink: #FFFFFF;
    --ac-ink2: #E2E8F0;
    --ac-ink3: #94A3B8;
    --ac-ink4: #64748B;
    --ac-input-bg: rgba(18, 22, 42, 0.8);
    --ac-hover-bg: rgba(255, 255, 255, 0.04);
}

.ac-root {
    font-family: 'DM Sans', sans-serif;
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    color: var(--ac-ink);
}

.ac-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--ac-card-bg);
    padding: 20px 24px;
    border-radius: 16px;
    border: 1px solid var(--ac-border);
    box-shadow: var(--ac-shadow);
    backdrop-filter: blur(10px);
}

.ac-header-title {
    font-family: 'Sora', sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: var(--ac-ink);
}

.ac-header-sub {
    font-size: 13px;
    font-weight: 500;
    color: var(--ac-ink3);
    margin-top: 4px;
}

.ac-card {
    background: var(--ac-card-bg);
    border-radius: 16px;
    border: 1px solid var(--ac-border);
    box-shadow: var(--ac-shadow);
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.ac-card-hd {
    padding: 18px 24px;
    border-bottom: 1px solid var(--ac-border);
    background: var(--ac-header-bg);
}

.ac-card-title {
    font-family: 'Sora', sans-serif;
    font-size: 15px;
    font-weight: 800;
    color: var(--ac-ink);
}

.ac-card-sub {
    font-size: 12.5px;
    font-weight: 500;
    color: var(--ac-ink3);
    margin-top: 2px;
}

.ac-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
}

.ac-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2.5;
}

.ac-btn-primary {
    background: var(--tf-blue);
    color: #fff;
    box-shadow: 0 4px 12px rgba(59, 111, 232, 0.2);
}

.ac-btn-primary:hover {
    background: var(--tf-blue);
    filter: brightness(1.1);
    transform: translateY(-1px);
}

.ac-btn-outline {
    background: transparent;
    border: 1px solid var(--ac-border);
    color: var(--ac-ink2);
}

.ac-btn-outline:hover {
    border-color: var(--tf-blue);
    color: var(--tf-blue);
}

.ac-btn-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

.ac-btn-danger:hover {
    background: #EF4444;
    color: #fff;
}

.ac-btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 8px;
}

.ac-flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 600;
}

.ac-flash svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

.ac-flash-ok {
    background: rgba(18, 183, 106, 0.15);
    color: #10B981;
    border: 1px solid rgba(18, 183, 106, 0.2);
}

.ac-flash-err {
    background: rgba(239, 68, 68, 0.15);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

/* Empty States */
.ac-empty {
    padding: 40px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.ac-empty-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: var(--tf-blue-lt);
    color: var(--tf-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}

.ac-empty-icon svg {
    width: 24px;
    height: 24px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

.ac-empty-ttl {
    font-family: 'Sora', sans-serif;
    font-size: 16px;
    font-weight: 800;
    color: var(--ac-ink);
    margin-bottom: 6px;
}

.ac-empty-sub {
    font-size: 13px;
    color: var(--ac-ink3);
    max-width: 320px;
}

/* Rows (Used in Session/Logs) */
.ac-sess-row, .ac-log-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid var(--ac-border);
}

.ac-sess-row:last-child, .ac-log-row:last-child {
    border-bottom: none;
}

.ac-sess-row:hover, .ac-log-row:hover {
    background: var(--ac-hover-bg);
}

.ac-sess-ip, .ac-log-event {
    font-size: 14px;
    font-weight: 700;
    color: var(--ac-ink);
}

.ac-sess-time, .ac-log-time {
    font-size: 12.5px;
    font-weight: 500;
    color: var(--ac-ink4);
    margin-top: 2px;
}

.ac-current-pill {
    padding: 4px 12px;
    border-radius: 100px;
    background: var(--tf-blue-pill);
    color: var(--tf-blue);
    font-size: 11px;
    font-weight: 700;
}

/* Common form elements */
.ac-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 16px;
}

.ac-form-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--ac-ink2);
}

.ac-form-control, .ac-num-input {
    background: var(--ac-input-bg);
    border: 1px solid var(--ac-border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13.5px;
    font-family: 'DM Sans', sans-serif;
    color: var(--ac-ink);
    transition: border-color 0.2s;
    outline: none;
}

.ac-form-control:focus, .ac-num-input:focus {
    border-color: var(--tf-blue);
}

.ac-toggle {
    width: 44px;
    height: 24px;
    border-radius: 100px;
    background: var(--ac-ink4);
    position: relative;
    cursor: pointer;
    border: none;
    transition: background 0.3s;
}

.ac-toggle.on {
    background: #10B981;
}

.ac-toggle::after {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    left: 3px;
    top: 3px;
    transition: transform 0.3s;
}

.ac-toggle.on::after {
    transform: translateX(20px);
}

/* Modals */
.ac-modal-bg {
    position: fixed;
    top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(15, 22, 41, 0.4);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ac-modal {
    background: var(--ac-card-bg);
    width: 480px;
    max-width: 90vw;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    overflow: hidden;
    border: 1px solid var(--ac-border);
}

.ac-modal-hd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--ac-border);
    background: var(--ac-header-bg);
}

.ac-modal-hd-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ac-modal-hd-icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    background: var(--tf-blue-lt);
    color: var(--tf-blue);
    display: flex;
    align-items: center;
    justify-content: center;
}

.ac-modal-hd-icon svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; }

.ac-modal-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: var(--ac-ink); }
.ac-modal-sub { font-size: 12.5px; color: var(--ac-ink3); margin-top: 2px; }
.ac-modal-close { background: transparent; border: none; color: var(--ac-ink4); cursor: pointer; display: flex; padding: 4px; border-radius: 6px; transition: 0.2s; }
.ac-modal-close:hover { background: rgba(0,0,0,0.05); color: var(--ac-ink); }
.ac-modal-close svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; }

.ac-modal-body { padding: 24px; }
.ac-modal-footer { padding: 16px 24px; background: var(--ac-header-bg); border-top: 1px solid var(--ac-border); display: flex; justify-content: flex-end; gap: 12px; }

/* Tables */
.ac-table-wrap { overflow-x: auto; }
.ac-table { width: 100%; border-collapse: collapse; }
.ac-table th { text-align: left; padding: 12px 24px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ac-ink4); border-bottom: 1px solid var(--ac-border); background: var(--ac-header-bg); }
.ac-table td { padding: 16px 24px; font-size: 13.5px; color: var(--ac-ink2); border-bottom: 1px solid var(--ac-border); }
.ac-table tr:hover td { background: var(--ac-hover-bg); }

.ac-user-cell { display: flex; align-items: center; gap: 12px; }
.ac-av { width: 36px; height: 36px; border-radius: 50%; background: var(--tf-blue-lt); color: var(--tf-blue); font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; }
.ac-user-name { font-weight: 700; color: var(--ac-ink); }
.ac-user-meta { font-size: 12px; color: var(--ac-ink4); }

/* Badges */
.ac-badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.ab-green { background: rgba(16, 185, 129, 0.1); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.2); }
.ab-red { background: rgba(239, 68, 68, 0.1); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2); }
.ab-indigo { background: rgba(99, 102, 241, 0.1); color: #6366F1; border: 1px solid rgba(99, 102, 241, 0.2); }
.ab-teal { background: rgba(20, 184, 166, 0.1); color: #14B8A6; border: 1px solid rgba(20, 184, 166, 0.2); }

/* Buttons Extra */
.ac-btn-purple { background: rgba(168, 85, 247, 0.1); color: #A855F7; }
.ac-btn-purple:hover { background: #A855F7; color: #fff; }
.ac-btn-teal { background: rgba(20, 184, 166, 0.1); color: #14B8A6; }
.ac-btn-teal:hover { background: #14B8A6; color: #fff; }

/* Misc */
.ac-pager { padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; background: var(--ac-header-bg); border-top: 1px solid var(--ac-border); }
.ac-pager-info { font-size: 13px; color: var(--ac-ink3); }

.ac-notice { display: flex; align-items: flex-start; gap: 10px; padding: 14px 20px; border-radius: 12px; font-size: 13.5px; font-weight: 600; line-height: 1.5; }
.ac-notice svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; margin-top: 2px; }
.ac-notice-warn { background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); color: #D97706; }
.ac-notice-info { background: var(--tf-blue-lt); border: 1px solid var(--tf-blue-pill); color: var(--tf-blue); }

.ac-field { margin-bottom: 16px; display: flex; flex-direction: column; gap: 8px; }
.ac-field label { font-size: 13px; font-weight: 700; color: var(--ac-ink2); }
.ac-field .req { color: #EF4444; }
.ac-field input, .ac-field select { background: var(--ac-input-bg); border: 1px solid var(--ac-border); border-radius: 10px; padding: 10px 14px; color: var(--ac-ink); font-family: 'DM Sans', sans-serif; font-size: 14px; outline: none; transition: 0.2s; }
.ac-field input:focus, .ac-field select:focus { border-color: var(--tf-blue); }
.ac-field-hint { font-size: 12px; color: var(--ac-ink4); margin-top: 4px; }

.ac-pw-display { background: rgba(0,0,0,0.03); border: 1px dashed var(--ac-border); padding: 14px; text-align: center; border-radius: 10px; font-family: 'DM Mono', monospace; font-size: 18px; font-weight: 700; color: var(--ac-ink); letter-spacing: 2px; }
html.tf-dark .ac-pw-display { background: rgba(255,255,255,0.03); }
.ac-pw-copy { background: transparent; border: none; color: var(--tf-blue); font-size: 12px; font-weight: 700; cursor: pointer; padding: 4px 8px; }
.ac-pw-copy:hover { text-decoration: underline; }

.ac-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-bottom: 1px solid var(--ac-border); }
.ac-toggle-row:last-child { border-bottom: none; }
.ac-toggle-label { font-size: 14px; font-weight: 700; color: var(--ac-ink); }
.ac-toggle-desc { font-size: 12.5px; color: var(--ac-ink4); margin-top: 4px; }

.ac-perm-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
@media (max-width: 1024px) { .ac-perm-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { .ac-perm-grid { grid-template-columns: 1fr; } }
.ac-perm-card { background: var(--ac-card-bg); border: 1px solid var(--ac-border); border-radius: 16px; box-shadow: var(--ac-shadow); overflow: hidden; backdrop-filter: blur(10px); }
.ac-perm-card-hd { padding: 16px 20px; background: var(--ac-header-bg); border-bottom: 1px solid var(--ac-border); display: flex; align-items: center; justify-content: space-between; font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800; color: var(--ac-ink); }
.ac-perm-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; border-bottom: 1px solid var(--ac-border); }
.ac-perm-row:last-child { border-bottom: none; }
.ac-search { display: flex; align-items: center; background: var(--ac-input-bg); border: 1px solid var(--ac-border); border-radius: 10px; padding: 0 12px; height: 38px; }
.ac-search svg { width: 16px; height: 16px; stroke: var(--ac-ink4); fill: none; margin-right: 8px; }
.ac-search input { border: none; background: transparent; outline: none; color: var(--ac-ink); font-size: 13.5px; width: 100%; height: 100%; }

/* Dashboard specific */
.ac-tiles { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 24px; }
@media (max-width: 1200px) { .ac-tiles { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { .ac-tiles { grid-template-columns: 1fr; } }
.ac-tile { background: var(--ac-card-bg); border: 1px solid var(--ac-border); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px; position: relative; overflow: hidden; box-shadow: var(--ac-shadow); backdrop-filter: blur(10px); }
.ac-tile-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ac-tile-icon svg { width: 24px; height: 24px; stroke-width: 2; fill: none; }
.ac-tile-lbl { font-size: 13px; font-weight: 700; color: var(--ac-ink3); text-transform: uppercase; letter-spacing: 0.5px; }
.ac-tile-val { font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 800; margin-top: 4px; }
.ac-tile-sub { font-size: 12px; color: var(--ac-ink4); margin-top: 2px; }

.ac-log-row { display: flex; align-items: center; padding: 12px 20px; border-bottom: 1px solid var(--ac-border); gap: 14px; }
.ac-log-row:last-child { border-bottom: none; }
.ac-log-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.ac-log-desc { font-size: 13.5px; font-weight: 600; color: var(--ac-ink); flex: 1; }

</style>
<script>
function acCopy(id, btn) {
    const text = document.getElementById(id).innerText;
    navigator.clipboard.writeText(text);
    const orig = btn.innerText;
    btn.innerText = 'Copied!';
    setTimeout(() => { btn.innerText = orig; }, 2000);
}
</script>
