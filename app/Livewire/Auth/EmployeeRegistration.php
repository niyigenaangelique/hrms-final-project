<?php

namespace App\Livewire\Auth;

use App\Enum\UserRole;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EmployeeRegistration extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone_number = '';
    public $password = '';
    public $password_confirmation = '';
    public $employee_code = '';

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'required|string|max:20',
        'password' => 'required|min:8|confirmed',
        'employee_code' => 'required|string|max:50',
    ];

    public function register()
    {
        $this->validate();

        try {
            // Generate user code
            $code = 'EMP-' . str_pad(User::query()->count() + 1, 3, '0', STR_PAD_LEFT);

            $user = User::create([
                'code' => $code,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'password' => Hash::make($this->password),
                'role' => UserRole::Employee,
                'email_verified_at' => now(),
            ]);

            Log::info('New employee registered', ['user_id' => $user->id, 'email' => $this->email]);

            Flux::toast('Registration successful! You can now login.', 'Success', 5000, variant: 'success');
            
            // Redirect to login after successful registration
            return redirect()->route('login');

        } catch (\Exception $e) {
            Log::error('Employee registration failed', ['error' => $e->getMessage()]);
            Flux::toast('Registration failed. Please try again.', 'Error', 5000, variant: 'danger');
        }
    }

    public function render()
    {
        return view('livewire.auth.employee-registration')->layout('components.layouts.guest');
    }
}
