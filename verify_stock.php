<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;
use App\Models\Product;

echo "=== VERIFYING STOCK REDUCTION ===\n\n";

// Check the processed orders
$paidOrders = CheckoutOrder::where('status', 'paid')->get();

foreach ($paidOrders as $order) {
    echo "📋 Order: {$order->order_id}\n";
    echo "  Customer: {$order->name}\n";
    
    $paymentDetails = $order->payment_details ?? [];
    $stockReduced = $paymentDetails['stock_reduced'] ?? false;
    
    echo "  Stock reduced: " . ($stockReduced ? '✅ Yes' : '❌ No') . "\n";
    
    if ($stockReduced && isset($paymentDetails['stock_reductions'])) {
        echo "  📊 Stock reduction details:\n";
        foreach ($paymentDetails['stock_reductions'] as $reduction) {
            echo "    - Product: {$reduction['product_name']} (ID: {$reduction['product_id']})\n";
            echo "      Quantity reduced: {$reduction['quantity_reduced']}\n";
            echo "      Stock: {$reduction['old_stock']} → {$reduction['new_stock']}\n";
            echo "      Reduced at: {$reduction['reduced_at']}\n\n";
        }
    }
    
    echo "  📦 Current product stocks:\n";
    foreach ($order->cart_items as $item) {
        $productId = $item['product_id'] ?? 'unknown';
        $product = Product::where('product_id', $productId)->first();
        if ($product) {
            echo "    - {$product->product_name}: {$product->stock_quantity} units\n";
        }
    }
    
    echo "  " . str_repeat("=", 60) . "\n\n";
}

echo "✅ Verification complete!\n";
