<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }}'s Profile | TriadGO</title>
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

        .profile-card {
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
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

        /* Product Card Styling */
        .product-card {
            background-color: #ffffff;
            color: #1f2937;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .dark .product-card {
            background-color: #374151;
            color: #f9fafb;
            border: 1px solid #4b5563;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .dark .product-card:hover {
            box-shadow: 0 10px 25px rgba(255,255,255,0.1);
        }

        /* Product Card Text Colors */
        .product-card h5 {
            color: #f59e0b !important;
        }

        .product-card h4 {
            color: #fbbf24 !important;
        }

        .product-card .product-description {
            color: #3b82f6 !important;
        }

        .dark .product-card .product-description {
            color: #93c5fd !important;
        }

        .product-card .price {
            color: #059669 !important;
        }

        .dark .product-card .price {
            color: #10b981 !important;
        }

        .product-card .stock-info {
            color: #6b7280 !important;
        }

        .dark .product-card .stock-info {
            color: #9ca3af !important;
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
    {{-- @if(Auth::user()->role === 'impor')
        @include('layouts.navbarimportir')
    @else
        @include('layouts.navbarekspor')
    @endif --}}

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-6 py-16">
        <!-- Back Button -->
        <div class="mb-6 slide-in">
            <button onclick="goBack()" class="flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </button>
        </div>

        <!-- Page Header -->
        <div class="text-center mb-12 slide-in">
            <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100 mb-4">{{ $user->name }}'s Profile</h1>
            <p class="text-xl text-blue-700 dark:text-blue-300">{{ ucfirst($user->role) }} from {{ $user->country }}</p>
        </div>

        <div class="max-w-7xl mx-auto">
            <!-- Profile Information Card -->
            <div class="profile-card bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 slide-in mb-8">
                <!-- Profile Picture and Basic Info -->
                <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
                    <div class="relative">
                        <img id="profileImage" 
                             src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://randomuser.me/api/portraits/' . ($user->role === 'impor' ? 'men' : 'women') . '/' . ($user->user_id % 100) . '.jpg' }}" 
                             alt="Profile" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-blue-200 dark:border-blue-600">
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">{{ ucfirst($user->role) }}</p>
                        <p class="text-gray-500 dark:text-gray-500">{{ $user->country }}</p>
                        @if($user->role === 'ekspor')
                            <div class="mt-3">
                                <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                    ✅ Verified Exporter
                                </span>
                            </div>
                        @else
                            <div class="mt-3">
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-medium">
                                    📦 Active Importer
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->email }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->phone }}</p>
                        </div>
                        <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->country }}</p>
                        </div>
                    </div>
                </div>

                

            <!-- Products Section (Only for Exporters) -->
            @if($user->role === 'ekspor')
                <div class="slide-in">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100">Products by {{ $user->name }}</h2>
                        <p class="text-blue-700 dark:text-blue-300">{{ $products->count() }} product{{ $products->count() != 1 ? 's' : '' }} available</p>
                    </div>

                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="product-card shadow-md rounded-lg p-4 hover:shadow-lg transition">
                                    <a href="{{ route('product.detail.importir', $product->product_id) }}">
                                        <h5 class="text-xl font-bold mb-2">{{ $product->product_name }}</h5>
                                        <h4 class="text-lg font-semibold mb-3">{{ $product->category }}</h4>
                                        
                                        @if($product->product_image)
                                            <img src="{{ asset($product->product_image) }}" 
                                                 alt="{{ $product->product_name }}" class="w-full h-48 mx-auto object-cover rounded-md mb-3" />
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
                                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                                    Origin: {{ $product->country_of_origin }}
                                                </p>
                                            @endif
                                        </div>
                                    </a>
                                    
                                    <!-- Action Button -->
                                    <a href="{{ route('product.detail.importir', $product->product_id) }}"
                                        class="w-full inline-block text-center bg-blue-700 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-md text-sm transition">
                                        View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Products Available</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't listed any products yet.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
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

        // Contact User Function
        function contactUser() {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Contact {{ $user->name }}',
                html: `
                    <div class="text-left space-y-2">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                        <p><strong>Country:</strong> {{ $user->country }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone }}</p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Send Message',
                cancelButtonText: 'Close',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const isDarkSuccess = document.documentElement.classList.contains('dark');
                    
                    Swal.fire({
                        title: 'Message Sent!',
                        text: 'Your message has been sent to {{ $user->name }}.',
                        icon: 'success',
                        background: isDarkSuccess ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDarkSuccess) popup.classList.add('swal2-dark');
                        }
                    });
                }
            });
        }

        // Report User Function
        function reportUser() {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Report {{ $user->name }}',
                text: 'Are you sure you want to report this user? Please only report users who violate our terms of service.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, report user',
                cancelButtonText: 'Cancel',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const isDarkSuccess = document.documentElement.classList.contains('dark');
                    
                    Swal.fire({
                        title: 'Report Submitted!',
                        text: 'Thank you for your report. We will review it and take appropriate action.',
                        icon: 'success',
                        background: isDarkSuccess ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDarkSuccess) popup.classList.add('swal2-dark');
                        }
                    });
                }
            });
        }

        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                @if(Auth::user()->role === 'impor')
                    window.location.href = '{{ route("importir") }}';
                @else
                    window.location.href = '{{ route("ekspor") }}';
                @endif
            }
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

        // Sidebar mobile
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
    </script>
</body>

</html>