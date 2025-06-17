<!DOCTYPE html>
<html lang="en">

<head>
    <!-- TAMBAHKAN SweetAlert2 seperti di importir -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Dark Mode Script - SAMA seperti importir -->
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .body {
            font-family: poppins, sans-serif;
        }

        /* SweetAlert2 Light Mode Text Fix */
        .swal2-popup .swal2-title {
            color: #1f2937 !important;
        }

        .swal2-popup .swal2-html-container {
            color: #374151 !important;
        }

        /* Dark mode override */
        .swal2-popup.swal2-dark .swal2-title {
            color: #ffffff !important;
        }

        .swal2-popup.swal2-dark .swal2-html-container {
            color: #d1d5db !important;
        }
    </style>
</head>

<body class="home-bg min-h-screen dark:bg-slate-900">
    <!-- Header/Navbar -->
    @include('layouts.navbarimportir')

    <!-- Main Content -->
    <section id="" class="container mx-auto px-6 py-16 slide-in">

        <body class="min-h-screen flex items-center justify-center dark:bg-slate-900">
            <div class="product shadow-lg rounded-lg max-w-8xl w-full p-8 bg-white dark:bg-gray-800">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex flex-col items-center md:items-start">
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="Product Image" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0">
                        <p class="text-2xl font-medium text-blue-800 dark:text-blue-300 mt-6">Exported by </p>

                        <a href=""
                            class="flex items-center gap-3 mt-6 bg-blue-700 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 p-4 rounded-lg shadow-sm">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt=""
                                class="w-[70px] h-[70px] rounded-full ml-3">
                            <div class="flex flex-col ml-2">
                                <p class="text-xl font-medium text-white">John Doe</p>
                                <p class="text-lg font-medium text-white">Indonesia</p>
                            </div>
                        </a>

                    </div>

                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-blue-900 dark:text-blue-100 mb-8 mt-3">Product Name</h1>
                        <!-- ALTERNATIVE KATEGORI STYLE -->
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Category:</span>
                                <span
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md">
                                    Electronics
                                </span>
                            </div>
                        </div>


                        <p class="text-lg text-blue-700 dark:text-blue-300 font-medium mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Libero culpa quam quas numquam hic tempore autem, velit voluptate sit illum molestiae nemo
                            dicta doloremque fugit recusandae ex at! Quam, quae.
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-5 font-semibold">
                            Price : <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">$100</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-2 font-semibold">
                            Stock : <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">50</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-2 font-semibold">
                            Product ID : <span class="text-xl font-bold text-blue-900 dark:text-blue-100">TDR -
                                3000</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-2 font-semibold">
                            Weight : <span class="text-xl font-bold text-blue-900 dark:text-blue-100">5 kg</span>
                        </p>
                        <!-- TAMBAH COUNTRY OF ORIGIN -->
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-6 mt-2 font-semibold">
                            Country of Origin : <span
                                class="text-xl font-bold text-blue-900 dark:text-blue-100">Indonesia</span>
                        </p>

                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label
                                class="text-lg font-semibold text-blue-700 dark:text-blue-300 block mb-2">Quantity:</label>
                            <div class="flex items-center space-x-3">
                                <button onclick="decreaseQuantity()"
                                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white w-10 h-10 rounded-lg font-bold">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="50"
                                    class="w-20 h-10 text-center border-2 border-blue-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <button onclick="increaseQuantity()"
                                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white w-10 h-10 rounded-lg font-bold">+</button>
                                <span class="text-sm text-blue-600 dark:text-blue-300 ml-2">Max: 50</span>
                            </div>
                        </div>

                        <!-- Cart Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-6">
                            <button onclick="addToCart()"
                                class="text-xl bg-amber-500 hover:bg-amber-400 dark:bg-amber-600 dark:hover:bg-amber-500 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5m0 0a2.2 0 100-4.4 2.2 0 000 4.4z">
                                    </path>
                                </svg>
                                Add to Cart
                            </button>
                            <button onclick="viewCart()"
                                class="text-xl bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                View Cart (<span id="cartCount">0</span>)
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            <div class="mt-20">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Write a Review</h3>
                    <form id="commentForm" class="space-y-4">
                        @csrf

                        <!-- Comment Textarea -->
                        <div>
                            <label for="reviewComment"
                                class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Your Review</label>
                            <textarea id="reviewComment" name="comment" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                placeholder="Share your experience with this product..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </body>
    </section>

    <footer class="bg-blue-800 dark:bg-slate-900 text-blue-100 py-6 mt-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" aria-label="Facebook" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M22 12.07c0-5.52-4.48-10-10-10s-10 4.48-10 10c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54v-2.21c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.25.2 2.25.2v2.49h-1.27c-1.25 0-1.64.78-1.64 1.57v1.84h2.78l-.44 2.89h-2.34v6.99c4.78-.76 8.44-4.89 8.44-9.88z" />
                    </svg>
                </a>
                <a href="https://github.com/Zahran40/TriadGo" aria-label="GitHub"
                    class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.397.1 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.744 0 .267.18.579.688.481C19.138 20.203 22 16.447 22 12.021 22 6.484 17.523 2 12 2z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/official.usu" aria-label="Instagram"
                    class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.13.62a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <!-- Shopping Cart Modal dengan Dark Mode -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Shopping Cart</h2>
                    <button onclick="closeCart()"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <div id="cartItems" class="space-y-4">
                        <!-- Cart items will be populated here -->
                    </div>
                    <div id="emptyCart" class="text-center py-8 hidden">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Your cart is empty</p>
                    </div>
                </div>

                <div class="border-t dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800 dark:text-white">Total: </span>
                        <span id="cartTotal" class="text-xl font-bold text-blue-600 dark:text-blue-400">$0.00</span>
                    </div>
                    <div class="flex gap-4">
                        <button onclick="clearCart()"
                            class="flex-1 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition">
                            Clear Cart
                        </button>
                        <button onclick="proceedToCheckout()"
                            class="flex-1 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md transition">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-4 right-4 bg-green-600 dark:bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toastMessage">Product added to cart!</span>
        </div>
    </div>

    <script>
        // Dark Mode Toggle - SAMA seperti importir
        const isDarkMode = document.documentElement.classList.contains('dark');

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

        if (localStorage.getItem('darkMode') === 'enabled') {
            htmlElement.classList.add('dark');
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

        // Comment Form Submission - PERBAIKI dengan dark detection
        const commentForm = document.getElementById('commentForm');
        if (commentForm) {
            commentForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const comment = document.getElementById('reviewComment').value;

                if (comment.trim() === '') {
                    const isDark = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Comment Required',
                        text: 'Please write a comment before submitting.',
                        background: isDark ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDark) popup.classList.add('swal2-dark');
                        }
                    });
                    return;
                }

                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    icon: 'success',
                    title: 'Comment Submitted!',
                    text: 'Thank you for your comment. It has been added successfully.',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
                });

                // Reset form
                this.reset();
            });
        }

        // Scroll to section with slide
        function scrollToSectionWithSlide(sectionId) {
            const section = document.getElementById(sectionId);
            if (!section) return;

            section.classList.remove('slide-in');

            const sectionRect = section.getBoundingClientRect();
            const absoluteElementTop = sectionRect.top + window.pageYOffset;
            const offset = window.innerHeight / 2 - sectionRect.height / 2;
            const scrollTo = absoluteElementTop - offset;

            window.scrollTo({
                top: scrollTo,
                behavior: 'smooth'
            });

            setTimeout(() => {
                section.classList.add('slide-in');
            }, 300);
        }

        document.querySelectorAll('nav a[href^="#"], a[href^="#"]').forEach(link => {
            link.addEventListener('click', function (event) {
                if (this.getAttribute('href') !== '#') {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    scrollToSectionWithSlide(targetId);
                }
            });
        });

        document.querySelectorAll('.slide-in').forEach(section => {
            function checkSlide() {
                const rect = section.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    section.classList.add('visible');
                }
            }
            window.addEventListener('scroll', checkSlide);
            checkSlide();
        });

        // Sidebar mobile
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

        // SweetAlert2 Logout Desktop - PERBAIKI dengan dark detection
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

        // SweetAlert2 Logout Mobile - PERBAIKI dengan dark detection
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

        // SHOPPING CART FUNCTIONALITY
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Product data - TAMBAH CATEGORY
        const product = {
            id: 'TDR-3000',
            name: 'Product Name',
            category: 'Electronics',
            price: 100,
            image: 'https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png',
            maxStock: 50
        };

        // Update cart count on page load
        updateCartCount();

        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < product.maxStock) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);

            // Check if product already exists in cart
            const existingItemIndex = cart.findIndex(item => item.id === product.id);

            if (existingItemIndex > -1) {
                // Update quantity if product exists
                const newQuantity = cart[existingItemIndex].quantity + quantity;
                if (newQuantity <= product.maxStock) {
                    cart[existingItemIndex].quantity = newQuantity;
                    showToast(`Updated quantity to ${newQuantity}`);
                } else {
                    showToast(`Cannot add more. Maximum stock is ${product.maxStock}`, 'error');
                    return;
                }
            } else {
                // Add new product to cart
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: quantity
                });
                showToast('Product added to cart!');
            }

            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();

            // Reset quantity to 1
            document.getElementById('quantity').value = 1;
        }

        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartCount').textContent = totalItems;
        }

        function viewCart() {
            renderCartItems();
            document.getElementById('cartModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeCart() {
            document.getElementById('cartModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        function renderCartItems() {
            const cartItemsContainer = document.getElementById('cartItems');
            const emptyCartDiv = document.getElementById('emptyCart');

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '';
                emptyCartDiv.classList.remove('hidden');
                updateCartTotal();
                return;
            }

            emptyCartDiv.classList.add('hidden');

            cartItemsContainer.innerHTML = cart.map(item => `
                <div class="flex items-center gap-4 p-4 border dark:border-gray-600 rounded-lg">
                    <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 dark:text-white">${item.name}</h3>
                        <p class="text-gray-600 dark:text-gray-300">$${item.price.toFixed(2)} each</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="updateCartItemQuantity('${item.id}', ${item.quantity - 1})" 
                                class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white w-8 h-8 rounded font-bold">-</button>
                        <span class="w-8 text-center text-gray-800 dark:text-white">${item.quantity}</span>
                        <button onclick="updateCartItemQuantity('${item.id}', ${item.quantity + 1})" 
                                class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white w-8 h-8 rounded font-bold">+</button>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800 dark:text-white">$${(item.price * item.quantity).toFixed(2)}</p>
                        <button onclick="removeFromCart('${item.id}')" 
                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm mt-1">Remove</button>
                    </div>
                </div>
            `).join('');

            updateCartTotal();
        }

        function updateCartItemQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                removeFromCart(productId);
                return;
            }

            if (newQuantity > product.maxStock) {
                showToast(`Maximum stock is ${product.maxStock}`, 'error');
                return;
            }

            const itemIndex = cart.findIndex(item => item.id === productId);
            if (itemIndex > -1) {
                cart[itemIndex].quantity = newQuantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                renderCartItems();
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            renderCartItems();
            showToast('Product removed from cart');
        }

        function updateCartTotal() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('cartTotal').textContent = `$${total.toFixed(2)}`;
        }

        function clearCart() {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Clear Cart?',
                text: "Are you sure you want to remove all items from your cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, clear it!',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    cart = [];
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                    renderCartItems();
                    showToast('Cart cleared');
                }
            });
        }

        function proceedToCheckout() {
            if (cart.length === 0) {
                showToast('Your cart is empty', 'error');
                return;
            }

            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Proceed to Checkout?',
                text: `Total: $${cart.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2)}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, checkout!',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const isDarkSuccess = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        title: 'Order Placed!',
                        text: 'Thank you for your purchase. You will be redirected to payment.',
                        icon: 'success',
                        background: isDarkSuccess ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDarkSuccess) popup.classList.add('swal2-dark');
                        }
                    });

                    // Clear cart after successful order
                    cart = [];
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                    closeCart();
                }
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');

            toastMessage.textContent = message;

            // Change color based on type
            if (type === 'error') {
                toast.className = toast.className.replace('bg-green-600 dark:bg-green-500', 'bg-red-600 dark:bg-red-500');
            } else {
                toast.className = toast.className.replace('bg-red-600 dark:bg-red-500', 'bg-green-600 dark:bg-green-500');
            }

            // Show toast
            toast.style.transform = 'translateY(0)';

            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateY(100%)';
            }, 3000);
        }

        // Close cart modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeCart();
            }
        });

        // Close cart modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCart();
            }
        });

        // Prevent quantity input from going below 1 or above max stock
        document.getElementById('quantity').addEventListener('input', function () {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > product.maxStock) {
                this.value = product.maxStock;
                showToast(`Maximum stock is ${product.maxStock}`, 'error');
            }
        });
    </script>

</body>

</html>