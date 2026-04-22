<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollMonth;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
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
    public bool    $showModal  = false;
    public bool    $showView   = false;
    public bool    $showDelete = false;
    public ?string $editingId  = null;
    public ?string $deletingId = null;   // FIX: was typed as int in some places
    public ?PayrollMonth $viewRecord = null;

    // ══ FORM FIELDS ══════════════════════════════════════════
    public string $code           = '';
    public string $name           = '';
    public string $description    = '';
    public string $projectId      = '';
    public string $startDate      = '';
    public string $endDate        = '';
    public string $approvalStatus = 'pending';

    const APPROVAL_STATUSES = [
        'initiated'    => 'Initiated',
        'pending'      => 'Pending',
        'under_review' => 'Under Review',
        'approved'     => 'Approved',
        'rejected'     => 'Rejected',
        'cancelled'    => 'Cancelled',
    ];

    // ── Validation ──────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'code'           => ['required', 'string', 'max:50', Rule::unique('payroll_months', 'code')->ignore($this->editingId)],
            'name'           => ['required', 'string', 'max:150'],
            'description'    => ['nullable', 'string', 'max:500'],
            'projectId'      => ['required', 'string', 'exists:projects,id'],
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

    public function updatedSearch(): void       { $this->resetPage(); }
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

    // FIX: parameter is string (UUID), not int
    public function openEdit(string $id): void
    {
        \Log::info('PayrollMonth openEdit called', ['id' => $id]);
        $r = PayrollMonth::findOrFail($id);
        $this->editingId      = $id;
        $this->code           = $r->code ?? '';
        $this->name           = $r->name ?? '';
        $this->description    = $r->description ?? '';
        $this->projectId      = $r->project_id ?? '';
        $this->startDate      = $r->start_date ? Carbon::parse($r->start_date)->format('Y-m-d') : '';
        $this->endDate        = $r->end_date   ? Carbon::parse($r->end_date)->format('Y-m-d')   : '';
        $this->approvalStatus = $r->approval_status instanceof \BackedEnum
            ? $r->approval_status->value : ($r->approval_status ?? 'pending');
        $this->showModal      = true;
        \Log::info('PayrollMonth openEdit completed', ['editingId' => $this->editingId]);
    }

    // FIX: parameter is string (UUID), not int
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

    // FIX: parameter is string (UUID), not int
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
        if (! $this->deletingId) {
            \Log::warning('PayrollMonth deleteRecord called without deletingId');
            $this->cancelDelete();
            return;
        }
        try {
            $r = PayrollMonth::findOrFail($this->deletingId);
            \Log::info('PayrollMonth found for deletion', ['id' => $r->id, 'name' => $r->name]);
            if ($r->payrollEntries()->count() > 0) {
                session()->flash('error', 'Cannot delete: this payroll month has linked entries.');
                $this->cancelDelete();
                return;
            }
            $r->delete();
            $this->cancelDelete();
            session()->flash('success', 'Payroll month deleted successfully.');
            \Log::info('PayrollMonth deleted successfully');
        } catch (\Exception $e) {
            \Log::error('PayrollMonth delete failed', ['exception' => $e->getMessage()]);
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Approve / Reject shortcuts ──────────────────────────
    public function approve(string $id): void
    {
        \Log::info('PayrollMonth approve called', ['id' => $id]);
        try {
            $payrollMonth = PayrollMonth::findOrFail($id);
            
            // Enhanced validation before approval
            if ($payrollMonth->approval_status === 'approved') {
                session()->flash('warning', 'Payroll month ' . $payrollMonth->name . ' is already approved.');
                $this->dispatch('console-log', message: 'Payroll month approval attempted but already approved: ' . $payrollMonth->name);
                return;
            }
            
            if ($payrollMonth->approval_status === 'rejected') {
                session()->flash('warning', 'Payroll month ' . $payrollMonth->name . ' was previously rejected. Please review before approving.');
                $this->dispatch('console-log', message: 'Payroll month approval attempted but previously rejected: ' . $payrollMonth->name);
            }
            
            $payrollMonth->update(['approval_status' => 'approved']);
            
            // FIX: close view modal after approving from inside it
            $this->showView = false;
            $this->viewRecord = null;
            
            session()->flash('success', 'Payroll month ' . $payrollMonth->name . ' approved successfully.');
            $this->dispatch('console-log', message: 'Payroll month approved successfully: ' . $payrollMonth->name);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('error', 'Payroll month not found. Please refresh and try again.');
            $this->dispatch('console-log', message: 'Payroll month approval failed: Record not found for ID ' . $id);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'database') !== false) {
                session()->flash('error', 'Database error occurred during approval. Please try again.');
            } else {
                session()->flash('error', 'Approval failed: ' . $errorMessage);
            }
            $this->dispatch('console-log', message: 'Payroll month approval failed: ' . $errorMessage);
        }
    }

    public function reject(string $id): void
    {
        try {
            $payrollMonth = PayrollMonth::findOrFail($id);
            
            // Enhanced validation before rejection
            if ($payrollMonth->approval_status === 'rejected') {
                session()->flash('warning', 'Payroll month ' . $payrollMonth->name . ' is already rejected.');
                $this->dispatch('console-log', message: 'Payroll month rejection attempted but already rejected: ' . $payrollMonth->name);
                return;
            }
            
            if ($payrollMonth->approval_status === 'approved') {
                session()->flash('warning', 'Payroll month ' . $payrollMonth->name . ' was previously approved. Please confirm rejection.');
                $this->dispatch('console-log', message: 'Payroll month rejection attempted but previously approved: ' . $payrollMonth->name);
            }
            
            $payrollMonth->update(['approval_status' => 'rejected']);
            
            session()->flash('success', 'Payroll month ' . $payrollMonth->name . ' rejected successfully.');
            $this->dispatch('console-log', message: 'Payroll month rejected successfully: ' . $payrollMonth->name);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('error', 'Payroll month not found. Please refresh and try again.');
            $this->dispatch('console-log', message: 'Payroll month rejection failed: Record not found for ID ' . $id);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'database') !== false) {
                session()->flash('error', 'Database error occurred during rejection. Please try again.');
            } else {
                session()->flash('error', 'Rejection failed: ' . $errorMessage);
            }
            $this->dispatch('console-log', message: 'Payroll month rejection failed: ' . $errorMessage);
        }
    }

    // FIX: combined openEditAndCloseView to avoid chaining two wire:click calls
    public function openEditFromView(string $id): void
    {
        $this->closeView();
        $this->openEdit($id);
    }

    // ── Save ────────────────────────────────────────────────
    public function save(): void
    {
        \Log::info('PayrollMonth save attempt', [
            'editingId' => $this->editingId,
            'code' => $this->code,
            'name' => $this->name,
            'projectId' => $this->projectId,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'approvalStatus' => $this->approvalStatus,
        ]);
        
        try {
            \Log::info('PayrollMonth validation starting');
            $this->validate();
            \Log::info('PayrollMonth validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enhanced validation error handling with specific field messages
            $errors = $e->errors();
            $errorMessages = [];
            
            foreach ($errors as $field => $messages) {
                $fieldName = $this->getFieldDisplayName($field);
                $errorMessages[] = $fieldName . ': ' . implode(', ', $messages);
            }
            
            \Log::error('PayrollMonth validation failed', [
                'errors' => $errors,
                'data' => [
                    'code' => $this->code,
                    'name' => $this->name,
                    'description' => $this->description,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                    'approvalStatus' => $this->approvalStatus,
                ]
            ]);
            
            $this->dispatch('console-log', message: 'Payroll month validation failed: ' . implode('; ', $errorMessages));
            session()->flash('error', 'Validation failed: ' . implode('; ', $errorMessages));
            return;
        }

        DB::beginTransaction();
        try {
            $data = [
                'code'            => strtoupper(trim($this->code)),
                'name'            => trim($this->name),
                'description'     => trim($this->description) ?: null,
                'project_id'      => $this->projectId,
                'start_date'      => $this->startDate,
                'end_date'        => $this->endDate,
                'approval_status' => $this->approvalStatus,
            ];
            
            \Log::info('PayrollMonth database operation', [
                'operation' => $this->editingId ? 'update' : 'create',
                'data' => $data
            ]);

            if ($this->editingId) {
                \Log::info('PayrollMonth updating record', ['id' => $this->editingId]);
                PayrollMonth::findOrFail($this->editingId)->update($data);
                $msg = 'Payroll month updated successfully.';
                \Log::info('PayrollMonth update completed');
            } else {
                \Log::info('PayrollMonth creating new record');
                PayrollMonth::create($data);
                $msg = 'Payroll month created successfully.';
                \Log::info('PayrollMonth creation completed');
            }

            DB::commit();
            \Log::info('PayrollMonth transaction committed');
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('PayrollMonth save failed', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? []
            ]);
            
            $this->dispatch('console-log', message: 'Payroll month save failed: ' . $e->getMessage());
            
            // Enhanced error messages for common issues
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'duplicate') !== false) {
                session()->flash('error', 'Duplicate payroll month code detected. Please use a unique code.');
            } elseif (strpos($errorMessage, 'foreign key') !== false) {
                session()->flash('error', 'Invalid data provided. Please check all fields.');
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
        $this->editingId      = null;
        $this->code           = '';
        $this->name           = '';
        $this->description    = '';
        $this->projectId      = '';
        $this->startDate      = '';
        $this->endDate        = '';
        $this->approvalStatus = 'pending';
        $this->resetValidation();
    }

    #[Computed]
    public function projects(): array
    {
        try {
            \Log::info('PayrollMonth loading projects');
            $projects = Project::orderBy('name')
                ->get()
                ->map(fn($project) => [
                    'id' => $project->id,
                    'name' => $project->name,
                ])
                ->toArray();
            
            \Log::info('PayrollMonth projects loaded', ['count' => count($projects)]);
            return $projects;
        } catch (\Exception $e) {
            \Log::error('PayrollMonth projects loading failed', ['exception' => $e->getMessage()]);
            return [];
        }
    }

    // Helper method to get field display names for error messages
    private function getFieldDisplayName(string $field): string
    {
        $fieldNames = [
            'code' => 'Payroll Month Code',
            'name' => 'Payroll Month Name',
            'description' => 'Description',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'approvalStatus' => 'Approval Status',
        ];
        
        return $fieldNames[$field] ?? $field;
    }

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

        $totalCount     = PayrollMonth::count();
        $approvedCount  = PayrollMonth::where('approval_status', 'approved')->count();
        $pendingCount   = PayrollMonth::where('approval_status', 'pending')->count();
        $initiatedCount = PayrollMonth::where('approval_status', 'initiated')->count();

        return view('livewire.payroll.payroll-month', [
            'records'          => $records,
            'totalCount'       => $totalCount,
            'approvedCount'    => $approvedCount,
            'pendingCount'     => $pendingCount,
            'initiatedCount'   => $initiatedCount,
            'approvalStatuses' => self::APPROVAL_STATUSES,
            'showModal'        => $this->showModal,
            'showView'         => $this->showView,
            'showDelete'       => $this->showDelete,
        ])->layout('components.layouts.app');
    }
}