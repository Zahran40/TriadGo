<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CheckoutOrder;
use App\Services\MidtransHttpService;
use Illuminate\Support\Facades\DB;

class TestCheckoutFlow extends Command
{
    protected $signature = 'test:checkout-flow {user_id?}';
    protected $description = 'Test the complete checkout flow';

    protected $midtransService;

    public function __construct(MidtransHttpService $midtransService)
    {
        parent::__construct();
        $this->midtransService = $midtransService;
    }

    public function handle()
    {
        $this->info('🛒 Testing Complete Checkout Flow');
        $this->info('================================');

        // Get user ID from argument or use first importir user
        $userId = $this->argument('user_id');
        if (!$userId) {
            $user = User::where('role', 'impor')->first();
            if (!$user) {
                $this->error('❌ No importir users found');
                return 1;
            }
            $userId = $user->user_id;
        } else {
            $user = User::where('user_id', $userId)->first();
            if (!$user) {
                $this->error("❌ User with ID {$userId} not found");
                return 1;
            }
        }

        $this->info("👤 Testing with user: {$user->name} (ID: {$user->user_id})");
        $this->newLine();

        // Step 1: Clean previous cart
        $this->info('1. Cleaning previous cart...');
        Cart::where('user_id', $user->user_id)->delete();
        $this->info('   ✅ Cart cleaned');

        // Step 2: Add items to cart
        $this->info('2. Adding items to cart...');
        $products = Product::where('stock_quantity', '>', 0)->take(2)->get();
        if ($products->count() < 2) {
            $this->error('❌ Not enough products with stock available');
            return 1;
        }

        foreach ($products as $product) {
            $quantity = rand(1, min(3, $product->stock_quantity));
            Cart::create([
                'user_id' => $user->user_id,
                'product_id' => $product->product_id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
            $this->info("   ✅ Added: {$product->product_name} (Qty: {$quantity})");
        }

        // Step 3: Verify cart
        $this->info('3. Verifying cart...');
        $cartItems = $user->getCartWithProducts();
        $cartTotal = $user->getCartTotal();
        $cartCount = $user->getCartCount();
        
        $this->info("   ✅ Cart Items: {$cartItems->count()}");
        $this->info("   ✅ Cart Count: {$cartCount}");
        $this->info("   ✅ Cart Total: \${$cartTotal}");

        // Step 4: Test checkout data preparation
        $this->info('4. Testing checkout data preparation...');
        $testOrderData = [
            'user_id' => $user->user_id,
            'order_id' => CheckoutOrder::generateOrderId(),
            'total_amount' => $cartTotal + 25.00 + ($cartTotal * 0.10), // Add shipping and tax
            'currency' => 'USD',
            'status' => 'pending',
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '1234567890',
            'address' => '123 Test Street',
            'city' => 'Test City',
            'state' => 'Test State',
            'zip_code' => '12345',
            'country' => 'US',
            'payment_method' => 'midtrans',
            'cart_items' => $cartItems->toArray(),
            'subtotal' => $cartTotal,
            'shipping_cost' => 25.00,
            'tax_amount' => $cartTotal * 0.10,
            'discount_amount' => 0,
        ];

        $this->info("   ✅ Order ID: {$testOrderData['order_id']}");
        $this->info("   ✅ Total Amount: \${$testOrderData['total_amount']}");

        // Step 5: Test order creation
        $this->info('5. Testing order creation...');
        try {
            DB::beginTransaction();
            $order = CheckoutOrder::create($testOrderData);
            $this->info("   ✅ Order created: {$order->order_id}");
            
            // Step 6: Test Midtrans integration (without actually creating token)
            $this->info('6. Testing Midtrans configuration...');
            $clientKey = config('services.midtrans.client_key');
            $serverKey = config('services.midtrans.server_key');
            $merchantId = config('services.midtrans.merchant_id');
            $environment = config('services.midtrans.is_production') ? 'production' : 'sandbox';
            
            $this->info("   ✅ Client Key: " . (empty($clientKey) ? '❌ NOT SET' : '✅ SET'));
            $this->info("   ✅ Server Key: " . (empty($serverKey) ? '❌ NOT SET' : '✅ SET'));
            $this->info("   ✅ Merchant ID: " . (empty($merchantId) ? '❌ NOT SET' : $merchantId));
            $this->info("   ✅ Environment: {$environment}");

            // Step 7: Test order status methods
            $this->info('7. Testing order methods...');
            $this->info("   ✅ Is Paid: " . ($order->isPaid() ? 'Yes' : 'No'));
            $this->info("   ✅ Formatted Total: {$order->formatted_total}");
            
            // Step 8: Test payment simulation
            if ($this->confirm('Do you want to simulate payment completion?', true)) {
                $this->info('8. Simulating payment completion...');
                $order->markAsPaid('TEST-' . time(), ['test_payment' => true]);
                $this->info("   ✅ Payment marked as completed");
                $this->info("   ✅ Order status: {$order->status}");
                
                // Clear cart after successful payment
                Cart::where('user_id', $user->user_id)->delete();
                $this->info("   ✅ Cart cleared after successful payment");
            }

            DB::commit();
            $this->newLine();
            $this->info('✅ Checkout Flow Test Complete!');
            $this->info("📋 Order Summary:");
            $this->info("   - Order ID: {$order->order_id}");
            $this->info("   - Status: {$order->status}");
            $this->info("   - Total: {$order->formatted_total}");
            $this->info("   - Customer: {$order->name}");

        } catch (\Exception $e) {
            DB::rollback();
            $this->error('❌ Error during order creation: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
