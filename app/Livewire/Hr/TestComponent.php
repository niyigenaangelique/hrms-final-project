<?php

namespace App\Livewire\HR;

use Livewire\Component;

class TestComponent extends Component
{
    public $message = "Hello from Livewire!";

    public function test()
    {
        $this->message = "Button clicked at " . now();
    }

    public function render()
    {
        return view('livewire.hr.test-component')->layout('components.layouts.app');
    }
}
