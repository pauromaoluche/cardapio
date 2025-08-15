<?php

namespace App\Livewire\Dashboard\Pages\Category;

use App\Services\CategoryService;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoryList extends Component
{
    public $categories;
    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function mount()
    {
        $this->categories = $this->categoryService->getAll();
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
            $this->categoryService->destroy($id);

            $this->reloadData();
            $this->dispatch('swal:message', ['icon' => 'success', 'title' => 'Sucesso!', 'text' => 'Item deletado com sucesso.']);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Esta categoria')) {
                $this->dispatch('swal:message', ['icon' => 'warning', 'title' => 'Aviso!', 'text' => $e->getMessage()]);
            } else {
                $this->dispatch('swal:message', ['icon' => 'error', 'title' => 'Erro!', 'text' => 'Ocorreu um erro ao excluir a categoria, se persistir, contate o administrador.']);
            }
        }
    }

    public function reloadData()
    {
        $this->categories = $this->categoryService->getAll();
    }

    #[Title('Categorias')]
    public function render()
    {
        return view('livewire.dashboard.pages.category.category-list')->layout('livewire.dashboard.layouts.app');
    }
}
