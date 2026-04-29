<?php
require dirname(__DIR__).'/vendor/autoload.php';
$app = require_once dirname(__DIR__).'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TaxBracket;

foreach (TaxBracket::all() as $b) {
    if ($b->rate >= 1) {
        $b->update(['rate' => $b->rate / 100]);
        echo "Updated bracket ID {$b->id} rate to {$b->rate}\n";
    }
}
echo "Done.\n";
