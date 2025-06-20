<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Transaksi - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50">
    @include('layouts.navbarekspor')

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Transaksi</h1>
                <p class="text-gray-600">Kelola status pembayaran dan pengiriman produk yang dipesan importir</p>
            </div>
        </div>

        <!-- Payment Status Filter Cards -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Filter Status Pembayaran</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <a href="{{ route('eksportir.transactions.index') }}" 
                   class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow {{ !request('payment_status') || request('payment_status') === 'all' ? 'ring-2 ring-blue-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Semua</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $paymentStatusCounts['all'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <span class="text-2xl">📋</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'pending']) }}" 
                   class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-orange-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'pending' ? 'ring-2 ring-orange-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $paymentStatusCounts['pending'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <span class="text-2xl">⏳</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'paid']) }}" 
                   class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'paid' ? 'ring-2 ring-green-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Paid</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $paymentStatusCounts['paid'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <span class="text-2xl">💰</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'failed']) }}" 
                   class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'failed' ? 'ring-2 ring-red-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Failed</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $paymentStatusCounts['failed'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-red-100 rounded-lg">
                            <span class="text-2xl">❌</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'cancelled']) }}" 
                   class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'cancelled' ? 'ring-2 ring-gray-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Cancelled</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $paymentStatusCounts['cancelled'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <span class="text-2xl">🚫</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Shipping Status Filter Cards -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Filter Status Pengiriman</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <a href="{{ route('eksportir.transactions.index') }}" 
               class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow {{ !request('shipping_status') || request('shipping_status') === 'all' ? 'ring-2 ring-blue-200' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Semua</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $shippingStatusCounts['all'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <span class="text-2xl">📦</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'processing']) }}" 
               class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'processing' ? 'ring-2 ring-yellow-200' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Diproses</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $shippingStatusCounts['processing'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <span class="text-2xl">🔄</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'shipped']) }}" 
               class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'shipped' ? 'ring-2 ring-purple-200' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dikirim</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $shippingStatusCounts['shipped'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <span class="text-2xl">🚚</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'in_transit']) }}" 
               class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-indigo-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'in_transit' ? 'ring-2 ring-indigo-200' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dalam Perjalanan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $shippingStatusCounts['in_transit'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <span class="text-2xl">🌊</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'delivered']) }}" 
               class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'delivered' ? 'ring-2 ring-green-200' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Terkirim</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $shippingStatusCounts['delivered'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-green-100 rounded-lg">
                        <span class="text-2xl">✅</span>
                    </div>
                </div>
            </a>
        </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan Order ID atau nama customer..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                    @if(request()->hasAny(['search', 'shipping_status']))
                        <a href="{{ route('eksportir.transactions.index') }}" 
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
                <!-- Keep shipping_status and payment_status filter -->
                @if(request('shipping_status'))
                    <input type="hidden" name="shipping_status" value="{{ request('shipping_status') }}">
                @endif
                @if(request('payment_status'))
                    <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
                @endif
            </form>
        </div>

        <!-- Orders Table -->
        @if($orders->count() > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pengiriman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                @php
                                    // Only show if this order contains eksportir's products
                                    $eksportir = Auth::user();
                                    $productIds = \App\Models\Product::where('user_id', $eksportir->user_id)->pluck('product_id')->toArray();
                                    $hasEksportirProducts = false;
                                    
                                    if ($order->cart_items && is_array($order->cart_items)) {
                                        foreach ($order->cart_items as $item) {
                                            if (isset($item['product_id']) && in_array($item['product_id'], $productIds)) {
                                                $hasEksportirProducts = true;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if($hasEksportirProducts)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#{{ $order->order_id }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->invoice_code ?? 'INV' . $order->order_id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $order->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->currency }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $paymentStatusColors = [
                                                    'pending' => 'bg-orange-100 text-orange-800 border-orange-300',
                                                    'paid' => 'bg-green-100 text-green-800 border-green-300',
                                                    'failed' => 'bg-red-100 text-red-800 border-red-300',
                                                    'cancelled' => 'bg-gray-100 text-gray-800 border-gray-300',
                                                ];
                                                $paymentStatusLabels = [
                                                    'pending' => 'Pending',
                                                    'paid' => 'Paid',
                                                    'failed' => 'Failed',
                                                    'cancelled' => 'Cancelled',
                                                ];
                                                $paymentStatusIcons = [
                                                    'pending' => '⏳',
                                                    'paid' => '💰',
                                                    'failed' => '❌',
                                                    'cancelled' => '🚫',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $paymentStatusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $paymentStatusIcons[$order->status] ?? '❓' }} {{ $paymentStatusLabels[$order->status] ?? ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $shippingStatusColors = [
                                                    'processing' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                                                    'in_transit' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                                    'delivered' => 'bg-green-100 text-green-800 border-green-300',
                                                ];
                                                $shippingStatusLabels = [
                                                    'processing' => 'Diproses',
                                                    'shipped' => 'Dikirim',
                                                    'in_transit' => 'Dalam Perjalanan',
                                                    'delivered' => 'Terkirim',
                                                ];
                                                $shippingStatusIcons = [
                                                    'processing' => '🔄',
                                                    'shipped' => '🚚',
                                                    'in_transit' => '🌊',
                                                    'delivered' => '✅',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $shippingStatusColors[$order->shipping_status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $shippingStatusIcons[$order->shipping_status] ?? '📦' }} {{ $shippingStatusLabels[$order->shipping_status] ?? ucfirst($order->shipping_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('eksportir.transactions.show', $order->order_id) }}" 
                                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                                        Detail
                                                    </a>
                                                </div>
                                                @if($order->status === 'pending')
                                                    <button onclick="updatePaymentStatus('{{ $order->order_id }}', 'paid')" 
                                                            class="text-xs bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition-colors">
                                                        Mark as Paid
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 text-lg mb-4">
                    @if(request('search'))
                        Tidak ada transaksi yang ditemukan untuk pencarian "{{ request('search') }}".
                    @elseif(request('shipping_status'))
                        Tidak ada transaksi dengan status "{{ request('shipping_status') }}".
                    @else
                        Belum ada transaksi untuk produk Anda.
                    @endif
                </div>
                <p class="text-gray-400">Transaksi akan muncul di sini setelah importir membeli produk Anda.</p>
            </div>
        @endif
    </div>

    <script>
        function updatePaymentStatus(orderId, status) {
            const statusLabels = {
                'paid': 'Paid (Lunas)',
                'failed': 'Failed (Gagal)',
                'cancelled': 'Cancelled (Dibatalkan)'
            };
            
            Swal.fire({
                title: 'Konfirmasi Update Status Pembayaran',
                text: `Apakah Anda yakin ingin mengubah status pembayaran menjadi "${statusLabels[status]}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Update',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    executePaymentStatusUpdate(orderId, status);
                }
            });
        }
        
        function executePaymentStatusUpdate(orderId, status) {
            fetch(`/eksportir/transactions/${orderId}/update-payment-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    payment_status: status,
                    reason: `Status updated by eksportir from transaction management page`
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reload page to show updated status
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat memperbarui status pembayaran.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada sistem.'
                });
            });
        }
    </script>
</body>
</html>
