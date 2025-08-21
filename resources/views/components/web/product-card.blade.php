@props(['item' => []])

<div class="product-card" wire:ignore.self>
    <div class="row g-0 p-3">
        <div class="col-auto me-3">
            @if (!empty($item['images']))
                <img src="{{ asset('storage/' . $item['images'][0]['path']) }}" alt="{{ $item['name'] }}"
                    class="product-image">
            @endif
        </div>
        <div class="col">
            <div class="product-info">
                <h5 class="product-name">
                    {{ $item['name'] }}
                    <!-- VERIFICAÇÃO DE DESCONTO -->
                    @if (!empty($item['discount']))
                        <span class="badge bg-success ms-2">Desconto</span>
                    @endif
                </h5>
                <p class="product-description">{{ $item['description'] }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- EXIBIÇÃO DE PREÇO COM DESCONTO -->
                    @if (!empty($item['discount']))
                        @php
                            $finalPrice = $item['price'];
                            if ($item['discount']['discount_type'] === 'percentage') {
                                $finalPrice = $finalPrice - $finalPrice * ($item['discount']['discount_value'] / 100);
                            } elseif ($item['discount']['discount_type'] === 'fixed') {
                                $finalPrice = $finalPrice - $item['discount']['discount_value'];
                            }
                        @endphp
                        <div class="d-flex flex-column">
                            <small class="text-muted text-decoration-line-through">R$
                                {{ number_format($item['price'], 2, ',', '.') }}</small>
                            <span class="product-price text-success fw-bold">R$
                                {{ number_format($finalPrice, 2, ',', '.') }}</span>
                        </div>
                    @else
                        <span class="product-price">R$
                            {{ number_format($item['price'], 2, ',', '.') }}</span>
                    @endif
                    <button type="button" class="add-btn" wire:click="selectProduct('{{ $item['key'] }}')">
                        Adicionar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
