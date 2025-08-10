<?php

namespace App\Livewire\Dashboard\Components;

use App\Models\Status;
use Livewire\Component;

class Filter extends Component
{
    public $filter = 'all';
    public $statuses;

    public function mount()
    {
        $this->statuses = Status::all();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->dispatch('filterUpdated', $filter);
    }

    public function render()
    {
        return view('livewire.dashboard.components.filter', [
            'statuses' => $this->statuses,
        ]);
    }
}
