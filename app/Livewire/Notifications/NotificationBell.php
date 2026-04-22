<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $filterTab = 'all';
    public $notifications = [];
    public $unreadCount = 0;
    public $totalCount = 0;
    public $isHrOrAdmin = false;

    public function mount(): void
    {
        $this->isHrOrAdmin = Auth::check() && in_array(Auth::user()->role, ['admin', 'hr_manager']);
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $user = Auth::user();
        if (!$user) return;

        $query = \App\Models\Notification::with('user')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->filterTab === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->filterTab === 'pay') {
            $query->whereIn('type', ['pay_reminder', 'payslip_ready']);
        } elseif ($this->filterTab === 'leave') {
            $query->where('type', 'leave_update');
        } elseif ($this->filterTab === 'contract') {
            $query->where('type', 'contract_expiry');
        }

        $this->notifications = $query->take(10)->get();
        $this->unreadCount = \App\Models\Notification::where('user_id', $user->id)->where('is_read', false)->count();
        $this->totalCount = \App\Models\Notification::where('user_id', $user->id)->count();
    }

    public function markOne(string $id): void
    {
        try {
            \App\Models\Notification::where('id', $id)->update(['is_read' => true, 'read_at' => now()]);
            $this->loadNotifications();
        } catch (\Exception) {}
    }

    public function markAllRead(): void
    {
        try {
            \App\Models\Notification::where('user_id', Auth::id())->update(['is_read' => true, 'read_at' => now()]);
            $this->loadNotifications();
        } catch (\Exception) {}
    }

    public function dismiss(string $id): void
    {
        try {
            \App\Models\Notification::findOrFail($id)->delete();
            $this->loadNotifications();
        } catch (\Exception) {}
    }

    public function render()
    {
        return view('livewire.notifications.notification-bell');
    }
}