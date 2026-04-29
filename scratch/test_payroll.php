<?php
require dirname(__DIR__).'/vendor/autoload.php';
$app = require_once dirname(__DIR__).'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use App\Models\PayrollMonth;
use App\Services\PayrollService;

$e = Employee::where('code', 'EMP-0007')->first();
$m = PayrollMonth::where('name', 'like', '%April%')->first();

if (!$e || !$m) {
    die("Employee or Month not found\n");
}

$s = new PayrollService();
$data = $s->calculateEmployeePayroll($e, $m);
print_r($data);
