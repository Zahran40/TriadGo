<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Product</title>
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
</head>

<body class="home-bg min-h-screen flex flex-col">
    @include('layouts.navbarimportir')

    <div class="flex flex-1 items-center justify-center py-12 px-4">
        <div class="product rounded-lg shadow-lg p-8 w-full max-w-lg">
            <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">Request Product</h2>
            <form id="product requestForm" method="" action="">
                @csrf
                <div class="mb-4">
                    <label for="product_name" class="block font-semibold text-blue-700  mb-1">Product Name</label>
                    <input type="text" id="product_name" name="product_name" required
                        class=" bg-white   dark:border-[#4a5568] hover:border-blue-700  rounded px-3 py-2 w-full text-blue-900 focus:ring-2 "
                        placeholder="Enter product name">
                </div>
                <div class="mb-4">
                    <label for="description" class="block font-semibold text-blue-700  mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" required
                        class=" bg-white    dark:border-[#4a5568] hover:border-blue-700 rounded px-3 py-2 w-full text-blue-900 focus:ring-2"
                        placeholder="Describe your request"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-blue-700  mb-2 hover:border-blue-700">Category</label>
                    <select id="Category"
                        class="w-full px-4 py-2.5 hover:border-blue-700 dark:border-gray-600 rounded-md text-blue-600 focus:ring-2  ">
                        <option value="" disabled selected hidden>Select Category</option>
                        <option>Electronics</option>
                        <option>Textile goods</option>
                        <option>Raw materials</option>
                        <option>Furniture items</option>
                        <option>Sports equipment</option>
                        <option>Medical/health supplies</option>
                        <option>Others</option>
                    </select>
                    <p id="categoryWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                </div>
                <div class="mb-4">
                    <label for="product_name" class="block font-semibold text-blue-700  mb-1">Quantity</label>
                    <input type="number" id="product_name" name="product_name" required
                        class=" bg-white  border  dark:border-[#4a5568] rounded px-3 py-2 w-full hover:border-blue-700 text-blue-900  focus:ring-2 "
                        placeholder="Enter quantity (kg)">
                </div>
                <div class="mb-4">
                    <label for="country" class="block font-semibold text-blue-700 mb-1">Country</label>
                    <select id="country" name="country"
                        class="bg-white border focus:ring-2 hover:border-blue-700 text-blue-600 dark:border-[#4a5568] rounded px-3 py-2 w-full">
                        <option value="Any" selected hidden>Select Country</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Brunei">Brunei</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Laos">Laos</option>
                        <option value="Myanmar">Myanmar</option>
                    </select>
                    <p id="categoryWarning" class="text-red-500 text-sm mt-1 hidden">This field is required.</p>
                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="inline-block bg-blue-700 hover:bg-amber-600 text-white font-bold py-2 px-3 rounded-md text-lg transition pulse-on-hover">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Dark Mode Toggle - SAMA seperti importir
        const isDarkMode = document.documentElement.classList.contains('dark');

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

        // Comment Form Submission
        const commentForm = document.getElementById('commentForm');
        if (commentForm) {
            commentForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const comment = document.getElementById('reviewComment').value;

                if (comment.trim() === '') {
                    const isDark = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Comment Required',
                        text: 'Please write a comment before submitting.',
                        background: isDark ? '#374151' : '#ffffff',
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            if (isDark) popup.classList.add('swal2-dark');
                        }
                    });
                    return;
                }

                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    icon: 'success',
                    title: 'Comment Submitted!',
                    text: 'Thank you for your comment. It has been added successfully.',
                    background: isDark ? '#374151' : '#ffffff',
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        if (isDark) popup.classList.add('swal2-dark');
                    }
                });

                // Reset form
                this.reset();
            });
        }

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

        // Sidebar mobile
        const sidebar = document.getElementById('mobileSidebar');
        const openSidebarBtn = document.querySelector('button.md\\:hidden[aria-label="Open Menu"]');
        const closeSidebarBtn = document.getElementById('closeSidebar');

        if (openSidebarBtn && closeSidebarBtn) {
            openSidebarBtn.addEventListener('click', function () {
                sidebar.classList.remove('hidden');
            });

            closeSidebarBtn.addEventListener('click', function () {
                sidebar.classList.add('hidden');
            });

            // Tutup sidebar jika klik di luar sidebar
            sidebar.addEventListener('click', function (e) {
                if (e.target === sidebar) {
                    sidebar.classList.add('hidden');
                }
            });
        }

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

        // Optional: SweetAlert2 for success feedback
        document.getElementById('requestForm').addEventListener('submit', function (e) {
            // Uncomment below if you want to show alert before submit
            // e.preventDefault();
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Request Submitted!',
            //     text: 'Your product request has been sent. We will contact you soon.',
            //     confirmButtonColor: '#EEA133'
            // }).then(() => {
            //     this.submit();
            // });
        });
    </script>
</body>

</html>