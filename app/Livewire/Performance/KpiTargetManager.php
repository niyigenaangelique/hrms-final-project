<?php

namespace App\Livewire\Performance;

use App\Models\KpiTarget;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

#[Title('TalentFlow Pro | KPI Targets')]
class KpiTargetManager extends Component
{
    use WithPagination;

    // ── List filters ────────────────────────────────────────
    public string $search          = '';
    public string $filterApproval  = '';
    public string $filterPeriod    = '';
    public string $filterEmployee  = '';
    public string $filterKpi       = '';
    public int    $perPage         = 15;

    // ── Modal flags ─────────────────────────────────────────
    public bool    $showModal  = false;
    public bool    $showView   = false;
    public bool    $showDelete = false;
    public ?string $editingId  = null;
    public ?string $deletingId = null;
    public ?KpiTarget $viewRecord = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code                  = '';
    public string $kpiId                 = '';
    public string $employeeId            = '';
    public string $periodType            = '';
    public string $periodStart           = '';
    public string $periodEnd             = '';
    public string $targetValue           = '';
    public string $actualValue           = '';
    public string $achievementPercentage = '';
    public string $score                 = '';
    public string $approvalStatus        = 'pending';

    // ── Constants ────────────────────────────────────────────
    const PERIOD_TYPES = [
        'daily'     => 'Daily',
        'weekly'    => 'Weekly',
        'monthly'   => 'Monthly',
        'quarterly' => 'Quarterly',
        'annual'    => 'Annual',
    ];

    const APPROVAL_STATUSES = [
        'draft'     => 'Draft',
        'pending'   => 'Pending',
        'approved'  => 'Approved',
        'rejected'  => 'Rejected',
        'cancelled' => 'Cancelled',
    ];

