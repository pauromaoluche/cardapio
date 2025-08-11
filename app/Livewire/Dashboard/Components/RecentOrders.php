<?php

namespace App\Livewire\Dashboard\Components;

use App\Models\Order;
use App\Models\Status;
use App\Services\OrderService;
use Livewire\Component;

class RecentOrders extends Component
{
    public ?string $colClass = 'col-12 col-lg-6 col-xl-4';
    public ?string $h;
    public $limit = null;
    public $filter = 'all';
    public $search = '';
    public array $statusMap;
    public array $iconStepMap;

    public $statuses;

    protected $listeners = [
        'filterUpdated' => 'applyFilter',
        'searchUpdated' => 'searchOrders'
    ];

    public function mount()
    {
        $this->statuses = Status::all();
        $this->statusMap = [
            1 => 'pending',
            2 => 'preparing',
            3 => 'ready',
            4 => 'delivered',
        ];
        $this->iconStepMap = [
            1 => 'bi-clock',
            2 => 'bi-fork-knife',
            3 => 'bi-check-circle',
            4 => 'bi-truck',
        ];
    }

    public function applyFilter($filter)
    {
        $this->filter = $filter;
    }

    public function searchOrders($search)
    {
        $this->search = $search;
    }

    public function render(OrderService $orderService)
    {
        $orders = $orderService->getAll(
            filter: $this->filter,
            search: $this->search,
            limit: $this->limit
        );

        return view('livewire.dashboard.components.recent-orders', [
            'orders' => $orders,
        ]);
    }
}
