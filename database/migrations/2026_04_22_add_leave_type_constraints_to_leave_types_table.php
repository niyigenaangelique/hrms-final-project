<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            // Add leave type constraints
            $table->integer('max_days_per_year')->nullable()->after('default_days');
            $table->boolean('requires_medical_document')->default(false)->after('requires_approval');
            $table->boolean('auto_approve')->default(false)->after('requires_medical_document');
            $table->boolean('deduct_from_annual')->default(false)->after('auto_approve');
            $table->string('gender_restriction')->nullable()->after('deduct_from_annual'); // 'male', 'female', null
            $table->text('doctor_extension_note')->nullable()->after('gender_restriction');
        });
    }

    public function down(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn([
                'max_days_per_year',
                'requires_medical_document',
                'auto_approve',
                'deduct_from_annual',
                'gender_restriction',
                'doctor_extension_note'
            ]);
        });
    }
};
