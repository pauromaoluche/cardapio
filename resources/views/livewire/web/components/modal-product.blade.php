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
                    <div class="product-modal-content">
                        @if (!empty($item['images']))
                            @if ($item['type'] === 'product')
                                <x-web.carousel :items="count($item['images'])">
                                    @foreach ($item['images'] as $key => $image)
                                        <div class="carousel-item @if ($key === 0) active @endif">
                                            <img src="{{ asset('storage/' . $image['path']) }}"
                                                class="d-block image-modal" alt="{{ $item['name'] }}">
                                        </div>
                                    @endforeach
                                </x-web.carousel>
                            @else
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
                        @endif
                        @if ($item['type'] === 'product')
                            <p class="product-description mt-1">{{ $item['description'] }}</p>
                        @else
                            <div class="promotion-items">
                                <h6 class="mt-1">Itens da Promoção:</h6>
                                <ul>
                                    @foreach ($item['products'] as $promotedProduct)
                                        <li>x{{ $promotedProduct['pivot']['quantity'] }}
                                            {{ $promotedProduct['name'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center quantity-modal">
                            @if (!empty($item['discount']) || $item['type'] === 'promotion')
                                <div class="d-flex align-items-baseline">
                                    <small class="text-muted text-decoration-line-through pe-2">R$
                                        {{ number_format($item['price'] * $quantity, 2, ',', '.') }}</small>
                                    <span class="product-price text-success fw-bold">R$
                                        {{ number_format($item['total_price'], 2, ',', '.') }}</span>
                                </div>
                            @else
                                <p class="product-price fw-bold">R$
                                    {{ number_format($item['total_price'], 2, ',', '.') }}
                                </p>
                            @endif
                            <x-web.increase-decrease :quantity="$quantity" />

                        </div>
                    </div>
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
