<?php

namespace App\Livewire\Admin;

use App\Models\Session;
use App\Models\User;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ActiveSessionManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public $search = '';
    public $statusFilter = '';
    public $userFilter = '';

    public function mount()
    {
        // Initialize with empty values
    }

    public function render()
    {
        $activeSessions = $this->loadActiveSessions();
        $users = User::orderBy('first_name')->pluck('first_name', 'last_name', 'id')->toArray();

        return view('livewire.admin.active-session-management', [
            'activeSessions' => $activeSessions,
            'users' => $users,
            'sessionStats' => $this->getSessionStats(),
        ])->layout('components.layouts.admin');
    }

    private function loadActiveSessions()
    {
        $query = Session::with(['user'])
            ->orderBy('last_activity', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhere('user_agent', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                               ->orWhere('last_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            if ($this->statusFilter === 'active') {
                $query->where('last_activity', '>', now()->subMinutes(30));
            } elseif ($this->statusFilter === 'idle') {
                $query->where('last_activity', '<=', now()->subMinutes(30));
            }
        }

        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        return $query->paginate(20);
    }

    public function terminateSession($id)
    {
        $session = Session::findOrFail($id);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'session_terminated',
            'description' => "Terminated session for user: {$session->user?->first_name} {$session->user?->last_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $session->delete();

        session()->flash('success', 'Session terminated successfully!');
    }

    public function terminateAllUserSessions($userId)
    {
        $user = User::findOrFail($userId);
        $sessions = Session::where('user_id', $userId)->get();
        
        foreach ($sessions as $session) {
            $session->delete();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'all_user_sessions_terminated',
            'description' => "Terminated all sessions for user: {$user->first_name} {$user->last_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'All sessions for user terminated successfully!');
    }

    public function terminateAllIdleSessions()
    {
        $idleSessions = Session::where('last_activity', '<=', now()->subMinutes(30))->get();
        $count = $idleSessions->count();
        
        foreach ($idleSessions as $session) {
            $session->delete();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'idle_sessions_terminated',
            'description' => "Terminated {$count} idle sessions",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', "{$count} idle sessions terminated successfully!");
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->userFilter = '';
        $this->resetPage();
    }

    public function getSessionStats()
    {
        return [
            'total_sessions' => Session::count(),
            'active_sessions' => Session::where('last_activity', '>', now()->subMinutes(30))->count(),
            'idle_sessions' => Session::where('last_activity', '<=', now()->subMinutes(30))->count(),
            'unique_users' => Session::distinct('user_id')->count('user_id'),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedUserFilter()
    {
        $this->resetPage();
    }
}
