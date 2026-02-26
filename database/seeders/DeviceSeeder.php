<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        $devices = [
            [
                'code' => 'DEV-001',
                'name' => 'Web Portal',
                'description' => 'Web-based attendance system',
                'type' => 'web',
                'status' => 'active',
                'created_by' => null,
            ],
            [
                'code' => 'DEV-002', 
                'name' => 'Mobile App',
                'description' => 'Mobile application for attendance',
                'type' => 'mobile',
                'status' => 'active',
                'created_by' => null,
            ],
        ];

        foreach ($devices as $device) {
            Device::updateOrCreate(['code' => $device['code']], $device);
        }
    }
}
