<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\AuditLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SecurityMonitoring extends Component
{
    use WithPagination;

    public $activeTab = 'dashboard';

    // Logs pagination
    public $auditSearch = '';
    public $activitySearch = '';

    // IT Settings from previous implementation
    public $maintenance_mode = false;
    public $maintenance_message = '';
    public $max_file_size = 10;
    public $allowed_file_types = 'jpg,png,pdf,doc';
    public $systemInfo = [];

    public function mount()
    {
        $this->maintenance_mode = app()->isDownForMaintenance();
        if (file_exists(storage_path('framework/down'))) {
            $downData = json_decode(file_get_contents(storage_path('framework/down')), true);
            $this->maintenance_message = $downData['message'] ?? '';
        }

        $this->systemInfo = [
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'database' => config('database.default'),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        ];
    }

    public function updatingAuditSearch()
    {
        $this->resetPage('auditPage');
    }

    public function updatingActivitySearch()
    {
        $this->resetPage('activityPage');
    }

    public function lockAccount($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->is_active = false;
            $user->save();

            // Log the action
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'locked_account',
                'module' => 'SecurityMonitoring',
                'description' => 'Locked user account ID: ' . $userId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            session()->flash('success', 'User account ' . $user->name . ' has been locked.');
        }
    }

    public function clearCache()
    {
        Artisan::call('optimize:clear');
        session()->flash('success', 'System cache cleared successfully.');
    }

    public function backupSystem()
    {
        try {
            // Placeholder: Typically you would use Spatie Backup: Artisan::call('backup:run');
            // Artisan::call('backup:run');
            session()->flash('success', 'System backup initiated successfully (Placeholder).');
        } catch (\Exception $e) {
            session()->flash('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function saveITSettings()
    {
        if ($this->maintenance_mode) {
            Artisan::call('down', [
                '--message' => $this->maintenance_message ?: 'System is currently under maintenance.',
            ]);
        } else {
            Artisan::call('up');
        }

        session()->flash('success', 'Maintenance & IT settings saved successfully.');
    }

    public function render()
    {
        // Fetch Audit Logs
        $auditLogs = AuditLog::with('causer')
            ->where('event', 'like', '%' . $this->auditSearch . '%')
            ->orWhere('subject_type', 'like', '%' . $this->auditSearch . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'auditPage');

        // Fetch Activity Logs
        $activityLogs = ActivityLog::with('user')
            ->where('action', 'like', '%' . $this->activitySearch . '%')
            ->orWhere('module', 'like', '%' . $this->activitySearch . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'activityPage');

        // Dashboard Stats
        $stats = [
            'total_audits' => AuditLog::count(),
            'total_activities' => ActivityLog::count(),
            'locked_users' => User::where('is_active', false)->count(),
        ];

        return view('livewire.admin.security-monitoring', [
            'auditLogs' => $auditLogs,
            'activityLogs' => $activityLogs,
            'stats' => $stats,
        ])->layout('components.layouts.admin');
    }
}
