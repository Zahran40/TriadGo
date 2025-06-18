<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;

class MidtransService
{    public function __construct()
    {
        // Debug: Check curl availability
        if (!function_exists('curl_init')) {
            Log::error('cURL extension is not available');
            throw new \Exception('cURL extension is required for Midtrans');
        }
        
        // Set Midtrans configuration - use services.midtrans config
        Config::$serverKey = config('services.midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = config('services.midtrans.is_production') ?: env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = config('services.midtrans.is_sanitized', true) ?: env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = config('services.midtrans.is_3ds', true) ?: env('MIDTRANS_IS_3DS', true);
        
        Log::info('Midtrans Config initialized', [
            'server_key' => substr(Config::$serverKey, 0, 10) . '...',
            'is_production' => Config::$isProduction,
            'curl_available' => function_exists('curl_init')
        ]);
    }

    /**
     * Create Snap Token for payment
     */
    public function createSnapToken(CheckoutOrder $order)
    {
        try {
            // Convert USD to IDR for Midtrans (Midtrans only accepts IDR)
            $amountInIDR = $this->convertToIDR($order->total_amount, $order->currency);

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_id,
                    'gross_amount' => (int) $amountInIDR,
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
                        'country_code' => $order->country,
                    ]
                ],
                'item_details' => $this->formatItemDetails($order),
                'callbacks' => [
                    'finish' => route('checkout.success', ['order' => $order->order_id]),
                    'unfinish' => route('checkout.pending', ['order' => $order->order_id]),
                    'error' => route('checkout.error', ['order' => $order->order_id])
                ]
            ];

            // Log the parameters for debugging
            Log::info('Midtrans Snap Token Parameters', $params);

            $snapToken = Snap::getSnapToken($params);

            // Update order with Midtrans order ID
            $order->update([
                'payment_gateway_order_id' => $order->order_id,
                'payment_details' => array_merge($order->payment_details ?? [], [
                    'snap_token' => $snapToken,
                    'amount_idr' => $amountInIDR,
                    'created_at' => now()
                ])
            ]);

            return $snapToken;

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                'order_id' => $order->order_id,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Handle Midtrans notification/webhook
     */
    public function handleNotification($notification)
    {
        try {
            $notification = new Notification();
            
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;

            Log::info('Midtrans Notification Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            $order = CheckoutOrder::where('order_id', $orderId)->first();

            if (!$order) {
                Log::warning('Order not found for Midtrans notification', ['order_id' => $orderId]);
                return false;
            }

            // Update order status based on Midtrans notification
            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'challenge') {
                        $order->update(['status' => 'pending']);
                    } else if ($fraudStatus == 'accept') {
                        $order->markAsPaid($notification->transaction_id, [
                            'midtrans_transaction_id' => $notification->transaction_id,
                            'payment_type' => $notification->payment_type,
                            'transaction_time' => $notification->transaction_time,
                            'fraud_status' => $fraudStatus
                        ]);
                    }
                    break;

                case 'settlement':
                    $order->markAsPaid($notification->transaction_id, [
                        'midtrans_transaction_id' => $notification->transaction_id,
                        'payment_type' => $notification->payment_type,
                        'transaction_time' => $notification->transaction_time,
                        'settlement_time' => $notification->settlement_time ?? null
                    ]);
                    break;

                case 'pending':
                    $order->update(['status' => 'pending']);
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $order->update(['status' => 'failed']);
                    break;

                default:
                    Log::warning('Unknown Midtrans transaction status', [
                        'order_id' => $orderId,
                        'status' => $transactionStatus
                    ]);
                    break;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage(), [
                'exception' => $e
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
            $status = Transaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            Log::error('Failed to get transaction status: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Convert amount to IDR
     */
    private function convertToIDR($amount, $currency)
    {
        // Exchange rates (you should use real-time rates in production)
        $rates = [
            'USD' => 15000,
            'IDR' => 1,
            'MYR' => 3191,
            'SGD' => 11111,
            'THB' => 423,
            'PHP' => 268,
            'VND' => 0.625,
            'BND' => 11111,
            'LAK' => 0.714,
            'KHR' => 3.66,
            'MMK' => 7.14
        ];

        $rate = $rates[$currency] ?? $rates['USD'];
        return round($amount * $rate);
    }

    /**
     * Format cart items for Midtrans
     */
    private function formatItemDetails(CheckoutOrder $order)
    {
        $items = [];
        
        // Add cart items
        foreach ($order->cart_items as $item) {
            $priceInIDR = $this->convertToIDR($item['price'], $order->currency);
            
            $items[] = [
                'id' => $item['id'] ?? uniqid(),
                'price' => (int) $priceInIDR,
                'quantity' => (int) $item['quantity'],
                'name' => $item['name'],
                'brand' => 'TriadGO',
                'category' => 'Products',
                'merchant_name' => 'TriadGO'
            ];
        }

        // Add shipping
        if ($order->shipping_cost > 0) {
            $shippingInIDR = $this->convertToIDR($order->shipping_cost, $order->currency);
            $items[] = [
                'id' => 'shipping',
                'price' => (int) $shippingInIDR,
                'quantity' => 1,
                'name' => 'Shipping Cost',
                'brand' => 'TriadGO',
                'category' => 'Shipping'
            ];
        }

        // Add tax
        if ($order->tax_amount > 0) {
            $taxInIDR = $this->convertToIDR($order->tax_amount, $order->currency);
            $items[] = [
                'id' => 'tax',
                'price' => (int) $taxInIDR,
                'quantity' => 1,
                'name' => 'Tax',
                'brand' => 'TriadGO',
                'category' => 'Tax'
            ];
        }

        // Add discount if any
        if ($order->discount_amount > 0) {
            $discountInIDR = $this->convertToIDR($order->discount_amount, $order->currency);
            $items[] = [
                'id' => 'discount',
                'price' => (int) -$discountInIDR, // Negative for discount
                'quantity' => 1,
                'name' => 'Discount' . ($order->coupon_code ? ' (' . $order->coupon_code . ')' : ''),
                'brand' => 'TriadGO',
                'category' => 'Discount'
            ];
        }

        return $items;
    }
}
