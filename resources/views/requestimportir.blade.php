
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

    <!-- Dark Mode Script -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                        darkblue: '#1e3a8a',
                    }
                },
            },
        }
        tailwind.scan()
    </script>

    <style>
        /* SweetAlert2 Dark Mode Fix */
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
<body class="bg-gray-50 dark:bg-slate-900">
    <div class="min-h-screen">
        @include('layouts.navbarimportir')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Request Form -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400">Request Produk Baru</h2>
                    <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                        Tidak menemukan produk yang Anda cari? Kirim request kepada eksportir.
                    </p>
                </div>
                                
                <div class="p-6">
                    <!-- PERBAIKI INI - form tag salah posisi -->
                    <form id="requestForm" action="{{ route('importir.request.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="request_text" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">
                                Deskripsi Produk yang Diminta
                            </label>
                            <textarea 
                                id="request_text" 
                                name="request_text" 
                                rows="4" 
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Contoh: Saya mencari kopi arabika kualitas premium dari Indonesia dengan volume minimum 500kg..."
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
                            Kirim Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400">Request Pending</h3>
                </div>
                <div class="p-6">
                    @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingRequests as $request)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-blue-600 dark:text-blue-400">{{ $request->request_text }}</p>
                                            <p class="text-sm text-blue-500 dark:text-blue-500 mt-1">
                                                Dikirim: {{ $request->created_at->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pending
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-blue-500 dark:text-blue-400">Tidak ada request pending.</p>
                    @endif
                </div>
            </div>

            <!-- Approved Requests -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400">Request Disetujui</h3>
                </div>
                <div class="p-6">
                    @if(isset($approvedRequests) && $approvedRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($approvedRequests as $request)
                                <div class="border border-green-200 dark:border-green-600 rounded-lg p-4 bg-green-50 dark:bg-green-900/20"> 
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-blue-600 dark:text-blue-400">{{ $request->request_text }}</p>
                                            <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                                                Disetujui oleh: <span class="font-medium">{{ $request->eksportir->name ?? 'Eksportir' }}</span>
                                            </p>
                                            <p class="text-sm text-blue-500 dark:text-blue-500">
                                                Disetujui: {{ $request->approved_at ? $request->approved_at->format('d M Y H:i') : '' }}
                                            </p>
                                            @if($request->product)
                                                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                                                    Produk terkait: {{ $request->product->product_name }}
                                                </p>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Disetujui
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-blue-500 dark:text-blue-400">Belum ada request yang disetujui.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark Mode Toggle
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

        // Form submission
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('=== FORM SUBMIT DEBUG ===');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            const formData = new FormData(this);
            console.log('Form data:', Object.fromEntries(formData));
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            const isDark = document.documentElement.classList.contains('dark');
            
            // Show loading
            Swal.fire({
                title: 'Mengirim...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                    Swal.showLoading();
                }
            });
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Request berhasil dikirim!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                console.error('=== ERROR DETAILS ===');
                console.error('Error:', error);
                console.error('Error message:', error.message);
                
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
                });
            });
        });

        // Logout functionality
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
    </script>
</body>
</html>