<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('notification_template_id')->nullable();
            $table->string('recipient_type'); // user, employee, department
            $table->uuid('recipient_id');
            $table->string('channel'); // email, sms, push, in_app
            $table->string('subject');
            $table->text('content');
            $table->string('status'); // pending, sent, failed, scheduled
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('delivery_status')->default('pending'); // pending, delivered, failed, read
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('notification_template_id')->references('id')->on('notification_templates')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
