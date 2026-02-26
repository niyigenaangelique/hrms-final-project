<?php

namespace App\Livewire\Performance;

use App\Models\KPI;
use App\Models\KPITarget;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('ZIBITECH | C-HRMS | KPI Management')]
class KPIManagement extends Component
{
    use WithPagination;

    public $showForm = false;
    public $showTargetForm = false;
    public $selectedKPI;
    public $selectedEmployee;
    public $searchTerm = '';
    public $filterCategory = '';

    // KPI Form Fields
    public $name;
    public $description;
    public $category;
    public $measurement_unit;
    public $target_type;
    public $target_value;
    public $weight_percentage;
    public $is_active = true;

    // KPI Target Form Fields
    public $period_type;
    public $period_start;
    public $period_end;
    public $target_actual_value;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'category' => 'required|string|max:100',
        'measurement_unit' => 'required|string|max:50',
        'target_type' => 'required|in:numeric,percentage,boolean',
        'target_value' => 'required|numeric|min:0',
        'weight_percentage' => 'required|numeric|min:0|max:100',
        'is_active' => 'boolean',
    ];

    protected $targetRules = [
        'selectedEmployee' => 'required|exists:employees,id',
        'period_type' => 'required|in:monthly,quarterly,yearly',
        'period_start' => 'required|date',
        'period_end' => 'required|date|after_or_equal:period_start',
        'target_actual_value' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->measurement_unit = '';
        $this->target_type = 'numeric';
        $this->target_value = 0;
        $this->weight_percentage = 0;
        $this->is_active = true;
        $this->selectedKPI = null;
    }

    public function resetTargetForm()
    {
        $this->selectedEmployee = null;
        $this->period_type = 'monthly';
        $this->period_start = null;
        $this->period_end = null;
        $this->target_actual_value = 0;
    }

    public function createKPI()
    {
        $this->validate();

        KPI::create([
            'code' => 'KPI-' . uniqid(),
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'measurement_unit' => $this->measurement_unit,
            'target_type' => $this->target_type,
            'target_value' => $this->target_value,
            'weight_percentage' => $this->weight_percentage,
            'is_active' => $this->is_active,
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('showNotification', 'KPI created successfully', 'success');
        $this->showForm = false;
        $this->resetForm();
    }

    public function updateKPI()
    {
        $this->validate();

        $this->selectedKPI->update([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'measurement_unit' => $this->measurement_unit,
            'target_type' => $this->target_type,
            'target_value' => $this->target_value,
            'weight_percentage' => $this->weight_percentage,
            'is_active' => $this->is_active,
            'updated_by' => auth()->id(),
        ]);

        $this->dispatch('showNotification', 'KPI updated successfully', 'success');
        $this->showForm = false;
        $this->resetForm();
    }

    public function deleteKPI($kpiId)
    {
        $kpi = KPI::find($kpiId);
        if ($kpi) {
            $kpi->delete();
            $this->dispatch('showNotification', 'KPI deleted successfully', 'success');
        }
    }

    public function editKPI($kpiId)
    {
        $this->selectedKPI = KPI::find($kpiId);
        if ($this->selectedKPI) {
            $this->name = $this->selectedKPI->name;
            $this->description = $this->selectedKPI->description;
            $this->category = $this->selectedKPI->category;
            $this->measurement_unit = $this->selectedKPI->measurement_unit;
            $this->target_type = $this->selectedKPI->target_type;
            $this->target_value = $this->selectedKPI->target_value;
            $this->weight_percentage = $this->selectedKPI->weight_percentage;
            $this->is_active = $this->selectedKPI->is_active;
            $this->showForm = true;
        }
    }

    public function createTarget()
    {
        $this->validate($this->targetRules);

        KPITarget::create([
            'code' => 'KPT-' . uniqid(),
            'kpi_id' => $this->selectedKPI->id,
            'employee_id' => $this->selectedEmployee,
            'period_type' => $this->period_type,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'target_value' => $this->target_actual_value,
            'actual_value' => 0,
            'achievement_percentage' => 0,
            'score' => 0,
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('showNotification', 'KPI target created successfully', 'success');
        $this->showTargetForm = false;
        $this->resetTargetForm();
    }

    public function getKPIs()
    {
        $query = KPI::withCount('targets');

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        return $query->latest()->paginate(10);
    }

    public function getEmployees()
    {
        return Employee::where('is_active', true)->get();
    }

    public function getCategories()
    {
        return KPI::distinct()->pluck('category')->filter();
    }

    public function render()
    {
        return view('livewire.performance.kpi-management', [
            'kpis' => $this->getKPIs(),
            'employees' => $this->getEmployees(),
            'categories' => $this->getCategories(),
        ]);
    }
}
