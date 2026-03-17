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
        Schema::table('payslip_entries', function (Blueprint $table) {
            $table->enum('status', ['Entered', 'Generated', 'Approved', 'printed', 'Posted'])
                ->default('Entered')
                ->comment('Status of the record')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslip_entries', function (Blueprint $table) {
            $table->enum('status', ['Entered', 'Rejected', 'Approved', 'printed', 'Posted'])
                ->default('Entered')
                ->comment('Status of the record')
                ->change();
        });
    }
};
