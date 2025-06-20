<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutOrder;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EksportirTransactionController extends Controller
{
    /**
     * Display transactions for eksportir's products
     */
    public function index(Request $request)
    {
        $eksportir = Auth::user();
        
        // Get all product IDs owned by this eksportir
        $productIds = Product::where('user_id', $eksportir->user_id)
                            ->pluck('product_id')
                            ->toArray();
          // Get orders that contain products from this eksportir (all statuses)
        $query = CheckoutOrder::orderBy('created_at', 'desc');
        
        // Filter orders to only show those that contain eksportir's products
        $allOrders = $query->get();
        $filteredOrderIds = [];
        
        foreach ($allOrders as $order) {
            if ($order->cart_items && is_array($order->cart_items)) {
                foreach ($order->cart_items as $item) {
                    if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                        $filteredOrderIds[] = $order->id;
                        break;
                    }
                }
            }
        }
        
        // Now get paginated results from filtered order IDs
        $query = CheckoutOrder::whereIn('id', $filteredOrderIds)
                              ->orderBy('created_at', 'desc');
        
        // Filter by shipping status if provided
        if ($request->has('shipping_status') && $request->shipping_status !== 'all') {
            $query->where('shipping_status', $request->shipping_status);
        }

        // Filter by payment status if provided
        if ($request->has('payment_status') && $request->payment_status !== 'all') {
            $query->where('status', $request->payment_status);
        }
        
        // Search by order ID or customer name
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }
        
        $orders = $query->paginate(10);
        
        // Calculate shipping status counts and payment status counts
        $shippingStatusCounts = $this->getShippingStatusCounts($productIds);
        $paymentStatusCounts = $this->getPaymentStatusCounts($productIds);
        
        return view('eksportir.transactions.index', compact('orders', 'shippingStatusCounts', 'paymentStatusCounts'));
    }
    
    /**
     * Show specific transaction for eksportir
     */
    public function show($orderId)
    {
        $eksportir = Auth::user();
        
        // Get eksportir's product IDs
        $productIds = Product::where('user_id', $eksportir->user_id)
                            ->pluck('product_id')
                            ->toArray();
        
        $order = CheckoutOrder::where('order_id', $orderId)->firstOrFail();
        
        // Verify this order contains eksportir's products
        $hasEksportirProducts = false;
        $eksportirItems = [];
        
        if ($order->cart_items && is_array($order->cart_items)) {
            foreach ($order->cart_items as $item) {
                if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                    $hasEksportirProducts = true;
                    $eksportirItems[] = $item;
                }
            }
        }
        
        if (!$hasEksportirProducts) {
            abort(403, 'You do not have products in this order.');
        }
        
        return view('eksportir.transactions.show', compact('order', 'eksportirItems'));
    }
    
    /**
     * Update shipping status
     */
    public function updateShippingStatus(Request $request, $orderId)
    {
        $request->validate([
            'shipping_status' => 'required|string|in:processing,shipped,in_transit,delivered',
            'reason' => 'nullable|string|max:255'
        ]);
        
        $eksportir = Auth::user();
        
        // Verify eksportir has products in this order
        $productIds = Product::where('user_id', $eksportir->user_id)
                            ->pluck('product_id')
                            ->toArray();
        
        $order = CheckoutOrder::where('order_id', $orderId)->firstOrFail();
        
        // Verify order contains eksportir's products
        $hasEksportirProducts = false;
        if ($order->cart_items && is_array($order->cart_items)) {
            foreach ($order->cart_items as $item) {
                if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                    $hasEksportirProducts = true;
                    break;
                }
            }
        }
        
        if (!$hasEksportirProducts) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have products in this order.'
            ], 403);
        }
        
        try {
            $reason = $request->reason ?: "Status updated by eksportir {$eksportir->name}";
            $order->updateShippingStatus($request->shipping_status, $reason);
            
            Log::info('Shipping status updated by eksportir', [
                'order_id' => $orderId,
                'eksportir_id' => $eksportir->user_id,
                'eksportir_name' => $eksportir->name,
                'old_status' => $order->getOriginal('shipping_status'),
                'new_status' => $request->shipping_status,
                'reason' => $reason
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status pengiriman berhasil diperbarui.',
                'new_status' => $request->shipping_status
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error updating shipping status', [
                'order_id' => $orderId,
                'eksportir_id' => $eksportir->user_id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status.'
            ], 500);
        }
    }
    
    /**
     * Update payment status from pending to paid
     */
    public function updatePaymentStatus(Request $request, $orderId)
    {
        $request->validate([
            'payment_status' => 'required|string|in:paid,failed,cancelled',
            'reason' => 'nullable|string|max:255'
        ]);

        $eksportir = Auth::user();
        
        // Verify eksportir has products in this order
        $productIds = Product::where('user_id', $eksportir->user_id)
                            ->pluck('product_id')
                            ->toArray();
        
        $order = CheckoutOrder::where('order_id', $orderId)->firstOrFail();
        
        // Verify order contains eksportir's products
        $hasEksportirProducts = false;
        if ($order->cart_items && is_array($order->cart_items)) {
            foreach ($order->cart_items as $item) {
                if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                    $hasEksportirProducts = true;
                    break;
                }
            }
        }
        
        if (!$hasEksportirProducts) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have products in this order.'
            ], 403);
        }
        
        try {
            $reason = $request->reason ?: "Payment status updated by eksportir {$eksportir->name}";
            
            if ($request->payment_status === 'paid') {
                $order->markAsPaid(null, [
                    'updated_by_eksportir' => $eksportir->user_id,
                    'eksportir_name' => $eksportir->name,
                    'reason' => $reason,
                    'updated_at' => now()
                ]);
            } else {
                $order->updateStatus($request->payment_status, $reason);
            }
            
            Log::info('Payment status updated by eksportir', [
                'order_id' => $orderId,
                'eksportir_id' => $eksportir->user_id,
                'eksportir_name' => $eksportir->name,
                'old_status' => $order->getOriginal('status'),
                'new_status' => $request->payment_status,
                'reason' => $reason
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran berhasil diperbarui.',
                'new_status' => $request->payment_status
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error updating payment status', [
                'order_id' => $orderId,
                'eksportir_id' => $eksportir->user_id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status pembayaran.'
            ], 500);
        }
    }

    /**
     * Get shipping status counts for dashboard
     */
    private function getShippingStatusCounts($productIds)
    {
        $statuses = ['processing', 'shipped', 'in_transit', 'delivered'];
        $counts = ['all' => 0];
          foreach ($statuses as $status) {
            $allOrders = CheckoutOrder::where('shipping_status', $status)->get();
            
            $count = 0;
            foreach ($allOrders as $order) {
                if ($order->cart_items && is_array($order->cart_items)) {
                    foreach ($order->cart_items as $item) {
                        if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                            $count++;
                            break;
                        }
                    }
                }
            }
            
            $counts[$status] = $count;
            $counts['all'] += $count;
        }
        
        return $counts;
    }

    /**
     * Get payment status counts for dashboard
     */
    private function getPaymentStatusCounts($productIds)
    {
        $statuses = ['pending', 'paid', 'failed', 'cancelled'];
        $counts = ['all' => 0];
        
        foreach ($statuses as $status) {
            $allOrders = CheckoutOrder::where('status', $status)->get();
            
            $count = 0;
            foreach ($allOrders as $order) {
                if ($order->cart_items && is_array($order->cart_items)) {
                    foreach ($order->cart_items as $item) {
                        if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                            $count++;
                            break;
                        }
                    }
                }
            }
            
            $counts[$status] = $count;
            $counts['all'] += $count;
        }
        
        return $counts;
    }
}
