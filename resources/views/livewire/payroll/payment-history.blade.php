<div class="ph-root">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

/* ══ TOKENS ══════════════════════════════════════════════ */
.ph-root {
    --blue:     #3B6FE8; --blue-2:   #2755CC; --blue-3:   #1A3FA8;
    --blue-lt:  rgba(59,111,232,0.09); --blue-mid: rgba(59,111,232,0.18);
    --blue-brd: rgba(59,111,232,0.22);
    --green:    #12B76A; --green-lt: rgba(18,183,106,0.10);
    --amber:    #F59E0B; --amber-lt: rgba(245,158,11,0.10);
    --red:      #EF4444; --red-lt:   rgba(239,68,68,0.09);
    --purple:   #7C3AED; --purple-lt:rgba(124,58,237,0.09);
    --teal:     #0BB5B5; --teal-lt:  rgba(11,181,181,0.10);
    --bg:       #F0F4FA; --white:    #FFFFFF;
    --ink:      #0F1629; --ink2:     #2D3356; --ink3:     #6B7094; --ink4:     #A8ADCA;
    --border:   rgba(15,22,41,0.08);
    --sh-sm:    0 2px 10px rgba(59,111,232,0.07);
    --sh-md:    0 8px 28px rgba(59,111,232,0.12);
    --sh-lg:    0 18px 52px rgba(59,111,232,0.16);
    --r: 12px; --r-lg: 18px;
    font-family: 'DM Sans', -apple-system, sans-serif;
    background: var(--bg); min-height: 100vh; color: var(--ink);
    padding: 24px 28px 48px; display: flex; flex-direction: column; gap: 20px;
}

