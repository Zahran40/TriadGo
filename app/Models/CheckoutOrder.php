<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $order_id
 * @property float $total_amount
 * @property string $currency
 * @property string $status
 * @property string $first_name
 * @property string $last_name
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
        'total_amount',
        'currency',
        'status',
        'first_name',
        'last_name',
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
        return $this->belongsTo(User::class);
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
        $this->update([
            'status' => 'paid',
            'payment_gateway_transaction_id' => $transactionId,
            'payment_details' => array_merge($this->payment_details ?? [], $paymentDetails),
            'payment_completed_at' => now()
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
        return $this->first_name . ' ' . $this->last_name;
    }
}
