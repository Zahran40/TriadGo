{{-- filepath: resources/views/formImportir.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TriadGo - Checkout</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Payment Gateway Scripts -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Debug Midtrans Config -->
    <script>
        console.log('Midtrans Client Key:', '{{ config('services.midtrans.client_key') }}');
        console.log('Midtrans Environment:', 'sandbox');
    </script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                        darkblue: '#1e3a8a',
                    }
                },
            },
        }
    </script>

    <style>
        /* Hide default radio */
        .custom-radio input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            background-color: #fff;
            margin: 0;
            font: inherit;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #cbd5e1;
            border-radius: 9999px;
            display: grid;
            place-content: center;
            transition: border-color 0.2s;
            box-shadow: none;
        }
        .dark .custom-radio input[type="radio"] {
            background-color: #1e293b;
            border-color: #334155;
        }
        .custom-radio input[type="radio"]:checked {
            border-color: #2563eb;
            background-color: #2563eb;
        }
        .custom-radio input[type="radio"]:checked::before {
            content: '';
            display: block;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 9999px;
            background: white;
            margin: auto;
        }
        .custom-radio input[type="radio"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px #2563eb33;
        }

        /* Make the dark mode thumb not block pointer events so the toggle is always clickable */
        #darkModeThumb {
            pointer-events: none;
        }

        /* Bank option styling */
        .bank-option {
            transition: all 0.3s ease;
        }
        .bank-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .bank-option input[type="radio"]:checked + div {
            transform: scale(1.02);
        }
        .bank-option input[type="radio"]:checked {
            + div {
                background: linear-gradient(135deg, #ebf4ff 0%, #dbeafe 100%);
            }
        }
        .dark .bank-option input[type="radio"]:checked + div {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        /* Payment option styling */
        .payment-option {
            transition: all 0.3s ease;
            position: relative;
        }
        .payment-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .payment-option input[type="radio"] {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 10;
        }
        .payment-option input[type="radio"]:checked + div {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #2563eb;
        }
        .dark .payment-option input[type="radio"]:checked + div {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        /* Midtrans option styling */
        .midtrans-option {
            transition: all 0.2s ease;
        }
        .midtrans-option:hover {
            transform: scale(1.05);
        }
        .midtrans-option.bg-blue-500 {
            background-color: #3b82f6 !important;
            color: white !important;
            border-color: #3b82f6 !important;
        }

        /* File upload styling */
        #receiptUpload:focus + label {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Loading animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Smooth transitions for currency changes */
        #totalAmount, #totalAltCurrency {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="home-bg min-h-screen flex flex-col dark:bg-slate-900">
    
    @include('layouts.navbarimportir')

    <main class="flex-grow container mx-auto px-4 py-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100">Checkout</h1>
                
                <!-- My Orders & Invoice Access Button -->
                @auth
                <div class="flex gap-3">
                    <a href="{{ route('my.orders') }}" 
                       class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        My Orders
                    </a>
                    
                    @php
                        $paidOrders = \App\Models\CheckoutOrder::where('user_id', Auth::id())
                                                             ->where('status', 'paid')
                                                             ->count();
                    @endphp
                    
                    @if($paidOrders > 0)
                    <a href="{{ route('my.orders') }}" 
                       class="inline-flex items-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-all transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        View Invoices
                        <span class="ml-2 bg-amber-800 text-amber-100 px-2 py-1 text-xs rounded-full">{{ $paidOrders }}</span>
                    </a>
                    @endif
                </div>
                @endauth
            </div>
            
            <!-- Quick Info Panel untuk Orders & Invoices -->
            @auth
            @php
                $userOrders = \App\Models\CheckoutOrder::where('user_id', Auth::id());
                $totalOrders = $userOrders->count();
                $paidOrders = $userOrders->where('status', 'paid')->count();
                $pendingOrders = $userOrders->where('status', 'pending')->count();
            @endphp
            
            @if($totalOrders > 0)
            <div class="bg-gradient-to-r from-blue-50 to-green-50 dark:from-slate-800 dark:to-slate-700 rounded-lg p-4 mb-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-blue-900 dark:text-blue-100 font-semibold">You have {{ $totalOrders }} order(s)</p>
                            <p class="text-blue-700 dark:text-blue-300 text-sm">
                                {{ $paidOrders }} paid, {{ $pendingOrders }} pending
                                @if($paidOrders > 0) • Invoices available @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @if($paidOrders > 0)
                        <a href="{{ route('my.orders') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View Invoices →
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endauth
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary Section -->
                <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div id="cartItemsCheckout" class="space-y-4 mb-6">
                        <!-- Items will be loaded from cart -->
                    </div>
                    
                    <!-- Add More Products Button -->
                    <div id="addMoreProductsBtn" class="mb-6 pt-4 border-t border-gray-300 dark:border-gray-600 text-center hidden">
                        <div class="flex gap-2 justify-center">
                            <a href="{{ url('/catalog') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add More Products
                            </a>
                            <button onclick="loadCartItems()" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Empty Cart Message -->
                    <div id="emptyCartMessage" class="text-center py-8 hidden">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 mb-4 text-lg font-medium">Your cart is empty</p>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 text-sm">Add some products to your cart to continue with checkout</p>
                        <a href="{{ url('/catalog') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Start Shopping
                        </a>
                    </div>
                    
                    <!-- Pricing Breakdown -->
                    <div class="space-y-2" id="pricingBreakdown">
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Subtotal:</span>
                            <span class="text-blue-900 dark:text-blue-100" id="subtotal">$0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Shipping:</span>
                            <span class="text-blue-900 dark:text-blue-100" id="shipping">$25.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Tax (10%):</span>
                            <span class="text-blue-900 dark:text-blue-100" id="tax">$0.00</span>
                        </div>
                        <div class="border-t border-gray-300 dark:border-gray-600 pt-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span class="text-blue-900 dark:text-blue-100">Total:</span>
                                <span class="text-blue-900 dark:text-blue-100" id="totalAmount">$25.00</span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                <span>≈ <span id="altCurrency">IDR</span> <span id="totalAltCurrency">375,750</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Selection -->
                    <div class="mt-4">
                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Currency</label>
                        <select id="currencySelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md" onchange="updateCurrency()">
                            <option value="USD"> USD - US Dollar</option>
                            <option value="IDR"> IDR - Indonesian Rupiah</option>
                            <option value="MYR"> MYR - Malaysian Ringgit</option>
                            <option value="SGD"> SGD - Singapore Dollar</option>
                            <option value="THB"> THB - Thai Baht</option>
                            <option value="PHP"> PHP - Philippine Peso</option>
                            <option value="VND"> VND - Vietnamese Dong</option>
                            <option value="BND"> BND - Brunei Dollar</option>
                            <option value="LAK"> LAK - Lao Kip</option>
                            <option value="KHR"> KHR - Cambodian Riel</option>
                            <option value="MMK"> MMK - Myanmar Kyat</option>
                        </select>
                    </div>

                    <!-- Coupon Code -->
                    <div class="mt-6 mb-4">
                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Coupon Code</label>
                        <div class="flex gap-2">
                            <input type="text" id="couponCode" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter coupon code">
                            <button onclick="applyCoupon()" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition">
                                Apply
                            </button>
                        </div>
                    </div>

                </div> <!-- Penutup card Order Summary -->

                <!-- Payment & Billing Section -->
                <div class="space-y-6">
                    <!-- Billing Information -->
                    <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Billing Information</h2>
                        
                        <form id="checkoutForm">
                            @csrf
                            
                            <!-- User Info (Auto-filled from logged in user) -->
                            @auth
                            <div class="space-y-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <input type="text" 
                                           value="{{ Auth::user()->name }}" 
                                           readonly
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                                    <p class="text-xs text-gray-500 mt-1">From your profile</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" 
                                           value="{{ Auth::user()->email }}" 
                                           readonly
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                                    <p class="text-xs text-gray-500 mt-1">From your profile</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                    <input type="tel" 
                                           value="{{ Auth::user()->phone ?? '' }}" 
                                           readonly
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                                    <p class="text-xs text-gray-500 mt-1">From your profile {{ Auth::user()->phone ? '' : '(Please update your profile)' }}</p>
                                </div>
                            </div>
                            @else
                            <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <p class="text-red-600 dark:text-red-400">Please login to continue with checkout</p>
                                <a href="{{ route('login') }}" class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Login</a>
                            </div>
                            @endauth
                            
                            <!-- Shipping Address -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Shipping Address</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address *</label>
                                    <textarea name="address" 
                                              id="address"
                                              required
                                              rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white"
                                              placeholder="Enter your full address"></textarea>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City *</label>
                                        <input type="text" 
                                               name="city" 
                                               id="city"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white"
                                               placeholder="City">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province *</label>
                                        <input type="text" 
                                               name="state" 
                                               id="state"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white"
                                               placeholder="State/Province">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ZIP/Postal Code *</label>
                                        <input type="text" 
                                               name="zip_code" 
                                               id="zipCode"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white"
                                               placeholder="ZIP/Postal Code">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country *</label>
                                        <select name="country" 
                                                id="country"
                                                required
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white">
                                            <option value="">Select Country</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="SG">Singapore</option>
                                            <option value="TH">Thailand</option>
                                            <option value="PH">Philippines</option>
                                            <option value="VN">Vietnam</option>
                                            <option value="US">United States</option>
                                            <option value="GB">United Kingdom</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Order Notes -->
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order Notes (Optional)</label>
                                <textarea name="notes" 
                                          id="notes"
                                          rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white"
                                          placeholder="Any special instructions for your order..."></textarea>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Methods -->
                    <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Payment Method</h2>
                        
                        <!-- Midtrans Payment Only -->
                        <div class="payment-method-container">
                            <label class="payment-option custom-radio flex flex-col items-center justify-center min-h-[160px] p-6 border-2 border-blue-500 rounded-xl cursor-pointer bg-blue-50 dark:bg-blue-900/30 transition-all w-full text-center">
                                <input type="radio" name="paymentMethod" value="midtrans" class="mb-3" id="midtransRadio" checked />
                                <div class="flex flex-col items-center w-full">
                                    <div class="w-20 h-12 mb-3 bg-white rounded-lg border flex items-center justify-center shadow-sm">
                                        <svg width="60" height="24" viewBox="0 0 120 48" fill="none">
                                            <rect width="120" height="48" rx="8" fill="#00AEEF"/>
                                            <text x="60" y="30" font-family="Arial, sans-serif" font-size="12" font-weight="bold" text-anchor="middle" fill="white">MIDTRANS</text>
                                        </svg>
                                    </div>
                                    <div class="font-semibold text-blue-900 dark:text-blue-100 text-lg">Midtrans Payment Gateway</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 mb-3">Credit Card, Debit, E-Wallet, Bank Transfer, QRIS</div>
                                    <div class="grid grid-cols-4 gap-2 mt-2 w-full max-w-xs">
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">Visa</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">Mastercard</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">GoPay</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">OVO</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">DANA</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">ShopeePay</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">QRIS</div>
                                        <div class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded text-center">Bank</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Payment Info -->
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium">Secure Payment Processing</p>
                                    <p>Your payment is processed securely through Midtrans. You'll be redirected to complete your payment after clicking "Proceed to Payment".</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Features -->
                    <div class="mt-6 p-4 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-700">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-green-800 dark:text-green-200">Your payment information is encrypted and secure</span>
                        </div>
                        <div class="flex items-center mt-2">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-green-800 dark:text-green-200">SSL Certificate • PCI Compliant • 256-bit Encryption</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                    <button type="button" 
                            id="proceedToPaymentBtn" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg text-lg transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span id="paymentBtnText">Proceed to Payment</span>
                        <span id="paymentBtnLoader" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                    
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            By proceeding, you agree to our 
                            <a href="#" class="text-blue-600 hover:text-blue-700">Terms of Service</a> 
                            and 
                            <a href="#" class="text-blue-600 hover:text-blue-700">Privacy Policy</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 dark:bg-slate-900 text-blue-100 py-6 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p>© 2025 TriadGO. All rights reserved. | Secure payments powered by Midtrans</p>
        </div>
    </footer>

    <!-- JavaScript Code -->
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
        // Check if user is authenticated before showing checkout options
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');
            
            // Load cart items immediately when page loads
            @auth
            loadCartItems();
            @endauth
            
            @guest
            // If user is not logged in, disable the checkout form
            const proceedBtn = document.getElementById('proceedToPaymentBtn');
            if (proceedBtn) {
                proceedBtn.disabled = true;
                proceedBtn.innerHTML = '<span class="text-gray-400">Please Login to Continue</span>';
                proceedBtn.onclick = function() {
                    window.location.href = '/login';
                };
            }
            @endguest
        });

        // Cart Management Functions
        function loadCartItems() {
            console.log('Loading cart items...');
            // Load cart from database instead of localStorage
            fetch('/cart', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Cart response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Cart data received:', data);
                if (data.success) {
                    displayCartItems(data.cart_items);
                    updatePricing(data.cart_total);
                } else {
                    console.error('Failed to load cart:', data.message);
                    displayEmptyCart();
                }
            })
            .catch(error => {
                console.error('Error loading cart:', error);
                displayEmptyCart();
            });
        }
        
        function displayCartItems(cartItems) {
            console.log('Displaying cart items:', cartItems);
            const cartItemsContainer = document.getElementById('cartItemsCheckout');
            const emptyCartMessage = document.getElementById('emptyCartMessage');
            const pricingBreakdown = document.getElementById('pricingBreakdown');
            const addMoreProductsBtn = document.getElementById('addMoreProductsBtn');

            console.log('Cart container found:', !!cartItemsContainer);

            if (!cartItems || cartItems.length === 0) {
                console.log('No cart items, displaying empty cart');
                displayEmptyCart();
                return;
            }

            console.log('Found', cartItems.length, 'cart items');

            if (emptyCartMessage) emptyCartMessage.classList.add('hidden');
            if (pricingBreakdown) pricingBreakdown.classList.remove('hidden');
            if (addMoreProductsBtn) addMoreProductsBtn.classList.remove('hidden');

            let cartHTML = '';

            cartItems.forEach((item, index) => {
                console.log('Processing cart item', index, ':', item);
                cartHTML += `
                    <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                        <div class="flex items-center space-x-4">
                            <img src="${item.product.product_image ? '/' + item.product.product_image : 'https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png'}" 
                                 alt="${item.product.product_name}" 
                                 class="w-20 h-20 object-cover rounded-lg shadow-sm">
                            <div class="flex-1">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100">${item.product.product_name}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Origin: ${item.product.country_of_origin}</p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Weight: ${item.product.weight}kg</p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">SKU: ${item.product.product_sku}</p>
                                <div class="flex items-center mt-2">
                                    <label class="text-sm text-blue-900 dark:text-blue-100 mr-2">Qty:</label>
                                    <select class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-2 py-1 text-sm" 
                                            onchange="updateCartItemQuantity(${item.id}, this.value)">
                                        ${generateQuantityOptions(item.quantity)}
                                    </select>
                                    <button onclick="removeCartItem(${item.id})" class="ml-3 text-red-500 hover:text-red-700 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-blue-900 dark:text-blue-100">$${parseFloat(item.total).toFixed(2)}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">$${parseFloat(item.price).toFixed(2)} each</p>
                            </div>
                        </div>
                    </div>
                `;
            });

            console.log('Generated cart HTML:', cartHTML);
            if (cartItemsContainer) {
                console.log('Setting cart HTML to container');
                cartItemsContainer.innerHTML = cartHTML;
            } else {
                console.error('Cart items container not found!');
            }
        }
        
        function displayEmptyCart() {
            const cartItemsContainer = document.getElementById('cartItemsCheckout');
            const emptyCartMessage = document.getElementById('emptyCartMessage');
            const pricingBreakdown = document.getElementById('pricingBreakdown');
            const addMoreProductsBtn = document.getElementById('addMoreProductsBtn');
            
            if (cartItemsContainer) cartItemsContainer.innerHTML = '';
            if (emptyCartMessage) emptyCartMessage.classList.remove('hidden');
            if (pricingBreakdown) pricingBreakdown.classList.add('hidden');
            if (addMoreProductsBtn) addMoreProductsBtn.classList.add('hidden');
            
            // Reset pricing
            updatePricing(0);
        }

        function generateQuantityOptions(currentQty) {
            let options = '';
            for (let i = 1; i <= 10; i++) {
                options += `<option value="${i}" ${i === currentQty ? 'selected' : ''}>${i}</option>`;
            }
            return options;
        }

        function updateCartItemQuantity(cartItemId, newQuantity) {
            fetch(`/cart/${cartItemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quantity: parseInt(newQuantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartItems(); // Reload cart display
                } else {
                    alert(data.message || 'Failed to update cart');
                    loadCartItems(); // Reload to reset the quantity
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                alert('Failed to update cart');
                loadCartItems();
            });
        }

        function removeCartItem(cartItemId) {
            if (confirm('Are you sure you want to remove this item?')) {
                fetch(`/cart/${cartItemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCartItems(); // Reload cart display
                    } else {
                        alert(data.message || 'Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    alert('Failed to remove item');
                });
            }
        }

        function updatePricing(subtotal) {
            const shipping = 25.00;
            const taxRate = 0.10;
            const tax = subtotal * taxRate;
            const total = subtotal + shipping + tax;

            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('shipping').textContent = `$${shipping.toFixed(2)}`;
            document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;
            
            // Update Complete Order button text
            const buttonText = document.getElementById('buttonText');
            if (buttonText) {
                buttonText.textContent = `Complete Order - $${total.toFixed(2)}`;
            }
            
            // Update transfer amount if exists
            const transferAmount = document.getElementById('transferAmount');
            if (transferAmount) {
                transferAmount.textContent = `$${total.toFixed(2)}`;
            }
            
            // Update currency conversions if function exists
            if (typeof updateCurrency === 'function') {
                updateCurrency();
            }
        }

        // Function to update complete order button text
        function updateCompleteOrderButton() {
            const totalElement = document.getElementById('totalAmount');
            const buttonText = document.getElementById('buttonText');
            const transferAmount = document.getElementById('transferAmount');
            
            if (totalElement && buttonText) {
                const total = totalElement.textContent;
                buttonText.textContent = `Complete Order - ${total}`;
                
                if (transferAmount) {
                    transferAmount.textContent = total;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Load cart items on page load
            loadCartItems();
            
            // Listen for cart updates
            window.addEventListener('cartUpdated', function() {
                loadCartItems();
            });
            
            // Listen for storage changes
            window.addEventListener('storage', function(e) {
                if (e.key === 'importCart') {
                    loadCartItems();
                }
            });
            
            // Dark mode functionality
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeThumb = document.getElementById('darkModeThumb');
            const htmlElement = document.documentElement;

            function updateDarkModeSwitch() {
                if (!darkModeToggle || !darkModeThumb) return;
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
                                confirmButtonColor: '#f97316'
                            });
                        }
                    }).render('#paypal-buttons');
                }
            }
            const cardNumberInput = document.getElementById('cardNumber');
            const cardExpiryInput = document.getElementById('cardExpiry');
            const cardCvcInput = document.getElementById('cardCvc');

            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    if (formattedValue.length > 19) formattedValue = formattedValue.substring(0, 19);
                    e.target.value = formattedValue;
                });
            }

            if (cardExpiryInput) {
                cardExpiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

            if (cardCvcInput) {
                cardCvcInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            }

            // Form submission - Updated for new checkout flow
            const proceedToPaymentBtn = document.getElementById('proceedToPaymentBtn');
            const paymentBtnText = document.getElementById('paymentBtnText');
            const paymentBtnLoader = document.getElementById('paymentBtnLoader');

            if (proceedToPaymentBtn) {
                proceedToPaymentBtn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    
                    // Validate cart first by checking database
                    console.log('Validating cart before checkout...');
                    const cartValidation = await validateCartNotEmpty();
                    if (!cartValidation.hasItems) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cart Empty',
                            text: 'Please add items to your cart before proceeding.',
                            confirmButtonColor: '#2563eb'
                        });
                        resetPaymentButton();
                        return;
                    }

                    // Validate required address fields
                    const requiredFields = {
                        'address': 'Address',
                        'city': 'City',
                        'state': 'State/Province',
                        'zipCode': 'ZIP/Postal Code',
                        'country': 'Country'
                    };

                    let missingFields = [];
                    for (const [fieldId, fieldName] of Object.entries(requiredFields)) {
                        const field = document.getElementById(fieldId);
                        if (!field || !field.value.trim()) {
                            missingFields.push(fieldName);
                        }
                    }

                    if (missingFields.length > 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Information',
                            text: `Please fill in the following required fields: ${missingFields.join(', ')}`,
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }

                    // Show loading state
                    paymentBtnText.classList.add('hidden');
                    paymentBtnLoader.classList.remove('hidden');
                    proceedToPaymentBtn.disabled = true;

                    // Process Midtrans payment
                    await processMidtransPayment();
                });
            }

            // Validate cart is not empty
            async function validateCartNotEmpty() {
                try {
                    const response = await fetch('/cart', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const data = await response.json();
                    return {
                        hasItems: data.success && data.cart_items && data.cart_items.length > 0,
                        cartData: data
                    };
                } catch (error) {
                    console.error('Error validating cart:', error);
                    return { hasItems: false, cartData: null };
                }
            }

            // Midtrans payment processing - Updated to use database cart
            async function processMidtransPayment() {
                try {
                    // Get cart data from database
                    console.log('Getting cart data from database...');
                    const cartResponse = await fetch('/cart', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const cartData = await cartResponse.json();
                    if (!cartData.success || !cartData.cart_items || cartData.cart_items.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cart Empty',
                            text: 'Your cart is empty. Please add items before proceeding.',
                            confirmButtonColor: '#2563eb'
                        });
                        resetPaymentButton();
                        return;
                    }

                    console.log('Cart data retrieved:', cartData);

                    // Calculate amounts from database cart
                    const subtotal = cartData.cart_total || 0;
                    const shipping = 25.00;
                    const taxRate = 0.10;
                    const tax = subtotal * taxRate;
                    const discount = 0;
                    const total = subtotal + shipping + tax - discount;

                    // Get form data - user data will be filled from backend (logged in user)
                    const formData = {
                        address: document.getElementById('address').value,
                        city: document.getElementById('city').value,
                        state: document.getElementById('state').value,
                        zip_code: document.getElementById('zipCode').value,
                        country: document.getElementById('country').value,
                        currency: document.getElementById('currencySelect').value || 'USD',
                        coupon_code: document.getElementById('couponCode')?.value || '',
                        discount_amount: discount,
                        notes: document.getElementById('notes')?.value || ''
                };

                // Debug: Log form data before sending
                console.log('Form data before sending:', formData);

                // Call backend to get snap token
                console.log('Sending request to create snap token...');
                fetch('/checkout/create-snap-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success && data.snap_token) {
                        console.log('Opening Midtrans popup with token:', data.snap_token);
                        console.log('Order ID:', data.order_id);
                        
                        // Check if snap is available
                        if (typeof window.snap === 'undefined') {
                            console.error('Midtrans Snap is not loaded!');
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment System Error',
                                text: 'Midtrans payment system is not loaded. Please refresh the page.',
                                confirmButtonColor: '#2563eb'
                            });
                            resetPaymentButton();
                            return;
                        }
                        
                        // Use Midtrans Snap
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                console.log('Payment Success:', result);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful!',
                                    text: 'Your payment has been processed successfully.',
                                    confirmButtonColor: '#2563eb'
                                }).then(() => {
                                    // Cart will be cleared automatically by backend after successful payment
                                    window.location.href = '/checkout/success/' + data.order_id;
                                });
                            },
                            onPending: function(result) {
                                console.log('Payment Pending:', result);
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Payment Pending',
                                    text: 'Please complete your payment.',
                                    confirmButtonColor: '#2563eb'
                                }).then(() => {
                                    window.location.href = '/checkout/pending/' + data.order_id;
                                });
                                resetPaymentButton();
                            },
                            onError: function(result) {
                                console.error('Payment Error:', result);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Payment Failed',
                                    text: 'There was an error processing your payment.',
                                    confirmButtonColor: '#2563eb'
                                }).then(() => {
                                    window.location.href = '/checkout/error/' + data.order_id;
                                });
                                resetPaymentButton();
                            },
                            onClose: function() {
                                console.log('Payment popup closed');
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Payment Cancelled',
                                    text: 'You have cancelled the payment. You can try again anytime.',
                                    confirmButtonColor: '#2563eb'
                                });
                                resetPaymentButton();
                            }
                        });
                    } else {
                        console.error('Backend error:', data);
                        throw new Error(data.message || data.error || 'Failed to get payment token');
                    }
                })
                .catch(error => {
                    console.error('Payment Error Details:', error);
                    
                    let errorMessage = 'Unable to process payment. Please try again.';
                    
                    if (error.message.includes('HTTP error! status: 500')) {
                        errorMessage = 'Server error occurred. Please check the form data and try again.';
                    } else if (error.message.includes('HTTP error! status: 422')) {
                        errorMessage = 'Please check all required fields are filled correctly.';
                    } else if (error.message.includes('login')) {
                        errorMessage = 'Please login first to proceed with checkout.';
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 2000);
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: errorMessage,
                        confirmButtonColor: '#2563eb'
                    });
                    resetPaymentButton();
                });
                
                } catch (error) {
                    console.error('Payment processing error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: 'An error occurred while processing your payment. Please try again.',
                        confirmButtonColor: '#2563eb'
                    });
                    resetPaymentButton();
                }
            }

            // Reset payment button state
            function resetPaymentButton() {
                if (paymentBtnText) paymentBtnText.classList.remove('hidden');
                if (paymentBtnLoader) paymentBtnLoader.classList.add('hidden');
                if (proceedToPaymentBtn) proceedToPaymentBtn.disabled = false;
            }

            // Initialize bank transfer functionality
            setupBankTransfer();
        });

        // Additional Cart and Currency Functions
        function updateCurrency() {
            const currencySelect = document.getElementById('currencySelect');
            const totalAmountElement = document.getElementById('totalAmount');
            
            if (!currencySelect || !totalAmountElement) return;
            
            const selectedCurrency = currencySelect.value;
            const totalInUSD = parseFloat(totalAmountElement.textContent.replace('$', '').replace(',', ''));
            
            // Exchange rates (simplified - in production, use live rates)
            const exchangeRates = {
                'USD': 1,
                'IDR': 15000,
                'MYR': 4.70,
                'SGD': 1.35,
                'THB': 35.50,
                'PHP': 56.00,
                'VND': 24000,
                'BND': 1.35,
                'LAK': 21000,
                'KHR': 4100,
                'MMK': 2100
            };
            
            const convertedAmount = totalInUSD * exchangeRates[selectedCurrency];
            const currencySymbols = {
                'USD': '$',
                'IDR': 'Rp ',
                'MYR': 'RM ',
                'SGD': 'S$',
                'THB': '฿',
                'PHP': '₱',
                'VND': '₫',
                'BND': 'B$',
                'LAK': '₭',
                'KHR': '៛',
                'MMK': 'K'
            };
            
            totalAmountElement.textContent = currencySymbols[selectedCurrency] + convertedAmount.toLocaleString();
        }

        function applyCoupon() {
            const couponCode = document.getElementById('couponCode').value.trim();
            
            if (!couponCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Coupon Required',
                    text: 'Please enter a coupon code'
                });
                return;
            }
            
            // Sample coupon codes (in production, validate with backend)
            const validCoupons = {
                'WELCOME10': { discount: 0.10, type: 'percentage', description: '10% off' },
                'SAVE25': { discount: 25, type: 'fixed', description: '$25 off' },
                'NEWUSER': { discount: 0.15, type: 'percentage', description: '15% off' }
            };
            
            const coupon = validCoupons[couponCode.toUpperCase()];
            
            if (coupon) {
                const subtotalElement = document.getElementById('subtotal');
                const subtotal = parseFloat(subtotalElement.textContent.replace('$', '').replace(',', ''));
                
                let discountAmount = 0;
                if (coupon.type === 'percentage') {
                    discountAmount = subtotal * coupon.discount;
                } else {
                    discountAmount = coupon.discount;
                }
                
                // Apply discount and recalculate
                const newSubtotal = Math.max(0, subtotal - discountAmount);
                subtotalElement.textContent = `$${newSubtotal.toFixed(2)}`;
                
                // Update total
                updatePricing(newSubtotal);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Coupon Applied!',
                    text: `${coupon.description} discount applied successfully`
                });
                
                // Clear coupon input
                document.getElementById('couponCode').value = '';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Coupon',
                    text: 'The coupon code you entered is not valid'
                });
            }
        }
    </script>
</body>
</html>