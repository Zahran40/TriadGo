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
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <img src="{{ asset('tglogo.png') }}" alt="TriadGo" class="h-8 w-auto">
                        <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-white">TriadGo</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home.eksportir') }}"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            Return To Dashboard
                        </a>
                        <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Pending Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Request New Product</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Review importer's requests.
                    </p>
                </div>
                <div class="p-6">
                    @if($pendingRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingRequests as $request)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <img src="{{ asset('default-avatar.png') }}" alt="User Avatar"
                                                    class="w-8 h-8 rounded-full mr-3">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">
                                                        {{ $request->importir->name }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $request->importir->email }}</p>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-3 mb-3">
                                                <p class="text-gray-900 dark:text-white">{{ $request->request_text }}</p>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Dikirim: {{ $request->created_at->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 ml-4">
                                            Pending
                                        </span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <button onclick="approveRequest({{ $request->id }})"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                        <button onclick="rejectRequest({{ $request->id }})"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reject
                                        </button>
                                        <button onclick="deleteRequest({{ $request->id }})"
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-xs font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No Pending Requests</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No demand for new products from
                                importers.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- My Handled Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">The Requests I Processed</h3>
                </div>
                <div class="p-6">
                    @if($myRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($myRequests as $request)
                                <div
                                    class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 
                                            {{ $request->status === 'approved' ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-600' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-600' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <img src="{{ asset('default-avatar.png') }}" alt="User Avatar"
                                                    class="w-8 h-8 rounded-full mr-3">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">
                                                        {{ $request->importir->name }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $request->importir->email }}</p>
                                                </div>
                                            </div>
                                            <div class="bg-white dark:bg-gray-700 rounded-md p-3 mb-3">
                                                <p class="text-gray-900 dark:text-white">{{ $request->request_text }}</p>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                @if($request->status === 'approved')
                                                    <p>✅ Approved at: {{ $request->approved_at->format('d M Y H:i') }}</p>
                                                    @if($request->product)
                                                        <p class="text-blue-600 dark:text-blue-400">
                                                            Related products: {{ $request->product->product_name }}
                                                        </p>
                                                    @endif
                                                @else
                                                    <p>❌ Rejected at: {{ $request->rejected_at->format('d M Y H:i') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end space-y-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $request->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $request->status === 'approved' ? 'Approved' : 'Rejected' }}
                                            </span>
                                            <button onclick="deleteRequest({{ $request->id }})"
                                                class="text-xs text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No proceed request.</p>
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
                title: 'Approve Request?',
                text: 'You are about to approve this request.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel'
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
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.error || 'An Error Occured',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An Error Occured. Please Try Again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        function rejectRequest(requestId) {
            Swal.fire({
                title: 'Reject Request?',
                text: 'You are about to reject this product.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel'
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
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.error || 'An Error Occured',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An Error Occured. Please Try Again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        function deleteRequest(requestId) {
            Swal.fire({
                title: 'Delete Request?',
                text: 'This request will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/requests/${requestId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.error || 'An Error Occured',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An Error Occured. Please Try Again.',
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