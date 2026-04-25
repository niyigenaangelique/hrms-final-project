<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollComputationEntry extends Model
{
    use HasUuids;

    protected $fillable = [
        'payroll_period_id', 'employee_id', 'employee_code', 'employee_name',
        'department', 'position',
        // Attendance
        'working_days', 'present_days', 'absent_days', 'leave_days',
        'unpaid_leave_days', 'total_late_minutes', 'total_ot_minutes',
        // Earnings
        'basic_salary', 'allowances_total', 'overtime_hours', 'overtime_pay', 'gross_pay',
        // Deductions
        'unpaid_leave_deduction', 'late_deduction',
        'rssb_employee', 'rssb_employer', 'paye_tax',
        'cbhi', 'maternity_fund', 'loan_deduction', 'other_deductions', 'total_deductions',
        // Final
        'taxable_income', 'net_pay', 'tax_bracket_used', 'effective_tax_rate',
        // Bank
        'bank_name', 'bank_account', 'payment_method',
        // Meta
        'status', 'is_locked', 'allowance_breakdown',
    ];

    protected $casts = [
        'basic_salary'           => 'decimal:2',
        'allowances_total'       => 'decimal:2',
        'overtime_hours'         => 'decimal:2',
        'overtime_pay'           => 'decimal:2',
        'gross_pay'              => 'decimal:2',
        'unpaid_leave_deduction' => 'decimal:2',
        'late_deduction'         => 'decimal:2',
        'rssb_employee'          => 'decimal:2',
        'rssb_employer'          => 'decimal:2',
        'paye_tax'               => 'decimal:2',
        'cbhi'                   => 'decimal:2',
        'maternity_fund'         => 'decimal:2',
        'loan_deduction'         => 'decimal:2',
        'other_deductions'       => 'decimal:2',
        'total_deductions'       => 'decimal:2',
        'taxable_income'         => 'decimal:2',
        'net_pay'                => 'decimal:2',
        'effective_tax_rate'     => 'decimal:2',
        'total_late_minutes'     => 'decimal:2',
        'total_ot_minutes'       => 'decimal:2',
        'is_locked'              => 'boolean',
        'allowance_breakdown'    => 'array',
    ];

    public function payrollPeriod(): BelongsTo
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
