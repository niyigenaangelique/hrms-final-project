<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── Payroll Periods (replaces legacy payroll_months for automation) ──
        Schema::create('payroll_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');             // "April 2026"
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('working_days')->default(0);
            $table->enum('status', ['draft', 'processing', 'approved', 'paid', 'locked'])->default('draft');
            $table->decimal('total_gross_pay', 15, 2)->default(0);
            $table->decimal('total_net_pay', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('total_employer_rssb', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->uuid('created_by')->nullable();
            $table->uuid('approved_by')->nullable();
            $table->uuid('locked_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
            $table->index(['start_date', 'end_date']);
            $table->index('status');
        });

        // ── Payroll Computation Entries (one row per employee per period) ──
        Schema::create('payroll_computation_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('payroll_period_id');
            $table->uuid('employee_id');
            $table->string('employee_code');
            $table->string('employee_name');
            $table->string('department')->nullable();
            $table->string('position')->nullable();

            // Attendance summary
            $table->integer('working_days')->default(0);
            $table->integer('present_days')->default(0);
            $table->integer('absent_days')->default(0);
            $table->integer('leave_days')->default(0);
            $table->integer('unpaid_leave_days')->default(0);
            $table->decimal('total_late_minutes', 8, 2)->default(0);
            $table->decimal('total_ot_minutes', 8, 2)->default(0);

            // Earnings
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('allowances_total', 12, 2)->default(0); // sum of all active allowance components
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('gross_pay', 12, 2)->default(0);

            // Deductions
            $table->decimal('unpaid_leave_deduction', 12, 2)->default(0);
            $table->decimal('late_deduction', 12, 2)->default(0);
            $table->decimal('rssb_employee', 12, 2)->default(0);   // 3%
            $table->decimal('rssb_employer', 12, 2)->default(0);   // 5% (cost, not employee deduction)
            $table->decimal('paye_tax', 12, 2)->default(0);
            $table->decimal('cbhi', 12, 2)->default(0);            // 4.5%
            $table->decimal('maternity_fund', 12, 2)->default(0);  // 0.3%
            $table->decimal('loan_deduction', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2)->default(0);

            // Final
            $table->decimal('taxable_income', 12, 2)->default(0);
            $table->decimal('net_pay', 12, 2)->default(0);
            $table->string('tax_bracket_used')->nullable();
            $table->decimal('effective_tax_rate', 5, 2)->default(0);

            // Bank info (snapshot at payroll time)
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('payment_method')->nullable();

            $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
            $table->boolean('is_locked')->default(false);
            $table->json('allowance_breakdown')->nullable(); // JSON snapshot of each allowance
            $table->timestamps();

            $table->foreign('payroll_period_id')->references('id')->on('payroll_periods')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unique(['payroll_period_id', 'employee_id']);
            $table->index('employee_code');
        });

        // ── Payroll Settings (rates, caps) ────────────────────────────────
        Schema::create('payroll_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique();
            $table->text('value');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // ── Rwanda PAYE Tax Brackets ───────────────────────────────────────
        Schema::create('tax_brackets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('min_income', 12, 2);
            $table->decimal('max_income', 12, 2)->nullable(); // null = no upper limit
            $table->decimal('rate', 5, 2);           // as percentage e.g. 10.00 = 10%
            $table->decimal('fixed_amount', 12, 2)->default(0); // cumulative tax from lower brackets
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['min_income', 'max_income']);
        });

        // ── Salary Components (Basic, House Allowance, Transport, Lunch…) ──
        Schema::create('salary_components', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');                // "House Allowance"
            $table->string('code')->unique();      // "HOUSE"
            $table->enum('type', ['earning', 'deduction'])->default('earning');
            $table->boolean('is_taxable')->default(true);
            $table->boolean('is_basic')->default(false);  // mark the basic salary component
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // ── Employee Salary Structures (per employee, per component, with effective dates) ──
        Schema::create('employee_salary_structures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->uuid('salary_component_id');
            $table->decimal('amount', 12, 2)->default(0);
            $table->date('effective_date');
            $table->date('end_date')->nullable();  // null = still active
            $table->text('notes')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('salary_component_id')->references('id')->on('salary_components');
            $table->index(['employee_id', 'salary_component_id', 'effective_date']);
        });

        // ── Seed default payroll settings ──────────────────────────────────
        DB::table('payroll_settings')->insert([
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'rssb_employee_rate',    'value' => '3',   'description' => 'RSSB Employee Contribution (%)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'rssb_employer_rate',    'value' => '5',   'description' => 'RSSB Employer Contribution (%)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'cbhi_rate',             'value' => '4.5', 'description' => 'CBHI Contribution (%)',           'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'maternity_rate',        'value' => '0.3', 'description' => 'Maternity Fund (%)',               'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'overtime_rate',         'value' => '1.5', 'description' => 'Overtime Rate Multiplier',         'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'max_ot_hours_per_day',  'value' => '2',   'description' => 'Max OT hours per day',             'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'max_ot_hours_per_week', 'value' => '10',  'description' => 'Max OT hours per week',            'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'work_hours_per_day',    'value' => '8',   'description' => 'Standard working hours per day',   'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'late_grace_minutes',    'value' => '15',  'description' => 'Late grace period (minutes)',       'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'currency',              'value' => 'RWF', 'description' => 'Currency',                         'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Seed Rwanda PAYE brackets (RRA confirmed) ──────────────────────
        // Monthly income brackets
        DB::table('tax_brackets')->insert([
            ['id' => \Illuminate\Support\Str::uuid(), 'min_income' => 0,       'max_income' => 60000,  'rate' => 0,  'fixed_amount' => 0,     'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'min_income' => 60001,   'max_income' => 100000, 'rate' => 10, 'fixed_amount' => 0,     'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'min_income' => 100001,  'max_income' => 200000, 'rate' => 20, 'fixed_amount' => 4000,  'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'min_income' => 200001,  'max_income' => null,   'rate' => 30, 'fixed_amount' => 24000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Seed default salary components ─────────────────────────────────
        DB::table('salary_components')->insert([
            ['id' => \Illuminate\Support\Str::uuid(), 'name' => 'Basic Salary',        'code' => 'BASIC',      'type' => 'earning',   'is_taxable' => true,  'is_basic' => true,  'is_active' => true, 'sort_order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'name' => 'House Allowance',     'code' => 'HOUSE',      'type' => 'earning',   'is_taxable' => true,  'is_basic' => false, 'is_active' => true, 'sort_order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'name' => 'Transport Allowance', 'code' => 'TRANSPORT',  'type' => 'earning',   'is_taxable' => false, 'is_basic' => false, 'is_active' => true, 'sort_order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'name' => 'Medical Allowance',   'code' => 'MEDICAL',    'type' => 'earning',   'is_taxable' => false, 'is_basic' => false, 'is_active' => true, 'sort_order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'name' => 'Lunch Allowance',     'code' => 'LUNCH',      'type' => 'earning',   'is_taxable' => false, 'is_basic' => false, 'is_active' => true, 'sort_order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['id' => \Illuminate\Support\Str::uuid(), 'name' => 'Loan Repayment',      'code' => 'LOAN',       'type' => 'deduction', 'is_taxable' => false, 'is_basic' => false, 'is_active' => true, 'sort_order' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_salary_structures');
        Schema::dropIfExists('salary_components');
        Schema::dropIfExists('tax_brackets');
        Schema::dropIfExists('payroll_settings');
        Schema::dropIfExists('payroll_computation_entries');
        Schema::dropIfExists('payroll_periods');
    }
};
