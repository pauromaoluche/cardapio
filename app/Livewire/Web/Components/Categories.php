<?php

namespace App\Livewire\Web\Components;

use App\Services\CategoryService;
use Livewire\Component;

class Categories extends Component
{
    public $filter = 'all';
    public $categories;

    public function mount(CategoryService $categoryService)
    {
        $this->categories = $categoryService->getAll();
    }

    public function setCategory($filter)
    {
        $this->filter = $filter;
        $this->dispatch('setCategory', $filter);
    }

    public function render()
    {
        return view('livewire.web.components.categories');
    }
}
