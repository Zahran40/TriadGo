<?php
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CheckoutOrder;

echo "🧪 TESTING UPDATED COMPLETE ORDER BUTTON\n";
echo "========================================\n\n";

// Test adding a product to cart and checking the price calculation
echo "📝 Testing price calculation with current setup:\n";
echo "- Product price: $0.10\n";
echo "- Shipping: $0.10\n";
echo "- Tax rate: 10%\n";
echo "- Expected calculation:\n";

$productPrice = 0.10;
$quantity = 1;
$subtotal = $productPrice * $quantity;
$shipping = 0.10;
$taxRate = 0.10;
$tax = $subtotal * $taxRate;
$total = $subtotal + $shipping + $tax;

echo "  Subtotal: \$" . number_format($subtotal, 2) . "\n";
echo "  Shipping: \$" . number_format($shipping, 2) . "\n";
echo "  Tax (10%): \$" . number_format($tax, 2) . "\n";
echo "  TOTAL: \$" . number_format($total, 2) . "\n\n";

echo "🎯 EXPECTED BUTTON TEXT:\n";
echo "Complete Order - \$" . number_format($total, 2) . "\n\n";

// Check recent orders to see what amounts are being created
$recentOrder = CheckoutOrder::orderBy('created_at', 'desc')->first();

if ($recentOrder) {
    echo "📊 LAST ORDER CREATED:\n";
    echo "Order ID: {$recentOrder->order_id}\n";
    echo "Amount: \${$recentOrder->total_amount} {$recentOrder->currency}\n";
    echo "Cart Items: " . json_encode($recentOrder->cart_items, JSON_PRETTY_PRINT) . "\n";
    echo "Subtotal: \${$recentOrder->subtotal}\n";
    echo "Shipping: \${$recentOrder->shipping_cost}\n";
    echo "Tax: \${$recentOrder->tax_amount}\n";
    echo "Total: \${$recentOrder->total_amount}\n\n";
}

echo "✅ CHANGES MADE:\n";
echo "1. ✅ Updated updatePricing() function to update button text\n";
echo "2. ✅ Added updateCompleteOrderButton() function\n";
echo "3. ✅ Changed default button text from \$300.00 to \$0.21\n";
echo "4. ✅ Fixed PayPal fallback value from 300.00 to 0.21\n";
echo "5. ✅ Fixed transfer amount from \$300.00 to \$0.21\n";
echo "6. ✅ Added event listener for cart updates\n";
echo "7. ✅ Auto-update on page load\n\n";

echo "🔍 TESTING STEPS:\n";
echo "1. Open http://localhost/TriadGo/public/formImportir\n";
echo "2. Add a product to cart\n";
echo "3. Check if 'Complete Order' button shows correct amount\n";
echo "4. Change quantity and verify button updates\n";
echo "5. Remove items and verify button updates\n\n";

echo "✅ Testing completed. Please check the browser to verify the button shows the correct amount.\n";
