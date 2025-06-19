<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MIDTRANS CONNECTION TEST ===\n\n";

// Set Midtrans config
\Midtrans\Config::$serverKey = config('midtrans.server_key');
\Midtrans\Config::$isProduction = config('midtrans.is_production', false);
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

echo "Configuration:\n";
echo "- Server Key: " . substr(config('midtrans.server_key'), 0, 15) . "...\n";
echo "- Environment: " . (config('midtrans.is_production', false) ? 'PRODUCTION' : 'SANDBOX') . "\n";
echo "- Dashboard: " . (config('midtrans.is_production', false) ? 'https://dashboard.midtrans.com' : 'https://dashboard.sandbox.midtrans.com') . "\n\n";

// Create test transaction
$orderId = 'DIRECT-TEST-' . time();

$params = [
    'transaction_details' => [
        'order_id' => $orderId,
        'gross_amount' => 15000, // 15,000 IDR
    ],
    'customer_details' => [
        'first_name' => 'Test',
        'last_name' => 'Connection',
        'email' => 'test@triadgo.com',
        'phone' => '+6281234567890',
    ],
    'item_details' => [
        [
            'id' => 'test-item',
            'price' => 15000,
            'quantity' => 1,
            'name' => 'Direct Test Item - Dashboard Check'
        ]
    ]
];

try {
    echo "Creating test transaction...\n";
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    
    echo "✅ SUCCESS!\n\n";
    echo "Transaction Details:\n";
    echo "- Order ID: $orderId\n";
    echo "- Snap Token: " . substr($snapToken, 0, 30) . "...\n";
    echo "- Payment URL: https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken\n\n";
    
    echo "Dashboard Check:\n";
    echo "1. Open: https://dashboard.sandbox.midtrans.com\n";
    echo "2. Login dengan akun Midtrans Anda\n";
    echo "3. Pergi ke menu 'Transactions'\n";
    echo "4. Cari Order ID: $orderId\n";
    echo "5. Jika muncul = Connection berhasil! ✅\n";
    echo "6. Jika tidak muncul = Ada masalah dengan account/connection ❌\n\n";
    
    echo "NEXT: Buka dashboard dan cek apakah transaksi dengan Order ID '$orderId' muncul!\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR!\n\n";
    echo "Error Message: " . $e->getMessage() . "\n";
    echo "Error Class: " . get_class($e) . "\n";
    
    if (method_exists($e, 'getHttpStatusCode')) {
        echo "HTTP Status: " . $e->getHttpStatusCode() . "\n";
    }
    
    echo "\nPossible Issues:\n";
    echo "- Server Key salah atau tidak valid\n";
    echo "- Network connectivity issue\n";
    echo "- Midtrans service down\n";
}
