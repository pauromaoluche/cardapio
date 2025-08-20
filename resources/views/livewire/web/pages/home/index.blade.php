<div>
    <livewire:web.components.categories />
    <div class="container-custom">
        <div class="menu-section">
            <!-- Loop para produtos e promoções -->
            @foreach ($products as $item)
                @if ($item['type'] === 'product')
                    <x-web.product-card :item="$item" />
                @elseif ($item['type'] === 'promotion')
                    <x-web.promotion-card :item="$item" />
                @endif
            @endforeach
        </div>
    </div>
</div>
