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
        <x-hero title="Descontos" description="Gerencie seus descontos" route="{{ route('dashboard.discount.create') }}" />
    </div>

    <x-table-list
        :cols="['Produto', 'Data de Inicio', 'Data de Termino']"
        :imageField="'product.images.0.path'"
        :fields="['product.name', 'start_date', 'end_date']"
        :hiddenFields="['discount_type', 'start_date', 'end_date']" route="dashboard.discount.edit"
        :data="$discounts" />
</div>
