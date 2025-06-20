<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckoutOrder;

class ProcessPaidOrdersStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:process-stock {--dry-run : Show what would be processed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process stock reduction for orders that were manually marked as paid';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('🔍 Scanning for paid orders that need stock processing...');
        
        $orders = CheckoutOrder::where('status', 'paid')
            ->whereNull('payment_completed_at')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('✅ No orders found that need stock processing.');
            return;
        }

        $this->info("📦 Found {$orders->count()} order(s) that need processing:");
        $this->newLine();

        $headers = ['Order ID', 'Customer', 'Amount', 'Created At'];
        $rows = [];

        foreach ($orders as $order) {
            $rows[] = [
                $order->order_id,
                $order->name,
                $order->formatted_total,
                $order->created_at->format('Y-m-d H:i:s')
            ];
        }

        $this->table($headers, $rows);
        $this->newLine();

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
            $this->info('Run without --dry-run to actually process these orders');
            return;
        }

        if (!$this->confirm('Do you want to process these orders? This will reduce stock and clear carts.')) {
            $this->info('❌ Operation cancelled');
            return;
        }

        $this->info('⚡ Processing orders...');
        $progressBar = $this->output->createProgressBar($orders->count());
        $progressBar->start();

        $processedCount = 0;

        foreach ($orders as $order) {
            try {
                // Set payment completed time
                $order->update(['payment_completed_at' => now()]);
                
                // Process stock reduction and cart clearing
                $order->reduceProductStock();
                $order->clearUserCart();
                
                $processedCount++;
                
            } catch (\Exception $e) {
                $this->error("\n❌ Error processing order {$order->order_id}: " . $e->getMessage());
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Successfully processed {$processedCount} out of {$orders->count()} orders");
        
        if ($processedCount > 0) {
            $this->info('📊 Stock has been reduced and carts have been cleared for processed orders');
        }
    }
}
