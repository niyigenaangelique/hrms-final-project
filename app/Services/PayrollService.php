<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\PayrollPeriod;
use App\Models\PayrollEntry;
use App\Models\TaxBracket;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollService
{
    private $settings = [];
    
    public function __construct()
    {
        $this->loadSettings();
    }
    
    private function loadSettings()
    {
        $settings = DB::table('payroll_settings')->pluck('value', 'key');
        $this->settings = $settings->toArray();
    }
    
    /**
     * Create a new payroll period
     */
    public function createPayrollPeriod(string $name, Carbon $startDate, Carbon $endDate): PayrollPeriod
    {
        return PayrollPeriod::create([
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'draft',
            'created_by' => auth()->id() ?? null,
        ]);
    }
    
    /**
     * Run payroll for a specific period
     */
    public function runPayroll(PayrollPeriod $period): array
    {
        Log::info("Starting payroll for period: {$period->name}");
        
        $period->update(['status' => 'processing']);
        
        $employees = Employee::with(['departmentAssignment', 'position', 'attendances', 'leaveRequests'])
            ->where('is_active', true)
            ->get();
            
        $totalGross = 0;
        $totalNet = 0;
        $totalDeductions = 0;
        $processedEmployees = 0;
        
        foreach ($employees as $employee) {
            try {
                $payrollData = $this->calculateEmployeePayroll($employee, $period);
                
                // Create or update payroll entry
                PayrollEntry::updateOrCreate(
                    [
                        'payroll_period_id' => $period->id,
                        'employee_id' => $employee->id,
                    ],
                    $payrollData
                );
                
                $totalGross += $payrollData['gross_pay'];
                $totalNet += $payrollData['net_pay'];
                $totalDeductions += $payrollData['total_deductions'];
                $processedEmployees++;
                
                Log::info("Processed payroll for employee: {$employee->full_name}");
                
            } catch (\Exception $e) {
                Log::error("Error processing payroll for employee {$employee->id}: " . $e->getMessage());
            }
        }
        
        // Update period totals
        $period->update([
            'total_gross_pay' => $totalGross,
            'total_net_pay' => $totalNet,
            'total_deductions' => $totalDeductions,
            'status' => 'draft', // Ready for review
        ]);
        
        return [
            'processed_employees' => $processedEmployees,
            'total_gross' => $totalGross,
            'total_net' => $totalNet,
            'total_deductions' => $totalDeductions,
        ];
    }
    
    /**
     * Calculate payroll for a single employee
     */
    public function calculateEmployeePayroll(Employee $employee, PayrollPeriod $period): array
    {
        $startDate = Carbon::parse($period->start_date);
        $endDate = Carbon::parse($period->end_date);
        
        // 1. Get attendance data for the period
        $attendanceData = $this->getAttendanceData($employee, $startDate, $endDate);
        
        // 2. Get leave data for the period
        $leaveData = $this->getLeaveData($employee, $startDate, $endDate);
        
        // 3. Calculate basic salary and allowances
        $basicSalary = $employee->basic_salary ?? 0;
        $dailyRate = $this->calculateDailyRate($basicSalary, $attendanceData['working_days']);
        
        // 4. Calculate earnings
        $earnings = $this->calculateEarnings($employee, $attendanceData, $dailyRate);
        
        // 5. Calculate deductions
        $deductions = $this->calculateDeductions($employee, $attendanceData, $leaveData, $dailyRate, $earnings['gross']);
        
        // 6. Calculate net pay
        $netPay = $earnings['gross'] - $deductions['total'];
        
        return array_merge([
            // Employee info
            'payroll_period_id' => $period->id,
            'employee_id' => $employee->id,
            'employee_code' => $employee->code,
            'employee_name' => $employee->full_name,
            'employee_department' => $employee->departmentAssignment->name ?? null,
            'employee_position' => $employee->position->name ?? null,
            'bank_account' => $employee->bank_account_number ?? null,
            'bank_name' => $employee->bank_name ?? null,
            
            // Attendance data
            'working_days' => $attendanceData['working_days'],
            'present_days' => $attendanceData['present_days'],
            'leave_days' => $attendanceData['leave_days'],
            'holiday_days' => $attendanceData['holiday_days'],
            'weekend_days' => $attendanceData['weekend_days'],
        ], $earnings, $deductions, ['net_pay' => $netPay]);
    }
    
    /**
     * Get attendance data for an employee in a period
     */
    private function getAttendanceData(Employee $employee, Carbon $startDate, Carbon $endDate): array
    {
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();
            
        $workingDays = 0;
        $presentDays = 0;
        $leaveDays = 0;
        $holidayDays = 0;
        $weekendDays = 0;
        $totalOvertimeMinutes = 0;
        $totalLateMinutes = 0;
        
        // Get holidays for this period
        $holidays = Holiday::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->pluck('date')
            ->toArray();
        
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dayOfWeek = $current->dayOfWeek; // 0 = Sunday, 6 = Saturday
            
            // Skip weekends for working days calculation
            if ($dayOfWeek >= 6) { // Saturday or Sunday
                $weekendDays++;
            } elseif (in_array($current->format('Y-m-d'), $holidays)) {
                $holidayDays++;
            } else {
                $workingDays++;
                
                // Check if employee was present
                $attendance = $attendances->firstWhere('date', $current->format('Y-m-d'));
                if ($attendance && in_array($attendance->status->value, ['Entered', 'Approved'])) {
                    $presentDays++;
                    $totalOvertimeMinutes += $attendance->overtime_minutes ?? 0;
                    $totalLateMinutes += $attendance->late_minutes ?? 0;
                }
            }
            
            $current->addDay();
        }
        
        return [
            'working_days' => $workingDays,
            'present_days' => $presentDays,
            'leave_days' => $leaveDays,
            'holiday_days' => $holidayDays,
            'weekend_days' => $weekendDays,
            'overtime_minutes' => $totalOvertimeMinutes,
            'late_minutes' => $totalLateMinutes,
        ];
    }
    
    /**
     * Get leave data for an employee in a period
     */
    private function getLeaveData(Employee $employee, Carbon $startDate, Carbon $endDate): array
    {
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', \App\Enum\LeaveStatus::APPROVED)
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->where(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->with('leaveType')
            ->get();
            
        $unpaidLeaveDays = 0;
        $paidLeaveDays = 0;
        
        foreach ($leaveRequests as $leave) {
            $leaveStart = Carbon::parse($leave->start_date);
            $leaveEnd = Carbon::parse($leave->end_date);
            
            // Calculate overlap with payroll period
            $overlapStart = max($leaveStart, $startDate);
            $overlapEnd = min($leaveEnd, $endDate);
            
            if ($overlapStart <= $overlapEnd) {
                $days = $overlapStart->diffInDays($overlapEnd) + 1;
                
                if ($leave->leaveType && $leave->leaveType->name === 'Unpaid') {
                    $unpaidLeaveDays += $days;
                } else {
                    $paidLeaveDays += $days;
                }
            }
        }
        
        return [
            'unpaid_leave_days' => $unpaidLeaveDays,
            'paid_leave_days' => $paidLeaveDays,
        ];
    }
    
    /**
     * Calculate daily rate from basic salary
     */
    private function calculateDailyRate(float $basicSalary, int $workingDays): float
    {
        if ($workingDays <= 0) return 0;
        return $basicSalary / $workingDays;
    }
    
    /**
     * Calculate earnings
     */
    private function calculateEarnings(Employee $employee, array $attendanceData, float $dailyRate): array
    {
        $basicSalary = $employee->basic_salary ?? 0;
        
        // Allowances (can be configured per employee or department)
        $houseAllowance = $employee->house_allowance ?? 0;
        $transportAllowance = $employee->transport_allowance ?? 0;
        
        // Overtime calculation
        $overtimeHours = min($attendanceData['overtime_minutes'] / 60, $this->settings['max_ot_hours_per_week']);
        $overtimeRate = floatval($this->settings['overtime_rate'] ?? 1.5);
        $hourlyRate = $basicSalary / (22 * 8); // Assuming 22 working days, 8 hours per day
        $overtimePay = $overtimeHours * $hourlyRate * $overtimeRate;
        
        $gross = $basicSalary + $houseAllowance + $transportAllowance + $overtimePay;
        
        return [
            'basic_salary' => $basicSalary,
            'house_allowance' => $houseAllowance,
            'transport_allowance' => $transportAllowance,
            'overtime_hours' => $overtimeHours,
            'overtime_pay' => $overtimePay,
            'holiday_ot_hours' => 0, // TODO: Implement holiday overtime
            'holiday_ot_pay' => 0,
            'bonus' => 0, // TODO: Implement bonus system
            'other_earnings' => 0,
            'gross_pay' => $gross,
        ];
    }
    
    /**
     * Calculate deductions
     */
    private function calculateDeductions(Employee $employee, array $attendanceData, array $leaveData, float $dailyRate, float $grossPay): array
    {
        // Unpaid leave deduction
        $unpaidLeaveDays = $leaveData['unpaid_leave_days'];
        $unpaidLeaveDeduction = $unpaidLeaveDays * $dailyRate;
        
        // Late deductions (if any policy)
        $lateDeductions = 0; // TODO: Implement late deduction policy
        
        // Statutory deductions
        $rssbEmployee = $grossPay * floatval($this->settings['rssb_employee_rate'] ?? 0.03);
        $rssbEmployer = $grossPay * floatval($this->settings['rssb_employer_rate'] ?? 0.05);
        $cbhi = $grossPay * floatval($this->settings['cbhi_rate'] ?? 0.045);
        $maternity = $grossPay * floatval($this->settings['maternity_rate'] ?? 0.003);
        
        // PAYE Tax calculation
        $payeTax = $this->calculatePAYETax($grossPay - $rssbEmployee - $cbhi - $maternity);
        
        // Other deductions (loans, etc.)
        $loanDeduction = 0; // TODO: Implement loan system
        $otherDeductions = 0;
        
        $totalDeductions = $unpaidLeaveDeduction + $lateDeductions + $rssbEmployee + $payeTax + $cbhi + $maternity + $loanDeduction + $otherDeductions;
        
        return [
            'unpaid_leave_days' => $unpaidLeaveDays,
            'unpaid_leave_deduction' => $unpaidLeaveDeduction,
            'late_deductions' => $lateDeductions,
            'rssb_employee' => $rssbEmployee,
            'rssb_employer' => $rssbEmployer,
            'paye_tax' => $payeTax,
            'cbhi' => $cbhi,
            'maternity_fund' => $maternity,
            'loan_deduction' => $loanDeduction,
            'other_deductions' => $otherDeductions,
            'total_deductions' => $totalDeductions,
        ];
    }
    
    /**
     * Calculate PAYE tax using Rwanda tax brackets
     */
    private function calculatePAYETax(float $taxableIncome): float
    {
        $taxBrackets = TaxBracket::where('is_active', true)
            ->orderBy('min_income')
            ->get();
            
        $tax = 0;
        
        foreach ($taxBrackets as $bracket) {
            if ($taxableIncome > $bracket->min_income) {
                if ($bracket->max_income === null || $taxableIncome <= $bracket->max_income) {
                    $tax += ($taxableIncome - $bracket->min_income) * $bracket->rate + $bracket->fixed_amount;
                } else {
                    $tax += ($bracket->max_income - $bracket->min_income) * $bracket->rate + $bracket->fixed_amount;
                }
            }
        }
        
        return $tax;
    }
    
    /**
     * Lock payroll period (prevents further edits)
     */
    public function lockPayrollPeriod(PayrollPeriod $period): bool
    {
        if ($period->status !== 'approved') {
            throw new \Exception('Payroll period must be approved before locking');
        }
        
        $period->update([
            'status' => 'locked',
            'locked_at' => now(),
        ]);
        
        return true;
    }
    
    /**
     * Get payroll analytics
     */
    public function getPayrollAnalytics(): array
    {
        // TODO: Implement analytics methods
        return [
            'total_payroll_cost_trend' => [],
            'payroll_by_department' => [],
            'ot_cost_comparison' => [],
            'statutory_vs_net_ratio' => [],
        ];
    }
}
