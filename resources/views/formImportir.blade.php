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
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AYpPIo4n7iUjkD_M5bK7Vg_dq4z4v_K5nM3z&currency=USD"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-YOUR_CLIENT_KEY"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
            <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100 mb-8">Checkout</h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary Section -->
                <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div id="cartItemsCheckout" class="space-y-4 mb-6">
                        <!-- Items will be loaded from cart -->
                    </div>
                    
                    <!-- Empty Cart Message -->
                    <div id="emptyCartMessage" class="text-center py-8 hidden">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Your cart is empty</p>
                        <a href="{{ url('/detail') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                            Continue Shopping
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
                    <div class="mt-6 mb-0 pb-0">
                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Coupon Code</label>
                        <div class="flex gap-2">
                            <input type="text" id="couponCode" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter coupon code">
                            <button onclick="applyCoupon()" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition">
                                Apply
                            </button>
                        </div>
                    </div>
                </div> <!-- Penutup card Order Summary dipindahkan ke sini agar card tidak panjang ke bawah -->

                <!-- Payment & Billing Section -->
                <div class="space-y-6">
                    <!-- Billing Information -->
                    <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Billing Information</h2>
                        
                        <form id="checkoutForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">First Name*</label>
                                    <input type="text" id="firstName" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="First name">
                                </div>
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">Last Name*</label>
                                    <input type="text" id="lastName" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Last name">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-blue-900 dark:text-blue-100 mb-2">Email Address*</label>
                                <input type="email" id="email" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="your@email.com">
                            </div>

                            <div class="mb-4">
                                <label class="block text-blue-900 dark:text-blue-100 mb-2">Phone Number*</label>
                                <input type="tel" id="phone" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="+62 812 3456 7890">
                            </div>

                            <div class="mb-4">
                                <label class="block text-blue-900 dark:text-blue-100 mb-2">Address*</label>
                                <textarea id="address" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Street address" rows="3"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">City*</label>
                                    <input type="text" id="city" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="City">
                                </div>
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">State/Province*</label>
                                    <input type="text" id="state" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="State">
                                </div>
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">Postal Code*</label>
                                    <input type="text" id="zipCode" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="12345">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-blue-900 dark:text-blue-100 mb-2">Country*</label>
                                <select id="country" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" onchange="updatePaymentMethods()">
                                    <option value="">Select Country</option>
                                    <option value="ID"> Indonesia</option>
                                    <option value="MY"> Malaysia</option>
                                    <option value="SG"> Singapore</option>
                                    <option value="TH"> Thailand</option>
                                    <option value="PH"> Philippines</option>
                                    <option value="VN"> Vietnam</option>
                                    <option value="BN"> Brunei Darussalam</option>
                                    <option value="LA"> Lao PDR</option>
                                    <option value="KH"> Cambodia</option>
                                    <option value="MM"> Myanmar</option>
                                    <option value="TL"> Timor-Leste</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Methods -->
                    <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Payment Method</h2>                        <!-- Payment Method Selection -->
                        <div class="space-y-4 mb-6" id="paymentMethods">
                            <!-- Midtrans (Indonesia) -->
                            <label class="payment-option custom-radio flex flex-col items-center justify-center min-h-[160px] p-6 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-blue-100 dark:hover:bg-slate-700 transition-all w-full text-center" data-countries="ID">
    <input type="radio" name="paymentMethod" value="midtrans" class="mb-3" id="midtransRadio" />
    <div class="flex flex-col items-center w-full">
        <div class="w-16 h-10 mb-2 bg-white rounded-lg border flex items-center justify-center">
            <svg width="50" height="20" viewBox="0 0 120 48" fill="none">
                <rect width="120" height="48" rx="8" fill="#00AEEF"/>
                <text x="60" y="30" font-family="Arial, sans-serif" font-size="12" font-weight="bold" text-anchor="middle" fill="white">MIDTRANS</text>
            </svg>
        </div>
        <div class="font-semibold text-blue-900 dark:text-blue-100 text-lg">Midtrans Payment</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">Credit Card, Bank Transfer, E-Wallet, QRIS</div>
        <div class="flex flex-wrap gap-2 justify-center mt-2" id="midtransOptions">
            <button type="button" class="midtrans-option px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs font-semibold text-blue-900 dark:text-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400" data-method="credit_card">Credit Card</button>
            <button type="button" class="midtrans-option px-3 py-1 rounded-lg border border-green-400 dark:border-green-600 bg-green-50 dark:bg-green-900 text-xs font-semibold text-green-800 dark:text-green-200 focus:outline-none focus:ring-2 focus:ring-green-400" data-method="gopay">GoPay</button>
            <button type="button" class="midtrans-option px-3 py-1 rounded-lg border border-blue-400 dark:border-blue-600 bg-blue-50 dark:bg-blue-900 text-xs font-semibold text-blue-800 dark:text-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400" data-method="bank_transfer">Bank Transfer</button>
            <button type="button" class="midtrans-option px-3 py-1 rounded-lg border border-purple-400 dark:border-purple-600 bg-purple-50 dark:bg-purple-900 text-xs font-semibold text-purple-800 dark:text-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400" data-method="qris">QRIS</button>
        </div>
        <input type="hidden" name="midtrans_submethod" id="midtransSubmethod" value="" />
        <div id="midtransFormContainer" class="w-full mt-4"></div>
    </div>
