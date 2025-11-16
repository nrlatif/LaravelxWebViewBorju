<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Pengaturan - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .settings-container {
            padding: 1rem;
            padding-bottom: 6rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .settings-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            padding: 1rem;
            font-weight: bold;
        }

        .section-body {
            padding: 1.5rem;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #E0E0E0;
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-label {
            flex: 1;
        }

        .setting-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .setting-description {
            font-size: 0.85rem;
            color: #999;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 28px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.3s;
            border-radius: 28px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #991B27;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(22px);
        }

        .btn-group {
            display: flex;
            gap: 0.75rem;
            flex-direction: column;
        }

        .btn {
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .btn-danger {
            background: #FF6B6B;
            color: white;
        }

        .btn-danger:hover {
            background: #FF5252;
        }

        .version-info {
            text-align: center;
            color: #999;
            font-size: 0.85rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top navbar removed -->

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Bottom Navbar -->
    @include('partials.bottom-navbar')

    <div class="settings-container">
        <!-- Display Settings -->
        <div class="settings-section">
            <div class="section-header">Tampilan</div>
            <div class="section-body">
                <div class="setting-item">
                    <div class="setting-label">
                        <div class="setting-name">Mode Gelap</div>
                        <div class="setting-description">Aktifkan mode gelap</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="darkModeToggle">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-label">
                        <div class="setting-name">Notifikasi Suara</div>
                        <div class="setting-description">Mainkan suara saat ada pesanan baru</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="soundToggle" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="settings-section">
            <div class="section-header">Akun</div>
            <div class="section-body">
                <div class="btn-group">
                    <button class="btn btn-primary">Ubah Password</button>
                    <button class="btn btn-primary">Keamanan Akun</button>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="settings-section">
            <div class="section-header">Zona Berbahaya</div>
            <div class="section-body">
                <div class="btn-group">
                    <button class="btn btn-danger" id="clearDataBtn">Hapus Semua Data</button>
                    <button class="btn btn-danger" id="logoutBtn">Logout</button>
                </div>
                <div class="version-info">
                    <p>KP Borju v1.0.0</p>
                    <p>© 2025 PT Koperasi Borju</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Use global authFunctions exported by app.js
        const { logout } = window.authFunctions || {};

        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const savedDarkMode = localStorage.getItem('darkMode') === 'true';
        darkModeToggle.checked = savedDarkMode;

        darkModeToggle.addEventListener('change', () => {
            localStorage.setItem('darkMode', darkModeToggle.checked);
            console.log('[Settings] Dark mode:', darkModeToggle.checked);
        });

        // Sound toggle
        const soundToggle = document.getElementById('soundToggle');
        const savedSound = localStorage.getItem('soundEnabled') === 'false' ? false : true;
        soundToggle.checked = savedSound;

        soundToggle.addEventListener('change', () => {
            localStorage.setItem('soundEnabled', soundToggle.checked);
            console.log('[Settings] Sound:', soundToggle.checked);
        });

        // Clear data
        document.getElementById('clearDataBtn').addEventListener('click', () => {
            if (confirm('Ini akan menghapus semua data lokal. Tindakan ini tidak dapat dibatalkan!')) {
                localStorage.clear();
                alert('Semua data telah dihapus');
                location.reload();
            }
        });

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', async (e) => {
            e.preventDefault();
            const result = await (logout ? logout() : Promise.resolve({ success: true }));
            if (result.success) {
                window.safeRedirectToLogin?.();
            }
        });
    </script>
</body>
</html>
