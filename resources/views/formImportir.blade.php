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
        /* Custom radio styling */
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
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-50 dark:bg-slate-900">
    
    @include('layouts.navbarimportir')

    <main class="flex-grow container mx-auto px-4 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-blue-900 dark:text-blue-100">Checkout</h1>
                <a href="{{ route('catalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">
                    Continue Shopping
                </a>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary Section -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items Container -->
                    <div id="cartItemsContainer" class="space-y-4 mb-6">
                        <!-- Cart items will be loaded here -->
                        <div class="animate-pulse">
                            <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded mb-2"></div>
                            <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-3/4"></div>
                        </div>
                    </div>
                    
                    <!-- Empty Cart Message -->
                    <div id="emptyCartMessage" class="text-center py-8 hidden">
                        <div class="text-6xl mb-4">🛒</div>
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">Your cart is empty</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Add some products to your cart to continue with checkout</p>
                        <a href="{{ route('catalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all">
                            Browse Products
                        </a>
                    </div>
                    
                    <!-- Pricing Breakdown -->
                    <div id="pricingBreakdown" class="border-t border-gray-200 dark:border-gray-600 pt-4 hidden">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 dark:text-gray-300">Subtotal:</span>
                            <span id="subtotalAmount" class="font-semibold text-blue-900 dark:text-blue-100">$0.00</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 dark:text-gray-300">Shipping:</span>
                            <span id="shippingAmount" class="font-semibold text-blue-900 dark:text-blue-100">$25.00</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 dark:text-gray-300">Tax (10%):</span>
                            <span id="taxAmount" class="font-semibold text-blue-900 dark:text-blue-100">$0.00</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-900 dark:text-blue-100">Total:</span>
                                <span id="totalAmount" class="text-lg font-bold text-blue-600 dark:text-blue-400">$25.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billing Information Section -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-6">Billing Information</h2>
                    
                    <form id="checkoutForm" class="space-y-4">
                        <!-- Personal Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" required
                                       class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2"
                                       value="{{ Auth::user()->name ?? '' }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2"
                                       value="{{ Auth::user()->email ?? '' }}">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2"
                                   value="{{ Auth::user()->phone ?? '' }}">
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address *</label>
                            <textarea id="address" name="address" required rows="3"
                                      class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City *</label>
                                <input type="text" id="city" name="city" required
                                       class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province *</label>
                                <input type="text" id="state" name="state" required
                                       class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ZIP/Postal Code *</label>
                                <input type="text" id="zipCode" name="zipCode" required
                                       class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country *</label>
                            <select id="country" name="country" required
                                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2">
                                <option value="">Select Country</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>                        <!-- Payment Method -->
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">Payment Method</h3>
                            
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

                        <!-- Order Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order Notes (Optional)</label>
                            <textarea id="orderNotes" name="orderNotes" rows="3"
                                      class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2"
                                      placeholder="Any special instructions for your order..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" id="proceedToPaymentBtn" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="proceedBtnText">Proceed to Payment</span>
                                <span id="proceedBtnLoader" class="hidden">Processing...</span>
                            </button>
                        </div>
                    </form>
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

    <!-- JavaScript -->
    <script>
        // Global variables
        let cartItems = [];
        let cartTotal = 0;
        let orderData = {};

        // Helper function to get proper product image URL
        function getProductImageUrl(imagePath) {
            if (!imagePath) {
                return 'https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png';
            }
            
            // If it's already a full URL (starts with http/https)
            if (imagePath.startsWith('http')) {
                return imagePath;
            }
            
            // If it already starts with uploads/, don't add it again
            if (imagePath.startsWith('uploads/')) {
                return '/' + imagePath;
            }
            
            // If it already starts with /uploads/, use as is
            if (imagePath.startsWith('/uploads/')) {
                return imagePath;
            }
            
            // Otherwise, assume it's just the filename and add the uploads/products/ path
            return '/uploads/products/' + imagePath;
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Checkout page initialized');
            loadCartItems();
            setupEventHandlers();
        });

        // Load cart items from database
        function loadCartItems() {
            console.log('Loading cart items...');
            
            fetch('/cart', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Cart response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Cart data received:', data);
                if (data.success && data.cart_items) {
                    cartItems = data.cart_items;
                    cartTotal = parseFloat(data.cart_total) || 0;
                    displayCartItems();
                    updatePricing();
                } else {
                    console.log('No cart items found');
                    displayEmptyCart();
                }
            })
            .catch(error => {
                console.error('Error loading cart:', error);
                displayEmptyCart();
            });
        }

        // Display cart items
        function displayCartItems() {
            const container = document.getElementById('cartItemsContainer');
            const emptyMessage = document.getElementById('emptyCartMessage');
            const pricingBreakdown = document.getElementById('pricingBreakdown');
            
            if (!cartItems || cartItems.length === 0) {
                displayEmptyCart();
                return;
            }

            // Hide empty message and show pricing
            emptyMessage.classList.add('hidden');
            pricingBreakdown.classList.remove('hidden');

            let html = '';
            cartItems.forEach((item, index) => {
                const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
                html += `                <div class="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">                    <img src="${getProductImageUrl(item.product.product_image)}" 
                         alt="${item.product.product_name}" 
                         class="w-16 h-16 object-cover rounded-lg shadow-sm"
                         onerror="this.src='https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png'">
                    <div class="flex-1">
                        <h3 class="font-semibold text-blue-900 dark:text-blue-100">${item.product.product_name}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Origin: ${item.product.country_of_origin}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Weight: ${item.product.weight}kg</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">SKU: ${item.product.product_sku}</p>
                        <div class="flex items-center mt-2">
                            <label class="text-sm text-gray-600 dark:text-gray-300 mr-2">Qty:</label>
                            <select class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-2 py-1 text-sm" 
                                    onchange="updateItemQuantity(${item.id}, this.value)">
                                ${generateQuantityOptions(parseInt(item.quantity))}
                            </select>
                            <button onclick="removeCartItem(${item.id})" 
                                    class="ml-3 text-red-500 hover:text-red-700 text-sm">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-blue-900 dark:text-blue-100">$${itemTotal.toFixed(2)}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">$${parseFloat(item.price).toFixed(2)} each</p>
                    </div>
                </div>
                `;
            });

            container.innerHTML = html;
        }

        // Display empty cart
        function displayEmptyCart() {
            document.getElementById('cartItemsContainer').innerHTML = '';
            document.getElementById('emptyCartMessage').classList.remove('hidden');
            document.getElementById('pricingBreakdown').classList.add('hidden');
            document.getElementById('proceedToPaymentBtn').disabled = true;
        }

        // Generate quantity options
        function generateQuantityOptions(currentQty) {
            let options = '';
            for (let i = 1; i <= 10; i++) {
                options += `<option value="${i}" ${i === currentQty ? 'selected' : ''}>${i}</option>`;
            }
            return options;
        }

        // Update item quantity
        function updateItemQuantity(cartItemId, newQuantity) {
            fetch(`/cart/${cartItemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: parseInt(newQuantity) })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartItems(); // Reload to refresh display
                    // Trigger navbar update
                    window.dispatchEvent(new CustomEvent('cartUpdated'));
                } else {
                    alert(data.message || 'Failed to update cart');
                    loadCartItems();
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                loadCartItems();
            });
        }

        // Remove cart item
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
                        loadCartItems(); // Reload to refresh display
                        // Trigger navbar update
                        window.dispatchEvent(new CustomEvent('cartUpdated'));
                    } else {
                        alert(data.message || 'Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                });
            }
        }

        // Update pricing breakdown
        function updatePricing() {
            const subtotal = cartTotal;
            const shipping = subtotal > 0 ? 25.00 : 0;
            const tax = subtotal * 0.10;
            const total = subtotal + shipping + tax;

            document.getElementById('subtotalAmount').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('shippingAmount').textContent = `$${shipping.toFixed(2)}`;
            document.getElementById('taxAmount').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;
            
            // Enable/disable checkout button
            document.getElementById('proceedToPaymentBtn').disabled = subtotal <= 0;
        }

        // Setup event handlers
        function setupEventHandlers() {
            document.getElementById('checkoutForm').addEventListener('submit', handleCheckoutSubmit);
        }

        // Handle checkout form submission
        function handleCheckoutSubmit(e) {
            e.preventDefault();
            
            if (cartItems.length === 0) {
                alert('Your cart is empty');
                return;
            }

            // Gather form data
            const formData = new FormData(e.target);
            const billingData = {
                name: formData.get('fullName'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                city: formData.get('city'),
                state: formData.get('state'),
                zip_code: formData.get('zipCode'),
                country: formData.get('country'),
                payment_method: formData.get('paymentMethod'),
                notes: formData.get('orderNotes')
            };

            // Validate required fields
            const requiredFields = ['name', 'email', 'phone', 'address', 'city', 'state', 'zip_code', 'country'];
            for (let field of requiredFields) {
                if (!billingData[field]) {
                    alert(`Please fill in the ${field.replace('_', ' ')} field`);
                    return;
                }
            }

            // Start checkout process
            processCheckout(billingData);
        }

        // Process checkout
        function processCheckout(billingData) {
            const btn = document.getElementById('proceedToPaymentBtn');
            const btnText = document.getElementById('proceedBtnText');
            const btnLoader = document.getElementById('proceedBtnLoader');
            
            // Show loading state
            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');

            // Calculate totals
            const subtotal = cartTotal;
            const shipping = 25.00;
            const tax = subtotal * 0.10;
            const total = subtotal + shipping + tax;

            // Prepare order data
            orderData = {
                ...billingData,
                cart_items: cartItems,
                subtotal: subtotal,
                shipping_cost: shipping,
                tax_amount: tax,
                total_amount: total,
                currency: 'USD'
            };

            console.log('Processing checkout with data:', orderData);

            // Create order and initiate payment
            fetch('/checkout/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Checkout response:', data);
                
                if (data.success && data.snap_token) {
                    // Use Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            handlePaymentSuccess(result, data.order_id);
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            handlePaymentPending(result, data.order_id);
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            handlePaymentError(result);
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                            resetCheckoutButton();
                        }
                    });
                } else {
                    throw new Error(data.message || 'Failed to create payment');
                }
            })
            .catch(error => {
                console.error('Checkout error:', error);
                alert('Checkout failed: ' + error.message);
                resetCheckoutButton();
            });
        }        // Handle payment success
        function handlePaymentSuccess(result, orderId) {
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: `Your order ${orderId} has been processed successfully.`,
                confirmButtonText: 'View Order Details'
            }).then(() => {
                // Clear cart and redirect to transactions page
                clearCartAndRedirect(orderId);
            });
        }        // Handle payment pending
        function handlePaymentPending(result, orderId) {
            Swal.fire({
                icon: 'info',
                title: 'Payment Pending',
                text: `Your order ${orderId} is being processed. You will receive a confirmation email shortly.`,
                confirmButtonText: 'View Order Status'
            }).then(() => {
                clearCartAndRedirect(orderId);
            });
        }

        // Handle payment error
        function handlePaymentError(result) {
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                text: 'There was an error processing your payment. Please try again.',
                confirmButtonText: 'OK'
            });
            resetCheckoutButton();
        }        // Clear cart and redirect
        function clearCartAndRedirect(orderId = null) {
            console.log('Redirecting with order ID:', orderId);
            
            fetch('/cart', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(() => {
                console.log('Cart cleared successfully');
                if (orderId) {
                    // Redirect to specific order detail page
                    const redirectUrl = `/transactions/${orderId}`;
                    console.log('Redirecting to:', redirectUrl);
                    window.location.href = redirectUrl;
                } else {
                    // Redirect to transactions list page
                    const redirectUrl = '{{ route("transactions.index") }}';
                    console.log('Redirecting to transactions list:', redirectUrl);
                    window.location.href = redirectUrl;
                }
            })
            .catch((error) => {
                console.error('Error clearing cart:', error);
                // Even if cart clearing fails, still redirect to show the order
                if (orderId) {
                    const redirectUrl = `/transactions/${orderId}`;
                    console.log('Fallback redirect to order:', redirectUrl);
                    window.location.href = redirectUrl;
                } else {
                    const redirectUrl = '{{ route("transactions.index") }}';
                    console.log('Fallback redirect to transactions list:', redirectUrl);
                    window.location.href = redirectUrl;
                }
            });
        }

        // Reset checkout button
        function resetCheckoutButton() {
            const btn = document.getElementById('proceedToPaymentBtn');
            const btnText = document.getElementById('proceedBtnText');
            const btnLoader = document.getElementById('proceedBtnLoader');
            
            btn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoader.classList.add('hidden');
        }

        // Debug function
        function debugCart() {
            console.log('Cart Items:', cartItems);
            console.log('Cart Total:', cartTotal);
            console.log('Order Data:', orderData);
        }
    </script>
</body>
</html>
