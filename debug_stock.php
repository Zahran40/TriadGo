<?php
/**
 * Debug script untuk test stock reduction manual
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;
use App\Models\Product;

echo "=== Debug Stock Reduction ===\n\n";

try {
    // 1. Cari order yang statusnya 'paid' untuk testing
    $order = CheckoutOrder::where('status', 'paid')->latest()->first();
    
    if (!$order) {
        echo "❌ No paid order found for testing\n";
        echo "Creating a test order...\n";
        
        // Buat test order
        $product = \App\Models\Product::where('stock_quantity', '>', 5)->first();
        if (!$product) {
            echo "❌ No product found for testing\n";
            exit;
        }
        
        $user = \App\Models\User::where('role', 'impor')->first();
        if (!$user) {
            echo "❌ No importir user found\n";
            exit;
        }
        
        $order = CheckoutOrder::create([
            'user_id' => $user->user_id,
            'order_id' => 'DEBUG-' . time(),
            'total_amount' => 100,
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
                    'quantity' => 2,
                    'price' => $product->price,
                    'total' => $product->price * 2
                ]
            ],
            'subtotal' => 100,
            'shipping_cost' => 25,
            'tax_amount' => 10,
        ]);
        
        echo "✅ Created test order: {$order->order_id}\n";
    } else {
        echo "✅ Found paid order: {$order->order_id}\n";
    }

    // 2. Debug cart items
    echo "\n--- Debugging Cart Items ---\n";
    echo "Cart Items Type: " . gettype($order->cart_items) . "\n";
    echo "Cart Items Content:\n";
    var_dump($order->cart_items);

    // 3. Test reduceProductStock method secara manual
    echo "\n--- Testing reduceProductStock Method ---\n";
    
    if ($order->cart_items && is_array($order->cart_items)) {
        foreach ($order->cart_items as $item) {
            $productId = $item['product_id'] ?? null;
            $quantity = $item['quantity'] ?? 0;
            
            echo "Processing item:\n";
            echo "  Product ID: {$productId}\n";
            echo "  Quantity: {$quantity}\n";
            
            if ($productId) {
                $product = Product::where('product_id', $productId)->first();
                if ($product) {
                    echo "  Product found: {$product->product_name}\n";
                    echo "  Current stock: {$product->stock_quantity}\n";
                    
                    if ($product->stock_quantity >= $quantity) {
                        echo "  ✅ Stock sufficient for reduction\n";
                    } else {
                        echo "  ❌ Insufficient stock!\n";
                    }
                } else {
                    echo "  ❌ Product not found in database!\n";
                }
            }
            echo "\n";
        }
    } else {
        echo "❌ Cart items is not a valid array!\n";
        echo "Raw cart_items value: ";
        var_dump($order->cart_items);
    }

    // 4. Test manual call ke reduceProductStock
    echo "\n--- Manual Test of reduceProductStock ---\n";
    $order->reduceProductStock();
    echo "✅ reduceProductStock() method called\n";

    // 5. Cleanup if this was a test order
    if (strpos($order->order_id, 'DEBUG-') === 0) {
        echo "\n--- Cleanup ---\n";
        $order->delete();
        echo "✅ Test order deleted\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Debug Completed ===\n";
