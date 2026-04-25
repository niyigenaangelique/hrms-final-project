<?php

namespace App\Services;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Enum\LeaveStatus;
use App\Enum\ApprovalStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LeaveService
{
    /**
     * Validate leave request against company policies
     */
    public static function validateLeaveRequest(Employee $employee, LeaveType $leaveType, Carbon $startDate, Carbon $endDate, int $totalDays): array
    {
        $errors = [];
        $warnings = [];

        // Check gender restrictions
        if ($leaveType->gender_restriction) {
            if ($leaveType->gender_restriction === 'male' && strtolower($employee->gender) !== 'male') {
                $errors[] = 'This leave type is only available for male employees.';
            } elseif ($leaveType->gender_restriction === 'female' && strtolower($employee->gender) !== 'female') {
                $errors[] = 'This leave type is only available for female employees.';
            }
        }

        // Check if medical document is required
        if ($leaveType->requires_medical_document) {
            // This would be checked during file upload
            $warnings[] = 'Medical document is required for this leave type.';
        }

        // Check annual leave balance for vacation leaves
        if ($leaveType->deduct_from_annual) {
            $annualBalance = self::getLeaveBalance($employee, 'ANNUAL');
            if ($annualBalance < $totalDays) {
                $errors[] = "Insufficient annual leave balance. Available: {$annualBalance} days, Requested: {$totalDays} days.";
            }
        }

        // Check maximum days per year
        if ($leaveType->max_days_per_year) {
            $currentYear = Carbon::now()->year;
            $usedDays = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', LeaveStatus::APPROVED->value)
                ->whereYear('start_date', $currentYear)
                ->sum('total_days');

            $totalRequestedDays = $usedDays + $totalDays;
            if ($totalRequestedDays > $leaveType->max_days_per_year) {
                $errors[] = "This would exceed the maximum {$leaveType->max_days_per_year} days per year for {$leaveType->name}. Already used: {$usedDays} days.";
            }

            // Check for personal leave exceeding limit (warning)
            if ($leaveType->code === 'PERSONAL' && $totalRequestedDays > 10) {
                $warnings[] = "Personal leave is approaching the maximum limit. Currently used: {$usedDays} days, Requested: {$totalDays} days.";
            }
        }

        // Check maternity leave extension rules
        if ($leaveType->code === 'MATERNITY' && $totalDays > 45) {
            $warnings[] = "Maternity leave exceeds standard 45 days. Doctor's medical certificate required for extension.";
        }

        // Check paternity leave limit
        if ($leaveType->code === 'PATERNITY' && $totalDays > 7) {
            $errors[] = "Paternity leave cannot exceed 7 days.";
        }

        // --- Departmental Restriction: Only one person on Annual/Vacation/Personal at a time ---
        $restrictedTypes = ['annual', 'vacation', 'personal'];
        $exemptTypes     = ['sick', 'paternity', 'maternity', 'bereavement'];
        
        $currentTypeName = strtolower($leaveType->name);
        $isRestricted = false;
        foreach ($restrictedTypes as $rt) {
            if (str_contains($currentTypeName, $rt)) {
                $isRestricted = true;
                break;
            }
        }

        if ($isRestricted) {
            $deptId = $employee->department_id ?: ($employee->departmentAssignment?->id ?? null);
            
            if ($deptId) {
                // Use simplified overlap logic: (StartA <= EndB) and (EndA >= StartB)
                $overlappingCount = LeaveRequest::where('employee_id', '!=', $employee->id)
                    ->whereIn('status', ['pending', 'approved', \App\Enum\LeaveStatus::PENDING->value, \App\Enum\LeaveStatus::APPROVED->value])
                    ->where(function($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $endDate->format('Y-m-d'))
                          ->where('end_date', '>=', $startDate->format('Y-m-d'));
                    })
                    ->whereHas('employee', function($q) use ($deptId) {
                        $q->where('department_id', $deptId);
                    })
                    ->whereHas('leaveType', function($q) use ($restrictedTypes) {
                        $q->where(function($sub) use ($restrictedTypes) {
                            foreach ($restrictedTypes as $rt) {
                                $sub->orWhere('name', 'like', "%{$rt}%");
                            }
                        });
                    })
                    ->count();

                if ($overlappingCount > 0) {
                    $errors[] = "Departmental Limit Reached: Another employee in your department is already scheduled for leave (Annual/Vacation/Personal) during this period. Only one person per department may take these leave types at a time.";
                }
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings,
            'auto_approve' => $leaveType->auto_approve
        ];
    }

    /**
     * Get leave balance for an employee and leave type
     */
    public static function getLeaveBalance(Employee $employee, string $leaveTypeCode): int
    {
        $leaveType = LeaveType::where('code', $leaveTypeCode)->first();
        if (!$leaveType) {
            return 0;
        }

        $currentYear = Carbon::now()->year;
        
        $balance = LeaveBalance::where('employee_id', $employee->id)
            ->where('leave_type_id', $leaveType->id)
            ->where('year', $currentYear)
            ->first();

        if ($balance) {
            return $balance->balance_days;
        }

        // Create balance if not exists
        $totalDays = $leaveType->default_days ?? 0;
        LeaveBalance::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'total_days' => $totalDays,
            'used_days' => 0,
            'balance_days' => $totalDays,
            'carried_forward_days' => 0,
            'year' => $currentYear,
            'created_by' => Auth::id(),
        ]);

        return $totalDays;
    }

    /**
     * Update leave balance after request approval
     */
    public static function updateLeaveBalance(LeaveRequest $leaveRequest): void
    {
        $leaveType = $leaveRequest->leaveType;
        
        // Don't update balance for vacation leaves (they use annual leave)
        if ($leaveType->deduct_from_annual) {
            // Deduct from annual leave instead
            $annualLeaveType = LeaveType::where('code', 'ANNUAL')->first();
            if ($annualLeaveType) {
                $annualBalance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)
                    ->where('leave_type_id', $annualLeaveType->id)
                    ->where('year', Carbon::now()->year)
                    ->first();

                if ($annualBalance) {
                    $annualBalance->used_days += $leaveRequest->total_days;
                    $annualBalance->balance_days = ($annualBalance->total_days + $annualBalance->carried_forward_days) - $annualBalance->used_days;
                    $annualBalance->save();
                }
            }
            return;
        }

        // Update regular leave balance
        $balance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)
            ->where('leave_type_id', $leaveRequest->leave_type_id)
            ->where('year', Carbon::now()->year)
            ->first();

        if ($balance) {
            $balance->updateBalance();
        }
    }

    /**
     * Check for leave limit exceedances and send notifications
     */
    public static function checkLeaveLimitExceeded(LeaveRequest $leaveRequest): void
    {
        $leaveType = $leaveRequest->leaveType;
        $employee = $leaveRequest->employee;

        // Check personal leave exceedance
        if ($leaveType->code === 'PERSONAL') {
            $currentYear = Carbon::now()->year;
            $usedDays = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', LeaveStatus::APPROVED->value)
                ->whereYear('start_date', $currentYear)
                ->sum('total_days');

            if ($usedDays > 15) {
                // Send notification to HR and employee
                self::sendExceededNotification($employee, $leaveType, $usedDays, 15);
            }
        }
    }

    /**
     * Send notification when leave limit is exceeded
     */
    private static function sendExceededNotification(Employee $employee, LeaveType $leaveType, int $usedDays, int $maxDays): void
    {
        $message = "Employee {$employee->first_name} {$employee->last_name} has exceeded their {$leaveType->name} limit. Used: {$usedDays} days, Limit: {$maxDays} days.";
        
        Log::warning($message);
        
        // Here you would typically send emails, notifications, etc.
        // For now, we'll just log it and create a system notification
        // You can extend this to send emails, push notifications, etc.
    }

    /**
     * Auto-approve leave if conditions are met
     */
    public static function autoApproveIfEligible(LeaveRequest $leaveRequest): bool
    {
        $leaveType = $leaveRequest->leaveType;
        
        if (!$leaveType->auto_approve) {
            return false;
        }

        // Bereavement leave auto-approves
        if ($leaveType->code === 'BEREAVEMENT') {
            $leaveRequest->update([
                'status' => LeaveStatus::APPROVED->value,
                'approval_status' => ApprovalStatus::Approved->value,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
            
            self::updateLeaveBalance($leaveRequest);
            return true;
        }

        return false;
    }
}
