<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

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
}