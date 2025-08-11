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
        <x-hero title="Promoções" description="Gerencie suas promoções"
            route="{{ route('dashboard.promotion.create') }}" />
    </div>

    <x-table-list :cols="['Nome', 'Descrição', 'Data de Inicio', 'Data de Termino']" :fields="['name', 'description', 'start_date', 'end_date']" route="dashboard.promotion.edit" :data="$promotions" />
</div>
