<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\PaymentHistory;
use App\Models\PayslipEntry;
use App\Models\Employee;

echo "=== Payroll CRUD Operations Test ===\n\n";

// Test 1: Check if models exist and can be instantiated
echo "1. Testing Model Instantiation:\n";
try {
    $payrollEntry = new PayrollEntry();
    echo "   PayrollEntry: OK\n";
} catch (Exception $e) {
    echo "   PayrollEntry: FAILED - " . $e->getMessage() . "\n";
}

try {
    $payrollMonth = new PayrollMonth();
    echo "   PayrollMonth: OK\n";
} catch (Exception $e) {
    echo "   PayrollMonth: FAILED - " . $e->getMessage() . "\n";
}

try {
    $paymentHistory = new PaymentHistory();
    echo "   PaymentHistory: OK\n";
} catch (Exception $e) {
    echo "   PaymentHistory: FAILED - " . $e->getMessage() . "\n";
}

try {
    $payslipEntry = new PayslipEntry();
    echo "   PayslipEntry: OK\n";
} catch (Exception $e) {
    echo "   PayslipEntry: FAILED - " . $e->getMessage() . "\n";
}

// Test 2: Check enum classes exist
echo "\n2. Testing Enum Classes:\n";
try {
    $approvalStatus = \App\Enum\ApprovalStatus::cases();
    echo "   ApprovalStatus: OK (" . count($approvalStatus) . " values)\n";
} catch (Exception $e) {
    echo "   ApprovalStatus: FAILED - " . $e->getMessage() . "\n";
}

try {
    $paymentStatus = \App\Enum\PaymentStatus::cases();
    echo "   PaymentStatus: OK (" . count($paymentStatus) . " values)\n";
} catch (Exception $e) {
    echo "   PaymentStatus: FAILED - " . $e->getMessage() . "\n";
}

try {
    $attendanceStatus = \App\Enum\AttendanceStatus::cases();
    echo "   AttendanceStatus: OK (" . count($attendanceStatus) . " values)\n";
} catch (Exception $e) {
    echo "   AttendanceStatus: FAILED - " . $e->getMessage() . "\n";
}

try {
    $payslipStatus = \App\Enum\PayslipStatus::cases();
    echo "   PayslipStatus: OK (" . count($payslipStatus) . " values)\n";
} catch (Exception $e) {
    echo "   PayslipStatus: FAILED - " . $e->getMessage() . "\n";
}

// Test 3: Check Livewire classes exist
echo "\n3. Testing Livewire Classes:\n";
try {
    $manager = new \App\Livewire\Payroll\PayrollEntryManager();
    echo "   PayrollEntryManager: OK\n";
} catch (Exception $e) {
    echo "   PayrollEntryManager: FAILED - " . $e->getMessage() . "\n";
}

try {
    $manager = new \App\Livewire\Payroll\PayrollMonthManager();
    echo "   PayrollMonthManager: OK\n";
} catch (Exception $e) {
    echo "   PayrollMonthManager: FAILED - " . $e->getMessage() . "\n";
}

try {
    $manager = new \App\Livewire\Payroll\PaymentHistoryManager();
    echo "   PaymentHistoryManager: OK\n";
} catch (Exception $e) {
    echo "   PaymentHistoryManager: FAILED - " . $e->getMessage() . "\n";
}

try {
    $manager = new \App\Livewire\Payroll\PayslipEntryManager();
    echo "   PayslipEntryManager: OK\n";
} catch (Exception $e) {
    echo "   PayslipEntryManager: FAILED - " . $e->getMessage() . "\n";
}

// Test 4: Check database tables exist (basic check)
echo "\n4. Testing Database Tables:\n";
try {
    $tables = [
        'payroll_entries',
        'payroll_months', 
        'payment_histories',
        'payslip_entries',
        'employees'
    ];
    
    foreach ($tables as $table) {
        $result = \Illuminate\Support\Facades\Schema::hasTable($table);
        echo "   $table: " . ($result ? "OK" : "MISSING") . "\n";
    }
} catch (Exception $e) {
    echo "   Database check: FAILED - " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
