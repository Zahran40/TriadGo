<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Pending - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    @include('layouts.navbarimportir')
    
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
                <!-- Pending Icon -->
                <div class="w-24 h-24 mx-auto mb-6 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <!-- Pending Message -->
                <h1 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-4">
                    Payment Pending
                </h1>
                
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    Your payment is being processed. Please complete your payment or wait for confirmation.
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
                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-sm font-medium">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Status Check -->
                <div class="mb-8">
                    <button id="checkStatusBtn" onclick="checkPaymentStatus()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                        Check Payment Status
                    </button>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('checkout.index') }}" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                        Try Again
                    </a>
                    
                    <a href="{{ route('importir') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-colors">
                        Back to Dashboard
                    </a>
                </div>
                
                <!-- Additional Info -->
                <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>Need Help?</strong><br>
                        If you're experiencing issues with payment, please contact our support team or try a different payment method.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function checkPaymentStatus() {
            const btn = document.getElementById('checkStatusBtn');
            const originalText = btn.textContent;
            
            btn.textContent = 'Checking...';
            btn.disabled = true;
            
            try {
                const response = await fetch('/checkout/status/{{ $order->order_id }}');
                const data = await response.json();
                
                if (data.success) {
                    if (data.order.status === 'paid') {
                        window.location.href = '/checkout/success/{{ $order->order_id }}';
                    } else if (data.order.status === 'failed') {
                        window.location.href = '/checkout/error/{{ $order->order_id }}';
                    } else {
                        alert('Payment is still pending. Please wait or complete your payment.');
                    }
                } else {
                    alert('Unable to check payment status. Please try again.');
                }
            } catch (error) {
                console.error('Error checking status:', error);
                alert('Error checking payment status. Please try again.');
            } finally {
                btn.textContent = originalText;
                btn.disabled = false;
            }
        }
        
        // Auto-refresh status every 30 seconds
        setInterval(() => {
            checkPaymentStatus();
        }, 30000);
    </script>
</body>
</html>
