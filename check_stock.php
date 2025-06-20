<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check product 9 stock
$product = \App\Models\Product::where('product_id', 9)->first();
echo "Product: {$product->product_name}\n";
echo "Current stock: {$product->stock_quantity}\n";

// Get the latest paid order for this product
$order = \App\Models\CheckoutOrder::where('status', 'paid')
    ->whereJsonContains('cart_items', ['product_id' => 9])
    ->latest()
    ->first();

if ($order) {
    echo "Latest paid order: {$order->order_id}\n";
    echo "Payment completed at: {$order->payment_completed_at}\n";
} else {
    echo "No paid order found with this product\n";
}
