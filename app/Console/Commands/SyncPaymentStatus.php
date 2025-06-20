<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;

class SyncPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:sync-payment-status 
                            {--dry-run : Show what would be updated without making changes}
                            {--force : Force update without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync payment_status with status for all orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');
        
        $this->info('🔄 Synchronizing Payment Status with Order Status');
        $this->info('=================================================');
        
        // Find orders where payment_status doesn't match status
        $orders = CheckoutOrder::whereColumn('status', '!=', 'payment_status')
                              ->orWhereNull('payment_status')
                              ->get();

        if ($orders->isEmpty()) {
            $this->info('✅ All orders already have synchronized payment_status!');
            return 0;
        }

        $this->warn("Found {$orders->count()} orders with mismatched payment_status:");
        $this->newLine();

        // Show table of orders to be updated
        $tableData = [];
        foreach ($orders as $order) {
            $tableData[] = [
                $order->order_id,
                $order->status,
                $order->payment_status ?? 'NULL',
                $order->status, // Will update to this
                $order->created_at->format('Y-m-d H:i')
            ];
        }

        $this->table(
            ['Order ID', 'Current Status', 'Current Payment Status', 'Will Update To', 'Created'],
            $tableData
        );

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes made. Remove --dry-run to apply changes.');
            return 0;
        }

        if (!$force && !$this->confirm('Do you want to proceed with updating these orders?')) {
            $this->info('❌ Operation cancelled.');
            return 0;
        }

        // Process updates
        $this->info('⚡ Processing updates...');
        $progressBar = $this->output->createProgressBar($orders->count());
        $progressBar->start();

        $updateCount = 0;
        $errorCount = 0;

        foreach ($orders as $order) {
            try {
                $oldPaymentStatus = $order->payment_status;
                $newPaymentStatus = $order->status;
                
                // Update payment_status
                $order->payment_status = $newPaymentStatus;
                $order->save();
                
                Log::info('Payment status synchronized', [
                    'order_id' => $order->order_id,
                    'old_payment_status' => $oldPaymentStatus,
                    'new_payment_status' => $newPaymentStatus,
                    'status' => $order->status
                ]);
                
                $updateCount++;
                
            } catch (\Exception $e) {
                $this->error("❌ Error updating order {$order->order_id}: " . $e->getMessage());
                Log::error('Failed to sync payment status', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage()
                ]);
                $errorCount++;
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Show results
        if ($updateCount > 0) {
            $this->info("✅ Successfully updated {$updateCount} orders!");
        }
        
        if ($errorCount > 0) {
            $this->error("❌ Failed to update {$errorCount} orders. Check logs for details.");
        }

        // Show some statistics
        $this->newLine();
        $this->info('📊 Final Statistics:');
        $statusCounts = CheckoutOrder::selectRaw('status, payment_status, COUNT(*) as count')
                                   ->groupBy('status', 'payment_status')
                                   ->get();

        $statsTable = [];
        foreach ($statusCounts as $stat) {
            $isSync = $stat->status === $stat->payment_status ? '✅' : '❌';
            $statsTable[] = [
                $stat->status,
                $stat->payment_status ?? 'NULL',
                $stat->count,
                $isSync
            ];
        }

        $this->table(
            ['Status', 'Payment Status', 'Count', 'Synced'],
            $statsTable
        );

        return $errorCount > 0 ? 1 : 0;
    }
}
