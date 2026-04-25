<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Employee;

$names = ['Aline', 'Janviere', 'Uwineza', 'Iradukunda'];
$emps = Employee::where(function($q) use ($names) {
    foreach($names as $n) {
        $q->orWhere('first_name', 'like', "%$n%")
          ->orWhere('last_name', 'like', "%$n%");
    }
})->get();

foreach($emps as $e) {
    echo "Employee: " . $e->first_name . " " . $e->last_name . " | ID: " . $e->id . " | DeptID: " . ($e->department_id ?: 'NULL') . "\n";
}
