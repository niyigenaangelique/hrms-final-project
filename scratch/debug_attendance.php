<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use App\Models\Attendance;

$emp = Employee::where('first_name', 'Ruzibiza')->first();
if($emp) {
    echo "Employee: " . $emp->first_name . " " . $emp->last_name . " (" . $emp->id . ")\n";
    echo "Shift: " . ($emp->shift ? $emp->shift->name . " (" . $emp->shift->start_time->format('H:i') . "-" . $emp->shift->end_time->format('H:i') . ")" : "None") . "\n";
    $openSessions = Attendance::where('employee_id', $emp->id)->whereNull('check_out')->orderBy('date', 'asc')->get();
    if($openSessions->count() > 0) {
        echo "Found " . $openSessions->count() . " open sessions:\n";
        foreach($openSessions as $s) {
            echo "Date: " . $s->date->format('Y-m-d') . " | In: " . $s->check_in . " | ID: " . $s->id . "\n";
        }
    } else {
        echo "No open sessions found.\n";
    }
} else {
    echo "Employee Ruzibiza not found\n";
}
