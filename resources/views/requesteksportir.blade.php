<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Expo - TriadGO Exporter</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>

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
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom Tailwind Configuration */
        @layer utilities {
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .animate-pulse-slow {
                animation: pulse 3s ease-in-out infinite;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .dark .modal-backdrop {
            background: rgba(0, 0, 0, 0.7);
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Custom badge styles */
        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }

        .badge-success {
            background-color: #10b981;
            color: white;
        }

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
    </style>
</head>

<body class="home-bg min-h-screen transition-colors duration-300">
    <!-- Navigation -->
    @include('layouts.navbarekspor')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900 flex items-center mb-4 md:mb-0 transition-colors duration-300">
                <i class="fas fa-inbox mr-3 text-orange-500"></i>Exporter Request
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
                        <option value="">Semua Status</option>
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
                    class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #REQ001
                        </h5>
                        <p class="text-blue-700  text-sm transition-colors duration-300">Tanggal: 15 Juni 2025</p>
                    </div>
                    <span class="badge-warning px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">Pending</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-box mr-2 text-orange-500"></i>Detail Produk
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Nama:</span> Kopi Arabica Premium</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Kategori:</span> Makanan & Minuman</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Quantity:</span> 500 kg</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Requestor Country:</span> Kamboja</p>
                            </div>
                        </div>
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 dark:text-white mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-user mr-2 text-orange-500"></i>Detail Importer
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Nama:</span> PT. Global Import</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Negara:</span> Jepang</p>
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
                            <i class="fas fa-check mr-2"></i>Terima
                        </button>
                        <button
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-200 btn-hover flex items-center justify-center"
                            onclick="rejectRequest('REQ001')">
                            <i class="fas fa-times mr-2"></i>Tolak
                        </button>
                    </div>
                </div>
            </div>

            <!-- Request 2 -->
            <div class="product bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 card request-item"
                data-status="approved">
                <div
                    class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h5 class="text-xl font-semibold text-blue-900 transition-colors duration-300">Request #REQ003
                        </h5>
                        <p class="text-blue-700  text-sm transition-colors duration-300">Tanggal: 13 Juni 2025</p>
                    </div>
                    <span
                        class="badge-success px-3 py-1 rounded-full text-sm font-semibold mt-2 md:mt-0">Approved</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-box mr-2 text-orange-500"></i>Detail Produk
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Nama:</span> Furniture Kayu Jati</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Kategori:</span> Furniture</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Quantity:</span> 50 set</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Requestor Country:</span> Kamboja</p>
                            </div>
                        </div>
                        <div>
                            <h6
                                class="text-lg font-semibold text-blue-900 dark:text-white mb-3 flex items-center transition-colors duration-300">
                                <i class="fas fa-user mr-2 text-orange-500"></i>Detail Importer
                            </h6>
                            <div class="space-y-2">
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Nama:</span> Luxury Furniture USA</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Negara:</span> Amerika Serikat</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Email:</span> import@luxuryfurniture.com</p>
                                <p class="text-blue-700 transition-colors duration-300"><span
                                        class="font-semibold">Phone:</span> +1-555-123-4567</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div
                            class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 p-4 rounded transition-colors duration-300">
                            <div class="flex">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <p class="text-green-700 dark:text-green-300 transition-colors duration-300">Request
                                    telah disetujui pada 13 Juni 2025</p>
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
        <div
            class="modal bg-white dark:bg-gray-800 rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3 transition-colors duration-300">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
                <h5 class="text-xl font-semibold text-blue-900 dark:text-white transition-colors duration-300"
                    id="modalTitle">Konfirmasi</h5>
                <button onclick="closeModal()"
                    class="text-gray-400 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-100 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 text-blue-700 dark:text-gray-300 transition-colors duration-300" id="modalBody">
                <!-- Content will be filled by JavaScript -->
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-end space-x-3">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-lg transition duration-200">Batal</button>
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
                <p class="mb-4 text-blue-700 dark:text-gray-300">Apakah Anda yakin ingin menerima request <strong>${requestId}</strong>?</p>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-blue-700 dark:text-gray-300 mb-2">Catatan (Opsional):</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-300" id="approveNote" rows="3" placeholder="Tambahkan catatan untuk importer..."></textarea>
                </div>
            `;
            document.getElementById('confirmButton').onclick = () => {
                alert(`Request ${requestId} berhasil disetujui!`);
                closeModal();
                updateRequestStatus(requestId, 'approved');
            };
            showModal();
        }

        function rejectRequest(requestId) {
            document.getElementById('modalTitle').textContent = 'Tolak Request';
            document.getElementById('modalBody').innerHTML = `
                <p class="mb-4 text-blue-700 dark:text-gray-300">Apakah Anda yakin ingin menolak request <strong>${requestId}</strong>?</p>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-blue-700 dark:text-gray-300 mb-2">Alasan Penolakan:</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-300" id="rejectReason" rows="3" placeholder="Berikan alasan penolakan..." required></textarea>
                </div>
            `;
            document.getElementById('confirmButton').onclick = () => {
                const reason = document.getElementById('rejectReason').value;
                if (!reason.trim()) {
                    alert('Harap berikan alasan penolakan');
                    return;
                }
                alert(`Request ${requestId} berhasil ditolak!`);
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

        // function logout() {
        //     if (confirm('Apakah Anda yakin ingin logout?')) {
        //         window.location.href = 'login.html';
        //     }
        // }

        // Close modal when clicking outside
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // SweetAlert2 Logout Desktop
        document.getElementById('logoutBtn')?.addEventListener('click', function (e) {
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
        document.getElementById('logoutBtnMobile')?.addEventListener('click', function (e) {
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