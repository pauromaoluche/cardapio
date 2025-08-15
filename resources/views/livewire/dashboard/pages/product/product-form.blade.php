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
                {{ $product ? 'Editar' : 'Criar' }} Produto
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <!-- Informações Básicas -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Nome <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="name" placeholder="Ex: X-Burger"
                        wire:model.live="form.name">
                    @error('form.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Descreva os detalhes do produto..."
                        wire:model.live="form.description"></textarea>
                    @error('form.description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Preço do produto</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="price" placeholder="0,00" min="0"
                                step="0.01" wire:model.live="form.price">
                        </div>
                        @error('form.price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">
                            Categoria do produto <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="category_id" wire:model.live="form.category_id">
                            <option value="">Selecione a categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('form.category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

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

                    @if ($product && $product->images)
                        <div class="mt-3 d-flex flex-wrap gap-3 mb-3">
                            @foreach ($product->images as $item)
                                <x-image-preview :image="$item" path="{{ asset('storage/' . $item->path) }}"
                                    :key="$item->id" removeMethod="toggleImageRemoval" :imagesToRemove="$imagesToRemove"
                                    isExistingImage />
                            @endforeach
                        </div>
                    @endif

                    {{-- Preview das imagens selecionadas --}}
                    @if ($images)
                        <span>Preview de imagens</span>
                        <div class="mt-3 d-flex flex-wrap gap-3">
                            @foreach ($images as $index => $image)
                                <x-image-preview :image="$image" :key="$index" />
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end">
                    <x-btn-group-form route="{{ route('dashboard.product') }}" />
                </div>
            </form>
        </div>
    </div>
</div>
