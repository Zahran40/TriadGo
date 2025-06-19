<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create request for the product detail page
$request = Illuminate\Http\Request::create('/product-detail-importir/8', 'GET');

try {
    // Add session for auth simulation
    $request->setLaravelSession($app->make('session'));
    
    $response = $kernel->handle($request);
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Content Length: " . strlen($response->getContent()) . "\n";
    
    $content = $response->getContent();
    
    if ($response->getStatusCode() == 302) {
        echo "REDIRECT: " . $response->headers->get('Location') . "\n";
        echo "This means authentication is required\n";
    }
    
    // Check for PHP errors
    if (strpos($content, 'Exception') !== false || strpos($content, 'Error') !== false || strpos($content, 'Fatal') !== false) {
        echo "✗ ERROR FOUND:\n";
        // Show first 1000 chars of error
        echo substr($content, 0, 1000) . "\n";
    } else {
        echo "✓ No PHP errors detected\n";
    }
    
    // Check if HTML structure exists
    if (strpos($content, '<html') !== false) {
        echo "✓ HTML structure found\n";
    } else {
        echo "✗ No HTML structure found\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

$kernel->terminate($request, $response);
