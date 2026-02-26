<?php



use App\Enum\ApprovalStatus;
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
        Schema::create('job_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('job_id')->nullable(); // Store queue job ID
            $table->string('job_type'); // 'import' or 'export'
            $table->string('file_path')->nullable(); // For export or import valid/error files
            $table->text('message');
            $table->json('fixed_values')->nullable();
            $table->string('status')->default('queued'); // queued, completed, failed

            $table->foreignUuid('user_id')
                ->nullable()
                ->comment('User who created the record')
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
        Schema::dropIfExists('job_results');
    }
};
