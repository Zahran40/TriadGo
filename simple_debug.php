<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/detailproductimportir/8', 'GET');
$response = $kernel->handle($request);

echo "HTTP Status: " . $response->getStatusCode() . "\n";
echo "Content Length: " . strlen($response->getContent()) . "\n";
echo "First 1000 chars:\n";
echo substr($response->getContent(), 0, 1000) . "\n";

// Test database connection
try {
    $product = \App\Models\Product::find(8);
    echo "\nProduct found: " . ($product ? 'YES' : 'NO') . "\n";
    if ($product) {
        echo "Product name: " . $product->name . "\n";
        echo "Product price: " . $product->price . "\n";
    }
} catch (Exception $e) {
    echo "\nDatabase error: " . $e->getMessage() . "\n";
}
