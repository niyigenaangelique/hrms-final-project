<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\Employee;

echo "=== Payroll System Check ===\n\n";

// Check employees
$employees = Employee::where('approval_status', 'Approved')->get();
echo "Approved Employees: " . $employees->count() . "\n";

if ($employees->count() > 0) {
    echo "Sample employee: " . $employees->first()->first_name . " " . $employees->first()->last_name . "\n";
    echo "Monthly salary: " . $employees->first()->monthly_salary . "\n\n";
}

// Check payroll months
$payrollMonths = PayrollMonth::get();
echo "Payroll Months: " . $payrollMonths->count() . "\n";

if ($payrollMonths->count() > 0) {
    echo "Latest month: " . $payrollMonths->first()->name . "\n";
    echo "Period: " . $payrollMonths->first()->start_date . " to " . $payrollMonths->first()->end_date . "\n\n";
}

// Check payroll entries
$payrollEntries = PayrollEntry::with(['employee', 'payrollMonth'])->get();
echo "Payroll Entries: " . $payrollEntries->count() . "\n";

if ($payrollEntries->count() > 0) {
    echo "Latest entry:\n";
    $entry = $payrollEntries->first();
    echo "- Employee: " . $entry->employee->first_name . " " . $entry->employee->last_name . "\n";
    echo "- Amount: " . $entry->total_amount . "\n";
    echo "- Month: " . $entry->payrollMonth->name . "\n";
    echo "- Status: " . $entry->approval_status->value . "\n";
    echo "- Has Payslip: " . ($entry->payslipEntry ? "Yes" : "No") . "\n\n";
} else {
    echo "❌ NO PAYROLL ENTRIES FOUND\n";
    echo "You need to create payroll entries first!\n\n";
}

echo "=== Recommendations ===\n";
if ($employees->count() === 0) {
    echo "1. Create and approve employees first\n";
}
if ($payrollMonths->count() === 0) {
    echo "2. Ensure payroll months are created\n";
}
if ($payrollEntries->count() === 0) {
    echo "3. Create payroll entries for employees\n";
    echo "4. Use payroll entry creation form or script\n";
}

echo "\nDone.\n";
