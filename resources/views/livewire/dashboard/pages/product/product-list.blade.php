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
        <x-hero title="Produtos" description="Gerencie seus produtos" route="{{ route('dashboard.product.create') }}" />
    </div>

    <x-table-list :cols="['Nome', 'Descrição', 'Preço']" :fields="['name', 'description', 'price']" route="dashboard.product.edit" :data="$products" />
</div>
