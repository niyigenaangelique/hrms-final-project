<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== User Check ===\n\n";

$users = User::all();
echo "Total users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "User: " . $user->email . "\n";
    echo "Name: " . $user->first_name . " " . $user->last_name . "\n";
    echo "Role: " . $user->role->value . "\n";
    echo "Status: " . ($user->email_verified_at ? 'Verified' : 'Not Verified') . "\n";
    echo "---\n";
}

if ($users->count() === 0) {
    echo "❌ No users found. You need to create an admin user.\n";
    echo "\nTo create an admin user, run:\n";
    echo "php artisan tinker\n";
    echo "User::create([\n";
    echo "  'first_name' => 'Admin',\n";
    echo "  'last_name' => 'User',\n";
    echo "  'email' => 'admin@example.com',\n";
    echo "  'password' => Hash::make('password'),\n";
    echo "  'role' => 'SuperAdmin',\n";
    echo "]);\n";
} else {
    echo "\n✅ Users found. Use any of these emails to login.\n";
    echo "If you don't know the password, you can reset it or create a new user.\n";
}

echo "\nDone.\n";
