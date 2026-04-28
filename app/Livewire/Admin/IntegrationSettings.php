<?php

namespace App\Livewire\Admin;

use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('SGA | C-HRMS | Integration Settings')]
#[Layout('components.layouts.admin')]
class IntegrationSettings extends Component
{
    public $activeTab = 'accounting';

    // Accounting Integration
    public $accounting_url = '';
    public $accounting_api_key = '';

    // Email Gateway
    public $mail_mailer = 'smtp';
    public $mail_host = '';
    public $mail_port = '';
    public $mail_username = '';
    public $mail_password = '';
    public $mail_encryption = '';
    public $mail_from_address = '';

    // SMS Gateway
    public $sms_provider = 'twilio';
    public $sms_api_key = '';
    public $sms_sender_id = '';

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Accounting
        $this->accounting_url = SystemSetting::getSetting('accounting_url', '');
        $this->accounting_api_key = SystemSetting::getSetting('accounting_api_key', '');

        // Email
        $this->mail_mailer = SystemSetting::getSetting('mail_mailer', 'smtp');
        $this->mail_host = SystemSetting::getSetting('mail_host', 'smtp.mailgun.org');
        $this->mail_port = SystemSetting::getSetting('mail_port', '587');
        $this->mail_username = SystemSetting::getSetting('mail_username', '');
        $this->mail_password = SystemSetting::getSetting('mail_password', '');
        $this->mail_encryption = SystemSetting::getSetting('mail_encryption', 'tls');
        $this->mail_from_address = SystemSetting::getSetting('mail_from_address', 'hello@example.com');

        // SMS
        $this->sms_provider = SystemSetting::getSetting('sms_provider', 'twilio');
        $this->sms_api_key = SystemSetting::getSetting('sms_api_key', '');
        $this->sms_sender_id = SystemSetting::getSetting('sms_sender_id', '');
    }

    public function saveAccounting()
    {
        SystemSetting::setSetting('accounting_url', $this->accounting_url, 'string', 'integration');
        SystemSetting::setSetting('accounting_api_key', $this->accounting_api_key, 'string', 'integration');
        session()->flash('success', 'Accounting integration settings saved.');
    }

    public function saveEmail()
    {
        SystemSetting::setSetting('mail_mailer', $this->mail_mailer, 'string', 'integration');
        SystemSetting::setSetting('mail_host', $this->mail_host, 'string', 'integration');
        SystemSetting::setSetting('mail_port', $this->mail_port, 'string', 'integration');
        SystemSetting::setSetting('mail_username', $this->mail_username, 'string', 'integration');
        SystemSetting::setSetting('mail_password', $this->mail_password, 'string', 'integration');
        SystemSetting::setSetting('mail_encryption', $this->mail_encryption, 'string', 'integration');
        SystemSetting::setSetting('mail_from_address', $this->mail_from_address, 'string', 'integration');
        session()->flash('success', 'Email gateway settings saved.');
    }

    public function saveSms()
    {
        SystemSetting::setSetting('sms_provider', $this->sms_provider, 'string', 'integration');
        SystemSetting::setSetting('sms_api_key', $this->sms_api_key, 'string', 'integration');
        SystemSetting::setSetting('sms_sender_id', $this->sms_sender_id, 'string', 'integration');
        session()->flash('success', 'SMS gateway settings saved.');
    }

    public function render()
    {
        return view('livewire.admin.integration-settings');
    }
}
