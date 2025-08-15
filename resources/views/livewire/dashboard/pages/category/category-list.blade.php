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
        <x-hero title="Categorias" description="Gerencie suas categorias" route="{{ route('dashboard.category.create') }}" />
    </div>

    <x-table-list :cols="['Nome']" :fields="['name']" :hiddenFields="['image']" route="dashboard.category.edit"
        :data="$categories" />
</div>
