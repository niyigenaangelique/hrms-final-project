<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Payroll Periods
        Schema::create('payroll_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // "April 2026"
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['draft', 'processing', 'approved', 'paid', 'locked'])->default('draft');
            $table->decimal('total_gross_pay', 15, 2)->default(0);
            $table->decimal('total_net_pay', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
            
            $table->index(['start_date', 'end_date']);
            $table->index('status');
        });

        // Payroll Entries (individual employee payslips)
        Schema::create('payroll_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('payroll_period_id');
            $table->uuid('employee_id');
            $table->string('employee_code');
            $table->string('employee_name');
            $table->string('employee_department')->nullable();
            $table->string('employee_position')->nullable();
            
            // EARNINGS
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('house_allowance', 12, 2)->default(0);
            $table->decimal('transport_allowance', 12, 2)->default(0);
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('holiday_ot_hours', 8, 2)->default(0);
            $table->decimal('holiday_ot_pay', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('other_earnings', 12, 2)->default(0);
            $table->decimal('gross_pay', 12, 2);
            
            // DEDUCTIONS
            $table->decimal('unpaid_leave_days', 5, 2)->default(0);
            $table->decimal('unpaid_leave_deduction', 12, 2)->default(0);
            $table->decimal('late_deductions', 12, 2)->default(0);
            $table->decimal('rssb_employee', 12, 2)->default(0);
            $table->decimal('rssb_employer', 12, 2)->default(0);
            $table->decimal('paye_tax', 12, 2)->default(0);
            $table->decimal('cbhi', 12, 2)->default(0);
            $table->decimal('maternity_fund', 12, 2)->default(0);
            $table->decimal('loan_deduction', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2);
            
            // FINAL
            $table->decimal('net_pay', 12, 2);
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            
            // Attendance calculations
            $table->integer('working_days')->default(0);
            $table->integer('present_days')->default(0);
            $table->integer('leave_days')->default(0);
            $table->integer('holiday_days')->default(0);
            $table->integer('weekend_days')->default(0);
            
            $table->timestamps();
            
            $table->foreign('payroll_period_id')->references('id')->on('payroll_periods')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->index(['payroll_period_id', 'employee_id']);
            $table->index('employee_code');
        });

        // Payroll Settings
        Schema::create('payroll_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique();
            $table->text('value');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('key');
        });

        // Tax Brackets (Rwanda PAYE)
        Schema::create('tax_brackets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('min_income', 12, 2);
            $table->decimal('max_income', 12, 2)->nullable();
            $table->decimal('rate', 5, 2); // Percentage
            $table->decimal('fixed_amount', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['min_income', 'max_income']);
        });

        // Insert default payroll settings
        DB::table('payroll_settings')->insert([
            ['key' => 'rssb_employee_rate', 'value' => '0.03', 'description' => 'RSSB Employee Contribution (3%)'],
            ['key' => 'rssb_employer_rate', 'value' => '0.05', 'description' => 'RSSB Employer Contribution (5%)'],
            ['key' => 'cbhi_rate', 'value' => '0.045', 'description' => 'CBHI Contribution (4.5%)'],
            ['key' => 'maternity_rate', 'value' => '0.003', 'description' => 'Maternity Fund (0.3%)'],
            ['key' => 'overtime_rate', 'value' => '1.5', 'description' => 'Overtime Rate (1.5x normal rate)'],
            ['key' => 'holiday_ot_rate', 'value' => '2.0', 'description' => 'Holiday Overtime Rate (2x normal rate)'],
            ['key' => 'max_ot_hours_per_day', 'value' => '2', 'description' => 'Maximum overtime hours per day'],
            ['key' => 'max_ot_hours_per_week', 'value' => '10', 'description' => 'Maximum overtime hours per week'],
            ['key' => 'currency', 'value' => 'RWF', 'description' => 'Currency Code'],
        ]);

        // Insert Rwanda tax brackets (example rates - should be updated with actual rates)
        DB::table('tax_brackets')->insert([
            ['min_income' => 0, 'max_income' => 36000, 'rate' => 0, 'fixed_amount' => 0],
            ['min_income' => 36001, 'max_income' => 120000, 'rate' => 0.20, 'fixed_amount' => 0],
            ['min_income' => 120001, 'max_income' => null, 'rate' => 0.30, 'fixed_amount' => 16800],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tax_brackets');
        Schema::dropIfExists('payroll_settings');
        Schema::dropIfExists('payroll_entries');
        Schema::dropIfExists('payroll_periods');
    }
};
