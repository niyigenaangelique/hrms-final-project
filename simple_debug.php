<?php

echo "=== Simple Payroll Entry Debug ===\n\n";

// 1. Check if the log file exists and show recent errors
$logFile = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "Checking recent log entries...\n";
    
    // Read last 1KB of the log file
    $handle = fopen($logFile, 'r');
    fseek($handle, -1024, SEEK_END);
    $recent = fread($handle, 1024);
    fclose($handle);
    
    echo "Recent log content:\n";
    echo "==================\n";
    echo $recent;
    echo "\n==================\n";
} else {
    echo "Log file not found\n";
}

// 2. Create a simple test to identify common issues
echo "\nCommon issues to check:\n";
echo "1. Are you selecting an employee?\n";
echo "2. Are you selecting a payroll month?\n";
echo "3. Are daily rate and work days filled with numbers?\n";
echo "4. Is the entry code unique?\n";

echo "\nTry these steps:\n";
echo "1. Go to Employees page and create at least one employee with daily_rate set\n";
echo "2. Go to Payroll Months page and create at least one payroll month\n";
echo "3. Try creating payroll entry again\n";

echo "\nIf error persists, check browser console (F12) for JavaScript errors\n";
echo "Also check network tab for failed AJAX requests\n";
