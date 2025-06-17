<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Profile | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>

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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .profile-card {
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .slide-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .slide-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

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

<body class="home-bg min-h-screen flex flex-col dark:bg-slate-900">
    <!-- Header/Navbar -->
    

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-6 py-16">
        <!-- Back Button -->
        <div class="mb-6 slide-in">
            <button onclick="goBack()" class="flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </button>
        </div>

        <!-- Page Header -->
        <div class="text-center mb-12 slide-in">
            <h1 class="text-4xl font-bold text-blue-900 dark:text-blue-100 mb-4">Account Settings</h1>
            <p class="text-xl text-blue-700 dark:text-blue-300">Manage your profile and account preferences</p>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Navigation -->
                <div class="lg:w-1/4">
                    <div class="profile-card bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 slide-in">
                        <nav class="space-y-2">
                            <div class="w-full text-left px-4 py-3 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Profile
                            </div>
                            <hr class="my-4 border-gray-200 dark:border-gray-600">
                            <button onclick="deleteAccount()" class="w-full text-left px-4 py-3 rounded-md transition-colors hover:bg-red-50 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400">
                                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Account
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="lg:w-3/4">
                    <!-- My Profile Tab -->
                    <div id="content-profile" class="profile-card bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 slide-in">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">My Profile</h2>
                            <button onclick="toggleEdit()" id="edit-profile-btn" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                        </div>

                        <!-- Profile Picture -->
                        <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
                            <div class="relative">
                                <img id="profileImage" 
                                     src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://randomuser.me/api/portraits/' . ($user->role === 'impor' ? 'men' : 'women') . '/' . ($user->user_id % 100) . '.jpg' }}" 
                                     alt="Profile" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-blue-200 dark:border-blue-600">
                                <div id="edit-profile-overlay" class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 cursor-pointer hidden">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <input type="file" id="imageUpload" class="hidden" accept="image/*" onchange="uploadProfilePicture(this)">
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white" id="displayName">{{ $user->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-400" id="displayRole">{{ ucfirst($user->role) }}</p>
                                <p class="text-gray-500 dark:text-gray-500" id="displayLocation">{{ $user->country }}</p>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Personal Information</h3>
                            </div>
                            
                            <form id="profileForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <input type="text" id="name" value="{{ $user->name }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                    <input type="email" id="email" value="{{ $user->email }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                                    <input type="tel" id="phone" value="{{ $user->phone }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed" readonly>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                                    <input type="text" id="country" value="{{ $user->country }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed" readonly>
                                </div>
                            </form>
                        </div>

                        <!-- Save/Cancel Buttons (Hidden by default) -->
                        <div id="profile-actions" class="hidden">
                            <div class="flex gap-4">
                                <button onclick="saveProfile()" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-6 py-2 rounded-md transition">
                                    Save Changes
                                </button>
                                <button onclick="cancelEdit()" class="bg-gray-600 hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-600 text-white px-6 py-2 rounded-md transition">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-800 dark:bg-slate-900 text-blue-100 py-6 mt-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" aria-label="Facebook" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12.07c0-5.52-4.48-10-10-10s-10 4.48-10 10c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54v-2.21c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.25.2 2.25.2v2.49h-1.27c-1.25 0-1.64.78-1.64 1.57v1.84h2.78l-.44 2.89h-2.34v6.99c4.78-.76 8.44-4.89 8.44-9.88z" />
                    </svg>
                </a>
                <a href="https://github.com/Zahran40/TriadGo" aria-label="GitHub" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.397.1 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.744 0 .267.18.579.688.481C19.138 20.203 22 16.447 22 12.021 22 6.484 17.523 2 12 2z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/official.usu" aria-label="Instagram" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.13.62a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Store original values for reset functionality
        let originalValues = {
            name: '{{ $user->name }}',
            email: '{{ $user->email }}',
            phone: '{{ $user->phone }}',
            country: '{{ $user->country }}'
        };

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

        // Profile Edit Functions
        function toggleEdit() {
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input');
            const editBtn = document.getElementById('edit-profile-btn');
            const actions = document.getElementById('profile-actions');
            const overlay = document.getElementById('edit-profile-overlay');
            
            inputs.forEach(input => {
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                    input.classList.remove('bg-gray-50', 'dark:bg-gray-700', 'cursor-not-allowed');
                    input.classList.add('bg-white', 'dark:bg-gray-600');
                } else {
                    input.setAttribute('readonly', true);
                    input.classList.add('bg-gray-50', 'dark:bg-gray-700', 'cursor-not-allowed');
                    input.classList.remove('bg-white', 'dark:bg-gray-600');
                }
            });
            
            editBtn.classList.toggle('hidden');
            actions.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
            overlay.classList.toggle('opacity-0');
        }

        function cancelEdit() {
            // Reset form values to original
            document.getElementById('name').value = originalValues.name;
            document.getElementById('email').value = originalValues.email;
            document.getElementById('phone').value = originalValues.phone;
            document.getElementById('country').value = originalValues.country;
            
            toggleEdit();
        }

        function saveProfile() {
            const isDark = document.documentElement.classList.contains('dark');
            
            // Get form data
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                country: document.getElementById('country').value,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            // Validate required fields
            if (!formData.name || !formData.email || !formData.phone || !formData.country) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please fill in all required fields.',
                    icon: 'error',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Save Changes?',
                text: "Do you want to save your profile changes?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Save Changes',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait while we update your profile.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send AJAX request
                    fetch('{{ route("user.profile.update") }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': formData._token
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update original values
                            originalValues = {
                                name: formData.name,
                                email: formData.email,
                                phone: formData.phone,
                                country: formData.country
                            };

                            // Update display values
                            document.getElementById('displayName').textContent = formData.name;
                            document.getElementById('displayLocation').textContent = formData.country;

                            const isDarkSuccess = document.documentElement.classList.contains('dark');
                            
                            Swal.fire({
                                title: 'Saved!',
                                text: 'Your profile has been updated successfully.',
                                icon: 'success',
                                background: isDarkSuccess ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDarkSuccess) popup.classList.add('swal2-dark');
                                }
                            });
                            
                            toggleEdit();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to update profile.',
                                icon: 'error',
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
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
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

        // Upload Profile Picture Function
        function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('profile_picture', input.files[0]);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Show loading
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Please wait while we upload your profile picture.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('{{ route("user.profile.upload") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileImage').src = data.profile_picture_url;
                        
                        const isDark = document.documentElement.classList.contains('dark');
                        Swal.fire({
                            title: 'Success!',
                            text: 'Profile picture updated successfully.',
                            icon: 'success',
                            background: isDark ? '#374151' : '#ffffff',
                            didOpen: () => {
                                const popup = Swal.getPopup();
                                if (isDark) popup.classList.add('swal2-dark');
                            }
                        });
                    } else {
                        const isDark = document.documentElement.classList.contains('dark');
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to upload profile picture.',
                            icon: 'error',
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
                    const isDark = document.documentElement.classList.contains('dark');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        background: isDark ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDark) popup.classList.add('swal2-dark');
                        }
                    });
                });
            }
        }

        function deleteAccount() {
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Delete Account?',
                text: "This action cannot be undone! All your data will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete my account!',
                background: isDark ? '#374151' : '#ffffff',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete your account.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send AJAX request
                    fetch('{{ route("user.profile.delete") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const isDarkSuccess = document.documentElement.classList.contains('dark');
                            
                            Swal.fire({
                                title: 'Account Deleted!',
                                text: 'Your account has been deleted successfully.',
                                icon: 'success',
                                background: isDarkSuccess ? '#374151' : '#ffffff',
                                didOpen: () => {
                                    const popup = Swal.getPopup();
                                    if (isDarkSuccess) popup.classList.add('swal2-dark');
                                }
                            }).then(() => {
                                window.location.href = '{{ route("homepage") }}';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to delete account.',
                                icon: 'error',
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
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
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

        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                @if(Auth::user()->role === 'impor')
                    window.location.href = '{{ route("importir") }}';
                @else
                    window.location.href = '{{ route("ekspor") }}';
                @endif
            }
        }

        // Image upload click handler
        document.getElementById('edit-profile-overlay').addEventListener('click', function() {
            document.getElementById('imageUpload').click();
        });

        // Scroll Animation
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
</body>

</html>