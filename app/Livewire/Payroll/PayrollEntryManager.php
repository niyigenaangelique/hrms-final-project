<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollEntry;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Payroll Entries')]
class PayrollEntryManager extends Component
{
    use WithPagination;

    // ── List filters ────────────────────────────────────────
    public string $search = '';
    public string $filterStatus = '';
    public string $filterApproval = '';
    public string $filterMonth = '';
    public int $perPage = 15;

    // ── Modal flags ─────────────────────────────────────────
    public bool $showModal = false;
    public bool $showView = false;
    public bool $showDelete = false;
    public ?string $editingId = null;
    public ?string $deletingId = null;
    public ?PayrollEntry $viewRecord = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code = '';
    public string $payrollMonthId = '';
    public string $employeeId = '';
    public string $dailyRate = '';
    public string $workDays = '';
    public string $workDaysPay = '';
    public string $overtimeHourRate = '';
    public string $overtimeHoursWorked = '';
    public string $overtimeTotalAmount = '';
    public string $totalAmount = '';
    public string $status = 'Entered';
    public string $approvalStatus = 'pending';

    // ── Constants ────────────────────────────────────────────
    const STATUSES = [
        'Entered' => 'Entered',
        'Approved' => 'Approved',
        'Posted' => 'Posted',
        'Cancelled' => 'Cancelled',
        'Rejected' => 'Rejected',
    ];

    const APPROVAL_STATUSES = [
        'initiated' => 'Initiated',
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'cancelled' => 'Cancelled',
    ];

