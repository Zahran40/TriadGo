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
                    
                    <!-- Product Items -->
                    <div class="space-y-4 mb-6">
                        <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                            <div class="flex items-center space-x-4">
                                <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=150&h=150&fit=crop&crop=center" alt="Premium Coffee Beans" class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-blue-900 dark:text-blue-100">Premium Coffee Beans</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Origin: Indonesia</p>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Weight: 5kg</p>
                                    <div class="flex items-center mt-2">
                                        <label class="text-sm text-blue-900 dark:text-blue-100 mr-2">Qty:</label>
                                        <select class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-2 py-1 text-sm" onchange="updateQuantity(this, 60)">
                                            <option value="1">1</option>
                                            <option value="2" selected>2</option>
                                            <option value="3">3</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-blue-900 dark:text-blue-100">$120.00</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">$60.00 each</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                            <div class="flex items-center space-x-4">
                                <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=150&h=150&fit=crop&crop=center" alt="Organic Spices Set" class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-blue-900 dark:text-blue-100">Organic Spices Set</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Origin: Thailand</p>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Package: Premium Set</p>
                                    <div class="flex items-center mt-2">
                                        <label class="text-sm text-blue-900 dark:text-blue-100 mr-2">Qty:</label>
                                        <select class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-2 py-1 text-sm" onchange="updateQuantity(this, 85)">
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-blue-900 dark:text-blue-100">$85.00</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">$85.00 each</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                            <div class="flex items-center space-x-4">
                                <img src="https://cdnimg.webstaurantstore.com/images/products/large/57498/1963206.jpg" alt="Premium Tea" class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-blue-900 dark:text-blue-100">Premium Green Tea</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Origin: Malaysia</p>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Package: 500g</p>
                                    <div class="flex items-center mt-2">
                                        <label class="text-sm text-blue-900 dark:text-blue-100 mr-2">Qty:</label>
                                        <select class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-2 py-1 text-sm" onchange="updateQuantity(this, 45)">
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-blue-900 dark:text-blue-100">$45.00</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">$45.00 each</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Subtotal:</span>
                            <span class="text-blue-900 dark:text-blue-100" id="subtotal">$250.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Shipping:</span>
                            <span class="text-blue-900 dark:text-blue-100">$25.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Tax (10%):</span>
                            <span class="text-blue-900 dark:text-blue-100" id="tax">$25.00</span>
                        </div>
                        <div class="border-t border-gray-300 dark:border-gray-600 pt-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span class="text-blue-900 dark:text-blue-100">Total:</span>
                                <span class="text-blue-900 dark:text-blue-100" id="totalAmount">$300.00</span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                <span>≈ IDR <span id="totalIDR">4,509,000</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Selection -->
                    <div class="mt-4">
                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Currency</label>
                        <select id="currencySelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md" onchange="updateCurrency()">
                            <option value="USD">🇺🇸 USD - US Dollar</option>
                            <option value="IDR">🇮🇩 IDR - Indonesian Rupiah</option>
                            <option value="MYR">🇲🇾 MYR - Malaysian Ringgit</option>
                            <option value="SGD">🇸🇬 SGD - Singapore Dollar</option>
                            <option value="THB">🇹🇭 THB - Thai Baht</option>
                            <option value="PHP">🇵🇭 PHP - Philippine Peso</option>
                            <option value="VND">🇻🇳 VND - Vietnamese Dong</option>
                            <option value="BND">🇧🇳 BND - Brunei Dollar</option>
                            <option value="LAK">🇱🇦 LAK - Lao Kip</option>
                            <option value="KHR">🇰🇭 KHR - Cambodian Riel</option>
                            <option value="MMK">🇲🇲 MMK - Myanmar Kyat</option>
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
                                    <div class="w-16 h-10 mb-2 bg-gray-100 dark:bg-gray-600 rounded-lg border flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 9.74s9-4.19 9-9.74V7l-10-5z"/>
                                        </svg>
                                    </div>
                                    <div class="font-semibold text-blue-900 dark:text-blue-100 text-lg">Bank Transfer</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">Direct bank transfer</div>
                                    <div class="flex flex-wrap gap-2 justify-center mt-2">
                                        <div class="w-10 h-5 bg-white rounded border flex items-center justify-center">
                                            <svg width="24" height="8" viewBox="0 0 30 12" fill="none">
                                                <rect width="30" height="12" fill="#003876"/>
                                                <text x="15" y="8" font-family="Arial, sans-serif" font-size="5" font-weight="bold" text-anchor="middle" fill="white">BCA</text>
                                            </svg>
                                        </div>
                                        <div class="w-12 h-5 bg-white rounded border flex items-center justify-center">
                                            <svg width="28" height="8" viewBox="0 0 30 12" fill="none">
                                                <rect width="30" height="12" fill="#FFD700"/>
                                                <text x="15" y="8" font-family="Arial, sans-serif" font-size="3" font-weight="bold" text-anchor="middle" fill="#003876">MANDIRI</text>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded border">
                                        <div class="flex items-center mb-2">
                                            <div class="w-12 h-6 mr-2 bg-blue-900 rounded flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">BCA</span>
                                            </div>
                                            <p class="font-medium text-blue-900 dark:text-blue-100">BCA (Indonesia)</p>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <p><strong>Account:</strong> 1234567890</p>
                                            <p><strong>Name:</strong> PT TriadGo Indonesia</p>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded border">
                                        <div class="flex items-center mb-2">
                                            <div class="w-12 h-6 mr-2 bg-yellow-500 rounded flex items-center justify-center">
                                                <span class="text-blue-900 text-xs font-bold">MANDIRI</span>
                                            </div>
                                            <p class="font-medium text-blue-900 dark:text-blue-100">Mandiri (Indonesia)</p>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <p><strong>Account:</strong> 9876543210</p>
                                            <p><strong>Name:</strong> PT TriadGo Indonesia</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900 rounded border border-yellow-200 dark:border-yellow-700">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        <strong>Note:</strong> Please include your order number in the transfer description.
                                    </p>
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

                        <!-- Terms and Conditions -->
                        <div class="mt-6">
                            <label class="flex items-center gap-3">
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
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 dark:bg-slate-900 text-blue-100 py-6 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p>© 2025 TriadGO. All rights reserved. | Secure payments powered by Stripe, PayPal & Midtrans</p>
        </div>
    </footer>

    <!-- JavaScript Code (sama seperti sebelumnya) -->
    <script>
        // Exchange rates for ASEAN countries
        const exchangeRates = {
            USD: 1,
            IDR: 15030,
            MYR: 4.45,
            SGD: 1.35,
            THB: 34.50,
            PHP: 56.20,
            VND: 24450,
            BND: 1.35,
            LAK: 20800,
            KHR: 4100,
            MMK: 2100
        };

        let currentCurrency = 'USD';
        let baseTotal = 300.00;

        // Initialize Stripe
        const stripe = Stripe('pk_test_51234567890');
        const elements = stripe.elements();

        const cardNumber = elements.create('cardNumber');
        const cardExpiry = elements.create('cardExpiry');
        const cardCvc = elements.create('cardCvc');

        cardNumber.mount('#card-number-element');
        cardExpiry.mount('#card-expiry-element');
        cardCvc.mount('#card-cvc-element');

        // Update currency display
        function updateCurrency() {
            const currency = document.getElementById('currencySelect').value;
            currentCurrency = currency;
            const rate = exchangeRates[currency];
            const total = baseTotal * rate;
            
            let formattedTotal;
            if (currency === 'IDR' || currency === 'VND' || currency === 'LAK' || currency === 'KHR' || currency === 'MMK') {
                formattedTotal = `${currency} ${Math.round(total).toLocaleString()}`;
            } else {
                formattedTotal = `${currency} ${total.toFixed(2)}`;
            }
            
            document.getElementById('totalAmount').textContent = formattedTotal;
            document.getElementById('buttonText').textContent = `Complete Order - ${formattedTotal}`;

            const idrTotal = baseTotal * exchangeRates.IDR;
            document.getElementById('totalIDR').textContent = Math.round(idrTotal).toLocaleString('id-ID');
        }

        // Update payment methods based on country
        function updatePaymentMethods() {
            const country = document.getElementById('country').value;
            const paymentOptions = document.querySelectorAll('.payment-option');
            
            paymentOptions.forEach(option => {
                const countries = option.dataset.countries;
                if (countries === 'all' || countries.includes(country)) {
                    option.style.display = 'flex';
                } else {
                    option.style.display = 'none';
                }
            });

            // Auto-select based on country
            if (country === 'ID') {
                document.querySelector('input[value="midtrans"]').checked = true;
                document.querySelector('input[value="midtrans"]').dispatchEvent(new Event('change'));
                document.getElementById('currencySelect').value = 'IDR';
                updateCurrency();
            } else if (country === 'MY') {
                document.getElementById('currencySelect').value = 'MYR';
                updateCurrency();
            } else if (country === 'SG') {
                document.getElementById('currencySelect').value = 'SGD';
                updateCurrency();
            } else if (country === 'TH') {
                document.getElementById('currencySelect').value = 'THB';
                updateCurrency();
            } else if (country === 'PH') {
                document.getElementById('currencySelect').value = 'PHP';
                updateCurrency();
            } else if (country === 'VN') {
                document.getElementById('currencySelect').value = 'VND';
                updateCurrency();
            } else if (country === 'BN') {
                document.getElementById('currencySelect').value = 'BND';
                updateCurrency();
            } else if (country === 'LA') {
                document.getElementById('currencySelect').value = 'LAK';
                updateCurrency();
            } else if (country === 'KH') {
                document.getElementById('currencySelect').value = 'KHR';
                updateCurrency();
            } else if (country === 'MM') {
                document.getElementById('currencySelect').value = 'MMK';
                updateCurrency();
            } else if (country === 'TL') {
                document.getElementById('currencySelect').value = 'USD';
                updateCurrency();
            }
        }

        // Payment method styling
        const paymentRadios = document.querySelectorAll('input[name="paymentMethod"]');
paymentRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove(
                'border-green-400', 'bg-green-50', 'dark:border-green-400', 'dark:bg-green-900/30',
                'border-orange-400', 'bg-orange-50', 'dark:border-orange-500', 'dark:bg-orange-900/20',
                'border-blue-400', 'bg-blue-50', 'dark:border-blue-500', 'dark:bg-blue-900/20',
                'border-gray-400', 'bg-gray-50', 'dark:border-gray-400', 'dark:bg-gray-800/20'
            );
            option.classList.add('border-gray-300', 'dark:border-gray-600');
        });
        const selectedOption = this.closest('.payment-option');
        selectedOption.classList.remove('border-gray-300', 'dark:border-gray-600');
        if (this.value === 'midtrans') {
            selectedOption.classList.add('border-green-400', 'bg-green-50', 'dark:border-green-400', 'dark:bg-green-900/30');
        } else if (this.value === 'stripe') {
            selectedOption.classList.add('border-orange-400', 'bg-orange-50', 'dark:border-orange-500', 'dark:bg-orange-900/20');
        } else if (this.value === 'paypal') {
            selectedOption.classList.add('border-blue-400', 'bg-blue-50', 'dark:border-blue-500', 'dark:bg-blue-900/20');
        } else if (this.value === 'bank') {
            selectedOption.classList.add('border-gray-400', 'bg-gray-50', 'dark:border-gray-400', 'dark:bg-gray-800/20');
        }

        // Show/hide forms
        const forms = ['stripeCardForm', 'paypal-button-container', 'bankTransferInfo', 'midtransInfo'];
        forms.forEach(form => document.getElementById(form)?.classList.add('hidden'));

        if (this.value === 'stripe') {
            document.getElementById('stripeCardForm').classList.remove('hidden');
        } else if (this.value === 'paypal') {
            document.getElementById('paypal-button-container').classList.remove('hidden');
            initializePayPal();
        } else if (this.value === 'bank') {
            document.getElementById('bankTransferInfo').classList.remove('hidden');
        } else if (this.value === 'midtrans') {
            document.getElementById('midtransInfo').classList.remove('hidden');
        }
    });
});

