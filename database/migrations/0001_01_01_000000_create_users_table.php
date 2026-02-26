<?php

use App\Enum\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->enum('role', UserRole::values())->default(UserRole::Employee);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            // Indexes for performance
            $table->index(['email', 'phone_number', 'username']);
        });

        // Insert default user
        DB::table('users')->insert([
            'id' => Str::orderedUuid(),
            'code' => 'SGA-00001',
            'first_name' => 'Joseph',
            'middle_name' => null,
            'last_name' => 'Niyonizeye',
            'username' => 'nijoseph',
            'email' => 'nijoseph36@gmail.com',
            'phone_number' => '0788909194',
            'password' => Hash::make(env('DEFAULT_SUPER_ADMIN_PASSWORD', 'ChangeMe@123')), // Uses env variable for security
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
            'password_changed_at' => now(),
            'role' => UserRole::SuperAdmin->value,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
