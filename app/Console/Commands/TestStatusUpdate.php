<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckoutOrder;

class TestStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:status-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test automatic status updates on orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Status Update System...');
        
        // Create a test order with pending status
        $order = CheckoutOrder::create([
            'user_id' => 1,
            'order_id' => 'TEST' . now()->format('YmdHis'),
            'total_amount' => 100.00,
            'currency' => 'USD',
            'status' => 'pending',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'state' => 'Test State',
            'zip_code' => '12345',
            'country' => 'Indonesia',
            'payment_method' => 'midtrans',
            'cart_items' => [
                [
                    'product_id' => 1,
                    'product_name' => 'Test Product',
                    'price' => 50.00,
                    'quantity' => 2
                ]
            ],
            'subtotal' => 100.00,
            'shipping_cost' => 0.00,
            'tax_amount' => 0.00,
            'discount_amount' => 0.00
        ]);
        
        $this->info("✅ Created test order: {$order->order_id}");
        $this->info("   Status: {$order->status}");
        $this->info("   Payment Status: {$order->payment_status}");
        $this->info("   Shipping Status: {$order->shipping_status}");
        $this->info("   Invoice Code: {$order->invoice_code}");
        $this->info("   Tracking Number: {$order->tracking_number}");
        $this->line('');
        
        // Test 1: Update to paid
        $this->info('🔄 Test 1: Updating status from pending to paid...');
        $order->updateStatus('paid', 'Test payment confirmation');
        
        $this->info("   ✅ Status: {$order->status}");
        $this->info("   ✅ Payment Status: {$order->payment_status}");
        $this->info("   ✅ Shipping Status: {$order->shipping_status}");
        $this->info("   ✅ Payment Completed At: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'Not set'));
        $this->line('');
        
        // Test 2: Update shipping status
        $this->info('🔄 Test 2: Updating shipping status to shipped...');
        $order->updateShippingStatus('shipped', 'Package dispatched');
        
        $this->info("   ✅ Shipping Status: {$order->shipping_status}");
        $this->line('');
        
        // Test 3: Update back to cancelled
        $this->info('🔄 Test 3: Updating status from paid to cancelled...');
        $order->updateStatus('cancelled', 'Customer requested cancellation');
        
        $this->info("   ✅ Status: {$order->status}");
        $this->info("   ✅ Payment Status: {$order->payment_status}");
        $this->info("   ✅ Shipping Status: {$order->shipping_status}");
        $this->info("   ✅ Payment Completed At: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'Not set'));
        $this->line('');
        
        // Show payment details
        $this->info('📋 Payment Details (Status Changes):');
        if (isset($order->payment_details['status_changes'])) {
            foreach ($order->payment_details['status_changes'] as $i => $change) {
                $this->info("   " . ($i + 1) . ". {$change['old_status']} → {$change['new_status']} at {$change['status_changed_at']}");
                if (!empty($change['reason'])) {
                    $this->info("      Reason: {$change['reason']}");
                }
            }
        }
        
        $this->line('');
        $this->info('📋 Shipping Changes:');
        if (isset($order->payment_details['shipping_changes'])) {
            foreach ($order->payment_details['shipping_changes'] as $i => $change) {
                $this->info("   " . ($i + 1) . ". {$change['old_shipping_status']} → {$change['new_shipping_status']} at {$change['shipping_status_changed_at']}");
                if (!empty($change['reason'])) {
                    $this->info("      Reason: {$change['reason']}");
                }
            }
        }
        
        $this->line('');
        $this->info('🎉 Status update test completed successfully!');
        $this->info("View order details at: /transactions/{$order->order_id}");
        
        return 0;
    }
}
