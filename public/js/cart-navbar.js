// Cart Navbar Integration - Database Version
(function() {
    'use strict';
    
    // Update cart count in navbar
    function updateNavCartCount() {
        // Only work with authenticated users
        const userIdMeta = document.querySelector('meta[name="user-id"]');
        if (!userIdMeta) {
            // Not authenticated, hide cart count
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.classList.add('hidden');
            }
            return;
        }
        
        // Get cart count from database
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.count;
                    if (data.count > 0) {
                        cartCountElement.classList.remove('hidden');
                    } else {
                        cartCountElement.classList.add('hidden');
                    }
                }
            }
        })
        .catch(error => {
            console.log('Cart count update failed (user may not be authenticated):', error.message);
        });
    }
    
    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', updateNavCartCount);
    
    // Listen for custom cart update events
    window.addEventListener('cartUpdated', updateNavCartCount);
    
    // Expose function globally for other scripts to use
    window.updateNavCartCount = updateNavCartCount;
})();
