<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions for the authenticated importer
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get orders for the current user
        $query = CheckoutOrder::where('user_id', $user->user_id)
                              ->orderBy('created_at', 'desc');
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
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
        $statusCounts = $this->getStatusCounts($user->user_id);
        
        return view('transactions.index', compact('orders', 'statusCounts'));
    }
      /**
     * Display the specified transaction
     */
    public function show($orderId)
    {
        $user = Auth::user();
        
        // Always get fresh data from database to ensure latest status
        $order = CheckoutOrder::where('order_id', $orderId)
                              ->where('user_id', $user->user_id)
                              ->firstOrFail();
        
        // Refresh the model to get the absolute latest data
        $order->refresh();
        
        return view('transactions.show', compact('order'));
    }
      /**
     * Display tracking page for paid orders
     */
    public function tracking($orderId)
    {
        $user = Auth::user();
        
        $order = CheckoutOrder::where('order_id', $orderId)
                              ->where('user_id', $user->user_id)
                              ->firstOrFail();
        
        // Refresh to get latest status
        $order->refresh();
        
        // Check if order is paid
        if ($order->status !== 'paid') {
            return redirect()->route('transactions.show', $orderId)
                           ->with('error', 'Tracking hanya tersedia untuk pesanan yang sudah dibayar.');
        }
        
        // Determine current step based on shipping status
        $currentStep = 0;
        switch ($order->shipping_status) {
            case 'warehouse':
                $currentStep = 0;
                break;
            case 'packing':
                $currentStep = 1;
                break;
            case 'customs':
                $currentStep = 2;
                break;
            case 'shipping':
                $currentStep = 3;
                break;
            case 'delivered':
                $currentStep = 4;
                break;
            default:
                $currentStep = 0;
        }
        
        return view('transactions.tracking', compact('order', 'currentStep'));
    }
    
    /**
     * Get status counts for the authenticated user
     */
    private function getStatusCounts($userId)
    {
        $counts = CheckoutOrder::where('user_id', $userId)
                               ->selectRaw('status, COUNT(*) as count')
                               ->groupBy('status')
                               ->pluck('count', 'status')
                               ->toArray();
        
        return [
            'all' => array_sum($counts),
            'pending' => $counts['pending'] ?? 0,
            'paid' => $counts['paid'] ?? 0,
            'failed' => $counts['failed'] ?? 0,
            'cancelled' => $counts['cancelled'] ?? 0,
            'expired' => $counts['expired'] ?? 0,
        ];
    }
    
    /**
     * Download invoice for a specific order
     */
    public function downloadInvoice($orderId)
    {
        $user = Auth::user();
        
        $order = CheckoutOrder::where('order_id', $orderId)
                              ->where('user_id', $user->user_id)
                              ->firstOrFail();
        
        // Check if order is paid
        if ($order->status !== 'paid') {
            return redirect()->back()->with('error', 'Invoice hanya tersedia untuk pesanan yang sudah dibayar.');
        }
        
        // Redirect to existing invoice controller
        return redirect()->route('invoice.show', $orderId);
    }
}
