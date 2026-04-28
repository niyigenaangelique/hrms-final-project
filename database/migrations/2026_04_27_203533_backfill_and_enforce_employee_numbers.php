<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ensure the column is nullable initially
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'employee_number')) {
                $table->string('employee_number')->nullable()->after('code');
            } else {
                $table->string('employee_number')->nullable()->change();
            }
        });

        // 2. Backfill existing employees starting from 1000
        $employees = Employee::withTrashed()->orderBy('created_at', 'asc')->get();
        $startNumber = 1000;
        
        foreach ($employees as $index => $employee) {
            $employee->employee_number = (string)($startNumber + $index);
            $employee->save();
        }

        // 3. Enforce uniqueness
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_number')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropUnique(['employee_number']);
        });
    }
};
