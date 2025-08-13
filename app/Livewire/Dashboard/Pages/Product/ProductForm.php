<?php

namespace App\Livewire\Dashboard\Pages\Product;

use App\Livewire\Forms\ProductFormValidation;
use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProductForm extends Component
{

    use WithFileUploads;

    public $product;
    public $images = [];

    public array $selectedProducts = [];
    public array $imagesToRemove = [];

    protected ProductService $productService;

    public ProductFormValidation $form;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function mount(?int $id = null)
    {
        if ($id) {
            $this->product = $this->productService->findById($id);
            if ($this->product) {
                $this->form->productId = $id;
                $this->form->fill($this->product);

                $this->updateExistingImageCount();
            }
        }
    }

    public function updated($property)
    {
        if (Str::startsWith($property, 'form.')) {
            $this->validateOnly($property);
        }
        if ($property == 'images') {
            $this->form->images = $this->images;
            $this->validateOnly('form.' . $property);
        }
    }

    public function removeImageTemporary($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->form->images = $this->images;
            $this->validateOnly('form.images');
        }
    }

    public function toggleImageRemoval($imageId)
    {
        if (in_array($imageId, $this->imagesToRemove)) {
            $this->imagesToRemove = array_diff($this->imagesToRemove, [$imageId]);
        } else {
            $this->imagesToRemove[] = $imageId;
        }

        $this->updateExistingImageCount();
        $this->validateOnly('form.images');
    }

    public function updateExistingImageCount()
    {
        $existingCount = $this->product->images->count();
        $removedCount = count($this->imagesToRemove);
        $this->form->existingImageCount = $existingCount - $removedCount;
        $this->form->images = $this->images;
    }

    public function save(bool $addOther = false)
    {
        $this->validate();

        $data = $this->form->all();

        try {
            if ($this->form->productId) {
                unset($data['productId']);
                $this->productService->update($this->product->id, $data, $this->imagesToRemove);
            } else {
                unset($data['productId']);
                $this->productService->store($data);
            }

            if ($addOther) {
                session()->flash('success', 'Produto ' . ($this->product ? 'atualizado' : 'criado') . ' com sucesso! Adicione outro.');
                return redirect()->route('dashboard.product.create');
            }
            session()->flash('success', $this->product ? 'Produto atualizado com sucesso!' : 'Produto criado com sucesso!');
            return redirect()->route('dashboard.product');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar o produto. Por favor, tente novamente. Se persistir, contate o administrador');

            return redirect()->route('dashboard.product');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.pages.product.product-form')->layout('livewire.dashboard.layouts.app');
    }
}
