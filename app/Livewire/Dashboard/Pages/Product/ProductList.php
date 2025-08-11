<?php

namespace App\Livewire\Dashboard\Pages\Product;

use App\Models\Product;
use App\Services\ProductService;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductList extends Component
{
    public $products;

    public function mount(ProductService $productService)
    {
        $this->products = $productService->getAll();
    }

    #[Title('Produtos')]
    public function render()
    {
        return view('livewire.dashboard.pages.product.product-list')->layout('livewire.dashboard.layouts.app');
    }
}
