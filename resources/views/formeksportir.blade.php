<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriadGo - Export Goods Management</title>
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
    </script>
</head>

<body class="home-bg min-h-screen flex flex-col">
    
    <!-- Header Section -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="tglogo.png" alt="Logo" class="h-12 w-12 mr-2" style="width: 65px; height: 65px" />
                <h1 class="text-2xl font-bold text-blue-900 gradient-move">Triad</h1>
                <h1 class="text-2xl font-bold text-orange-500 gradient-move">Go</h1>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <label for="darkModeToggle" class="flex items-center cursor-pointer select-none">
                    <span class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-200" style="font-size: 30px">☀️</span>
                    <div class="relative">
                        <input type="checkbox" id="darkModeToggle" class="sr-only" />
                        <div class="block w-12 h-7 rounded-full bg-gray-300 dark:bg-gray-600 transition"></div>
                        <div id="darkModeThumb" class="dot absolute left-1 top-1 w-5 h-5 rounded-full bg-white border border-gray-400 dark:bg-[#003355] transition-transform duration-300"></div>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-200" style="font-size: 30px">🌙</span>
                </label>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-blue-700 focus:outline-none" aria-label="Open Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                    </svg>
                </button>
                
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition" onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
        <!-- Product Information Section -->
        <div class="export-card bg-blue-50 rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-4xl font-extrabold text-blue-900 mb-6 leading-tight">Product Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product Images Upload -->
                <div class="md:col-span-1">
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Product Images</h3>
                    <div class="file-upload bg-gray-light rounded-lg p-6 text-center cursor-pointer hover:bg-gray-100 transition-colors" id="dropArea">
                        <div class="border-2 border-dashed border-gray p-8 rounded-lg">
                            <i class="fas fa-cloud-upload-alt text-4xl text-blue-900 mb-3"></i>
                            <p class="text-gray-500 mb-2">Drag & drop images here</p>
                            <p class="text-sm text-gray-500 mb-4">or</p>
                            <div id="preview" class="flex flex-wrap gap-2 justify-center mb-4 w-full"></div>
                            <button type="button" id="browseBtn" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors">
                                Browse Files
                            </button>
                            <input type="file" id="fileInput" multiple accept="image/*" class="hidden">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mt-4">
                        <div class="h-24 bg-gray-light rounded flex items-center justify-center">
                            <i class="fas fa-plus text-blue-900"></i>
                        </div>
                    </div>
                </div>

                <!-- Product Details Form -->
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-blue-900 mb-2">Product Name*</label>
                            <input type="text" id="ProductName" class="w-full px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400" placeholder="Enter " onblur="checkInput(this)">
                            <p id="nameWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                        </div>
                        <div>
                            <label class="block text-blue-900 mb-2">Category*</label>
                            <select id="productCategory" class="w-full px-4 py-2.5 border border-gray-light rounded-md text-black-900 focus:outline-none focus:ring-2 focus:ring-primary-light " onblur="checkInput(this)">
                                <option value="" disabled selected hidden>Select Category</option>
                                <option>Raw materials</option>
                                <option>Textile goods</option>
                                <option>Electronic goods</option>
                                <option>Furniture items</option>
                                <option>Sports equipment</option>
                                <option>Medical/health supplies</option>
                                <option>Etc.</option>
                            </select>
                            <p id="categoryWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                        </div>
                        <div>
                            <label class="block text-blue-900 mb-2">HS Code</label>
                            <input type="text" class="w-full px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400" placeholder="Enter HS Code">
                        </div>
                        <div>
                            <label class="block text-blue-900 mb-2">Country</label>
                            <input type="text" class="w-full px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400" placeholder="Enter country of origin">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-blue-900 mb-2">Product Description*</label>
                            <textarea id="productDescription" class="w-full px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light placeholder-gray-400" placeholder="Detailed product description" onblur="checkInput(this)"></textarea>
                            <p id="descWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Variants Section -->
       <div class="export-card bg-blue-50 rounded-lg shadow-md p-8 mb-8">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-3xl font-bold text-blue-900 mb-4">Product Variants</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b text-blue-900">
                            <th class="text-left py-3 px-4">Variant</th>
                            <th class="text-left py-3 px-4">SKU</th>
                            <th class="text-left py-3 px-4">Price (USD)</th>
                            <th class="text-left py-3 px-4">MOQ</th>
                            <th class="text-left py-3 px-4">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-4 px-4">
                                <input type="text" class="w-full px-3 py-1.5 border border-gray-light rounded focus:outline-none focus:ring-1 focus:ring-primary-light" placeholder="Variant name">
                            </td>
                            <td class="py-4 px-4">
                                <input type="text" class="w-full px-3 py-1.5 border border-gray-light rounded focus:outline-none focus:ring-1 focus:ring-primary-light" placeholder="SKU">
                            </td>
                            <td class="py-4 px-4">
                                <input type="number" min="1" class="w-full px-3 py-1.5 border border-gray-light rounded focus:outline-none focus:ring-1 focus:ring-primary-light" placeholder="Price">
                            </td>
                            <td class="py-4 px-4">
                                <input type="number" min="1" class="w-full px-3 py-1.5 border border-gray-light rounded focus:outline-none focus:ring-1 focus:ring-primary-light" placeholder="MOQ">
                            </td>
                            <td class="py-4 px-4">
                                <input type="number" min="1" class="w-full px-3 py-1.5 border border-gray-light rounded focus:outline-none focus:ring-1 focus:ring-primary-light" placeholder="Stock">
                            </td>
                            <td class="py-4 px-4">
                                <button class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipping & Export Details -->
        <div class="export-card bg-blue-50 rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Shipping & Export Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Shipping Information -->
                <div>
                    <h3 class="block text-blue-900 mb-4">Shipping Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-blue-900 mb-2">Package Weight (kg)*</label>
                            <input type="number" min="1" id="packageWeight" class="w-full px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light" placeholder="1" onblur="checkInput(this)">
                            <p id="weightWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                        </div>
                        <div>
                            <label class="block text-blue-900 mb-2">Package Dimensions (cm)*</label>
                            <div class="grid grid-cols-3 gap-3">
                                <input type="number" min="1" class="px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light" placeholder="Length" onblur="checkInput(this)">
                                <input type="number" min="1" class="px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light" placeholder="Width" onblur="checkInput(this)">
                                <input type="number" min="1" class="px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light" placeholder="Height"onblur="checkInput(this)">
                            </div>
                            <p id="dimensionWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                        </div>
                        <div>
                            <label class="block text-blue-900 mb-2">Shipping Methods*</label>
                            <div class="space-y-3">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="form-checkbox text-primary">
                                    <span class="text-black dark:text-gray-200">Sea Freight</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="form-checkbox text-primary">
                                    <span class="text-blue-900 dark:text-gray-200">Air Freight</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="form-checkbox text-primary">
                                    <span class="text-blue-900 dark:text-gray-200">Express (DHL, FedEx, etc.)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Export Documentation -->
                <div>
                    <h3 class="text-2xl block text-blue-900 mb-4">Export Documentation</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-blue-900 mb-2">Export License (if required)</label>
                            <div class="file-upload bg-gray-light rounded-lg p-4 cursor-pointer hover:bg-gray-100 transition-colors border border-gray-light">
                                <div class="flex items-center gap-3">
                                    <!-- Export License Upload Button -->
                                    <button type="button" id="exportLicenseBrowse" class="mr-2 flex items-center justify-center w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-full shadow-lg hover:scale-110 hover:from-orange-500 hover:to-orange-700 transition-all duration-200" title="Upload file">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                    </button>
                                    <i class="fas fa-file-upload text-gray"></i>
                                    <span class="text-sm text-gray-400">Upload PDF, JPG, or PNG</span>
                                    <input type="file" id="exportLicenseInput" accept=".pdf,.jpg,.png" class="hidden">
                                </div>
                                <div id="exportLicensePreview" class="mt-2 flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-blue-900 mb-2">Product Certifications</label>
                            <div class="file-upload bg-gray-light rounded-lg p-4 cursor-pointer hover:bg-gray-100 transition-colors border border-gray-light">
                                <div class="flex items-center gap-3">
                                    <!-- Product Certifications Upload Button -->
                                    <button type="button" id="certificationsBrowse" class="mr-2 flex items-center justify-center w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-full shadow-lg hover:scale-110 hover:from-orange-500 hover:to-orange-700 transition-all duration-200" title="Upload file">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                    </button>
                                    <i class="fas fa-file-upload text-gray"></i>
                                    <span class="text-sm text-gray-400">Upload multiple files</span>
                                    <input type="file" id="certificationsInput" multiple class="hidden">
                                </div>
                                <div id="certificationsPreview" class="mt-2 flex flex-wrap gap-2"></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-blue-900 mb-2">Incoterms*</label>
                            <select id="incotermsOpsion" class="w-full px-4 py-2.5 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-primary-light" onblur="checkInput(this)">   
                            <option value="" disabled selected hidden>Select Incoterm</option>
                                <option>EXW - Ex Works</option>
                                <option>FOB - Free On Board</option>
                                <option>CIF - Cost, Insurance & Freight</option>
                                <option>DDP - Delivered Duty Paid</option>
                            </select>
                            <p id="incotermsWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4 mb-12">
            <button class="px-5 py-2.5 rounded-md font-medium cursor-pointer transition-all border border-primary text-primary hover:bg-primary hover:text-white">
                Save as Draft
            </button>
            <button class="px-5 py-2.5 rounded-md font-medium cursor-pointer transition-all border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white">
                Publish Product
            </button>
        </div>
    </main>

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