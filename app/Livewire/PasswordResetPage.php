<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Password;

class PasswordResetPage extends GuestBaseClass
{
    public $email = '';
    public $status = null;

    public function submit()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find a user with that email address.',
        ]);

        $status = Password::broker()->sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = __($status);
            $this->email = ''; // clear form
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.password-reset-page');
    }
}
