<?php

namespace App\Livewire;

use App\Enum\UserRole;
use App\Helpers\FormattedCodeHelper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class HomePage extends Component
{
    use AuthorizesRequests;

    public $users = [];
    public $selected = [];
    public $selectAll = false;
    public $errors = [];

    public function rules(): array
    {
        $RwPhoneRegex = '/^(07[2-9]\d{7}|\+2507[2-9]\d{7})$/';
        $usernameRegex = '/^[a-zA-Z0-9_.-]+$/';

        $rules = [
            'users.*.first_name' => ['required', 'string', 'max:100'],
            'users.*.last_name' => ['nullable', 'string', 'max:100'],
            'users.*.username' => [
                'required',
                'string',
                'max:50',
                'regex:'.$usernameRegex,
                function ($attribute, $value, $fail) {
                    if (preg_match('/\s/', $value)) {
                        $fail('The username cannot contain spaces.');
                    }
                }
            ],
            'users.*.email' => ['required', 'email:rfc,dns', 'max:100'],
            'users.*.phone_number' => ['required', 'string', 'max:20'],
            'users.*.role' => ['required', Rule::in(UserRole::getValues())],
            'users.*.code' => ['required', 'string', 'max:20'],
        ];

        foreach ($this->users as $key => $user) {
            $userId = $user['id'] ?? null;

            $rules["users.{$key}.email"][] = Rule::unique('users', 'email')->ignore($userId);
            $rules["users.{$key}.code"][] = Rule::unique('users', 'code')->ignore($userId);
            $rules["users.{$key}.phone_number"][] = Rule::unique('users', 'phone_number')->ignore($userId);

            $rules["users.{$key}.phone_number"][] = 'regex:'.$RwPhoneRegex;

            if (empty($userId)) {
                $rules["users.{$key}.password"] = [
                    'nullable',
                    'string',
                    'min:8',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/[A-Z]/', $value) ||
                            !preg_match('/[a-z]/', $value) ||
                            !preg_match('/[0-9]/', $value)) {
                            $fail('The password must contain uppercase, lowercase, and numbers.');
                        }
                    }
                ];
            }
        }

        return $rules;
    }

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::orderBy('code')->limit(50)->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'code' => $user->code,
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name ?? '',
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'role' => $user->role->value,
                    'created_at' => $user->created_at,
                ];
            })
            ->toArray();

        if (empty($this->users)) {
            $this->addEmptyRow();
        }
    }

    public function saveData()
    {
        try {
            $this->validate($this->rules());

            DB::transaction(function () {
                $processed = ['created' => 0, 'updated' => 0];
                $usersCollection = collect($this->users);

                // Process updates
                $toUpdate = $usersCollection->whereNotNull('id');
                foreach ($toUpdate->chunk(100) as $chunk) {
                    foreach ($chunk as $user) {
                        User::where('id', $user['id'])->update($user);
                        $processed['updated']++;
                    }
                }

                // Process creates
                $toCreate = $usersCollection->whereNull('id');
                foreach ($toCreate as $user) {
                    $user['password'] = bcrypt($user['password']);
                    User::create($user);
                    $processed['created']++;
                }

                session()->flash('message',
                    "Processed {$processed['created']} new users and updated {$processed['updated']} users."
                );
            });

            $this->loadUsers();
        } catch (ValidationException $e) {
            $this->errors = $e->errors();
            dd($this->errors);
            session()->flash('error', 'Validation failed. Please check the form.');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    protected function isRowEmpty($index)
    {
        $row = $this->users[$index] ?? [];
        return empty($row['first_name']) &&
            empty($row['last_name']) &&
            empty($row['username']) &&
            empty($row['email']);
    }

    public function addEmptyRow()
    {
        if (!empty($this->users) && $this->isRowEmpty(count($this->users) - 1)) {
            return;
        }

        $this->users[] = [
            'id' => null,
            'code' => FormattedCodeHelper::getNextFormattedCode(User::class, 'SGA', 5),
            'first_name' => '',
            'middle_name' => '',
            'last_name' => '',
            'username' => '',
            'email' => '',
            'phone_number' => '',
            'role' => UserRole::Employee->value,
            'password' => ''
        ];
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
