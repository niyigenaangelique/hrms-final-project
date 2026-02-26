<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\DeductionEntry;
use App\Models\BenefitEntry;
use App\Models\PayslipEntry;
use App\Models\LeaveBalance;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | My Payroll')]
class EmployeePayroll extends Component
{
    public $employee;
    public $payrollEntries;
    public $currentPayrollEntry;
    public $selectedMonth;
    public $leaveBalances;
    public $recentAttendances;
    public $totalDeductions = 0;
    public $totalBenefits = 0;
    public $netPay = 0;

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('email', $user->email)->first();
        
        if (!$this->employee) {
            // Get the highest existing employee code number
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            $this->employee = Employee::create([
                'code' => $newCode,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ]);
        }

        $this->selectedMonth = now()->format('Y-m');
        $this->loadPayrollData();
    }

    public function loadPayrollData()
    {
        // Load payroll entries for the employee
        $this->payrollEntries = PayrollEntry::where('employee_id', $this->employee->id)
            ->with(['payrollMonth', 'deductionEntries.deduction', 'benefitEntries.benefit', 'payslipEntry'])
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        // Get current month payroll entry
        $currentMonth = PayrollMonth::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        if ($currentMonth) {
            $this->currentPayrollEntry = PayrollEntry::where('employee_id', $this->employee->id)
                ->where('payroll_month_id', $currentMonth->id)
                ->with(['deductionEntries.deduction', 'benefitEntries.benefit', 'payslipEntry'])
                ->first();

            if ($this->currentPayrollEntry) {
                $this->calculateTotals();
            }
        }

        // Load leave balances
        $this->leaveBalances = LeaveBalance::where('employee_id', $this->employee->id)->get();

        // Load recent attendances (last 30 days)
        $this->recentAttendances = Attendance::where('employee_id', $this->employee->id)
            ->where('date', '>=', now()->subDays(30))
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
    }

    public function calculateTotals()
    {
        if (!$this->currentPayrollEntry) return;

        $this->totalDeductions = $this->currentPayrollEntry->deductionEntries->sum('amount');
        $this->totalBenefits = $this->currentPayrollEntry->benefitEntries->sum('amount');
        
        $grossPay = $this->currentPayrollEntry->work_days_pay + $this->currentPayrollEntry->overtime_total_amount;
        $this->netPay = $grossPay - $this->totalDeductions + $this->totalBenefits;
    }

    public function formatCurrency($amount)
    {
        return number_format($amount, 2);
    }

    public function render()
    {
        return view('livewire.employee.employee-payroll')
            ->layout('components.layouts.employee');
    }
}
