<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;

echo "=== PROCESSING EXISTING PAID ORDERS ===\n\n";

// Find all orders with status 'paid' but no payment_completed_at timestamp
$orders = CheckoutOrder::where('status', 'paid')
    ->whereNull('payment_completed_at')
    ->get();

if ($orders->isEmpty()) {
    echo "✅ No orders found that need stock processing.\n";
    echo "All paid orders have already been processed.\n\n";
} else {
    echo "📦 Found {$orders->count()} order(s) that need stock processing:\n\n";
    
    foreach ($orders as $order) {
        echo "- Order ID: {$order->order_id}\n";
        echo "  Customer: {$order->name} ({$order->email})\n";
        echo "  Amount: {$order->formatted_total}\n";
        echo "  Status: {$order->status}\n";
        echo "  Created: {$order->created_at->format('Y-m-d H:i:s')}\n";
        echo "  Items: " . count($order->cart_items) . "\n";
        
        foreach ($order->cart_items as $item) {
            echo "    * {$item['product_name']} (Qty: {$item['quantity']})\n";
        }
        echo "\n";
    }
    
    echo "⚡ Processing stock reduction for these orders...\n";
    $processedCount = CheckoutOrder::processManuallyPaidOrders();
    echo "✅ Successfully processed {$processedCount} order(s)\n\n";
    
    if ($processedCount > 0) {
        echo "📊 Stock has been reduced for all processed orders\n";
        echo "🛒 Customer carts have been cleared\n";
        echo "📅 Payment completion timestamps have been set\n\n";
    }
}

echo "=== PROCESSING COMPLETE ===\n";
