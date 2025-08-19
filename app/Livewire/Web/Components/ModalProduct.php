<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;
use PhpParser\Node\Stmt\Else_;

class ModalProduct extends Component
{
    public $item;

    public $quantity = 1;
    public $observation;

    public $cart = [];

    protected $listeners = [
        'data-modal' => 'dataModal'
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function dataModal($itemData)
    {
        $this->item = $itemData;
        $this->quantity = 1;
        $this->observation = '';

        $this->dispatch('active-modal');
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function addToCart()
    {
        if ($this->item) {
            $price = 0;
            $totalPrice = 0;
            if ($this->item['type'] === 'promotion') {
                foreach ($this->item['products'] as $promotedProduct) {
                    $totalPrice += $promotedProduct['price'];
                }

                if ($this->item['discount_type'] === 'percentage') {
                    $price = $totalPrice - ($totalPrice * ($this->item['discount_value'] / 100));
                } elseif ($this->item['discount_type'] === 'fixed') {
                    $price = $totalPrice - $this->item['discount_value'];
                }
            } else {
                if (isset($this->item['discount']) && $this->item['discount']) {
                    if ($this->item['discount']['discount_type'] === 'percentage') {
                        $price = $this->item['price'] - ($this->item['price'] * ($this->item['discount']['discount_value'] / 100));
                    } elseif ($this->item['discount']['discount_type'] === 'fixed') {
                        $price = $this->item['price'] - $this->item['discount']['discount_value'];
                    }
                } else {
                    $price = $this->item['price'];
                }
            }

            $cartItem = [
                'id' => $this->item['id'],
                'type' => $this->item['type'],
                'image' => $this->item['images'][0]['path'],
                'name' => $this->item['type'] === 'product' ? $this->item['name'] : $this->item['title'],
                'price' => $price,
                'total_price' => $price * $this->quantity,
                'quantity' => $this->quantity,
                'observation' => $this->observation ?? '',
                'data' => $this->item,
            ];

            session()->push('cart', $cartItem);

            // dd($cartItem);
            $this->dispatch('active-cart');
            $this->dispatch('close-modal');

            $this->reset(['item', 'quantity', 'observation']);
        }
    }

    public function render()
    {
        return view('livewire.web.components.modal-product');
    }
}
