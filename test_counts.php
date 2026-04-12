<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$strCount = App\Models\Contract::where('status', 'active')->count();
$enumCount = App\Models\Contract::where('status', App\Enum\ContractStatus::ACTIVE)->count();

$out = "String count: $strCount\nEnum count: $enumCount\n";
file_put_contents('test_counts.txt', $out);
