<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('tglogo.png') }}" alt="Logo" class="h-12 w-12 mr-2" style="width: 65px; height: 65px" />
            <h1 class="text-2xl font-bold text-blue-900 gradient-move">Triad</h1>
            <h1 class="text-2xl font-bold text-orange-500 gradient-move">Go</h1>
        </div>
        <nav class="hidden md:flex items-center space-x-6 text-blue-700 font-semibold">
            <a href="{{ route('ekspor') }}" class="hover:text-orange-500 font-semibold nav-gradient-move transition">Home</a>
            <a href="{{ route('requesteksportir') }}" class="hover:text-orange-500 transition nav-gradient-move">Request</a>
            <a href="{{ route('eksportir.transactions.index') }}" class="hover:text-orange-500 transition nav-gradient-move">Transactions</a>
            <a href="{{ route('user.profile') }}" class="hover:text-orange-500 transition nav-gradient-move flex items-center">
                Account
                <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'https://randomuser.me/api/portraits/men/' . (Auth::user()->user_id % 100) . '.jpg' }}" 
                     alt="Profile Picture"
                     style="width: 40px; height: 40px;" 
                     class="inline-block ml-2 rounded-full object-cover border-2 border-blue-200" />
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

        <!-- Menu Items -->
        <a href="{{ route('ekspor') }}" class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">Home</a>
        <a href="{{ route('requesteksportir') }}"
            class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">Request</a>
        <a href="{{ route('eksportir.transactions.index') }}"
            class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">Transactions</a>
        <a href="{{ route('user.profile') }}"
            class="mb-4 text-blue-700 font-semibold hover:text-orange-500 transition nav-gradient-move">Account</a>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit"
                class="w-full px-4 py-2 bg-red-500 text-white rounded-md font-semibold hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </div>
</div>