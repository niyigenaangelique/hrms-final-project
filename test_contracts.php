<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = "";
$contracts = App\Models\Contract::select('id', 'status', 'approval_status')->get();
foreach ($contracts as $contract) {
    $output .= "ID: " . $contract->id . "\n";
    $output .= "Status: " . (is_object($contract->status) ? $contract->status->value : $contract->status) . "\n";
}
$output .= "Count where status=active: " . App\Models\Contract::where('status', 'active')->count() . "\n";

file_put_contents('test_contracts_output.txt', $output);
