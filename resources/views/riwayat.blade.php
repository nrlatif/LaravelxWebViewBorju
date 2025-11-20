<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Riwayat Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .history-container {
            padding: 1rem;
            padding-bottom: 6rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .filter-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #E0E0E0;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            border-color: #991B27;
        }

        .filter-btn:hover {
            border-color: #991B27;
        }

        .date-filter {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .date-filter label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
        }

        .date-filter input[type="date"],
        .date-filter input[type="time"] {
            padding: 0.5rem;
            border: 2px solid #E0E0E0;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .date-filter input[type="date"]:focus,
        .date-filter input[type="time"]:focus {
            outline: none;
            border-color: #991B27;
            box-shadow: 0 0 0 3px rgba(153, 27, 39, 0.1);
        }

        .filter-reset-btn {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #991B27, #BD2630);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .filter-reset-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .order-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .order-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .order-card-header {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id {
            font-weight: bold;
            font-size: 1rem;
        }

        .order-date {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .status-completed {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .status-pending {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-processing {
            background: #E3F2FD;
            color: #0D47A1;
        }

        .order-card-body {
            padding: 1rem;
        }

        .order-items {
            margin-bottom: 1rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #E0E0E0;
            font-size: 0.9rem;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            flex: 1;
        }

        .item-qty {
            color: #666;
            margin: 0 1rem;
            min-width: 40px;
            text-align: center;
        }

        .item-price {
            font-weight: 600;
            color: #991B27;
            min-width: 100px;
            text-align: right;
        }

        .order-summary {
            background: #F5F5F5;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 1rem;
            color: #991B27;
            border-top: 2px solid #E0E0E0;
            padding-top: 0.5rem;
        }

        .order-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 0 0.5rem;
        }

        .btn-action {
            flex: 1;
            padding: 0.65rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-view {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
            background: linear-gradient(135deg, #42A5F5 0%, #2196F3 100%);
        }

        .btn-view:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(33, 150, 243, 0.3);
        }

        .btn-print {
            background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
            color: white;
        }

        .btn-print:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, #66BB6A 0%, #4CAF50 100%);
        }

        .btn-print:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #FF6B6B 0%, #F44336 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #FF8A80 0%, #FF6B6B 100%);
        }

        .btn-delete:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(255, 107, 107, 0.3);
        }

        @media (max-width: 640px) {
            .order-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-action {
                width: 100%;
            }
        }

        /* Print receipt styles */
        @media print {
            body > * {
                display: none !important;
            }
            #printReceipt {
                display: block !important;
                position: fixed;
                left: 0;
                top: 0;
                width: 80mm;
                height: 80mm;
                margin: 0;
                padding: 0;
            }
            #printReceipt * {
                visibility: visible;
            }
            @page {
                margin: 0;
                size: 80mm 80mm;
            }
        }

        #printReceipt {
            display: none;
        }

        .receipt-container {
            width: 80mm;
            height: 80mm;
            max-width: 80mm;
            max-height: 80mm;
            margin: 0;
            padding: 3mm;
            font-family: 'Courier New', monospace;
            background: white;
            color: black;
            font-size: 8pt;
            overflow: hidden;
            box-sizing: border-box;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 1mm;
            margin-bottom: 1.5mm;
        }

        .receipt-logo {
            font-size: 10pt;
            font-weight: bold;
            color: #991B27;
            margin-bottom: 0.1mm;
            letter-spacing: 1px;
        }

        .receipt-title {
            font-weight: bold;
            font-size: 8pt;
            margin-bottom: 0.5mm;
        }

        .receipt-subtitle {
            font-size: 6pt;
            color: #666;
            margin-bottom: 0.3mm;
            line-height: 1.1;
        }

        .receipt-divider {
            border-bottom: 1px dashed #333;
            margin: 1.5mm 0;
        }

        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8mm;
            font-size: 7pt;
        }

        .receipt-info-label {
            font-weight: 600;
        }

        .receipt-item {
            margin-bottom: 1mm;
        }

        .receipt-item-name {
            font-size: 8pt;
            font-weight: 600;
            margin-bottom: 0.5mm;
            text-align: left;
        }

        .receipt-item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 7pt;
            color: #555;
            padding-left: 2mm;
        }

        .receipt-summary {
            border-top: 1px dashed #333;
            padding-top: 1.5mm;
            margin-top: 1.5mm;
        }

        .receipt-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8mm;
            font-size: 7pt;
        }

        .receipt-total {
            font-size: 9pt;
            font-weight: bold;
            margin-top: 0.8mm;
            padding-top: 0.8mm;
            border-top: 1px solid #333;
        }

        .receipt-footer {
            border-top: 1px dashed #333;
            padding-top: 1.5mm;
            margin-top: 2mm;
            text-align: center;
        }

        .receipt-thank-you {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 1mm;
            color: #000;
        }

        .receipt-message {
            font-size: 7pt;
            color: #333;
            margin-bottom: 0.5mm;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #999;
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #991B27;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top navbar removed -->

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Bottom Navbar -->
    @include('partials.bottom-navbar')

    <div class="history-container">
        <!-- Statistics Summary -->
        <div class="stats-summary">
            <div class="stat-box">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value" id="statTotalOrders">0</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value" style="font-size: 1.1rem;" id="statTotalRevenue">Rp 0</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pesanan Selesai</div>
                <div class="stat-value" id="statCompleted">0</div>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="date-filter">
            <label>Filter Tanggal:</label>
            <input type="date" id="filterStartDate" placeholder="Dari">
            <label>s/d</label>
            <input type="date" id="filterEndDate" placeholder="Sampai">
            <button class="filter-reset-btn" onclick="resetDateFilter()">Reset</button>
        </div>

        <!-- Status Filter Bar -->
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="completed">Selesai</button>
            <button class="filter-btn" data-filter="pending">Pending</button>
            <button class="filter-btn" data-filter="processing">Proses</button>
        </div>

        <!-- Order List -->
        <div class="order-list" id="orderList">
            <div class="empty-state">Tidak ada pesanan</div>
        </div>
    </div>

    <script>
        let allOrders = [];
        let currentFilter = 'all';
        let dateFilter = {
            startDate: null,
            endDate: null
        };
        let userRole = null; // Will be set after auth check
        let isRoleChecked = false;

        // Get current user role using onAuthChange
        async function getCurrentUserRole() {
            return new Promise(async (resolve) => {
                console.log('[History] Starting role check...');
                
                // Wait for authFunctions to be available
                let attempts = 0;
                while (!window.authFunctions && attempts < 50) {
                    await new Promise(r => setTimeout(r, 100));
                    attempts++;
                }

                if (!window.authFunctions || !window.authFunctions.onAuthChange) {
                    console.error('[History] authFunctions not available');
                    userRole = 'admin'; // Default to admin to avoid blocking
                    isRoleChecked = true;
                    resolve(userRole);
                    return;
                }

                // Use onAuthChange to get user with role
                const unsubscribe = window.authFunctions.onAuthChange((user) => {
                    if (user) {
                        userRole = user.role || 'kasir';
                        console.log('[History] User role from auth:', userRole);
                        console.log('[History] User data:', user);
                    } else {
                        userRole = 'admin'; // Default to admin if no user
                        console.log('[History] No user logged in, defaulting to admin');
                    }
                    
                    isRoleChecked = true;
                    if (unsubscribe) unsubscribe();
                    resolve(userRole);
                });
            });
        }

        // Set today's date filter for kasir
        function setTodayFilter() {
            const today = new Date();
            // Get local date in YYYY-MM-DD format
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const todayStr = `${year}-${month}-${day}`;
            
            dateFilter.startDate = todayStr;
            dateFilter.endDate = todayStr;
            
            // Update UI
            const startDateInput = document.getElementById('filterStartDate');
            const endDateInput = document.getElementById('filterEndDate');
            if (startDateInput) startDateInput.value = todayStr;
            if (endDateInput) endDateInput.value = todayStr;
            
            console.log('[History] Date filter set to today (local time):', todayStr);
        }

        // Load orders (Firestore only, no localStorage fallback)
        async function initOrders() {
            // Wait briefly for orderFunctions to be available
            let attempts = 0;
            while (!window.orderFunctions && attempts < 20) {
                await new Promise(r => setTimeout(r, 100));
                attempts++;
            }

            const of = window.orderFunctions || {};
            if (typeof of.onOrdersChange === 'function') {
                // Use real-time listener
                try {
                    // Initial fetch
                    if (typeof of.getOrders === 'function') {
                        const items = await of.getOrders();
                        allOrders = items || [];
                        updateStatistics();
                        renderOrders();
                    }

                    // Subscribe to changes
                    const unsub = of.onOrdersChange((err, items) => {
                        if (err) {
                            console.error('[History] orders listener error:', err);
                            return;
                        }
                        allOrders = items || [];
                        updateStatistics();
                        renderOrders();
                    });

                    // store unsub if needed later
                    window._ordersUnsub = unsub;
                    return;
                } catch (e) {
                    console.error('[History] Failed to use Firestore orders:', e);
                    await window.KPAlert.error('Gagal menghubungkan ke Firestore.\n\nError: ' + (e && e.message ? e.message : String(e)), 'Koneksi Gagal');
                }
            } else {
                await window.KPAlert.error('Firestore orders tidak tersedia. Pastikan Firebase sudah dikonfigurasi dan Anda terhubung ke internet.', 'Koneksi Gagal');
            }
        }

        // Display statistics on UI
        function displayStatistics(stats) {
            if (!stats) stats = {};
            document.getElementById('statTotalOrders').textContent = stats.totalOrders || 0;
            document.getElementById('statTotalRevenue').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(stats.totalRevenue || 0)}`;
            document.getElementById('statCompleted').textContent = stats.completedOrders || stats.totalOrders || 0;
        }

        // Calculate statistics from filtered orders
        function calculateFilteredStatistics(orders) {
            const totalOrders = orders.length;
            const totalRevenue = orders.reduce((sum, order) => sum + (order.total || 0), 0);
            const completedOrders = orders.filter(order => order.status === 'completed').length;
            
            return {
                totalOrders,
                totalRevenue,
                completedOrders
            };
        }

        // Set up real-time listener for statistics (auto-updates when orders change)
        function setupStatisticsListener() {
            try {
                const of = window.orderFunctions || {};
                if (typeof of.onStatisticsChange === 'function') {
                    const unsub = of.onStatisticsChange((err, stats) => {
                        if (err) {
                            console.error('[History] Statistics listener error:', err);
                            displayStatistics({});
                            return;
                        }
                        console.log('[History] Statistics updated from Firestore:', stats);
                        displayStatistics(stats);
                    });
                    window._statisticsUnsub = unsub;
                    return;
                }
            } catch (e) {
                console.error('[History] Failed to setup statistics listener:', e);
            }

            // Fallback: show zeros
            displayStatistics({});
        }

        // Update statistics once (used at startup before listener is ready)
        async function updateStatistics() {
            const of = window.orderFunctions || {};
            if (typeof of.getStatistics === 'function') {
                try {
                    const s = await of.getStatistics();
                    if (s) {
                        displayStatistics(s);
                        return;
                    }
                } catch (e) {
                    console.error('[History] Failed to load stats from Firestore:', e);
                }
            }

            // If Firestore fails, show zeros
            displayStatistics({});
        }

        // Filter orders
        function filterOrders(filter) {
            if (filter === 'all') {
                return allOrders;
            }
            return allOrders.filter(order => order.status === filter);
        }

        // Render orders
        function renderOrders() {
            let filtered = filterOrders(currentFilter);
            filtered = filterByDateTime(filtered);
            const orderList = document.getElementById('orderList');

            // Update statistics based on filtered orders
            const filteredStats = calculateFilteredStatistics(filtered);
            displayStatistics(filteredStats);

            if (filtered.length === 0) {
                orderList.innerHTML = '<div class="empty-state">Tidak ada pesanan</div>';
                return;
            }

            orderList.innerHTML = filtered.reverse().map(order => {
                // Format date to show date and time
                let displayDate = 'N/A';
                if (order.date) {
                    displayDate = order.date; // Show full date with time (DD/MM/YYYY HH:MM:SS)
                }
                
                return `
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <div class="order-id">${order.id}</div>
                            <div class="order-date">${displayDate}</div>
                        </div>
                        <span class="order-status status-${order.status || 'pending'}">${
                            order.status === 'completed' ? 'Selesai' :
                            order.status === 'processing' ? 'Proses' :
                            'Pending'
                        }</span>
                    </div>
                    <div class="order-card-body">
                        <div class="order-items">
                            ${order.items.map(item => `
                                <div class="order-item">
                                    <span class="item-name">${item.name}</span>
                                    <span class="item-qty">x${item.quantity}</span>
                                    <span class="item-price">Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</span>
                                </div>
                            `).join('')}
                        </div>
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span>Rp ${new Intl.NumberFormat('id-ID').format(order.subtotal)}</span>
                            </div>
                            <div class="summary-row">
                                <span>PPN (10%):</span>
                                <span>Rp ${new Intl.NumberFormat('id-ID').format(order.tax)}</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total:</span>
                                <span>Rp ${new Intl.NumberFormat('id-ID').format(order.total)}</span>
                            </div>
                        </div>
                        <div class="order-actions">
                            <button class="btn-action btn-view" onclick="viewOrder('${order.id}')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                Detail
                            </button>
                            <button class="btn-action btn-print" onclick="printReceipt('${order.id}')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                                </svg>
                                Cetak
                            </button>
                            <button class="btn-action btn-delete" onclick="deleteOrder('${order.id}')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;
            }).join('');
        }

        // View order detail
        async function viewOrder(orderId) {
            const order = allOrders.find(o => o.id === orderId);
            if (order) {
                const displayDate = order.date || 'N/A';
                const statusText = order.status === 'completed' ? 'Selesai' : 
                                 order.status === 'processing' ? 'Proses' : 'Pending';
                
                let detailHTML = '<div style="text-align: left; font-size: 0.85rem; line-height: 1.5; max-height: 50vh; overflow-y: auto; overflow-x: hidden; padding: 2px;">';
                
                // Customer & Table Info - Compact
                if (order.customerName || order.tableNumber) {
                    detailHTML += '<div style="margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #e5e7eb; font-size: 0.8rem;">';
                    const infoParts = [];
                    if (order.customerName) infoParts.push(`<strong>Pelanggan:</strong> ${order.customerName}`);
                    if (order.tableNumber) infoParts.push(`<strong>Meja:</strong> ${order.tableNumber}`);
                    detailHTML += infoParts.join(' | ');
                    detailHTML += '</div>';
                }
                
                // Order Items - Compact
                detailHTML += '<div style="margin-bottom: 10px;">';
                if (order.items && order.items.length > 0) {
                    order.items.forEach(item => {
                        detailHTML += `
                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 6px; padding: 4px 0; border-bottom: 1px solid #f8fafc;">
                                <span style="flex: 1; font-size: 0.8rem;">${item.name} <span style="color: #94a3b8;">×${item.quantity}</span></span>
                                <span style="font-weight: 600; font-size: 0.8rem; white-space: nowrap;">Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</span>
                            </div>
                        `;
                    });
                }
                detailHTML += '</div>';
                
                // Summary - Compact
                detailHTML += `
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 8px; margin-top: 8px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 0.95rem;">
                            <strong>Total:</strong>
                            <strong style="color: #991B27;">Rp ${new Intl.NumberFormat('id-ID').format(order.total)}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: #64748b; font-size: 0.75rem;">
                            <span>Status: <strong style="color: ${order.status === 'completed' ? '#16a34a' : '#f59e0b'};">${statusText}</strong></span>
                            <span>${displayDate}</span>
                        </div>
                    </div>
                `;
                
                detailHTML += '</div>';
                
                await window.KPAlert.info(
                    detailHTML,
                    `Detail #${orderId}`
                );
            }
        }

        // Print receipt
        function printReceipt(orderId) {
            const order = allOrders.find(o => o.id === orderId);
            if (!order) {
                console.error('Order tidak ditemukan:', orderId);
                return;
            }

            console.log('Printing order:', order);

            // Format date and time
            const orderDateTime = order.date || new Date().toLocaleString('id-ID');
            const currentDateTime = new Date().toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Create receipt HTML
            const receiptHTML = `
                <div class="receipt-container">
                    <!-- Header -->
                    <div class="receipt-header">
                        <div class="receipt-logo">KEDAI SAMBEL BORJU</div>
                        <div class="receipt-title">Kedai Makanan dan Minuman</div>
                        <div class="receipt-subtitle" style="font-size: 0.75rem; line-height: 1.3;">Jl. Raya Cigugur No.30B, Kuningan</div>
                        <div class="receipt-subtitle" style="font-size: 0.75rem;">Kec. Kuningan, Kab. Kuningan</div>
                    </div>

                    <!-- Order Info -->
                    <div style="margin-bottom: 2mm;">
                        <div class="receipt-info-row">
                            <span class="receipt-info-label">No:</span>
                            <span><strong>#${order.id}</strong></span>
                        </div>
                        <div class="receipt-info-row">
                            <span class="receipt-info-label">Tanggal:</span>
                            <span style="font-size: 6pt;">${orderDateTime}</span>
                        </div>
                        ${order.customerName ? `
                        <div class="receipt-info-row">
                            <span class="receipt-info-label">Pelanggan:</span>
                            <span>${order.customerName}</span>
                        </div>
                        ` : ''}
                        ${order.tableNumber && order.tableNumber !== '-' ? `
                        <div class="receipt-info-row">
                            <span class="receipt-info-label">No. Meja:</span>
                            <span>${order.tableNumber}</span>
                        </div>
                        ` : ''}
                    </div>

                    <div class="receipt-divider"></div>

                    <!-- Order Items -->
                    <div style="margin-bottom: 2mm;">
                        ${order.items && order.items.length > 0 ? order.items.map(item => `
                            <div class="receipt-item">
                                <div class="receipt-item-name">${item.name}</div>
                                <div class="receipt-item-detail">
                                    <span>${item.quantity} x Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</span>
                                    <span><strong>Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</strong></span>
                                </div>
                            </div>
                        `).join('') : '<div class="receipt-item-name">Tidak ada item</div>'}
                    </div>

                    <!-- Summary -->
                    <div class="receipt-summary">
                        <div class="receipt-summary-row">
                            <span>Subtotal:</span>
                            <span>Rp ${new Intl.NumberFormat('id-ID').format(order.subtotal || order.total)}</span>
                        </div>
                        ${order.tax && order.tax > 0 ? `
                        <div class="receipt-summary-row">
                            <span>PPN:</span>
                            <span>Rp ${new Intl.NumberFormat('id-ID').format(order.tax)}</span>
                        </div>
                        ` : ''}
                        <div class="receipt-summary-row receipt-total">
                            <span>TOTAL:</span>
                            <span>Rp ${new Intl.NumberFormat('id-ID').format(order.total)}</span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="receipt-footer">
                        <div class="receipt-thank-you">TERIMA KASIH</div>
                        <div class="receipt-message">Selamat Menikmati!</div>
                    </div>
                </div>
            `;

            // Create or update hidden div for printing
            let printDiv = document.getElementById('printReceipt');
            if (!printDiv) {
                printDiv = document.createElement('div');
                printDiv.id = 'printReceipt';
                document.body.appendChild(printDiv);
            }
            printDiv.innerHTML = receiptHTML;

            // Trigger print after a short delay to ensure content is rendered
            setTimeout(() => {
                window.print();
            }, 100);
        }

        // Delete order — Firestore only (no localStorage fallback)
        async function deleteOrder(firestoreDocId) {
            const confirmed = await window.KPAlert.confirm('Pesanan ini akan dihapus secara permanen', 'Hapus Pesanan?');
            if (!confirmed) return;

            console.log('[History] deleteOrder called with ID:', firestoreDocId);
            const of = window.orderFunctions || {};

            if (typeof of.deleteOrder === 'function') {
                try {
                    console.log('[History] Attempting Firestore delete for doc ID:', firestoreDocId);
                    const res = await of.deleteOrder(firestoreDocId);
                    console.log('[History] deleteOrder response:', res);
                    if (res && res.success) {
                        console.log('[History] Order deleted in Firestore successfully:', firestoreDocId);
                        await window.KPAlert.success('Pesanan telah dihapus dari sistem', 'Berhasil Dihapus');
                        // Wait a moment for the listener to update, then refresh UI
                        setTimeout(() => {
                            updateStatistics();
                            renderOrders();
                        }, 500);
                        return;
                    } else {
                        const errorMsg = res ? res.error : 'Unknown error';
                        console.error('[History] Firestore deleteOrder failed:', errorMsg);
                        await window.KPAlert.error('Gagal menghapus pesanan dari Firestore.\n\nError: ' + errorMsg, 'Gagal Menghapus');
                    }
                } catch (e) {
                    console.error('[History] Firestore deleteOrder exception:', e);
                    await window.KPAlert.error('Gagal menghapus pesanan dari Firestore.\n\nError: ' + (e && e.message ? e.message : String(e)), 'Gagal Menghapus');
                }
            } else {
                await window.KPAlert.error('Firestore delete tidak tersedia. Pastikan koneksi internet aktif.', 'Koneksi Gagal');
            }
        }

        // Filter by date
        function filterByDateTime(orders) {
            // If no date filter is set, return all orders
            if (!dateFilter.startDate && !dateFilter.endDate) {
                return orders;
            }

            return orders.filter(order => {
                if (!order.date) return false;

                try {
                    // Parse order date (format: "21/11/2025 10:30:45" or "21/11/2025")
                    const orderDateStr = order.date.trim();
                    const datePart = orderDateStr.split(' ')[0]; // Get DD/MM/YYYY
                    const [day, month, year] = datePart.split('/').map(str => parseInt(str, 10));
                    
                    // Create date object (month is 0-indexed in JS)
                    const orderDate = new Date(year, month - 1, day);
                    
                    if (isNaN(orderDate.getTime())) {
                        return false;
                    }

                    // Normalize to date only (remove time)
                    orderDate.setHours(0, 0, 0, 0);

                    // Filter by start date
                    if (dateFilter.startDate) {
                        const startDate = new Date(dateFilter.startDate);
                        startDate.setHours(0, 0, 0, 0);
                        if (orderDate < startDate) {
                            return false;
                        }
                    }

                    // Filter by end date
                    if (dateFilter.endDate) {
                        const endDate = new Date(dateFilter.endDate);
                        endDate.setHours(0, 0, 0, 0);
                        if (orderDate > endDate) {
                            return false;
                        }
                    }

                    return true;
                } catch (e) {
                    console.error('Error parsing date:', orderDateStr, e);
                    return false;
                }
            });
        }

        // Reset date filter
        function resetDateFilter() {
            // For kasir, reset to today only
            if (userRole === 'kasir') {
                setTodayFilter();
            } else {
                // For admin, clear all filters
                dateFilter = {
                    startDate: null,
                    endDate: null
                };
                document.getElementById('filterStartDate').value = '';
                document.getElementById('filterEndDate').value = '';
            }
            renderOrders(); // This will also update statistics
        }

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                renderOrders();
            });
        });

        // Date filter event listeners
        document.getElementById('filterStartDate').addEventListener('change', (e) => {
            // Wait for role check to complete
            if (!isRoleChecked) {
                console.log('[History] Role check not complete yet');
                return;
            }
            
            // Kasir cannot change date filter (locked to today)
            if (userRole === 'kasir') {
                setTodayFilter();
                if (window.KPAlert && window.KPAlert.warning) {
                    window.KPAlert.warning('Akun kasir hanya dapat melihat riwayat hari ini', 'Akses Terbatas');
                }
                return;
            }
            dateFilter.startDate = e.target.value;
            renderOrders();
        });

        document.getElementById('filterEndDate').addEventListener('change', (e) => {
            // Wait for role check to complete
            if (!isRoleChecked) {
                console.log('[History] Role check not complete yet');
                return;
            }
            
            // Kasir cannot change date filter (locked to today)
            if (userRole === 'kasir') {
                setTodayFilter();
                if (window.KPAlert && window.KPAlert.warning) {
                    window.KPAlert.warning('Akun kasir hanya dapat melihat riwayat hari ini', 'Akses Terbatas');
                }
                return;
            }
            dateFilter.endDate = e.target.value;
            renderOrders();
        });

        // Initialize
        (async () => {
            // Get user role first
            await getCurrentUserRole();
            
            // If kasir, set today filter and disable date inputs
            if (userRole === 'kasir') {
                setTodayFilter();
                
                // Disable date inputs for kasir
                const startDateInput = document.getElementById('filterStartDate');
                const endDateInput = document.getElementById('filterEndDate');
                if (startDateInput) {
                    startDateInput.style.opacity = '0.6';
                    startDateInput.style.cursor = 'not-allowed';
                    startDateInput.title = 'Kasir hanya dapat melihat riwayat hari ini';
                }
                if (endDateInput) {
                    endDateInput.style.opacity = '0.6';
                    endDateInput.style.cursor = 'not-allowed';
                    endDateInput.title = 'Kasir hanya dapat melihat riwayat hari ini';
                }
                
                console.log('[History] Kasir mode: Date filter locked to today');
            }
            
            await updateStatistics();
            setupStatisticsListener(); // Set up real-time listener for auto-updates
            initOrders();
        })();
    </script>
</body>
</html>
