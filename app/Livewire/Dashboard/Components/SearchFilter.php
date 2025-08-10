<?php

namespace App\Livewire\Dashboard\Components;

use Livewire\Component;

class SearchFilter extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', search: $this->search);
    }

    public function render()
    {
        return view('livewire.dashboard.components.search-filter');
    }
}
