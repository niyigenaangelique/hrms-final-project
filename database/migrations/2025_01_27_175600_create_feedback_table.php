<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('performance_review_id')->nullable();
            $table->uuid('giver_id');
            $table->uuid('receiver_id');
            $table->string('feedback_type'); // peer, manager, self, 360
            $table->string('relationship'); // colleague, manager, subordinate, peer
            $table->decimal('rating', 5, 2);
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('comments')->nullable();
            $table->string('status')->default('pending'); // pending, submitted, reviewed
            $table->timestamp('feedback_date')->nullable();
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('performance_review_id')->references('id')->on('performance_reviews')->onDelete('cascade');
            $table->foreign('giver_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
