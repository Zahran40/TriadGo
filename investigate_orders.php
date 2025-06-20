<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\DB;

echo "=== CHECKING ALL ORDERS IN DATABASE ===\n\n";

// Check all orders
$allOrders = CheckoutOrder::orderBy('created_at', 'desc')->get();

if ($allOrders->isEmpty()) {
    echo "❌ No orders found in database at all.\n\n";
} else {
    echo "📦 Found {$allOrders->count()} total order(s) in database:\n\n";
    
    $statusCounts = [];
    
    foreach ($allOrders as $order) {
        $status = $order->status;
        $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
        
        echo "- Order ID: {$order->order_id}\n";
        echo "  Status: {$order->status}\n";
        echo "  Amount: {$order->formatted_total}\n";
        echo "  Customer: {$order->name}\n";
        echo "  Payment completed: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'No') . "\n";
        echo "  Stock reduced: " . (isset($order->payment_details['stock_reduced']) ? ($order->payment_details['stock_reduced'] ? 'Yes' : 'No') : 'Not set') . "\n";
        echo "  Created: {$order->created_at->format('Y-m-d H:i:s')}\n";
        echo "\n";
    }
    
    echo "📊 Order status summary:\n";
    foreach ($statusCounts as $status => $count) {
        echo "  {$status}: {$count} order(s)\n";
    }
    echo "\n";
}

// Check specifically for paid orders
$paidOrders = CheckoutOrder::where('status', 'paid')->get();
echo "💰 Paid orders: {$paidOrders->count()}\n";

if ($paidOrders->count() > 0) {
    $needProcessing = $paidOrders->whereNull('payment_completed_at');
    echo "🔄 Paid orders needing processing: {$needProcessing->count()}\n\n";
    
    if ($needProcessing->count() > 0) {
        echo "These orders need stock processing:\n";
        foreach ($needProcessing as $order) {
            echo "- {$order->order_id} ({$order->name}) - {$order->formatted_total}\n";
        }
    }
}

echo "\n=== INVESTIGATION COMPLETE ===\n";
