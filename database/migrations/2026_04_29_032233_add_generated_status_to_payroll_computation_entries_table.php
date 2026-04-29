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
        DB::statement("ALTER TABLE payroll_computation_entries MODIFY COLUMN status ENUM('draft', 'approved', 'paid', 'generated') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE payroll_computation_entries MODIFY COLUMN status ENUM('draft', 'approved', 'paid') DEFAULT 'draft'");
    }
};
