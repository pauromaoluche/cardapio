@props(['quantity' => 1])
<div class="quantity-selector border rounded bg-primary-custom">
    <div class="input-group text-white d-flex align-items-center">
        <button class="btn border-0" type="button" wire:click="decreaseQuantity">-</button>
        <span>{{ $quantity }}</span>
        <button class="btn border-0" type="button" wire:click="increaseQuantity">+</button>
    </div>
</div>
