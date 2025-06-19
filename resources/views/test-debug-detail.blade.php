<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Product Detail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .product-card { border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .debug-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .debug-info pre { margin: 0; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Test Product Detail Debug</h1>
        
        <div class="debug-info">
            <h3>🔧 Debug Information:</h3>
            <pre>
Current User: {{ Auth::check() ? Auth::user()->name . ' (' . Auth::user()->role . ')' : 'Not logged in' }}
Product ID: {{ request()->route('id') ?? 'No ID' }}
Laravel Version: {{ app()->version() }}
Environment: {{ app()->environment() }}
            </pre>
        </div>

        @if(Auth::check())
            <div class="alert alert-success">
                ✅ User is logged in as: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})
            </div>
        @else
            <div class="alert alert-error">
                ❌ User is not logged in. Please <a href="{{ route('login') }}">login first</a>.
            </div>
        @endif

        @php
            $productId = request()->route('id');
            $product = null;
            try {
                if ($productId) {
                    $product = \App\Models\Product::with('user', 'comments.user')
                                 ->where('product_id', $productId)
                                 ->where('status', 'approved')
                                 ->first();
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        @endphp

        @if(isset($error))
            <div class="alert alert-error">
                ❌ Database Error: {{ $error }}
            </div>
        @elseif($product)
            <div class="alert alert-success">
                ✅ Product found: <strong>{{ $product->product_name }}</strong>
            </div>
            
            <div class="product-card">
                <h2>{{ $product->product_name }}</h2>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Description:</strong> {{ $product->product_description }}</p>
                <p><strong>Category:</strong> {{ $product->category }}</p>
                <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
                <p><strong>Weight:</strong> {{ $product->weight }}kg</p>
                <p><strong>Country:</strong> {{ $product->country_of_origin }}</p>
                <p><strong>Status:</strong> {{ $product->status }}</p>
                @if($product->user)
                    <p><strong>Exporter:</strong> {{ $product->user->name }} ({{ $product->user->country }})</p>
                @endif
                <p><strong>Comments:</strong> {{ $product->comments->count() }}</p>
            </div>
        @else
            <div class="alert alert-error">
                ❌ Product not found or not approved (ID: {{ $productId ?? 'None' }})
            </div>
        @endif

        <div class="debug-info">
            <h3>🧪 Quick Tests:</h3>
            <p><a href="{{ route('detailproductimportir', ['id' => 8]) }}">Test Product ID 8 (Indonesian Clove Spice)</a></p>
            <p><a href="{{ route('detailproductimportir', ['id' => 5]) }}">Test Product ID 5 (Virgin Coconut Oil)</a></p>
            <p><a href="{{ route('detailproductimportir', ['id' => 999]) }}">Test Non-existent Product (ID 999)</a></p>
        </div>
    </div>
</body>
</html>
