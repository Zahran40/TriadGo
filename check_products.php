<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

// Check products
try {
    $products = \App\Models\Product::select('product_id', 'product_name', 'price', 'status')->get();
    
    echo "Total products: " . $products->count() . "\n\n";
    
    foreach($products as $product) {
        echo "ID: " . $product->product_id . "\n";
        echo "Name: " . $product->product_name . "\n";
        echo "Price: " . $product->price . "\n";
        echo "Status: " . $product->status . "\n";
        echo "---\n";
    }
    
    // Check specific product ID 8
    $product8 = \App\Models\Product::where('product_id', 8)->first();
    echo "\nProduct ID 8: " . ($product8 ? 'EXISTS' : 'NOT FOUND') . "\n";
    if ($product8) {
        echo "Name: " . $product8->product_name . "\n";
        echo "Status: " . $product8->status . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
