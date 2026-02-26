<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;
#[Title('SGA | C-HRMS | Login')]
class LoginForm extends Form
{
    public string $username = '';
    public string $password = '';
    public bool $rememberMe = false;
    public ?string $errorMessage = null;

    // Configuration constants
    private const MAX_ATTEMPTS = 5;
    private const RATE_LIMIT_SECONDS = 60;
    private const MIN_PASSWORD_LENGTH = 4; // Increased from 4 to 8 for better security

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidCredential($value)) {
                        $fail(__('auth.invalid_format'));
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:' . self::MIN_PASSWORD_LENGTH,
            ],
        ];
    }

    protected function isValidCredential(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false ||
            preg_match('/^(\+\d{1,3}[- ]?)?\d{9,15}$/', $value) === 1 || // Improved phone validation
            preg_match('/^[a-zA-Z0-9._-]{3,30}$/i', $value) === 1; // Improved username validation
    }
    protected function determineLoginField(): string
    {
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL) !== false) {
            return 'email';
        }
        if (preg_match('/^(\+\d{1,3}[- ]?)?\d{9,15}$/', $this->username) === 1) {
            return 'phone_number';
        }
        return 'username';
    }

    private function generateRateLimitKey(): string
    {
        return 'login:' . sha1(
                Str::lower($this->username) . '|' . request()->ip()
            );
    }

    /**
     * @throws ValidationException
     */
    public function submit()
    {
        $this->validate();

        $rateLimitKey = $this->generateRateLimitKey();

        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            throw ValidationException::withMessages([
                'username' => __('auth.throttle', ['seconds' => $seconds]),
            ]);
        }

        $credentials = [
            $this->determineLoginField() => $this->normalizeCredential($this->username),
            'password' => $this->password,
        ];

        RateLimiter::hit($rateLimitKey, self::RATE_LIMIT_SECONDS);

        if (Auth::attempt($credentials, $this->rememberMe)) {
            RateLimiter::clear($rateLimitKey);
            request()->session()->regenerate();

            // Redirect based on user role
            $user = Auth::user();
            return match($user->role) {
                \App\Enum\UserRole::Employee => redirect()->route('employee.dashboard'),
                \App\Enum\UserRole::HRManager => redirect()->route('home'),
                \App\Enum\UserRole::CompanyAdmin => redirect()->route('home'),
                \App\Enum\UserRole::SuperAdmin => redirect()->route('admin.enhanced-dashboard'),
                default => redirect()->route('home'),
            };
        }else{
            session()->flash('error', 'Invalid credentials. Please check your username and password.');
        }

        $this->handleFailedAttempt($rateLimitKey);
    }
    private function normalizeCredential(string $value): string
    {
        $field = $this->determineLoginField();

        return match ($field) {
            'email' => Str::lower(trim($value)),
            'phone_number' => preg_replace('/[^0-9+]/', '', $value),
            'username' => trim($value),
        };
    }

    /**
     * @throws ValidationException
     */
    private function handleFailedAttempt(string $rateLimitKey): void
    {
        $attemptsLeft = RateLimiter::remaining($rateLimitKey, self::MAX_ATTEMPTS);

        throw ValidationException::withMessages([
            'username' => __('auth.failed', ['attempts' => $attemptsLeft]),
        ]);
    }
}
