<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->timestamp('used_at')->nullable()->after('created_at');
            $table->string('reset_reason')->nullable()->after('token');
            $table->uuid('created_by')->nullable()->after('reset_reason');
            $table->timestamp('updated_at')->nullable()->after('used_at');
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['used_at', 'reset_reason', 'created_by', 'updated_at']);
        });
    }
};
