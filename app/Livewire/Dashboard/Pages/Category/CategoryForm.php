<?php

namespace App\Livewire\Dashboard\Pages\Category;

use App\Livewire\Forms\CategoryFormValidation;
use App\Services\CategoryService;
use Livewire\Component;

class CategoryForm extends Component
{
    public $category;

    protected CategoryService $categoryService;

    public CategoryFormValidation $form;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function mount(?int $id = null)
    {
        if ($id) {
            $this->category = $this->categoryService->findById($id);
            if ($this->category) {
                $this->form->categoryId = $id;
                $this->form->fill($this->category);
            }
        }
    }

    public function save(bool $addOther = false)
    {
        $this->validate();

        $data = $this->form->all();

        try {
            if ($this->form->categoryId) {
                unset($data['categoryId']);
                $this->categoryService->update($this->category->id, $data);
            } else {
                unset($data['categoryId']);
                $this->categoryService->store($data);
            }

            if ($addOther) {
                session()->flash('success', 'Categoria ' . ($this->category ? 'atualizada' : 'criada') . ' com sucesso! Adicione outra.');
                return redirect()->route('dashboard.category.create');
            }
            session()->flash('success', $this->category ? 'Categoria atualizada com sucesso!' : 'Categoria criada com sucesso!');
            return redirect()->route('dashboard.category');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar a categoria. Por favor, tente novamente. Se persistir, contate o administrador');

            return redirect()->route('dashboard.category');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.pages.category.category-form')->layout('livewire.dashboard.layouts.app');
    }
}
