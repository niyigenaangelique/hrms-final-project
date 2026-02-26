<?php

namespace App\Livewire\Forms;

use App\Enum\ApprovalStatus;
use App\Models\AuthorizedOvertime;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class AuthorizedOvertimeForm extends Form {

    public ?AuthorizedOvertime $authorizedOvertime = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $employee_id = null;
    public Carbon|null $start_date = null;
    public Carbon|null $end_date = null;
    public ?string $hour_rate = null;
    public ApprovalStatus|null $approval_status = ApprovalStatus::NotApplicable;
    public ?bool $is_locked = false;
    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;

    protected array $fillableData = [
        'code',
        'employee_id',
        'start_date',
        'end_date',
        'hour_rate',
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
            'code' => ['nullable','string','max:255',Rule::unique('authorized_overtimes', 'code')->ignore($this->id),],
            'employee_id' => ['required','string','max:255',Rule::exists('employees', 'id')],
            'start_date' => ['required','date'],
            'end_date' => ['required','date', 'after_or_equal:start_date'],
            'hour_rate' => ['required','string','max:255'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.required' => 'Code is required',
            'code.unique' => 'Code must be unique',
            'code.max' => 'Code must not be greater than 255 characters',
            'employee_id.required' => 'Employee ID is required',
            'employee_id.exists' => 'The selected employee does not exist',
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.required' => 'End date is required',
            'end_date.date' => 'End date must be a valid date',
            'end_date.after' => 'End date must be after start date',
            'hour_rate.required' => 'Hour rate is required',
        ];
    }

    public function setData(AuthorizedOvertime $authorizedOvertime): void {
        $this->authorizedOvertime = $authorizedOvertime;
        $this->id = $authorizedOvertime->id;
        $this->code = $authorizedOvertime->code;
        $this->employee_id = $authorizedOvertime->employee_id;
        $this->start_date = $authorizedOvertime->start_date;
        $this->end_date = $authorizedOvertime->end_date;
        $this->hour_rate = $authorizedOvertime->hour_rate;
        $this->approval_status = $authorizedOvertime->approval_status;
        $this->is_locked = $authorizedOvertime->is_locked;
        $this->locked_by = $authorizedOvertime->locked_by;
        $this->created_by = $authorizedOvertime->created_by;
        $this->updated_by = $authorizedOvertime->updated_by;
        $this->deleted_by = $authorizedOvertime->deleted_by;
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
            $authorizedOvertime = AuthorizedOvertime::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'authorizedOvertime' => $authorizedOvertime,
                'message' => 'AuthorizedOvertime created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('AuthorizedOvertime creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create Authorized Overtime: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'authorizedOvertime' => null,
                'message' => 'Failed to create Authorized Overtime: ' . $e->getMessage(),
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
            $this->authorizedOvertime->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'authorizedOvertime' => $this->authorizedOvertime,
                'message' => 'AuthorizedOvertime updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('AuthorizedOvertime update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'authorizedOvertime' => null,
                'message' => 'Failed to update Authorized Overtime: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->authorizedOvertime = null; // Ensure user is reset
    }
}
