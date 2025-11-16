
<!-- Top Navigation Bar (shared) -->
<nav class="navbar">
    <button class="navbar-toggle" id="sidebarToggle">
        <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
        </svg>
    </button>

    <div class="navbar-brand">{{ $title ?? 'KP Borju' }}</div>

    <div style="width: 2rem;"></div>
</nav>

<script>
    (function(){
        const toggle = document.getElementById('sidebarToggle');
        if (!toggle) return;
        toggle.addEventListener('click', () => {
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
