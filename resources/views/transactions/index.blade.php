<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Transactions | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Dark Mode Script -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        }
                    }
                },
            },
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .transaction-card {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .transaction-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .dark .transaction-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .dark .transaction-card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }

        .status-badge:hover::before {
            left: 100%;
        }

        .search-input {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .dark .search-input {
            background: rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>

<body class="home-bg min-h-screen dark:bg-slate-900 transition-colors duration-300">
    <!-- Header/Navbar -->
    @include('layouts.navbarimportir')

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8 animate-fade-in">
        <!-- Page Header -->
        <div class="mb-8 animate-slide-up">
            <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100 mb-2 animate-float">
                🛒 Transaction History
            </h1>
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                Track all your import orders and purchase history
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-slide-up">
            <!-- Total Transactions -->
            <div class="transaction-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Transactions</p>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_transactions'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-full">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="transaction-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Spent</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">${{ number_format($stats['total_spent'], 2) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-full">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="transaction-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Orders</p>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['completed_orders'] }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-full">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="transaction-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Orders</p>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['pending_orders'] }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 dark:bg-orange-900/20 rounded-full">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg mb-8 transaction-card animate-slide-up">
            <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Order ID, Product name..."
                           class="search-input w-full px-4 py-3 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="search-input w-full px-4 py-3 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="search-input w-full px-4 py-3 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="search-input w-full px-4 py-3 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Filter Buttons -->
                <div class="md:col-span-2 lg:col-span-4 flex gap-4 mt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>     
                           </div>
            </form>
        </div>

        <!-- Transaction Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 animate-slide-up">
            @forelse($transactions as $transaction)
                <div class="transaction-card bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <!-- Transaction Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $transaction->order_id }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->created_at->format('M d, Y • H:i') }}</p>
                            </div>
                            <div class="status-badge px-3 py-1 rounded-full text-sm font-semibold
                                @if($transaction->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                @elseif($transaction->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                @endif">
                                @if($transaction->status === 'paid') ✅ Paid
                                @elseif($transaction->status === 'pending') ⏳ Pending
                                @elseif($transaction->status === 'failed') ❌ Failed
                                @else 📋 {{ ucfirst($transaction->status) }}
                                @endif
                            </div>
                        </div>

                        <!-- Customer Info -->                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 font-bold">{{ strtoupper(substr($transaction->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $transaction->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Items -->
                    <div class="p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Items ({{ count($transaction->cart_items) }})
                        </h4>
                        
                        <div class="space-y-3 max-h-40 overflow-y-auto">
                            @foreach($transaction->cart_items as $item)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ $item['name'] }}</p>
                                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span>Qty: {{ $item['quantity'] }}</span>
                                            <span>•</span>
                                            <span>${{ number_format($item['price'], 2) }}</span>
                                            @if(isset($item['origin']))
                                                <span>•</span>
                                                <span>{{ $item['origin'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Transaction Summary -->
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="text-gray-900 dark:text-white">${{ number_format($transaction->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                                <span class="text-gray-900 dark:text-white">${{ number_format($transaction->shipping_cost, 2) }}</span>
                            </div>
                            @if($transaction->tax_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                                    <span class="text-gray-900 dark:text-white">${{ number_format($transaction->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($transaction->discount_amount > 0)
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Discount:</span>
                                    <span>-${{ number_format($transaction->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <hr class="border-gray-300 dark:border-gray-600">
                            <div class="flex justify-between font-bold text-lg">
                                <span class="text-gray-900 dark:text-white">Total:</span>
                                <span class="text-blue-600 dark:text-blue-400">${{ number_format($transaction->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-4">
                            <a href="{{ route('transactions.show', $transaction->order_id) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition text-center">
                                View Details
                            </a>
                            @if($transaction->status === 'paid')
                                <a href="{{ route('invoice.show', $transaction->order_id) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                    📄 Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full text-center py-16">
                    <div class="animate-float">
                        <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v4.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-500 dark:text-gray-400 mb-2">No Transactions Found</h3>
                    <p class="text-gray-400 dark:text-gray-500 mb-6">You haven't made any purchases yet.</p>
                    <a href="{{ route('catalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        Start Shopping
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="mt-8 flex justify-center animate-slide-up">
                {{ $transactions->links() }}
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-blue-800 dark:bg-slate-900 text-blue-100 py-12 mt-20">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <img src="{{ asset('tglogo.png') }}" alt="Logo" class="h-12 w-12 mr-3" />
                    <h2 class="text-2xl font-bold">
                        <span class="text-blue-100">Triad</span><span class="text-amber-400">GO</span>
                    </h2>
                </div>
                <p class="text-blue-200 mb-6">Your trusted partner for international trade</p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-blue-200 hover:text-amber-400 transition">Privacy Policy</a>
                    <a href="#" class="text-blue-200 hover:text-amber-400 transition">Terms of Service</a>
                    <a href="#" class="text-blue-200 hover:text-amber-400 transition">Support</a>
                </div>
                <p class="text-blue-300 text-sm mt-6">© 2025 TriadGO. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeThumb = document.getElementById('darkModeThumb');
        const htmlElement = document.documentElement;

        function updateDarkModeSwitch() {
            if (htmlElement.classList.contains('dark')) {
                if (darkModeToggle) darkModeToggle.checked = true;
                if (darkModeThumb) {
                    darkModeThumb.style.transform = 'translateX(1.25rem)';
                    darkModeThumb.style.backgroundColor = '#003355';
                    darkModeThumb.style.borderColor = '#003355';
                }
            } else {
                if (darkModeToggle) darkModeToggle.checked = false;
                if (darkModeThumb) {
                    darkModeThumb.style.transform = 'translateX(0)';
                    darkModeThumb.style.backgroundColor = '#fff';
                    darkModeThumb.style.borderColor = '#ccc';
                }
            }
        }

        // Initialize dark mode
        updateDarkModeSwitch();

        if (darkModeToggle) {
            darkModeToggle.addEventListener('change', () => {
                htmlElement.classList.toggle('dark');
                if (htmlElement.classList.contains('dark')) {
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                }
                updateDarkModeSwitch();
            });
        }

        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-slide-up');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        window.addEventListener('scroll', animateOnScroll);
        document.addEventListener('DOMContentLoaded', animateOnScroll);
    </script>
</body>

</html>