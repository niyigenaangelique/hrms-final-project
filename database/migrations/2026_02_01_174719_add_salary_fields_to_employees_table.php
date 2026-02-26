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
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('basic_salary', 12, 2)->nullable()->after('email')->comment('Monthly basic salary');
            $table->decimal('daily_rate', 10, 2)->nullable()->after('basic_salary')->comment('Daily rate calculated from basic salary');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('daily_rate')->comment('Hourly rate for overtime calculations');
            $table->string('salary_currency', 3)->default('RWF')->after('hourly_rate')->comment('Currency for salary');
            $table->enum('payment_method', ['bank', 'cash', 'mobile_money'])->default('bank')->after('salary_currency')->comment('Preferred payment method');
            $table->string('bank_name')->nullable()->after('payment_method')->comment('Bank name for salary payments');
            $table->string('bank_account_number')->nullable()->after('bank_name')->comment('Bank account number');
            $table->string('bank_branch')->nullable()->after('bank_account_number')->comment('Bank branch name');
            $table->string('mobile_money_provider')->nullable()->after('bank_branch')->comment('Mobile money provider (Tigo, Airtel, etc)');
            $table->string('mobile_money_number')->nullable()->after('mobile_money_provider')->comment('Mobile money phone number');
            $table->date('salary_effective_date')->nullable()->after('mobile_money_number')->comment('Date when salary becomes effective');
            $table->boolean('is_taxable')->default(true)->after('salary_effective_date')->comment('Whether salary is subject to tax');
            $table->decimal('rssb_rate', 5, 2)->default(3.00)->after('is_taxable')->comment('RSSB contribution rate');
            $table->decimal('pension_rate', 5, 2)->default(5.00)->after('rssb_rate')->comment('Pension contribution rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'basic_salary',
                'daily_rate',
                'hourly_rate',
                'salary_currency',
                'payment_method',
                'bank_name',
                'bank_account_number',
                'bank_branch',
                'mobile_money_provider',
                'mobile_money_number',
                'salary_effective_date',
                'is_taxable',
                'rssb_rate',
                'pension_rate'
            ]);
        });
    }
};
