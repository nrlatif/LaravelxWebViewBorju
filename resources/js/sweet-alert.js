// Custom Sweet Alert system - lightweight and beautiful
// No external dependencies needed

const alertStyles = `
<style id="kp-alert-styles">
    .kp-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        animation: kpAlertFadeIn 0.2s ease;
    }

    @keyframes kpAlertFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes kpAlertSlideIn {
        from { 
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to { 
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .kp-alert-box {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 100%;
        padding: 2rem;
        animation: kpAlertSlideIn 0.3s ease;
        text-align: center;
    }

    .kp-alert-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .kp-alert-icon.success {
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
    }

    .kp-alert-icon.error {
        background: linear-gradient(135deg, #FF6B6B, #FF5252);
        color: white;
    }

    .kp-alert-icon.warning {
        background: linear-gradient(135deg, #FFC107, #FFB300);
        color: white;
    }

    .kp-alert-icon.info {
        background: linear-gradient(135deg, #2196F3, #1976D2);
        color: white;
    }

    .kp-alert-icon.confirm {
        background: linear-gradient(135deg, #991B27, #BD2630);
        color: white;
    }

    .kp-alert-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.75rem;
    }

    .kp-alert-message {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        white-space: pre-line;
    }

    .kp-alert-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .kp-alert-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        min-width: 100px;
    }

    .kp-alert-btn.primary {
        background: linear-gradient(135deg, #991B27, #BD2630);
        color: white;
    }

    .kp-alert-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
    }

    .kp-alert-btn.secondary {
        background: white;
        color: #991B27;
        border: 2px solid #991B27;
    }

    .kp-alert-btn.secondary:hover {
        background: #F5F5F5;
    }
</style>
`;

// Inject styles once
if (!document.getElementById('kp-alert-styles')) {
    document.head.insertAdjacentHTML('beforeend', alertStyles);
}

/**
 * Show custom alert
 * @param {Object} options - Alert options
 * @param {string} options.title - Alert title
 * @param {string} options.message - Alert message
 * @param {string} options.type - Alert type: success, error, warning, info, confirm
 * @param {string} options.confirmText - Confirm button text
 * @param {string} options.cancelText - Cancel button text (for confirm type)
 * @returns {Promise<boolean>} - true if confirmed, false if cancelled
 */
export function showAlert({
    title = 'Notification',
    message = '',
    type = 'info',
    confirmText = 'OK',
    cancelText = 'Batal'
}) {
    return new Promise((resolve) => {
        // Remove existing alert if any
        const existing = document.querySelector('.kp-alert-overlay');
        if (existing) existing.remove();

        // Icon mapping
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ',
            confirm: '?'
        };

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'kp-alert-overlay';

        // Create alert box
        const isConfirm = type === 'confirm';
        overlay.innerHTML = `
            <div class="kp-alert-box">
                <div class="kp-alert-icon ${type}">
                    ${icons[type] || icons.info}
                </div>
                <div class="kp-alert-title">${title}</div>
                <div class="kp-alert-message">${message}</div>
                <div class="kp-alert-buttons">
                    ${isConfirm ? `<button class="kp-alert-btn secondary" data-action="cancel">${cancelText}</button>` : ''}
                    <button class="kp-alert-btn primary" data-action="confirm">${confirmText}</button>
                </div>
            </div>
        `;

        // Handle button clicks
        overlay.addEventListener('click', (e) => {
            if (e.target.classList.contains('kp-alert-overlay')) {
                // Click outside - close for non-confirm, cancel for confirm
                overlay.remove();
                resolve(!isConfirm);
            }

            const action = e.target.dataset.action;
            if (action === 'confirm') {
                overlay.remove();
                resolve(true);
            } else if (action === 'cancel') {
                overlay.remove();
                resolve(false);
            }
        });

        // Add to DOM
        document.body.appendChild(overlay);

        // Focus confirm button
        setTimeout(() => {
            const confirmBtn = overlay.querySelector('[data-action="confirm"]');
            if (confirmBtn) confirmBtn.focus();
        }, 100);
    });
}

/**
 * Success alert
 */
export function showSuccess(message, title = 'Berhasil!') {
    return showAlert({ title, message, type: 'success' });
}

/**
 * Error alert
 */
export function showError(message, title = 'Terjadi Kesalahan') {
    return showAlert({ title, message, type: 'error' });
}

/**
 * Warning alert
 */
export function showWarning(message, title = 'Perhatian') {
    return showAlert({ title, message, type: 'warning' });
}

/**
 * Info alert
 */
export function showInfo(message, title = 'Informasi') {
    return showAlert({ title, message, type: 'info' });
}

/**
 * Confirm dialog
 */
export function showConfirm(message, title = 'Konfirmasi') {
    return showAlert({ 
        title, 
        message, 
        type: 'confirm',
        confirmText: 'Ya',
        cancelText: 'Tidak'
    });
}

// Export as window global for easy access in blade templates
if (typeof window !== 'undefined') {
    window.KPAlert = {
        show: showAlert,
        success: showSuccess,
        error: showError,
        warning: showWarning,
        info: showInfo,
        confirm: showConfirm
    };
}