    // ── Validation ───────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('payroll_entries', 'code')->ignore($this->editingId)
            ],
            'payrollMonthId' => ['required', 'string', 'exists:payroll_months,id'],
            'employeeId' => ['required', 'string', 'exists:employees,id'],
            'dailyRate' => ['required', 'numeric', 'min:0'],
            'workDays' => ['required', 'numeric', 'min:0'],
            'workDaysPay' => ['required', 'numeric', 'min:0'],
            'overtimeHourRate' => ['nullable', 'numeric', 'min:0'],
            'overtimeHoursWorked' => ['nullable', 'numeric', 'min:0'],
            'overtimeTotalAmount' => ['nullable', 'numeric', 'min:0'],
            'totalAmount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'approvalStatus' => ['required', Rule::in(array_keys(self::APPROVAL_STATUSES))],
        ];
    }

    protected array $messages = [
        'code.required' => 'Entry code is required.',
        'code.unique' => 'This code already exists.',
        'payrollMonthId.required' => 'Payroll month is required.',
        'payrollMonthId.exists' => 'Selected payroll month does not exist.',
        'employeeId.required' => 'Employee is required.',
        'employeeId.exists' => 'Selected employee does not exist.',
        'dailyRate.required' => 'Daily rate is required.',
        'workDays.required' => 'Work days is required.',
        'workDaysPay.required' => 'Work days pay is required.',
        'totalAmount.required' => 'Total amount is required.',
    ];

    // ── Lifecycle ────────────────────────────────────────────
    public function mount(): void
    {
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatedFilterApproval(): void
    {
        $this->resetPage();
    }
    public function updatedFilterMonth(): void
    {
        $this->resetPage();
    }

    // ── Pre-fill rates when employee is selected ─────────────────
    public function updatedEmployeeId($value): void
    {
        if ($value) {
            $emp = \App\Models\Employee::find($value);
            if ($emp) {
                $this->dailyRate = (string) ($emp->daily_rate ?: 0);
                $this->overtimeHourRate = (string) ($emp->hourly_rate ?: 0);
            }
        } else {
            $this->dailyRate = '';
            $this->overtimeHourRate = '';
        }
        $this->recalculate();
    }

    // ── Auto-calculate fields ─────────────────────────────
    public function updatedDailyRate(): void
    {
        $this->recalculate();
    }
    public function updatedWorkDays(): void
    {
        $this->recalculate();
    }
    public function updatedOvertimeHourRate(): void
    {
        $this->recalculate();
    }
    public function updatedOvertimeHoursWorked(): void
    {
        $this->recalculate();
    }

    private function recalculate(): void
    {
        $daily = (float) ($this->dailyRate ?: 0);
        $days = (float) ($this->workDays ?: 0);
        $otRate = (float) ($this->overtimeHourRate ?: 0);
        $otHours = (float) ($this->overtimeHoursWorked ?: 0);

        $workPay = round($daily * $days, 2);
        $otTotal = round($otRate * $otHours, 2);
        $total = round($workPay + $otTotal, 2);

        $this->workDaysPay = (string) $workPay;
        $this->overtimeTotalAmount = (string) $otTotal;
        $this->totalAmount = (string) $total;
    }

    // ── Code generator ───────────────────────────────────────
    private function generateCode(): string
    {
        $last = PayrollEntry::orderBy('id', 'desc')->first();
        $n = $last ? ((int) preg_replace('/\D/', '', $last->code)) + 1 : 1;
        return 'PE-' . str_pad($n, 5, '0', STR_PAD_LEFT);
    }

    // ── CRUD openers ─────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $r = PayrollEntry::findOrFail($id);
        $this->editingId = $id;
        $this->code = $r->code ?? '';
        $this->payrollMonthId = (string) ($r->payroll_month_id ?? '');
        $this->employeeId = (string) ($r->employee_id ?? '');
        $this->dailyRate = (string) ($r->daily_rate ?? '');
        $this->workDays = (string) ($r->work_days ?? '');
        $this->workDaysPay = (string) ($r->work_days_pay ?? '');
        $this->overtimeHourRate = (string) ($r->overtime_hour_rate ?? '');
        $this->overtimeHoursWorked = (string) ($r->overtime_hours_worked ?? '');
        $this->overtimeTotalAmount = (string) ($r->overtime_total_amount ?? '');
        $this->totalAmount = (string) ($r->total_amount ?? '');
        $this->status = $this->enumVal($r->status) ?: 'draft';
        $this->approvalStatus = $this->enumVal($r->approval_status) ?: 'pending';
        $this->showModal = true;
    }

    public function openView(int $id): void
    {
        $this->viewRecord = PayrollEntry::with(['employee', 'payrollMonth', 'payslipEntry', 'paymentHistories'])
            ->findOrFail($id);
        $this->showView = true;
    }

    public function closeView(): void
    {
        $this->showView = false;
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
            $r = PayrollEntry::findOrFail($this->deletingId);

            // Guard: cannot delete if payslip or payments exist
            $hasPayslip = $r->payslipEntry()->exists() ?? false;
            $hasPayments = $r->paymentHistories()->exists() ?? false;

            if ($hasPayslip || $hasPayments) {
                session()->flash('error', 'Cannot delete: this entry has linked payslip or payment records.');
                $this->cancelDelete();
                return;
            }

            $r->delete();
            $this->cancelDelete();
            session()->flash('success', 'Payroll entry deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Approve / Reject ─────────────────────────────────────
    public function approve(string $id): void
    {
        try {
            PayrollEntry::findOrFail($id)->update(['approval_status' => 'approved']);
            session()->flash('success', 'Payroll entry approved.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject(string $id): void
    {
        try {
            PayrollEntry::findOrFail($id)->update(['approval_status' => 'rejected']);
            session()->flash('success', 'Payroll entry rejected.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ── Save ─────────────────────────────────────────────────
    public function save(): void
    {
        try {
            $this->recalculate();
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('PayrollEntry validation failed', [
                'errors' => $e->errors(),
                'data' => [
                    'code' => $this->code,
                    'payrollMonthId' => $this->payrollMonthId,
                    'employeeId' => $this->employeeId,
                    'dailyRate' => $this->dailyRate,
                    'workDays' => $this->workDays,
                    'totalAmount' => $this->totalAmount,
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
                'code' => strtoupper(trim($this->code)),
                'payroll_month_id' => $this->payrollMonthId,
                'employee_id' => $this->employeeId,
                'daily_rate' => (float) $this->dailyRate,
                'work_days' => (float) $this->workDays,
                'work_days_pay' => (float) $this->workDaysPay,
                'overtime_hour_rate' => $this->overtimeHourRate !== '' ? (float) $this->overtimeHourRate : null,
                'overtime_hours_worked' => $this->overtimeHoursWorked !== '' ? (float) $this->overtimeHoursWorked : null,
                'overtime_total_amount' => $this->overtimeTotalAmount !== '' ? (float) $this->overtimeTotalAmount : null,
                'total_amount' => (float) $this->totalAmount,
                'status' => $this->status,
                'approval_status' => $this->approvalStatus,
            ];

            if ($this->editingId) {
                PayrollEntry::findOrFail($this->editingId)->update($data);
                $msg = 'Payroll entry updated successfully.';
            } else {
                PayrollEntry::create($data);
                $msg = 'Payroll entry created successfully.';
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('PayrollEntry save failed', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? []
            ]);
            session()->flash('error', 'Save failed: ' . $e->getMessage());
        }
    }

    // ── Helpers ──────────────────────────────────────────────
    private function enumVal(mixed $v): string
    {
        return $v instanceof \BackedEnum ? $v->value : (string) ($v ?? '');
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->code = '';
        $this->payrollMonthId = '';
        $this->employeeId = '';
        $this->dailyRate = '';
        $this->workDays = '';
        $this->workDaysPay = '';
        $this->overtimeHourRate = '';
        $this->overtimeHoursWorked = '';
        $this->overtimeTotalAmount = '';
        $this->totalAmount = '';
        $this->status = 'Entered';
        $this->approvalStatus = 'pending';
        $this->resetValidation();
    }

    // ── Invoke for routing ─────────────────────────────────────
    public function __invoke()
    {
        return $this->render();
    }

    // ── Render ───────────────────────────────────────────────
    public function render()
    {
        $records = PayrollEntry::query()
            ->with(['employee', 'payrollMonth'])
            ->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('code', 'like', "%{$this->search}%")
                    ->orWhereHas(
                        'employee',
                        fn($eq) =>
                        $eq->where('first_name', 'like', "%{$this->search}%")
                            ->orWhere('last_name', 'like', "%{$this->search}%")
                    )
                    ->orWhereHas(
                        'payrollMonth',
                        fn($mq) =>
                        $mq->where('name', 'like', "%{$this->search}%")
                            ->orWhere('code', 'like', "%{$this->search}%")
                    );
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterApproval, fn($q) => $q->where('approval_status', $this->filterApproval))
            ->when($this->filterMonth, fn($q) => $q->where('payroll_month_id', $this->filterMonth))
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $totalCount = PayrollEntry::count();
        $approvedCount = PayrollEntry::where('approval_status', 'approved')->count();
        $paidCount = PayrollEntry::where('status', 'Posted')->count();
        $totalPayroll = PayrollEntry::where('approval_status', 'approved')->sum('total_amount');

        $employees = [];
        try {
            $employees = \App\Models\Employee::orderBy('first_name')
                ->get(['id', 'first_name', 'last_name'])->toArray();
        } catch (\Exception) {
        }

        $payrollMonths = [];
        try {
            $payrollMonths = \App\Models\PayrollMonth::orderBy('start_date', 'desc')
                ->get(['id', 'code', 'name', 'start_date', 'end_date'])->toArray();
        } catch (\Exception) {
        }

        return view('livewire.payroll.payroll-entry', [
            'records' => $records,
            'totalCount' => $totalCount,
            'approvedCount' => $approvedCount,
            'paidCount' => $paidCount,
            'totalPayroll' => $totalPayroll,
            'employees' => $employees,
            'payrollMonths' => $payrollMonths,
            'statuses' => self::STATUSES,
            'approvalStatuses' => self::APPROVAL_STATUSES,
            'showModal' => $this->showModal,
            'showView' => $this->showView,
            'showDelete' => $this->showDelete,
        ])->layout('components.layouts.app');
    }
}
