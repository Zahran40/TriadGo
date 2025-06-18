<div class="space-y-4">
    <!-- Order Header -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order Items</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Order ID: {{ $order->order_id }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ count($order->cart_items ?? []) }} item(s)
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Total: ${{ number_format($order->total_amount, 2) }}
                </p>
            </div>
        </div>
    </div>

    @if($order->cart_items && count($order->cart_items) > 0)
        <!-- Items List -->
        <div class="space-y-4">
            @foreach($order->cart_items as $index => $item)
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-start space-x-4">
                    <!-- Item Image Placeholder -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ asset('uploads/' . $item['image']) }}" 
                                     alt="{{ $item['name'] ?? 'Product' }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Item Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $item['name'] ?? 'Unknown Product' }}
                                </h4>
                                
                                @if(isset($item['description']) && $item['description'])
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ Str::limit($item['description'], 100) }}
                                </p>
                                @endif

                                @if(isset($item['sku']) && $item['sku'])
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                    SKU: {{ $item['sku'] }}
                                </p>
                                @endif

                                <!-- Item Attributes -->
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @if(isset($item['category']) && $item['category'])
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $item['category'] }}
                                    </span>
                                    @endif
                                    
                                    @if(isset($item['weight']) && $item['weight'])
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                        {{ $item['weight'] }}kg
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="text-right ml-4">
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    ${{ number_format($item['price'] ?? 0, 2) }} × {{ $item['quantity'] ?? 1 }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-500">
                                    per unit
                                </div>
                            </div>
                        </div>

                        <!-- Additional Item Info -->
                        @if(isset($item['specifications']) && $item['specifications'])
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                <strong>Specifications:</strong> {{ $item['specifications'] }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mt-6">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Order Summary</h4>
            
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">
                        Subtotal ({{ count($order->cart_items) }} items):
                    </span>
                    <span class="text-gray-900 dark:text-white">
                        ${{ number_format($order->subtotal, 2) }}
                    </span>
                </div>
                
                @if($order->shipping_cost > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Shipping & Handling:</span>
                    <span class="text-gray-900 dark:text-white">
                        ${{ number_format($order->shipping_cost, 2) }}
                    </span>
                </div>
                @endif
                
                @if($order->tax_amount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                    <span class="text-gray-900 dark:text-white">
                        ${{ number_format($order->tax_amount, 2) }}
                    </span>
                </div>
                @endif
                
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">
                        Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif:
                    </span>
                    <span class="text-green-600 dark:text-green-400">
                        -${{ number_format($order->discount_amount, 2) }}
                    </span>
                </div>
                @endif
                
                <hr class="border-gray-200 dark:border-gray-700">
                
                <div class="flex justify-between text-lg font-semibold">
                    <span class="text-gray-900 dark:text-white">Total:</span>
                    <span class="text-gray-900 dark:text-white">
                        ${{ number_format($order->total_amount, 2) }} {{ strtoupper($order->currency) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Customer & Delivery</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Customer:</p>
                    <p class="text-gray-900 dark:text-white font-medium">
                        {{ $order->first_name }} {{ $order->last_name }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->email }}</p>
                </div>
                
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Delivery Address:</p>
                    <p class="text-gray-900 dark:text-white">
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}<br>
                        {{ $order->country }}
                    </p>
                </div>
            </div>
        </div>

    @else
        <!-- No Items -->
        <div class="text-center py-8">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Items Found</h3>
            <p class="text-gray-600 dark:text-gray-400">This order doesn't contain any items.</p>
        </div>
    @endif
</div>
