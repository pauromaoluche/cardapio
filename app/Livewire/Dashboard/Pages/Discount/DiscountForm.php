<?php

namespace App\Livewire\Dashboard\Pages\Discount;

use App\Livewire\Forms\DiscountFormValidation;
use App\Services\DiscountService;
use App\Services\ProductService;
use Livewire\Component;

class DiscountForm extends Component
{

    public $products;
    public $discount;

    protected ProductService $productService;
    protected DiscountService $discountService;

    public DiscountFormValidation $form;

    public function boot(ProductService $productService, DiscountService $discountService)
    {
        $this->productService = $productService;
        $this->discountService = $discountService;
    }

    public function mount(?int $id = null)
    {
        $this->products = $this->productService->getAll();

        if ($id) {
            $this->discount = $this->discountService->findById($id);
            if ($this->discount) {
                $this->form->discountId = $id;
                $this->form->fill($this->discount);
            }
        }
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save(bool $addOther = false)
    {
        $this->validate();

        $data = $this->form->all();

        try {
            if ($this->form->discountId) {
                unset($data['discountId']);
                $this->discountService->update($this->discount->id, $data);
            } else {
                unset($data['discountId']);
                $this->discountService->store($data);
            }

            if ($addOther) {
                session()->flash('success', 'Desconto ' . ($this->discount ? 'atualizado' : 'criado') . ' com sucesso! Adicione outro.');
                return redirect()->route('dashboard.discount.create');
            }
            session()->flash('success', $this->discount ? 'Desconto atualizado com sucesso!' : 'Desconto criado com sucesso!');
            return redirect()->route('dashboard.discount');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar o Desconto. Por favor, tente novamente. Se persistir, contate o administrador');

            return redirect()->route('dashboard.discount');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.pages.discount.discount-form')->layout('livewire.dashboard.layouts.app');
    }
}
