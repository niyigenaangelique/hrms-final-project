<?php

echo "=== Payroll CRUD Syntax Validation ===\n\n";

// Test 1: Check if all files exist and are syntactically correct
$files = [
    'app/Livewire/Payroll/PayrollEntryManager.php',
    'app/Livewire/Payroll/PayrollMonthManager.php', 
    'app/Livewire/Payroll/PaymentHistoryManager.php',
    'app/Livewire/Payroll/PayslipEntryManager.php',
    'app/Models/PayrollEntry.php',
    'app/Models/PayrollMonth.php',
    'app/Models/PaymentHistory.php',
    'app/Models/PayslipEntry.php',
    'app/Enum/ApprovalStatus.php',
    'app/Enum/PaymentStatus.php',
    'app/Enum/AttendanceStatus.php',
    'app/Enum/PayslipStatus.php'
];

echo "1. Checking file syntax:\n";
foreach ($files as $file) {
    if (file_exists($file)) {
        $output = [];
        $returnCode = 0;
        exec("php -l \"$file\" 2>&1", $output, $returnCode);
        
        if ($returnCode === 0) {
            echo "   $file: OK\n";
        } else {
            echo "   $file: SYNTAX ERROR\n";
            foreach ($output as $line) {
                echo "     $line\n";
            }
        }
    } else {
        echo "   $file: MISSING\n";
    }
}

// Test 2: Check for common issues in Livewire files
echo "\n2. Checking Livewire file patterns:\n";
$livewireFiles = [
    'app/Livewire/Payroll/PayrollEntryManager.php',
    'app/Livewire/Payroll/PayrollMonthManager.php',
    'app/Livewire/Payroll/PaymentHistoryManager.php', 
    'app/Livewire/Payroll/PayslipEntryManager.php'
];

foreach ($livewireFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Check for required methods
        $requiredMethods = ['save', 'render', 'rules', 'messages'];
        $missingMethods = [];
        
        foreach ($requiredMethods as $method) {
            if (!preg_match("/function\s+$method\s*\(/", $content)) {
                $missingMethods[] = $method;
            }
        }
        
        if (empty($missingMethods)) {
            echo "   " . basename($file) . ": All required methods present\n";
        } else {
            echo "   " . basename($file) . ": Missing methods: " . implode(', ', $missingMethods) . "\n";
        }
        
        // Check for validation error handling
        if (preg_match("/ValidationException/", $content)) {
            echo "   " . basename($file) . ": Has validation error handling\n";
        } else {
            echo "   " . basename($file) . ": WARNING - No validation error handling\n";
        }
        
        // Check for database transactions
        if (preg_match("/DB::beginTransaction/", $content)) {
            echo "   " . basename($file) . ": Uses database transactions\n";
        } else {
            echo "   " . basename($file) . ": WARNING - No database transactions\n";
        }
    }
}

echo "\n3. Checking enum consistency:\n";
$enumFiles = [
    'app/Enum/ApprovalStatus.php' => ['initiated', 'pending', 'under_review', 'approved', 'rejected', 'cancelled'],
    'app/Enum/PaymentStatus.php' => ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'],
    'app/Enum/AttendanceStatus.php' => ['present', 'absent', 'late', 'leave', 'holiday'],
    'app/Enum/PayslipStatus.php' => ['active', 'inactive', 'cancelled', 'paid']
];

foreach ($enumFiles as $file => $expectedValues) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $foundValues = [];
        foreach ($expectedValues as $value) {
            if (preg_match("/case\s+[A-Z_]+\s*=\s*'$value'/", $content)) {
                $foundValues[] = $value;
            }
        }
        
        if (count($foundValues) === count($expectedValues)) {
            echo "   " . basename($file) . ": All expected values present\n";
        } else {
            $missing = array_diff($expectedValues, $foundValues);
            echo "   " . basename($file) . ": Missing values: " . implode(', ', $missing) . "\n";
        }
    } else {
        echo "   " . basename($file) . ": MISSING\n";
    }
}

echo "\n=== Syntax Check Complete ===\n";
