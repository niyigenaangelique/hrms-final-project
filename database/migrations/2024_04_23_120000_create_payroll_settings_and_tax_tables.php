<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Payroll Settings
        if (!Schema::hasTable('payroll_settings')) {
            Schema::create('payroll_settings', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('key')->unique();
                $table->text('value');
                $table->text('description')->nullable();
                $table->timestamps();
                
                $table->index('key');
            });

            // Insert default payroll settings
            DB::table('payroll_settings')->insert([
                ['id' => \Str::uuid(), 'key' => 'rssb_employee_rate', 'value' => '0.03', 'description' => 'RSSB Employee Contribution (3%)'],
                ['id' => \Str::uuid(), 'key' => 'rssb_employer_rate', 'value' => '0.05', 'description' => 'RSSB Employer Contribution (5%)'],
                ['id' => \Str::uuid(), 'key' => 'cbhi_rate', 'value' => '0.045', 'description' => 'CBHI Contribution (4.5%)'],
                ['id' => \Str::uuid(), 'key' => 'maternity_rate', 'value' => '0.003', 'description' => 'Maternity Fund (0.3%)'],
                ['id' => \Str::uuid(), 'key' => 'overtime_rate', 'value' => '1.5', 'description' => 'Overtime Rate (1.5x normal rate)'],
                ['id' => \Str::uuid(), 'key' => 'holiday_ot_rate', 'value' => '2.0', 'description' => 'Holiday Overtime Rate (2x normal rate)'],
                ['id' => \Str::uuid(), 'key' => 'max_ot_hours_per_day', 'value' => '2', 'description' => 'Maximum overtime hours per day'],
                ['id' => \Str::uuid(), 'key' => 'max_ot_hours_per_week', 'value' => '10', 'description' => 'Maximum overtime hours per week'],
                ['id' => \Str::uuid(), 'key' => 'currency', 'value' => 'RWF', 'description' => 'Currency Code'],
            ]);
        }

        // Tax Brackets (Rwanda PAYE)
        if (!Schema::hasTable('tax_brackets')) {
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

            // Insert Rwanda tax brackets (example rates - should be updated with actual rates)
            DB::table('tax_brackets')->insert([
                ['id' => \Str::uuid(), 'min_income' => 0, 'max_income' => 36000, 'rate' => 0, 'fixed_amount' => 0],
                ['id' => \Str::uuid(), 'min_income' => 36001, 'max_income' => 120000, 'rate' => 0.20, 'fixed_amount' => 0],
                ['id' => \Str::uuid(), 'min_income' => 120001, 'max_income' => null, 'rate' => 0.30, 'fixed_amount' => 16800],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('tax_brackets');
        Schema::dropIfExists('payroll_settings');
    }
};
