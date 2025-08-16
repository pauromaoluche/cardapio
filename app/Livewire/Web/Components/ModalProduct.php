<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class ModalProduct extends Component
{
    public $item;

    public $quantity = 1;

    protected $listeners = ['open-modal' => 'openModal'];

    public function openModal($itemData)
    {
        $this->item = $itemData;
    }

    public function render()
    {
        return view('livewire.web.components.modal-product');
    }
}
