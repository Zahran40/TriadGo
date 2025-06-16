<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Dark mode script - harus dijalankan sebelum body load
        (function() {
            const darkMode = localStorage.getItem('darkMode');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (darkMode === 'true' || (darkMode === null && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body class="home-bg min-h-screen flex flex-col transition-colors duration-300">
    <!-- Header dengan Logo dan Dark Mode Toggle -->
    <header class="navbar-background shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo TriadGO yang Benar -->
                <div class="flex items-center space-x-3">
                    <!-- SVG Logo TriadGO -->
                    <div class="w-12 h-12 flex-shrink-0">
                        <svg viewBox="0 0 120 120" class="w-full h-full">
                            <!-- Orange Curve -->
                            <path d="M20 60 Q40 20, 80 30" stroke="#EEA133" stroke-width="8" fill="none" stroke-linecap="round"/>
                            
                            <!-- Ship -->
                            <g fill="#003355">
                                <!-- Ship Hull -->
                                <path d="M30 70 L85 70 L90 85 L25 85 Z"/>
                                <!-- Ship Cabin -->
                                <rect x="35" y="55" width="15" height="15" rx="2"/>
                                <!-- Ship Chimney -->
                                <rect x="38" y="45" width="4" height="10"/>
                                <rect x="43" y="48" width="4" height="7"/>
                                <!-- Windows -->
                                <circle cx="32" cy="77" r="2" fill="white"/>
                                <circle cx="38" cy="77" r="2" fill="white"/>
                                <circle cx="44" cy="77" r="2" fill="white"/>
                            </g>
                            
                            <!-- Airplane -->
                            <g fill="#003355">
                                <ellipse cx="75" cy="35" rx="15" ry="4" transform="rotate(15 75 35)"/>
                                <ellipse cx="70" cy="38" rx="8" ry="3" transform="rotate(15 70 38)"/>
                                <ellipse cx="82" cy="32" rx="6" ry="2" transform="rotate(15 82 32)"/>
                            </g>
                            
                            <!-- Blue Waves -->
                            <path d="M20 90 Q35 85, 50 90 T80 90 T110 90" stroke="#186094" stroke-width="4" fill="none"/>
                            <path d="M15 95 Q30 92, 45 95 T75 95 T105 95" stroke="#186094" stroke-width="3" fill="none" opacity="0.7"/>
                        </svg>
                    </div>
                    
                    <!-- Text Logo -->
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-blue-900 dark:text-blue-100 transition-colors duration-300">
                            Triad<span class="text-orange-500">GO</span>
                        </span>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <label for="darkModeToggle" class="flex items-center cursor-pointer select-none">
                    <span class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-200"
                        style="font-size: 30px">☀️</span>
                    <div class="relative">
                        <input type="checkbox" id="darkModeToggle" class="sr-only" />
                        <div class="block w-12 h-7 rounded-full bg-gray-300 dark:bg-gray-600 transition"></div>
                        <div id="darkModeThumb"
                            class="dot absolute left-1 top-1 w-5 h-5 rounded-full bg-white border border-gray-400 dark:bg-[#003355] transition-transform duration-300">
                        </div>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-200"
                        style="font-size: 30px">🌙</span>
                </label>
                <button class="md:hidden text-blue-700 focus:outline-none" aria-label="Open Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 wiggle" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-8">
        <div class="text-center max-w-2xl mx-auto">
            <!-- 404 Number dengan Animasi -->
            <div class="mb-8 relative">
                <h1 class="text-8xl md:text-9xl lg:text-[12rem] font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-800 to-orange-500 dark:from-blue-400 dark:via-blue-300 dark:to-orange-400 animate-pulse select-none">
                    404
                </h1>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-10 dark:opacity-20">
                    <svg class="w-32 h-32 md:w-48 md:h-48 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <div class="mb-12 space-y-4">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-800 dark:text-blue-300 mb-4 transition-colors duration-300">
                    Oops! Page Not Found
                </h2>
                <p class="text-lg md:text-xl text-blue-600 dark:text-blue-400 mb-6 max-w-lg mx-auto transition-colors duration-300">
                    Sorry, the page you are looking for doesn't exist or you don't have permission to access it.
                </p>
                @if(Auth::check())
                    <div class="inline-flex items-center bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 px-4 py-2 rounded-full text-sm font-medium transition-colors duration-300">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Logged in as: {{ ucfirst(Auth::user()->role) }}
                    </div>
                @endif
            </div>

            <!-- Enhanced Illustration dengan Logo TriadGO -->
            <div class="mb-12 floating-404">
                <div class="inline-block relative">
                    <div class="w-64 h-64 md:w-80 md:h-80 mx-auto bg-gradient-to-br from-blue-50 to-orange-50 dark:from-blue-900/20 dark:to-orange-900/20 rounded-full flex items-center justify-center shadow-2xl">
                        <!-- Logo TriadGO di tengah dengan ukuran besar -->
                        <div class="w-32 h-32 md:w-40 md:h-40 opacity-60 dark:opacity-80">
                            <svg viewBox="0 0 120 120" class="w-full h-full filter drop-shadow-lg">
                                <!-- Orange Curve -->
                                <path d="M20 60 Q40 20, 80 30" stroke="#EEA133" stroke-width="10" fill="none" stroke-linecap="round"/>
                                
                                <!-- Ship -->
                                <g fill="#003355" class="dark:fill-blue-300">
                                    <!-- Ship Hull -->
                                    <path d="M30 70 L85 70 L90 85 L25 85 Z"/>
                                    <!-- Ship Cabin -->
                                    <rect x="35" y="55" width="15" height="15" rx="2"/>
                                    <!-- Ship Chimney -->
                                    <rect x="38" y="45" width="4" height="10"/>
                                    <rect x="43" y="48" width="4" height="7"/>
                                    <!-- Windows -->
                                    <circle cx="32" cy="77" r="2" fill="white"/>
                                    <circle cx="38" cy="77" r="2" fill="white"/>
                                    <circle cx="44" cy="77" r="2" fill="white"/>
                                </g>
                                
                                <!-- Airplane -->
                                <g fill="#003355" class="dark:fill-blue-300">
                                    <ellipse cx="75" cy="35" rx="15" ry="4" transform="rotate(15 75 35)"/>
                                    <ellipse cx="70" cy="38" rx="8" ry="3" transform="rotate(15 70 38)"/>
                                    <ellipse cx="82" cy="32" rx="6" ry="2" transform="rotate(15 82 32)"/>
                                </g>
                                
                                <!-- Blue Waves -->
                                <path d="M20 90 Q35 85, 50 90 T80 90 T110 90" stroke="#186094" stroke-width="5" fill="none"/>
                                <path d="M15 95 Q30 92, 45 95 T75 95 T105 95" stroke="#186094" stroke-width="4" fill="none" opacity="0.7"/>
                            </svg>
                        </div>
                        
                        <!-- Floating Question Marks -->
                        <div class="absolute top-8 left-8 text-4xl text-blue-600 dark:text-blue-400 opacity-40 animate-bounce" style="animation-delay: 0.5s">?</div>
                        <div class="absolute top-12 right-12 text-3xl text-orange-500 dark:text-orange-400 opacity-50 animate-bounce" style="animation-delay: 1s">?</div>
                        <div class="absolute bottom-16 left-12 text-5xl text-blue-700 dark:text-blue-300 opacity-30 animate-bounce" style="animation-delay: 1.5s">?</div>
                        <div class="absolute bottom-8 right-8 text-4xl text-orange-600 dark:text-orange-300 opacity-40 animate-bounce" style="animation-delay: 2s">?</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-6">
                @php
                    $userRole = $userRole ?? (Auth::check() ? Auth::user()->role : 'guest');
                    
                    // Tentukan home URL berdasarkan role
                    $homeUrl = '/';
                    $homeText = 'Back to Homepage';
                    $homeIcon = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6';
                    
                    switch($userRole) {
                        case 'admin':
                            $homeUrl = '/admin1';
                            $homeText = 'Back to Admin Panel';
                            $homeIcon = 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z';
                            break;
                        case 'impor':
                            $homeUrl = '/importir';
                            $homeText = 'Back to Importir Dashboard';
                            $homeIcon = 'M7 16a4 4 0 11-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10';
                            break;
                        case 'ekspor':
                            $homeUrl = '/ekspor';
                            $homeText = 'Back to Eksportir Dashboard';
                            $homeIcon = 'M7 16a4 4 0 11-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12';
                            break;
                    }
                @endphp

                <!-- Primary Action Button -->
                <div>
                    <a href="{{ $homeUrl }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-orange-500 hover:from-blue-700 hover:to-orange-600 dark:from-blue-500 dark:to-orange-400 dark:hover:from-blue-600 dark:hover:to-orange-500 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl group">
                        <svg class="w-6 h-6 mr-3 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $homeIcon }}"/>
                        </svg>
                        {{ $homeText }}
                    </a>
                </div>

                @if(!Auth::check())
                    <!-- Guest Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('signup') }}" 
                           class="inline-flex items-center bg-orange-500 hover:bg-orange-600 dark:bg-orange-600 dark:hover:bg-orange-500 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Sign Up
                        </a>
                    </div>
                @else
                    <!-- Logout Option for Logged Users -->
                    <div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium transition-all duration-300 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Auto Redirect Info -->
            <div class="mt-8 text-sm text-blue-500 dark:text-blue-400 opacity-75 transition-colors duration-300">
                <div id="redirectInfo" class="hidden">
                    <p>Auto redirecting in <span id="countdown" class="font-bold">10</span> seconds...</p>
                    <button id="cancelRedirect" class="mt-2 text-xs underline hover:no-underline">Cancel</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="navbar-background py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-3 mb-2">
                <!-- Small Logo in Footer -->
                <div class="w-8 h-8">
                    <svg viewBox="0 0 120 120" class="w-full h-full">
                        <path d="M20 60 Q40 20, 80 30" stroke="#EEA133" stroke-width="8" fill="none" stroke-linecap="round"/>
                        <g fill="#003355">
                            <path d="M30 70 L85 70 L90 85 L25 85 Z"/>
                            <rect x="35" y="55" width="15" height="15" rx="2"/>
                            <rect x="38" y="45" width="4" height="10"/>
                            <rect x="43" y="48" width="4" height="7"/>
                            <circle cx="32" cy="77" r="2" fill="white"/>
                            <circle cx="38" cy="77" r="2" fill="white"/>
                            <circle cx="44" cy="77" r="2" fill="white"/>
                        </g>
                        <g fill="#003355">
                            <ellipse cx="75" cy="35" rx="15" ry="4" transform="rotate(15 75 35)"/>
                            <ellipse cx="70" cy="38" rx="8" ry="3" transform="rotate(15 70 38)"/>
                            <ellipse cx="82" cy="32" rx="6" ry="2" transform="rotate(15 82 32)"/>
                        </g>
                        <path d="M20 90 Q35 85, 50 90 T80 90 T110 90" stroke="#186094" stroke-width="4" fill="none"/>
                        <path d="M15 95 Q30 92, 45 95 T75 95 T105 95" stroke="#186094" stroke-width="3" fill="none" opacity="0.7"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-blue-900 dark:text-blue-100 transition-colors duration-300">
                    Triad<span class="text-orange-500">GO</span>
                </span>
            </div>
            <p class="text-sm text-blue-600 dark:text-blue-400 transition-colors duration-300">
                © 2024 TriadGO. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
         const isDarkMode = document.documentElement.classList.contains('dark');

    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeThumb = document.getElementById('darkModeThumb');
    const htmlElement = document.documentElement;

    function updateDarkModeSwitch() {
        if (htmlElement.classList.contains('dark')) {
            darkModeToggle.checked = true;
            darkModeThumb.style.transform = 'translateX(1.25rem)';
            darkModeThumb.style.backgroundColor = '#003355';
            darkModeThumb.style.borderColor = '#003355';
        } else {
            darkModeToggle.checked = false;
            darkModeThumb.style.transform = 'translateX(0)';
            darkModeThumb.style.backgroundColor = '#fff';
            darkModeThumb.style.borderColor = '#ccc';
        }
    }

    if (localStorage.getItem('darkMode') === 'enabled') {
        htmlElement.classList.add('dark');
    }

    updateDarkModeSwitch();

    darkModeToggle.addEventListener('change', () => {
        htmlElement.classList.toggle('dark');
        if (htmlElement.classList.contains('dark')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
        updateDarkModeSwitch();
    });

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
        link.addEventListener('click', function (event) {
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

    openSidebarBtn.addEventListener('click', function () {
        sidebar.classList.remove('hidden');
    });

    closeSidebarBtn.addEventListener('click', function () {
        sidebar.classList.add('hidden');
    });

    // Tutup sidebar jika klik di luar sidebar
    sidebar.addEventListener('click', function (e) {
        if (e.target === sidebar) {
            sidebar.classList.add('hidden');
        }
    });

    // Scroll to section dari sidebar
    sidebar.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            sidebar.classList.add('hidden');
            const targetId = this.getAttribute('href').substring(1);
            scrollToSectionWithSlide(targetId);
        });
    });

    // SweetAlert2 Logout Desktop
    document.getElementById('logoutBtn')?.addEventListener('click', function (e) {
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