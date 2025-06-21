<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Request - TriadGo</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <style>
        /* SweetAlert2 Dark Mode Fix*/
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

<body class="bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navbarekspor')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-blue-600">Kelola Request Importir</h2>
                    <p class="text-sm text-blue-600 mt-1">
                        Tinjau dan proses permintaan produk dari importir.
                    </p>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">Request Masuk (Pending)</h3>
                    <p class="text-sm text-blue-500">{{ $pendingRequests->count() }} request menunggu persetujuan</p>
                </div>
                <div class="p-6">
                    @if($pendingRequests->count() > 0)
                        <div class="space-y-6">
                            @foreach($pendingRequests as $request)
                            <div class="border border-gray-200 rounded-lg p-6 bg-yellow-50">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-blue-900">Request #{{ $request->id }}</h4>
                                        <p class="text-sm text-blue-600">
                                            Dari: <span class="font-medium">{{ $request->importir->name ?? 'Unknown' }}</span>
                                        </p>
                                        <p class="text-sm text-blue-500">
                                            Dikirim: {{ $request->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </div>
                                
                                <div class="mb-4">
                                    <h5 class="font-medium text-blue-800 mb-2">Detail Permintaan:</h5>
                                    <p class="text-blue-700 bg-white p-3 rounded border">{{ $request->request_text }}</p>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <button 
                                        onclick="approveRequest({{ $request->id }})"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui
                                    </button>
                                    <button 
                                        onclick="rejectRequest({{ $request->id }})"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-blue-500">Tidak ada request pending saat ini.</p>
                    @endif
                </div>
            </div>

            <!-- My Processed Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">Request yang Saya Proses</h3>
                    <p class="text-sm text-blue-500">Riwayat request yang telah Anda proses</p>
                </div>
                <div class="p-6">
                    @if($myRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($myRequests as $request)
                            <div class="border border-gray-200 rounded-lg p-4 
                                @if($request->status === 'approved') bg-green-50 border-green-200 
                                @elseif($request->status === 'rejected') bg-red-50 border-red-200 
                                @endif">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h5 class="font-medium text-blue-900">Request #{{ $request->id }}</h5>
                                        <p class="text-sm text-blue-600">
                                            Dari: {{ $request->importir->name ?? 'Unknown' }}
                                        </p>
                                        <p class="text-sm text-blue-700 mt-1">{{ $request->request_text }}</p>
                                        <p class="text-xs text-blue-500 mt-2">
                                            @if($request->status === 'approved')
                                                Disetujui: {{ $request->approved_at ? $request->approved_at->format('d M Y H:i') : '-' }}
                                            @elseif($request->status === 'rejected')
                                                Ditolak: {{ $request->rejected_at ? $request->rejected_at->format('d M Y H:i') : '-' }}
                                            @endif
                                        </p>
                                        @if($request->product)
                                            <p class="text-sm text-blue-600 mt-1">
                                                Produk terkait: {{ $request->product->product_name }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($request->status === 'approved') bg-green-100 text-green-800
                                        @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        @if($request->status === 'approved') Disetujui
                                        @elseif($request->status === 'rejected') Ditolak
                                        @else {{ ucfirst($request->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-blue-500">Belum ada request yang Anda proses.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // CSRF Token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function approveRequest(requestId) {
            Swal.fire({
                title: 'Setujui Request?',
                text: 'Anda akan menyetujui request produk ini.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/eksportir/requests/${requestId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error || 'Terjadi kesalahan',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        }

        function rejectRequest(requestId) {
            Swal.fire({
                title: 'Tolak Request?',
                text: 'Anda akan menolak request produk ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/eksportir/requests/${requestId}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error || 'Terjadi kesalahan',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>
