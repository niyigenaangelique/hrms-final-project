<?php



use App\Enum\ApprovalStatus;
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
        Schema::create('payroll_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->foreignUuid('payroll_month_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('employee_id')->constrained()->cascadeOnDelete();

            $table->decimal('daily_rate', 10, 2)->default(0.00);
            $table->decimal('work_days', 10, 2)->default(0.00);
            $table->decimal('work_days_pay', 10, 2)->default(0.00);

            $table->decimal('overtime_hour_rate', 10, 2)->default(1.50);
            $table->decimal('overtime_hours_worked', 10, 2)->default(0);
            $table->decimal('overtime_total_amount', 10, 2)->default(0);

            $table->decimal('total_amount', 10, 2)->default(0);

            $table->enum('status', AttendanceStatus::values())
                ->default(AttendanceStatus::Entered->value)
                ->comment('Status of the record');


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
        Schema::dropIfExists('payroll_entries');
    }
};
