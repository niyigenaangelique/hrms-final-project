<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\PayslipEntry;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Payslip Generator')]
class PayslipGenerator extends Component
{
    public $selectedPayrollMonth;
    public $selectedEmployee;
    public $payrollEntries;
    public $employees;
    public $payrollMonths;
    public $payslipData;
    public $showPreview = false;
    public $search = '';

    public function mount()
    {
        $this->employees = Employee::where('approval_status', 'Approved')->get();
        $this->payrollMonths = PayrollMonth::orderBy('start_date', 'desc')->get();
        $this->loadPayrollEntries();
    }

    public function loadPayrollEntries()
    {
        $query = PayrollEntry::with(['employee', 'payrollMonth', 'payslipEntry']);

        if ($this->selectedPayrollMonth) {
            $query->where('payroll_month_id', $this->selectedPayrollMonth);
        }

        if ($this->selectedEmployee) {
            $query->where('employee_id', $this->selectedEmployee);
        }

        if ($this->search) {
            $query->whereHas('employee', function ($subQuery) {
                $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                       ->orWhere('last_name', 'like', '%' . $this->search . '%')
                       ->orWhere('employee_number', 'like', '%' . $this->search . '%');
            });
        }

        $this->payrollEntries = $query->orderBy('created_at', 'desc')->get();
    }

    public function updatedSelectedPayrollMonth()
    {
        $this->loadPayrollEntries();
    }

    public function updatedSelectedEmployee()
    {
        $this->loadPayrollEntries();
    }

    public function updatedSearch()
    {
        $this->loadPayrollEntries();
    }

    public function generatePayslip($payrollEntryId)
    {
        $payrollEntry = PayrollEntry::with(['employee', 'payrollMonth', 'payslipEntry'])->find($payrollEntryId);
        
        if (!$payrollEntry) {
            session()->flash('error', 'Payroll entry not found');
            return;
        }

        // Use individual employee tax calculation approach
        $grossPay = $payrollEntry->total_amount;
        
        // Get employee-specific tax settings (could be stored in employee preferences)
        $employee = $payrollEntry->employee;
        
        // Calculate statutory deductions using Rwandan tax rates
        $pension = $grossPay * 0.05; // 5% employee pension
        $maternity = $grossPay * 0.01; // 1% maternity fund
        $cbhi = $grossPay * 0.01; // 1% CBHI
        
        // Calculate taxable income (gross - pension)
        $taxableIncome = $grossPay - $pension;
        
        // Apply Rwandan progressive tax
        $paye = $this->calculateRwandanPAYE($taxableIncome);
        
        // Calculate employer contribution
        $employerContribution = $grossPay * 0.07; // 7% employer contribution
        
        // Calculate net pay
        $netPay = $taxableIncome - $paye - $maternity - $cbhi;
        
        // Create or update payslip entry with detailed breakdown
        $payslipEntry = PayslipEntry::updateOrCreate(
            ['payroll_entry_id' => $payrollEntryId],
            [
                'code' => 'PS-' . strtoupper(uniqid()),
                'gross_pay' => $grossPay,
                'taxable_income' => $taxableIncome, // Added for transparency
                'paye' => $paye,
                'pension' => $pension,
                'maternity' => $maternity,
                'cbhi' => $cbhi,
                'employer_contribution' => $employerContribution,
                'net_pay' => $netPay,
                'status' => 'Generated',
                'created_by' => auth()->id(),
                // Add calculation metadata
                'tax_bracket_used' => $this->getTaxBracket($taxableIncome),
                'effective_tax_rate' => $grossPay > 0 ? ($paye / $grossPay) * 100 : 0,
            ]
        );

        session()->flash('success', 'Payslip generated successfully for ' . $payrollEntry->employee->first_name . ' ' . $payrollEntry->employee->last_name . ' (Tax Rate: ' . number_format(($paye / $grossPay) * 100, 1) . '%)');
        $this->loadPayrollEntries();
    }

    private function calculateRwandanPAYE($grossPay)
    {
        // Rwandan PAYE calculation (progressive rates)
        if ($grossPay <= 30000) {
            return 0;
        } elseif ($grossPay <= 100000) {
            return $grossPay * 0.20;
        } elseif ($grossPay <= 500000) {
            return 20000 + (($grossPay - 100000) * 0.30);
        } else {
            return 140000 + (($grossPay - 500000) * 0.35);
        }
    }

    private function getTaxBracket($taxableIncome)
    {
        if ($taxableIncome <= 30000) {
            return '0% (Up to 30,000)';
        } elseif ($taxableIncome <= 100000) {
            return '20% (30,001 - 100,000)';
        } elseif ($taxableIncome <= 500000) {
            return '30% (100,001 - 500,000)';
        } else {
            return '35% (Above 500,000)';
        }
    }

    public function previewPayslip($payrollEntryId)
    {
        $payrollEntry = PayrollEntry::with(['employee', 'payrollMonth', 'payslipEntry'])->find($payrollEntryId);
        
        if (!$payrollEntry || !$payrollEntry->payslipEntry) {
            session()->flash('error', 'Payslip not found. Please generate payslip first.');
            return;
        }

        $this->payslipData = $payrollEntry;
        $this->showPreview = true;
    }

    public function downloadPayslip($payrollEntryId)
    {
        $payrollEntry = PayrollEntry::with(['employee', 'payrollMonth', 'payslipEntry'])->find($payrollEntryId);
        
        if (!$payrollEntry || !$payrollEntry->payslipEntry) {
            session()->flash('error', 'Payslip not found. Please generate payslip first.');
            return;
        }

        try {
            $pdf = PDF::loadView('livewire.payroll.payslip-pdf', ['payrollEntry' => $payrollEntry]);
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'payslip-' . $payrollEntry->employee->employee_number . '-' . $payrollEntry->payrollMonth->name . '.pdf');
        } catch (\Exception $e) {
            session()->flash('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    public function bulkGeneratePayslips()
    {
        $entries = $this->payrollEntries->where('payslipEntry', null);
        
        if ($entries->count() === 0) {
            session()->flash('info', 'No payslips to generate. All entries already have payslips.');
            return;
        }

        foreach ($entries as $entry) {
            $this->generatePayslip($entry->id);
        }

        session()->flash('success', 'Bulk payslip generation completed. ' . $entries->count() . ' payslips generated.');
    }

    public function bulkDownloadPayslips()
    {
        $entries = $this->payrollEntries->whereNotNull('payslipEntry');
        
        if ($entries->count() === 0) {
            session()->flash('error', 'No payslips available for download.');
            return;
        }

        session()->flash('info', 'Bulk download feature coming soon. Please download payslips individually for now.');
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->payslipData = null;
    }

    public function render()
    {
        return view('livewire.payroll.payslip-generator')
            ->layout('components.layouts.app');
    }
}