// PayPal initialization
function initializePayPal() {
    document.getElementById('paypal-buttons').innerHTML = '';
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: baseTotal.toString(),
                        currency_code: currentCurrency
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Payment successful!');
                window.location.href = '/order-success';
            });
        }
    }).render('#paypal-buttons');
}

// Payment submission
document.getElementById('submitPayment').addEventListener('click', async function(e) {
    e.preventDefault();
    
    if (!document.getElementById('termsAccepted').checked) {
        alert('Please accept the terms and conditions');
        return;
    }

    const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked').value;
    
    if (selectedPayment === 'stripe') {
        handleStripePayment();
    } else if (selectedPayment === 'midtrans') {
        handleMidtransPayment();
    } else if (selectedPayment === 'bank') {
        handleBankTransfer();
    }
});

function handleStripePayment() {
    alert('Stripe payment processing...');
}

function handleMidtransPayment() {
    alert('Midtrans payment processing...');
}

function handleBankTransfer() {
    const orderNumber = 'TG' + Date.now();
    alert(`Order submitted! Order Number: ${orderNumber}`);
}

function updateQuantity(select, price) {
    console.log('Quantity updated:', select.value, 'Price:', price);
}

function applyCoupon() {
    const couponCode = document.getElementById('couponCode').value;
    if (couponCode === 'TRIAD10') {
        alert('Coupon applied! 10% discount');
        baseTotal = baseTotal * 0.9;
        updateCurrency();
    } else if (couponCode) {
        alert('Invalid coupon code');
    }
}        // Dark Mode functionality
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

        // Check for saved dark mode preference on page load
        if (localStorage.getItem('darkMode') === 'enabled') {
            htmlElement.classList.add('dark');
        }

        updateDarkModeSwitch();

        // Add event listener for dark mode toggle
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

        // Initialize
        document.querySelector('input[name="paymentMethod"][value="stripe"]').dispatchEvent(new Event('change'));
        updateCurrency();

        // Midtrans sub-method interactivity
