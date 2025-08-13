<?php

namespace App\Livewire\Dashboard\Components;

use App\Services\OrderService;
use Livewire\Component;

class NewOrders extends Component
{

    public $orders;
    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mount()
    {
        $this->orders = $this->orderService->getAll(filter: 'Pendente', limit: 3);
    }

    public function render()
    {

        return view('livewire.dashboard.components.new-orders');
    }
}
