<?php



use App\Enum\ApprovalStatus;
use App\Enum\PayslipStatus;
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
        Schema::create('payslip_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->foreignUuid('payroll_entry_id')->constrained()->cascadeOnDelete();
            $table->decimal('gross_pay', 12, 2)->default(0.00);
            $table->decimal('paye', 12, 2)->default(0.00);
            $table->decimal('pension', 12, 2)->default(0.00);
            $table->decimal('maternity', 12, 2)->default(0.00);
            $table->decimal('cbhi', 12, 2)->default(0.00);
            $table->decimal('employer_contribution', 12, 2)->default(0.00);
            $table->decimal('net_pay', 12, 2)->default(0.00);

            $table->enum('status', PayslipStatus::values())
                ->default(PayslipStatus::Entered->value)
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
        Schema::dropIfExists('payslip_entries');
    }
};
