<!DOCTYPE html>
<html>
<head>
    <title>Quick Login Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Test Login - Importer</h2>
        
        <form action="/login" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" value="testimpor@test.com" 
                       class="w-full px-3 py-2 border rounded-lg" readonly>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" value="password123" 
                       class="w-full px-3 py-2 border rounded-lg" readonly>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Login as Importer
            </button>
        </form>
        
        <div class="mt-4 text-sm text-gray-600">
            <p>This will log you in as a test importer user to access the product detail page.</p>
            <p class="mt-2">After login, go to: <a href="/product-detail-importir/1" class="text-blue-500">/product-detail-importir/1</a></p>
        </div>
    </div>
</body>
</html>
