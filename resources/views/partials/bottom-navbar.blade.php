<!-- Bottom Navbar (Mobile) - Quick Menu Icons -->
@php
    $current = request()->path();
    $isActive = function($path) use ($current) {
        return trim($current, '/') === trim($path, '/') ? 'active' : '';
    };
@endphp

<div class="bottom-navbar">
    <a class="bottom-nav-item {{ $isActive('dashboard') }}" href="/dashboard" title="Dashboard" aria-label="Dashboard">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
        </svg>
    </a>
    <a class="bottom-nav-item role-bottom-nav {{ $isActive('kasir') }}" id="bottomNavKasir" href="/kasir" title="Kasir" aria-label="Kasir">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-4 10h-2v2h-2v-2h-2v-2h2V8h2v2h2v2z"/>
        </svg>
    </a>

    <a class="bottom-nav-item role-bottom-nav {{ $isActive('riwayat') }}" id="bottomNavRiwayat" href="/riwayat" title="Riwayat" aria-label="Riwayat">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
        </svg>
    </a>

    <a class="bottom-nav-item role-bottom-nav {{ $isActive('pencatatan') }}" id="bottomNavPencatatan" href="/pencatatan" title="Pencatatan" aria-label="Pencatatan" style="display: none;">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 3h18v2H3V3zm2 4h14v14H5V7zm2 2v2h10V9H7zm0 4v2h6v-2H7z"/>
        </svg>
    </a>

    <a class="bottom-nav-item role-bottom-nav {{ $isActive('menu-crud') }}" id="bottomNavMenuCrud" href="/menu-crud" title="Kelola Menu" aria-label="Kelola Menu" style="display: none;">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M11 9H9V2H8v7H6V2H5v7H3V2H2v20h20V2h-1v7h-3V2h-1v7h-3V2h-1v7zm7 8H7v-5h11v5z"/>
        </svg>
    </a>
</div>

<style>
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
    }

    .bottom-nav-item {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 0;
        text-decoration: none;
        color: #666;
        font-size: 0.75rem;
        text-align: center;
        transition: color 0.15s ease, background 0.15s ease;
        cursor: pointer;
        position: relative;
        -webkit-tap-highlight-color: transparent;
        -webkit-user-select: none;
    }

    .bottom-nav-item svg {
        width: 1.6rem;
        height: 1.6rem;
    }

    .bottom-nav-item.active {
        color: #991B27;
    }

    /* center the active indicator under the icon */
    .bottom-nav-item.active::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 6px;
        width: 28px;
        height: 3px;
        background: #991B27;
        border-radius: 2px;
    }

    /* remove default focus outline and avoid visible background on tap */
    .bottom-nav-item:focus {
        outline: none;
    }
    .bottom-nav-item:active {
        background: transparent;
    }
</style>
