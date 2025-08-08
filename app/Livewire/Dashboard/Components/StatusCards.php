<?php

namespace App\Livewire\Dashboard\Components;

use App\Models\Order;
use Livewire\Component;

class StatusCards extends Component
{
    public array $data = [];

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

        $this->data = collect($cards)->map(function ($card) {
            $value = 0;

            if ($card['title'] === 'Faturamento Hoje') {
                $value = Order::where('status_id', $card['status_id'])
                    ->whereDate('created_at', today())
                    ->sum('total_value');

                $value = "R$ " . $value;
            } else {
                $value = Order::where('status_id', $card['status_id'])->count();
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
