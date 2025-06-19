<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->product_name }} | TriadGO</title>
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

        body {
            font-family: 'Poppins', sans-serif;
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

        .slide-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .slide-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ✅ Edit Mode Styles */
        .edit-input {
            border: 2px solid #3b82f6;
            background: rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
        }

        .edit-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
                
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('myproduct') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to My Products
                    </a>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex flex-col items-center md:items-start">
                        @if($product->product_image)
                            <img src="{{ asset($product->product_image) }}"
                                alt="{{ $product->product_name }}" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0 shadow-md">
                        @else
                            <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                                alt="No Image" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0 shadow-md">
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="mt-4">
                            @if($product->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
                                    ⏳ Pending Review
                                </span>
                            @elseif($product->status === 'approved')
                                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                                    ✅ Approved
                                </span>
                            @elseif($product->status === 'rejected')
                                <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-medium">
                                    ❌ Rejected
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm font-medium">
                                    {{ ucfirst($product->status) }}
                                </span>
                            @endif
                        </div>
                        
                        <p class="text-2xl font-medium text-blue-800 dark:text-blue-300 mt-6">Exported by</p>
                        
                        <div class="flex items-center gap-3 mt-6 bg-blue-700 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 p-4 rounded-lg shadow-sm">
                            @if($product->user->profile_picture)
                                <img src="{{ asset($product->user->profile_picture) }}" alt="{{ $product->user->name }}"
                                    class="w-[70px] h-[70px] rounded-full ml-3 object-cover">
                            @else
                                <div class="w-[70px] h-[70px] rounded-full ml-3 bg-blue-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <div class="flex flex-col ml-2">
                                <p class="text-xl font-medium text-white">{{ $product->user->name }}</p>
                                <p class="text-lg font-medium text-white">{{ $product->user->country }}</p>
                                <p class="text-sm text-blue-100">{{ $product->user->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <!-- ✅ Product Name - Editable -->
                        <div class="mb-8 mt-3">
                            <h1 id="productNameDisplay" class="text-3xl font-bold text-blue-900 dark:text-blue-100 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 p-2 rounded-lg transition" onclick="editField('productName')">
                                {{ $product->product_name }} ✏️
                            </h1>
                            <input id="productNameEdit" type="text" value="{{ $product->product_name }}" 
                                   class="hidden text-3xl font-bold text-blue-900 dark:text-blue-100 bg-transparent edit-input w-full p-2 rounded-lg dark:text-white"
                                   onblur="saveField('productName')" onkeydown="handleKeyDown(event, 'productName')">
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Category:</span>
                                @php
                                    $categoryColors = [
                                        'Electronics' => 'from-blue-500 to-blue-600',
                                        'Food & Beverages' => 'from-orange-500 to-orange-600',
                                        'Textile goods' => 'from-purple-500 to-purple-600',
                                        'Raw materials' => 'from-gray-500 to-gray-600',
                                        'Furniture items' => 'from-green-500 to-green-600',
                                    ];
                                    $gradient = $categoryColors[$product->category] ?? 'from-blue-500 to-blue-600';
                                @endphp
                                <span class="bg-gradient-to-r {{ $gradient }} text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md">
                                    {{ $product->category }}
                                </span>
                            </div>
                        </div>

                        <p class="text-lg text-blue-700 dark:text-blue-300 font-medium mb-4">
                            {{ $product->product_description }}
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- ✅ Price - Editable -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">Price:</p>
                                <div id="priceDisplay" class="cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800/30 p-2 rounded transition" onclick="editField('price')">
                                    <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">${{ number_format($product->price, 2) }}</span> ✏️
                                </div>
                                <input id="priceEdit" type="number" step="0.01" min="0" value="{{ $product->price }}" 
                                       class="hidden text-2xl font-bold text-blue-900 dark:text-blue-100 bg-transparent edit-input w-full p-2 rounded-lg dark:text-white"
                                       onblur="saveField('price')" onkeydown="handleKeyDown(event, 'price')">
                            </div>
                            
                            <!-- ✅ Stock - Editable -->
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">Stock:</p>
                                <div id="stockDisplay" class="cursor-pointer hover:bg-green-100 dark:hover:bg-green-800/30 p-2 rounded transition" onclick="editField('stock')">
                                    <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $product->stock_quantity }}</span> units ✏️
                                </div>
                                <input id="stockEdit" type="number" min="0" value="{{ $product->stock_quantity }}" 
                                       class="hidden text-2xl font-bold text-blue-900 dark:text-blue-100 bg-transparent edit-input w-full p-2 rounded-lg dark:text-white"
                                       onblur="saveField('stock')" onkeydown="handleKeyDown(event, 'stock')">
                            </div>
                            
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                                    SKU: <span class="text-xl font-bold text-blue-900 dark:text-blue-100">{{ $product->product_sku }}</span>
                                </p>
                            </div>
                            
                            <!-- ✅ Weight - Editable -->
                            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">Weight:</p>
                                <div id="weightDisplay" class="cursor-pointer hover:bg-purple-100 dark:hover:bg-purple-800/30 p-2 rounded transition" onclick="editField('weight')">
                                    <span class="text-xl font-bold text-blue-900 dark:text-blue-100">{{ $product->weight }}</span> kg ✏️
                                </div>
                                <input id="weightEdit" type="number" step="0.1" min="0" value="{{ $product->weight }}" 
                                       class="hidden text-xl font-bold text-blue-900 dark:text-blue-100 bg-transparent edit-input w-full p-2 rounded-lg dark:text-white"
                                       onblur="saveField('weight')" onkeydown="handleKeyDown(event, 'weight')">
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                            <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                                Country of Origin: <span class="text-xl font-bold text-blue-900 dark:text-blue-100">{{ $product->country_of_origin }}</span>
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                Created: {{ $product->created_at->format('F d, Y \a\t H:i') }}
                            </p>
                            @if($product->updated_at != $product->created_at)
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Last updated: {{ $product->updated_at->format('F d, Y \a\t H:i') }}
                                </p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4">
                            <button onclick="deleteProduct({{ $product->product_id }})" 
                                    class="text-xl bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Product
                            </button>
                        </div>

                        <!-- ✅ Edit Instructions -->
                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                💡 <strong>Quick Edit:</strong> Click on product name, price, stock, or weight to edit inline. Press Enter to save or click outside to cancel.
                            </p>
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
        // ✅ INLINE EDITING FUNCTIONALITY
        let originalValues = {
            productName: '{{ $product->product_name }}',
            price: {{ $product->price }},
            stock: {{ $product->stock_quantity }},
            weight: {{ $product->weight }}
        };

        function editField(field) {
            const display = document.getElementById(field + 'Display');
            const edit = document.getElementById(field + 'Edit');
            
            if (display && edit) {
                display.classList.add('hidden');
                edit.classList.remove('hidden');
                edit.focus();
                edit.select();
            }
        }

        function cancelEdit(field) {
            const display = document.getElementById(field + 'Display');
            const edit = document.getElementById(field + 'Edit');
            
            if (display && edit) {
                edit.value = originalValues[field];
                edit.classList.add('hidden');
                display.classList.remove('hidden');
            }
        }

        function handleKeyDown(event, field) {
            if (event.key === 'Enter') {
                saveField(field);
            } else if (event.key === 'Escape') {
                cancelEdit(field);
            }
        }

        async function saveField(field) {
            const edit = document.getElementById(field + 'Edit');
            const newValue = edit.value.trim();
            
            // Validation
            if (!newValue) {
                cancelEdit(field);
                return;
            }

            if (field === 'price' && (parseFloat(newValue) < 0 || isNaN(parseFloat(newValue)))) {
                showError('Price must be a valid positive number');
                cancelEdit(field);
                return;
            }

            if ((field === 'stock' || field === 'weight') && (parseFloat(newValue) < 0 || isNaN(parseFloat(newValue)))) {
                showError(`${field.charAt(0).toUpperCase() + field.slice(1)} must be a valid positive number`);
                cancelEdit(field);
                return;
            }

            // If no change, just cancel
            if (newValue == originalValues[field]) {
                cancelEdit(field);
                return;
            }

            try {
                // Show loading state
                edit.disabled = true;
                edit.classList.add('opacity-50');

                const response = await fetch(`/product/{{ $product->product_id }}/update-field`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        field: field,
                        value: newValue
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update display
                    updateDisplay(field, newValue);
                    originalValues[field] = newValue;
                    showSuccess(`${field.charAt(0).toUpperCase() + field.slice(1)} updated successfully!`);
                } else {
                    throw new Error(data.message || 'Update failed');
                }

            } catch (error) {
                console.error('Error:', error);
                showError(`Failed to update ${field}: ${error.message}`);
                cancelEdit(field);
            } finally {
                edit.disabled = false;
                edit.classList.remove('opacity-50');
            }
        }

        function updateDisplay(field, value) {
            const display = document.getElementById(field + 'Display');
            const edit = document.getElementById(field + 'Edit');

            if (field === 'productName') {
                display.innerHTML = `${value} ✏️`;
            } else if (field === 'price') {
                display.innerHTML = `<span class="text-2xl font-bold text-blue-900 dark:text-blue-100">$${parseFloat(value).toFixed(2)}</span> ✏️`;
            } else if (field === 'stock') {
                display.innerHTML = `<span class="text-2xl font-bold text-blue-900 dark:text-blue-100">${value}</span> units ✏️`;
            } else if (field === 'weight') {
                display.innerHTML = `<span class="text-xl font-bold text-blue-900 dark:text-blue-100">${value}</span> kg ✏️`;
            }

            edit.classList.add('hidden');
            display.classList.remove('hidden');
        }

        function showSuccess(message) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const title = popup.querySelector('.swal2-title');
                        const content = popup.querySelector('.swal2-html-container');
                        if (title) title.style.color = '#1f2937';
                        if (content) content.style.color = '#1f2937';
                    }
                }
            });
        }

        function showError(message) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const title = popup.querySelector('.swal2-title');
                        const content = popup.querySelector('.swal2-html-container');
                        if (title) title.style.color = '#1f2937';
                        if (content) content.style.color = '#1f2937';
                    }
                }
            });
        }

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
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const title = popup.querySelector('.swal2-title');
                        const content = popup.querySelector('.swal2-html-container');
                        if (title) title.style.color = '#1f2937';
                        if (content) content.style.color = '#1f2937';
                    }
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
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const title = popup.querySelector('.swal2-title');
                        const content = popup.querySelector('.swal2-html-container');
                        if (title) title.style.color = '#1f2937';
                        if (content) content.style.color = '#1f2937';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });

        // Delete Product Function
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
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const title = popup.querySelector('.swal2-title');
                        const content = popup.querySelector('.swal2-html-container');
                        if (title) title.style.color = '#1f2937';
                        if (content) content.style.color = '#1f2937';
                    }
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
                                color: isDarkSuccess ? '#ffffff' : '#1f2937',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDarkSuccess) {
                                        popup.classList.add('swal2-dark');
                                    } else {
                                        popup.style.color = '#1f2937';
                                        const title = popup.querySelector('.swal2-title');
                                        const content = popup.querySelector('.swal2-html-container');
                                        if (title) title.style.color = '#1f2937';
                                        if (content) content.style.color = '#1f2937';
                                    }
                                }
                            }).then(() => {
                                // Redirect to products list after deletion
                                window.location.href = '/myproduct';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                background: isDark ? '#374151' : '#ffffff',
                                color: isDark ? '#ffffff' : '#1f2937',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDark) {
                                        popup.classList.add('swal2-dark');
                                    } else {
                                        popup.style.color = '#1f2937';
                                        const title = popup.querySelector('.swal2-title');
                                        const content = popup.querySelector('.swal2-html-container');
                                        if (title) title.style.color = '#1f2937';
                                        if (content) content.style.color = '#1f2937';
                                    }
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
                            color: isDark ? '#ffffff' : '#1f2937',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (isDark) {
                                    popup.classList.add('swal2-dark');
                                } else {
                                    popup.style.color = '#1f2937';
                                    const title = popup.querySelector('.swal2-title');
                                    const content = popup.querySelector('.swal2-html-container');
                                    if (title) title.style.color = '#1f2937';
                                    if (content) content.style.color = '#1f2937';
                                }
                            }
                        });
                    });
                }
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
    </script>
</body>

</html>