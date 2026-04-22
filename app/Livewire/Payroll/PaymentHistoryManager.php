<?php

namespace App\Livewire\Payroll;

use App\Models\PaymentHistory;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Payment History')]
class PaymentHistoryManager extends Component
{
    use WithPagination;

    // ── List filters ────────────────────────────────────────
    public string $search          = '';
    public string $filterStatus    = '';
    public string $filterApproval  = '';
    public string $filterMethod    = '';
    public int    $perPage         = 15;

    // ── Modal flags ─────────────────────────────────────────
    public bool  $showModal  = false;
    public bool  $showView   = false;
    public bool  $showDelete = false;
    public ?string $editingId  = null;
    public ?string $deletingId = null;
    public ?PaymentHistory $viewRecord = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code                = '';
    public string $payrollEntryId      = '';
    public string $payslipEntryId      = '';
    public string $employeeId          = '';
    public string $paymentMethod       = '';
    public string $transactionReference= '';
    public string $amountPaid          = '';
    public string $currency            = 'RWF';
    public string $paymentDate         = '';
    public string $bankName            = '';
    public string $accountNumber       = '';
    public string $chequeNumber        = '';
    public string $notes               = '';
    public string $status              = 'pending';
    public string $approvalStatus      = 'pending';

    // ── Constants ────────────────────────────────────────────
    const PAYMENT_METHODS = [
        'bank_transfer' => 'Bank Transfer',
        'cash'          => 'Cash',
        'cheque'        => 'Cheque',
        'mobile_money'  => 'Mobile Money',
        'other'         => 'Other',
    ];

    const STATUSES = [
        'pending'    => 'Pending',
        'processing' => 'Processing',
        'completed'  => 'Completed',
        'failed'     => 'Failed',
        'cancelled'  => 'Cancelled',
        'refunded'   => 'Refunded',
    ];

    const APPROVAL_STATUSES = [
        'initiated'   => 'Initiated',
        'pending'     => 'Pending',
        'under_review' => 'Under Review',
        'approved'    => 'Approved',
        'rejected'    => 'Rejected',
        'cancelled'   => 'Cancelled',
    ];

    const CURRENCIES = ['RWF', 'USD', 'EUR', 'GBP', 'KES', 'UGX', 'TZS'];

