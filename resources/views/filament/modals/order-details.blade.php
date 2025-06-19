<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order: {{ $order->order_id }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Placed on {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($order->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($order->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
                @if($order->payment_completed_at)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Paid: {{ $order->payment_completed_at->format('M d, Y H:i') }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Customer & Billing Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Customer Information -->
        <div class="space-y-4">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                Customer Information
            </h4>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->first_name }} {{ $order->last_name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        <a href="mailto:{{ $order->email }}" class="text-blue-600 hover:text-blue-800">{{ $order->email }}</a>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        <a href="tel:{{ $order->phone }}" class="text-blue-600 hover:text-blue-800">{{ $order->phone }}</a>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->country }}</p>
                </div>
            </div>
        </div>

        <!-- Billing Address -->
        <div class="space-y-4">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                Billing Address
            </h4>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->address }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->city }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->state }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ZIP Code</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->zip_code }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->country }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h4>
        
        <div class="space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                <span class="text-gray-900 dark:text-white">${{ number_format($order->subtotal, 2) }}</span>
            </div>
            
            @if($order->shipping_cost > 0)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                <span class="text-gray-900 dark:text-white">${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            @endif
            
            @if($order->tax_amount > 0)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                <span class="text-gray-900 dark:text-white">${{ number_format($order->tax_amount, 2) }}</span>
            </div>
            @endif
            
            @if($order->discount_amount > 0)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Discount:</span>
                <span class="text-green-600 dark:text-green-400">-${{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            
            <hr class="border-gray-200 dark:border-gray-700">
            
            <div class="flex justify-between text-lg font-semibold">
                <span class="text-gray-900 dark:text-white">Total:</span>
                <span class="text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }} {{ strtoupper($order->currency) }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Payment Information</h4>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ strtoupper($order->payment_method) }}</p>
            </div>
            
            @if($order->payment_gateway_transaction_id)
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction ID</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $order->payment_gateway_transaction_id }}</p>
            </div>
            @endif
            
            @if($order->coupon_code)
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coupon Used</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->coupon_code }}</p>
            </div>
            @endif
        </div>
        
        @if($order->notes)
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Notes</label>
            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                <p class="text-sm text-gray-900 dark:text-white">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Order Items Preview -->
    @if($order->cart_items && count($order->cart_items) > 0)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Order Items ({{ count($order->cart_items) }} items)</h4>
        
        <div class="space-y-3 max-h-48 overflow-y-auto">
            @foreach($order->cart_items as $item)
            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['name'] ?? 'Unknown Product' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ $item['quantity'] ?? 1 }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        ${{ number_format($item['price'] ?? 0, 2) }} each
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
            <button onclick="viewOrderItems('{{ $order->order_id }}')" 
                    class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                View all items in detail →
            </button>
        </div>
    </div>
    @endif
</div>

<script>
function viewOrderItems(orderId) {
    // This would open the order items modal
    // Implementation depends on your Filament setup
    console.log('View items for order:', orderId);
}
</script>
