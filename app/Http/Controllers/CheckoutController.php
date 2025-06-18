<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutOrder;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
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
        try {
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
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Calculate total amount
            $subtotal = (float) $request->subtotal;
            $shipping = (float) $request->shipping_cost;
            $tax = (float) $request->tax_amount;
            $discount = (float) ($request->discount_amount ?? 0);
            $totalAmount = $subtotal + $shipping + $tax - $discount;

            // Create order
            $order = CheckoutOrder::create([
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
            ]);

            // Create Midtrans snap token
            $snapToken = $this->midtransService->createSnapToken($order);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->order_id
            ]);

        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment. Please try again.',
                'error' => $e->getMessage()
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
            
            if ($result) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'failed'], 400);
            }
        } catch (\Exception $e) {
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
                
                if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                    $order->markAsPaid($status->transaction_id, [
                        'midtrans_transaction_id' => $status->transaction_id,
                        'payment_type' => $status->payment_type,
                        'transaction_time' => $status->transaction_time,
                        'verified_at' => now()
                    ]);
                }
            } catch (\Exception $e) {
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
            $order = CheckoutOrder::where('order_id', $orderId)->first();
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->order_id,
                    'status' => $order->status,
                    'total_amount' => $order->formatted_total,
                    'payment_method' => $order->payment_method,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    'payment_completed_at' => $order->payment_completed_at ? $order->payment_completed_at->format('Y-m-d H:i:s') : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get order status'
            ], 500);
        }
    }
}
