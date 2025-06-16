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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"   />
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
    <div class="container mx-auto px-6 py-16 slide-in mt-4 mb-8">
        <h3 class="text-3xl font-bold text-blue-900 mb-12 text-center">Top Imported Products</h3>
        <div class="mt-6">
            <div class="mt-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="product shadow-md rounded-lg p-3 max-w-md">

                        <h5 class="text-2xl font-semibold text-amber-500">Product 1</h5>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-40 h-40 mx-auto" />
                        <p class="text-md text-blue-700 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero culpa
                            quam quas numquam hic tempore autem, velit voluptate sit illum molestiae nemo dicta doloremque fugit recusandae ex at! Quam, quae.
                        </p>


                        <a href="" class="flex items-center gap-3 mt-6">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="" class="w-[55px] h-[55px] rounded-full">
                            <div class="flex flex-col">
                                <p class="text-lg font-bold text-blue-700 ">John Doe</p>
                                <p class="text-md font-semibold text-amber-500">Indonesia</p>
                            </div>
                        </a>
                        <a href="{{ route('detail') }}"
                            class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded-md text-sm transition pulse-on-hover">
                            See Detail
                        </a>
                    </div>
                    <div class="product shadow-md rounded-lg p-3 max-w-md">

                        <h5 class="text-2xl font-semibold text-amber-500">Product 2</h5>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-40 h-40 mx-auto" />
                        <p class="text-md text-blue-700 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero culpa
                            quam quas numquam hic tempore autem, velit voluptate sit illum molestiae nemo dicta doloremque fugit recusandae ex at! Quam, quae.
                        </p>


                        <a href="" class="flex items-center gap-3 mt-6">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="" class="w-[55px] h-[55px] rounded-full">
                            <div class="flex flex-col">
                                <p class="text-lg font-bold text-blue-700 ">John Doe</p>
                                <p class="text-md font-semibold text-amber-500">Indonesia</p>
                            </div>
                        </a>
                        <a href="{{ route('detail') }}"
                            class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded-md text-sm transition pulse-on-hover">
                            See Detail
                        </a>
                    </div>
                    <div class="product shadow-md rounded-lg p-3 max-w-md">

                        <h5 class="text-2xl font-semibold text-amber-500">Product 3</h5>
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="" class="w-40 h-40 mx-auto" />
                        <p class="text-md text-blue-700 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero culpa
                            quam quas numquam hic tempore autem, velit voluptate sit illum molestiae nemo dicta doloremque fugit recusandae ex at! Quam, quae.
                        </p>


                        <a href="" class="flex items-center gap-3 mt-6">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="" class="w-[55px] h-[55px] rounded-full">
                            <div class="flex flex-col">
                                <p class="text-lg font-bold text-blue-700 ">John Doe</p>
                                <p class="text-md font-semibold text-amber-500">Indonesia</p>
                            </div>
                        </a>
                        <a href="{{ route('detail') }}"
                            class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded-md text-sm transition pulse-on-hover">
                            See Detail
                        </a>
                    </div>
                </div>

            </div>
        </div>
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