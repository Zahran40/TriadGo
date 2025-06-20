<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutOrder;
use App\Models\Cart;
use App\Models\User;
use App\Services\MidtransHttpService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Exception;

/**
 * @method User getCurrentUser()
 */

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
        // Require authentication for checkout
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to proceed with checkout');
        }
        
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
            // Get user
            $user = $this->getCurrentUser();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            // Log data request untuk debugging
            Log::info('Checkout createSnapToken request', [
                'user_id' => $user->user_id,
                'request_data' => $request->all()
            ]);
            
            // Get cart items from database
            $cartItems = $user->getCartWithProducts();
            
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }
            
            // Validate request
            $validator = Validator::make($request->all(), [
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'country' => 'required|string|max:2',
                'currency' => 'string|max:3'
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Calculate amounts from cart items
            $subtotal = $cartItems->sum('total');
            $shipping = 25.00; // Fixed shipping cost
            $taxRate = 0.10;
            $tax = $subtotal * $taxRate;
            $discount = 0; // Can be implemented later
            $totalAmount = $subtotal + $shipping + $tax - $discount;
            
            Log::info('Calculated amounts from cart', [
                'cart_items_count' => $cartItems->count(),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $totalAmount
            ]);

            // Get authenticated user data (already retrieved above)
            // $user is already available from getCurrentUser()
            
            // Prepare cart items data for storage
            $cartItemsData = $cartItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name' => $item->product->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                    'sku' => $item->product->product_sku,
                    'image' => $item->product->product_image,
                    'origin' => $item->product->country_of_origin,
                    'weight' => $item->product->weight
                ];
            })->toArray();
            
            // Create order
            $orderData = [
                'user_id' => $user->user_id,
                'order_id' => CheckoutOrder::generateOrderId(),
                'total_amount' => $totalAmount,
                'currency' => $request->currency ?? 'USD',
                'status' => 'pending',
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'payment_method' => 'midtrans',
                'cart_items' => json_encode($cartItemsData),
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
                'customer' => $order->name,
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
            
            if ($result) {
                // Return proper response for Midtrans dashboard sync
                return response()->json([
                    'status_code' => '200',
                    'status_message' => 'Success, notification processed'
                ], 200);
            } else {
                // Return 200 but with failed status to prevent retry
                return response()->json([
                    'status_code' => '400', 
                    'status_message' => 'Failed to process notification'
                ], 200);
            }
        } catch (Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            
            // Still return 200 to prevent Midtrans retry loop
            return response()->json([
                'status_code' => '500',
                'status_message' => 'Internal server error: ' . $e->getMessage()
            ], 200);
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
                        
                        // Clear cart after successful payment
                        if ($order->user_id) {
                            Cart::where('user_id', $order->user_id)->delete();
                        }
                    }
                } elseif (is_object($status) && isset($status->transaction_status)) {
                    if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                        $order->markAsPaid($status->transaction_id, [
                            'midtrans_transaction_id' => $status->transaction_id,
                            'payment_type' => $status->payment_type ?? null,
                            'transaction_time' => $status->transaction_time ?? null,
                            'verified_at' => now()
                        ]);
                        
                        // Clear cart after successful payment
                        if ($order->user_id) {
                            Cart::where('user_id', $order->user_id)->delete();
                        }
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
     * Process complete checkout (new unified method)
     */
    public function process(Request $request)
    {
        try {
            // Get user
            $user = $this->getCurrentUser();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Log checkout request
            Log::info('Checkout process request', [
                'user_id' => $user->user_id,
                'request_data' => $request->all()
            ]);

            // Get cart items
            $cartItems = $user->getCartWithProducts();
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }

            // Validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'country' => 'required|string|max:255',
                'payment_method' => 'required|string',
                'subtotal' => 'required|numeric',
                'shipping_cost' => 'required|numeric',
                'tax_amount' => 'required|numeric',
                'total_amount' => 'required|numeric',
                'currency' => 'required|string|max:3'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generate order ID
            $orderId = CheckoutOrder::generateOrderId();

            // Prepare cart items data
            $cartItemsData = $cartItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->product_name,
                    'product_sku' => $item->product->product_sku,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                    'weight' => $item->product->weight,
                    'country_of_origin' => $item->product->country_of_origin
                ];
            });

            // Create checkout order
            $order = CheckoutOrder::create([
                'user_id' => $user->user_id,
                'order_id' => $orderId,
                'total_amount' => $request->total_amount,
                'currency' => $request->currency,
                'status' => 'pending',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'payment_method' => $request->payment_method,
                'cart_items' => $cartItemsData->toArray(),
                'subtotal' => $request->subtotal,
                'shipping_cost' => $request->shipping_cost,
                'tax_amount' => $request->tax_amount,
                'notes' => $request->notes
            ]);

            Log::info('Creating Midtrans snap token', [
                'order_id' => $orderId,
                'total_amount' => $request->total_amount
            ]);

            $snapToken = $this->midtransService->createSnapToken($order);

            if (!$snapToken) {
                throw new Exception('Failed to create payment token');
            }

            // Update order with Midtrans details
            $order->update([
                'payment_gateway_order_id' => $orderId,
                'payment_details' => [
                    'snap_token' => $snapToken,
                    'created_at' => now()
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order_id' => $orderId,
                'snap_token' => $snapToken,
                'total_amount' => $request->total_amount
            ]);

        } catch (Exception $e) {
            Log::error('Checkout process error: ' . $e->getMessage(), [
                'user_id' => $user->user_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to get current authenticated user
     */
    private function getCurrentUser()
    {
        if (!Auth::check()) {
            return null;
        }
        
        return Auth::user();
    }
}