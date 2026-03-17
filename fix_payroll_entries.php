<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\Employee;
use App\Models\User;

echo "=== Fixing Payroll Entries ===\n\n";

// Get approved employees
$employees = Employee::where('approval_status', 'Approved')->get();
echo "Found " . $employees->count() . " approved employees\n";

// Get latest payroll month
$payrollMonth = PayrollMonth::orderBy('start_date', 'desc')->first();
if (!$payrollMonth) {
    echo "❌ No payroll month found!\n";
    exit;
}

echo "Using payroll month: " . $payrollMonth->name . "\n\n";

// Get a valid user ID for created_by
$user = User::first();
if (!$user) {
    echo "❌ No user found for created_by!\n";
    exit;
}

$createdBy = $user->id;
echo "Using user ID: " . $createdBy . "\n\n";

// Delete existing payroll entries to start fresh
PayrollEntry::where('payroll_month_id', $payrollMonth->id)->delete();
echo "Cleared existing payroll entries\n";

// Create new payroll entries with proper salaries
foreach ($employees as $employee) {
    // Set a default salary if not set
    $salary = $employee->monthly_salary ?: 100000; // Default to 100,000 if not set
    
    echo "Creating payroll entry for: " . $employee->first_name . " " . $employee->last_name . "\n";
    echo "- Salary: " . $salary . "\n";
    
    try {
        $payrollEntry = PayrollEntry::create([
            'code' => 'PE-' . strtoupper(uniqid()),
            'payroll_month_id' => $payrollMonth->id,
            'employee_id' => $employee->id,
            'total_amount' => $salary,
            'approval_status' => 'approved',
            'is_locked' => false,
            'created_by' => $createdBy,
        ]);
        
        echo "✅ Created payroll entry: " . $payrollEntry->code . "\n";
        
    } catch (\Exception $e) {
        echo "❌ Error creating payroll entry: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "=== Verification ===\n";
$entries = PayrollEntry::with(['employee', 'payrollMonth'])->get();
echo "Total payroll entries: " . $entries->count() . "\n";

foreach ($entries as $entry) {
    echo "- " . $entry->employee->first_name . " " . $entry->employee->last_name . ": " . $entry->total_amount . "\n";
}

echo "\n✅ Payroll entries are now ready for payslip generation!\n";
echo "You can now go to /payroll/payslip-generator and process payroll.\n";
