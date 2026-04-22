<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $exists = User::where('role', 'admin')->exists();

        if ($exists) {
            $this->command->warn('Admin user already exists — skipping.');
            return;
        }

        User::create([
            'id'           => Str::uuid(),
            'code'         => 'USR-00001',
            'first_name'   => 'System',
            'middle_name'  => null,
            'last_name'    => 'Administrator',
            'username'     => 'admin',
            'email'        => 'admin@talentflow.rw',
            'phone_number' => null,
            'password'     => Hash::make('Admin@1234'),
            'role'         => 'admin',
        ]);

        $this->command->info('✓ Admin user created.');
        $this->command->line('  Email:    admin@talentflow.rw');
        $this->command->line('  Password: Admin@1234');
        $this->command->warn('  ⚠  Change this password immediately after first login!');
    }
}

