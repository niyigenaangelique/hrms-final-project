<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | Admin - Imports Management')]

class ImportsManagement extends Component
{
    public function render(): object
    {
        return view('livewire.admin.imports-management')
            ->layout('components.layouts.admin');
    }
}
