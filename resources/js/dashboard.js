import { logout, onAuthChange, getCurrentUser } from './auth.js';
import { auth } from './firebase.js';

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

// Quick menu button handlers with role-based filtering
function setupQuickMenuHandlers(userRole) {
    const isAdmin = userRole === 'admin';
    
    // Batch DOM queries
    const buttons = {
        cashier: document.getElementById('cashierBtn'),
        history: document.getElementById('historyBtn'),
        record: document.getElementById('recordBtn'),
        menuCrud: document.getElementById('menuCrudBtn')
    };

    // Use requestAnimationFrame for optimal rendering
    requestAnimationFrame(() => {
        if (isAdmin) {
            // Admin sees all menu items
            if (buttons.cashier) buttons.cashier.style.cssText = 'display: flex !important;';
            if (buttons.history) buttons.history.style.cssText = 'display: flex !important;';
            if (buttons.record) buttons.record.style.cssText = 'display: flex !important;';
            if (buttons.menuCrud) buttons.menuCrud.style.cssText = 'display: flex !important;';
        } else {
            // Kasir only sees Kasir and Riwayat (already set by default HTML)
            if (buttons.cashier) buttons.cashier.style.cssText = 'display: flex !important;';
            if (buttons.history) buttons.history.style.cssText = 'display: flex !important;';
            // record and menuCrud remain hidden by default
        }
    });

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

// Setup sidebar menu based on role
function setupSidebarMenuByRole(userRole) {
    console.log('[Dashboard] Setting up sidebar menu for role:', userRole);
    
    const sidebarKasir = document.getElementById('sidebarKasirItem');
    const sidebarRiwayat = document.getElementById('sidebarRiwayatItem');
    const sidebarPencatatan = document.getElementById('sidebarPencatatanItem');
    const sidebarMenuCrud = document.getElementById('sidebarMenuCrudItem');

    if (userRole === 'admin') {
        // Admin sees all sidebar items
        console.log('[Dashboard] Admin - showing all sidebar items');
        if (sidebarKasir) sidebarKasir.style.display = 'block';
        if (sidebarRiwayat) sidebarRiwayat.style.display = 'block';
        if (sidebarPencatatan) sidebarPencatatan.style.display = 'block';
        if (sidebarMenuCrud) sidebarMenuCrud.style.display = 'block';
    } else {
        // Kasir only sees Kasir and Riwayat in sidebar
        console.log('[Dashboard] Kasir - hiding Pencatatan and Menu Crud from sidebar');
        if (sidebarKasir) sidebarKasir.style.display = 'block';
        if (sidebarRiwayat) sidebarRiwayat.style.display = 'block';
        if (sidebarPencatatan) sidebarPencatatan.style.display = 'none';
        if (sidebarMenuCrud) sidebarMenuCrud.style.display = 'none';
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
            console.log('[Dashboard] Logout button clicked');
            const result = await logout();
            console.log('[Dashboard] Logout result:', result);
            if (result.success) {
                console.log('[Dashboard] Redirecting to login...');
                window.location.href = '/login';
            }
        });
    }

    if (sidebarLogoutBtn) {
        sidebarLogoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            console.log('[Dashboard] Sidebar logout button clicked');
            const result = await logout();
            console.log('[Dashboard] Logout result:', result);
            if (result.success) {
                console.log('[Dashboard] Redirecting to login...');
                window.location.href = '/login';
            }
        });
    }

    // Monitor auth state
    const unsubscribe = onAuthChange((user) => {
        if (!user) {
            console.log('[Dashboard] No user detected');
            // Auth state will handle redirect after logout
            return;
        } else {
            // Log full user object to debug
            console.log('[Dashboard] Full user object:', user);
            console.log('[Dashboard] User UID:', user.uid);
            console.log('[Dashboard] User role from Firestore:', user.role);
            
            const userNameEl = document.getElementById('userName');
            const userEmailEl = document.getElementById('userEmail');
            const userRole = user.role || 'kasir'; // Default to kasir if no role

            console.log('[Dashboard] Final user role:', userRole);

            if (userNameEl) {
                userNameEl.textContent = user.displayName || user.fullName || 'Pengguna';
            }
            if (userEmailEl) {
                userEmailEl.textContent = user.email || '-';
            }

            // Display role badge
            const userInfoDiv = document.querySelector('.user-info');
            if (userInfoDiv && !document.getElementById('userRole')) {
                const roleRow = document.createElement('div');
                roleRow.className = 'user-info-row';
                roleRow.id = 'userRoleRow';
                roleRow.innerHTML = `
                    <span class="user-info-label">Role:</span>
                    <span class="user-info-value" id="userRole" style="text-transform: capitalize; font-weight: bold; color: ${userRole === 'admin' ? '#991B27' : '#4CAF50'};">
                        ${userRole === 'admin' ? 'Admin' : 'Kasir'}
                    </span>
                `;
                userInfoDiv.appendChild(roleRow);
            } else if (document.getElementById('userRole')) {
                // Update existing role display
                const roleEl = document.getElementById('userRole');
                roleEl.textContent = userRole === 'admin' ? 'Admin' : 'Kasir';
                roleEl.style.color = userRole === 'admin' ? '#991B27' : '#4CAF50';
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

                    console.log('[Dashboard] Setting up quick menu handlers with role:', userRole);
                    setupQuickMenuHandlers(userRole); // Pass user role
                    setupSidebarMenuByRole(userRole); // Setup sidebar based on role

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
