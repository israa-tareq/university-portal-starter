document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    const sidebar       = document.getElementById('sidebar');
    const mainWrapper   = document.getElementById('mainWrapper');
    const toggleBtn     = document.getElementById('sidebarToggle');
    const toggleIcon    = document.getElementById('toggleIcon');
    const overlay       = document.getElementById('sidebarOverlay');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');

    // Restore collapsed state from previous visit
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        setCollapsed(true, false);
    }

    // Desktop: collapse / expand
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            setCollapsed(!sidebar.classList.contains('collapsed'), true);
        });
    }

    // Mobile: open sidebar
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
        });
    }

    // Mobile: close sidebar via overlay
    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
    }

    function setCollapsed(collapse, save) {
        if (collapse) {
            sidebar.classList.add('collapsed');
            mainWrapper.classList.add('sidebar-collapsed');
            toggleIcon.setAttribute('data-lucide', 'chevrons-right');
        } else {
            sidebar.classList.remove('collapsed');
            mainWrapper.classList.remove('sidebar-collapsed');
            toggleIcon.setAttribute('data-lucide', 'chevrons-left');
        }
        lucide.createIcons();
        if (save) localStorage.setItem('sidebarCollapsed', collapse);
    }

    // Highlight the active nav link
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-link').forEach(function (link) {
        const linkPath = new URL(link.href).pathname;
        if (linkPath === currentPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
            link.classList.add('active');
        }
    });
});
