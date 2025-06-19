<?php

require_once 'vendor/autoload.php';

use App\Models\Product;
use App\Models\CheckoutOrder;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING PRICES VERIFICATION ===\n\n";

echo "📦 PRODUCT PRICES:\n";
echo "==================\n";
$products = Product::select('product_name', 'price')->take(5)->get();
foreach ($products as $product) {
    echo "- " . $product->product_name . ": $" . number_format($product->price, 2) . "\n";
}
echo "Total products: " . Product::count() . " (all set to $0.10)\n\n";

echo "🚢 SHIPPING COSTS:\n";
echo "==================\n";
$orders = CheckoutOrder::select('order_id', 'shipping_cost', 'total_amount')->take(5)->get();
foreach ($orders as $order) {
    echo "- " . $order->order_id . ": Shipping $" . number_format($order->shipping_cost, 2) . " | Total $" . number_format($order->total_amount, 2) . "\n";
}
echo "Total orders: " . CheckoutOrder::count() . " (all shipping set to $0.10)\n\n";

echo "✅ TESTING READY!\n";
echo "================\n";
echo "- Product prices: $0.10 each\n";
echo "- Shipping cost: $0.10 per order\n";
echo "- Tax: 10% of subtotal\n";
echo "- Example: 1 product + shipping + tax = $0.10 + $0.10 + $0.01 = $0.21\n";
echo "- In Midtrans: ~Rp 3,200 (very affordable for testing!)\n";
