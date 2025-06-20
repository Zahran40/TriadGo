<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\DB;

class SimulateManualStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:manual-update {order_id} {new_status} {--direct-db : Update directly in database without using model methods}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate manual status update as done by exportir/admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $newStatus = $this->argument('new_status');
        $directDb = $this->option('direct-db');

        // Find the order
        $order = CheckoutOrder::where('order_id', $orderId)->first();
        
        if (!$order) {
            $this->error("Order with ID {$orderId} not found.");
            return 1;
        }

        $this->info("🔍 Current Order Status:");
        $this->info("Order ID: {$order->order_id}");
        $this->info("Status: {$order->status}");
        $this->info("Payment Status: {$order->payment_status}");
        $this->info("Shipping Status: {$order->shipping_status}");
        $this->info("Payment Completed At: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'null'));

        if ($directDb) {
            // Simulate direct database update (like what might happen from external admin panel)
            $this->info("\n🔧 Simulating DIRECT DATABASE UPDATE (like external admin panel)...");
            
            $updateData = [
                'status' => $newStatus,
                'payment_status' => $newStatus,
                'updated_at' => now()
            ];
            
            // Update related fields based on status
            if ($newStatus === 'paid') {
                $updateData['payment_completed_at'] = now();
                if ($order->shipping_status === 'pending') {
                    $updateData['shipping_status'] = 'processing';
                }
            } elseif (in_array($newStatus, ['cancelled', 'failed', 'expired'])) {
                $updateData['payment_completed_at'] = null;
                $updateData['shipping_status'] = 'pending';
            }
            
            DB::table('checkout_orders')
                ->where('id', $order->id)
                ->update($updateData);
                
            $this->info("✅ Direct database update completed!");
            
        } else {
            // Use model method (proper way)
            $this->info("\n🔧 Using MODEL METHOD (proper way)...");
            
            try {
                $order->updateStatus($newStatus, 'Simulated manual update by admin/exportir');
                $this->info("✅ Model method update completed!");
            } catch (\Exception $e) {
                $this->error("❌ Error using model method: " . $e->getMessage());
                return 1;
            }
        }

        // Show updated status
        $updatedOrder = CheckoutOrder::find($order->id);
        $this->info("\n📋 Updated Order Status:");
        $this->info("Order ID: {$updatedOrder->order_id}");
        $this->info("Status: {$updatedOrder->status}");
        $this->info("Payment Status: {$updatedOrder->payment_status}");
        $this->info("Shipping Status: {$updatedOrder->shipping_status}");
        $this->info("Payment Completed At: " . ($updatedOrder->payment_completed_at ? $updatedOrder->payment_completed_at->format('Y-m-d H:i:s') : 'null'));

        $this->info("\n🌐 TEST INSTRUCTIONS:");
        $this->info("1. Open browser to: http://127.0.0.1:8000/transactions");
        $this->info("2. Click on order: {$updatedOrder->order_id}");
        $this->info("3. Verify that the status shows: {$updatedOrder->status}");
        $this->info("4. Check if tracking button appears for paid orders");
        $this->info("5. Verify payment completed date is shown correctly");

        // Show change history if using model method
        if (!$directDb && isset($updatedOrder->payment_details['status_changes'])) {
            $this->info("\n📝 Status Change History:");
            foreach ($updatedOrder->payment_details['status_changes'] as $change) {
                $this->line("  - {$change['old_status']} → {$change['new_status']} at {$change['status_changed_at']} (Reason: {$change['reason']})");
            }
        }

        return 0;
    }
}
