<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goal_updates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('goal_id');
            $table->text('update_text');
            $table->decimal('progress_percentage', 5, 2);
            $table->string('attachment_path')->nullable();
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_updates');
    }
};
