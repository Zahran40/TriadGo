<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id }}">
    <title>{{ $product->product_name }} | TriadGO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">{{ $product->product_name }}</h1>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Image -->
                <div>
                    @if($product->product_image)
                        <img src="{{ asset($product->product_image) }}" 
                             alt="{{ $product->product_name }}" 
                             class="w-full h-64 object-cover rounded">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4">{{ $product->product_name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $product->product_description }}</p>
                    
                    <div class="space-y-2">
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p><strong>Stock:</strong> {{ $product->stock_quantity }} units</p>
                        <p><strong>Weight:</strong> {{ $product->weight }} kg</p>
                        <p><strong>Category:</strong> {{ $product->category }}</p>
                        <p><strong>Country:</strong> {{ $product->country_of_origin }}</p>
                    </div>
                    
                    @if($product->user)
                        <div class="mt-4 p-4 border rounded">
                            <h3 class="font-semibold">Exporter</h3>
                            <p>{{ $product->user->name }}</p>
                            <p>{{ $product->user->country }}</p>
                            <p>{{ $product->user->phone }}</p>
                        </div>
                    @endif
                    
                    <!-- Quantity Selection -->
                    <div class="mt-6">
                        <label class="block font-medium mb-2">Quantity:</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="decreaseBtn" class="bg-blue-500 text-white px-3 py-1 rounded">-</button>
                            <input type="number" id="quantity" value="1" min="1" class="border rounded px-3 py-1 w-20 text-center">
                            <button type="button" id="increaseBtn" class="bg-blue-500 text-white px-3 py-1 rounded">+</button>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-2">
                        <button type="button" id="addToCartBtn" class="w-full bg-orange-500 text-white py-2 px-4 rounded hover:bg-orange-600">
                            Add to Cart
                        </button>
                        <button type="button" id="viewCartBtn" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                            View Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple functionality
        document.getElementById('increaseBtn').addEventListener('click', function() {
            const qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
        });
        
        document.getElementById('decreaseBtn').addEventListener('click', function() {
            const qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        });
        
        document.getElementById('addToCartBtn').addEventListener('click', function() {
            const quantity = parseInt(document.getElementById('quantity').value);
            
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: {{ $product->product_id }},
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Product added to cart!');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add to cart');
            });
        });
        
        document.getElementById('viewCartBtn').addEventListener('click', function() {
            window.location.href = "{{ route('formimportir') }}";
        });
    </script>
</body>
</html>
