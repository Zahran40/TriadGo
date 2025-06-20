<?php
/**
 * Script untuk test pengurangan stok produk
 * Jalankan dari terminal: php test_stock_reduction.php
 */

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;

echo "=== Testing Stock Reduction System ===\n\n";

try {
    // 1. Cari user importir untuk testing
    $user = User::where('role', 'impor')->first();
    if (!$user) {
        echo "❌ No importir user found for testing\n";
        exit;
    }
    echo "✅ Found importir user: {$user->name} (ID: {$user->user_id})\n";

    // 2. Cari produk dengan stok > 0
    $product = Product::where('stock_quantity', '>', 5)->first();
    if (!$product) {
        echo "❌ No product with sufficient stock found for testing\n";
        exit;
    }
    echo "✅ Found product: {$product->product_name} (Stock: {$product->stock_quantity})\n";

    $originalStock = $product->stock_quantity;
    $testQuantity = 2;

    // 3. Simulasi checkout order dengan cart items
    $testOrder = CheckoutOrder::create([
        'user_id' => $user->user_id,
        'order_id' => 'TEST-' . time(),
        'total_amount' => $product->price * $testQuantity,
        'currency' => 'USD',
        'status' => 'pending',
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone ?? '123456789',
        'address' => 'Test Address',
        'city' => 'Test City',
        'state' => 'Test State',
        'zip_code' => '12345',
        'country' => 'Indonesia',
        'payment_method' => 'midtrans',
        'cart_items' => [
            [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'quantity' => $testQuantity,
                'price' => $product->price,
                'total' => $product->price * $testQuantity
            ]
        ],
        'subtotal' => $product->price * $testQuantity,
        'shipping_cost' => 25.00,
        'tax_amount' => ($product->price * $testQuantity) * 0.1,
    ]);

    echo "✅ Created test order: {$testOrder->order_id}\n";

    // 4. Test markAsPaid (ini akan mengurangi stok)
    echo "\n--- Testing Stock Reduction ---\n";
    echo "Before payment: Product stock = {$originalStock}\n";
    
    $testOrder->markAsPaid('TEST-TRANSACTION-' . time(), [
        'payment_type' => 'test',
        'transaction_status' => 'settlement'
    ]);

    // 5. Cek stok setelah pembayaran
    $product->refresh();
    $newStock = $product->stock_quantity;
    $expectedStock = $originalStock - $testQuantity;

    echo "After payment: Product stock = {$newStock}\n";
    echo "Expected stock: {$expectedStock}\n";

    if ($newStock == $expectedStock) {
        echo "✅ Stock reduction SUCCESS! Stock reduced by {$testQuantity} units\n";
    } else {
        echo "❌ Stock reduction FAILED! Expected {$expectedStock}, got {$newStock}\n";
    }

    // 6. Cek apakah order status berubah
    $testOrder->refresh();
    echo "Order status: {$testOrder->status}\n";
    echo "Payment completed at: {$testOrder->payment_completed_at}\n";

    // 7. Cleanup - hapus test order dan restore stock
    echo "\n--- Cleanup ---\n";
    $product->stock_quantity = $originalStock;
    $product->save();
    $testOrder->delete();
    echo "✅ Test order deleted and stock restored\n";

} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Completed ===\n";
