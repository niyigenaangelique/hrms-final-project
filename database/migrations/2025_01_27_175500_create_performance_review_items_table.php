<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_review_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('performance_review_id');
            $table->uuid('kpi_id')->nullable();
            $table->string('criteria');
            $table->string('rating'); // 1-5 scale
            $table->decimal('score', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->text('comments')->nullable();
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('performance_review_id')->references('id')->on('performance_reviews')->onDelete('cascade');
            $table->foreign('kpi_id')->references('id')->on('kpis')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_review_items');
    }
};