    // ── Validation ───────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'code'                 => ['required', 'string', 'max:50',
                                       Rule::unique('payment_histories', 'code')->ignore($this->editingId)],
            'employeeId'           => ['required', 'string', 'exists:employees,id'],
            'payrollEntryId'       => ['nullable', 'exists:payroll_entries,id'],
            'payslipEntryId'       => ['nullable', 'exists:payslip_entries,id'],
            'paymentMethod'        => ['required', Rule::in(array_keys(self::PAYMENT_METHODS))],
            'transactionReference' => ['nullable', 'string', 'max:150'],
            'amountPaid'           => ['required', 'numeric', 'min:0'],
            'currency'             => ['required', 'string', 'max:10'],
            'paymentDate'          => ['required', 'date'],
            'bankName'             => ['nullable', 'string', 'max:150'],
            'accountNumber'        => ['nullable', 'string', 'max:100'],
            'chequeNumber'         => ['nullable', 'string', 'max:100'],
            'notes'                => ['nullable', 'string', 'max:1000'],
            'status'               => ['required', Rule::in(array_keys(self::STATUSES))],
            'approvalStatus'       => ['required', Rule::in(array_keys(self::APPROVAL_STATUSES))],
        ];
    }

    protected array $messages = [
        'code.required'       => 'Payment code is required.',
        'code.unique'         => 'This code already exists.',
        'employeeId.required' => 'Employee is required.',
        'employeeId.exists'   => 'Selected employee does not exist.',
        'paymentMethod.required' => 'Payment method is required.',
        'amountPaid.required' => 'Amount paid is required.',
        'amountPaid.numeric'  => 'Amount must be a valid number.',
        'paymentDate.required'=> 'Payment date is required.',
    ];

    // ── Lifecycle ────────────────────────────────────────────
    public function mount(): void {}

    public function updatedSearch(): void         { $this->resetPage(); }
    public function updatedFilterStatus(): void   { $this->resetPage(); }
    public function updatedFilterApproval(): void { $this->resetPage(); }
    public function updatedFilterMethod(): void   { $this->resetPage(); }

    // ── Code generator ───────────────────────────────────────
    private function generateCode(): string
    {
        $last = PaymentHistory::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) preg_replace('/\D/', '', $last->code)) + 1 : 1;
        return 'PAY-' . str_pad($n, 5, '0', STR_PAD_LEFT);
    }

    // ── CRUD openers ─────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code        = $this->generateCode();
        $this->paymentDate = now()->format('Y-m-d');
        $this->showModal   = true;
    }

    public function openEdit(string $id): void
    {
        $r = PaymentHistory::findOrFail($id);
        $this->editingId           = $id;
        $this->code                = $r->code                 ?? '';
        $this->payrollEntryId      = (string)($r->payroll_entry_id  ?? '');
        $this->payslipEntryId      = (string)($r->payslip_entry_id  ?? '');
        $this->employeeId          = (string)($r->employee_id        ?? '');
        $this->paymentMethod       = $this->enumVal($r->payment_method)       ?: '';
        $this->transactionReference= $r->transaction_reference ?? '';
        $this->amountPaid          = (string)($r->amount_paid         ?? '');
        $this->currency            = $r->currency              ?? 'RWF';
        $this->paymentDate         = $r->payment_date
            ? Carbon::parse($r->payment_date)->format('Y-m-d') : '';
        $this->bankName            = $r->bank_name             ?? '';
        $this->accountNumber       = $r->account_number        ?? '';
        $this->chequeNumber        = $r->cheque_number         ?? '';
        $this->notes               = $r->notes                 ?? '';
        $this->status              = $this->enumVal($r->status)              ?: 'pending';
        $this->approvalStatus      = $this->enumVal($r->approval_status)     ?: 'pending';
        $this->showModal           = true;
    }

    public function openView(string $id): void
    {
        $this->viewRecord = PaymentHistory::with(['employee', 'payrollEntry', 'payslipEntry'])
            ->findOrFail($id);
        $this->showView = true;
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
            PaymentHistory::findOrFail($this->deletingId)->delete();
            $this->cancelDelete();
            session()->flash('success', 'Payment record deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Approve / Reject ─────────────────────────────────────
    public function approve(string $id): void
    {
        try {
            PaymentHistory::findOrFail($id)->update(['approval_status' => 'approved']);
            session()->flash('success', 'Payment approved.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject(string $id): void
    {
        try {
            PaymentHistory::findOrFail($id)->update(['approval_status' => 'rejected']);
            session()->flash('success', 'Payment rejected.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ── Save ─────────────────────────────────────────────────
    public function save(): void
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('PaymentHistory validation failed', [
                'errors' => $e->errors(),
                'data' => [
                    'code' => $this->code,
                    'employeeId' => $this->employeeId,
                    'paymentMethod' => $this->paymentMethod,
                    'amountPaid' => $this->amountPaid,
                    'paymentDate' => $this->paymentDate,
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
                'payroll_entry_id'      => $this->payrollEntryId  ?: null,
                'payslip_entry_id'      => $this->payslipEntryId  ?: null,
                'employee_id'           => $this->employeeId,
                'payment_method'        => $this->paymentMethod,
                'transaction_reference' => trim($this->transactionReference) ?: null,
                'amount_paid'           => (float)$this->amountPaid,
                'currency'              => $this->currency,
                'payment_date'          => $this->paymentDate,
                'bank_name'             => trim($this->bankName)     ?: null,
                'account_number'        => trim($this->accountNumber) ?: null,
                'cheque_number'         => trim($this->chequeNumber)  ?: null,
                'notes'                 => trim($this->notes)         ?: null,
                'status'                => $this->status,
                'approval_status'       => $this->approvalStatus,
            ];

            if ($this->editingId) {
                PaymentHistory::findOrFail($this->editingId)->update($data);
                $msg = 'Payment record updated successfully.';
            } else {
                PaymentHistory::create($data);
                $msg = 'Payment record created successfully.';
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Save failed: ' . $e->getMessage());
        }
    }

    // ── Helpers ──────────────────────────────────────────────
    private function enumVal(mixed $v): string
    {
        return $v instanceof \BackedEnum ? $v->value : (string)($v ?? '');
    }

    private function resetForm(): void
    {
        $this->editingId            = null;
        $this->code                 = '';
        $this->payrollEntryId       = '';
        $this->payslipEntryId       = '';
        $this->employeeId           = '';
        $this->paymentMethod        = '';
        $this->transactionReference = '';
        $this->amountPaid           = '';
        $this->currency             = 'RWF';
        $this->paymentDate          = '';
        $this->bankName             = '';
        $this->accountNumber        = '';
        $this->chequeNumber         = '';
        $this->notes                = '';
        $this->status               = 'pending';
        $this->approvalStatus       = 'pending';
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
        $records = PaymentHistory::query()
            ->with(['employee', 'payrollEntry', 'payslipEntry'])
            ->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('code', 'like', "%{$this->search}%")
                   ->orWhere('transaction_reference', 'like', "%{$this->search}%")
                   ->orWhere('bank_name', 'like', "%{$this->search}%")
                   ->orWhere('account_number', 'like', "%{$this->search}%")
                   ->orWhereHas('employee', fn($eq) =>
                       $eq->where('first_name', 'like', "%{$this->search}%")
                          ->orWhere('last_name',  'like', "%{$this->search}%")
                   );
            }))
            ->when($this->filterStatus,   fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterApproval, fn($q) => $q->where('approval_status', $this->filterApproval))
            ->when($this->filterMethod,   fn($q) => $q->where('payment_method', $this->filterMethod))
            ->orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $totalCount     = PaymentHistory::count();
        $completedCount = PaymentHistory::where('status', 'completed')->count();
        $pendingCount   = PaymentHistory::where('status', 'pending')->count();
        $totalPaid      = PaymentHistory::where('status', 'completed')->sum('amount_paid');

        // Dropdown data
        $employees = [];
        try {
            $employees = \App\Models\Employee::orderBy('first_name')
                ->get(['id','first_name','last_name'])->toArray();
        } catch (\Exception) {}

        $payrollEntries = [];
        try {
            $payrollEntries = \App\Models\PayrollEntry::with('employee')
                ->orderBy('id','desc')->get()->toArray();
        } catch (\Exception) {}

        $payslipEntries = [];
        try {
            $payslipEntries = \App\Models\PayslipEntry::with('payrollEntry.employee')
                ->orderBy('id','desc')->get()->toArray();
        } catch (\Exception) {}

        return view('livewire.payroll.payment-history', [
            'records'         => $records,
            'totalCount'      => $totalCount,
            'completedCount'  => $completedCount,
            'pendingCount'    => $pendingCount,
            'totalPaid'       => $totalPaid,
            'employees'       => $employees,
            'payrollEntries'  => $payrollEntries,
            'payslipEntries'  => $payslipEntries,
            'paymentMethods'  => self::PAYMENT_METHODS,
            'statuses'        => self::STATUSES,
            'approvalStatuses'=> self::APPROVAL_STATUSES,
            'currencies'      => self::CURRENCIES,
            'showModal'       => $this->showModal,
            'showView'        => $this->showView,
            'showDelete'      => $this->showDelete,
        ])->layout('components.layouts.app');
    }
}
