<?php

namespace App\Livewire\HR;

use App\Models\Department;
use App\Models\Employee;
use App\Enum\ApprovalStatus;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

#[Title('TalentFlow Pro | Departments')]
class DepartmentManager extends Component
{
    use WithPagination;

    // ── List / search ──────────────────────────────────────
    public string $search  = '';
    public int    $perPage = 15;

    // ── Modal state ────────────────────────────────────────
    public bool  $showModal  = false;
    public bool  $showView   = false;
    public bool  $showDelete = false;
    public ?string  $editingId  = null;
    public ?string  $deletingId = null;
    public ?Department $viewDepartment = null;

    // ══ FORM FIELDS ═════════════════════════════════════════
    public string $code        = '';
    public string $name        = '';
    public string $description = '';
    public string $managerId   = '';

    // ── Dropdown ───────────────────────────────────────────
    public array $managers = [];

    // ── Validation ─────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:150',
                Rule::unique('departments', 'name')->ignore($this->editingId)],
            'code'        => ['required', 'string', 'max:50',
                Rule::unique('departments', 'code')->ignore($this->editingId)],
            'description' => 'nullable|string|max:500',
            'managerId'   => 'nullable|exists:employees,id',
        ];
    }

    protected array $messages = [
        'name.required'   => 'Department name is required.',
        'name.unique'     => 'A department with this name already exists.',
        'code.required'   => 'Department code is required.',
        'code.unique'     => 'This code is already taken.',
    ];

    // ── Lifecycle ──────────────────────────────────────────
    public function mount(): void
    {
        $this->loadManagers();
    }

    private function loadManagers(): void
    {
        try {
            $this->managers = Employee::orderBy('first_name')
                ->get(['id', 'first_name', 'last_name', 'code'])
                ->map(fn($e) => [
                    'id'   => $e->id,
                    'name' => "{$e->first_name} {$e->last_name} ({$e->code})",
                ])->toArray();
        } catch (\Exception) {
            $this->managers = [];
        }
    }

    // ── Auto-generate code ─────────────────────────────────
    private function generateCode(): string
    {
        $last = Department::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) substr($last->code, -3)) + 1 : 1;
        return 'DEPT-' . str_pad($n, 3, '0', STR_PAD_LEFT);
    }

    // ── Pagination reset ───────────────────────────────────
    public function updatedSearch(): void { $this->resetPage(); }

    // ── CRUD openers ───────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code      = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $dept = Department::findOrFail($id);
        $this->editingId   = $id;
        $this->code        = $dept->code        ?? '';
        $this->name        = $dept->name        ?? '';
        $this->description = $dept->description ?? '';
        $this->managerId   = $dept->manager_id  ?? '';
        $this->showModal   = true;
    }

    public function openView(string $id): void
    {
        $this->viewDepartment = Department::with(['manager', 'employees'])->findOrFail($id);
        $this->showView       = true;
    }

    public function closeView(): void
    {
        $this->showView       = false;
        $this->viewDepartment = null;
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

    public function deleteDepartment(): void
    {
        try {
            $dept = Department::findOrFail($this->deletingId);

            // Prevent delete if employees are assigned
            if ($dept->employees()->count() > 0) {
                session()->flash('error', 'Cannot delete: this department has ' . $dept->employees()->count() . ' employee(s) assigned.');
                $this->cancelDelete();
                return;
            }

            $dept->delete();
            $this->cancelDelete();
            session()->flash('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Save ───────────────────────────────────────────────
    public function save(): void
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $data = [
                'code'        => strtoupper(trim($this->code)),
                'name'        => trim($this->name),
                'description' => trim($this->description) ?: null,
                'manager_id'  => $this->managerId ?: null,
            ];

            if ($this->editingId) {
                Department::findOrFail($this->editingId)->update($data);
                $msg = 'Department updated successfully.';
            } else {
                Department::create($data);
                $msg = 'Department created successfully.';
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Save failed: ' . $e->getMessage());
        }
    }

    // ── Reset form ─────────────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId   = null;
        $this->code        = '';
        $this->name        = '';
        $this->description = '';
        $this->managerId   = '';
        $this->resetValidation();
    }

    // ── Render ─────────────────────────────────────────────
    public function render()
    {
        // Debug: Log what's happening
        \Log::info('DepartmentManager render method called');
        
        try {
            $departments = Department::query()
                ->with(['manager', 'employees'])
                ->withCount(['employees'])
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('name', 'like', "%{$this->search}%")
                           ->orWhere('code', 'like', "%{$this->search}%")
                           ->orWhere('description', 'like', "%{$this->search}%");
                }))
                ->orderBy('name')
                ->paginate($this->perPage);

            $totalCount    = Department::count();
            $withManagerCount = Department::whereNotNull('manager_id')->count();
            $totalEmployees   = \App\Models\Employee::whereNotNull('department_id')->count();

            // Debug: Log the data
            \Log::info('Departments count: ' . $departments->count());
            \Log::info('Total count: ' . $totalCount);

            return view('livewire.hr.hr-department-manager', [
                'departments'      => $departments,
                'totalCount'       => $totalCount,
                'withManagerCount' => $withManagerCount,
                'totalEmployees'   => $totalEmployees,
            ])->layout('components.layouts.app');
        } catch (\Exception $e) {
            \Log::error('DepartmentManager render error: ' . $e->getMessage());
            throw $e;
        }
    }
}