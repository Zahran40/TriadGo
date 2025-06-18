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
            $amountInIDR = $this->convertToIDR($order->total_amount, $order->currency);            // Prepare transaction parameters
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
    }

    /**
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
                'id' => $item['id'],
                'price' => $priceInIDR,
                'quantity' => $item['quantity'],
                'name' => $item['name'],
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
            $orderId = $notificationData['order_id'];
            $transactionStatus = $notificationData['transaction_status'];
            $fraudStatus = $notificationData['fraud_status'] ?? null;

            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                Log::warning('Order not found for notification', ['order_id' => $orderId]);
                return false;
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->markAsPaid($notificationData['transaction_id'], $notificationData);
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->markAsPaid($notificationData['transaction_id'], $notificationData);
            } elseif ($transactionStatus == 'pending') {
                // Payment pending
                $order->update(['status' => 'pending']);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $order->update(['status' => 'failed']);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Midtrans notification handling error: ' . $e->getMessage());
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
