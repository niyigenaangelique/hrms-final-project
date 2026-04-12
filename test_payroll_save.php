<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $m = \App\Models\PayrollMonth::create([
        'code'            => 'PM-TEST-DX',
        'name'            => 'Test Month',
        'start_date'      => '2025-04-01',
        'end_date'        => '2025-04-30',
        'approval_status' => 'pending',
    ]);
    echo "PayrollMonth saved OK: " . $m->id . "\n";
} catch (\Exception $e) {
    echo "PayrollMonth ERROR: " . $e->getMessage() . "\nPREV: " . ($e->getPrevious() ? $e->getPrevious()->getMessage() : 'none') . "\n";
}

// Get first employee and month for entry test
$emp = \App\Models\Employee::first();
$month = \App\Models\PayrollMonth::first();

if ($emp && $month) {
    try {
        $e = \App\Models\PayrollEntry::create([
            'code'             => 'PE-TEST-DX',
            'payroll_month_id' => $month->id,
            'employee_id'      => $emp->id,
            'daily_rate'       => 22727.27,
            'work_days'        => 22,
            'work_days_pay'    => 499999.94,
            'total_amount'     => 499999.94,
            'status'           => 'Entered',
            'approval_status'  => 'pending',
        ]);
        echo "PayrollEntry saved OK: " . $e->id . "\n";
    } catch (\Exception $e) {
        echo "PayrollEntry ERROR: " . $e->getMessage() . "\nPREV: " . ($e->getPrevious() ? $e->getPrevious()->getMessage() : 'none') . "\n";
    }
} else {
    echo "No employee or month found to test PayrollEntry\n";
}
