<?php



use App\Enum\ApprovalStatus;
use App\Enum\AttendanceMethod;
use App\Enum\AttendanceStatus;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->foreignUuid('employee_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('check_in');
            $table->time('check_out')->nullable();
            $table->foreignUuid('device_id')->constrained()->cascadeOnDelete();
            $table->enum('check_in_method', AttendanceMethod::values())->default(AttendanceMethod::Manuel_Input->value);
            $table->enum('check_out_method', AttendanceMethod::values())->default(AttendanceMethod::Manuel_Input->value);
            $table->enum('status', AttendanceStatus::values())->default(AttendanceStatus::Entered->value);

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

            $table->unique(['employee_id', 'date'], 'unique_attendance_per_employee_per_day');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
