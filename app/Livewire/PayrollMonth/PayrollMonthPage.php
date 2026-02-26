<?php

namespace App\Livewire\PayrollMonth;

use App\Models\PayrollMonth;
use App\Models\PayrollEntry;
use App\Models\Employee;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Payroll Months')]

class PayrollMonthPage extends Component
{
    public $selectedMonth = null;
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $deleteId = null;
    
    // Form properties
    public $name = null;
    public $description = null;
    public $start_date = null;
    public $end_date = null;
    public $project_id = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'project_id' => 'required|exists:projects,id',
    ];

    public function mount()
    {
        // Load the most recent month by default
        $this->selectedMonth = PayrollMonth::latest('start_date')->first();
    }

    public function createMonth()
    {
        $this->reset(['name', 'description', 'start_date', 'end_date', 'project_id']);
        $this->showCreateModal = true;
    }

    public function storeMonth()
    {
        $this->validate();
        
        PayrollMonth::create([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'project_id' => $this->project_id,
            'code' => 'PM-' . strtoupper(uniqid()),
            'approval_status' => 'NotApplicable',
            'is_locked' => false,
            'created_by' => auth()->id(),
        ]);

        $this->showCreateModal = false;
        session()->flash('success', 'Payroll month created successfully!');
    }

    public function editMonth($id)
    {
        $month = PayrollMonth::findOrFail($id);
        $this->selectedMonth = $month;
        $this->name = $month->name;
        $this->description = $month->description;
        $this->start_date = $month->start_date->format('Y-m-d');
        $this->end_date = $month->end_date->format('Y-m-d');
        $this->project_id = $month->project_id;
        $this->showEditModal = true;
    }

    public function updateMonth()
    {
        $this->validate();
        
        $this->selectedMonth->update([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'project_id' => $this->project_id,
            'updated_by' => auth()->id(),
        ]);

        $this->showEditModal = false;
        session()->flash('success', 'Payroll month updated successfully!');
    }

    public function deleteMonth($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        $month = PayrollMonth::findOrFail($this->deleteId);
        
        // Check if there are any payroll entries
        if ($month->payrollEntries()->count() > 0) {
            session()->flash('error', 'Cannot delete payroll month with existing entries!');
            $this->showDeleteModal = false;
            return;
        }

        $month->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        
        if ($this->selectedMonth?->id === $month->id) {
            $this->selectedMonth = PayrollMonth::latest('start_date')->first();
        }
        
        session()->flash('success', 'Payroll month deleted successfully!');
    }

    public function selectMonth($id)
    {
        $this->selectedMonth = PayrollMonth::findOrFail($id);
    }

    public function lockMonth($id)
    {
        $month = PayrollMonth::findOrFail($id);
        $month->update([
            'is_locked' => !$month->is_locked,
            'locked_by' => auth()->id(),
        ]);
        
        $status = $month->is_locked ? 'locked' : 'unlocked';
        session()->flash('success', "Payroll month {$status} successfully!");
    }

    public function generateEntries($id)
    {
        $month = PayrollMonth::findOrFail($id);
        $employees = Employee::where('approval_status', 'Approved')->get();
        
        foreach ($employees as $employee) {
            // Check if entry already exists
            $existingEntry = PayrollEntry::where('payroll_month_id', $month->id)
                ->where('employee_id', $employee->id)
                ->first();
                
            if (!$existingEntry) {
                PayrollEntry::create([
                    'code' => 'PE-' . strtoupper(uniqid()),
                    'payroll_month_id' => $month->id,
                    'employee_id' => $employee->id,
                    'daily_rate' => $employee->daily_rate ?? 100.00, // Default rate
                    'work_days' => 22, // Default work days
                    'work_days_pay' => 2200.00,
                    'overtime_hour_rate' => 1.50,
                    'overtime_hours_worked' => 0,
                    'overtime_total_amount' => 0,
                    'total_amount' => 2200.00,
                    'status' => 'entered',
                    'created_by' => auth()->id(),
                ]);
            }
        }
        
        session()->flash('success', 'Payroll entries generated successfully!');
    }

    #[On('payroll_monthNotification')]
    public function handleNotification(): void
    {
        // Handle any real-time notifications
    }

    public function render():object
    {
        return view('livewire.payroll-month.payroll-month-page')
            ->layout('components.layouts.app');
    }
}
