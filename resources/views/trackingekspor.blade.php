<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Product | TriadGO</title>
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
                        'primary-light': '#3b82f6',
                        accent: '#f97316',
                        'gray-light': '#e5e7eb'
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

        .export-card {
            transition: all 0.3s ease;
        }

        .export-card:hover {
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
     <!-- filepath: resources/views/transactions.blade.php -->

<title>Tracking Pengiriman</title>
@vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto py-16 px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Lacak Pengiriman</h1>
            <div class="text-xl text-gray-600">
                Nomor Resi: <span class="font-mono font-semibold text-blue-600">{{ $transaction->nomor_resi }}</span>
            </div>
        </div>
<!-- Tracking Timeline -->
<div class="relative">
    <!-- Vertical line -->
    <div class="absolute left-6 top-0 h-full w-0.5 bg-blue-100 transform -translate-x-1/2"></div>

    <div class="space-y-8">
        @foreach($trackings as $tracking)
        <div class="relative flex items-start group">
            <!-- Timeline dot -->
            <div class="absolute left-6 top-5 h-4 w-4 rounded-full bg-blue-600 border-4 border-blue-50 transform -translate-x-1/2 z-10"></div>
            
            <!-- Card -->
            <div class="ml-12 flex-1 bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $tracking->status }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $tracking->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <!-- Radio button  -->
                    <div class="relative">
                    <input type="radio" id="tracking-{{ $tracking->id }}" name="tracking_option"
                        class="hidden peer" value="{{ $tracking->id }}">
                    <label for="tracking-{{ $tracking->id }}"
                        class="w-10 h-10 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-100
                                flex items-center justify-center cursor-pointer transition duration-200">
                    </label>
                </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



    <!-- Footer
    <footer class="bg-blue-800 dark:bg-slate-900 text-blue-100 py-6 mt-20">
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
    </footer> -->

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

        // Image Preview Function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('uploadArea').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            document.getElementById('productImage').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');
            document.getElementById('imageWarning').classList.add('hidden');
        }

        function checkImageInput() {
            const imageInput = document.getElementById('productImage');
            const imageWarning = document.getElementById('imageWarning');

            if (!imageInput.files || imageInput.files.length === 0) {
                imageWarning.classList.remove('hidden');
                return false;
            } else {
                imageWarning.classList.add('hidden');
                return true;
            }
        }

        // Form Validation Function
        window.checkInput = function (element) {
            const value = element.value.trim();
            let warningId = "";

            const fieldMap = {
                "ProductName": "nameWarning",
                "productDescription": "descWarning",
                "productCategory": "categoryWarning",
                "productPrice": "priceWarning",
                "stockQuantity": "stockWarning",
                "productWeight": "productWeightWarning",
                "countryOrigin": "countryWarning"
            };

            warningId = fieldMap[element.id];

            if (warningId) {
                if (value === "" || value === null) {
                    document.getElementById(warningId).classList.remove("hidden");
                    return false;
                } else {
                    document.getElementById(warningId).classList.add("hidden");
                    return true;
                }
            }
            return true;
        };

        // Reset Form Function
        function resetForm() {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Reset Form?',
                text: "All form data will be cleared. This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Reset',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('productForm').reset();
                    removeImage();

                    // Hide all warning messages
                    document.querySelectorAll('[id$="Warning"]').forEach(warning => {
                        warning.classList.add('hidden');
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Form Reset!',
                        text: 'All form fields have been cleared.',
                        timer: 1500,
                        showConfirmButton: false,
                        background: isDark ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDark) popup.classList.add('swal2-dark');
                        }
                    });
                }
            });
        }

        // Form Submission Validation
        document.addEventListener('DOMContentLoaded', function () {
            function validateAll() {
                const requiredFields = [
                    'ProductName', 'productCategory', 'productDescription',
                    'productPrice', 'stockQuantity', 'productWeight', // REMOVED 'productSKU'
                    'countryOrigin'
                ];

                let allValid = true;

                // Check image
                if (!checkImageInput()) {
                    allValid = false;
                }

                // Check required fields
                requiredFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field && !window.checkInput(field)) {
                        allValid = false;
                    }
                });

                return allValid;
            }

            // Form submission with AJAX
            document.getElementById('productForm').addEventListener('submit', function (e) {
                e.preventDefault();

                if (!validateAll()) {
                    const isDark = document.documentElement.classList.contains('dark');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Information',
                        text: 'Please fill in all required fields before submitting.',
                        background: isDark ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDark) popup.classList.add('swal2-dark');
                        }
                    });
                    return;
                }

                // Prepare form data (WITHOUT product_sku)
                const formData = new FormData();
                formData.append('product_name', document.getElementById('ProductName').value);
                formData.append('product_description', document.getElementById('productDescription').value);
                formData.append('category', document.getElementById('productCategory').value);
                formData.append('price', document.getElementById('productPrice').value);
                formData.append('stock_quantity', document.getElementById('stockQuantity').value);
                // REMOVED: formData.append('product_sku', document.getElementById('productSKU').value);
                formData.append('weight', document.getElementById('productWeight').value);
                formData.append('country_of_origin', document.getElementById('countryOrigin').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Add product image if selected
                const productImage = document.getElementById('productImage');
                if (productImage.files && productImage.files[0]) {
                    formData.append('product_image', productImage.files[0]);
                }

                // Show loading
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    title: 'Publishing...',
                    text: 'Please wait while we publish your product.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send AJAX request
                fetch('{{ route("product.store") }}', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Product Published!',
                                html: `Your product has been successfully published.<br><strong>SKU: ${data.product_sku || 'Generated'}</strong>`,
                                background: isDark ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDark) popup.classList.add('swal2-dark');
                                }
                            }).then(() => {
                                // Reset form after success
                                document.getElementById('productForm').reset();
                                removeImage();

                                // Hide all warning messages
                                document.querySelectorAll('[id$="Warning"]').forEach(warning => {
                                    warning.classList.add('hidden');
                                });
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Failed to publish product.',
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
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            background: isDark ? '#374151' : '#ffffff',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (isDark) popup.classList.add('swal2-dark');
                            }
                        });
                    });
            });
        });

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

        // Navigation
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
    </script>
</body>

</html>
