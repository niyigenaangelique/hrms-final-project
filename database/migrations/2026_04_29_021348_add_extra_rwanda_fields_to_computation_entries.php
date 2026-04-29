<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payroll_computation_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_computation_entries', 'nationality')) {
                $table->string('nationality')->nullable()->after('employee_name');
            }
            if (!Schema::hasColumn('payroll_computation_entries', 'house_allowance')) {
                $table->decimal('house_allowance', 12, 2)->default(0)->after('basic_salary');
            }
            if (!Schema::hasColumn('payroll_computation_entries', 'transport_allowance')) {
                $table->decimal('transport_allowance', 12, 2)->default(0)->after('house_allowance');
            }
            if (!Schema::hasColumn('payroll_computation_entries', 'other_allowances')) {
                $table->decimal('other_allowances', 12, 2)->default(0)->after('transport_allowance');
            }
            if (!Schema::hasColumn('payroll_computation_entries', 'net_before_cbhi')) {
                $table->decimal('net_before_cbhi', 12, 2)->default(0)->after('total_deductions');
            }
            if (!Schema::hasColumn('payroll_computation_entries', 'salary_advance')) {
                $table->decimal('salary_advance', 12, 2)->default(0)->after('net_before_cbhi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payroll_computation_entries', function (Blueprint $table) {
            $table->dropColumn(['nationality', 'house_allowance', 'transport_allowance', 'other_allowances', 'net_before_cbhi', 'salary_advance']);
        });
    }
};
