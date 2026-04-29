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
        $this->employee = Employee::where('user_id', $user->id)
            ->with(['positionAssignment', 'departmentAssignment'])
            ->first();

        if (!$this->employee) {
            // Smart Link: Check by email
            $this->employee = Employee::where('email', $user->email)
                ->with(['positionAssignment', 'departmentAssignment'])
                ->first();
                
            if ($this->employee) {
                $this->employee->update(['user_id' => $user->id]);
            } else {
                // Get the highest existing employee code with EMP prefix
                $lastEmployee = Employee::where('code', 'like', 'EMP-%')
                    ->orderBy('code', 'desc')
                    ->first();
                $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -3)) : 0;
                $newCode = 'EMP-' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);
                
                // Check if the code already exists to avoid duplicates
                while (Employee::where('code', $newCode)->exists()) {
                    $lastCode++;
                    $newCode = 'EMP-' . str_pad($lastCode, 3, '0', STR_PAD_LEFT);
                }
                
                $this->employee = Employee::create([
                    'code' => $newCode,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'user_id' => $user->id,
                    'approval_status' => \App\Enum\ApprovalStatus::Approved,
                ]);
            }
        }

        $this->selectedMonth = now()->format('Y-m');
        $this->loadPayrollData();
    }

    public function loadPayrollData()
    {
        // Load latest computation entries for the employee (excluding future periods)
        $this->payrollEntries = \App\Models\PayrollComputationEntry::where('employee_id', $this->employee->id)
            ->where(function($q) {
                $q->whereHas('payrollPeriod', function($sq) {
                    $sq->where('end_date', '<=', now());
                })->orWhereHas('payrollMonth', function($sq) {
                    // Assuming legacy months are in the past or check date if needed
                })->orWhere(function($sq) {
                    $sq->whereNull('payroll_period_id')->whereNull('payroll_month_id');
                });
            })
            ->with(['payrollPeriod', 'payrollMonth', 'employee', 'payslipEntry'])
            ->latest()
            ->take(12)
            ->get();

        // Get the latest computation entry for the current display
        $this->currentPayrollEntry = $this->payrollEntries->first();

        if ($this->currentPayrollEntry) {
            $this->calculateTotals();
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

        $this->totalDeductions = $this->currentPayrollEntry->total_deductions;
        $this->totalBenefits = $this->currentPayrollEntry->house_allowance + $this->currentPayrollEntry->transport_allowance + $this->currentPayrollEntry->other_allowances;
        $this->netPay = $this->currentPayrollEntry->net_pay;
    }

    public function formatCurrency($amount)
    {
        return number_format($amount, 2);
    }

    public function selectEntry($entryId)
    {
        $this->currentPayrollEntry = \App\Models\PayrollComputationEntry::find($entryId);
        if ($this->currentPayrollEntry) {
            $this->calculateTotals();
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Viewing details for ' . $this->currentPayrollEntry->period_name]);
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-payroll')
            ->layout('components.layouts.employee');
    }
}
