import { logout, onAuthChange } from './auth.js';

document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById('logoutBtn');
    if (!logoutBtn) return;

    logoutBtn.addEventListener('click', async () => {
        const result = await logout();
        if (result.success) {
            window.location.href = '/login';
        }
    });

    // Monitor auth state
    onAuthChange((user) => {
        if (!user) {
            // Redirect to login if not authenticated
            window.location.href = '/login';
        } else {
            // Update user info
            const userNameEl = document.getElementById('userName');
            const userEmailEl = document.getElementById('userEmail');

            if (userNameEl) {
                userNameEl.textContent = user.displayName || 'Pengguna';
            }
            if (userEmailEl) {
                userEmailEl.textContent = user.email || '-';
            }
        }
    });
});
