import { logout, onAuthChange } from './auth.js';

let statisticsUnsubscribe = null;

// Display statistics on UI
function updateStatisticsUI(stats) {
    if (!stats) stats = {};

    const totalOrdersEl = document.getElementById('totalOrders');
    const completedOrdersEl = document.getElementById('completedOrders');
    const todayRevenueEl = document.getElementById('todayRevenue');
    const activeMenusEl = document.getElementById('activeMenus');

    if (totalOrdersEl) totalOrdersEl.textContent = stats.totalOrders || 0;
    if (completedOrdersEl) completedOrdersEl.textContent = stats.completedOrders || stats.totalOrders || 0;
    if (todayRevenueEl) todayRevenueEl.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(stats.totalRevenue || 0)}`;
    if (activeMenusEl) activeMenusEl.textContent = stats.activeMenus || 0;
}

// Load statistics once (used at startup before listener is ready)
async function loadStatistics() {
    try {
        // Wait for orderFunctions to be available
        let attempts = 0;
        while (!window.orderFunctions && attempts < 20) {
            await new Promise(r => setTimeout(r, 100));
            attempts++;
        }

        const of = window.orderFunctions || {};
        if (typeof of.getStatistics === 'function') {
            console.log('[Dashboard] Loading statistics from Firestore...');
            const stats = await of.getStatistics();
            console.log('[Dashboard] Statistics loaded:', stats);
            if (stats) {
                updateStatisticsUI(stats);
                return;
            }
        }
    } catch (e) {
        console.error('[Dashboard] Failed to load statistics from Firestore:', e);
    }

    // If Firestore fails, show zeros (no localStorage fallback)
    console.log('[Dashboard] Showing zeros due to Firestore unavailable');
    updateStatisticsUI({});
}

// Set up real-time listener for statistics (auto-updates when orders change)
function setupStatisticsListener() {
    try {
        // Wait for orderFunctions to be available
        if (!window.orderFunctions) {
            console.warn('[Dashboard] setupStatisticsListener: orderFunctions not available yet, retrying...');
            setTimeout(() => setupStatisticsListener(), 200);
            return;
        }

        const of = window.orderFunctions || {};
        if (typeof of.onStatisticsChange === 'function') {
            // Unsubscribe from previous listener if any
            if (statisticsUnsubscribe) {
                statisticsUnsubscribe();
            }

            console.log('[Dashboard] Setting up statistics listener...');
            statisticsUnsubscribe = of.onStatisticsChange((err, stats) => {
                if (err) {
                    console.error('[Dashboard] Statistics listener error:', err);
                    updateStatisticsUI({});
                    return;
                }
                console.log('[Dashboard] Statistics updated from Firestore listener:', stats);
                updateStatisticsUI(stats);
            });
            console.log('[Dashboard] Statistics listener set up successfully');
            return;
        } else {
            console.warn('[Dashboard] onStatisticsChange not available in orderFunctions');
        }
    } catch (e) {
        console.error('[Dashboard] Failed to setup statistics listener:', e);
    }

    // Fallback: show zeros
    console.log('[Dashboard] Showing zeros due to listener setup failed');
    updateStatisticsUI({});
}

// Load recent orders from Firestore
async function loadRecentOrders() {
    const ordersList = document.getElementById('recentOrdersList');
    if (!ordersList) return;

    try {
        const of = window.orderFunctions || {};
        if (typeof of.getOrders === 'function') {
            const orders = await of.getOrders();
            if (!orders || orders.length === 0) {
                ordersList.innerHTML = '<div style="text-align: center; color: #999; padding: 2rem;">Tidak ada pesanan terbaru</div>';
                return;
            }

            // Show last 5 orders
            const recentOrders = orders.slice(0, 5);
            ordersList.innerHTML = recentOrders.map(order => `
                <div class="order-item">
                    <div class="order-header">
                        <span class="order-id">#${order.id || 'N/A'}</span>
                        <span class="order-status ${order.status || 'pending'}">${order.status || 'Pending'}</span>
                    </div>
                    <div class="order-details">
                        <div>Menu: ${order.items?.length || 0} item(s)</div>
                        <div class="order-total">Rp ${new Intl.NumberFormat('id-ID').format(order.total || 0)}</div>
                    </div>
                </div>
            `).join('');
            return;
        }
    } catch (e) {
        console.error('[Dashboard] Failed to load recent orders from Firestore:', e);
    }

    // If Firestore fails, show empty
    ordersList.innerHTML = '<div style="text-align: center; color: #999; padding: 2rem;">Tidak ada pesanan terbaru (Firestore tidak tersedia)</div>';
}

// Quick menu button handlers
function setupQuickMenuHandlers() {
    const cashierBtn = document.getElementById('cashierBtn');
    const historyBtn = document.getElementById('historyBtn');
    const recordBtn = document.getElementById('recordBtn');
    const menuCrudBtn = document.getElementById('menuCrudBtn');

    if (cashierBtn) {
        cashierBtn.addEventListener('click', () => {
            console.log('[Dashboard] Opening Kasir');
            window.location.href = '/kasir';
        });
    }

    if (historyBtn) {
        historyBtn.addEventListener('click', () => {
            console.log('[Dashboard] Opening Riwayat');
            window.location.href = '/riwayat';
        });
    }

    if (recordBtn) {
        recordBtn.addEventListener('click', () => {
            console.log('[Dashboard] Opening Pencatatan');
            window.location.href = '/pencatatan';
        });
    }

    if (menuCrudBtn) {
        menuCrudBtn.addEventListener('click', () => {
            console.log('[Dashboard] Opening Menu CRUD');
            window.location.href = '/menu-crud';
        });
    }
}

// Bottom navbar navigation uses href links directly
// No additional setup needed

// Sidebar navigation uses href links directly
// No additional setup needed

document.addEventListener('DOMContentLoaded', () => {
    console.log('[Dashboard] Initializing...');

    const logoutBtn = document.getElementById('logoutBtn');
    const sidebarLogoutBtn = document.getElementById('sidebarLogoutBtn');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const result = await logout();
            if (result.success) {
                    window.safeRedirectToLogin?.();
            }
        });
    }

    if (sidebarLogoutBtn) {
        sidebarLogoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const result = await logout();
            if (result.success) {
                    window.safeRedirectToLogin?.();
            }
        });
    }

    // Monitor auth state
    onAuthChange((user) => {
        if (!user) {
                window.safeRedirectToLogin?.();
        } else {
            const userNameEl = document.getElementById('userName');
            const userEmailEl = document.getElementById('userEmail');

            if (userNameEl) {
                userNameEl.textContent = user.displayName || 'Pengguna';
            }
            if (userEmailEl) {
                userEmailEl.textContent = user.email || '-';
            }

            // Load stats and orders from Firestore (async)
            (async () => {
                try {
                    console.log('[Dashboard] Loading initial statistics...');
                    await loadStatistics();

                    console.log('[Dashboard] Setting up statistics listener...');
                    setupStatisticsListener(); // Set up real-time listener for auto-updates on deletes/creates

                    console.log('[Dashboard] Loading recent orders...');
                    await loadRecentOrders();

                    setupQuickMenuHandlers();
                    setupBottomNavigation();
                    setupSidebarNavigation();

                    // Refresh recent orders every 30 seconds (stats auto-update via listener)
                    setInterval(async () => {
                        await loadRecentOrders();
                    }, 30000);

                    console.log('[Dashboard] All UI components loaded successfully');
                } catch (err) {
                    console.error('[Dashboard] Error during initialization:', err);
                }
            })();
        }
    });

    console.log('[Dashboard] Initialized');
});

export { loadStatistics, loadRecentOrders, setupStatisticsListener };
