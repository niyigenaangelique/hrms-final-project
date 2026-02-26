<?php



use App\Enum\ApprovalStatus;
use App\Enum\ContractStatus;
use App\Enum\EmployeeCategory;
use App\Enum\ProjectStatus;
use App\Enum\RemunerationType;
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
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->foreignUuid('project_id')
                ->comment('Project ID')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('employee_id')
                ->comment('Employee ID')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('position_id')
                ->comment('Position ID')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('remuneration', 12, 2);
            $table->enum('remuneration_type', RemunerationType::values())->default(RemunerationType::DAILY->value);
            $table->enum('employee_category', EmployeeCategory::values())->default(EmployeeCategory::CASUAL->value);
            $table->decimal('daily_working_hours', 10, 2)->default(9.00);


            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->enum('status', ContractStatus::values())->default(ContractStatus::DRAFT);

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
        Schema::dropIfExists('contracts');
    }
};
