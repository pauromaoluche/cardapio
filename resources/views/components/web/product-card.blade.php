@props(['item' => []])

<div class="product-card" wire:ignore.self>
    <div class="row g-0 p-3 promotion-row">
        <div class="col-auto me-3 col-image">
            @if (!empty($item['images']))
                <img src="{{ asset('storage/' . $item['images'][0]['path']) }}"
                    alt="{{ $item['name'] ?? $item['title'] }}" class="product-image">
            @endif
        </div>
        <div class="col">
            <div class="product-info">
                <h5 class="product-name">
                    {{ $item['name'] ?? $item['title'] }}
                    @if ($item['type'] == 'product' && !empty($item['discount']))
                        <span class="badge bg-success ms-2">Desconto</span>
                    @elseif ($item['type'] === 'promotion')
                        <span class="badge promotion ms-2">Promoção</span>
                    @endif
                </h5>
                @if ($item['type'] === 'promotion')
                    <p class="promotion-description">{{ $item['description'] }}</p>

                    <div class="promoted-products mt-2">
                        <small class="text-secondary">Itens na promoção:</small>
                        <ul>
                            @foreach ($item['products'] as $promotedProduct)
                                <li><small>x{{ $promotedProduct['pivot']['quantity'] }}
                                        {{ $promotedProduct['name'] }}</small></li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="product-description">{{ $item['description'] }}</p>
                @endif

                <div class="row price-row">
                    @if (!empty($item['discount']) || $item['type'] === 'promotion')
                        <div class="col-12 prices-container mt-2 d-flex align-items-center justify-content-between col-price">
                            <div class="price-info">
                                <small class="text-muted text-decoration-line-through me-2">R$
                                    {{ number_format($item['price'], 2, ',', '.') }}</small>
                                <p class="promotion-price text-success fw-bold mt-1 mb-0">R$
                                    {{ number_format($item['final_price'], 2, ',', '.') }}</p>
                            </div>
                            @if (!empty($item['discount']))
                                <button type="button" class="add-btn"
                                    wire:click="selectProduct('{{ $item['key'] }}')">
                                    <i class="fas fa-plus me-1"></i>Adicionar
                                </button>
                            @endif
                        </div>
                        @if ($item['type'] === 'promotion')
                            <div class="col-12 d-flex justify-content-between align-items-center mt-1 col-price">
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

                                <button type="button" class="add-btn"
                                    wire:click="selectPromotion('{{ $item['key'] }}')">
                                    <i class="fas fa-plus me-1"></i>Adicionar
                                </button>
                            </div>
                        @else
                        @endif
                    @else
                        <div class="col-12 d-flex justify-content-between align-items-center mt-1 price-default">
                            <span class="product-price">R$
                                {{ number_format($item['price'], 2, ',', '.') }}</span>
                            <button type="button" class="add-btn" wire:click="selectProduct('{{ $item['key'] }}')">
                                Adicionar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
