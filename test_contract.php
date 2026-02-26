<?php

require_once 'vendor/autoload.php';

use App\Models\Contract;
use App\Models\Employee;
use App\Models\Position;

echo "Testing contract creation...\n";

try {
    // Get sample data
    $employee = Employee::first();
    $position = Position::first();
    
    if (!$employee || !$position) {
        echo "No employee or position found in database\n";
        exit;
    }
    
    echo "Employee ID: " . $employee->id . "\n";
    echo "Position ID: " . $position->id . "\n";
    
    // Test contract creation
    $contractData = [
        'code' => 'SGA-00001',
        'employee_id' => $employee->id,
        'position_id' => $position->id,
        'remuneration' => 5000.00,
        'remuneration_type' => 'Daily',
        'employee_category' => 'Casual',
        'daily_working_hours' => 9.0,
        'start_date' => now()->format('Y-m-d'),
        'end_date' => now()->addMonths(6)->format('Y-m-d'),
        'status' => 'draft',
        'approval_status' => 'not applicable',
        'is_locked' => false,
        'created_by' => null,
        'updated_by' => null,
        'deleted_by' => null,
    ];
    
    echo "Creating contract with data:\n";
    print_r($contractData);
    
    $contract = Contract::create($contractData);
    
    echo "Contract created successfully! ID: " . $contract->id . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
