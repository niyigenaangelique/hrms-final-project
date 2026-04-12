<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$query = App\Models\Contract::where('status', 'active');
echo $query->toSql() . "\n";
print_r($query->getBindings());

$queryEnum = App\Models\Contract::where('status', App\Enum\ContractStatus::ACTIVE);
echo $queryEnum->toSql() . "\n";
print_r($queryEnum->getBindings());
