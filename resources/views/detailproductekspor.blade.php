<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail | TriadGO</title>
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

<body class="home-bg min-h-screen dark:bg-slate-900">
    <!-- Header/Navbar -->
    @include('layouts.navbarekspor')

    <!-- Main Content -->
    <section id="" class="container mx-auto px-6 py-16 slide-in">
        <div class="min-h-screen flex items-center justify-center dark:bg-slate-900">
            <div class="product shadow-lg rounded-lg max-w-8xl w-full p-8 bg-white dark:bg-gray-800">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex flex-col items-center md:items-start">
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="Product Image" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0">
                        
                        <p class="text-2xl font-medium text-blue-800 dark:text-blue-300 mt-6">Exported by</p>
                        
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
                        <h1 class="text-3xl font-bold text-blue-900 dark:text-blue-100 mb-8 mt-3">Mystery Product Box</h1>
                        
                        <!-- Category -->
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Category:</span>
                                <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md">
                                    Electronics
                                </span>
                            </div>
                        </div>

                        <p class="text-lg text-blue-700 dark:text-blue-300 font-medium mb-4">
                            High-quality electronic product with advanced features and reliable performance. Perfect for both personal and professional use.
                        </p>
                        
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-5 font-semibold">
                            Price : <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">$100</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-2 font-semibold">
                            Stock : <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">50</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-2 font-semibold">
                            Product ID : <span class="text-xl font-bold text-blue-900 dark:text-blue-100">TDR-3000</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-4 mt-2 font-semibold">
                            Weight : <span class="text-xl font-bold text-blue-900 dark:text-blue-100">5 kg</span>
                        </p>
                        <p class="text-xl text-blue-700 dark:text-blue-300 mb-6 mt-2 font-semibold">
                            Country of Origin : <span class="text-xl font-bold text-blue-900 dark:text-blue-100">Indonesia</span>
                        </p>

                        
                            
                            <button onclick="deleteProduct('TDR-3000')" 
                                    class="text-xl bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Product
                            </button>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

        // SweetAlert2 Logout Mobile
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

        // Product Management Functions
        function editProduct(productId) {
            // Redirect to edit product page
            window.location.href = `/edit-product/${productId}`;
        }

        function deleteProduct(productId) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Delete Product?',
                text: "This action cannot be undone! Your product will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
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
                        title: 'Deleted!',
                        text: 'Your product has been deleted successfully.',
                        icon: 'success',
                        background: isDarkSuccess ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDarkSuccess) popup.classList.add('swal2-dark');
                        }
                    }).then(() => {
                        // Redirect to products list after deletion
                        window.location.href = '/my-products';
                    });
                }
            });
        }

        function viewAllProducts() {
            // Redirect to products list page
            window.location.href = '/my-products';
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
    </script>
</body>

</html>