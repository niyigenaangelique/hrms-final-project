<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KPI;
use App\Enum\ApprovalStatus;

class KPIDataSeeder extends Seeder
{
    public function run(): void
    {
        $kpis = [
            [
                'code' => 'KPI-001',
                'name' => 'Employee Turnover Rate',
                'description' => 'Percentage of employees who leave the organization annually.',
                'category' => 'Retention',
                'measurement_unit' => 'percentage',
                'target_type' => 'percentage',
                'target_value' => 10,
                'weight_percentage' => 30,
                'is_active' => true,
                'approval_status' => ApprovalStatus::Approved,
            ],
            [
                'code' => 'KPI-002',
                'name' => 'Absenteeism Rate',
                'description' => 'Frequency of employee absences relative to total workdays.',
                'category' => 'Attendance',
                'measurement_unit' => 'percentage',
                'target_type' => 'percentage',
                'target_value' => 3,
                'weight_percentage' => 20,
                'is_active' => true,
                'approval_status' => ApprovalStatus::Approved,
            ],
            [
                'code' => 'KPI-003',
                'name' => 'Training Completion Rate',
                'description' => 'Percentage of assigned trainings completed by employees.',
                'category' => 'Development',
                'measurement_unit' => 'percentage',
                'target_type' => 'percentage',
                'target_value' => 90,
                'weight_percentage' => 20,
                'is_active' => true,
                'approval_status' => ApprovalStatus::Approved,
            ],
            [
                'code' => 'KPI-004',
                'name' => 'eNPS (Employee Net Promoter Score)',
                'description' => 'Measure of employee loyalty and likelihood to recommend the workplace.',
                'category' => 'Engagement',
                'measurement_unit' => 'score',
                'target_type' => 'numeric',
                'target_value' => 20,
                'weight_percentage' => 30,
                'is_active' => true,
                'approval_status' => ApprovalStatus::Approved,
            ],
        ];

        foreach ($kpis as $kpiData) {
            KPI::updateOrCreate(['code' => $kpiData['code']], $kpiData);
        }
    }
}
