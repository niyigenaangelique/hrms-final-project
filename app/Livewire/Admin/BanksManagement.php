<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | Admin - Banks Management')]

class BanksManagement extends Component
{
    public function render(): object
    {
        return view('livewire.admin.banks-management')
            ->layout('components.layouts.admin');
    }
}
