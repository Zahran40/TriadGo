@extends('layouts.app')

@section('title', 'Daftar TransAction')

@section('content')
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
        /* SweetAlert2 Dark Mode Fix*/
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
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-800">Transaction List</h1>
            <p class="text-blue-600 mt-2">Manage and monitor all your orders</p>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-blue-500">Total: {{ $statusCounts['all'] }} order</span>
        </div>
    </div>

    <!-- Status Filter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
        <a href="{{ route('transactions.index') }}" 
           class="product p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'all' || !request('status') ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-800">{{ $statusCounts['all'] }}</div>
                <div class="text-sm text-blue-600">All</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" 
           class="product p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'pending' ? 'border-orange-500' : 'border-gray-200' }} hover:border-orange-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $statusCounts['pending'] }}</div>
                <div class="text-sm text-blue-600">Pending</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'paid']) }}" 
           class="product p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'paid' ? 'border-green-500' : 'border-gray-200' }} hover:border-green-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $statusCounts['paid'] }}</div>
                <div class="text-sm text-blue-600">Paid</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'failed']) }}" 
           class="product p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'failed' ? 'border-red-500' : 'border-gray-200' }} hover:border-red-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $statusCounts['failed'] }}</div>
                <div class="text-sm text-blue-600">Failed</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'cancelled']) }}" 
           class="product p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'cancelled' ? 'border-gray-500' : 'border-gray-200' }} hover:border-gray-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $statusCounts['cancelled'] }}</div>
                <div class="text-sm text-blue-600">Canceled</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'expired']) }}" 
           class="product p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'expired' ? 'border-purple-500' : 'border-gray-200' }} hover:border-purple-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $statusCounts['expired'] }}</div>
                <div class="text-sm text-blue-600">Expired</div>
            </div>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col md:flex-row gap-4">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by Order ID or Customer Name..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Cari
                </button>
                <a href="{{ route('transactions.index') }}" 
                   class="product text-blue-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class=" rounded-lg shadow-sm overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="product">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                Order Code
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                Payment
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class=" divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-900">{{ $order->order_id }}</div>
                                <div class="text-sm text-blue-500">{{ count($order->cart_items) }} item</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-blue-900">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-sm text-blue-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-900">{{ $order->formatted_total }}</div>
                                <div class="text-sm text-blue-500">{{ $order->currency }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        'cancelled' => 'bg-gray-100 text-blue-800',
                                        'expired' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'failed' => 'Failed',
                                        'cancelled' => 'Canceled',
                                        'expired' => 'Expired'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-blue-800' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-blue-900">{{ ucfirst($order->payment_method) }}</div>
                                @if($order->payment_completed_at)
                                    <div class="text-sm text-blue-500">{{ $order->payment_completed_at->format('d M Y H:i') }}</div>
                                @else
                                    <div class="text-sm text-blue-500">Pending</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('transactions.show', $order->order_id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                        Detail
                                    </a>
                                    @if($order->status === 'paid')
                                        <a href="{{ route('transactions.invoice', $order->order_id) }}" 
                                           class="text-green-600 hover:text-green-900 transition-colors">
                                            Invoice
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class=" px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-blue-500 text-lg mb-4">
                    @if(request('search'))
                        Tidak ada pesanan yang sesuai dengan pencarian "{{ request('search') }}"
                    @elseif(request('status') && request('status') !== 'all')
                        Tidak ada pesanan dengan status "{{ request('status') }}"
                    @else
                        Anda belum memiliki pesanan
                    @endif
                </div>
                <a href="{{ route('catalog') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Mulai Berbelanja
                </a>
            </div>
        @endif
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
@endsection