<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MIDTRANS ACCOUNT DEBUGGING ===\n\n";

// Ambil konfigurasi
$serverKey = config('midtrans.server_key');
$clientKey = config('midtrans.client_key');
$isProduction = config('midtrans.is_production', false);

echo "Current Configuration:\n";
echo "- Server Key: $serverKey\n";
echo "- Client Key: $clientKey\n";
echo "- Environment: " . ($isProduction ? 'PRODUCTION' : 'SANDBOX') . "\n";
echo "- Expected Dashboard: " . ($isProduction ? 'https://dashboard.midtrans.com' : 'https://dashboard.sandbox.midtrans.com') . "\n\n";

// Ambil merchant ID dari server key
if (preg_match('/^SB-Mid-server-([^-]+)-/', $serverKey, $matches)) {
    $merchantId = $matches[1];
    echo "Detected Merchant ID (from server key): $merchantId\n";
} elseif (preg_match('/^Mid-server-([^-]+)-/', $serverKey, $matches)) {
    $merchantId = $matches[1];
    echo "Detected Merchant ID (from server key): $merchantId\n";
} else {
    echo "Cannot extract Merchant ID from server key\n";
}

echo "\n=== ACCOUNT VERIFICATION ===\n";
echo "1. Pastikan Anda login ke dashboard yang benar:\n";
if ($isProduction) {
    echo "   - URL: https://dashboard.midtrans.com\n";
    echo "   - Environment: PRODUCTION\n";
} else {
    echo "   - URL: https://dashboard.sandbox.midtrans.com\n";
    echo "   - Environment: SANDBOX\n";
}

echo "\n2. Cek di dashboard apakah Merchant ID Anda sama dengan: ";
if (isset($merchantId)) {
    echo "$merchantId\n";
} else {
    echo "UNKNOWN (check server key format)\n";
}

echo "\n3. Di dashboard, pergi ke Settings > Configuration\n";
echo "   - Bandingkan Server Key yang tercantum dengan: " . substr($serverKey, 0, 20) . "...\n";
echo "   - Jika berbeda = Anda menggunakan key dari akun lain\n";

echo "\n=== CREATE VERIFIED TEST TRANSACTION ===\n";

// Set Midtrans config
\Midtrans\Config::$serverKey = $serverKey;
\Midtrans\Config::$isProduction = $isProduction;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$orderId = 'VERIFY-' . date('YmdHis');

$params = [
    'transaction_details' => [
        'order_id' => $orderId,
        'gross_amount' => 10000,
    ],
    'customer_details' => [
        'first_name' => 'Account',
        'last_name' => 'Verification',
        'email' => 'verify@test.com',
        'phone' => '+6281234567890',
    ],
    'item_details' => [
        [
            'id' => 'verify-item',
            'price' => 10000,
            'quantity' => 1,
            'name' => 'Account Verification Test'
        ]
    ]
];

try {
    echo "Creating verification transaction...\n";
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    
    echo "✅ Transaction created successfully!\n";
    echo "- Order ID: $orderId\n";
    echo "- Snap Token: " . substr($snapToken, 0, 30) . "...\n\n";
    
    echo "=== IMMEDIATE VERIFICATION STEPS ===\n";
    echo "1. Buka dashboard: " . ($isProduction ? 'https://dashboard.midtrans.com' : 'https://dashboard.sandbox.midtrans.com') . "\n";
    echo "2. Refresh halaman dashboard\n";
    echo "3. Cari Order ID: $orderId\n";
    echo "4. Tunggu 1-2 menit lalu coba lagi jika tidak muncul\n\n";
    
    echo "=== JIKA MASIH TIDAK MUNCUL ===\n";
    echo "1. Cek apakah Anda login ke akun yang tepat\n";
    echo "2. Bandingkan Merchant ID di dashboard dengan yang terdeteksi di atas\n";
    echo "3. Pastikan menggunakan dashboard URL yang benar (sandbox vs production)\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR creating transaction:\n";
    echo "- Message: " . $e->getMessage() . "\n";
    echo "- Class: " . get_class($e) . "\n";
    
    if (method_exists($e, 'getResponse')) {
        echo "- Response: " . $e->getResponse() . "\n";
    }
    
    echo "\nKemungkinan masalah:\n";
    echo "1. Server Key tidak valid\n";
    echo "2. Account suspended atau restricted\n";
    echo "3. Network connectivity issue\n";
}
