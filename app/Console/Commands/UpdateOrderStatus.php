<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckoutOrder;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:update-status {order_id} {status} {--reason=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order status manually';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $newStatus = $this->argument('status');
        $reason = $this->option('reason') ?? 'Manual update via command';
        
        // Find the order
        $order = CheckoutOrder::where('order_id', $orderId)->first();
        
        if (!$order) {
            $this->error("Order not found: {$orderId}");
            return 1;
        }
        
        $this->info("Current order status: {$order->status}");
        $this->info("Updating to: {$newStatus}");
        
        try {
            $order->updateStatus($newStatus, $reason);
            
            $this->info("✅ Order status updated successfully!");
            $this->info("Order ID: {$order->order_id}");
            $this->info("Status: {$order->status}");
            $this->info("Payment Status: {$order->payment_status}");
            $this->info("Shipping Status: {$order->shipping_status}");
            $this->info("Payment Completed At: " . ($order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : 'Not set'));
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error updating order status: " . $e->getMessage());
            return 1;
        }
    }
}