const midtransOptions = document.querySelectorAll('.midtrans-option');
const midtransFormContainer = document.getElementById('midtransFormContainer');
const midtransSubmethod = document.getElementById('midtransSubmethod');
const midtransRadio = document.getElementById('midtransRadio');

midtransOptions.forEach(btn => {
    btn.addEventListener('click', function() {
        midtransOptions.forEach(b => b.classList.remove('ring-2', 'ring-blue-400', 'ring-green-400', 'ring-purple-400'));
        this.classList.add('ring-2', 'ring-blue-400');
        midtransSubmethod.value = this.dataset.method;
        midtransRadio.checked = true;
        // Show demo form/info for each method
        if (this.dataset.method === 'credit_card') {
            midtransFormContainer.innerHTML = `<div class='p-4 bg-white dark:bg-gray-800 rounded-lg border mt-2'><label class='block text-blue-900 dark:text-blue-100 mb-2'>Card Number*</label><input type='text' class='w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md mb-2' placeholder='Card Number'><label class='block text-blue-900 dark:text-blue-100 mb-2'>Expiry*</label><input type='text' class='w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md mb-2' placeholder='MM/YY'><label class='block text-blue-900 dark:text-blue-100 mb-2'>CVC*</label><input type='text' class='w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md' placeholder='CVC'></div>`;
        } else if (this.dataset.method === 'gopay') {
            midtransFormContainer.innerHTML = `<div class='p-4 bg-green-50 dark:bg-green-900 rounded-lg border mt-2 text-center'><span class='text-green-700 dark:text-green-200 font-semibold'>Scan QR with GoPay app after clicking Complete Order.</span></div>`;
        } else if (this.dataset.method === 'bank_transfer') {
            midtransFormContainer.innerHTML = `<div class='p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border mt-2 text-center'><span class='text-blue-700 dark:text-blue-200 font-semibold'>Bank transfer instructions will be shown after clicking Complete Order.</span></div>`;
        } else if (this.dataset.method === 'qris') {
            midtransFormContainer.innerHTML = `<div class='p-4 bg-purple-50 dark:bg-purple-900 rounded-lg border mt-2 text-center'><span class='text-purple-700 dark:text-purple-200 font-semibold'>Scan QRIS code after clicking Complete Order.</span></div>`;
        }
    });
});
    </script>
</body>
</html>