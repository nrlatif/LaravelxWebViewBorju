<!-- Sidebar -->
<!-- Fixed hamburger visible on all pages to open sidebar -->
<button id="globalHamburger" aria-label="Buka menu" title="Buka menu" style="position:fixed;left:12px;top:12px;z-index:60;background:white;border:none;color:#991B27;padding:10px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.15);display:block;">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="#991B27" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
    </svg>
</button>

 <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2 style = "font-weight: 700; font-family: 'Poppins', sans-serif;">Kedai Sambel Borju</h2>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 24 24" style="margin-right:1rem;"><g fill="currentColor"><path d="M4 19v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-2z"/><path fill-rule="evenodd" d="M9 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2v1h2a1 1 0 0 1 .994.89l.901 8.11H4.105l.901-8.11A1 1 0 0 1 6 8h6V7h-2a1 1 0 0 1-1-1zm1.01 8H8v2.01h2.01zm.99 0h2.01v2.01H11zm5.01 0H14v2.01h2.01zM8 14h2.01v2.01H8zm5.01 0H11v2.01h2.01zm.99 0h2.01v2.01H14zM11 4h6v1h-6z" clip-rule="evenodd"/></g></svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 256 256" style="margin-right:1rem;"><path fill="currentColor" d="M88 96a8 8 0 0 1 8-8h64a8 8 0 0 1 0 16H96a8 8 0 0 1-8-8m8 40h64a8 8 0 0 0 0-16H96a8 8 0 0 0 0 16m32 16H96a8 8 0 0 0 0 16h32a8 8 0 0 0 0-16m96-104v108.69a15.86 15.86 0 0 1-4.69 11.31L168 219.31a15.86 15.86 0 0 1-11.31 4.69H48a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16h160a16 16 0 0 1 16 16M48 208h104v-48a8 8 0 0 1 8-8h48V48H48Zm120-40v28.7l28.69-28.7Z"/></svg>
                    Pencatatan
                </a>
            </li>
            <!-- Profile and Settings removed per request -->
            <li id="sidebarMenuCrudItem" class="role-menu-item" style="display: none;">
                <a href="/menu-crud">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 24 24" style="margin-right:1rem;"><path fill="currentColor" d="M6 22q-.825 0-1.412-.587T4 20v-2H3v-2h1v-3H3v-2h1V8H3V6h1V4q0-.825.588-1.412T6 2h12q.825 0 1.413.588T20 4v16q0 .825-.587 1.413T18 22zm0-2h12V4H6v2h1v2H6v3h1v2H6v3h1v2H6zm0 0V4zm3.5-3H11v-4q.65-.175 1.075-.712t.425-1.213V7h-1v3.775h-.75V7h-1v3.775H9V7H8v4.075q0 .675.425 1.213T9.5 13zm5.5 0h1.5V7q-1.25 0-2.125.875T13.5 10v3H15z"/></svg>
                    Kelola Menu
                </a>
            </li>
            <li>
                <a href="/login" id="sidebarLogoutBtn">
                    <img src="/icons/ic_logout.png" alt="Logout" width="25" height="20" style="margin-right:1rem; filter: invert(1);" />
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
      .sidebar-header h2{
            font-family: 'Poppins', sans-serif;
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
