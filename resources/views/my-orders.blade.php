<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'triad-blue': '#1e3a8a',
                        'triad-green': '#059669',
                        'triad-orange': '#f97316', 
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    @include('layouts.navbarimportir')
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">My Orders</h1>
                        <p class="text-gray-600 dark:text-gray-300">Track your orders and view invoices</p>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold text-triad-blue dark:text-triad-green">
                            Total Orders: {{ $orders->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Paid Orders: {{ $orders->where('status', 'paid')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            @if($orders->count() > 0)
                <div class="grid gap-6">
                    @foreach($orders as $order)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-gradient-to-r from-triad-blue to-triad-green p-6">
                                <div class="flex items-center justify-between text-white">
                                    <div>
                                        <h3 class="text-xl font-bold">{{ $order->order_id }}</h3>
                                        <p class="text-blue-100">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold">{{ $order->formatted_total }}</div>
                                        @php
                                            $statusColor = match($order->status) {
                                                'paid' => 'bg-green-500',
                                                'pending' => 'bg-yellow-500',
                                                'failed' => 'bg-red-500',
                                                'cancelled' => 'bg-gray-500',
                                                default => 'bg-orange-500'
                                            };
                                        @endphp
                                        <span class="inline-block {{ $statusColor }} text-white px-3 py-1 rounded-full text-sm font-medium mt-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="p-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <!-- Customer Info -->
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Customer Information</h4>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Name:</span> {{ $order->full_name }}</p>
                                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Email:</span> {{ $order->email }}</p>
                                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Phone:</span> {{ $order->phone }}</p>
                                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Address:</span> {{ $order->address }}, {{ $order->city }}</p>
                                        </div>
                                    </div>

                                    <!-- Payment Info -->
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Payment Information</h4>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Method:</span> {{ ucfirst($order->payment_method ?? 'Midtrans') }}</p>
                                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Currency:</span> {{ $order->currency }}</p>
                                            @if($order->payment_completed_at)
                                                <p><span class="font-medium text-gray-600 dark:text-gray-400">Paid At:</span> {{ $order->payment_completed_at->format('d M Y, H:i') }}</p>
                                            @endif
                                            @if($order->payment_gateway_transaction_id)
                                                <p><span class="font-medium text-gray-600 dark:text-gray-400">Transaction ID:</span> {{ $order->payment_gateway_transaction_id }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                @if($order->cart_items && count($order->cart_items) > 0)
                                    <div class="mt-6">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Order Items</h4>
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <div class="grid gap-3">
                                                @foreach($order->cart_items as $item)
                                                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                                        <div class="flex-1">
                                                            <p class="font-medium text-gray-900 dark:text-white">{{ $item['name'] ?? 'Product' }}</p>
                                                            @if(isset($item['description']) && $item['description'])
                                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item['description'] }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-right ml-4">
                                                            <p class="text-sm text-gray-600 dark:text-gray-300">Qty: {{ $item['quantity'] ?? 1 }}</p>
                                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                                {{ $order->currency === 'IDR' ? 'Rp ' : '$' }}{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), $order->currency === 'IDR' ? 0 : 2) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="mt-6 flex flex-wrap gap-3">
                                    @if($order->status === 'paid')
                                        <a href="{{ route('invoice.show', $order->order_id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-triad-green hover:bg-green-700 text-white font-semibold rounded-lg transition-colors"
                                           target="_blank">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            View Invoice
                                        </a>
                                    @endif
                                    
                                    @if(in_array($order->status, ['pending', 'failed']))
                                        <a href="{{ route('test.payment', $order->order_id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-triad-orange hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            Complete Payment
                                        </a>
                                    @endif

                                    <button onclick="copyOrderId('{{ $order->order_id }}')" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Copy Order ID
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Orders Yet</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                    <a href="{{ route('catalog') }}" 
                       class="inline-flex items-center px-6 py-3 bg-triad-blue hover:bg-blue-800 text-white font-semibold rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyOrderId(orderId) {
            navigator.clipboard.writeText(orderId).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Copied!';
                button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-gray-600', 'hover:bg-gray-700');
                }, 2000);
            });
        }
    </script>
</body>
</html>
