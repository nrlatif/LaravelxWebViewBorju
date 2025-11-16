<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Dashboard - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Dashboard specific styles */
        body.sidebar-open {
            overflow: hidden;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 40;
            overflow-y: auto;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-content {
            padding: 1rem 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #ED884C;
        }

        .sidebar-menu svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 1rem;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 30;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Top navbar */
        .navbar {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-toggle {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-toggle svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Main content */
        .main-content {
            padding: 1rem;
            padding-bottom: 5rem;
        }

        /* Bottom navbar for mobile */
        .bottom-navbar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 2px solid #E0E0E0;
            display: none;
            z-index: 20;
        }

        @media (max-width: 640px) {
            .bottom-navbar {
                display: flex;
                justify-content: space-around;
                align-items: center;
            }

            .main-content {
                padding-bottom: 6rem;
            }

            .navbar {
                padding: 0.75rem;
            }

            .navbar-brand {
                font-size: 1.25rem;
            }
        }

        .bottom-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            text-decoration: none;
            color: #666;
            font-size: 0.75rem;
            text-align: center;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .bottom-nav-item:hover,
        .bottom-nav-item.active {
            color: #991B27;
        }

        .bottom-nav-item svg {
            width: 1.5rem;
            height: 1.5rem;
            margin-bottom: 0.25rem;
        }

        /* Content card */
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            color: #991B27;
            margin-bottom: 1rem;
        }

        .user-info {
            background: linear-gradient(135deg, rgba(153, 27, 39, 0.05) 0%, rgba(189, 38, 48, 0.05) 100%);
            border-left: 4px solid #991B27;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .user-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .user-info-row:last-child {
            border-bottom: none;
        }

        .user-info-label {
            font-weight: 600;
            color: #991B27;
        }

        .user-info-value {
            color: #555;
        }

        .logout-btn {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #BD2630 0%, #991B27 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 28px;
            height: 28px;
        }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: bold;
            color: #991B27;
            word-break: break-word;
        }

        /* Quick Menu Grid */
        .quick-menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .quick-menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .quick-menu-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            border: none;
            background: white;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 0.875rem;
            font-weight: 500;
            color: #333;
        }

        .quick-menu-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .quick-menu-btn:active {
            transform: translateY(-2px);
        }

        .quick-menu-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quick-menu-icon svg {
            width: 32px;
            height: 32px;
        }

        /* Order Item */
        .order-item {
            background: white;
            border-left: 4px solid #991B27;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .order-id {
            font-weight: bold;
            color: #991B27;
            font-size: 0.9rem;
        }

        .order-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .order-status.completed {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .order-status.pending {
            background: #FFF3E0;
            color: #E65100;
        }

        .order-status.processing {
            background: #E3F2FD;
            color: #0D47A1;
        }

        .order-details {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
        }

        .order-total {
            margin-top: 0.5rem;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('partials.sidebar')

    <!-- Top Navbar (shared partial) -->
    <!-- Top Navbar (brand + hamburger) -->
    @include('partials.navbar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Card -->
        <div class="card">
            <div class="card-header">Selamat Datang di Dashboard</div>
            <div class="user-info">
                <div class="user-info-row">
                    <span class="user-info-label">Nama:</span>
                    <span class="user-info-value" id="userName">Loading...</span>
                </div>
                <div class="user-info-row">
                    <span class="user-info-label">Email:</span>
                    <span class="user-info-value" id="userEmail">Loading...</span>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value" id="totalOrders">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ED884C 0%, #FFA500 100%);">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pesanan Selesai</div>
                    <div class="stat-value" id="completedOrders">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pendapatan Hari Ini</div>
                    <div class="stat-value" id="todayRevenue">Rp 0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #2196F3 0%, #42A5F5 100%);">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path d="M11 9H9V2H8v7H6V2H5v7H3V2H2v20h20V2h-1v7h-3V2h-1v7h-3V2h-1v7zm7 8H7v-5h11v5z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Menu Aktif</div>
                    <div class="stat-value" id="activeMenus">0</div>
                </div>
            </div>
        </div>

        <!-- Quick Action Menu -->
        <div class="card">
            <div class="card-header">Menu Cepat</div>
            <div class="quick-menu-grid">
                <button class="quick-menu-btn" id="cashierBtn">
                    <div class="quick-menu-icon" style="background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);">
                        <svg fill="white" viewBox="0 0 24 24">
                            <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-4 10h-2v2h-2v-2h-2v-2h2V8h2v2h2v2z"/>
                        </svg>
                    </div>
                    <span>Kasir</span>
                </button>

                <button class="quick-menu-btn" id="historyBtn">
                    <div class="quick-menu-icon" style="background: linear-gradient(135deg, #ED884C 0%, #FFA500 100%);">
                        <svg fill="white" viewBox="0 0 24 24">
                            <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                        </svg>
                    </div>
                    <span>Riwayat</span>
                </button>

                <button class="quick-menu-btn" id="recordBtn">
                    <div class="quick-menu-icon" style="background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);">
                        <svg fill="white" viewBox="0 0 24 24">
                            <path d="M19 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h4l3 3 3-3h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-5 12h-2v2h-2v-2H8v-2h2v-2h2v2h2v2z"/>
                        </svg>
                    </div>
                    <span>Pencatatan</span>
                </button>

                <button class="quick-menu-btn" id="menuCrudBtn">
                    <div class="quick-menu-icon" style="background: linear-gradient(135deg, #2196F3 0%, #42A5F5 100%);">
                        <svg fill="white" viewBox="0 0 24 24">
                            <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-4h2v18h-2z"/>
                        </svg>
                    </div>
                    <span>Menu</span>
                </button>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">Riwayat Pesanan Terbaru</div>
            <div id="recentOrdersList" style="max-height: 400px; overflow-y: auto;">
                <div style="text-align: center; color: #999; padding: 2rem;">
                    Tidak ada pesanan terbaru
                </div>
            </div>
        </div>

        <button id="logoutBtn" class="logout-btn">Logout</button>
    </div>

    <!-- Bottom Navbar (Mobile) -->
    @include('partials.bottom-navbar')

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
            document.body.classList.toggle('sidebar-open');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
            document.body.classList.remove('sidebar-open');
        });

        // Close sidebar when clicking menu items
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            });
        });

        // Bottom navbar active state
        document.querySelectorAll('.bottom-nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                document.querySelectorAll('.bottom-nav-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            });
        });
    </script>
</body>
</html>
