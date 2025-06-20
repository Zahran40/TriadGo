<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;
use App\Models\Product;
use App\Models\User;

echo "=== TESTING MANUAL PAYMENT SCENARIO ===\n\n";

// Create a test user if not exists
$user = User::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test User',
        'country' => 'Indonesia',
        'phone' => '081234567890',
        'password' => bcrypt('password'),
        'role' => 'customer'
    ]
);

// Create a test product if not exists
$product = Product::firstOrCreate(
    ['product_id' => 'TEST-PRODUCT-001'],
    [
        'user_id' => $user->user_id,
        'product_name' => 'Test Product',
        'product_description' => 'A test product for manual payment testing',
        'price' => 100000,
        'stock_quantity' => 50,
        'category' => 'test',
        'product_sku' => 'TEST-SKU-001',
        'weight' => 1.00,
        'country_of_origin' => 'Indonesia',
        'status' => 'approved'
    ]
);

echo "📦 Product created/found: {$product->product_name} (Stock: {$product->stock_quantity})\n";

// Create a test order
$order = CheckoutOrder::create([
    'user_id' => $user->id,
    'order_id' => 'TEST-ORDER-' . time(),
    'total_amount' => 150000,
    'currency' => 'IDR',
    'status' => 'pending', // Start as pending
    'name' => 'Test Customer',
    'email' => 'test@customer.com',
    'phone' => '081234567890',
    'address' => 'Test Address',
    'city' => 'Jakarta',
    'state' => 'DKI Jakarta',
    'zip_code' => '12345',
    'country' => 'Indonesia',
    'payment_method' => 'bank_transfer',
    'cart_items' => [
        [
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'price' => $product->price,
            'quantity' => 2
        ]
    ],
    'subtotal' => 200000,
    'shipping_cost' => 0,
    'tax_amount' => 0,
    'discount_amount' => 50000,
    'payment_details' => []
]);

echo "📝 Order created: {$order->order_id} (Status: {$order->status})\n";
echo "🛒 Cart items: " . count($order->cart_items) . " item(s)\n\n";

// Show initial stock
$product->refresh();
echo "📊 Initial stock: {$product->stock_quantity}\n\n";

// Simulate manual database update (like what happens in phpMyAdmin)
echo "🔧 Simulating manual database update to 'paid' status...\n";
CheckoutOrder::where('id', $order->id)->update(['status' => 'paid']);
echo "✅ Order status manually updated to 'paid' in database\n\n";

// Check stock - should still be the same since no processing happened
$product->refresh();
echo "📊 Stock after manual status change: {$product->stock_quantity} (should be unchanged)\n\n";

// Now run the processing command
echo "⚡ Running stock processing command...\n";
$processedCount = CheckoutOrder::processManuallyPaidOrders();
echo "✅ Processed {$processedCount} order(s)\n\n";

// Check stock again - should now be reduced
$product->refresh();
echo "📊 Stock after processing: {$product->stock_quantity} (should be reduced by 2)\n\n";

// Verify order details
$order->refresh();
echo "📋 Order status: {$order->status}\n";
echo "📅 Payment completed at: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'null') . "\n";
echo "🔐 Stock reduced flag: " . (isset($order->payment_details['stock_reduced']) ? ($order->payment_details['stock_reduced'] ? 'Yes' : 'No') : 'Not set') . "\n\n";

// Test double processing prevention
echo "🔄 Testing double processing prevention...\n";
$processedCount2 = CheckoutOrder::processManuallyPaidOrders();
echo "✅ Second processing attempt processed {$processedCount2} order(s) (should be 0)\n\n";

// Check stock one more time - should be the same
$product->refresh();
echo "📊 Final stock: {$product->stock_quantity} (should be unchanged from previous check)\n\n";

// Cleanup
echo "🧹 Cleaning up test data...\n";
$order->delete();
$product->delete();
$user->delete();
echo "✅ Test completed and cleaned up!\n";
