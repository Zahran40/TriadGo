<?php
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;

echo "📋 COMPREHENSIVE ORDER ANALYSIS\n";
echo "===============================\n\n";

// All recent orders
$recentOrders = CheckoutOrder::where('created_at', '>=', now()->subHours(2))
    ->orderBy('created_at', 'desc')
    ->get();

echo "📊 Orders in last 2 hours: " . $recentOrders->count() . "\n\n";

// Summary by status
$statusCounts = $recentOrders->groupBy('status')->map(function($orders) {
    return $orders->count();
});

echo "📈 Status breakdown:\n";
foreach ($statusCounts as $status => $count) {
    echo "  {$status}: {$count} orders\n";
}
echo "\n";

// Detailed order list
echo "📝 DETAILED ORDER LIST:\n";
echo "========================\n";

foreach ($recentOrders as $order) {
    echo "Order ID: {$order->order_id}\n";
    echo "Status: {$order->status}\n";
    echo "Amount: \${$order->total_amount} {$order->currency}\n";
    echo "Customer: {$order->first_name} {$order->last_name} ({$order->email})\n";
    echo "Created: {$order->created_at}\n";
    echo "Payment Method: {$order->payment_method}\n";
    echo "Transaction ID: " . ($order->payment_gateway_transaction_id ?? 'N/A') . "\n";
    
    // Check if has snap token
    $paymentDetails = $order->payment_details;
    if ($paymentDetails && isset($paymentDetails['snap_token'])) {
        echo "Snap Token: YES (length: " . strlen($paymentDetails['snap_token']) . ")\n";
    } else {
        echo "Snap Token: NO\n";
    }
    
    // Payment completion
    if ($order->payment_completed_at) {
        echo "Payment Completed: {$order->payment_completed_at}\n";
    } else {
        echo "Payment Completed: NOT COMPLETED\n";
    }
    
    echo "Items: " . count($order->cart_items ?? []) . " item(s)\n";
    echo "---\n";
}

echo "\n🔍 MIDTRANS INTEGRATION CHECK:\n";
echo "==============================\n";

// Check configuration
echo "Environment: " . (config('services.midtrans.is_production') ? 'PRODUCTION' : 'SANDBOX') . "\n";
echo "Merchant ID: " . config('services.midtrans.merchant_id') . "\n";
echo "Server Key: " . substr(config('services.midtrans.server_key'), 0, 15) . "...\n";
echo "Client Key: " . substr(config('services.midtrans.client_key'), 0, 15) . "...\n";

$dashboardUrl = config('services.midtrans.is_production') 
    ? 'https://dashboard.midtrans.com' 
    : 'https://dashboard.sandbox.midtrans.com';

echo "Dashboard URL: {$dashboardUrl}\n\n";

// Orders to check in dashboard
echo "🎯 ORDERS TO VERIFY IN MIDTRANS DASHBOARD:\n";
echo "==========================================\n";

$ordersWithSnapToken = $recentOrders->filter(function($order) {
    $details = $order->payment_details;
    return $details && isset($details['snap_token']);
});

if ($ordersWithSnapToken->count() > 0) {
    echo "These orders should appear in Midtrans Dashboard:\n\n";
    foreach ($ordersWithSnapToken as $order) {
        echo "✓ {$order->order_id} - \${$order->total_amount} - {$order->status}\n";
        echo "  Created: {$order->created_at}\n";
        echo "  Customer: {$order->first_name} {$order->last_name}\n";
        
        if ($order->status === 'paid' && $order->payment_gateway_transaction_id) {
            echo "  Transaction ID: {$order->payment_gateway_transaction_id}\n";
        }
        
        echo "\n";
    }
} else {
    echo "❌ No orders with snap tokens found!\n";
}

echo "📝 TROUBLESHOOTING STEPS:\n";
echo "1. Login to: {$dashboardUrl}\n";
echo "2. Check 'Transactions' menu\n";
echo "3. Search for Order IDs listed above\n";
echo "4. If not found, check:\n";
echo "   - Correct environment (sandbox vs production)\n";
echo "   - Correct merchant account\n";
echo "   - Network connectivity\n";
echo "   - Wait 5-10 minutes for dashboard update\n\n";

echo "✅ Analysis completed.\n";
