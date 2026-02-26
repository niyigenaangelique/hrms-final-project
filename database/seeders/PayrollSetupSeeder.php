<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\PayrollMonth;
use App\Enum\ProjectStatus;
use App\Enum\ApprovalStatus;
use Illuminate\Support\Facades\DB;

class PayrollSetupSeeder extends Seeder
{
    public function run(): void
    {
        // Get a valid user ID
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : null;
        
        if (!$userId) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }

        // Get or create a default project
        $project = Project::where('code', 'PROJ-DEFAULT')->first();
        if (!$project) {
            $project = Project::create([
                'code' => 'PROJ-DEFAULT',
                'name' => 'Default Payroll Project',
                'description' => 'Default project for payroll processing',
                'status' => ProjectStatus::InProgress,
                'created_by' => $userId,
            ]);
            $this->command->info('Created project: ' . $project->name);
        } else {
            $this->command->info('Using existing project: ' . $project->name);
        }

        // Create payroll months for current year
        $currentYear = date('Y');
        $createdMonths = 0;
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));
            $monthName = date('F', strtotime($startDate));
            
            PayrollMonth::create([
                'code' => 'PM-' . $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT),
                'name' => $monthName . ' ' . $currentYear . ' Payroll',
                'description' => 'Payroll period for ' . $monthName . ' ' . $currentYear,
                'project_id' => $project->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'approval_status' => ApprovalStatus::Approved,
                'created_by' => $userId,
            ]);
            $createdMonths++;
        }

        $this->command->info("Created {$createdMonths} payroll months for {$currentYear}");
    }
}
