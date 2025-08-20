@props(['item' => []])

<div class="product-card">
    <div class="row g-0 p-3 promotion-row">
        <div class="col-auto me-3">
            <img src="{{ asset('storage/' . $item['images'][0]['path']) }}" alt="{{ $item['title'] }}"
                class="product-image promotion-image">
        </div>
        <div class="col">
            <div class="promotion-info">
                <h5 class="promotion-title">
                    {{ $item['title'] }}
                    <span class="badge promotion ms-2">Promoção</span>
                </h5>
                <p class="promotion-description">{{ $item['description'] }}</p>
                <div class="promoted-products mt-2">
                    <small class="text-secondary">Itens na promoção:</small>
                    <ul>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($item['products'] as $promotedProduct)
                            <li><small>x{{ $promotedProduct['pivot']['quantity'] }}
                                    {{ $promotedProduct['name'] }}</small></li>
                            @php
                                $totalPrice += ($promotedProduct['price'] * $promotedProduct['pivot']['quantity']);
                            @endphp
                        @endforeach
                    </ul>
                </div>
                <div class="prices-container mt-2">
                    <small class="text-muted text-decoration-line-through me-2">R$
                        {{ number_format($totalPrice, 2, ',', '.') }}</small>
                    @php
                        $finalPrice = $totalPrice;

                        if ($item['discount_type'] === 'percentage') {
                            $finalPrice = $totalPrice - $totalPrice * ($item['discount_value'] / 100);
                        } elseif ($item['discount_type'] === 'fixed') {
                            $finalPrice = $totalPrice - $item['discount_value'];
                        }

                        if ($finalPrice < 0) {
                            $finalPrice = 0;
                        }
                    @endphp
                    <p class="promotion-price fs-5 fw-bold text-success mt-1 mb-0">R$
                        {{ number_format($finalPrice, 2, ',', '.') }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <span class="discount-info">
                        @if ($item['discount_type'] === 'percentage')
                            <small class="text-secondary">Desconto de
                                {{ number_format($item['discount_value'], 1, ',') }}%</small>
                        @elseif ($item['discount_type'] === 'fixed')
                            <small class="text-secondary">Desconto de R$
                                {{ number_format($item['discount_value'], 2, ',', '.') }}
                                OFF</small>
                        @endif
                    </span>

                    <button type="button" class="add-btn" wire:click="selectPromotion('{{ $item['key'] }}')">
                        <i class="fas fa-plus me-1"></i>Adicionar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
