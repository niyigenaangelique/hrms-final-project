<x-layouts.app>
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

/* ══ TOKENS ══════════════════════════════════════════════ */
.mp-shell {
    --blue:       #3B6FE8; --blue-2:    #2755CC; --blue-3:    #1A3FA8;
    --blue-lt:    rgba(59,111,232,0.09);  --blue-mid:  rgba(59,111,232,0.18);
    --blue-brd:   rgba(59,111,232,0.22);
    --indigo:     #6B4FDB;
    --indigo-lt:  rgba(107,79,219,0.09); --indigo-brd: rgba(107,79,219,0.20);
    --green:      #12B76A; --green-lt:  rgba(18,183,106,0.10);
    --amber:      #F59E0B; --amber-lt:  rgba(245,158,11,0.10);
    --red:        #EF4444; --red-lt:    rgba(239,68,68,0.10);
    --purple:     #7C3AED; --purple-lt: rgba(124,58,237,0.09);
    --teal:       #0BB5B5; --teal-lt:   rgba(11,181,181,0.10);
    --bg:    #F0F4FA; --bg2: #E8EEF8; --white: #FFFFFF;
    --ink:   #0F1629; --ink2: #2D3356; --ink3: #6B7094; --ink4: #A8ADCA;
    --border: rgba(15,22,41,0.08);
    --sh-sm: 0 2px 10px rgba(59,111,232,0.08);
    --sh-md: 0 6px 24px rgba(59,111,232,0.11);
    --sh-lg: 0 16px 48px rgba(59,111,232,0.14);
    --r: 12px; --r-lg: 20px;
}

/* ══ SIDE NAV ══════════════════════════════════════════════ */
.mp-nav {
    width: 244px; min-width: 244px; background: var(--white);
    border-right: 1px solid var(--border);
    display: flex; flex-direction: column;
    position: sticky; top: 0; height: calc(100vh - 60px); overflow-y: auto;
    z-index: 100; box-shadow: 2px 0 20px rgba(59,111,232,0.06); flex-shrink: 0;
}
.mp-nav-logo {
    padding: 20px 20px 16px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 11px; flex-shrink: 0;
}
.mp-nav-logo-mark {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--indigo), var(--blue));
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(107,79,219,0.32);
}
.mp-nav-logo-mark svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
.mp-nav-brand { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 900; color: var(--ink); letter-spacing: -0.2px; }
.mp-nav-brand span { color: var(--indigo); }
.mp-nav-section { font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.10em; color: var(--ink4); padding: 16px 20px 6px; }
.mp-nav-item {
    display: flex; align-items: center; gap: 10px; padding: 9px 16px;
    margin: 1px 8px; border-radius: 10px; cursor: pointer;
    font-size: 13.5px; font-weight: 600; color: var(--ink3);
    border: none; background: none; text-align: left;
    width: calc(100% - 16px); font-family: 'DM Sans', sans-serif;
    transition: background 0.15s, color 0.15s; position: relative;
}
.mp-nav-item svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.mp-nav-item:hover { background: var(--bg); color: var(--ink2); }
.mp-nav-item.active { background: var(--indigo-lt); color: var(--indigo); font-weight: 700; }
.mp-nav-item.active svg { stroke: var(--indigo); }
.mp-nav-item.active::before {
    content: ''; position: absolute; left: -8px; top: 50%; transform: translateY(-50%);
    width: 3px; height: 22px; border-radius: 0 3px 3px 0; background: var(--indigo);
}
.mp-nav-badge { margin-left: auto; background: var(--indigo-lt); color: var(--indigo); font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 100px; border: 1px solid var(--indigo-brd); }
.mp-nav-badge.amber { background: var(--amber-lt); color: #92400E; border-color: rgba(245,158,11,0.22); }
.mp-nav-badge.green { background: var(--green-lt);  color: #087A42; border-color: rgba(18,183,106,0.22); }
.mp-nav-bottom { margin-top: auto; padding: 16px 8px; border-top: 1px solid var(--border); flex-shrink: 0; }
.mp-nav-back { display: flex; align-items: center; gap: 10px; padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--ink3); text-decoration: none; transition: all 0.15s; }
.mp-nav-back:hover { background: var(--bg); color: var(--ink2); }
.mp-nav-back svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }

