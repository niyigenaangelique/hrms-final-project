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
        Schema::table('payslip_entries', function (Blueprint $table) {
            $table->decimal('loan_deduction', 10, 2)->nullable()->after('employer_contribution');
            $table->decimal('advance_deduction', 10, 2)->nullable()->after('loan_deduction');
            $table->decimal('other_deductions', 10, 2)->nullable()->after('advance_deduction');
            $table->decimal('housing_allowance', 10, 2)->nullable()->after('other_deductions');
            $table->decimal('transport_allowance', 10, 2)->nullable()->after('housing_allowance');
            $table->decimal('meal_allowance', 10, 2)->nullable()->after('transport_allowance');
            $table->decimal('other_benefits', 10, 2)->nullable()->after('meal_allowance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslip_entries', function (Blueprint $table) {
            $table->dropColumn([
                'loan_deduction',
                'advance_deduction', 
                'other_deductions',
                'housing_allowance',
                'transport_allowance',
                'meal_allowance',
                'other_benefits'
            ]);
        });
    }
};
