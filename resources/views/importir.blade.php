<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriadGO</title>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .body {
            font-family: poppins, sans-serif;
        }

        /* Carousel Animation Styles */
        .product-carousel {
            position: relative;
            overflow: hidden;
        }

        .product-slide {
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.6s ease-in-out;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
        }

        .product-slide.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        .product-slide.prev {
            opacity: 0;
            transform: translateX(-100%);
        }

        /* Fade animation for individual products */
        .product-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Progress bar animation */
        .progress-bar {
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b, #d97706);
            border-radius: 2px;
            transition: width 5s linear;
        }

        .progress-bar.active {
            width: 100%;
        }

        /* Hover effects */
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .pulse-on-hover:hover {
            animation: pulse 0.5s ease-in-out;
        }

        /* Tambahkan di dalam tag <style> di head atau di app.css */

/* Dark mode untuk product cards */
html.dark .product-card {
    background-color: #2d3748 !important;
    color: #f7fafc;
}

/* Dark mode untuk teks dalam product card */
html.dark .product-card h5,
html.dark .product-card p {
    color: #f7fafc;
}

/* Dark mode untuk category badge */
html.dark .product-card .bg-blue-100 {
    background-color: #4a5568 !important;
    color: #f7fafc !important;
}

/* Dark mode untuk exporter info section */
html.dark .product-card .bg-blue-50 {
    background-color: #4a5568 !important;
}

html.dark .product-card .text-blue-600 {
    color: #63b3ed !important;
}

html.dark .product-card .text-blue-400 {
    color: #90cdf4 !important;
}

/* Dark mode untuk fallback card */
html.dark .product-card.bg-white {
    background-color: #2d3748 !important;
}