/* ══ FLASH ═══════════════════════════════════════════════ */
.ph-flash { padding: 12px 18px; border-radius: var(--r); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 9px; }
.ph-flash-ok  { background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); color: #087A42; }
.ph-flash-err { background: var(--red-lt);   border: 1px solid rgba(239,68,68,0.22);  color: #991B1B; }
.ph-flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* ══ HERO ════════════════════════════════════════════════ */
.ph-hero { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
.ph-hero-cover { height: 72px; background: linear-gradient(118deg,#1A3FA8 0%,#2755CC 36%,#3B6FE8 66%,#12B76A 100%); position: relative; overflow: hidden; }
.ph-hero-cover::before { content:''; position:absolute; top:-40px; right:80px; width:200px; height:200px; border-radius:50%; background:rgba(255,255,255,0.06); }
.ph-hero-cover::after  { content:''; position:absolute; bottom:-30px; left:40px; width:130px; height:130px; border-radius:50%; background:rgba(255,255,255,0.04); }
.ph-hero-body { padding: 0 24px 20px; display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; margin-top: -26px; }
.ph-hero-icon { width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg,var(--green),#0DD47A); border: 3px solid var(--white); box-shadow: 0 4px 14px rgba(18,183,106,0.30); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ph-hero-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 1.75; }
.ph-hero-title { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 800; color: var(--ink); letter-spacing: -0.3px; }
.ph-hero-sub   { font-size: 12.5px; color: var(--ink3); margin-top: 2px; }

/* ── Summary tiles ──────────────────────────────────────── */
.ph-tiles { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
.ph-tile  { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); padding: 16px; display: flex; align-items: flex-start; gap: 12px; position: relative; overflow: hidden; }
.ph-tile-bar  { position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 20px 0 0 20px; }
.ph-tile-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ph-tile-icon svg { width: 16px; height: 16px; fill: none; stroke-width: 2; }
.ph-tile-lbl  { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--ink4); margin-bottom: 3px; }
.ph-tile-val  { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: var(--ink); letter-spacing: -0.4px; line-height: 1; }
.ph-tile-sub  { font-size: 11px; color: var(--ink4); margin-top: 3px; }
.ph-t-blue  .ph-tile-bar { background: var(--blue);  } .ph-t-blue  .ph-tile-icon { background: var(--blue-lt);  } .ph-t-blue  .ph-tile-icon svg { stroke: var(--blue);  } .ph-t-blue  .ph-tile-val { color: var(--blue-2); }
.ph-t-green .ph-tile-bar { background: var(--green); } .ph-t-green .ph-tile-icon { background: var(--green-lt); } .ph-t-green .ph-tile-icon svg { stroke: var(--green); } .ph-t-green .ph-tile-val { color: var(--green);   }
.ph-t-amber .ph-tile-bar { background: var(--amber); } .ph-t-amber .ph-tile-icon { background: var(--amber-lt); } .ph-t-amber .ph-tile-icon svg { stroke: var(--amber); } .ph-t-amber .ph-tile-val { color: var(--amber);   }
.ph-t-teal  .ph-tile-bar { background: var(--teal);  } .ph-t-teal  .ph-tile-icon { background: var(--teal-lt);  } .ph-t-teal  .ph-tile-icon svg { stroke: var(--teal);  } .ph-t-teal  .ph-tile-val { color: var(--teal);    }

/* ══ TOOLBAR ═════════════════════════════════════════════ */
.ph-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); padding: 14px 18px; }
.ph-search { display: flex; align-items: center; gap: 8px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 13px; flex: 1; min-width: 200px; transition: border-color .15s, box-shadow .15s; }
.ph-search:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); }
.ph-search svg { width: 14px; height: 14px; stroke: var(--ink4); fill: none; flex-shrink: 0; }
.ph-search input { border: none; background: transparent; font-size: 13.5px; color: var(--ink); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
.ph-search input::placeholder { color: var(--ink4); }
.ph-sel { background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 30px 8px 12px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; cursor: pointer; font-family: 'DM Sans', sans-serif; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; -webkit-appearance: none; transition: border-color .15s; }
.ph-sel:focus { border-color: var(--blue); }

/* ══ BUTTONS ═════════════════════════════════════════════ */
.ph-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all .15s; white-space: nowrap; }
.ph-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.ph-btn-primary { background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(59,111,232,0.28); }
.ph-btn-primary:hover { background: var(--blue-2); transform: translateY(-1px); }
.ph-btn-ghost   { background: var(--blue-lt); color: var(--blue); border: 1px solid var(--blue-brd); }
.ph-btn-ghost:hover   { background: var(--blue-mid); }
.ph-btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }
.ph-btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.ph-btn-green  { background: var(--green-lt); color: #087A42; border: 1px solid rgba(18,183,106,0.22); }
.ph-btn-green:hover  { background: rgba(18,183,106,0.16); }
.ph-btn-danger { background: var(--red-lt); color: var(--red); border: 1px solid rgba(239,68,68,0.22); }
.ph-btn-danger:hover { background: rgba(239,68,68,0.15); }
.ph-btn-sm { padding: 5px 11px; font-size: 12px; }

/* ══ BADGE ═══════════════════════════════════════════════ */
.ph-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
.pb-green  { background: var(--green-lt);  color: #087A42; }
.pb-amber  { background: var(--amber-lt);  color: #92400E; }
.pb-red    { background: var(--red-lt);    color: #991B1B; }
.pb-blue   { background: var(--blue-lt);   color: var(--blue-2); }
.pb-purple { background: var(--purple-lt); color: var(--purple); }
.pb-teal   { background: var(--teal-lt);   color: #0E7490; }
.pb-gray   { background: var(--bg); color: var(--ink3); border: 1px solid var(--border); }

/* ── Method icon badge ────────────────────────────────── */
.ph-method { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 8px; font-size: 11.5px; font-weight: 700; }
.ph-method svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2; }
.ph-method-bank   { background: var(--blue-lt);   color: var(--blue-2); }
.ph-method-cash   { background: var(--green-lt);  color: #087A42; }
.ph-method-cheque { background: var(--purple-lt); color: var(--purple); }
.ph-method-mobile { background: var(--teal-lt);   color: #0E7490; }
.ph-method-other  { background: var(--bg);         color: var(--ink3); border: 1px solid var(--border); }

/* ══ TABLE CARD ══════════════════════════════════════════ */
.ph-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
.ph-card-hd { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid var(--border); }
.ph-card-hd-left { display: flex; align-items: center; gap: 9px; }
.ph-card-ico { width: 30px; height: 30px; border-radius: 8px; background: var(--green-lt); border: 1px solid rgba(18,183,106,0.22); display: flex; align-items: center; justify-content: center; }
.ph-card-ico svg { width: 14px; height: 14px; stroke: var(--green); fill: none; stroke-width: 2; }
.ph-card-title { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.ph-card-sub   { font-size: 11.5px; color: var(--ink4); margin-top: 1px; }
.ph-table-wrap { overflow-x: auto; }
table.ph-table { width: 100%; border-collapse: collapse; }
.ph-table thead tr { background: #FAFBFF; border-bottom: 1px solid var(--border); }
.ph-table th { padding: 10px 16px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); text-align: left; white-space: nowrap; }
.ph-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
.ph-table tbody tr:last-child { border-bottom: none; }
.ph-table tbody tr:hover { background: #F8FAFF; }
.ph-table td { padding: 12px 16px; font-size: 13px; color: var(--ink2); }
.ph-code { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 800; background: var(--blue-lt); color: var(--blue-2); border: 1px solid var(--blue-brd); padding: 3px 9px; border-radius: 7px; letter-spacing: .04em; }
.ph-emp-cell { display: flex; align-items: center; gap: 9px; }
.ph-emp-av { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,var(--blue),#6B4FDB); display: flex; align-items: center; justify-content: center; font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 800; color: #fff; flex-shrink: 0; }
.ph-emp-name { font-size: 13px; font-weight: 700; color: var(--ink); }
.ph-emp-dept { font-size: 11px; color: var(--ink4); }
.ph-amount { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800; color: var(--ink); }
.ph-currency { font-size: 10.5px; font-weight: 700; color: var(--ink4); }
.ph-actions { display: flex; gap: 5px; align-items: center; }

/* ══ EMPTY ═══════════════════════════════════════════════ */
.ph-empty { padding: 56px 32px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 10px; }
.ph-empty-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--green-lt); display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.ph-empty-icon svg { width: 22px; height: 22px; stroke: var(--green); fill: none; stroke-width: 1.5; }
.ph-empty-ttl { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: var(--ink2); }
.ph-empty-sub { font-size: 13px; color: var(--ink4); }

/* ══ MODAL ═══════════════════════════════════════════════ */
.ph-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.52); backdrop-filter: blur(10px); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 16px; }
.ph-modal { background: var(--white); border-radius: var(--r-lg); box-shadow: var(--sh-lg); border: 1px solid var(--border); width: 100%; max-width: 680px; max-height: 93vh; overflow-y: auto; display: flex; flex-direction: column; }
.ph-modal-lg { max-width: 760px; }
.ph-modal-hd { background: linear-gradient(105deg,var(--blue-3),var(--blue) 60%,#12B76A 130%); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 2; }
.ph-modal-hd-left { display: flex; align-items: center; gap: 12px; }
.ph-modal-hd-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; }
.ph-modal-hd-icon svg { width: 17px; height: 17px; stroke: #fff; fill: none; stroke-width: 2; }
.ph-modal-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: #fff; }
.ph-modal-sub   { font-size: 12px; color: rgba(255,255,255,.65); margin-top: 1px; }
.ph-modal-close { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.18); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; flex-shrink: 0; }
.ph-modal-close:hover { background: rgba(255,255,255,0.30); }
.ph-modal-close svg { width: 14px; height: 14px; stroke: #fff; fill: none; stroke-width: 2.5; }

/* ── Tab strip inside modal ───────────────────────────── */
.ph-tabs { display: flex; gap: 2px; padding: 14px 24px 0; border-bottom: 1px solid var(--border); background: var(--white); flex-shrink: 0; }
.ph-tab { padding: 8px 16px; border-radius: 10px 10px 0 0; font-size: 13px; font-weight: 700; cursor: pointer; border: none; background: none; font-family: 'DM Sans', sans-serif; color: var(--ink3); position: relative; transition: color .15s; }
.ph-tab.active { color: var(--blue); background: var(--blue-lt); }
.ph-tab.active::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: var(--blue); border-radius: 2px 2px 0 0; }
.ph-tab-panel { display: none; }
.ph-tab-panel.active { display: flex; flex-direction: column; gap: 14px; }

.ph-modal-body { padding: 20px 24px; display: flex; flex-direction: column; gap: 0; }
.ph-modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; position: sticky; bottom: 0; background: var(--white); z-index: 2; }

/* ── Fields ─────────────────────────────────────────── */
.ph-field { display: flex; flex-direction: column; gap: 5px; }
.ph-field label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .09em; color: var(--ink4); }
.ph-field label .req { color: var(--red); }
.ph-field input, .ph-field select, .ph-field textarea {
    width: 100%; padding: 9px 13px; box-sizing: border-box;
    background: #F6F8FC; border: 1.5px solid var(--border); border-radius: var(--r);
    font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--ink);
    outline: none; transition: border-color .15s, box-shadow .15s;
}
.ph-field input:focus, .ph-field select:focus, .ph-field textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,111,232,0.09); background: var(--white); }
.ph-field textarea { resize: vertical; min-height: 80px; }
.ph-field-err { font-size: 11.5px; color: var(--red); font-weight: 600; margin-top: 2px; }
.ph-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.ph-grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.ph-section-lbl { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .10em; color: var(--ink4); padding: 4px 0 2px; border-bottom: 1px solid var(--border); }

/* ══ VIEW MODAL ══════════════════════════════════════════ */
.ph-view-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.ph-view-row  { display: flex; flex-direction: column; gap: 3px; padding: 10px 14px; background: var(--bg); border-radius: 10px; border: 1px solid var(--border); }
.ph-view-row.full { grid-column: 1 / -1; }
.ph-view-lbl  { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--ink4); }
.ph-view-val  { font-size: 13.5px; font-weight: 600; color: var(--ink); }

/* ══ DELETE ══════════════════════════════════════════════ */
.ph-del-modal { max-width: 420px; }
.ph-del-body  { padding: 28px 26px; text-align: center; }
.ph-del-icon  { width: 52px; height: 52px; border-radius: 50%; background: var(--red-lt); border: 1px solid rgba(239,68,68,0.22); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
.ph-del-icon svg { width: 22px; height: 22px; stroke: var(--red); fill: none; stroke-width: 2; }
.ph-del-ttl   { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 8px; }
.ph-del-sub   { font-size: 13px; color: var(--ink3); line-height: 1.6; }

/* ══ PAGINATION ══════════════════════════════════════════ */
.ph-pager { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.ph-pager-info { font-size: 12.5px; color: var(--ink4); font-weight: 600; }

@media (max-width: 768px) { .ph-grid2,.ph-grid3 { grid-template-columns: 1fr; } .ph-view-grid { grid-template-columns: 1fr; } .ph-tiles { grid-template-columns: 1fr 1fr; } }
@media (max-width: 480px) { .ph-tiles { grid-template-columns: 1fr; } .ph-tabs { overflow-x: auto; } }
</style>

{{-- ── Flash ────────────────────────────────────────────── --}}
@if(session()->has('success'))
    <div class="ph-flash ph-flash-ok">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="ph-flash ph-flash-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ══ HERO ════════════════════════════════════════════════ --}}
<div class="ph-hero">
    <div class="ph-hero-cover"></div>
    <div class="ph-hero-body">
        <div style="display:flex;align-items:flex-end;gap:14px;">
            <div class="ph-hero-icon">
                <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <div>
                <div class="ph-hero-title">Payment History</div>
                <div class="ph-hero-sub">Track all employee payment transactions, approvals and references</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;padding-bottom:4px;">
            <button class="ph-btn ph-btn-primary" wire:click="openCreate">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Payment
            </button>
        </div>
    </div>
</div>

{{-- ══ STAT TILES ══════════════════════════════════════════ --}}
<div class="ph-tiles">
    <div class="ph-tile ph-t-blue">
        <div class="ph-tile-bar"></div>
        <div class="ph-tile-icon"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div>
        <div>
            <div class="ph-tile-lbl">Total Records</div>
            <div class="ph-tile-val">{{ $totalCount }}</div>
            <div class="ph-tile-sub">all payments</div>
        </div>
    </div>
    <div class="ph-tile ph-t-green">
        <div class="ph-tile-bar"></div>
        <div class="ph-tile-icon"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div>
            <div class="ph-tile-lbl">Completed</div>
            <div class="ph-tile-val">{{ $completedCount }}</div>
            <div class="ph-tile-sub">successful</div>
        </div>
    </div>
    <div class="ph-tile ph-t-amber">
        <div class="ph-tile-bar"></div>
        <div class="ph-tile-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div>
            <div class="ph-tile-lbl">Pending</div>
            <div class="ph-tile-val">{{ $pendingCount }}</div>
            <div class="ph-tile-sub">awaiting processing</div>
        </div>
    </div>
    <div class="ph-tile ph-t-teal">
        <div class="ph-tile-bar"></div>
        <div class="ph-tile-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <div>
            <div class="ph-tile-lbl">Total Paid (RWF)</div>
            <div class="ph-tile-val" style="font-size:16px;">{{ number_format($totalPaid, 0) }}</div>
            <div class="ph-tile-sub">completed payments</div>
        </div>
    </div>
</div>

{{-- ══ TOOLBAR ════════════════════════════════════════════ --}}
<div class="ph-toolbar">
    <div class="ph-search">
        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" wire:model.live.debounce.300ms="search"
               placeholder="Search code, employee, reference, bank…">
    </div>
    <select class="ph-sel" wire:model.live="filterMethod">
        <option value="">All Methods</option>
        @foreach($paymentMethods as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="ph-sel" wire:model.live="filterStatus">
        <option value="">All Statuses</option>
        @foreach($statuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    <select class="ph-sel" wire:model.live="filterApproval">
        <option value="">All Approvals</option>
        @foreach($approvalStatuses as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
</div>

{{-- ══ TABLE ═══════════════════════════════════════════════ --}}
<div class="ph-card">
    <div class="ph-card-hd">
        <div class="ph-card-hd-left">
            <div class="ph-card-ico">
                <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <div>
                <div class="ph-card-title">Payment Records</div>
                <div class="ph-card-sub">{{ $records->total() }} record{{ $records->total() != 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>

    <div class="ph-table-wrap">
        <table class="ph-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Employee</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Reference</th>
                    <th>Status</th>
                    <th>Approval</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $row)
                    @php
                        $emp     = $row->employee;
                        $empInit = $emp ? strtoupper(substr($emp->first_name??'',0,1).substr($emp->last_name??'',0,1)) : '??';
                        $method  = $row->payment_method instanceof \BackedEnum ? $row->payment_method->value : ($row->payment_method ?? '');
                        $st      = $row->status instanceof \BackedEnum ? $row->status->value : ($row->status ?? 'pending');
                        $appr    = $row->approval_status instanceof \BackedEnum ? $row->approval_status->value : ($row->approval_status ?? 'pending');
                        $stClass = match($st) { 'completed'=>'pb-green','failed'=>'pb-red','reversed'=>'pb-red', default=>'pb-amber' };
                        $apClass = match($appr) { 'approved'=>'pb-green','rejected'=>'pb-red','cancelled'=>'pb-red', 'draft'=>'pb-gray', default=>'pb-amber' };
                        $mClass  = match($method) { 'bank_transfer'=>'ph-method-bank','cash'=>'ph-method-cash','cheque'=>'ph-method-cheque','mobile_money'=>'ph-method-mobile', default=>'ph-method-other' };
                    @endphp
                    <tr>
                        <td><span class="ph-code">{{ $row->code }}</span></td>
                        <td>
                            <div class="ph-emp-cell">
                                <div class="ph-emp-av">{{ $empInit }}</div>
                                <div>
                                    <div class="ph-emp-name">{{ $emp ? trim(($emp->first_name??'').' '.($emp->last_name??'')) : '—' }}</div>
                                    <div class="ph-emp-dept">{{ $emp?->department?->name ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="ph-method {{ $mClass }}">
                                <svg viewBox="0 0 24 24">
                                    @if($method === 'bank_transfer')<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                    @elseif($method === 'cash')<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                                    @elseif($method === 'cheque')<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
                                    @elseif($method === 'mobile_money')<rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
                                    @else<circle cx="12" cy="12" r="10"/>@endif
                                </svg>
                                {{ $paymentMethods[$method] ?? ucfirst(str_replace('_',' ',$method)) }}
                            </span>
                        </td>
                        <td>
                            <div class="ph-amount">{{ number_format($row->amount_paid, 2) }}</div>
                            <div class="ph-currency">{{ $row->currency }}</div>
                        </td>
                        <td style="font-weight:600;color:var(--ink2);white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($row->payment_date)->format('M d, Y') }}
                        </td>
                        <td style="font-size:12px;color:var(--ink3);max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $row->transaction_reference ?: '—' }}
                        </td>
                        <td><span class="ph-badge {{ $stClass }}">{{ ucfirst($st) }}</span></td>
                        <td><span class="ph-badge {{ $apClass }}">{{ ucfirst($appr) }}</span></td>
                        <td>
                            <div class="ph-actions">
                                <button class="ph-btn ph-btn-ghost ph-btn-sm" wire:click="openView({{ $row->id }})" title="View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="ph-btn ph-btn-outline ph-btn-sm" wire:click="openEdit({{ $row->id }})" title="Edit">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                @if($appr !== 'approved')
                                <button class="ph-btn ph-btn-green ph-btn-sm" wire:click="approve({{ $row->id }})"
                                        wire:confirm="Approve this payment?" title="Approve">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </button>
                                @endif
                                <button class="ph-btn ph-btn-danger ph-btn-sm" wire:click="confirmDelete({{ $row->id }})" title="Delete">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="ph-empty">
                                <div class="ph-empty-icon">
                                    <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                </div>
                                <div class="ph-empty-ttl">No payment records found</div>
                                <div class="ph-empty-sub">{{ $search || $filterStatus || $filterApproval || $filterMethod ? 'Try adjusting your filters.' : 'Create the first payment record to get started.' }}</div>
                                @unless($search || $filterStatus || $filterApproval || $filterMethod)
                                    <button class="ph-btn ph-btn-primary" wire:click="openCreate" style="margin-top:8px;">
                                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Add First Payment
                                    </button>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($records->hasPages())
        <div class="ph-pager">
            <div class="ph-pager-info">Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of {{ $records->total() }}</div>
            {{ $records->links() }}
        </div>
    @endif
</div>

{{-- ══ CREATE / EDIT MODAL (3 tabs) ═══════════════════════ --}}
@if($showModal)
<div class="ph-modal-bg" wire:click.self="closeModal">
    <div class="ph-modal ph-modal-lg">

        <div class="ph-modal-hd">
            <div class="ph-modal-hd-left">
                <div class="ph-modal-hd-icon">
                    <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
                <div>
                    <div class="ph-modal-title">{{ $editingId ? 'Edit Payment Record' : 'New Payment Record' }}</div>
                    <div class="ph-modal-sub">{{ $editingId ? 'Update payment details' : 'Record a new employee payment' }}</div>
                </div>
            </div>
            <button class="ph-modal-close" wire:click="closeModal">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Tab nav --}}
        <div class="ph-tabs" id="phModalTabs">
            <button class="ph-tab active" onclick="phTab('basic',this)">Basic Info</button>
            <button class="ph-tab" onclick="phTab('banking',this)">Banking Details</button>
            <button class="ph-tab" onclick="phTab('status',this)">Status & Links</button>
        </div>

        <div class="ph-modal-body">

            {{-- Tab 1 — Basic Info --}}
            <div class="ph-tab-panel active" id="phTab-basic">
                <div class="ph-grid2">
                    <div class="ph-field">
                        <label>Code <span class="req">*</span></label>
                        <input type="text" wire:model="code" placeholder="PAY-00001" style="text-transform:uppercase;">
                        @error('code')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="ph-field">
                        <label>Employee <span class="req">*</span></label>
                        <select wire:model="employeeId">
                            <option value="">— Select employee —</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp['id'] }}">{{ $emp['first_name'] }} {{ $emp['last_name'] }}</option>
                            @endforeach
                        </select>
                        @error('employeeId')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="ph-grid3">
                    <div class="ph-field">
                        <label>Amount Paid <span class="req">*</span></label>
                        <input type="number" wire:model="amountPaid" placeholder="0.00" step="0.01" min="0">
                        @error('amountPaid')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="ph-field">
                        <label>Currency <span class="req">*</span></label>
                        <select wire:model="currency">
                            @foreach($currencies as $cur)
                                <option value="{{ $cur }}">{{ $cur }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ph-field">
                        <label>Payment Date <span class="req">*</span></label>
                        <input type="date" wire:model="paymentDate">
                        @error('paymentDate')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="ph-grid2">
                    <div class="ph-field">
                        <label>Payment Method <span class="req">*</span></label>
                        <select wire:model="paymentMethod">
                            <option value="">— Select method —</option>
                            @foreach($paymentMethods as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('paymentMethod')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="ph-field">
                        <label>Transaction Reference</label>
                        <input type="text" wire:model="transactionReference" placeholder="e.g. TXN-20250401-001">
                        @error('transactionReference')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="ph-field">
                    <label>Notes</label>
                    <textarea wire:model="notes" placeholder="Optional payment notes…"></textarea>
                    @error('notes')<div class="ph-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Tab 2 — Banking Details --}}
            <div class="ph-tab-panel" id="phTab-banking">
                <div style="background:var(--blue-lt);border:1px solid var(--blue-brd);border-radius:var(--r);padding:11px 14px;font-size:12.5px;color:var(--blue-2);font-weight:600;">
                    Fill in the fields that apply to the selected payment method.
                </div>
                <div class="ph-grid2">
                    <div class="ph-field">
                        <label>Bank Name</label>
                        <input type="text" wire:model="bankName" placeholder="e.g. Bank of Kigali">
                        @error('bankName')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="ph-field">
                        <label>Account Number</label>
                        <input type="text" wire:model="accountNumber" placeholder="e.g. 000123456789">
                        @error('accountNumber')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="ph-field">
                    <label>Cheque Number</label>
                    <input type="text" wire:model="chequeNumber" placeholder="e.g. CHQ-0001 (for cheque payments)">
                    @error('chequeNumber')<div class="ph-field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Tab 3 — Status & Links --}}
            <div class="ph-tab-panel" id="phTab-status">
                <div class="ph-section-lbl">Status</div>
                <div class="ph-grid2">
                    <div class="ph-field">
                        <label>Payment Status <span class="req">*</span></label>
                        <select wire:model="status">
                            @foreach($statuses as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="ph-field">
                        <label>Approval Status <span class="req">*</span></label>
                        <select wire:model="approvalStatus">
                            @foreach($approvalStatuses as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('approvalStatus')<div class="ph-field-err">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="ph-section-lbl" style="margin-top:4px;">Linked Records</div>
                <div class="ph-grid2">
                    <div class="ph-field">
                        <label>Payroll Entry</label>
                        <select wire:model="payrollEntryId">
                            <option value="">— None —</option>
                            @foreach($payrollEntries as $pe)
                                @php
                                    $peEmp = is_array($pe['employee'] ?? null) ? ($pe['employee']['first_name']??'').' '.($pe['employee']['last_name']??'') : '—';
                                @endphp
                                <option value="{{ $pe['id'] }}">{{ $pe['code'] ?? '#'.$pe['id'] }} — {{ trim($peEmp) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ph-field">
                        <label>Payslip Entry</label>
                        <select wire:model="payslipEntryId">
                            <option value="">— None —</option>
                            @foreach($payslipEntries as $pse)
                                <option value="{{ $pse['id'] }}">{{ $pse['code'] ?? '#'.$pse['id'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>{{-- /ph-modal-body --}}

        <div class="ph-modal-footer">
            <button class="ph-btn ph-btn-outline" wire:click="closeModal">Cancel</button>
            <button class="ph-btn ph-btn-primary" wire:click="save" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update' : 'Create' }} Payment</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══ VIEW MODAL ══════════════════════════════════════════ --}}
@if($showView && $viewRecord)
<div class="ph-modal-bg" wire:click.self="closeView">
    <div class="ph-modal ph-modal-lg">

        <div class="ph-modal-hd">
            <div class="ph-modal-hd-left">
                <div class="ph-modal-hd-icon">
                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <div>
                    <div class="ph-modal-title">{{ $viewRecord->code }}</div>
                    <div class="ph-modal-sub">Payment Record Details</div>
                </div>
            </div>
            <button class="ph-modal-close" wire:click="closeView">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="ph-modal-body" style="padding-top:20px;">
            @php
                $vEmp    = $viewRecord->employee;
                $vEmpN   = $vEmp ? trim(($vEmp->first_name??'').' '.($vEmp->last_name??'')) : '—';
                $vMethod = $viewRecord->payment_method instanceof \BackedEnum ? $viewRecord->payment_method->value : ($viewRecord->payment_method ?? '');
                $vSt     = $viewRecord->status instanceof \BackedEnum ? $viewRecord->status->value : ($viewRecord->status ?? '');
                $vAp     = $viewRecord->approval_status instanceof \BackedEnum ? $viewRecord->approval_status->value : ($viewRecord->approval_status ?? '');
                $vStCls  = match($vSt) { 'completed'=>'pb-green','failed'=>'pb-red','reversed'=>'pb-red', default=>'pb-amber' };
                $vApCls  = match($vAp) { 'approved'=>'pb-green','rejected'=>'pb-red','cancelled'=>'pb-red','draft'=>'pb-gray', default=>'pb-amber' };
            @endphp

            <div class="ph-view-grid">
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Code</div>
                    <div class="ph-view-val"><span class="ph-code">{{ $viewRecord->code }}</span></div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Employee</div>
                    <div class="ph-view-val">{{ $vEmpN }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Amount Paid</div>
                    <div class="ph-view-val" style="font-family:'Sora',sans-serif;font-size:18px;color:var(--green);">
                        {{ number_format($viewRecord->amount_paid, 2) }}
                        <span style="font-size:12px;color:var(--ink4);font-family:'DM Sans',sans-serif;">{{ $viewRecord->currency }}</span>
                    </div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Payment Date</div>
                    <div class="ph-view-val">{{ \Carbon\Carbon::parse($viewRecord->payment_date)->format('l, M d, Y') }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Payment Method</div>
                    <div class="ph-view-val">{{ $paymentMethods[$vMethod] ?? ucfirst(str_replace('_',' ',$vMethod)) }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Transaction Reference</div>
                    <div class="ph-view-val">{{ $viewRecord->transaction_reference ?: '—' }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Bank Name</div>
                    <div class="ph-view-val">{{ $viewRecord->bank_name ?: '—' }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Account Number</div>
                    <div class="ph-view-val">{{ $viewRecord->account_number ?: '—' }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Cheque Number</div>
                    <div class="ph-view-val">{{ $viewRecord->cheque_number ?: '—' }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Payroll Entry</div>
                    <div class="ph-view-val">{{ $viewRecord->payrollEntry?->code ?? ($viewRecord->payroll_entry_id ? '#'.$viewRecord->payroll_entry_id : '—') }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Payment Status</div>
                    <div class="ph-view-val"><span class="ph-badge {{ $vStCls }}">{{ ucfirst($vSt) }}</span></div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Approval Status</div>
                    <div class="ph-view-val"><span class="ph-badge {{ $vApCls }}">{{ ucfirst($vAp) }}</span></div>
                </div>
                @if($viewRecord->notes)
                <div class="ph-view-row full">
                    <div class="ph-view-lbl">Notes</div>
                    <div class="ph-view-val" style="font-size:13px;color:var(--ink3);line-height:1.6;">{{ $viewRecord->notes }}</div>
                </div>
                @endif
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Created</div>
                    <div class="ph-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->created_at)->format('M d, Y · H:i') }}</div>
                </div>
                <div class="ph-view-row">
                    <div class="ph-view-lbl">Last Updated</div>
                    <div class="ph-view-val" style="font-size:12.5px;">{{ \Carbon\Carbon::parse($viewRecord->updated_at)->format('M d, Y · H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="ph-modal-footer">
            <button class="ph-btn ph-btn-outline" wire:click="closeView">Close</button>
            <button class="ph-btn ph-btn-ghost" wire:click="openEdit({{ $viewRecord->id }}); closeView()">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </button>
            @if($vAp !== 'approved')
                <button class="ph-btn ph-btn-green" wire:click="approve({{ $viewRecord->id }}); closeView()"
                        wire:confirm="Approve this payment?">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Approve
                </button>
            @endif
        </div>
    </div>
</div>
@endif

{{-- ══ DELETE CONFIRM ══════════════════════════════════════ --}}
@if($showDelete)
<div class="ph-modal-bg" wire:click.self="cancelDelete">
    <div class="ph-modal ph-del-modal">
        <div class="ph-del-body">
            <div class="ph-del-icon">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
            </div>
            <div class="ph-del-ttl">Delete Payment Record?</div>
            <div class="ph-del-sub">This will permanently remove this payment record. This action cannot be undone.</div>
        </div>
        <div class="ph-modal-footer" style="justify-content:center;gap:12px;">
            <button class="ph-btn ph-btn-outline" wire:click="cancelDelete">Cancel</button>
            <button class="ph-btn ph-btn-danger" wire:click="deleteRecord" wire:loading.attr="disabled">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                <span wire:loading.remove wire:target="deleteRecord">Yes, Delete</span>
                <span wire:loading wire:target="deleteRecord">Deleting…</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- Tab switching JS (pure client-side, no Livewire) --}}
<script>
function phTab(name, btn) {
    document.querySelectorAll('#phModalTabs .ph-tab').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('.ph-tab-panel').forEach(function(p){ p.classList.remove('active'); });
    btn.classList.add('active');
    var panel = document.getElementById('phTab-' + name);
    if (panel) panel.classList.add('active');
}
// Re-init tabs after Livewire re-renders the modal
document.addEventListener('livewire:updated', function(){
    var tabs = document.querySelectorAll('#phModalTabs .ph-tab');
    if (tabs.length && !document.querySelector('#phModalTabs .ph-tab.active')) {
        tabs[0].classList.add('active');
        var panels = document.querySelectorAll('.ph-tab-panel');
        if (panels[0]) panels[0].classList.add('active');
    }
});
</script>

</div>{{-- /ph-root --}}
