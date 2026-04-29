<?php

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Str;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$deviceId = '019dd657-2d3c-7270-899d-e68143b99e6c'; // Provided device ID
$employees = Employee::where('is_active', true)->get();

$months = [
    ['month' => 1, 'year' => 2026, 'days' => 31],
    ['month' => 2, 'year' => 2026, 'days' => 28],
    ['month' => 3, 'year' => 2026, 'days' => 31],
];

echo "Starting backfill for " . $employees->count() . " employees...\n";

foreach ($months as $m) {
    for ($day = 1; $day <= $m['days']; $day++) {
        $date = Carbon::create($m['year'], $m['month'], $day);
        
        // Skip weekends
        if ($date->isWeekend()) {
            continue;
        }
        
        foreach ($employees as $employee) {
            // Check if record already exists to avoid duplicates
            $exists = Attendance::where('employee_id', $employee->id)
                ->where('date', $date->format('Y-m-d'))
                ->exists();
                
            if (!$exists) {
                Attendance::create([
                    'id' => Str::uuid(),
                    'code' => 'ATT-' . strtoupper(Str::random(8)),
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                    'check_in' => '08:00:00',
                    'check_out' => '17:00:00', // 9 hours total, which implies 1 hour break = 8 working hours
                    'device_id' => $deviceId,
                    'check_in_method' => 'Manuel Input',
                    'check_out_method' => 'Manuel Input',
                    'status' => 'Entered',
                    'approval_status' => 'not applicable',
                    'is_locked' => false,
                ]);
            }
        }
    }
    echo "Completed " . $date->format('F Y') . "\n";
}

echo "Backfill complete!\n";
