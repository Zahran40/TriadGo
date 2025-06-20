@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Transaksi</h1>
            <p class="text-gray-600 mt-2">Kelola dan pantau semua pesanan Anda</p>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-500">Total: {{ $statusCounts['all'] }} pesanan</span>
        </div>
    </div>

    <!-- Status Filter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
        <a href="{{ route('transactions.index') }}" 
           class="bg-white p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'all' || !request('status') ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-800">{{ $statusCounts['all'] }}</div>
                <div class="text-sm text-gray-600">Semua</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" 
           class="bg-white p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'pending' ? 'border-orange-500' : 'border-gray-200' }} hover:border-orange-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $statusCounts['pending'] }}</div>
                <div class="text-sm text-gray-600">Menunggu</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'paid']) }}" 
           class="bg-white p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'paid' ? 'border-green-500' : 'border-gray-200' }} hover:border-green-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $statusCounts['paid'] }}</div>
                <div class="text-sm text-gray-600">Dibayar</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'failed']) }}" 
           class="bg-white p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'failed' ? 'border-red-500' : 'border-gray-200' }} hover:border-red-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $statusCounts['failed'] }}</div>
                <div class="text-sm text-gray-600">Gagal</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'cancelled']) }}" 
           class="bg-white p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'cancelled' ? 'border-gray-500' : 'border-gray-200' }} hover:border-gray-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-600">{{ $statusCounts['cancelled'] }}</div>
                <div class="text-sm text-gray-600">Dibatalkan</div>
            </div>
        </a>
        
        <a href="{{ route('transactions.index', ['status' => 'expired']) }}" 
           class="bg-white p-4 rounded-lg shadow-sm border-2 {{ request('status') == 'expired' ? 'border-purple-500' : 'border-gray-200' }} hover:border-purple-300 transition-colors">
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $statusCounts['expired'] }}</div>
                <div class="text-sm text-gray-600">Kedaluwarsa</div>
            </div>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col md:flex-row gap-4">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan kode pesanan atau nama..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Cari
                </button>
                <a href="{{ route('transactions.index') }}" 
                   class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode Pesanan
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pembayaran
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $order->order_id }}</div>
                                <div class="text-sm text-gray-500">{{ count($order->cart_items) }} item</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $order->formatted_total }}</div>
                                <div class="text-sm text-gray-500">{{ $order->currency }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        'cancelled' => 'bg-gray-100 text-gray-800',
                                        'expired' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'paid' => 'Dibayar',
                                        'failed' => 'Gagal',
                                        'cancelled' => 'Dibatalkan',
                                        'expired' => 'Kedaluwarsa'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</div>
                                @if($order->payment_completed_at)
                                    <div class="text-sm text-gray-500">{{ $order->payment_completed_at->format('d M Y H:i') }}</div>
                                @else
                                    <div class="text-sm text-gray-500">Belum dibayar</div>
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
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 text-lg mb-4">
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
@endsection