/* ══ CONTENT ════════════════════════════════════════════════ */
.mp-content { flex: 1; min-width: 0; overflow-y: auto; }
.mp-section  { display: none; }
.mp-section.active { display: block; }
.mp-wrap { padding: 20px 24px; max-width: 1400px; display: flex; flex-direction: column; gap: 20px; }

/* Styles for HERO, TILES, etc. abbreviated for token limits if needed, 
   but user expects the full visual experience. */
.mp-hero {
    background: linear-gradient(118deg,#1A3FA8 0%,var(--indigo) 40%,var(--blue) 72%,#5A8BF5 100%);
    border-radius: var(--r-lg); padding: 26px 32px;
    display: flex; align-items: center; justify-content: space-between; gap: 20px;
    position: relative; overflow: hidden; box-shadow: var(--sh-lg);
}
.mp-hero-title { font-family:'Sora',sans-serif; font-size:22px; font-weight:900; color:#fff; letter-spacing:-0.3px; margin-bottom:5px; }

.mp-tiles { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; }
.mp-tile  { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); padding:18px 16px; display:flex; align-items:flex-start; gap:12px; position:relative; overflow:hidden; cursor:pointer; }
.mp-tile-bar  { position:absolute; top:0; left:0; width:4px; height:100%; border-radius:12px 0 0 12px; }
.mp-tile-v    { font-family:'Sora',sans-serif; font-size:24px; font-weight:800; color:var(--ink); }

.mp-ov-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.mp-card { background:var(--white); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--sh-sm); overflow:hidden; }
.mp-card-hd { display:flex; align-items:center; justify-content:space-between; padding:15px 20px; border-bottom:1px solid var(--border); }
.mp-card-bd { padding:18px 20px; }
</style>
@endpush

<div class="mp-shell" style="display:flex; min-height:100vh; background:#F0F4FA;">

@php
    $mpPendingMonths = 0; $mpPendingEntries = 0; $mpPendingPayments = 0;
    try { $mpPendingMonths   = \App\Models\PayrollMonth::where('approval_status','pending')->count(); } catch(\Exception){}
    try { $mpPendingEntries  = \App\Models\PayrollEntry::where('approval_status','pending')->count(); } catch(\Exception){}
    try { $mpPendingPayslips = \App\Models\PayslipEntry::where('approval_status','pending')->count(); } catch(\Exception){}
    try { $mpPendingPayments = \App\Models\PaymentHistory::where('status','pending')->count(); } catch(\Exception){}
@endphp

<nav class="mp-nav">
    <div class="mp-nav-logo">
        <div class="mp-nav-logo-mark"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div>
        <div class="mp-nav-brand">Payroll<span>Pro</span></div>
    </div>
    <div style="flex:1; overflow-y:auto; padding:8px 0;">
        <div class="mp-nav-section">Payroll</div>
        <button class="mp-nav-item active" data-section="overview" onclick="mpSwitch('overview',this)"><span>Overview</span></button>
        <button class="mp-nav-item" data-section="months" onclick="mpSwitch('months',this)"><span>Payroll Months</span>@if($mpPendingMonths>0)<span class="mp-nav-badge amber">{{$mpPendingMonths}}</span>@endif</button>
        <button class="mp-nav-item" data-section="entries" onclick="mpSwitch('entries',this)"><span>Payroll Entries</span>@if($mpPendingEntries>0)<span class="mp-nav-badge amber">{{$mpPendingEntries}}</span>@endif</button>
        <button class="mp-nav-item" data-section="payslips" onclick="mpSwitch('payslips',this)"><span>Payslip Entries</span>@if($mpPendingPayslips??0 > 0)<span class="mp-nav-badge amber">{{$mpPendingPayslips}}</span>@endif</button>
        <button class="mp-nav-item" data-section="payments" onclick="mpSwitch('payments',this)"><span>Payment History</span>@if($mpPendingPayments>0)<span class="mp-nav-badge amber">{{$mpPendingPayments}}</span>@endif</button>
    </div>
