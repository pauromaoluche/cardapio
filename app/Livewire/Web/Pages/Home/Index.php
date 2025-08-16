<?php

namespace App\Livewire\Web\Pages\Home;

use App\Services\ProductService;
use App\Services\PromotionService;
use Livewire\Component;

class Index extends Component
{
    public $products;
    public $filter = 'all';
    public $showModal = false;

    protected ProductService $productService;
    protected PromotionService $promotionService;

    protected $listeners = [
        'setCategory' => 'fetchProducts',
    ];

    public function boot(ProductService $productService, PromotionService $promotionService)
    {
        $this->productService = $productService;
        $this->promotionService = $promotionService;
    }

    public function mount()
    {
        $this->fetchProducts($this->filter);
    }

    public function fetchProducts(string $filter = 'all')
    {
        $this->filter = $filter;

        $allProducts = $this->productService->findByCategory($this->filter);
        $allPromotions = $this->promotionService->getPromotions($this->filter);

        $productsWithType = $allProducts->map(fn ($item) => array_merge($item->toArray(), ['type' => 'product']));
        $promotionsWithType = $allPromotions->map(fn ($item) => array_merge($item->toArray(), ['type' => 'promotion']));

        $combinedCollection = $productsWithType->concat($promotionsWithType);

        $this->products = $combinedCollection->sortBy(function ($item) {
            if ($item['type'] === 'promotion') {
                return 1;
            }
            if ($item['type'] === 'product' && !empty($item['discount'])) {
                return 2;
            }
            return 3;
        })->values();
    }

    public function render()
    {
        return view('livewire.web.pages.home.index')->layout('livewire.web.layouts.app');
    }
}
