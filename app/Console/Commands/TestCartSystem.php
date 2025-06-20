<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CheckoutOrder;

class TestCartSystem extends Command
{
    protected $signature = 'test:cart-system';
    protected $description = 'Test the cart system functionality';

    public function handle()
    {
        $this->info('🧪 Testing Cart System Functionality');
        $this->info('=====================================');

        // Test 1: Check database connectivity
        $this->newLine();
        $this->info('1. Testing Database Connectivity...');
        try {
            $userCount = User::count();
            $productCount = Product::count();
            $cartCount = Cart::count();
            $orderCount = CheckoutOrder::count();
            
            $this->info("   ✅ Users: {$userCount}");
            $this->info("   ✅ Products: {$productCount}");
            $this->info("   ✅ Cart Items: {$cartCount}");
            $this->info("   ✅ Orders: {$orderCount}");
        } catch (\Exception $e) {
            $this->error("   ❌ Database connection failed: " . $e->getMessage());
            return 1;
        }

        // Test 2: Check for importir users
        $this->newLine();
        $this->info('2. Checking Importir Users...');
        $importirUsers = User::where('role', 'impor')->get();
        if ($importirUsers->count() > 0) {
            $this->info("   ✅ Found {$importirUsers->count()} importir users:");
            foreach ($importirUsers->take(3) as $user) {
                $cartItemsCount = $user->getCartCount();
                $this->info("      - {$user->name} (ID: {$user->user_id}) - Cart: {$cartItemsCount} items");
            }
        } else {
            $this->warn('   ⚠️ No importir users found');
        }

        // Test 3: Check products available for import
        $this->newLine();
        $this->info('3. Checking Available Products...');
        $products = Product::take(3)->get();
        if ($products->count() > 0) {
            $this->info("   ✅ Found {$products->count()} products (showing first 3):");
            foreach ($products as $product) {
                $this->info("      - {$product->product_name} (\${$product->price}) - Stock: {$product->stock_quantity}");
            }
        } else {
            $this->warn('   ⚠️ No products found');
        }

        // Test 4: Check cart relationships
        $this->newLine();
        $this->info('4. Testing Cart Relationships...');
        $cartItems = Cart::with(['user', 'product'])->take(5)->get();
        if ($cartItems->count() > 0) {
            $this->info("   ✅ Found {$cartItems->count()} cart items:");
            foreach ($cartItems as $item) {
                $userName = $item->user ? $item->user->name : 'Unknown User';
                $productName = $item->product ? $item->product->product_name : 'Unknown Product';
                $this->info("      - {$userName}: {$productName} (Qty: {$item->quantity})");
            }
        } else {
            $this->info('   ℹ️ No cart items found');
        }

        // Test 5: Check recent orders
        $this->newLine();
        $this->info('5. Checking Recent Orders...');
        $orders = CheckoutOrder::orderBy('created_at', 'desc')->take(3)->get();
        if ($orders->count() > 0) {
            $this->info("   ✅ Found {$orders->count()} recent orders:");
            foreach ($orders as $order) {
                $this->info("      - {$order->order_id}: {$order->status} - \${$order->total_amount} ({$order->name})");
            }
        } else {
            $this->info('   ℹ️ No orders found');
        }

        // Test 6: Test cart methods on a user
        $this->newLine();
        $this->info('6. Testing User Cart Methods...');
        $testUser = User::where('role', 'impor')->first();
        if ($testUser) {
            $cartItems = $testUser->getCartWithProducts();
            $cartTotal = $testUser->getCartTotal();
            $cartCount = $testUser->getCartCount();
            
            $this->info("   ✅ Testing user: {$testUser->name}");
            $this->info("      - Cart Count: {$cartCount}");
            $this->info("      - Cart Total: \${$cartTotal}");
            $this->info("      - Cart Items: {$cartItems->count()}");
        } else {
            $this->warn('   ⚠️ No importir user available for testing');
        }

        $this->newLine();
        $this->info('✅ Cart System Test Complete!');
        
        return 0;
    }
}
