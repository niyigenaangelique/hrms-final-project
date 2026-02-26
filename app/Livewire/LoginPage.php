<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginPage extends GuestBaseClass
{
    public LoginForm  $form;

    /**
     * @throws ValidationException
     */
    public function submit(): void
    {
        $this->form->submit();
    }
    public function render(): object
    {
        return view('livewire.login-page');
    }
}
