<div>
    <div class="card">
        <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-tags me-2"></i>
                {{ $promotion ? 'Editar' : 'Criar' }} Promoção
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <!-- Informações Básicas -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Nome da Promoção <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="title"
                                placeholder="Ex: Desconto de Verão" wire:model.live="form.title">
                            @error('form.title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" rows="3" placeholder="Descreva os detalhes da promoção..."
                                wire:model.live="form.description"></textarea>
                            @error('form.description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

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
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="images" class="form-label">
                                Imagens do produto (máx. 4)
                            </label>
                            <input type="file" class="form-control" id="images"
                                accept="image/png, image/gif, image/jpeg, image/jpg" multiple wire:model="images">

                            @error('form.images')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('form.images.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            @if ($promotion && $promotion->images)
                                <div class="mt-3 d-flex flex-wrap gap-3 mb-3">
                                    @foreach ($promotion->images as $item)
                                        <x-image-preview :image="$item" path="{{ asset('storage/' . $item->path) }}"
                                            :key="$item->id" removeMethod="toggleImageRemoval" :imagesToRemove="$imagesToRemove"
                                            isExistingImage />
                                    @endforeach
                                </div>
                            @endif

                            @if (count($images) != 0)
                                <span>Preview de novas imagens</span>
                                <div class="mt-3 d-flex flex-wrap gap-3">
                                    @foreach ($images as $index => $image)
                                        <x-image-preview :image="$image" :key="$index" />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Configurações -->
                    {{-- <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Configurações</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="promotionCode" class="form-label">Código da Promoção</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="promotionCode"
                                            placeholder="DESCONTO20">
                                        <button class="btn btn-secondary" type="button" id="generateCode">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-muted">Deixe em branco para aplicar
                                        automaticamente</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isActive" checked>
                                        <label class="form-check-label" for="isActive">
                                            Promoção Ativa
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="applyToAll">
                                        <label class="form-check-label" for="applyToAll">
                                            Aplicar a Todos os Produtos
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="stackable">
                                        <label class="form-check-label" for="stackable">
                                            Combinável com Outras Promoções
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- Produtos Aplicáveis -->
                <div class="row mt-4" id="productSelection">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-custom text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-box me-2"></i>
                                    Produtos Aplicáveis
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="search" class="form-control" id="productSearch"
                                        placeholder="Buscar produtos..." wire:model.live="search">
                                </div>
                                @error('form.selected_products')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row">
                                    @foreach ($products as $item)
                                        <div class="col-md-6 col-lg-4 py-2" wire:key="product-{{ $item->id }}">
                                            <div class="product-item card p-2 @if (array_search($item->id, array_column($form->selected_products, 'id')) !== false) selected @endif"
                                                wire:click="toggleProductPromotion({{ $item->id }})">

                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $item->images[0]->path) }}"
                                                        alt="Produto" class="me-3 rounded"
                                                        style="height: 40px; width: 40px;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->name }}</h6>
                                                        <p class="mb-0 text-muted small">R$ {{ $item->price }}</p>
                                                    </div>
                                                </div>

                                                @if (array_search($item->id, array_column($form->selected_products, 'id')) !== false)
                                                    <div class="mt-2" wire:ignore.self>
                                                        <label for="quantity-{{ $item->id }}"
                                                            class="form-label mb-0">Quantidade na promoção:</label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="quantity-{{ $item->id }}" min="1"
                                                            wire:model.live="form.selected_products.{{ array_search($item->id, array_column($form->selected_products, 'id')) }}.quantity"
                                                            wire:key="quantity-input-{{ $item->id }}" @click.stop>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-end">
                    <x-btn-group-form route="{{ route('dashboard.promotion') }}" />
                </div>
            </form>
        </div>
    </div>
</div>
