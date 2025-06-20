<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

/**
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property string|null $profile_picture
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @method \Illuminate\Database\Eloquent\Collection getCartWithProducts()
 * @method float getCartTotal()
 * @method int getCartCount()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany cartItems()
 */
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'phone',
        'role',
        'profile_picture', // Tambah ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: User has many Products (One-to-Many)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id');
    }

    // Override untuk primary key custom
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;
    }

    // Method untuk Filament - return true karena middleware sudah filter
    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Middleware AdminAccess sudah handle filtering
    }

    /**
     * Relasi ke Comments yang dibuat user ini
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }

    /**
     * Relationship with checkout orders
     */
    public function checkoutOrders()
    {
        return $this->hasMany(CheckoutOrder::class);
    }

    /**
     * Relationship with cart
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

    /**
     * Get cart items with product details
     */
    public function getCartWithProducts()
    {
        return $this->cartItems()->with('product')->get();
    }

    /**
     * Get cart total
     */
    public function getCartTotal()
    {
        return $this->cartItems()->with('product')->get()->sum('total');
    }

    /**
     * Get cart count
     */
    public function getCartCount()
    {
        return $this->cartItems()->sum('quantity');
    }

    /**
     * ✅ ADD THIS METHOD - Get comments untuk produk milik user ini
     */
    public function receivedComments()
    {
        return Comment::join('products', 'comments.product_id', '=', 'products.product_id')
                      ->where('products.user_id', $this->user_id)
                      ->select('comments.*')
                      ->with(['user', 'product'])
                      ->orderBy('comments.created_at', 'desc');
    }
}