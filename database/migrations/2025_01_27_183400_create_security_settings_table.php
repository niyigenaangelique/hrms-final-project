<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('key')->unique();
            $table->text('value');
            $table->text('description')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, array
            $table->boolean('is_active')->default(true);
            $table->string('approval_status')->default(App\Enum\ApprovalStatus::Initiated->value);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_settings');
    }
};
