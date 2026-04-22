<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ─────────────────────────────────────────────────────────────────────────────
// Run:  php artisan migrate
// This migration is safe to run on an existing users table — it checks for
// column existence before adding anything.
// ─────────────────────────────────────────────────────────────────────────────

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Add role column to users ─────────────────────────
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('employee')->after('password');
            });
        }

        // ── 2. Add code column to users (if missing) ────────────
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('code', 50)->nullable()->unique()->after('id');
            });
        }

        // ── 3. Add middle_name / phone_number (if missing) ──────
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'middle_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('middle_name')->nullable()->after('first_name');
            });
        }
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'phone_number')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone_number')->nullable()->after('email');
            });
        }

        // ── 4. audit_logs table ──────────────────────────────────
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->uuid('id')->primary();

                // Who did it
                $table->string('causer_type')->nullable();  // e.g. App\Models\User
                $table->char('causer_id', 36)->nullable();  // UUID of the acting user

                // What happened
                $table->string('event', 50);                // create | update | delete | login | logout | custom
                $table->string('subject_type')->nullable(); // e.g. App\Models\PayrollEntry
                $table->char('subject_id', 36)->nullable(); // UUID of the affected record

                // Human-readable description
                $table->text('description')->nullable();

                // Extra context (old/new values, IP, user-agent, etc.)
                $table->json('properties')->nullable();

                // Request metadata
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();

                $table->timestamps();

                $table->index(['causer_id', 'created_at']);
                $table->index(['subject_type', 'subject_id']);
                $table->index(['event', 'created_at']);
                $table->index('created_at');
            });
        }

        // ── 5. role_permissions table ────────────────────────────
        // Stores the saved permissions matrix for each role.
        // key = permission key (e.g. "payroll.approve"), value = bool
        if (!Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table) {
                $table->id();
                $table->string('role', 50);           // admin | hr_manager | employee
                $table->string('permission', 100);    // payroll.view | employees.delete …
                $table->boolean('allowed')->default(false);
                $table->timestamps();

                $table->unique(['role', 'permission']);
                $table->index('role');
            });
        }

        // ── 6. security_settings table ───────────────────────────
        if (!Schema::hasTable('security_settings')) {
            Schema::create('security_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            // Seed defaults
            $defaults = [
                ['key' => 'two_factor_enabled',       'value' => '0'],
                ['key' => 'session_timeout_enabled',   'value' => '1'],
                ['key' => 'session_timeout_minutes',   'value' => '60'],
                ['key' => 'password_expiry_enabled',   'value' => '0'],
                ['key' => 'password_expiry_days',      'value' => '90'],
                ['key' => 'login_audit_enabled',       'value' => '1'],
                ['key' => 'max_login_attempts',        'value' => '5'],
                ['key' => 'ip_whitelist_enabled',      'value' => '0'],
                ['key' => 'ip_whitelist',              'value' => ''],
            ];
            \DB::table('security_settings')->insert(
                array_map(fn($r) => array_merge($r, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]), $defaults)
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('security_settings');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('audit_logs');

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', fn(Blueprint $t) => $t->dropColumn('role'));
        }
        if (Schema::hasColumn('users', 'code')) {
            Schema::table('users', fn(Blueprint $t) => $t->dropColumn('code'));
        }
        if (Schema::hasColumn('users', 'middle_name')) {
            Schema::table('users', fn(Blueprint $t) => $t->dropColumn('middle_name'));
        }
        if (Schema::hasColumn('users', 'phone_number')) {
            Schema::table('users', fn(Blueprint $t) => $t->dropColumn('phone_number'));
        }
    }
};
