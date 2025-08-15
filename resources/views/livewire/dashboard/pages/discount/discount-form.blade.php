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
    <div class="card">
        <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-tags me-2"></i>
                {{ $discount ? 'Editar' : 'Criar' }} Produto
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="product_id" class="form-label">
                        Produto <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="product_id" wire:model.live="form.product_id">
                        <option value="">Selecione o produto</option>
                        @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                    </select>
                    @error('form.product_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Informações Básicas -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="discount_type" class="form-label">
                            Tipo de Desconto <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="discount_type" wire:model.live="form.discount_type">
                            <option value="">Selecione o tipo</option>
                            <option value="percentage">Porcentagem (%)</option>
                            <option value="fixed">Valor Fixo (R$)</option>
                        </select>
                        @error('form.discount_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="discount_value" class="form-label">
                            Valor do Desconto <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="discountPrefix">%</span>
                            <input type="number" class="form-control" id="discount_value" placeholder="0"
                                min="0" step="0.01" wire:model.live="form.discount_value">
                        </div>
                        @error('form.discount_value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">
                            Data de Início <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="start_date"
                            wire:model.live="form.start_date">
                        @error('form.start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">
                            Data de Fim <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="end_date"
                            wire:model.live="form.end_date">

                        @error('form.end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <x-btn-group-form route="{{ route('dashboard.discount') }}" />
                </div>
            </form>
        </div>
    </div>
</div>
