/**
 * TriadGO Comment System
 * JavaScript for product comment functionality
 */

// Global variables
let currentRating = 5;

/**
 * Initialize comment system when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    initializeCommentSystem();
});

/**
 * Initialize all comment system functionality
 */
function initializeCommentSystem() {
    setRating(5); // Set default rating
    setupCommentForm();
    setupDarkModeToggle();
}

/**
 * Set star rating and update UI
 * @param {number} rating - Rating value (1-5)
 */
function setRating(rating) {
    currentRating = rating;
    const ratingInput = document.getElementById('rating');
    if (ratingInput) {
        ratingInput.value = rating;
    }
    
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

/**
 * Setup comment form submission
 */
function setupCommentForm() {
    const commentForm = document.getElementById('commentForm');
    if (!commentForm) return;

    commentForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        await handleCommentSubmission();
    });
}

/**
 * Handle comment form submission with AJAX
 */
async function handleCommentSubmission() {
    const submitBtn = document.getElementById('submitBtn');
    const commentTextElement = document.getElementById('commentText');
    const ratingElement = document.getElementById('rating');
    const productIdElement = document.getElementById('productId');

    if (!submitBtn || !commentTextElement || !ratingElement || !productIdElement) {
        showErrorMessage('Form elements not found');
        return;
    }

    const comment = commentTextElement.value.trim();
    const rating = ratingElement.value;
    const productId = productIdElement.value;

    // Validation
    if (comment.length < 10) {
        showWarningMessage('Review Too Short', 'Please write at least 10 characters for your review.');
        return;
    }

    // Show loading state
    setSubmitButtonLoading(submitBtn, true);

    try {
        const response = await submitComment(productId, comment, rating);
        
        if (response.success) {
            showSuccessMessage('Review Submitted!', 'Thank you for your review. It has been added successfully.');
            addCommentToList(response.comment);
            resetCommentForm();
            updateCommentCount();
        } else {
            throw new Error(response.message || 'Failed to submit review');
        }
    } catch (error) {
        console.error('Comment submission error:', error);
        showErrorMessage(error.message || 'Failed to submit review. Please try again.');
    } finally {
        setSubmitButtonLoading(submitBtn, false);
    }
}

/**
 * Submit comment to server via AJAX
 * @param {string} productId - Product ID
 * @param {string} comment - Comment text
 * @param {number} rating - Rating value
 * @returns {Promise<Object>} Response data
 */
async function submitComment(productId, comment, rating) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        throw new Error('CSRF token not found');
    }

    const response = await fetch(`/product/${productId}/comment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        },
        body: JSON.stringify({
            comment_text: comment,
            rating: parseInt(rating)
        })
    });

    if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || `HTTP ${response.status}`);
    }

    return await response.json();
}

/**
 * Add new comment to the comments list
 * @param {Object} comment - Comment data from server
 */
function addCommentToList(comment) {
    const commentsList = document.getElementById('commentsList');
    const noComments = document.getElementById('noComments');
    const commentsContainer = document.getElementById('commentsContainer');
    
    // Hide "no comments" message
    if (noComments) {
        noComments.style.display = 'none';
    }
    
    // Create comment element
    const commentElement = createCommentElement(comment);
    
    // Add to comments list
    if (commentsList) {
        commentsList.insertBefore(commentElement, commentsList.firstChild);
    } else if (commentsContainer) {
        // Create comments list if it doesn't exist
        createCommentsListStructure(commentsContainer, commentElement);
    }
}

/**
 * Create comment HTML element
 * @param {Object} comment - Comment data
 * @returns {HTMLElement} Comment element
 */
function createCommentElement(comment) {
    const commentElement = document.createElement('div');
    commentElement.className = 'bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300';
    
    const profilePicture = comment.user_profile_picture 
        ? `<img src="${comment.user_profile_picture}" alt="${escapeHtml(comment.user_name)}" class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 dark:border-blue-600">`
        : `<div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg">
               ${escapeHtml(comment.user_name.charAt(0).toUpperCase())}
           </div>`;
    
    commentElement.innerHTML = `
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-4">
                ${profilePicture}
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">${escapeHtml(comment.user_name)}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${escapeHtml(comment.user_country)}</p>
                </div>
            </div>
            
            <div class="text-right">
                <div class="flex text-yellow-400 text-lg mb-1">
                    ${comment.stars}
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    ${escapeHtml(comment.created_at)}
                </p>
            </div>
        </div>
        
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">${escapeHtml(comment.comment_text)}</p>
        </div>
    `;
    
    return commentElement;
}

