import { login } from './auth.js';

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    const errorAlert = document.getElementById('errorAlert');
    const successAlert = document.getElementById('successAlert');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const submitBtn = document.getElementById('submitBtn');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Hide alerts
        errorAlert.classList.add('hidden');
        successAlert.classList.add('hidden');

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sedang login...';

        try {
            console.log('Logging in with:', { email });
            const result = await login(email, password);
            console.log('Login result:', result);

            if (result.success) {
                successMessage.textContent = 'Login berhasil! Mengalihkan...';
                successAlert.classList.remove('hidden');

                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
            } else {
                errorMessage.textContent = result.error || 'Login gagal. Silakan coba lagi.';
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Login';
            }
        } catch (error) {
            console.error('Login error:', error);
            errorMessage.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
            errorAlert.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Login';
        }
    });
});
