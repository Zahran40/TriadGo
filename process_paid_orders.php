<?php
/**
 * Script untuk memproses ulang stock reduction untuk order yang sudah paid
 * tapi belum diproses stock reductionnya
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;

echo "=== Processing Paid Orders Stock Reduction ===\n\n";

try {
    // Cari semua order yang status paid tapi payment_completed_at null
    // (kemungkinan diubah manual di database)
    $orders = CheckoutOrder::where('status', 'paid')
        ->whereNull('payment_completed_at')
        ->get();

    echo "Found " . $orders->count() . " paid orders that need stock processing\n\n";

    foreach ($orders as $order) {
        echo "Processing Order: {$order->order_id}\n";
        echo "  User: {$order->name}\n";
        echo "  Amount: {$order->total_amount} {$order->currency}\n";
        
        // Update payment_completed_at and trigger stock reduction
        $order->update(['payment_completed_at' => now()]);
        
        // Manual call stock reduction
        $order->reduceProductStock();
        
        // Clear user cart
        $order->clearUserCart();
        
        echo "  ✅ Stock reduced and cart cleared\n\n";
    }

    echo "=== Processing Completed ===\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
