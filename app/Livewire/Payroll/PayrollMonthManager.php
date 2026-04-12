<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollMonth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Payroll Months')]
class PayrollMonthManager extends Component
{
    use WithPagination;

    // ── List / search ───────────────────────────────────────
    public string $search       = '';
    public string $filterStatus = '';
    public int    $perPage      = 15;

    // ── Modal state ─────────────────────────────────────────
    public bool  $showModal  = false;
    public bool  $showView   = false;
    public bool  $showDelete = false;
    public ?string $editingId  = null;
    public ?string $deletingId = null;
    public ?PayrollMonth $viewRecord = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code           = '';
    public string $name           = '';
    public string $description    = '';
    public string $startDate      = '';
    public string $endDate        = '';
    public string $approvalStatus = 'pending';

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
            'code'           => ['required', 'string', 'max:50', Rule::unique('payroll_months', 'code')->ignore($this->editingId)],
            'name'           => ['required', 'string', 'max:150'],
            'description'    => ['nullable', 'string', 'max:500'],
            'startDate'      => ['required', 'date'],
            'endDate'        => ['required', 'date', 'after_or_equal:startDate'],
            'approvalStatus' => ['required', Rule::in(array_keys(self::APPROVAL_STATUSES))],
        ];
    }

    protected array $messages = [
        'code.required'          => 'Payroll month code is required.',
        'code.unique'            => 'This code is already taken.',
        'name.required'          => 'Name is required.',
        'startDate.required'     => 'Start date is required.',
        'endDate.required'       => 'End date is required.',
        'endDate.after_or_equal' => 'End date must be on or after start date.',
    ];

    // ── Lifecycle ───────────────────────────────────────────
    public function mount(): void {}

    public function updatedSearch(): void      { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }

    // ── Auto-generate code ──────────────────────────────────
    private function generateCode(): string
    {
        $last = PayrollMonth::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) preg_replace('/\D/', '', $last->code)) + 1 : 1;
        return 'PM-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    // ── CRUD Openers ────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code      = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $r = PayrollMonth::findOrFail($id);
        $this->editingId      = $id;
        $this->code           = $r->code ?? '';
        $this->name           = $r->name ?? '';
        $this->description    = $r->description ?? '';
        $this->startDate      = $r->start_date ? Carbon::parse($r->start_date)->format('Y-m-d') : '';
        $this->endDate        = $r->end_date   ? Carbon::parse($r->end_date)->format('Y-m-d')   : '';
        $this->approvalStatus = $r->approval_status instanceof \BackedEnum
            ? $r->approval_status->value : ($r->approval_status ?? 'draft');
        $this->showModal      = true;
    }

    public function openView(string $id): void
    {
        $this->viewRecord = PayrollMonth::with('payrollEntries')->findOrFail($id);
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
            $r = PayrollMonth::findOrFail($this->deletingId);
            if ($r->payrollEntries()->count() > 0) {
                session()->flash('error', 'Cannot delete: this payroll month has linked entries.');
                $this->cancelDelete();
                return;
            }
            $r->delete();
            $this->cancelDelete();
            session()->flash('success', 'Payroll month deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Approve / Reject shortcuts ──────────────────────────
    public function approve(string $id): void
    {
        try {
            PayrollMonth::findOrFail($id)->update(['approval_status' => 'approved']);
            session()->flash('success', 'Payroll month approved.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject(string $id): void
    {
        try {
            PayrollMonth::findOrFail($id)->update(['approval_status' => 'rejected']);
            session()->flash('success', 'Payroll month rejected.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ── Save ────────────────────────────────────────────────
    public function save(): void
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('PayrollMonth validation failed', [
                'errors' => $e->errors(),
                'data' => [
                    'code' => $this->code,
                    'name' => $this->name,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                    'approvalStatus' => $this->approvalStatus,
                ]
            ]);
            session()->flash('error', 'Validation failed. Please check all required fields.');
            return;
        }

        DB::beginTransaction();
        try {
            $data = [
                'code'            => strtoupper(trim($this->code)),
                'name'            => trim($this->name),
                'description'     => trim($this->description) ?: null,
                'start_date'      => $this->startDate,
                'end_date'        => $this->endDate,
                'approval_status' => $this->approvalStatus,
            ];

            if ($this->editingId) {
                PayrollMonth::findOrFail($this->editingId)->update($data);
                $msg = 'Payroll month updated successfully.';
            } else {
                PayrollMonth::create($data);
                $msg = 'Payroll month created successfully.';
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('PayrollMonth save failed', [
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
        $this->editingId      = null;
        $this->code           = '';
        $this->name           = '';
        $this->description    = '';
        $this->startDate      = '';
        $this->endDate        = '';
        $this->approvalStatus = 'pending';
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
        $records = PayrollMonth::query()
            ->withCount('payrollEntries')
            ->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('code', 'like', "%{$this->search}%")
                   ->orWhere('name', 'like', "%{$this->search}%")
                   ->orWhere('description', 'like', "%{$this->search}%");
            }))
            ->when($this->filterStatus, fn($q) => $q->where('approval_status', $this->filterStatus))
            ->orderBy('start_date', 'desc')
            ->paginate($this->perPage);

        $totalCount    = PayrollMonth::count();
        $approvedCount = PayrollMonth::where('approval_status', 'approved')->count();
        $pendingCount  = PayrollMonth::where('approval_status', 'pending')->count();
        $draftCount    = PayrollMonth::where('approval_status', 'initiated')->count();

        return view('livewire.payroll.payroll-month', [
            'records'          => $records,
            'totalCount'       => $totalCount,
            'approvedCount'    => $approvedCount,
            'pendingCount'     => $pendingCount,
            'draftCount'       => $draftCount,
            'approvalStatuses' => self::APPROVAL_STATUSES,
            'showModal'        => $this->showModal,
            'showView'         => $this->showView,
            'showDelete'       => $this->showDelete,
        ])->layout('components.layouts.app');
    }
}