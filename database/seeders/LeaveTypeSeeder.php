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
                'code' => 'SICK',
                'name' => 'Sick Leave',
                'description' => 'Leave taken due to illness or medical reasons',
                'default_days' => 10,
                'is_paid' => true,
                'requires_approval' => true,
                'allow_carry_forward' => true,
                'max_carry_forward_days' => 5,
                'is_active' => true,
            ],
            [
                'code' => 'PERSONAL',
                'name' => 'Personal Leave',
                'description' => 'Leave taken for personal reasons and emergencies',
                'default_days' => 5,
                'is_paid' => true,
                'requires_approval' => true,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'VACATION',
                'name' => 'Vacation Leave',
                'description' => 'Annual vacation leave for rest and recreation',
                'default_days' => 21,
                'is_paid' => true,
                'requires_approval' => true,
                'allow_carry_forward' => true,
                'max_carry_forward_days' => 10,
                'is_active' => true,
            ],
            [
                'code' => 'MATERNITY',
                'name' => 'Maternity Leave',
                'description' => 'Leave for female employees during pregnancy and after childbirth',
                'default_days' => 90,
                'is_paid' => true,
                'requires_approval' => true,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'PATERNITY',
                'name' => 'Paternity Leave',
                'description' => 'Leave for male employees during childbirth of their partner',
                'default_days' => 7,
                'is_paid' => true,
                'requires_approval' => true,
                'allow_carry_forward' => false,
                'max_carry_forward_days' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'BEREAVEMENT',
                'name' => 'Bereavement Leave',
                'description' => 'Leave taken due to death of immediate family member',
                'default_days' => 3,
                'is_paid' => true,
                'requires_approval' => false,
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
                    'is_paid' => $leaveType['is_paid'],
                    'requires_approval' => $leaveType['requires_approval'],
                    'allow_carry_forward' => $leaveType['allow_carry_forward'],
                    'max_carry_forward_days' => $leaveType['max_carry_forward_days'],
                    'is_active' => $leaveType['is_active'],
                ]
            );
        }

        $this->command->info('Leave types created successfully!');
    }
}