html.dark .product-card .text-blue-700 {
    color: #90cdf4 !important;
}
    </style>

    <script src="https://cdn.tailwindcss.com">
        tailwind.config = {
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
</head>

<body class="home-bg"></body>
<section id="home">

    @include('layouts.navbarimportir')

    <section class="flex container mx-auto px-6 md:px-12 py-16  flex-col md:flex-row items-center">
        <div class="md:w-1/2 text-center md:text-left ml-12 mr-6">
            <h2 class="text-4xl font-extrabold text-blue-900 mb-6 ml-6 leading-tight fade-in-up">
                <span class="text-amber-500">Hello Importer !</span> <br>Welcome to TriadGO Import Hub
            </h2>

            <p class="text-lg text-justify text-blue-700 mb-8 ml-6 max-w-xl fade-in-up" style="animation-delay:0.4s">
                Find the best solution for your import needs. We provide a platform that makes it easy for you to
                conduct international transactions safely and efficiently.
            </p>
            <a href="{{ route('catalog') }}"
                class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 ml-4 rounded-md shadow-md fade-in-up"
                style="animation-delay:0.6s">
                Find Products here
            </a>
        </div>
        <div class="mt-10 fade-in-up">
            <img src="https://ik.imagekit.io/hplmjgnnw/containershipV2%20(1).png?updatedAt=1748035307076"
                alt="Impor photo"
                class="floating-img ml-6 w-[500px] h-auto" />
        </div>
    </section>

    <section id="" class=" py-16 fade-in-up">
        <div class="container mx-auto px-6 md:px-12">
            <h3 class="text-3xl font-bold text-blue-900 mb-12 text-center">Our Import Solutions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                <div
                    class="export-card bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition hover:border-amber-500 border-2 border-transparent">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"   />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">TriadGo Catalog
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Explore the TriadGo 's catalog of exporter products, search for product by name or by products country.
                    </p>
                    <a href="{{ route('catalog') }}" class="text-blue-800 font-semibold inline-flex items-center mt-4 hover:text-amber-500">
                        Go
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div
                    class="export-card bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition hover:border-amber-500 border-2 border-transparent">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Request for Products
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        If you can't find what you're looking for, submit a request and exporter will help you find it.
                    </p>
                    <a href="#" class="text-blue-800 font-semibold inline-flex items-center mt-4 hover:text-amber-500">
                        Go
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div
                    class="export-card bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition hover:border-amber-500 border-2 border-transparent">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Transactions Management
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Manage your transactions efficiently with our tracking status features, share provide real-time updates .
                    </p>
                    <a href="#" class="text-blue-800 font-semibold inline-flex items-center mt-4 hover:text-amber-500">
                        Go
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- UPDATED: Top Imported Products dengan data dinamis dari database -->
    <div class="container mx-auto px-6 py-16 slide-in mt-4 mb-8">
        <div class="text-center mb-8">
            <h3 class="text-3xl font-bold text-blue-900 mb-4">Top Imported Products</h3>
            <p class="text-blue-600">Discover the latest approved products from our trusted exporters</p>
            
            <!-- Progress Bar for Carousel -->
            <div class="w-full max-w-md mx-auto mt-4 bg-gray-200 rounded-full h-1">
                <div class="progress-bar bg-gradient-to-r from-amber-500 to-orange-500 rounded-full" id="progressBar"></div>
            </div>
        </div>

        @if(isset($topProducts) && $topProducts->count() > 0)
            <div class="product-carousel relative">
                @php
                    $productChunks = $topProducts->chunk(3); // Group products into chunks of 3
                @endphp
                
                 @foreach($productChunks as $index => $chunk)
                    <div class="product-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($chunk as $product)
                                <!-- FIXED: Product Card dengan Background yang Proper -->
                                <div class="product-card shadow-lg rounded-xl p-6 max-w-md mx-auto transform transition-all duration-300 hover:scale-105 border dark:border-gray-600">
                                    <div class="text-center">
                                        <h5 class="text-xl font-bold mb-3 line-clamp-2">{{ $product->product_name }}</h5>
                                        
                                        @if($product->product_image)
                                            <img src="{{ asset($product->product_image) }}" 
                                                 alt="{{ $product->product_name }}" 
                                                 class="w-32 h-32 mx-auto object-cover rounded-lg shadow-md mb-4" />
                                        @else
                                            <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                                                 alt="No Image" class="w-32 h-32 mx-auto object-cover rounded-lg shadow-md mb-4" />
                                        @endif
                                        
                                        <p class="product-description text-sm mb-4 line-clamp-3">
                                            {{ Str::limit($product->product_description, 80) }}
                                        </p>

                                        <!-- Price and Category -->
                                        <div class="mb-4">
                                            <span class="category-badge px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ $product->category }}
                                            </span>
                                            <p class="price text-lg font-bold mt-2">
                                                ${{ number_format($product->price, 2) }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Exporter Info -->
                                    <div class="flex items-center gap-3 mb-4 exporter-info p-3 rounded-lg">
                                        @if($product->user && $product->user->profile_picture)
                                            <img src="{{ asset($product->user->profile_picture) }}" 
                                                 alt="{{ $product->user->name }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center text-white font-bold">
                                                {{ $product->user ? strtoupper(substr($product->user->name, 0, 1)) : 'U' }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col flex-1">
                                            <p class="exporter-name text-sm font-bold">
                                                {{ $product->user ? $product->user->name : 'Unknown Exporter' }}
                                            </p>
                                            <p class="exporter-country text-xs font-semibold">
                                                {{ $product->user ? $product->user->country : 'Unknown Country' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <a href="{{ route('product.detail.importir', $product->product_id) }}"
                                        class="w-full inline-block text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 dark:from-blue-500 dark:to-blue-600 dark:hover:from-blue-600 dark:hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg text-sm transition-all duration-300 transform hover:scale-105 pulse-on-hover shadow-lg">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            See Detail
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Carousel Controls -->
                @if($productChunks->count() > 1)
                    <div class="flex justify-center mt-8 space-x-2">
                        @foreach($productChunks as $index => $chunk)
                            <button class="carousel-dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-amber-500' : 'bg-gray-300' }}" 
                                    data-slide="{{ $index }}" onclick="goToSlide({{ $index }})">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <!-- Fallback content jika tidak ada produk -->
            <div class="text-center py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sample Product 1 -->
                    <div class="product-card bg-white shadow-lg rounded-xl p-6 max-w-md mx-auto">
                        <h5 class="text-xl font-bold text-amber-500 mb-3">No Products Available</h5>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-32 h-32 mx-auto rounded-lg shadow-md mb-4" />
                        <p class="text-sm text-blue-700 mb-4">
                            Currently no approved products are available. Please check back later.
                        </p>
                        <a href="{{ route('catalog') }}"
                            class="w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-sm transition">
                            Browse Catalog
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <footer class="bg-blue-800 text-blue-100 py-6 mt-auto">
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
</section>

<script>
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

    // Product Carousel Logic
    let currentSlide = 0;
    let slideInterval;
    let progressInterval;
    const slides = document.querySelectorAll('.product-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const progressBar = document.getElementById('progressBar');

    function showSlide(index) {
        // Hide all slides
        slides.forEach((slide, i) => {
            slide.classList.remove('active', 'prev');
            if (i === index) {
                slide.classList.add('active');
            } else if (i < index) {
                slide.classList.add('prev');
            }
        });

        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-amber-500', i === index);
            dot.classList.toggle('bg-gray-300', i !== index);
        });

        currentSlide = index;
    }

    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
    }

    function goToSlide(index) {
        showSlide(index);
        resetCarousel();
    }

    function startProgressBar() {
        if (progressBar) {
            progressBar.classList.remove('active');
            setTimeout(() => {
                progressBar.classList.add('active');
            }, 100);
        }
    }

    function resetCarousel() {
        clearInterval(slideInterval);
        clearInterval(progressInterval);
        
        if (slides.length > 1) {
            startProgressBar();
            slideInterval = setInterval(nextSlide, 5000);
        }
    }

    // Initialize carousel if there are multiple slides
    if (slides.length > 1) {
        startProgressBar();
        slideInterval = setInterval(nextSlide, 5000);

        // Pause carousel on hover
        const carousel = document.querySelector('.product-carousel');
        if (carousel) {
            carousel.addEventListener('mouseenter', () => {
                clearInterval(slideInterval);
                if (progressBar) progressBar.style.animationPlayState = 'paused';
            });

            carousel.addEventListener('mouseleave', () => {
                resetCarousel();
            });
        }
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
        link.addEventListener('click', function(event) {
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
        openSidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('hidden');
        });

        closeSidebarBtn.addEventListener('click', function() {
            sidebar.classList.add('hidden');
        });

        // Tutup sidebar jika klik di luar sidebar
        sidebar.addEventListener('click', function(e) {
            if (e.target === sidebar) {
                sidebar.classList.add('hidden');
            }
        });

        // Scroll to section dari sidebar
        sidebar.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                sidebar.classList.add('hidden');
                const targetId = this.getAttribute('href').substring(1);
                scrollToSectionWithSlide(targetId);
            });
        });
    }

    // SweetAlert2 Logout Desktop
    document.getElementById('logoutBtn')?.addEventListener('click', function(e) {
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
    document.getElementById('logoutBtnMobile')?.addEventListener('click', function(e) {
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