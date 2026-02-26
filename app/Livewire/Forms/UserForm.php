<?php

namespace App\Livewire\Forms;

use App\Enum\UserRole;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Exception;

class UserForm extends Form
{
    public ?User $user = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $first_name = null;
    public ?string $middle_name = null;
    public ?string $last_name = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $phone_number = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public Carbon|null $phone_verified_at = null;
    public Carbon|null $email_verified_at = null;
    public Carbon|null $password_changed_at = null;
    public UserRole $role = UserRole::Employee;

    protected array $fillableData = [
        'code',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'password',
        'password_confirmation',
        'phone_verified_at',
        'email_verified_at',
        'password_changed_at',
        'role',
    ];

    public function rules(): array
    {
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $phoneRegex = '/^\+?[1-9]\d{1,14}$/';
        $RwPhoneRegex = '/^(\+2507[2-38-9]\d{7}|07[2-38-9]\d{7})$/'; // Rwanda-specific phone number
        $CombinedPhoneRegex = '/^(?:07[2-9]\d{7}|\+2507[2-9]\d{7}|\+\d{7,15})$/';
        $CombinedMaskedPhoneRegex = '/^(\+?\d[\d\s\-\(\)]{6,20}|\s*07[2-9][\d\s\-\(\)]{7,15})$/';

        return [
            'code' => ['nullable', 'string', 'max:255', Rule::unique('users', 'code')->ignore($this->id)],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'regex:' . $emailRegex, Rule::unique('users', 'email')->ignore($this->id)],
            'phone_number' => ['nullable', 'string', 'max:255', 'regex:' . $RwPhoneRegex, Rule::unique('users', 'phone_number')->ignore($this->id)],
            'phone_verified_at' => ['nullable', 'date'],
            'email_verified_at' => ['nullable', 'date'],
            'password_changed_at' => ['nullable', 'date'],
            'role' => ['required'],
            'password' => ['nullable', 'string', 'max:16', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/'],
            'password_confirmation' => ['nullable', 'string', 'max:16'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'The user code is already in use. Please use a different code.',
            'code.string' => 'The user code must be a valid string.',
            'code.max' => 'The user code cannot exceed 255 characters.',
            'first_name.required' => 'The first name is required.',
            'first_name.string' => 'The first name must be a valid string.',
            'first_name.max' => 'The first name cannot exceed 255 characters.',
            'middle_name.string' => 'The middle name must be a valid string.',
            'middle_name.max' => 'The middle name cannot exceed 255 characters.',
            'last_name.string' => 'The last name must be a valid string.',
            'last_name.max' => 'The last name cannot exceed 255 characters.',
            'username.required' => 'The username is required.',
            'username.string' => 'The username must be a valid string.',
            'username.max' => 'The username cannot exceed 255 characters.',
            'email.required' => 'The email address is required.',
            'email.string' => 'The email address must be a valid string.',
            'email.max' => 'The email address cannot exceed 255 characters.',
            'email.regex' => 'Please enter a valid email address (e.g., user@example.com).',
            'email.unique' => 'This email address is already registered.',
            'phone_number.regex' => 'Please enter a valid Rwanda phone number (e.g., +2507xxxxxxxx or 07xxxxxxxx).',
            'phone_number.string' => 'The phone number must be a valid string.',
            'phone_number.max' => 'The phone number cannot exceed 255 characters.',
            'phone_number.unique' => 'This phone number is already registered.',
            'phone_verified_at.date' => 'The phone verification date must be a valid date.',
            'email_verified_at.date' => 'The email verification date must be a valid date.',
            'password_changed_at.date' => 'The password change date must be a valid date.',
            'role.required' => 'Please select a user role.',
            'password.string' => 'The password must be a valid string.',
            'password.max' => 'The password cannot exceed 16 characters.',
            'password.confirmed' => 'The password and confirmation do not match.',
            'password.regex' => 'The password must be at least 6 characters long and include at least one lowercase letter, one uppercase letter, and one number.',
            'password_confirmation.string' => 'The password confirmation must be a valid string.',
            'password_confirmation.max' => 'The password confirmation cannot exceed 16 characters.',
        ];
    }

    public function setData(User $user): void
    {
        $this->user = $user;
        $this->id = $user->id;
        $this->code = $user->code;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->password = null; // Avoid loading password
        $this->phone_verified_at = $user->phone_verified_at;
        $this->email_verified_at = $user->email_verified_at;
        $this->password_changed_at = $user->password_changed_at;
        $this->role = $user->role;
    }

    protected array $backupData = [];

    public function backupFormData(): void
    {
        $this->backupData = $this->only($this->fillableData);
    }

    public function restoreFormData(): void
    {
        foreach ($this->backupData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function storeData(): array
    {
        try {
            $this->validate();
            $this->password = config('defaults.passwords.default');
            $this->password_confirmation = config('defaults.passwords.default');
            $excludeFields = ['password_confirmation'];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);

            $this->backupFormData(); // Backup before operation
            $user = User::create($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'user' => $user,
                'message' => 'User created successfully',
            ];
        } catch (ValidationException $e) {
            Log::error('Validation errors in storeData: ' . json_encode($e->errors()), [
                'input' => $this->only($this->fillableData),
                'errors' => $e->errors(),
            ]);

            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create user: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure
            return [
                'success' => false,
                'errors' => [],
                'user' => null,
                'message' => 'Failed to create user: ' . $e->getMessage(),
            ];
        }
    }

    public function updateData(): array
    {
        try {
            if (!$this->user) {
                throw new Exception('No user selected for update.');
            }
            $this->validate();
            $this->backupFormData(); // Backup before operation
            $excludeFields = ['password', 'password_confirmation'];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);
            $this->user->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'user' => $this->user,
                'message' => 'User updated successfully',
            ];
        } catch (ValidationException $e) {
            Log::error('Validation errors in updateData: ' . json_encode($e->errors()), [
                'input' => $this->only($this->fillableData),
                'errors' => $e->errors(),
            ]);

            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('User update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to update user: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure
            return [
                'success' => false,
                'errors' => [],
                'user' => null,
                'message' => 'Failed to update user: ' . $e->getMessage(),
            ];
        }
    }

    public function changePassword(): array
    {
        try {
            if (!$this->user) {
                throw new Exception('No user selected for password change.');
            }

            $this->validate();

            $this->backupFormData(); // Backup before operation
            $this->user->update([
                'password' => $this->password,
                'password_changed_at' => now(),
            ]);
            $this->clearData();
            return [
                'success' => true,
                'user' => $this->user,
                'message' => 'Password changed successfully',
            ];
        } catch (ValidationException $e) {
            Log::error('Validation errors in changePassword: ' . json_encode($e->errors()), [
                'input' => ['password' => $this->password ? '****' : null],
                'errors' => $e->errors(),
            ]);

            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Password change failed: ' . $e->getMessage(), [
                'user_id' => $this->user?->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to change password: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure
            return [
                'success' => false,
                'errors' => [],
                'user' => null,
                'message' => 'Failed to change password: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->user = null; // Ensure user is reset
    }
}
