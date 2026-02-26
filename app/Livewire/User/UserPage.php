<?php

namespace App\Livewire\User;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Users')]

class UserPage extends Component
{
    #[On('userNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.user.user-page');
    }
}
