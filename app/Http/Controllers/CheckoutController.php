<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutOrder;
use App\Services\MidtransHttpService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransHttpService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show checkout page
     */
    public function index()
    {
        return view('formImportir');
    }

    /**
     * Create Midtrans snap token
     */
    public function createSnapToken(Request $request)
    {
        // Force JSON response for API endpoint
        $request->headers->set('Accept', 'application/json');
        
        try {
            // Log data request untuk debugging
            Log::info('Checkout createSnapToken request', [
                'all_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);
            
            // Validate request
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'country' => 'required|string|max:2',
                'cart_items' => 'required|array|min:1',
                'subtotal' => 'required|numeric|min:0',
                'shipping_cost' => 'required|numeric|min:0',
                'tax_amount' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'currency' => 'required|string|max:3'
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Log validated data
            $validatedData = $validator->validated();
            Log::info('Validated data', $validatedData);

            // Calculate total amount
            $subtotal = (float) $request->subtotal;
            $shipping = (float) $request->shipping_cost;
            $tax = (float) $request->tax_amount;
            $discount = (float) ($request->discount_amount ?? 0);
            $totalAmount = $subtotal + $shipping + $tax - $discount;
            
            Log::info('Calculated amounts', [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $totalAmount
            ]);

            // Create order
            $orderData = [
                'order_id' => CheckoutOrder::generateOrderId(),
                'total_amount' => $totalAmount,
                'currency' => $request->currency,
                'status' => 'pending',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'payment_method' => 'midtrans',
                'cart_items' => $request->cart_items,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'tax_amount' => $tax,
                'coupon_code' => $request->coupon_code,
                'discount_amount' => $discount,
                'notes' => $request->notes
            ];
            
            Log::info('Creating order with data', $orderData);
            $order = CheckoutOrder::create($orderData);
            Log::info('Order created successfully', [
                'order_id' => $order->order_id,
                'database_id' => $order->id,
                'amount' => $order->total_amount,
                'currency' => $order->currency,
                'status' => $order->status,
                'customer' => $order->first_name . ' ' . $order->last_name,
                'email' => $order->email
            ]);

            // Create Midtrans snap token
            Log::info('Creating Midtrans snap token for order', [
                'order_id' => $order->order_id,
                'merchant_id' => config('services.midtrans.merchant_id'),
                'environment' => config('services.midtrans.is_production') ? 'production' : 'sandbox'
            ]);
            
            $snapToken = $this->midtransService->createSnapToken($order);
            
            Log::info('Snap token created successfully', [
                'order_id' => $order->order_id,
                'token_preview' => substr($snapToken, 0, 20) . '...',
                'token_length' => strlen($snapToken),
                'dashboard_url' => config('services.midtrans.is_production') 
                    ? 'https://dashboard.midtrans.com' 
                    : 'https://dashboard.sandbox.midtrans.com',
                'should_appear_in_dashboard' => true,
                'search_order_id' => $order->order_id
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->order_id,
                'message' => 'Payment token created successfully',
                'debug' => [
                    'token_length' => strlen($snapToken),
                    'order_id' => $order->order_id,
                    'total_amount' => $order->total_amount,
                    'currency' => $order->currency            ]
        ]);

    } catch (Exception $e) {
        Log::error('Checkout Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment. Please try again.',
                'error' => $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification/webhook
     */
    public function handleNotification(Request $request)
    {
        try {
            Log::info('Midtrans notification received', $request->all());
            
            $result = $this->midtransService->handleNotification($request->all());
            
            if ($result) {            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed'], 400);
        }
    } catch (Exception $e) {
        Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Payment success page
     */
    public function success(Request $request, $orderId = null)
    {
        $orderId = $orderId ?? $request->get('order_id');
        
        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        $order = CheckoutOrder::where('order_id', $orderId)->first();
        
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        // Check payment status from Midtrans if order is still pending
        if ($order->status === 'pending') {
            try {
                $status = $this->midtransService->getTransactionStatus($orderId);
                // Jika $status adalah array, akses dengan ['key']
                if (is_array($status) && isset($status['transaction_status'])) {
                    if (in_array($status['transaction_status'], ['capture', 'settlement'])) {
                        $order->markAsPaid($status['transaction_id'], [
                            'midtrans_transaction_id' => $status['transaction_id'],
                            'payment_type' => $status['payment_type'] ?? null,
                            'transaction_time' => $status['transaction_time'] ?? null,
                            'verified_at' => now()
                        ]);
                    }
                } elseif (is_object($status) && isset($status->transaction_status)) {
                    if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                        $order->markAsPaid($status->transaction_id, [
                            'midtrans_transaction_id' => $status->transaction_id,
                            'payment_type' => $status->payment_type ?? null,
                            'transaction_time' => $status->transaction_time ?? null,
                            'verified_at' => now()
                        ]);
                    }
                }        } catch (Exception $e) {
            Log::warning('Failed to verify payment status: ' . $e->getMessage());
        }
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Payment pending page
     */
    public function pending(Request $request, $orderId = null)
    {
        $orderId = $orderId ?? $request->get('order_id');
        
        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        $order = CheckoutOrder::where('order_id', $orderId)->first();
        
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        return view('checkout.pending', compact('order'));
    }

    /**
     * Payment error page
     */
    public function error(Request $request, $orderId = null)
    {
        $orderId = $orderId ?? $request->get('order_id');
        
        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        $order = CheckoutOrder::where('order_id', $orderId)->first();
        
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        return view('checkout.error', compact('order'));
    }

    /**
     * Get order status
     */
    public function getOrderStatus($orderId)
    {
        try {
            Log::info('Checking order status for: ' . $orderId);
            
            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                Log::warning('Order not found: ' . $orderId);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            Log::info('Order found: ' . $orderId . ' - Status: ' . $order->status);

            return response()->json([
                'status' => 'success',
                'payment_status' => $order->status,
                'order' => [
                    'id' => $order->order_id,
                    'status' => $order->status,
                    'total_amount' => $order->formatted_total,
                    'payment_method' => $order->payment_method,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    'payment_completed_at' => $order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : null
                ]
            ]);
        } catch (Exception $e) {
            Log::error('Error checking order status: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get order status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test payment page (tanpa middleware)
     */
    public function testPaymentPage($orderId)
    {
        try {
            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);        }
        
        return view('test.payment', compact('order'));
        
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Simulate payment (tanpa middleware)
     */
    public function simulatePayment(Request $request, $orderId)
    {
        try {
            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }
            
            if ($order->status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Order is not pending'], 400);
            }
            
            // Simulate successful payment
            $transactionId = 'TEST-SIM-' . time();
            
            $order->update([
                'status' => 'paid',
                'payment_gateway_transaction_id' => $transactionId,
                'payment_details' => [
                    'transaction_id' => $transactionId,
                    'payment_type' => 'test_simulation',
                    'transaction_status' => 'capture',
                    'gross_amount' => $order->total_amount,
                    'currency' => $order->currency,
                    'simulated_at' => now()->toISOString(),
                    'simulation_method' => 'manual_test'
                ],
                'payment_completed_at' => now()
            ]);
            
            Log::info('Payment simulated successfully', [
                'order_id' => $orderId,
                'transaction_id' => $transactionId,
                'amount' => $order->total_amount
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Payment simulated successfully',
                'order_id' => $orderId,
                'transaction_id' => $transactionId,
                'order_status' => 'paid',
                'amount' => $order->total_amount        ]);
        
    } catch (Exception $e) {
        Log::error('Payment simulation failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Payment simulation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Force simulate payment (tanpa middleware)
     */
    public function forceSimulatePayment(Request $request, $orderId)
    {
        try {
            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }
            
            // Force simulate payment regardless of current status
            $action = $request->input('action', 'success');
            $transactionId = 'FORCE-SIM-' . time() . '-' . $orderId;
            
            if ($action === 'success') {
                $order->update([
                    'status' => 'paid',
                    'payment_gateway_transaction_id' => $transactionId,
                    'payment_details' => [
                        'transaction_id' => $transactionId,
                        'payment_type' => 'simulation',
                        'gross_amount' => $order->total_amount,
                        'currency' => $order->currency ?? 'USD',
                        'status_code' => '200',
                        'transaction_status' => 'settlement',
                        'fraud_status' => 'accept',
                        'simulated_at' => now(),
                        'original_status' => $order->getOriginal('status')                ],
                'payment_completed_at' => now(),
            ]);
            
            Log::info("Force payment simulation completed for order: {$orderId}");
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Payment simulation completed successfully',
                    'transaction_id' => $transactionId,
                    'status' => 'paid'
                ]);
            } else {
                $order->update([
                    'status' => 'failed',
                    'payment_gateway_transaction_id' => $transactionId,
                    'payment_details' => [
                        'transaction_id' => $transactionId,
                        'payment_type' => 'simulation',
                        'error_message' => 'Simulated payment failure',
                        'status_code' => '400',
                        'transaction_status' => 'deny',
                        'simulated_at' => now(),
                        'original_status' => $order->getOriginal('status')
                    ],
                ]);
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Payment failure simulation completed',
                    'transaction_id' => $transactionId,
                    'status' => 'failed'
                ]);
            }
            
        } catch (Exception $e) {
            Log::error("Force payment simulation error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Simulation failed: ' . $e->getMessage()], 500);
        }
    }
}
