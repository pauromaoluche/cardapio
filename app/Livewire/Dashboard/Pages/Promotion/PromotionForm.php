<?php

namespace App\Livewire\Dashboard\Pages\Promotion;

use App\Livewire\Forms\PromotionFormValidation;
use App\Services\ProductService;
use App\Services\PromotionService;
use Livewire\Component;
use Livewire\WithFileUploads;

class PromotionForm extends Component
{

    use WithFileUploads;

    public $products = [];
    public $promotion;
    public $images = [];

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
                    $this->selectedProducts[] = ['id' => $product->id, 'quantity' => $product->pivot->quantity];
                }
            }
        }
    }
    public function updatedImages($propertyName)
    {
        $this->form->images = $this->images;
        $this->validate();
    }

    public function removeImageTemporary($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->form->images = $this->images;
            $this->validate();
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
        $this->validate();
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
        $key = array_search($productId, array_column($this->selectedProducts, 'id'));

        if ($key !== false) {
            unset($this->selectedProducts[$key]);
            $this->selectedProducts = array_values($this->selectedProducts);
        } else {
            $this->selectedProducts[] = ['id' => $productId, 'quantity' => 1];
        }
    }

    public function save(bool $addOther = false)
    {
        $this->validate();

        $data = $this->form->all();

        try {
            if ($this->form->promotionId) {
                unset($data['promotionId']);
                $this->promotionService->update($this->form->promotionId, $data, $this->selectedProducts, $this->imagesToRemove);
            } else {
                unset($data['promotionId']);
                $this->promotionService->store($data, $this->selectedProducts);
            }

            if ($addOther) {
                session()->flash('success', 'Promoção ' . ($this->promotion ? 'atualizada' : 'criada') . ' com sucesso! Adicione outra.');
                return redirect()->route('dashboard.promotion.create');
            }
            session()->flash('success', $this->promotion ? 'Promoção atualizada com sucesso!' : 'Promoção criada com sucesso!');
            return redirect()->route('dashboard.promotion');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar a promoção. Por favor, tente novamente. Se persistir, contate o administrador' . $e->getMessage());

            return redirect()->route('dashboard.promotion');
        }
    }


    public function render()
    {

        return view('livewire.dashboard.pages.promotion.promotion-form')->layout('livewire.dashboard.layouts.app');
    }
}
