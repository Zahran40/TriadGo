<?php

namespace App\Services;

use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransHttpService
{
    protected $serverKey;
    protected $isProduction;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        $this->isProduction = config('services.midtrans.is_production') ?: env('MIDTRANS_IS_PRODUCTION', false);
        $this->apiBaseUrl = $this->isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * Create Snap Token using Laravel HTTP client
     */
    public function createSnapToken(CheckoutOrder $order)
    {
        try {
            // Convert USD to IDR for Midtrans (Midtrans only accepts IDR)
            $amountInIDR = $this->convertToIDR($order->total_amount, $order->currency);            // Prepare transaction parameters with enhanced payment methods
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_id,
                    'gross_amount' => $amountInIDR
                ],
                'customer_details' => [
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                    'billing_address' => [
                        'first_name' => $order->first_name,
                        'last_name' => $order->last_name,
                        'address' => $order->address,
                        'city' => $order->city,
                        'postal_code' => $order->zip_code,
                        'country_code' => $this->convertToISO3CountryCode($order->country)
                    ]
                ],
                'item_details' => $this->buildItemDetails($order),
                // ✅ COMPREHENSIVE PAYMENT METHODS - Optimized for Payment Simulator
                'enabled_payments' => [
                    // E-Wallet Methods (Simulator Compatible Order)
                    'gopay',           // GoPay - Priority 1 (simplest for simulator)
                    'qris',            // QRIS Universal - Priority 2
                    'shopeepay',       // ShopeePay - Priority 3
                    
                    // Credit/Debit Cards  
                    'credit_card',     // Credit Card
                    
                    // Bank Transfer & Virtual Account
                    'bca_va',          // BCA Virtual Account
                    'bni_va',          // BNI Virtual Account  
                    'bri_va',          // BRI Virtual Account
                    'permata_va',      // Permata Virtual Account
                    'bank_transfer',   // Manual bank transfer
                    'echannel',        // Mandiri ClickPay
                    
                    // Convenience Store
                    'cstore',          // Indomaret, Alfamart
                    
                    // Cardless Credit
                    'akulaku'          // Akulaku PayLater
                ],
                
                // ✅ CREDIT CARD CONFIGURATION
                'credit_card' => [
                    'secure' => true,
                    'channel' => 'migs',
                    'bank' => 'bca',
                    'save_card' => false,
                    'save_token_id' => false
                ],
                
                // ✅ QRIS CONFIGURATION - Simplified for Payment Simulator
                'qris' => [
                    'acquirer' => 'gopay'  // Use gopay acquirer for better simulator compatibility
                ],
                
                // ✅ GOPAY CONFIGURATION - Simplified for Payment Simulator
                'gopay' => [
                    'enable_callback' => true,
                    'callback_url' => url('/midtrans/callback')
                    // Remove complex payment_options and account_id for simulator compatibility
                ],
                
                // ✅ SHOPEEPAY CONFIGURATION  
                'shopeepay' => [
                    'callback_url' => url('/midtrans/callback')
                ],
                
                // ✅ BANK TRANSFER CONFIGURATION
                'bank_transfer' => [
                    'bank' => ['bca', 'bni', 'bri', 'permata', 'mandiri'],
                    'va_numbers' => [
                        'bca' => ['va_number' => '12345678901'],
                        'bni' => ['va_number' => '12345678902']
                    ]
                ],
                
                // ✅ CONVENIENCE STORE CONFIGURATION
                'cstore' => [
                    'store' => 'indomaret',
                    'message' => 'Payment for TriadGO Order'
                ],
                
                // ✅ SANDBOX SPECIFIC CONFIGURATION
                'custom_expiry' => [
                    'order_time' => date('Y-m-d H:i:s O'),
                    'expiry_duration' => 60,
                    'unit' => 'minute'
                ],
                
                // ✅ ADVANCED PAYMENT PREFERENCES - Simplified for Payment Simulator
                'payment_options' => [
                    'enabled_payments' => [
                        // E-Wallet Priority (most compatible in sandbox simulator)
                        'gopay',           // ✅ GoPay - Primary e-wallet
                        'qris',            // ✅ QRIS - Universal QR
                        'shopeepay',       // ✅ ShopeePay
                        
                        // Traditional Methods
                        'credit_card',     // ✅ Credit card
                        'bca_va',
                        'bni_va', 
                        'bri_va',
                        'bank_transfer',
                        'echannel',
                        'cstore'
                    ]
                ],
                
                // ✅ SANDBOX ENVIRONMENT OPTIMIZATION
                'custom_field_1' => 'SANDBOX_SIMULATOR',  // Flag for Midtrans to optimize for simulator
                
                'callbacks' => [
                    'finish' => url("/checkout/success?order=" . $order->order_id),
                    'unfinish' => url("/checkout/pending?order=" . $order->order_id),
                    'error' => url("/checkout/error?order=" . $order->order_id)
                ]
            ];

            Log::info('Midtrans HTTP Request Parameters', $params);

            // Make HTTP request to Midtrans API
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':')
            ])->post($this->apiBaseUrl, $params);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Midtrans HTTP Response Success', $data);
                return $data['token'];
            } else {
                Log::error('Midtrans HTTP Response Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to create payment token: ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('Midtrans HTTP Service Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Convert amount to IDR
     */
    private function convertToIDR($amount, $currency)
    {
        if ($currency === 'IDR') {
            return (int) $amount;
        }

        // Simple conversion rates (in production, use live rates)
        $rates = [
            'USD' => 15000,
            'MYR' => 3500,
            'SGD' => 11000,
            'THB' => 420,
            'PHP' => 270,
            'VND' => 0.65,
            'BND' => 11000,
        ];

        $rate = $rates[$currency] ?? 15000; // Default to USD rate
        return (int) ($amount * $rate);
    }    /**
     * Build item details for Midtrans
     */
    private function buildItemDetails(CheckoutOrder $order)
    {
        $items = [];
        $cartItems = $order->cart_items ?: [];

        // Add cart items
        foreach ($cartItems as $item) {
            $priceInIDR = $this->convertToIDR($item['price'], $order->currency);
            $items[] = [
                'id' => $item['product_id'] ?? 'PRODUCT-' . rand(1000, 9999),
                'price' => $priceInIDR,
                'quantity' => $item['quantity'] ?? 1,
                'name' => $item['product_name'] ?? $item['name'] ?? 'Product',
                'brand' => 'TriadGO',
                'category' => 'Products',
                'merchant_name' => 'TriadGO'
            ];
        }

        // Add shipping cost if exists
        if ($order->shipping_cost > 0) {
            $shippingInIDR = $this->convertToIDR($order->shipping_cost, $order->currency);
            $items[] = [
                'id' => 'shipping',
                'price' => $shippingInIDR,
                'quantity' => 1,
                'name' => 'Shipping Cost',
                'brand' => 'TriadGO',
                'category' => 'Shipping'
            ];
        }

        // Add tax if exists
        if ($order->tax_amount > 0) {
            $taxInIDR = $this->convertToIDR($order->tax_amount, $order->currency);
            $items[] = [
                'id' => 'tax',
                'price' => $taxInIDR,
                'quantity' => 1,
                'name' => 'Tax',
                'brand' => 'TriadGO',
                'category' => 'Tax'
            ];
        }

        return $items;
    }

    /**
     * Handle notification from Midtrans webhook
     */
    public function handleNotification($notificationData)
    {
        try {
            // Extract notification data
            $orderId = $notificationData['order_id'] ?? null;
            $transactionStatus = $notificationData['transaction_status'] ?? null;
            $fraudStatus = $notificationData['fraud_status'] ?? null;
            $transactionId = $notificationData['transaction_id'] ?? null;
            $paymentType = $notificationData['payment_type'] ?? null;
            
            // Enhanced logging for better debugging
            Log::info('Processing Midtrans notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId
            ]);

            // Validate required data
            if (!$orderId || !$transactionStatus) {
                Log::error('Missing required notification data', $notificationData);
                return false;
            }

            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                Log::warning('Order not found for notification', ['order_id' => $orderId]);
                return false;
            }

            // Handle different transaction statuses
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->markAsPaid($transactionId, $notificationData);
                    Log::info('Order marked as PAID via capture', [
                        'order_id' => $orderId,
                        'transaction_id' => $transactionId
                    ]);
                } else {
                    $order->update(['status' => 'failed']);
                    Log::warning('Order marked as FAILED due to fraud capture', [
                        'order_id' => $orderId,
                        'fraud_status' => $fraudStatus
                    ]);
                }
            } elseif ($transactionStatus == 'settlement') {
                // Settlement always means payment successful (no fraud check needed)
                $order->markAsPaid($transactionId, $notificationData);
                Log::info('Order marked as PAID via settlement', [
                    'order_id' => $orderId,
                    'transaction_id' => $transactionId,
                    'payment_type' => $paymentType
                ]);
            } elseif ($transactionStatus == 'pending') {
                // Payment pending - keep current status
                $order->update(['status' => 'pending']);
                Log::info('Order status updated to pending', ['order_id' => $orderId]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
                // Payment failed
                $order->update(['status' => 'failed']);
                Log::info('Order marked as FAILED', [
                    'order_id' => $orderId,
                    'reason' => $transactionStatus
                ]);
            } else {
                Log::warning('Unknown transaction status received', [
                    'order_id' => $orderId,
                    'transaction_status' => $transactionStatus,
                    'full_data' => $notificationData
                ]);
            }

            // Log successful processing for dashboard sync
            Log::info('Notification processed successfully for dashboard sync', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'processed_at' => now()->toISOString(),
                'merchant_id' => config('midtrans.merchant_id')
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Midtrans notification handling error', [
                'error' => $e->getMessage(),
                'data' => $notificationData,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Get transaction status from Midtrans
     */
    public function getTransactionStatus($orderId)
    {
        try {
            $statusUrl = $this->isProduction 
                ? "https://api.midtrans.com/v2/{$orderId}/status"
                : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':')
            ])->get($statusUrl);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to get transaction status', [
                    'order_id' => $orderId,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

        } catch (\Exception $e) {
            Log::error('Error getting transaction status: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Convert ISO 2-letter country code to ISO 3-letter country code for Midtrans
     */
    private function convertToISO3CountryCode($countryCode)
    {
        $mapping = [
            'ID' => 'IDN', // Indonesia
            'MY' => 'MYS', // Malaysia
            'SG' => 'SGP', // Singapore
            'TH' => 'THA', // Thailand
            'PH' => 'PHL', // Philippines
            'VN' => 'VNM', // Vietnam
            'BN' => 'BRN', // Brunei
            'LA' => 'LAO', // Laos
            'KH' => 'KHM', // Cambodia
            'MM' => 'MMR', // Myanmar
            'US' => 'USA', // United States
            'GB' => 'GBR', // United Kingdom
            'AU' => 'AUS', // Australia
            'JP' => 'JPN', // Japan
            'KR' => 'KOR', // South Korea
            'CN' => 'CHN', // China
            'IN' => 'IND', // India
        ];

        return $mapping[$countryCode] ?? 'IDN'; // Default to Indonesia
    }
}