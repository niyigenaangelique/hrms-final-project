<?php

namespace App\Livewire\Payroll;

use App\Models\Employee;
use App\Models\PayrollPeriod;
use App\Models\PayrollComputationEntry;
use App\Services\PayrollService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class PayrollComputationManager extends Component
{
    use WithPagination;

    public $selectedPeriodId;
    public $search = '';
    public $showCreateModal = false;
    
    // Form fields for new period
    public $newPeriodName;
    public $newStartDate;
    public $newEndDate;

    protected $listeners = ['refreshMatrix' => '$refresh'];

    public function mount()
    {
        // Default to latest legacy month if no periods exist
        $latest = PayrollPeriod::latest()->first();
        if ($latest) {
            $this->selectedPeriodId = 'period_' . $latest->id;
        } else {
            $latestMonth = \App\Models\PayrollMonth::latest()->first();
            if ($latestMonth) {
                $this->selectedPeriodId = 'month_' . $latestMonth->id;
            }
        }
    }

    public function updatedSelectedPeriodId()
    {
        $this->resetPage();
    }

    /**
     * Initiate a new payroll month
     */
    public function initiatePayroll()
    {
        $this->validate([
            'newPeriodName' => 'required|string',
            'newStartDate' => 'required|date',
            'newEndDate' => 'required|date|after:newStartDate',
        ]);

        if (Carbon::parse($this->newEndDate)->isFuture()) {
            $this->dispatch('notify', ['type' => 'warning', 'message' => 'Cannot initiate payroll for future periods.']);
            return;
        }

        try {
            $service = new PayrollService();
            $period = $service->createPayrollPeriod(
                $this->newPeriodName,
                Carbon::parse($this->newStartDate),
                Carbon::parse($this->newEndDate)
            );

            // Populate initial entries for all active employees
            $employees = Employee::where('is_active', true)->get();
            foreach ($employees as $employee) {
                PayrollComputationEntry::create([
                    'payroll_period_id' => $period->id,
                    'employee_id' => $employee->id,
                    'employee_code' => $employee->code,
                    'employee_name' => $employee->full_name,
                    'basic_salary' => $employee->basic_salary ?? 0,
                    'status' => 'draft',
                ]);
            }

            $this->selectedPeriodId = $period->id;
            $this->showCreateModal = false;
            $this->reset(['newPeriodName', 'newStartDate', 'newEndDate']);
            
            session()->flash('success', 'Payroll month initiated successfully.');
        } catch (\Exception $e) {
            Log::error('Payroll initiation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to initiate: ' . $e->getMessage());
        }
    }

    /**
     * Run full calculation for the selected period
     */
    public function calculateAll()
    {
        if (!$this->selectedPeriodId) return;

        try {
            $id = str_replace(['period_', 'month_'], '', $this->selectedPeriodId);
            $service = new PayrollService();
            
            if (str_starts_with($this->selectedPeriodId, 'period_')) {
                $period = PayrollPeriod::findOrFail($id);
            } else {
                $period = \App\Models\PayrollMonth::findOrFail($id);
            }

            if (Carbon::parse($period->end_date)->isFuture()) {
                $this->dispatch('notify', ['type' => 'warning', 'message' => 'Cannot calculate for a future period.']);
                return;
            }

            // We no longer delete entries here, so runPayroll can preserve manual overrides
            // via its internal updateOrCreate logic.

            // The runPayroll method now handles both creating missing entries and 
            // updating existing ones while preserving manual overrides.
            $results = $service->runPayroll($period);
            session()->flash('success', "Calculated {$results['processed_employees']} employees successfully.");
            
        } catch (\Exception $e) {
            Log::error('Payroll calculation failed: ' . $e->getMessage());
            session()->flash('error', 'Calculation error: ' . $e->getMessage());
        }
    }

    /**
     * Generate payslips for all employees in the selected period
     */
    public function generatePayslips()
    {
        if (!$this->selectedPeriodId) return;

        try {
            $id = str_replace(['period_', 'month_'], '', $this->selectedPeriodId);
            
            if ($this->isAdvancedPeriod()) {
                session()->flash('error', 'Cannot generate payslips for a future period.');
                return;
            }
            
            $entries = PayrollComputationEntry::where(function($q) use ($id) {
                $q->where('payroll_period_id', $id)->orWhere('payroll_month_id', $id);
            })->get();

            if ($entries->isEmpty()) {
                $this->dispatch('notify', ['type' => 'warning', 'message' => 'No records to generate payslips for.']);
                return;
            }

            foreach ($entries as $entry) {
                $payslip = \App\Models\PayslipEntry::firstOrNew(['payroll_computation_entry_id' => $entry->id]);
                if (!$payslip->exists) {
                    $payslip->code = 'PS-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::replace('-', '', \Illuminate\Support\Str::uuid()->toString()));
                }
                
                $payslip->fill([
                    'gross_pay' => $entry->gross_pay,
                    'taxable_income' => max(0, $entry->gross_pay - $entry->rssb_employee - $entry->maternity_fund - $entry->cbhi),
                    'paye' => $entry->paye_tax,
                    'pension' => $entry->rssb_employee,
                    'maternity' => $entry->maternity_fund,
                    'cbhi' => $entry->cbhi,
                    'net_pay' => $entry->net_pay,
                    'status' => \App\Enum\PayslipStatus::Generated,
                    'approval_status' => \App\Enum\ApprovalStatus::Pending,
                ]);
                $payslip->save();

                // Update the computation entry status so it reflects in the UI
                $entry->update(['status' => 'generated']);
            }

            $this->dispatch('notify', ['type' => 'success', 'message' => 'Payslips generated and assigned to employees.']);
            session()->flash('success', 'Payslips generated and assigned to employees successfully.');
        } catch (\Exception $e) {
            Log::error('Payslip generation failed: ' . $e->getMessage());
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to generate: ' . $e->getMessage()]);
            session()->flash('error', 'Failed to generate payslips: ' . $e->getMessage());
        }
    }

    /**
     * Update a single field in the matrix
     */
    public function updateEntry($entryId, $field, $value)
    {
        try {
            $entry = PayrollComputationEntry::findOrFail($entryId);
                        // Ensure the incoming value is numeric (empty strings become 0)
            $numericValue = is_numeric($value) ? (float) $value : 0;
            $entry->update([$field => $numericValue]);
            $entry->refresh(); // Reload latest DB values

            // Re-calculate allowances_total if components were changed
            if (in_array($field, ['house_allowance', 'transport_allowance', 'other_allowances'])) {
                $entry->update([
                    'allowances_total' => $entry->house_allowance + $entry->transport_allowance + $entry->other_allowances,
                ]);
            }
            
            // Re-calculate this specific employee
            $service = new PayrollService();
            $id = str_replace(['period_', 'month_'], '', $this->selectedPeriodId);
            
            if (str_starts_with($this->selectedPeriodId, 'period_')) {
                $period = PayrollPeriod::find($id);
            } else {
                $period = \App\Models\PayrollMonth::find($id);
            }
            
            $employee = Employee::find($entry->employee_id);
            $newData = $service->calculateEmployeePayroll($employee, $period, [
                'basic_salary' => $entry->basic_salary,
                'house_allowance' => $entry->house_allowance,
                'transport_allowance' => $entry->transport_allowance,
                'other_allowances' => $entry->other_allowances,
                'salary_advance' => $entry->salary_advance,
            ]);
            $entry->update($newData);
            

            // Re-calculate allowances_total if components were changed
            if (in_array($field, ['house_allowance', 'transport_allowance', 'other_allowances'])) {
                $entry->update([
                    'allowances_total' => $entry->house_allowance + $entry->transport_allowance + $entry->other_allowances
                ]);
            }
            
            // Re-calculate this specific employee
            $service = new PayrollService();
            $id = str_replace(['period_', 'month_'], '', $this->selectedPeriodId);
            
            if (str_starts_with($this->selectedPeriodId, 'period_')) {
                $period = PayrollPeriod::find($id);
            } else {
                $period = \App\Models\PayrollMonth::find($id);
            }
            
            $employee = Employee::find($entry->employee_id);
            $newData = $service->calculateEmployeePayroll($employee, $period, [
                'basic_salary' => $entry->basic_salary,
                'house_allowance' => $entry->house_allowance,
                'transport_allowance' => $entry->transport_allowance,
                'other_allowances' => $entry->other_allowances,
                'salary_advance' => $entry->salary_advance,
            ]);
            $entry->update($newData);

            $this->dispatch('notify', ['type' => 'success', 'message' => 'Updated and recalculated.']);
        } catch (\Exception $e) {
            Log::error('Matrix update failed: ' . $e->getMessage());
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Update failed.']);
        }
    }
    

    /**
     * Export to Excel
     */
    public function exportExcel()
    {
        if (!$this->selectedPeriodId) return;
        
        $id = str_replace(['period_', 'month_'], '', $this->selectedPeriodId);
        
        if (str_starts_with($this->selectedPeriodId, 'period_')) {
            $period = PayrollPeriod::find($id);
            $query = PayrollComputationEntry::where('payroll_period_id', $id);
        } else {
            $period = \App\Models\PayrollMonth::find($id);
            $query = PayrollComputationEntry::where('payroll_month_id', $id);
        }

        if (!$period) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Period not found.']);
            return;
        }

        if ($this->isAdvancedPeriod()) {
            session()->flash('error', 'Cannot export payroll for a future period.');
            return;
        }

        $fileName = 'Payroll_' . str_replace(' ', '_', $period->name) . '_' . now()->format('Ymd') . '.csv';
        
        return response()->streamDownload(function() use ($query) {
            $entries = $query->get();
            $csv = fopen('php://output', 'w');
            
            // Headers matches user's matrix columns
            fputcsv($csv, [
                'Code', 'Names', 'Position', 'Bank Name', 'Bank Account', 'Nationality',
                'Gross Salary', 'House Allowance', 'Transport Allowance', 'Other Allowance',
                'Basic Salary', 'PAYE', 'RSSB (3%)', 'RSSB (5%) Employer', 'Maternity (0.3%)',
                'Total Deductions', 'Net Before CBHI', 'CBHI (4.5%)', 'Salary Advance', 'Net Pay RWF'
            ]);
            
            foreach ($entries as $e) {
                fputcsv($csv, [
                    $e->employee_code,
                    $e->employee_name,
                    $e->position,
                    $e->bank_name,
                    $e->bank_account,
                    $e->nationality,
                    $e->gross_pay,
                    $e->house_allowance,
                    $e->transport_allowance,
                    $e->other_allowances,
                    $e->basic_salary,
                    $e->paye_tax,
                    $e->rssb_employee,
                    $e->rssb_employer,
                    $e->maternity_fund,
                    $e->total_deductions,
                    $e->net_before_cbhi,
                    $e->cbhi,
                    $e->salary_advance,
                    $e->net_pay
                ]);
            }
            fclose($csv);
        }, $fileName);
    }

    public function render()
    {
        $newPeriods = PayrollPeriod::latest()->get()->map(fn($p) => ['id' => 'period_' . $p->id, 'name' => $p->name . ' (Automated)', 'status' => $p->status]);
        $oldMonths = \App\Models\PayrollMonth::latest()->get()->map(fn($m) => ['id' => 'month_' . $m->id, 'name' => $m->name, 'status' => $m->approval_status]);
        
        $allPeriods = $newPeriods->concat($oldMonths);

        $query = PayrollComputationEntry::query();
        
        if (str_starts_with($this->selectedPeriodId, 'period_')) {
            $query->where('payroll_period_id', str_replace('period_', '', $this->selectedPeriodId));
        } elseif (str_starts_with($this->selectedPeriodId, 'month_')) {
            $query->where('payroll_month_id', str_replace('month_', '', $this->selectedPeriodId));
        }

        $entries = $query->when($this->search, function($q) {
                $q->where('employee_name', 'like', '%' . $this->search . '%')
                  ->orWhere('employee_code', 'like', '%' . $this->search . '%');
            })
            ->orderBy('employee_name')
            ->paginate(20);

        return view('livewire.payroll.payroll-computation-manager', [
            'periods' => $allPeriods,
            'entries' => $entries,
        ]);
    }
    private function isAdvancedPeriod()
    {
        if (!$this->selectedPeriodId) return false;
        
        $id = str_replace(['period_', 'month_'], '', $this->selectedPeriodId);
        
        if (str_starts_with($this->selectedPeriodId, 'period_')) {
            $period = PayrollPeriod::find($id);
        } else {
            $period = \App\Models\PayrollMonth::find($id);
        }
        
        if (!$period) return false;
        
        return Carbon::parse($period->end_date)->isFuture();
    }
}
