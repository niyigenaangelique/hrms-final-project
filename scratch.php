<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$component = app(App\Livewire\Analytics\AnalyticsDashboard::class);
$view = $component->render();
echo $view->render();
