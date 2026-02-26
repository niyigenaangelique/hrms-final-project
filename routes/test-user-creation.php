<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

Route::get('/test-user-creation', function (Request $request) {
    try {
        Log::info('Test user creation started');
        
        $user = User::create([
            'code' => 'TEST-001',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test' . time() . '@example.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('password123'),
            'role' => 'Employee',
            'username' => 'testuser',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password_changed_at' => now(),
        ]);
        
        Log::info('Test user created successfully with ID: ' . $user->id);
        
        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'code' => $user->code,
            'username' => $user->username,
        ]);
        
    } catch (\Exception $e) {
        Log::error('Test user creation failed: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});
