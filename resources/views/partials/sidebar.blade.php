<!-- Sidebar -->
<!-- Fixed hamburger visible on all pages to open sidebar -->
<button id="globalHamburger" aria-label="Buka menu" title="Buka menu" style="position:fixed;left:12px;top:12px;z-index:60;background:white;border:none;color:#991B27;padding:10px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.15);display:block;">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="#991B27" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
    </svg>
</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2>KP Borju</h2>
        <p style="font-size: 0.875rem; opacity: 0.9; margin: 0.5rem 0 0;">Menu</p>
    </div>
    @php
        $sidebarCurrent = request()->path();
        $sidebarIsActive = function($path) use ($sidebarCurrent) {
            return trim($sidebarCurrent, '/') === trim($path, '/') ? 'active' : '';
        };
    @endphp

    <!-- quick items will be rendered at top of the menu so they behave like other links -->

    <div class="sidebar-content">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard" class="{{ $sidebarIsActive('dashboard') }}">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li id="sidebarKasirItem" class="role-menu-item">
                <a href="/kasir" class="quick-link {{ $sidebarIsActive('kasir') }}">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-4 10h-2v2h-2v-2h-2v-2h2V8h2v2h2v2z"/></svg>
                    Kasir
                </a>
            </li>
            <li id="sidebarRiwayatItem" class="role-menu-item">
                <a href="/riwayat" class="quick-link {{ $sidebarIsActive('riwayat') }}">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                    Riwayat
                </a>
            </li>
            <li id="sidebarPencatatanItem" class="role-menu-item" style="display: none;">
                <a href="/pencatatan" class="quick-link {{ $sidebarIsActive('pencatatan') }}">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h18v2H3V3zm2 4h14v14H5V7zm2 2v2h10V9H7zm0 4v2h6v-2H7z"/></svg>
                    Pencatatan
                </a>
            </li>
            <!-- Profile and Settings removed per request -->
            <li id="sidebarMenuCrudItem" class="role-menu-item" style="display: none;">
                <a href="/menu-crud">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11 9H9V2H8v7H6V2H5v7H3V2H2v20h20V2h-1v7h-3V2h-1v7h-3V2h-1v7zm7 8H7v-5h11v5z"/>
                    </svg>
                    Kelola Menu
                </a>
            </li>
            <li>
                <a href="/login" id="sidebarLogoutBtn">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
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

    .sidebar-header h2 {
        margin: 0;
        font-size: 1.5rem;
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

    .sidebar-quick-menu {
        display: flex;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        justify-content: flex-start;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .sidebar-quick-menu .quick-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        background: transparent;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .sidebar-quick-menu .quick-item svg {
        width: 1.2rem;
        height: 1.2rem;
    }

    .sidebar-quick-menu .quick-item.active,
    .sidebar-quick-menu .quick-item:hover {
        background: rgba(255,255,255,0.08);
        color: #ED884C;
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

    /* Hide floating hamburger and any sidebar toggle buttons while sidebar is open */
    body.sidebar-open #globalHamburger,
    .sidebar.open #globalHamburger,
    body.sidebar-open .navbar-toggle,
    .sidebar.open .navbar-toggle,
    /* also hide any element with id ending in SidebarToggle (e.g., smallSidebarToggle) */
    body.sidebar-open [id$="SidebarToggle"],
    .sidebar.open [id$="SidebarToggle"] {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateX(-8px);
        transition: opacity 0.18s ease, transform 0.18s ease;
    }
</style>

<script>
    // Show the global hamburger on larger pages as well when JS is available
    (function(){
        try {
            const btn = document.getElementById('globalHamburger');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            const openSidebar = () => {
                if (!sidebar || !overlay) return;
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
                document.body.classList.toggle('sidebar-open');
            };

            if (btn) {
                btn.addEventListener('click', openSidebar);
            }

            // Also attach to any existing toggle (e.g., #sidebarToggle from navbar)
            const navToggle = document.getElementById('sidebarToggle');
            if (navToggle) {
                navToggle.addEventListener('click', openSidebar);
            }

            // allow clicking the overlay to close
            if (overlay) {
                overlay.addEventListener('click', () => {
                    if (!sidebar) return;
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                });
            }
        } catch (e) {
            console.warn('Sidebar hamburger init error', e);
        }
    })();
</script>
