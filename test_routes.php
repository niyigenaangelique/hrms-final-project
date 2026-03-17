<?php

// Simple test to check if routes are working
echo "Testing Laravel Routes...\n\n";

// Test 1: Check if Laravel is working
$ch = curl_init('http://localhost:8000');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Test 1 - Root URL: ";
echo $httpCode === 200 ? "✅ Working (HTTP $httpCode)" : "❌ Failed (HTTP $httpCode)";
echo "\n";

// Test 2: Check payroll dashboard route
$ch = curl_init('http://localhost:8000/payroll/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Test 2 - Payroll Dashboard: ";
echo $httpCode === 200 ? "✅ Working (HTTP $httpCode)" : "❌ Failed (HTTP $httpCode)";
echo "\n";

// Test 3: Check if there's a redirect
$ch = curl_init('http://localhost:8000/payroll/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$redirectCode = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
curl_close($ch);

echo "Test 3 - Redirect Check: ";
if ($httpCode === 302 || $httpCode === 301) {
    echo "⚠️  Redirecting to: $redirectCode";
} else {
    echo "✅ No redirect (HTTP $httpCode)";
}
echo "\n";

// Test 4: Check login route
$ch = curl_init('http://localhost:8000/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Test 4 - Login Page: ";
echo $httpCode === 200 ? "✅ Working (HTTP $httpCode)" : "❌ Failed (HTTP $httpCode)";
echo "\n\n";

echo "=== Recommendations ===\n";
if ($httpCode === 302 || $httpCode === 301) {
    echo "1. You need to login first: http://localhost:8000/login\n";
    echo "2. After login, try: http://localhost:8000/payroll/dashboard\n";
} else {
    echo "1. Check if you're logged in\n";
    echo "2. Try clearing browser cache\n";
    echo "3. Try incognito/private browsing\n";
}

echo "\nDone.\n";
