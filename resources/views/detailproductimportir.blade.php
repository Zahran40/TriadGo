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
    </style>
</head>

<body class="home-bg min-h-screen dark:bg-slate-900">
    <!-- Header/Navbar -->
    @include('layouts.navbarimportir')

    <!-- Main Content -->
    <section id="" class="container mx-auto px-6 py-16 slide-in">
        <div class="min-h-screen flex items-center justify-center dark:bg-slate-900">
            <div class="product shadow-lg rounded-lg max-w-8xl w-full p-8 bg-white dark:bg-gray-800">
                
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Catalog
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
                          <a href="{{ route('other.profile', $product->user->user_id) }}" class="flex items-center gap-3 mt-6 bg-blue-700 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 p-4 rounded-lg shadow-sm text-3xl font-bold">View Profile</a>
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-blue-900 dark:text-blue-100 mb-4 mt-3">{{ $product->product_name }}</h1>
                        
                        <!-- Category Badge -->
                        <div class="mb-6">
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

                        <!-- Product Description -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-blue-500">
                            <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-2">Product Description</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $product->product_description }}
                            </p>
                        </div>
                        
                        <!-- Product info grid with Weight -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">Price:</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">${{ number_format($product->price, 2) }}</p>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">Stock:</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $product->stock_quantity }} <span class="text-base font-normal">units</span></p>
                            </div>
                            
                            <!-- Weight Information -->
                            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">Weight:</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $product->weight }} <span class="text-base font-normal">kg</span></p>
                            </div>
                            
                            <!-- SKU Information -->
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">SKU:</p>
                                <p class="text-xl font-bold text-blue-900 dark:text-blue-100">{{ $product->product_sku }}</p>
                            </div>
                        </div>

                        <!-- Additional Product Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Country of Origin</p>
                                    <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ $product->country_of_origin }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Listed Date</p>
                                    <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ $product->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg mb-6">
                            <label class="text-lg font-semibold text-blue-700 dark:text-blue-300 block mb-3">Import Quantity:</label>
                            <div class="flex items-center space-x-3 mb-3">
                                <button onclick="decreaseQuantity()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg font-bold transition">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                    class="w-20 h-10 text-center border-2 border-blue-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-bold">
                                <button onclick="increaseQuantity()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg font-bold transition">+</button>
                            </div>
                            
                            <!-- Weight Calculator -->
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p>Total weight: <span id="totalWeight" class="font-semibold text-blue-700 dark:text-blue-300">{{ $product->weight }} kg</span></p>
                                <p>Estimated shipping cost: <span id="shippingCost" class="font-semibold text-green-600 dark:text-green-400">$<span id="shippingAmount">{{ number_format($product->weight * 2.5, 2) }}</span></span></p>
                            </div>
                        </div>

                        <!-- Import Button -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="addToCart()"
                                class="text-xl bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v5a2 2 0 11-4 0v-5m4 0V8a2 2 0 10-4 0v5.01"></path>
                                </svg>
                                Add to Import Cart
                            </button>
                            
                            <!-- Contact Exporter Button -->
                            <button onclick="contactExporter()"
                                class="text-xl bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Contact Exporter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comment Section -->
    <section class="container mx-auto px-6 py-16 slide-in">
        <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">

            <!-- Add Comment Form -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Write a Review
                </h2>

                <form id="commentForm" class="space-y-6">
                    @csrf
                    <input type="hidden" id="productId" value="{{ $product->product_id }}">
                    <input type="hidden" id="rating" value="5">

                    <!-- Rating Stars -->
                    <div>
                        <label class="block text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3">Rating:</label>
                        <div class="flex gap-2 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg onclick="setRating({{ $i }})" class="star w-8 h-8 cursor-pointer transition-colors {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Click on stars to rate this product</p>
                    </div>

                    <!-- Comment Text -->
                    <div>
                        <label for="commentText" class="block text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3">Your Review:</label>
                        <textarea id="commentText" name="comment_text" rows="4" required
                            class="w-full px-4 py-3 border-2 border-blue-300 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none"
                            placeholder="Share your experience with this product... (minimum 10 characters)"></textarea>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Minimum 10 characters required</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                        class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition flex items-center gap-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Submit Review
                        </span>
                    </button>
                </form>
            </div>

            <!-- Display Comments -->
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Customer Reviews ({{ $product->comments->count() }})
                </h3>

                @if($product->comments->count() > 0)
                    @foreach($product->comments as $comment)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border-l-4 border-blue-500">
                            <div class="flex items-start gap-4">
                                @if($comment->user->profile_picture)
                                    <img src="{{ asset($comment->user->profile_picture) }}" alt="{{ $comment->user->name }}"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-semibold text-blue-900 dark:text-blue-100">{{ $comment->user->name }}</h4>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->user->country }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">•</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Rating Stars -->
                                    <div class="flex gap-1 mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $comment->rating }}/5)</span>
                                    </div>

                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $comment->comment_text }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No reviews yet</p>
                        <p class="text-gray-400 dark:text-gray-500">Be the first to review this product!</p>
                    </div>
                @endif
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

    <!-- COMPLETE JAVASCRIPT -->
    <script>
        console.log('Page loaded, initializing...');

        // Global variables
        let currentRating = 5;
        const productWeight = {{ $product->weight }};

        // Dark mode toggle
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }

        // Update weight calculation
        function updateWeightCalculation() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const totalWeight = (productWeight * quantity).toFixed(2);
            const shippingCost = (totalWeight * 2.5).toFixed(2); // $2.5 per kg
            
            document.getElementById('totalWeight').textContent = totalWeight + ' kg';
            document.getElementById('shippingAmount').textContent = shippingCost;
        }

        // Quantity controls
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            const maxStock = {{ $product->stock_quantity }};
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
                updateWeightCalculation();
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateWeightCalculation();
            }
        }

        // Contact Exporter Function
        function contactExporter() {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Contact Exporter',
                html: `
                    <div class="text-left">
                        <p class="mb-3"><strong>{{ $product->user->name }}</strong></p>
                        <p class="mb-2">📧 Email: <a href="mailto:{{ $product->user->email }}" class="text-blue-600">{{ $product->user->email }}</a></p>
                        <p class="mb-2">📱 Phone: <a href="tel:{{ $product->user->phone }}" class="text-blue-600">{{ $product->user->phone }}</a></p>
                        <p class="mb-4">🌍 Country: {{ $product->user->country }}</p>
                        <div class="bg-blue-50 p-3 rounded mt-4">
                            <p class="text-sm text-gray-600">
                                💡 <strong>Tip:</strong> Mention product "{{ $product->product_name }}" (SKU: {{ $product->product_sku }}) when contacting.
                            </p>
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                width: '500px',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const content = popup.querySelector('.swal2-html-container');
                        if (content) content.style.color = '#1f2937';
                    }
                }
            });
        }

        // Add to cart function with weight info
        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);
            const totalWeight = (productWeight * quantity).toFixed(2);
            const shippingCost = (totalWeight * 2.5).toFixed(2);
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Add to Import Cart?',
                html: `
                    <div class="text-left">
                        <p class="mb-2"><strong>Product:</strong> {{ $product->product_name }}</p>
                        <p class="mb-2"><strong>Quantity:</strong> ${quantity} units</p>
                        <p class="mb-2"><strong>Unit Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p class="mb-2"><strong>Total Weight:</strong> ${totalWeight} kg</p>
                        <p class="mb-4"><strong>Est. Shipping:</strong> $${shippingCost}</p>
                        <div class="bg-blue-50 p-3 rounded">
                            <p class="text-sm"><strong>Total Est. Cost:</strong> $${(quantity * {{ $product->price }} + parseFloat(shippingCost)).toFixed(2)}</p>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, add to cart!',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#1f2937',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                    } else {
                        popup.style.color = '#1f2937';
                        const content = popup.querySelector('.swal2-html-container');
                        if (content) content.style.color = '#1f2937';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Added to Cart!',
                        text: 'Product has been added to your import cart.',
                        icon: 'success',
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
                    document.getElementById('quantity').value = 1;
                    updateWeightCalculation();
                }
            });
        }

        // Rating system
        function setRating(rating) {
            currentRating = rating;
            const ratingInput = document.getElementById('rating');
            if (ratingInput) {
                ratingInput.value = rating;
            }
            
            const stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Initialize rating and weight calculation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up form...');
            setRating(5);
            updateWeightCalculation();
            
            // Quantity input change listener
            const quantityInput = document.getElementById('quantity');
            if (quantityInput) {
                quantityInput.addEventListener('input', updateWeightCalculation);
            }
            
            // Comment form submission
            const commentForm = document.getElementById('commentForm');
            if (commentForm) {
                console.log('Comment form found');
                
                commentForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    console.log('Form submitted');
                    
                    const commentText = document.getElementById('commentText').value.trim();
                    const rating = document.getElementById('rating').value;
                    const productId = document.getElementById('productId').value;
                    
                    console.log('Form data:', { commentText, rating, productId });
                    
                    if (commentText.length < 10) {
                        const isDark = document.documentElement.classList.contains('dark');
                        
                        Swal.fire({
                            icon: 'warning',
                            title: 'Review Too Short',
                            text: 'Please write at least 10 characters for your review.',
                            background: isDark ? '#374151' : '#ffffff',
                            color: isDark ? '#ffffff' : '#1f2937',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (!isDark) {
                                    popup.style.color = '#1f2937';
                                    const title = popup.querySelector('.swal2-title');
                                    const content = popup.querySelector('.swal2-html-container');
                                    if (title) title.style.color = '#1f2937';
                                    if (content) content.style.color = '#1f2937';
                                }
                            }
                        });
                        return;
                    }
                    
                    // Show loading
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Submitting...';
                    
                    try {
                        const response = await fetch(`/product/${productId}/comment`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                comment_text: commentText,
                                rating: parseInt(rating)
                            })
                        });
                        
                        console.log('Response status:', response.status);
                        const data = await response.json();
                        console.log('Response data:', data);
                        
                        if (data.success) {
                            const isDark = document.documentElement.classList.contains('dark');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Review Submitted!',
                                text: 'Thank you for your review.',
                                background: isDark ? '#374151' : '#ffffff',
                                color: isDark ? '#ffffff' : '#1f2937',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (!isDark) {
                                        popup.style.color = '#1f2937';
                                        const title = popup.querySelector('.swal2-title');
                                        const content = popup.querySelector('.swal2-html-container');
                                        if (title) title.style.color = '#1f2937';
                                        if (content) content.style.color = '#1f2937';
                                    }
                                }
                            });
                            
                            // Reset form
                            commentForm.reset();
                            setRating(5);
                            
                            // Reload page to show new comment
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            throw new Error(data.message || 'Failed to submit review');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        const isDark = document.documentElement.classList.contains('dark');
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Failed to submit review. Please try again.',
                            background: isDark ? '#374151' : '#ffffff',
                            color: isDark ? '#ffffff' : '#1f2937',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (!isDark) {
                                    popup.style.color = '#1f2937';
                                    const title = popup.querySelector('.swal2-title');
                                    const content = popup.querySelector('.swal2-html-container');
                                    if (title) title.style.color = '#1f2937';
                                    if (content) content.style.color = '#1f2937';
                                }
                            }
                        });
                    } finally {
                        // Reset button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = `
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Review
                            </span>
                        `;
                    }
                });
            } else {
                console.error('Comment form not found');
            }
        });

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