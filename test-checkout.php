<?php
require_once 'vendor/autoload.php';

// Load Laravel bootstrap
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use App\Services\MidtransHttpService;

echo "Testing TriadGO Checkout System\n";
echo "================================\n\n";

try {
    // Test 1: Create a sample order
    echo "1. Creating sample order...\n";
    $orderData = [
        'order_id' => 'TEST-' . time(),
        'total_amount' => 100.00,
        'currency' => 'USD',
        'status' => 'pending',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '+62812345678',
        'address' => 'Jalan Test No. 123',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'zip_code' => '12345',
        'country' => 'ID',
        'payment_method' => 'midtrans',
        'cart_items' => [
            [
                'id' => 'PROD001',
                'name' => 'Test Product',
                'price' => 90.00,
                'quantity' => 1
            ]
        ],
        'subtotal' => 90.00,
        'shipping_cost' => 10.00,
        'tax_amount' => 0.00,
        'discount_amount' => 0.00
    ];
    
    $order = CheckoutOrder::create($orderData);
    echo "✅ Order created successfully: {$order->order_id}\n\n";
    
    // Test 2: Create Midtrans snap token
    echo "2. Creating Midtrans snap token...\n";
    $midtransService = new MidtransHttpService();
    $snapToken = $midtransService->createSnapToken($order);
    echo "✅ Snap token created successfully: " . substr($snapToken, 0, 20) . "...\n\n";
    
    // Test 3: Check order status
    echo "3. Checking order status...\n";
    $status = $midtransService->getTransactionStatus($order->order_id);
    if ($status) {
        echo "✅ Transaction status retrieved: " . $status['transaction_status'] . "\n\n";
    } else {
        echo "⚠️  Transaction not found in Midtrans (normal for new orders)\n\n";
    }
    
    echo "🎉 All tests passed! Checkout system is working correctly.\n";
    echo "🌐 You can now test the frontend at: http://localhost:8000/formImportir\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📋 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
