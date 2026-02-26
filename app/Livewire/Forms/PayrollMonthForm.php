<?php

namespace App\Livewire\Forms;


use App\Enum\ApprovalStatus;
use App\Models\PayrollMonth;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class PayrollMonthForm extends Form {

    public ?PayrollMonth $payrollMonth = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $description = null;
    public Carbon|null $start_date = null;
    public Carbon|null $end_date = null;
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
        'start_date',
        'end_date',
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
            'code' => ['nullable','string','max:255',Rule::unique('payroll_months', 'code')->ignore($this->id),],
            'name' => ['required','string','max:255',Rule::unique('payroll_months', 'name')->ignore($this->id),],
            'description' => ['nullable','string','max:255'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date', 'after_or_equal:start_date'],

        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after start date.',
            'code.required' => 'Code is required.',
            'code.unique' => 'Code must be unique.',
            'code.max' => 'Code must not be greater than 255 characters.',
            'name.required' => 'Name is required.',
            'name.unique' => 'Name must be unique.',
            'name.max' => 'Name must not be greater than 255 characters.',
        ];
    }

    public function setData(PayrollMonth $payrollMonth): void {
        $this->payrollMonth = $payrollMonth;
        $this->id = $payrollMonth->id;
        $this->code = $payrollMonth->code;
        $this->name = $payrollMonth->name;
        $this->description = $payrollMonth->description;
        $this->start_date = $payrollMonth->start_date;
        $this->end_date = $payrollMonth->end_date;
        $this->approval_status = $payrollMonth->approval_status;
        $this->is_locked = $payrollMonth->is_locked;
        $this->locked_by = $payrollMonth->locked_by;
        $this->created_by = $payrollMonth->created_by;
        $this->updated_by = $payrollMonth->updated_by;
        $this->deleted_by = $payrollMonth->deleted_by;
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
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);

            $this->backupFormData(); // Backup before operation
            $payrollMonth = PayrollMonth::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'payrollMonth' => $payrollMonth,
                'message' => 'PayrollMonth created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('PayrollMonth creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create payrollMonth: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'payrollMonth' => null,
                'message' => 'Failed to create payrollMonth: ' . $e->getMessage(),
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
            $this->payrollMonth->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'payrollMonth' => $this->payrollMonth,
                'message' => 'PayrollMonth updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('PayrollMonth update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'payrollMonth' => null,
                'message' => 'Failed to update payrollMonth: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->payrollMonth = null; // Ensure payrollMonth is reset
    }
}
