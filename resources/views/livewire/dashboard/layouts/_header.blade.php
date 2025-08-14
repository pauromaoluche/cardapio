<header class="main-header py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" onclick="initSidebarToggle()">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="dropdown d-flex align-items-center gap-3">
            <livewire:dashboard.components.new-orders />

            <div class="avatar">A</div>
        </div>
    </div>
</header>

{{-- @push('scripts')
    <script>
        function initSidebarToggle() {
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const mainContent = document.querySelector('.main-content');
            const sidebar = document.getElementById('sidebar');


            // handleSidebarToggle();
            function handleSidebarToggle() {
                // alert('teste');
                sidebar.classList.toggle('close-sidebar');
                mainContent.classList.toggle('full-width');
            }
        }
    </script>
@endpush --}}
