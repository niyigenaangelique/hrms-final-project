<?php

echo "=== Payroll Entry Debug Helper ===\n\n";

// Check Laravel log for recent errors
$logFile = __DIR__ . '/storage/logs/laravel.log';

if (file_exists($logFile)) {
    echo "1. Recent Laravel log entries (last 20 lines):\n";
    echo "----------------------------------------\n";
    
    $lines = file($logFile);
    $recentLines = array_slice($lines, -20);
    
    foreach ($recentLines as $line) {
        echo trim($line) . "\n";
    }
} else {
    echo "Log file not found at: $logFile\n";
}

echo "\n2. Checking database connections:\n";
echo "----------------------------------------\n";

try {
    // Try to connect to database without Laravel bootstrap
    $config = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'casual_hrms',
        'username' => 'root',
        'password' => '',
    ];
    
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection: SUCCESS\n";
    
    // Check if required tables exist
    $tables = ['employees', 'payroll_months', 'payroll_entries'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "Table '$table': EXISTS\n";
            
            // Check row counts
            $countStmt = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
            $count = $countStmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "  Records: $count\n";
        } else {
            echo "Table '$table': MISSING\n";
        }
    }
    
} catch (Exception $e) {
    echo "Database connection: FAILED - " . $e->getMessage() . "\n";
}

echo "\n3. Common payroll entry issues to check:\n";
echo "----------------------------------------\n";
echo "a) Make sure you have at least one employee created\n";
echo "b) Make sure you have at least one payroll month created\n";
echo "c) Check that employee daily_rate and hourly_rate are numeric\n";
echo "d) Verify payroll entry code is unique\n";
echo "e) Ensure all required fields are filled:\n";
echo "   - Employee (required)\n";
echo "   - Payroll Month (required)\n";
echo "   - Daily Rate (required, numeric)\n";
echo "   - Work Days (required, numeric)\n";

echo "\n4. Quick test data check:\n";
echo "----------------------------------------\n";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=casual_hrms;charset=utf8mb4", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check for employees with rates
    $stmt = $pdo->query("SELECT id, first_name, last_name, daily_rate, hourly_rate FROM employees LIMIT 5");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($employees)) {
        echo "WARNING: No employees found in database\n";
    } else {
        echo "Sample employees:\n";
        foreach ($employees as $emp) {
            $rateStatus = ($emp['daily_rate'] > 0) ? "OK" : "MISSING RATE";
            echo "  - {$emp['first_name']} {$emp['last_name']} (ID: {$emp['id']}) - Daily Rate: $rateStatus\n";
        }
    }
    
    // Check for payroll months
    $stmt = $pdo->query("SELECT id, code, name, start_date, end_date FROM payroll_months LIMIT 5");
    $months = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($months)) {
        echo "WARNING: No payroll months found in database\n";
    } else {
        echo "Sample payroll months:\n";
        foreach ($months as $month) {
            echo "  - {$month['code']}: {$month['name']} (ID: {$month['id']})\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error checking test data: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
echo "\nIf you're still getting errors, check the Laravel log file for detailed error messages.\n";
echo "Log file: storage/logs/laravel.log\n";
