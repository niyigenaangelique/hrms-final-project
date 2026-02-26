<?php

namespace App\Livewire\PayrollEntry;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | Payroll Entries')]

class PayrollEntryPage extends Component
{
    #[On('payroll_entryNotification')]
    public function handleNotification(): void
    {

    }
    
    public function render():object
    {
        return view('livewire.payroll-entry.payroll-entry-page')
            ->layout('components.layouts.app');
    }
}
