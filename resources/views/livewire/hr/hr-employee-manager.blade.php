<div class="em-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ Tokens ══════════════════════════════════════════════ */
.em-root {
    --blue:     #3B6FE8;
    --blue-2:   #2755CC;
    --blue-3:   #1A3FA8;
    --blue-lt:  rgba(59,111,232,0.08);
    --blue-mid: rgba(59,111,232,0.16);
    --blue-brd: rgba(59,111,232,0.22);
    --green:    #12B76A;
    --green-lt: rgba(18,183,106,0.10);
    --amber:    #F59E0B;
    --amber-lt: rgba(245,158,11,0.10);
    --red:      #EF4444;
    --red-lt:   rgba(239,68,68,0.09);
    --bg:       #F0F4FA;
    --white:    #FFFFFF;
    --ink:      #0F1629;
    --ink2:     #2D3356;
    --ink3:     #6B7094;
    --ink4:     #A8ADCA;
    --border:   rgba(15,22,41,0.08);
    --shadow:   0 2px 12px rgba(59,111,232,0.07);
    --shadow-md:0 8px 32px rgba(59,111,232,0.13);
    --r:        12px;
    --r-lg:     18px;
    font-family:'DM Sans',-apple-system,sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--ink);
    padding: 24px 24px 40px;
    display: flex; flex-direction: column; gap: 18px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.em-flash { padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 9px; }
