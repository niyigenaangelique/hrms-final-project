<?php



use App\Enum\ApprovalStatus;
use App\Enum\DeviceStatus;
use App\Enum\ProjectStatus;
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
        Schema::create('devices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', DeviceStatus::values())->nullable();
            $table->datetime('last_seen_at')->nullable();
            $table->datetime('last_sync_at')->nullable();
            $table->foreignUuid('project_id')
                ->comment('Project ID')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('approval_status', ApprovalStatus::values())
                ->default(ApprovalStatus::NotApplicable)
                ->comment('Approval status of the record');

            $table->boolean('is_locked')
                ->default(false)
                ->comment('Indicates if record is locked from edits');

            $table->foreignUuid('locked_by')
                ->nullable()
                ->comment('User who locked the record')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignUuid('created_by')
                ->nullable()
                ->comment('User who created the record')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignUuid('updated_by')
                ->nullable()
                ->comment('User who last updated the record')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignUuid('deleted_by')
                ->nullable()
                ->comment('User who last updated the record')
                ->constrained('users')
                ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
