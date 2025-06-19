
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update your transactions status</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
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
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                },
            },
        }
        tailwind.scan()
    </script>
</head>

<body class="home-bg min-h-screen flex flex-col">
    
    <!-- Header Section -->
   @include('layouts.navbarekspor')

    <!-- Main Content -->
    <div class="container mx-auto p-4 max-w-4xl">
    <!-- Back Button and Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengiriman</h1>
            <p class="text-gray-600">Lacak perjalanan paket Anda</p>
        </div>
        <a href="{{ route('tracking.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Package Summary Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-blue-500">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nomor Resi</p>
                <p class="font-medium">#TG123456789</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">Dalam Proses</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Estimasi Sampai</p>
                <p class="font-medium">25 Juni 2025</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <p class="text-sm text-gray-500">Pengirim</p>
                <p class="font-medium">PT. Exportindo Jaya</p>
                <p class="text-gray-600 text-sm">Jakarta, Indonesia</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Penerima</p>
                <p class="font-medium">John Smith</p>
                <p class="text-gray-600 text-sm">Singapore</p>
            </div>
        </div>
    </div>

    <!-- Tracking Timeline -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Status Pengiriman</h2>
        
        <!-- Current Status (Customs) -->
        <div class="mb-8 border-l-2 border-blue-500 pl-6 relative pb-8">
            <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-500 rounded-full"></div>
            <h3 class="text-lg font-medium">Proses Bea Cukai</h3>
            <p class="text-gray-600 text-sm">11 Juni 2025, 13:30 WIB</p>
            <p class="text-gray-700 mt-2">Paket sedang dalam proses pemeriksaan bea cukai</p>
            <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">SEDANG DIPROSES</span>
        </div>

        <!-- Next Statuses -->
        <div class="border-l-2 border-gray-300 pl-6 space-y-8 relative">
            <!-- Status 2 (Shipping) -->
            <div class="relative">
                <div class="absolute -left-2 top-0 w-4 h-4 bg-gray-300 rounded-full"></div>
                <h3 class="text-lg font-medium">Pengiriman ke Negara Tujuan</h3>
                <p class="text-gray-600 text-sm">12 Juni 2025, 08:00 WIB</p>
                <p class="text-gray-700 mt-2">Paket akan dimuat ke kapal kargo</p>
                <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">MENUNGGU</span>
            </div>

            <!-- Status 3 (Delivery) -->
            <div class="relative">
                <div class="absolute -left-2 top-0 w-4 h-4 bg-gray-300 rounded-full"></div>
                <h3 class="text-lg font-medium">Paket Dikirimkan</h3>
                <p class="text-gray-600 text-sm">Perkiraan: 15 Juni 2025</p>
                <p class="text-gray-700 mt-2">Paket akan dikirim ke alamat Anda</p>
                <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">MENUNGGU</span>
            </div>
        </div>
    </div>

    <!-- Update Status Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Update Status Pengiriman</h2>
        
        <!-- Status Update Form -->
        <form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Status Saat Ini</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Pilih Status</option>
                        <option selected>Dalam Proses Bea Cukai</option>
                        <option>Diterima di Gudang</option>
                        <option>Dalam Pengiriman</option>
                        <option>Terkirim</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Update</label>
                    <input type="datetime-local" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="2025-06-11T13:30">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Catatan</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Tambahkan catatan tentang status pengiriman..."></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 mr-2">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
        
        <!-- Status Update History -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4">Riwayat Update</h3>
            <div class="space-y-4">
                <!-- Update 1 -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium">Proses Bea Cukai</p>
                            <p class="text-gray-600 text-sm">11 Juni 2025, 13:30 WIB</p>
                        </div>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">DIPROSES</span>
                    </div>
                    <p class="mt-2 text-gray-700">Paket sedang dalam pemeriksaan bea cukai di Singapura</p>
                </div>
                
                <!-- Update 2 -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium">Diterima di Gudang</p>
                            <p class="text-gray-600 text-sm">10 Juni 2025, 09:00 WIB</p>
                        </div>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">SELESAI</span>
                    </div>
                    <p class="mt-2 text-gray-700">Paket telah diterima di gudang Jakarta</p>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Footer Section -->
    <footer class="bg-blue-900 text-blue-100 py-6 mt-auto">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" aria-label="Facebook" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12.07c0-5.52-4.48-10-10-10s-10 4.48-10 10c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54v-2.21c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.25.2 2.25.2v2.49h-1.27c-1.25 0-1.64.78-1.64 1.57v1.84h2.78l-.44 2.89h-2.34v6.99c4.78-.76 8.44-4.89 8.44-9.88z" />
                    </svg>
                </a>
                <a href="https://github.com/Zahran40/TriadGo" aria-label="GitHub" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.397.1 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.744 0 .267.18.579.688.481C19.138 20.203 22 16.447 22 12.021 22 6.484 17.523 2 12 2z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/official.usu" aria-label="Instagram" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.13.62a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <!-- JavaScript Section -->
    <script>
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
            link.addEventListener('click', function (event) {
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
    </script>

    <!-- Form Validation Script -->
    <script>
        window.checkInput = function(element) {
            const value = element.value.trim();
            let warningId = "";
            if (element.id === "ProductName") warningId = "nameWarning";
            else if (element.id === "productDescription") warningId = "descWarning";
            else if (element.id === "productCategory") warningId = "categoryWarning";
            else if (element.id === "packageWeight") warningId = "weightWarning";
            else if (element.id === "incotermsOpsion") warningId = "incotermsWarning";
            else if (
                element.id === "packageLength" ||
                element.id === "packageWidth" ||
                element.id === "packageHeight"
            ) warningId = "dimensionWarning";

            if (warningId) {
                // khusus dimension, cek semua input
                if (warningId === "dimensionWarning") {
                    const l = document.getElementById('packageLength').value.trim();
                    const w = document.getElementById('packageWidth').value.trim();
                    const h = document.getElementById('packageHeight').value.trim();
                    if (!l || !w || !h) {
                        document.getElementById(warningId).classList.remove("hidden");
                        return false;
                    } else {
                        document.getElementById(warningId).classList.add("hidden");
                        return true;
                    }
                } else {
                    if (value === "" || value === null) {
                        document.getElementById(warningId).classList.remove("hidden");
                        return false;
                    } else {
                        document.getElementById(warningId).classList.add("hidden");
                        return true;
                    }
                }
            }
            return true;
        };

        document.addEventListener('DOMContentLoaded', function() {
            function validateAll() {
                const nameValid = window.checkInput(document.getElementById('ProductName'));
                const catValid = window.checkInput(document.getElementById('productCategory'));
                const descValid = window.checkInput(document.getElementById('productDescription'));
                const weightValid = window.checkInput(document.getElementById('packageWeight'));
                
                const dimValid = window.checkInput(document.getElementById('packageLength'));
                return nameValid && catValid && descValid && weightValid && dimValid;
            }

            document.querySelectorAll('button').forEach(btn => {
                if (
                    btn.textContent.includes('Save as Draft') ||
                    btn.textContent.includes('Publish Product')
                ) {
                    btn.addEventListener('click', function(e) {
                        if (!validateAll()) {
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- Image Upload Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropArea = document.getElementById('dropArea');
            const fileInput = document.getElementById('fileInput');
            const browseBtn = document.getElementById('browseBtn');
            const preview = document.getElementById('preview');

            browseBtn.addEventListener('click', () => fileInput.click());

            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.classList.add('bg-orange-100');
            });
            dropArea.addEventListener('dragleave', () => {
                dropArea.classList.remove('bg-orange-100');
            });
            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dropArea.classList.remove('bg-orange-100');
                handleFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', () => {
                handleFiles(fileInput.files);
            });

            function handleFiles(files) {
                preview.innerHTML = '';
                Array.from(files).forEach((file, idx) => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const wrapper = document.createElement('div');
                        wrapper.className = "relative inline-block m-1";

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = "w-80 h-60 object-cover rounded border"; 

                        const delBtn = document.createElement('button');
                        delBtn.type = "button";
                        delBtn.innerHTML = '&times;';
                        delBtn.className = "absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs shadow hover:bg-red-800 transition";
                        delBtn.title = "Remove image";
                        delBtn.onclick = function () {
                            wrapper.remove();
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(delBtn);
                        preview.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>

    <!-- Document Upload Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Export License Upload
            const exportLicenseInput = document.getElementById('exportLicenseInput');
            const exportLicenseBrowse = document.getElementById('exportLicenseBrowse');
            const exportLicensePreview = document.getElementById('exportLicensePreview');

            exportLicenseBrowse.addEventListener('click', () => exportLicenseInput.click());
            exportLicenseInput.addEventListener('change', () => {
                exportLicensePreview.innerHTML = '';
                if (exportLicenseInput.files.length > 0) {
                    const file = exportLicenseInput.files[0];
                    const wrapper = document.createElement('div');
                    wrapper.className = "relative inline-block";

                    const fileIcon = document.createElement('a');
                    fileIcon.href = URL.createObjectURL(file);
                    fileIcon.target = "_blank";
                    fileIcon.className = "flex items-center gap-1 px-2 py-1 bg-white border rounded shadow text-blue-900 hover:bg-blue-50 transition";
                    fileIcon.innerHTML = `<i class="fas fa-file-alt text-lg"></i> <span class="text-xs">${file.name}</span>`;

                    // Button hapus kecil
                    const delBtn = document.createElement('button');
                    delBtn.type = "button";
                    delBtn.innerHTML = '&times;';
                    delBtn.className = "absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow hover:bg-red-800 transition";
                    delBtn.title = "Remove file";
                    delBtn.onclick = function () {
                        wrapper.remove();
                        exportLicenseInput.value = ""; // reset input file
                    };

                    wrapper.appendChild(fileIcon);
                    wrapper.appendChild(delBtn);
                    exportLicensePreview.appendChild(wrapper);
                }
            });

            // Certifications Upload
            const certificationsInput = document.getElementById('certificationsInput');
            const certificationsBrowse = document.getElementById('certificationsBrowse');
            const certificationsPreview = document.getElementById('certificationsPreview');

            certificationsBrowse.addEventListener('click', () => certificationsInput.click());
            certificationsBrowse.addEventListener('click', () => certificationsInput.click());
            certificationsInput.addEventListener('change', () => {
                certificationsPreview.innerHTML = '';
                Array.from(certificationsInput.files).forEach((file, idx) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = "relative inline-block";

                    const fileIcon = document.createElement('a');
                    fileIcon.href = URL.createObjectURL(file);
                    fileIcon.target = "_blank";
                    fileIcon.className = "flex items-center gap-1 px-2 py-1 bg-white border rounded shadow text-blue-900 hover:bg-blue-50 transition";
                    fileIcon.innerHTML = `<i class="fas fa-file-alt text-lg"></i> <span class="text-xs">${file.name}</span>`;

                    // Button hapus kecil
                    const delBtn = document.createElement('button');
                    delBtn.type = "button";
                    delBtn.innerHTML = '&times;';
                    delBtn.className = "absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow hover:bg-red-800 transition";
                    delBtn.title = "Remove file";
                    delBtn.onclick = function () {
                        wrapper.remove();
                        // Catatan: file tetap ada di input, hanya preview yang dihapus
                    };

                    wrapper.appendChild(fileIcon);
                    wrapper.appendChild(delBtn);
                    certificationsPreview.appendChild(wrapper);
                });
            });
        });
    </script>
</body>
</html>
@endsection