<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="tglogo.png" alt="Logo" class="h-12 w-12 mr-2" style="width: 65px; height: 65px" />
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
                    Login
                </button>
            </a>
            <a href="{{ route('signup') }}">
                <button
                    class="ml-3 px-4 py-1.5 bg-amber-500 text-white rounded-md font-semibold hover:bg-amber-600 transition pulse-on-hover">
                    Register
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
                class="w-full mb-3 px-4 py-2 bg-blue-400 text-white rounded-md font-semibold hover:bg-blue-600 transition">Login</button>
        </a>
        <a href="{{ route('signup') }}">
            <button
                class="w-full px-4 py-2 bg-amber-500 text-white rounded-md font-semibold hover:bg-amber-600 transition">Register</button>
        </a>
    </div>
</div>