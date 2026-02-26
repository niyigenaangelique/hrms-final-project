<?php

namespace App\Livewire\PayrollEntry;

use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\Employee;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Carbon\Carbon;

class ListView extends Component
{
    use WithPagination, WithoutUrlPagination;

    public ?string $selectedId = null;
    public int $perPage = 16;
    public string $pageName = 'payrollPager';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public ?string $search = null;
    public ?string $filterMonth = null;
    public ?string $filterStatus = null;
    public ?string $filterEmployee = null;

    private const SORTABLE_COLUMNS = ['code', 'created_at', 'total_amount'];
    private const SEARCHABLE_COLUMNS = ['code'];

    #[Computed]
    #[On('reload-page')]
    public function payrollEntries()
    {
        $query = PayrollEntry::with(['employee', 'payrollMonth']);

        // Apply search
        if ($this->search) {
            $query->where(function ($q) use ($search) {
                foreach (self::SEARCHABLE_COLUMNS as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
                // Also search by employee name
                $q->orWhereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                           ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            });
        }

        // Apply filters
        if ($this->filterMonth) {
            $query->whereHas('payrollMonth', function ($subQuery) {
                $subQuery->where('id', $this->filterMonth);
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterEmployee) {
            $query->where('employee_id', $this->filterEmployee);
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage, pageName: $this->pageName);
    }

    #[Computed]
    public function payrollMonths()
    {
        return PayrollMonth::orderBy('start_date', 'desc')->get();
    }

    #[Computed]
    public function employees()
    {
        return Employee::where('approval_status', 'Approved')
            ->orderBy('first_name')
            ->get();
    }

    public function dispatchSelectPayrollEntry($id): void
    {
        $this->selectedId = $id;
        $this->dispatch('payrollEntry-selected', ['id' => $id]);
    }

    public function updatedFilterMonth()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterEmployee()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render():object
    {
        return view('livewire.payroll-entry.list-view');
    }
}
