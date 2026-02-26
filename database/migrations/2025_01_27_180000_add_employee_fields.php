<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('employees', 'employee_number')) {
                $table->string('employee_number')->unique()->nullable()->after('code');
            }
            if (!Schema::hasColumn('employees', 'position_id')) {
                $table->uuid('position_id')->nullable()->after('country');
            }
            if (!Schema::hasColumn('employees', 'department_id')) {
                $table->uuid('department_id')->nullable()->after('position_id');
            }
            if (!Schema::hasColumn('employees', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_locked');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['employee_number', 'position_id', 'department_id', 'is_active']);
        });
    }
};