</label>

                            <!-- PayPal -->
                            <label class="payment-option custom-radio flex flex-col items-center justify-center min-h-[160px] p-6 border-2 border-blue-300 dark:border-blue-500 rounded-xl cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900/20 transition-all w-full text-center bg-blue-50 dark:bg-blue-900/20" data-countries="all">
    <input type="radio" name="paymentMethod" value="paypal" class="mb-3" />
    <div class="flex flex-col items-center w-full">
        <div class="w-16 h-10 mb-2 bg-white rounded-lg border flex items-center justify-center">
            <svg width="50" height="20" viewBox="0 0 50 20" fill="none">
                <rect width="50" height="20" rx="4" fill="#0070BA"/>
                <text x="25" y="13" font-family="Arial, sans-serif" font-size="8" font-weight="bold" text-anchor="middle" fill="white">PayPal</text>
            </svg>
        </div>
        <div class="font-semibold text-blue-900 dark:text-blue-100 text-lg">PayPal</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">Pay with your PayPal account</div>
        <div class="flex flex-wrap gap-2 justify-center">
            <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded-full">PayPal Balance</span>
            <span class="text-xs bg-yellow-400 text-gray-900 px-2 py-1 rounded-full">Cards</span>
        </div>
    </div>
</label>

                            <!-- Bank Transfer -->
                            <label class="payment-option custom-radio flex flex-col items-center justify-center min-h-[160px] p-6 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800/20 transition-all w-full text-center bg-gray-50 dark:bg-gray-800/20" data-countries="all">
    <input type="radio" name="paymentMethod" value="bank" class="mb-3" />
    <div class="flex flex-col items-center w-full">
        <div class="w-16 h-10 mb-2 bg-white rounded-lg border flex items-center justify-center">
            <img src="https://static.vecteezy.com/system/resources/previews/013/948/616/original/bank-icon-logo-design-vector.jpg" alt="Bank Logo" class="w-8 h-8 object-contain" />
        </div>
        <div class="font-semibold text-blue-900 dark:text-blue-100 text-lg">Bank Transfer</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">Direct bank transfer</div>
        <div class="flex flex-wrap gap-2 justify-center mt-2">
            <div class="w-10 h-5 bg-white rounded border flex items-center justify-center">
                <svg width="24" height="8" viewBox="0 0 30 12" fill="none">
                    <rect width="30" height="12" fill="#2196F3"/>
                    <text x="15" y="8" font-family="Arial, sans-serif" font-size="5" font-weight="bold" text-anchor="middle" fill="white">BCA</text>
                </svg>
            </div>
            <div class="w-12 h-5 bg-white rounded border flex items-center justify-center">
                <svg width="28" height="8" viewBox="0 0 30 12" fill="none">
                    <rect width="30" height="12" fill="#FFD700"/>
                    <text x="15" y="8" font-family="Arial, sans-serif" font-size="3" font-weight="bold" text-anchor="middle" fill="#003876">MANDIRI</text>
                </svg>
            </div>
            <div class="w-12 h-5 bg-white rounded border flex items-center justify-center">
                <svg width="28" height="8" viewBox="0 0 30 12" fill="none">
                    <rect width="30" height="12" fill="#20C997"/>
                    <text x="15" y="8" font-family="Arial, sans-serif" font-size="4" font-weight="bold" text-anchor="middle" fill="white">BSI</text>
                </svg>
            </div>
            <div class="w-12 h-5 bg-white rounded border flex items-center justify-center">
                <svg width="28" height="8" viewBox="0 0 30 12" fill="none">
                    <rect width="30" height="12" fill="#003876"/>
                    <text x="15" y="8" font-family="Arial, sans-serif" font-size="4" font-weight="bold" text-anchor="middle" fill="white">BRI</text>
                </svg>
            </div>
        </div>
    </div>
