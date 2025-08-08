<?php

namespace App\Livewire\Dashboard\Components;

use App\Models\Order;
use App\Models\Status;
use Livewire\Component;

class RecentOrders extends Component
{
    public $orders;
    public array $statusMap;

    public function mount()
    {

        $this->orders = Order::with(['products', 'status'])->latest()->limit(10)->get();

        $this->statusMap = [
            1 => 'pending',
            2 => 'preparing',
            3 => 'ready',
            4 => 'delivered',
        ];

        // foreach ($orders as $order) {
        //     foreach ($order->products as $product) {
        //         // ID do produto (da tabela products)
        //         $productId = $product->id;

        //         // Nome do produto
        //         $productName = $product->name;

        //         // Campos da pivot
        //         $quantity = $product->pivot->quantity;
        //         $observation = $product->pivot->observation;

        //         dump([
        //             'order_id' => $order->id,
        //             'product_id' => $productId,
        //             'product_name' => $productName,
        //             'quantity' => $quantity,
        //             'observation' => $observation
        //         ]);
        //     }
        // }
    }

    public function render()
    {
        return view('livewire.dashboard.components.recent-orders');
    }
}
