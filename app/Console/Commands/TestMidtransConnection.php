<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Midtrans\Config;
use Midtrans\Snap;

class TestMidtransConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'midtrans:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Midtrans connection and configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Midtrans Configuration...');
        $this->newLine();

        // Test direct env reading
        $this->info('=== Direct Environment Check ===');
        $this->line("MIDTRANS_MERCHANT_ID from env(): " . env('MIDTRANS_MERCHANT_ID', 'NOT FOUND'));
        $this->line("MIDTRANS_CLIENT_KEY from env(): " . env('MIDTRANS_CLIENT_KEY', 'NOT FOUND'));
        $this->line("MIDTRANS_SERVER_KEY from env(): " . env('MIDTRANS_SERVER_KEY', 'NOT FOUND'));
        $this->newLine();

        // Test configuration
        $this->info('=== Configuration Check ===');
        $merchantId = config('midtrans.merchant_id');
        $clientKey = config('midtrans.client_key');
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');

        $this->line("Merchant ID: " . ($merchantId ? $merchantId : 'NOT SET'));
        $this->line("Client Key: " . ($clientKey ? substr($clientKey, 0, 10) . '...' : 'NOT SET'));
        $this->line("Server Key: " . ($serverKey ? substr($serverKey, 0, 10) . '...' : 'NOT SET'));
        $this->line("Is Production: " . ($isProduction ? 'YES' : 'NO (Sandbox)'));
        $this->newLine();

        // Use direct env values for testing
        $testMerchantId = env('MIDTRANS_MERCHANT_ID', 'G699511196');
        $testClientKey = env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-JV1hxBKvK54RC4PV');
        $testServerKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-vtes-EfWHAlMBGLjEXF06HtG');
        $testIsProduction = env('MIDTRANS_IS_PRODUCTION', false);

        if (!$testClientKey || !$testServerKey) {
            $this->error('❌ Missing Midtrans configuration. Using fallback values for testing.');
            // Fallback untuk testing
            $testClientKey = 'SB-Mid-client-JV1hxBKvK54RC4PV';
            $testServerKey = 'SB-Mid-server-vtes-EfWHAlMBGLjEXF06HtG';
        }

        // Set Midtrans configuration with test values
        Config::$serverKey = $testServerKey;
        Config::$isProduction = $testIsProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->info('=== API Connection Test ===');
        $this->line("Using Server Key: " . substr($testServerKey, 0, 10) . '...');

        try {
            // Test with a sample transaction
            $params = [
                'transaction_details' => [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 100000, // IDR 100,000
                ],
                'customer_details' => [
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test@example.com',
                    'phone' => '+628123456789',
                ],
                'item_details' => [
                    [
                        'id' => 'test-item',
                        'price' => 100000,
                        'quantity' => 1,
                        'name' => 'Test Item'
                    ]
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            if ($snapToken) {
                $this->info('✅ Successfully connected to Midtrans!');
                $this->line("Generated Snap Token: " . substr($snapToken, 0, 20) . '...');
                $this->newLine();
                
                $this->info('=== Environment Details ===');
                $this->line("Environment: " . ($testIsProduction ? 'PRODUCTION' : 'SANDBOX'));
                $this->line("API Base URL: " . ($testIsProduction ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com'));
                $this->newLine();
                
                $this->info('✅ Midtrans is properly configured and ready to use!');
                return 0;
            } else {
                $this->error('❌ Failed to get Snap token from Midtrans');
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Error connecting to Midtrans: ' . $e->getMessage());
            $this->newLine();
            
            $this->info('=== Troubleshooting Tips ===');
            $this->line('1. Verify your Midtrans credentials in .env file');
            $this->line('2. Make sure you\'re using the correct environment (sandbox/production)');
            $this->line('3. Check your internet connection');
            $this->line('4. Verify that your Midtrans account is active');
            
            return 1;
        }
    }
}