</label>
                        </div>

                        <!-- Stripe Card Form -->
                        <div id="stripeCardForm" class="space-y-4">
                            <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded-lg">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">Credit Card Information</h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Card Number*</label>
                                        <div id="card-number-element" class="px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                                            <!-- Stripe Elements will create form elements here -->
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-blue-900 dark:text-blue-100 mb-2">Expiry Date*</label>
                                            <div id="card-expiry-element" class="px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                                                <!-- Stripe Elements will create form elements here -->
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-blue-900 dark:text-blue-100 mb-2">CVC*</label>
                                            <div id="card-cvc-element" class="px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                                                <!-- Stripe Elements will create form elements here -->
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Cardholder Name*</label>
                                        <input type="text" id="cardholderName" class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Name on card">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PayPal Button Container -->
                        <div id="paypal-button-container" class="hidden mt-4">
                            <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded-lg">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">PayPal Payment</h4>
                                <div id="paypal-buttons"></div>
                            </div>
                        </div>

                        <!-- Midtrans Info -->
                        <div id="midtransInfo" class="hidden mt-4">
                            <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded-lg">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">Midtrans Payment Options</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border">
                                        <div class="h-8 flex items-center justify-center mb-2">
                                            <svg width="40" height="16" viewBox="0 0 40 16" fill="none">
                                                <rect width="40" height="16" fill="#1A1F71"/>
                                                <text x="20" y="11" font-family="Arial, sans-serif" font-size="8" font-weight="bold" text-anchor="middle" fill="white">VISA</text>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">Credit Card</p>
                                    </div>
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border">
                                        <div class="h-8 bg-green-500 rounded mb-2 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">GoPay</span>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">E-Wallet</p>
                                    </div>
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border">
                                        <div class="h-8 flex items-center justify-center mb-2">
                                            <svg width="40" height="16" viewBox="0 0 40 16" fill="none">
                                                <rect width="40" height="16" fill="#003876"/>
                                                <text x="20" y="11" font-family="Arial, sans-serif" font-size="8" font-weight="bold" text-anchor="middle" fill="white">BCA</text>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">Bank Transfer</p>
                                    </div>
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border">
                                        <div class="h-8 bg-blue-500 rounded mb-2 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">QRIS</span>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">QR Code</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-3 text-center">
                                    Click "Complete Order" to choose your preferred payment method
                                </p>
                            </div>
                        </div>

                        <!-- Bank Transfer Info -->
                        <div id="bankTransferInfo" class="hidden mt-4">
                            <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded-lg">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">Bank Transfer Details</h4>
                                <form id="bankTransferForm">
                                    <h5 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">Choose Destination Bank</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <label class="bank-option flex items-center min-h-[100px] p-4 bg-white dark:bg-gray-800 rounded-lg border-2 border-gray-300 dark:border-gray-600 gap-4 cursor-pointer transition-all hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500">
                                            <input type="radio" name="selectedBank" value="BCA" class="w-5 h-5 text-blue-600 mr-4" required>
                                            <div class="flex flex-col items-center w-full">
                                                <div class="flex items-center mb-2 justify-center w-full">
                                                    <div class="w-16 h-8 rounded flex items-center justify-center" style="background-color: #2196F3;">
                                                        <span class="text-white text-sm font-bold">BCA</span>
                                                    </div>
                                                </div>
                                                <span class="font-medium text-blue-900 dark:text-blue-100 text-center">Bank Central Asia</span>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">Indonesia</span>
                                            </div>
                                        </label>
                                        
                                        <label class="bank-option flex items-center min-h-[100px] p-4 bg-white dark:bg-gray-800 rounded-lg border-2 border-gray-300 dark:border-gray-600 gap-4 cursor-pointer transition-all hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500">
                                            <input type="radio" name="selectedBank" value="Mandiri" class="w-5 h-5 text-yellow-600 mr-4">
                                            <div class="flex flex-col items-center w-full">
                                                <div class="flex items-center mb-2 justify-center w-full">
                                                    <div class="rounded flex items-center justify-center px-3 py-2" style="background-color: #FFD600; width: 90px; height: 32px;">
                                                        <span class="text-blue-900 text-sm font-bold text-center">MANDIRI</span>
                                                    </div>
                                                </div>
                                                <span class="font-medium text-blue-900 dark:text-blue-100 text-center">Bank Mandiri</span>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">Indonesia</span>
                                            </div>
                                        </label>
                                        
                                        <label class="bank-option flex items-center min-h-[100px] p-4 bg-white dark:bg-gray-800 rounded-lg border-2 border-gray-300 dark:border-gray-600 gap-4 cursor-pointer transition-all hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500">
                                            <input type="radio" name="selectedBank" value="BSI" class="w-5 h-5 text-teal-600 mr-4">
                                            <div class="flex flex-col items-center w-full">
                                                <div class="flex items-center mb-2 justify-center w-full">
                                                    <div class="rounded flex items-center justify-center px-4 py-2" style="background-color: #20C997;">
                                                        <span class="text-white text-sm font-bold whitespace-nowrap">BSI</span>
                                                    </div>
                                                </div>
                                                <span class="font-medium text-blue-900 dark:text-blue-100 text-center">Bank Syariah Indonesia</span>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">Indonesia</span>
                                            </div>
                                        </label>
                                        
                                        <label class="bank-option flex items-center min-h-[100px] p-4 bg-white dark:bg-gray-800 rounded-lg border-2 border-gray-300 dark:border-gray-600 gap-4 cursor-pointer transition-all hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500">
                                            <input type="radio" name="selectedBank" value="BRI" class="w-5 h-5 text-blue-900 mr-4">
                                            <div class="flex flex-col items-center w-full">
                                                <div class="flex items-center mb-2 justify-center w-full">
                                                    <div class="rounded flex items-center justify-center px-4 py-2" style="background-color: #003876;">
                                                        <span class="text-white text-sm font-bold whitespace-nowrap">BRI</span>
                                                    </div>
                                                </div>
                                                <span class="font-medium text-blue-900 dark:text-blue-100 text-center">Bank Rakyat Indonesia</span>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 text-center mt-1">Indonesia</span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Selected Bank Transfer Details (will be populated by JavaScript) -->
                                    <div id="bankTransferDetails" class="hidden">
                                        <!-- Bank details will be inserted here by JavaScript -->
                                    </div>
                                </form>
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

                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <label class="flex items-start space-x-3">
                            <input type="checkbox" id="termsAccepted" required class="accent-blue-600 w-5 h-5 rounded focus:ring-2 focus:ring-blue-400">
                            <span class="text-sm text-blue-900 dark:text-blue-100">
                                I agree to the <a href="#" class="text-orange-500 hover:underline font-medium">Terms of Service</a> 
                                and <a href="#" class="text-orange-500 hover:underline font-medium">Privacy Policy</a>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Place Order Button -->
                <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                    <button id="submitPayment" class="w-full px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="buttonText">Complete Order - $300.00</span>
                        <span id="spinner" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 dark:bg-slate-900 text-blue-100 py-6 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p>© 2025 TriadGO. All rights reserved. | Secure payments powered by Stripe, PayPal & Midtrans</p>
        </div>
    </footer>

    <!-- JavaScript Code -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Bank Transfer System
            const bankOptions = document.querySelectorAll('input[name="selectedBank"]');
            const bankTransferDetails = document.getElementById('bankTransferDetails');
            
            // Bank details data
            const bankData = {
                BCA: {
                    name: 'Bank Central Asia (BCA)',
                    accountNumber: '1234567890',
                    accountName: 'TriadGO Indonesia',
                    swiftCode: 'CENAIDJA',
                    logo: '🏦',
                    color: 'blue'
                },
                Mandiri: {
                    name: 'Bank Mandiri',
                    accountNumber: '0987654321',
                    accountName: 'TriadGO Indonesia',
                    swiftCode: 'BMRIIDJA',
                    logo: '🏛️',
                    color: 'yellow'
                },
                BSI: {
                    name: 'Bank Syariah Indonesia (BSI)',
                    accountNumber: '1122334455',
                    accountName: 'TriadGO Indonesia',
                    swiftCode: 'BSYAIDJA',
                    logo: '🕌',
                    color: 'green'
                },
                BRI: {
                    name: 'Bank Rakyat Indonesia (BRI)',
                    accountNumber: '5544332211',
                    accountName: 'TriadGO Indonesia',
                    swiftCode: 'BRINIDJA',
                    logo: '🏢',
                    color: 'red'
                }
            };

            // Setup bank transfer functionality
            function setupBankTransfer() {
                bankOptions.forEach(option => {
                    option.addEventListener('change', function() {
                        if (this.checked) {
                            showBankDetails(this.value);
                        }
                    });
                });
            }

            // Show bank details
            function showBankDetails(bankCode) {
                const bank = bankData[bankCode];
                if (!bank || !bankTransferDetails) return;

                bankTransferDetails.innerHTML = `
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
                        <div class="flex items-center mb-4">
                            <span class="text-3xl mr-3">${bank.logo}</span>
                            <div>
                                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100">${bank.name}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Official TriadGO Account</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Account Number</label>
                                    <p class="text-lg font-mono font-bold text-gray-900 dark:text-white">${bank.accountNumber}</p>
                                </div>
                                <button onclick="copyToClipboard('${bank.accountNumber}')" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors text-sm">
                                    Copy
                                </button>
                            </div>
                            
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Account Name</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${bank.accountName}</p>
                                </div>
                                <button onclick="copyToClipboard('${bank.accountName}')" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors text-sm">
                                    Copy
                                </button>
                            </div>
                            
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Transfer Amount</label>
                                    <p class="text-xl font-bold text-green-600 dark:text-green-400" id="transferAmount">$300.00</p>
                                </div>
                                <button onclick="copyToClipboard('300.00')" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors text-sm">
                                    Copy
                                </button>
                            </div>
                            
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">SWIFT Code</label>
                                    <p class="text-lg font-mono font-semibold text-gray-900 dark:text-white">${bank.swiftCode}</p>
                                </div>
                                <button onclick="copyToClipboard('${bank.swiftCode}')" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors text-sm">
                                    Copy
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg border border-yellow-200 dark:border-yellow-700">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                <strong>Important:</strong> Please include order number <strong>TG-${new Date().toISOString().replace(/[-:.]/g, '').slice(0, 14)}</strong> in your transfer description
                            </p>
                        </div>
                    </div>
                `;
                bankTransferDetails.classList.remove('hidden');
            }

            // Copy to clipboard function
            window.copyToClipboard = function(text) {
                navigator.clipboard.writeText(text).then(function() {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Copied to clipboard successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Copied to clipboard successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            };

            // File upload handling - Removed since receiptUpload element no longer exists

            // Payment method handling
            const paymentOptions = document.querySelectorAll('input[name="paymentMethod"]');
            const bankTransferInfo = document.getElementById('bankTransferInfo');
            const midtransInfo = document.getElementById('midtransInfo');
            const midtransOptions = document.querySelectorAll('.midtrans-option');
            const midtransFormContainer = document.getElementById('midtransFormContainer');

            paymentOptions.forEach(option => {
                option.addEventListener('change', function() {
                    // Hide all forms first
                    if (bankTransferInfo) bankTransferInfo.classList.add('hidden');
                    if (midtransInfo) midtransInfo.classList.add('hidden');
                    if (bankTransferDetails) bankTransferDetails.classList.add('hidden');

                    // Show relevant form
                    if (this.value === 'bank' && bankTransferInfo) {
                        bankTransferInfo.classList.remove('hidden');
                    } else if (this.value === 'midtrans' && midtransInfo) {
                        midtransInfo.classList.remove('hidden');
                    }
                });
            });

            // Midtrans payment options
            midtransOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    midtransOptions.forEach(opt => opt.classList.remove('ring-2', 'ring-blue-500'));
                    // Add active class to selected option
                    this.classList.add('ring-2', 'ring-blue-500');

                    // Show method-specific information
                    if (this.dataset.method === 'gopay') {
                        if (midtransFormContainer) {
                            midtransFormContainer.innerHTML = `<div class='p-4 bg-green-50 dark:bg-green-900 rounded-lg border mt-2 text-center'><span class='text-green-700 dark:text-green-200 font-semibold'>Scan QR with GoPay app after clicking Complete Order.</span></div>`;
                        }
                    } else if (this.dataset.method === 'bank_transfer') {
                        if (midtransFormContainer) {
                            midtransFormContainer.innerHTML = `<div class='p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border mt-2 text-center'><span class='text-blue-700 dark:text-blue-200 font-semibold'>Bank transfer instructions will be shown after clicking Complete Order.</span></div>`;
                        }
                    } else if (this.dataset.method === 'qris') {
                        if (midtransFormContainer) {
                            midtransFormContainer.innerHTML = `<div class='p-4 bg-purple-50 dark:bg-purple-900 rounded-lg border mt-2 text-center'><span class='text-purple-700 dark:text-purple-200 font-semibold'>Scan QRIS code after clicking Complete Order.</span></div>`;
                        }
                    }
                });
            });

            // Form submission
            const submitButton = document.getElementById('submitPayment');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('spinner');

            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Validate terms acceptance
                    const termsAccepted = document.getElementById('termsAccepted');
                    if (!termsAccepted || !termsAccepted.checked) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Terms Required',
                            text: 'Please accept the Terms of Service and Privacy Policy to continue'
                        });
                        return;
                    }

                    // Get selected payment method
                    const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');
                    if (!selectedPayment) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Payment Method Required',
                            text: 'Please select a payment method to continue'
                        });
                        return;
                    }

                    // Additional validation for bank transfer
                    if (selectedPayment.value === 'bank') {
                        const selectedBank = document.querySelector('input[name="selectedBank"]:checked');
                        if (!selectedBank) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Bank Selection Required',
                                text: 'Please select a bank for transfer'
                            });
                            return;
                        }
                    }

                    // Show loading state
                    if (buttonText) buttonText.classList.add('hidden');
                    if (spinner) spinner.classList.remove('hidden');
                    submitButton.disabled = true;

                    // Simulate payment processing
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Placed Successfully!',
                            text: 'Your order has been submitted. You will receive confirmation details shortly.',
                            confirmButtonColor: '#f97316'
                        }).then(() => {
                            // Reset form state
                            if (buttonText) buttonText.classList.remove('hidden');
                            if (spinner) spinner.classList.add('hidden');
                            submitButton.disabled = false;
                        });
                    }, 2000);
                });
            }

            // Initialize bank transfer functionality
            setupBankTransfer();
        });
    </script>
</body>
</html>