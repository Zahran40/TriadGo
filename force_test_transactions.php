<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FORCE MIDTRANS TRANSACTION TEST ===\n\n";

// Set Midtrans config
\Midtrans\Config::$serverKey = config('midtrans.server_key');
\Midtrans\Config::$isProduction = config('midtrans.is_production', false);
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

echo "Merchant ID yang terdeteksi: vtes\n";
echo "Dashboard yang benar: https://dashboard.sandbox.midtrans.com\n\n";

// Buat beberapa transaksi test dengan pattern berbeda
$testTransactions = [];

for ($i = 1; $i <= 3; $i++) {
    $orderId = "MULTITEST-{$i}-" . time();
    
    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => 10000 + ($i * 1000), // 11000, 12000, 13000
        ],
        'customer_details' => [
            'first_name' => "Test{$i}",
            'last_name' => 'Customer',
            'email' => "test{$i}@verify.com",
            'phone' => '+628123456789' . $i,
        ],
        'item_details' => [
            [
                'id' => "test-item-{$i}",
                'price' => 10000 + ($i * 1000),
                'quantity' => 1,
                'name' => "Multi Test Item #{$i}"
            ]
        ]
    ];
    
    try {
        echo "Creating transaction #{$i}...\n";
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        $testTransactions[] = [
            'order_id' => $orderId,
            'snap_token' => $snapToken,
            'amount' => 10000 + ($i * 1000)
        ];
        
        echo "✅ Created: $orderId\n";
        
        // Sleep 1 detik antara transaksi
        sleep(1);
        
    } catch (\Exception $e) {
        echo "❌ Failed: " . $e->getMessage() . "\n";
    }
}

echo "\n=== SUMMARY TRANSAKSI YANG DIBUAT ===\n";
foreach ($testTransactions as $index => $transaction) {
    echo ($index + 1) . ". Order ID: {$transaction['order_id']}\n";
    echo "   Amount: Rp " . number_format($transaction['amount']) . "\n";
    echo "   Token: " . substr($transaction['snap_token'], 0, 20) . "...\n\n";
}

echo "=== VERIFICATION CHECKLIST ===\n";
echo "1. ✅ Buka: https://dashboard.sandbox.midtrans.com\n";
echo "2. ✅ Pastikan login dengan akun yang memiliki Merchant ID: vtes\n";
echo "3. ✅ Pergi ke menu 'Transactions'\n";
echo "4. ✅ Cari salah satu Order ID di atas\n";
echo "5. ✅ Jika muncul = Account sudah benar!\n";
echo "6. ❌ Jika tidak muncul = Salah akun atau environment\n\n";

echo "=== TROUBLESHOOTING ===\n";
echo "Jika transaksi tetap tidak muncul:\n";
echo "1. Cek di Settings > Configuration apakah Server Key sesuai:\n";
echo "   Expected: SB-Mid-server-vtes-...\n";
echo "2. Pastikan tidak login ke dashboard PRODUCTION\n";
echo "3. Try refresh dashboard atau logout-login ulang\n";
echo "4. Cek apakah ada multiple akun Midtrans\n\n";

echo "Total transaksi dibuat: " . count($testTransactions) . "\n";
echo "Jika SEMUA transaksi tidak muncul = Masalah account/environment\n";
echo "Jika ADA yang muncul = Connection OK, masalah pada transaksi specific\n";
