<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['code' => 'POS-001', 'name' => 'Software Engineer', 'description' => 'Develops and maintains software applications'],
            ['code' => 'POS-002', 'name' => 'HR Manager', 'description' => 'Manages human resources operations'],
            ['code' => 'POS-003', 'name' => 'Accountant', 'description' => 'Handles financial records and accounting'],
            ['code' => 'POS-004', 'name' => 'Marketing Specialist', 'description' => 'Manages marketing campaigns and strategies'],
            ['code' => 'POS-005', 'name' => 'Project Manager', 'description' => 'Oversees project execution and team coordination'],
            ['code' => 'POS-006', 'name' => 'Sales Representative', 'description' => 'Handles sales and client relationships'],
            ['code' => 'POS-007', 'name' => 'Customer Service Representative', 'description' => 'Provides customer support and service'],
            ['code' => 'POS-008', 'name' => 'Data Analyst', 'description' => 'Analyzes data and provides insights'],
            ['code' => 'POS-009', 'name' => 'Office Manager', 'description' => 'Manages office operations and administration'],
            ['code' => 'POS-010', 'name' => 'Quality Assurance Engineer', 'description' => 'Ensures product quality and testing'],
        ];

        foreach ($positions as $position) {
            Position::updateOrCreate(
                ['code' => $position['code']],
                [
                    'name' => $position['name'],
                    'description' => $position['description'],
                    'approval_status' => \App\Enum\ApprovalStatus::Approved,
                ]
            );
        }

        $this->command->info('Positions created successfully!');
    }
}
