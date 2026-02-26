<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_targets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('kpi_id');
            $table->uuid('employee_id');
            $table->string('period_type'); // monthly, quarterly, yearly
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('target_value', 10, 2);
            $table->decimal('actual_value', 10, 2)->default(0);
            $table->decimal('achievement_percentage', 5, 2)->default(0);
            $table->decimal('score', 5, 2)->default(0);
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kpi_id')->references('id')->on('kpis')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_targets');
    }
};
