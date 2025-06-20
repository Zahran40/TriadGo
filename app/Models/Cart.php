<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id', 
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Accessor untuk mendapatkan total harga item
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    // Scope untuk mendapatkan cart berdasarkan user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
