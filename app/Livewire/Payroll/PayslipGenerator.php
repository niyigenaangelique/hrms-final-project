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

        // Calculate deductions based on Tanzanian tax rates
        $grossPay = $payrollEntry->total_amount;
        $paye = $this->calculatePAYE($grossPay);
        $pension = $grossPay * 0.05; // 5% employee pension
        $maternity = $grossPay * 0.01; // 1% maternity fund
        $cbhi = $grossPay * 0.01; // 1% CBHI
        $employerContribution = $grossPay * 0.07; // 7% employer contribution
        $netPay = $grossPay - $paye - $pension - $maternity - $cbhi;

        // Create or update payslip entry
        $payslipEntry = PayslipEntry::updateOrCreate(
            ['payroll_entry_id' => $payrollEntryId],
            [
                'code' => 'PS-' . strtoupper(uniqid()),
                'gross_pay' => $grossPay,
                'paye' => $paye,
                'pension' => $pension,
                'maternity' => $maternity,
                'cbhi' => $cbhi,
                'employer_contribution' => $employerContribution,
                'net_pay' => $netPay,
                'status' => 'generated',
                'created_by' => auth()->id(),
            ]
        );

        session()->flash('success', 'Payslip generated successfully for ' . $payrollEntry->employee->first_name . ' ' . $payrollEntry->employee->last_name);
        $this->loadPayrollEntries();
    }

    private function calculatePAYE($grossPay)
    {
        // Simplified Tanzanian PAYE calculation (for demonstration)
        if ($grossPay <= 170000) {
            return 0;
        } elseif ($grossPay <= 360000) {
            return ($grossPay - 170000) * 0.09;
        } elseif ($grossPay <= 540000) {
            return 17100 + (($grossPay - 360000) * 0.20);
        } elseif ($grossPay <= 720000) {
            return 53100 + (($grossPay - 540000) * 0.25);
        } else {
            return 98100 + (($grossPay - 720000) * 0.30);
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
