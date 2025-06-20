# Automatic Product Stock Reduction System

## Overview
Sistem ini secara otomatis mengurangi stok produk ketika importir berhasil melakukan pembayaran melalui Midtrans.

## How It Works

### 1. Payment Success Flow
```
Importir melakukan checkout → Midtrans payment → Payment success notification → 
Stock reduced automatically → Cart cleared → Order marked as paid
```

### 2. Automatic Stock Reduction
- **Trigger**: Saat method `markAsPaid()` dipanggil di `CheckoutOrder` model
- **Source**: Data cart items yang tersimpan di field `cart_items` pada order
- **Process**: Loop through semua items dan kurangi stok produk sesuai quantity yang dibeli

### 3. Safety Features

#### Double Payment Prevention
```php
// Check if already paid to prevent double processing
if ($this->status === 'paid') {
    Log::info('Order already marked as paid, skipping duplicate processing');
    return;
}
```

#### Stock Validation
```php
// Check if stock is sufficient (safety check)
if ($product->stock_quantity < $quantity) {
    Log::warning('Insufficient stock for reduction');
    continue; // Skip this item
}
```

#### Database Constraint
```sql
-- Prevents negative stock at database level
ALTER TABLE products ADD CONSTRAINT chk_stock_positive CHECK (stock_quantity >= 0)
```

### 4. Stock Restoration (Refund/Cancel)

#### Cancel Order
```php
$order->markAsCancelled('Customer requested cancellation');
```

#### Refund Order  
```php
$order->markAsRefunded(['refund_id' => 'REF123', 'amount' => 100.00]);
```

#### Automatic Stock Restoration
- Ketika order di-cancel atau refund, stok akan dikembalikan otomatis
- Midtrans notification untuk status `deny`, `expire`, `cancel` akan trigger stock restoration

## Implementation Details

### Files Modified

1. **CheckoutOrder.php** - Model utama
   - `markAsPaid()` - Trigger stock reduction
   - `reduceProductStock()` - Logic pengurangan stok
   - `restoreProductStock()` - Logic restore stok
   - `markAsCancelled()` - Cancel dengan restore stok
   - `markAsRefunded()` - Refund dengan restore stok
   - `clearUserCart()` - Clear cart setelah payment

2. **MidtransHttpService.php** - Payment notification handler
   - Updated `handleNotification()` untuk handle cancel/expire dengan restore stok

3. **Database Migration**
   - Added constraint untuk prevent negative stock

### Logging & Monitoring

Semua proses stock reduction/restoration di-log dengan detail:

```php
Log::info('Product stock reduced successfully', [
    'order_id' => $this->order_id,
    'product_id' => $productId,
    'product_name' => $product->product_name,
    'quantity_sold' => $quantity,
    'old_stock' => $oldStock,
    'new_stock' => $product->stock_quantity
]);
```

### Error Handling

- Graceful handling jika produk tidak ditemukan
- Continue processing jika ada error pada satu item
- Detailed error logging untuk debugging

## Testing

System telah ditest dengan:
- ✅ Normal payment flow dengan stock reduction
- ✅ Double payment prevention
- ✅ Stock restoration pada cancel/refund
- ✅ Database constraint untuk negative stock prevention
- ✅ Error handling untuk edge cases

## Monitoring

Check logs di `storage/logs/laravel.log` untuk:
- Stock reduction activities
- Stock restoration activities  
- Errors atau warnings
- Payment processing events

## Future Enhancements

1. **Stock Alert**: Notification ketika stok produk hampir habis
2. **Stock History**: Track semua perubahan stok dengan timestamps
3. **Bulk Stock Management**: Interface untuk update stok dalam jumlah besar
4. **Stock Reservation**: Reserve stok saat item di cart (sebelum payment)
