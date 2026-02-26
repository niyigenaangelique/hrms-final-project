<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('payroll_entry_id')->nullable();
            $table->uuid('payslip_entry_id')->nullable();
            $table->uuid('employee_id');
            $table->string('payment_method'); // bank_transfer, cash, cheque, mobile_money
            $table->string('transaction_reference')->nullable();
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency')->default('USD');
            $table->date('payment_date');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('cheque_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default(App\Enum\PaymentStatus::PENDING->value);
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payroll_entry_id')->references('id')->on('payroll_entries')->onDelete('set null');
            $table->foreign('payslip_entry_id')->references('id')->on('payslip_entries')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
