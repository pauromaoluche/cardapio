<div>
    <livewire:web.components.categories />
    <div class="container-custom">
        <div class="menu-section">
            @foreach ($products as $item)
                <x-web.product-card :item="$item" />
            @endforeach
        </div>
    </div>
</div>
