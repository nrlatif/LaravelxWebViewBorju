<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Riwayat Pesanan - KP Borju</title>
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
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
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
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-action {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-view {
            background: #2196F3;
            color: white;
        }

        .btn-view:hover {
            background: #1976D2;
        }

        .btn-delete {
            background: #FF6B6B;
            color: white;
        }

        .btn-delete:hover {
            background: #FF5252;
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

        <!-- Filter Bar -->
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
                    alert('Gagal menghubungkan ke Firestore.\n\nError: ' + (e && e.message ? e.message : String(e)));
                }
            } else {
                alert('Firestore orders tidak tersedia. Pastikan Firebase sudah dikonfigurasi dan Anda terhubung ke internet.');
            }
        }

        // Display statistics on UI
        function displayStatistics(stats) {
            if (!stats) stats = {};
            document.getElementById('statTotalOrders').textContent = stats.totalOrders || 0;
            document.getElementById('statTotalRevenue').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(stats.totalRevenue || 0)}`;
            document.getElementById('statCompleted').textContent = stats.completedOrders || stats.totalOrders || 0;
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
            const filtered = filterOrders(currentFilter);
            const orderList = document.getElementById('orderList');

            if (filtered.length === 0) {
                orderList.innerHTML = '<div class="empty-state">Tidak ada pesanan</div>';
                return;
            }

            orderList.innerHTML = filtered.reverse().map(order => `
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <div class="order-id">${order.id}</div>
                            <div class="order-date">${order.date || 'N/A'}</div>
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
                            <button class="btn-view" onclick="viewOrder('${order.id}')">Lihat Detail</button>
                            <button class="btn-delete" onclick="deleteOrder('${order.id}')">Hapus</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // View order detail
        function viewOrder(orderId) {
            const order = allOrders.find(o => o.id === orderId);
            if (order) {
                alert(`Detail Pesanan ${orderId}\n\n` +
                    `Total: Rp ${new Intl.NumberFormat('id-ID').format(order.total)}\n` +
                    `Status: ${order.status}\n` +
                    `Tanggal: ${order.date}`);
            }
        }

        // Delete order — Firestore only (no localStorage fallback)
        async function deleteOrder(firestoreDocId) {
            if (!confirm('Yakin ingin menghapus pesanan ini?')) return;

            console.log('[History] deleteOrder called with ID:', firestoreDocId);
            const of = window.orderFunctions || {};

            if (typeof of.deleteOrder === 'function') {
                try {
                    console.log('[History] Attempting Firestore delete for doc ID:', firestoreDocId);
                    const res = await of.deleteOrder(firestoreDocId);
                    console.log('[History] deleteOrder response:', res);
                    if (res && res.success) {
                        console.log('[History] Order deleted in Firestore successfully:', firestoreDocId);
                        alert('Pesanan berhasil dihapus');
                        // Wait a moment for the listener to update, then refresh UI
                        setTimeout(() => {
                            updateStatistics();
                            renderOrders();
                        }, 500);
                        return;
                    } else {
                        const errorMsg = res ? res.error : 'Unknown error';
                        console.error('[History] Firestore deleteOrder failed:', errorMsg);
                        alert('Gagal menghapus pesanan dari Firestore.\n\nError: ' + errorMsg);
                    }
                } catch (e) {
                    console.error('[History] Firestore deleteOrder exception:', e);
                    alert('Gagal menghapus pesanan dari Firestore.\n\nError: ' + (e && e.message ? e.message : String(e)));
                }
            } else {
                alert('Firestore delete tidak tersedia.');
            }
        }        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                renderOrders();
            });
        });

        // Initialize
        (async () => {
            await updateStatistics();
            setupStatisticsListener(); // Set up real-time listener for auto-updates
            initOrders();
        })();
    </script>
</body>
</html>
