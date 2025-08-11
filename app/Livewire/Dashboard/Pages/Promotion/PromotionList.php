<?php

namespace App\Livewire\Dashboard\Pages\Promotion;

use App\Services\PromotionService;
use Livewire\Attributes\Title;
use Livewire\Component;

class PromotionList extends Component
{
    public $promotions;

    public function mount(PromotionService $promotionService)
    {
        $this->promotions = $promotionService->getAll();
    }

    #[Title('Promocoes')]
    public function render()
    {
        return view('livewire.dashboard.pages.promotion.promotion-list')->layout('livewire.dashboard.layouts.app');
    }
}
