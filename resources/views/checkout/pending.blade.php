<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Pending - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    @include('layouts.navbarimportir')
    
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="product rounded-lg shadow-lg p-8 text-center">
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
                
                <p class="text-blue-800  mb-8">
                    Your payment is being processed. Please complete your payment or wait for confirmation.
                </p>
                
                <!-- Order Details -->
                <div class=" rounded-lg p-6 mb-8 text-left">
                    <h3 class="text-lg font-semibold text-blue-700  mb-4">Order Details</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-blue-800 ">Order ID:</span>
                            <span class="font-semibold text-blue-700 ">{{ $order->order_id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-blue-800 ">Customer:</span>
                            <span class="font-semibold text-blue-700 ">{{ $order->full_name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-blue-800 ">Total Amount:</span>
                            <span class="font-semibold text-blue-700 ">{{ $order->formatted_total }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-blue-800 ">Status:</span>
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
        const isDarkMode = document.documentElement.classList.contains('dark');

        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeThumb = document.getElementById('darkModeThumb');
        const htmlElement = document.documentElement;

        function updateDarkModeSwitch() {
            if (htmlElement.classList.contains('dark')) {
                darkModeToggle.checked = true;
                darkModeThumb.style.transform = 'translateX(1.25rem)';
                darkModeThumb.style.backgroundColor = '#003355';
                darkModeThumb.style.borderColor = '#003355';
            } else {
                darkModeToggle.checked = false;
                darkModeThumb.style.transform = 'translateX(0)';
                darkModeThumb.style.backgroundColor = '#fff';
                darkModeThumb.style.borderColor = '#ccc';
            }
        }

        if (localStorage.getItem('darkMode') === 'enabled') {
            htmlElement.classList.add('dark');
        }

        updateDarkModeSwitch();

        darkModeToggle.addEventListener('change', () => {
            htmlElement.classList.toggle('dark');
            if (htmlElement.classList.contains('dark')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
            updateDarkModeSwitch();
        });

        // Check Payment Status Function
        function checkPaymentStatus() {
            const checkBtn = document.getElementById('checkStatusBtn');
            const orderId = '{{ $order->order_id }}';
            
            // Disable button and show loading
            checkBtn.disabled = true;
            checkBtn.innerHTML = 'Checking...';
            checkBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
            
            // Make AJAX request to check status
            fetch(`/checkout/status/${orderId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'same-origin' // Include cookies for session
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else if (response.status === 404) {
                    throw new Error('Order not found');
                } else if (response.status === 401 || response.status === 403) {
                    throw new Error('Authentication required');
                } else {
                    throw new Error('Server error');
                }
            })
            .then(data => {
                if (data.status === 'success') {
                    const paymentStatus = data.payment_status.toLowerCase();
                    
                    // Redirect based on payment status
                    if (paymentStatus === 'capture' || paymentStatus === 'settlement' || paymentStatus === 'paid' || paymentStatus === 'success') {
                        // Payment successful - redirect to success page
                        alert('Payment completed successfully! Redirecting to success page...');
                        window.location.href = `/checkout/success/${orderId}`;
                    } else if (paymentStatus === 'cancel' || paymentStatus === 'expire' || paymentStatus === 'failure' || paymentStatus === 'failed') {
                        // Payment failed - redirect to error page
                        alert('Payment failed. Redirecting to error page...');
                        window.location.href = `/checkout/error/${orderId}`;
                    } else {
                        // Still pending, show message
                        alert(`Current payment status: ${data.payment_status}. Please complete your payment.`);
                        
                        // Update status display if different
                        const statusElement = document.querySelector('.bg-yellow-100 span');
                        if (statusElement) {
                            statusElement.textContent = data.payment_status.charAt(0).toUpperCase() + data.payment_status.slice(1);
                        }
                    }
                } else {
                    alert('Error checking payment status: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message === 'Order not found') {
                    alert('Order not found. Please check your order ID.');
                } else if (error.message === 'Authentication required') {
                    alert('Please login to check payment status.');
                    // Optionally redirect to login
                    // window.location.href = '/login';
                } else {
                    alert('Network error. Please check your connection and try again.');
                }
            })
            .finally(() => {
                // Re-enable button
                checkBtn.disabled = false;
                checkBtn.innerHTML = 'Check Payment Status';
                checkBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }

        // Auto-check status every 30 seconds
        setInterval(checkPaymentStatus, 30000);

    </script>
</body>
</html>
