<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class Cart extends Component
{
    public $active = false;
    public $quantity = 1;
    public $cart = [];

    protected $listeners = [
        'active-cart' => 'activeCart',
        'desactive-cart' => 'deactivateCart',
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);

        $this->quantity = count($this->cart);

        if (!empty($this->cart)) {
            $this->active = true;
        }
    }

    public function activeCart()
    {
        $this->cart = session()->get('cart', []);

        $this->quantity = count($this->cart);
        $this->active = true;
    }

    public function deactivateCart()
    {
        $this->active = false;
        $this->cart = [];
        $this->quantity = 0;
        $this->dispatch('close-offcanvas');
    }

    public function offcanvas()
    {
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.web.components.cart');
    }
}
