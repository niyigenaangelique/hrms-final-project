<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rows = Illuminate\Support\Facades\DB::select('SELECT id, status FROM contracts');

$out = "RAW DATABASE VALUES:\n";
foreach ($rows as $row) {
    $out .= "ID: {$row->id} | Status: {$row->status}\n";
}

file_put_contents('db_raw.txt', $out);
