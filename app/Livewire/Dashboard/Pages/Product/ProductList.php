<?php

namespace App\Livewire\Dashboard\Pages\Product;

use App\Services\ProductService;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductList extends Component
{
    public $products;
    protected ProductService $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function mount()
    {
        $this->products = $this->productService->getAll();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Tem certeza?',
            'text' => 'Você realmente quer excluir este item? Isso não poderá ser revertido!',
            'icon' => 'warning',
            'onConfirmedEvent' => 'performDelete',
            'onConfirmedParams' => ['id' => $id]
        ]);
    }

    #[On('performDelete')]
    public function performDelete(array $params): void
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            $this->dispatch('swal:message', ['icon' => 'error', 'title' => 'Erro!', 'text' => 'ID do item não fornecido para exclusão.']);
            return;
        }

        try {
            $this->productService->destroy($id);

            $this->reloadData();
            $this->dispatch('swal:message', ['icon' => 'success', 'title' => 'Sucesso!', 'text' => 'Item deletado com sucesso.']);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Este produto')) {
                $this->dispatch('swal:message', ['icon' => 'warning', 'title' => 'Aviso!', 'text' => $e->getMessage()]);
            } else {
                $this->dispatch('swal:message', ['icon' => 'error', 'title' => 'Erro!', 'text' => 'Ocorreu um erro ao excluir o produto, se persistir, contate o administrador.']);
            }
        }
    }

    public function reloadData()
    {
        $this->products = $this->productService->getAll();
    }

    #[Title('Produtos')]
    public function render()
    {
        return view('livewire.dashboard.pages.product.product-list')->layout('livewire.dashboard.layouts.app');
    }
}
