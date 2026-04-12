<?php

namespace App\Livewire\Payroll;

use App\Models\PayslipEntry;
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
    public string $status              = 'active';
    public string $approvalStatus      = 'pending';

    const STATUSES = [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
        'cancelled' => 'Cancelled',
    ];

    const APPROVAL_STATUSES = [
        'initiated'  => 'Initiated',
        'pending'    => 'Pending',
        'approved'   => 'Approved',
        'rejected'   => 'Rejected',
        'cancelled'  => 'Cancelled',
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
            'netPay'               => ['required', 'numeric', 'min:0'],
            'taxBracketUsed'       => ['nullable', 'string', 'max:100'],
            'effectiveTaxRate'     => ['required', 'numeric', 'min:0', 'max:100'],
            'status'               => ['required', Rule::in(array_keys(self::STATUSES))],
            'approvalStatus'       => ['required', Rule::in(array_keys(self::APPROVAL_STATUSES))],
        ];
    }

    protected array $messages = [
        'code.required'           => 'Entry code is required.',
        'code.unique'             => 'This code is already taken.',
        'payrollEntryId.required' => 'Please select a payroll month.',
        'payrollEntryId.exists'   => 'Selected payroll month does not exist.',
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

    // ── Auto-compute net pay when deductions change ─────────
    public function updatedGrossPay(): void            { $this->recalculate(); }
    public function updatedPaye(): void                { $this->recalculate(); }
    public function updatedPension(): void             { $this->recalculate(); }
    public function updatedMaternity(): void           { $this->recalculate(); }
    public function updatedCbhi(): void                { $this->recalculate(); }
    public function updatedTaxableIncome(): void       { $this->recalculate(); }

    private function recalculate(): void
    {
        $gross    = (float) ($this->grossPay    ?: 0);
        
        // 1. Calculate RSSB Contributions (Employee parts)
        $pension   = round($gross * 0.03, 2);
        $maternity = round($gross * 0.003, 2);
        
        // 2. Taxable Income
        $taxable   = max(0, $gross - $pension - $maternity);
        
        // 3. Calculate PAYE (Tax)
        $paye      = $this->calculatePaye($taxable);
        
        // 4. Update component state
        $this->pension        = (string)$pension;
        $this->maternity      = (string)$maternity;
        $this->taxableIncome  = (string)$taxable;
        $this->paye           = (string)$paye;
        $this->cbhi           = $this->cbhi ?: '0'; // Default CBHI to 0 if not set
        
        $cbhiVal = (float)$this->cbhi;
        $this->netPay = (string) max(0, $gross - $paye - $pension - $maternity - $cbhiVal);

        if ($taxable > 0) {
            $this->effectiveTaxRate = (string) round(($paye / $taxable) * 100, 2);
        } else {
            $this->effectiveTaxRate = '0';
        }
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
        $r = PayslipEntry::findOrFail($id);
        $this->editingId             = $id;
        $this->code                  = $r->code ?? '';
        $this->payrollEntryId        = (string) ($r->payroll_entry_id ?? '');
        $this->grossPay              = (string) ($r->gross_pay ?? '');
        $this->taxableIncome         = (string) ($r->taxable_income ?? '');
        $this->paye                  = (string) ($r->paye ?? '');
        $this->pension               = (string) ($r->pension ?? '');
        $this->maternity             = (string) ($r->maternity ?? '');
        $this->cbhi                  = (string) ($r->cbhi ?? '');
        $this->employerContribution  = (string) ($r->employer_contribution ?? '');
        $this->netPay                = (string) ($r->net_pay ?? '');
        $this->taxBracketUsed        = $r->tax_bracket_used ?? '';
        $this->effectiveTaxRate      = (string) ($r->effective_tax_rate ?? '');
        $this->status                = $r->status instanceof \BackedEnum
            ? $r->status->value : ($r->status ?? 'active');
        $this->approvalStatus        = $r->approval_status instanceof \BackedEnum
            ? $r->approval_status->value : ($r->approval_status ?? 'draft');
        $this->showModal             = true;
    }

    public function openView(string $id): void
    {
        $this->viewRecord = PayslipEntry::with('payrollMonth')->findOrFail($id);
        $this->showView   = true;
    }

    public function closeView(): void
    {
        $this->showView   = false;
        $this->viewRecord = null;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->showDelete = false;
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
            // Log validation errors for debugging
            \Log::error('PayslipEntry validation failed', [
                'errors' => $e->errors(),
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
                    'effectiveTaxRate' => $this->effectiveTaxRate,
                    'status' => $this->status,
                    'approvalStatus' => $this->approvalStatus,
                ]
            ]);
            session()->flash('error', 'Validation failed. Please check all required fields.');
            return;
        }

        DB::beginTransaction();
        try {
            $data = [
                'code'                  => strtoupper(trim($this->code)),
                'payroll_entry_id'      => $this->payrollEntryId,
                'gross_pay'             => $this->grossPay,
                'taxable_income'        => $this->taxableIncome,
                'paye'                  => $this->paye,
                'pension'               => $this->pension,
                'maternity'             => $this->maternity,
                'cbhi'                  => (float)($this->cbhi ?: 0),
                'employer_contribution' => (float)($this->employerContribution ?: 0),
                'net_pay'               => $this->netPay,
                'tax_bracket_used'      => trim($this->taxBracketUsed) ?: null,
                'effective_tax_rate'    => $this->effectiveTaxRate,
                'status'                => $this->status,
                'approval_status'       => $this->approvalStatus,
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
            session()->flash('error', 'Save failed: ' . $e->getMessage());
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
        $this->status                = 'active';
        $this->approvalStatus        = 'pending';
        $this->resetValidation();
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
            ->with('payrollMonth')
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
        if ($value) {
            $entry = \App\Models\PayrollEntry::find($value);
            if ($entry) {
                $this->grossPay = (string)$entry->total_amount;
                $this->recalculate();
            }
        }
    }
}
