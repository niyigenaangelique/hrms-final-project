<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Employee;
use App\Models\LeaveRequest;

$emps = Employee::whereIn('first_name', ['Aline', 'Janviere'])->get();

foreach($emps as $emp) {
    echo "Employee: " . $emp->first_name . " " . $emp->last_name . " (" . $emp->id . ")\n";
    echo "Department ID: " . $emp->department_id . "\n";
    echo "Department Name: " . ($emp->departmentAssignment?->name ?? 'N/A') . "\n";
    
    $leaves = LeaveRequest::where('employee_id', $emp->id)->get();
    foreach($leaves as $l) {
        echo "  Leave: " . $l->leaveType?->name . " | Start: " . $l->start_date->format('Y-m-d') . " | End: " . $l->end_date->format('Y-m-d') . " | Status: " . $l->status . "\n";
    }
    echo "-------------------\n";
}
