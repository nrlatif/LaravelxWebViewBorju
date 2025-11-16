// Handle screen orientation and prevent layout jump

// Store current page state in sessionStorage for persistence
let currentPage = {
    path: window.location.pathname,
    scroll: window.scrollY,
    formData: {}
};

// Save form data to sessionStorage
function saveFormData() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginForm) {
        currentPage.formData.email = document.getElementById('email')?.value || '';
        currentPage.formData.password = document.getElementById('password')?.value || '';
    }

    if (registerForm) {
        currentPage.formData.fullName = document.getElementById('fullName')?.value || '';
        currentPage.formData.email = document.getElementById('email')?.value || '';
        currentPage.formData.password = document.getElementById('password')?.value || '';
        currentPage.formData.confirmPassword = document.getElementById('confirmPassword')?.value || '';
    }

    // Save to sessionStorage as backup
    try {
        sessionStorage.setItem('formData', JSON.stringify(currentPage.formData));
        console.log('[Orientation] Form data saved to sessionStorage');
    } catch (e) {
        console.warn('[Orientation] SessionStorage not available:', e);
    }
}

// Restore form data from sessionStorage
function restoreFormData() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // Try to restore from sessionStorage first
    try {
        const savedData = sessionStorage.getItem('formData');
        if (savedData) {
            currentPage.formData = JSON.parse(savedData);
            console.log('[Orientation] Form data restored from sessionStorage');
        }
    } catch (e) {
        console.warn('[Orientation] Could not restore from sessionStorage:', e);
    }

    if (loginForm && currentPage.formData.email) {
        document.getElementById('email').value = currentPage.formData.email || '';
        document.getElementById('password').value = currentPage.formData.password || '';
    }

    if (registerForm && currentPage.formData.fullName) {
        document.getElementById('fullName').value = currentPage.formData.fullName || '';
        document.getElementById('email').value = currentPage.formData.email || '';
        document.getElementById('password').value = currentPage.formData.password || '';
        document.getElementById('confirmPassword').value = currentPage.formData.confirmPassword || '';
    }
}

// Handle page visibility changes (app backgrounding)
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        console.log('[Orientation] Page hidden, saving state...');
        saveFormData();
    } else {
        console.log('[Orientation] Page visible, restoring state...');
        restoreFormData();
    }
});

// Handle orientation change
window.addEventListener('orientationchange', (e) => {
    console.log('[Orientation] Orientation changed to:', window.orientation);

    // Save form data
    saveFormData();

    // Adjust viewport height
    setTimeout(() => {
        // Adjust for URL bar visibility on mobile
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);

        // Force layout recalculation
        document.body.style.height = window.innerHeight + 'px';
        window.scrollTo(0, 0);

        console.log('[Orientation] Layout adjusted for orientation. New height:', window.innerHeight);
    }, 100);
}, false);

// Handle resize events (for WebView)
window.addEventListener('resize', () => {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    console.log('[Orientation] Resized, viewport height:', window.innerHeight);
}, false);

// Prevent accidental navigation on swipe
let touchStartX = 0;
let touchStartY = 0;

document.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
}, { passive: true });

document.addEventListener('touchend', (e) => {
    const touchEndX = e.changedTouches[0].clientX;
    const touchEndY = e.changedTouches[0].clientY;
    const diffX = touchStartX - touchEndX;
    const diffY = touchStartY - touchEndY;

    // Prevent horizontal swipe navigation (common in Android WebView)
    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
        e.preventDefault();
    }
}, { passive: false });

// Save form data periodically
setInterval(() => {
    saveFormData();
}, 5000);

// Initial viewport height setup
const vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);

// Lock viewport scrolling issues
const viewport = document.querySelector('meta[name="viewport"]');
if (viewport) {
    viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover');
}

// Restore data on page load
window.addEventListener('load', () => {
    console.log('[Orientation] Page loaded, attempting to restore form data');
    restoreFormData();
}, false);

console.log('[Orientation] Orientation management module loaded');
