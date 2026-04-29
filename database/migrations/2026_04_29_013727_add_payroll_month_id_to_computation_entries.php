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
            $table->uuid('payroll_month_id')->nullable()->after('payroll_period_id');
            $table->foreign('payroll_month_id')->references('id')->on('payroll_months')->onDelete('cascade');
            $table->uuid('payroll_period_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll_computation_entries', function (Blueprint $table) {
            $table->dropForeign(['payroll_month_id']);
            $table->dropColumn('payroll_month_id');
            $table->uuid('payroll_period_id')->nullable(false)->change();
        });
    }
};
