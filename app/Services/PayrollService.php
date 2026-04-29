<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\PayrollPeriod;
use App\Models\PayrollComputationEntry;
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
     * Run payroll for a specific period or month
     */
    public function runPayroll($period): array
    {
        Log::info("Starting payroll for period: {$period->name}");
        
        if ($period instanceof PayrollPeriod) {
            $period->update(['status' => 'processing']);
        }
        
        $employees = Employee::with(['department', 'positionAssignment', 'attendances', 'leaveRequests'])
            ->where('is_active', true)
            ->get();
            
        $totalGross = 0;
        $totalNet = 0;
        $totalDeductions = 0;
        $processedEmployees = 0;
        
        foreach ($employees as $employee) {
            try {
                // Fetch existing entry to preserve manual overrides
                $existingEntry = PayrollComputationEntry::where('employee_id', $employee->id)
                    ->where(function($q) use ($period) {
                        if ($period instanceof \App\Models\PayrollMonth) {
                            $q->where('payroll_month_id', $period->id);
                        } else {
                            $q->where('payroll_period_id', $period->id);
                        }
                    })->first();

                $overrides = [];
                if ($existingEntry) {
                    $overrides = [
                        'basic_salary' => $existingEntry->basic_salary,
                        'house_allowance' => $existingEntry->house_allowance,
                        'transport_allowance' => $existingEntry->transport_allowance,
                        'other_allowances' => $existingEntry->other_allowances,
                        'salary_advance' => $existingEntry->salary_advance,
                    ];
                }

                $payrollData = $this->calculateEmployeePayroll($employee, $period, $overrides);
                
                // Create or update payroll computation entry
                $searchCriteria = ['employee_id' => $employee->id];
                
                // Check if this is a PayrollPeriod or PayrollMonth
                if ($period instanceof \App\Models\PayrollMonth) {
                    $searchCriteria['payroll_month_id'] = $period->id;
                } else {
                    $searchCriteria['payroll_period_id'] = $period->id;
                }

                PayrollComputationEntry::updateOrCreate($searchCriteria, $payrollData);
                
                $totalGross += $payrollData['gross_pay'];
                $totalNet += $payrollData['net_pay'];
                $totalDeductions += $payrollData['total_deductions'];
                $processedEmployees++;
                
                Log::info("Processed payroll for employee: {$employee->full_name}");
                
            } catch (\Exception $e) {
                Log::error("Error processing payroll for employee {$employee->id}: " . $e->getMessage());
            }
        }
        
        // Update totals if it's a model in the DB
        if ($period->exists) {
            $period->update([
                'total_gross_pay' => $totalGross,
                'total_net_pay' => $totalNet,
                'total_deductions' => $totalDeductions,
                'status' => 'draft',
            ]);
        }
        
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
    public function calculateEmployeePayroll(Employee $employee, $period, array $overrides = []): array
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
        $earnings = $this->calculateEarnings($employee, $attendanceData, $dailyRate, $overrides);
        
        // 5. Calculate deductions
        $deductions = $this->calculateDeductions($employee, $attendanceData, $leaveData, $dailyRate, $earnings['gross_pay'], $overrides);
        
        // 6. Calculate net pay
        $netPay = $earnings['gross_pay'] - $deductions['total_deductions'];
        
        $result = [
            // Employee info
            'employee_id' => $employee->id,
            'employee_code' => $employee->code,
            'employee_name' => $employee->full_name,
            'nationality' => $employee->nationality ?? 'Rwandan',
            'department' => $employee->departmentAssignment->name ?? null,
            'position' => $employee->positionAssignment->name ?? null,
            'bank_account' => $employee->bank_account_number ?? null,
            'bank_name' => $employee->bank_name ?? null,
        ];

        $netBeforeCBHI = $earnings['gross_pay'] - ($deductions['total_deductions'] - $deductions['cbhi']);

        // Assign the ID to the correct column
        if ($period instanceof \App\Models\PayrollMonth) {
            $result['payroll_month_id'] = $period->id;
        } else {
            $result['payroll_period_id'] = $period->id;
        }

        return array_merge($result, [
            'working_days' => $attendanceData['working_days'],
            'present_days' => $attendanceData['present_days'],
            'absent_days' => $attendanceData['absent_days'],
            'leave_days' => $attendanceData['leave_days'],
            'total_late_minutes' => $attendanceData['total_late_minutes'],
            'total_ot_minutes' => $attendanceData['total_ot_minutes'],
        ], $earnings, $deductions, [
            'net_before_cbhi' => $netBeforeCBHI,
            'net_pay' => $netPay,
            'salary_advance' => 0,
        ]);
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
        Log::info("Calculating attendance for {$employee->full_name} from {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}");
        
        $holidays = Holiday::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->pluck('date')
            ->toArray();
        
        // FIX: Pre-build a date-string => Attendance map.
        // The 'date' column is cast to Carbon in the model, so collection->firstWhere('date', 'Y-m-d')
        // always returns null (Carbon object !== string). Keying by formatted string fixes this.
        $attendanceMap = [];
        foreach ($attendances as $att) {
            $key = ($att->date instanceof \Carbon\Carbon)
                ? $att->date->format('Y-m-d')
                : \Carbon\Carbon::parse($att->date)->format('Y-m-d');
            $attendanceMap[$key] = $att;
        }

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dayOfWeek = $current->dayOfWeek;
            $dateStr   = $current->format('Y-m-d');

            $isHoliday = in_array($dateStr, $holidays);
            $isWeekend = ($dayOfWeek === 0 || $dayOfWeek === 6);

            if ($isWeekend) {
                $weekendDays++;
                $presentDays++; // Paid weekend
            } elseif ($isHoliday) {
                $holidayDays++;
                $workingDays++;
                $presentDays++; // Paid holiday
            } else {
                $workingDays++; // Only real weekdays count

                // Check for leave overlap
                $isOnLeave = LeaveRequest::where('employee_id', $employee->id)
                    ->where('status', \App\Enum\LeaveStatus::APPROVED)
                    ->where('start_date', '<=', $dateStr)
                    ->where('end_date', '>=', $dateStr)
                    ->first();

                if ($isOnLeave) {
                    $leaveDays++;
                    if ($isOnLeave->leaveType && $isOnLeave->leaveType->name !== 'Unpaid') {
                        $presentDays++;
                    }
                } else {
                    // Use the pre-built map — no more Carbon vs string mismatch
                    $attendance = $attendanceMap[$dateStr] ?? null;

                    $deptName = $employee->department->name ?? '';
                    $empCode  = strtoupper($employee->code);
                    $isExempt = (str_contains($deptName, 'Resources') || str_contains($deptName, 'Manager') ||
                                 str_contains($empCode, 'ADMIN') || str_contains($empCode, 'HR'));

                    if ($isExempt || ($attendance && in_array($this->enumVal($attendance->status), ['Entered', 'Approved']))) {
                        $presentDays++;
                        if ($attendance) {
                            $totalOvertimeMinutes += $attendance->overtime_minutes ?? 0;
                            $totalLateMinutes     += $attendance->late_minutes ?? 0;
                        }
                    }
                }
            }

            $current->addDay();
        }
        
        return [
            'working_days' => $workingDays,
            'present_days' => $presentDays,
            'absent_days' => $workingDays - $presentDays,
            'leave_days' => $leaveDays,
            'holiday_days' => $holidayDays,
            'weekend_days' => $weekendDays,
            'total_ot_minutes' => $totalOvertimeMinutes,
            'total_late_minutes' => $totalLateMinutes,
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
    private function calculateEarnings(Employee $employee, array $attendanceData, float $dailyRate, array $overrides = []): array
    {
        $basicSalary = $overrides['basic_salary'] ?? $employee->basic_salary ?? 0;
        
        // Allowances (prefers overrides from the matrix)
        $houseAllowance = $overrides['house_allowance'] ?? $employee->house_allowance ?? 0;
        $transportAllowance = $overrides['transport_allowance'] ?? $employee->transport_allowance ?? 0;
        $otherAllowances = $overrides['other_allowances'] ?? 0;
        
        // Overtime calculation
        $overtimeHours = $attendanceData['total_ot_minutes'] / 60;
        $overtimeRate = floatval($this->settings['overtime_rate'] ?? 1.5);
        $hourlyRate = $basicSalary / (22 * 8); // Assuming 22 working days, 8 hours per day
        $overtimePay = $overtimeHours * $hourlyRate * $overtimeRate;
        
        $allowancesTotal = $houseAllowance + $transportAllowance + $otherAllowances;
        $gross = $basicSalary + $allowancesTotal + $overtimePay;
        
        return [
            'basic_salary' => $basicSalary,
            'house_allowance' => $houseAllowance,
            'transport_allowance' => $transportAllowance,
            'other_allowances' => $otherAllowances,
            'allowances_total' => $allowancesTotal,
            'overtime_hours' => $overtimeHours,
            'overtime_pay' => $overtimePay,
            'holiday_ot_hours' => 0, 
            'holiday_ot_pay' => 0,
            'bonus' => 0, 
            'other_earnings' => 0,
            'gross_pay' => $gross,
        ];
    }
    
    /**
     * Calculate deductions
     */
    private function calculateDeductions(Employee $employee, array $attendanceData, array $leaveData, float $dailyRate, float $grossPay, array $overrides = []): array
    {
        // Absence and Unpaid leave deduction
        $unpaidLeaveDays = $leaveData['unpaid_leave_days'];
        $absentDays = $attendanceData['absent_days'];
        
        $absenceDeduction = ($unpaidLeaveDays + $absentDays) * $dailyRate;
        $unpaidLeaveDeduction = $absenceDeduction; 
        
        // Late deductions
        $lateDeductions = 0; 
        
        // Statutory deductions should be calculated on ACTUAL EARNED GROSS
        $actualGross = $grossPay - $absenceDeduction;
        if ($actualGross < 0) $actualGross = 0;

        $rssbEmployee = $actualGross * (floatval($this->settings['rssb_employee_rate'] ?? 3) / 100);
        $rssbEmployer = $actualGross * (floatval($this->settings['rssb_employer_rate'] ?? 5) / 100);
        $cbhi = $actualGross * (floatval($this->settings['cbhi_rate'] ?? 4.5) / 100);
        $maternity = $actualGross * (floatval($this->settings['maternity_rate'] ?? 0.3) / 100);
        
        // PAYE Tax calculation 
        $taxableIncome = $actualGross - $rssbEmployee - $cbhi - $maternity;
        $payeTax = $this->calculatePAYETax($taxableIncome);
        
        // Manual salary advance / loan override
        $salaryAdvance = $overrides['salary_advance'] ?? 0;
        $loanDeduction = 0; 
        $otherDeductions = 0;
        
        $totalDeductions = $absenceDeduction + $lateDeductions + $rssbEmployee + $payeTax + $cbhi + $maternity + $loanDeduction + $otherDeductions + $salaryAdvance;
        
        return [
            'unpaid_leave_days' => $unpaidLeaveDays,
            'unpaid_leave_deduction' => $unpaidLeaveDeduction,
            'late_deduction' => $lateDeductions,
            'rssb_employee' => $rssbEmployee,
            'rssb_employer' => $rssbEmployer,
            'paye_tax' => $payeTax,
            'cbhi' => $cbhi,
            'maternity_fund' => $maternity,
            'loan_deduction' => $loanDeduction,
            'salary_advance' => $salaryAdvance,
            'other_deductions' => $otherDeductions,
            'total_deductions' => $totalDeductions,
            'taxable_income' => $taxableIncome,
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
        ];
    }

    /**
     * Helper to get value from enum or string
     */
    private function enumVal(mixed $v): string
    {
        return $v instanceof \BackedEnum ? $v->value : (string) ($v ?? '');
    }
}
