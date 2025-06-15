<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        (function () {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Page Not Found | TriadGO</title>
    @vite('resources/css/app.css')
    
    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'

        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                },
            },
        }

        tailwind.scan()
    </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-4">
    
    <!-- Dark Mode Toggle -->
    <div class="fixed top-6 right-6 z-50">
        <label for="darkModeToggle" class="flex items-center cursor-pointer select-none">
            <span class="mr-2 text-2xl">☀️</span>
            <div class="relative">
                <input type="checkbox" id="darkModeToggle" class="sr-only" />
                <div class="block w-12 h-7 rounded-full bg-gray-300 dark:bg-gray-600 transition"></div>
                <div id="darkModeThumb"
                    class="dot absolute left-1 top-1 w-5 h-5 rounded-full bg-white border border-gray-400 dark:bg-blue-600 transition-transform duration-300">
                </div>
            </div>
            <span class="ml-2 text-2xl">🌙</span>
        </label>
    </div>

    <div class="max-w-md w-full text-center">
        <!-- Logo -->
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center">
                <img src="tglogo.png" alt="Logo" class="h-16 w-16 mr-3 animate-float" style="width: 65px; height: 65px;" />
                <div>
                    <h1 id="triadText" class="text-2xl font-bold text-blue-900 dark:text-white transition-colors duration-300">Triad</h1>
                    <h1 id="goText" class="text-2xl font-bold text-orange-500 transition-colors duration-300">Go</h1>
                </div>
            </div>
        </div>

        <!-- 404 Illustration -->
        <div class="mb-8">
            <div class="text-8xl font-bold text-blue-600 dark:text-blue-400 mb-4 animate-bounce-slow transition-colors duration-300">
                404
            </div>
            <div class="text-6xl mb-4">🔒</div>
        </div>

        <!-- Error Message -->
        <div id="errorCard" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6 transition-colors duration-300">
            <h2 id="errorTitle" class="text-2xl font-bold text-gray-800 dark:text-white mb-4 transition-colors duration-300">
                Akses Ditolak
            </h2>
            <p id="errorText" class="text-gray-600 dark:text-gray-300 mb-4 transition-colors duration-300">
                Halaman yang Anda coba akses memerlukan login terlebih dahulu. 
                Silakan login sesuai dengan role Anda untuk mengakses halaman tersebut.
            </p>
            <div id="roleInfo" class="bg-blue-50 dark:bg-gray-700 rounded-lg p-4 mb-4 transition-colors duration-300">
                <h3 id="roleTitle" class="font-semibold text-blue-800 dark:text-blue-400 mb-2 transition-colors duration-300">
                    🔑 Akses Halaman Berdasarkan Role:
                </h3>
                <ul id="roleList" class="text-sm text-blue-700 dark:text-blue-300 space-y-1 transition-colors duration-300">
                    <li>• <strong>Importir:</strong> Dapat mengakses halaman importir</li>
                    <li>• <strong>Eksportir:</strong> Dapat mengakses halaman eksportir</li>
                    <li>• <strong>Admin:</strong> Dapat mengakses panel admin</li>
                </ul>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a href="{{ route('login') }}" 
               class="w-full inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                🔐 Login Sekarang
            </a>
            
            <a href="{{ route('signup') }}" 
               class="w-full inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                📝 Daftar Akun Baru
            </a>
            
            <a href="/" 
               class="w-full inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                🏠 Kembali ke Beranda
            </a>
        </div>

        <!-- Additional Info -->
        <div id="additionalInfo" class="mt-8 text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">
            <p>Butuh bantuan? <a href="/#contact" id="contactLink" class="text-blue-600 dark:text-blue-400 hover:underline transition-colors duration-300">Hubungi kami</a></p>
        </div>
    </div>

    <script>
        // Dark mode functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeThumb = document.getElementById('darkModeThumb');
        const htmlElement = document.documentElement;

        // Elements yang perlu diupdate
        const errorCard = document.getElementById('errorCard');
        const errorTitle = document.getElementById('errorTitle');
        const errorText = document.getElementById('errorText');
        const roleInfo = document.getElementById('roleInfo');
        const roleTitle = document.getElementById('roleTitle');
        const roleList = document.getElementById('roleList');
        const additionalInfo = document.getElementById('additionalInfo');
        const contactLink = document.getElementById('contactLink');
        const triadText = document.getElementById('triadText');
        const goText = document.getElementById('goText');

        function updateDarkModeSwitch() {
            const isDark = htmlElement.classList.contains('dark');
            
            if (isDark) {
                darkModeToggle.checked = true;
                darkModeThumb.style.transform = 'translateX(1.25rem)';
                darkModeThumb.style.backgroundColor = '#2563eb';
                darkModeThumb.style.borderColor = '#2563eb';
            } else {
                darkModeToggle.checked = false;
                darkModeThumb.style.transform = 'translateX(0)';
                darkModeThumb.style.backgroundColor = '#fff';
                darkModeThumb.style.borderColor = '#ccc';
            }
        }

        function updateCardColors() {
            const isDark = htmlElement.classList.contains('dark');
            
            if (isDark) {
                // Dark mode colors
                errorCard.style.backgroundColor = '#1f2937';
                errorCard.style.color = '#f9fafb';
                
                errorTitle.style.color = '#f9fafb';
                errorText.style.color = '#d1d5db';
                
                roleInfo.style.backgroundColor = '#374151';
                roleTitle.style.color = '#60a5fa';
                roleList.style.color = '#93c5fd';
                
                additionalInfo.style.color = '#9ca3af';
                contactLink.style.color = '#60a5fa';
                
                // Logo text colors for dark mode
                triadText.style.color = '#ffffff';
                goText.style.color = '#f97316';
            } else {
                // Light mode colors
                errorCard.style.backgroundColor = '#ffffff';
                errorCard.style.color = '#1f2937';
                
                errorTitle.style.color = '#1f2937';
                errorText.style.color = '#4b5563';
                
                roleInfo.style.backgroundColor = '#eff6ff';
                roleTitle.style.color = '#1e40af';
                roleList.style.color = '#1d4ed8';
                
                additionalInfo.style.color = '#6b7280';
                contactLink.style.color = '#2563eb';
                
                // Logo text colors for light mode
                triadText.style.color = '#1e3a8a'; // blue-900
                goText.style.color = '#f97316'; // orange-500
            }
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'enabled') {
            htmlElement.classList.add('dark');
        }

        // Update initial state
        updateDarkModeSwitch();
        updateCardColors();

        // Event listener untuk toggle dark mode
        darkModeToggle.addEventListener('change', () => {
            htmlElement.classList.toggle('dark');
            if (htmlElement.classList.contains('dark')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
            updateDarkModeSwitch();
            updateCardColors(); // Update card colors ketika toggle berubah
        });

        // Auto redirect countdown
        let countdown = 30;
        const countdownElement = document.createElement('div');
        countdownElement.id = 'countdownElement';
        countdownElement.className = 'text-sm mt-4 transition-colors duration-300';
        
        function updateCountdownColors() {
            const isDark = htmlElement.classList.contains('dark');
            if (isDark) {
                countdownElement.style.color = '#9ca3af';
            } else {
                countdownElement.style.color = '#6b7280';
            }
        }
        
        countdownElement.innerHTML = `Otomatis redirect ke beranda dalam <span class="font-bold text-blue-600 dark:text-blue-400">${countdown}</span> detik`;
        document.querySelector('.max-w-md').appendChild(countdownElement);
        
        updateCountdownColors();

        const countdownInterval = setInterval(() => {
            countdown--;
            const isDark = htmlElement.classList.contains('dark');
            const spanColor = isDark ? '#60a5fa' : '#2563eb';
            
            countdownElement.innerHTML = `Otomatis redirect ke beranda dalam <span class="font-bold" style="color: ${spanColor}">${countdown}</span> detik`;
            updateCountdownColors();
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.location.href = '/';
            }
        }, 1000);

        // Stop countdown if user interacts with the page
        document.addEventListener('click', () => {
            clearInterval(countdownInterval);
            countdownElement.style.display = 'none';
        });

        // Update colors when dark mode changes
        const observer = new MutationObserver(() => {
            updateCardColors();
            updateCountdownColors();
        });

        observer.observe(htmlElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0, -15px, 0);
            }
            70% {
                transform: translate3d(0, -8px, 0);
            }
            90% {
                transform: translate3d(0, -3px, 0);
            }
        }
        
        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }
    </style>
</body>

</html>