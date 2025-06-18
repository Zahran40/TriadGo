<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;
use Exception;

class InvoiceController extends Controller
{
    /**
     * Show invoice for a specific order
     */
    public function show($order_id)
    {
        try {
            // Find order by order_id
            $order = CheckoutOrder::where('order_id', $order_id)->first();
            
            if (!$order) {
                return redirect()->back()->with('error', 'Invoice not found');
            }
            
            return view('invoice', compact('order'));
            
        } catch (Exception $e) {
            Log::error('Error showing invoice: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading invoice');
        }
    }
}
