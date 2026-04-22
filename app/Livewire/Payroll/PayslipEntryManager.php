<?php

namespace App\Livewire\Payroll;

use App\Models\PayslipEntry;
use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

#[Title('TalentFlow Pro | Payslip Entries')]
class PayslipEntryManager extends Component
{
    use WithPagination;

    // ── List / search ───────────────────────────────────────
    public string $search              = '';
    public string $filterStatus        = '';
    public string $filterApproval      = '';
    public string $filterPayrollMonth  = '';
    public int    $perPage             = 15;

    // ── Modal state ─────────────────────────────────────────
    public bool  $showModal  = false;
    public bool  $showView   = false;
    public bool  $showDelete = false;
    public ?string $editingId  = null;
    public ?string $deletingId = null;
    
    // ── Generate Payslip ─────────────────────────────────────
    public string $generatePayrollEntryId = '';
    public bool  $showGenerateModal = false;
    public ?string $generateEditingId = null; // Track if we're editing existing payslip
    public ?PayslipEntry $viewRecord = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code                = '';
    public string $payrollEntryId      = '';
    public string $grossPay            = '';
    public string $taxableIncome       = '';
    public string $paye                = '';
    public string $pension             = '';
    public string $maternity           = '';
    public string $cbhi                = '';
    public string $employerContribution= '';
    public string $netPay              = '';
    public string $taxBracketUsed      = '';
    public string $effectiveTaxRate    = '';
    public string $status              = 'Entered';
    public string $approvalStatus      = 'pending';
    
    // Additional Deductions
    public string $loanDeduction       = '';
    public string $advanceDeduction    = '';
    public string $otherDeductions      = '';
    
    // Additional Benefits
    public string $housingAllowance     = '';
    public string $transportAllowance  = '';
    public string $mealAllowance       = '';
    public string $otherBenefits        = '';
    
    // Search and Filter
    public string $filterMonth         = '';
    
    // Tax Override Options
    public bool $overrideAutoTax       = false;
    public string $customTaxRate       = '';
    public string $manualTaxAmount      = '';
    
    // Calculated fields (for display)
    public string $adjustedGrossPay    = '';
    public string $totalDeductions     = '';
    
    // Editable percentage rates
    public string $pensionRate         = '3.0';
    public string $maternityRate       = '0.3';

    const STATUSES = [
        'Entered'   => 'Entered',
        'Generated' => 'Generated',
        'Approved'  => 'Approved',
        'Printed'   => 'Printed',
        'Posted'    => 'Posted',
    ];

    const APPROVAL_STATUSES = [
        'initiated'   => 'Initiated',
        'pending'     => 'Pending',
        'under_review' => 'Under Review',
        'approved'    => 'Approved',
        'rejected'    => 'Rejected',
        'cancelled'   => 'Cancelled',
    ];

