<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->product_name }} | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="home-bg min-h-screen dark:bg-slate-900">
    <!-- Header/Navbar -->
    

    <!-- Main Content -->
    <section class="container mx-auto px-6 py-16">
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

                <!-- Product Details Section -->
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Product Image & Exporter Info -->
                    <div class="flex flex-col items-center md:items-start">
                        @if($product->product_image)
                            <img src="{{ asset($product->product_image) }}"
                                alt="{{ $product->product_name }}" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0 shadow-md">
                        @else
                            <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                                alt="No Image" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0 shadow-md">
                        @endif
                        
                        <!-- Exporter Info -->
                        <a href="{{ route('other.profile', $product->user->user_id) }}" 
                           class="flex items-center gap-3 mt-6 bg-blue-700 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 p-4 rounded-lg shadow-sm transition group">
                            @if($product->user->profile_picture)
                                <img src="{{ asset($product->user->profile_picture) }}" alt="{{ $product->user->name }}"
                                    class="w-[70px] h-[70px] rounded-full ml-3 object-cover">
                            @else
                                <div class="w-[70px] h-[70px] rounded-full ml-3 bg-blue-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <div class="flex flex-col ml-2 flex-1">
                                <p class="text-xl font-medium text-white">{{ $product->user->name }}</p>
                                <p class="text-lg font-medium text-white">{{ $product->user->country }}</p>
                                <p class="text-sm text-blue-100">{{ $product->user->phone }}</p>
                            </div>
                        </a>
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-blue-900 dark:text-blue-100 mb-8 mt-3">{{ $product->product_name }}</h1>
                        
                        <!-- Product info grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                                    Price: <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">${{ number_format($product->price, 2) }}</span>
                                </p>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <p class="text-lg text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                                    Stock: <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $product->stock_quantity }}</span> units
                                </p>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg mb-6">
                            <label class="text-lg font-semibold text-blue-700 dark:text-blue-300 block mb-3">Import Quantity:</label>
                            <div class="flex items-center space-x-3">
                                <button onclick="decreaseQuantity()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg font-bold transition">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                    class="w-20 h-10 text-center border-2 border-blue-300 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-bold">
                                <button onclick="increaseQuantity()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg font-bold transition">+</button>
                            </div>
                        </div>

                        <!-- Import Button -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="addToCart()"
                                class="text-xl bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                Add to Import Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ✅ FIXED COMMENT SECTION -->
                <div class="mt-12 border-t dark:border-gray-600 pt-8">
                    <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">
                        Product Reviews & Comments
                        <span id="commentCount" class="text-lg font-normal text-gray-600 dark:text-gray-400">
                            ({{ $product->comments->count() }} reviews)
                        </span>
                    </h2>
                    
                    <!-- Comment Form -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6 mb-8 border border-blue-200 dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Write a Review
                        </h3>
                        
                        <!-- ✅ FIXED FORM WITH CORRECT IDs -->
                        <form id="commentForm" class="space-y-6">
                            @csrf
                            <input type="hidden" id="productId" value="{{ $product->product_id }}">
                            
                            <!-- Rating Stars -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-3">Your Rating</label>
                                <div class="flex gap-2" id="starRating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" onclick="setRating({{ $i }})" 
                                                class="star text-3xl text-gray-300 hover:text-yellow-400 transition-all duration-200" 
                                                data-rating="{{ $i }}">★</button>
                                    @endfor
                                </div>
                                <input type="hidden" id="rating" name="rating" value="5">
                            </div>

                            <!-- ✅ FIXED TEXTAREA ID -->
                            <div>
                                <label for="commentText" class="block text-gray-700 dark:text-gray-300 font-medium mb-3">Your Review</label>
                                <textarea id="commentText" name="comment_text" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                    placeholder="Share your experience with this product..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" id="submitBtn"
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Submit Review
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Comments Display -->
                    <div id="commentsContainer">
                        @if($product->comments->count() > 0)
                            <div id="commentsList" class="space-y-6">
                                @foreach($product->comments as $comment)
                                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center gap-4">
                                            @if($comment->user->profile_picture)
                                                <img src="{{ asset($comment->user->profile_picture) }}" 
                                                     alt="{{ $comment->user->name }}" 
                                                     class="w-12 h-12 rounded-full object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->user->country }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <div class="flex text-yellow-400 text-lg mb-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $comment->rating)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $comment->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $comment->comment_text }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div id="noComments" class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No reviews yet</h3>
                                <p class="text-gray-500 dark:text-gray-400">Be the first to review this product!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ SINGLE CLEAN JAVASCRIPT -->
    <script>
        console.log('Page loaded, initializing...');

        // Global variables
        let currentRating = 5;

        // Dark mode toggle
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
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

        // Initialize rating
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up form...');
            setRating(5);
            
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
                        Swal.fire({
                            icon: 'warning',
                            title: 'Review Too Short',
                            text: 'Please write at least 10 characters for your review.'
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Review Submitted!',
                                text: 'Thank you for your review.'
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Failed to submit review. Please try again.'
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

        // Quantity controls
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            const maxStock = {{ $product->stock_quantity }};
            if (currentValue < maxStock) {
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

        // Add to cart function
        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);
            
            Swal.fire({
                title: 'Add to Import Cart?',
                text: `Add ${quantity} units to your import cart?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, add to cart!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Added to Cart!',
                        text: 'Product has been added to your import cart.',
                        icon: 'success'
                    });
                    document.getElementById('quantity').value = 1;
                }
            });
        }
    </script>
</body>
</html>