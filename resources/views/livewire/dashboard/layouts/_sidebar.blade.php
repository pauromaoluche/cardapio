<div class="sidebar" id="sidebar">
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
                <a class="nav-link @if (request()->routeIs('dashboard.category')) active @endif"
                    href="{{ route('dashboard.category') }}" wire:navigate>
                    <i class="bi bi-tags"></i>
                    <span>Categorias</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('dashboard.product')) active @endif"
                    href="{{ route('dashboard.product') }}" wire:navigate>
                    <i class="bi bi-box2"></i>
                    <span>Produtos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('dashboard.promotion')) active @endif"
                    href="{{ route('dashboard.promotion') }}" wire:navigate>
                    <i class="bi bi-megaphone"></i>
                    <span>Promoções</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('dashboard.discount')) active @endif"
                    href="{{ route('dashboard.discount') }}" wire:navigate>
                    <i class="bi bi-cash"></i>
                    <span>Descontos</span>
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
