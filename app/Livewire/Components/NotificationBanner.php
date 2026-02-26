<?php

namespace App\Livewire\Components;

use App\Models\Message;
use App\Models\LeaveRequest;
use Livewire\Component;

class NotificationBanner extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        // Temporarily disabled to prevent errors
        $this->notifications = [];
        $this->unreadCount = 0;
    }

    public function loadNotifications()
    {
        // Temporarily disabled to prevent errors
        $this->notifications = [];
        $this->unreadCount = 0;
    }

    public function render()
    {
        return view('livewire.components.notification-banner');
    }
}
