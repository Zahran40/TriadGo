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
    @include('layouts.navbarekspor')

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('eksportir.transactions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Kelola Transaksi
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
            </div>
            <div class="mt-4 lg:mt-0 flex space-x-3">
                <a href="{{ route('transactions.tracking', $order->order_id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    🚢 Lacak Pengiriman
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Update Shipping Status -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Update Status Pengiriman
                    </h2>
                    
                    <div class="mb-4">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="text-sm font-medium text-gray-600">Status Saat Ini:</span>
                            @php
                                $shippingStatusColors = [
                                    'processing' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                                    'in_transit' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                    'delivered' => 'bg-green-100 text-green-800 border-green-300',
                                ];
                                $shippingStatusLabels = [
                                    'processing' => 'Sedang Diproses',
                                    'shipped' => 'Telah Dikirim',
                                    'in_transit' => 'Dalam Perjalanan',
                                    'delivered' => 'Telah Diterima',
                                ];
                                $shippingStatusIcons = [
                                    'processing' => '🔄',
                                    'shipped' => '🚚',
                                    'in_transit' => '🌊',
                                    'delivered' => '✅',
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full border {{ $shippingStatusColors[$order->shipping_status] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
                                {{ $shippingStatusIcons[$order->shipping_status] ?? '📦' }} {{ $shippingStatusLabels[$order->shipping_status] ?? ucfirst($order->shipping_status) }}
                            </span>
                        </div>
                    </div>

                    <form id="updateShippingStatusForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="shipping_status" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                            <select id="shipping_status" name="shipping_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Status Baru</option>
                                <option value="processing" {{ $order->shipping_status === 'processing' ? 'disabled' : '' }}>🔄 Sedang Diproses</option>
                                <option value="shipped" {{ $order->shipping_status === 'shipped' ? 'disabled' : '' }}>🚚 Telah Dikirim</option>
                                <option value="in_transit" {{ $order->shipping_status === 'in_transit' ? 'disabled' : '' }}>🌊 Dalam Perjalanan</option>
                                <option value="delivered" {{ $order->shipping_status === 'delivered' ? 'disabled' : '' }}>✅ Telah Diterima</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                            <textarea id="reason" name="reason" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Tambahkan keterangan perubahan status..."></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Update Status Pengiriman
                        </button>
                    </form>
                </div>

                <!-- Your Products in this Order -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk Anda dalam Pesanan Ini
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($eksportirItems as $item)
                            <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border">
                                @if(isset($item['product_image']) && $item['product_image'])
                                    <img src="{{ asset('uploads/' . $item['product_image']) }}" 
                                         alt="{{ $item['product_name'] }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $item['product_name'] }}</h3>
                                    <p class="text-sm text-gray-600">Jumlah: {{ $item['quantity'] }}</p>
                                    @if(isset($item['weight']))
                                        <p class="text-sm text-gray-600">Berat: {{ $item['weight'] }} kg</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                    <p class="text-sm text-gray-600">${{ number_format($item['price'], 2) }} per item</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Customer
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Nama</p>
                            <p class="text-sm text-gray-900">{{ $order->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Email</p>
                            <p class="text-sm text-gray-900">{{ $order->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Telepon</p>
                            <p class="text-sm text-gray-900">{{ $order->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
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
                        <div>{{ $order->country }}</div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Ringkasan Pesanan
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Order ID</span>
                            <span class="text-sm font-medium text-gray-900">{{ $order->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Invoice</span>
                            <span class="text-sm font-medium text-gray-900">{{ $order->invoice_code ?? 'INV' . $order->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status Pembayaran</span>
                            <span class="text-sm font-medium text-green-600">Lunas</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tanggal Order</span>
                            <span class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('updateShippingStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const status = formData.get('shipping_status');
            const reason = formData.get('reason');
            
            if (!status) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Status',
                    text: 'Silakan pilih status pengiriman baru.'
                });
                return;
            }
            
            // Show confirmation
            const statusLabels = {
                'processing': 'Sedang Diproses 🔄',
                'shipped': 'Telah Dikirim 🚚',
                'in_transit': 'Dalam Perjalanan 🌊',
                'delivered': 'Telah Diterima ✅'
            };
            
            Swal.fire({
                title: 'Konfirmasi Update Status',
                text: `Apakah Anda yakin ingin mengubah status menjadi "${statusLabels[status]}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Update',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateShippingStatus(status, reason);
                }
            });
        });
        
        function updateShippingStatus(status, reason) {
            const orderId = '{{ $order->order_id }}';
            
            fetch(`/eksportir/transactions/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    shipping_status: status,
                    reason: reason
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
                        text: data.message || 'Terjadi kesalahan saat memperbarui status.'
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
