<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Password Reset ===\n\n";

// Reset admin password to 'password'
$user = User::where('email', 'admin@company.com')->first();

if ($user) {
    $user->password = Hash::make('password');
    $user->save();
    
    echo "✅ Password reset successfully!\n\n";
    echo "Login Details:\n";
    echo "Email: admin@company.com\n";
    echo "Password: password\n\n";
    echo "Go to: http://localhost:8000/login\n";
    echo "Then: http://localhost:8000/payroll/dashboard\n";
} else {
    echo "❌ User admin@company.com not found\n";
}

echo "\nDone.\n";
