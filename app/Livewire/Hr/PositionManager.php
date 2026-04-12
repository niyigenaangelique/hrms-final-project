<?php

namespace App\Livewire\HR;

use App\Models\Position;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

#[Title('TalentFlow Pro | Positions')]
class PositionManager extends Component
{
    use WithPagination;

    // ── List / search ──────────────────────────────────────
    public string $search       = '';
    public string $filterDept   = '';
    public int    $perPage      = 15;

    // ── Modal state ────────────────────────────────────────
    public bool  $showModal  = false;
    public bool  $showView   = false;
    public bool  $showDelete = false;
    public ?string  $editingId  = null;
    public ?string  $deletingId = null;
    public ?Position $viewPosition = null;

    // ══ FORM FIELDS ═════════════════════════════════════════
    public string $code         = '';
    public string $name         = '';
    public string $description  = '';

    // ── Validation ─────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:150',
                Rule::unique('positions', 'name')->ignore($this->editingId)],
            'code'         => ['required', 'string', 'max:50',
                Rule::unique('positions', 'code')->ignore($this->editingId)],
            'description'  => 'nullable|string|max:500',
        ];
    }

    protected array $messages = [
        'name.required'  => 'Position name is required.',
        'name.unique'    => 'A position with this name already exists.',
        'code.required'  => 'Position code is required.',
        'code.unique'    => 'This code is already taken.',
    ];

    // ── Lifecycle ──────────────────────────────────────────
    public function mount(): void
    {
        // $this->loadDepartments(); // Removed - no longer needed
    }

    // ── Auto-generate code ─────────────────────────────────
    private function generateCode(): string
    {
        $last = Position::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) substr($last->code, -3)) + 1 : 1;
        return 'POS-' . str_pad($n, 3, '0', STR_PAD_LEFT);
    }

    // ── Pagination reset ───────────────────────────────────
    public function updatedSearch(): void   { $this->resetPage(); }
    public function updatedFilterDept(): void { $this->resetPage(); }

    // ── Auto-uppercase code ────────────────────────────────
    public function updatedCode(): void
    {
        $this->code = strtoupper($this->code);
    }

    // ── CRUD openers ───────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->code      = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $pos = Position::findOrFail($id);
        $this->editingId    = $id;
        $this->code         = $pos->code         ?? '';
        $this->name         = $pos->name         ?? '';
        $this->description  = $pos->description  ?? '';
        $this->showModal    = true;
    }

    public function openView(string $id): void
    {
        $this->viewPosition = Position::with(['employees'])->findOrFail($id);
        $this->showView     = true;
    }

    public function closeView(): void
    {
        $this->showView     = false;
        $this->viewPosition = null;
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

    public function deletePosition(): void
    {
        try {
            $pos = Position::findOrFail($this->deletingId);

            if ($pos->employees()->count() > 0) {
                session()->flash('error', 'Cannot delete: ' . $pos->employees()->count() . ' employee(s) hold this position.');
                $this->cancelDelete();
                return;
            }

            $pos->delete();
            $this->cancelDelete();
            session()->flash('success', 'Position deleted successfully.');
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
                'code'          => strtoupper(trim($this->code)),
                'name'          => trim($this->name),
                'description'   => trim($this->description) ?: null,
            ];

            if ($this->editingId) {
                Position::findOrFail($this->editingId)->update($data);
                $msg = 'Position updated successfully.';
            } else {
                Position::create($data);
                $msg = 'Position created successfully.';
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
        $this->editingId    = null;
        $this->code         = '';
        $this->name         = '';
        $this->description  = '';
        $this->resetValidation();
    }

    // ── Render ─────────────────────────────────────────────
    public function render()
    {
        $positions = Position::query()
            ->withCount('employees')
            ->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('name', 'like', "%{$this->search}%")
                   ->orWhere('code', 'like', "%{$this->search}%")
                   ->orWhere('description', 'like', "%{$this->search}%");
            }))
            ->orderBy('name')
            ->paginate($this->perPage);

        $totalCount      = Position::count();
        $withStaffCount  = Position::has('employees')->count();
        $vacantCount     = Position::doesntHave('employees')->count();

        return view('livewire.hr.hr-position-manager', [
            'positions'     => $positions,
            'totalCount'    => $totalCount,
            'withStaffCount'=> $withStaffCount,
            'vacantCount'   => $vacantCount,
        ])->layout('components.layouts.hr');
    }
}