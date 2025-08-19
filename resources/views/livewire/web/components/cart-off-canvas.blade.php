<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Minha Sacola</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @foreach ($cartItems as $item)
            <div class="item-cart">
                <div class="top-item d-flex justify-content-between">
                    <div class="top-image-name d-flex gap-4">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                            class="img-fluid rounded" style="width: 50px; height: 50px;">
                        <span>{{ $item['name'] }}</span>
                    </div>
                    <div class="top-delete">
                        <button type="button" class="btn text-danger fs-5"
                            wire:click="removeItem('{{ $item['id'] }}')"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                <div class="bottom-item d-flex justify-content-between align-items-center mt-2">
                    <div class="bottom-price">
                        <span class="product-price">R$ {{ $item['total_price'] }}</span>
                    </div>
                    <x-web.increase-decrease :quantity="$item['quantity']" />
                </div>
            </div>
            <hr>
        @endforeach
        <div class="total-price mt-4">
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
        </div>
    </div>
</div>
