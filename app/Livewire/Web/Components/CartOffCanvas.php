<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class CartOffCanvas extends Component
{

    public $cartItems = [];
    public $totalPrice = 0;

    protected $listeners = [
        'cart-updated' => 'refreshCart'
    ];

    public function decreaseQuantity($itemIndex)
    {

        // Verifica se o índice existe no array e se a quantidade é maior que 1
        if (isset($this->cartItems[$itemIndex]) && $this->cartItems[$itemIndex]['quantity'] > 1) {
            $this->cartItems[$itemIndex]['quantity']--;
            $this->cartItems[$itemIndex]['total_price'] = $this->cartItems[$itemIndex]['final_price'] * $this->cartItems[$itemIndex]['quantity'];
            $this->updateSession();
        }
    }

    // Método para aumentar a quantidade de um item
    public function increaseQuantity($itemIndex)
    {
        // Verifica se o índice existe no array
        if (isset($this->cartItems[$itemIndex])) {
            $this->cartItems[$itemIndex]['quantity']++;
            $this->cartItems[$itemIndex]['total_price'] = $this->cartItems[$itemIndex]['final_price'] * $this->cartItems[$itemIndex]['quantity'];
            $this->updateSession();
        }
    }

    public function removeItem($itemIndex)
    {
        if (isset($this->cartItems[$itemIndex])) {
            unset($this->cartItems[$itemIndex]);
            $this->cartItems = array_values($this->cartItems);
            $this->updateSession();

            if (count($this->cartItems) === 0) {
                $this->dispatch('close-offcanvas');
                $this->dispatch('desactive-cart');
            }
        }
    }

    private function updateSession()
    {
        session()->put('cart', $this->cartItems);

        $this->calculateTotalPrice();
    }

    public function refreshCart()
    {

        $this->cartItems = session()->get('cart', []);

        $this->calculateTotalPrice();

        $this->dispatch('open-offcanvas');
    }

    private function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        foreach ($this->cartItems as $item) {
            $this->totalPrice += $item['final_price'] * $item['quantity'];
        }
    }

    public function render()
    {
        return view('livewire.web.components.cart-off-canvas');
    }
}
