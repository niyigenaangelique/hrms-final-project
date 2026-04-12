<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$contract = App\Models\Contract::first();
echo "Before Update - Status: " . $contract->status->value . "\n";

$data = [
    'status' => 'active'
];

try {
    $contract->update($data);
    echo "Update executed.\n";
    
    $contract->refresh();
    echo "After Update - Status: " . $contract->status->value . "\n";
    
} catch (\Exception $e) {
    echo "Update failed: " . $e->getMessage() . "\n";
}
