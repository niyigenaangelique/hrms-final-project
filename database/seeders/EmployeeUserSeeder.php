<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample employee accounts
        $employees = [
            [
                'code' => 'EMP-001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'john.doe',
                'email' => 'john.doe@company.com',
                'phone_number' => '0781234567',
                'role' => UserRole::Employee,
                'password' => 'password123', // Will be hashed
            ],
            [
                'code' => 'EMP-002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'username' => 'jane.smith',
                'email' => 'jane.smith@company.com',
                'phone_number' => '0782345678',
                'role' => UserRole::Employee,
                'password' => 'password123',
            ],
            [
                'code' => 'EMP-003',
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'username' => 'mike.johnson',
                'email' => 'mike.johnson@company.com',
                'phone_number' => '0783456789',
                'role' => UserRole::Employee,
                'password' => 'password123',
            ],
            [
                'code' => 'HR-001',
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'username' => 'sarah.wilson',
                'email' => 'sarah.wilson@company.com',
                'phone_number' => '0784567890',
                'role' => UserRole::HRManager,
                'password' => 'password123',
            ],
            [
                'code' => 'ADMIN-001',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'email' => 'admin@company.com',
                'phone_number' => '0785678901',
                'role' => UserRole::SuperAdmin,
                'password' => 'password123',
            ],
        ];

        foreach ($employees as $employee) {
            User::updateOrCreate(
                ['email' => $employee['email']],
                [
                    'code' => $employee['code'],
                    'first_name' => $employee['first_name'],
                    'last_name' => $employee['last_name'],
                    'username' => $employee['username'],
                    'phone_number' => $employee['phone_number'],
                    'role' => $employee['role'],
                    'password' => Hash::make($employee['password']),
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Employee user accounts created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Employee: john.doe@company.com / password123');
        $this->command->info('Employee: jane.smith@company.com / password123');
        $this->command->info('Employee: mike.johnson@company.com / password123');
        $this->command->info('HR Manager: sarah.wilson@company.com / password123');
        $this->command->info('Admin: admin@company.com / password123');
    }
}
