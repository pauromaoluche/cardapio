<section class="categories-nav" wire.ignore>
    <div class="container category">
        <div class="buttons">
            <!-- Botão "Todos" -->
            <button class="btn filter-btn @if ($filter === 'all') active @endif"
                    wire:click="setCategory('all')">
                <i class="fas fa-list me-1"></i>Todos
            </button>

            <!-- Loop para as categorias -->
            @foreach ($categories as $category)
                <button class="btn filter-btn @if ($filter == $category->id) active @endif"
                        wire:click="setCategory('{{ $category->id }}')">
                    <i class="fas fa-list me-1"></i>{{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
</section>
