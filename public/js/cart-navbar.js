// Cart Navbar Integration
(function() {
    'use strict';
    
    // Update cart count in navbar
    function updateNavCartCount() {
        const cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        const cartCountElement = document.getElementById('navCartCount');
        
        if (cartCountElement) {
            if (totalItems > 0) {
                cartCountElement.textContent = totalItems;
                cartCountElement.classList.remove('hidden');
            } else {
                cartCountElement.classList.add('hidden');
            }
        }
    }
    
    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', updateNavCartCount);
    
    // Update cart count when storage changes (from other tabs/windows)
    window.addEventListener('storage', function(e) {
        if (e.key === 'shoppingCart') {
            updateNavCartCount();
        }
    });
    
    // Expose function globally for other scripts to use
    window.updateNavCartCount = updateNavCartCount;
})();
