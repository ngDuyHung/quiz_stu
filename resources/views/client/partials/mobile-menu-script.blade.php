<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleButton = document.getElementById('mobile-menu-toggle');
        const body = document.body;
        const mobileLinks = sidebar ? sidebar.querySelectorAll('a.nav-item') : [];

        function openSidebar() {
            if (!sidebar || !overlay) return;
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            overlay.classList.add('block');
            body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            if (!sidebar || !overlay) return;
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            overlay.classList.remove('block');
            body.classList.remove('overflow-hidden');
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', function () {
                if (!sidebar || !overlay) return;
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        mobileLinks.forEach(link => {
            link.addEventListener('click', function () {
                if (window.matchMedia('(max-width: 767px)').matches) {
                    closeSidebar();
                }
            });
        });
    });
</script>
