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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                        darkblue: '#1e3a8a',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        }
                    }
                },
            },
        }

        tailwind.scan()
    </script>

    <style>
        /* SweetAlert2 Dark Mode Fix - TAMBAHKAN INI */
        .swal2-popup .swal2-title {
            color: #1f2937 !important;
        }

        .swal2-popup .swal2-html-container {
            color: #374151 !important;
        }

        .swal2-popup.swal2-dark .swal2-title {
            color: #ffffff !important;
        }

        .swal2-popup.swal2-dark .swal2-html-container {
            color: #d1d5db !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('layouts.navbarekspor')

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-blue-800 mb-2">Manage Transactions</h1>
                <p class="text-blue-600">Manage payment and delivery status of products ordered by importers</p>
            </div>
        </div>

        <!-- Payment Status Filter Cards -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-blue-700 mb-4">Filter Payment Status</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <a href="{{ route('eksportir.transactions.index') }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow {{ !request('payment_status') || request('payment_status') === 'all' ? 'ring-2 ring-blue-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">All</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $paymentStatusCounts['all'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <span class="text-2xl">📋</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'pending']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-orange-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'pending' ? 'ring-2 ring-orange-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Pending</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $paymentStatusCounts['pending'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <span class="text-2xl">⏳</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'paid']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'paid' ? 'ring-2 ring-green-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Paid</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $paymentStatusCounts['paid'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <span class="text-2xl">💰</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'failed']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-red-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'failed' ? 'ring-2 ring-red-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Failed</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $paymentStatusCounts['failed'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-red-100 rounded-lg">
                            <span class="text-2xl">❌</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['payment_status' => 'cancelled']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-gray-500 hover:shadow-md transition-shadow {{ request('payment_status') === 'cancelled' ? 'ring-2 ring-gray-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Cancelled</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $paymentStatusCounts['cancelled'] ?? 0 }}</p>
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
            <h3 class="text-lg font-semibold text-blue-700 mb-4">Filter Shipping Status</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <a href="{{ route('eksportir.transactions.index') }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow {{ !request('shipping_status') || request('shipping_status') === 'all' ? 'ring-2 ring-blue-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">All</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $shippingStatusCounts['all'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <span class="text-2xl">📦</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'processing']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-yellow-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'processing' ? 'ring-2 ring-yellow-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Pending</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $shippingStatusCounts['processing'] ?? 0 }}
                            </p>
                        </div>
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <span class="text-2xl">🔄</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'shipped']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-purple-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'shipped' ? 'ring-2 ring-purple-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Sent</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $shippingStatusCounts['shipped'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <span class="text-2xl">🚚</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'in_transit']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-indigo-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'in_transit' ? 'ring-2 ring-indigo-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">On The Way</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $shippingStatusCounts['in_transit'] ?? 0 }}
                            </p>
                        </div>
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <span class="text-2xl">🌊</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('eksportir.transactions.index', ['shipping_status' => 'delivered']) }}"
                    class="product rounded-lg shadow-sm p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow {{ request('shipping_status') === 'delivered' ? 'ring-2 ring-green-200' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Sent</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $shippingStatusCounts['delivered'] ?? 0 }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <span class="text-2xl">✅</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="product rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by Order ID or Customer Name..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                    @if(request()->hasAny(['search', 'shipping_status']))
                        <a href="{{ route('eksportir.transactions.index') }}"
                            class="px-6 py-2 bg-gray-300 text-blue-700 rounded-lg hover:bg-gray-400 transition-colors">
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
            <div class="product rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Payment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Shipping Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <body class="product divide-y divide-gray-200">
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
                                            <div class="text-sm font-medium text-blue-600">#{{ $order->order_id }}</div>
                                            <div class="text-sm text-blue-500">
                                                {{ $order->invoice_code ?? 'INV' . $order->order_id }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-blue-600">{{ $order->name }}</div>
                                            <div class="text-sm text-blue-500">{{ $order->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-blue-600">
                                                ${{ number_format($order->total_amount, 2) }}</div>
                                            <div class="text-sm text-blue-500">{{ $order->currency }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $paymentStatusColors = [
                                                    'pending' => 'bg-orange-100 text-orange-800 border-orange-300',
                                                    'paid' => 'bg-green-100 text-green-800 border-green-300',
                                                    'failed' => 'bg-red-100 text-red-800 border-red-300',
                                                    'cancelled' => 'bg-gray-100 text-blue-800 border-gray-300',
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
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $paymentStatusColors[$order->status] ?? 'bg-gray-100 text-blue-800' }}">
                                                {{ $paymentStatusIcons[$order->status] ?? '❓' }}
                                                {{ $paymentStatusLabels[$order->status] ?? ucfirst($order->status) }}
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
                                                    'processing' => 'Pending',
                                                    'shipped' => 'Sent',
                                                    'in_transit' => 'On The Way',
                                                    'delivered' => 'Sent',
                                                ];
                                                $shippingStatusIcons = [
                                                    'processing' => '🔄',
                                                    'shipped' => '🚚',
                                                    'in_transit' => '🌊',
                                                    'delivered' => '✅',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $shippingStatusColors[$order->shipping_status] ?? 'bg-gray-100 text-blue-800' }}">
                                                {{ $shippingStatusIcons[$order->shipping_status] ?? '📦' }}
                                                {{ $shippingStatusLabels[$order->shipping_status] ?? ucfirst($order->shipping_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('eksportir.transactions.show', $order->order_id) }}"
                                                        class="text-blue-600 hover:text-blue-600 transition-colors">
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
                <div class="product px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-blue-500 text-lg mb-4">
                    @if(request('search'))
                        No Transaction Found "{{ request('search') }}".
                    @elseif(request('shipping_status'))
                        No Transaction With Status "{{ request('shipping_status') }}".
                    @else
                         Your Product
                    @endif
                </div>
                <p class="text-blue-400">Transactions will appear here after the importer purchases your product.</p>
            </div>
        @endif
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

        // SweetAlert2 Logout Desktop
        document.getElementById('logoutBtn')?.addEventListener('click', function (e) {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#eea133',
                confirmButtonText: 'Logout',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });

        // SweetAlert2 Logout Mobile
        document.getElementById('logoutBtnMobile')?.addEventListener('click', function (e) {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#eea133',
                confirmButtonText: 'Logout',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>
</body>

</html>