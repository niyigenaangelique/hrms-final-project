<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$contract = App\Models\Contract::find('019c11ad-9ac0-706c-bae3-685bda542d8d');
echo "Raw DB values:\n";
print_r($contract->getAttributes());
echo "\nEloquent properties:\n";
echo "status enum value: " . $contract->status->value . "\n";
echo "status property: " . serialize($contract->status) . "\n";
