<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | Admin - Notifications Management')]

class NotificationsManagement extends Component
{
    public function render(): object
    {
        return view('livewire.admin.notifications-management')
            ->layout('components.layouts.admin');
    }
}
