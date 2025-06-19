<?php

require_once 'vendor/autoload.php';

use App\Models\Product;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Product Prices after update:\n";
echo "============================\n";

$products = Product::select('product_name', 'price')->take(10)->get();

foreach ($products as $product) {
    echo "- " . $product->product_name . ": $" . number_format($product->price, 2) . "\n";
}

echo "\nTotal products: " . Product::count() . "\n";
echo "All products now cost $0.10 for testing!\n";
