<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$contracts = App\Models\Contract::all();
$count = 0;
foreach ($contracts as $contract) {
    if ($contract->employee && $contract->employee->position_id && $contract->position_id !== $contract->employee->position_id) {
        $contract->position_id = $contract->employee->position_id;
        $contract->save();
        $count++;
    }
}
echo "Synchronized $count contracts with their employee's position.";
