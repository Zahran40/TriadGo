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

</head>

<body>
    <div class="min-h-screen">
        @include('layouts.navbarekspor')

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
                    text: 'You are about to reject this request.',
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
                    text: 'This request will be deleted permanently.',
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

<script>
    tailwind.config = {
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
</head>

<body class="home-bg min-h-screen transition-colors duration-300">

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900 flex items-center mb-4 md:mb-0 transition-colors duration-300">
                <i class="fas fa-inbox mr-3 text-orange-500"></i>Importer Request
            </h2>
            <div class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold">
                <span id="totalRequests">3</span> Request Pending
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
            <!-- Request 1 -->
            <div class="product bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 card request-item"
                data-status="pending">
                <div
                    class="border-b border-gray-200 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #REQ001
                        </h5>
                        <p class="text-blue-700  text-sm transition-colors duration-300">Date: June 15th 2025</p>
                    </div>
                    <span class="badge-warning px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">Pending</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-box mr-2 text-orange-500"></i>Product Detail
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Name:</span> Kopi Arabica Premium</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Category:</span> Makanan & Minuman</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Quantity:</span> 500 kg</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Requestor Country:</span> Cambodia</p>
                            </div>
                        </div>
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-user mr-2 text-orange-500"></i>Importer Detail
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Name:</span> PT. Global Import</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Country:</span> Jepang</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Email:</span> import@global.jp</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Phone:</span> +81-123-456-789</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h6
                            class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                            <i class="fas fa-comment mr-2 text-orange-500"></i>Description
                        </h6>
                        <div class="product p-4 rounded-lg transition-colors duration-300">
                            <p class="product text-blue-800 transition-colors duration-300">Kami tertarik dengan produk
                                kopi Arabica Anda. Mohon konfirmasi
                                ketersediaan dan waktu pengiriman.</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-3 mt-6">
                        <button
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition duration-200 btn-hover flex items-center justify-center"
                            onclick="approveRequest('REQ001')">
                            <i class="fas fa-check mr-2"></i>Accept
                        </button>
                        <button
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-200 btn-hover flex items-center justify-center"
                            onclick="rejectRequest('REQ001')">
                            <i class="fas fa-times mr-2"></i>Reject
                        </button>
                    </div>
                </div>
            </div>

            <!-- Request 2 -->
            <div class="product bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 card request-item"
                data-status="approved">
                <div
                    class="border-b border-gray-200 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #REQ003
                        </h5>
                        <p class="text-blue-700  text-sm transition-colors duration-300">Date: June 13th 2025</p>
                    </div>
                    <span
                        class="badge-success px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">Approved</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-box mr-2 text-orange-500"></i>Product Detail
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Name:</span> Furniture Kayu Jati</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Category:</span> Furniture</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Quantity:</span> 50 set</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Requestor Country:</span> Kamboja</p>
                            </div>
                        </div>
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-user mr-2 text-orange-500"></i>Importer Detail
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Name:</span> Luxury Furniture USA</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Country:</span> Amerika Serikat</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Email:</span> import@luxuryfurniture.com</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Phone:</span> +1-555-123-4567</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div
                            class="bg-green-100 border-l-4 border-green-500 p-4 rounded transition-colors duration-300">
                            <div class="flex">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <p class="text-green-700 transition-colors duration-300">Request Approved : June 13th
                                    2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="hidden">
        <div class="modal-backdrop" onclick="closeModal()"></div>
        <div class="modal bg-white rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3 transition-colors duration-300">
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300" id="modalTitle">
                    Konfirmasi</h5>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 text-blue-700 transition-colors duration-300" id="modalBody">
                <!-- Content will be filled by JavaScript -->
            </div>
            <div class="border-t border-gray-200 px-6 py-4 flex justify-end space-x-3">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition duration-200">Cancel</button>
                <button id="confirmButton"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200">Konfirmasi</button>
            </div>
        </div>
    </div>

    <script>
        // Dark Mode
        const isDarkMode = document.documentElement.classList.contains('dark');

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
        // End of Dark Mode

        function showModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function approveRequest(requestId) {
            document.getElementById('modalTitle').textContent = 'Terima Request';
            document.getElementById('modalBody').innerHTML = `
                <p class="mb-4 text-blue-700 dark:text-gray-300">Are you sure you want to approve <strong>${requestId}</strong>?</p>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-blue-700 dark:text-gray-300 mb-2">Note (Optional):</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-300" id="approveNote" rows="3" placeholder="Add a note for importer..."></textarea>
                </div>
            `;
            document.getElementById('confirmButton').onclick = () => {
                alert(`Request ${requestId} has been successfully approved!`);
                closeModal();
                updateRequestStatus(requestId, 'approved');
            };
            showModal();
        }

        function rejectRequest(requestId) {
            document.getElementById('modalTitle').textContent = 'Reject Request';
            document.getElementById('modalBody').innerHTML = `
                <p class="mb-4 text-blue-700 dark:text-gray-300">Are you sure you want to reject <strong>${requestId}</strong>?</p>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-blue-700 dark:text-gray-300 mb-2">Reason:</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-300" id="rejectReason" rows="3" placeholder="Give a reason..." required></textarea>
                </div>
            `;
            document.getElementById('confirmButton').onclick = () => {
                const reason = document.getElementById('rejectReason').value;
                if (!reason.trim()) {
                    alert('Please provide a reason for rejection.');
                    return;
                }
                alert(`Request ${requestId} has been rejected!`);
                closeModal();
                updateRequestStatus(requestId, 'rejected');
            };
            showModal();
        }

        function updateRequestStatus(requestId, status) {
            location.reload();
        }

        function filterRequests() {
            const status = document.getElementById('statusFilter').value;
            const items = document.querySelectorAll('.request-item');

            items.forEach(item => {
                const itemStatus = item.getAttribute('data-status');
                const statusMatch = !status || itemStatus === status;
                item.style.display = statusMatch ? 'block' : 'none';
            });
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'login.html';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // SweetAlert2 Logout Desktop
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

        // SweetAlert2 Logout Mobile
        document.getElementById('logoutBtnMobile')?.addEventListener('click', function (e) {
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