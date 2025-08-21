<?php

namespace App\Livewire\Web\Pages\Home;

use App\Services\AuxService;
use App\Services\ProductService;
use App\Services\PromotionService;
use Livewire\Component;

class Index extends Component
{
    public $products;
    public $filter = 'all';

    public $selectedItem;

    protected ProductService $productService;
    protected PromotionService $promotionService;
    protected AuxService $auxService;

    protected $listeners = [
        'setCategory' => 'fetchProducts',
    ];

    public function boot(ProductService $productService, PromotionService $promotionService, AuxService $auxService)
    {
        $this->productService = $productService;
        $this->promotionService = $promotionService;
        $this->auxService = $auxService;
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


        $productsWithType = $allProducts->map(fn ($item) => array_merge($item->toArray(), [
            'type' => 'product',
            'key' => 'product-' . $item['id'],
        ]));

        $promotionsWithType = $allPromotions->map(fn ($item) => array_merge($item->toArray(), [
            'type' => 'promotion',
            'key' => 'promotion-' . $item['id'],
        ]));

        $combinedCollection = $productsWithType->concat($promotionsWithType);

        $sortedCollection = $combinedCollection->sortBy(function ($item) {
            if ($item['type'] === 'promotion') {
                return 1;
            }
            if ($item['type'] === 'product' && !empty($item['discount'])) {
                return 2;
            }
            return 3;
        })->values();

        $this->products = $sortedCollection->map(function ($item) {
            return $this->auxService->calculateTotalPrice($item);
        });
    }

    public function selectProduct(string $itemKey)
    {
        $this->selectedItem = collect($this->products)->firstWhere('key', $itemKey);
        $this->dispatch('data-modal', $this->selectedItem);
    }

    public function selectPromotion(string $itemKey)
    {
        $this->selectedItem = collect($this->products)->firstWhere('key', $itemKey);
        $this->dispatch('data-modal', $this->selectedItem);
    }

    public function render()
    {
        return view('livewire.web.pages.home.index')->layout('livewire.web.layouts.app');
    }
}
