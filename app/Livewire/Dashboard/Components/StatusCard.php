<?php

namespace App\Livewire\Dashboard\Components;

use Livewire\Component;

class StatusCard extends Component
{
    public string $title;
    public string $icon;
    public string $bg;

    public function mount($title = null, $icon = null, $bg = null)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->bg = $bg;
    }

    public function render()
    {
        return view('livewire.dashboard.components.status-card');
    }
}
