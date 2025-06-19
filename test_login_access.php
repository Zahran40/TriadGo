<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test user session
session_start();

// Test user data (from seeder - importir)
$testUser = [
    'email' => 'john.smith@example.com', // Importer user from seeder
    'password' => 'password123'
];

echo "=== LOGIN TEST ===\n";

// Try login
$loginRequest = Illuminate\Http\Request::create('/login', 'POST', [
    'email' => $testUser['email'],
    'password' => $testUser['password'],
    '_token' => 'test'
]);

// Disable CSRF for this test
$loginRequest->session()->put('_token', 'test');

try {
    $loginResponse = $kernel->handle($loginRequest);
    echo "Login Status: " . $loginResponse->getStatusCode() . "\n";
    
    // Now try to access product detail with session
    $detailRequest = Illuminate\Http\Request::create('/detailproductimportir/8', 'GET');
    
    // Copy session from login
    foreach ($_SESSION as $key => $value) {
        $detailRequest->session()->put($key, $value);
    }
    
    $detailResponse = $kernel->handle($detailRequest);
    echo "Detail Page Status: " . $detailResponse->getStatusCode() . "\n";
    echo "Content Length: " . strlen($detailResponse->getContent()) . "\n";
    
    if ($detailResponse->getStatusCode() == 200) {
        echo "SUCCESS! Page loaded\n";
        echo "First 500 chars:\n";
        echo substr($detailResponse->getContent(), 0, 500) . "\n";
    } else {
        echo "Page still not accessible\n";
        echo "Response:\n";
        echo substr($detailResponse->getContent(), 0, 500) . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
