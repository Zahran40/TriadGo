<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Payment - {{ $order->order_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">🧪 Test Payment Simulator</h1>
                <p class="text-gray-600 mt-2">Simulasi pembayaran untuk testing - GRATIS!</p>
            </div>

            <!-- Order Info -->
            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-blue-900 mb-4">📋 Order Details</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Order ID:</span>
                        <div class="font-mono font-bold text-blue-600" id="orderId">{{ $order->order_id }}</div>
                    </div>
                    <div>
                        <span class="text-gray-600">Amount:</span>
                        <div class="font-bold text-green-600">${{ number_format($order->total_amount, 2) }}</div>
                    </div>
                    <div>
                        <span class="text-gray-600">Status:</span>
                        <span id="orderStatus" class="px-3 py-1 rounded-full text-xs font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'paid') bg-green-100 text-green-800
                            @elseif($order->status === 'failed') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">Customer:</span>
                        <div class="font-medium">{{ $order->first_name }} {{ $order->last_name }}</div>
                    </div>
                </div>
                
                <button onclick="copyOrderId()" class="mt-4 text-blue-600 hover:text-blue-800 text-sm underline">
                    📋 Copy Order ID
                </button>
            </div>

            <!-- Cart Items -->
            @if($order->cart_items && count($order->cart_items) > 0)
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🛒 Cart Items</h3>
                <div class="space-y-3">
                    @foreach($order->cart_items as $item)
                    <div class="flex justify-between items-center bg-white p-3 rounded border">
                        <div>
                            <div class="font-medium">{{ $item['product_name'] ?? $item['name'] ?? 'Product' }}</div>
                            <div class="text-sm text-gray-500">
                                Qty: {{ $item['quantity'] ?? 1 }} × ${{ number_format($item['price'] ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="font-bold text-green-600">
                            ${{ number_format(($item['total'] ?? 0), 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Payment Actions -->
            <div class="space-y-4">
                @if($order->status === 'pending')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">💰 Simulate Payment</h3>
                        <p class="text-green-700 mb-4">
                            Klik tombol di bawah untuk mensimulasikan pembayaran berhasil <strong>TANPA BAYAR APAPUN</strong>. 
                            Ini khusus untuk testing!
                        </p>
                        
                        <button id="simulateSuccess" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                            ✅ SIMULATE SUCCESSFUL PAYMENT
                        </button>
                        
                        <button id="simulateFailure" 
                                class="w-full mt-3 bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                            ❌ SIMULATE PAYMENT FAILURE
                        </button>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            @if($order->status === 'paid') ✅ Payment Completed
                            @elseif($order->status === 'failed') ❌ Payment Failed
                            @else 🔸 Order Processed
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Order ini sudah diproses dengan status: <strong>{{ $order->status }}</strong>
                        </p>
                        @if($order->payment_completed_at)
                        <p class="text-sm text-gray-500">
                            Completed at: {{ $order->payment_completed_at->format('d M Y H:i:s') }}
                        </p>
                        @endif
                    </div>
                @endif

                <!-- Navigation -->
                <div class="flex gap-4">
                    <a href="{{ url('/') }}" 
                       class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg text-center transition duration-200">
                        🏠 Home
                    </a>
                    <a href="{{ url('/admin/order-monitoring') }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg text-center transition duration-200">
                        📊 Admin Panel
                    </a>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <h4 class="font-semibold text-yellow-900 mb-3">💡 Testing Instructions</h4>
                <ul class="text-sm text-yellow-800 space-y-2">
                    <li>• <strong>100% GRATIS</strong> - Tidak ada pembayaran real yang diproses</li>
                    <li>• Simulasi ini akan mengubah status order menjadi "paid"</li>
                    <li>• Order akan muncul di Midtrans Dashboard sebagai transaksi sukses</li>
                    <li>• Admin dapat melihat update di Order Monitoring page</li>
                    <li>• Gunakan ini untuk testing integrasi payment system</li>
                </ul>
            </div>

            <!-- Results -->
            <div id="resultMessage" class="mt-6 hidden"></div>
        </div>
    </div>

    <script>
        // Set up CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Add event listeners
        document.getElementById('simulateSuccess')?.addEventListener('click', function() {
            simulatePayment('success');
        });
        
        document.getElementById('simulateFailure')?.addEventListener('click', function() {
            simulatePayment('failure');
        });
        
        function simulatePayment(type) {
            const button = event.target;
            const originalText = button.innerHTML;
            
            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = type === 'success' ? '⏳ Processing Success...' : '⏳ Processing Failure...';            // Send simulation request - using force route that works
            fetch(`/force-simulate-payment/{{ $order->order_id }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
                    action: type === 'success' ? 'success' : 'failure',
                    force: 'true'
                })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data, type);
                if (data.success) {
                    updateOrderStatus(data.order_status);
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showResult({success: false, message: 'Network error occurred'}, type);
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }
        
        function showResult(data, type) {
            const resultDiv = document.getElementById('resultMessage');
            resultDiv.className = `mt-6 p-4 rounded-lg ${data.success ? 'bg-green-100 border border-green-300' : 'bg-red-100 border border-red-300'}`;
            
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="text-green-800">
                        <h4 class="font-bold text-lg">🎉 Payment Simulation Successful!</h4>
                        <p class="mt-2">Order Status: <strong>${data.order_status}</strong></p>
                        <p>Transaction ID: <strong>${data.transaction_id}</strong></p>
                        <p class="text-sm mt-2">✅ Order sekarang akan muncul di Midtrans Dashboard!</p>
                        <p class="text-sm">🔄 Page akan refresh otomatis dalam 3 detik...</p>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="text-red-800">
                        <h4 class="font-bold text-lg">❌ Simulation Failed</h4>
                        <p class="mt-2">${data.message}</p>
                    </div>
                `;
            }
            
            resultDiv.classList.remove('hidden');
        }
        
        function updateOrderStatus(newStatus) {
            const statusElement = document.getElementById('orderStatus');
            statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            statusElement.className = `px-3 py-1 rounded-full text-xs font-medium ${
                newStatus === 'paid' ? 'bg-green-100 text-green-800' : 
                newStatus === 'failed' ? 'bg-red-100 text-red-800' : 
                'bg-yellow-100 text-yellow-800'
            }`;
        }
        
        function copyOrderId() {
            const orderId = document.getElementById('orderId').textContent;
            navigator.clipboard.writeText(orderId).then(function() {
                alert('✅ Order ID copied to clipboard: ' + orderId);
            });
        }
    </script>
</body>
</html>
