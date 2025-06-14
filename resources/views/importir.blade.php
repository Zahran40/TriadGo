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
    </style>
    {{-- <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --> --}}

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
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
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

    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="tglogo.png" alt="Logo" class="h-12 w-12 mr-2 " style="width: 65px;  height: 65px" />
                <h1 class="text-2xl font-bold text-blue-900 gradient-move">Triad</h1>
                <h1 class="text-2xl font-bold text-orange-500 gradient-move">Go</h1>
            </div>
            <nav class="hidden md:flex items-center space-x-6 text-blue-700 font-semibold">
                <a href="#home-bg" class="hover:text-orange-500 transition nav-gradient-move">Home</a>
                <a href="#services" class="hover:text-orange-500 transition nav-gradient-move">Catalog</a>
                <a href="#about" class="hover:text-orange-500 transition nav-gradient-move">Request</a>
                <a href="#about" class="hover:text-orange-500 transition nav-gradient-move">Transaction</a>
                <a href="{{ route('userprofile') }}" class="hover:text-orange-500 transition nav-gradient-move">Account
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
                <!-- Tambahkan di dalam <nav> atau di tempat yang diinginkan -->
                <form action="{{ route('logout') }}" method="POST" class="hidden md:inline" id="logoutForm">
                    @csrf
                    <button type="button"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition"
                        id="logoutBtn">
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
                <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                    @csrf
                    <button type="button"
                        class="w-full mt-3 px-4 py-2 bg-red-500 text-white rounded-md font-semibold hover:bg-red-600 transition"
                        id="logoutBtnMobile">Logout</button>
                </form>
            @endauth
        </div>
    </div>

    <section class="flex-grow container mx-auto px-6 md:px-12 py-16 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 text-center md:text-left">
            <h2 class="text-4xl font-extrabold text-blue-900 mb-6 leading-tight fade-in-up">
                <span class="text-amber-500">Hello Importer !</span> <br>Welcome to TriadGO Import Hub
            </h2>

            <p class="text-lg text-blue-700 mb-8 max-w-xl fade-in-up" style="animation-delay:0.4s">
                Find the best solution for your import needs. We provide a platform that makes it easy for you to
                conduct international transactions safely and efficiently.
            </p>
            <a href="#cari"
                class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover">
                Temukan Barang Impor
            </a>
        </div>
        <div class="md:w-1/2 mt-10 md:mt-0">
            <img src="triadgo.jpg" alt="Ekspor Impor" class="floating-img ml-7" />
        </div>
    </section>

    <section id="cari" class="container mx-auto px-6 py-16 slide-in">
        <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">Find the product you want to import</h2>
        <form action="" class="flex flex-col md:flex-row items-center">
            <input type="text" name="" placeholder="Search for products..."
                class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500 mr-4 mb-4 md:mb-0"
                required />
            <button type="submit"
                class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition pulse-on-hover">
                <img src="https://img.icons8.com/m_outlined/512/FFFFFF/search.png" alt=""
                    style="width: 30px; height: 30px;" />
            </button>
        </form>

        <div class="mt-8">
            <h3 class="text-2xl font-bold text-blue-900 mb-4">Search Result</h3>
            <div class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="product shadow-md rounded-lg p-4">
                        <h4 class="text-xl font-semibold text-amber-500">Product 1</h4>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-50 h-50" />
                        <p class="product-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero culpa
                            quam
                            quas numquam hic tempore autem,
                            velit voluptate sit illum molestiae nemo dicta doloremque fugit recusandae ex at! Quam,
                            quae.
                        </p>
                        <a href="#"
                            class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition pulse-on-hover">
                            See Detail
                        </a>
                    </div>
                    <div class="product shadow-md rounded-lg p-4">
                        <h4 class="text-xl font-semibold text-amber-500">Product 2</h4>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-50 h-50" />
                        <p class="product-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur
                            rerum
                            totam nam, vero fugiat sit corporis,
                            quod possimus similique ad voluptate recusandae unde suscipit delectus aperiam fugit
                            provident
                            iusto laboriosam?</p>
                        <a href="#"
                            class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition pulse-on-hover">
                            See Detail
                        </a>
                    </div>
                    <div class="product shadow-md rounded-lg p-4">
                        <h4 class="text-xl font-semibold text-amber-500">Product 3</h4>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-50 h-50" />
                        <p class="product-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam atque aut
                            explicabo cupiditate culpa saepe,
                            suscipit consequuntur iure fugiat fugit. Repellat voluptatibus labore unde ad. Voluptatibus
                            qui
                            eius pariatur dolorum!</p>
                        <a href="#"
                            class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition pulse-on-hover">
                            See Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-14 text-center">
            <h3 class="text-2xl font-bold text-red-400 mb-4 mt-12">No Matching Items found</h3>
            <img src="https://cdn-icons-png.flaticon.com/512/6134/6134051.png" alt=""
                style="width: 100px; height: 100px;" class="mx-auto mb-10 mt-7" />
            <p class="text-blue-700 mb-4">We were unable to find any items that matched your search.</p>
            <p class="text-blue-700 mb-4">Please try with other keywords or make a request for the item you are looking
                for.
            </p>
            <button
                class="bg-amber-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition pulse-on-hover">
                Request now
            </button>
        </div>
    </section>

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
            cancelButtonColor: '#ff9d00',
            confirmButtonText: 'Logout',
            customClass: {
                popup: 'bg-white dark:bg-red-500',
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
    document.getElementById('logoutBtnMobile')?.addEventListener('click', function (e) {
        Swal.fire({
            title: 'Logout?',
            text: "Are you sure you want to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#ff9d00',
            confirmButtonText: 'Logout',
            customClass: {
                popup: 'bg-white dark:bg-red-500',
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