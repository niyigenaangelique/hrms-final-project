<?php

namespace App\Livewire\Forms;


use App\Enum\ApprovalStatus;
use App\Enum\AttendanceStatus;
use App\Models\PayrollEntry;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class PayrollEntryForm extends Form {

    public ?PayrollEntry $payrollEntry = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $payroll_month_id = null;
    public ?string $employee_id = null;

    public ?float $daily_rate = null;
    public ?float $work_days = null;
    public ?float $work_days_pay = null;

    public ?float $overtime_hour_rate = null;
    public ?float $overtime_hours_worked = null;
    public ?float $overtime_total_amount = null;

    public ?float $total_amount = null;

    public AttendanceStatus|null $status = null;
    public ApprovalStatus|null $approval_status = ApprovalStatus::NotApplicable;
    public ?bool $is_locked = false;

    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;


    protected array $fillableData = [
        'code',
        'payroll_month_id',
        'employee_id',

        'daily_rate',
        'work_days',
        'work_days_pay',

        'overtime_hour_rate',
        'overtime_hours_worked',
        'overtime_total_amount',

        'total_amount',

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
            'code' => ['nullable','string','max:255',Rule::unique('payroll_entries', 'code')->ignore($this->id),],
            'payroll_month_id' => ['required','string','max:255',Rule::exists('payroll_months', 'id')],
            'employee_id' => ['required','string','max:255',Rule::exists('employees', 'id')],
            'daily_rate' => ['required','numeric'],
            'work_days' => ['required','numeric'],
            'work_days_pay' => ['required','numeric'],
            'overtime_hour_rate' => ['required','numeric'],
            'overtime_hours_worked' => ['required','numeric'],
            'overtime_total_amount' => ['required','numeric'],
            'total_amount' => ['required','numeric'],
            'status' => ['required','string','max:255'],

        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.required' => 'Code is required',
            'code.unique' => 'Code must be unique',
            'code.max' => 'Code must not be greater than 255 characters',
            'payroll_month_id.required' => 'Payroll month ID is required',
            'payroll_month_id.exists' => 'The selected payroll month does not exist',
            'employee_id.required' => 'Employee ID is required',
            'employee_id.exists' => 'The selected employee does not exist',
            'daily_rate.required' => 'Daily rate is required',
            'work_days.required' => 'Work days is required',
            'work_days_pay.required' => 'Work days pay is required',
            'overtime_hour_rate.required' => 'Overtime hour rate is required',
            'overtime_hours_worked.required' => 'Overtime hours worked is required',
            'overtime_total_amount.required' => 'Overtime total amount is required',
        ];
    }

    public function setData(PayrollEntry $payrollEntry): void {
        $this->payrollEntry = $payrollEntry;
        $this->id = $payrollEntry->id;
        $this->code = $payrollEntry->code;
        $this->payroll_month_id = $payrollEntry->payroll_month_id;
        $this->employee_id = $payrollEntry->employee_id;
        $this->daily_rate = $payrollEntry->daily_rate;
        $this->work_days = $payrollEntry->work_days;
        $this->work_days_pay = $payrollEntry->work_days_pay;
        $this->overtime_hour_rate = $payrollEntry->overtime_hour_rate;
        $this->overtime_hours_worked = $payrollEntry->overtime_hours_worked;
        $this->overtime_total_amount = $payrollEntry->overtime_total_amount;
        $this->total_amount = $payrollEntry->total_amount;
        $this->status = $payrollEntry->status;
        $this->approval_status = $payrollEntry->approval_status;
        $this->is_locked = $payrollEntry->is_locked;
        $this->locked_by = $payrollEntry->locked_by;
        $this->created_by = $payrollEntry->created_by;
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
            $payrollEntry = PayrollEntry::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'payrollEntry' => $payrollEntry,
                'message' => 'PayrollEntry created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('PayrollEntry creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create payrollEntry: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'payrollEntry' => null,
                'message' => 'Failed to create payrollEntry: ' . $e->getMessage(),
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
            $this->payrollEntry->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'payrollEntry' => $this->payrollEntry,
                'message' => 'PayrollEntry updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('PayrollEntry update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'payrollEntry' => null,
                'message' => 'Failed to update payrollEntry: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->payrollEntry = null; // Ensure payrollEntry is reset
    }
}
