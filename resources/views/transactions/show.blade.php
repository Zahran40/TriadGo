<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Transaksi - {{ $order->order_id }} | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50">
    @include('layouts.navbarimportir')

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Daftar Transaksi
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500">{{ $order->order_id }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Transaksi</h1>
                <p class="text-gray-600">Kode Pesanan: <span class="font-semibold text-blue-600">{{ $order->order_id }}</span></p>
            </div>            <div class="mt-4 lg:mt-0 flex space-x-3">
                @php
                    // Get current order status from database to ensure freshness
                    $currentOrder = \App\Models\CheckoutOrder::find($order->id);
                    $isPaid = $currentOrder ? $currentOrder->status === 'paid' : $order->status === 'paid';
                @endphp
                @if($isPaid)
                    <a href="{{ route('transactions.tracking', $order->order_id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        🚢 Lacak Pengiriman
                    </a>
                    <a href="{{ route('transactions.invoice', $order->order_id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Invoice
                    </a>
                @else
                    <div class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Menunggu Pembayaran
                    </div>
                @endif
                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-sm no-print">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status Pesanan
                    </h2>
                    <div class="flex items-center justify-between">                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                    'paid' => 'bg-green-100 text-green-800 border-green-300',
                                    'failed' => 'bg-red-100 text-red-800 border-red-300',
                                    'cancelled' => 'bg-gray-100 text-gray-800 border-gray-300',
                                    'expired' => 'bg-purple-100 text-purple-800 border-purple-300',
                                    'refunded' => 'bg-orange-100 text-orange-800 border-orange-300',
                                    'processing' => 'bg-blue-100 text-blue-800 border-blue-300'
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Pembayaran',
                                    'paid' => 'Pembayaran Berhasil',
                                    'failed' => 'Pembayaran Gagal',
                                    'cancelled' => 'Pesanan Dibatalkan',
                                    'expired' => 'Pesanan Kedaluwarsa',
                                    'refunded' => 'Pembayaran Dikembalikan',
                                    'processing' => 'Sedang Diproses'
                                ];
                                $statusIcons = [
                                    'pending' => '⏳',
                                    'paid' => '✅',
                                    'failed' => '❌',
                                    'cancelled' => '🚫',
                                    'expired' => '⏰',
                                    'refunded' => '💰',
                                    'processing' => '🔄'
                                ];
                                
                                // Refresh data dari database untuk memastikan status terbaru
                                $currentOrder = \App\Models\CheckoutOrder::find($order->id);
                                $currentStatus = $currentOrder ? $currentOrder->status : $order->status;
                            @endphp
                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full border {{ $statusColors[$currentStatus] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
                                {{ $statusIcons[$currentStatus] ?? '📄' }} {{ $statusLabels[$currentStatus] ?? ucfirst($currentStatus) }}
                            </span>
                            
                            @if($currentOrder && $currentOrder->shipping_status)
                                @php
                                    $shippingStatusColors = [
                                        'pending' => 'bg-gray-100 text-gray-700 border-gray-300',
                                        'processing' => 'bg-blue-100 text-blue-700 border-blue-300',
                                        'shipped' => 'bg-purple-100 text-purple-700 border-purple-300',
                                        'in_transit' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                                        'delivered' => 'bg-green-100 text-green-700 border-green-300',
                                        'returned' => 'bg-red-100 text-red-700 border-red-300'
                                    ];
                                    $shippingStatusLabels = [
                                        'pending' => 'Belum Diproses',
                                        'processing' => 'Sedang Diproses',
                                        'shipped' => 'Telah Dikirim',
                                        'in_transit' => 'Dalam Perjalanan',
                                        'delivered' => 'Telah Diterima',
                                        'returned' => 'Dikembalikan'
                                    ];
                                    $shippingStatusIcons = [
                                        'pending' => '📦',
                                        'processing' => '🔄',
                                        'shipped' => '🚚',
                                        'in_transit' => '🌊',
                                        'delivered' => '✅',
                                        'returned' => '↩️'
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full border ml-2 {{ $shippingStatusColors[$currentOrder->shipping_status] ?? 'bg-gray-100 text-gray-700 border-gray-300' }}">
                                    {{ $shippingStatusIcons[$currentOrder->shipping_status] ?? '📄' }} {{ $shippingStatusLabels[$currentOrder->shipping_status] ?? ucfirst($currentOrder->shipping_status) }}
                                </span>
                            @endif
                        </div>                        <div class="text-right">
                            <div class="text-sm text-gray-500">Dibuat pada</div>
                            <div class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                            @if($currentOrder && $currentOrder->payment_completed_at)
                                <div class="text-sm text-gray-500 mt-1">Dibayar pada</div>
                                <div class="text-sm font-medium text-green-600">{{ $currentOrder->payment_completed_at->format('d M Y, H:i') }} WIB</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4-8-4m16 0v10l-8 4-8-4V7"></path>
                        </svg>
                        Item Pesanan ({{ count($order->cart_items) }} item)
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->cart_items as $item)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:shadow-sm transition-shadow">
                            @if(isset($item['product_image']) && $item['product_image'])
                                <img src="{{ asset('uploads/' . $item['product_image']) }}" 
                                     alt="{{ $item['product_name'] ?? 'Product' }}" 
                                     class="w-20 h-20 rounded-lg object-cover shadow-sm">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4-8-4m16 0v10l-8 4-8-4V7"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-lg">{{ $item['product_name'] ?? 'Unknown Product' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        ID: {{ $item['product_id'] ?? 'N/A' }}
                                    </span>
                                </p>
                                @if(isset($item['weight']))
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-3m-3 3l-3-3"></path>
                                            </svg>
                                            Berat: {{ $item['weight'] }} kg
                                        </span>
                                    </p>
                                @endif
                            </div>
                            
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Harga Satuan</div>
                                <div class="font-semibold text-gray-900 text-lg">${{ number_format($item['price'] ?? 0, 2) }}</div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Jumlah</div>
                                <div class="font-semibold text-gray-900 text-lg">{{ $item['quantity'] ?? 0 }}</div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Subtotal</div>
                                <div class="font-bold text-blue-600 text-lg">${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                @if($order->payment_details && count($order->payment_details) > 0)
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Informasi Pembayaran
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-500 font-medium">Metode Pembayaran</label>
                                <div class="font-semibold text-gray-900 mt-1">{{ ucfirst($order->payment_method) }}</div>
                            </div>
                            @if(isset($order->payment_details['payment_type']))
                            <div>
                                <label class="text-sm text-gray-500 font-medium">Tipe Pembayaran</label>
                                <div class="font-semibold text-gray-900 mt-1">{{ $order->payment_details['payment_type'] }}</div>
                            </div>
                            @endif
                        </div>
                        <div class="space-y-4">
                            @if($order->payment_gateway_transaction_id)
                            <div>
                                <label class="text-sm text-gray-500 font-medium">ID Transaksi</label>
                                <div class="font-mono text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded border">{{ $order->payment_gateway_transaction_id }}</div>
                            </div>
                            @endif
                            @if(isset($order->payment_details['bank']))
                            <div>
                                <label class="text-sm text-gray-500 font-medium">Bank</label>
                                <div class="font-semibold text-gray-900 mt-1">{{ strtoupper($order->payment_details['bank']) }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pelanggan
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500 font-medium">Nama Lengkap</label>
                            <div class="font-semibold text-gray-900 mt-1">{{ $order->name }}</div>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 font-medium">Email</label>
                            <div class="font-medium text-gray-900 mt-1">{{ $order->email }}</div>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 font-medium">Telepon</label>
                            <div class="font-medium text-gray-900 mt-1">{{ $order->phone }}</div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Pengiriman
                    </h2>
                    <div class="text-gray-900 space-y-1">
                        <div class="font-medium">{{ $order->address }}</div>
                        <div>{{ $order->city }}, {{ $order->state }}</div>
                        <div>{{ $order->zip_code }}</div>
                        <div class="font-medium">{{ $order->country }}</div>
                    </div>
                </div>

                <!-- Order Total -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Ringkasan Pembayaran
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        @if($order->tax_amount > 0)
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Pajak</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        @endif
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium text-red-600">-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        @if($order->coupon_code)
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Kode Kupon</span>
                            <span class="font-medium text-gray-900 bg-green-50 px-2 py-1 rounded text-sm">{{ $order->coupon_code }}</span>
                        </div>
                        @endif
                        <hr class="my-4">
                        <div class="flex justify-between text-xl font-bold bg-blue-50 p-4 rounded-lg">
                            <span class="text-gray-900">Total Pembayaran</span>
                            <span class="text-blue-600">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                @if(isset($order->payment_details['status_changes']) && count($order->payment_details['status_changes']) > 0)
                <!-- Status Change History -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Perubahan Status
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->payment_details['status_changes'] as $change)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                                <div class="flex-shrink-0">
                                    @php
                                        $changeIcon = [
                                            'pending' => '⏳',
                                            'paid' => '✅',
                                            'failed' => '❌',
                                            'cancelled' => '🚫',
                                            'expired' => '⏰',
                                            'refunded' => '💰',
                                            'processing' => '🔄'
                                        ];
                                    @endphp
                                    <span class="text-2xl">{{ $changeIcon[$change['new_status']] ?? '📄' }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-900">
                                            Status berubah dari 
                                            <span class="text-orange-600">{{ ucfirst($change['old_status']) }}</span> 
                                            menjadi 
                                            <span class="text-green-600">{{ ucfirst($change['new_status']) }}</span>
                                        </h4>
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($change['status_changed_at'])->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                    @if(!empty($change['reason']))
                                        <p class="text-sm text-gray-600 mt-1">
                                            <strong>Alasan:</strong> {{ $change['reason'] }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">
                                        Diubah oleh: {{ $change['changed_by'] ?? 'System' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($order->payment_details['shipping_changes']) && count($order->payment_details['shipping_changes']) > 0)
                <!-- Shipping Status Change History -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Status Pengiriman
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->payment_details['shipping_changes'] as $change)
                            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                <div class="flex-shrink-0">
                                    @php
                                        $shippingIcon = [
                                            'pending' => '📦',
                                            'processing' => '🔄',
                                            'shipped' => '🚚',
                                            'in_transit' => '🌊',
                                            'delivered' => '✅',
                                            'returned' => '↩️'
                                        ];
                                    @endphp
                                    <span class="text-2xl">{{ $shippingIcon[$change['new_shipping_status']] ?? '📄' }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-900">
                                            Status pengiriman berubah dari 
                                            <span class="text-orange-600">{{ ucfirst($change['old_shipping_status']) }}</span> 
                                            menjadi 
                                            <span class="text-blue-600">{{ ucfirst($change['new_shipping_status']) }}</span>
                                        </h4>
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($change['shipping_status_changed_at'])->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                    @if(!empty($change['reason']))
                                        <p class="text-sm text-gray-600 mt-1">
                                            <strong>Alasan:</strong> {{ $change['reason'] }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">
                                        Diubah oleh: {{ $change['changed_by'] ?? 'System' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($order->notes)
                <!-- Order Notes -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Catatan Pesanan
                    </h2>
                    <div class="text-gray-900 bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .no-print {
            display: none !important;
        }
        .bg-gray-50 {
            background-color: white !important;
        }
        .shadow-sm {
            box-shadow: none !important;
        }
    }
    </style>

</body>
</html>