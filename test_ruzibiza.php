<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$emp = App\Models\Employee::where('first_name', 'like', '%Ruzibiza%')->orWhere('last_name', 'like', '%Ruzibiza%')->first();

$out = "Employee Name: " . $emp->first_name . " " . $emp->last_name . "\n";
$out .= "Employee Position ID: " . $emp->position_id . "\n";
if ($emp->position_id) {
    $out .= "Employee Position Name: " . App\Models\Position::find($emp->position_id)->name . "\n";
}

$contract = App\Models\Contract::where('employee_id', $emp->id)->first();
if ($contract) {
    $out .= "Contract ID: " . $contract->id . "\n";
    $out .= "Contract Position ID: " . $contract->position_id . "\n";
    if ($contract->position_id) {
        $out .= "Contract Position Name: " . App\Models\Position::find($contract->position_id)->name . "\n";
    }
}
file_put_contents('ruzibiza_data.txt', $out);
