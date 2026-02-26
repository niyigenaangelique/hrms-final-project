<?php

namespace App\Livewire\Payroll;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Title('ZIBITECH | C-HRMS | Tax Calculator')]
class TaxCalculator extends Component
{
    public $grossSalary;
    public $payeRate = 30; // Default PAYE rate
    public $pensionRate = 5; // Default pension rate
    public $maternityRate = 1; // Default maternity rate
    public $cbhiRate = 1; // Default CBHI rate
    public $customDeductions = [];
    public $customBenefits = [];

    public $taxableIncome;
    public $payeAmount;
    public $pensionAmount;
    public $maternityAmount;
    public $cbhiAmount;
    public $totalDeductions;
    public $netSalary;

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
        $this->grossSalary = 0;
        $this->calculateTaxes();
    }

    public function updated($property)
    {
        if (in_array($property, ['grossSalary', 'payeRate', 'pensionRate', 'maternityRate', 'cbhiRate', 'customDeductions', 'customBenefits'])) {
            $this->calculateTaxes();
        }
    }

    public function calculateTaxes()
    {
        if (!$this->grossSalary) {
            $this->resetCalculations();
            return;
        }

        // Calculate statutory deductions
        $this->pensionAmount = ($this->grossSalary * $this->pensionRate) / 100;
        $this->maternityAmount = ($this->grossSalary * $this->maternityRate) / 100;
        $this->cbhiAmount = ($this->grossSalary * $this->cbhiRate) / 100;

        // Calculate total custom deductions
        $totalCustomDeductions = collect($this->customDeductions)->sum('amount');

        // Calculate taxable income (gross - pension - custom deductions)
        $this->taxableIncome = $this->grossSalary - $this->pensionAmount - $totalCustomDeductions;

        // Calculate PAYE on taxable income
        $this->payeAmount = ($this->taxableIncome * $this->payeRate) / 100;

        // Calculate total deductions
        $this->totalDeductions = $this->payeAmount + $this->pensionAmount + $this->maternityAmount + $this->cbhiAmount + $totalCustomDeductions;

        // Calculate total custom benefits
        $totalCustomBenefits = collect($this->customBenefits)->sum('amount');

        // Calculate net salary (taxable income - other taxes + benefits)
        $this->netSalary = $this->taxableIncome - $this->payeAmount - $this->maternityAmount - $this->cbhiAmount + $totalCustomBenefits;
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

    public function render()
    {
        return view('livewire.payroll.tax-calculator');
    }
}
