<div class="space-y-6">
    <!-- Product Image -->
    <div class="flex justify-center">
        @if($product->product_image)
            <img src="{{ asset('uploads/' . $product->product_image) }}" 
                 alt="{{ $product->product_name }}" 
                 class="w-48 h-48 object-cover rounded-lg shadow-md">
        @else
            <div class="w-48 h-48 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                </svg>
            </div>
        @endif
    </div>

    <!-- Product Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->product_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->category }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Quantity</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($product->stock_quantity) }} units</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->weight }} kg</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product SKU</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->product_sku }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country of Origin</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->country_of_origin }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Eksportir</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->user->name ?? 'Unknown' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($product->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($product->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($product->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                    @endif">
                    {{ ucfirst($product->status) }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Submitted Date</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
        <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 rounded-md">
            <p class="text-sm text-gray-900 dark:text-white">{{ $product->product_description }}</p>
        </div>
    </div>

    <!-- Action Buttons (if status is pending) -->
    @if($product->status === 'pending')
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button type="button" 
                    onclick="approveProduct({{ $product->product_id }})"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Approve
            </button>
            
            <button type="button" 
                    onclick="rejectProduct({{ $product->product_id }})"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                Reject
            </button>
        </div>
    @endif
</div>

<script>
function approveProduct(productId) {
    if (confirm('Are you sure you want to approve this product?')) {
        // Implementation would depend on your Filament setup
        // This is a placeholder for the actual approval action
        window.location.reload();
    }
}

function rejectProduct(productId) {
    if (confirm('Are you sure you want to reject this product?')) {
        // Implementation would depend on your Filament setup
        // This is a placeholder for the actual rejection action
        window.location.reload();
    }
}
</script>
