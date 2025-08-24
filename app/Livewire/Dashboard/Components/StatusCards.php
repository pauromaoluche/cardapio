<?php

namespace App\Livewire\Dashboard\Components;

use App\Models\Order;
use App\Services\OrderService;
use Livewire\Component;

class StatusCards extends Component
{
    public array $data = [];

    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mount()
    {
        $cards = [
            [
                'title' => 'Pedidos Pendentes',
                'icon' => 'bi bi-clock',
                'bg' => 'warning-custom text-warning',
                'status_id' => 1,
            ],
            [
                'title' => 'Em Preparo',
                'icon' => 'bi bi-bag',
                'bg' => 'info-custom text-info',
                'status_id' => 2,
            ],
            [
                'title' => 'Prontos',
                'icon' => 'bi bi-check-circle',
                'bg' => 'success-custom text-success',
                'status_id' => 3,
            ],
            [
                'title' => 'Faturamento Hoje',
                'icon' => 'bi bi-graph-up',
                'bg' => 'primary-custom text-primary-custom',
                'status_id' => 4,
            ]
        ];

        $statusCounts = $this->orderService->getCountsByStatus([1, 2, 3]);
        $todayRevenue = $this->orderService->getTodayRevenue();


        $this->data = collect($cards)->map(function ($card) use ($statusCounts, $todayRevenue) {
            $value = 0;

            if ($card['title'] === 'Faturamento Hoje') {
                $value = "R$ " . number_format($todayRevenue, 2, ',', '.');
            } else {
                $value = $statusCounts->get($card['status_id'])->count ?? 0;
            }

            $card['value'] = $value;
            return $card;
        })->toArray();
    }


    public function render()
    {
        return view('livewire.dashboard.components.status-cards');
    }
}
