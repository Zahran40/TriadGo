<?php
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;

echo "💳 SIMULATING PAYMENT FOR ORDER\n";
echo "===============================\n\n";

$orderId = 'TG-20250619-6853A208C510B';

echo "Processing order: {$orderId}\n\n";

try {
    $order = CheckoutOrder::where('order_id', $orderId)->first();
    
    if (!$order) {
        echo "❌ Order not found!\n";
        exit(1);
    }
    
    echo "📊 Current order status: {$order->status}\n";
    echo "💰 Amount: \${$order->total_amount} {$order->currency}\n\n";
    
    if ($order->status !== 'pending') {
        echo "⚠️  Order is not pending (current: {$order->status})\n";
        echo "Proceeding anyway for testing...\n\n";
    }
    
    // Simulate successful payment
    $transactionId = 'SCRIPT-SIM-' . time() . '-' . $orderId;
    
    $order->update([
        'status' => 'paid',
        'payment_gateway_transaction_id' => $transactionId,
        'payment_details' => array_merge($order->payment_details ?? [], [
            'transaction_id' => $transactionId,
            'payment_type' => 'script_simulation',
            'gross_amount' => $order->total_amount,
            'currency' => $order->currency,
            'status_code' => '200',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'simulated_at' => now()->toISOString(),
            'simulation_method' => 'direct_script'
        ]),
        'payment_completed_at' => now()
    ]);
    
    echo "✅ Payment simulation completed!\n";
    echo "Transaction ID: {$transactionId}\n";
    echo "Status: {$order->fresh()->status}\n";
    echo "Payment completed at: {$order->fresh()->payment_completed_at}\n\n";
    
    echo "🎯 VERIFICATION STEPS:\n";
    echo "1. Order ID to search in Midtrans Dashboard: {$orderId}\n";
    echo "2. Transaction ID: {$transactionId}\n";
    echo "3. Dashboard URL: https://dashboard.sandbox.midtrans.com\n";
    echo "4. Check database for updated status\n\n";
    
    echo "✅ Script completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
