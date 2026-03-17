<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payslip_entries', function (Blueprint $table) {
            $table->decimal('taxable_income', 10, 2)->nullable()->after('gross_pay')->comment('Taxable income after pension deduction');
            $table->string('tax_bracket_used')->nullable()->after('net_pay')->comment('Tax bracket used for calculation');
            $table->decimal('effective_tax_rate', 5, 2)->nullable()->after('tax_bracket_used')->comment('Effective tax rate percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslip_entries', function (Blueprint $table) {
            $table->dropColumn(['taxable_income', 'tax_bracket_used', 'effective_tax_rate']);
        });
    }
};
