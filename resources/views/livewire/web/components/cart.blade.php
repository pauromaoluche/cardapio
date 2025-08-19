<div class="cart-container @if ($active) active @endif">
    <div class="cart-body container" wire:click="offcanvas()">
        <button type="button" class="btn position-relative">
            <i class="bi bi-bag"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $quantity }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </button>
        <span>VER SACOLA</span>
    </div>
</div>
