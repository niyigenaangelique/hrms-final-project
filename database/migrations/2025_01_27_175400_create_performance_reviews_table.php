<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('employee_id');
            $table->uuid('reviewer_id');
            $table->date('review_period_start');
            $table->date('review_period_end');
            $table->string('type'); // annual, semi-annual, quarterly, probation
            $table->string('overall_rating'); // excellent, good, satisfactory, needs_improvement
            $table->decimal('overall_score', 5, 2);
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('development_plan')->nullable();
            $table->text('employee_comments')->nullable();
            $table->text('manager_comments')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed, cancelled
            $table->timestamp('review_date')->nullable();
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
