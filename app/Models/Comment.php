<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'comment_id';
    
    protected $fillable = [
        'product_id',
        'user_id',
        'comment_text',
        'rating'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Product (Many-to-One)
     * Satu komentar milik satu produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Relasi ke User (Many-to-One)
     * Satu komentar milik satu user (pemberi komentar)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Scope untuk komentar berdasarkan produk
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope untuk komentar berdasarikan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get rating as stars (helper method)
     */
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}