<?php

namespace App\Livewire\PayslipEntry;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | PayslipEntries')]

class PayslipEntryPage extends Component
{
    #[On('payslip_entryNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.payslip-entry.payslip-entry-page');
    }
}