.em-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.em-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.em-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ PAGE HERO ═══════════════════════════════════════════ */
.em-hero { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.em-hero-cover {
    height: 68px;
    background: linear-gradient(118deg, var(--blue-3) 0%, var(--blue-2) 40%, var(--blue) 70%, #5A8BF5 100%);
    position: relative;
}
.em-hero-cover::before { content:''; position:absolute; top:-30px; right:60px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,0.06); }
.em-hero-body {
    padding: 0 24px 18px;
    display: flex; align-items: flex-end; justify-content: space-between; gap:16px;
    margin-top: -2px;
}
.em-hero-icon {
    width: 52px; height: 52px; border-radius: 15px;
    background: linear-gradient(135deg, var(--blue), #5A8BF5);
    border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(59,111,232,0.28);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.em-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.em-hero-title { font-family:'Sora',sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.em-hero-sub   { font-size: 12.5px; color: var(--ink3); font-weight: 500; }

/* Stat strip */
.em-stat-strip { display: grid; grid-template-columns: repeat(3,1fr); gap: 1px; background: var(--border); border-radius: 0 0 var(--r-lg) var(--r-lg); overflow: hidden; }
.em-stat-cell { background: var(--white); padding: 13px 18px; display: flex; flex-direction: column; gap: 2px; }
.em-stat-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--ink4); }
.em-stat-val   { font-family:'Sora',sans-serif; font-size: 20px; font-weight: 800; color: var(--ink2); }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.em-toolbar {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    background: var(--white); border-radius: var(--r-lg);
    border: 1px solid var(--border); box-shadow: var(--shadow);
    padding: 14px 18px;
}
.em-search-box {
    display: flex; align-items: center; gap: 8px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 10px; padding: 8px 13px; flex: 1; min-width: 200px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.em-search-box:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); }
.em-search-box svg { width: 14px; height: 14px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.em-search-box input { border: none; background: transparent; font-size: 13.5px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.em-search-box input::placeholder { color: var(--ink4); }

.em-filter-select {
    background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px;
    padding: 8px 32px 8px 12px; font-size: 13px; font-weight: 600; color: var(--ink2);
    outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
    -webkit-appearance: none;
    transition: border-color 0.15s;
}
.em-filter-select:focus { border-color: var(--blue); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.em-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 17px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all 0.15s; white-space: nowrap; }
.em-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.em-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.em-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.em-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.em-btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.em-btn-ghost { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.em-btn-ghost:hover { background: var(--blue-mid); }
.em-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.em-btn-danger:hover { background: rgba(239,68,68,0.15); }
.em-btn-amber { background: var(--amber-lt); color: #92400E; border: 1px solid rgba(245,158,11,0.22); }
.em-btn-sm { padding: 6px 12px; font-size: 12px; }

/* ══ EMPLOYEE TABLE ══════════════════════════════════════ */
.em-table-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.em-table-wrap { overflow-x: auto; }
table.em-table { width: 100%; border-collapse: collapse; }
.em-table thead tr { border-bottom: 1px solid var(--border); background: #FAFBFF; }
.em-table th { padding: 11px 14px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.em-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s; }
.em-table tbody tr:last-child { border-bottom: none; }
.em-table tbody tr:hover { background: #F8FAFF; }
.em-table td { padding: 13px 14px; font-size: 13px; font-weight: 500; color: var(--ink2); }
.em-table td.bold { font-weight: 700; color: var(--ink); }

/* Avatar cell */
.em-av-cell { display: flex; align-items: center; gap: 10px; }
.em-av {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), #6B4FDB);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 800; color: #fff;
    flex-shrink: 0;
}
.em-av-name { font-size: 13.5px; font-weight: 700; color: var(--ink); }
.em-av-code { font-size: 11px; color: var(--ink4); font-weight: 500; }

/* Badges */
.em-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700; }
.em-badge svg { width: 7px; height: 7px; stroke: currentColor; fill: currentColor; }
.badge-active   { background: var(--green-lt);  color: #087A42; }
.badge-inactive { background: var(--red-lt);    color: #991B1B; }
.badge-dept     { background: var(--blue-lt);   color: var(--blue-2); }
.badge-pos      { background: var(--amber-lt);  color: #92400E; }

/* Row actions */
.em-actions { display: flex; gap: 6px; }

/* ══ EMPTY STATE ═════════════════════════════════════════ */
.em-empty { text-align: center; padding: 56px 24px; }
.em-empty svg { width: 40px; height: 40px; stroke: var(--ink4); fill: none; stroke-width: 1.5; margin: 0 auto 14px; display: block; opacity: 0.4; }
.em-empty-title { font-size: 16px; font-weight: 700; color: var(--ink3); margin-bottom: 5px; }
.em-empty-sub   { font-size: 13px; color: var(--ink4); font-weight: 500; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.em-pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-top: 1px solid var(--border); }
.em-page-info { font-size: 12.5px; color: var(--ink4); font-weight: 500; }

/* ══ MODAL OVERLAY ═══════════════════════════════════════ */
.em-modal-bg {
    position: fixed; inset: 0; background: rgba(15,22,41,0.50);
    backdrop-filter: blur(8px); z-index: 9999;
    display: flex; align-items: center; justify-content: center; padding: 16px;
}
.em-modal {
    background: var(--white); border-radius: var(--r-lg);
    box-shadow: 0 24px 64px rgba(15,22,41,0.22);
    border: 1px solid var(--border);
    width: 100%; max-width: 860px;
    max-height: 92vh; display: flex; flex-direction: column;
    overflow: hidden;
}
.em-modal-sm { max-width: 460px; }

/* Modal header */
.em-modal-hd {
    background: linear-gradient(105deg, var(--blue-3), var(--blue));
    padding: 18px 22px; display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.em-modal-title { font-family:'Sora',sans-serif; font-size: 16px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 9px; }
.em-modal-title svg { width: 18px; height: 18px; stroke: rgba(255,255,255,0.8); fill: none; stroke-width: 2; }
.em-modal-close { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.18); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.15s; }
.em-modal-close:hover { background: rgba(255,255,255,0.28); }
.em-modal-close svg { width: 13px; height: 13px; stroke: #fff; fill: none; stroke-width: 2.5; }

/* Tabs */
.em-tabs { display: flex; gap: 0; border-bottom: 1px solid var(--border); padding: 0 22px; background: #FAFBFF; flex-shrink: 0; overflow-x: auto; }
.em-tab {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 12px 16px; font-size: 13px; font-weight: 600;
    color: var(--ink4); background: none; border: none;
    border-bottom: 2.5px solid transparent; cursor: pointer;
    white-space: nowrap; transition: color 0.15s, border-color 0.15s;
    margin-bottom: -1px; font-family: 'DM Sans', sans-serif;
}
.em-tab svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
.em-tab:hover { color: var(--ink2); }
.em-tab.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 700; }

/* Modal body */
.em-modal-body { flex: 1; overflow-y: auto; padding: 22px; }

/* Section label */
.em-section-lbl {
    font-size: 10px; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.09em; color: var(--ink4); margin: 20px 0 12px;
    display: flex; align-items: center; gap: 6px;
}
.em-section-lbl:first-child { margin-top: 0; }
.em-section-lbl::after { content:''; flex:1; height:1px; background: var(--border); }

/* Form grid */
.em-form-grid   { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
.em-form-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; }
.em-form-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; }
.em-col-span-2  { grid-column: span 2; }
.em-col-span-3  { grid-column: span 3; }
.em-col-span-4  { grid-column: span 4; }

/* Fields */
.em-field { display: flex; flex-direction: column; gap: 5px; }
.em-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink4); }
.em-field label .req { color: var(--red); margin-left: 2px; }
.em-field input,
.em-field select,
.em-field textarea {
    width: 100%; padding: 9px 12px; box-sizing: border-box;
    background: #F6F8FC; border: 1.5px solid var(--border);
    border-radius: var(--r); font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    -webkit-appearance: none;
}
.em-field input:focus, .em-field select:focus, .em-field textarea:focus {
    border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white);
}
.em-field input[type="date"] { cursor: pointer; }
.em-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 11px center;
    padding-right: 32px; cursor: pointer;
}
.em-field textarea { resize: vertical; min-height: 72px; }
.em-field-error { font-size: 11.5px; color: var(--red); font-weight: 600; margin-top: 2px; }

/* Checkbox row */
.em-checkbox-row {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 14px; border-radius: var(--r);
    background: var(--blue-lt); border: 1px solid var(--blue-brd);
    cursor: pointer;
}
.em-checkbox-row input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--blue); cursor: pointer; }
.em-checkbox-row label { font-size: 13.5px; font-weight: 700; color: var(--blue-2); cursor: pointer; }
.em-checkbox-row span  { font-size: 12px; color: var(--ink3); font-weight: 500; }

/* Payment method tabs */
.em-pay-tabs { display: flex; gap: 8px; margin-bottom: 16px; }
.em-pay-tab {
    flex: 1; padding: 9px 12px; border-radius: var(--r);
    border: 1.5px solid var(--border); background: var(--bg);
    font-size: 12.5px; font-weight: 700; color: var(--ink3);
    cursor: pointer; text-align: center; transition: all 0.15s;
    font-family: 'DM Sans', sans-serif;
}
.em-pay-tab:hover { border-color: var(--blue-brd); color: var(--blue); }
.em-pay-tab.active { border-color: var(--blue); background: var(--blue-lt); color: var(--blue-2); }

/* Modal footer */
.em-modal-footer { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }

/* ══ VIEW MODAL ══════════════════════════════════════════ */
.em-view-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
.em-view-row { display: flex; flex-direction: column; gap: 2px; padding: 11px 0; border-bottom: 1px solid var(--border); }
.em-view-row:nth-last-child(-n+2) { border-bottom: none; }
.em-view-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.09em; color: var(--ink4); }
.em-view-value { font-size: 13.5px; font-weight: 600; color: var(--ink2); }

/* Emergency contacts */
.em-emergency-contact { transition: all 0.2s ease; }
.em-emergency-contact:hover { 
    border-color: var(--blue-brd); 
    box-shadow: 0 2px 8px rgba(59,111,232,0.08); 
    transform: translateY(-1px);
}

/* View hero */
.em-view-hero { text-align: center; padding: 24px 22px 16px; border-bottom: 1px solid var(--border); }
.em-view-av {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), #6B4FDB);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #fff;
    margin: 0 auto 12px; box-shadow: 0 4px 14px rgba(59,111,232,0.28);
}
.em-view-name { font-family:'Sora',sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
.em-view-meta { display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap; }

/* ══ DELETE MODAL ════════════════════════════════════════ */
.em-delete-icon {
    width: 56px; height: 56px; border-radius: 16px;
    background: var(--red-lt); border: 1px solid rgba(239,68,68,0.22);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.em-delete-icon svg { width: 26px; height: 26px; stroke: var(--red); fill: none; stroke-width: 1.75; }

/* ══ RESPONSIVE ══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .em-form-grid   { grid-template-columns: repeat(2,1fr); }
    .em-form-grid-4 { grid-template-columns: repeat(2,1fr); }
    .em-col-span-3  { grid-column: span 2; }
}
@media (max-width: 640px) {
    .em-root { padding: 14px 12px 32px; }
    .em-form-grid, .em-form-grid-2, .em-form-grid-4 { grid-template-columns: 1fr; }
    .em-col-span-2, .em-col-span-3, .em-col-span-4 { grid-column: span 1; }
    .em-modal { max-height: 100vh; border-radius: 0; }
    .em-view-info-grid { grid-template-columns: 1fr; }
}
</style>

{{-- Flash messages --}}
@if(session()->has('success'))
    <div class="em-flash em-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="em-flash em-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- Dynamic message container for Livewire events --}}
<div id="livewire-messages" style="position: fixed; top: 20px; right: 20px; z-index: 10000;"></div>

<script>
document.addEventListener('livewire:init', () => {
    // Listen for Livewire dispatched messages
    Livewire.on('show-message', (message) => {
        console.log('Livewire message received:', message);
        showMessage(message);
    });
    
    // Listen for validation errors
    Livewire.on('validation-error', (errors) => {
        console.log('Validation errors received:', errors);
        let errorMessage = 'Validation failed: ';
        const errorMessages = [];
        for (const [field, messages] of Object.entries(errors)) {
            errorMessages.push(`${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}`);
        }
        showMessage(errorMessage + errorMessages.join('; '), true);
    });
});

function showMessage(message, isError = false) {
    const messagesContainer = document.getElementById('livewire-messages');
    
    // Determine message type
    const messageClass = isError ? 'em-flash em-flash-err' : 'em-flash em-flash-ok';
    const icon = isError ? 
        '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>' :
        '<svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
    
    // Create message element
    const messageEl = document.createElement('div');
    messageEl.className = messageClass;
    messageEl.style.cssText = 'margin-bottom: 10px; animation: slideIn 0.3s ease-out;';
    messageEl.innerHTML = `${icon} ${message}`;
    
    // Add to container
    messagesContainer.appendChild(messageEl);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        messageEl.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => {
            if (messageEl.parentNode) {
                messageEl.parentNode.removeChild(messageEl);
            }
        }, 300);
    }, 5000);
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>

{{-- ══ PAGE HERO ══════════════════════════════════════════ --}}
<div class="em-hero">
    <div class="em-hero-cover"></div>
    <div class="em-hero-body">
        <div style="display:flex;align-items:flex-end;gap:13px;">
            <div class="em-hero-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div>
                <div class="em-hero-title">Employees</div>
                <div class="em-hero-sub">Manage all employee records, profiles and salary information</div>
            </div>
        </div>
        <button class="em-btn em-btn-primary" wire:click="openCreate">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Employee
        </button>
    </div>
    <div class="em-stat-strip">
        <div class="em-stat-cell">
            <div class="em-stat-label">Total Employees</div>
            <div class="em-stat-val">{{ $totalCount }}</div>
        </div>
        <div class="em-stat-cell">
            <div class="em-stat-label">Active</div>
            <div class="em-stat-val" style="color:var(--green);">{{ $activeCount }}</div>
        </div>
        <div class="em-stat-cell">
            <div class="em-stat-label">Inactive</div>
            <div class="em-stat-val" style="color:var(--red);">{{ $inactiveCount }}</div>
        </div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="em-toolbar">
    <div class="em-search-box">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, code, email…">
    </div>
    <select class="em-filter-select" wire:model.live="filterDept">
        <option value="">All Departments</option>
        @foreach($departments as $dept)
            <option value="{{ $dept['id'] }}">{{ $dept['name'] }}</option>
        @endforeach
    </select>
    <select class="em-filter-select" wire:model.live="filterStatus">
        <option value="">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <select class="em-filter-select" wire:model.live="perPage" style="min-width:80px;">
        <option value="15">15</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
</div>

{{-- ══ EMPLOYEE TABLE ══════════════════════════════════════ --}}
<div class="em-table-card">
    <div class="em-table-wrap">
        <table class="em-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Join Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    @php
                        $initials = strtoupper(substr($emp->first_name,0,1).substr($emp->last_name,0,1));
                        $isActive = $emp->is_active ?? true;
                    @endphp
                    <tr>
                        <td>
                            <div class="em-av-cell">
                                <div class="em-av">{{ $initials }}</div>
                                <div>
                                    <div class="em-av-name">{{ $emp->first_name }} {{ $emp->last_name }}</div>
                                    <div class="em-av-code">{{ $emp->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($emp->departmentAssignment)
                                <span class="em-badge badge-dept">{{ $emp->departmentAssignment->name }}</span>
                            @else
                                <span style="color:var(--ink4);font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($emp->positionAssignment)
                                <span class="em-badge badge-pos">{{ $emp->positionAssignment->name }}</span>
                            @else
                                <span style="color:var(--ink4);font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:13px;color:var(--ink2);">{{ $emp->email }}</div>
                            <div style="font-size:11.5px;color:var(--ink4);">{{ $emp->phone_number ?? '—' }}</div>
                        </td>
                        <td style="color:var(--ink3);font-size:12.5px;">
                            {{ $emp->join_date ? $emp->join_date->format('M d, Y') : '—' }}
                        </td>
                        <td>
                            <span class="em-badge {{ $isActive ? 'badge-active' : 'badge-inactive' }}">
                                <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="em-actions">
                                <button class="em-btn em-btn-ghost em-btn-sm" wire:click="openView('{{ $emp->id }}')" title="View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="em-btn em-btn-outline em-btn-sm" wire:click="openEdit('{{ $emp->id }}')" title="Edit">
                                    <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                </button>
                                <button class="em-btn em-btn-danger em-btn-sm" wire:click="confirmDelete('{{ $emp->id }}')" title="Delete">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="em-empty">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                                <div class="em-empty-title">No employees found</div>
                                <div class="em-empty-sub">{{ $search ? 'Try a different search term.' : 'Click "Add Employee" to get started.' }}</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($employees->hasPages())
        <div class="em-pagination">
            <div class="em-page-info">
                Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }} of {{ $employees->total() }} employees
            </div>
            {{ $employees->links() }}
        </div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════
     CREATE / EDIT MODAL
══════════════════════════════════════════════════════ --}}
@if($showModal)
<div class="em-modal-bg" wire:click.self="closeModal">
    <div class="em-modal">

        {{-- Header --}}
        <div class="em-modal-hd">
            <div class="em-modal-title">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{ $editingId ? 'Edit Employee' : 'Add New Employee' }}
                @if($code)
                    <span style="font-size:12px;font-weight:600;background:rgba(255,255,255,0.18);padding:2px 10px;border-radius:100px;">{{ $code }}</span>
                @endif
            </div>
            <button class="em-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="em-tabs">
            <button class="em-tab {{ $activeTab === 'personal' ? 'active' : '' }}" wire:click="setTab('personal')">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20a8 8 0 0116 0"/></svg>
                Personal Info
            </button>
            <button class="em-tab {{ $activeTab === 'contact' ? 'active' : '' }}" wire:click="setTab('contact')">
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 .95h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                Contact &amp; Location
            </button>
            <button class="em-tab {{ $activeTab === 'salary' ? 'active' : '' }}" wire:click="setTab('salary')">
                <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                Salary &amp; Payment
            </button>
        </div>

        {{-- Body --}}
        <div class="em-modal-body">

            {{-- ─── TAB: PERSONAL ─────────────────────────────── --}}
            @if($activeTab === 'personal')

            <div class="em-section-lbl">Basic Details</div>
            <div class="em-form-grid">
                <div class="em-field">
                    <label>Employee Code</label>
                    <input type="text" wire:model="code" placeholder="EMP-0001" readonly style="background:#F0F4FA;color:var(--ink3);">
                </div>
                <div class="em-field">
                    <label>Gender <span class="req">*</span></label>
                    <select wire:model="gender">
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    @error('gender') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="em-field">
                    <label>Join Date</label>
                    <input type="date" wire:model="joinDate">
                    @error('joinDate') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="em-form-grid" style="margin-top:14px;">
                <div class="em-field">
                    <label>First Name <span class="req">*</span></label>
                    <input type="text" wire:model="firstName" placeholder="e.g. Jean">
                    @error('firstName') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="em-field">
                    <label>Middle Name</label>
                    <input type="text" wire:model="middleName" placeholder="Optional">
                </div>
                <div class="em-field">
                    <label>Last Name <span class="req">*</span></label>
                    <input type="text" wire:model="lastName" placeholder="e.g. Dupont">
                    @error('lastName') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="em-section-lbl">Identity</div>
            <div class="em-form-grid">
                <div class="em-field">
                    <label>Birth Date</label>
                    <input type="date" wire:model="birthDate">
                    @error('birthDate') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="em-field">
                    <label>Nationality</label>
                    <input type="text" wire:model="nationality" placeholder="e.g. Rwandan">
                </div>
                <div class="em-field">
                    <label>National ID</label>
                    <input type="text" wire:model="nationalId" placeholder="16-digit ID">
                    @error('nationalId') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="em-field">
                    <label>Passport Number</label>
                    <input type="text" wire:model="passportNumber" placeholder="Optional">
                </div>
                <div class="em-field">
                    <label>RSS Number</label>
                    <input type="text" wire:model="rssNumber" placeholder="Social security">
                </div>
            </div>

            <div class="em-section-lbl">Department &amp; Schedule</div>
            <div class="em-form-grid">
                <div class="em-field">
                    <label>Department</label>
                    <select wire:model="departmentId">
                        <option value="">No department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept['id'] }}">{{ $dept['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="em-field">
                    <label>Position / Role</label>
                    <select wire:model="positionId">
                        <option value="">No position</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos['id'] }}">{{ $pos['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="em-field">
                    <label>Work Shift <span class="req">*</span></label>
                    <select wire:model="shiftId">
                        <option value="">Select a shift</option>
                        @foreach($shifts as $sh)
                            <option value="{{ $sh['id'] }}">{{ $sh['name'] }}</option>
                        @endforeach
                    </select>
                    @error('shiftId') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            @endif

            {{-- ─── TAB: CONTACT ──────────────────────────────── --}}
            @if($activeTab === 'contact')

            <div class="em-section-lbl">Contact Information</div>
            <div class="em-form-grid-2">
                <div class="em-field em-col-span-2">
                    <label>Email Address <span class="req">*</span></label>
                    <input type="email" wire:model="email" placeholder="employee@company.com">
                    @error('email') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="em-field">
                    <label>Phone Number</label>
                    <input type="text" wire:model="phone" placeholder="+250 700 000 000">
                </div>
            </div>

            <div class="em-section-lbl">Address</div>
            <div class="em-form-grid">
                <div class="em-field">
                    <label>City</label>
                    <input type="text" wire:model="city" placeholder="e.g. Kigali">
                </div>
                <div class="em-field">
                    <label>State / Province</label>
                    <input type="text" wire:model="state" placeholder="e.g. Kigali City">
                </div>
                <div class="em-field">
                    <label>Country</label>
                    <input type="text" wire:model="country" placeholder="e.g. Rwanda">
                </div>
                <div class="em-field em-col-span-3">
                    <label>Street Address</label>
                    <textarea wire:model="address" placeholder="Full street address…"></textarea>
                </div>
            </div>
            @endif

            {{-- ─── TAB: SALARY ───────────────────────────────── --}}
            @if($activeTab === 'salary')

            <div class="em-section-lbl">Salary Details</div>
            <div class="em-form-grid">
                <div class="em-field">
                    <label>Basic Salary</label>
                    <input type="number" wire:model="basicSalary" placeholder="0.00" min="0" step="0.01">
                    @error('basicSalary') <span class="em-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="em-field">
                    <label>Currency</label>
                    <select wire:model="currency">
                        <option value="RWF">RWF – Rwandan Franc</option>
                        <option value="USD">USD – US Dollar</option>
                        <option value="EUR">EUR – Euro</option>
                    </select>
                </div>
                <div class="em-field">
                    <label>Effective Date</label>
                    <input type="date" wire:model="salaryEffectiveDate">
                </div>
            </div>

            <div class="em-section-lbl">Tax &amp; Deductions</div>
            <div class="em-form-grid">
                <div class="em-field">
                    <label>RSSB Rate (%)</label>
                    <input type="number" wire:model="rssbRate" placeholder="5" min="0" max="100" step="0.1">
                </div>
                <div class="em-field">
                    <label>Pension Rate (%)</label>
                    <input type="number" wire:model="pensionRate" placeholder="3" min="0" max="100" step="0.1">
                </div>
                <div class="em-field" style="display:flex;flex-direction:column;justify-content:flex-end;">
                    <div class="em-checkbox-row">
                        <input type="checkbox" id="paye" wire:model="subjectToPaye">
                        <div>
                            <label for="paye">Subject to PAYE Tax</label>
                            <span>Income tax will be applied to this employee's salary</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="em-section-lbl">Payment Method</div>
            <div class="em-pay-tabs">
                <button type="button" class="em-pay-tab {{ $paymentMethod === 'bank_transfer' ? 'active' : '' }}"
                        wire:click="$set('paymentMethod','bank_transfer')">
                    🏦 Bank Transfer
                </button>
                <button type="button" class="em-pay-tab {{ $paymentMethod === 'cash' ? 'active' : '' }}"
                        wire:click="$set('paymentMethod','cash')">
                    💵 Cash
                </button>
                <button type="button" class="em-pay-tab {{ $paymentMethod === 'mobile_money' ? 'active' : '' }}"
                        wire:click="$set('paymentMethod','mobile_money')">
                    📱 Mobile Money
                </button>
            </div>

            @if($paymentMethod === 'bank_transfer')
                <div class="em-form-grid">
                    <div class="em-field em-col-span-3">
                        <label>Bank Name</label>
                        <select wire:model="bankName">
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank }}">{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="em-field">
                        <label>Account Number</label>
                        <input type="text" wire:model="accountNumber" placeholder="Account number">
                    </div>
                    <div class="em-field">
                        <label>Bank Branch</label>
                        <input type="text" wire:model="bankBranch" placeholder="Branch name">
                    </div>
                </div>
            @elseif($paymentMethod === 'mobile_money')
                <div class="em-form-grid-2">
                    <div class="em-field">
                        <label>Mobile Money Provider</label>
                        <select wire:model="mobileMoneyProvider">
                            <option value="">Select Provider</option>
                            <option value="MTN Mobile Money">MTN Mobile Money</option>
                            <option value="Airtel Money">Airtel Money</option>
                            <option value="Tigo Cash">Tigo Cash</option>
                        </select>
                    </div>
                    <div class="em-field">
                        <label>Mobile Money Number</label>
                        <input type="text" wire:model="mobileMoneyNumber" placeholder="+250 7XX XXX XXX">
                    </div>
                </div>
            @elseif($paymentMethod === 'cash')
                <div style="background:var(--amber-lt);border:1px solid rgba(245,158,11,0.22);border-radius:var(--r);padding:13px 16px;font-size:13px;font-weight:600;color:#92400E;">
                    💵 This employee will receive their salary in cash. No bank or mobile money details required.
                </div>
            @endif
            @endif

        </div>{{-- /em-modal-body --}}

        {{-- Footer --}}
        <div class="em-modal-footer">
            <div style="display:flex;gap:8px;">
                @if($activeTab !== 'personal')
                    <button class="em-btn em-btn-outline"
                            wire:click="setTab({{ $activeTab === 'salary' ? "'contact'" : "'personal'" }})">
                        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        Back
                    </button>
                @endif
            </div>
            <div style="display:flex;gap:8px;">
                <button class="em-btn em-btn-outline" wire:click="closeModal">Cancel</button>
                @if($activeTab !== 'salary')
                    <button class="em-btn em-btn-ghost"
                            wire:click="setTab({{ $activeTab === 'personal' ? "'contact'" : "'salary'" }})">
                        Next
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                @else
                    <button class="em-btn em-btn-primary" wire:click="save">
                        <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        {{ $editingId ? 'Update Employee' : 'Create Employee' }}
                    </button>
                @endif
            </div>
        </div>

    </div>{{-- /em-modal --}}
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     VIEW MODAL
══════════════════════════════════════════════════════ --}}
@if($showView && $viewEmployee)
<div class="em-modal-bg" wire:click.self="closeView">
    <div class="em-modal" style="max-width:640px;">
        <div class="em-modal-hd">
            <div class="em-modal-title">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Employee Profile
            </div>
            <button class="em-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- View hero --}}
        <div class="em-view-hero">
            @php $vi = strtoupper(substr($viewEmployee->first_name,0,1).substr($viewEmployee->last_name,0,1)); @endphp
            <div class="em-view-av">{{ $vi }}</div>
            <div class="em-view-name">{{ $viewEmployee->first_name }} {{ $viewEmployee->middle_name }} {{ $viewEmployee->last_name }}</div>
            <div class="em-view-meta">
                <span class="em-badge badge-dept" style="font-size:12px;">{{ $viewEmployee->code }}</span>
                @if($viewEmployee->position_id)
                    @php $pos = \App\Models\Position::find($viewEmployee->position_id); @endphp
                    @if($pos)
                        <span class="em-badge badge-pos">{{ $pos->name }}</span>
                    @endif
                @endif
                @if($viewEmployee->department_id)
                    @php $dept = \App\Models\Department::find($viewEmployee->department_id); @endphp
                    @if($dept)
                        <span class="em-badge badge-dept">{{ $dept->name }}</span>
                    @endif
                @endif
                <span class="em-badge {{ ($viewEmployee->is_active ?? true) ? 'badge-active' : 'badge-inactive' }}">
                    <svg viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>
                    {{ ($viewEmployee->is_active ?? true) ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <div style="padding:16px 22px;overflow-y:auto;max-height:420px;">

            <div class="em-section-lbl">Personal</div>
            <div class="em-view-info-grid">
                <div class="em-view-row"><div class="em-view-label">Gender</div><div class="em-view-value">{{ ucfirst($viewEmployee->gender ?? '—') }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Birth Date</div><div class="em-view-value">{{ $viewEmployee->birth_date?->format('M d, Y') ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Nationality</div><div class="em-view-value">{{ $viewEmployee->nationality ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">National ID</div><div class="em-view-value">{{ $viewEmployee->national_id ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Passport</div><div class="em-view-value">{{ $viewEmployee->passport_number ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">RSS Number</div><div class="em-view-value">{{ $viewEmployee->rss_number ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Join Date</div><div class="em-view-value">{{ $viewEmployee->join_date?->format('M d, Y') ?? '—' }}</div></div>
            </div>

            <div class="em-section-lbl" style="margin-top:14px;">Contact</div>
            <div class="em-view-info-grid">
                <div class="em-view-row"><div class="em-view-label">Email</div><div class="em-view-value">{{ $viewEmployee->email ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Phone</div><div class="em-view-value">{{ $viewEmployee->phone_number ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">City</div><div class="em-view-value">{{ $viewEmployee->city ?? '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Country</div><div class="em-view-value">{{ $viewEmployee->country ?? '—' }}</div></div>
                <div class="em-view-row em-col-span-2"><div class="em-view-label">Address</div><div class="em-view-value">{{ $viewEmployee->address ?? '—' }}</div></div>
            </div>

            <div class="em-section-lbl" style="margin-top:14px;">Emergency Contacts</div>
            @if($viewEmployee->emergencyContacts && $viewEmployee->emergencyContacts->count() > 0)
                @foreach($viewEmployee->emergencyContacts as $contact)
                    <div class="em-emergency-contact" style="background: var(--bg); border: 1px solid var(--border); border-radius: var(--r); padding: 12px; margin-bottom: 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                    <div style="font-weight: 700; color: var(--ink2); font-size: 14px;">{{ $contact->name }}</div>
                                    @if($contact->is_primary)
                                        <span style="background: var(--green-lt); color: var(--green); padding: 2px 8px; border-radius: 100px; font-size: 10px; font-weight: 600;">PRIMARY</span>
                                    @endif
                                </div>
                                <div style="font-size: 12px; color: var(--ink3); margin-bottom: 4px;">{{ $contact->relationship }}</div>
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    @if($contact->phone)
                                        <div style="font-size: 12px; color: var(--ink2);">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; margin-right: 4px;">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                            </svg>
                                            {{ $contact->phone }}
                                        </div>
                                    @endif
                                    @if($contact->email)
                                        <div style="font-size: 12px; color: var(--ink2);">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; margin-right: 4px;">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                            {{ $contact->email }}
                                        </div>
                                    @endif
                                    @if($contact->address)
                                        <div style="font-size: 12px; color: var(--ink2);">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; margin-right: 4px;">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            {{ $contact->address }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 20px; color: var(--ink4); font-size: 13px; font-style: italic; background: var(--bg); border-radius: var(--r); border: 1px solid var(--border);">
                    No emergency contacts on record
                </div>
            @endif

            <div class="em-section-lbl" style="margin-top:14px;">Salary</div>
            <div class="em-view-info-grid">
                <div class="em-view-row"><div class="em-view-label">Basic Salary</div><div class="em-view-value">{{ $viewEmployee->currency ?? 'RWF' }} {{ $viewEmployee->basic_salary ? number_format($viewEmployee->basic_salary,2) : '—' }}</div></div>
                <div class="em-view-row"><div class="em-view-label">Payment Method</div><div class="em-view-value">{{ ucfirst(str_replace('_',' ',$viewEmployee->payment_method ?? '—')) }}</div></div>
                <div class="em-view-row"><div class="em-view-label">RSSB Rate</div><div class="em-view-value">{{ $viewEmployee->rssb_rate ?? '—' }}%</div></div>
                <div class="em-view-row"><div class="em-view-label">Pension Rate</div><div class="em-view-value">{{ $viewEmployee->pension_rate ?? '—' }}%</div></div>
                <div class="em-view-row"><div class="em-view-label">PAYE Tax</div><div class="em-view-value">{{ ($viewEmployee->subject_to_paye ?? true) ? 'Yes' : 'No' }}</div></div>
                @if($viewEmployee->payment_method === 'bank_transfer')
                    <div class="em-view-row"><div class="em-view-label">Bank</div><div class="em-view-value">{{ $viewEmployee->bank_name ?? '—' }}</div></div>
                    <div class="em-view-row"><div class="em-view-label">Account No.</div><div class="em-view-value">{{ $viewEmployee->account_number ?? '—' }}</div></div>
                @elseif($viewEmployee->payment_method === 'mobile_money')
                    <div class="em-view-row"><div class="em-view-label">Provider</div><div class="em-view-value">{{ $viewEmployee->mobile_money_provider ?? '—' }}</div></div>
                    <div class="em-view-row"><div class="em-view-label">Mobile No.</div><div class="em-view-value">{{ $viewEmployee->mobile_money_number ?? '—' }}</div></div>
                @endif
            </div>

        </div>

        <div class="em-modal-footer" style="justify-content:flex-end;">
            <button class="em-btn em-btn-outline" wire:click="closeView">Close</button>
            <button class="em-btn em-btn-primary" wire:click="openEdit('{{ $viewEmployee->id }}'); closeView()">
                <svg viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                Edit
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     DELETE CONFIRM MODAL
══════════════════════════════════════════════════════ --}}
@if($showDelete)
<div class="em-modal-bg" wire:click.self="cancelDelete">
    <div class="em-modal em-modal-sm">
        <div class="em-modal-hd" style="background:linear-gradient(105deg,#991B1B,var(--red));">
            <div class="em-modal-title">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                Delete Employee
            </div>
            <button class="em-modal-close" wire:click="cancelDelete">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="em-modal-body" style="text-align:center;padding:28px 24px;">
            <div class="em-delete-icon">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:800;color:var(--ink);margin-bottom:8px;">Are you sure?</div>
            <p style="font-size:13.5px;color:var(--ink3);font-weight:500;line-height:1.6;margin:0;">
                This will permanently delete the employee record and all associated data. This action cannot be undone.
            </p>
        </div>
        <div class="em-modal-footer" style="justify-content:center;gap:12px;">
            <button class="em-btn em-btn-outline" wire:click="cancelDelete">Cancel, Keep It</button>
            <button class="em-btn em-btn-danger" wire:click="deleteEmployee">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>
@endif

</div>{{-- /em-root --}}