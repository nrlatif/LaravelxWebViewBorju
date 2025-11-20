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
            body * {
                visibility: hidden;
            }
            #printReceipt, #printReceipt * {
                visibility: visible;
            }
            #printReceipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }

        .receipt-container {
            max-width: 300px;
            margin: 0 auto;
            font-family: 'Courier New', monospace;
            padding: 1rem;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .receipt-title {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .receipt-footer {
            border-top: 2px dashed #333;
            padding-top: 0.5rem;
            margin-top: 0.5rem;
            text-align: center;
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

        <!-- Date & Time Filter -->
        <div class="date-filter">
            <label>Filter Tanggal:</label>
            <input type="date" id="filterStartDate" placeholder="Dari">
            <label>s/d</label>
            <input type="date" id="filterEndDate" placeholder="Sampai">
            <label style="margin-left: 1rem;">Jam:</label>
            <input type="time" id="filterStartTime">
            <label>s/d</label>
            <input type="time" id="filterEndTime">
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
            endDate: null,
            startTime: null,
            endTime: null
        };

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
            `).join('');
        }

        // View order detail
        async function viewOrder(orderId) {
            const order = allOrders.find(o => o.id === orderId);
            if (order) {
                const items = order.items && order.items.length > 0 
                    ? order.items.map(item => `${item.name} x${item.quantity} - Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}`).join('\n')
                    : 'Tidak ada item';
                await window.KPAlert.info(
                    `${items}\n\nTotal: Rp ${new Intl.NumberFormat('id-ID').format(order.total)}\nStatus: ${order.status}\nTanggal: ${order.date}`,
                    `Detail Pesanan ${orderId}`
                );
            }
        }

        // Print receipt
        function printReceipt(orderId) {
            const order = allOrders.find(o => o.id === orderId);
            if (!order) return;

            // Create receipt HTML
            const receiptHTML = `
                <div class="receipt-container">
                    <div class="receipt-header">
                        <div class="receipt-title">KP BORJU</div>
                        <div style="font-size: 0.8rem;">Kedai Kopi & Makanan</div>
                        <div style="font-size: 0.75rem; margin-top: 0.5rem;">
                            ${order.date || new Date().toLocaleString('id-ID')}
                        </div>
                    </div>
                    <div style="margin: 1rem 0;">
                        <div class="receipt-item">
                            <span>No. Pesanan:</span>
                            <span>${order.id}</span>
                        </div>
                        ${order.customerName ? `
                        <div class="receipt-item">
                            <span>Pelanggan:</span>
                            <span>${order.customerName}</span>
                        </div>
                        ` : ''}
                        ${order.tableNumber && order.tableNumber !== '-' ? `
                        <div class="receipt-item">
                            <span>Meja:</span>
                            <span>${order.tableNumber}</span>
                        </div>
                        ` : ''}
                    </div>
                    <div style="border-bottom: 1px dashed #333; padding-bottom: 0.5rem; margin-bottom: 0.5rem;">
                        ${order.items && order.items.length > 0 ? order.items.map(item => `
                            <div class="receipt-item">
                                <span>${item.name} x${item.quantity}</span>
                                <span>Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</span>
                            </div>
                        `).join('') : '<div>Tidak ada item</div>'}
                    </div>
                    <div style="margin: 0.5rem 0;">
                        <div class="receipt-item">
                            <span>Subtotal:</span>
                            <span>Rp ${new Intl.NumberFormat('id-ID').format(order.subtotal || order.total)}</span>
                        </div>
                        ${order.tax && order.tax > 0 ? `
                        <div class="receipt-item">
                            <span>PPN:</span>
                            <span>Rp ${new Intl.NumberFormat('id-ID').format(order.tax)}</span>
                        </div>
                        ` : ''}
                        <div class="receipt-item" style="font-weight: bold; font-size: 1.1rem; margin-top: 0.5rem;">
                            <span>TOTAL:</span>
                            <span>Rp ${new Intl.NumberFormat('id-ID').format(order.total)}</span>
                        </div>
                    </div>
                    ${order.paymentMethod ? `
                    <div class="receipt-item" style="margin-top: 0.5rem;">
                        <span>Pembayaran:</span>
                        <span>${order.paymentMethod.toUpperCase()}</span>
                    </div>
                    ` : ''}
                    <div class="receipt-footer">
                        <div style="margin-top: 1rem; font-size: 0.8rem;">Terima Kasih</div>
                        <div style="font-size: 0.75rem; margin-top: 0.25rem;">Selamat Menikmati!</div>
                    </div>
                </div>
            `;

            // Create hidden div for printing
            let printDiv = document.getElementById('printReceipt');
            if (!printDiv) {
                printDiv = document.createElement('div');
                printDiv.id = 'printReceipt';
                printDiv.style.display = 'none';
                document.body.appendChild(printDiv);
            }
            printDiv.innerHTML = receiptHTML;

            // Trigger print
            window.print();
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

        // Filter by date and time
        function filterByDateTime(orders) {
            return orders.filter(order => {
                if (!order.date) return true;

                try {
                    // Parse order date/time (format: "21/11/2025 10:30:45" or similar)
                    const orderDateStr = order.date;
                    let orderDate;

                    // Try parsing different date formats
                    if (orderDateStr.includes('/')) {
                        // Format: DD/MM/YYYY HH:mm:ss
                        const [datePart, timePart] = orderDateStr.split(' ');
                        const [day, month, year] = datePart.split('/');
                        orderDate = new Date(`${year}-${month}-${day}T${timePart || '00:00:00'}`);
                    } else {
                        orderDate = new Date(orderDateStr);
                    }

                    if (isNaN(orderDate.getTime())) return true;

                    // Filter by date
                    if (dateFilter.startDate) {
                        const startDate = new Date(dateFilter.startDate);
                        startDate.setHours(0, 0, 0, 0);
                        if (orderDate < startDate) return false;
                    }

                    if (dateFilter.endDate) {
                        const endDate = new Date(dateFilter.endDate);
                        endDate.setHours(23, 59, 59, 999);
                        if (orderDate > endDate) return false;
                    }

                    // Filter by time
                    if (dateFilter.startTime || dateFilter.endTime) {
                        const orderHours = orderDate.getHours();
                        const orderMinutes = orderDate.getMinutes();
                        const orderTimeInMinutes = orderHours * 60 + orderMinutes;

                        if (dateFilter.startTime) {
                            const [startHours, startMinutes] = dateFilter.startTime.split(':').map(Number);
                            const startTimeInMinutes = startHours * 60 + startMinutes;
                            if (orderTimeInMinutes < startTimeInMinutes) return false;
                        }

                        if (dateFilter.endTime) {
                            const [endHours, endMinutes] = dateFilter.endTime.split(':').map(Number);
                            const endTimeInMinutes = endHours * 60 + endMinutes;
                            if (orderTimeInMinutes > endTimeInMinutes) return false;
                        }
                    }

                    return true;
                } catch (e) {
                    console.error('Error parsing date:', e);
                    return true;
                }
            });
        }

        // Reset date filter
        function resetDateFilter() {
            dateFilter = {
                startDate: null,
                endDate: null,
                startTime: null,
                endTime: null
            };
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            document.getElementById('filterStartTime').value = '';
            document.getElementById('filterEndTime').value = '';
            renderOrders();
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
            dateFilter.startDate = e.target.value;
            renderOrders();
        });

        document.getElementById('filterEndDate').addEventListener('change', (e) => {
            dateFilter.endDate = e.target.value;
            renderOrders();
        });

        document.getElementById('filterStartTime').addEventListener('change', (e) => {
            dateFilter.startTime = e.target.value;
            renderOrders();
        });

        document.getElementById('filterEndTime').addEventListener('change', (e) => {
            dateFilter.endTime = e.target.value;
            renderOrders();
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
