<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Profile - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .profile-container {
            padding: 1rem;
            padding-bottom: 6rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .profile-header {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .profile-email {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .profile-body {
            padding: 1.5rem;
        }

        .profile-info {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #E0E0E0;
        }

        .profile-info:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 600;
        }

        .info-value {
            color: #333;
            text-align: right;
        }

        .btn-logout {
            width: 100%;
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #BD2630 0%, #991B27 100%);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top navbar removed -->

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Bottom Navbar -->
    @include('partials.bottom-navbar')

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <div class="profile-name" id="profileName">Loading...</div>
                <div class="profile-email" id="profileEmail">Loading...</div>
            </div>
            <div class="profile-body">
                <div class="profile-info">
                    <span class="info-label">Status:</span>
                    <span class="info-value">Aktif</span>
                </div>
                <div class="profile-info">
                    <span class="info-label">Bergabung:</span>
                    <span class="info-value" id="joinDate">-</span>
                </div>
                <button class="btn-logout" id="logoutBtn">Logout</button>
            </div>
        </div>
    </div>

    <script>
        // Use global authFunctions exported by app.js
        const { getCurrentUser, logout } = window.authFunctions || {};

        function loadProfileData() {
            const user = getCurrentUser ? getCurrentUser() : null;
            if (user) {
                document.getElementById('profileName').textContent = user.displayName || user.email;
                document.getElementById('profileEmail').textContent = user.email;
                document.getElementById('joinDate').textContent = user.metadata?.creationTime || '-';
            }
        }

        document.getElementById('logoutBtn').addEventListener('click', async (e) => {
            e.preventDefault();
            const result = await (logout ? logout() : Promise.resolve({ success: true }));
            if (result.success) {
                window.safeRedirectToLogin?.();
            }
        });

        loadProfileData();
    </script>
</body>
</html>
