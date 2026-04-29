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
        'payroll_period_id', 'payroll_month_id', 'employee_id', 'employee_code', 'employee_name',
        'department', 'position', 'nationality',
        // Attendance
        'working_days', 'present_days', 'absent_days', 'leave_days',
        'unpaid_leave_days', 'total_late_minutes', 'total_ot_minutes',
        // Earnings
        'basic_salary', 'house_allowance', 'transport_allowance', 'other_allowances', 'allowances_total', 
        'overtime_hours', 'overtime_pay', 'gross_pay',
        // Deductions
        'unpaid_leave_deduction', 'late_deduction',
        'rssb_employee', 'rssb_employer', 'paye_tax',
        'cbhi', 'maternity_fund', 'loan_deduction', 'other_deductions', 'total_deductions',
        // Final
        'taxable_income', 'net_before_cbhi', 'net_pay', 'salary_advance', 'tax_bracket_used', 'effective_tax_rate',
        // Bank
        'bank_name', 'bank_account', 'payment_method',
        // Meta
        'status', 'is_locked', 'allowance_breakdown',
    ];

    protected $casts = [
        'basic_salary'           => 'decimal:2',
        'house_allowance'        => 'decimal:2',
        'transport_allowance'    => 'decimal:2',
        'other_allowances'       => 'decimal:2',
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
        'net_before_cbhi'        => 'decimal:2',
        'net_pay'                => 'decimal:2',
        'salary_advance'         => 'decimal:2',
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

    public function payslipEntry(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PayslipEntry::class, 'payroll_computation_entry_id');
    }

    public function payrollMonth(): BelongsTo
    {
        return $this->belongsTo(PayrollMonth::class, 'payroll_month_id');
    }

    public function getPeriodNameAttribute()
    {
        if ($this->payrollPeriod) {
            return $this->payrollPeriod->name;
        }
        if ($this->payrollMonth) {
            return $this->payrollMonth->name;
        }
        return 'Unknown Period';
    }
}
