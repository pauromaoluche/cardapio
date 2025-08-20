<div wire:ignore.self class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    @if ($item)
                        {{ $item['type'] === 'product' ? $item['name'] : $item['title'] }}
                    @else
                        Detalhes do Item
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($item)
                    @if ($item['type'] === 'product')
                        <div class="product-modal-content" wire:ignore>
                            @if (!empty($item['images']))
                                <x-web.carousel :items="count($item['images'])">
                                    @foreach ($item['images'] as $key => $image)
                                        <div class="carousel-item @if ($key === 0) active @endif">
                                            <img src="{{ asset('storage/' . $image['path']) }}"
                                                class="d-block image-modal" alt="{{ $item['name'] }}">
                                        </div>
                                    @endforeach
                                </x-web.carousel>
                            @endif
                            <p class="product-description mt-1">{{ $item['description'] }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                @if (!empty($item['discount']))
                                    @php
                                        $finalPrice = $item['price'];
                                        if ($item['discount']['discount_type'] === 'percentage') {
                                            $finalPrice =
                                                $finalPrice - $finalPrice * ($item['discount']['discount_value'] / 100);
                                        } elseif ($item['discount']['discount_type'] === 'fixed') {
                                            $finalPrice = $finalPrice - $item['discount']['discount_value'];
                                        }
                                    @endphp
                                    <div class="d-flex align-items-baseline">
                                        <small class="text-muted text-decoration-line-through pe-2">R$
                                            {{ number_format($item['price'], 2, ',', '.') }}</small>
                                        <span class="product-price text-success fw-bold">R$
                                            {{ number_format($finalPrice, 2, ',', '.') }}</span>
                                    </div>
                                @else
                                    <p class="product-price fs-5 fw-bold">R$
                                        {{ number_format($item['price'], 2, ',', '.') }}
                                    </p>
                                @endif

                                <x-web.increase-decrease :quantity="$quantity" />

                            </div>
                        </div>
                    @elseif ($item['type'] === 'promotion')
                        <div class="promotion-modal-content">
                            @if (!empty($item['images']))
                                <x-web.carousel :items="count($item['images']) + count($item['products'])">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $item['images'][0]['path']) }}"
                                            class="d-block image-modal" alt="...">
                                    </div>
                                    @foreach ($item['products'] as $prod)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $prod['images'][0]['path']) }}"
                                                class="d-block image-modal" alt="{{ $prod['name'] }}">
                                        </div>
                                    @endforeach
                                </x-web.carousel>
                            @endif
                            <h6 class="mt-1">Itens da Promoção:</h6>
                            <ul>
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($item['products'] as $promotedProduct)
                                    <li>x{{ $promotedProduct['pivot']['quantity'] }}
                                        {{ $promotedProduct['name'] }}
                                    </li>
                                    @php
                                        $totalPrice += $promotedProduct['price'];
                                    @endphp
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
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
                                <div class="d-flex align-items-baseline">
                                    <small class="text-muted text-decoration-line-through pe-2">R$
                                        {{ number_format($totalPrice, 2, ',', '.') }}</small>
                                    <span class="product-price text-success fw-bold">R$
                                        {{ number_format($finalPrice, 2, ',', '.') }}</span>
                                </div>
                               <x-web.increase-decrease :quantity="$quantity" />
                            </div>
                        </div>
                    @endif
                @else
                    <p>Selecione um item para ver os detalhes.</p>
                @endif
                <div class="obervations">
                    <h6>Observações:</h6>
                    <textarea class="form-control" rows="3" placeholder="Adicione observações sobre o item..."
                        wire:model.defer="observation"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" wire:click="addToCart">
                    Adicionar ao Carrinho
                </button>
            </div>
        </div>
    </div>
</div>
