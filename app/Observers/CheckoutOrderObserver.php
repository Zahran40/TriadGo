<?php

namespace App\Observers;

use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Log;

class CheckoutOrderObserver
{
    /**
     * Handle the CheckoutOrder "creating" event.
     */
    public function creating(CheckoutOrder $checkoutOrder): void
    {
        // Generate invoice code and tracking number if not provided
        if (empty($checkoutOrder->invoice_code)) {
            $checkoutOrder->invoice_code = 'INV' . now()->format('YmdHis') . substr(uniqid(), -4);
        }
        
        if (empty($checkoutOrder->tracking_number)) {
            $checkoutOrder->tracking_number = 'TG' . now()->format('YmdHis') . substr(uniqid(), -4);
        }
        
        // Set default shipping status
        if (empty($checkoutOrder->shipping_status)) {
            $checkoutOrder->shipping_status = 'pending';
        }
        
        // Set payment status same as status initially
        if (empty($checkoutOrder->payment_status)) {
            $checkoutOrder->payment_status = $checkoutOrder->status;
        }
    }

    /**
     * Handle the CheckoutOrder "created" event.
     */
    public function created(CheckoutOrder $checkoutOrder): void
    {
        Log::info('New order created', [
            'order_id' => $checkoutOrder->order_id,
            'status' => $checkoutOrder->status,
            'total_amount' => $checkoutOrder->total_amount
        ]);
    }

    /**
     * Handle the CheckoutOrder "updating" event.
     */
    public function updating(CheckoutOrder $checkoutOrder): void
    {
        // Check if status is being changed
        if ($checkoutOrder->isDirty('status')) {
            $oldStatus = $checkoutOrder->getOriginal('status');
            $newStatus = $checkoutOrder->status;
            
            Log::info('Order status changing', [
                'order_id' => $checkoutOrder->order_id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
            
            // Auto-update related fields based on status change
            $this->handleStatusChange($checkoutOrder, $oldStatus, $newStatus);
        }
    }

    /**
     * Handle the CheckoutOrder "updated" event.
     */
    public function updated(CheckoutOrder $checkoutOrder): void
    {
        // Log status changes
        if ($checkoutOrder->wasChanged('status')) {
            Log::info('Order status changed', [
                'order_id' => $checkoutOrder->order_id,
                'status' => $checkoutOrder->status,
                'payment_completed_at' => $checkoutOrder->payment_completed_at
            ]);
        }
    }

    /**
     * Handle the CheckoutOrder "deleted" event.
     */
    public function deleted(CheckoutOrder $checkoutOrder): void
    {
        Log::info('Order deleted', [
            'order_id' => $checkoutOrder->order_id,
            'status' => $checkoutOrder->status
        ]);
    }

    /**
     * Handle the CheckoutOrder "restored" event.
     */
    public function restored(CheckoutOrder $checkoutOrder): void
    {
        Log::info('Order restored', [
            'order_id' => $checkoutOrder->order_id,
            'status' => $checkoutOrder->status
        ]);
    }

    /**
     * Handle the CheckoutOrder "force deleted" event.
     */
    public function forceDeleted(CheckoutOrder $checkoutOrder): void
    {
        Log::info('Order force deleted', [
            'order_id' => $checkoutOrder->order_id
        ]);
    }

    /**
     * Handle status changes and update related fields
     */
    protected function handleStatusChange(CheckoutOrder $checkoutOrder, $oldStatus, $newStatus): void
    {
        // Update payment_status to match status
        $checkoutOrder->payment_status = $newStatus;
        
        switch ($newStatus) {
            case 'paid':
                // Set payment completed time if not already set
                if (!$checkoutOrder->payment_completed_at) {
                    $checkoutOrder->payment_completed_at = now();
                }
                
                // Update shipping status to processing if still pending
                if ($checkoutOrder->shipping_status === 'pending') {
                    $checkoutOrder->shipping_status = 'processing';
                }
                
                // Generate codes if missing
                if (empty($checkoutOrder->invoice_code)) {
                    $checkoutOrder->invoice_code = 'INV' . now()->format('YmdHis') . substr(uniqid(), -4);
                }
                if (empty($checkoutOrder->tracking_number)) {
                    $checkoutOrder->tracking_number = 'TG' . now()->format('YmdHis') . substr(uniqid(), -4);
                }
                
                Log::info('Order marked as paid via observer', [
                    'order_id' => $checkoutOrder->order_id,
                    'payment_completed_at' => $checkoutOrder->payment_completed_at,
                    'shipping_status' => $checkoutOrder->shipping_status
                ]);
                break;
                
            case 'failed':
            case 'cancelled':
            case 'expired':
                // Clear payment completed time
                $checkoutOrder->payment_completed_at = null;
                
                // Reset shipping status to pending
                if (in_array($checkoutOrder->shipping_status, ['processing', 'shipped', 'in_transit'])) {
                    $checkoutOrder->shipping_status = 'pending';
                }
                
                Log::info('Order status changed to failed/cancelled/expired', [
                    'order_id' => $checkoutOrder->order_id,
                    'new_status' => $newStatus,
                    'shipping_status_reset' => $checkoutOrder->shipping_status
                ]);
                break;
                
            case 'refunded':
                // Keep payment_completed_at but update status
                Log::info('Order refunded', [
                    'order_id' => $checkoutOrder->order_id,
                    'original_payment_date' => $checkoutOrder->payment_completed_at
                ]);
                break;
        }
    }
}
