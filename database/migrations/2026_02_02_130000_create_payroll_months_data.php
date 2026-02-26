<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Get a valid user ID for created_by
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : null;
        
        // First, let's check if we have a default project
        $project = DB::table('projects')->first();
        if (!$project) {
            // Create a default project if none exists
            $projectId = DB::table('projects')->insertGetId([
                'id' => \Illuminate\Support\Str::uuid(),
                'code' => 'PROJ-DEFAULT',
                'name' => 'Default Payroll Project',
                'description' => 'Default project for payroll processing',
                'status' => \App\Enum\ProjectStatus::InProgress->value,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $projectId = $project->id;
        }

        // Insert payroll months for current year
        $currentYear = date('Y');
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));
            $monthName = date('F', strtotime($startDate));
            
            DB::table('payroll_months')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'code' => 'PM-' . $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT),
                'name' => $monthName . ' ' . $currentYear . ' Payroll',
                'description' => 'Payroll period for ' . $monthName . ' ' . $currentYear,
                'project_id' => $projectId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'approval_status' => \App\Enum\ApprovalStatus::Approved->value,
                'is_locked' => false,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('payroll_months')->where('created_by', 'system')->delete();
    }
};
