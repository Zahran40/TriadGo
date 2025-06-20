<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckoutOrder;

class TestCheckoutRedirect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:checkout-redirect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test checkout redirect functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Checkout Redirect Functionality');
        $this->info('=' . str_repeat('=', 50));

        // Show available orders
        $orders = CheckoutOrder::select('order_id', 'status', 'created_at')->orderBy('created_at', 'desc')->take(5)->get();
        
        if ($orders->isEmpty()) {
            $this->warn('No orders found in database.');
            return 0;
        }

        $this->info("\n📋 Recent Orders:");
        foreach ($orders as $order) {
            $this->line("  - {$order->order_id} ({$order->status}) - {$order->created_at->format('Y-m-d H:i:s')}");
        }

        $this->info("\n🔧 Testing Redirect URLs:");
        foreach ($orders->take(3) as $order) {
            $detailUrl = url("/transactions/{$order->order_id}");
            $this->line("  - Order {$order->order_id}: {$detailUrl}");
        }

        $transactionsUrl = route('transactions.index');
        $this->info("\n📄 Transactions List URL: {$transactionsUrl}");

        $this->info("\n💡 Checkout Flow After Changes:");
        $this->line("1. User completes payment via Midtrans");
        $this->line("2. SweetAlert shows success message");
        $this->line("3. User clicks 'View Order Details' button");
        $this->line("4. Cart is cleared");
        $this->line("5. User is redirected to: /transactions/{ORDER_ID}");
        $this->line("6. User sees detailed order information");

        $this->info("\n🌐 To test the complete flow:");
        $this->line("1. Open: http://127.0.0.1:8000/formImportir");
        $this->line("2. Add items to cart from catalog");
        $this->line("3. Complete checkout form");
        $this->line("4. Use Midtrans test payment");
        $this->line("5. Verify redirect goes to order detail page");

        return 0;
    }
}
