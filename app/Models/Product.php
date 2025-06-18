<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $product_id
 * @property int $user_id
 * @property string $product_name
 * @property string $product_description
 * @property string $category
 * @property float $price
 * @property int $stock_quantity
 * @property string $product_sku
 * @property float $weight
 * @property string $country_of_origin
 * @property string|null $product_image
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'user_id',
        'product_name',
        'product_description',
        'category',
        'price',
        'stock_quantity',
        'product_sku',
        'weight',
        'country_of_origin',
        'product_image',
        'status', // pending, approved, rejected, archived
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    /**
     * Boot method - Auto generate SKU sebelum create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_sku)) {
                $product->product_sku = static::generateSKU();
            }
        });
    }

    /**
     * Generate auto increment SKU dengan format TD-XXX
     */
    public static function generateSKU()
    {
        // Cari SKU terakhir dengan format TD-XXX
        $lastProduct = static::where('product_sku', 'LIKE', 'TD-%')
                            ->orderByRaw('CAST(SUBSTRING(product_sku, 4) AS UNSIGNED) DESC')
                            ->first();

        if ($lastProduct) {
            // Extract nomor dari SKU terakhir (TD-20 -> 20)
            $lastNumber = (int) str_replace('TD-', '', $lastProduct->product_sku);
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada produk, mulai dari 1
            $newNumber = 1;
        }

        return 'TD-' . $newNumber;
    }

     public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get status with proper formatting
     */
    public function getStatusBadgeAttribute()
    {
        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800', 
            'rejected' => 'bg-red-100 text-red-800',
            
        ];

        return $statusColors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Relationship: Product belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}