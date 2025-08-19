<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class CartOffCanvas extends Component
{

    public $cartItems = [];
    public $totalPrice = 0;

    protected $listeners = [
        'cart-updated' => 'refreshCart',
        'refresh-cart' => 'refreshCart',
    ];

    public function refreshCart()
    {

        $this->cartItems = session()->get('cart', []);

        foreach ($this->cartItems as $item) {
            $this->totalPrice += $item['total_price'];
        }

        $this->dispatch('open-offcanvas');
    }

    public function render()
    {
        return view('livewire.web.components.cart-off-canvas');
    }
}
