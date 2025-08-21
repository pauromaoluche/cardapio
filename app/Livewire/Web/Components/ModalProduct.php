<?php

namespace App\Livewire\Web\Components;

use App\Services\AuxService;
use Livewire\Component;

class ModalProduct extends Component
{
    public $item;

    public $quantity = 1;
    public $observation;

    public $cart = [];

    protected $listeners = [
        'data-modal' => 'dataModal'
    ];

    protected AuxService $auxService;

    public function boot(AuxService $auxService)
    {
        $this->auxService = $auxService;
    }

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function dataModal($itemData)
    {
        $this->item = $itemData;
        $this->quantity = 1;
        $this->observation = '';
        $this->item = $this->auxService->calculateTotalPrice($this->item, $this->quantity);

        $this->dispatch('active-modal');
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->item = $this->auxService->calculateTotalPrice($this->item, $this->quantity);
        }
    }

    public function increaseQuantity()
    {
        $this->quantity++;
        $this->item = $this->auxService->calculateTotalPrice($this->item, $this->quantity);
    }

    public function addToCart()
    {

        if ($this->item) {

            $cartItem = [
                'id' => $this->item['id'],
                'type' => $this->item['type'],
                'image' => $this->item['images'][0]['path'],
                'name' => $this->item['type'] === 'product' ? $this->item['name'] : $this->item['title'],
                'price' => $this->item['price'],
                'final_price' => $this->item['final_price'],
                'total_price' => $this->item['total_price'],
                'quantity' => $this->quantity,
                'observation' => $this->observation ?? ''
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
