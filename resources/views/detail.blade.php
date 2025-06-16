<!DOCTYPE html>
<html lang="en">

<head>
    <!-- TAMBAHKAN SweetAlert2 seperti di importir -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog | TriadGO</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Dark Mode Script - SAMA seperti importir -->
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .body {
            font-family: poppins, sans-serif;
        }
    </style>
</head>

<body class="home-bg min-h-screen">
    <!-- Header/Navbar -->
    @include('layouts.navbarimportir')

    <!-- Main Content -->
    <section id="" class="container mx-auto px-6 py-16 slide-in">

        <body class=" min-h-screen flex items-center justify-center">
            <div class="product shadow-lg rounded-lg max-w-8xl w-full p-8 ">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex flex-col items-center md:items-start">
                        <img src="https://png.pngtree.com/png-vector/20231023/ourmid/pngtree-mystery-box-with-question-mark-3d-illustration-png-image_10313605.png"
                            alt="Product Image" class="w-80 h-80 object-cover rounded-lg mx-auto md:mx-0">
                        <p class="text-2xl font-medium text-blue-800 mt-6">Exported by </p>

                        <a href="" class="flex items-center gap-3 mt-6 bg-blue-700 hover:bg-blue-600 p-4 rounded-lg shadow-sm ">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="" class="w-[70px] h-[70px] rounded-full ml-3">
                            <div class="flex flex-col ml-2">
                                <p class="text-xl font-medium text-white ">John Doe</p>
                                <p class="text-lg font-medium text-white">Indonesia</p>
                            </div>
                        </a>

                    </div>

                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-blue-900 mb-8 mt-3">Product Name</h1>
                        <p class="text-lg text-blue-700 font-medium mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                            Libero culpa quam quas numquam hic tempore autem, velit voluptate sit illum molestiae nemo dicta doloremque fugit recusandae ex at! Quam, quae.
                        </p>
                        <p class="text-xl text-blue-700 mb-4 mt-5 font-semibold">
                            Price : <span class="text-2xl font-bold text-blue-900">$100</span>
                        </p>
                        <p class="text-xl text-blue-700 mb-4 mt-2 font-semibold">
                            Stock : <span class="text-2xl font-bold text-blue-900">50</span>
                        </p>
                        <p class="text-xl text-blue-700 mb-4 mt-2 font-semibold">
                            Product ID : <span class="text-xl font-bold text-blue-900">TDR - 3000</span>
                        </p>
                        <p class="text-xl text-blue-700 mb-4 mt-2 font-semibold">
                            Weight : <span class="text-xl font-bold text-blue-900">5 kg</span>
                        </p>
                        
                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label class="text-lg font-semibold text-blue-700 block mb-2">Quantity:</label>
                            <div class="flex items-center space-x-3">
                                <button onclick="decreaseQuantity()" class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg font-bold">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="50" class="w-20 h-10 text-center border-2 border-blue-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <button onclick="increaseQuantity()" class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg font-bold">+</button>
                                <span class="text-sm text-blue-600 ml-2">Max: 50</span>
                            </div>
                        </div>

                        <!-- Cart Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-6">
                            <button onclick="addToCart()" class="text-xl bg-amber-500 hover:bg-amber-400 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5m0 0a2.2 0 100-4.4 2.2 0 000 4.4z"></path>
                                </svg>
                                Add to Cart
                            </button>
                            <button onclick="viewCart()" class="text-xl bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                View Cart (<span id="cartCount">0</span>)
                            </button>
                        </div>
                    </div>
                    
                </div>

            </div>
            </div>
        </body>
    </section>
    <footer class="bg-blue-800 text-blue-100 py-6 mt-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p>© 2025 TriadGO. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" aria-label="Facebook" class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M22 12.07c0-5.52-4.48-10-10-10s-10 4.48-10 10c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54v-2.21c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.25.2 2.25.2v2.49h-1.27c-1.25 0-1.64.78-1.64 1.57v1.84h2.78l-.44 2.89h-2.34v6.99c4.78-.76 8.44-4.89 8.44-9.88z" />
                    </svg>
                </a>
                <a href="https://github.com/Zahran40/TriadGo" aria-label="GitHub"
                    class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.397.1 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.744 0 .267.18.579.688.481C19.138 20.203 22 16.447 22 12.021 22 6.484 17.523 2 12 2z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/official.usu" aria-label="Instagram"
                    class="hover:text-amber-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 wiggle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.13.62a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>





    <script>
        const isDarkMode = document.documentElement.classList.contains('dark');

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
            link.addEventListener('click', function(event) {
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

        openSidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('hidden');
        });

        closeSidebarBtn.addEventListener('click', function() {
            sidebar.classList.add('hidden');
        });

        // Tutup sidebar jika klik di luar sidebar
        sidebar.addEventListener('click', function(e) {
            if (e.target === sidebar) {
                sidebar.classList.add('hidden');
            }
        });

        // Scroll to section dari sidebar
        sidebar.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                sidebar.classList.add('hidden');
                const targetId = this.getAttribute('href').substring(1);
                scrollToSectionWithSlide(targetId);
            });
        });

        // SweetAlert2 Logout Desktop
        document.getElementById('logoutBtn')?.addEventListener('click', function(e) {
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
        document.getElementById('logoutBtnMobile')?.addEventListener('click', function(e) {
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

    <!-- Shopping Cart Modal -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Shopping Cart</h2>
                    <button onclick="closeCart()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 max-h-96 overflow-y-auto">
                    <div id="cartItems" class="space-y-4">
                        <!-- Cart items will be populated here -->
                    </div>
                    <div id="emptyCart" class="text-center py-8 hidden">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 1.8M7 13v6a2 2 0 002 2h7.5"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Your cart is empty</p>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="border-t dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800 dark:text-white">Total: </span>
                        <span id="cartTotal" class="text-xl font-bold text-blue-600 dark:text-blue-400">$0.00</span>
                    </div>
                    <div class="flex gap-4">
                        <button onclick="clearCart()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition">
                            Clear Cart
                        </button>
                        <button onclick="proceedToCheckout()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toastMessage">Product added to cart!</span>
        </div>
    </div>

    <script>
        // Shopping Cart System
        let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];
        
        // Product data (in real app, this would come from backend)
        const currentProduct = {
            id: 1,
            name: "Nanas Subang",
            price: 15.50,
            image: "https://via.placeholder.com/150x150/FFD700/000000?text=Nanas",
            weight: 5,
            origin: "Indonesia"
        };
        
        // Update cart count on page load
        updateCartCount();
        
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);
            if (quantity < 50) {
                quantityInput.value = quantity + 1;
            }
        }
        
        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
            }
        }
        
        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);
            
            // Check if product already exists in cart
            const existingItemIndex = cart.findIndex(item => item.id === currentProduct.id);
            
            if (existingItemIndex > -1) {
                // Update quantity if product exists
                cart[existingItemIndex].quantity += quantity;
            } else {
                // Add new product to cart
                cart.push({
                    ...currentProduct,
                    quantity: quantity
                });
            }
            
            // Save to localStorage
            localStorage.setItem('shoppingCart', JSON.stringify(cart));
            
            // Update cart count
            updateCartCount();
            
            // Show toast notification
            showToast('Product added to cart successfully!');
            
            // Reset quantity to 1
            document.getElementById('quantity').value = 1;
        }
        
        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartCount').textContent = totalItems;
            
            // Update navbar cart count if element exists
            const navCartCount = document.getElementById('navCartCount');
            if (navCartCount) {
                if (totalItems > 0) {
                    navCartCount.textContent = totalItems;
                    navCartCount.classList.remove('hidden');
                } else {
                    navCartCount.classList.add('hidden');
                }
            }
        }
        
        function viewCart() {
            renderCartItems();
            document.getElementById('cartModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeCart() {
            document.getElementById('cartModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        function renderCartItems() {
            const cartItemsContainer = document.getElementById('cartItems');
            const emptyCartDiv = document.getElementById('emptyCart');
            
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '';
                emptyCartDiv.classList.remove('hidden');
                document.getElementById('cartTotal').textContent = '$0.00';
                return;
            }
            
            emptyCartDiv.classList.add('hidden');
            
            cartItemsContainer.innerHTML = cart.map((item, index) => `
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-lg">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 dark:text-white">${item.name}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Origin: ${item.origin}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Weight: ${item.weight}kg each</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQuantity(${index}, -1)" class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white w-8 h-8 rounded">-</button>
                        <span class="w-8 text-center font-semibold dark:text-white">${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, 1)" class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white w-8 h-8 rounded">+</button>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-blue-600 dark:text-blue-400">$${(item.price * item.quantity).toFixed(2)}</p>
                        <button onclick="removeFromCart(${index})" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                    </div>
                </div>
            `).join('');
            
            updateCartTotal();
        }
        
        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            localStorage.setItem('shoppingCart', JSON.stringify(cart));
            updateCartCount();
            renderCartItems();
        }
        
        function removeFromCart(index) {
            cart.splice(index, 1);
            localStorage.setItem('shoppingCart', JSON.stringify(cart));
            updateCartCount();
            renderCartItems();
            showToast('Product removed from cart');
        }
        
        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                cart = [];
                localStorage.setItem('shoppingCart', JSON.stringify(cart));
                updateCartCount();
                renderCartItems();
                showToast('Cart cleared');
            }
        }
        
        function updateCartTotal() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('cartTotal').textContent = `$${total.toFixed(2)}`;
        }
        
        function proceedToCheckout() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            // Redirect to checkout form with cart data
            window.location.href = "{{ route('formimportir') }}";
        }
        
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-full');
            
            setTimeout(() => {
                toast.classList.add('translate-y-full');
            }, 3000);
        }
        
        // Close modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCart();
            }
        });
    </script>
</body>

</html>