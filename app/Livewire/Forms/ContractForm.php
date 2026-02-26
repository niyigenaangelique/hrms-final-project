<?php

namespace App\Livewire\Forms;


use App\Enum\ApprovalStatus;
use App\Enum\ContractStatus;
use App\Enum\EmployeeCategory;
use App\Enum\RemunerationType;
use App\Models\Contract;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class ContractForm extends Form {

    public ?Contract $contract = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $employee_id = null;
    public ?string $employee_first_name = null;
    public ?string $employee_last_name = null;
    public ?string $employee_code = null;
    public ?string $employee_middle_name = null;
    public ?string $position_id = null;
    public ?string $position_name = null;
    public ?float $remuneration = null;
    public ?string $remuneration_type = 'Daily';
    public ?string $employee_category = 'Casual';
    public ?float $daily_working_hours = null;
    public ?Carbon $start_date = null;
    public ?Carbon $end_date = null;
    public ?string $status = 'draft';
    public ?string $approval_status = 'not applicable';
    public ?bool $is_locked = false;
    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;

    protected array $fillableData = [
        'code',
        'project_id',
        'employee_id',
        'position_id',
        'remuneration',
        'remuneration_type',
        'employee_category',
        'daily_working_hours',
        'start_date',
        'end_date',
        'status',
        'approval_status',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** @return array<string, array<int, string>> */
    public function rules(): array {
        return [
            'code' => ['nullable','string','max:255',Rule::unique('contracts', 'code')->ignore($this->id),],
            'employee_id' => ['required','string','max:255',Rule::exists('employees', 'id')],
            'position_id' => ['required','string','max:255',Rule::exists('positions', 'id')],
            'remuneration' => ['required','numeric','min:0'],
            'remuneration_type' => ['required','string','in:' . implode(',', RemunerationType::values())],
            'employee_category' => ['required','string','in:' . implode(',', EmployeeCategory::values())],
            'daily_working_hours' => ['required','numeric','min:0','max:24'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date', 'after_or_equal:start_date'],
            'status' => ['required','string','in:' . implode(',', ContractStatus::values())],
            'approval_status' => ['required','string','in:' . implode(',', ApprovalStatus::values())],

        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.required' => 'The code field is required.',
            'code.unique' => 'The code has already been taken.',
            'code.max' => 'The code must not be greater than 255 characters.',
            'employee_id.required' => 'The employee field is required.',
            'employee_id.exists' => 'The selected employee does not exist.',
            'position_id.required' => 'The position field is required.',
            'position_id.exists' => 'The selected position does not exist.',
            'remuneration.required' => 'The remuneration field is required.',
            'remuneration.numeric' => 'The remuneration must be a number.',
            'remuneration.min' => 'The remuneration must be at least 0.',
            'remuneration_type.required' => 'The remuneration type field is required.',
            'remuneration_type.in' => 'The selected remuneration type is invalid.',
            'employee_category.required' => 'The employee category field is required.',
            'employee_category.in' => 'The selected employee category is invalid.',
            'daily_working_hours.required' => 'The daily working hours field is required.',
            'daily_working_hours.numeric' => 'The daily working hours must be a number.',
            'daily_working_hours.min' => 'The daily working hours must be at least 0.',
            'daily_working_hours.max' => 'The daily working hours must not exceed 24.',
            'start_date.required' => 'The start date field is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date field is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The selected status is invalid.',
            'approval_status.required' => 'The approval status field is required.',
            'approval_status.in' => 'The selected approval status is invalid.',
        ];
    }

    public function setData(Contract $contract): void {
        $this->contract = $contract;
        $this->id = $contract->id;
        $this->code = $contract->code;
        $this->employee_id = $contract->employee_id;
        $this->position_id = $contract->position_id;
        $this->remuneration = $contract->remuneration;
        
        // Convert enum instances to strings for form properties
        $this->remuneration_type = is_object($contract->remuneration_type) ? $contract->remuneration_type->value : $contract->remuneration_type;
        $this->employee_category = is_object($contract->employee_category) ? $contract->employee_category->value : $contract->employee_category;
        $this->daily_working_hours = $contract->daily_working_hours;
        $this->start_date = $contract->start_date;
        $this->end_date = $contract->end_date;
        $this->status = is_object($contract->status) ? $contract->status->value : $contract->status;
        $this->approval_status = is_object($contract->approval_status) ? $contract->approval_status->value : $contract->approval_status;
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
            // Debug: Log the incoming data
            Log::info('ContractForm::storeData - Starting with data:', [
                'form_data' => $this->only($this->fillableData),
                'remuneration_type' => $this->remuneration_type,
                'employee_category' => $this->employee_category,
                'status' => $this->status,
                'approval_status' => $this->approval_status,
            ]);
            
            $this->validate();
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);

            // Prepare data - store enum values as strings
            $data = $this->only($this->fillableData);
            // Set project_id to null since projects table doesn't exist
            $data['project_id'] = null;
            
            // Debug: Log the prepared data
            Log::info('ContractForm::storeData - Prepared data:', $data);
            
            // Convert enum instances to their string values for storage
            if (isset($data['remuneration_type']) && is_object($data['remuneration_type'])) {
                $data['remuneration_type'] = $data['remuneration_type']->value;
            }
            if (isset($data['employee_category']) && is_object($data['employee_category'])) {
                $data['employee_category'] = $data['employee_category']->value;
            }
            if (isset($data['status']) && is_object($data['status'])) {
                $data['status'] = $data['status']->value;
            }
            if (isset($data['approval_status']) && is_object($data['approval_status'])) {
                $data['approval_status'] = $data['approval_status']->value;
            }

            // Debug: Log final data before creation
            Log::info('ContractForm::storeData - Final data before creation:', $data);

            $this->backupFormData(); // Backup before operation
            $contract = Contract::create($data);

            // Debug: Log successful creation
            Log::info('ContractForm::storeData - Contract created successfully:', ['contract_id' => $contract->id]);

            $this->clearData();
            return [
                'success' => true,
                'contract' => $contract,
                'message' => 'Contract created successfully',
            ];
        } catch (ValidationException $e) {
            // Debug: Log validation error
            Log::error('ContractForm::storeData - Validation error:', [
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            // Debug: Log general error
            Log::error('Contract creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create contract: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'contract' => null,
                'message' => 'Failed to create contract: ' . $e->getMessage(),
            ];
        }
    }



    public function updateData(): array
    {
        try {
            $this->validate();
            $this->backupFormData(); // Backup before operation
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);
            
            // Prepare data - store enum values as strings
            $data = $this->only($this->fillableData);
            
            // Convert enum instances to their string values for storage
            if (isset($data['remuneration_type']) && is_object($data['remuneration_type'])) {
                $data['remuneration_type'] = $data['remuneration_type']->value;
            }
            if (isset($data['employee_category']) && is_object($data['employee_category'])) {
                $data['employee_category'] = $data['employee_category']->value;
            }
            if (isset($data['status']) && is_object($data['status'])) {
                $data['status'] = $data['status']->value;
            }
            if (isset($data['approval_status']) && is_object($data['approval_status'])) {
                $data['approval_status'] = $data['approval_status']->value;
            }
            
            $this->contract->update($data);
            $this->clearData();
            return [
                'success' => true,
                'contract' => $this->contract,
                'message' => 'Contract updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Contract update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'contract' => null,
                'message' => 'Failed to update contract: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->contract = null; // Ensure contract is reset
    }
}
