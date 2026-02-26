<?php

namespace App\Livewire\Position;

use App\Models\Position;
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
    private const SEARCHABLE_COLUMNS = ['code'];

    #[Computed]
    #[On('reload-page')]
    public function positions()
    {
        return Position::query()
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    foreach (self::SEARCHABLE_COLUMNS as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage, pageName: $this->pageName);

    }

    public function dispatchSelectPosition($id): void
    {
        $this->selectedId=$id;
        $this->dispatch('position-selected', ['id' => $id]);
    }
    public function render():object
    {
        return view('livewire.position.list-view');
    }
}
