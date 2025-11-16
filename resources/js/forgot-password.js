import { sendPasswordResetEmail } from 'firebase/auth';
import { auth } from './firebase.js';

// Forgot Password Modal Management
const forgotPasswordLink = document.getElementById('forgotPasswordLink');
const forgotPasswordModal = document.getElementById('forgotPasswordModal');
const closeModalBtn = document.getElementById('closeModalBtn');
const sendResetBtn = document.getElementById('sendResetBtn');
const forgotPasswordEmail = document.getElementById('forgotPasswordEmail');
const forgotPasswordAlert = document.getElementById('forgotPasswordAlert');
const forgotPasswordMessage = document.getElementById('forgotPasswordMessage');

// Open Forgot Password Modal
if (forgotPasswordLink) {
    forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();
        forgotPasswordModal.style.display = 'flex';
        forgotPasswordEmail.value = '';
        forgotPasswordAlert.classList.add('hidden');
        console.log('[Auth] Forgot password modal opened');
    });
}

// Close Modal
if (closeModalBtn) {
    closeModalBtn.addEventListener('click', () => {
        forgotPasswordModal.style.display = 'none';
        console.log('[Auth] Forgot password modal closed');
    });
}

// Close Modal when clicking outside
if (forgotPasswordModal) {
    forgotPasswordModal.addEventListener('click', (e) => {
        if (e.target === forgotPasswordModal) {
            forgotPasswordModal.style.display = 'none';
        }
    });
}

// Send Password Reset Email
if (sendResetBtn) {
    sendResetBtn.addEventListener('click', async () => {
        const email = forgotPasswordEmail.value.trim();

        if (!email) {
            showAlert('Masukkan email Anda', 'error');
            return;
        }

        if (!email.includes('@')) {
            showAlert('Format email tidak valid', 'error');
            return;
        }

        sendResetBtn.disabled = true;
        sendResetBtn.textContent = 'Mengirim...';

        try {
            console.log('[Auth] Sending password reset email to:', email);
            await sendPasswordResetEmail(auth, email);

            console.log('[Auth] Password reset email sent successfully');
            showAlert('Link reset password telah dikirim ke email Anda. Silakan cek email Anda.', 'success');

            // Auto close modal after 3 seconds
            setTimeout(() => {
                forgotPasswordModal.style.display = 'none';
                sendResetBtn.disabled = false;
                sendResetBtn.textContent = 'Kirim Link Reset';
            }, 3000);

        } catch (error) {
            console.error('[Auth] Error sending reset email:', error);

            let errorMessage = 'Gagal mengirim email reset password';

            if (error.code === 'auth/user-not-found') {
                errorMessage = 'Email tidak terdaftar di sistem';
            } else if (error.code === 'auth/invalid-email') {
                errorMessage = 'Format email tidak valid';
            } else if (error.code === 'auth/too-many-requests') {
                errorMessage = 'Terlalu banyak percobaan. Silakan coba lagi nanti';
            }

            showAlert(errorMessage, 'error');
            sendResetBtn.disabled = false;
            sendResetBtn.textContent = 'Kirim Link Reset';
        }
    });
}

// Show Alert Function
function showAlert(message, type) {
    forgotPasswordMessage.textContent = message;
    forgotPasswordAlert.classList.remove('hidden');

    if (type === 'success') {
        forgotPasswordAlert.style.backgroundColor = '#D1FAE5';
        forgotPasswordAlert.style.color = '#065F46';
        forgotPasswordAlert.style.borderColor = '#6EE7B7';
    } else {
        forgotPasswordAlert.style.backgroundColor = '#FEE2E2';
        forgotPasswordAlert.style.color = '#991B1B';
        forgotPasswordAlert.style.borderColor = '#FCA5A5';
    }
}

console.log('[Auth] Forgot password module loaded');
