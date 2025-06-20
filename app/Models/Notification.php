<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property string $type
 * @property bool $is_read
 * @property string|null $related_id
 * @property string|null $related_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'related_id',
        'related_type'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    // Notification types
    const TYPE_REQUEST_APPROVED = 'request_approved';
    const TYPE_REQUEST_REJECTED = 'request_rejected';
    const TYPE_PRODUCT_ADDED = 'product_added';
    const TYPE_STOCK_UPDATE = 'stock_update';
    const TYPE_ORDER_STATUS = 'order_status';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Methods
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public static function createNotification($userId, $title, $message, $type, $relatedId = null, $relatedType = null)
    {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_id' => $relatedId,
            'related_type' => $relatedType,
            'is_read' => false
        ]);
    }
}
