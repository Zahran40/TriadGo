<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews & Responses | TriadGO</title>
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
        
        /* ✅ HOVER EFFECTS FOR CLICKABLE ELEMENTS */
        .clickable-title {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .clickable-title:hover {
            color: #fbbf24 !important;
            text-decoration: underline;
            transform: translateX(5px);
        }
        
        .profile-btn {
            transition: all 0.3s ease;
        }
        
        .profile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
    <!-- Back Buttons -->
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center gap-3 mb-6">
            <button onclick="goBack()" 
                    class="back-btn-hover bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </button>
            
            <a href="{{ route('ekspor') }}" 
               class="bg-gray-600 hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8 transition-colors duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-3">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 0v10a2 2 0 002 2h6a2 2 0 002-2V8M9 12h6"></path>
                        </svg>
                        Customer Reviews & Feedback
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Reviews and comments for your products from importers worldwide
                    </p>
                </div>
                
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 text-white px-6 py-3 rounded-lg shadow-lg">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $comments->count() }}</div>
                        <div class="text-sm opacity-90">Total Reviews</div>
                    </div>
                </div>
            </div>
        </div>

        @if($comments->count() > 0)
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Average Rating</p>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($comments->avg('rating'), 1) }}</p>
                        </div>
                        <div class="text-yellow-400 text-2xl">★</div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">5-Star Reviews</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $comments->where('rating', 5)->count() }}</p>
                        </div>
                        <div class="text-green-500 text-2xl">🌟</div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">This Month</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $comments->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                        <div class="text-blue-500 text-2xl">📅</div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Products Reviewed</p>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $commentsByProduct->count() }}</p>
                        </div>
                        <div class="text-purple-500 text-2xl">📦</div>
                    </div>
                </div>
            </div>

            <!-- Comments by Product -->
            @foreach($commentsByProduct as $productName => $productComments)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-8 overflow-hidden transition-colors duration-300">
                <!-- ✅ CLICKABLE PRODUCT HEADER -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700 text-white p-6 cursor-pointer hover:from-blue-700 hover:to-indigo-700 transition-all duration-300" 
                     onclick="goToProduct({{ $productComments->first()->product_id }})">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="clickable-title text-xl font-bold mb-2 flex items-center gap-2">
                                {{ $productName }}
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </h2>
                            <div class="flex items-center gap-4">
                                <span class="bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-10 px-3 py-1 rounded-full text-sm">
                                    {{ $productComments->count() }} Reviews
                                </span>
                                <span class="bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-10 px-3 py-1 rounded-full text-sm">
                                    ★ {{ number_format($productComments->avg('rating'), 1) }} Average
                                </span>
                            </div>
                            <p class="text-sm opacity-80 mt-2">
                                💡 Click to view product details
                            </p>
                        </div>
                        
                        <div class="text-right">
                            <div class="text-3xl mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($productComments->avg('rating')))
                                        <span class="text-yellow-300">★</span>
                                    @else
                                        <span class="text-white text-opacity-30">★</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments for this Product -->
                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($productComments->sortByDesc('created_at') as $comment)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    @if($comment->user->profile_picture)
                                        <img src="{{ asset($comment->user->profile_picture) }}" 
                                             alt="{{ $comment->user->name }}" 
                                             class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 dark:border-blue-600">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $comment->user->country }}
                                        </p>
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
                                        {{ $comment->created_at->format('M d, Y \a\t H:i') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 transition-colors duration-300">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    "{{ $comment->comment_text }}"
                                </p>
                            </div>
                            
                            <!-- ✅ FIXED CHECK PROFILE BUTTON -->
                            <div class="flex justify-end mt-4">
                                <a href="{{ route('other.profile', $comment->user->user_id) }}" 
                                   class="profile-btn bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Check Profile
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

        @else
            <!-- No Comments State -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center transition-colors duration-300">
                <svg class="w-24 h-24 text-gray-400 dark:text-gray-500 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 0v10a2 2 0 002 2h6a2 2 0 002-2V8M9 12h6"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Reviews Yet</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    You haven't received any reviews for your products yet. Keep promoting your products to get more feedback from importers!
                </p>
                <a href="{{ route('myproduct') }}" 
                   class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    View My Products
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-blue-800 dark:bg-slate-900 text-blue-100 dark:text-blue-200 py-6 mt-20 transition-colors duration-300">
        <div class="container mx-auto px-6 text-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
        </div>
    </footer>

    <!-- ✅ IMPROVED JAVASCRIPT WITH NAVIGATION FUNCTIONS -->
    <script>
        // ✅ GO TO PRODUCT FUNCTION
        function goToProduct(productId) {
            // Navigate to product detail page for eksportir
            window.location.href = `/product-detail/${productId}`;
        }

        // ✅ BACK BUTTON FUNCTION
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '{{ route("ekspor") }}';
            }
        }

        // Contact Reviewer Function
        function contactReviewer(name, phone) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Contact Reviewer',
                html: `
                    <div class="text-left space-y-3">
                        <p><strong>Reviewer:</strong> ${name}</p>
                        <p><strong>Phone:</strong> ${phone}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-4">
                            You can reach out to thank them for their review or address any concerns they may have mentioned.
                        </p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Send Message',
                cancelButtonText: 'Close',
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#000000',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                        popup.style.backgroundColor = '#374151';
                        popup.style.color = '#ffffff';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const isDarkSuccess = document.documentElement.classList.contains('dark');
                    
                    Swal.fire({
                        title: 'Message Sent!',
                        text: 'Your message has been sent to the reviewer.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        background: isDarkSuccess ? '#374151' : '#ffffff',
                        color: isDarkSuccess ? '#ffffff' : '#000000',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDarkSuccess) {
                                popup.classList.add('swal2-dark');
                                popup.style.backgroundColor = '#374151';
                                popup.style.color = '#ffffff';
                            }
                        }
                    });
                }
            });
        }

        // Thank Reviewer Function
        function thankReviewer(name) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Thank You Message',
                text: `Send a thank you message to ${name} for their review?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Send Thanks',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#000000',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) {
                        popup.classList.add('swal2-dark');
                        popup.style.backgroundColor = '#374151';
                        popup.style.color = '#ffffff';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const isDarkSuccess = document.documentElement.classList.contains('dark');
                    
                    Swal.fire({
                        title: 'Thank You Sent!',
                        text: 'Your appreciation message has been sent to the reviewer.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        background: isDarkSuccess ? '#374151' : '#ffffff',
                        color: isDarkSuccess ? '#ffffff' : '#000000',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDarkSuccess) {
                                popup.classList.add('swal2-dark');
                                popup.style.backgroundColor = '#374151';
                                popup.style.color = '#ffffff';
                            }
                        }
                    });
                }
            });
        }

        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.addEventListener('change', () => {
                document.documentElement.classList.toggle('dark');
                const isDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            // ESC key to go back
            if (event.key === 'Escape') {
                goBack();
            }
        });

        // Add click sound effect (optional)
        function playClickSound() {
            // Create a subtle click sound
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LKeSAFLYHO8tiJNwgZaLvt559NEAxQp+Pw==');
            audio.volume = 0.1;
            audio.play().catch(() => {
                // Ignore errors if audio can't play
            });
        }

        // Add click effect to clickable elements
        document.querySelectorAll('.clickable-title, .profile-btn').forEach(element => {
            element.addEventListener('click', playClickSound);
        });

        console.log('Response page loaded with navigation functions');
    </script>
</body>

                     
               

       
</html>