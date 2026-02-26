<?php

namespace App\Livewire\AuthorizedOvertime;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | AuthorizedOvertimes')]

class AuthorizedOvertimePage extends Component
{
    #[On('authorized_overtimeNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.authorized-overtime.authorized-overtime-page');
    }
}
