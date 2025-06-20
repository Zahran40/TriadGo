<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;
use App\Models\Product;

echo "=== CHECKING STOCK REDUCTION STATUS ===\n\n";

// Get paid orders that might need stock processing
$paidOrders = CheckoutOrder::where('status', 'paid')->get();

foreach ($paidOrders as $order) {
    echo "🔍 Checking Order: {$order->order_id}\n";
    echo "  Customer: {$order->name}\n";
    echo "  Amount: {$order->formatted_total}\n";
    echo "  Payment completed: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'No') . "\n";
    
    $paymentDetails = $order->payment_details ?? [];
    $stockReduced = $paymentDetails['stock_reduced'] ?? false;
    
    echo "  Stock reduced flag: " . ($stockReduced ? 'Yes' : 'No') . "\n";
    
    if (!$stockReduced) {
        echo "  ❌ This order needs stock processing!\n";
        echo "  📦 Cart items:\n";
        
        foreach ($order->cart_items as $item) {
            $productId = $item['product_id'] ?? 'unknown';
            $quantity = $item['quantity'] ?? 0;
            $productName = $item['product_name'] ?? 'Unknown Product';
            
            echo "    - Product ID: {$productId}\n";
            echo "      Name: {$productName}\n";
            echo "      Quantity ordered: {$quantity}\n";
            
            // Check current stock
            $product = Product::where('product_id', $productId)->first();
            if ($product) {
                echo "      Current stock: {$product->stock_quantity}\n";
            } else {
                echo "      ⚠️  Product not found in database!\n";
            }
            echo "\n";
        }
    } else {
        echo "  ✅ Stock already processed\n";
    }
    
    echo "  " . str_repeat("-", 50) . "\n\n";
}

// Now let's manually process the orders that need it
$needProcessing = $paidOrders->filter(function($order) {
    $paymentDetails = $order->payment_details ?? [];
    return !($paymentDetails['stock_reduced'] ?? false);
});

if ($needProcessing->count() > 0) {
    echo "⚡ Processing {$needProcessing->count()} order(s) that need stock reduction...\n\n";
    
    foreach ($needProcessing as $order) {
        echo "Processing order: {$order->order_id}\n";
        
        // Call the stock reduction method directly
        $order->reduceProductStock();
        $order->clearUserCart();
        
        echo "✅ Order processed successfully\n\n";
    }
    
    echo "🎉 All orders have been processed!\n";
} else {
    echo "✅ All paid orders have already been processed.\n";
}

echo "\n=== PROCESSING COMPLETE ===\n";
