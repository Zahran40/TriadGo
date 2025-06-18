/**
 * TriadGO Response System
 * JavaScript for response page functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeResponseSystem();
});

/**
 * Initialize response system functionality
 */
function initializeResponseSystem() {
    setupDarkModeToggle();
    setupTooltips();
}

/**
 * Contact Reviewer Function
 * @param {string} name - Reviewer name
 * @param {string} phone - Reviewer phone
 */
function contactReviewer(name, phone) {
    const isDark = document.documentElement.classList.contains('dark');
    
    Swal.fire({
        title: 'Contact Reviewer',
        html: `
            <div class="text-left space-y-3">
                <p><strong>Reviewer:</strong> ${escapeHtml(name)}</p>
                <p><strong>Phone:</strong> ${escapeHtml(phone)}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-4">
                    You can reach out to thank them for their review or address any concerns they may have mentioned.
                </p>
            </div>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Send Message',
        cancelButtonText: 'Close',
        confirmButtonColor: '#2563eb',
        background: isDark ? '#374151' : '#ffffff',
        color: isDark ? '#ffffff' : '#000000',
        didOpen: () => {
            const popup = Swal.getPopup();
            if (isDark) popup.classList.add('swal2-dark');
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Message Sent!',
                text: 'Your message has been sent to the reviewer.',
                icon: 'success',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#000000',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            });
        }
    });
}

/**
 * Thank Reviewer Function
 * @param {string} name - Reviewer name
 */
function thankReviewer(name) {
    const isDark = document.documentElement.classList.contains('dark');
    
    Swal.fire({
        title: 'Thank You Message',
        text: `Send a thank you message to ${name} for their review?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Send Thanks',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#10b981',
        background: isDark ? '#374151' : '#ffffff',
        color: isDark ? '#ffffff' : '#000000',
        didOpen: () => {
            const popup = Swal.getPopup();
            if (isDark) popup.classList.add('swal2-dark');
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Thank You Sent!',
                text: 'Your appreciation message has been sent to the reviewer.',
                icon: 'success',
                background: isDark ? '#374151' : '#ffffff',
                color: isDark ? '#ffffff' : '#000000',
                didOpen: () => {
                    const popup = Swal.getPopup();
                    if (isDark) popup.classList.add('swal2-dark');
                }
            });
        }
    });
}

/**
 * Setup dark mode toggle functionality
 */
function setupDarkModeToggle() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', () => {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
        });
    }
}

/**
 * Setup tooltips
 */
function setupTooltips() {
    // Add tooltip functionality if needed
}

/**
 * Escape HTML to prevent XSS attacks
 * @param {string} text - Text to escape
 * @returns {string} Escaped text
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}