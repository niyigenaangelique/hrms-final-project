<?php

namespace App\Livewire\Contract;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Contracts')]

class ContractPage extends Component
{
    #[On('contractNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.contract.contract-page');
    }
}
