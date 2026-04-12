<?php

namespace App\Livewire\HR;

use App\Models\Contract;
use App\Models\Employee;
use App\Models\Position;
use App\Enum\ApprovalStatus;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Title('TalentFlow Pro | Contracts')]
class HrEmployeeContract extends Component
{
    use WithPagination;

    // ── List / search ──────────────────────────────────────
    public string $search          = '';
    public string $filterStatus    = '';
    public string $filterCategory  = '';
    public string $filterEmployee  = '';
    public int    $perPage         = 15;

    // ── Modal state ────────────────────────────────────────
    public bool  $showModal   = false;
    public bool  $showView    = false;
    public bool  $showDelete  = false;
    public ?string  $editingId   = null;
    public ?string  $deletingId  = null;
    public ?Contract $viewContract = null;

    // ══ FORM FIELDS ═══════════════════════════════════════
    public string $code               = '';
    public string $projectId          = '';
    public string $employeeId         = '';
    public string $positionId         = '';
    public string $remuneration       = '';
    public string $remunerationType   = 'Monthly';
    public string $employeeCategory   = 'Permanent';
    public string $contractType       = 'contract';
    public string $status             = 'active';
    public string $startDate          = '';
    public string $endDate            = '';
    public string $probationEndDate    = '';
    public string $workSchedule       = 'full_time';
    public string $workLocation       = '';
    public string $reportingTo        = '';
    public string $department         = '';
    public string $notes              = '';
    public bool   $isActive           = true;

    // ── Lifecycle ──────────────────────────────────────────
    public function mount(): void
    {
        // Initialization logic here
    }

    // ── Reset pagination on search/filter change ───────────
    public function updatedSearch(): void      { $this->resetPage(); }
    public function updatedFilterStatus(): void  { $this->resetPage(); }
    public function updatedFilterCategory(): void { $this->resetPage(); }
    public function updatedFilterEmployee(): void { $this->resetPage(); }

    #[Computed]
    public function duration(): string
    {
        if (!$this->startDate) {
            return '';
        }
        $start = \Carbon\Carbon::parse($this->startDate);
        
        if (!$this->endDate) {
            return 'Open-ended';
        }
        $end = \Carbon\Carbon::parse($this->endDate);
        
        if ($end->isBefore($start)) {
            return 'Invalid date range';
        }
        
        return $start->diffForHumans($end, true);
    }

    // ── Auto-retrieve position and salary when employee is selected ─────
    public function updatedEmployeeId(): void
    {
        if ($this->employeeId) {
            $employee = Employee::find($this->employeeId);
            if ($employee) {
                if ($employee->position_id) {
                    $this->positionId = $employee->position_id;
                }
                if ($employee->basic_salary) {
                    $this->remuneration = (string) $employee->basic_salary;
                }
            }
        } else {
            $this->positionId = '';
            $this->remuneration = '';
        }
    }

