<?php

namespace App\Livewire\Forms;


use App\Enum\ApprovalStatus;
use App\Models\Employee;
use App\Rules\RwandanNationalIdRule;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class EmployeeForm extends Form {

    public ?Employee $employee = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $middle_name = null;
    public ?string $gender = null;
    public ?DateTime $birth_date = null;
    public ?string $nationality = null;
    public ?string $national_id = null;
    public ?string $passport_number = null;
    public ?string $rss_number = null;
    public ?DateTime $join_date = null;
    public ?string $phone_number = null;
    public ?string $email = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $country = null;
    public ?float $basic_salary = null;
    public ?float $daily_rate = null;
    public ?float $hourly_rate = null;
    public ?string $salary_currency = 'RWF';
    public ?string $payment_method = 'bank';
    public ?string $bank_name = null;
    public ?string $bank_account_number = null;
    public ?string $bank_branch = null;
    public ?string $mobile_money_provider = null;
    public ?string $mobile_money_number = null;
    public ?DateTime $salary_effective_date = null;
    public ?bool $is_taxable = true;
    public ?float $rssb_rate = 3.00;
    public ?float $pension_rate = 5.00;
    public ApprovalStatus|null $approval_status = ApprovalStatus::NotApplicable;
    public ?bool $is_locked = false;
    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;

    protected array $fillableData = [
        'code',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'birth_date',
        'nationality',
        'national_id',
        'passport_number',
        'rss_number',
        'join_date',
        'phone_number',
        'email',
        'address',
        'city',
        'state',
        'country',
        'basic_salary',
        'daily_rate',
        'hourly_rate',
        'salary_currency',
        'payment_method',
        'bank_name',
        'bank_account_number',
        'bank_branch',
        'mobile_money_provider',
        'mobile_money_number',
        'salary_effective_date',
        'is_taxable',
        'rssb_rate',
        'pension_rate',
        'approval_status',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** @return array<string, array<int, string>> */
    public function rules(): array {

        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $phoneRegex = '/^\+?[1-9]\d{1,14}$/';
        $RwPhoneRegex = '/^(\+2507[2-38-9]\d{7}|07[2-38-9]\d{7})$/'; // Rwanda-specific phone number
        $RwNationalId = '/^[1-2][0-9]{4}[7-8][0-9]{7}[0-9]{1}[0-9]{2}$/'; // Rwanda-specific National ID
        $RwRssbNumberRegex = '/^\d{8}([A-Za-z])?$/'; // Rwanda-specific RSSB number

        $CombinedPhoneRegex = '/^(?:07[2-9]\d{7}|\+2507[2-9]\d{7}|\+\d{7,15})$/';
        $CombinedMaskedPhoneRegex = '/^(\+?\d[\d\s\-\(\)]{6,20}|\s*07[2-9][\d\s\-\(\)]{7,15})$/';
        $employeeId = $this->employee?->id ?? $this->id;
        
        return [
            'code' => ['nullable','string','max:255',Rule::unique('employees', 'code')->ignore($employeeId)],
            'first_name' => ['required','string','max:255'],
            'last_name' => ['nullable','string','max:255'],
            'middle_name' => ['nullable','string','max:255'],
            'gender' => ['required','string','max:255'],
            'birth_date' => ['nullable','date'],
            'nationality' => ['nullable','string','max:255'],
            'national_id' => ['nullable','string','regex:' . $RwNationalId,'max:16',Rule::unique('employees', 'national_id')->ignore($employeeId)],
            'passport_number' => ['nullable','string','max:255',Rule::unique('employees', 'passport_number')->ignore($employeeId)],
            'rss_number' => ['nullable','string', 'regex:' . $RwRssbNumberRegex,Rule::unique('employees', 'rss_number')->ignore($employeeId)],
            'join_date' => ['required','date'],
            'phone_number' => [
                'nullable', 
                'string', 
                'regex:' . $RwPhoneRegex, 
                Rule::unique('employees', 'phone_number')->ignore($employeeId)->where(function ($query) {
                    // Only check uniqueness if we're updating and the phone has changed
                    if ($this->employee && $this->employee->phone_number === $this->phone_number) {
                        return $query->where('id', '!=', $this->employee->id); // This will never match, effectively skipping the check
                    }
                    return $query;
                })
            ],
            'email' => [
                'nullable', 
                'string', 
                'max:255', 
                'regex:' . $emailRegex, 
                Rule::unique('employees', 'email')->ignore($employeeId)->where(function ($query) {
                    // Only check uniqueness if we're updating and the email has changed
                    if ($this->employee && $this->employee->email === $this->email) {
                        return $query->where('id', '!=', $this->employee->id); // This will never match, effectively skipping the check
                    }
                    return $query;
                })
            ],
            'basic_salary' => ['nullable','numeric','min:0'],
            'salary_currency' => ['nullable','string','max:3'],
            'payment_method' => ['nullable','string','in:bank,cash,mobile_money'],
            'bank_name' => ['nullable','string','max:255'],
            'bank_account_number' => ['nullable','string','max:50'],
            'bank_branch' => ['nullable','string','max:255'],
            'mobile_money_provider' => ['nullable','string','max:255'],
            'mobile_money_number' => ['nullable','string','max:20'],
            'salary_effective_date' => ['nullable','date'],
            'is_taxable' => ['nullable','boolean'],
            'rssb_rate' => ['nullable','numeric','min:0','max:100'],
            'pension_rate' => ['nullable','numeric','min:0','max:100'],


        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'phone_number.regex' => 'Invalid phone number format.',
            'email.regex' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'phone_number.unique' => 'Phone number already exists.',
            'national_id.unique' => 'National ID already exists.',
            'passport_number.unique' => 'Passport number already exists.',
            'rss_number.unique' => 'RSS number already exists.',
            'code.required' => 'The code field is required.',
            'code.unique' => 'The code has already been taken.',
            'code.max' => 'The code must not be greater than 255 characters.',
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name must not be greater than 255 characters.',
            'last_name.max' => 'The last name must not be greater than 255 characters.',
            'middle_name.max' => 'The middle name must not be greater than 255 characters.',
            'gender.required' => 'The gender is required.',
            'gender.max' => 'The gender must not be greater than 255 characters.',
            'birth_date.date' => 'The birth date must be a valid date.',
            'nationality.max' => 'The nationality must not be greater than 255 characters.',
            'national_id.max' => 'The national ID must not be greater than 16 characters.',
            'passport_number.max' => 'The passport number must not be greater than 255 characters.',
            'rss_number.max' => 'The RSS number must not be greater than 255 characters.',
            'join_date.required' => 'The join date is required.',
            'join_date.date' => 'The join date must be a valid date.',
            'email.max' => 'The email must not be greater than 255 characters.',

        ];
    }

    public function setData(Employee $employee): void {
        $this->employee = $employee;
        $this->id = $employee->id;
        $this->code = $employee->code;
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->middle_name = $employee->middle_name;
        $this->gender = $employee->gender;
        $this->birth_date = $employee->birth_date;
        $this->nationality = $employee->nationality;
        $this->national_id = $employee->national_id;
        $this->passport_number = $employee->passport_number;
        $this->rss_number = $employee->rss_number;
        $this->join_date = $employee->join_date;
        $this->phone_number = $employee->phone_number;
        $this->email = $employee->email;
        $this->address = $employee->address;
        $this->city = $employee->city;
        $this->state = $employee->state;
        $this->country = $employee->country;
        $this->basic_salary = $employee->basic_salary;
        $this->daily_rate = $employee->daily_rate;
        $this->hourly_rate = $employee->hourly_rate;
        $this->salary_currency = $employee->salary_currency;
        $this->payment_method = $employee->payment_method;
        $this->bank_name = $employee->bank_name;
        $this->bank_account_number = $employee->bank_account_number;
        $this->bank_branch = $employee->bank_branch;
        $this->mobile_money_provider = $employee->mobile_money_provider;
        $this->mobile_money_number = $employee->mobile_money_number;
        $this->salary_effective_date = $employee->salary_effective_date;
        $this->is_taxable = $employee->is_taxable;
        $this->rssb_rate = $employee->rssb_rate;
        $this->pension_rate = $employee->pension_rate;
        $this->locked_by = $employee->locked_by;
        $this->created_by = $employee->created_by;
        $this->updated_by = $employee->updated_by;
        $this->deleted_by = $employee->deleted_by;

    }

    protected array $backupData = [];

    public function backupFormData(): void {
        $this->backupData = $this->only($this->fillableData);
    }

    public function restoreFormData(): void {
        foreach ($this->backupData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function storeData(): array {
        try {
            $this->validate();
            
            // Calculate daily and hourly rates from basic salary
            if ($this->basic_salary) {
                $this->daily_rate = $this->basic_salary / 22; // 22 working days
                $this->hourly_rate = $this->daily_rate / 8; // 8 working hours
            }
            
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);

            $this->backupFormData(); // Backup before operation
            $employee = Employee::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'employee' => $employee,
                'message' => 'Employee created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Employee creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create employee: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'employee' => null,
                'message' => 'Failed to create employee: ' . $e->getMessage(),
            ];
        }
    }



    public function updateData(): array
    {
        try {
            $this->validate();
            
            // Calculate daily and hourly rates from basic salary
            if ($this->basic_salary) {
                $this->daily_rate = $this->basic_salary / 22; // 22 working days
                $this->hourly_rate = $this->daily_rate / 8; // 8 working hours
            }
            
            $this->backupFormData(); // Backup before operation
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);
            $this->employee->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'employee' => $this->employee,
                'message' => 'Employee updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Employee update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'employee' => null,
                'message' => 'Failed to update employee: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->employee = null; // Ensure employee is reset
    }
}
