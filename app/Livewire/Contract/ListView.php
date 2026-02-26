<?php

namespace App\Livewire\Contract;

use App\Models\Contract;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListView extends Component
{
    use WithPagination, WithoutUrlPagination;

    public ?string $selectedId = null;
    public int $perPage = 16;
    public string $pageName = 'usersPager';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public ?string $search = null;

    private const SORTABLE_COLUMNS = ['code', 'created_at'];
    private const SEARCHABLE_COLUMNS = ['code','employee.first_name','employee.last_name', 'position.name'];

    #[Computed]
    #[On('reload-page')]
    public function contracts()
    {
        return Contract::query()
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->orWhere('code', 'like', "%{$search}%")
                        ->orWhereHas('employee', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('position', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage, pageName: $this->pageName);

    }

    public function dispatchSelectContract($id): void
    {
        $this->selectedId=$id;
        $this->dispatch('contract-selected', ['id' => $id]);
    }
    public function render():object
    {
        return view('livewire.contract.list-view');
    }
}
