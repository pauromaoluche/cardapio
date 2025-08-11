<?php

namespace App\Livewire\Dashboard\Pages\Order;

use Livewire\Attributes\Title;
use Livewire\Component;

class OrderList extends Component
{
    #[Title('Pedidos')]
    public function render()
    {
        return view('livewire.dashboard.pages.order.order-list')->layout('livewire.dashboard.layouts.app');
    }
}
