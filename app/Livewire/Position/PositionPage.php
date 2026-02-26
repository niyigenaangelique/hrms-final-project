<?php

namespace App\Livewire\Position;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Positions')]

class PositionPage extends Component
{
    #[On('positionNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.position.position-page');
    }
}
