<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Kasir - Kedai Sambel Borju</title>
    
    <!-- Preconnect untuk optimasi loading -->
    <link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
    <link rel="preconnect" href="https://firestore.googleapis.com" crossorigin>
    <link rel="dns-prefetch" href="https://res.cloudinary.com">
    <link rel="dns-prefetch" href="https://firestore.googleapis.com">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Prevent layout shift during image load */
        img {
            content-visibility: auto;
        }
        
        .menu-item-icon img,
        .menu-card-header img {
            background: #f0f0f0;
        }
        
        .kasir-container {
            display: block;
            height: calc(100vh - 80px);
            padding: 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .kasir-container {
                height: auto;
                padding: 0.5rem;
                padding-bottom: 6rem;
            }
        }

        .menu-section {
            display: grid;
            grid-template-columns: repeat(auto-fill, 240px);
            gap: 1.25rem;
            overflow-y: auto;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            justify-content: center;
        }

        /* Large Tablet Portrait (iPad Pro, etc.) */
        @media (min-width: 900px) and (max-width: 1024px) and (orientation: portrait) {
            .menu-section {
                grid-template-columns: repeat(auto-fill, 250px);
                gap: 1.2rem;
                padding: 1rem;
            }
        }

        /* Tablet Landscape */
        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
            .menu-section {
                grid-template-columns: repeat(auto-fill, 210px);
                gap: 1.1rem;
                padding: 1rem;
            }
        }

        /* Medium Tablet Portrait */
        @media (min-width: 600px) and (max-width: 899px) and (orientation: portrait) {
            .menu-section {
                grid-template-columns: repeat(auto-fill, 220px);
                gap: 1.1rem;
                padding: 1rem;
            }
        }

        /* Mobile Landscape */
        @media (max-width: 767px) and (orientation: landscape) {
            .menu-section {
                grid-template-columns: repeat(auto-fill, 185px);
                gap: 1rem;
                padding: 0.875rem;
                border-radius: 8px;
            }
        }

        /* Mobile Portrait */
        @media (max-width: 599px) and (orientation: portrait) {
            .menu-section {
                grid-template-columns: repeat(auto-fill, 180px);
                gap: 0.95rem;
                padding: 0.75rem;
                border-radius: 8px;
            }
        }

        /* Mobile Small */
        @media (max-width: 479px) {
            .menu-section {
                grid-template-columns: repeat(auto-fill, 155px);
                gap: 0.8rem;
                padding: 0.5rem;
                border-radius: 8px;
            }
        }

        .menu-item-card {
            display: grid;
            grid-template-rows: auto auto auto auto;
            align-items: center;
            padding: 1rem 0.85rem 0.85rem;
            background: white;
            border: 2px solid #E8E8E8;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            height: 260px;
            position: relative;
            overflow: visible;
            gap: 0.6rem;
        }

        .menu-item-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #991B27 0%, #ED884C 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            z-index: 1;
        }

        .menu-item-card:hover {
            border-color: #991B27;
            box-shadow: 0 8px 16px rgba(153, 27, 39, 0.15);
            transform: translateY(-4px);
            z-index: 5;
        }

        .menu-item-card:hover::before {
            transform: scaleX(1);
        }

        @media (max-width: 768px) {
            .menu-item-card {
                padding: 0.9rem 0.6rem 0.7rem;
                border-radius: 10px;
                height: 230px;
                gap: 0.5rem;
            }

            .menu-item-card:active {
                transform: scale(0.97);
                border-color: #991B27;
            }

            .menu-item-card:hover {
                transform: translateY(-2px);
            }
        }

        @media (max-width: 480px) {
            .menu-item-card {
                padding: 0.8rem 0.55rem 0.6rem;
                height: 220px;
                gap: 0.45rem;
            }
        }

        .menu-item-icon {
            width: 110px;
            height: 110px;
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            justify-self: center;
            color: white;
            font-weight: bold;
            font-size: 2.5rem;
            box-shadow: 0 3px 6px rgba(153, 27, 39, 0.25);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .menu-item-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 14px;
        }
        
        @media (max-width: 768px) {
            .menu-item-icon img {
                border-radius: 12px;
            }
        }

        .menu-item-card:hover .menu-item-icon {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(153, 27, 39, 0.3);
        }

        @media (max-width: 768px) {
            .menu-item-icon {
                width: 90px;
                height: 90px;
                border-radius: 12px;
                font-size: 2.25rem;
            }
        }

        @media (max-width: 480px) {
            .menu-item-icon {
                width: 85px;
                height: 85px;
                border-radius: 12px;
                font-size: 2rem;
            }
        }

        .menu-item-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2D3748;
            text-align: center;
            word-break: break-word;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            align-self: center;
            max-height: 2.7em;
        }

        @media (max-width: 768px) {
            .menu-item-name {
                font-size: 0.85rem;
                line-height: 1.3;
            }
        }

        @media (max-width: 480px) {
            .menu-item-name {
                font-size: 0.8rem;
                line-height: 1.25;
            }
        }

        .menu-item-price {
            font-size: 0.9rem;
            font-weight: 700;
            color: #991B27;
            background: linear-gradient(135deg, #FFF5F5 0%, #FED7D7 100%);
            padding: 0.45rem 0.7rem;
            border-radius: 8px;
            white-space: nowrap;
            justify-self: center;
        }

        @media (max-width: 768px) {
            .menu-item-price {
                font-size: 0.8rem;
                padding: 0.35rem 0.5rem;
            }
        }

        /* Menu Card Quantity Controls */
        .menu-card-quantity {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            background: linear-gradient(135deg, #F5F5F5 0%, #E8E8E8 100%);
            border-radius: 20px;
            padding: 0.3rem 0.45rem;
            margin-top: -0.2rem;
            justify-self: center;
        }

        .menu-card-quantity.active {
            display: flex;
        }

        .menu-card-quantity button {
            background: #991B27;
            color: white;
            border: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
            transition: all 0.2s;
        }

        .menu-card-quantity button:hover {
            background: #BD2630;
            transform: scale(1.1);
        }

        .menu-card-quantity button:active {
            transform: scale(0.95);
        }

        .menu-card-quantity span {
            font-size: 0.8rem;
            font-weight: 700;
            color: #333;
            min-width: 20px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .menu-item-price {
                font-size: 0.65rem;
                padding: 0.2rem 0.35rem;
                border-radius: 4px;
            }
        }

        .menu-item-stok {
            font-size: 0.625rem;
            color: #E53E3E;
            font-weight: 600;
            background: #FFF5F5;
            padding: 0.2rem 0.35rem;
            border-radius: 4px;
            border: 1px solid #FED7D7;
            white-space: nowrap;
            justify-self: center;
            margin-top: -0.25rem;
        }
        
        @media (max-width: 480px) {
            .menu-item-stok {
                font-size: 0.6rem;
                padding: 0.15rem 0.3rem;
            }
        }

        /* Floating Cart Button */
        .floating-cart-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.4);
            cursor: pointer;
            z-index: 100;
            transition: all 0.3s ease;
            border: none;
        }

        .floating-cart-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(153, 27, 39, 0.5);
        }

        .floating-cart-btn svg {
            width: 28px;
            height: 28px;
            fill: white;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ED884C;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            border: 2px solid white;
        }

        .cart-badge.hidden {
            display: none;
        }

        .cart-info {
            position: fixed;
            bottom: 80px;
            right: 90px;
            background: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: none;
            flex-direction: column;
            gap: 0.25rem;
            z-index: 99;
        }

        .cart-info.active {
            display: flex;
        }

        .cart-info-item {
            font-size: 0.75rem;
            color: #666;
            white-space: nowrap;
        }

        .cart-info-total {
            font-size: 0.85rem;
            font-weight: 700;
            color: #991B27;
        }

        @media (max-width: 768px) {
            .cart-info {
                right: 90px;
            }
        }

        /* Cart Sidebar */
        .cart-section {
            position: fixed;
            top: 0;
            right: -100%;
            width: 380px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: white;
            box-shadow: -4px 0 16px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 1001;
            transition: right 0.5s ease-in-out;
        }

        .cart-section.active {
            right: 0;
        }

        @media (max-width: 768px) {
            .cart-section {
                width: 100%;
                right: -100%;
            }
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .cart-overlay.active {
            display: block;
        }

        .cart-header {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            padding: 1rem;
            font-weight: bold;
            border-bottom: 2px solid #ED884C;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-close-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .cart-close-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .cart-close-btn svg {
            width: 24px;
            height: 24px;
        }

        @media (max-width: 768px) {
            .cart-header {
                padding: 0.75rem;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-header {
                padding: 0.5rem;
                font-size: 0.85rem;
            }
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            max-height: 400px;
        }

        @media (max-width: 768px) {
            .cart-items {
                padding: 0.75rem;
                max-height: 300px;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-items {
                padding: 0.5rem;
                max-height: calc(100vh - 280px);
            }
        }

        .cart-item {
            background: #F5F5F5;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
            border-radius: 8px;
            border-left: 3px solid #991B27;
        }

        @media (max-width: 768px) {
            .cart-item {
                padding: 0.6rem;
                margin-bottom: 0.6rem;
                border-radius: 6px;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-item {
                padding: 0.4rem;
                margin-bottom: 0.4rem;
            }
        }

        .cart-item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .cart-item-name {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-item-name {
                font-size: 0.75rem;
                margin-bottom: 0.15rem;
            }
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .cart-item-controls {
                gap: 0.4rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-item-controls {
                gap: 0.3rem;
            }
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            border-radius: 4px;
            padding: 0.25rem;
        }

        .quantity-controls button {
            background: none;
            border: none;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #991B27;
            font-weight: bold;
        }

        .quantity-controls button:hover {
            background: #E0E0E0;
            border-radius: 3px;
        }

        .quantity-value {
            min-width: 24px;
            text-align: center;
            font-weight: 600;
            color: #333;
        }

        .cart-item-price {
            font-weight: 600;
            color: #991B27;
        }

        .remove-item {
            background: #FF6B6B;
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-item:hover {
            background: #FF5252;
        }

        .cart-footer {
            border-top: 2px solid #E0E0E0;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .cart-footer {
                padding: 0.75rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-footer {
                padding: 0.5rem;
            }
        }

        .cart-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .cart-summary {
                font-size: 0.85rem;
                margin-bottom: 0.6rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-summary {
                font-size: 0.75rem;
                margin-bottom: 0.4rem;
            }
        }

        .cart-summary.total {
            font-weight: bold;
            font-size: 1.1rem;
            color: #991B27;
            padding-top: 0.75rem;
            border-top: 1px solid #E0E0E0;
        }

        @media (max-width: 768px) {
            .cart-summary.total {
                font-size: 1rem;
                padding-top: 0.6rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .cart-summary.total {
                font-size: 0.9rem;
                padding-top: 0.4rem;
            }
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.75rem;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .checkout-btn {
                padding: 0.65rem;
                font-size: 0.95rem;
                margin-top: 0.6rem;
            }
        }

        @media (max-width: 767px) and (orientation: landscape) {
            .checkout-btn {
                padding: 0.5rem;
                font-size: 0.85rem;
                margin-top: 0.4rem;
            }
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #BD2630 0%, #991B27 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .checkout-btn:disabled {
            background: #CCC;
            cursor: not-allowed;
            transform: none;
        }

        .clear-cart-btn {
            width: 100%;
            background: white;
            color: #991B27;
            border: 2px solid #991B27;
            padding: 0.5rem;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 0.75rem;
        }

        .clear-cart-btn:hover {
            background: #F5F5F5;
        }

        .empty-cart {
            text-align: center;
            color: #999;
            padding: 2rem 0;
        }

        /* Order Detail Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .modal-content {
                padding: 1.5rem;
                width: 95%;
                border-radius: 8px;
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                padding: 1rem;
            }
        }

        .modal-header {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #991B27;
            padding-bottom: 0.75rem;
        }

        @media (max-width: 768px) {
            .modal-header {
                font-size: 1.1rem;
                margin-bottom: 1.2rem;
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1.2rem;
            }
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #991B27;
            box-shadow: 0 0 0 3px rgba(153, 27, 39, 0.1);
        }

        .order-summary-box {
            background: #F5F5F5;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #991B27;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 1.1rem;
            color: #991B27;
            border-top: 1px solid #E0E0E0;
            padding-top: 0.5rem;
            margin-top: 0.5rem;
        }

        .modal-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .modal-buttons button {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-submit {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #BD2630 0%, #991B27 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .btn-cancel {
            background: white;
            color: #991B27;
            border: 2px solid #991B27;
        }

        .btn-cancel:hover {
            background: #F5F5F5;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Small sidebar toggle for pages without full navbar -->
    <button id="smallSidebarToggle" aria-label="Buka menu" title="Buka menu" style="position:fixed;left:12px;top:12px;z-index:50;background:white;border:none;color:#991B27;padding:10px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.12);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="#991B27" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
        </svg>
    </button>

    <script>
        (function(){
            const btn = document.getElementById('smallSidebarToggle');
            if (!btn) return;
            btn.addEventListener('click', () => {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar) {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open');
                }
            });
        })();
    </script>

    <!-- Bottom Navbar -->
    @include('partials.bottom-navbar')

    <!-- Floating Cart Button -->
    <button class="floating-cart-btn" id="floatingCartBtn" aria-label="Buka Keranjang">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
        </svg>
        <div class="cart-badge hidden" id="cartBadge">0</div>
    </button>

    <!-- Cart Info -->
    <div class="cart-info" id="cartInfo">
        <div class="cart-info-item"><span id="cartInfoItems">0</span> item</div>
        <div class="cart-info-total">Rp <span id="cartInfoTotal">0</span></div>
    </div>

    <!-- Cart Overlay -->
    <div class="cart-overlay" id="cartOverlay"></div>

    <div class="kasir-container">
        <!-- Menu Items -->
        <div class="menu-section" id="menuSection">
            <div style="grid-column: 1/-1; text-align: center; color: #999;">
                Loading menu...
            </div>
        </div>
    </div>

    <!-- Shopping Cart (Floating) -->
    <div class="cart-section" id="cartSection">
        <div class="cart-header">
            <span>Keranjang Belanja</span>
            <button class="cart-close-btn" id="cartCloseBtn" aria-label="Tutup Keranjang">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>
            <div class="cart-items" id="cartItems">
                <div class="empty-cart">Keranjang kosong</div>
            </div>
            <div class="cart-footer">
                <div class="cart-summary">
                    <span>Total Item:</span>
                    <span id="totalItems">0</span>
                </div>
                <div class="cart-summary">
                    <span>Subtotal:</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="cart-summary total">
                    <span>Total:</span>
                    <span id="totalAmount">Rp 0</span>
                </div>
                <button class="checkout-btn" id="checkoutBtn" disabled>Checkout</button>
                <button class="clear-cart-btn" id="clearCartBtn">Hapus Semua</button>
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div class="modal-overlay" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">Konfirmasi Pesanan</div>

            <!-- Order Summary -->
            <div class="order-summary-box">
                <div id="orderItemsList"></div>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span id="modalSubtotal">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span id="modalTotal">Rp 0</span>
                </div>
            </div>

            <!-- Form -->
            <form id="orderForm">
                <div class="form-group">
                    <label for="customerName">Nama Pelanggan</label>
                    <input type="text" id="customerName" name="customerName" placeholder="Masukkan nama pelanggan" required>
                </div>

                <div class="form-group">
                    <label for="paymentMethod">Metode Pembayaran</label>
                    <select id="paymentMethod" name="paymentMethod" required onchange="toggleCashInput()">
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="cash">Tunai</option>
                        <option value="non-cash">Non Tunai</option>
                    </select>
                </div>

                <div class="form-group" id="cashInputGroup" style="display: none;">
                    <label for="cashAmount">Uang Tunai</label>
                    <input type="number" id="cashAmount" name="cashAmount" placeholder="Masukkan nominal uang" min="0" step="1000">
                    <div id="changeAmount" style="margin-top: 0.5rem; padding: 0.5rem; background: #F0FDF4; border: 1px solid #86EFAC; border-radius: 6px; color: #166534; font-weight: 600; display: none;">
                        Kembalian: Rp <span id="changeValue">0</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tableNumber">Nomor Meja</label>
                    <input type="text" id="tableNumber" name="tableNumber" placeholder="Masukkan nomor meja (opsional)">
                </div>
            </form>

            <!-- Buttons -->
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="closeOrderModal()">Batal</button>
                <button class="btn-submit" onclick="submitOrder()">Proses Pesanan</button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let menuItems = [];
        let unsubscribe = null;

        // Cart UI Functions
        function openCart() {
            document.getElementById('cartSection').classList.add('active');
            document.getElementById('cartOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCart() {
            document.getElementById('cartSection').classList.remove('active');
            document.getElementById('cartOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            const badge = document.getElementById('cartBadge');
            const cartInfo = document.getElementById('cartInfo');
            const cartInfoItems = document.getElementById('cartInfoItems');
            const cartInfoTotal = document.getElementById('cartInfoTotal');
            
            if (totalItems > 0) {
                badge.textContent = totalItems;
                badge.classList.remove('hidden');
                cartInfo.classList.add('active');
                cartInfoItems.textContent = totalItems;
                cartInfoTotal.textContent = new Intl.NumberFormat('id-ID').format(totalAmount);
            } else {
                badge.classList.add('hidden');
                cartInfo.classList.remove('active');
            }
        }

        function updateMenuCardQuantities() {
            menuItems.forEach(item => {
                const cartItem = cart.find(c => c.id === item.id);
                const quantityEl = document.getElementById('qty-' + item.id);
                if (quantityEl) {
                    if (cartItem && cartItem.quantity > 0) {
                        quantityEl.classList.add('active');
                        quantityEl.querySelector('span').textContent = cartItem.quantity;
                    } else {
                        quantityEl.classList.remove('active');
                    }
                }
            });
        }

        function addToCartFromCard(itemId, event) {
            event.stopPropagation();
            const item = menuItems.find(m => m.id === itemId);
            if (!item) return;

            const existingItem = cart.find(c => c.id === itemId);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: 1
                });
            }

            renderCart();
            updateCartBadge();
            updateMenuCardQuantities();
        }

        function removeFromCartCard(itemId, event) {
            event.stopPropagation();
            const existingItem = cart.find(c => c.id === itemId);
            if (existingItem) {
                existingItem.quantity--;
                if (existingItem.quantity <= 0) {
                    cart = cart.filter(c => c.id !== itemId);
                }
            }

            renderCart();
            updateCartBadge();
            updateMenuCardQuantities();
        }

        // Event listeners for cart
        document.getElementById('floatingCartBtn').addEventListener('click', openCart);
        document.getElementById('cartCloseBtn').addEventListener('click', closeCart);
        document.getElementById('cartOverlay').addEventListener('click', closeCart);

        // Note: don't destructure window.menuFunctions here (it may load later).
        // We'll access `window.menuFunctions` when we need it (after init ensures it's available).

        // Load menu items from Firestore
        async function loadMenuItems() {
            const menuSection = document.getElementById('menuSection');
            try {
                console.log('[Kasir] Loading menu items from Firestore...');
                menuSection.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: #999; padding: 2rem;">Loading menu...</div>';

                const mf = window.menuFunctions || {};
                if (typeof mf.getMenus !== 'function') {
                    throw new Error('menuFunctions.getMenus not available');
                }

                menuItems = await mf.getMenus();
                renderMenu();

                // Setup real-time listener
                if (typeof mf.onMenusChange === 'function') {
                    unsubscribe = await mf.onMenusChange((updatedMenus) => {
                        menuItems = updatedMenus;
                        renderMenu();
                    });
                }
                console.log('[Kasir] Real-time listener initialized');
            } catch (error) {
                console.error('[Kasir] Error loading menu:', error);
                menuItems = [];
                menuSection.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; color: #999; padding: 2rem;">
                        Gagal memuat menu dari Firestore.<br>
                        Pastikan Anda terhubung ke internet dan konfigurasi Firebase sudah benar.
                        <div style="margin-top:0.75rem;">
                            <button id="retryLoadMenus" style="background:#991B27;color:white;border:none;padding:0.5rem 0.75rem;border-radius:6px;">Muat Ulang</button>
                            <a href="/diagnostics.html" style="margin-left:0.5rem;color:#991B27;">Buka Diagnostics</a>
                        </div>
                        <div style="margin-top:0.5rem;color:#c33;font-size:0.85rem;">${error && error.message ? error.message : ''}</div>
                    </div>
                `;

                // attach retry handler
                const retryBtn = document.getElementById('retryLoadMenus');
                if (retryBtn) {
                    retryBtn.addEventListener('click', () => {
                        loadMenuItems();
                    });
                }
            }
        }

        // Render menu
        function renderMenu() {
            const menuSection = document.getElementById('menuSection');
            if (menuItems.length === 0) {
                menuSection.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: #999; padding: 2rem;">Tidak ada menu tersedia</div>';
                return;
            }

            menuSection.innerHTML = menuItems.map(item => {
                // Optimasi URL Cloudinary dengan transformasi
                let optimizedUrl = item.imageUrl;
                if (optimizedUrl && optimizedUrl.includes('cloudinary.com')) {
                    optimizedUrl = optimizedUrl.replace('/upload/', '/upload/w_200,h_200,c_fill,q_auto,f_auto/');
                }
                return `
                <div class="menu-item-card" onclick="addToCart('${item.id}')">
                    <div class="menu-item-icon">
                        ${item.imageUrl ? `<img src="${optimizedUrl}" alt="${item.name}" loading="lazy">` : (item.icon || '🍔')}
                    </div>
                    <div class="menu-item-name">${item.name}</div>
                    <div class="menu-item-price">Rp ${new Intl.NumberFormat('id-ID').format(item.price || 0)}</div>
                    ${item.stok !== undefined && item.stok < 5 ? `<div class="menu-item-stok">⚠️ Stok: ${item.stok}</div>` : ''}
                    <div class="menu-card-quantity" id="qty-${item.id}">
                        <button onclick="removeFromCartCard('${item.id}', event)">−</button>
                        <span>0</span>
                        <button onclick="addToCartFromCard('${item.id}', event)">+</button>
                    </div>
                </div>
                `;
            }).join('');
            
            updateMenuCardQuantities();
        }

        // Add to cart (ketika card diklik)
        function addToCart(itemId) {
            const item = menuItems.find(m => m.id === itemId);
            if (!item) return;

            const existingItem = cart.find(c => c.id === itemId);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: 1
                });
            }

            renderCart();
            updateCartBadge();
            updateMenuCardQuantities();
            // Don't auto open cart, just update badge
            console.log('[Kasir] Item added to cart:', item.name);
        }

        // Remove from cart
        function removeFromCart(itemId) {
            cart = cart.filter(c => c.id !== itemId);
            renderCart();
            updateCartBadge();
        }

        // Update quantity
        function updateQuantity(itemId, change) {
            const item = cart.find(c => c.id === itemId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(itemId);
                } else {
                    renderCart();
                    updateCartBadge();
                }
            }
        }

        // Render cart
        function renderCart() {
            const cartItems = document.getElementById('cartItems');

            if (cart.length === 0) {
                cartItems.innerHTML = '<div class="empty-cart">Keranjang kosong</div>';
                updateCartSummary();
                return;
            }

            cartItems.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-controls">
                        <div class="quantity-controls">
                            <button onclick="updateQuantity('${item.id}', -1)">−</button>
                            <div class="quantity-value">${item.quantity}</div>
                            <button onclick="updateQuantity('${item.id}', 1)">+</button>
                        </div>
                        <div class="cart-item-price">Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</div>
                        <button class="remove-item" onclick="removeFromCart('${item.id}')">✕</button>
                    </div>
                </div>
            `).join('');

            updateCartSummary();
        }

        // Update cart summary
        function updateCartSummary() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const total = subtotal; // No tax

            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('subtotal').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
            document.getElementById('totalAmount').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;

            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.disabled = cart.length === 0;
        }

        // Checkout — save ONLY to Firestore (no localStorage fallback)
        function checkout() {
            if (cart.length === 0) return;

            // Close cart section first
            closeCart();
            
            // Small delay to ensure cart closes smoothly before modal opens
            setTimeout(() => {
                openOrderModal();
            }, 300);
        }

        // Open order modal
        function openOrderModal() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const total = subtotal; // No tax

            // Display items
            const itemsList = document.getElementById('orderItemsList');
            itemsList.innerHTML = cart.map(item => `
                <div class="summary-row">
                    <span>${item.name} × ${item.quantity}</span>
                    <span>Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</span>
                </div>
            `).join('');

            // Display totals
            document.getElementById('modalSubtotal').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
            document.getElementById('modalTotal').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;

            // Reset form
            document.getElementById('orderForm').reset();

            // Show modal
            document.getElementById('orderModal').classList.add('active');
        }

        // Close order modal
        function closeOrderModal() {
            document.getElementById('orderModal').classList.remove('active');
            document.getElementById('orderForm').reset();
            document.getElementById('cashInputGroup').style.display = 'none';
            document.getElementById('changeAmount').style.display = 'none';
        }

        // Toggle cash input field
        function toggleCashInput() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const cashInputGroup = document.getElementById('cashInputGroup');
            const cashAmount = document.getElementById('cashAmount');
            
            if (paymentMethod === 'cash') {
                cashInputGroup.style.display = 'block';
                cashAmount.required = true;
            } else {
                cashInputGroup.style.display = 'none';
                cashAmount.required = false;
                cashAmount.value = '';
                document.getElementById('changeAmount').style.display = 'none';
            }
        }

        // Calculate change
        function calculateChange() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const cashAmount = parseFloat(document.getElementById('cashAmount').value) || 0;
            const change = cashAmount - total;
            
            const changeAmountDiv = document.getElementById('changeAmount');
            
            if (cashAmount > 0) {
                if (change > 0) {
                    // Ada kembalian
                    changeAmountDiv.innerHTML = `💰 Uang Kembalian: Rp <span id="changeValue">${new Intl.NumberFormat('id-ID').format(change)}</span>`;
                    changeAmountDiv.style.display = 'block';
                    changeAmountDiv.style.background = '#F0FDF4';
                    changeAmountDiv.style.borderColor = '#86EFAC';
                    changeAmountDiv.style.color = '#166534';
                } else if (change === 0) {
                    // Uang pas
                    changeAmountDiv.style.display = 'none';
                } else {
                    // Uang kurang
                    changeAmountDiv.innerHTML = `⚠️ Uang Kurang: Rp <span id="changeValue">${new Intl.NumberFormat('id-ID').format(Math.abs(change))}</span>`;
                    changeAmountDiv.style.display = 'block';
                    changeAmountDiv.style.background = '#FEF2F2';
                    changeAmountDiv.style.borderColor = '#FECACA';
                    changeAmountDiv.style.color = '#991B1B';
                }
            } else {
                changeAmountDiv.style.display = 'none';
            }
        }

        // Listen to cash amount input
        document.addEventListener('DOMContentLoaded', function() {
            const cashAmountInput = document.getElementById('cashAmount');
            if (cashAmountInput) {
                cashAmountInput.addEventListener('input', calculateChange);
            }
        });

        // Submit order
        async function submitOrder() {
            if (cart.length === 0) return;

            const customerName = document.getElementById('customerName').value.trim();
            const paymentMethod = document.getElementById('paymentMethod').value;
            const tableNumber = document.getElementById('tableNumber').value.trim();
            const cashAmount = parseFloat(document.getElementById('cashAmount').value) || 0;

            // Validation
            if (!customerName) {
                await window.KPAlert.warning('Nama pelanggan harus diisi', 'Data Tidak Lengkap');
                return;
            }
            if (!paymentMethod) {
                await window.KPAlert.warning('Metode pembayaran harus dipilih', 'Data Tidak Lengkap');
                return;
            }

            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const total = subtotal; // No tax

            // Validasi tunai
            if (paymentMethod === 'cash') {
                if (!cashAmount || cashAmount <= 0) {
                    await window.KPAlert.warning('Nominal uang tunai harus diisi', 'Data Tidak Lengkap');
                    return;
                }
                if (cashAmount < total) {
                    await window.KPAlert.warning('Uang tunai tidak mencukupi', 'Pembayaran Gagal');
                    return;
                }
            }

            const change = paymentMethod === 'cash' ? (cashAmount - total) : 0;

            const order = {
                id: 'ORD-' + Date.now(),
                items: cart,
                subtotal: subtotal,
                tax: 0,
                total: total,
                status: 'completed',
                customerName: customerName,
                paymentMethod: paymentMethod,
                cashAmount: paymentMethod === 'cash' ? cashAmount : null,
                change: paymentMethod === 'cash' ? change : null,
                tableNumber: tableNumber || '-',
                date: new Date().toLocaleString('id-ID')
            };

            const of = window.orderFunctions || {};
            if (typeof of.createOrder === 'function') {
                try {
                    console.log('[Kasir] Creating order in Firestore:', order);
                    const res = await of.createOrder(order);
                    if (res && res.success && res.id) {
                        // Close modal and clear cart
                        closeOrderModal();
                        closeCart();
                        cart = [];
                        renderCart();
                        updateCartBadge();
                        console.log('[Kasir] Order created in Firestore:', res.id);
                        
                        let successMessage = 'No. Pesanan: ' + res.id + '\nNama: ' + customerName + '\nMetode: ' + (paymentMethod === 'cash' ? 'Tunai' : 'Non Tunai') + '\nMeja: ' + (tableNumber || '-') + '\nTotal: Rp ' + new Intl.NumberFormat('id-ID').format(total);
                        
                        if (paymentMethod === 'cash') {
                            successMessage += '\n\nUang Tunai: Rp ' + new Intl.NumberFormat('id-ID').format(cashAmount);
                            successMessage += '\nKembalian: Rp ' + new Intl.NumberFormat('id-ID').format(change);
                        }
                        
                        await window.KPAlert.success(successMessage, 'Pesanan Berhasil Dibuat!');
                        return;
                    } else {
                        const errorMsg = res && res.error ? res.error : 'Unknown error';
                        console.error('[Kasir] Firestore createOrder failed:', errorMsg);
                        await window.KPAlert.error('Gagal menyimpan pesanan ke Firestore.\n\nError: ' + errorMsg, 'Gagal Menyimpan');
                    }
                } catch (err) {
                    console.error('[Kasir] Firestore createOrder exception:', err);
                    await window.KPAlert.error('Gagal menyimpan pesanan ke Firestore.\n\nError: ' + (err && err.message ? err.message : String(err)), 'Gagal Menyimpan');
                }
            } else {
                await window.KPAlert.error('Firestore tidak tersedia. Pastikan Anda terhubung ke internet dan Firebase sudah dikonfigurasi.', 'Koneksi Gagal');
            }
        }

        // Close modal when clicking outside
        document.getElementById('orderModal').addEventListener('click', (e) => {
            if (e.target.id === 'orderModal') {
                closeOrderModal();
            }
        });

        // Clear cart
        async function clearCart() {
            const confirmed = await window.KPAlert.confirm('Semua item dalam keranjang akan dihapus', 'Hapus Semua Item?');
            if (confirmed) {
                cart = [];
                renderCart();
                updateCartBadge();
                updateMenuCardQuantities();
            }
        }

        // Event listeners
        document.getElementById('checkoutBtn').addEventListener('click', checkout);
        document.getElementById('clearCartBtn').addEventListener('click', clearCart);

        // Initialize
        async function init() {
            // Wait for window.menuFunctions to be available
            let attempts = 0;
            while (!window.menuFunctions && attempts < 20) {
                await new Promise(r => setTimeout(r, 100));
                attempts++;
            }

            if (!window.menuFunctions) {
                console.error('[Kasir] menuFunctions not available on window');
                const menuSection = document.getElementById('menuSection');
                if (menuSection) {
                    menuSection.innerHTML = `
                        <div style="grid-column: 1/-1; text-align: center; color: #999; padding: 2rem;">
                            Modul menu tidak tersedia. Pastikan ` + "`resources/js/app.js`" + ` telah dibundel dan dimuat oleh Vite.
                            <div style="margin-top:0.75rem;"><button id="retryLoadMenus" style="background:#991B27;color:white;border:none;padding:0.5rem 0.75rem;border-radius:6px;">Coba Lagi</button></div>
                        </div>
                    `;
                    const retryBtn = document.getElementById('retryLoadMenus');
                    if (retryBtn) retryBtn.addEventListener('click', () => location.reload());
                }
                return;
            }

            console.log('[Kasir] menuFunctions available, starting load...');
            loadMenuItems();
        }

        // Start init
        init();
    </script>

        <script>
            (function(){
                function el(id){return document.getElementById(id);}
                function set(id, txt){const e=el(id); if(e) e.querySelector('span').textContent = txt;}

                // Check for Vite client script
                const viteClient = !!document.querySelector("script[src*='@@vite/client']");
                set('dbg_vite', viteClient ? 'present' : 'missing');

                // Check for app bundle script (dev or build)
                const appScript = !!(document.querySelector("script[src*='resources/js/app.js']") || document.querySelector("script[src*='/assets/app']"));
                set('dbg_appjs', appScript ? 'present' : 'missing');

                // Check exposed globals
                set('dbg_menu', (window.menuFunctions && typeof window.menuFunctions.getMenus === 'function') ? 'available' : (window.menuFunctions ? 'partial' : 'missing'));
                set('dbg_order', (window.orderFunctions && typeof window.orderFunctions.createOrder === 'function') ? 'available' : (window.orderFunctions ? 'partial' : 'missing'));

                // Firestore init: inspect console for logs (we don't attach db to window in modular SDK)
                set('dbg_firebase', 'see console');

                document.getElementById('dbgReload').addEventListener('click', () => location.reload());
            })();
        </script>
</body>
</html>
