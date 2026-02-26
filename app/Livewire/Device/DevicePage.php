<?php

namespace App\Livewire\Device;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Devices')]

class DevicePage extends Component
{
    #[On('deviceNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.device.device-page');
    }
}
