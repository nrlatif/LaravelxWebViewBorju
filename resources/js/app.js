import './bootstrap';

// Import form handlers
import './register-form.js';
import './login-form.js';
import './dashboard.js';

// Export auth functions globally for use in blade templates
import { register, login, logout, getCurrentUser, onAuthChange } from './auth.js';

window.authFunctions = {
    register,
    login,
    logout,
    getCurrentUser,
    onAuthChange
};
