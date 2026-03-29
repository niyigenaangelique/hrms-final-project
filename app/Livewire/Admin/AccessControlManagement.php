<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | Admin - Access Control Management')]

class AccessControlManagement extends Component
{
    public function render(): object
    {
        return view('livewire.admin.access-control-management')
            ->layout('components.layouts.admin');
    }
}
