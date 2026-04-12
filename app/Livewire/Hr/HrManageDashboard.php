<?php

namespace App\Livewire\HR;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('TalentFlow Pro | HR Management')]
class HrManageDashboard extends Component
{
    public function render()
    {
        return view('livewire.hr.manage')->layout('components.layouts.app');
    }
}
