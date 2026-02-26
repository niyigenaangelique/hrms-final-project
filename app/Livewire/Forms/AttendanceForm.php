<?php

namespace App\Livewire\Forms;

use App\Enum\ApprovalStatus;
use App\Enum\AttendanceMethod;
use App\Enum\AttendanceStatus;
use App\Models\Attendance;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttendanceForm extends Form {

    public ?Attendance $attendance = null;
    public ?string $id = null;
    public ?string $code = null;
    public string $employee_id;
    public Carbon $date;
    public datetime $check_in;
    public ?datetime $check_out = null;
    public ?string $device_id = null;
    public AttendanceMethod|null $check_in_method = null;
    public AttendanceMethod|null $check_out_method = null;
    public AttendanceStatus|null $status = null;
    public ApprovalStatus|null $approval_status = ApprovalStatus::NotApplicable;
    public ?bool $is_locked = false;
    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;


    protected array $fillableData = [
        'code',
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'device_id',
        'check_in_method',
        'check_out_method',
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
            'code' => ['nullable','string','max:255',Rule::unique('attendances', 'code')->ignore($this->id),],
            'employee_id' => ['required','string','max:255',Rule::exists('employees', 'id')],
            'device_id' => ['nullable','string','max:255',Rule::exists('devices', 'id')],
            'date' => ['required','date'],
            'check_in' => ['required','date'],
            'check_out' => ['nullable','date', 'after_or_equal:check_in'],


        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.unique' => 'The attendance code must be unique.',
            'code.max' => 'The attendance code may not be greater than 255 characters.',
            'employee_id.required' => 'The employee ID is required.',
            'employee_id.exists' => 'The selected employee does not exist.',
            'date.required' => 'The date is required.',
            'date.date' => 'The date must be a valid date.',
            'check_in.required' => 'The check-in time is required.',
            'check_in.date' => 'The check-in time must be a valid date.',
            'check_out.date' => 'The check-out time must be a valid date.',
            'check_out.after' => 'The check-out time must be after the check-in time.',
            'device_id.max' => 'The device ID may not be greater than 255 characters.',
            'device_id.exists' => 'The selected device does not exist.',

        ];
    }

    public function setData(Attendance $attendance): void {
        $this->attendance = $attendance;
        $this->id = $attendance->id;
        $this->code = $attendance->code;
        $this->employee_id = $attendance->employee_id;
        $this->date = $attendance->date;
        $this->check_in = $attendance->check_in;
        $this->check_out = $attendance->check_out;
        $this->device_id = $attendance->device_id;
        $this->check_in_method = $attendance->check_in_method;
        $this->check_out_method = $attendance->check_out_method;
        $this->status = $attendance->status;
        $this->approval_status = $attendance->approval_status;
        $this->is_locked = $attendance->is_locked;
        $this->locked_by = $attendance->locked_by;
        $this->created_by = $attendance->created_by;
        $this->updated_by = $attendance->updated_by;
        $this->deleted_by = $attendance->deleted_by;
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
            $attendance = Attendance::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'user' => $attendance,
                'message' => 'Attendance created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Attendance creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create user: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
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
            $this->validate();
            $this->backupFormData(); // Backup before operation
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);
            $this->attendance->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'user' => $this->attendance,
                'message' => 'Attendance updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Attendance update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'user' => null,
                'message' => 'Failed to update user: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->attendance = null; // Ensure user is reset
    }
}
