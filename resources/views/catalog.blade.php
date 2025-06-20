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

    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'

        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                    },
                },
            },
        }

        tailwind.scan()
    </script>

    <!-- Dark Mode Script - SAMA seperti importir -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .body {
            font-family: poppins, sans-serif;
        }

        .slide-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .slide-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* FIXED: Web Background dengan Light/Dark Mode */
        .catalog-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            transition: background 0.3s ease;
        }

        .dark .catalog-bg {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        /* FIXED: Heading Text Colors */
        .catalog-heading {
            color: #1e3a8a !important;
            /* Dark blue untuk light mode */
        }

        .dark .catalog-heading {
            color: #dbeafe !important;
            /* Light blue untuk dark mode */
        }

        .catalog-label {
            color: #1e40af !important;
            /* Dark blue untuk light mode */
        }

        .dark .catalog-label {
            color: #bfdbfe !important;
            /* Light blue untuk dark mode */
        }

        /* FIXED: Product Card Dark Mode dengan Specificity Tinggi */
        .product {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb !important;
        }

        .dark .product {
            background-color: #374151 !important;
            color: #f9fafb !important;
            border: 1px solid #4b5563 !important;
        }

        /* Text colors dalam product card */
        .product h5 {
            color: #f59e0b !important;
            /* Amber untuk title */
        }

        .product h4 {
            color: #fbbf24 !important;
            /* Amber untuk category */
        }

        .product .product-description {
            color: #3b82f6 !important;
            /* Blue untuk light mode */
        }

        .dark .product .product-description {
            color: #93c5fd !important;
            /* Light blue untuk dark mode */
        }

        /* Price */
        .product .price {
            color: #059669 !important;
            /* Green untuk light mode */
        }

        .dark .product .price {
            color: #10b981 !important;
            /* Light green untuk dark mode */
        }

        /* Stock info */
        .product .stock-info {
            color: #6b7280 !important;
            /* Gray untuk light mode */
        }

        .dark .product .stock-info {
            color: #9ca3af !important;
            /* Light gray untuk dark mode */
        }

        /* User name */
        .product .user-name {
            color: #1d4ed8 !important;
        }

        .dark .product .user-name {
            color: #93c5fd !important;
        }

        /* User country */
        .product .user-country {
            color: #f59e0b !important;
        }

        .dark .product .user-country {
            color: #fbbf24 !important;
        }

        /* Form elements */
        .form-select,
        .form-input {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            border: 1px solid #9ca3af !important;
        }

        .dark .form-select,
        .dark .form-input {
            background-color: #374151 !important;
            color: #ffffff !important;
            border: 1px solid #4b5563 !important;
        }

        /* Hover effects */
        .product:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dark .product:hover {
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.1);
        }

        /* FIXED: Footer styling */
        .catalog-footer {
            background-color: #1e40af !important;
        }

        .dark .catalog-footer {
            background-color: #1e293b !important;
        }

        /* Search and Filter styling */
        .filter-container {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
        }

        .dark .filter-container {
            background-color: #2d3748 !important;
            border: 1px solid #4a5568 !important;
        }
    </style>
</head>

<!-- FIXED: Changed from home-bg to catalog-bg -->

