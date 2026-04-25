<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;

$deptId = '019d45ba-9f6b-70c0-b3f2-ad2cb20acac7';
$alineId = '019d4552-f257-7266-954f-4ee7aad45a9c';
$janviereId = '019d4a76-9cfa-736e-84fe-ddbe9b858f79';

$startDate = '2026-04-23';
$endDate   = '2026-04-28';

echo "=== All leave requests in dept for Apr 23-28 ===\n";
$results = LeaveRequest::where('employee_id', '!=', $janviereId)
    ->whereIn('status', ['pending', 'approved'])
    ->where('start_date', '<=', $endDate)
    ->where('end_date', '>=', $startDate)
    ->whereHas('employee', function($q) use ($deptId) {
        $q->where('department_id', $deptId);
    })
    ->whereHas('leaveType', function($q) {
        $q->where(function($sub) {
            foreach (['annual', 'vacation', 'personal'] as $rt) {
                $sub->orWhere('name', 'like', "%$rt%");
            }
        });
    })
    ->with(['employee', 'leaveType'])
    ->get();

echo "Count: " . $results->count() . "\n";
foreach ($results as $r) {
    echo "  " . $r->employee->first_name . " | " . $r->leaveType->name . " | " . $r->status . " | " . $r->start_date->format('Y-m-d') . " to " . $r->end_date->format('Y-m-d') . "\n";
}

echo "\n=== LeaveType 'Personal Leave' check ===\n";
$lt = LeaveType::where('name', 'like', '%personal%')->first();
if ($lt) {
    echo "Found: " . $lt->name . " | deduct_from_annual: " . ($lt->deduct_from_annual ? 'yes' : 'no') . "\n";
} else {
    echo "No personal leave type found!\n";
    LeaveType::all()->each(fn($l) => print("  Type: " . $l->name . "\n"));
}

echo "\n=== LeaveService::validateLeaveRequest simulation ===\n";
$employee = Employee::find($janviereId);
$leaveType = LeaveType::where('name', 'like', '%personal%')->first();
if ($leaveType && $employee) {
    $result = \App\Services\LeaveService::validateLeaveRequest(
        $employee,
        $leaveType,
        Carbon::parse($startDate),
        Carbon::parse($endDate),
        6
    );
    echo "Valid: " . ($result['valid'] ? 'yes' : 'no') . "\n";
    echo "Errors: " . implode(', ', $result['errors']) . "\n";
}
