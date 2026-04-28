<div class="ac-root">
    <x-admin-content-styles />

    @if(session()->has('success'))<div class="ac-flash ac-flash-ok"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif

    {{-- ── HERO ── --}}
    <div class="ac-hero">
        <div>
            <div class="ac-hero-ttl">Integration Settings</div>
            <div class="ac-hero-sub">Accounting bridge, Email relay, and SMS gateways</div>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="ac-btn ac-btn-primary" style="background:rgba(255,255,255,0.2); box-shadow:none; border:1px solid rgba(255,255,255,0.3);" wire:click="saveAll">
                Save Global Config
            </button>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="ac-card">
        <div class="ac-card-hd" style="padding:0; border-bottom:none;">
            <div style="display:flex; padding:0 24px;">
                <div class="ac-btn {{ $activeTab === 'accounting' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'accounting' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'accounting' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'accounting')">Accounting Bridge</div>
                <div class="ac-btn {{ $activeTab === 'email' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'email' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'email' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'email')">Mail Delivery</div>
                <div class="ac-btn {{ $activeTab === 'sms' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="border-radius:0; border-bottom:{{ $activeTab === 'sms' ? '2px solid var(--blue)' : 'none' }}; background:none; color:{{ $activeTab === 'sms' ? 'var(--blue)' : 'var(--ink4)' }}; padding:18px 20px;" wire:click="$set('activeTab', 'sms')">SMS Gateway</div>
            </div>
        </div>

        <div style="padding:24px; border-top:1px solid var(--border);">
            @if($activeTab === 'accounting')
                <div style="max-width: 600px;">
                    <div class="ac-card-title" style="margin-bottom:20px;">External ERP Synchronization</div>
                    <div class="ac-field">
                        <label>Target API Endpoint</label>
                        <input type="url" wire:model="accounting_url" placeholder="https://api.erp-system.com/v2/">
                        <div style="font-size:11px; color:var(--ink4);">URL for payroll data export and synchronization</div>
                    </div>
                    <div class="ac-field">
                        <label>Secure Token / API Secret</label>
                        <input type="password" wire:model="accounting_api_key" placeholder="••••••••••••••••">
                    </div>
                    <button class="ac-btn ac-btn-primary mt-4" wire:click="saveAccounting">Update Bridge</button>
                </div>
            @endif

            @if($activeTab === 'email')
                <div style="max-width: 800px;">
                    <div class="ac-card-title" style="margin-bottom:20px;">Global SMTP Relay Configuration</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="ac-field">
                            <label>Mail Protocol</label>
                            <select wire:model="mail_mailer">
                                <option value="smtp">SMTP (Recommended)</option>
                                <option value="mailgun">Mailgun API</option>
                                <option value="ses">Amazon SES</option>
                            </select>
                        </div>
                        <div class="ac-field">
                            <label>Server Host</label>
                            <input type="text" wire:model="mail_host" placeholder="smtp.postmarkapp.com">
                        </div>
                        <div class="ac-field">
                            <label>Port Number</label>
                            <input type="text" wire:model="mail_port" placeholder="587">
                        </div>
                        <div class="ac-field">
                            <label>Encryption Logic</label>
                            <select wire:model="mail_encryption">
                                <option value="">No Encryption (Insecure)</option>
                                <option value="tls">STARTTLS / TLS</option>
                                <option value="ssl">SSL / Port 465</option>
                            </select>
                        </div>
                        <div class="ac-field">
                            <label>Auth Username</label>
                            <input type="text" wire:model="mail_username">
                        </div>
                        <div class="ac-field">
                            <label>Auth Password</label>
                            <input type="password" wire:model="mail_password">
                        </div>
                    </div>
                    <div class="ac-field mt-4">
                        <label>Sender Identity (From Address)</label>
                        <input type="email" wire:model="mail_from_address" placeholder="hrms@company-domain.com">
                    </div>
                    <button class="ac-btn ac-btn-primary mt-4" wire:click="saveEmail">Test & Save Delivery</button>
                </div>
            @endif

            @if($activeTab === 'sms')
                <div style="max-width: 600px;">
                    <div class="ac-card-title" style="margin-bottom:20px;">SMS Alerting Gateway</div>
                    <div class="ac-field">
                        <label>Active Carrier / Provider</label>
                        <select wire:model="sms_provider">
                            <option value="twilio">Twilio Global</option>
                            <option value="africas_talking">Africa's Talking (Regional)</option>
                            <option value="nexmo">Vonage / Nexmo</option>
                        </select>
                    </div>
                    <div class="ac-field">
                        <label>Provider Secret Key / SID</label>
                        <input type="password" wire:model="sms_api_key" placeholder="••••••••••••••••">
                    </div>
                    <div class="ac-field">
                        <label>Alpha-Numeric Sender ID</label>
                        <input type="text" wire:model="sms_sender_id" placeholder="TALENTFLOW">
                        <div style="font-size:11px; color:var(--ink4);">Branding displayed as the sender name</div>
                    </div>
                    <button class="ac-btn ac-btn-primary mt-4" wire:click="saveSms">Save Provider Settings</button>
                </div>
            @endif
        </div>
    </div>
</div>

