<?php

namespace App\Livewire\Bank;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Banks')]

class BankPage extends Component
{
    #[On('bankNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.bank.bank-page');
    }
}
