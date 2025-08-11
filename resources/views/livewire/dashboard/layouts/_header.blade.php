<header class="main-header py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="dropdown d-flex align-items-center gap-3">
            <button class="btn btn-link position-relative p-2 dropdown-toggle" style="color: var(--text-secondary);"
                data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="notification-dot"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end p-0" style="min-width: 300px;">
                <li class="dropdown-header bg-light fw-bold py-2 px-3 text-primary-custom">
                    Novos Pedidos
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-start gap-2 py-2" href="#">
                        <i class="bi bi-basket text-primary-custom fs-5"></i>
                        <div>
                            <div class="fw-semibold">Pedido #1023</div>
                            <small class="text-muted">X-Burger, Batata Frita</small>
                        </div>
                    </a>
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-start gap-2 py-2" href="#">
                        <i class="bi bi-basket text-primary-custom fs-5"></i>
                        <div>
                            <div class="fw-semibold">Pedido #1024</div>
                            <small class="text-muted">Pizza Calabresa</small>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="m-0" />
                    <a class="dropdown-item text-center text-primary-custom fw-semibold py-2" href="#">
                        Ver todos os pedidos
                    </a>
                </li>
            </ul>

            <div class="avatar">A</div>
        </div>
    </div>
</header>
