<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Product Detail Test</title>
</head>
<body>
    <h1>SIMPLE PRODUCT DETAIL TEST</h1>
    
    @if(isset($product))
        <h2>Product Found: {{ $product->product_name }}</h2>
        <p>Price: ${{ $product->price }}</p>
        <p>Status: {{ $product->status }}</p>
        <p>Description: {{ $product->product_description }}</p>
    @else
        <h2>No Product Data Passed</h2>
    @endif
    
    <hr>
    <p>Auth Status: {{ Auth::check() ? 'Logged In as ' . Auth::user()->name : 'Not Logged In' }}</p>
    <p>User Role: {{ Auth::check() ? Auth::user()->role : 'No Role' }}</p>
    <p>Product ID: {{ request()->route('id') }}</p>
    
    <script>
        console.log('Page loaded successfully');
    </script>
</body>
</html>
