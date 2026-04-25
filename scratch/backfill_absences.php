<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use App\Models\Attendance;

// Get a valid device_id for the system (just pick the first one or null if we can)
$deviceId = \DB::table('devices')->first()?->id;

for ($i = 1; $i < 23; $i++) {
    $date = '2026-04-' . str_pad($i, 2, '0', STR_PAD_LEFT);
    echo "Processing $date...\n";
    
    $employees = Employee::where('is_active', true)
        ->whereHas('user', fn($q) => $q->where('role', 'employee'))
        ->whereDoesntHave('attendances', fn($q) => $q->where('date', $date))
        ->whereDoesntHave('leaveRequests', fn($q) => $q->where('status', 'approved')->whereDate('start_date', '<=', $date)->whereDate('end_date', '>=', $date))
        ->get();
        
    foreach ($employees as $emp) {
        try {
            Attendance::create([
                'employee_id' => $emp->id,
                'date'        => $date,
                'check_in'    => '00:00:00', // Dummy for Absent
                'device_id'   => $deviceId,  // Dummy for System
                'daily_status'=> 'Absent',
                'status'      => 'Entered',
                'code'        => 'ATT-ABS-' . $emp->code . '-' . str_replace('-', '', $date),
                'notes'       => 'System backfill: Absent'
            ]);
        } catch (\Exception $e) {
            echo "Error for {$emp->first_name} on $date: " . $e->getMessage() . "\n";
        }
    }
}
echo "Done backfilling April.\n";
