<?php

namespace App\Livewire\PayrollMonth;

use App\Models\PayrollMonth;
use App\Models\PayrollEntry;
use App\Models\Employee;
use App\Services\TaxService;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | Payroll Months')]
class PayrollMonthPage extends Component
{
    public $selectedMonth   = null;
    public $showCreateModal = false;
    public $showEditModal   = false;
    public $showDeleteModal = false;
    public $deleteId        = null;

    // Form fields
    public $name        = null;
    public $description = null;
    public $start_date  = null;
    public $end_date    = null;

    protected $rules = [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'end_date.after_or_equal' => 'End date must be on or after the start date.',
    ];

    public function mount()
    {
        $this->selectedMonth = PayrollMonth::latest('start_date')->first();
    }

    // ── Create ────────────────────────────────────────────────

    public function createMonth()
    {
        $this->reset(['name', 'description', 'start_date', 'end_date']);
        $this->resetErrorBag();
        $this->showCreateModal = true;
    }

    public function storeMonth()
    {
        $this->validate();

        PayrollMonth::create([
            'name'            => $this->name,
            'description'     => $this->description,
            'start_date'      => $this->start_date,
            'end_date'        => $this->end_date,
            'code'            => 'PM-' . strtoupper(substr(uniqid(), -6)),
            'approval_status' => 'NotApplicable',
            'is_locked'       => false,
            'created_by'      => Auth::id(),
        ]);

        $this->showCreateModal = false;
        $this->reset(['name', 'description', 'start_date', 'end_date']);
        session()->flash('success', 'Payroll month created successfully!');
    }

    // ── Edit ──────────────────────────────────────────────────

    public function editMonth($id)
    {
        $month              = PayrollMonth::findOrFail($id);
        $this->selectedMonth = $month;
        $this->name         = $month->name;
        $this->description  = $month->description;
        $this->start_date   = $month->start_date ? \Carbon\Carbon::parse($month->start_date)->format('Y-m-d') : null;
        $this->end_date     = $month->end_date ? \Carbon\Carbon::parse($month->end_date)->format('Y-m-d') : null;
        $this->resetErrorBag();
        $this->showEditModal = true;
    }

    public function updateMonth()
    {
        $this->validate();

        $this->selectedMonth->update([
            'name'        => $this->name,
            'description' => $this->description,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'updated_by'  => Auth::id(),
        ]);

        $this->showEditModal = false;
        $this->reset(['name', 'description', 'start_date', 'end_date']);
        session()->flash('success', 'Payroll month updated successfully!');
    }

    // ── Delete ────────────────────────────────────────────────

    public function deleteMonth($id)
    {
        $this->deleteId        = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        $month = PayrollMonth::findOrFail($this->deleteId);

        if ($month->payrollEntries()->count() > 0) {
            session()->flash('error', 'Cannot delete a payroll month that has payroll entries.');
            $this->showDeleteModal = false;
            return;
        }

        $month->update(['deleted_by' => Auth::id()]);
        $month->delete();

        $this->showDeleteModal = false;
        $this->deleteId        = null;

        if ($this->selectedMonth?->id === $month->id) {
            $this->selectedMonth = PayrollMonth::latest('start_date')->first();
        }

        session()->flash('success', 'Payroll month deleted successfully!');
    }

    // ── Other actions ─────────────────────────────────────────

    public function selectMonth($id)
    {
        $this->selectedMonth = PayrollMonth::findOrFail($id);
    }

    public function lockMonth($id)
    {
        $month = PayrollMonth::findOrFail($id);
        $month->update([
            'is_locked' => !$month->is_locked,
            'locked_by' => Auth::id(),
        ]);

        $status = $month->fresh()->is_locked ? 'locked' : 'unlocked';
        session()->flash('success', "Payroll month {$status} successfully!");
    }

    /**
     * Generate payroll entries + payslip entries for all approved
     * employees in this month, using the Rwandan tax system.
     */
    public function generateEntries($id)
    {
        $month     = PayrollMonth::findOrFail($id);
        $employees = Employee::where('approval_status', 'Approved')
            ->whereNotNull('monthly_salary')
            ->get();

        $tax   = app(TaxService::class);
        $count = 0;

        foreach ($employees as $employee) {
            $grossSalary = (float)$employee->monthly_salary;

            $entry = PayrollEntry::firstOrCreate(
                [
                    'payroll_month_id' => $month->id,
                    'employee_id'      => $employee->id,
                ],
                [
                    'code'                  => 'PE-' . strtoupper(substr(uniqid(), -6)),
                    'daily_rate'            => round($grossSalary / 22, 2),
                    'work_days'             => 22,
                    'work_days_pay'         => $grossSalary,
                    'overtime_hour_rate'    => 0,
                    'overtime_hours_worked' => 0,
                    'overtime_total_amount' => 0,
                    'total_amount'          => $grossSalary,
                    'approval_status'       => 'approved',
                    'created_by'            => Auth::id(),
                ]
            );

            // Calculate and save taxes
            $result = $tax->calculate(grossSalary: $grossSalary);

            \App\Models\PayslipEntry::updateOrCreate(
                ['payroll_entry_id' => $entry->id],
                array_merge($result, [
                    'code'       => 'PS-' . strtoupper(substr(uniqid(), -6)),
                    'status'     => 'Generated',
                    'created_by' => Auth::id(),
                ])
            );

            $count++;
        }

        session()->flash('success', "Generated payroll entries and payslips for {$count} employees.");
    }

    #[On('payroll_monthNotification')]
    public function handleNotification(): void {}

    public function render(): object
    {
        $payrollMonths = PayrollMonth::with('payrollEntries')
            ->latest('start_date')
            ->get();

        return view('livewire.payroll-month.payroll-month-page', [
            'payrollMonths' => $payrollMonths,
        ])->layout('components.layouts.app');
    }
}
