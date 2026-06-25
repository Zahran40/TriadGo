<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Requests - TriadGo</title>
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
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                        darkblue: '#1e3a8a',
                        orange: '#ff6b35',
                    },
                },
            },
        }
    </script>
    
<style>
    .badge-danger {
        background-color: #ef4444;
        color: white;
    }

    /* Hover effects */
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .dark .card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .btn-hover:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .dark .btn-hover:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .mobile-stack {
            flex-direction: column;
        }

        .mobile-full {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    /* SweetAlert2 Dark Mode Fix - TAMBAHKAN INI */
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

<body class="home-bg min-h-screen transition-colors duration-300 dark:bg-slate-900">
    @include('layouts.navbarekspor')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900 flex items-center mb-4 md:mb-0 transition-colors duration-300">
                <i class="fas fa-inbox mr-3 text-orange-500"></i>Importer Request
            </h2>
            <div class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold">
                <span id="totalRequests">{{ isset($pendingRequests) ? $pendingRequests->count() : 0 }}</span> Request Pending
            </div>
        </div>

        <!-- Filter -->
        <div class="product bg-white rounded-lg shadow-md p-6 mb-6 transition-colors duration-300">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <select
                        class="product w-full px-4 py-2 border border-gray-400 bg-white  text-blue-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-300"
                        id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="md:col-span-1"></div>
                <div class="md:col-span-1">
                </div>
            </div>
        </div>

        <!-- Requests List -->
        <div id="requestsList" class="space-y-6">
            @php
                Log::info('View requesteksportir - Data Check', [
                    'pendingRequests_isset' => isset($pendingRequests),
                    'pendingRequests_count' => isset($pendingRequests) ? $pendingRequests->count() : 'not set',
                    'pendingRequests_data' => isset($pendingRequests) ? $pendingRequests->toArray() : 'not set'
                ]);
            @endphp
            
            @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                @foreach($pendingRequests as $request)
                <div class="product bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 card request-item"
                    data-status="pending">
                    <div
                        class="border-b border-gray-200 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #{{ $request->id }}
                            </h5>
                            <p class="text-blue-700  text-sm transition-colors duration-300">Date: {{ $request->created_at->format('F jS Y') }}</p>
                        </div>
                        <span class="badge-warning px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">{{ ucfirst($request->status) }}</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h6
                                    class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                    <i class="fas fa-comment mr-2 text-orange-500"></i>Request Details
                                </h6>
                                <div class="space-y-2">
                                    <p class="text-blue-700 transition-colors duration-300">{{ $request->request_text }}</p>
                                </div>
                            </div>
                            <div>
                                <h6
                                    class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                    <i class="fas fa-user mr-2 text-orange-500"></i>Importer Detail
                                </h6>
                                <div class="space-y-2">
                                    <p class="text-blue-700 transition-colors duration-300"><span
                                            class="font-semibold">Name:</span> {{ $request->importir->name ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span
                                            class="font-semibold">Country:</span> {{ $request->importir->country ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span
                                            class="font-semibold">Email:</span> {{ $request->importir->email ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span
                                            class="font-semibold">Phone:</span> {{ $request->importir->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-3 mt-6">
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition duration-200 btn-hover flex items-center justify-center"
                                onclick="approveRequest({{ $request->id }})">
                                <i class="fas fa-check mr-2"></i>Accept
                            </button>
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-200 btn-hover flex items-center justify-center"
                                onclick="rejectRequest({{ $request->id }})">
                                <i class="fas fa-times mr-2"></i>Reject
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="product bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-blue-700">No pending requests at the moment.</p>
                </div>
            @endif

            {{-- Approved Requests --}}
            @php
                $approvedRequests = isset($myRequests) ? $myRequests->where('status', 'approved') : collect([]);
            @endphp
            @if($approvedRequests->count() > 0)
                @foreach($approvedRequests as $request)
                <div class="product bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 card request-item"
                    data-status="approved">
                    <div
                        class="border-b border-gray-200 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #{{ $request->id }}
                            </h5>
                            <p class="text-blue-700 text-sm transition-colors duration-300">Date: {{ $request->created_at->format('F jS Y') }}</p>
                        </div>
                        <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">Approved</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h6 class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                    <i class="fas fa-comment mr-2 text-green-500"></i>Request Details
                                </h6>
                                <div class="space-y-2">
                                    <p class="text-blue-700 transition-colors duration-300">{{ $request->request_text }}</p>
                                </div>
                            </div>
                            <div>
                                <h6 class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                    <i class="fas fa-user mr-2 text-green-500"></i>Importer Detail
                                </h6>
                                <div class="space-y-2">
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Name:</span> {{ $request->importir->name ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Country:</span> {{ $request->importir->country ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Email:</span> {{ $request->importir->email ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Phone:</span> {{ $request->importir->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <p class="text-green-700 dark:text-green-300 text-sm">
                                <i class="fas fa-check-circle mr-1"></i>
                                Approved on {{ $request->approved_at ? $request->approved_at->format('F jS Y, H:i') : '-' }}
                                @if($request->product)
                                    — Linked product: <span class="font-semibold">{{ $request->product->product_name }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            {{-- Rejected Requests --}}
            @php
                $rejectedRequests = isset($myRequests) ? $myRequests->where('status', 'rejected') : collect([]);
            @endphp
            @if($rejectedRequests->count() > 0)
                @foreach($rejectedRequests as $request)
                <div class="product bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 card request-item"
                    data-status="rejected">
                    <div
                        class="border-b border-gray-200 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #{{ $request->id }}
                            </h5>
                            <p class="text-blue-700 text-sm transition-colors duration-300">Date: {{ $request->created_at->format('F jS Y') }}</p>
                        </div>
                        <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">Rejected</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h6 class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                    <i class="fas fa-comment mr-2 text-red-500"></i>Request Details
                                </h6>
                                <div class="space-y-2">
                                    <p class="text-blue-700 transition-colors duration-300">{{ $request->request_text }}</p>
                                </div>
                            </div>
                            <div>
                                <h6 class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                    <i class="fas fa-user mr-2 text-red-500"></i>Importer Detail
                                </h6>
                                <div class="space-y-2">
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Name:</span> {{ $request->importir->name ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Country:</span> {{ $request->importir->country ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Email:</span> {{ $request->importir->email ?? 'N/A' }}</p>
                                    <p class="text-blue-700 transition-colors duration-300"><span class="font-semibold">Phone:</span> {{ $request->importir->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <p class="text-red-700 dark:text-red-300 text-sm">
                                <i class="fas fa-times-circle mr-1"></i>
                                Rejected on {{ $request->rejected_at ? $request->rejected_at->format('F jS Y, H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        // CSRF Token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Dark Mode
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeThumb = document.getElementById('darkModeThumb');
        const htmlElement = document.documentElement;

        function updateDarkModeSwitch() {
            if (darkModeToggle && darkModeThumb) {
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

        // Approve Request Function
        function approveRequest(requestId) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Approve Request?',
                text: 'You are about to approve this request.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/eksportir/requests/${requestId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Request approved successfully!',
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
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error || 'An error occurred',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                background: isDark ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDark) popup.classList.add('swal2-dark');
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            background: isDark ? '#374151' : '#ffffff',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (isDark) popup.classList.add('swal2-dark');
                            }
                        });
                    });
                }
            });
        }

        // Reject Request Function
        function rejectRequest(requestId) {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Reject Request?',
                text: 'You are about to reject this request.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/eksportir/requests/${requestId}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Request rejected successfully!',
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
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error || 'An error occurred',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                background: isDark ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDark) popup.classList.add('swal2-dark');
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            background: isDark ? '#374151' : '#ffffff',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (isDark) popup.classList.add('swal2-dark');
                            }
                        });
                    });
                }
            });
        }

        // Filter Requests
        function filterRequests() {
            const status = document.getElementById('statusFilter').value;
            const items = document.querySelectorAll('.request-item');

            items.forEach(item => {
                const itemStatus = item.getAttribute('data-status');
                const statusMatch = !status || itemStatus === status;
                item.style.display = statusMatch ? 'block' : 'none';
            });
        }

        // Wire up filter dropdown
        document.getElementById('statusFilter')?.addEventListener('change', filterRequests);

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