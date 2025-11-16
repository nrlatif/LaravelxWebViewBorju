import './bootstrap';

// Import form handlers
import './register-form.js';
import './login-form.js';
import './dashboard.js';
import './forgot-password.js';
import './toggle-password.js';
import './orientation.js';

// Export auth functions globally for use in blade templates
import { register, login, logout, getCurrentUser, onAuthChange } from './auth.js';

window.authFunctions = {
    register,
    login,
    logout,
    getCurrentUser,
    onAuthChange
};

// Export menu functions for use in menu-crud.blade.php
import { addMenu, updateMenu, deleteMenu, getMenus, onMenusChange, searchMenus } from './menu.js';

window.menuFunctions = {
    addMenu,
    updateMenu,
    deleteMenu,
    getMenus,
    onMenusChange,
    searchMenus
};

// Orders: import and expose order functions for Kasir and Dashboard
import { createOrder, getOrders, onOrdersChange, getOrderCount, getStatistics, deleteOrder, onStatisticsChange } from './orders.js';

window.orderFunctions = {
    createOrder,
    getOrders,
    onOrdersChange,
    getOrderCount,
    getStatistics,
    deleteOrder,
    onStatisticsChange
};

// Safe redirect helper to avoid rapid repeated redirects to login
window.safeRedirectToLogin = function() {
    try {
        if (sessionStorage.getItem('kp_login_redirect_in_progress')) return;
        sessionStorage.setItem('kp_login_redirect_in_progress', '1');
        window.location.href = '/login';
        // Remove the flag after a short delay so future redirects can occur normally
        setTimeout(() => {
            sessionStorage.removeItem('kp_login_redirect_in_progress');
        }, 5000);
    } catch (e) {
        // Fallback
        window.location.href = '/login';
    }
};
