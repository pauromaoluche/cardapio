<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-tags me-2"></i>
                Editar Produto
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
                        wire:model.live="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Descreva os detalhes do produto..."
                        wire:model.live="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Preço do produto</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" class="form-control" id="price" placeholder="0,00" min="0"
                            step="0.01" wire:model.live="price">
                    </div>
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">
                        Imagens do produto (máx. 4)
                    </label>
                    <input type="file" class="form-control" id="images" accept="image/png, image/gif, image/jpeg, image/jpg" multiple wire:model.live="images">

                    @error('images')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('images.*')
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
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button type="button" class="btn btn-primary" wire:click="save(true)">Salvar e adicionar
                            outro</button>
                        <a href="{{ route('dashboard.product') }}" type="button" class="btn btn-danger">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
