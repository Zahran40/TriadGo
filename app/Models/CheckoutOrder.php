<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * @property string $order_id
 * @property float $total_amount
 * @property string $currency
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string $country
 * @property string $payment_method
 * @property string|null $payment_gateway_order_id
 * @property string|null $payment_gateway_transaction_id
 * @property array|null $payment_details
 * @property array $cart_items
 * @property float $subtotal
 * @property float $shipping_cost
 * @property float $tax_amount
 * @property string|null $coupon_code
 * @property float $discount_amount
 * @property string|null $notes
 * @property \Carbon\Carbon|null $payment_completed_at
 * @property-read string $formatted_total
 * @property-read string $full_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class CheckoutOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'invoice_code',
        'tracking_number',
        'total_amount',
        'currency',
        'status',
        'shipping_status',
        'payment_status',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'payment_method',
        'payment_gateway_order_id',
        'payment_gateway_transaction_id',
        'payment_details',
        'cart_items',
        'subtotal',
        'shipping_cost',
        'tax_amount',
        'coupon_code',
        'discount_amount',
        'notes',
        'payment_completed_at'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'payment_details' => 'array',
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payment_completed_at' => 'datetime'
    ];

    protected $dates = [
        'payment_completed_at'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

    // Generate unique order ID
    public static function generateOrderId()
    {
        do {
            $orderId = 'TG-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
        } while (static::where('order_id', $orderId)->exists());

        return $orderId;
    }

    // Check if order is paid
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    // Mark order as paid
    public function markAsPaid($transactionId = null, $paymentDetails = [])
    {
        // Check if already paid to prevent double processing
        if ($this->status === 'paid') {
            Log::info('Order already marked as paid, skipping duplicate processing', [
                'order_id' => $this->order_id
            ]);
            return;
        }

        $this->update([
            'status' => 'paid',
            'payment_status' => 'paid', // 🔧 PERBAIKAN: Sinkronkan payment_status
            'payment_gateway_transaction_id' => $transactionId,
            'payment_details' => array_merge($this->payment_details ?? [], $paymentDetails),
            'payment_completed_at' => now()
        ]);
        
        // Send email notification
        $this->sendPaymentSuccessEmail();
        
        // Reduce product stock after successful payment
        $this->reduceProductStock();

        // Clear user cart after successful payment
        $this->clearUserCart();
        
        Log::info('Order marked as paid with email notification', [
            'order_id' => $this->order_id,
            'customer_email' => $this->email,
            'amount' => $this->getFormattedTotalAttribute()
        ]);
    }
    
    /**
     * Send payment success email notification
     */
    private function sendPaymentSuccessEmail()
    {
        try {
            // Skip if email is dummy/test
            if (str_contains($this->email, 'example.com') || str_contains($this->email, 'test.com')) {
                Log::info('Skipping email for test/dummy address', ['email' => $this->email]);
                return;
            }
            
            $subject = "Payment Confirmation - TriadGO Order #{$this->order_id}";
            $message = "
Dear {$this->name},

Your payment has been successfully processed!

Order Details:
- Order ID: {$this->order_id}
- Amount: {$this->getFormattedTotalAttribute()}
- Payment Method: Midtrans
- Paid At: {$this->payment_completed_at->format('d M Y H:i:s')}

Thank you for your business!

Best regards,
TriadGO Team
            ";
            
            // Send email using Laravel Mail
            Mail::raw($message, function ($mail) use ($subject) {
                $mail->to($this->email, $this->name)
                     ->subject($subject);
            });
            
            Log::info('Payment success email sent', [
                'order_id' => $this->order_id,
                'email' => $this->email
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send payment success email', [
                'order_id' => $this->order_id,
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Clear user cart after successful payment
     */
    public function clearUserCart()
    {
        try {
            if ($this->user_id) {
                \App\Models\Cart::where('user_id', $this->user_id)->delete();
                Log::info('User cart cleared after successful payment', [
                    'order_id' => $this->order_id,
                    'user_id' => $this->user_id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error clearing user cart', [
                'order_id' => $this->order_id,
                'user_id' => $this->user_id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Reduce product stock based on cart items in the order
     */
    public function reduceProductStock()
    {
        try {
            // Check if stock has already been reduced (prevent double reduction)
            if (isset($this->payment_details['stock_reduced']) && $this->payment_details['stock_reduced'] === true) {
                Log::info('Stock already reduced for this order, skipping', ['order_id' => $this->order_id]);
                return;
            }

            // Get cart items from the order
            $cartItems = $this->cart_items;
            
            if (!$cartItems || !is_array($cartItems)) {
                Log::warning('No cart items found in order', ['order_id' => $this->order_id]);
                return;
            }

            $stockReductions = [];
            $success = true;

            foreach ($cartItems as $item) {
                $productId = $item['product_id'] ?? null;
                $quantity = $item['quantity'] ?? 0;

                if (!$productId || !$quantity) {
                    Log::warning('Invalid cart item data', [
                        'order_id' => $this->order_id,
                        'item' => $item
                    ]);
                    continue;
                }

                // Find the product and reduce stock
                $product = \App\Models\Product::where('product_id', $productId)->first();
                
                if (!$product) {
                    Log::warning('Product not found for stock reduction', [
                        'order_id' => $this->order_id,
                        'product_id' => $productId
                    ]);
                    $success = false;
                    continue;
                }

                // Check if stock is sufficient (safety check)
                if ($product->stock_quantity < $quantity) {
                    Log::warning('Insufficient stock for reduction', [
                        'order_id' => $this->order_id,
                        'product_id' => $productId,
                        'requested_quantity' => $quantity,
                        'available_stock' => $product->stock_quantity
                    ]);
                    $success = false;
                    continue;
                }

                // Reduce stock
                $oldStock = $product->stock_quantity;
                $product->stock_quantity -= $quantity;
                $product->save();

                $stockReductions[] = [
                    'product_id' => $productId,
                    'product_name' => $product->product_name,
                    'quantity_reduced' => $quantity,
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock_quantity,
                    'reduced_at' => now()
                ];

                Log::info('Product stock reduced successfully', [
                    'order_id' => $this->order_id,
                    'product_id' => $productId,
                    'product_name' => $product->product_name,
                    'quantity_sold' => $quantity,
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock_quantity
                ]);
            }

            // Mark stock as reduced in payment details
            $updatedPaymentDetails = array_merge($this->payment_details ?? [], [
                'stock_reduced' => true,
                'stock_reduced_at' => now(),
                'stock_reductions' => $stockReductions
            ]);

            $this->update(['payment_details' => $updatedPaymentDetails]);

            Log::info('Stock reduction completed for order', [
                'order_id' => $this->order_id,
                'total_items' => count($cartItems),
                'successful_reductions' => count($stockReductions),
                'fully_successful' => $success
            ]);

            // Send stock update notifications to eksportir
            $this->sendStockUpdateNotifications();

        } catch (\Exception $e) {
            Log::error('Error reducing product stock', [
                'order_id' => $this->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Send stock update notifications to eksportir
     */
    private function sendStockUpdateNotifications()
    {
        try {
            // Get cart items from the order
            $cartItems = $this->cart_items;
            
            if (!$cartItems || !is_array($cartItems)) {
                return;
            }

            // Group products by eksportir
            $produktByEksportir = [];
            
            foreach ($cartItems as $item) {
                $productId = $item['product_id'] ?? null;
                
                if (!$productId) continue;
                
                $product = \App\Models\Product::where('product_id', $productId)->first();
                
                if (!$product) continue;
                
                $eksportirUserId = $product->user_id;
                
                if (!isset($produktByEksportir[$eksportirUserId])) {
                    $produktByEksportir[$eksportirUserId] = [];
                }
                
                $produktByEksportir[$eksportirUserId][] = [
                    'product_name' => $product->product_name,
                    'quantity_sold' => $item['quantity'],
                    'new_stock' => $product->stock_quantity
                ];
            }

            // Send notification to each eksportir
            foreach ($produktByEksportir as $eksportirUserId => $products) {
                $productNames = array_map(function($p) {
                    return $p['product_name'] . ' (terjual: ' . $p['quantity_sold'] . ', sisa: ' . $p['new_stock'] . ')';
                }, $products);
                
                $message = 'Produk Anda telah dibeli oleh importir ' . $this->name . '. ' . 
                          'Produk: ' . implode(', ', $productNames);

                \App\Models\Notification::createNotification(
                    $eksportirUserId,
                    'Produk Terjual',
                    $message,
                    \App\Models\Notification::TYPE_STOCK_UPDATE,
                    $this->order_id,
                    'checkout_order'
                );
            }

            Log::info('Stock update notifications sent', [
                'order_id' => $this->order_id,
                'eksportir_count' => count($produktByEksportir)
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending stock update notifications', [
                'order_id' => $this->order_id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Restore product stock if order is cancelled or refunded
     */
    public function restoreProductStock()
    {
        try {
            // Only restore stock if order was previously paid
            if ($this->status !== 'paid') {
                Log::info('Order was not paid, no stock to restore', ['order_id' => $this->order_id]);
                return;
            }

            // Get cart items from the order
            $cartItems = $this->cart_items;
            
            if (!$cartItems || !is_array($cartItems)) {
                Log::warning('No cart items found for stock restoration', ['order_id' => $this->order_id]);
                return;
            }

            foreach ($cartItems as $item) {
                $productId = $item['product_id'] ?? null;
                $quantity = $item['quantity'] ?? 0;

                if (!$productId || !$quantity) {
                    Log::warning('Invalid cart item data for stock restoration', [
                        'order_id' => $this->order_id,
                        'item' => $item
                    ]);
                    continue;
                }

                // Find the product and restore stock
                $product = \App\Models\Product::where('product_id', $productId)->first();
                
                if (!$product) {
                    Log::warning('Product not found for stock restoration', [
                        'order_id' => $this->order_id,
                        'product_id' => $productId
                    ]);
                    continue;
                }

                // Restore stock
                $oldStock = $product->stock_quantity;
                $product->stock_quantity += $quantity;
                $product->save();

                Log::info('Product stock restored successfully', [
                    'order_id' => $this->order_id,
                    'product_id' => $productId,
                    'product_name' => $product->product_name,
                    'quantity_restored' => $quantity,
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock_quantity
                ]);
            }

            Log::info('Stock restoration completed for order', [
                'order_id' => $this->order_id,
                'total_items' => count($cartItems)
            ]);

        } catch (\Exception $e) {
            Log::error('Error restoring product stock', [
                'order_id' => $this->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Mark order as cancelled and restore stock
     */
    public function markAsCancelled($reason = null)
    {
        // Restore stock before marking as cancelled
        $this->restoreProductStock();

        $this->update([
            'status' => 'cancelled',
            'payment_status' => 'cancelled', // 🔧 PERBAIKAN: Sinkronkan payment_status
            'payment_details' => array_merge($this->payment_details ?? [], [
                'cancelled_at' => now(),
                'cancellation_reason' => $reason
            ])
        ]);

        Log::info('Order marked as cancelled', [
            'order_id' => $this->order_id,
            'reason' => $reason
        ]);
    }

    /**
     * Mark order as refunded and restore stock
     */
    public function markAsRefunded($refundDetails = [])
    {
        // Restore stock before marking as refunded
        $this->restoreProductStock();

        $this->update([
            'status' => 'refunded',
            'payment_status' => 'refunded', // 🔧 PERBAIKAN: Sinkronkan payment_status
            'payment_details' => array_merge($this->payment_details ?? [], [
                'refunded_at' => now(),
                'refund_details' => $refundDetails
            ])
        ]);

        Log::info('Order marked as refunded', [
            'order_id' => $this->order_id,
            'refund_details' => $refundDetails
        ]);
    }

    // Get formatted total amount
    public function getFormattedTotalAttribute()
    {
        $symbols = [
            'USD' => '$',
            'IDR' => 'Rp ',
            'MYR' => 'RM ',
            'SGD' => 'S$',
            'THB' => '฿',
            'PHP' => '₱',
            'VND' => '₫',
            'BND' => 'B$',
            'LAK' => '₭',
            'KHR' => '៛',
            'MMK' => 'K'
        ];

        $symbol = $symbols[$this->currency] ?? '$';
        return $symbol . number_format($this->total_amount, 2);
    }

    // Get customer full name
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Process stock reduction for orders that were manually marked as paid
     * This method can be called to fix orders that were updated directly in database
     */
    public static function processManuallyPaidOrders()
    {
        $orders = self::where('status', 'paid')
            ->whereNull('payment_completed_at')
            ->get();

        $processedCount = 0;
        
        foreach ($orders as $order) {
            Log::info('Processing manually paid order', ['order_id' => $order->order_id]);
            
            // Set payment completed time
            $order->update(['payment_completed_at' => now()]);
            
            // Process stock reduction and cart clearing
            $order->reduceProductStock();
            $order->clearUserCart();
            
            $processedCount++;
        }

        Log::info('Processed manually paid orders', ['count' => $processedCount]);
        
        return $processedCount;
    }

    /**
     * Update order status manually (for admin/exportir use)
     */
    public function updateStatus($newStatus, $reason = null, $updateShippingStatus = true)
    {
        $oldStatus = $this->status;
        
        // Validate status
        $validStatuses = ['pending', 'paid', 'failed', 'cancelled', 'expired', 'refunded', 'processing'];
        if (!in_array($newStatus, $validStatuses)) {
            throw new \InvalidArgumentException("Invalid status: {$newStatus}");
        }
        
        // Update status
        $this->status = $newStatus;
        $this->payment_status = $newStatus;
        
        // Update related fields based on new status
        switch ($newStatus) {
            case 'paid':
                if (!$this->payment_completed_at) {
                    $this->payment_completed_at = now();
                }
                if ($updateShippingStatus && $this->shipping_status === 'pending') {
                    $this->shipping_status = 'processing';
                }
                break;
                
            case 'failed':
            case 'cancelled':
            case 'expired':
                $this->payment_completed_at = null;
                if ($updateShippingStatus) {
                    $this->shipping_status = 'pending';
                }
                break;
        }
        
        // Add status change to payment details
        $statusChangeLog = [
            'status_changed_at' => now(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'reason' => $reason,
            'changed_by' => 'manual_update'
        ];
        
        $paymentDetails = $this->payment_details ?? [];
        $paymentDetails['status_changes'][] = $statusChangeLog;
        $this->payment_details = $paymentDetails;
        
        $this->save();
        
        // Handle stock based on status change
        if ($oldStatus !== 'paid' && $newStatus === 'paid') {
            // Reduce stock when changing to paid
            $this->reduceProductStock();
            $this->clearUserCart();
        } elseif ($oldStatus === 'paid' && $newStatus !== 'paid') {
            // Restore stock when changing from paid to other status
            $this->restoreProductStock();
        }
        
        Log::info('Order status updated manually', [
            'order_id' => $this->order_id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'reason' => $reason,
            'payment_completed_at' => $this->payment_completed_at,
            'shipping_status' => $this->shipping_status
        ]);
        
        return $this;
    }

    /**
     * Update shipping status
     */
    public function updateShippingStatus($newShippingStatus, $reason = null)
    {
        $oldShippingStatus = $this->shipping_status;
        
        // Validate shipping status
        $validShippingStatuses = ['pending', 'processing', 'shipped', 'in_transit', 'delivered', 'returned'];
        if (!in_array($newShippingStatus, $validShippingStatuses)) {
            throw new \InvalidArgumentException("Invalid shipping status: {$newShippingStatus}");
        }
        
        $this->shipping_status = $newShippingStatus;
        
        // Add shipping status change to payment details
        $shippingChangeLog = [
            'shipping_status_changed_at' => now(),
            'old_shipping_status' => $oldShippingStatus,
            'new_shipping_status' => $newShippingStatus,
            'reason' => $reason,
            'changed_by' => 'manual_update'
        ];
        
        $paymentDetails = $this->payment_details ?? [];
        $paymentDetails['shipping_changes'][] = $shippingChangeLog;
        $this->payment_details = $paymentDetails;
        
        $this->save();
        
        Log::info('Order shipping status updated manually', [
            'order_id' => $this->order_id,
            'old_shipping_status' => $oldShippingStatus,
            'new_shipping_status' => $newShippingStatus,
            'reason' => $reason
        ]);
        
        return $this;
    }

    /**
     * Boot method for automatic payment_status synchronization
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-sync payment_status dengan status setiap kali status berubah
        static::updating(function ($model) {
            // Jika status berubah, sync payment_status
            if ($model->isDirty('status')) {
                $oldStatus = $model->getOriginal('status');
                $newStatus = $model->status;
                
                // Set payment_status to match status
                $model->payment_status = $newStatus;
                
                Log::info('Auto-syncing payment_status with status', [
                    'order_id' => $model->order_id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'payment_status' => $model->payment_status
                ]);
            }
        });
        
        // Log when creating new order
        static::creating(function ($model) {
            // Ensure payment_status matches status on creation
            if ($model->status && !$model->payment_status) {
                $model->payment_status = $model->status;
                
                Log::info('Setting initial payment_status to match status', [
                    'order_id' => $model->order_id ?? 'NEW',
                    'status' => $model->status,
                    'payment_status' => $model->payment_status
                ]);
            }
        });
    }
}