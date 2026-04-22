<?php

namespace App\Livewire\Admin;
 
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
 
#[Title('TalentFlow Pro | Security Settings')]
class SecuritySettingsManagement extends Component
{
    public bool   $twoFactorEnabled      = false;
    public bool   $sessionTimeoutEnabled = true;
    public int    $sessionTimeoutMinutes = 60;
    public bool   $passwordExpiry        = false;
    public int    $passwordExpiryDays    = 90;
    public bool   $loginAuditEnabled     = true;
    public int    $maxLoginAttempts      = 5;
    public bool   $ipWhitelistEnabled    = false;
    public string $ipWhitelist           = '';
 
    public function mount(): void
    {
        try {
            $rows = DB::table('security_settings')->pluck('value','key');
            if ($rows->isNotEmpty()) {
                $this->twoFactorEnabled      = (bool)($rows['two_factor_enabled']      ?? false);
                $this->sessionTimeoutEnabled = (bool)($rows['session_timeout_enabled'] ?? true);
                $this->sessionTimeoutMinutes = (int) ($rows['session_timeout_minutes'] ?? 60);
                $this->passwordExpiry        = (bool)($rows['password_expiry_enabled'] ?? false);
                $this->passwordExpiryDays    = (int) ($rows['password_expiry_days']    ?? 90);
                $this->loginAuditEnabled     = (bool)($rows['login_audit_enabled']     ?? true);
                $this->maxLoginAttempts      = (int) ($rows['max_login_attempts']      ?? 5);
                $this->ipWhitelistEnabled    = (bool)($rows['ip_whitelist_enabled']    ?? false);
                $this->ipWhitelist           = (string)($rows['ip_whitelist']          ?? '');
            }
        } catch (\Exception) {}
    }
 
    public function save(): void
    {
        $settings = [
            'two_factor_enabled'     => $this->twoFactorEnabled      ? '1':'0',
            'session_timeout_enabled'=> $this->sessionTimeoutEnabled  ? '1':'0',
            'session_timeout_minutes'=> (string)$this->sessionTimeoutMinutes,
            'password_expiry_enabled'=> $this->passwordExpiry         ? '1':'0',
            'password_expiry_days'   => (string)$this->passwordExpiryDays,
            'login_audit_enabled'    => $this->loginAuditEnabled      ? '1':'0',
            'max_login_attempts'     => (string)$this->maxLoginAttempts,
            'ip_whitelist_enabled'   => $this->ipWhitelistEnabled     ? '1':'0',
            'ip_whitelist'           => $this->ipWhitelist,
        ];
        DB::beginTransaction();
        try {
            foreach ($settings as $key => $value) {
                DB::table('security_settings')->upsert(
                    ['key'=>$key,'value'=>$value,'updated_at'=>now(),'created_at'=>now()],
                    ['key'], ['value','updated_at']
                );
            }
            DB::commit();
            session()->flash('success','Security settings saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error','Save failed: '.$e->getMessage());
        }
    }
 
    public function render()
    {
        return view('livewire.admin.security-settings-management')
            ->layout('components.layouts.admin');
    }
}
 