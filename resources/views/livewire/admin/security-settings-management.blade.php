<x-admin-content-styles />
<div class="ac-root">
 
    @if(session('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ac-flash ac-flash-err"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif
 
    <div class="ac-header">
        <div><div class="ac-header-title">Security Settings</div><div class="ac-header-sub">Authentication, session and password policies</div></div>
        <button class="ac-btn ac-btn-primary" wire:click="save">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
            Save Settings
        </button>
    </div>
 
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start;">
 
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div class="ac-card">
                <div class="ac-card-hd"><div><div class="ac-card-title">Authentication</div><div class="ac-card-sub">Login and session controls</div></div></div>
                <div class="ac-toggle-row">
                    <div><div class="ac-toggle-label">Two-Factor Authentication</div><div class="ac-toggle-desc">Require 2FA for all admin accounts</div></div>
                    <button class="ac-toggle {{ $twoFactorEnabled ? 'on' : '' }}" wire:click="$toggle('twoFactorEnabled')"></button>
                </div>
                <div class="ac-toggle-row">
                    <div><div class="ac-toggle-label">Login Audit Logging</div><div class="ac-toggle-desc">Log all login attempts to audit trail</div></div>
                    <button class="ac-toggle {{ $loginAuditEnabled ? 'on' : '' }}" wire:click="$toggle('loginAuditEnabled')"></button>
                </div>
                <div class="ac-toggle-row">
                    <div><div class="ac-toggle-label">Max Login Attempts</div><div class="ac-toggle-desc">Lock account after N failed attempts</div></div>
                    <input type="number" class="ac-num-input" wire:model.defer="maxLoginAttempts" min="3" max="20">
                </div>
                <div class="ac-toggle-row">
                    <div><div class="ac-toggle-label">Session Timeout</div><div class="ac-toggle-desc">Auto-logout after inactivity (minutes)</div></div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <input type="number" class="ac-num-input" wire:model.defer="sessionTimeoutMinutes" min="5" max="1440">
                        <button class="ac-toggle {{ $sessionTimeoutEnabled ? 'on' : '' }}" wire:click="$toggle('sessionTimeoutEnabled')"></button>
                    </div>
                </div>
            </div>
 
            <div class="ac-card">
                <div class="ac-card-hd">
                    <div><div class="ac-card-title">IP Whitelist</div><div class="ac-card-sub">Restrict admin access by IP address</div></div>
                    <button class="ac-toggle {{ $ipWhitelistEnabled ? 'on' : '' }}" wire:click="$toggle('ipWhitelistEnabled')"></button>
                </div>
                <div style="padding:16px;">
                    <div class="ac-field">
                        <label>Allowed IP Addresses</label>
                        <textarea wire:model.defer="ipWhitelist" placeholder="One IP per line&#10;192.168.1.1&#10;10.0.0.0/24"
                            style="{{ !$ipWhitelistEnabled ? 'opacity:.4;pointer-events:none;' : '' }}"></textarea>
                        <div class="ac-field-hint">CIDR notation supported. Leave empty to allow all IPs.</div>
                    </div>
                </div>
            </div>
        </div>
 
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div class="ac-card">
                <div class="ac-card-hd"><div><div class="ac-card-title">Password Policy</div><div class="ac-card-sub">Enforce strong credentials</div></div></div>
                <div class="ac-toggle-row">
                    <div><div class="ac-toggle-label">Password Expiry</div><div class="ac-toggle-desc">Force password change periodically</div></div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <input type="number" class="ac-num-input" wire:model.defer="passwordExpiryDays" min="30" max="365">
                        <span style="font-size:12px;color:var(--ink4);">days</span>
                        <button class="ac-toggle {{ $passwordExpiry ? 'on' : '' }}" wire:click="$toggle('passwordExpiry')"></button>
                    </div>
                </div>
                @foreach(['Minimum 8 characters','Uppercase + lowercase required','At least one number','At least one special character'] as $policy)
                <div class="ac-toggle-row">
                    <div class="ac-toggle-label" style="font-size:13px;">{{ $policy }}</div>
                    <button class="ac-toggle on" title="Always enforced"></button>
                </div>
                @endforeach
            </div>
 
            <div class="ac-card">
                <div class="ac-card-hd"><div><div class="ac-card-title">Security Overview</div><div class="ac-card-sub">Current policy status</div></div></div>
                <div style="padding:14px 18px;display:flex;flex-direction:column;gap:10px;">
                    @foreach([
                        ['Two-Factor Auth',    $twoFactorEnabled],
                        ['Session Timeout',    $sessionTimeoutEnabled],
                        ['Login Audit',        $loginAuditEnabled],
                        ['IP Whitelist',       $ipWhitelistEnabled],
                        ['Password Expiry',    $passwordExpiry],
                    ] as [$lbl, $on])
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="font-size:13px;color:var(--ink2);">{{ $lbl }}</div>
                        <span class="ac-badge {{ $on ? 'ab-green' : 'ab-red' }}">{{ $on ? 'ON' : 'OFF' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
 
