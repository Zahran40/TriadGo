<!DOCTYPE html>
<html lang="en">

<head>
    <!-- SweetAlert2 seperti di importir -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TriadGo - Checkout</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Dark Mode Script - SAMA seperti importir -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    <!-- Payment Gateway Scripts -->
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AYpPIo4n7iUjkD_M5bK7Vg_dq4z4v_K5nM3z&currency=USD"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-YOUR_CLIENT_KEY"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                },
            },
        }
        tailwind.scan()
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
                        <!-- Sample Cart Item -->
                        <div class="flex items-center space-x-4 p-4 bg-white dark:bg-slate-700 rounded-lg">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-2xl">📱</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100">Premium Smartphone</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Electronics • Qty: 1</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-900 dark:text-blue-100">$399.00</p>
                                <p class="text-gray-500 text-sm line-through">$499.00</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-white dark:bg-slate-700 rounded-lg">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-2xl">👕</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100">Premium Cotton Shirt</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Textiles • Qty: 2</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-900 dark:text-blue-100">$118.00</p>
                                <p class="text-gray-500 text-sm">$59.00 each</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Empty Cart Message -->
                    <div id="emptyCartMessage" class="text-center py-8 hidden">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Your cart is empty</p>
                        <a href="{{ route('catalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                            Continue Shopping
                        </a>
                    </div>
                    
                    <!-- Pricing Breakdown -->
                    <div class="space-y-2" id="pricingBreakdown">
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Subtotal:</span>
                            <span class="text-blue-900 dark:text-blue-100" id="subtotal">$517.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Shipping:</span>
                            <span class="text-blue-900 dark:text-blue-100" id="shipping">$25.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-900 dark:text-blue-100">Tax (10%):</span>
                            <span class="text-blue-900 dark:text-blue-100" id="tax">$51.70</span>
                        </div>
                        <div class="border-t border-gray-300 dark:border-gray-600 pt-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span class="text-blue-900 dark:text-blue-100">Total:</span>
                                <span class="text-blue-900 dark:text-blue-100" id="totalAmount">$593.70</span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                <span>≈ <span id="altCurrency">IDR</span> <span id="totalAltCurrency">8,905,500</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Selection -->
                    <div class="mt-4">
                        <label class="block text-blue-900 dark:text-blue-100 mb-2">Currency</label>
                        <select id="currencySelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md" onchange="updateCurrency()">
                            <option value="USD">💵 USD - US Dollar</option>
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
                </div>

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
                                    <option value="ID">🇮🇩 Indonesia</option>
                                    <option value="MY">🇲🇾 Malaysia</option>
                                    <option value="SG">🇸🇬 Singapore</option>
                                    <option value="TH">🇹🇭 Thailand</option>
                                    <option value="PH">🇵🇭 Philippines</option>
                                    <option value="VN">🇻🇳 Vietnam</option>
                                    <option value="BN">🇧🇳 Brunei Darussalam</option>
                                    <option value="LA">🇱🇦 Lao PDR</option>
                                    <option value="KH">🇰🇭 Cambodia</option>
                                    <option value="MM">🇲🇲 Myanmar</option>
                                    <option value="TL">🇹🇱 Timor-Leste</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Methods -->
                    <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Payment Method</h2>

                        <div class="space-y-4">
                            <!-- Credit Card -->
                            <label class="custom-radio flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                <input type="radio" name="paymentMethod" value="card" class="mr-3" checked>
                                <div class="flex items-center space-x-3">
                                    <div class="text-2xl">💳</div>
                                    <div>
                                        <div class="font-semibold text-blue-900 dark:text-blue-100">Credit/Debit Card</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">Visa, MasterCard, American Express</div>
                                    </div>
                                </div>
                            </label>

                            <!-- PayPal -->
                            <label class="custom-radio flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                <input type="radio" name="paymentMethod" value="paypal" class="mr-3">
                                <div class="flex items-center space-x-3">
                                    <div class="text-2xl">🔵</div>
                                    <div>
                                        <div class="font-semibold text-blue-900 dark:text-blue-100">PayPal</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">Pay with your PayPal account</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Bank Transfer (SEPA) -->
                            <label class="custom-radio flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                <input type="radio" name="paymentMethod" value="sepa" class="mr-3">
                                <div class="flex items-center space-x-3">
                                    <div class="text-2xl">🏦</div>
                                    <div>
                                        <div class="font-semibold text-blue-900 dark:text-blue-100">Bank Transfer</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">SEPA direct debit</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Local Payment Methods (Indonesia) -->
                            <div id="localPayments" class="space-y-4">
                                <label class="custom-radio flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                    <input type="radio" name="paymentMethod" value="gopay" class="mr-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-2xl">💚</div>
                                        <div>
                                            <div class="font-semibold text-blue-900 dark:text-blue-100">GoPay</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Indonesian digital wallet</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="custom-radio flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                    <input type="radio" name="paymentMethod" value="ovo" class="mr-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-2xl">🟣</div>
                                        <div>
                                            <div class="font-semibold text-blue-900 dark:text-blue-100">OVO</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Indonesian digital wallet</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="custom-radio flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                    <input type="radio" name="paymentMethod" value="dana" class="mr-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-2xl">🔵</div>
                                        <div>
                                            <div class="font-semibold text-blue-900 dark:text-blue-100">DANA</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Indonesian digital wallet</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Card Details (shown when card is selected) -->
                        <div id="cardDetails" class="mt-6 space-y-4">
                            <div>
                                <label class="block text-blue-900 dark:text-blue-100 mb-2">Card Number*</label>
                                <input type="text" id="cardNumber" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">Expiry Date*</label>
                                    <input type="text" id="cardExpiry" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="MM/YY">
                                </div>
                                <div>
                                    <label class="block text-blue-900 dark:text-blue-100 mb-2">CVV*</label>
                                    <input type="text" id="cardCvv" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="123">
                                </div>
                            </div>
                            <div>
                                <label class="block text-blue-900 dark:text-blue-100 mb-2">Cardholder Name*</label>
                                <input type="text" id="cardName" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary" placeholder="John Doe">
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <div class="export-card bg-blue-50 dark:bg-slate-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="agreeTerms" class="mr-2">
                            <label for="agreeTerms" class="text-sm text-blue-900 dark:text-blue-100">
                                I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <button id="submitPayment" class="w-full px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-400 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="buttonText">Complete Order - $593.70</span>
                            <span id="spinner" class="hidden">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                        
                        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Your payment information is secured with SSL encryption</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 dark:bg-slate-900 text-blue-100 py-6 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="w-8 h-8">
                    <svg viewBox="0 0 120 120" class="w-full h-full">
                        <path d="M20 60 Q40 20, 80 30" stroke="#EEA133" stroke-width="8" fill="none" stroke-linecap="round"/>
                        <g fill="#003355" class="dark:fill-blue-300">
                            <path d="M30 70 L85 70 L90 85 L25 85 Z"/>
                            <rect x="35" y="55" width="15" height="15" rx="2"/>
                            <rect x="38" y="45" width="4" height="10"/>
                            <rect x="43" y="48" width="4" height="7"/>
                            <circle cx="32" cy="77" r="2" fill="white"/>
                            <circle cx="38" cy="77" r="2" fill="white"/>
                            <circle cx="44" cy="77" r="2" fill="white"/>
                        </g>
                        <g fill="#003355" class="dark:fill-blue-300">
                            <ellipse cx="75" cy="35" rx="15" ry="4" transform="rotate(15 75 35)"/>
                            <ellipse cx="70" cy="38" rx="8" ry="3" transform="rotate(15 70 38)"/>
                            <ellipse cx="82" cy="32" rx="6" ry="2" transform="rotate(15 82 32)"/>
                        </g>
                        <path d="M20 90 Q35 85, 50 90 T80 90 T110 90" stroke="#186094" stroke-width="4" fill="none"/>
                        <path d="M15 95 Q30 92, 45 95 T75 95 T105 95" stroke="#186094" stroke-width="3" fill="none" opacity="0.7"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-blue-100">
                    Triad<span class="text-orange-500">GO</span>
                </span>
            </div>
            <p class="text-blue-200">
                © 2024 TriadGO. All rights reserved. | Secure payments powered by Stripe, PayPal & Midtrans
            </p>
        </div>
    </footer>

    <!-- Script LENGKAP - SAMA seperti importir -->
    <script>
        // Dark Mode Toggle - SAMA seperti importir dengan 'enabled'/'disabled'
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

        // Initialize dark mode dari localStorage - SAMA seperti importir
        if (localStorage.getItem('darkMode') === 'enabled') {
            htmlElement.classList.add('dark');
        }

        updateDarkModeSwitch();

        // Toggle event listener - SAMA seperti importir
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

        // Sidebar Mobile
        const sidebar = document.getElementById('mobileSidebar');
        const openSidebarBtn = document.querySelector('button.md\\:hidden[aria-label="Open Menu"]');
        const closeSidebarBtn = document.getElementById('closeSidebar');

        if (openSidebarBtn && closeSidebarBtn) {
            openSidebarBtn.addEventListener('click', function () {
                sidebar.classList.remove('hidden');
            });

            closeSidebarBtn.addEventListener('click', function () {
                sidebar.classList.add('hidden');
            });

            // Tutup sidebar jika klik di luar sidebar
            sidebar.addEventListener('click', function (e) {
                if (e.target === sidebar) {
                    sidebar.classList.add('hidden');
                }
            });
        }

        // SweetAlert2 Logout Desktop
        document.getElementById('logoutBtn')?.addEventListener('click', function (e) {
            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#eea133',
                confirmButtonText: 'Logout',
                customClass: {
                    popup: 'bg-white dark:bg-red-600',
                    title: 'text-black dark:text-white',
                    content: 'text-black dark:text-white',
                    confirmButton: 'text-white',
                    cancelButton: 'text-white'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });

        // SweetAlert2 Logout Mobile
        document.getElementById('logoutBtnMobile')?.addEventListener('click', function (e) {
            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#eea133',
                confirmButtonText: 'Logout',
                customClass: {
                    popup: 'bg-white dark:bg-red-600',
                    title: 'text-black dark:text-white',
                    content: 'text-black dark:text-white',
                    confirmButton: 'text-white',
                    cancelButton: 'text-white'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });

        // Payment Method Toggle
        const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
        const cardDetails = document.getElementById('cardDetails');

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'card') {
                    cardDetails.style.display = 'block';
                } else {
                    cardDetails.style.display = 'none';
                }
            });
        });

        // Currency Exchange Rates (mock data)
        const exchangeRates = {
            USD: 1,
            IDR: 15000,
            MYR: 4.2,
            SGD: 1.35,
            THB: 33.5,
            PHP: 55.8,
            VND: 24000,
            BND: 1.35,
            LAK: 20000,
            KHR: 4100,
            MMK: 2100
        };

        function updateCurrency() {
            const currencySelect = document.getElementById('currencySelect');
            const selectedCurrency = currencySelect.value;
            const baseAmount = 593.70; // Base amount in USD
            
            const convertedAmount = baseAmount * exchangeRates[selectedCurrency];
            const formattedAmount = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: selectedCurrency,
                minimumFractionDigits: selectedCurrency === 'IDR' || selectedCurrency === 'VND' || selectedCurrency === 'LAK' || selectedCurrency === 'KHR' || selectedCurrency === 'MMK' ? 0 : 2
            }).format(convertedAmount);
            
            document.getElementById('totalAmount').textContent = formattedAmount;
            document.getElementById('buttonText').textContent = `Complete Order - ${formattedAmount}`;
            
            // Update alternative currency display
            if (selectedCurrency !== 'USD') {
                const usdAmount = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(baseAmount);
                document.getElementById('altCurrency').textContent = 'USD';
                document.getElementById('totalAltCurrency').textContent = usdAmount.replace('$', '');
            } else {
                const idrAmount = baseAmount * exchangeRates.IDR;
                document.getElementById('altCurrency').textContent = 'IDR';
                document.getElementById('totalAltCurrency').textContent = idrAmount.toLocaleString();
            }
        }

        function applyCoupon() {
            const couponCode = document.getElementById('couponCode').value.trim();
            if (couponCode === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Coupon',
                    text: 'Please enter a coupon code.',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800',
                        title: 'text-black dark:text-white',
                        content: 'text-black dark:text-white'
                    }
                });
                return;
            }

            // Mock coupon validation
            const validCoupons = {
                'SAVE10': 0.1,
                'WELCOME20': 0.2,
                'NEWUSER15': 0.15
            };

            if (validCoupons[couponCode.toUpperCase()]) {
                const discount = validCoupons[couponCode.toUpperCase()];
                Swal.fire({
                    icon: 'success',
                    title: 'Coupon Applied!',
                    text: `You saved ${(discount * 100).toFixed(0)}% on your order!`,
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800',
                        title: 'text-black dark:text-white',
                        content: 'text-black dark:text-white'
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Coupon',
                    text: 'The coupon code you entered is not valid.',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800',
                        title: 'text-black dark:text-white',
                        content: 'text-black dark:text-white'
                    }
                });
            }
        }

        function updatePaymentMethods() {
            const country = document.getElementById('country').value;
            const localPayments = document.getElementById('localPayments');
            
            // Show/hide local payment methods based on country
            if (country === 'ID') {
                localPayments.style.display = 'block';
            } else {
                localPayments.style.display = 'none';
                // Reset to card payment if local payment was selected
                const cardPayment = document.querySelector('input[value="card"]');
                if (cardPayment) cardPayment.checked = true;
                cardDetails.style.display = 'block';
            }
        }

        // Form Submission
        document.getElementById('submitPayment').addEventListener('click', function(e) {
            e.preventDefault();
            
            const agreeTerms = document.getElementById('agreeTerms');
            if (!agreeTerms.checked) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Terms Required',
                    text: 'Please agree to the Terms of Service and Privacy Policy to continue.',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800',
                        title: 'text-black dark:text-white',
                        content: 'text-black dark:text-white'
                    }
                });
                return;
            }

            // Show loading
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('spinner');
            const submitBtn = document.getElementById('submitPayment');
            
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');
            submitBtn.disabled = true;

            // Simulate payment processing
            setTimeout(() => {
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
                submitBtn.disabled = false;

                Swal.fire({
                    icon: 'success',
                    title: 'Order Placed Successfully!',
                    text: 'Thank you for your order. You will receive a confirmation email shortly.',
                    confirmButtonText: 'View Order',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800',
                        title: 'text-black dark:text-white',
                        content: 'text-black dark:text-white'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to order confirmation or invoice page
                        window.location.href = '{{ route("invoice") }}';
                    }
                });
            }, 3000);
        });

        // Initialize
        updateCurrency();
        updatePaymentMethods();
    </script>
</body>

</html>