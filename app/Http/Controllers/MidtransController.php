<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Generate Midtrans Snap Token
     */
    public function getSnapToken(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'transaction_details.order_id' => 'required|string',
                'transaction_details.gross_amount' => 'required|numeric',
                'customer_details.first_name' => 'required|string',
                'customer_details.last_name' => 'required|string',
                'customer_details.email' => 'required|email',
                'customer_details.phone' => 'required|string',
            ]);

            // Prepare transaction details
            $transactionDetails = [
                'order_id' => $validated['transaction_details']['order_id'],
                'gross_amount' => (int) $validated['transaction_details']['gross_amount']
            ];

            // Prepare customer details
            $customerDetails = [
                'first_name' => $validated['customer_details']['first_name'],
                'last_name' => $validated['customer_details']['last_name'],
                'email' => $validated['customer_details']['email'],
                'phone' => $validated['customer_details']['phone'],
            ];

            // Add billing address if provided
            if (isset($request->customer_details['billing_address'])) {
                $customerDetails['billing_address'] = [
                    'first_name' => $validated['customer_details']['first_name'],
                    'last_name' => $validated['customer_details']['last_name'],
                    'address' => $request->customer_details['billing_address']['address'] ?? '',
                    'city' => $request->customer_details['billing_address']['city'] ?? '',
                    'postal_code' => $request->customer_details['billing_address']['postal_code'] ?? '',
                    'country_code' => $request->customer_details['billing_address']['country_code'] ?? 'ID',
                ];
            }

            // Prepare transaction data
            $transactionData = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'enabled_payments' => [
                    'credit_card',
                    'mandiri_clickpay',
                    'cimb_clicks',
                    'bca_klikbca',
                    'bca_klikpay',
                    'bri_epay',
                    'echannel',
                    'permata_va',
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'other_va',
                    'gopay',
                    'indomaret',
                    'alfamart',
                    'danamon_online',
                    'akulaku',
                    'shopeepay',
                    'kredivo',
                    'uob_ezpay'
                ],
                'vtweb' => []
            ];

            // Get Snap token from Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($transactionData);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $transactionDetails['order_id']
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate payment token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification callback
     */
    public function handleNotification(Request $request): JsonResponse
    {
        try {
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            // Handle transaction status
            switch ($transactionStatus) {
                case 'capture':
                    if ($type == 'credit_card') {
                        if ($fraud == 'challenge') {
                            // TODO: Set payment status to 'Challenge' and wait for manual review
                            \Log::info("Transaction order_id: " . $orderId . " is challenged by FDS");
                        } else {
                            // TODO: Set payment status to 'Success'
                            \Log::info("Transaction order_id: " . $orderId . " is successfully captured");
                        }
                    }
                    break;

                case 'settlement':
                    // TODO: Set payment status to 'Success'
                    \Log::info("Transaction order_id: " . $orderId . " is successfully settled");
                    break;

                case 'pending':
                    // TODO: Set payment status to 'Pending'
                    \Log::info("Waiting customer to finish transaction order_id: " . $orderId);
                    break;

                case 'deny':
                    // TODO: Set payment status to 'Failed'
                    \Log::info("Payment using " . $type . " for transaction order_id: " . $orderId . " is denied");
                    break;

                case 'expire':
                    // TODO: Set payment status to 'Failed'
                    \Log::info("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired");
                    break;

                case 'cancel':
                    // TODO: Set payment status to 'Failed'
                    \Log::info("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled");
                    break;
            }

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
