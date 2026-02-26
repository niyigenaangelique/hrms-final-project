<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SystemConfigurationManagement extends Component
{
    // System Configuration
    public $app_name = 'HR Management System';
    public $app_version = '1.0.0';
    public $app_environment;
    public $maintenance_mode = false;
    public $maintenance_message = 'System is currently under maintenance. Please try again later.';
    public $max_file_upload_size = 10240; // in KB
    public $allowed_file_types = 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx';
    public $session_lifetime = 120; // in minutes
    public $password_reset_timeout = 60; // in minutes
    public $email_notifications_enabled = true;
    public $email_from_address = 'noreply@company.com';
    public $email_from_name = 'HR Management System';
    public $backup_enabled = true;
    public $backup_frequency = 'daily';
    public $backup_retention_days = 30;
    public $log_retention_days = 90;
    public $api_rate_limit = 1000; // requests per hour
    public $enable_debug_mode = false;

    public function mount()
    {
        $this->loadSystemConfiguration();
    }

    public function render()
    {
        return view('livewire.admin.system-configuration-management', [
            'systemInfo' => $this->getSystemInfo(),
            'systemStats' => $this->getSystemStats(),
        ])->layout('components.layouts.admin');
    }

    private function loadSystemConfiguration()
    {
        // Load from config or database settings
        $this->app_environment = config('app.env', 'production');
        $this->maintenance_mode = Cache::get('maintenance_mode', false);
        $this->maintenance_message = Cache::get('maintenance_message', 'System is currently under maintenance. Please try again later.');
        
        // Load other settings from database or config
        $this->max_file_upload_size = config('filesystems.max_file_size', 10240);
        $this->allowed_file_types = config('filesystems.allowed_file_types', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx');
        $this->session_lifetime = config('session.lifetime', 120);
        $this->password_reset_timeout = config('auth.passwords.users.expire', 60);
        $this->email_notifications_enabled = config('mail.enabled', true);
        $this->email_from_address = config('mail.from.address', 'noreply@company.com');
        $this->email_from_name = config('mail.from.name', 'HR Management System');
        $this->backup_enabled = config('backup.enabled', true);
        $this->backup_frequency = config('backup.frequency', 'daily');
        $this->backup_retention_days = config('backup.retention_days', 30);
        $this->log_retention_days = config('logging.retention_days', 90);
        $this->api_rate_limit = config('api.rate_limit', 1000);
        $this->enable_debug_mode = config('app.debug', false);
    }

    public function saveSystemConfiguration()
    {
        $this->validate([
            'app_name' => 'required|string|max:255',
            'app_version' => 'required|string|max:20',
            'maintenance_message' => 'required|string|max:500',
            'max_file_upload_size' => 'required|integer|min:100|max:51200',
            'allowed_file_types' => 'required|string|max:255',
            'session_lifetime' => 'required|integer|min:5|max:480',
            'password_reset_timeout' => 'required|integer|min:15|max:1440',
            'email_from_address' => 'required|email',
            'email_from_name' => 'required|string|max:255',
            'backup_retention_days' => 'required|integer|min:1|max:365',
            'log_retention_days' => 'required|integer|min:7|max:365',
            'api_rate_limit' => 'required|integer|min:10|max:10000',
        ]);

        // Save configuration to cache or database
        Cache::put('maintenance_mode', $this->maintenance_mode);
        Cache::put('maintenance_message', $this->maintenance_message);

        // Update configuration values
        // (In a real application, you would update config files or database)

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'system_configuration_updated',
            'description' => 'System configuration was updated',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'System configuration saved successfully!');
    }

    public function toggleMaintenanceMode()
    {
        $this->maintenance_mode = !$this->maintenance_mode;
        Cache::put('maintenance_mode', $this->maintenance_mode);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'maintenance_mode_toggled',
            'description' => "Maintenance mode " . ($this->maintenance_mode ? 'enabled' : 'disabled'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $message = $this->maintenance_mode ? 'Maintenance mode enabled!' : 'Maintenance mode disabled!';
        session()->flash('info', $message);
    }

    public function clearSystemCache()
    {
        Cache::flush();
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'system_cache_cleared',
            'description' => 'System cache was cleared',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'System cache cleared successfully!');
    }

    public function optimizeDatabase()
    {
        // Database optimization functionality
        DB::statement('OPTIMIZE TABLE users');
        DB::statement('OPTIMIZE TABLE employees');
        DB::statement('OPTIMIZE TABLE activity_logs');
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'database_optimized',
            'description' => 'Database tables were optimized',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'Database optimized successfully!');
    }

    public function testEmailConfiguration()
    {
        // Test email configuration functionality
        session()->flash('info', 'Email configuration test coming soon');
    }

    public function generateSystemReport()
    {
        // Generate system report functionality
        session()->flash('info', 'System report generation coming soon');
    }

    public function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_os' => PHP_OS,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => DB::select('SELECT VERSION() as version')[0]->version,
            'memory_usage' => memory_get_usage(true),
            'disk_space' => disk_free_space('/'),
            'server_time' => now()->format('Y-m-d H:i:s'),
        ];
    }

    public function getSystemStats()
    {
        return [
            'total_users' => User::count(),
            'total_employees' => Employee::count(),
            'total_activities' => ActivityLog::count(),
            'cache_size' => Cache::get('cache_size', 0),
            'disk_usage' => $this->getDiskUsage(),
        ];
    }

    private function getDiskUsage()
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total - $free;
        
        return [
            'total' => $total,
            'free' => $free,
            'used' => $used,
            'percentage' => round(($used / $total) * 100, 2),
        ];
    }
}
