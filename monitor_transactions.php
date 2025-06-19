<?php
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;

echo "🔍 TRANSACTION MONITORING TOOL\n";
echo "========================================\n\n";

// Monitor orders created in the last 30 minutes
$recentOrders = CheckoutOrder::where('created_at', '>=', now()->subMinutes(30))
    ->orderBy('created_at', 'desc')
    ->get();

echo "📊 Recent orders (last 30 minutes): " . $recentOrders->count() . "\n\n";

if ($recentOrders->count() > 0) {
    foreach ($recentOrders as $order) {
        echo "Order ID: {$order->order_id}\n";
        echo "Status: {$order->status}\n";
        echo "Amount: \${$order->total_amount} {$order->currency}\n";
        echo "Created: {$order->created_at}\n";
        echo "Transaction ID: " . ($order->payment_gateway_transaction_id ?? 'N/A') . "\n";
        echo "Payment Details: " . json_encode($order->payment_details, JSON_PRETTY_PRINT) . "\n";
        echo "---\n";
    }
}

// Check Midtrans configuration
echo "\n⚙️  MIDTRANS CONFIGURATION:\n";
echo "Server Key: " . substr(config('services.midtrans.server_key'), 0, 10) . "...\n";
echo "Client Key: " . substr(config('services.midtrans.client_key'), 0, 10) . "...\n";
echo "Environment: " . (config('services.midtrans.is_production') ? 'PRODUCTION' : 'SANDBOX') . "\n";
echo "Merchant ID: " . config('services.midtrans.merchant_id') . "\n";

// Test Midtrans connection
echo "\n🔗 TESTING MIDTRANS CONNECTION:\n";
try {
    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
    \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    // Create a simple test transaction
    $testOrderId = 'MONITOR-TEST-' . time();
    $params = [
        'transaction_details' => [
            'order_id' => $testOrderId,
            'gross_amount' => 15000, // 150 IDR (about $0.10)
        ],
        'customer_details' => [
            'first_name' => 'Monitor',
            'last_name' => 'Test',
            'email' => 'monitor@triadgo.test',
            'phone' => '+6281234567890',
        ],
        'item_details' => [
            [
                'id' => 'monitor-test',
                'price' => 15000,
                'quantity' => 1,
                'name' => 'Monitor Test Product'
            ]
        ]
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo "✅ Connection successful! Test order created: {$testOrderId}\n";
    echo "📋 Copy this Order ID and search it in Midtrans Dashboard:\n";
    echo "🔗 Dashboard URL: " . (config('services.midtrans.is_production') ? 'https://dashboard.midtrans.com' : 'https://dashboard.sandbox.midtrans.com') . "\n";
    echo "Token: " . substr($snapToken, 0, 20) . "...\n";

} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}

// Show debugging instructions
echo "\n📝 DEBUGGING INSTRUCTIONS:\n";
echo "1. Cari Order ID di Midtrans Dashboard\n";
echo "2. Jika tidak muncul, periksa:\n";
echo "   - Environment (sandbox vs production)\n";
echo "   - Merchant ID\n";
echo "   - Server Key\n";
echo "3. Dashboard delay bisa 1-5 menit\n";
echo "4. Pastikan gunakan dashboard yang sesuai environment\n\n";

echo "✅ Monitoring completed.\n";
