<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;

echo "=== TESTING TRANSACTION DETAIL PAGE ===\n\n";

// Get a sample order to test
$order = CheckoutOrder::first();

if (!$order) {
    echo "❌ No orders found in database\n";
    exit;
}

echo "✅ Sample order found:\n";
echo "  - Order ID: {$order->order_id}\n";
echo "  - Customer: {$order->name}\n";
echo "  - Status: {$order->status}\n";
echo "  - Total: {$order->formatted_total}\n";
echo "  - Items: " . count($order->cart_items) . "\n";
echo "  - Created: {$order->created_at->format('Y-m-d H:i:s')}\n\n";

echo "📋 Cart Items Details:\n";
foreach ($order->cart_items as $index => $item) {
    echo "  Item " . ($index + 1) . ":\n";
    echo "    - Product ID: " . ($item['product_id'] ?? 'N/A') . "\n";
    echo "    - Name: " . ($item['product_name'] ?? 'Unknown') . "\n";
    echo "    - Price: $" . number_format($item['price'] ?? 0, 2) . "\n";
    echo "    - Quantity: " . ($item['quantity'] ?? 0) . "\n";
    echo "    - Subtotal: $" . number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) . "\n\n";
}

echo "💳 Payment Details:\n";
if ($order->payment_details && count($order->payment_details) > 0) {
    foreach ($order->payment_details as $key => $value) {
        if (is_array($value)) {
            echo "  - {$key}: " . json_encode($value) . "\n";
        } else {
            echo "  - {$key}: {$value}\n";
        }
    }
} else {
    echo "  - No payment details available\n";
}

echo "\n📍 Shipping Address:\n";
echo "  - Address: {$order->address}\n";
echo "  - City: {$order->city}, {$order->state}\n";
echo "  - ZIP: {$order->zip_code}\n";
echo "  - Country: {$order->country}\n\n";

echo "💰 Order Summary:\n";
echo "  - Subtotal: $" . number_format($order->subtotal, 2) . "\n";
echo "  - Shipping: $" . number_format($order->shipping_cost, 2) . "\n";
echo "  - Tax: $" . number_format($order->tax_amount, 2) . "\n";
echo "  - Discount: $" . number_format($order->discount_amount, 2) . "\n";
echo "  - TOTAL: {$order->formatted_total}\n\n";

echo "🔗 Test URLs:\n";
echo "  - List: http://localhost:8000/transactions\n";
echo "  - Detail: http://localhost:8000/transactions/{$order->order_id}\n";
if ($order->status === 'paid') {
    echo "  - Invoice: http://localhost:8000/transactions/{$order->order_id}/invoice\n";
}

echo "\n✅ Ready to test transaction detail page!\n";
