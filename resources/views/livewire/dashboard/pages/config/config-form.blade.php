<div>
    @if (session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="mb-4">
        <x-hero title="Configurações" description="Gerencie suas Configurações" />
    </div>

    {{-- Adiciona a diretiva wire:submit.prevent para chamar o método save() no componente --}}
    <form wire:submit.prevent="save">
        <div class="card card-settings">
            <div class="card-header bg-custom text-white">
                Notificações
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5 class="setting-title">Enviar mensagem no status Preparando</h5>
                            <p class="setting-description">Envia mensagem para o usuario no whatsapp informando que o
                                pedido dele começou a ser preparado.</p>
                        </div>
                        <div class="form-check form-switch">

                            {{-- wire:model para ligar o checkbox ao campo `send_message_all_status` --}}
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="form.send_message_all_status" @if ($form->send_message_all_status) ? checked @endif>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5 class="setting-title">Me enviar mensagem de novo pedido</h5>
                            <p class="setting-description">Você recebe uma mensagem o WhatsApp quando chegar um novo
                                pedido.</p>

                            {{-- Alpine.js x-show: exibe este div somente se form.notify_new_order for verdadeiro --}}
                            {{-- Este div é o que contém o campo de telefone --}}
                            <div x-show="$wire.form.notify_new_order" x-transition.duration.500ms>
                                <div class="mb-3">
                                    {{-- wire:model para o campo de telefone --}}
                                    <input type="text" class="form-control mt-2" id="phone" placeholder="Numero do WhatsApp" wire:model="form.phone_to_notify">
                                    {{-- Exibe mensagem de erro se houver --}}
                                    @error('form.phone_to_notify')
                                        <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            {{-- wire:model para o checkbox de notificação --}}
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="form.notify_new_order" @if ($form->notify_new_order) ? checked @endif>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="card card-settings">
            <div class="card-header bg-custom text-white">
                Contato e endereço
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="setting-item">
                        <div class="setting-info w-100">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        {{-- wire:model para o campo de email --}}
                                        <input type="email" class="form-control" id="email"
                                            placeholder="name@example.com" wire:model="form.email">
                                        {{-- Exibe mensagem de erro se houver --}}
                                        @error('form.email')
                                            <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Telefone</label>
                                        {{-- wire:model para o campo de telefone --}}
                                        <input type="text" class="form-control" id="phone" wire:model="form.phone">
                                        {{-- Exibe mensagem de erro se houver --}}
                                        @error('form.phone')
                                            <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Endereço</label>
                                        {{-- wire:model para o campo de endereço --}}
                                        <input type="text" class="form-control" id="address" wire:model="form.address">
                                        {{-- Exibe mensagem de erro se houver --}}
                                        @error('form.address')
                                            <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="card card-settings">
            <div class="card-header bg-custom text-white">
                Entrega
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="setting-item">
                        <div class="setting-info w-100">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="delivery_fee" class="form-label">Taxa de entrega</label>
                                        {{-- wire:model para a taxa de entrega --}}
                                        <input type="text" class="form-control" id="delivery_fee" wire:model="form.delivery_fee">
                                        {{-- Exibe mensagem de erro se houver --}}
                                        @error('form.delivery_fee')
                                            <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-end">
            {{-- wire:submit.prevent chama o método 'save' ao clicar --}}
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>