    // ── Validation ───────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'code'                  => ['required', 'string', 'max:255',
                                        Rule::unique('kpi_targets', 'code')->ignore($this->editingId, 'id')],
            'kpiId'                 => ['required', 'string', 'exists:kpis,id'],
            'employeeId'            => ['required', 'string', 'exists:employees,id'],
            'periodType'            => ['required', Rule::in(array_keys(self::PERIOD_TYPES))],
            'periodStart'           => ['required', 'date'],
            'periodEnd'             => ['required', 'date', 'after_or_equal:periodStart'],
            'targetValue'           => ['required', 'numeric', 'min:0'],
            'actualValue'           => ['nullable', 'numeric', 'min:0'],
            'achievementPercentage' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'score'                 => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'approvalStatus'        => ['required', Rule::in(array_keys(self::APPROVAL_STATUSES))],
        ];
    }

    protected array $messages = [
        'code.required'       => 'Target code is required.',
        'code.unique'         => 'This code already exists.',
        'kpiId.required'      => 'KPI is required.',
        'kpiId.exists'        => 'Selected KPI does not exist.',
        'employeeId.required' => 'Employee is required.',
        'employeeId.exists'   => 'Selected employee does not exist.',
        'periodType.required' => 'Period type is required.',
        'periodStart.required'=> 'Period start date is required.',
        'periodEnd.required'  => 'Period end date is required.',
        'periodEnd.after_or_equal' => 'End date must be on or after start date.',
        'targetValue.required'=> 'Target value is required.',
    ];

    // ── Lifecycle ────────────────────────────────────────────
    public function mount(): void {}

    public function updatedSearch(): void         { $this->resetPage(); }
    public function updatedFilterApproval(): void { $this->resetPage(); }
    public function updatedFilterPeriod(): void   { $this->resetPage(); }
    public function updatedFilterEmployee(): void { $this->resetPage(); }
    public function updatedFilterKpi(): void      { $this->resetPage(); }

    // ── Auto-calculate achievement % and score ───────────────
    public function updatedTargetValue(): void { $this->recalculate(); }
    public function updatedActualValue(): void { $this->recalculate(); }

    private function recalculate(): void
    {
        $target = (float)($this->targetValue ?: 0);
        $actual = (float)($this->actualValue ?: 0);

        if ($target > 0 && $actual >= 0) {
            $pct   = round(($actual / $target) * 100, 2);
            $score = round(min($pct, 100) / 10, 2);
            $this->achievementPercentage = (string)$pct;
            $this->score                 = (string)$score;
        } else {
            $this->achievementPercentage = '';
            $this->score                 = '';
        }
    }

    // ── Code generator ───────────────────────────────────────
    private function generateCode(): string
    {
        $last = KpiTarget::orderBy('created_at', 'desc')->first();
        if ($last && preg_match('/(\d+)$/', $last->code, $m)) {
            $n = (int)$m[1] + 1;
        } else {
            $n = 1;
        }
        return 'KPIT-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    // ── CRUD openers ─────────────────────────────────────────
    public function openCreate(?string $preselectedKpiId = null): void
    {
        $this->resetForm();
        $this->code        = $this->generateCode();
        $this->periodStart = now()->startOfMonth()->format('Y-m-d');
        $this->periodEnd   = now()->endOfMonth()->format('Y-m-d');
        if ($preselectedKpiId) {
            $this->kpiId = $preselectedKpiId;
        }
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $r = KpiTarget::findOrFail($id);
        $this->editingId             = $id;
        $this->code                  = $r->code            ?? '';
        $this->kpiId                 = (string)($r->kpi_id      ?? '');
        $this->employeeId            = (string)($r->employee_id  ?? '');
        $this->periodType            = $this->enumVal($r->period_type)     ?: '';
        $this->periodStart           = $r->period_start
            ? Carbon::parse($r->period_start)->format('Y-m-d') : '';
        $this->periodEnd             = $r->period_end
            ? Carbon::parse($r->period_end)->format('Y-m-d')   : '';
        $this->targetValue           = (string)($r->target_value           ?? '');
        $this->actualValue           = (string)($r->actual_value           ?? '');
        $this->achievementPercentage = (string)($r->achievement_percentage ?? '');
        $this->score                 = (string)($r->score                  ?? '');
        $this->approvalStatus        = $this->enumVal($r->approval_status) ?: 'pending';
        $this->showModal             = true;
    }

    public function openView(string $id): void
    {
        $this->viewRecord = KpiTarget::with(['employee', 'kpi'])->findOrFail($id);
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

    public function deleteRecord(): void
    {
        try {
            KpiTarget::findOrFail($this->deletingId)->delete();
            $this->cancelDelete();
            session()->flash('success', 'KPI target deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Approve / Reject ─────────────────────────────────────
    public function approve(string $id): void
    {
        try {
            KpiTarget::findOrFail($id)->update(['approval_status' => 'approved']);
            session()->flash('success', 'KPI target approved.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject(string $id): void
    {
        try {
            KpiTarget::findOrFail($id)->update(['approval_status' => 'rejected']);
            session()->flash('success', 'KPI target rejected.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ── Save ─────────────────────────────────────────────────
    public function save(): void
    {
        $this->recalculate();
        $this->validate();

        DB::beginTransaction();
        try {
            $data = [
                'code'                   => strtoupper(trim($this->code)),
                'kpi_id'                 => $this->kpiId,
                'employee_id'            => $this->employeeId,
                'period_type'            => $this->periodType,
                'period_start'           => $this->periodStart,
                'period_end'             => $this->periodEnd,
                'target_value'           => (float)$this->targetValue,
                'actual_value'           => $this->actualValue !== '' ? (float)$this->actualValue : null,
                'achievement_percentage' => $this->achievementPercentage !== '' ? (float)$this->achievementPercentage : null,
                'score'                  => $this->score !== '' ? (float)$this->score : null,
                'approval_status'        => $this->approvalStatus,
            ];

            if ($this->editingId) {
                KpiTarget::findOrFail($this->editingId)->update($data);
                $msg = 'KPI target updated successfully.';
            } else {
                KpiTarget::create($data);
                $msg = 'KPI target created successfully.';
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
        $this->editingId             = null;
        $this->code                  = '';
        $this->kpiId                 = '';
        $this->employeeId            = '';
        $this->periodType            = '';
        $this->periodStart           = '';
        $this->periodEnd             = '';
        $this->targetValue           = '';
        $this->actualValue           = '';
        $this->achievementPercentage = '';
        $this->score                 = '';
        $this->approvalStatus        = 'pending';
        $this->resetValidation();
    }

    // ── Render ───────────────────────────────────────────────
    public function render()
    {
        $records = KpiTarget::query()
            ->with(['employee', 'kpi'])
            ->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('code', 'like', "%{$this->search}%")
                   ->orWhereHas('employee', fn($eq) =>
                       $eq->where('first_name', 'like', "%{$this->search}%")
                          ->orWhere('last_name',  'like', "%{$this->search}%")
                   )
                   ->orWhereHas('kpi', fn($kq) =>
                       $kq->where('code', 'like', "%{$this->search}%")
                   );
            }))
            ->when($this->filterApproval, fn($q) => $q->where('approval_status', $this->filterApproval))
            ->when($this->filterPeriod,   fn($q) => $q->where('period_type', $this->filterPeriod))
            ->when($this->filterEmployee, fn($q) => $q->where('employee_id', $this->filterEmployee))
            ->when($this->filterKpi,      fn($q) => $q->where('kpi_id', $this->filterKpi))
            ->orderBy('period_start', 'desc')
            ->orderBy('created_at',   'desc')
            ->paginate($this->perPage);

        $totalCount    = KpiTarget::count();
        $approvedCount = KpiTarget::where('approval_status', 'approved')->count();
        $pendingCount  = KpiTarget::where('approval_status', 'pending')->count();
        $avgAchievement= round(KpiTarget::whereNotNull('achievement_percentage')->avg('achievement_percentage') ?? 0, 1);
        $avgScore      = round(KpiTarget::whereNotNull('score')->avg('score') ?? 0, 1);

        $employees = [];
        try {
            $employees = \App\Models\Employee::orderBy('first_name')
                ->get(['id', 'first_name', 'last_name'])->toArray();
        } catch (\Exception) {}

        $kpis = [];
        try {
            $kpis = \App\Models\Kpi::orderBy('code')
                ->get(['id', 'code'])->toArray();
        } catch (\Exception) {}

        return view('livewire.performance.kpi-target-manager', [
            'records'         => $records,
            'totalCount'      => $totalCount,
            'approvedCount'   => $approvedCount,
            'pendingCount'    => $pendingCount,
            'avgAchievement'  => $avgAchievement,
            'avgScore'        => $avgScore,
            'employees'       => $employees,
            'kpis'            => $kpis,
            'periodTypes'     => self::PERIOD_TYPES,
            'approvalStatuses'=> self::APPROVAL_STATUSES,
        ])->layout('components.layouts.app');
    }
}
