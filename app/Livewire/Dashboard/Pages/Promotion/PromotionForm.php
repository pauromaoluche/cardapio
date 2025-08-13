<?php

namespace App\Livewire\Dashboard\Pages\Promotion;

use App\Livewire\Forms\PromotionFormValidation;
use App\Services\ProductService;
use App\Services\PromotionService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PromotionForm extends Component
{

    use WithFileUploads;

    public $products = [];
    public $promotion;
    public $images = [];
    public $search = '';

    public array $selectedProducts = [];
    public array $imagesToRemove = [];

    protected ProductService $productService;
    protected PromotionService $promotionService;

    public PromotionFormValidation $form;

    public function boot(ProductService $productService, PromotionService $promotionService)
    {
        $this->productService = $productService;
        $this->promotionService = $promotionService;
    }

    public function mount(?int $id = null)
    {
        $this->products = $this->productService->getAll();

        if ($id) {
            $this->promotion = $this->promotionService->findById($id);
            if ($this->promotion) {
                $this->form->promotionId = $id;
                $this->form->fill($this->promotion);

                $this->updateExistingImageCount();

                foreach ($this->promotion->products as $product) {
                    $this->form->selected_products[] = ['id' => $product->id, 'quantity' => $product->pivot->quantity];
                }
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
        $existingCount = $this->promotion->images->count();
        $removedCount = count($this->imagesToRemove);
        $this->form->existingImageCount = $existingCount - $removedCount;
        $this->form->images = $this->images;
    }

    public function toggleProductPromotion($productId)
    {
        $key = array_search($productId, array_column($this->form->selected_products, 'id'));

        if ($key !== false) {
            unset($this->form->selected_products[$key]);
            $this->form->selected_products = array_values($this->form->selected_products);
        } else {
            $this->form->selected_products[] = ['id' => $productId, 'quantity' => 1];
        }
        $this->validateOnly('form.selected_products');
    }

    public function updatedSearch()
    {
        $this->products = $this->productService->search($this->search);
    }

    public function save(bool $addOther = false)
    {
        $this->validate();

        $data = $this->form->all();

        try {
            if ($this->form->promotionId) {
                unset($data['promotionId']);
                $this->promotionService->update($this->form->promotionId, $data, $this->imagesToRemove);
            } else {
                unset($data['promotionId']);
                $this->promotionService->store($data);
            }

            if ($addOther) {
                session()->flash('success', 'Promoção ' . ($this->promotion ? 'atualizada' : 'criada') . ' com sucesso! Adicione outra.');
                return redirect()->route('dashboard.promotion.create');
            }
            session()->flash('success', $this->promotion ? 'Promoção atualizada com sucesso!' : 'Promoção criada com sucesso!');
            return redirect()->route('dashboard.promotion');
        } catch (\Throwable $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar a promoção. Por favor, tente novamente. Se persistir, contate o administrador.');

            return redirect()->route('dashboard.promotion');
        }
    }


    public function render()
    {

        return view('livewire.dashboard.pages.promotion.promotion-form')->layout('livewire.dashboard.layouts.app');
    }
}
