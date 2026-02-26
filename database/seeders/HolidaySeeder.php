<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HolidaySeeder extends Seeder
{
    public function run()
    {
        $holidays = [
            [
                'code' => 'HOL-001',
                'name' => 'New Year\'s Day',
                'description' => 'New Year\'s Day celebration',
                'date' => Carbon::createFromDate(2026, 1, 1),
                'is_recurring' => true,
                'type' => 'public',
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => null,
            ],
            [
                'code' => 'HOL-002',
                'name' => 'Workers Day',
                'description' => 'International Workers Day',
                'date' => Carbon::createFromDate(2026, 5, 1),
                'is_recurring' => true,
                'type' => 'public',
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => null,
            ],
            [
                'code' => 'HOL-003',
                'name' => 'Independence Day',
                'description' => 'National Independence Day',
                'date' => Carbon::createFromDate(2026, 7, 4),
                'is_recurring' => true,
                'type' => 'public',
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => null,
            ],
            [
                'code' => 'HOL-004',
                'name' => 'Christmas Day',
                'description' => 'Christmas celebration',
                'date' => Carbon::createFromDate(2026, 12, 25),
                'is_recurring' => true,
                'type' => 'public',
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => null,
            ],
        ];

        foreach ($holidays as $holiday) {
            Holiday::updateOrCreate(['code' => $holiday['code']], $holiday);
        }
    }
}
