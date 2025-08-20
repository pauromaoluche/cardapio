<div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Minha Sacola</h5>
        <button type="button" class="btn-close" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div class="cart-items-wrapper flex-grow-1 overflow-auto">
            @foreach ($cartItems as $key => $item)
                <div class="item-cart">
                    <div class="top-item d-flex justify-content-between">
                        <div class="top-image-name d-flex gap-4">
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                class="img-fluid rounded" style="width: 50px; height: 50px;">
                            <span>{{ $item['name'] }}</span>
                        </div>
                        <div class="top-delete">
                            <button type="button" class="btn text-danger fs-5"
                                wire:click="removeItem({{ $key }})"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div class="bottom-item d-flex justify-content-between align-items-center mt-2">
                        <div class="bottom-price">
                            <span class="product-price">R$ {{ $item['total_price'] }}</span>
                        </div>
                        <div class="quantity-selector border rounded bg-primary-custom">
                            <div class="input-group text-white d-flex align-items-center">
                                <button class="btn border-0" type="button"
                                    wire:click="decreaseQuantity({{ $key }})">-</button>
                                <span>{{ $item['quantity'] }}</span>
                                <button class="btn border-0" type="button"
                                    wire:click="increaseQuantity({{ $key }})">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="total-price">
            <div class="total-items-price d-flex justify-content-between">
                <span>Frete:</span>
                <strong>R$ {{ $totalPrice }}</strong>
            </div>
            <div class="total-items-price d-flex justify-content-between">
                <span>Valor Pedidos:</span>
                <strong>R$ {{ $totalPrice }}</strong>
            </div>
            <div class="total-items-price d-flex justify-content-between">
                <span>Valor Total:</span>
                <strong>R$ {{ $totalPrice }}</strong>
            </div>
            <div class="d-grid mt-3">
                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg" wire:navigate>
                    Finalizar Pedido
                </a>
            </div>
        </div>
    </div>
</div>
