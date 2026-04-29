<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | NotificationBells')]

class NotificationBell extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $showDropdown = false;

    public function mount()
    {
        $this->syncSystemNotifications();
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->where('status', 'sent')
            ->latest()
            ->take(10)
            ->get();
        
        $this->unreadCount = \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->where('status', 'sent')
            ->count();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        if ($this->showDropdown) {
            $this->loadNotifications();
        }
    }

    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::find($id);
        if ($notification) {
            $notification->update(['is_read' => true, 'read_at' => now()]);
        }
        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        $this->loadNotifications();
    }

    /**
     * Proactively find holidays, contract expiries, and paydays 
     * and create notifications for the current user if they are Admin/HR.
     */
    public function syncSystemNotifications()
    {
        $user = auth()->user();
        if (!$user) {
            return;
        }

        $now = now();
        $isAdminOrHR = method_exists($user, 'isAdmin') && ($user->isAdmin() || $user->isHrManager());
        
        // 1. Contract Expiry
        if ($isAdminOrHR) {
            // HR sees all expiring contracts
            $expiringContracts = \App\Models\Contract::with('employee')
                ->where('status', 'active')
                ->whereBetween('end_date', [$now, $now->copy()->addDays(30)])
                ->get();

            foreach ($expiringContracts as $contract) {
                $uniqueKey = "contract_expiry_{$contract->id}_{$contract->end_date->format('Y-m')}";
                $this->createSystemNotification(
                    'Contract Expiry Warning',
                    "The contract for {$contract->employee->full_name} ({$contract->code}) is expiring on {$contract->end_date->format('M d, Y')}.",
                    'contract_expiry',
                    'high',
                    $uniqueKey
                );
            }
        }

        // 2. Upcoming Holidays (Everyone sees these)
        $upcomingHolidays = \App\Models\Holiday::whereBetween('date', [$now, $now->copy()->addDays(10)])
            ->orWhere(function($q) use ($now) {
                $q->where('is_recurring', true)
                  ->whereMonth('date', $now->month)
                  ->whereDay('date', '>=', $now->day)
                  ->whereDay('date', '<=', $now->copy()->addDays(10)->day);
            })->get();

        foreach ($upcomingHolidays as $holiday) {
            $uniqueKey = "holiday_{$holiday->id}_{$now->year}";
            $this->createSystemNotification(
                'Upcoming Holiday',
                "Reminder: {$holiday->name} is on {$holiday->date->format('M d')}.",
                'holiday',
                'low',
                $uniqueKey
            );
        }

        // 3. Payday Reminder (Everyone sees this)
        if ($now->daysInMonth - $now->day <= 5) {
            $uniqueKey = "payday_reminder_{$now->format('Y-m')}";
            $this->createSystemNotification(
                'Payday Reminder',
                $isAdminOrHR 
                    ? "Payroll for {$now->format('F Y')} should be finalized within the next 5 days."
                    : "Payday for {$now->format('F Y')} is approaching!",
                'pay_reminder',
                'urgent',
                $uniqueKey
            );
        }
    }

    private function createSystemNotification($title, $body, $type, $priority, $uniqueKey)
    {
        // Check if this specific notification already exists for this user
        $exists = \App\Models\Notification::where('user_id', auth()->id())
            ->where('metadata->unique_key', $uniqueKey)
            ->exists();

        if (!$exists) {
            \App\Models\Notification::create([
                'user_id' => auth()->id(),
                'title' => $title,
                'body' => $body,
                'type' => $type,
                'priority' => $priority,
                'status' => 'sent',
                'sent_at' => now(),
                'is_read' => false,
                'channel' => 'in_app',
                'metadata' => ['unique_key' => $uniqueKey]
            ]);
        }
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
