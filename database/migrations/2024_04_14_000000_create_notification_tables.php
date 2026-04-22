<?php
// database/migrations/xxxx_xx_xx_create_notification_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Main notifications table ──────────────────────────
        Schema::create('notifications', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $t->string('title');
            $t->text('body');
            $t->string('type')->default('general');         // pay_reminder | contract_expiry | holiday | leave_update | attendance_alert | payslip_ready | announcement | general
            $t->string('channel')->default('in_app');       // in_app | email | sms | both
            $t->string('priority')->default('normal');      // low | normal | high | urgent
            $t->boolean('is_read')->default(false);
            $t->timestamp('read_at')->nullable();
            $t->string('status')->default('sent');          // sent | scheduled | failed | cancelled
            $t->timestamp('scheduled_at')->nullable();
            $t->timestamp('sent_at')->nullable();
            $t->foreignUuid('sent_by')->nullable()->references('id')->on('users');  // HR user who triggered it
            $t->json('metadata')->nullable();               // contract_id, month_id, etc.
            $t->string('action_url')->nullable();
            $t->timestamps();
            $t->index(['user_id', 'is_read']);
            $t->index(['status', 'scheduled_at']);
            $t->index('type');
        });

        // ── Reusable message templates ────────────────────────
        Schema::create('notification_templates', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('type')->default('general');
            $t->string('channel')->default('email');
            $t->string('subject')->nullable();
            $t->text('body');
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        // ── Auto-trigger alert rules ──────────────────────────
        Schema::create('notification_alerts', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('trigger');          // contract_expiry | pay_reminder | holiday | leave_approval | leave_rejection | attendance_alert | payslip_ready
            $t->string('channel')->default('in_app');
            $t->string('priority')->default('normal');
            $t->integer('days_before')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        // ── Key-value settings store ──────────────────────────
        Schema::create('notification_settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
        Schema::dropIfExists('notification_alerts');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('notifications');
    }
};
