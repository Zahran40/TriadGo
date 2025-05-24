<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriadGO - Export Solutions</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
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
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                },
            },
        }
    </script>
</head>

<body class="home-bg min-h-screen flex flex-col">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="tglogo.png" alt="Logo" class="h-12 w-12 mr-2" style="width: 65px; height: 65px" />
                <h1 class="text-2xl font-bold text-blue-900 gradient-move">Triad</h1>
                <h1 class="text-2xl font-bold text-orange-500 gradient-move">Go</h1>
            </div>
            <nav class="hidden md:flex items-center space-x-6 text-blue-700 font-semibold">
                <a href="#" class="hover:text-orange-500 transition nav-gradient-move">Request</a>
                <a href="#" class="hover:text-orange-500 transition nav-gradient-move">Transactions</a>
                <a href="#" class="hover:text-orange-500 transition nav-gradient-move">Account
                    <img src="https://cdn-icons-png.freepik.com/512/8345/8345339.png" alt=""
                        style="width: 40px; height: 40px;" class="inline-block ml-2" />
                </a>
            </nav>
            <div class="flex items-center space-x-4">
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
                <form action="{{ route('logout') }}" method="POST" class="hidden md:inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition"
                        onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar untuk Mobile View -->
    <div id="mobileSidebar" class="navbar-background fixed inset-0 z-50 bg-opacity-40 hidden">
        <div class="navbar-background fixed top-0 right-0 w-64 h-full shadow-lg p-6 flex flex-col">
            <button id="closeSidebar" class="self-end mb-8 text-2xl text-blue-700">&times;</button>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full mt-3 px-4 py-2 bg-red-500 text-white rounded-md font-semibold hover:bg-red-600 transition">Logout</button>
                </form>
            @endauth
        </div>
    </div>

    <section class="flex-grow container mx-auto px-6 md:px-12 py-16 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 text-center md:text-left">
            <h2 class="text-4xl font-extrabold text-blue-900 mb-6 leading-tight">
                <span class="text-amber-500">Hello Exporter!</span> <br>Welcome to TriadGO Export Hub
            </h2>

            <p class="text-lg text-blue-700 mb-8 max-w-xl fade-in-up" style="animation-delay:0.4s">
                Expand your business globally with our comprehensive export solutions. We provide the platform and tools
                you need to connect with international buyers and streamline your export operations.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('formeksportir') }}"
                    class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover glow-on-hover">
                    Upload Your Products
                </a>
                <a href="#find-buyers"
                    class="inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover">
                    Find International Buyers
                </a>
            </div>
        </div>
        <div class="md:w-1/2 mt-10 md:mt-0">
            <img src="eksportir.png" alt="Export Illustration" class="floating-img w-full max-w-lg" />
        </div>
    </section>

    <section id="services" class="bg-white py-16 slide-in">
        <div class="container mx-auto px-6 md:px-12 ">
            <h3 class="text-3xl font-bold text-blue-900 mb-12 text-center">Our Export Solutions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                <div
                    class="export-card bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition hover:border-orange-500 border-2 border-transparent">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0 wiggle" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Global Market Access
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Connect with buyers from all SEA countries through our extensive
                        international network.
                    </p>
                    <a href="#" class="text-blue-800 font-semibold inline-flex items-center mt-4">
                        Learn more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div
                    class="export-card bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition hover:border-orange-500 border-2 border-transparent">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0 wiggle" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Secure Transactions
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Our escrow system ensures safe and reliable international payments for your exports.
                    </p>
                    <a href="#" class="text-blue-800 font-semibold inline-flex items-center mt-4">
                        Learn more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div
                    class="export-card bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition hover:border-orange-500 border-2 border-transparent">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0 wiggle" fill="none"
                            viewBox="0 -5 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-6a1 1 0 012 0v6a1 1 0 11-2 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12h3l3 9m-3-9v-7a7 7 0 00-14 0v7" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Logistics Support
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        End-to-end logistics solutions including shipping, customs clearance, and documentation.
                    </p>
                    <a href="#" class="text-blue-800 font-semibold inline-flex items-center mt-4">
                        Learn more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="find-buyers" class="container mx-auto px-6 py-16 slide-in">
        <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">Find Buyers Respons</h2>
        <form action="" class="flex flex-col md:flex-row items-center max-w-2xl mx-auto">
            <input type="text" name="" placeholder="Search for buyers response..."
                class="flex-grow px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mr-4 mb-4 md:mb-0"
                required />
            <button type="submit"
                class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-md transition pulse-on-hover flex items-center">
                <img src="https://img.icons8.com/m_outlined/512/FFFFFF/search.png" alt=""
                    style="width: 20px; height: 20px;" class="mr-2" />
                Search
            </button>
        </form>

        <!-- Buyers Response -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-blue-900 mb-6 text-center">Buyers Respons</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="buyer-card shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Buyer"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold text-lg">Vincent Simbolon</h4>
                                <p class="text-orange-500 text-sm">Indonesia</p>
                            </div>
                        </div>
                        <p class="buyer-card-text mb-4">Plz sell more Product</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Last active: 2 days ago</span>

                        </div>
                    </div>
                </div>

                <div class="buyer-card shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Buyer"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold text-lg">Reagan Siahaan</h4>
                                <p class="text-orange-500 text-sm">Singapore</p>
                            </div>
                        </div>
                        <p class="buyer-card-text mb-4">Your Handyman Servicesis best</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Last active: 1 day ago</span>

                        </div>
                    </div>
                </div>

                <div class="buyer-card shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Buyer"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold text-lg">Abbil Rizki Abdillah</h4>
                                <p class="text-orange-500 text-sm">Cambodia</p>
                            </div>
                        </div>
                        <p class="buyer-card-text mb-4">I love All your Product</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Last active: Today</span>

                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <button
                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-md transition pulse-on-hover inline-flex items-center">
                    View All Responses
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <section id="services" class="bg-blue-800 text-white py-16 slide-in">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Start Exporting?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of businesses expanding their reach globally with
                TriadGO</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button
                    class="bg-orange-500 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover">
                    Create Export Profile
                </button>
                <button
                    class="bg-blue-700 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover">
                    Schedule Consultation
                </button>
            </div>
        </div>
    </section>

    <footer class="bg-blue-900 text-blue-100 py-6 mt-auto">
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

    <script>
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
    </script>
</body>

</html>