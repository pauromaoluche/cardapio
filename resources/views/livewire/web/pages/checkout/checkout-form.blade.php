<div class="container py-5">
    @if ($orderFinalized)
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Pedido Finalizado com Sucesso!</h4>
            <p>Seu pedido foi recebido e está sendo processado. Entraremos em contato em breve para confirmar os detalhes.</p>
            <hr>
            <p class="mb-0">Agradecemos a sua preferência!</p>
        </div>
    @else
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt=""
                width="72" height="57">
            <h1 class="h2">Finalizar Pedido</h1>
            <p class="lead">Preencha todos os dados de maneira correta para que possamos enviar o seu pedido.
                <br>Todos os campos são obrigatórios, exceto onde indicado como opcional.
            </p>
        </div>
        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Sua Sacola</span>
                    <span class="badge bg-primary rounded-pill">{{ count($cartItems) }}</span>
                </h4>
                @if (count($cartItems) > 0)
                    <ul class="list-group mb-3">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $item['name'] }}</h6>
                                    <small class="text-body-secondary">Quantidade: {{ $item['quantity'] }}</small>
                                </div>
                                <span class="text-body-secondary">R$ {{ number_format($item['total_price'], 2, ',', '.') }}</span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Valor Total</span>
                            <strong>R$ {{ number_format($totalPrice, 2, ',', '.') }}</strong>
                        </li>
                    </ul>
                @else
                    <div class="alert alert-info text-center">
                        Sua sacola está vazia.
                    </div>
                @endif
            </div>
            <div class="col-md-7 col-lg-8">
                <form class="needs-validation" wire:submit.prevent="finalizeOrder" novalidate>
                    <div class="row g-3">
                        <h4 class="mb-3">Informações do cliente</h4>
                        <div class="col-sm-12">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" placeholder="Seu nome completo"
                                wire:model="name" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="whatsapp" class="form-label">WhatsApp <span
                                    class="text-body-secondary">(Opcional)</span></label>
                            <input type="text" class="form-control" id="whatsapp" placeholder="(xx) xxxxx-xxxx"
                                wire:model="whatsapp">
                            @error('whatsapp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row g-3">
                        <h4 class="mb-3">Endereço de entrega</h4>
                        <div class="col-12">
                            <label for="address" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="address" placeholder="Rua, número, bairro..."
                                wire:model="address" required>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Removi os campos de país e estado para simplificar, já que não estavam sendo usados com wire:model --}}
                    </div>
                    <hr class="my-4">
                    <div class="row g-3">
                        <h4>Método de pagamento</h4>
                        <small>O pagamento é feito quando o produto é recebido.</small>
                        <div class="my-3">
                            <div class="form-check">
                                <input id="credit" name="paymentMethod" type="radio" class="form-check-input"
                                    checked required>
                                <label class="form-check-label" for="credit">Cartão de Crédito</label>
                            </div>
                            <div class="form-check">
                                <input id="debit" name="paymentMethod" type="radio" class="form-check-input"
                                    required>
                                <label class="form-check-label" for="debit">Cartão de Débito</label>
                            </div>
                            <div class="form-check">
                                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input"
                                    required>
                                <label class="form-check-label" for="paypal">Dinheiro</label>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Finalizar Pedido</button>
                </form>
            </div>
        </div>
    @endif
</div>
