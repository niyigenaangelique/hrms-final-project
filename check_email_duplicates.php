<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Employee;

// Check for duplicate emails
$employees = Employee::all();
$emailCounts = [];

echo "=== EMAIL DUPLICATE CHECK ===\n\n";

foreach ($employees as $emp) {
    $email = strtolower(trim($emp->email ?? ''));
    if ($email) {
        if (!isset($emailCounts[$email])) {
            $emailCounts[$email] = [];
        }
        $emailCounts[$email][] = [
            'code' => $emp->code,
            'id' => $emp->id,
            'name' => $emp->first_name . ' ' . $emp->last_name,
            'is_active' => $emp->is_active ?? 'null'
        ];
    }
}

// Show duplicates
$duplicatesFound = false;
foreach ($emailCounts as $email => $records) {
    if (count($records) > 1) {
        $duplicatesFound = true;
        echo "DUPLICATE EMAIL: $email\n";
        foreach ($records as $record) {
            echo "  - {$record['code']} (ID: {$record['id']}) - {$record['name']} (active: {$record['is_active']})\n";
        }
        echo "\n";
    }
}

if (!$duplicatesFound) {
    echo "No duplicate emails found.\n\n";
}

// Check EMP-003 specifically
echo "=== EMP-003 SPECIFIC CHECK ===\n";
$emp003 = Employee::where('code', 'EMP-003')->first();
if ($emp003) {
    echo "EMP-003 found:\n";
    echo "  - ID: {$emp003->id}\n";
    echo "  - Email: {$emp003->email}\n";
    echo "  - Name: {$emp003->first_name} {$emp003->last_name}\n";
    echo "  - is_active: " . ($emp003->is_active ?? 'null') . "\n\n";
    
    // Check if anyone else has this email
    $othersWithSameEmail = Employee::where('email', $emp003->email)
                                ->where('id', '!=', $emp003->id)
                                ->get();
    
    if ($othersWithSameEmail->count() > 0) {
        echo "OTHER EMPLOYEES WITH SAME EMAIL ({$emp003->email}):\n";
        foreach ($othersWithSameEmail as $other) {
            echo "  - {$other->code} (ID: {$other->id}) - {$other->first_name} {$other->last_name}\n";
        }
    } else {
        echo "No other employees have this email.\n";
    }
} else {
    echo "EMP-003 not found!\n";
}
