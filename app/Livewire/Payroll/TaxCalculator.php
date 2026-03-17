<?php

namespace App\Livewire\Payroll;

use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Title('ZIBITECH | C-HRMS | Tax Calculator')]
class TaxCalculator extends Component
{
    public $selectedEmployee;
    public $employees;
    public $grossSalary;
    public $payeRate = 30; // Default PAYE rate
    public $pensionRate = 5; // Default pension rate
    public $maternityRate = 1; // Default maternity rate
    public $cbhiRate = 1; // Default CBHI rate
    public $customDeductions = [];
    public $customBenefits = [];
    public $useRwandanTax = true; // Use Rwandan progressive tax by default

    public $taxableIncome;
    public $payeAmount;
    public $pensionAmount;
    public $maternityAmount;
    public $cbhiAmount;
    public $totalDeductions;
    public $netSalary;
    public $employerPensionContribution;

    #[Computed]
    public function formattedGrossSalary()
    {
        return number_format(is_numeric($this->grossSalary) ? (float) $this->grossSalary : 0, 2);
    }

    protected $rules = [
        'grossSalary' => 'required|numeric|min:0',
        'payeRate' => 'required|numeric|min:0|max:100',
        'pensionRate' => 'required|numeric|min:0|max:100',
        'maternityRate' => 'required|numeric|min:0|max:100',
        'cbhiRate' => 'required|numeric|min:0|max:100',
        'customDeductions.*.amount' => 'required|numeric|min:0',
        'customBenefits.*.amount' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->employees = Employee::where('approval_status', 'Approved')->get();
        $this->grossSalary = 0;
        $this->calculateTaxes();
    }

    public function updated($property)
    {
        if (in_array($property, ['selectedEmployee', 'grossSalary', 'payeRate', 'pensionRate', 'maternityRate', 'cbhiRate', 'customDeductions', 'customBenefits', 'useRwandanTax'])) {
            $this->calculateTaxes();
        }
    }

    public function updatedSelectedEmployee()
    {
        if ($this->selectedEmployee) {
            $employee = Employee::find($this->selectedEmployee);
            if ($employee && $employee->monthly_salary) {
                $this->grossSalary = (float) $employee->monthly_salary;
            } else {
                $this->grossSalary = 0;
            }
        } else {
            $this->grossSalary = 0;
        }
        $this->calculateTaxes();
    }

    public function calculateTaxes()
    {
        // Ensure grossSalary is a float
        $grossSalary = is_numeric($this->grossSalary) ? (float) $this->grossSalary : 0;
        
        if ($grossSalary <= 0) {
            $this->resetCalculations();
            return;
        }

        // Calculate statutory deductions
        $this->pensionAmount = ($grossSalary * $this->pensionRate) / 100;
        $this->maternityAmount = ($grossSalary * $this->maternityRate) / 100;
        $this->cbhiAmount = ($grossSalary * $this->cbhiRate) / 100;

        // Calculate total custom deductions
        $totalCustomDeductions = collect($this->customDeductions)->sum('amount');

        // Calculate taxable income (gross - pension - custom deductions)
        $this->taxableIncome = $grossSalary - $this->pensionAmount - $totalCustomDeductions;

        // Calculate PAYE based on selected method
        if ($this->useRwandanTax) {
            $this->payeAmount = $this->calculateRwandanPAYE($this->taxableIncome);
        } else {
            $this->payeAmount = ($this->taxableIncome * $this->payeRate) / 100;
        }

        // Calculate employer pension contribution (7%)
        $this->employerPensionContribution = ($grossSalary * 7) / 100;

        // Calculate total deductions
        $this->totalDeductions = $this->payeAmount + $this->pensionAmount + $this->maternityAmount + $this->cbhiAmount + $totalCustomDeductions;

        // Calculate total custom benefits
        $totalCustomBenefits = collect($this->customBenefits)->sum('amount');

        // Calculate net salary (taxable income - other taxes + benefits)
        $this->netSalary = $this->taxableIncome - $this->payeAmount - $this->maternityAmount - $this->cbhiAmount + $totalCustomBenefits;
    }

    private function calculateRwandanPAYE($taxableIncome)
    {
        // Rwandan PAYE calculation (progressive rates)
        // These are the current Rwandan tax brackets (simplified for demonstration)
        if ($taxableIncome <= 30000) {
            return 0;
        } elseif ($taxableIncome <= 100000) {
            return $taxableIncome * 0.20;
        } elseif ($taxableIncome <= 500000) {
            return 20000 + (($taxableIncome - 100000) * 0.30);
        } else {
            return 140000 + (($taxableIncome - 500000) * 0.35);
        }
    }

    private function resetCalculations()
    {
        $this->taxableIncome = 0;
        $this->payeAmount = 0;
        $this->pensionAmount = 0;
        $this->maternityAmount = 0;
        $this->cbhiAmount = 0;
        $this->totalDeductions = 0;
        $this->netSalary = 0;
        $this->employerPensionContribution = 0;
    }

    public function addCustomDeduction()
    {
        $this->customDeductions[] = ['name' => '', 'amount' => 0];
    }

    public function removeCustomDeduction($index)
    {
        unset($this->customDeductions[$index]);
        $this->customDeductions = array_values($this->customDeductions);
        $this->calculateTaxes();
    }

    public function addCustomBenefit()
    {
        $this->customBenefits[] = ['name' => '', 'amount' => 0];
    }

    public function removeCustomBenefit($index)
    {
        unset($this->customBenefits[$index]);
        $this->customBenefits = array_values($this->customBenefits);
        $this->calculateTaxes();
    }

    public function calculateForAllEmployees()
    {
        $results = [];
        
        foreach ($this->employees as $employee) {
            if ($employee->monthly_salary && is_numeric($employee->monthly_salary)) {
                $grossSalary = (float) $employee->monthly_salary;
                
                // Calculate deductions for this employee
                $pensionAmount = ($grossSalary * $this->pensionRate) / 100;
                $maternityAmount = ($grossSalary * $this->maternityRate) / 100;
                $cbhiAmount = ($grossSalary * $this->cbhiRate) / 100;
                
                $taxableIncome = $grossSalary - $pensionAmount;
                
                if ($this->useRwandanTax) {
                    $payeAmount = $this->calculateRwandanPAYE($taxableIncome);
                } else {
                    $payeAmount = ($taxableIncome * $this->payeRate) / 100;
                }
                
                $totalDeductions = $payeAmount + $pensionAmount + $maternityAmount + $cbhiAmount;
                $netSalary = $taxableIncome - $payeAmount - $maternityAmount - $cbhiAmount;
                $employerPension = ($grossSalary * 7) / 100;
                
                $results[] = [
                    'employee' => $employee,
                    'gross_salary' => $grossSalary,
                    'taxable_income' => $taxableIncome,
                    'paye_amount' => $payeAmount,
                    'pension_amount' => $pensionAmount,
                    'maternity_amount' => $maternityAmount,
                    'cbhi_amount' => $cbhiAmount,
                    'total_deductions' => $totalDeductions,
                    'net_salary' => $netSalary,
                    'employer_pension' => $employerPension,
                    'effective_rate' => $grossSalary > 0 ? ($totalDeductions / $grossSalary) * 100 : 0,
                ];
            }
        }
        
        return $results;
    }

    public function render()
    {
        return view('livewire.payroll.tax-calculator');
    }
}
