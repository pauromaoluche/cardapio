<!-- Order Card 1 -->
<div class="{{ $colClass }}">
    <div class="card order-card {{ $h }} shadow bg-body-tertiary rounded">
        <div class="card-header bg-transparent border-0 pb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="order-number">#{{ $order->id }}</div>
                    <div>
                        <h6 class="mb-0 fw-semibold">Pedido #{{ $order->id }}</h6>
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="bi bi-clock"></i>
                            {{ $order->created_at->format('H:i') }}
                        </small>
                    </div>
                </div>
                <span class="status-badge status-{{ $statusClass }}">
                    <i class="bi {{ $iconStep }}"></i>
                    {{ $order->status->name }}
                </span>
            </div>
        </div>

        <div class="card-body pt-0 d-flex flex-column">
            <!-- Cliente -->
            <div class="d-flex gap-2 mb-3">
                <i class="bi bi-person text-muted mt-1"></i>
                <div class="flex-grow-1">
                    <p class="mb-0 fw-medium small">{{ $order->client_name }}</p>
                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">{{ $order->client_phone }}</p>
                    <div class="d-flex gap-1 mt-1">
                        <i class="bi bi-geo-alt text-muted" style="font-size: 0.75rem;"></i>
                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">{{ $order->address }}</p>
                    </div>
                    @if ($order->observation)
                        <div class="d-flex gap-1 mt-1">
                            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Obs: {{ $order->observation }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Itens -->
            <div class="mb-3">
                <h6 class="text-muted mb-2"
                    style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    Itens</h6>
                <div class="small">
                    @foreach ($order->promotions as $promotion)
                        <div class="d-flex justify-content-between mb-1">
                            <div>
                                <span class="fw-medium">{{ $promotion->pivot->quantity }}x
                                    {{ $promotion->title }}</span>
                                @if ($promotion->pivot->observation)
                                    <div class="text-muted" style="font-size: 0.75rem; font-style: italic;">
                                        Obs: {{ $promotion->pivot->observation }}</div>
                                @endif
                            </div>
                            <span class="fw-medium">R$
                                {{ $promotion->pivot->unit_price * $promotion->pivot->quantity }}</span>
                        </div>
                    @endforeach
                    @foreach ($order->products as $item)
                        <div class="d-flex justify-content-between mb-1">
                            <div>
                                <span class="fw-medium">{{ $item->pivot->quantity }}x {{ $item->name }}</span>
                                @if ($item->pivot->observation)
                                    <div class="text-muted" style="font-size: 0.75rem; font-style: italic;">
                                        Obs: {{ $item->pivot->observation }}</div>
                                @endif
                            </div>
                            <span class="fw-medium">R$ {{ $item->pivot->unit_price * $item->pivot->quantity }}</span>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between mb-1">
                        <div>
                            <span class="fw-light">Taxa de entrega</span>
                        </div>
                        <span class="fw-medium">R$ {{ $order->delivery_fee }}</span>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-currency-dollar text-primary-custom"></i>
                        <span class="fw-bold fs-5 text-primary-custom total-value">R$
                            {{ number_format($order->total_value, 2, ',', '.') }}</span>
                    </div>
                    <small class="text-muted d-flex align-items-center gap-1">
                        <i class="bi bi-clock"></i>
                        ~{{ $order->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