<body class="catalog-bg min-h-screen">
    <!-- Header/Navbar -->
    @include('layouts.navbarimportir')

    <!-- Main Content -->
    <section id="cari" class="container mx-auto px-6 py-16 slide-in">
        <!-- FIXED: Changed text color class -->
        <h2 class="text-3xl font-bold catalog-heading mb-6 text-center">Welcome to TriadGO Catalog</h2>

        <!-- Enhanced Search and Filter Section -->
        <div class="filter-container rounded-lg p-6 mb-8 max-w-4xl mx-auto">
            <form action="{{ route('catalog') }}" method="GET" class="space-y-4">
                <!-- Search and Filter Row -->
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <!-- Search Bar -->
                    <div class="flex-1 w-full">
                        <label for="search" class="block font-semibold catalog-label mb-2">Search Products:</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search by product name, description, category, or country..."
                                class="form-input w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            @if(request('search'))
                                <button type="button" onclick="clearSearch()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="w-full md:w-64">
                        <label for="country" class="block font-semibold catalog-label mb-2">Filter by Country:</label>
                        <select name="country" id="country"
                            class="form-select w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">All Countries</option>
                            @if(isset($countries))
                                @foreach($countries as $country)
                                    <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search & Filter
                    </button>
                    @if(request('search') || request('country'))
                        <a href="{{ route('catalog') }}"
                            class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Clear All
                        </a>
                    @endif
                </div>

                <!-- Active Filters Display -->
                @if(request('search') || request('country'))
                    <div class="border-t dark:border-gray-600 pt-4 mt-4">
                        <p class="catalog-label text-sm mb-2">Active Filters:</p>
                        <div class="flex flex-wrap gap-2">
                            @if(request('search'))
                                <span
                                    class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                                    Search: "{{ request('search') }}"
                                    <button type="button" onclick="clearSearchOnly()"
                                        class="hover:text-blue-600 dark:hover:text-blue-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </span>
                            @endif
                            @if(request('country'))
                                <span
                                    class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                                    Country: {{ request('country') }}
                                    <button type="button" onclick="clearCountryOnly()"
                                        class="hover:text-green-600 dark:hover:text-green-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <div class="mt-8">
            <!-- Results Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold catalog-heading">Product Catalog</h3>
                @if(isset($products))
                    <p class="catalog-label text-sm">
                        {{ $products->count() }} product{{ $products->count() != 1 ? 's' : '' }} found
                        @if(request('search') || request('country'))
                            @if(request('search') && request('country'))
                                for "{{ request('search') }}" in {{ request('country') }}
                            @elseif(request('search'))
                                for "{{ request('search') }}"
                            @else
                                from {{ request('country') }}
                            @endif
                        @endif
                    </p>
                @endif
            </div>

            <div class="mt-8">
                @if(isset($products) && $products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <!-- FIXED: Product Card dengan CSS Classes -->
                            <div class="product shadow-md rounded-lg p-4 max-w-md hover:shadow-lg transition">
                                <a href="{{ route('product.detail.importir', $product->product_id) }}">
                                    <h5 class="text-xl font-bold mb-2">{{ $product->product_name }}</h5>
                                    <h4 class="text-lg font-semibold mb-3">{{ $product->category }}</h4>

                                    @if($product->product_image)
                                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}"
                                            class="w-full h-48 mx-auto object-cover rounded-md mb-3" />
                                    @else
                                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                                            alt="No Image" class="w-full h-48 mx-auto object-cover rounded-md mb-3" />
                                    @endif

                                    <p class="product-description text-md mt-2 mb-4">
                                        {{ Str::limit($product->product_description, 100) }}
                                    </p>

                                    <!-- Price and Stock Info -->
                                    <div class="mb-4">
                                        <p class="price text-lg font-bold">
                                            ${{ number_format($product->price, 2) }}
                                        </p>
                                        <p class="stock-info text-sm">
                                            Stock: {{ $product->stock_quantity }} units
                                        </p>
                                        @if($product->country_of_origin)
                                            <p class="text-xs catalog-label mt-1">
                                                Origin: {{ $product->country_of_origin }}
                                            </p>
                                        @endif
                                    </div>
                                </a>

                                <!-- User Info -->
                                <div class="flex items-center gap-3 mt-4 mb-4">
                                    <a href="{{ route('other.profile', $product->user->user_id) }}"
                                        class="flex items-center gap-3 hover:opacity-80 transition">
                                        @if($product->user && $product->user->profile_picture)
                                            <img src="{{ asset($product->user->profile_picture) }}" alt="{{ $product->user->name }}"
                                                class="w-[50px] h-[50px] rounded-full object-cover">
                                        @else
                                            <div
                                                class="w-[50px] h-[50px] rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center text-white font-bold">
                                                {{ $product->user ? strtoupper(substr($product->user->name, 0, 1)) : 'U' }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <p class="user-name text-lg font-bold">
                                                {{ $product->user ? $product->user->name : 'Unknown User' }}
                                            </p>
                                            <p class="user-country text-md font-semibold">
                                                {{ $product->user ? $product->user->country : 'Unknown Country' }}
                                            </p>
                                        </div>
                                    </a>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('product.detail.importir', $product->product_id) }}"
                                    class="w-full inline-block text-center bg-blue-700 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-md text-sm transition">
                                    See Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No products found -->
                    <div class="mt-14 text-center">
                        <h3 class="text-2xl font-bold text-red-400 mb-4 mt-12">
                            @if(request('search') || request('country'))
                                No Products Found
                            @else
                                No Products Available
                            @endif
                        </h3>
                        <img src="https://cdn-icons-png.flaticon.com/512/6134/6134051.png" alt=""
                            style="width: 100px; height: 100px;" class="mx-auto mb-10 mt-7" />
                        @if(request('search') || request('country'))
                            <p class="text-blue-700 dark:text-blue-300 mb-4">
                                No products match your search criteria. Try adjusting your filters.
                            </p>
                            <a href="{{ route('catalog') }}"
                                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                                View All Products
                            </a>
                        @else
                            <p class="text-blue-700 dark:text-blue-300 mb-4">Currently there are no products available in our
                                catalog.</p>
                            <p class="text-blue-700 dark:text-blue-300 mb-4">Please check back later for new products from our
                                exporters.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </section>


    <!-- FIXED: Footer dengan class yang proper -->
    <footer class="catalog-footer text-blue-100 py-6 mt-auto">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" aria-label="Facebook" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M22 12.07c0-5.52-4.48-10-10-10s-10 4.48-10 10c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54v-2.21c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.25.2 2.25.2v2.49h-1.27c-1.25 0-1.64.78-1.64 1.57v1.84h2.78l-.44 2.89h-2.34v6.99c4.78-.76 8.44-4.89 8.44-9.88z" />
                    </svg>
                </a>
                <a href="https://github.com/Zahran40/TriadGo" aria-label="GitHub"
                    class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.397.1 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.744 0 .267.18.579.688.481C19.138 20.203 22 16.447 22 12.021 22 6.484 17.523 2 12 2z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/official.usu" aria-label="Instagram"
                    class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.13.62a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Clear filter functions
        function clearSearch() {
            document.getElementById('search').value = '';
            document.querySelector('form').submit();
        }

        function clearSearchOnly() {
            const url = new URL(window.location);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }

        function clearCountryOnly() {
            const url = new URL(window.location);
            url.searchParams.delete('country');
            window.location.href = url.toString();
        }

        // Dark Mode Script
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

        // Scroll animations
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
    </script>
</body>

</html>