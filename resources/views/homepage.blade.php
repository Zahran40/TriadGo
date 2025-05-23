<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriadGO</title>
    @vite('resources/css/app.css')

    {{-- <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --> --}}

    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'

        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                    },
                },
            },
        }


        tailwind.scan()
    </script>
</head>





<body class="home-bg">
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                background: '#2563eb',
                color: '#fff',
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="tglogo.png" alt="Logo" class="h-12 w-12 mr-2" style="width: 65px;  height: 65px" />
                <h1 class="text-2xl font-bold text-blue-900 gradient-move">Triad</h1>
                <h1 class="text-2xl font-bold text-orange-500 gradient-move">Go</h1>
            </div>
            <nav class="hidden md:flex items-center space-x-6 text-blue-700 font-semibold">
                <a href="#services" class="hover:text-orange-500 transition nav-gradient-move">Services</a>
                <a href="#about" class="hover:text-orange-500 transition nav-gradient-move">About Us</a>
                <a href="#contact" class="hover:text-orange-500 transition nav-gradient-move">Contact</a>
                <a href="{{ route('login') }}">
                    <button
                        class="ml-6 px-4 py-1.5 bg-blue-400 text-white rounded-md font-semibold hover:bg-blue-600 transition pulse-on-hover">
                        Masuk
                    </button></a>
                <a href="{{ route('signup') }}">
                    <button
                        class="ml-3 px-4 py-1.5 bg-amber-500 text-white rounded-md font-semibold hover:bg-amber-600 transition pulse-on-hover">
                        Daftar
                    </button>
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
            </div>
        </div>
    </header>

    <!-- Sidebar untuk Mobile View -->
    <div id="mobileSidebar" class="navbar-background fixed inset-0 z-50 bg-opacity-40 hidden">
        <div class="navbar-background fixed top-0 right-0 w-64 h-full shadow-lg p-6 flex flex-col">
            <button id="closeSidebar" class="self-end mb-8 text-2xl text-blue-700">&times;</button>
            <a href="#services"
                class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">Services</a>
            <a href="#about"
                class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">About Us</a>
            <a href="#contact"
                class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">Contact</a>
            <a href="{{ route('login') }}">
                <button
                    class="w-full mb-3 px-4 py-2 bg-blue-400 text-white rounded-md font-semibold hover:bg-blue-600 transition">Masuk</button>
            </a>
            <a href="{{ route('signup') }}">
                <button
                    class="w-full px-4 py-2 bg-amber-500 text-white rounded-md font-semibold hover:bg-amber-600 transition">Daftar</button>
            </a>
        </div>
    </div>

    <section class="flex-grow container mx-auto px-6 md:px-12 py-16 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 text-center md:text-left">
            <h2 class="text-4xl font-extrabold text-blue-900 mb-6 leading-tight fade-in-up">
                Solusi Terpercaya untuk Ekspor & Impor Anda
            </h2>
            <p class="text-lg text-blue-700 mb-8 max-w-xl fade-in-up" style="animation-delay:0.4s">
                Memudahkan koneksi bisnis Anda dengan pasar global, layanan ekspor-impor yang andal dan cepat.
            </p>
            <a href="#contact"
                class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-md shadow-md transition pulse-on-hover">
                Contact Us
            </a>
        </div>
        <div class="md:w-1/2 mt-10 md:mt-0">
            <img src="triadgo.jpg" alt="Ekspor Impor" class="floating-img ml-7" />
        </div>
    </section>

    <section id="services" class="bg-white py-16 slide-in">
        <div class="container mx-auto px-6 md:px-12">
            <h3 class="text-3xl font-bold text-blue-900 mb-12 text-center">Our Services</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                <div class="bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0 wiggle" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h4l3 9 4-18 3 9h4" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Manajemen Logistik
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Mengatur pengiriman barang secara efisien dari pintu ke pintu dengan solusi logistik
                        terintegrasi.
                    </p>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0 wiggle" fill="none"
                            viewBox="5 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.105 0-2 .895-2 2h4a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12v7m0-7a7 7 0 017-7h0a7 7 0 014 12" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Konsultasi Bea Cukai
                    </h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Membantu proses bea cukai Anda agar berjalan lancar dan sesuai dengan regulasi internasional.
                    </p>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-orange-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto md:mx-0 wiggle" fill="none"
                            viewBox="0 -5 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-6a1 1 0 012 0v6a1 1 0 11-2 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12h3l3 9m-3-9v-7a7 7 0 00-14 0v7" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-blue-800 mb-2 text-center md:text-left">Pemasaran Global</h4>
                    <p class="text-blue-700 text-center md:text-left">
                        Membuka akses pasar internasional untuk produk Anda dengan strategi pemasaran yang efektif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="container mx-autof px-6 md:px-12 py-16 slide-in">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-3xl font-bold mb-6 text-blue-900">About Us</h3>
            <p class="text-blue-700 text-lg leading-relaxed">
                TriadGO merupakan website tubes kelompok 3 KOM C TI '24 yang terdiri dari Andre (ketua), Abbil, Vincent,
                Reagan, dan Dan Dan Dan Dandragnel.
            </p>
        </div>
    </section>

    <section id="testimoni" class="bg-white py-16 slide-in">
        <div class="container mx-auto px-6 md:px-12">
            <h3 class="text-3xl font-bold text-blue-900 mb-12 text-center">Testimoni Pelanggan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition text-center card-animate">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Pelanggan 1"
                        class="w-16 h-16 rounded-full mx-auto mb-4">
                    <p class="text-blue-700 mb-4">Kece abis. Beli perlengkapan duduk duduk dari negara ASEAN mana aja
                        jadi
                        simple</p>
                    <h4 class="font-semibold text-blue-800">Andre Sebayang</h4>
                    <span class="text-sm text-blue-800">Pengusaha Teteng</span>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition text-center card-animate">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Pelanggan 1"
                        class="w-16 h-16 rounded-full mx-auto mb-4">
                    <p class="text-blue-700 mb-4">Kece parah sih. Mau top up Football Manager jadi gampang. Makasih
                        TriadGO.
                        Sukses!</p>
                    <h4 class="font-semibold text-blue-800">Daniele Siahaan</h4>
                    <span class="text-sm text-blue-800">Appara Reagan</span>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg shadow hover:shadow-lg transition text-center card-animate">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Pelanggan 1"
                        class="w-16 h-16 rounded-full mx-auto mb-4">
                    <p class="text-blue-700 mb-4">Bener kata appara gw. Bukan cuma top up, tapi ekspor impor WDP pun
                        bisa.
                        Mudah + aman</p>
                    <h4 class="font-semibold text-blue-800">Reagan Siahaan</h4>
                    <span class="text-sm text-blue-800">Appara Daniele</span>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-white py-12 px-6 max-w-2xl mx-auto my-8 slide-in">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-2 text-blue-800 text-primary">Contact Us</h2>
            <p class="mb-6 text-amber-600">Send us a message and we'll get back to you soon.</p>
        </div>
        <form action="{{ route('contactus.store') }}" method="POST" class="space-y-4">
            @csrf
            <input class="w-full border dark:text-black border-gray-300 p-3 rounded focus:border-primary input-animate"
                name="name" type="text" placeholder="Your Name" />
            <input class="w-full border dark:text-black border-gray-300 p-3 rounded focus:border-primary input-animate"
                name="email" type="email" placeholder="Email" />
            <textarea
                class="w-full border dark:text-black border-gray-300 p-3 rounded focus:border-primary input-animate"
                name="message" rows="5" placeholder="Message"></textarea>
            <button class="bg-amber-500 text-white px-6 py-3 rounded hover:bg-blue-600 transition-colors w-full"
                type="submit">Send</button>
        </form>
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

    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeThumb = document.getElementById('darkModeThumb');
        const htmlElement = document.documentElement;

        function updateDarkModeSwitch() {
            if (htmlElement.classList.contains('dark')) {
                darkModeToggle.checked = true;
                darkModeThumb.style.transform = 'translateX(1.25rem)';
                darkModeThumb.style.backgroundColor = '#003355'; // dark mode
                darkModeThumb.style.borderColor = '#003355';
            } else {
                darkModeToggle.checked = false;
                darkModeThumb.style.transform = 'translateX(0)';
                darkModeThumb.style.backgroundColor = '#fff'; // white mode
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

        document.querySelectorAll('nav a[href="#services"], nav a[href="#about"], nav a[href="#contact"], a[href="#contact"]').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                scrollToSectionWithSlide(targetId);
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