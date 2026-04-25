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
        Schema::table('departments', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('geofence_radius_meters')->default(100);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignUuid('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignUuid('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->decimal('check_in_latitude', 10, 8)->nullable();
            $table->decimal('check_in_longitude', 11, 8)->nullable();
            $table->decimal('check_out_latitude', 10, 8)->nullable();
            $table->decimal('check_out_longitude', 11, 8)->nullable();
            $table->integer('late_minutes')->default(0);
            $table->integer('overtime_minutes')->default(0);
            $table->integer('total_worked_minutes')->default(0);
            $table->integer('total_break_minutes')->default(0);
            $table->string('daily_status')->default('Present'); // Present, Absent, Late, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'geofence_radius_meters']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['shift_id']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'shift_id', 'check_in_latitude', 'check_in_longitude', 
                'check_out_latitude', 'check_out_longitude', 
                'late_minutes', 'overtime_minutes', 
                'total_worked_minutes', 'total_break_minutes', 'daily_status'
            ]);
        });
    }
};
