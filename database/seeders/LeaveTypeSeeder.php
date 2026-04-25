<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'code' => 'ANNUAL',
                'name' => 'Annual Leave',
                'description' => 'Annual leave entitlement (30 days per year)',
                'default_days' => 30,
                'max_days_per_year' => 30,
                'is_paid' => true,
                'requires_approval' => true,
                'requires_medical_document' => false,
                'auto_approve' => false,
                'deduct_from_annual' => false,
                'gender_restriction' => null,
                'doctor_extension_note' => null,
                'allow_carry_forward' => true,
                'max_carry_forward_days' => 10,
                'is_active' => true,
            ],
            [
                'code' => 'PERSONAL',
                'name' => 'Personal Leave',
                'description' => 'Personal leave (10-15 days per year)',
                'default_days' => 15,
                'max_days_per_year' => 15,
                'is_paid' => true,
                'requires_approval' => true,
                'requires_medical_document' => false,
                'auto_approve' => false,
                'deduct_from_annual' => false,
                'gender_restriction' => null,
                'doctor_extension_note' => null,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'MATERNITY',
                'name' => 'Maternity Leave',
                'description' => 'Maternity leave for female employees (45 days, extendable with doctor note)',
                'default_days' => 45,
                'max_days_per_year' => null, // No limit with doctor extension
                'is_paid' => true,
                'requires_approval' => true,
                'requires_medical_document' => true,
                'auto_approve' => false,
                'deduct_from_annual' => false,
                'gender_restriction' => 'female',
                'doctor_extension_note' => 'Doctor can extend days beyond 45 with medical certificate',
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'PATERNITY',
                'name' => 'Paternity Leave',
                'description' => 'Paternity leave for male employees (5-7 days)',
                'default_days' => 7,
                'max_days_per_year' => 7,
                'is_paid' => true,
                'requires_approval' => true,
                'requires_medical_document' => false,
                'auto_approve' => false,
                'deduct_from_annual' => false,
                'gender_restriction' => 'male',
                'doctor_extension_note' => null,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SICK',
                'name' => 'Sick Leave',
                'description' => 'Sick leave (requires medical document, no limit)',
                'default_days' => null,
                'max_days_per_year' => null, // No limit with medical document
                'is_paid' => true,
                'requires_approval' => true,
                'requires_medical_document' => true,
                'auto_approve' => false,
                'deduct_from_annual' => false,
                'gender_restriction' => null,
                'doctor_extension_note' => 'Medical document required from doctor',
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'BEREAVEMENT',
                'name' => 'Bereavement Leave',
                'description' => 'Bereavement leave (no HR approval required)',
                'default_days' => 5,
                'max_days_per_year' => 5,
                'is_paid' => true,
                'requires_approval' => false, // No HR approval needed
                'requires_medical_document' => false,
                'auto_approve' => true,
                'deduct_from_annual' => false,
                'gender_restriction' => null,
                'doctor_extension_note' => null,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'VACATION',
                'name' => 'Vacation Leave',
                'description' => 'Vacation leave (deducted from annual leave)',
                'default_days' => null,
                'max_days_per_year' => null, // Uses annual leave balance
                'is_paid' => true,
                'requires_approval' => true,
                'requires_medical_document' => false,
                'auto_approve' => false,
                'deduct_from_annual' => true, // Deduct from annual leave
                'gender_restriction' => null,
                'doctor_extension_note' => null,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::updateOrCreate(
                ['code' => $leaveType['code']],
                [
                    'name' => $leaveType['name'],
                    'description' => $leaveType['description'],
                    'default_days' => $leaveType['default_days'],
                    'max_days_per_year' => $leaveType['max_days_per_year'],
                    'is_paid' => $leaveType['is_paid'],
                    'requires_approval' => $leaveType['requires_approval'],
                    'requires_medical_document' => $leaveType['requires_medical_document'],
                    'auto_approve' => $leaveType['auto_approve'],
                    'deduct_from_annual' => $leaveType['deduct_from_annual'],
                    'gender_restriction' => $leaveType['gender_restriction'],
                    'doctor_extension_note' => $leaveType['doctor_extension_note'],
                    'allow_carry_forward' => $leaveType['allow_carry_forward'],
                    'max_carry_forward_days' => $leaveType['max_carry_forward_days'],
                    'is_active' => $leaveType['is_active'],
                ]
            );
        }

        $this->command->info('Leave types created successfully!');
    }
}
