<?php

namespace App\Livewire\Forms;


use App\Models\PayslipEntry;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class PayslipEntryForm extends Form {

    public ?PayslipEntry $payslipEntry = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $payroll_entry_id = null;
    public ?float $gross_pay = null;
    public ?float $paye = null;
    public ?float $pension = null;
    public ?float $maternity = null;
    public ?float $cbhi = null;
    public ?float $employer_contribution = null;
    public ?float $net_pay = null;

    protected array $fillableData = [
        'code',
        'payroll_entry_id',

        'gross_pay',
        'paye',
        'pension',
        'maternity',
        'cbhi',
        'employer_contribution',
        'net_pay',

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
            'code' => ['nullable','string','max:255',Rule::unique('payslip_entries', 'code')->ignore($this->id),],
            'payroll_entry_id' => ['required','string','max:255',Rule::exists('payroll_entries', 'id')],
            'gross_pay' => ['required','numeric'],
            'paye' => ['required','numeric'],
            'pension' => ['required','numeric'],
            'maternity' => ['required','numeric'],
            'cbhi' => ['required','numeric'],
            'employer_contribution' => ['required','numeric'],
            'net_pay' => ['required','numeric'],

        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.required' => 'The code field is required.',
            'code.unique' => 'The code has already been taken.',
            'code.max' => 'The code must not be greater than 255 characters.',
            'payroll_entry_id.required' => 'The payroll entry ID field is required.',
            'payroll_entry_id.exists' => 'The selected payroll entry does not exist.',
            'gross_pay.required' => 'The gross pay field is required.',
            'paye.required' => 'The paye field is required.',
            'pension.required' => 'The pension field is required.',
            'maternity.required' => 'The maternity field is required.',
            'cbhi.required' => 'The cbhi field is required.',
            'employer_contribution.required' => 'The employer contribution field is required.',
            'net_pay.required' => 'The net pay field is required.',
        ];
    }

    public function setData(PayslipEntry $payslipEntry): void {
        $this->payslipEntry = $payslipEntry;
        $this->id = $payslipEntry->id;
        $this->code = $payslipEntry->code;
        $this->payroll_entry_id = $payslipEntry->payroll_entry_id;
        $this->gross_pay = $payslipEntry->gross_pay;
        $this->paye = $payslipEntry->paye;
        $this->pension = $payslipEntry->pension;
        $this->maternity = $payslipEntry->maternity;
        $this->cbhi = $payslipEntry->cbhi;
        $this->employer_contribution = $payslipEntry->employer_contribution;
        $this->net_pay = $payslipEntry->net_pay;
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
            $payslipEntry = PayslipEntry::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'payslipEntry' => $payslipEntry,
                'message' => 'PayslipEntry created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('PayslipEntry creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create payslipEntry: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'payslipEntry' => null,
                'message' => 'Failed to create payslipEntry: ' . $e->getMessage(),
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
            $this->payslipEntry->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'payslipEntry' => $this->payslipEntry,
                'message' => 'PayslipEntry updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('PayslipEntry update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'payslipEntry' => null,
                'message' => 'Failed to update payslipEntry: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->payslipEntry = null; // Ensure payslipEntry is reset
    }
}
