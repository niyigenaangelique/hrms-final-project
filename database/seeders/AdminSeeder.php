<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the main admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'angelbrenna20@gmail.com'],
            [
                'first_name' => 'Angel',
                'last_name' => 'Brenna',
                'email' => 'angelbrenna20@gmail.com',
                'phone_number' => '+1234567890',
                'role' => \App\Enum\UserRole::SuperAdmin,
                'password' => Hash::make('Niyigena2003@'),
                'email_verified_at' => now(),
            ]
        );

        // Create corresponding employee record for the admin
        Employee::updateOrCreate(
            ['email' => 'angelbrenna20@gmail.com'],
            [
                'code' => 'ADMIN-001',
                'first_name' => 'Angel',
                'last_name' => 'Brenna',
                'email' => 'angelbrenna20@gmail.com',
                'phone_number' => '+1234567890',
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => $adminUser->id,
                'updated_by' => $adminUser->id,
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: angelbrenna20@gmail.com');
        $this->command->info('Password: Niyigena2003@');
    }
}
