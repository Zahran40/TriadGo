<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $importir_user_id
 * @property string $request_text
 * @property string $status
 * @property int|null $eksportir_user_id
 * @property int|null $product_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $approved_at
 * @property \Carbon\Carbon|null $rejected_at
 */
class Request extends Model
{
    use HasFactory;

    protected $table = 'product_requests';

    protected $fillable = [
        'importir_user_id',
        'request_text',
        'status',
        'eksportir_user_id',
        'product_id',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_FULFILLED = 'fulfilled';

    // Relationships
    public function importir()
    {
        return $this->belongsTo(User::class, 'importir_user_id', 'user_id');
    }

    public function eksportir()
    {
        return $this->belongsTo(User::class, 'eksportir_user_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Methods
    public function approve($eksportirUserId, $productId = null)
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'eksportir_user_id' => $eksportirUserId,
            'product_id' => $productId,
            'approved_at' => now()
        ]);
    }

    public function reject($eksportirUserId)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'eksportir_user_id' => $eksportirUserId,
            'rejected_at' => now()
        ]);
    }

    public function markAsFulfilled()
    {
        $this->update([
            'status' => self::STATUS_FULFILLED
        ]);
    }
}
