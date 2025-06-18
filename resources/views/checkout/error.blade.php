<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    @include('layouts.navbarimportir')
    
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
                <!-- Error Icon -->
                <div class="w-24 h-24 mx-auto mb-6 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                
                <!-- Error Message -->
                <h1 class="text-3xl font-bold text-red-600 dark:text-red-400 mb-4">
                    Payment Failed
                </h1>
                
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    We're sorry, but there was an issue processing your payment. Please try again or use a different payment method.
                </p>
                
                <!-- Order Details -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8 text-left">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Details</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Order ID:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->order_id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Customer:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->full_name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Total Amount:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->formatted_total }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Status:</span>
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full text-sm font-medium">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Common Issues -->
                <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-6 mb-8 text-left">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">Common Issues & Solutions</h3>
                    
                    <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                            <span>Insufficient funds in your account</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                            <span>Incorrect card details or expired card</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                            <span>Network connection issues</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                            <span>Card blocked by your bank for online transactions</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('checkout.index') }}" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                        Try Payment Again
                    </a>
                    
                    <a href="{{ route('catalog') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                        Continue Shopping
                    </a>
                    
                    <a href="{{ route('importir') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-colors">
                        Back to Dashboard
                    </a>
                </div>
                
                <!-- Support Info -->
                <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Need Help?</strong><br>
                        If you continue to experience issues, please contact our customer support team at 
                        <a href="mailto:support@triadgo.com" class="text-blue-600 dark:text-blue-400 hover:underline">support@triadgo.com</a> 
                        or call us at +1 (555) 123-4567.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
