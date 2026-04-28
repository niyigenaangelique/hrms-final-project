<div class="ac-root">
    <x-admin-content-styles />

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div style="display:flex; align-items:center; gap:24px;">
            <div class="ac-av" style="width:72px; height:72px; font-size:24px; background:rgba(255,255,255,0.25); color:#fff; border:3px solid rgba(255,255,255,0.4);">
                <svg viewBox="0 0 24 24" style="width:1.4em; height:1.4em;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="8 12 11 15 16 9"/></svg>
            </div>
            <div>
                <div class="ac-hero-ttl">Firewall & Security</div>
                <div class="ac-hero-sub">Infrastructure Governance & Access Control</div>
            </div>
        </div>
        <div>
            <button wire:click="save" class="ac-btn ac-btn-primary" style="background:#fff; color:var(--blue);">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Deploy Configuration
            </button>
        </div>
    </div>

    {{-- ── ALERTS ── --}}
    @if (session()->has('success'))
        <div class="ac-flash ac-flash-ok" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        
        {{-- Authentication Policy --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div>
                    <div class="ac-card-title">Authentication Policy</div>
                    <div class="ac-card-sub">Login enforcement and MFA rules</div>
                </div>
            </div>
            <div style="padding:24px; display:flex; flex-direction:column; gap:20px;">
                <div class="ac-field">
                    <label style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Two-Factor Authentication</span>
                        <input type="checkbox" wire:model="twoFactorEnabled" style="width:20px; height:20px;">
                    </label>
                    <div style="font-size:11px; color:var(--ink4);">Require TOTP or SMS verification for all admin logins</div>
                </div>

                <div class="ac-field">
                    <label>Maximum Login Attempts</label>
                    <input type="number" wire:model="maxLoginAttempts" min="1" max="10">
                    <div style="font-size:11px; color:var(--ink4);">Accounts will be locked after this many failed attempts</div>
                </div>

                <div class="ac-field">
                    <label style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Password Expiry</span>
                        <input type="checkbox" wire:model="passwordExpiry" style="width:20px; height:20px;">
                    </label>
                    <div style="font-size:11px; color:var(--ink4);">Force periodic password rotations</div>
                </div>

                @if($passwordExpiry)
                    <div class="ac-field">
                        <label>Expiry Interval (Days)</label>
                        <input type="number" wire:model="passwordExpiryDays" min="30" max="365">
                    </div>
                @endif
            </div>
        </div>

        {{-- Session & Access --}}
        <div class="ac-card">
            <div class="ac-card-hd">
                <div>
                    <div class="ac-card-title">Session & Geofencing</div>
                    <div class="ac-card-sub">Infrastructure perimeter settings</div>
                </div>
            </div>
            <div style="padding:24px; display:flex; flex-direction:column; gap:20px;">
                <div class="ac-field">
                    <label style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Auto-Session Timeout</span>
                        <input type="checkbox" wire:model="sessionTimeoutEnabled" style="width:20px; height:20px;">
                    </label>
                    <div style="font-size:11px; color:var(--ink4);">Invalidate sessions after periods of inactivity</div>
                </div>

                @if($sessionTimeoutEnabled)
                    <div class="ac-field">
                        <label>Timeout Threshold (Minutes)</label>
                        <input type="number" wire:model="sessionTimeoutMinutes" min="5" max="1440">
                    </div>
                @endif

                <div class="ac-field">
                    <label style="display:flex; justify-content:space-between; align-items:center;">
                        <span>IP Filtering (Whitelisting)</span>
                        <input type="checkbox" wire:model="ipWhitelistEnabled" style="width:20px; height:20px;">
                    </label>
                    <div style="font-size:11px; color:var(--ink4);">Restrict access to specific network segments</div>
                </div>

                @if($ipWhitelistEnabled)
                    <div class="ac-field">
                        <label>Authorized IPv4 / CIDR</label>
                        <textarea wire:model="ipWhitelist" rows="3" placeholder="192.168.1.1, 10.0.0.0/24"></textarea>
                        <div style="font-size:11px; color:var(--red); font-weight: 700;">CAUTION: Incorrect settings may lock your account</div>
                    </div>
                @endif

                <div class="ac-field">
                    <label style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Audit Log Retention</span>
                        <span class="ac-badge ab-amber">90 DAYS</span>
                    </label>
                    <div style="font-size:11px; color:var(--ink4);">Automatic purging of logs older than threshold</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ac-card" style="margin-top:20px;">
        <div class="ac-card-hd">
            <div>
                <div class="ac-card-title">Security Pulse</div>
                <div class="ac-card-sub">Infrastructure health and threat status</div>
            </div>
        </div>
        <div style="padding:24px; display:grid; grid-template-columns: repeat(4, 1fr); gap:20px;">
            <div style="text-align:center;">
                <div style="font-size:11px; font-weight:800; color:var(--ink4); margin-bottom:5px;">FIREWALL STATUS</div>
                <div style="font-size:18px; font-weight:900; color:var(--green);">OPERATIONAL</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:11px; font-weight:800; color:var(--ink4); margin-bottom:5px;">BRUTEFORCE BLOCK</div>
                <div style="font-size:18px; font-weight:900; color:var(--blue);">ACTIVE</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:11px; font-weight:800; color:var(--ink4); margin-bottom:5px;">ACTIVE THREATS</div>
                <div style="font-size:18px; font-weight:900; color:var(--ink);">0</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:11px; font-weight:800; color:var(--ink4); margin-bottom:5px;">INTEGRITY CHECK</div>
                <div style="font-size:18px; font-weight:900; color:var(--teal);">PASSED</div>
            </div>
        </div>
    </div>
</div>