    // ── Validation ──────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'code'                 => ['required', 'string', 'max:50', Rule::unique('payslip_entries', 'code')->ignore($this->editingId)],
            'payrollEntryId'       => ['required', 'exists:payroll_entries,id'],
            'grossPay'             => ['required', 'numeric', 'min:0'],
            'taxableIncome'        => ['required', 'numeric', 'min:0'],
            'paye'                 => ['required', 'numeric', 'min:0'],
            'pension'              => ['required', 'numeric', 'min:0'],
            'maternity'            => ['required', 'numeric', 'min:0'],
            'cbhi'                 => ['nullable', 'numeric', 'min:0'],
            'employerContribution' => ['nullable', 'numeric', 'min:0'],
            'loanDeduction'        => ['nullable', 'numeric', 'min:0'],
            'advanceDeduction'     => ['nullable', 'numeric', 'min:0'],
            'otherDeductions'      => ['nullable', 'numeric', 'min:0'],
            'housingAllowance'      => ['nullable', 'numeric', 'min:0'],
            'transportAllowance'   => ['nullable', 'numeric', 'min:0'],
            'mealAllowance'        => ['nullable', 'numeric', 'min:0'],
            'otherBenefits'        => ['nullable', 'numeric', 'min:0'],
            'netPay'               => ['required', 'numeric', 'min:0'],
            'taxBracketUsed'       => ['nullable', 'string', 'max:100'],
            'effectiveTaxRate'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'overrideAutoTax'      => ['boolean'],
            'customTaxRate'        => ['nullable', 'numeric', 'min:0', 'max:100'],
            'manualTaxAmount'      => ['nullable', 'numeric', 'min:0'],
            'status'               => ['required', Rule::in(array_keys(self::STATUSES))],
            'approvalStatus'       => ['required', Rule::in(array_keys(self::APPROVAL_STATUSES))],
        ];
    }

    protected array $messages = [
        'code.required'           => 'Entry code is required.',
        'code.unique'             => 'This code is already taken.',
        'payrollEntryId.required' => 'Please select a payroll entry.',
        'payrollEntryId.exists'   => 'Selected payroll entry does not exist.',
        'grossPay.required'       => 'Gross pay is required.',
        'grossPay.numeric'        => 'Gross pay must be a number.',
        'taxableIncome.required'  => 'Taxable income is required.',
        'paye.required'           => 'PAYE is required.',
        'pension.required'        => 'Pension is required.',
        'maternity.required'      => 'Maternity is required.',
        'cbhi.required'           => 'CBHI is required.',
        'employerContribution.required' => 'Employer contribution is required.',
        'netPay.required'         => 'Net pay is required.',
        'effectiveTaxRate.required' => 'Effective tax rate is required.',
        'effectiveTaxRate.max'    => 'Effective tax rate cannot exceed 100%.',
    ];

    // ── Lifecycle ───────────────────────────────────────────
    public function mount(): void {}

    public function updatedSearch(): void             { $this->resetPage(); }
    public function updatedFilterStatus(): void        { $this->resetPage(); }
    public function updatedFilterApproval(): void      { $this->resetPage(); }
    public function updatedFilterPayrollMonth(): void  { $this->resetPage(); }
    public function updatedFilterMonth(): void         { $this->resetPage(); }

    // ── Auto-compute net pay when deductions change ─────────
    public function updatedGrossPay(): void            { $this->recalculate(); }
    public function updatedPaye(): void                { $this->recalculate(); }
    public function updatedPension(): void             { $this->recalculate(); }
    public function updatedMaternity(): void           { $this->recalculate(); }
    public function updatedCbhi(): void                { $this->recalculate(); }
    public function updatedTaxableIncome(): void       { $this->recalculate(); }
    public function updatedLoanDeduction(): void       { $this->recalculate(); }
    public function updatedAdvanceDeduction(): void    { $this->recalculate(); }
    public function updatedOtherDeductions(): void     { $this->recalculate(); }
    public function updatedHousingAllowance(): void    { $this->recalculate(); }
    public function updatedTransportAllowance(): void { $this->recalculate(); }
    public function updatedMealAllowance(): void       { $this->recalculate(); }
    public function updatedOtherBenefits(): void       { $this->recalculate(); }
    public function updatedOverrideAutoTax(): void     { $this->recalculate(); }
    public function updatedCustomTaxRate(): void       { $this->recalculate(); }
    public function updatedManualTaxAmount(): void     { $this->recalculate(); }
    public function updatedPensionRate(): void        { $this->recalculate(); }
    public function updatedMaternityRate(): void      { $this->recalculate(); }

    private function recalculate(): void
    {
        $gross    = (float) ($this->grossPay    ?: 0);
        
        // Calculate benefits
        $housingAllowance    = (float) ($this->housingAllowance    ?: 0);
        $transportAllowance  = (float) ($this->transportAllowance  ?: 0);
        $mealAllowance       = (float) ($this->mealAllowance       ?: 0);
        $otherBenefits        = (float) ($this->otherBenefits        ?: 0);
        $totalBenefits        = $housingAllowance + $transportAllowance + $mealAllowance + $otherBenefits;
        
        // Adjusted gross pay (including benefits)
        $adjustedGross = $gross + $totalBenefits;
        
        // 1. Calculate RSSB Contributions (Employee parts) using editable rates
        $pensionRate   = (float) ($this->pensionRate ?: 3.0) / 100;
        $maternityRate = (float) ($this->maternityRate ?: 0.3) / 100;
        $pension      = round($adjustedGross * $pensionRate, 2);
        $maternity    = round($adjustedGross * $maternityRate, 2);
        
        // 2. Taxable Income
        $taxable   = max(0, $adjustedGross - $pension - $maternity);
        
        // 3. Calculate PAYE (Tax) - with override options
        if ($this->overrideAutoTax) {
            if ($this->manualTaxAmount !== '' && $this->manualTaxAmount > 0) {
                $paye = (float) $this->manualTaxAmount;
                $this->taxBracketUsed = 'Manual Override';
            } elseif ($this->customTaxRate !== '' && $this->customTaxRate > 0) {
                $paye = round($taxable * ((float) $this->customTaxRate / 100), 2);
                $this->taxBracketUsed = 'Custom Rate (' . $this->customTaxRate . '%)';
            } else {
                $paye = $this->calculatePaye($taxable);
            }
        } else {
            $paye = $this->calculatePaye($taxable);
        }
        
        // 4. Calculate additional deductions
        $loanDeduction    = (float) ($this->loanDeduction    ?: 0);
        $advanceDeduction = (float) ($this->advanceDeduction ?: 0);
        $otherDeductions  = (float) ($this->otherDeductions  ?: 0);
        $totalDeductions  = $loanDeduction + $advanceDeduction + $otherDeductions;
        
        // Calculate display fields
        $this->pension        = (string)$pension;
        $this->maternity      = (string)$maternity;
        $this->taxableIncome  = (string)$taxable;
        $this->paye           = (string)$paye;
        $this->cbhi           = (string) ((float) ($this->cbhi ?: 0));
        
        // Calculate display fields
        $this->adjustedGrossPay = (string) $adjustedGross;
        
        $cbhiVal = (float) ($this->cbhi ?: 0);
        $totalDeductionsAmount = $paye + $pension + $maternity + $cbhiVal + $totalDeductions;
        $this->totalDeductions = (string) $totalDeductionsAmount;
        
        $this->netPay = (string) max(0, $adjustedGross - $totalDeductionsAmount);

        if ($taxable > 0) {
            $this->effectiveTaxRate = (string) round(($paye / $taxable) * 100, 2);
        } else {
            $this->effectiveTaxRate = '0';
        }
        
        // Debug calculated values
        $this->dispatch('console-log', message: 'Recalculation values:');
        $this->dispatch('console-log', message: "  gross: '{$this->grossPay}' -> {$gross}");
        $this->dispatch('console-log', message: "  adjustedGross: {$adjustedGross}");
        $this->dispatch('console-log', message: "  pension: {$pension} -> '{$this->pension}'");
        $this->dispatch('console-log', message: "  maternity: {$maternity} -> '{$this->maternity}'");
        $this->dispatch('console-log', message: "  taxable: {$taxable} -> '{$this->taxableIncome}'");
        $this->dispatch('console-log', message: "  paye: {$paye} -> '{$this->paye}'");
        $this->dispatch('console-log', message: "  netPay: '{$this->netPay}'");
        $this->dispatch('console-log', message: "  effectiveTaxRate: '{$this->effectiveTaxRate}'");
    }

    private function calculatePaye(float $taxable): float
    {
        if ($taxable <= 60000) {
            $this->taxBracketUsed = '0 - 60,000 (0%)';
            return 0;
        }
        
        if ($taxable <= 100000) {
            $this->taxBracketUsed = '60,001 - 100,000 (10%)';
            return round(($taxable - 60000) * 0.10, 2);
        }
        
        if ($taxable <= 200000) {
            $this->taxBracketUsed = '100,001 - 200,000 (20%)';
            return round(4000 + ($taxable - 100000) * 0.20, 2); // 4000 is tax from previous bracket
        }
        
        // Above 200,000
        $this->taxBracketUsed = 'Above 200,000 (30%)';
        return round(24000 + ($taxable - 200000) * 0.30, 2); // 24000 is cumulative tax from previous brackets
    }

    // ── Auto-generate code ──────────────────────────────────
    private function generateCode(): string
    {
        $last = PayslipEntry::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) preg_replace('/\D/', '', $last->code)) + 1 : 1;
        return 'PSE-' . str_pad($n, 5, '0', STR_PAD_LEFT);
    }

    // ── CRUD Openers ────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        try {
            \Log::info('openEdit called with ID: ' . $id);
            
            $r = PayslipEntry::with(['payrollMonth', 'payrollEntry.employee', 'employee'])->findOrFail($id);
            
            \Log::info('PayslipEntry loaded for edit: ' . $id);
            \Log::info('PayslipEntry code: ' . ($r->code ?? 'null'));
            \Log::info('PayslipEntry payroll_entry_id: ' . ($r->payroll_entry_id ?? 'null'));
            \Log::info('PayslipEntry gross_pay: ' . ($r->gross_pay ?? 'null'));
            
            // Load payslip data into generate modal properties
            $this->generateEditingId        = $id;
            $this->generatePayrollEntryId   = $r->payroll_entry_id ?? '';
            $this->grossPay               = (string) ($r->gross_pay ?? '');
            $this->taxableIncome          = (string) ($r->taxable_income ?? '');
            $this->paye                   = (string) ($r->paye ?? '');
            $this->pension                = (string) ($r->pension ?? '');
            $this->maternity              = (string) ($r->maternity ?? '');
            $this->cbhi                   = (string) ($r->cbhi ?? '');
            $this->employerContribution    = (string) ($r->employer_contribution ?? '');
            
            // Load additional fields
            $this->loanDeduction          = (string) ($r->loan_deduction ?? '');
            $this->advanceDeduction       = (string) ($r->advance_deduction ?? '');
            $this->otherDeductions        = (string) ($r->other_deductions ?? '');
            $this->housingAllowance        = (string) ($r->housing_allowance ?? '');
            $this->transportAllowance      = (string) ($r->transport_allowance ?? '');
            $this->mealAllowance          = (string) ($r->meal_allowance ?? '');
            $this->otherBenefits          = (string) ($r->other_benefits ?? '');
            
            // Tax override options
            $this->overrideAutoTax         = false; // Reset override for editing
            $this->customTaxRate          = '';
            $this->manualTaxAmount        = '';
            $this->taxBracketUsed         = $r->tax_bracket_used ?? '';
            $this->effectiveTaxRate       = (string) ($r->effective_tax_rate ?? '');
            $this->status                 = $r->status instanceof \BackedEnum
                ? $r->status->value : ($r->status ?? 'Entered');
            $this->approvalStatus         = $r->approval_status instanceof \BackedEnum
                ? $r->approval_status->value : ($r->approval_status ?? 'pending');
            
            // Open generate modal for editing
            $this->showGenerateModal = true;
        } catch (\Exception $e) {
            \Log::error('Error loading payslip entry for edit: ' . $e->getMessage());
            session()->flash('error', 'Failed to load payslip entry: ' . $e->getMessage());
        }
    }

    public function openView(string $id): void
    {
        try {
            \Log::info('openView called with ID: ' . $id);
            
            $this->viewRecord = PayslipEntry::with(['payrollMonth', 'payrollEntry.employee', 'employee'])->findOrFail($id);
            
            \Log::info('PayslipEntry loaded for view: ' . $id);
            \Log::info('viewRecord code: ' . ($this->viewRecord->code ?? 'null'));
            \Log::info('viewRecord employee: ' . ($this->viewRecord->employee ? 'exists' : 'null'));
            \Log::info('viewRecord payrollEntry: ' . ($this->viewRecord->payrollEntry ? 'exists' : 'null'));
            \Log::info('viewRecord payrollMonth: ' . ($this->viewRecord->payrollMonth ? 'exists' : 'null'));
            
            if ($this->viewRecord->employee) {
                \Log::info('Employee name: ' . ($this->viewRecord->employee->first_name ?? '') . ' ' . ($this->viewRecord->employee->last_name ?? ''));
            }
            
            if ($this->viewRecord->payrollEntry) {
                \Log::info('PayrollEntry code: ' . ($this->viewRecord->payrollEntry->code ?? 'null'));
                if ($this->viewRecord->payrollEntry->employee) {
                    \Log::info('PayrollEntry employee name: ' . ($this->viewRecord->payrollEntry->employee->first_name ?? '') . ' ' . ($this->viewRecord->payrollEntry->employee->last_name ?? ''));
                }
            }
            
            $this->showView   = true;
            
        } catch (\Exception $e) {
            \Log::error('Error loading payslip entry for view: ' . $e->getMessage());
            \Log::error('Exception trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Failed to load payslip entry: ' . $e->getMessage());
        }
    }

    public function closeView(): void
    {
        $this->showView   = false;
        $this->viewRecord = null;
    }

    public function openGenerateModal(): void
    {
        $this->showGenerateModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(string $id): void
    {
        $this->deletingId = $id;
        $this->showDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->showDelete = false;
    }
    
    // ── Generate Payslip Functions ───────────────────────────
    
    public function closeGenerateModal(): void
    {
        $this->showGenerateModal = false;
        $this->generatePayrollEntryId = '';
        $this->generateEditingId = null;
    }
    
    public function generatePayslip(): void
    {
        try {
            $this->dispatch('console-log', message: 'Starting payslip generation process...');
            
            // Enhanced validation with specific error messages
            if (!$this->generatePayrollEntryId) {
                session()->flash('error', 'Please select a payroll entry from the dropdown list.');
                $this->dispatch('console-log', message: 'Payslip generation failed: No payroll entry selected');
                return;
            }
            
            $this->dispatch('console-log', message: 'Finding payroll entry with ID: ' . $this->generatePayrollEntryId);
            
            $payrollEntry = PayrollEntry::find($this->generatePayrollEntryId);
            if (!$payrollEntry) {
                session()->flash('error', 'Selected payroll entry not found. Please refresh and try again.');
                $this->dispatch('console-log', message: 'Payslip generation failed: Payroll entry ID ' . $this->generatePayrollEntryId . ' not found');
                return;
            }
            
            $this->dispatch('console-log', message: 'Found payroll entry: ' . $payrollEntry->code . ' with amount: ' . $payrollEntry->total_amount);
            
            // Validate payroll entry data
            if (!$payrollEntry->total_amount || $payrollEntry->total_amount <= 0) {
                session()->flash('error', 'Selected payroll entry has invalid total amount (' . $payrollEntry->total_amount . '). Please check the payroll entry.');
                $this->dispatch('console-log', message: 'Payslip generation failed: Invalid total amount in payroll entry');
                return;
            }
            
            // Check if payslip already exists
            $existingPayslip = PayslipEntry::where('payroll_entry_id', $payrollEntry->id)->first();
            
            // If we're editing, use the existing payslip
            if ($this->generateEditingId) {
                $existingPayslip = PayslipEntry::find($this->generateEditingId);
                if (!$existingPayslip) {
                    session()->flash('error', 'Payslip to edit not found. Please refresh and try again.');
                    $this->dispatch('console-log', message: 'Edit failed: Payslip ID ' . $this->generateEditingId . ' not found');
                    return;
                }
            } elseif ($existingPayslip) {
                session()->flash('error', 'Payslip already exists for payroll entry ' . $payrollEntry->code . '. Payslip code: ' . $existingPayslip->code . '. Use Edit button to modify.');
                $this->dispatch('console-log', message: 'Payslip generation failed: Payslip already exists for payroll entry ' . $payrollEntry->code);
                return;
            }
            
            $this->dispatch('console-log', message: 'Validation passed, starting database transaction...');
            
            DB::beginTransaction();
            try {
                $this->dispatch('console-log', message: 'Creating payslip data array...');
                
                $data = [
                    'code' => $this->generateEditingId ? ($existingPayslip->code ?? 'PS-' . str_pad($payrollEntry->id, 5, '0', STR_PAD_LEFT)) : 'PS-' . str_pad($payrollEntry->id, 5, '0', STR_PAD_LEFT),
                    'payroll_entry_id' => $payrollEntry->id,
                    'gross_pay' => $this->grossPay ?: 0,
                    'taxable_income' => $this->taxableIncome ?: 0,
                    'paye' => $this->paye ?: 0,
                    'pension' => $this->pension ?: 0,
                    'maternity' => $this->maternity ?: 0,
                    'cbhi' => $this->cbhi ?: 0,
                    'employer_contribution' => $this->employerContribution ?: 0,
                    'net_pay' => $this->netPay ?: 0,
                    
                    // Additional deductions and benefits from form
                    'loan_deduction' => $this->loanDeduction ?: 0,
                    'advance_deduction' => $this->advanceDeduction ?: 0,
                    'other_deductions' => $this->otherDeductions ?: 0,
                    'housing_allowance' => $this->housingAllowance ?: 0,
                    'transport_allowance' => $this->transportAllowance ?: 0,
                    'meal_allowance' => $this->mealAllowance ?: 0,
                    'other_benefits' => $this->otherBenefits ?: 0,
                    
                    'tax_bracket_used' => $this->taxBracketUsed ?: '',
                    'effective_tax_rate' => $this->effectiveTaxRate ?: 0,
                    'status' => $this->status ?: 'Entered',
                    'approval_status' => $this->approvalStatus ?: 'pending',
                ];
                
                if ($this->generateEditingId) {
                    // Update existing payslip
                    $this->dispatch('console-log', message: 'Updating payslip record with code: ' . $data['code']);
                    $payslip = PayslipEntry::findOrFail($this->generateEditingId);
                    $payslip->update($data);
                    $this->dispatch('console-log', message: 'Payslip record updated with ID: ' . $payslip->id);
                    $msg = 'Payslip entry updated successfully.';
                } else {
                    // Create new payslip
                    $this->dispatch('console-log', message: 'Creating payslip record with code: ' . $data['code']);
                    $payslip = PayslipEntry::create($data);
                    $this->dispatch('console-log', message: 'Payslip record created with ID: ' . $payslip->id);
                    $msg = 'Payslip entry created successfully.';
                }
                
                // Trigger recalculation to compute taxes
                $this->dispatch('console-log', message: 'Setting up for recalculation...');
                $this->payrollEntryId = $payrollEntry->id;
                $this->grossPay = (string) $payrollEntry->total_amount;
                $this->recalculate();
                
                $this->dispatch('console-log', message: 'Recalculation completed, updating payslip...');
                
                // Update payslip with calculated values
                $updateData = [
                    'taxable_income' => $this->taxableIncome,
                    'paye' => $this->paye,
                    'pension' => $this->pension,
                    'maternity' => $this->maternity,
                    'cbhi' => $this->cbhi ?: 0,
                    'employer_contribution' => $this->employerContribution ?: 0,
                    'loan_deduction' => $this->loanDeduction ?: 0,
                    'advance_deduction' => $this->advanceDeduction ?: 0,
                    'other_deductions' => $this->otherDeductions ?: 0,
                    'housing_allowance' => $this->housingAllowance ?: 0,
                    'transport_allowance' => $this->transportAllowance ?: 0,
                    'meal_allowance' => $this->mealAllowance ?: 0,
                    'other_benefits' => $this->otherBenefits ?: 0,
                    'net_pay' => $this->netPay,
                    'tax_bracket_used' => $this->taxBracketUsed ?: '',
                    'effective_tax_rate' => $this->effectiveTaxRate ?: 0,
                ];
                
                $this->dispatch('console-log', message: 'Update data prepared - checking values...');
                foreach ($updateData as $key => $value) {
                    $this->dispatch('console-log', message: "  {$key}: '{$value}' (type: " . gettype($value) . ")");
                }
                
                $payslip->update($updateData);
                
                $this->dispatch('console-log', message: 'Payslip updated with calculated values');
                
                DB::commit();
                $this->dispatch('console-log', message: 'Database transaction committed successfully');
                
                $this->closeGenerateModal();
                session()->flash('success', $msg);
                $this->dispatch('console-log', message: 'Payslip operation completed successfully');
                
            } catch (\Exception $e) {
                DB::rollBack();
                $this->dispatch('console-log', message: 'Database transaction failed: ' . $e->getMessage());
                session()->flash('error', 'Failed to generate payslip: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
            $this->dispatch('console-log', message: 'GENERATE PAYSLIP ERROR: ' . $errorMessage);
            $this->dispatch('console-log', message: 'ERROR TRACE: ' . $e->getTraceAsString());
        }
    }

    public function deleteRecord(): void
    {
        try {
            PayslipEntry::findOrFail($this->deletingId)->delete();
            $this->cancelDelete();
            session()->flash('success', 'Payslip entry deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Approve / Reject shortcuts ──────────────────────────
    public function approve(string $id): void
    {
        try {
            PayslipEntry::findOrFail($id)->update(['approval_status' => 'approved']);
            session()->flash('success', 'Payslip entry approved.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject(string $id): void
    {
        try {
            PayslipEntry::findOrFail($id)->update(['approval_status' => 'rejected']);
            session()->flash('success', 'Payslip entry rejected.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reject: ' . $e->getMessage());
        }
    }

    public function save(): void
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enhanced validation error handling with specific field messages
            $errors = $e->errors();
            $errorMessages = [];
            
            foreach ($errors as $field => $messages) {
                $fieldName = $this->getFieldDisplayName($field);
                $errorMessages[] = $fieldName . ': ' . implode(', ', $messages);
            }
            
            \Log::error('PayslipEntry validation failed', [
                'errors' => $errors,
                'data' => [
                    'code' => $this->code,
                    'payrollEntryId' => $this->payrollEntryId,
                    'grossPay' => $this->grossPay,
                    'taxableIncome' => $this->taxableIncome,
                    'paye' => $this->paye,
                    'pension' => $this->pension,
                    'maternity' => $this->maternity,
                    'cbhi' => $this->cbhi,
                    'employerContribution' => $this->employerContribution,
                    'netPay' => $this->netPay,
                    'status' => $this->status,
                    'approvalStatus' => $this->approvalStatus,
                ]
            ]);
            
            $this->dispatch('console-log', message: 'Payslip validation failed: ' . implode('; ', $errorMessages));
            session()->flash('error', 'Validation failed: ' . implode('; ', $errorMessages));
            return;
        }

        DB::beginTransaction();
        try {
            // Build data array
            $data = [
                'code'                 => strtoupper(trim($this->code)),
                'payroll_entry_id'     => $this->payrollEntryId,
                'gross_pay'            => $this->grossPay,
                'taxable_income'       => $this->taxableIncome,
                'paye'                 => $this->paye,
                'pension'              => $this->pension,
                'maternity'            => $this->maternity,
                'cbhi'                 => $this->cbhi,
                'employer_contribution'=> $this->employerContribution,
                'net_pay'              => $this->netPay,
                
                // Additional deductions and benefits
                'loan_deduction'       => $this->loanDeduction ?: 0,
                'advance_deduction'    => $this->advanceDeduction ?: 0,
                'other_deductions'     => $this->otherDeductions ?: 0,
                'housing_allowance'    => $this->housingAllowance ?: 0,
                'transport_allowance'  => $this->transportAllowance ?: 0,
                'meal_allowance'       => $this->mealAllowance ?: 0,
                'other_benefits'       => $this->otherBenefits ?: 0,
                
                'tax_bracket_used'     => trim($this->taxBracketUsed) ?: null,
                'effective_tax_rate'   => $this->effectiveTaxRate ?: 0,
                'status'               => $this->status,
                'approval_status'      => $this->approvalStatus,
            ];

            if ($this->editingId) {
                PayslipEntry::findOrFail($this->editingId)->update($data);
                $msg = 'Payslip entry updated successfully.';
            } else {
                PayslipEntry::create($data);
                $msg = 'Payslip entry created successfully.';
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('PayslipEntry save failed', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? []
            ]);
            
            $this->dispatch('console-log', message: 'Payslip save failed: ' . $e->getMessage());
            
            // Enhanced error messages for common issues
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'duplicate') !== false) {
                session()->flash('error', 'Duplicate payslip code detected. Please use a unique code.');
            } elseif (strpos($errorMessage, 'foreign key') !== false) {
                session()->flash('error', 'Invalid payroll entry selected. Please check the payroll entry exists.');
            } elseif (strpos($errorMessage, 'database') !== false) {
                session()->flash('error', 'Database error occurred. Please try again or contact support.');
            } else {
                session()->flash('error', 'Save failed: ' . $errorMessage);
            }
        }
    }

    // ── Reset ───────────────────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId             = null;
        $this->code                  = '';
        $this->payrollEntryId        = '';
        $this->grossPay              = '';
        $this->taxableIncome         = '';
        $this->paye                  = '';
        $this->pension               = '';
        $this->maternity             = '';
        $this->cbhi                  = '';
        $this->employerContribution  = '';
        $this->netPay                = '';
        $this->taxBracketUsed        = '';
        $this->effectiveTaxRate      = '';
        $this->status                = 'Entered';
        $this->approvalStatus        = 'pending';
        
        // Reset new fields
        $this->loanDeduction         = '';
        $this->advanceDeduction      = '';
        $this->otherDeductions       = '';
        $this->housingAllowance      = '';
        $this->transportAllowance    = '';
        $this->mealAllowance         = '';
        $this->otherBenefits         = '';
        $this->overrideAutoTax       = false;
        $this->customTaxRate         = '';
        $this->manualTaxAmount       = '';
        $this->adjustedGrossPay      = '';
        $this->totalDeductions       = '';
        $this->pensionRate           = '3.0';
        $this->maternityRate         = '0.3';
        
        // Reset search and filters
        $this->search                = '';
        $this->filterMonth           = '';
        
        $this->resetValidation();
    }

    // Helper method to get field display names for error messages
    private function getFieldDisplayName(string $field): string
    {
        $fieldNames = [
            'code' => 'Payslip Code',
            'payrollEntryId' => 'Payroll Entry',
            'grossPay' => 'Gross Pay',
            'taxableIncome' => 'Taxable Income',
            'paye' => 'PAYE Tax',
            'pension' => 'Pension',
            'maternity' => 'Maternity',
            'cbhi' => 'CBHI',
            'employerContribution' => 'Employer Contribution',
            'netPay' => 'Net Pay',
            'status' => 'Status',
            'approvalStatus' => 'Approval Status',
            'loanDeduction' => 'Loan Deduction',
            'advanceDeduction' => 'Advance Deduction',
            'otherDeductions' => 'Other Deductions',
            'housingAllowance' => 'Housing Allowance',
            'transportAllowance' => 'Transport Allowance',
            'mealAllowance' => 'Meal Allowance',
            'otherBenefits' => 'Other Benefits',
            'customTaxRate' => 'Custom Tax Rate',
            'manualTaxAmount' => 'Manual Tax Amount',
        ];
        
        return $fieldNames[$field] ?? $field;
    }

    // ── Manual Refresh Method ─────────────────────────────
    public function refreshPayrollData(): void
    {
        \Log::info('Manual refresh called');
        if ($this->generatePayrollEntryId) {
            $entry = \App\Models\PayrollEntry::find($this->generatePayrollEntryId);
            if ($entry) {
                \Log::info('Manual refresh: Setting gross pay to: ' . $entry->total_amount);
                $this->grossPay = (string)$entry->total_amount;
                $this->recalculate();
                \Log::info('Manual refresh: Net pay is now: ' . $this->netPay);
            }
        }
    }

    // ── Invoke for routing ─────────────────────────────────────
    public function __invoke()
    {
        return $this->render();
    }

    // ── Render ──────────────────────────────────────────────
    public function render()
    {
        $records = PayslipEntry::query()
            ->with(['payrollMonth', 'payrollEntry.employee'])
            ->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('code', 'like', "%{$this->search}%")
                   ->orWhere('tax_bracket_used', 'like', "%{$this->search}%")
                   ->orWhereHas('payrollMonth', fn($q3) =>
                       $q3->where('name', 'like', "%{$this->search}%")
                          ->orWhere('code', 'like', "%{$this->search}%")
                   );
            }))
            ->when($this->filterStatus,       fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterApproval,     fn($q) => $q->where('approval_status', $this->filterApproval))
            ->when($this->filterPayrollMonth, fn($q) => $q->where('payroll_entry_id', $this->filterPayrollMonth))
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $totalCount    = PayslipEntry::count();
        $approvedCount = PayslipEntry::where('approval_status', 'approved')->count();
        $pendingCount  = PayslipEntry::where('approval_status', 'pending')->count();
        $activeCount   = PayslipEntry::where('status', 'active')->count();
        $paidCount     = PayslipEntry::where('status', 'paid')->count();
        $totalPayroll  = PayslipEntry::sum('gross_pay');

        $payrollEntries = \App\Models\PayrollEntry::with(['employee', 'payrollMonth'])
            ->orderBy('id', 'desc')
            ->get();

        $payrollMonths = \App\Models\PayrollMonth::orderBy('start_date', 'desc')->get(['id', 'code', 'name']);

        $employees = \App\Models\Employee::orderBy('first_name')->get(['id', 'first_name', 'last_name']);

        return view('livewire.payroll.payslip-entry', [
            'records'          => $records,
            'totalCount'       => $totalCount,
            'approvedCount'    => $approvedCount,
            'pendingCount'     => $pendingCount,
            'activeCount'      => $activeCount,
            'paidCount'        => $paidCount,
            'totalPayroll'     => $totalPayroll,
            'payrollEntries'   => $payrollEntries,
            'payrollMonths'    => $payrollMonths,
            'employees'        => $employees,
            'statuses'         => self::STATUSES,
            'approvalStatuses' => self::APPROVAL_STATUSES,
            'showModal'        => $this->showModal,
            'showView'         => $this->showView,
            'showDelete'       => $this->showDelete,
        ])->layout('components.layouts.app');
    }
    
    // ── Fetch Gross Pay from Payroll Entry ──────────────────
    public function updatedPayrollEntryId($value): void
    {
        \Log::info('updatedPayrollEntryId called with value: ' . $value);
        
        if ($value) {
            $entry = \App\Models\PayrollEntry::find($value);
            if ($entry) {
                \Log::info('Found payroll entry: ' . $entry->id . ' with total_amount: ' . $entry->total_amount);
                
                // Clear all form fields and set new values
                $this->grossPay = (string)$entry->total_amount;
                $this->taxableIncome = '';
                $this->paye = '';
                $this->pension = '';
                $this->maternity = '';
                $this->cbhi = '';
                $this->employerContribution = '';
                $this->loanDeduction = '';
                $this->advanceDeduction = '';
                $this->otherDeductions = '';
                $this->housingAllowance = '';
                $this->transportAllowance = '';
                $this->mealAllowance = '';
                $this->otherBenefits = '';
                $this->overrideAutoTax = false;
                $this->customTaxRate = '';
                $this->manualTaxAmount = '';
                $this->taxBracketUsed = '';
                $this->effectiveTaxRate = '';
                $this->netPay = '';
                
                \Log::info('About to call recalculate, grossPay set to: ' . $this->grossPay);
                $this->recalculate();
                \Log::info('After recalculate, netPay is: ' . $this->netPay);
            } else {
                \Log::info('No payroll entry found for ID: ' . $value);
            }
        } else {
            \Log::info('Payroll entry ID cleared, clearing all fields');
            // Clear all fields when no payroll entry is selected
            $this->grossPay = '';
            $this->taxableIncome = '';
            $this->paye = '';
            $this->pension = '';
            $this->maternity = '';
            $this->cbhi = '';
            $this->employerContribution = '';
            $this->loanDeduction = '';
            $this->advanceDeduction = '';
            $this->otherDeductions = '';
            $this->housingAllowance = '';
            $this->transportAllowance = '';
            $this->mealAllowance = '';
            $this->otherBenefits = '';
            $this->overrideAutoTax = false;
            $this->customTaxRate = '';
            $this->manualTaxAmount = '';
            $this->taxBracketUsed = '';
            $this->effectiveTaxRate = '';
            $this->netPay = '';
        }
    }
}
