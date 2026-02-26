<?php

namespace App\Livewire\Admin;

use App\Models\SecuritySetting;
use App\Models\ActivityLog;
use Livewire\Component;

class SecuritySettingsManagement extends Component
{
    // Security Settings
    public $password_min_length = 8;
    public $password_require_uppercase = true;
    public $password_require_lowercase = true;
    public $password_require_numbers = true;
    public $password_require_symbols = true;
    public $session_timeout_minutes = 120;
    public $max_login_attempts = 5;
    public $lockout_duration_minutes = 15;
    public $enable_two_factor = false;
    public $force_password_change_days = 90;

    public function mount()
    {
        $this->loadSecuritySettings();
    }

    public function render()
    {
        return view('livewire.admin.security-settings-management')->layout('components.layouts.admin');
    }

    private function loadSecuritySettings()
    {
        // Create default security settings if they don't exist
        $defaultSettings = [
            'password_min_length' => '8',
            'password_require_uppercase' => 'true',
            'password_require_lowercase' => 'true',
            'password_require_numbers' => 'true',
            'password_require_symbols' => 'true',
            'session_timeout_minutes' => '120',
            'max_login_attempts' => '5',
            'lockout_duration_minutes' => '15',
            'enable_two_factor' => 'false',
            'force_password_change_days' => '90',
        ];

        foreach ($defaultSettings as $key => $value) {
            SecuritySetting::setValue($key, $value, "Security setting for {$key}");
        }

        // Load settings as an object for the form
        $this->password_min_length = SecuritySetting::getInteger('password_min_length', 8);
        $this->password_require_uppercase = SecuritySetting::getBoolean('password_require_uppercase', true);
        $this->password_require_lowercase = SecuritySetting::getBoolean('password_require_lowercase', true);
        $this->password_require_numbers = SecuritySetting::getBoolean('password_require_numbers', true);
        $this->password_require_symbols = SecuritySetting::getBoolean('password_require_symbols', true);
        $this->session_timeout_minutes = SecuritySetting::getInteger('session_timeout_minutes', 120);
        $this->max_login_attempts = SecuritySetting::getInteger('max_login_attempts', 5);
        $this->lockout_duration_minutes = SecuritySetting::getInteger('lockout_duration_minutes', 15);
        $this->enable_two_factor = SecuritySetting::getBoolean('enable_two_factor', false);
        $this->force_password_change_days = SecuritySetting::getInteger('force_password_change_days', 90);
    }

    public function saveSecuritySettings()
    {
        $this->validate([
            'password_min_length' => 'required|integer|min:6|max:20',
            'session_timeout_minutes' => 'required|integer|min:5|max:480',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'lockout_duration_minutes' => 'required|integer|min:5|max:1440',
            'force_password_change_days' => 'required|integer|min:0|max:365',
        ]);

        // Save all security settings
        SecuritySetting::setValue('password_min_length', $this->password_min_length);
        SecuritySetting::setValue('password_require_uppercase', $this->password_require_uppercase ? 'true' : 'false');
        SecuritySetting::setValue('password_require_lowercase', $this->password_require_lowercase ? 'true' : 'false');
        SecuritySetting::setValue('password_require_numbers', $this->password_require_numbers ? 'true' : 'false');
        SecuritySetting::setValue('password_require_symbols', $this->password_require_symbols ? 'true' : 'false');
        SecuritySetting::setValue('session_timeout_minutes', $this->password_timeout_minutes);
        SecuritySetting::setValue('max_login_attempts', $this->max_login_attempts);
        SecuritySetting::setValue('lockout_duration_minutes', $this->lockout_duration_minutes);
        SecuritySetting::setValue('enable_two_factor', $this->enable_two_factor ? 'true' : 'false');
        SecuritySetting::setValue('force_password_change_days', $this->force_password_change_days);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'security_settings_updated',
            'description' => 'Security settings were updated',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'Security settings saved successfully!');
    }

    public function resetToDefaults()
    {
        $this->password_min_length = 8;
        $this->password_require_uppercase = true;
        $this->password_require_lowercase = true;
        $this->password_require_numbers = true;
        $this->password_require_symbols = true;
        $this->session_timeout_minutes = 120;
        $this->max_login_attempts = 5;
        $this->lockout_duration_minutes = 15;
        $this->enable_two_factor = false;
        $this->force_password_change_days = 90;

        session()->flash('info', 'Settings reset to defaults. Click Save to apply.');
    }

    public function testPasswordPolicy()
    {
        // Test password policy functionality placeholder
        session()->flash('info', 'Password policy test coming soon');
    }

    public function generateSecurityReport()
    {
        // Generate security report functionality placeholder
        session()->flash('info', 'Security report generation coming soon');
    }
}
