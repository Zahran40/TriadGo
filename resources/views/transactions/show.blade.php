<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaction {{ $transaction->order_id }} | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>

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
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
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

        .detail-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .dark .detail-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>

<body class="home-bg min-h-screen dark:bg-slate-900 transition-colors duration-300">
    <!-- Header/Navbar -->
    @include('layouts.navbarimportir')

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8 animate-fade-in">
        <!-- Status Message -->
        @if(isset($statusMessage))
            <div class="mb-6 animate-slide-up">
                <div class="px-4 py-3 rounded-lg border-l-4 
                    @if($statusType === 'info') bg-blue-50 border-blue-400 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300
                    @elseif($statusType === 'error') bg-red-50 border-red-400 text-red-700 dark:bg-red-900/20 dark:text-red-300
                    @elseif($statusType === 'warning') bg-yellow-50 border-yellow-400 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-300
                    @endif">
                    <div class="flex items-center">
                        @if($statusType === 'info')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($statusType === 'error')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($statusType === 'warning')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        <span class="font-medium">{{ $statusMessage }}</span>
                    </div>
                </div>
            </div>
        @endif
        <!-- Back Button -->
        <div class="mb-6 animate-slide-up">
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Transactions
            </a>
        </div>

        <!-- Transaction Header -->
        <div class="detail-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg mb-8 animate-slide-up">
            <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $transaction->order_id }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">Order placed on {{ $transaction->created_at->format('F d, Y \a\t H:i') }}</p>
                    @if($transaction->payment_completed_at)
                        <p class="text-green-600 dark:text-green-400">Paid on {{ $transaction->payment_completed_at->format('F d, Y \a\t H:i') }}</p>
                    @endif
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Status Badge -->
                    <div class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($transaction->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                        @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                        @elseif($transaction->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                        @endif">
                        @if($transaction->status === 'paid') ✅ Paid
                        @elseif($transaction->status === 'pending') ⏳ Pending Payment
                        @elseif($transaction->status === 'failed') ❌ Payment Failed
                        @else 📋 {{ ucfirst($transaction->status) }}
                        @endif
                    </div>
                    
                    @if($transaction->status === 'paid')
                        <a href="{{ route('invoice.show', $transaction->order_id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            📄 Download Invoice
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="detail-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg animate-slide-up">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Order Items ({{ count($transaction->cart_items) }})
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($transaction->cart_items as $item)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">{{ $item['name'] }}</h3>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span>SKU: {{ $item['sku'] ?? 'N/A' }}</span>
                                        @if(isset($item['origin']))
                                            <span>Origin: {{ $item['origin'] }}</span>
                                        @endif
                                        @if(isset($item['weight']))
                                            <span>Weight: {{ $item['weight'] }}kg</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $item['quantity'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Unit Price: ${{ number_format($item['price'], 2) }}</p>
                                    <p class="font-bold text-lg text-blue-600 dark:text-blue-400">
                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary & Customer Info -->
            <div class="space-y-8">
                <!-- Customer Information -->
                <div class="detail-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate-slide-up">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Customer Information
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Name:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-white">{{ $transaction->full_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-white">{{ $transaction->email }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-white">{{ $transaction->phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="detail-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate-slide-up">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Shipping Address
                    </h3>
                    
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        <p>{{ $transaction->address }}</p>
                        <p>{{ $transaction->city }}, {{ $transaction->state }} {{ $transaction->zip_code }}</p>
                        <p>{{ $transaction->country }}</p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="detail-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate-slide-up">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Order Summary
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($transaction->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($transaction->shipping_cost, 2) }}</span>
                        </div>
                        @if($transaction->tax_amount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($transaction->tax_amount, 2) }}</span>
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
                </div>

                @if($transaction->payment_details)
                    <!-- Payment Details -->
                    <div class="detail-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate-slide-up">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Payment Details
                        </h3>
                        
                        <div class="space-y-2 text-sm">
                            @if(isset($transaction->payment_details['transaction_id']))
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Transaction ID:</span>
                                    <span class="font-medium text-gray-900 dark:text-white font-mono">{{ $transaction->payment_details['transaction_id'] }}</span>
                                </div>
                            @endif
                            @if(isset($transaction->payment_details['payment_type']))
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($transaction->payment_details['payment_type']) }}</span>
                                </div>
                            @endif
                            @if(isset($transaction->payment_details['transaction_time']))
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Payment Time:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->payment_details['transaction_time'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
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
                <p class="text-blue-300 text-sm">© 2025 TriadGO. All rights reserved.</p>
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
    </script>
</body>

</html>