<div class="container py-5">
    @if ($orderFinalized)
        <div class="alert alert-success text-center" role="alert" wire:ignore>
            <h4 class="alert-heading">Pedido Finalizado com Sucesso!</h4>
            <p>Seu pedido foi recebido e está sendo processado. Entraremos em contato em breve para confirmar os
                detalhes.</p>
            <hr>
            <p class="mb-0">Agradecemos a sua preferência!</p>
        </div>
    @else
        @if (!empty($cartItems))
            <div class="py-5 text-center text-lg-start">
                <h1 class="h2">Finalizar Pedido</h1>
                <p class="fs-6">Preencha todos os dados de maneira correta para que possamos enviar o seu pedido.
                </p>
            </div>
            <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-4 order-md-last p-0 p-md-2">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Sua Sacola</span>
                        <span class="badge bg-primary rounded-pill">{{ $quantity }}</span>
                    </h4>
                    @if ($quantity > 0)
                        <ul class="list-group mb-3">
                            @foreach ($cartList as $item)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $item['name'] }}</h6>
                                        <small class="text-body-secondary">Quantidade: {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="text-body-secondary">R$
                                        {{ number_format($item['total_price'], 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>Taxa de entrega</span>
                                    <strong>R$ {{ number_format($totalPrice, 2, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Valor Total</span>
                                    <strong>R$ {{ number_format($totalPrice, 2, ',', '.') }}</strong>
                                </div>
                            </li>
                        </ul>
                    @else
                        <div class="alert alert-info text-center" wire:ignore>
                            Sua sacola está vazia.
                        </div>
                    @endif
                </div>
                <div class="col-md-7 col-lg-8 card">
                    <form class="needs-validation card-body" wire:submit.prevent="finalizeOrder">
                        <div class="row g-3">
                            <h4 class="mb-3 ">Informações do cliente</h4>
                            <div class="col-sm-12">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Seu nome completo" wire:model.defer="form.name">
                                @error('form.name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" placeholder="(xx) xxxxx-xxxx"
                                    wire:model.defer="form.whatsapp">
                                @error('form.whatsapp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="col-12" x-data="{ pickupInStore: @entangle('form.pickup_in_store') }">
                            <div class="row">
                                <!-- Switch Retirar na loja -->
                                <div class="col-12 mb-3">
                                    <input type="checkbox" x-model="pickupInStore" id="switchCheckChecked">
                                    <label class="form-check-label" for="switchCheckChecked"
                                        wire:model.defer='form.pickup_in_store'>Retirar na loja</label>
                                    <div x-show="pickupInStore" class="col-12 mb-3 mt-3">
                                        <h5>Endereço da loja</h5>
                                        <p>Rua da Loja, 123 - Bairro Central, Cidade/UF</p>
                                    </div>
                                    <hr class="my-4">
                                </div>

                                <div class="col-12 mb-3" x-show="!pickupInStore">
                                    <h4 class="mb-3">Endereço de entrega</h4>
                                    <div class="col-12">
                                        <label for="address" class="form-label">Endereço</label>
                                        <input type="text" id="address" wire:model.defer="form.address"
                                            class="form-control" placeholder="Rua, número, bairro..."
                                            :required="!pickupInStore">
                                        @error('form.address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="my-4">
                                </div>


                                <div class="col-12" x-data="{
                                    paymentMethod: @entangle('form.payment_method'),
                                    needChange: false
                                }" x-show="!pickupInStore">
                                    <h4>Método de pagamento</h4>
                                    <small>O pagamento é feito quando o produto é recebido.</small>

                                    <div class="my-3">
                                        <select wire:model.defer="form.payment_method" class="form-control"
                                            x-model="paymentMethod">
                                            <option value="" selected>Selecione o método</option>
                                            <option value="credit">Cartão de Crédito</option>
                                            <option value="debit">Cartão de Débito</option>
                                            <option value="cash">Dinheiro</option>
                                            <option value="pix">Pix</option>
                                        </select>
                                        @error('form.payment_method')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Checkbox aparece apenas se for dinheiro -->
                                    <div class="form-check mt-3" x-show="paymentMethod === 'cash'">
                                        <input type="checkbox" class="form-check-input" id="needChange"
                                            x-model="needChange">
                                        <label for="needChange" class="form-check-label">Precisa de troco?</label>
                                    </div>

                                    <!-- Input aparece apenas se marcar que precisa de troco -->
                                    <div class="mt-3" x-show="paymentMethod === 'cash' && needChange">
                                        <label for="change_to" class="form-label">Troco para:</label>
                                        <input type="number" id="change_to" class="form-control" min="0"
                                            placeholder="Ex: 100" wire:model.defer="form.change_to">
                                        @error('form.change_to')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="alert alert-info mt-3" x-show="paymentMethod === 'pix'">
                                        Após o Finalizar o pedido, você ira receber uma mensagem informando seu pedido,
                                        assim que receber envie o comprovante de pagamentom, caso não receba, envie o
                                        comprovante no seguinte WhatsApp:
                                        <strong>(xx) xxxxx-xxxx</strong> e informe seu nome completo.
                                    </div>

                                    <hr class="my-4">
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="observation" class="form-label">Observação</label>
                                <textarea class="form-control" id="observation" rows="3" wire:model.defer="form.observation"></textarea>
                            </div>
                            <hr class="my-4">
                        </div>

                        <button type="button" type="submit" class="btn btn-primary" wire:click="finalizeOrder">
                            Finalizar Pedido
                        </button>
                    </form>
                </div>
            </div>
            </div>
        @else
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt=""
                    width="72" height="57">
                <h1 class="h2">Atenção</h1>
                <p class="lead">Seu carrinho esta vazio, adicione itens para finalizar a compra.
                </p>
            </div>
        @endif

    @endif

</div>
