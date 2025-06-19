<?php
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use App\Services\MidtransHttpService;
use Illuminate\Support\Facades\Log;

echo "🚀 CREATING NEW TEST ORDER\n";
echo "===========================\n\n";

// Create a new test order
$orderData = [
    'order_id' => CheckoutOrder::generateOrderId(),
    'total_amount' => 0.21, // Super cheap for testing
    'currency' => 'USD',
    'status' => 'pending',
    'first_name' => 'TestUser',
    'last_name' => 'Dashboard',
    'email' => 'testdashboard@triadgo.test',
    'phone' => '+6281234567890',
    'address' => '123 Test Street',
    'city' => 'Jakarta',
    'state' => 'DKI Jakarta',
    'zip_code' => '12345',
    'country' => 'ID',
    'payment_method' => 'midtrans',
    'cart_items' => [
        [
            'id' => 'TESTPROD001',
            'name' => 'Dashboard Test Product',
            'price' => 0.10,
            'quantity' => 1,
            'category' => 'Test',
            'sku' => 'TEST-001',
            'weight' => 0.1
        ]
    ],
    'subtotal' => 0.10,
    'shipping_cost' => 0.10,
    'tax_amount' => 0.01,
    'coupon_code' => null,
    'discount_amount' => 0,
    'notes' => 'Test order untuk memastikan muncul di dashboard'
];

echo "📝 Creating order with data:\n";
echo "Order ID: {$orderData['order_id']}\n";
echo "Amount: \${$orderData['total_amount']} {$orderData['currency']}\n";
echo "Customer: {$orderData['first_name']} {$orderData['last_name']}\n\n";

try {
    // Create the order
    $order = CheckoutOrder::create($orderData);
    echo "✅ Order created successfully!\n";
    echo "Database ID: {$order->id}\n";
    echo "Order ID: {$order->order_id}\n\n";

    // Create Midtrans snap token
    echo "🔗 Creating Midtrans snap token...\n";
    $midtransService = new MidtransHttpService();
    $snapToken = $midtransService->createSnapToken($order);
    
    echo "✅ Snap token created successfully!\n";
    echo "Token: " . substr($snapToken, 0, 30) . "...\n\n";

    // Update order with snap token info
    $order->update([
        'payment_details' => [
            'snap_token' => $snapToken,
            'created_via' => 'dashboard_test_script',
            'created_at' => now()->toISOString()
        ]
    ]);

    echo "📊 ORDER SUMMARY:\n";
    echo "=================\n";
    echo "Order ID: {$order->order_id}\n";
    echo "Status: {$order->status}\n";
    echo "Amount: \${$order->total_amount} {$order->currency}\n";
    echo "Payment Method: {$order->payment_method}\n";
    echo "Created: {$order->created_at}\n";
    echo "Customer: {$order->first_name} {$order->last_name} ({$order->email})\n";
    echo "Items: " . count($order->cart_items) . " item(s)\n\n";

    echo "🎯 NEXT STEPS:\n";
    echo "1. Copy Order ID: {$order->order_id}\n";
    echo "2. Login ke Midtrans Dashboard: https://dashboard.sandbox.midtrans.com\n";
    echo "3. Cari order tersebut di menu Transactions\n";
    echo "4. Jika tidak muncul dalam 5 menit, ada masalah dengan koneksi\n\n";

    echo "🔗 Direct payment URL untuk test:\n";
    echo "http://localhost/TriadGo/public/test-payment/{$order->order_id}\n\n";

    echo "✅ Test order creation completed successfully!\n";

} catch (Exception $e) {
    echo "❌ Error creating order: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
