<?php

namespace App\Livewire\Dashboard\Pages\Home;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.dashboard.pages.home.index')->layout('livewire.dashboard.layouts.app');
    }
}
