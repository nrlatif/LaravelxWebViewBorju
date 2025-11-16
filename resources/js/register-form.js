import { register } from './auth.js';

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    if (!registerForm) return;

    const errorAlert = document.getElementById('errorAlert');
    const successAlert = document.getElementById('successAlert');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const submitBtn = document.getElementById('submitBtn');

    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const fullName = document.getElementById('fullName').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Hide alerts
        errorAlert.classList.add('hidden');
        successAlert.classList.add('hidden');

        // Validasi password
        if (password !== confirmPassword) {
            errorMessage.textContent = 'Password dan konfirmasi password tidak cocok!';
            errorAlert.classList.remove('hidden');
            return;
        }

        if (password.length < 6) {
            errorMessage.textContent = 'Password minimal harus 6 karakter!';
            errorAlert.classList.remove('hidden');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sedang mendaftar...';

        try {
            console.log('Registering with:', { fullName, email });
            const result = await register(email, password, fullName);
            console.log('Register result:', result);

            if (result.success) {
                successMessage.textContent = 'Pendaftaran berhasil! Mengalihkan ke login...';
                successAlert.classList.remove('hidden');

                // Reset form
                registerForm.reset();

                // Redirect after 2 seconds (use safe redirect to avoid loops)
                setTimeout(() => {
                    window.safeRedirectToLogin?.();
                }, 2000);
            } else {
                errorMessage.textContent = result.error || 'Pendaftaran gagal. Silakan coba lagi.';
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Daftar';
            }
        } catch (error) {
            console.error('Register error:', error);
            errorMessage.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
            errorAlert.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Daftar';
        }
    });
});
