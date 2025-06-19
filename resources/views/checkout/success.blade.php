<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    @include('layouts.navbarimportir')
    
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
                <!-- Success Icon -->
                <div class="w-24 h-24 mx-auto mb-6 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">
                    Payment Successful!
                </h1>
                
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    Thank you for your purchase! Your payment has been processed successfully.
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
                            <span class="text-gray-600 dark:text-gray-300">Email:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->email }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Total Amount:</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">{{ $order->formatted_total }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Payment Method:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Status:</span>
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-medium">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        
                        @if($order->payment_completed_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Payment Date:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->payment_completed_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                  <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('invoice.show', $order->order_id) }}" 
                       class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                       target="_blank">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        View Invoice
                    </a>
                    
                    <a href="{{ route('catalog') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                        Continue Shopping
                    </a>
                    
                    <a href="{{ route('importir') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-colors">
                        Back to Dashboard
                    </a>
                </div>
                
                <!-- Additional Info -->
                <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        <strong>What's Next?</strong><br>
                        You will receive an order confirmation email shortly. Our team will process your order and provide tracking information once your items are shipped.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
