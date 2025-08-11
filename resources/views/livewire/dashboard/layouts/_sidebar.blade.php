<div class="sidebar position-fixed start-0 top-0 h-100" id="sidebar" style="width: 250px; z-index: 1000;">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-shop text-white"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">FoodAdmin</h5>
                <small class="text-muted">Painel de controle</small>
            </div>
        </div>
    </div>

    <div class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('dashboard.index')) active @endif"
                    href="{{ route('dashboard.index') }}" wire:navigate>
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('dashboard.order')) active @endif"
                    href="{{ route('dashboard.order') }}" wire:navigate>
                    <i class="bi bi-bag"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('dashboard.product')) active @endif"
                    href="{{ route('dashboard.product') }}" wire:navigate>
                    <i class="bi bi-people"></i>
                    <span>Produtos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#relatorios">
                    <i class="bi bi-graph-up"></i>
                    <span>Relatórios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#configuracoes">
                    <i class="bi bi-gear"></i>
                    <span>Configurações</span>
                </a>
            </li>
        </ul>
    </div>
</div>
