<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold mb-6">Product Detail Test</h1>
        
        @if(isset($product))
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $product->product_name ?? 'No Name' }}</h2>
                <p><strong>ID:</strong> {{ $product->product_id ?? 'No ID' }}</p>
                <p><strong>Price:</strong> ${{ $product->price ?? 'No Price' }}</p>
                <p><strong>Category:</strong> {{ $product->category ?? 'No Category' }}</p>
                
                @if(isset($product->user))
                    <h3 class="text-xl font-bold mt-4 mb-2">Exporter:</h3>
                    <p><strong>Name:</strong> {{ $product->user->name ?? 'No Name' }}</p>
                    <p><strong>Country:</strong> {{ $product->user->country ?? 'No Country' }}</p>
                @else
                    <p class="text-red-500 mt-4">No user relationship found</p>
                @endif
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Error:</strong> No product data available
            </div>
        @endif
        
        <div class="mt-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <strong>Debug Info:</strong>
            <ul class="mt-2">
                <li>Current URL: {{ request()->url() }}</li>
                <li>Route Parameters: {{ json_encode(request()->route()->parameters ?? []) }}</li>
                <li>Auth User: {{ auth()->check() ? auth()->user()->name : 'Not logged in' }}</li>
                <li>User Role: {{ auth()->check() ? auth()->user()->role : 'No role' }}</li>
            </ul>
        </div>
    </div>
</body>
</html>
