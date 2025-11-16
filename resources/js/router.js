// Simple routing for SPA-like navigation
const routes = {
    '#dashboard': '/dashboard',
    '#kasir': '/kasir',
    '#riwayat': '/riwayat',
    '#pencatatan': '/pencatatan',
    '#menu-crud': '/menu-crud',
    '#profile': '/profile',
    '#settings': '/settings'
};

function handleNavigation(hash) {
    const route = routes[hash];
    if (route) {
        window.location.href = route;
    }
}

// Listen for hash changes
window.addEventListener('hashchange', () => {
    handleNavigation(window.location.hash);
});

// Handle initial hash
if (window.location.hash && routes[window.location.hash]) {
    handleNavigation(window.location.hash);
}

export { handleNavigation };
