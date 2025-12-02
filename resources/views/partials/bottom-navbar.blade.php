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
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><g fill="currentColor"><path d="M4 19v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-2z"/><path fill-rule="evenodd" d="M9 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2v1h2a1 1 0 0 1 .994.89l.901 8.11H4.105l.901-8.11A1 1 0 0 1 6 8h6V7h-2a1 1 0 0 1-1-1zm1.01 8H8v2.01h2.01zm.99 0h2.01v2.01H11zm5.01 0H14v2.01h2.01zM8 14h2.01v2.01H8zm5.01 0H11v2.01h2.01zm.99 0h2.01v2.01H14zM11 4h6v1h-6z" clip-rule="evenodd"/></g></svg>
    </a>

    <a class="bottom-nav-item role-bottom-nav {{ $isActive('riwayat') }}" id="bottomNavRiwayat" href="/riwayat" title="Riwayat" aria-label="Riwayat">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
        </svg>
    </a>

    <a class="bottom-nav-item role-bottom-nav {{ $isActive('pencatatan') }}" id="bottomNavPencatatan" href="/pencatatan" title="Pencatatan" aria-label="Pencatatan" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="currentColor" d="M88 96a8 8 0 0 1 8-8h64a8 8 0 0 1 0 16H96a8 8 0 0 1-8-8m8 40h64a8 8 0 0 0 0-16H96a8 8 0 0 0 0 16m32 16H96a8 8 0 0 0 0 16h32a8 8 0 0 0 0-16m96-104v108.69a15.86 15.86 0 0 1-4.69 11.31L168 219.31a15.86 15.86 0 0 1-11.31 4.69H48a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16h160a16 16 0 0 1 16 16M48 208h104v-48a8 8 0 0 1 8-8h48V48H48Zm120-40v28.7l28.69-28.7Z"/></svg>
    </a>

    <a class="bottom-nav-item role-bottom-nav {{ $isActive('menu-crud') }}" id="bottomNavMenuCrud" href="/menu-crud" title="Kelola Menu" aria-label="Kelola Menu" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.412-.587T4 20v-2H3v-2h1v-3H3v-2h1V8H3V6h1V4q0-.825.588-1.412T6 2h12q.825 0 1.413.588T20 4v16q0 .825-.587 1.413T18 22zm0-2h12V4H6v2h1v2H6v3h1v2H6v3h1v2H6zm0 0V4zm3.5-3H11v-4q.65-.175 1.075-.712t.425-1.213V7h-1v3.775h-.75V7h-1v3.775H9V7H8v4.075q0 .675.425 1.213T9.5 13zm5.5 0h1.5V7q-1.25 0-2.125.875T13.5 10v3H15z"/></svg>
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
    /* SVG icon color will follow .bottom-nav-item color (currentColor) */
</style>
