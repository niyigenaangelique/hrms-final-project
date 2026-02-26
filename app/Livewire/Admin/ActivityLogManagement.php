<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ActivityLogManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public $search = '';
    public $actionFilter = '';
    public $dateFilter = '';
    public $userFilter = '';

    public function mount()
    {
        // Initialize with empty values
    }

    public function render()
    {
        $activityLogs = $this->loadActivityLogs();
        $users = User::orderBy('first_name')->pluck('first_name', 'last_name', 'id')->toArray();

        return view('livewire.admin.activity-log-management', [
            'activityLogs' => $activityLogs,
            'users' => $users,
        ])->layout('components.layouts.admin');
    }

    private function loadActivityLogs()
    {
        $query = ActivityLog::with(['user'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('action', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                               ->orWhere('last_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        return $query->paginate(20);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->actionFilter = '';
        $this->dateFilter = '';
        $this->userFilter = '';
        $this->resetPage();
    }

    public function exportLogs()
    {
        // Export functionality placeholder
        session()->flash('info', 'Export functionality coming soon');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedActionFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function updatedUserFilter()
    {
        $this->resetPage();
    }

    public function getActivityStats()
    {
        return [
            'total_logs' => ActivityLog::count(),
            'today_logs' => ActivityLog::whereDate('created_at', today())->count(),
            'unique_users' => ActivityLog::distinct('user_id')->count('user_id'),
            'failed_logins' => ActivityLog::where('action', 'login_failed')->count(),
        ];
    }
}
