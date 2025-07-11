<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Products | TriadGO</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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

        /* SweetAlert2 Dark Mode Fix */
        .swal2-popup .swal2-title {
            color: #1f2937 !important;
        }
        
        .swal2-popup .swal2-html-container {
            color: #374151 !important;
        }
        
        .swal2-popup.swal2-dark .swal2-title {
            color: #ffffff !important;
        }
        
        .swal2-popup.swal2-dark .swal2-html-container {
            color: #d1d5db !important;
        }
    </style>
</head>

<body class="home-bg min-h-screen flex flex-col dark:bg-slate-900">
    <!-- Header/Navbar -->
    @include('layouts.navbarekspor')

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-6 py-16">
        <!-- Page Header -->
        <div class="text-center mb-12 slide-in">
            <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100 mb-4">My Products</h1>
            <p class="text-xl text-blue-700 dark:text-blue-300">Manage and view all your exported products</p>
            
            <!-- Stats -->
            <div class="flex justify-center gap-8 mt-6">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $products->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $products->where('status', 'pending')->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $products->where('status', 'approved')->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Approved</p>
                </div>
            </div>
            
            <!-- Add Product Button -->
            <div class="mt-6">
                <a href="{{ route('formeksportir') }}" class="inline-block bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-500 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Product
                </a>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 slide-in" id="productsGrid">
                @foreach($products as $product)
                    <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            @if($product->product_image)
                                <img src="{{ asset($product->product_image) }}" 
                                     alt="{{ $product->product_name }}" class="w-full h-48 object-cover">
                            @else
                                <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png" 
                                     alt="No Image" class="w-full h-48 object-cover">
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="absolute top-2 left-2">
                                @if($product->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                                        Pending
                                    </span>
                                @elseif($product->status === 'approved')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                        Approved
                                    </span>
                                @elseif($product->status === 'rejected')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                                        Rejected
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $product->product_name }}</h3>
                                <span class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->product_sku }}</span>
                            </div>
                            
                            <div class="mb-3">
                                @php
                                    $categoryColors = [
                                        'Electronics' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                                        'Food & Beverages' => 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200',
                                        'Textile goods' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
                                        'Raw materials' => 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200',
                                        'Furniture items' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                    ];
                                    $colorClass = $categoryColors[$product->category] ?? 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200';
                                @endphp
                                <span class="inline-block {{ $colorClass }} px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $product->category }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($product->product_description, 100) }}
                            </p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Stock: {{ $product->stock_quantity }} units</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Weight: {{ $product->weight }} kg</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Origin: {{ $product->country_of_origin }}</p>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
    <a href="{{ route('product.detail', $product->product_id) }}" class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white py-2 px-3 rounded-md text-sm font-medium transition">View</a>
                             
                                <button onclick="deleteProduct({{ $product->product_id }})" class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 text-white py-2 px-3 rounded-md text-sm font-medium transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                Created: {{ $product->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div id="emptyState" class="text-center py-16 slide-in">
                <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-500 dark:text-gray-400 mb-2">No products found</h3>
                <p class="text-gray-400 dark:text-gray-500 mb-6">You haven't added any products yet</p>
                <a href="{{ route('formeksportir') }}" class="inline-block bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-500 text-white font-bold py-2 px-6 rounded-md transition">
                    Add Your First Product
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-blue-800 dark:bg-slate-900 text-blue-100 py-6 mt-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" aria-label="Facebook" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12.07c0-5.52-4.48-10-10-10s-10 4.48-10 10c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54v-2.21c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.25.2 2.25.2v2.49h-1.27c-1.25 0-1.64.78-1.64 1.57v1.84h2.78l-.44 2.89h-2.34v6.99c4.78-.76 8.44-4.89 8.44-9.88z" />
                    </svg>
                </a>
                <a href="https://github.com/Zahran40/TriadGo" aria-label="GitHub" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.397.1 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.744 0 .267.18.579.688.481C19.138 20.203 22 16.447 22 12.021 22 6.484 17.523 2 12 2z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/official.usu" aria-label="Instagram" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.13.62a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

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

        // SweetAlert2 Logout
        document.getElementById('logoutBtn')?.addEventListener('click', function(e) {
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

        document.getElementById('logoutBtnMobile')?.addEventListener('click', function(e) {
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

        // Delete Product Function dengan AJAX
        function deleteProduct(productId) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Delete Product?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX delete request
                    fetch(`/product/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const isDarkSuccess = document.documentElement.classList.contains('dark');
                            
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.message,
                                icon: 'success',
                                background: isDarkSuccess ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDarkSuccess) popup.classList.add('swal2-dark');
                                }
                            }).then(() => {
                                // Reload page to update the list
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                background: isDark ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDark) popup.classList.add('swal2-dark');
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            background: isDark ? '#374151' : '#ffffff',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (isDark) popup.classList.add('swal2-dark');
                            }
                        });
                    });
                }
            });
        }

        // Scroll Animation
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

        // Mobile Sidebar
        const sidebar = document.getElementById('mobileSidebar');
        const openSidebarBtn = document.querySelector('button.md\\:hidden[aria-label="Open Menu"]');
        const closeSidebarBtn = document.getElementById('closeSidebar');

        if (openSidebarBtn && closeSidebarBtn) {
            openSidebarBtn.addEventListener('click', function() {
                sidebar.classList.remove('hidden');
            });

            closeSidebarBtn.addEventListener('click', function() {
                sidebar.classList.add('hidden');
            });

            sidebar.addEventListener('click', function(e) {
                if (e.target === sidebar) {
                    sidebar.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>