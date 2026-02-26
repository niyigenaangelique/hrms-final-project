<?php

namespace App\Livewire\Project;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | Projects')]

class ProjectPage extends Component
{
    #[On('projectNotification')]
    public function handleNotification(): void
    {

    }
    public function render():object
    {
        return view('livewire.project.project-page');
    }
}
