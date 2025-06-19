<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

\Midtrans\Config::$serverKey = config('midtrans.server_key');
\Midtrans\Config::$isProduction = false;

$orderId = 'INSTANT-' . date('YmdHis');
$token = \Midtrans\Snap::getSnapToken([
    'transaction_details' => [
        'order_id' => $orderId, 
        'gross_amount' => 15000
    ],
    'customer_details' => [
        'first_name' => 'Instant', 
        'last_name' => 'Test', 
        'email' => 'instant@test.com'
    ]
]);

echo "INSTANT ORDER CREATED: $orderId\n";
echo "SEARCH THIS IN DASHBOARD: https://dashboard.sandbox.midtrans.com/transactions\n";