/**
 * Create comments list structure if it doesn't exist
 * @param {HTMLElement} container - Comments container
 * @param {HTMLElement} commentElement - First comment element
 */
function createCommentsListStructure(container, commentElement) {
    const heading = document.createElement('h3');
    heading.className = 'text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6';
    heading.textContent = 'Customer Reviews';
    
    const newCommentsList = document.createElement('div');
    newCommentsList.id = 'commentsList';
    newCommentsList.className = 'space-y-6';
    newCommentsList.appendChild(commentElement);
    
    container.appendChild(heading);
    container.appendChild(newCommentsList);
}

/**
 * Reset comment form to initial state
 */
function resetCommentForm() {
    const commentForm = document.getElementById('commentForm');
    if (commentForm) {
        commentForm.reset();
        setRating(5);
    }
}

/**
 * Update comment count display
 */
function updateCommentCount() {
    const commentCount = document.getElementById('commentCount');
    if (commentCount) {
        const currentCountMatch = commentCount.textContent.match(/\d+/);
        const currentCount = currentCountMatch ? parseInt(currentCountMatch[0]) : 0;
        const newCount = currentCount + 1;
        commentCount.textContent = `(${newCount} reviews)`;
    }
}

/**
 * Set submit button loading state
 * @param {HTMLElement} button - Submit button element
 * @param {boolean} isLoading - Loading state
 */
function setSubmitButtonLoading(button, isLoading) {
    if (isLoading) {
        button.disabled = true;
        button.innerHTML = `
            <span class="flex items-center gap-2">
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
            </span>
        `;
    } else {
        button.disabled = false;
        button.innerHTML = `
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                Submit Review
            </span>
        `;
    }
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
 * Check if dark mode is enabled
 * @returns {boolean} Dark mode status
 */
function isDarkModeEnabled() {
    return document.documentElement.classList.contains('dark');
}

/**
 * Show success message using SweetAlert2
 * @param {string} title - Alert title
 * @param {string} text - Alert text
 */
function showSuccessMessage(title, text) {
    const isDark = isDarkModeEnabled();
    
    Swal.fire({
        icon: 'success',
        title: title,
        text: text,
        background: isDark ? '#374151' : '#ffffff',
        color: isDark ? '#ffffff' : '#000000',
        confirmButtonColor: '#2563eb',
        didOpen: () => {
            const popup = Swal.getPopup();
            if (isDark) popup.classList.add('swal2-dark');
        }
    });
}

/**
 * Show warning message using SweetAlert2
 * @param {string} title - Alert title
 * @param {string} text - Alert text
 */
function showWarningMessage(title, text) {
    const isDark = isDarkModeEnabled();
    
    Swal.fire({
        icon: 'warning',
        title: title,
        text: text,
        background: isDark ? '#374151' : '#ffffff',
        color: isDark ? '#ffffff' : '#000000',
        confirmButtonColor: '#f59e0b',
        didOpen: () => {
            const popup = Swal.getPopup();
            if (isDark) popup.classList.add('swal2-dark');
        }
    });
}

/**
 * Show error message using SweetAlert2
 * @param {string} message - Error message
 */
function showErrorMessage(message) {
    const isDark = isDarkModeEnabled();
    
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        background: isDark ? '#374151' : '#ffffff',
        color: isDark ? '#ffffff' : '#000000',
        confirmButtonColor: '#dc2626',
        didOpen: () => {
            const popup = Swal.getPopup();
            if (isDark) popup.classList.add('swal2-dark');
        }
    });
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

/**
 * Get formatted current date
 * @returns {string} Formatted date
 */
function getCurrentFormattedDate() {
    const now = new Date();
    const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return now.toLocaleDateString('en-US', options);
}

// Export functions for testing (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        setRating,
        escapeHtml,
        isDarkModeEnabled,
        getCurrentFormattedDate
    };
}