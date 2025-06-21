<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Request Produk - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
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
        /* SweetAlert2 Dark Mode Fix*/
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
<body class="bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navbarimportir')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Request Form -->
            <div class="bg-whiteoverflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-600">Request New Product</h2>
                    <p class="text-sm text-blue-600 mt-1">
                        Can't find the product you are looking for? Send a request to the exporter.
                    </p>
                </div>
                <div class="p-6">
                    <form id="requestForm" action="{{ route('importir.request.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="request_text" class="block text-sm font-medium text-blue-700 mb-2">
                                Requested Product Description
                            </label>
                            <textarea 
                                id="request_text" 
                                name="request_text" 
                                rows="4" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Example: I am looking for premium quality Arabica coffee from Indonesia with a minimum volume of 500kg..."
                                required
                            ></textarea>
                        </div>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Send Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="product overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">Request Pending</h3>
                </div>
                <div class="p-6">
                    @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingRequests as $request)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-blue-600">{{ $request->request_text }}</p>
                                            <p class="text-sm text-blue-500 mt-1">
                                                Dikirim: {{ $request->created_at->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-blue-500">No Pending Request</p>
                    @endif
                </div>
            </div>

            <!-- Approved Requests -->
            <div class="product overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">Request Approved</h3>
                </div>
                <div class="p-6">
                    @if(isset($approvedRequests) && $approvedRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($approvedRequests as $request)
                                <div class="product border border-green-200 rounded-lg p-4"> 
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-blue-90">{{ $request->request_text }}</p>
                                            <p class="text-sm text-blue-600 mt-1">
                                                Disetujui oleh: <span class="font-medium">{{ $request->eksportir->name ?? 'Eksportir' }}</span>
                                            </p>
                                            <p class="text-sm text-blue-500">
                                                Disetujui: {{ $request->approved_at->format('d M Y H:i') }}
                                            </p>
                                            @if($request->product)
                                                <p class="text-sm text-blue-600 mt-1">
                                                    Produk terkait: {{ $request->product->product_name }}
                                                </p>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-blue-500">No Accepted Request</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // CSRF Token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Form submission
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.text())
            .then(data => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Request berhasil dikirim!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>

    <script>
        // Dark Mode Toggle - SAMA seperti importir
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

        // Comment Form Submission - PERBAIKI dengan dark detection
        const commentForm = document.getElementById('commentForm');
        if (commentForm) {
            commentForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const comment = document.getElementById('reviewComment').value;

                if (comment.trim() === '') {
                    const isDark = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Comment Required',
                        text: 'Please write a comment before submitting.',
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
                    title: 'Comment Submitted!',
                    text: 'Thank you for your comment. It has been added successfully.',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
                });

                // Reset form
                this.reset();
            });
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

        // Optional: SweetAlert2 for success feedback
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            // Uncomment below if you want to show alert before submit
            // e.preventDefault();
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Request Submitted!',
            //     text: 'Your product request has been sent. We will contact you soon.',
            //     confirmButtonColor: '#EEA133'
            // }).then(() => {
            //     this.submit();
            // });
        });
    </script>
</body>

</html>