<div>
    @if (session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-1">Produtos</h1>
                    <p class="text-muted-foreground mb-0">Gerencie seus produtos</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.product.create') }}" :wire.navigate class="btn btn-success">Adicionar</a>
                </div>
            </div>
        </div>
    </div>

    <table class="table product-list">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Preço</th>
                <th scope="col" class="text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
                <tr>
                    <td>
                        @if ($item->images->count() > 0)
                            <img src="{{ asset('storage/' . $item->images[0]->path) }}"
                                class="img-thumbnail img-product-list">
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->price }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('dashboard.product.edit', ['id' => $item->id]) }}"
                                class="btn btn-success">Editar</a>
                            <button type="button" class="btn btn-danger">Remover</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
