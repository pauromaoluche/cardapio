<div>
    <button class="btn btn-link position-relative p-2 dropdown-toggle" style="color: var(--text-secondary);"
        data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="notification-dot"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end p-0" style="min-width: 300px;">
        <li class="dropdown-header bg-light fw-bold py-2 px-3 text-primary-custom">
            Novos Pedidos
        </li>
        @foreach ($orders as $order)
            <li>
                <a class="dropdown-item d-flex align-items-start gap-2 py-2" href="{{ route('dashboard.order') }}">
                    <i class="bi bi-basket text-primary-custom fs-5"></i>
                    <div>
                        <div class="fw-semibold">Pedido #{{ $order->id }}</div>
                        <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                            {{ $order->products->pluck('name')->implode(', ') }}
                        </small>
                    </div>
                </a>
            </li>
        @endforeach
        <li>
            <hr class="m-0" />
            <a class="dropdown-item text-center text-primary-custom fw-semibold py-2" href="{{ route('dashboard.order') }}">
                Ver todos os pedidos
            </a>
        </li>
    </ul>
</div>
