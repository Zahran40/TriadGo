<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <main class="flex-1 container mx-auto px-6 py-16">
        <!-- Page Header -->
        <div class="text-center mb-12 slide-in">
            <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100 mb-4">Add New Product</h1>
            <p class="text-xl text-blue-700 dark:text-blue-300">Fill in the details to list your export product</p>
        </div>

        <form class="max-w-6xl mx-auto space-y-8">
            <!-- Product Information Section -->
            <div class="export-card bg-blue-50 dark:bg-gray-800 rounded-lg shadow-md p-8 slide-in">
                <div class="flex justify-between items-center mb-6 border-b dark:border-gray-600 pb-4">
                    <h2 class="text-3xl font-bold text-blue-900 dark:text-blue-100 mb-4">Product Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Product Image Upload -->
                    <div class="flex flex-col items-center">
                        <div class="w-full max-w-xs mb-4">
                            <label class="block text-blue-900 dark:text-blue-300 mb-2">Product Image*</label>
                            <div class="border-2 border-dashed border-blue-300 dark:border-gray-600 rounded-lg p-8 text-center">
                                <div id="imagePreview" class="hidden">
                                    <img id="previewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg mb-4">
                                    <button type="button" onclick="removeImage()" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm">Remove Image</button>
                                </div>
                                <div id="uploadArea">
                                    <svg class="mx-auto h-12 w-12 text-blue-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4">
                                        <input type="file" id="productImage" class="hidden" accept="image/*" onchange="previewImage(this)" onblur="checkImageInput()">
                                        <label for="productImage" class="cursor-pointer bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                                            Choose Image
                                        </label>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">PNG, JPG up to 5MB</p>
                                    </div>
                                </div>
                            </div>
                            <p id="imageWarning" class="text-red-500 text-sm mt-1 hidden">Product image is required.</p>
                        </div>
                    </div>

                    <!-- Product Details Form -->
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Product Name*</label>
                                <input type="text" id="ProductName" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Enter product name" onblur="checkInput(this)">
                                <p id="nameWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            <div>
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Category*</label>
                                <select id="productCategory" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-light" onblur="checkInput(this)">
                                    <option value="" disabled selected hidden>Select Category</option>
                                    <option>Electronics</option>
                                    <option>Textile goods</option>
                                    <option>Raw materials</option>
                                    <option>Furniture items</option>
                                    <option>Sports equipment</option>
                                    <option>Medical/health supplies</option>
                                    <option>Others</option>
                                </select>
                                <p id="categoryWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            
                            <!-- Price and Stock Row -->
                            <div>
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Price (USD)*</label>
                                <input type="number" id="productPrice" min="1" step="0.01" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="100.00" onblur="checkInput(this)">
                                <p id="priceWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            <div>
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Stock Quantity*</label>
                                <input type="number" id="stockQuantity" min="1" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="50" onblur="checkInput(this)">
                                <p id="stockWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            
                            <!-- Product ID and Weight Row -->
                            <div>
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Product ID/SKU*</label>
                                <input type="text" id="productSKU" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="TDR-3000" onblur="checkInput(this)">
                                <p id="skuWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            <div>
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Product Weight (kg)*</label>
                                <input type="number" id="productWeight" min="0.1" step="0.1" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="5.0" onblur="checkInput(this)">
                                <p id="productWeightWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            
                            <!-- Country of Origin -->
                            <div class="md:col-span-2">
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Country of Origin*</label>
                                <select id="countryOrigin" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light bg-white dark:bg-gray-700 text-gray-900 dark:text-white" onblur="checkInput(this)">
                                    <option value="" disabled selected hidden>Select Country</option>
                                    <option>Indonesia</option>
                                    <option>Malaysia</option>
                                    <option>Thailand</option>
                                    <option>Singapore</option>
                                    <option>Vietnam</option>
                                    <option>Philippines</option>
                                    <option>China</option>
                                    <option>India</option>
                                    <option>Others</option>
                                </select>
                                <p id="countryWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-blue-900 dark:text-blue-300 mb-2">Product Description*</label>
                                <textarea id="productDescription" class="w-full px-4 py-2.5 border border-gray-light dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" rows="4" placeholder="Detailed product description..." onblur="checkInput(this)"></textarea>
                                <p id="descWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center slide-in">
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-md transition-all duration-300 transform hover:scale-105">
                    Publish Product
                </button>
            </div>
        </form>
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

        // SweetAlert2 Logout Desktop
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

        // SweetAlert2 Logout Mobile
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

        // Image Preview Function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
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
        window.checkInput = function(element) {
            const value = element.value.trim();
            let warningId = "";
            
            const fieldMap = {
                "ProductName": "nameWarning",
                "productDescription": "descWarning", 
                "productCategory": "categoryWarning",
                "productPrice": "priceWarning",
                "stockQuantity": "stockWarning",
                "productSKU": "skuWarning",
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

        // Form Submission Validation
        document.addEventListener('DOMContentLoaded', function() {
            function validateAll() {
                const requiredFields = [
                    'ProductName', 'productCategory', 'productDescription', 
                    'productPrice', 'stockQuantity', 'productSKU', 'productWeight',
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

            // Form submission with SweetAlert
            document.querySelector('form').addEventListener('submit', function(e) {
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

                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    icon: 'success',
                    title: 'Product Published!',
                    text: 'Your product has been successfully published.',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
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
            link.addEventListener('click', function(event) {
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