    // ── Open create form ───────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code = $this->generateCode();
        $this->showModal = true;
    }

    // ── Open edit form ─────────────────────────────────────
    public function openEdit(string $id): void
    {
        \Log::info('openEdit called with ID: ' . $id);
        $contract = Contract::findOrFail($id);
        $this->editingId = $id;
        $this->fillForm($contract);
        $this->showModal = true;
    }

    // ── View contract ──────────────────────────────────────
    public function openView(string $id): void
    {
        \Log::info('openView called with ID: ' . $id);
        $this->viewContract = Contract::findOrFail($id);
        $this->showView = true;
    }

    public function closeView(): void
    {
        $this->showView = false;
        $this->viewContract = null;
    }

    // ── Confirm delete ─────────────────────────────────────
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

    public function deleteContract(): void
    {
        if ($this->deletingId) {
            Contract::findOrFail($this->deletingId)->delete();
            $this->cancelDelete();
            session()->flash('success', 'Contract deleted successfully.');
        }
    }

    // ── Approve/Reject contract ────────────────────────────
    public function approveContract(string $id): void
    {
        $contract = Contract::findOrFail($id);
        $contract->approval_status = ApprovalStatus::Approved;
        $contract->status = \App\Enum\ContractStatus::ACTIVE;
        $contract->save();
        session()->flash('success', 'Contract approved successfully.');
    }

    public function rejectContract(string $id): void
    {
        $contract = Contract::findOrFail($id);
        $contract->approval_status = ApprovalStatus::Rejected;
        $contract->status = \App\Enum\ContractStatus::REJECTED;
        $contract->save();
        session()->flash('success', 'Contract rejected.');
    }

    // ── Close modal ────────────────────────────────────────
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    // ── Fill form from contract ─────────────────────────────
    private function fillForm(Contract $contract): void
    {
        $this->code               = $contract->code ?? '';
        $this->projectId          = $contract->project_id ?? '';
        $this->employeeId         = $contract->employee_id ?? '';
        $this->positionId         = $contract->position_id ?? '';
        $this->remuneration       = $contract->remuneration ?? '';
        $this->remunerationType   = $contract->remuneration_type instanceof \BackedEnum ? $contract->remuneration_type->value : ($contract->remuneration_type ?? 'Monthly');
        $this->employeeCategory   = $contract->employee_category instanceof \BackedEnum ? $contract->employee_category->value : ($contract->employee_category ?? 'Permanent');
        $this->status             = $contract->status instanceof \BackedEnum ? $contract->status->value : ($contract->status ?? 'active');
        $this->startDate          = $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('Y-m-d') : '';
        $this->endDate            = $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('Y-m-d') : '';
        $this->probationEndDate    = '';
        $this->workSchedule       = 'full_time';
        $this->workLocation       = '';
        $this->reportingTo        = '';
        $this->department         = '';
        $this->notes              = $contract->notes ?? '';
        $this->isActive           = true;
    }

    // ── Reset form fields ──────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId          = null;
        $this->code               = '';
        $this->projectId          = '';
        $this->employeeId         = '';
        $this->positionId         = '';
        $this->remuneration       = '';
        $this->remunerationType   = 'Monthly';
        $this->employeeCategory   = 'Permanent';
        $this->contractType       = 'contract';
        $this->status             = 'active';
        $this->startDate          = '';
        $this->endDate            = '';
        $this->probationEndDate    = '';
        $this->workSchedule       = 'full_time';
        $this->workLocation       = '';
        $this->reportingTo        = '';
        $this->department         = '';
        $this->notes              = '';
        $this->isActive           = true;
    }

    // ── Save (create or update) ────────────────────────────
    public function save(): void
    {
        \Log::info('Contract save attempt', [
            'employeeId' => $this->employeeId,
            'positionId' => $this->positionId,
            'status' => $this->status,
            'startDate' => $this->startDate,
            'remunerationType' => $this->remunerationType,
            'employeeCategory' => $this->employeeCategory,
        ]);

        $this->validate([
            'employeeId' => 'required|exists:employees,id',
            'positionId' => 'required|exists:positions,id',
            'status' => 'required|in:draft,pending,approved,active,inactive,expired,rejected,cancelled,terminated',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after:startDate',
            'remuneration' => 'nullable|numeric|min:0',
            'remunerationType' => 'required|in:Hourly,Daily,Monthly,Annually',
            'employeeCategory' => 'required|in:Permanent,Casual,Exempted,Second Employer',
        ]);

        \Log::info('Contract validation passed');

        try {
            $data = [
                'code' => $this->code ?: $this->generateCode(),
                'employee_id' => $this->employeeId,
                'position_id' => $this->positionId,
                'status' => $this->status,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate ?: null,
                'remuneration' => $this->remuneration ?: null,
                'remuneration_type' => $this->remunerationType,
                'employee_category' => $this->employeeCategory,
                'daily_working_hours' => '8.00',
                'approval_status' => ApprovalStatus::Approved,
                'is_locked' => false,
            ];

            \Log::info('Contract data prepared', ['data' => $data]);

            if ($this->editingId) {
                Contract::findOrFail($this->editingId)->update($data);
                $msg = 'Contract updated successfully.';
            } else {
                $contract = Contract::create($data);
                \Log::info('Contract created', ['contract_id' => $contract->id]);
                $msg = 'Contract created successfully.';
            }

            $this->closeModal();
            session()->flash('success', $msg);

        } catch (\Exception $e) {
            \Log::error('Contract save failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Save failed: ' . $e->getMessage());
        }
    }

    // ── Generate contract code ─────────────────────────────
    private function generateCode(): string
    {
        $last = Contract::orderBy('id','desc')->first();
        $n    = $last ? ((int) substr($last->code, 4)) + 1 : 1;
        return 'CON-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    // ── Render ─────────────────────────────────────────────
    public function render()
    {
        $contracts = Contract::query()
            ->with(['employee','position'])
            ->when($this->search, fn($q) => $q->where(function($q2) {
                $q2->where('code', 'like', "%{$this->search}%")
                   ->orWhereHas('employee', fn($e) => $e->where('first_name', 'like', "%{$this->search}%"))
                   ->orWhereHas('employee', fn($e) => $e->where('last_name', 'like', "%{$this->search}%"));
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus === 'active' ? \App\Enum\ContractStatus::ACTIVE : \App\Enum\ContractStatus::TERMINATED))
            ->when($this->filterCategory, fn($q) => $q->where('employee_category', $this->filterCategory))
            ->when($this->filterEmployee, fn($q) => $q->where('employee_id', $this->filterEmployee))
            ->orderBy('created_at','desc')
            ->paginate($this->perPage);

        // Calculate statistics
        $totalCount = Contract::count();
        $activeCount = Contract::where('status', \App\Enum\ContractStatus::ACTIVE)->count();
        $expiredCount = Contract::where('status', \App\Enum\ContractStatus::EXPIRED)->count();
        $pendingApproval = Contract::where('approval_status', ApprovalStatus::Pending)->count();

        // Define arrays for form options
        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'expired' => 'Expired',
            'terminated' => 'Terminated',
            'draft' => 'Draft',
            'suspended' => 'Suspended',
        ];

        $employeeCategories = [
            'Permanent' => 'Permanent',
            'Casual' => 'Casual',
            'Exempted' => 'Exempted',
            'Second Employer' => 'Second Employer',
        ];

        $contractTypes = [
            'permanent' => 'Permanent',
            'fixed_term' => 'Fixed Term',
            'probation' => 'Probation',
            'contract' => 'Contract',
        ];

        $remunerationTypes = [
            'Hourly' => 'Hourly',
            'Daily' => 'Daily',
            'Monthly' => 'Monthly',
            'Annually' => 'Annually',
        ];

        $approvalStatuses = [
            \App\Enum\ApprovalStatus::Pending,
            \App\Enum\ApprovalStatus::Approved,
            \App\Enum\ApprovalStatus::Rejected,
            \App\Enum\ApprovalStatus::Initiated,
        ];

        return view('livewire.hr.hr-employee-contract', [
            'contracts' => $contracts,
            'employees' => Employee::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'positions' => Position::orderBy('name')->get(['id', 'name']),
            'projects' => \App\Models\Project::orderBy('name')->get(['id', 'name']),
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'expiredCount' => $expiredCount,
            'pendingApproval' => $pendingApproval,
            'statuses' => $statuses,
            'employeeCategories' => $employeeCategories,
            'contractTypes' => $contractTypes,
            'remunerationTypes' => $remunerationTypes,
            'approvalStatuses' => $approvalStatuses,
        ])->layout('components.layouts.app');
    }
}