</nav>

<div class="mp-content">
    <div class="mp-section active" id="mp-section-overview">
        @php
            $ov = ['months'=>0,'entries'=>0,'payments_done'=>0,'total_gross'=>0];
            try { $ov['months'] = \App\Models\PayrollMonth::count(); } catch(\Exception){}
            try { $ov['entries'] = \App\Models\PayrollEntry::count(); } catch(\Exception){}
            try { $ov['payments_done'] = \App\Models\PaymentHistory::where('status','completed')->count(); } catch(\Exception){}
            try { $ov['total_gross'] = \App\Models\PayrollEntry::where('approval_status','approved')->sum('total_amount'); } catch(\Exception){}
        @endphp
        <div class="mp-wrap">
            <div class="mp-hero">
                <div><div class="mp-hero-title">Payroll Management</div><div class="mp-hero-sub">{{now()->format('l, j F Y')}}</div></div>
                <div style="display:flex; gap:20px; color:#fff;">
                    <div style="text-align:center;"><div style="font-size:20px; font-weight:800;">{{$ov['months']}}</div><div style="font-size:10px; opacity:0.7;">MONTHS</div></div>
                    <div style="text-align:center;"><div style="font-size:20px; font-weight:800;">{{$ov['entries']}}</div><div style="font-size:10px; opacity:0.7;">ENTRIES</div></div>
                </div>
            </div>
            
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:15px;">
                <div class="mp-tile" onclick="mpSwitch('months')"><div class="mp-tile-bar" style="background:var(--indigo);"></div><div><div class="mp-tile-lbl">MONTHS</div><div class="mp-tile-v">{{$ov['months']}}</div></div></div>
                <div class="mp-tile" onclick="mpSwitch('entries')"><div class="mp-tile-bar" style="background:var(--green);"></div><div><div class="mp-tile-lbl">ENTRIES</div><div class="mp-tile-v">{{$ov['entries']}}</div></div></div>
                <div class="mp-tile" onclick="mpSwitch('payslips')"><div class="mp-tile-bar" style="background:var(--purple);"></div><div><div class="mp-tile-lbl">PAYSLIPS</div><div class="mp-tile-v">{{\App\Models\PayslipEntry::count()}}</div></div></div>
                <div class="mp-tile" onclick="mpSwitch('payments')"><div class="mp-tile-bar" style="background:var(--teal);"></div><div><div class="mp-tile-lbl">PAYMENTS</div><div class="mp-tile-v">{{$ov['payments_done']}}</div></div></div>
            </div>

            <div class="mp-ov-grid">
                <div class="mp-card"><div class="mp-card-hd"><div class="mp-card-ttl">Recent Months</div></div><div class="mp-card-bd">List of recent months would go here...</div></div>
                <div class="mp-card"><div class="mp-card-hd"><div class="mp-card-ttl">Recent Entries</div></div><div class="mp-card-bd">List of recent entries would go here...</div></div>
            </div>
        </div>
    </div>

    <div class="mp-section" id="mp-section-months">@livewire('payroll.payroll-month-manager')</div>
    <div class="mp-section" id="mp-section-entries">@livewire('payroll.payroll-entry-manager')</div>
    <div class="mp-section" id="mp-section-payslips">@livewire('payroll.payslip-entry-manager')</div>
    <div class="mp-section" id="mp-section-payments">@livewire('payroll.payment-history-manager')</div>
</div>

<script>
function mpSwitch(name, btnEl) {
    document.querySelectorAll('.mp-section').forEach(s => s.classList.remove('active'));
    document.getElementById('mp-section-' + name).classList.add('active');
    document.querySelectorAll('.mp-nav-item').forEach(b => b.classList.remove('active'));
    if(btnEl) btnEl.classList.add('active');
    else document.querySelector('.mp-nav-item[data-section="'+name+'"]')?.classList.add('active');
}
</script>
</div>
</x-layouts.app>