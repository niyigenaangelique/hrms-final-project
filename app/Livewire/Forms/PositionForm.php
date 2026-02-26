<?php

namespace App\Livewire\Forms;

use App\Enum\ApprovalStatus;
use App\Models\Position;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class PositionForm extends Form
{
    public ?Position $position = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $description = null;

    // Float fields (for DB storage)
    public ?float $minimum_pay = 0.00;
    public ?float $maximum_pay = 0.00;

    // String fields (for UI formatting)
    public ?string $minimum_pay_string = null;
    public ?string $maximum_pay_string = null;

    public ApprovalStatus|null $approval_status = ApprovalStatus::NotApplicable;
    public ?bool $is_locked = false;
    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;

    protected array $fillableData = [
        'code',
        'name',
        'description',
        'minimum_pay',
        'maximum_pay',
        'approval_status',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'code' => ['nullable', 'string', 'max:255', Rule::unique('positions', 'code')->ignore($this->id)],
            'name' => ['required', 'string', 'max:255', Rule::unique('positions', 'name')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],

            'minimum_pay_string' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $cleaned = str_replace(',', '', $value);
                    if (!is_numeric($cleaned)) {
                        $fail('The ' . $attribute . ' must be a number.');
                    }
                },
            ],
            'maximum_pay_string' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $cleaned = str_replace(',', '', $value);
                    if (!is_numeric($cleaned)) {
                        $fail('The ' . $attribute . ' must be a number.');
                    }
                },
            ],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Code is required',
            'name.required' => 'Name is required',
            'name.unique' => 'Name must be unique',
            'name.max' => 'Name must not exceed 255 characters',
            'code.unique' => 'Code must be unique',
            'code.max' => 'Code must not exceed 255 characters',
            'minimum_pay_string.numeric' => 'Minimum pay must be a number',
            'maximum_pay_string.numeric' => 'Maximum pay must be a number',
        ];
    }

    /**
     * Load position data into form
     */
    public function setData(Position $position): void
    {
        $this->position = $position;
        $this->id = $position->id;
        $this->code = $position->code;
        $this->name = $position->name;
        $this->description = $position->description;
        $this->approval_status = $position->approval_status ?? ApprovalStatus::NotApplicable;
        $this->is_locked = (bool)$position->is_locked;
        $this->locked_by = $position->locked_by;
        $this->created_by = $position->created_by;
        $this->updated_by = $position->updated_by;
        $this->deleted_by = $position->deleted_by;

        // Format decimal values as strings for display/input
        $this->minimum_pay = $position->minimum_pay;
        $this->maximum_pay = $position->maximum_pay;

        $this->minimum_pay_string = number_format($position->minimum_pay, 2, '.', ',');
        $this->maximum_pay_string = number_format($position->maximum_pay, 2, '.', ',');
    }

    /**
     * Backup current state before operation
     */
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

    /**
     * Store new position
     */
    public function storeData(): array
    {
        try {
            // Convert string decimals back to float
            $this->minimum_pay = $this->minimum_pay_string ? (float)$this->minimum_pay_string : 0;
            $this->maximum_pay = $this->maximum_pay_string ? (float)$this->maximum_pay_string : 0;

            if (!$this->approval_status) {
                $this->approval_status = ApprovalStatus::NotApplicable;
            }

            if ($this->is_locked === null) {
                $this->is_locked = false;
            }

            $this->validate();
            $this->backupFormData();

            $excludeFields = [];
            $this->fillableData = array_values(array_diff($this->fillableData, $excludeFields));

            $position = Position::create($this->only($this->fillableData));

            $this->clearData();


            return [
                'success' => true,
                'position' => $position,
                'message' => 'Position created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Position creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Failed to create position: ' . $e->getMessage());
            $this->restoreFormData();

            Flux::modal('loadingPage')->close();

            return [
                'success' => false,
                'errors' => [],
                'position' => null,
                'message' => 'Failed to create position: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update existing position
     */
    public function updateData(): array
    {
        try {
            // Convert string decimals back to float
            $this->minimum_pay = $this->minimum_pay_string ? (float)$this->minimum_pay_string : null;
            $this->maximum_pay = $this->maximum_pay_string ? (float)$this->maximum_pay_string : null;

            $this->validate();
            $this->backupFormData();

            $excludeFields = [];
            $this->fillableData = array_values(array_diff($this->fillableData, $excludeFields));

            $this->position->update($this->only($this->fillableData));
            $this->clearData();

            return [
                'success' => true,
                'position' => $this->position,
                'message' => 'Position updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Position update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->restoreFormData();
            Flux::modal('loadingPage')->close();

            return [
                'success' => false,
                'errors' => [],
                'position' => null,
                'message' => 'Failed to update position: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Reset form
     */
    public function clearData(): void
    {
        $this->reset();
        $this->position = null;
    }
}
